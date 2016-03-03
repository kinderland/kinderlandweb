<?php
class SummerCampPaymentPeriod {
	private $paymentPeriodId;
	private $summerCampId;
	private $dateStart;
	private $dateFinish;
	private $price;
	private $portions;
	private $associatedPrice;

	public function __construct($paymentPeriodId, $summerCampId, $dateStart, $dateFinish, $price, $portions, $associatedPrice) {
		$this -> paymentPeriodId = $paymentPeriodId;
		$this -> summerCampId = $summerCampId;
		$this -> dateStart = $dateStart;
		$this -> dateFinish = $dateFinish;
		$this -> price = $price;
		$this -> portions = $portions;
		$this -> associatedPrice = $associatedPrice;
	}

	public static function createSummerCampPaymentPeriodObject($resultRow) {
		return new SummerCampPaymentPeriod($resultRow -> payment_period_id, $resultRow -> summer_camp_id, $resultRow -> date_start, $resultRow -> date_finish, $resultRow -> price, $resultRow -> portions, $resultRow -> associate_price);
	}

	public function setPaymentPeriodId($paymentPeriodId) {
		$this -> paymentPeriodId = $paymentPeriodId;
	}

	public function getPaymentPeriodId() {
		return $this -> paymentPeriodId;
	}

	public function setSummerCampId($summerCampId) {
		$this -> summerCampId = $summerCampId;
	}

	public function getSummerCampId() {
		return $this -> summerCampId;
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

	public function setPrice($price) {
		$this -> price = $price;
	}

	public function getPrice() {
		return $this -> price;
	}

	public function setPortions($portions) {
		$this -> portions = $portions;
	}

	public function getPortions() {
		return $this -> portions;
	}
	
	public function setAssociatedPrice($associatedPrice) {
		$this -> associatedPrice = $associatedPrice;
	}
	
	public function getAssociatedPrice() {
		return $this -> associatedPrice;
	}

}
?>