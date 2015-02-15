<?php
	class Event {
		private $eventId;
		private $eventName;
		private $dateStart;
		private $dateFinish;
		private $price;
		private $dateStartShow;
		private $dateFinishShow;
		private $description;
		private $private;

		public function __construct($eventId, $eventName, $dateStart, 
			$dateFinish, $price, $dateStartShow, $dateFinishShow, $description, $private){
			$this->eventId = $eventId;
			$this->eventName = $eventName;
			$this->dateStart = $dateStart;
			$this->dateFinish = $dateFinish;
			$this->price = $price;
			$this->dateStartShow = $dateStartShow;
			$this->dateFinishShow = $dateFinishShow;
			$this->description = $description;
			$this->private = $private;
		}

		public static function createEventObject($resultRow){
			return new Event(
				$resultRow->event_id,
				$resultRow->event_name,
				$resultRow->date_start,
				$resultRow->date_finish,
				$resultRow->price,
				$resultRow->date_start_show,
				$resultRow->date_finish_show,
				$resultRow->description,
				$resultRow->private
			);
		}

		public function setEventId($eventId){
			$this->eventId = $eventId;
		}
		public function getEventId(){
			return $this->eventId;
		}

		public function setEventName($eventName){
			$this->eventName = $eventName;
		}
		public function getEventName(){
			return $this->eventName;
		}

		public function setDateStart($dateStart){
			$this->dateStart = $dateStart;
		}
		public function getDateStart(){
			return $this->dateStart;
		}

		public function setDateFinish($dateFinish){
			$this->dateFinish = $dateFinish;
		}
		public function getDateFinish(){
			return $this->dateFinish;
		}

		public function setPrice($price){
			$this->price = $price;
		}
		public function getPrice(){
			return $this->price;
		}

		public function setDateStartShow($dateStartShow){
			$this->dateStartShow = $dateStartShow;
		}
		public function getDateStartShow(){
			return $this->dateStartShow;
		}

		public function setDateFinishShow($dateFinishShow){
			$this->dateFinishShow = $dateFinishShow;
		}
		public function getDateFinishShow(){
			return $this->dateFinishShow;
		}

		public function setDescription($description){
			$this->description = $description;
		}
		public function getDescription(){
			return $this->description;
		}

		public function setPrivate($private){
			$this->private = $private;
		}
		public function isPrivate(){
			return $this->private;
		}

	}
?>