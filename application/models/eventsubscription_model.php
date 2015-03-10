<?php
    require_once APPPATH . 'core/CK_Model.php';
    require_once APPPATH . 'core/person.php';

    class eventsubscription_model extends CK_Model {
        
        public function __construct() {
            parent::__construct();
        }

        public function createSubcription($event, $userId, $personId, $subscriptionStatus) {
            $sql = "INSERT INTO event_subscription (person_id, event_id, person_user_id, final_price, subscription_status) 
                    VALUES(?,?,?,?,?)";

            if ($this->execute($this->db, $sql, array( intval($personId), intval($event->getEventId()), intval($userId), floatval($event->getPrice()), $subscriptionStatus )))
                return true;

            throw new ModelException("Failed to create subscription");
        }

        public function getSubscriptionsForEventByUserId($userId, $eventId){
            $sql = "SELECT es.*, p.fullname from event_subscription as es 
                    inner join person as p on p.person_id = es.person_id 
                    where es.event_id = ? and es.person_user_id = ?";

            return $this->executeRows($this->db, $sql, array(intval($eventId), intval($userId)));
        }

        public function getPeopleRelatedToUser($userId){
            $sql = "SELECT p.* from event_subscription es inner join person p on p.person_id=es.person_id 
            inner join person_user pu on pu.person_id = es.person_user_id where es.person_user_id = ? and es.person_id <> ?";
            $rs = $this->executeRows($this->db, $sql, array(intval($userId), intval($userId)));

            $people = array();
            foreach($rs as $result)
                $people[] = Person::createPersonObject($result);
            

            return $people;
        }

    }
?>