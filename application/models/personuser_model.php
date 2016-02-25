<?php

require_once APPPATH . 'core/CK_Model.php';

class personuser_model extends CK_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * This function is responsable for finding a Bcrypt cost that makes password creation and
     * should be used only once. Each time you change the cost we should rehash all the
     * passwords in the database so that all of them have the same security.
     * It's set to take 50 milisseconds to execute a bcrypt, so the server will be able to
     * interprete 10 passwords per second.
     * Links for bcrypt:
     * Why 100 milisseconds:
     * http://security.stackexchange.com/questions/17207/recommended-of-rounds-for-bcrypt
     * If we ever have to change the cost:
     * http://crypto.stackexchange.com/questions/3003/do-i-have-to-recompute-all-hashes-if-i-change-the-work-factor-in-bcrypt
     * The return of the bcrypt function is something like this:
     * $2a$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa
     * First argument: 2a -> Version
     * Second argument: 10 -> Cost value
     * Third argument: rest -> salt and cipher together
     */

    public static function findGoodBcryptCost() {
        $timeTarget = 0.100;
        // 100 milliseconds

        $cost = 8;
        do {
            $cost++;
            $start = microtime(true);
            password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);
        return cost;
    }

    /*
     * Creates a password hash and salt.
     */

    private static function createPasswordHash($password) {

        return password_hash($password, PASSWORD_BCRYPT, ["cost" => bcryptocost]);
    }

    /*
     * Compares the password the user used to login with the password in the database.
     */

    private static function comparePassword($userInputPassword, $databasePassword) {
        return password_verify($userInputPassword, $databasePassword);
    }

    public function insertNewUser($personId, $cpf, $login, $password, $occupation) {
        $password = personuser_model::createPasswordHash($password);

        $this->Logger->info("Running: " . __METHOD__);
        $sql = 'INSERT INTO person_user(person_id, cpf, login, password, occupation) VALUES (?,?,?,?,?)';

        if ($this->execute($this->db, $sql, array(intval($personId), $cpf, $login, $password, $occupation))) {
            //Inserts the person type as COMMON_USER
            $sqlPersonType = "INSERT INTO person_user_type (person_id, user_type) VALUES (?, ?)";
            if ($this->execute($this->db, $sqlPersonType, array(intval($personId), COMMON_USER)))
                return true;
        }

        throw new Exception("User not inserted");
    }

    public function userLogin($login, $password) {
        $this->Logger->info("Running: " . __METHOD__);
        //Not using log to hide the salt and password from the log.
        $sql = "SELECT person_id,password FROM person_user WHERE login = ?";
        $rs = $this->executeRowsNoLog($this->db, $sql, array($login));
        if (isset($rs[0]))
            if (personuser_model::comparePassword($password, $rs[0]->password))
                return $rs[0]->person_id;
        return false;
    }

    public function getUserById($person_id) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT
                    p.person_id, put.user_type, pu.login, a.address_id, pu.cpf, pu.occupation,
                    p.fullname, p.gender, p.email, a.street,
                    a.place_number, a.complement, a.city, a.cep, a.uf,
                    a.neighborhood, (SELECT phone_number FROM telephone WHERE person_id = ? LIMIT 1) AS phone1,
                    (SELECT phone_number FROM telephone WHERE person_id = ? LIMIT 1 OFFSET 1) AS phone2
                    FROM person_user AS pu
                    INNER JOIN person AS p on p.person_id = pu.person_id
                    LEFT JOIN address AS a on a.address_id = p.address_id
                    LEFT JOIN person_user_type AS put on put.person_id = pu.person_id
                    WHERE p.person_id = ?";

        $rows = $this->executeRows($this->db, $sql, array(intval($person_id), intval($person_id), intval($person_id)));

        if (isset($rows[0])) {
            $personUser = PersonUser::createUserObject($rows[0], true);
            $personUser->setUserTypes($this->getUserPermissions($person_id));
            return $personUser;
        }
        return null;
    }

    public function getPersonIdByEmail($email) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = "SELECT
				p.person_id
				FROM person_user AS pu
				NATURAL JOIN person AS p
				WHERE p.email = ?";

        $row = $this->executeRow($this->db, $sql, array($email));

        if ($row) {
            return $row->person_id;
        }

        return null;
    }

    public function getUserPermissions($person_id) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = "select
				put.user_type
				from person_user_type put
				where put.person_id = ?";

        $rows = $this->executeRows($this->db, $sql, array(intval($person_id)));

        $permissions = array();
        if (count($rows) > 0)
            foreach ($rows as $row)
                $permissions[] = $row->user_type;

        return $permissions;
    }

    public function updatePersonUser($email, $cpf, $occupation, $person_id) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "UPDATE person_user SET login=?, cpf=?, occupation=? WHERE person_id=?";
        if ($this->execute($this->db, $sql, array($email, $cpf, $occupation, intval($person_id))))
            return true;
        return false;
    }

    public function updatePassword($password, $person_id) {
        $this->Logger->info("Running: " . __METHOD__);
        $password = personuser_model::createPasswordHash($password);
        $sql = "UPDATE person_user SET password=? WHERE person_id=?";
        if ($this->execute($this->db, $sql, array($password, intval($person_id))))
            return true;
        return false;
    }

    public function cpfExists($cpf) {
        $sql = "SELECT * FROM person_user WHERE cpf=?";
        $resultSet = $this->executeRow($this->db, $sql, array($cpf));

        if ($resultSet)
            return true;

        return false;
    }

    public function getAllUserRegistered() {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "
        SELECT count_users.count_users,
        count_associates.count_associates AS count_associates,
        count_benemerit.count_benemerit,
        count_non_benemerit.count_non_associate

        FROM
        ( SELECT count(*) AS count_users
               FROM person_user) count_users,

        ( SELECT count(*) AS count_associates
          FROM  donation d, person p
          WHERE d.donation_type=2
          AND d.donation_status=2
          AND d.person_id=p.person_id
          AND d.person_id not in ( SELECT b.person_id
                                   FROM   benemerits b )) count_associates,

        ( SELECT count(*) AS count_benemerit
          FROM benemerits b
          WHERE b.date_finished IS NULL) count_benemerit,

        ( SELECT count(*) AS count_non_associate
          FROM person_user
          WHERE NOT (person_user.person_id IN ( SELECT d.person_id
                                                FROM   donation d
                                                WHERE  d.donation_type = 2
                                                AND d.donation_status = 2
                                                UNION
                                                SELECT b.person_id
                                                FROM   benemerits b))) count_non_benemerit";

        $rows = $this->executeRows($this->db, $sql);
        return $rows;
    }

    public function getAllUsersDetailed() {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "
            SELECT a.fullname, a.email, a.associate, a.person_id
            FROM ( SELECT p.fullname, p.email, 'não sócio'::text AS associate, p.person_id
                   FROM person_user pu
                   JOIN person p ON pu.person_id = p.person_id
                   WHERE NOT (pu.person_id IN ( SELECT c.person_id
                                                FROM contributors c
                                                UNION
                                                SELECT person_id
                                                FROM  benemerits))
            UNION
            SELECT p.fullname, p.email, 'contribuinte'::text AS associate, p.person_id
            FROM  contributors c,person p
            WHERE p.person_id=c.person_id
            UNION
            SELECT p.fullname, p.email, 'benemerito'::text AS associate, p.person_id
            FROM benemerits b
            JOIN person p ON p.person_id = b.person_id
            WHERE b.date_finished IS NULL) a
            ORDER BY a.fullname";

        $rows = $this->executeRows($this->db, $sql);
        return $rows;
    }

    public function getAllContributorsByYearDetailed($year) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = " SELECT p.fullname,p.email,p.person_id,d.date_created as association_date
                 FROM donation d, person p
                 WHERE d.person_id = p.person_id
                 AND   d.donation_type=2 
                 AND   d.donation_status=2
                 AND   d.date_created >= (SELECT c.date_start
                                          FROM campaign c
                                          WHERE campaign_year = '?')
                 AND   d.date_created <= (SELECT cc.date_finish
                                          FROM campaign cc
                                          WHERE campaign_year = '?')";
        $rows = $this->executeRows($this->db, $sql,array(intval($year),intval($year)));
        return $rows;
    }

    public function checkPermission(
    $class, $method, $userType) {
        $this->Logger->info("Running: " . __METHOD__);
        foreach ($userType as $typeUser) {
            $sql = "select system_method_id from system_method where lower(method_name) = ? and lower(controller_name) = ? and user_type = ?;
                ";
            $rows = $this->executeRows($this->db, $sql, array(strtolower($method), strtolower($class), intval($typeUser)));
            if (count($rows) > 0) {
                return true;
            }
        }
        return false;
    }

    public function isAssociate($person_id) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "Select associate from v_report_all_users where person_id = ?";
        $row = $this->executeRow($this->db, $sql, array(intval($person_id)));
        if (isset($row)) {
            if ($row->associate === "t")
                return TRUE;
        }
        return FALSE;
    }

    public function getEmailsByUserId($person_id) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT c.communication_id, c.content, to_char(c.date_sent, 'YYYY-MM-DD HH:mm') as date_sent, 
				c.successfully_sent, c.type FROM communication c 
				INNER JOIN communication_recipient cr on cr.communication_id = c.communication_id
				INNER JOIN person p on p.email = cr.recipient
				WHERE p.person_id = ?
				AND cr.recipient_type = 'recipient'
				ORDER BY date_sent DESC
				LIMIT 30";
        $rows = $this->executeRows($this->db, $sql, array(intval($person_id)));
        foreach ($rows as $row) {
            $row = $this->extractMessageEmail($row);
        }
        return $rows;
    }

    private function extractMessageEmail($email) {
        $email->content = substr($email->content, strpos($email->content, "Body:") + 5);
        return $email;
    }

    public function getUsersByUserType($userType, $gender = null) {
        $sql = "select
                *
                from person p
                inner join person_user_type put on put.person_id = p.person_id
                where put.user_type = $userType
                " . (($gender != null) ? "AND p.gender = ?" : "") . "";

        if ($gender != null)
            $rows = $this->executeRows($this->db, $sql, array($gender));
        else
            $rows = $this->executeRows($this->db, $sql);

        $personUser = array();
        foreach ($rows as $row) {
            $personUser[] = Person:: createPersonObjectSimple($row, false);
        }
        return $personUser






        ;
    }

}

?>