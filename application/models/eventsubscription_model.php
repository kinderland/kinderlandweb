<?php
    require_once APPPATH . 'core/CK_Model.php';
    require_once APPPATH . 'core/person.php';

    class eventsubscription_model extends CK_Model {
        
        public function __construct() {
            parent::__construct();
        }

        public function createSubcription($event, $userId, $personId, $subscriptionStatus) {
            $subs = $this->getSubscriptionByPersonIdAndEventId($personId, $event->getEventId());
            if(count($subs) == 0){
                $sql = "INSERT INTO event_subscription (person_id, event_id, person_user_id, subscription_status, age_group_id, associate) 
                    VALUES(?,?,?,?,3,false)";

                if ($this->execute($this->db, $sql, array( intval($personId), intval($event->getEventId()), intval($userId), $subscriptionStatus )))
                    return true;
            } else {
                $this->Logger->info("Failed to insert new, trying to update an existing one.");
                $sqlUpdate = "UPDATE event_subscription SET person_user_id = ?, subscription_status = ?, age_group_id = 3, associate = false
                              WHERE event_id = ? AND person_id = ?";
                if($this->execute($this->db, $sqlUpdate, array(  intval($userId), $subscriptionStatus, intval($event->getEventId()), intval($personId))))
                    return true;
            }
            throw new ModelException("Failed to create subscription");
        }

        public function getSubscriptionByPersonIdAndEventId($personId, $eventId){
            $sql = "SELECT * FROM event_subscription WHERE person_id = ? AND event_id = ?";

            return $this->executeRows($this->db, $sql, array(intval($personId), intval($eventId)));
        }

        public function unsubscribeUsersFromEvent($usersId, $eventId){
            $sql = "UPDATE event_subscription SET subscription_status = -1 WHERE event_id = ? AND person_id in (".$usersId.")";
            if ($this->execute($this->db, $sql, array(intval($eventId))))
                return true;

            throw new ModelException("Failed to create subscription");
        }

        public function getSubscriptionsForEventByUserId($userId, $eventId){
            $sql = "SELECT es.*, p.fullname, ag.description as age_description from event_subscription as es 
                    inner join person as p on p.person_id = es.person_id 
                    inner join age_group as ag on ag.age_group_id = es.age_group_id
                    where es.event_id = ? and es.person_user_id = ? and subscription_status >= 0";

            return $this->executeRows($this->db, $sql, array(intval($eventId), intval($userId)));
        }

        public function getPeopleRelatedToUser($userId){
            $sql = "SELECT p.*, (SELECT phone_number FROM telephone WHERE person_id = ? LIMIT 1) AS phone1,
                (SELECT phone_number FROM telephone WHERE person_id = ? LIMIT 1 OFFSET 1) AS phone2
                 from event_subscription es inner join person p on p.person_id=es.person_id 
            inner join person_user pu on pu.person_id = es.person_user_id where es.person_user_id = ? and es.person_id <> ?";
            $rs = $this->executeRows($this->db, $sql, array(intval($userId), intval($userId), intval($userId), intval($userId)));

            $people = array();
            foreach($rs as $result)
                $people[] = Person::createPersonObject($result);
            

            return $people;
        }

        public function getEventPrices($eventId){
            $sql = "SELECT * from payment_period
                    where event_id = ?  
                    and date_start <= ? and date_finish >= ?";

            $prices =  $this->executeRow($this->db, $sql, array(intval($eventId), date('Y-m-d H:m:s'), date('Y-m-d H:m:s') ));
            if(count($prices) > 0)
                return $prices;
            else {
                $sql = "SELECT * from payment_period
                    where event_id = ?  
                    and date_start = (SELECT max(date_start) from payment_period
                    where event_id = ?)";

                $prices =  $this->executeRow($this->db, $sql, array(intval($eventId), date('Y-m-d H:m:s') ));
                return $prices;
            }
                
        }

        public function getAgeGroups(){
            $sql = "SELECT * FROM age_group";

            return $this->executeRows($this->db, $sql);
        }

    }
?>