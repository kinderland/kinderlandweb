<?php
class Payment_period {
	private $payment_period_id;
	private $eventId;
	private $date_start;
	private $date_finish;
	private $full_price;
	private $middle_price;
	private $children_price;
	private $associate_discount;
	private $portions;

	public function __construct($payment_period_id, $eventId, $date_start, $date_finish, $full_price, $middle_price, $children_price, $associate_discount, $portions) {
		$this -> payment_period_id = $payment_period_id;
		$this -> eventId = $eventId;
		$this -> date_start = $date_start;
		$this -> date_finish = $date_finish;
		$this -> full_price = $full_price;
		$this -> middle_price = $middle_price;
		$this -> children_price = $children_price;
		$this -> associate_discount = $associate_discount;
		$this -> portions = $portions;
	}

	public static function createAddressObject($resultRow) {
		return new Payment_period($resultRow -> payment_period_id, $resultRow -> event_id, $resultRow -> date_start, $resultRow -> date_finish, $resultRow -> full_price, $resultRow -> middle_price, $resultRow -> children_price, $resultRow -> associate_discount, $resultRow -> portions);
	}

	public function setPaymentPeriodId($payment_period_id) {
		$this -> payment_period_id = $payment_period_id;
	}

	public function getPaymentPeriodId() {
		return $this -> payment_period_id;
	}

	public function setEventId($eventId) {
		$this -> eventId = $EventId;
	}

	public function getEventId() {
		return $this -> eventId;
	}

	public function setDateStart($dateStart) {
		$this -> date_start = $dateStart;
	}

	public function getDateStart() {
		return $this -> date_start;
	}

	public function setDateFinish($dateFinish) {
		$this -> date_finish = $dateFinish;
	}

	public function getDateFinish() {
		return $this -> date_finish;
	}

	public function setFullPrice($fullPrice) {
		$this -> full_price = $fullPrice;
	}

	public function getFullPrice() {
		return $this -> full_price;
	}

	public function setMiddlePrice($middlePrice) {
		$this -> middle_price = $middlePrice;
	}

	public function getMiddlePrice() {
		return $this -> middle_price;
	}

	public function setChildrenPrice($childrenPrice) {
		$this -> children_price = $childrenPrice;
	}

	public function getChildrenPrice() {
		return $this -> children_price;
	}

	public function setAssociateDiscount($associateDiscount) {
		$this -> associate_discount = $associateDiscount;
	}

	public function getAssociateDiscount() {
		return $this -> associate_discount;
	}

	public function setPortions($portions) {
		$this -> portions = $portions;
	}

	public function getPortions() {
		return $this -> portions;
	}

}
?>