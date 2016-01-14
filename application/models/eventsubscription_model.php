<?php
    require_once APPPATH . 'core/CK_Model.php';
    require_once APPPATH . 'core/person.php';

    class eventsubscription_model extends CK_Model {
        
        public function __construct() {
            parent::__construct();
        }

        public function createSubcription($event, $userId, $personId, $subscriptionStatus, $ageGroup, $isAssociate, $nonSleeper) {
            $subs = $this->getSubscriptionByPersonIdAndEventId($personId, $event->getEventId());
            if(count($subs) == 0){
                $sql = "INSERT INTO event_subscription (person_id, event_id, person_user_id, subscription_status, age_group_id, associate, nonsleeper) 
                    VALUES(?,?,?,?,?,?,?)";

                if ($this->execute($this->db, $sql, array( intval($personId), intval($event->getEventId()), intval($userId), $subscriptionStatus, intval($ageGroup), $isAssociate, $nonSleeper )))
                    return true;
            } else {
                //Tratar do caso se a inscrição estiver confirmada.
                
                $this->Logger->info("Failed to insert new, trying to update an existing one.");
                $sqlUpdate = "UPDATE event_subscription SET person_user_id = ?, subscription_status = ?, age_group_id = ?, associate = ?, nonsleeper = ?
                              WHERE event_id = ? AND person_id = ?";
                if($this->execute($this->db, $sqlUpdate, array(  intval($userId), $subscriptionStatus, intval($ageGroup), $isAssociate, $nonSleeper, intval($event->getEventId()), intval($personId) )))
                    return true;
            }
            throw new ModelException("Failed to create subscription");
        }

        public function getSubscriptionByPersonIdAndEventId($personId, $eventId){
            $sql = "SELECT * FROM event_subscription WHERE person_id = ? AND event_id = ?";

            return $this->executeRows($this->db, $sql, array(intval($personId), intval($eventId)));
        }
        public function getPersonsIdByEventIdAndDonationId($eventId, $donationId) {
        	$sql = "SELECT * FROM event_subscription es INNER JOIN age_group ag
            		on ag.age_group_id = es.age_group_id WHERE es.event_id = ? AND es.donation_id = ?";
        	
        	return $this -> executeRows($this->db, $sql, array(intval($eventId), intval($donationId)));
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
            inner join person_user pu on pu.person_id = es.person_user_id where es.person_user_id = ?";
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

                $prices = $this->executeRow($this->db, $sql, array(intval($eventId), intval($eventId) ));
                return $prices;
            }
                
        }

        public function getAgeGroups(){
            $sql = "SELECT * FROM age_group ORDER BY age_group_id";

            return $this->executeRows($this->db, $sql);
        }

        public function getSubscriptions($userId, $eventId, $personIds){
            $sql = "SELECT es.*, p.fullname, ag.description as age_description from event_subscription as es 
                    inner join person as p on p.person_id = es.person_id 
                    inner join age_group as ag on ag.age_group_id = es.age_group_id
                    where es.event_id = ? and es.person_user_id = ? and subscription_status >= 0 and es.person_id in (".$personIds.")";

            return $this->executeRows($this->db, $sql, array(intval($eventId), intval($userId), $personIds));
        }

        public function updateSubscriptionsDonationId($personIds, $userId, $eventId, $donationId){
            $this->Logger->info("Running: " . __METHOD__);
            $sql = "UPDATE event_subscription SET donation_id = ? WHERE event_id = ? AND person_user_id = ? AND person_id in (".$personIds.")";
            return $this->execute($this->db, $sql, array( intval($donationId), intval($eventId), intval($userId) ));
        }

        public function evaluateCheckoutValues($subscriptions, $paymentOptions){
            $this->Logger->info("Running: " . __METHOD__);
            $this->Logger->debug("Parameter 1: ". print_r($subscriptions, true));
            $this->Logger->debug("Parameter 2: ". print_r($paymentOptions, true));
            $totalPrice = 0.00;
            $totalDiscounted = 0.00;
            foreach ($subscriptions as $sub){
                $value = 0.00;
                switch ($sub->age_group_id){
                    case AGE_GROUP_CHILDREN_PRICE:
                        $this->Logger->info("Children price age group =====> R$".$paymentOptions->children_price);
                        $value = $paymentOptions->children_price;
                        break;
                    case AGE_GROUP_MIDDLE_PRICE:
                        $this->Logger->info("Middle price age group =====> R$".$paymentOptions->middle_price);
                        $value = $paymentOptions->middle_price;
                        break;
                    case AGE_GROUP_FULL_PRICE:
                    default:
                        $this->Logger->info("Full price age group =====> R$".$paymentOptions->full_price);
                        $value = $paymentOptions->full_price;
                        break;

                }

                if($sub->associate == "t"){
                    $discount = $value * $paymentOptions->associate_discount;
                    $totalDiscounted += $discount;
                    $value -= $discount;
                }
                    
                $totalPrice += $value;
            }
        
            return array("total_price" => $totalPrice, "total_discounted" => $totalDiscounted);
        }

        public function updateSubscriptionsStatusByDonationId($donation_id, $status) {
            $sql = "UPDATE event_subscription SET subscription_status = ? WHERE donation_id = ?";
            return $this->execute($this->db, $sql, array($status, intval($donation_id)));
        }
        public function getSubscriptionsByEventId ($eventId){
            $sql = "SELECT * FROM event_subscription WHERE event_id = ?";
            return $this->executeRows($this->db, $sql, array(intval($eventId)));
        }

    }
?>