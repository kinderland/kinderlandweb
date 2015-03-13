<?php
require_once APPPATH . 'core/CK_Model.php';

class event_model extends CK_Model{

	public function __construct(){
		parent::__construct();
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


        if($resultSet)
            return Event::createEventObject($resultSet);

        return null;
    }

    public function insertNewEvent($event_name, $description, $date_start, $date_finish, 
        $date_start_show, $date_finish_show, $private, $price){

        $this->Logger->info("Running: " . __METHOD__);
        
        $sql = 'INSERT INTO event(event_name, description, date_created, date_start, date_finish, 
            date_start_show, date_finish_show, private, price) VALUES (?,?, current_timestamp,?,?,?,?,?,?)';
        $returnId = $this->executeReturningId($this->db, $sql, array($event_name, $description, $date_start, $date_finish, 
                $date_start_show, $date_finish_show, $private, $price));
        if($returnId)
            return $returnId;

        return false;
    }


}

?>