<?php

class event_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

    public function getPublicOpenEvents(){
        $sql = "SELECT * FROM open_public_events";
        $resultSet = $this->db->query($sql);

        $eventArray = array();

        if($resultSet->num_rows() > 0)
            foreach ($resultSet->result() as $row)
                $eventArray[] = Event::createEventObject($row);
            
        return $eventArray;
    }

    public function getEventById($eventId){
        $sql = "SELECT * FROM event WHERE event_id=?";
        $resultSet = $this->db->query($sql, array(intval($eventId)));


        if($resultSet->num_rows() > 0)
            return Event::createEventObject($resultSet->row());

        return null;
    }


}

?>