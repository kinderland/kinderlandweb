<?php
require_once APPPATH . 'core/CK_Model.php';

class event_model extends CK_Model{

	public function __construct(){
		parent::__construct();
	}
    
    public function getAllEvents(){
        $sql = "SELECT * FROM event";
        $resultSet = $this->executeRows($this->db, $sql);

        $eventArray = array();

        if($resultSet)
            foreach ($resultSet as $row)
                $eventArray[] = Event::createEventObject($row);
            
        return $eventArray;
    }
    

    public function getPublicOpenEvents(){
        $sql = "SELECT * FROM open_public_events";
        $resultSet = $this->executeRows($this->db, $sql);

        $eventArray = array();

        if($resultSet)
            foreach ($resultSet as $row)
                $eventArray[] = Event::createEventObject($row);
            
        return $eventArray;
    }

    public function getEventById($eventId){
        $sql = "SELECT * FROM event WHERE event_id=?";
        $resultSet = $this->executeRow($this->db, $sql, array(intval($eventId)));

        $sqlCapacity = "
            select 
                'M' as gender, count(es.event_id) as vagas_ocupadas
            from person p
            left outer join event_subscription es
                on es.person_id = p.person_id
            where es.event_id = ? and es.subscription_status = 3
                and p.gender = 'M'

            UNION

            select 
                'F' as gender, count(es.event_id) as vagas_ocupadas
            from person p
            left outer join event_subscription es
                on es.person_id = p.person_id
            where es.event_id = ? and es.subscription_status = 3
                and p.gender = 'F'
        ";

        $capacityResultSet = $this->executeRows($this->db, $sqlCapacity, array(intval($eventId), intval($eventId)));

        $resultSet->capacity_male   = $resultSet->capacity_male   - $capacityResultSet[1]->vagas_ocupadas;
        $resultSet->capacity_female = $resultSet->capacity_female - $capacityResultSet[0]->vagas_ocupadas;

        if($resultSet)
            return Event::createEventObject($resultSet);

        return null;
    }

    public function insertNewEvent($event_name, $description, $date_start, $date_finish, 
        $date_start_show, $date_finish_show, $enabled, $capacity_male, $capacity_female,$capacity_nonsleeper){

        $this->Logger->info("Running: " . __METHOD__);
        
        $sql = 'INSERT INTO event(event_name, description, date_created, date_start, date_finish, 
            date_start_show, date_finish_show, enabled, capacity_male, capacity_female,capacity_nonsleeper) VALUES (?,?, current_timestamp,?,?,?,?,?,?,?,?)';
        
        $returnId = $this->executeReturningId($this->db, $sql, array($event_name, $description, $date_start, $date_finish, 
                $date_start_show, $date_finish_show, $enabled, $capacity_male, $capacity_female,$capacity_nonsleeper));
				
        if($returnId)
            return $returnId;

        return false;
    }
		
	public function insertNewPaymentPeriod($eventId, $date_start, $date_finish, $full_price,$middle_price,$children_price,$associate_discount,$portions){
        $this->Logger->info("Running: " . __METHOD__);
        
        $sql = 'INSERT INTO payment_period(event_id, date_start, date_finish, full_price, middle_price, 
            children_price, associate_discount, portions) VALUES (?,?,?,?,?,?,?,?)';
        
        $returnId = $this->executeReturningId($this->db, $sql, array($eventId, $date_start, $date_finish, 
                $full_price, $middle_price, $children_price, $associate_discount, $portions,));
				
        if($returnId)
            return $returnId;

        return false;
		
	}
	
	public function toggleEventEnable($eventId){
        $this->Logger->info("Running: " . __METHOD__);
        
        $sql = 'update event set enabled = NOT enabled where event_id = ?;';
        
        return $this->execute($this->db, $sql, array($eventId));
				
	}


}

?>