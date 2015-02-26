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


}

?>