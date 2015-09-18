<?php

require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/personuser.php';

class User extends CK_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('person_model');
        $this->load->model('address_model');
        $this->load->model('generic_model');
        $this->load->model('telephone_model');
        $this->load->model('personuser_model');

        $this->person_model->setLogger($this->Logger);
        $this->address_model->setLogger($this->Logger);
        $this->generic_model->setLogger($this->Logger);
        $this->telephone_model->setLogger($this->Logger);
        $this->personuser_model->setLogger($this->Logger);
    }

    public function edit() {
        $this->Logger->info("Starting " . __METHOD__);
        $user = $this->personuser_model->getUserById($this->session->userdata("user_id"));

        $data['user'] = $user;
        $data['fullname'] = $this->session->userdata("fullname");
        $this->loadView('user/form_edit', $data);
    }

    public function update() {
        $this->Logger->info("Starting " . __METHOD__);

        $person_id = $this->session->userdata("user_id");
        $fullname = $_POST['fullname'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $cpf = str_replace(".", "", $cpf);
        $cpf = str_replace("-", "", $cpf);
        $street = $_POST['street'];
        $number = $_POST['number'];
        $city = $_POST['city'];
        $phone1 = $_POST['phone1'];
        $phone2 = $_POST['phone2'];
        $cep = $_POST['cep'];
        $occupation = $_POST['occupation'];
        $complement = $_POST['complement'];
        $neighborhood = $_POST['neighborhood'];
        $uf = $_POST['uf'];
        $password = $_POST['password'];

        try {
            $this->Logger->info("Starting upadte user");
            $address = $this->address_model->getAddressByPersonId($person_id);
            $this->generic_model->startTransaction();

            if ($address != null && intval($address->getAddressId()) != 0) {
                $this->address_model->updateAddress($street, $number, $complement, $city, $cep, $uf, $neighborhood, $address->getAddressId());
                $addressId = $address->getAddressId();
            } else
                $addressId = $this->address_model->insertNewAddress($street, $number, $complement, $cep, $neighborhood, $city, $uf);

            $this->person_model->updatePerson($fullname, $gender, $email, $person_id, $addressId);
            $this->personuser_model->updatePersonUser($email, $cpf, $occupation, $person_id);

            $this->telephone_model->updatePhone($person_id, $phone1, $phone2);
            if ($password != '')
                $this->personuser_model->updatePassword($password, $person_id);

            $this->Logger->info("User data updated, saving fullname in session");
            $this->session->set_userdata("fullname", $fullname);

            $this->generic_model->commitTransaction();

            redirect("user/menu");
        } catch (Exception $ex) {
            $this->Logger->error("Failed to update user");
            $this->generic_model->rollbackTransaction();
            $this->edit();
        }
    }

    public function details() {
        if (!isset($_GET['id'])) {
            $this->loadView("user/not_found");
            return;
        }

        $personId = $_GET['id'];
        if ($personId == null || strlen($personId) == 0) {
            $this->loadView("user/not_found");
            return;
        }

        $user = $this->person_model->getPersonFullById($personId);
        if (!$personId) {
            $this->loadView("user/not_found");
            return;
        }

        $data["user"] = $user;
        $this->loadView("user/details", $data);
    }

    public function menu() {
        $data['fullname'] = $this->session->userdata("fullname");
        $this->loadView("user/menu", $data);
    }

    public function admin() {
        /* switch ($type) {
          case "user":
          $data['fullname'] = $this->session->userdata("fullname");
          $this->loadView("user/menu", $data);
          break;
          default: */
        $data['fullname'] = $this->session->userdata("fullname");
        $this->loadView("user/menu_admin", $data);
        //break;
        //}
    }

    public function emails() {
        $this->Logger->info("Running: " . __METHOD__);
        $userid = $this->session->userdata("user_id");
        $data['emails'] = $this->personuser_model->getEmailsByUserId($userid);
        $this->loadView("reports/users/emails", $data);
    }

}

?>