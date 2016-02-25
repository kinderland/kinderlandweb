<?php
class Event {
	private $eventId;
	private $eventName;
	private $dateStart;
	private $dateFinish;
	//private $price;
	private $dateStartShow;
	private $dateFinishShow;
	private $description;
	private $enabled;
	private $capacityMale;
	private $capacityFemale;
	private $capacityNonSleeper;
	private $isValid;
	private $type;

	public function __construct($eventId, $eventName, $dateStart, $dateFinish, /*$price,*/$dateStartShow, $dateFinishShow, $description, $enabled, $capacityMale, $capacityFemale, $capacityNonSleeper,$type) {
		$this -> eventId = $eventId;
		$this -> eventName = $eventName;
		$this -> dateStart = $dateStart;
		$this -> dateFinish = $dateFinish;
		//$this->price = $price;
		$this -> dateStartShow = $dateStartShow;
		$this -> dateFinishShow = $dateFinishShow;
		$this -> description = $description;
		$this -> enabled = $enabled;
		$this -> capacityMale = $capacityMale;
		$this -> capacityFemale = $capacityFemale;
		$this -> capacityNonSleeper = $capacityNonSleeper;
		$this -> isValid = -1;
		$this -> type = $type;
	}

	public static function createEventObject($resultRow) {
		return new Event($resultRow -> event_id, $resultRow -> event_name, $resultRow -> date_start, $resultRow -> date_finish,
		//$resultRow->price,
		$resultRow -> date_start_show, $resultRow -> date_finish_show, $resultRow -> description, $resultRow -> enabled, $resultRow -> capacity_male, $resultRow -> capacity_female, $resultRow -> capacity_nonsleeper, $resultRow -> type_id);
	}

	public function setEventId($eventId) {
		$this -> eventId = $eventId;
	}

	public function getEventId() {
		return $this -> eventId;
	}

	public function setEventName($eventName) {
		$this -> eventName = $eventName;
	}

	public function getEventName() {
		return $this -> eventName;
	}

	public function setDateStart($dateStart) {
		$this -> dateStart = $dateStart;
	}

	public function getDateStart() {
		return $this -> dateStart;
	}

	public function setDateFinish($dateFinish) {
		$this -> dateFinish = $dateFinish;
	}

	public function getDateFinish() {
		return $this -> dateFinish;
	}

	/*
	 public function setPrice($price){
	 $this->price = $price;
	 }
	 public function getPrice(){
	 return $this->price;
	 }*/

	public function setDateStartShow($dateStartShow) {
		$this -> dateStartShow = $dateStartShow;
	}

	public function getDateStartShow() {
		return $this -> dateStartShow;
	}

	public function setDateFinishShow($dateFinishShow) {
		$this -> dateFinishShow = $dateFinishShow;
	}

	public function getDateFinishShow() {
		return $this -> dateFinishShow;
	}

	public function setDescription($description) {
		$this -> description = $description;
	}

	public function getDescription() {
		return $this -> description;
	}

	public function setEnabled($enabled) {
		$this -> enabled = $enabled;
	}

	public function isEnabled() {
		if ($this -> enabled == "t")
			return TRUE;
		return FALSE;
	}

	public function setCapacityMale($capacityMale) {
		$this -> capacityMale = $capacityMale;
	}

	public function getCapacityMale() {
		return $this -> capacityMale;
	}

	public function setCapacityFemale($capacityFemale) {
		$this -> capacityFemale = $capacityFemale;
	}

	public function getCapacityFemale() {
		return $this -> capacityFemale;
	}

	public function setCapacityNonSleeper($capacityNonSleeper) {
		$this -> capacityNonSleeper = $capacityNonSleeper;
	}

	public function getCapacityNonSleeper() {
		return $this -> capacityNonSleeper;
	}

	//Checa se o evento pode ser habilitado, mas não verifica seus periodos de pagamento.

	private function checkIsTheEventValid($payments) {
		//Verifica se tem datas de inicio, fim tanto de evento quanto de inscrições.
		if (!$this -> dateStart
			|| !$this -> dateFinish 
			|| !$this -> dateFinishShow 
			|| !$this -> dateStartShow)
			return FALSE;
		//Verifica se essas datas não se cruzam segundo as regras.
		if (!Events::verifyAntecedence($this -> dateStart, $this -> dateFinish) 
		|| !Events::verifyAntecedence($this->dateStartShow, $this->dateFinishShow) 
		|| Events::verifyAntecedence($this -> dateStart, $this->dateStartShow))
		return FALSE;
		if($payments){
			foreach ($payments as $payment) {
				if (!$payment -> getDateStart() || !$payment -> getDateFinish())
					return FALSE;
				if (!Events::verifyAntecedence($payment -> getDateStart(), $this -> dateFinishShow) 
				|| !Events::verifyAntecedence($payment -> getDateFinish(), $this -> dateFinishShow) 
				|| !Events::verifyAntecedence($this -> dateStartShow, $payment -> getDateStart()))
					return FALSE;
				foreach ($payments as $payment2) {
					if ($payment2 -> getPaymentPeriodId() != $payment -> getPaymentPeriodId()) {
						//Se o periodo A começar antes tem que acabar antes, se começar depois tem que começar depois do outro ter acabado
						if 	(
						(Events::verifyAntecedence($payment -> getDateStart(), $payment2 -> getDateStart()) 
						&& Events::verifyAntecedence($payment2 -> getDateStart(), $payment -> getDateFinish())) 
						|| 
						(Events::verifyAntecedence($payment2 -> getDateStart(), $payment -> getDateStart()) 
						&& Events::verifyAntecedence($payment -> getDateStart(), $payment2 -> getDateFinish())))
							return false;
					}
				}
			}
		}
		else 
			return FALSE;
		return TRUE;
	}

	public function setIsValid($payments){
		$this->isValid = $this->checkIsTheEventValid($payments);
	}


	public function getIsValid(){
		return $this->isValid;
	}
	
	public function setType($type){
		$this->type = $type;
	}
	
	public function getType() {
		return $this -> type;
	}

}
?>