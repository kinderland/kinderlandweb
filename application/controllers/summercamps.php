<?php

require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/summercamp.php';
require_once APPPATH . 'core/summercampSubscription.php';

class SummerCamps extends CK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('address_model');
        $this->load->model('colonist_model');
        $this->load->model('donation_model');
        $this->load->model('generic_model');
        $this->load->model('medical_file_model');
        $this->load->model('person_model');
        $this->load->model('personuser_model');
        $this->load->model('summercamp_model');
        $this->load->model('telephone_model');
        $this->load->model('validation_model');
        $this->address_model->setLogger($this->Logger);
        $this->colonist_model->setLogger($this->Logger);
        $this->donation_model->setLogger($this->Logger);
        $this->generic_model->setLogger($this->Logger);
        $this->medical_file_model->setLogger($this->Logger);
        $this->person_model->setLogger($this->Logger);
        $this->personuser_model->setLogger($this->Logger);
        $this->summercamp_model->setLogger($this->Logger);
        $this->telephone_model->setLogger($this->Logger);
        $this->validation_model->setLogger($this->Logger);
    }

    public function indexm()
    {
        return $this->index('1');
    }

    public function index($i = null)
    {
        $this->Logger->info("Starting " . __METHOD__);
        $isAssociate = $this->personuser_model->isAssociate($this->session->userdata("user_id"));

        if ($isAssociate) {
            $hasTemporary         = $this->personuser_model->hasTemporary($this->session->userdata("user_id"));
            $data['hasTemporary'] = $hasTemporary;
            $isAssociate          = !($hasTemporary);
        }

        $data["summerCamps"]            = $this->summercamp_model->getAvailableSummerCamps($isAssociate);
        $data["summerCampInscriptions"] = $this->summercamp_model->getSummerCampSubscriptionsOfUser($this->session->userdata("user_id"));
        $data["summercamp_model"]       = $this->summercamp_model;
        $rawStatusArray                 = $this->summercamp_model->getStatusArray();
        $statusArray                    = array();
        foreach ($rawStatusArray as $status) {
            switch ($status["database_id"]) {
                case 0:
                case 1:
                    $statusArray[$status["database_id"]] = $status;
                    break;
                case 2:
                case 3:
                case 4:
                case 5:
                    $statusArray[$status["database_id"] + 1] = $status;
                    break;
                case 6:
                    $statusArray[2] = $status;
                case -1:
                case -2:
                case -3:
                    $statusArray[6 - $status["database_id"]] = $status;
                    break;
            }
        }

        $data['i']           = $i;
        $data["statusArray"] = $statusArray;
        $this->loadView('summercamps/index', $data);
    }

    public function getPreviousSubscriptions()
    {
        $colonists_id = $this->input->post('colonists_id', true);
        $this->Logger->info("COLONISTAS: " . $colonists_id);
        $colonists_id = explode("-", $colonists_id);

        $summercampId = $this->input->post('summercampId', true);

        foreach ($colonists_id as $c) {
            if ($c !== "") {
                if (!$this->summercamp_model->getOldSubscriptionByUserIdAndColonistIdAndInsertNew($this->session->userdata("user_id"), $c, $summercampId)) {
                    echo "false";
                    return;
                }
            }
        }

        echo "true";
        return;
    }

    public function subscribeColonist()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $id                 = $this->input->get('id', true);
        $data["summerCamp"] = $this->summercamp_model->getSummerCampById($id);
        $data["id"]         = $id;
        $this->loadView('summercamps/subscribeColonist', $data);
    }

    public function editSubscriptionColonistForm()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $colonistId                     = $this->input->get('colonistId', true);
        $summerCampId                   = $this->input->get('summerCampId', true);
        $oldSubscriptionRestored        = $this->summercamp_model->isOldSubscriptionRestored($summerCampId, $colonistId);
        $camper                         = $this->summercamp_model->getSummerCampSubscription($colonistId, $summerCampId);
        $address                        = $this->address_model->getAddressByPersonId($camper->getPersonId());
        $responsableId                  = $this->session->userdata("user_id");
        $responsableAddress             = $this->address_model->getAddressByPersonId($responsableId);
        $data["sameAddressResponsable"] = "n";
        if ($responsableAddress) {
            if ($address->getAddressId() == $responsableAddress->getAddressId()) {
                $data["sameAddressResponsable"] = "s";
            }
        }

        $data["summerCamp"]   = $this->summercamp_model->getSummerCampById($summerCampId);
        $data["summerCampId"] = $summerCampId;
        $data["colonistId"]   = $colonistId;
        $data["personId"]     = $camper->getPersonId();
        $data["fullName"]     = $camper->getFullName();
        $data["Gender"]       = $camper->getGender();
        $data["birthdate"]    = date("d-m-Y", strtotime($camper->getBirthDate()));
        if ($oldSubscriptionRestored) {
            if ($oldSubscriptionRestored->register == 'f') {
                $data["school"]     = null;
                $data["schoolYear"] = null;
            } else if ($oldSubscriptionRestored->register == 't') {
                $data["school"]     = $camper->getSchool();
                $data["schoolYear"] = $camper->getSchoolYear();
            }
        } else {
            $data["school"]     = $camper->getSchool();
            $data["schoolYear"] = $camper->getSchoolYear();
        }
        $data["documentNumber"] = $camper->getDocumentNumber();
        $data["documentType"]   = $camper->getDocumentType();
        $data["phone1"]         = $camper->getDocumentType();
        $data["phone2"]         = $camper->getDocumentType();
        $data["street"]         = $address->getStreet();
        $data["number"]         = $address->getPlaceNumber();
        $data["city"]           = $address->getCity();
        $data["cep"]            = $address->getCEP();
        $data["complement"]     = $address->getComplement();
        $data["neighborhood"]   = $address->getNeighborhood();
        $data["uf"]             = $address->getUf();
        $telephones             = $this->telephone_model->getTelephonesByPersonId($camper->getPersonId());
        $data["phone1"]         = isset($telephones[0]) ? $telephones[0] : false;
        $data["phone2"]         = isset($telephones[1]) ? $telephones[1] : false;
        $father                 = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
        $mother                 = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");
        $data["dad"]            = "";
        if ($father) {
            $data["dad"] = $father;
            if ($father == $responsableId) {
                $data["responsableDadMother"] = "dad";
            }

            $father              = $this->person_model->getPersonFullById($father);
            $data["dadFullName"] = $father->fullname;
            $data["dadEmail"]    = $father->email;
            $data["dadPhone"]    = $father->phone1;
        }
        $data["mother"] = "";
        if ($mother) {
            $data["mother"] = $mother;
            if ($mother == $responsableId) {
                $data["responsableDadMother"] = "mother";
            }

            $mother                 = $this->person_model->getPersonFullById($mother);
            $data["motherFullName"] = $mother->fullname;
            $data["motherEmail"]    = $mother->email;
            $data["motherPhone"]    = $mother->phone1;
        }
        if ($data["summerCamp"]->isMiniCamp()) {
            $miniCamp         = $this->summercamp_model->getMiniCampObs($summerCampId, $colonistId);
            $data['miniCamp'] = $miniCamp;
        }

        if ($camper->getRoommate1()) {
            $data['roommate1'] = $camper->getRoommate1();
        }

        if ($camper->getRoommate2()) {
            $data['roommate2'] = $camper->getRoommate2();
        }

        if ($camper->getRoommate3()) {
            $data['roommate3'] = $camper->getRoommate3();
        }

        if ($camper->getSpecialCare()) {
            $data['specialCare'] = $camper->getSpecialCare();
        }

        if ($camper->getSpecialCareObs()) {
            $data['specialCareObs'] = $camper->getSpecialCareObs();
        }

        $this->loadView('summercamps/editSubscriptionColonistForm', $data);
    }

    public function editSubscriptionColonist()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $colonistId             = $this->input->post('colonistId', true);
        $summerCampId           = $this->input->post('summerCampId', true);
        $personId               = $this->input->post('personId', true);
        $fullname               = $this->input->post('fullname', true);
        $gender                 = $this->input->post('gender', true);
        $street                 = $this->input->post('street', true);
        $number                 = $this->input->post('number', true);
        $city                   = $this->input->post('city', true);
        $phone1                 = $this->input->post('phone1', true);
        $phone2                 = $this->input->post('phone2', true);
        $cep                    = $this->input->post('cep', true);
        $occupation             = $this->input->post('occupation', true);
        $complement             = $this->input->post('complement', true);
        $neighborhood           = $this->input->post('neighborhood', true);
        $uf                     = $this->input->post('uf', true);
        $birthdate              = $this->input->post('birthdate', true);
        $school                 = $this->input->post('school', true);
        $schoolYear             = $this->input->post('schoolYear', true);
        $documentType           = $this->input->post('documentType', true);
        $documentNumber         = $this->input->post('documentNumber', true);
        $sameAddressResponsable = $this->input->post('sameAddressResponsable', true);
        $summerCampId           = $this->input->post('summerCampId', true);
        $responsableDadMother   = $this->input->post('responsableDadMother', true);
        $dad                    = $this->input->post('dad', true);
        $dadDeclare             = $this->input->post('dadDeclare', true);
        $dadFullName            = $this->input->post('dadFullName', true);
        $dadPhone               = $this->input->post('dadPhone', true);
        $dadEmail               = $this->input->post('dadEmail', true);
        $mother                 = $this->input->post('mother', true);
        $motherDeclare          = $this->input->post('motherDeclare', true);
        $motherFullName         = $this->input->post('motherFullName', true);
        $motherPhone            = $this->input->post('motherPhone', true);
        $motherEmail            = $this->input->post('motherEmail', true);
        $responsableId          = $this->session->userdata("user_id");
        $summerCampMini         = $this->input->post('summerCampMini', true);
        $roommate1              = $this->input->post('roommate1', true);
        $roommate2              = $this->input->post('roommate2', true);
        $roommate3              = $this->input->post('roommate3', true);
        $specialCare            = $this->input->post('specialCare', true);
        $specialCareObs         = $this->input->post('specialCareObs', true);

        try {
            $this->Logger->info("Editing colonist $summerCampId");
            $this->generic_model->startTransaction();
            if ($sameAddressResponsable === "s") {
                $addressId = $this->address_model->getAddressByPersonId($responsableId)->getAddressId();
            } else {
                $addressId = $this->address_model->insertNewAddress($street, $number, $complement, $cep, $neighborhood, $city, $uf);
            }

            $this->person_model->updatePerson($fullname, $gender, null, $personId, $addressId);
            $this->colonist_model->updateColonist($personId, $birthdate, $documentNumber, $documentType, $colonistId);
            if ($school[0] == -1) {
                if ($school[1] != -1) {
                    $school = $school[1];
                    $this->summercamp_model->insertSchool($school);
                }
            } else {
                $school = $school[0];
            }
            $this->summercamp_model->editColonistSubscription($summerCampId, $colonistId, $school, $schoolYear, $roommate1, $roommate2, $roommate3, $specialCare, $specialCareObs);

            if ($phone1 || $phone2) {
                $this->telephone_model->updatePhone($personId, $phone1, $phone2);
            }

            $dadId    = 0;
            $motherId = 0;

            if ($responsableDadMother === "dad") {
                $dadId = $responsableId;
            } else if ($responsableDadMother === "mother") {
                $motherId = $responsableId;
            }

            $this->summercamp_model->removeParentFromSummerCampSubscripted($summerCampId, $colonistId, "Pai");
            $this->summercamp_model->removeParentFromSummerCampSubscripted($summerCampId, $colonistId, "Mãe");

            if ($dadId == 0 && !$dadDeclare && $dadFullName && $dadEmail && $dadPhone) {
                $this->Logger->info("Inserting dad for colonist $colonistId in summercamp $summerCampId");
                $dadId = $this->person_model->insertPersonWithoutAddress($dadFullName, "M", $dadEmail);
                $this->telephone_model->insertNewTelephone($dadPhone, $dadId);
            }

            if ($motherId == 0 && !$motherDeclare && $motherFullName && $motherEmail && $motherPhone) {
                $this->Logger->info("Inserting Mom for colonist $colonistId in summercamp $summerCampId");
                $motherId = $this->person_model->insertPersonWithoutAddress($motherFullName, "F", $motherEmail);
                $this->telephone_model->insertNewTelephone($motherPhone, $motherId);
            }

            if ($dadId != 0) {
                $this->summercamp_model->addParentToSummerCampSubscripted($summerCampId, $colonistId, $dadId, "Pai");
            }

            if ($motherId != 0) {
                $this->summercamp_model->addParentToSummerCampSubscripted($summerCampId, $colonistId, $motherId, "Mãe");
            }

            $this->validation_model->sentNewSubscription($colonistId, $summerCampId);

            //Caso tenha ocorrido tudo bem, salva as mudanças
            $this->generic_model->commitTransaction();

            if ($summerCampMini) {
                $sleepOut            = $this->input->post('sleepOut', true);
                $summerInterest      = $this->input->post('summerInterest', true);
                $wakeUpEarly         = $this->input->post('wakeUpEarly', true);
                $foodRestriction     = $this->input->post('foodRestriction', true);
                $feedsIndependently  = $this->input->post('feedsIndependently', true);
                $wcIndependent       = $this->input->post('wcIndependent', true);
                $routineToFallAsleep = $this->input->post('routineToFallAsleep', true);
                $bunkBed             = $this->input->post('bunkBed', true);
                $awakeAtNight        = $this->input->post('awakeAtNight', true);
                $sleepwalk           = $this->input->post('sleepwalk', true);
                $nameResponsible     = $this->input->post('nameResponsible', true);
                $phoneResponsible    = $this->input->post('phoneResponsible', true);
                $observationMini     = $this->input->post('observationMini', true);
                $sleepEnuresis       = $this->input->post('sleepEnuresis', true);
                $this->summercamp_model->updateSummerCampMini($summerCampId, $colonistId, $sleepOut, $summerInterest, $wakeUpEarly, $foodRestriction, $feedsIndependently, $wcIndependent, $routineToFallAsleep, $bunkBed, $awakeAtNight, $sleepEnuresis, $sleepwalk, $observationMini, $nameResponsible, $phoneResponsible);
            }

            $oldSubscriptionRestored = $this->summercamp_model->isOldSubscriptionRestored($summerCampId, $colonistId);

            if ($oldSubscriptionRestored) {
                $this->summercamp_model->turnOnSummerCampOldSubscriptionStatus($summerCampId, $colonistId, 'register');
            }

            $this->Logger->info("Colonist sucessfully edited");

            redirect("summercamps/index");
        } catch (Exception $ex) {
            $this->Logger->error("Failed to edit colonist subscription");
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;
            redirect("summercamps/editSubscriptionColonistForm?colonistId=$colonistId&summerCampId=$summerCampId");
        }
    }

    public function confirmDocument()
    {
        $camp_id       = $this->input->post('camp_id', true);
        $colonist_id   = $this->input->post('colonist_id', true);
        $document_type = $this->input->post('document_type', true);

        if ($document_type == 3) {
            $status = 'identification_document';
        } else if ($document_type == 5) {
            $status = 'photo';
        }

        if ($this->summercamp_model->turnOnSummerCampOldSubscriptionStatus($camp_id, $colonist_id, $status)) {
            echo "true";
            return;
        } else {
            echo "false";
            return;
        }

    }

    public function completeSubscription()
    {
        $this->Logger->info("Starting " . __METHOD__);

        $fullname               = $this->input->post('fullname', true);
        $gender                 = $this->input->post('gender', true);
        $street                 = $this->input->post('street', true);
        $number                 = $this->input->post('number', true);
        $city                   = $this->input->post('city', true);
        $phone1                 = $this->input->post('phone1', true);
        $phone2                 = $this->input->post('phone2', true);
        $cep                    = $this->input->post('cep', true);
        $occupation             = $this->input->post('occupation', true);
        $complement             = $this->input->post('complement', true);
        $neighborhood           = $this->input->post('neighborhood', true);
        $uf                     = $this->input->post('uf', true);
        $birthdate              = $this->input->post('birthdate', true);
        $school                 = $this->input->post('school', true);
        $schoolYear             = $this->input->post('schoolYear', true);
        $documentType           = $this->input->post('documentType', true);
        $documentNumber         = $this->input->post('documentNumber', true);
        $sameAddressResponsable = $this->input->post('sameAddressResponsable', true);
        $summerCampId           = $this->input->post('summerCampId', true);
        $responsableDadMother   = $this->input->post('responsableDadMother', true);
        $dadDeclare             = $this->input->post('dadDeclare', true);
        $dadFullName            = $this->input->post('dadFullName', true);
        $dadPhone               = $this->input->post('dadPhone', true);
        $dadEmail               = $this->input->post('dadEmail', true);
        $motherDeclare          = $this->input->post('motherDeclare', true);
        $motherFullName         = $this->input->post('motherFullName', true);
        $motherPhone            = $this->input->post('motherPhone', true);
        $motherEmail            = $this->input->post('motherEmail', true);
        $responsableId          = $this->session->userdata("user_id");
        $roommate1              = $this->input->post('roommate1', true);
        $roommate2              = $this->input->post('roommate2', true);
        $roommate3              = $this->input->post('roommate3', true);
        $specialCare            = $this->input->post('specialCare', true);
        $specialCareObs         = $this->input->post('specialCareObs', true);
        $summerCampMini         = $this->input->post('summerCampMini', true);

        try {
            $this->Logger->info("Inserting new colony subscription");
            //Inicia transação no banco
            $this->generic_model->startTransaction();

            //Faz todo o processo que tem que ser feito no banco
            if ($sameAddressResponsable === "s") {
                $addressId = $this->address_model->getAddressByPersonId($responsableId)->getAddressId();
            } else {
                $addressId = $this->address_model->insertNewAddress($street, $number, $complement, $cep, $neighborhood, $city, $uf);
            }

            if ($addressId == 0) // If necessario para evitar propagacao de erros em query resultando em colonista nao inscrito
            {
                $addressId = null;
            }

            $personId   = $this->person_model->insertNewPerson($fullname, $gender, null, $addressId);
            $colonistId = $this->colonist_model->insertColonist($personId, $birthdate, $documentNumber, $documentType);
            if ($school[0] == -1) {
                if ($school[1] != -1) {
//So evitando que alguem tente inserir uma escola com nome -1 o que poderia quebrar o nosso sistema...
                    $school = $school[1];
                    $this->summercamp_model->insertSchool($school);
                }
            } else {
                $school = $school[0];
            }
            $this->summercamp_model->subscribeColonist($summerCampId, $colonistId, $responsableId, SUBSCRIPTION_STATUS_PRE_SUBSCRIPTION_INCOMPLETE, $school, $schoolYear, $roommate1, $roommate2, $roommate3, $specialCare, $specialCareObs);

            if ($phone1) {
                $this->telephone_model->insertNewTelephone($phone1, $personId);
            }

            if ($phone2) {
                $this->telephone_model->insertNewTelephone($phone2, $personId);
            }

            $dadId    = 0;
            $motherId = 0;

            if ($responsableDadMother === "dad") {
                $dadId = $responsableId;
            } else if ($responsableDadMother === "mother") {
                $motherId = $responsableId;
            }

            if ($dadId == 0 && !$dadDeclare && $dadFullName && $dadEmail && $dadPhone) {
                $this->Logger->info("Inserting dad for colonist $colonistId in summercamp $summerCampId");
                $dadId = $this->person_model->insertPersonWithoutAddress($dadFullName, "M", $dadEmail);
                $this->telephone_model->insertNewTelephone($dadPhone, $dadId);
            }

            if ($motherId == 0 && !$motherDeclare && $motherFullName && $motherEmail && $motherPhone) {
                $this->Logger->info("Inserting Mom for colonist $colonistId in summercamp $summerCampId");
                $motherId = $this->person_model->insertPersonWithoutAddress($motherFullName, "F", $motherEmail);
                $this->telephone_model->insertNewTelephone($motherPhone, $motherId);
            }

            if ($dadId != 0) {
                $this->summercamp_model->addParentToSummerCampSubscripted($summerCampId, $colonistId, $dadId, "Pai");
            }

            if ($motherId != 0) {
                $this->summercamp_model->addParentToSummerCampSubscripted($summerCampId, $colonistId, $motherId, "Mãe");
            }

            if ($summerCampMini) {
                $sleepOut            = $this->input->post('sleepOut', true);
                $summerInterest      = $this->input->post('summerInterest', true);
                $wakeUpEarly         = $this->input->post('wakeUpEarly', true);
                $foodRestriction     = $this->input->post('foodRestriction', true);
                $feedsIndependently  = $this->input->post('feedsIndependently', true);
                $wcIndependent       = $this->input->post('wcIndependent', true);
                $routineToFallAsleep = $this->input->post('routineToFallAsleep', true);
                $bunkBed             = $this->input->post('bunkBed', true);
                $awakeAtNight        = $this->input->post('awakeAtNight', true);
                $sleepwalk           = $this->input->post('sleepwalk', true);
                $nameResponsible     = $this->input->post('nameResponsible', true);
                $phoneResponsible    = $this->input->post('phoneResponsible', true);
                $observationMini     = $this->input->post('observationMini', true);
                $sleepEnuresis       = $this->input->post('sleepEnuresis', true);
                $this->summercamp_model->saveSummerCampMini($summerCampId, $colonistId, $sleepOut, $summerInterest,  $wakeUpEarly, $foodRestriction, $feedsIndependently, $wcIndependent, $routineToFallAsleep, $bunkBed, $awakeAtNight, $sleepEnuresis, $sleepwalk, $observationMini, $nameResponsible, $phoneResponsible);
            }

            $this->generic_model->commitTransaction();

            $this->Logger->info("New colonist successfully inserted");

            redirect("summercamps/index");
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new colonist");
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;
            redirect("summercamps/index");
        }
    }

    public function deleteColonist()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $campId        = $this->input->get('camp_id', true);
        $colonistId    = $this->input->get('colonist_id', true);
        $camper        = $this->summercamp_model->getSummerCampSubscription($colonistId, $campId);
        $personUserId  = $camper->getPersonUserId();
        $responsableId = $this->session->userdata("user_id");

        if ($personUserId !== $responsableId) {
            $this->Logger->error("Responsavel de id $responsableId tentou deletar o colonista $colonistId da campanha $campId que pertence ao responsavel $personUserId");
            //$this->index();
        } else {
            $this->summercamp_model->updateColonistStatus($colonistId, $campId, SUMMER_CAMP_SUBSCRIPTION_STATUS_GIVEN_UP);
            //$this->index();
        }

        redirect("summercamps/index");
    }

    public function excludeColonist()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $campId        = $this->input->get('camp_id', true);
        $colonistId    = $this->input->get('colonist_id', true);
        $camper        = $this->summercamp_model->getSummerCampSubscription($colonistId, $campId);
        $personUserId  = $camper->getPersonUserId();
        $responsableId = $this->session->userdata("user_id");

        if ($personUserId !== $responsableId) {
            $this->Logger->error("Responsavel de id $responsableId tentou excluir o colonista $colonistId da campanha $campId que pertence ao responsavel $personUserId");
            //$this->index();
        } else {
            //$this->summercamp_model->updateColonistStatus($colonistId, $campId, SUMMER_CAMP_SUBSCRIPTION_STATUS_EXCLUDED);
            $this->sendExclusionEmail($colonistId, $campId);
            //$this->index();
        }

        redirect("summercamps/index");
    }

    public function medicalFile($data)
    {
        if ($this->summercamp_model->hasDocument($data["camp_id"], $data["colonist_id"], DOCUMENT_MEDICAL_FILE)) {
            $medical_file      = $this->medical_file_model->getMedicalFile($data["camp_id"], $data["colonist_id"]);
            $data["bloodType"] = $medical_file->getBloodType();
            $data["rh"]        = $medical_file->getRH();

            $oldSubscriptionRestored = $this->summercamp_model->isOldSubscriptionRestored($data["camp_id"], $data["colonist_id"]);

            if ($oldSubscriptionRestored) {
                if ($oldSubscriptionRestored->medical_file == "f") {
                    $data["weight"]                      = null;
                    $data["height"]                      = null;
                    $data["physicalActivityRestriction"] = null;
                    $data["vacineTetanus"]               = null;
                    $data["vacineMMR"]                   = null;
                    $data["vacineTetanus"]               = null;
                    $data["vacineHepatitis"]             = null;
                    $data["vacineYellowFever"]           = null;
                    $data["antecedents"]                 = null;
                    $data["regularUseMedicine"]          = null;
                    $data["medicineRestrictions"]        = null;
                    $data["allergies"]                   = null;
                    $data["analgesicAntipyretic"]        = null;
                    $data["specialCareMedical"]          = null;
                    $data["psychMedication"]             = null;
                } else if ($oldSubscriptionRestored->medical_file == 't') {
                    $data["weight"]                      = $medical_file->getWeight();
                    $data["height"]                      = $medical_file->getHeight();
                    $data["physicalActivityRestriction"] = $medical_file->getPhysicalActivityRestriction();
                    $data["vacineTetanus"]               = $medical_file->getVacineTetanus();
                    $data["vacineMMR"]                   = $medical_file->getVacineMMR();
                    $data["vacineTetanus"]               = $medical_file->getVacineTetanus();
                    $data["vacineHepatitis"]             = $medical_file->getVacineHepatitis();
                    $data["vacineYellowFever"]           = $medical_file->getVacineYellowFever();
                    $data["antecedents"]                 = $medical_file->getInfectoContagiousAntecedents();
                    $data["regularUseMedicine"]          = $medical_file->getRegularUseMedicine();
                    $data["medicineRestrictions"]        = $medical_file->getMedicineRestrictions();
                    $data["allergies"]                   = $medical_file->getAllergies();
                    $data["analgesicAntipyretic"]        = $medical_file->getAnalgesicAntipyretic();
                    $data["specialCareMedical"]          = $medical_file->getSpecialCareMedical();
                    $data["psychMedication"]             = $medical_file->getPsychMedication();
                }
            } else {
                $data["weight"]                      = $medical_file->getWeight();
                $data["height"]                      = $medical_file->getHeight();
                $data["physicalActivityRestriction"] = $medical_file->getPhysicalActivityRestriction();
                $data["vacineTetanus"]               = $medical_file->getVacineTetanus();
                $data["vacineMMR"]                   = $medical_file->getVacineMMR();
                $data["vacineTetanus"]               = $medical_file->getVacineTetanus();
                $data["vacineHepatitis"]             = $medical_file->getVacineHepatitis();
                $data["vacineYellowFever"]           = $medical_file->getVacineYellowFever();
                $data["antecedents"]                 = $medical_file->getInfectoContagiousAntecedents();
                $data["regularUseMedicine"]          = $medical_file->getRegularUseMedicine();
                $data["medicineRestrictions"]        = $medical_file->getMedicineRestrictions();
                $data["allergies"]                   = $medical_file->getAllergies();
                $data["analgesicAntipyretic"]        = $medical_file->getAnalgesicAntipyretic();
                $data["specialCareMedical"]          = $medical_file->getSpecialCareMedical();
                $data["psychMedication"]             = $medical_file->getPsychMedication();
            }

            $doctorId            = $medical_file->getDoctorId();
            $doctor              = $this->person_model->getPersonById($doctorId);
            $data["doctorName"]  = $doctor->getFullName();
            $data["doctorEmail"] = $doctor->getEmail();
            $tels                = $this->telephone_model->getTelephonesByPersonId($doctorId);
            if (isset($tels[0])) {
                $data["doctorPhone1"] = $tels[0];
            } else {
                $data["doctorPhone1"] = "";
            }

            if (isset($tels[1])) {
                $data["doctorPhone2"] = $tels[1];
            } else {
                $data["doctorPhone2"] = "";
            }

            $colonistid = $data["colonist_id"];

            $colonist = $this->summercamp_model->getColonistInformationById($colonistid);

            $data['colonist_id']    = $colonist->colonist_id;
            $data['ano_escolhido']  = $colonist->year;
            $data['summer_camp_id'] = $colonist->camp_id;
            $data['pavilhao']       = $colonist->pavilhao;
            $data['quarto']         = $colonist->room;

            $type         = 'simples';
            $data['type'] = $type;

            $this->loadView('summercamps/editMedicalFileForm', $data);
        } else {
            $this->loadView('summercamps/medicalFile', $data);
        }
    }

    public function medicalFileStaff()
    {
        $user      = $this->personuser_model->getUserById($this->session->userdata("user_id"));
        $person_id = $user->getPersonId();

        $data['person_id'] = $person_id;
        $data['editable']  = true;

        if ($this->summercamp_model->hasDocumentStaff($person_id, DOCUMENT_MEDICAL_FILE)) {
            $medical_file                        = $this->medical_file_model->getStaffMedicalFile($person_id);
            $data["bloodType"]                   = $medical_file->getBloodType();
            $data["rh"]                          = $medical_file->getRH();
            $data["weight"]                      = $medical_file->getWeight();
            $data["height"]                      = $medical_file->getHeight();
            $data["physicalActivityRestriction"] = $medical_file->getPhysicalActivityRestriction();
            $data["vacineTetanus"]               = $medical_file->getVacineTetanus();
            $data["vacineMMR"]                   = $medical_file->getVacineMMR();
            $data["vacineTetanus"]               = $medical_file->getVacineTetanus();
            $data["vacineHepatitis"]             = $medical_file->getVacineHepatitis();
            $data["vacineYellowFever"]           = $medical_file->getVacineYellowFever();
            $data["antecedents"]                 = $medical_file->getInfectoContagiousAntecedents();
            $data["regularUseMedicine"]          = $medical_file->getRegularUseMedicine();
            $data["medicineRestrictions"]        = $medical_file->getMedicineRestrictions();
            $data["allergies"]                   = $medical_file->getAllergies();
            $data["analgesicAntipyretic"]        = $medical_file->getAnalgesicAntipyretic();
            $doctorId                            = $medical_file->getDoctorId();
            $doctor                              = $this->person_model->getPersonById($doctorId);
            $data["doctorName"]                  = $doctor->getFullName();
            $data["doctorEmail"]                 = $doctor->getEmail();
            $tels                                = $this->telephone_model->getTelephonesByPersonId($doctorId);
            $data["specialCareMedical"]          = $medical_file->getSpecialCareMedical();
            $data["psychMedication"]             = $medical_file->getPsychMedication();
            if (isset($tels[0])) {
                $data["doctorPhone1"] = $tels[0];
            } else {
                $data["doctorPhone1"] = "";
            }

            if (isset($tels[1])) {
                $data["doctorPhone2"] = $tels[1];
            } else {
                $data["doctorPhone2"] = "";
            }

            $type         = 'simples';
            $data['type'] = $type;

            $this->loadView('summercamps/editMedicalFileFormStaff', $data);
        } else {
            $this->loadView('summercamps/medicalFileStaff', $data);
        }
    }

    public function uploadDocument()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $summerCampId          = $this->input->get('camp_id', true);
        $data["camp_id"]       = $summerCampId;
        $colonistId            = $this->input->get('colonist_id', true);
        $data["colonist_id"]   = $colonistId;
        $data["document_type"] = $this->input->get('document_type', true);

        $status         = $this->summercamp_model->getColonistStatus($colonistId, $summerCampId);
        $data['status'] = $status;

        $camper     = $this->summercamp_model->getSummerCampSubscription($data["colonist_id"], $data["camp_id"]);
        $validation = $this->validation_model->getColonistValidationInfoObject($data["colonist_id"], $data["camp_id"]);
        if ($camper->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN || ($camper->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS && $validation && !$validation->verifyDocument($data["document_type"]))) {
            $data["editable"] = true;
            if ($validation && !$validation->verifyDocument($data["document_type"])) {
                $data["extra"] = $validation->getDocumentData($data["document_type"]);
            }

        } else {
            $data["editable"] = true;
        }

        $data["document_name"] = false;
        if ($data["document_type"] == DOCUMENT_MEDICAL_FILE) {
            $data["document_name"] = "Ficha médica";
        } else if ($data["document_type"] == DOCUMENT_IDENTIFICATION_DOCUMENT) {
            $data["document_name"] = "Documento de identificação";
        } else if ($data["document_type"] == DOCUMENT_GENERAL_RULES) {
            $data["document_name"] = "Normas gerais";
        } else if ($data["document_type"] == DOCUMENT_PHOTO_3X4) {
            $data["document_name"] = "Foto 3x4";
        } else if ($data["document_type"] == DOCUMENT_TRIP_AUTHORIZATION) {
            $data["document_name"] = "Autorização de viagem";
        } else if ($data["document_type"] == DOCUMENT_TRIP_AUTHORIZATION_SIGNED) {
            $data["document_name"] = "Autorização de viagem assinada";
        } else if ($data["document_type"] == DOCUMENT_MEDICAL_CARD) {
            $data["document_name"] = "Carteira do Plano de Saude";
        }

        $data["hasDocument"] = "";
        if (!$this->summercamp_model->hasDocument($data["camp_id"], $data["colonist_id"], $data["document_type"])) {
            $data["hasDocument"] = "disabled";
        }

        if ($data["document_type"] == DOCUMENT_MEDICAL_FILE) {
            $this->medicalFile($data);
        } else if ($data["document_type"] == DOCUMENT_GENERAL_RULES) {
            $data["summercamp"]      = $this->summercamp_model->getSummerCampById($data["camp_id"]);
            $data["colonist_status"] = $camper->getSituationId();
            $this->loadView('summercamps/generalRules', $data);
        } else if ($data["document_type"] == DOCUMENT_TRIP_AUTHORIZATION) {
            $data["day"]             = date('d');
            $data["month"]           = date('m');
            $data["year"]            = date('Y');
            $data["colonist_status"] = $camper->getSituationId();
            $this->loadView('summercamps/tripAuthorization', $data);
        } else {
            $this->loadView('summercamps/uploadDocument', $data);
        }

    }

    public function verifyDocument()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $camp_id       = $this->input->get('camp_id', true);
        $colonist_id   = $this->input->get('colonist_id', true);
        $document_type = $this->input->get('document_type', true);
        $document      = $this->summercamp_model->getNewestDocument($camp_id, $colonist_id, $document_type);
        $this->load->helper('download');
        if ($document) {
            force_download($document["name"], pg_unescape_bytea($document["data"]));
        } else {
            echo "<script>alert('Erro ao tentar fazer download do arquivo, verifique se o arquivo ja foi enviado e tente novamente mais tarde');
            window.location.replace('" . $this->config->item('url_link') . "summercamps/uploadDocument?camp_id=$camp_id&colonist_id=$colonist_id&document_type=$document_type');</script>";
        }
    }

    public function saveDocument()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $camp_id       = $this->input->post('camp_id', true);
        $colonist_id   = $this->input->post('colonist_id', true);
        $document_type = $this->input->post('document_type', true);
        $fileName      = $_FILES['uploadedfile']['name'];
        if (isset($_FILES['uploadedfile']['tmp_name']) && !empty($_FILES['uploadedfile']['tmp_name'])) {
            $file = file_get_contents($_FILES['uploadedfile']['tmp_name']);
        }

        $userId = $this->session->userdata("user_id");
        if ($_FILES['uploadedfile']['error'] > 0 || !$this->summercamp_model->uploadDocument($camp_id, $colonist_id, $userId, $fileName, $file, $document_type)) {
            echo "<script>alert('Erro ao enviar documento, verifique se ele se adequa as regras de envio e tente novamente. Lembramos que somente aceitamos arquivos até 2MB.');
            window.location.replace('" . $this->config->item('url_link') . "summercamps/uploadDocument?camp_id=$camp_id&colonist_id=$colonist_id&document_type=$document_type');</script>";
        } else {
            $this->validation_model->sentNewDocument($colonist_id, $camp_id, $document_type);

            if ($document_type != 6) {
                $oldSubscriptionRestored = $this->summercamp_model->isOldSubscriptionRestored($camp_id, $colonist_id);

                if ($oldSubscriptionRestored) {
                    if ($document_type == 3) {
                        $status = 'identification_document';
                    } else if ($document_type == 5) {
                        $status = 'photo';
                    }

                    $this->summercamp_model->turnOnSummerCampOldSubscriptionStatus($camp_id, $colonist_id, $status);
                }
            }

            echo "<script>alert('Documento enviado com sucesso.'); window.location.replace('" . $this->config->item('url_link') . "summercamps/index');</script>";
        }
    }

    public function donateMultipleColonists()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $campId        = $this->input->post('camp_id', true);
        $colonistId    = $this->input->post('colonist_id', true);
        $userId        = $this->session->userdata("user_id");
        $price         = $this->input->post('price', true);
        $donationValue = 0;
        try {
            if (count($campId) == count($colonistId)) {
                for ($i = 0; $i < count($campId); $i++) {
                    $summerCampPayment = $this->summercamp_model->getSummerCampPaymentPeriod($campId[$i]);
                    if ($summerCampPayment) {
                        $summerCampSubscription = $this->summercamp_model->getSummerCampSubscription($colonistId[$i], $campId[$i]);
                        if ($summerCampSubscription && $summerCampSubscription->duringPaymentLimit()) {
                            $discount = 1 - ($summerCampSubscription->getDiscount() / 100);
                            $donationValue += floor($summerCampPayment->getPrice() * $discount);
                        } else {
                            $this->Logger->error("Trying 1 donation for multiple colonists: Colonist with id and campId" . $colonistId[$i] . " " . $campId[$i] . " does not exist or is not during its payment limit");
                            redirect("summercamps/index");
                        }
                    } else {
                        $this->Logger->error("Trying 1 donation for multiple colonists: Did not find payment period for colonist with id and campId" . $colonistId[$i] . " " . $campId[$i]);
                        redirect("summercamps/index");
                    }
                }
                $this->generic_model->startTransaction();
                $donationId = $this->donation_model->createDonation($userId, $donationValue, DONATION_TYPE_SUMMERCAMP_SUBSCRIPTION);
                $this->Logger->info("Created donation with id: " . $donationId);
                for ($i = 0; $i < count($campId); $i++) {
                    $this->summercamp_model->associateDonation($campId[$i], $colonistId[$i], $donationId, $price[$i]);
                    $this->Logger->info("Associated donation with id: " . $donationId . " to colonist with id/campId " . $colonistId[$i] . "/" . $campId[$i]);
                }
                $this->generic_model->commitTransaction();
                redirect("payments/checkout/" . $donationId);
            } else {
                redirect("summercamps/index");
            }
        } catch (Exception $ex) {
            $this->generic_model->rollbackTransaction();
            $this->Logger->error("Failed to create donation for multiple colonists");
            redirect("summercamps/index");
        }
    }

    public function paySummerCampSubscription()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $campId     = $this->input->get('camp_id', true);
        $colonistId = $this->input->get('colonist_id', true);
        if (!$this->checkSession()) {
            redirect("login/index");
        }

        $userId = $this->session->userdata("user_id");
        try {
            $summerCampPayment      = $this->summercamp_model->getSummerCampPaymentPeriod($campId);
            $summerCampSubscription = $this->summercamp_model->getSummerCampSubscription($colonistId, $campId);
            $discount               = 1 - ($summerCampSubscription->getDiscount() / 100);
            if ($summerCampPayment && $summerCampSubscription->duringPaymentLimit()) {
                if ($discount == 0) {
                    $this->generic_model->startTransaction();
                    $this->Logger->info("Discount is 100%, subscribing colonist with id and campId" . $colonistId . " " . $campId);
                    $this->summercamp_model->updateColonistStatus($colonistId, $campId, SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED);
                    $this->generic_model->commitTransaction();
                    $this->sendSubscriptionFinalMail($userId, $summerCampSubscription);
                    redirect("summercamps/index");
                    return;
                } else {
                    $donationId = $this->donation_model->createDonation($userId, floor($summerCampPayment->getPrice() * $discount), DONATION_TYPE_SUMMERCAMP_SUBSCRIPTION);
                    $this->Logger->info("Created donation with id: " . $donationId);
                    $this->summercamp_model->associateDonation($campId, $colonistId, $donationId, floor($summerCampPayment->getPrice() * $discount));
                    $this->Logger->info("Associated donation with id: " . $donationId . " to colonist with id/campId" . $colonistId . "/" . $campId);
                    $this->generic_model->commitTransaction();
                    redirect("payments/checkout/" . $donationId);
                }
            } else {
                redirect("summercamps/index");
            }
        } catch (Exception $ex) {
            $this->generic_model->rollbackTransaction();
            $this->Logger->error("Failed to create payment");
            redirect("summercamps/index");
        }
    }

    public function invalidateSubscription()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $camp_id                = $this->input->get('camp_id', true);
        $colonist_id            = $this->input->get('colonist_id', true);
        $summerCampSubscription = $this->summercamp_model->getSummerCampSubscription($colonist_id, $camp_id);
        if ($summerCampSubscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) {
            $this->summercamp_model->updateColonistStatus($colonist_id, $camp_id, SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN);
            $this->validation_model->deleteValidation($colonist_id, $camp_id);
            echo "<script>alert('Retorno realizado com sucesso'); window.location.replace('" . $this->config->item('url_link') . "summercamps/index');</script>";
        } else {
            echo "<script>alert('O status " . utf8_decode($summerCampSubscription->getSituation()) . utf8_decode(" não") . " permite retorno.'); window.location.replace('" . $this->config->item('url_link') . "summercamps/index');</script>";
        }
    }

    public function sendPreSubscription()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $camp_id                = $this->input->get('camp_id', true);
        $colonist_id            = $this->input->get('colonist_id', true);
        $documents              = $this->input->get('documents', true);
        $summerCampSubscription = $this->summercamp_model->getSummerCampSubscription($colonist_id, $camp_id);
        if ($summerCampSubscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS || $summerCampSubscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN) {
            if ($documents == 7) {
                $this->summercamp_model->updateColonistStatus($colonist_id, $camp_id, SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION);
                $this->sendPreSubscriptionEmail($colonist_id, $camp_id);
                echo "<script>alert('Envio realizado com sucesso'); window.location.replace('" . $this->config->item('url_link') . "summercamps/index');</script>";
            } else {
                echo "<script>alert('O cadastro e os anexos devem estar indicados com o simbolo em verde para poder enviar.'); window.location.replace('" . $this->config->item('url_link') . "summercamps/index');</script>";
            }

        } else {
            echo "<script>alert('O status " . utf8_decode($summerCampSubscription->getSituation()) . utf8_decode(" não") . " permite envio'); window.location.replace('" . $this->config->item('url_link') . "summercamps/index');</script>";
        }
    }

    public function sendPreSubscriptionEmail($colonistId, $summerCampId)
    {
        $this->Logger->info("Running: " . __METHOD__);

        $summercamp = $this->summercamp_model->getSummerCampById($summerCampId);
        if (!$summercamp) {
            $this->Logger->error("Camp not found, cannot send an email");
            return;
        }

        $colonist = $this->colonist_model->getColonist($colonistId);
        if (!$colonist) {
            $this->Logger->error("Colonist not found");
            return;
        }

        $personuser = $this->colonist_model->getColonistPersonUser($colonistId, $summerCampId);
        if (!$personuser) {
            $this->Logger->error("PersonUser related to colonist not found");
            return;
        }

        $this->Logger->info("Sending email");

        $responsableId = $personuser->getPersonId();

        $father = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
        $mother = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");

        $emailArray = array();
        if ($father && $responsableId != $father) {
            $father       = $this->person_model->getPersonFullById($father);
            $emailArray[] = $father->email;
        }
        if ($mother && $mother != $responsableId) {
            $mother       = $this->person_model->getPersonFullById($mother);
            $emailArray[] = $mother->email;
        }

        $this->sendEmailSubmittedPreSubscription($personuser, $colonist, $summercamp->getCampName(), $emailArray);
    }

    public function sendExclusionEmail($colonistId, $summerCampId)
    {
        $this->Logger->info("Running: " . __METHOD__);

        $summercamp = $this->summercamp_model->getSummerCampById($summerCampId);
        if (!$summercamp) {
            $this->Logger->error("Camp not found, cannot send an email");
            return;
        }

        $colonist = $this->colonist_model->getColonist($colonistId);
        if (!$colonist) {
            $this->Logger->error("Colonist not found");
            return;
        }

        $personuser = $this->colonist_model->getColonistPersonUser($colonistId, $summerCampId);
        if (!$personuser) {
            $this->Logger->error("PersonUser related to colonist not found");
            return;
        }

        $this->Logger->info("Sending email");

        $responsableId = $personuser->getPersonId();

        $father = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
        $mother = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");

        $emailArray = array();
        if ($father && $responsableId != $father) {
            $father       = $this->person_model->getPersonFullById($father);
            $emailArray[] = $father->email;
        }
        if ($mother && $mother != $responsableId) {
            $mother       = $this->person_model->getPersonFullById($mother);
            $emailArray[] = $mother->email;
        }

        $this->sendEmailExcluded($personuser, $colonist, $summercamp->getCampName(), $emailArray);
    }

    public function acceptGeneralRules()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $camp_id     = $this->input->post('camp_id', true);
        $colonist_id = $this->input->post('colonist_id', true);
        $this->summercamp_model->updateGeneralRules($camp_id, $colonist_id, 't');
        //$this->index();
        redirect("summercamps/index");
    }

    public function rejectGeneralRules()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $camp_id     = $this->input->post('camp_id', true);
        $colonist_id = $this->input->post('colonist_id', true);
        $this->summercamp_model->updateGeneralRules($camp_id, $colonist_id, 'f');
        //$this->index();
        redirect("summercamps/index");
    }

    public function acceptTripAuthorization()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $camp_id     = $this->input->post('camp_id', true);
        $colonist_id = $this->input->post('colonist_id', true);
        $this->summercamp_model->updateTripAuthorization($camp_id, $colonist_id, 't');
        //$this->index();
        redirect("summercamps/index");
    }

    public function rejectTripAuthorization()
    {
        $camp_id     = $this->input->post('camp_id', true);
        $colonist_id = $this->input->post('colonist_id', true);
        $this->summercamp_model->updateTripAuthorization($camp_id, $colonist_id, 'f');
        //this->index();
        redirect("summercamps/index");
    }

    public function viewColonistInfo()
    {
        $this->Logger->info("Starting " . __METHOD__);
        $colonistId                     = $this->input->get('colonistId', true);
        $summerCampId                   = $this->input->get('summerCampId', true);
        $camper                         = $this->summercamp_model->getSummerCampSubscription($colonistId, $summerCampId);
        $address                        = $this->address_model->getAddressByPersonId($camper->getPersonId());
        $responsableId                  = $camper->getPersonUserId();
        $responsableAddress             = $this->address_model->getAddressByPersonId($responsableId);
        $data["colonistId"]             = $colonistId;
        $data["sameAddressResponsable"] = "n";
        if ($responsableAddress) {
            if ($address->getAddressId() == $responsableAddress->getAddressId()) {
                $data["sameAddressResponsable"] = "s";
            }
        }

        $data["summerCamp"]     = $this->summercamp_model->getSummerCampById($summerCampId);
        $data["id"]             = $summerCampId;
        $data["fullName"]       = $camper->getFullName();
        $data["Gender"]         = $camper->getGender();
        $data["birthdate"]      = date("d-m-Y", strtotime($camper->getBirthDate()));
        $data["school"]         = $camper->getSchool();
        $data["schoolYear"]     = $camper->getSchoolYear();
        $data["documentNumber"] = $camper->getDocumentNumber();
        $data["documentType"]   = $camper->getDocumentType();
        $data["phone1"]         = $camper->getDocumentType();
        $data["phone2"]         = $camper->getDocumentType();
        $data["street"]         = $address->getStreet();
        $data["number"]         = $address->getPlaceNumber();
        $data["city"]           = $address->getCity();
        $data["cep"]            = $address->getCEP();
        $data["complement"]     = $address->getComplement();
        $data["neighborhood"]   = $address->getNeighborhood();
        $data["uf"]             = $address->getUf();
        $telephones             = $this->telephone_model->getTelephonesByPersonId($camper->getPersonId());
        $data["phone1"]         = isset($telephones[0]) ? $telephones[0] : false;
        $data["phone2"]         = isset($telephones[1]) ? $telephones[1] : false;
        $father                 = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
        $mother                 = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");
        if ($father) {
            if ($father == $responsableId) {
                $data["responsableDadMother"] = "dad";
            }

            $father              = $this->person_model->getPersonFullById($father);
            $data["dadFullName"] = $father->fullname;
            $data["dadEmail"]    = $father->email;
            $data["dadPhone"]    = $father->phone1;
        } else {
            $data["noFather"] = true;
        }
        if ($mother) {
            if ($mother == $responsableId) {
                $data["responsableDadMother"] = "mother";
            }

            $mother                 = $this->person_model->getPersonFullById($mother);
            $data["motherFullName"] = $mother->fullname;
            $data["motherEmail"]    = $mother->email;
            $data["motherPhone"]    = $mother->phone1;
        } else {
            $data["noMother"] = true;
        }

        if ($camper->getRoommate1()) {
            $data['roommate1'] = $camper->getRoommate1();
        }

        if ($camper->getRoommate2()) {
            $data['roommate2'] = $camper->getRoommate2();
        }

        if ($camper->getRoommate3()) {
            $data['roommate3'] = $camper->getRoommate3();
        }

        
            $data['specialCare'] = $camper->getSpecialCare();
        

        if ($camper->getSpecialCareObs()) {
            $data['specialCareObs'] = $camper->getSpecialCareObs();
        }

        if ($data["summerCamp"]->isMiniCamp()) {
            $miniCamp         = $this->summercamp_model->getMiniCampObs($summerCampId, $colonistId);
            $data['miniCamp'] = $miniCamp;
        }

        $this->loadView('summercamps/viewColonistInfo', $data);
    }

    public function submitMedicalFile()
    {
        $responsability = $this->input->post('responsability', true);
        if (!$responsability) {
            echo "<script>alert('Por favor valide a veracidade dos dados.');history.go(-1);</script>";

            return;
        }
        $campId     = $this->input->post('camp_id', true);
        $colonistId = $this->input->post('colonist_id', true);
        $bloodType  = $this->input->post('bloodType', true);
        $rh         = $this->input->post('rh', true);
        $weight     = $this->input->post('weight', true);
        $height     = $this->input->post('height', true);

        if ($this->input->post('physicalrestrictions_radio', true)) {
            $physicalActivityRestriction = $this->input->post('physicalrestrictions_text', true);
        } else {
            $physicalActivityRestriction = null;
        }

        if ($this->input->post('antecedents_radio', true)) {
            $infectoContagiousAntecedents = $this->input->post('antecedents_text', true);
        } else {
            $infectoContagiousAntecedents = null;
        }

        if ($this->input->post('habitualmedicine_radio', true)) {
            $regularUseMedicine = $this->input->post('habitualmedicine_text', true);
        } else {
            $regularUseMedicine = null;
        }

        if ($this->input->post('medicinerestrictions_radio', true)) {
            $medicineRestrictions = $this->input->post('medicinerestrictions_text', true);
        } else {
            $medicineRestrictions = null;
        }

        if ($this->input->post('allergies_radio', true)) {
            $allergies = $this->input->post('allergies_text', true);
        } else {
            $allergies = null;
        }

        if ($this->input->post('analgesicantipyretic_radio', true)) {
            $analgesicAntipyretic = $this->input->post('analgesicantipyretic_text', true);
        } else {
            $analgesicAntipyretic = null;
        }

        if ($this->input->post('specialcare_radio', true)) {
            $specialCareMedical = $this->input->post('specialcare_text', true);
        } else {
            $specialCareMedical = null;
        }

        if ($this->input->post('psych_radio', true)) {
            $psychMedication = $this->input->post('psych_text', true);
        } else {
            $psychMedication = null;
        }

        $doctorName   = $this->input->post('doctor_name', true);
        $doctorMail   = $this->input->post('doctor_email', true);
        $doctorPhone1 = $this->input->post('doctor_phone1', true);
        $doctorPhone2 = $this->input->post('doctor_phone2', true);
        if ($doctorMail && $doctorMail === "") {
            $doctorMail = null;
        }

        $doctorId = $this->person_model->insertPersonWithoutAddress($doctorName, null, $doctorMail);
        $this->telephone_model->insertNewTelephone($doctorPhone1, $doctorId);

        if ($doctorPhone2 && $doctorPhone2 !== "") {
            $this->telephone_model->insertNewTelephone($doctorPhone2, $doctorId);
        }

        $vacineTetanus   = $this->input->post('antiTetanus', true);
        $vacineMMR       = $this->input->post('MMR', true);
        $vacineHepatitis = $this->input->post('vacineHepatitis', true);
        $vacineYellowFever = $this->input->post('vacineYellowFever', true);

        if ($this->medical_file_model->insertNewMedicalFile($campId, $colonistId, $bloodType, $rh, $weight, $height, $physicalActivityRestriction, $vacineTetanus, $vacineMMR, $vacineHepatitis, $vacineYellowFever, $infectoContagiousAntecedents, $regularUseMedicine, $medicineRestrictions, $allergies, $analgesicAntipyretic, $doctorId, $specialCareMedical, $psychMedication)) {
            echo "<script>alert('Ficha medica salva com sucesso.'); window.location.replace('" . $this->config->item('url_link') . "summercamps/index');</script>";
        }

    }

    public function submitMedicalFileStaff()
    {
        $responsability = $this->input->post('responsability', true);
        if (!$responsability) {
            echo "<script>alert('Por favor valide a veracidade dos dados.');history.go(-1);</script>";

            return;
        }
        $personId  = $this->input->post('person_id', true);
        $bloodType = $this->input->post('bloodType', true);
        $rh        = $this->input->post('rh', true);
        $weight    = $this->input->post('weight', true);
        $height    = $this->input->post('height', true);

        if ($this->input->post('physicalrestrictions_radio', true)) {
            $physicalActivityRestriction = $this->input->post('physicalrestrictions_text', true);
        } else {
            $physicalActivityRestriction = null;
        }

        if ($this->input->post('antecedents_radio', true)) {
            $infectoContagiousAntecedents = $this->input->post('antecedents_text', true);
        } else {
            $infectoContagiousAntecedents = null;
        }

        if ($this->input->post('habitualmedicine_radio', true)) {
            $regularUseMedicine = $this->input->post('habitualmedicine_text', true);
        } else {
            $regularUseMedicine = null;
        }

        if ($this->input->post('medicinerestrictions_radio', true)) {
            $medicineRestrictions = $this->input->post('medicinerestrictions_text', true);
        } else {
            $medicineRestrictions = null;
        }

        if ($this->input->post('allergies_radio', true)) {
            $allergies = $this->input->post('allergies_text', true);
        } else {
            $allergies = null;
        }

        if ($this->input->post('analgesicantipyretic_radio', true)) {
            $analgesicAntipyretic = $this->input->post('analgesicantipyretic_text', true);
        } else {
            $analgesicAntipyretic = null;
        }

        if ($this->input->post('specialcare_radio', true)) {
            $specialCareMedical = $this->input->post('specialcare_text', true);
        } else {
            $specialCareMedical = null;
        }

        if ($this->input->post('psych_radio', true)) {
            $psychMedication = $this->input->post('psych_text', true);
        } else {
            $psychMedication = null;
        }



        $doctorName   = $this->input->post('doctor_name', true);
        $doctorMail   = $this->input->post('doctor_email', true);
        $doctorPhone1 = $this->input->post('doctor_phone1', true);
        $doctorPhone2 = $this->input->post('doctor_phone2', true);
        if ($doctorMail && $doctorMail === "") {
            $doctorMail = null;
        }

        $doctorId = $this->person_model->insertPersonWithoutAddress($doctorName, null, $doctorMail);
        $this->telephone_model->insertNewTelephone($doctorPhone1, $doctorId);

        if ($doctorPhone2 && $doctorPhone2 !== "") {
            $this->telephone_model->insertNewTelephone($doctorPhone2, $doctorId);
        }

        $vacineTetanus   = $this->input->post('antiTetanus', true);
        $vacineMMR       = $this->input->post('MMR', true);
        $vacineHepatitis = $this->input->post('vacineHepatitis', true);
        $vacineYellowFever = $this->input->post('vacineYellowFever', true);

        if ($this->medical_file_model->insertNewStaffMedicalFile($personId, $bloodType, $rh, $weight, $height, $physicalActivityRestriction, $vacineTetanus, $vacineMMR, $vacineHepatitis, $vacineYellowFever, $infectoContagiousAntecedents, $regularUseMedicine, $medicineRestrictions, $allergies, $analgesicAntipyretic, $doctorId, $specialCareMedical, $psychMedication)) {
            echo "<script>alert('Ficha medica salva com sucesso.'); window.close();</script>";
        }

    }

    public function editMedicalFile()
    {
        $responsability = $this->input->post('responsability', true);
        if (!$responsability) {
            echo "<script>alert('Por favor valide a veracidade dos dados.');history.go(-1);</script>";

            return;
        }
        $campId     = $this->input->post('camp_id', true);
        $colonistId = $this->input->post('colonist_id', true);
        $bloodType  = $this->input->post('bloodType', true);
        $rh         = $this->input->post('rh', true);
        $weight     = $this->input->post('weight', true);
        $height     = $this->input->post('height', true);

        if ($this->input->post('physicalrestrictions_radio', true)) {
            $physicalActivityRestriction = $this->input->post('physicalrestrictions_text', true);
        } else {
            $physicalActivityRestriction = null;
        }

        if ($this->input->post('antecedents_radio', true)) {
            $infectoContagiousAntecedents = $this->input->post('antecedents_text', true);
        } else {
            $infectoContagiousAntecedents = null;
        }

        if ($this->input->post('habitualmedicine_radio', true)) {
            $regularUseMedicine = $this->input->post('habitualmedicine_text', true);
        } else {
            $regularUseMedicine = null;
        }

        if ($this->input->post('medicinerestrictions_radio', true)) {
            $medicineRestrictions = $this->input->post('medicinerestrictions_text', true);
        } else {
            $medicineRestrictions = null;
        }

        if ($this->input->post('allergies_radio', true)) {
            $allergies = $this->input->post('allergies_text', true);
        } else {
            $allergies = null;
        }

        if ($this->input->post('analgesicantipyretic_radio', true)) {
            $analgesicAntipyretic = $this->input->post('analgesicantipyretic_text', true);
        } else {
            $analgesicAntipyretic = null;
        }

        if ($this->input->post('specialcare_radio', true)) {
            $specialCareMedical = $this->input->post('specialcare_text', true);
        } else {
            $specialCareMedical = null;
        }

        if ($this->input->post('psych_radio', true)) {
            $psychMedication = $this->input->post('psych_text', true);
        } else {
            $psychMedication = null;
        }



        $doctorName   = $this->input->post('doctor_name', true);
        $doctorMail   = $this->input->post('doctor_email', true);
        $doctorPhone1 = $this->input->post('doctor_phone1', true);
        $doctorPhone2 = $this->input->post('doctor_phone2', true);
        if ($doctorMail && $doctorMail === "") {
            $doctorMail = null;
        }

        $doctorId = $this->person_model->insertPersonWithoutAddress($doctorName, null, $doctorMail);
        $this->telephone_model->insertNewTelephone($doctorPhone1, $doctorId);

        if ($doctorPhone2 && $doctorPhone2 !== "") {
            $this->telephone_model->insertNewTelephone($doctorPhone2, $doctorId);
        }

        $vacineTetanus   = $this->input->post('antiTetanus', true);
        $vacineMMR       = $this->input->post('MMR', true);
        $vacineHepatitis = $this->input->post('vacineHepatitis', true);
        $vacineYellowFever = $this->input->post('vacineYellowFever', true);

        if ($this->medical_file_model->updateMedicalFile($campId, $colonistId, $bloodType, $rh, $weight, $height, $physicalActivityRestriction, $vacineTetanus, $vacineMMR, $vacineHepatitis, $vacineYellowFever, $infectoContagiousAntecedents, $regularUseMedicine, $medicineRestrictions, $allergies, $analgesicAntipyretic, $doctorId, $specialCareMedical, $psychMedication)) {
            $oldSubscriptionRestored = $this->summercamp_model->isOldSubscriptionRestored($campId, $colonistId);

            if ($oldSubscriptionRestored) {
                $this->summercamp_model->turnOnSummerCampOldSubscriptionStatus($campId, $colonistId, 'medical_file');
            }

            echo "<script>alert('Ficha medica atualizada com sucesso.'); window.location.replace('" . $this->config->item('url_link') . "summercamps/index');</script>";
        }
    }

    public function editMedicalFileStaff()
    {
        $responsability = $this->input->post('responsability', true);
        if (!$responsability) {
            echo "<script>alert('Por favor valide a veracidade dos dados.');history.go(-1);</script>";

            return;
        }
        $personId  = $this->input->post('person_id', true);
        $bloodType = $this->input->post('bloodType', true);
        $rh        = $this->input->post('rh', true);
        $weight    = $this->input->post('weight', true);
        $height    = $this->input->post('height', true);

        if ($this->input->post('physicalrestrictions_radio', true)) {
            $physicalActivityRestriction = $this->input->post('physicalrestrictions_text', true);
        } else {
            $physicalActivityRestriction = null;
        }

        if ($this->input->post('antecedents_radio', true)) {
            $infectoContagiousAntecedents = $this->input->post('antecedents_text', true);
        } else {
            $infectoContagiousAntecedents = null;
        }

        if ($this->input->post('habitualmedicine_radio', true)) {
            $regularUseMedicine = $this->input->post('habitualmedicine_text', true);
        } else {
            $regularUseMedicine = null;
        }

        if ($this->input->post('medicinerestrictions_radio', true)) {
            $medicineRestrictions = $this->input->post('medicinerestrictions_text', true);
        } else {
            $medicineRestrictions = null;
        }

        if ($this->input->post('allergies_radio', true)) {
            $allergies = $this->input->post('allergies_text', true);
        } else {
            $allergies = null;
        }

        if ($this->input->post('analgesicantipyretic_radio', true)) {
            $analgesicAntipyretic = $this->input->post('analgesicantipyretic_text', true);
        } else {
            $analgesicAntipyretic = null;
        }

        if ($this->input->post('specialcare_radio', true)) {
            $specialCareMedical = $this->input->post('specialcare_text', true);
        } else {
            $specialCareMedical = null;
        }

        if ($this->input->post('psych_radio', true)) {
            $psychMedication§ = $this->input->post('psych_text', true);
        } else {
            $psychMedication = null;
        }

        $doctorName   = $this->input->post('doctor_name', true);
        $doctorMail   = $this->input->post('doctor_email', true);
        $doctorPhone1 = $this->input->post('doctor_phone1', true);
        $doctorPhone2 = $this->input->post('doctor_phone2', true);
        if ($doctorMail && $doctorMail === "") {
            $doctorMail = null;
        }

        $doctorId = $this->person_model->insertPersonWithoutAddress($doctorName, null, $doctorMail);
        $this->telephone_model->insertNewTelephone($doctorPhone1, $doctorId);

        if ($doctorPhone2 && $doctorPhone2 !== "") {
            $this->telephone_model->insertNewTelephone($doctorPhone2, $doctorId);
        }

        $vacineTetanus   = $this->input->post('antiTetanus', true);
        $vacineMMR       = $this->input->post('MMR', true);
        $vacineHepatitis = $this->input->post('vacineHepatitis', true);
        $vacineYellowFever = $this->input->post('vacineYellowFever', true);

        if ($this->medical_file_model->updateStaffMedicalFile($personId, $bloodType, $rh, $weight, $height, $physicalActivityRestriction, $vacineTetanus, $vacineMMR, $vacineHepatitis, $vacineYellowFever, $infectoContagiousAntecedents, $regularUseMedicine, $medicineRestrictions, $allergies, $analgesicAntipyretic, $doctorId, $specialCareMedical, $psychMedication)) {
            echo "<script>alert('Ficha medica atualizada com sucesso.'); window.close();</script>";
        }

    }

    public function updateInfoPostSubscription()
    {

        $colonistId   = $_POST["colonist_id"];
        $summerCampId = $_POST["summer_camp_id"];
        $roommate1    = $_POST["roommate1"];
        $roommate2    = $_POST["roommate2"];
        $roommate3    = $_POST["roommate3"];

        $phone1 = $_POST["phone1"];
        $phone2 = $_POST["phone2"];

        $camper = $this->summercamp_model->getSummerCampSubscription($colonistId, $summerCampId);

        $this->telephone_model->updatePhone($camper->getPersonId(), $phone1, $phone2);

        $result = $this->summercamp_model->updateRoomates($colonistId, $summerCampId, $roommate1, $roommate2, $roommate3);

        if ($result) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function roomDisposal()
    {
        $data = array();

        $years       = array();
        $start       = 2015;
        $date        = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end         = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        while ($start <= $end) {
            $years[] = $start;
            $start++;
        }
        $year = null;

        if (isset($_GET['ano_f'])) {
            $year = $_GET['ano_f'];
        } else {
            $year = date('Y');
        }

        $data['ano_escolhido'] = $year;
        $data['years']         = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps    = array();
        $start    = $campsQtd;
        $end      = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f'])) {
            $campChosen = $_GET['colonia_f'];
        }

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen) {
                $campChosenId = $camp->getCampId();
            }

        }

        $data['summer_camp_id']    = $campChosenId;
        $data['colonia_escolhida'] = $campChosen;
        $data['camps']             = $camps;

        if ($campChosenId != null && isset($_GET['quarto']) && isset($_GET["pavilhao"])) {

            $pavilhao = $_GET['pavilhao'];
            $quarto   = $_GET['quarto'];

            $data["quarto"]   = $quarto;
            $data["pavilhao"] = $pavilhao;
            $num_quartos      = $this->summercamp_model->getRoomQuantityForSummerCamp($campChosenId, $pavilhao);
            $colonists        = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year, SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED, $campChosenId, $pavilhao);

            $colonistsSelected = $this->filterColonists($colonists, $quarto, $pavilhao);
            foreach ($colonistsSelected as $colonist) {
                $colonist->friend_roommates = $this->countFriendRoommates($colonists, $colonist, $pavilhao);
            }

            $roomOccupation = array_fill(0, $num_quartos + 1, 0);
            for ($i = 0; $i < count($roomOccupation); $i++) {
                $roomColonists      = $this->filterColonists($colonists, $i, $pavilhao);
                $roomOccupation[$i] = count($roomColonists);
            }

            $data["num_quartos"]     = $num_quartos;
            $data["room_occupation"] = $roomOccupation;
            $data["colonists"]       = $colonistsSelected;
        }

        $this->loadView('summercamps/roomDisposal', $data);
    }

    private function createNamePattern($name)
    {
        if ($name == null || $name == '') {
            return null;
        }

        $nameExploded = explode(" ", trim($name));
        $namePattern  = null;
        if (is_array($nameExploded)) {
            $namePattern = "/^";
            $namePattern .= strtolower(substr(trim($nameExploded[0]), 0, 3)) . "[\w'éáóíúêôçâôãõàñ ]*";
            if (count($nameExploded) - 1 > 0) {
                $namePattern .= " " . strtolower(substr(trim($nameExploded[count($nameExploded) - 1]), 0, 3)) . "[\w'éáóíúêôçâôãõàñ ]*";
            }

            $namePattern .= "$/";
        }

        return $namePattern;
    }

    private function countFriendRoommates($colonists, $colonist, $gender)
    {
        $unwanted_array = array('Á'=>'A', 'À'=>'A', 'Ã'=>'A','Â'=>'A','É'=>'E', 'È'=>'E','Ê'=>'E','Í'=>'I','Ó'=>'O', 'Õ'=>'O','Ô'=>'O','Ú'=>'U', 'á'=>'a', 'à'=>'a', 'ã'=>'a','â'=>'a','é'=>'e', 'è'=>'e','ê'=>'e','í'=>'i','ó'=>'o', 'õ'=>'o','ô'=>'o','ú'=>'u', 'Ç'=>'c', 'ç'=>'c');

        $roommate1Pattern = $this->createNamePattern(trim(strtolower($colonist->roommate1)));
        $roommate1Pattern = strtr($roommate1Pattern, $unwanted_array);
        $roommate2Pattern = $this->createNamePattern(trim(strtolower($colonist->roommate2)));
        $roommate2Pattern = strtr($roommate2Pattern, $unwanted_array);
        $roommate3Pattern = $this->createNamePattern(trim(strtolower($colonist->roommate3)));
        $roommate3Pattern = strtr($roommate3Pattern, $unwanted_array);

        $colonist->roommate1_status = "F";
        $colonist->roommate2_status = "F";
        $colonist->roommate3_status = "F";

        $friendCount      = 0;
        $matchesRoommate1 = 0;
        $matchesRoommate2 = 0;
        $matchesRoommate3 = 0;

        foreach ($colonists as $c) {
            $colonistNameLowerCase = trim(strtolower($c->colonist_name));
            $colonistNameLowerCase = strtr($colonistNameLowerCase, $unwanted_array);
            if ($roommate1Pattern != null && preg_match($roommate1Pattern, $colonistNameLowerCase)) {
                $matchesRoommate1++;
                if ($c->room_number == $colonist->room_number && $c->room_number != "") {
                    if ($colonist->roommate1_status != "T") {
                        $friendCount++;
                    }

                    $colonist->roommate1_status = "T";
                } else {
                    if ($colonist->roommate1_status != "T") {
                        if ($c->room_number != "" && $c->room_number != 0) {
                            $colonist->roommate1_status = "TF" . $c->room_number . $gender;
                        } else {
                            $colonist->roommate1_status = "TF";
                        }

                    }
                }
            }

            if ($roommate2Pattern != null && preg_match($roommate2Pattern, $colonistNameLowerCase)) {
                $matchesRoommate2++;
                if ($c->room_number == $colonist->room_number && $c->room_number != "") {
                    if ($colonist->roommate2_status != "T") {
                        $friendCount++;
                    }

                    $colonist->roommate2_status = "T";
                } else {
                    if ($colonist->roommate2_status != "T") {
                        if ($c->room_number != "" && $c->room_number != 0) {
                            $colonist->roommate2_status = "TF" . $c->room_number . $gender;
                        } else {
                            $colonist->roommate2_status = "TF";
                        }

                    }
                }
            }

            if ($roommate3Pattern != null && preg_match($roommate3Pattern, $colonistNameLowerCase)) {
                $matchesRoommate3++;
                if ($c->room_number == $colonist->room_number && $c->room_number != "") {
                    if ($colonist->roommate3_status != "T") {
                        $friendCount++;
                    }

                    $colonist->roommate3_status = "T";
                } else {
                    if ($colonist->roommate3_status != "T") {
                        if ($c->room_number != "" && $c->room_number != 0) {
                            $colonist->roommate3_status = "TF" . $c->room_number . $gender;
                        } else {
                            $colonist->roommate3_status = "TF";
                        }

                    }
                }
            }
        }

        if ($matchesRoommate1 > 1) {
            $colonist->roommate1_status = "F";
            $friendCount--;
        }
        if ($matchesRoommate2 > 1) {
            $colonist->roommate2_status = "F";
            $friendCount--;
        }
        if ($matchesRoommate3 > 1) {
            $colonist->roommate3_status = "F";
            $friendCount--;
        }

        return $friendCount;
    }

    public function updateRoomNumber()
    {
        $colonistId   = $this->input->post("colonist_id", true);
        $summerCampId = $this->input->post("summer_camp_id", true);
        $roomNumber   = $this->input->post("room_number", true);

        if ($this->summercamp_model->updateRoomNumber($colonistId, $summerCampId, $roomNumber)) {
            echo "true";
        } else {
            echo "false";
        }

    }

    private function filterColonists($colonists, $room, $gender)
    {
        $resultArray = array();

        foreach ($colonists as $colonist) {
            if ($colonist->colonist_gender == $gender) {
                if ($room < 0) {
                    $resultArray[] = $colonist;
                } else if ($room == 0 && ($colonist->room_number == null ||
                    $colonist->room_number == 0 || $colonist->room_number == '')) {
                    $resultArray[] = $colonist;
                } else if ($colonist->room_number == $room) {
                    $resultArray[] = $colonist;
                }

            }
        }

        return $resultArray;
    }

    public function addRoom()
    {
        $this->Logger->info("Running:" . __METHOD__);

        $summerCampId = $this->input->post("summer_camp_id", true);
        $pavilhao     = $this->input->post("pavilhao", true);

        $this->summercamp_model->addRoom($summerCampId, $pavilhao);
    }

    public function dropRoom()
    {
        $this->Logger->info("Running:" . __METHOD__);

        $summerCampId = $this->input->post("summer_camp_id", true);
        $pavilhao     = $this->input->post("pavilhao", true);
        $year         = $this->input->post("year", true);

        $result = $this->summercamp_model->getLastRoom($summerCampId, $pavilhao);
        $ids    = array();
        if ($result) {
            $quarto    = $result->id;
            $colonists = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year, SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED, $summerCampId, $pavilhao);

            $colonistsSelected = $this->filterColonists($colonists, $quarto, $pavilhao);
            foreach ($colonistsSelected as $colonist) {
                $ids[] = $colonist->colonist_id;
            }

            if ($this->summercamp_model->dropRoom($summerCampId, $pavilhao, $quarto, $ids)) {
                echo "true";
            } else {
                echo "false";
            }

        } else {
            echo "false";
        }

    }

    public function autoFillRooms()
    {
        $this->Logger->info("Running:" . __METHOD__);

        $summerCampId = $this->input->post("summer_camp_id", true);
        $gender       = $this->input->post("gender", true);
        $number       = $this->summercamp_model->getLastRoom($summerCampId, $gender)->id;

        if ($number == "") {
            return false;
        }

        $colonists        = $this->summercamp_model->getColonistsToDistributeInRooms($summerCampId, $gender);
        $colonistsPerRoom = ceil(count($colonists) / $number);
        $this->Logger->info("Colonists to distribute in $number rooms: " . count($colonists));
        $this->Logger->info("Colonists per room: " . $colonistsPerRoom);
        $actualRoom   = 1;
        $totalUpdated = 0;

        while ($actualRoom <= $number) {
            for ($i = 0; $i < $colonistsPerRoom && $totalUpdated < count($colonists); $i++) {
                $this->summercamp_model->updateRoomNumber($colonists[(($actualRoom - 1) * $colonistsPerRoom) + $i]->colonist_id, $summerCampId, $actualRoom);
                $totalUpdated++;
            }

            $this->Logger->info("Number of colonists in room " . $actualRoom . ": " . $i);
            $actualRoom++;
        }

        $this->Logger->info("Total of colonists allocated: " . $totalUpdated);

        echo "true";
    }

    public function generateStaffList()
    {
        $this->load->plugin('mpdf');

        $campId = $this->input->post('campId', true);

        $summercamp = $this->summercamp_model->getSummerCampById($campId);

        $staff       = $this->summercamp_model->getCampStaffAlphabetic($campId);
        $coordinator = array();
        $monitor     = array();
        $doctor      = null;

        $data['nameFile'] = 'Lista da equipe ' . $summercamp->getCampName();

        foreach ($staff as $s) {
            if ($s->staff_function == 1) {
                $coordinator[] = $s;
            } else if ($s->staff_function == 2) {
                $monitor[] = $s;
            } else if ($s->staff_function == 3) {
                $doctor = $s;
            }

        }

        $data['summercamp']   = $summercamp->getCampName();
        $data['coordinators'] = $coordinator;
        $data['monitors']     = $monitor;
        $data['doctor']       = $doctor;

        date_default_timezone_set('America/Sao_Paulo');
        $data['time'] = date('d-m-Y G:i:sa');

        $this->loadReportView("summercamps/staffList", $data);
        $html = $this->output->get_output();
        pdf($html, $data['nameFile'] . "_" . date('d-m-Y_G:i:sa') . ".pdf");

    }

    public function generatePDFWithColonistData()
    {
        $this->load->plugin('mpdf');
        $summercampId     = null;
        $monitorInfo      = null;
        $dataIn           = $this->input->post('data', true);
        $dataArray        = json_decode($dataIn);
        $data['nameFile'] = $this->input->post('name', true);
        $this->Logger->info("////// name: " . $this->input->post('name', true));
        $data['type'] = $this->input->post('type', true);
        if (($this->input->post('summercamp', true)) != null) {
            $summercampId       = $this->input->post('summercampId', true);
            $summercamp         = $this->input->post('summercamp', true);
            $data['summercamp'] = $summercamp;
        }
        if (($this->input->post('room', true)) != null) {
            $room         = $this->input->post('room', true);
            $data['room'] = $room;

            if ($summercampId != null) {
                if (($this->summercamp_model->getMonitorIdByRoom($summercampId, $room)) != null) {
                    $monitorId       = $this->summercamp_model->getMonitorIdByRoom($summercampId, $room);
                    $monitor         = $this->person_model->getPersonById($monitorId->person_id);
                    $data['monitor'] = $monitor->getFullname();
                }
            }
        }

        $data['monitorInfo'] = $monitorId;
        $data['filtros']     = json_decode($this->input->post('filters', true));
        date_default_timezone_set('America/Sao_Paulo');
        $data['time'] = date('d-m-Y G:i:sa');

        $colonists = array();

        foreach ($dataArray as $d) {
            foreach ($d as $c) {
                $colonists[] = $this->summercamp_model->getColonistDataFromPDF($c);
            }
        }
        for ($i = 0; $i < count($colonists); $i++) {
            $data['report'][$i]['summercamp']  = $colonists[$i];
            $data['report'][$i]['colonist']    = $this->person_model->getPersonFullById($data['report'][$i]['summercamp']->person_id);
            $data['report'][$i]['mother']      = $this->person_model->getPersonFullById($data['report'][$i]['summercamp']->mother_id);
            $data['report'][$i]['responsable'] = $this->person_model->getPersonFullById($data['report'][$i]['summercamp']->responsable_id);
            $data['report'][$i]['father']      = $this->person_model->getPersonFullById($data['report'][$i]['summercamp']->father_id);
            $data['report'][$i]['document']    = $this->colonist_model->getColonist($data['report'][$i]['summercamp']->colonist_id);
            $data['report'][$i]['minik']       = $this->summercamp_model->getMiniCampObs($data['report'][$i]['summercamp']->camp_id, $data['report'][$i]['summercamp']->colonist_id);

        }
        $this->loadReportView("reports/summercamps/pdf_colonist_info", $data);
        $html = $this->output->get_output();
        pdf($html, $data['nameFile'] . "_" . date('d-m-Y_G:i:sa') . ".pdf");
    }

    private function zipFolder($path,$output)
    {
        // Get real path for our folder
        $rootPath = realpath($path);

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($output, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath     = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();

    }

    public function generatePDFWithSignedAuthorizations()
    {
        $this->load->plugin('mpdf');

        $year         = $_POST['ano'];
        $campChosen   = $_POST['colonia'];
        $allCamps     = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen) {
                $campChosenId = $camp->getCampId();
            }

        }
        $pavilhao = $_POST['pavilhao'];
        $quarto   = $_POST['quarto'];
        $colonists         = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year, SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED, $campChosenId, $pavilhao);
        $colonistsSelected = $this->filterColonists($colonists, $quarto, $pavilhao);
        $time = date('d-m-Y_G:i:sa');
        $path              = "/tmp/" . $time;
        mkdir($path);
        foreach ($colonistsSelected as $colonist ) {
            $nome = utf8_decode($colonist->colonist_name);
            $id = $colonist->colonist_id;
            $document = $this->summercamp_model->getNewestDocument($campChosenId, $id, DOCUMENT_TRIP_AUTHORIZATION_SIGNED);
            if ($document) {
                $extensao = strtolower($document["extension"]);
                $myfile = fopen($path . "/{$nome}.{$extensao}", "w");
                fwrite($myfile, pg_unescape_bytea($document["data"]));
                fclose($myfile);
            } else {
                $myfile = fopen($path . "/{$nome}.txt", "w");
                fwrite($myfile, "Falta o documento assinado para o colonista: {$nome} ");
                fclose($myfile);
            }
        }

        if($quarto == -1)
        {
            $quarto_string = "Todos_{$pavilhao}";
        }else if ($quarto == 0)
        {
            $quarto_string = "SemQuarto_{$pavilhao}";
        }else
        {
            $quarto_string = "{$quarto}{$pavilhao}";
        }
        $campchosen = utf8_decode($campChosen);
        $zippedFile = "/tmp/Autorizacoes_Assinadas_colonia_{$campChosen}_quarto_{$quarto_string}_{$time}.zip";
        $this->zipFolder($path,$zippedFile);

        $file_name = basename($zippedFile);

        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Length: " . filesize($zippedFile));

        readfile($zippedFile);

        die;

    }

    public function generatePDFTripAuthorization()
    {
        $this->load->plugin('mpdf');

        if ($this->input->post('data', true) != null) {
            $dataIn    = $this->input->post('data', true);
            $dataArray = json_decode($dataIn);

            $colonists = $this->colonist_model->getColonists($dataArray);

            $data['colonists'] = $colonists;
            $data['nameFile']  = $this->input->post('name', true);
        } else {
            $data['colonist_id'] = $this->input->post('colonist_id', true);
            $data['nameFile']    = 'autorizacao_de_viagem';
        }

        $data['type']    = $this->input->post('type', true);
        $data['camp_id'] = $this->input->post('camp_id', true);

        $this->loadReportView("summercamps/pdfTripAuthorization", $data);
        $html = $this->output->get_output();
        pdf($html, $data['nameFile'] . "_" . date('d-m-Y_G:i:sa') . ".pdf");
    }

    public function generateStaffPDFTripAuthorization()
    {
        $this->load->plugin('mpdf');
        $staffT = array();

        $data['type'] = $this->input->post('type', true);
        $camp_id      = $this->input->post('camp_id', true);

        $staff = $this->summercamp_model->getCampStaffByFunction($camp_id, 2);

        foreach ($staff as $s) {
            $staffT[] = $this->personuser_model->getUserById($s->person_id);
        }

        $summercamp = $this->summercamp_model->getSummerCampById($camp_id);

        $start = date("d/m/Y", strtotime($summercamp->getDateStart()));
        $end   = date("d/m/Y", strtotime($summercamp->getDateFinish()));

        $data['staff'] = $staffT;
        $data['start'] = $start;
        $data['end']   = $end;

        $data['nameFile'] = 'Autorizações-Monitores-Auxiliares-' . $summercamp->getCampName();

        $this->loadReportView("summercamps/staffPdfTripAuthorization", $data);
        $html = $this->output->get_output();
        pdf($html, $data['nameFile'] . "_" . date('d-m-Y_G:i:sa') . ".pdf");
    }

    public function medicalFiles()
    {
        $data = array();

        $years       = array();
        $start       = 2015;
        $date        = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        while ($start <= $end) {
            $years[] = $start;
            $start++;
        }
        $year = null;

        if (isset($_GET['ano_f'])) {
            $year = $_GET['ano_f'];
        } else {
            $year = date('Y');
        }

        $data['ano_escolhido'] = $year;
        $data['years']         = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps    = array();
        $start    = $campsQtd;
        $end      = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f'])) {
            $campChosen = $_GET['colonia_f'];
        }

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen) {
                $campChosenId = $camp->getCampId();
            }

        }

        $data['summer_camp_id']    = $campChosenId;
        $data['colonia_escolhida'] = $campChosen;
        $data['camps']             = $camps;

        if ($campChosenId != null && isset($_GET['quarto']) && isset($_GET["pavilhao"])) {
            $quarto           = $_GET['quarto'];
            $data["quarto"]   = $quarto;
            $pavilhao         = $_GET['pavilhao'];
            $data["pavilhao"] = $pavilhao;
            $colonists        = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year, SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED, $campChosenId, $pavilhao);

            $colonistsSelected = $this->filterColonists($colonists, $quarto, $pavilhao);

            $roomOccupation = [0, 0, 0, 0, 0, 0, 0];
            for ($i = 0; $i < count($roomOccupation); $i++) {
                $roomColonists      = $this->filterColonists($colonists, $i, $pavilhao);
                $roomOccupation[$i] = count($roomColonists);
            }

            $data["room_occupation"] = $roomOccupation;
            $data["colonists"]       = $colonistsSelected;
        }

        $this->loadView("summercamps/colonistsMedicalFiles", $data);
    }

    public function viewMedicalFile($colonistId, $summerCampId)
    {
        $data = array("camp_id" => $summerCampId, "colonist_id" => $colonistId);
        if ($this->summercamp_model->hasDocument($data["camp_id"], $data["colonist_id"], DOCUMENT_MEDICAL_FILE)) {
            $medical_file        = $this->medical_file_model->getMedicalFile($data["camp_id"], $data["colonist_id"]);
            $data["medicalFile"] = $medical_file;
            $doctor              = $this->person_model->getPersonById($medical_file->getDoctorId());
            $tels                = $this->telephone_model->getTelephonesByPersonId($medical_file->getDoctorId());
            if (isset($tels[0])) {
                $doctor->setPhone1($tels[0]);
            }

            if (isset($tels[1])) {
                $doctor->setPhone2($tels[1]);
            }

            $data["doctor"] = $doctor;
        }

        $this->loadView('summercamps/doctorViewMedicalFile', $data);
    }

    public function updateDoctorObservations()
    {
        $colonistId   = $this->input->post("colonist_id", true);
        $summerCampId = $this->input->post("summer_camp_id", true);
        $observations = $this->input->post("doctor_observations", true);

        if ($this->medical_file_model->updateDoctorObservations($colonistId, $summerCampId, $observations)) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function generatePDFWithColonistMedicalFiles($year, $summerCampId, $gender, $room, $type)
    {
        $this->load->plugin('mpdf');
        $colonists         = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year, SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED, $summerCampId, $gender);
        $colonistsSelected = $this->filterColonists($colonists, $room, $gender);
        $medicalFiles      = array();

        foreach ($colonistsSelected as $colonist) {
            if ($this->summercamp_model->hasDocument($summerCampId, $colonist->colonist_id, DOCUMENT_MEDICAL_FILE)) {
                $mf             = $this->medical_file_model->getMedicalFile($summerCampId, $colonist->colonist_id);
                $medicalFiles[] = $mf;
                $doctor         = $this->person_model->getPersonById($mf->getDoctorId());
                $tels           = $this->telephone_model->getTelephonesByPersonId($mf->getDoctorId());
                if (isset($tels[0])) {
                    $doctor->setPhone1($tels[0]);
                }

                if (isset($tels[1])) {
                    $doctor->setPhone2($tels[1]);
                }

                $doctors[] = $doctor;
            }
        }

        $data['time'] = date('d-m-Y G:i:sa');

        $data["colonists"]    = $colonistsSelected;
        $data["medicalFiles"] = $medicalFiles;
        $data["doctors"]      = $doctors;
        $data['type']         = $type;

        $data["roomNumber"] = $room;
        $data["pavilhao"]   = $gender;
        $data["summerCamp"] = $this->summercamp_model->getSummerCampById($summerCampId);

        if ($type == "varios") {
            if ($room == -1) {
                $room = "Todos-os-Quartos";

                if ($gender == "M") {
                    $gender = "-Masculino";
                } else {
                    $gender = "-Feminino";
                }

            } else if ($room == 0) {
                $room = "Sem-Quarto";

                if ($gender == "M") {
                    $gender = "-Masculino";
                } else {
                    $gender = "-Feminino";
                }

            }

            $fileName = "Fichas-Medicas-" . $room . $gender . "-" . $data["summerCamp"]->getCampName();
        } else {
            $fileName = "ficha-medica-";
        }

        $this->loadReportView("summercamps/pdfMedicalFiles", $data);

        $html = $this->output->get_output();
        pdf($html, $fileName . "_" . date('d-m-Y_G:i:sa') . ".pdf");
    }

    public function generatePDFWithStaffMedicalFiles($year, $summerCampId)
    {
        $this->load->plugin('mpdf');
        $staff                   = $this->summercamp_model->getCampStaffAlphabetic($summerCampId);
        $staffWithMedicalFile    = array();
        $staffWithoutMedicalFile = array();
        $medicalFiles            = array();
        $doctors                 = array();

        foreach ($staff as $s) {
            if ($this->summercamp_model->hasDocumentStaff($s->person_id, DOCUMENT_MEDICAL_FILE)) {
                $mf             = $this->medical_file_model->getStaffMedicalFile($s->person_id);
                $medicalFiles[] = $mf;
                $doctor         = $this->person_model->getPersonById($mf->getDoctorId());
                $tels           = $this->telephone_model->getTelephonesByPersonId($mf->getDoctorId());
                if (isset($tels[0])) {
                    $doctor->setPhone1($tels[0]);
                }

                if (isset($tels[1])) {
                    $doctor->setPhone2($tels[1]);
                }

                $doctors[]              = $doctor;
                $staffWithMedicalFile[] = $s;
            } else {
                $staffWithoutMedicalFile[] = $s;
            }

        }

        $data['time'] = date('d-m-Y G:i:sa');

        $data["staffWithMedicalFile"]    = $staffWithMedicalFile;
        $data["staffWithoutMedicalFile"] = $staffWithoutMedicalFile;
        $data["medicalFiles"]            = $medicalFiles;
        $data["doctors"]                 = $doctors;

        $data["summerCamp"] = $this->summercamp_model->getSummerCampById($summerCampId);

        $fileName = "Fichas-Medicas-Equipe-" . $data["summerCamp"]->getCampName();

        $this->loadReportView("summercamps/pdfStaffMedicalFiles", $data);

        $html = $this->output->get_output();
        pdf($html, $fileName . "_" . date('d-m-Y_G:i:sa') . ".pdf");
    }

    public function colonistPDFMedicalFile()
    {
        $this->load->plugin('mpdf');
        $data         = array("camp_id" => $_GET['camp_id'], "colonist_id" => $_GET['colonist_id']);
        $doctor       = null;
        $medical_file = null;
        $colonist     = $this->summercamp_model->getColonistInformationById($data["colonist_id"]);

        if ($this->summercamp_model->hasDocument($data["camp_id"], $data["colonist_id"], DOCUMENT_MEDICAL_FILE)) {
            $medical_file        = $this->medical_file_model->getMedicalFile($data["camp_id"], $data["colonist_id"]);
            $data["medicalFile"] = $medical_file;
            $doctor              = $this->person_model->getPersonById($medical_file->getDoctorId());
            $tels                = $this->telephone_model->getTelephonesByPersonId($medical_file->getDoctorId());
            if (isset($tels[0])) {
                $doctor->setPhone1($tels[0]);
            }

            if (isset($tels[1])) {
                $doctor->setPhone2($tels[1]);
            }

        }
        $fileName     = "Colonista_" . $colonist->colonist_id;
        $data['time'] = date('d-m-Y G:i:sa');

        $data["colonists"]    = array($colonist);
        $data["medicalFiles"] = array($medical_file);
        $data["doctors"]      = array($doctor);
        $data['type']         = "simples";
        $data["summerCamp"]   = $this->summercamp_model->getSummerCampById($data["camp_id"]);

        $this->loadReportView("summercamps/pdfMedicalFiles", $data);

        $html = $this->output->get_output();

        pdf($html, $fileName . "_" . date('d-m-Y_G:i:sa') . ".pdf");
    }

    public function manageStaff($summerCampId)
    {
        $summerCamp = $this->summercamp_model->getSummerCampById($summerCampId);
        if ($summerCamp != null) {

            $data["summerCamp"] = $summerCamp;

            $data["staff"] = $this->summercamp_model->getCampStaff($summerCampId);

            $data["possibleCoordinators"]   = $this->personuser_model->getUsersByUserType(COORDINATOR);
            $data["possibleMonitors"]       = $this->personuser_model->getUsersByUserType(MONITOR);
            $data["possibleMaleMonitors"]   = $this->personuser_model->getUsersByUserType(MONITOR, 'M');
            $data["possibleFemaleMonitors"] = $this->personuser_model->getUsersByUserType(MONITOR, 'F');
            $data["possibleDoctors"]        = $this->personuser_model->getUsersByUserType(DOCTOR);

            $this->loadView("admin/camps/campStaff", $data);
        }
    }

    public function updateCoordinator()
    {
        $personId       = $this->input->post("person_id", true);
        $summerCampId   = $this->input->post("camp_id", true);
        $coordinatorId1 = $this->input->post("coordinatorId1", true);
        $coordinatorId2 = $this->input->post("coordinatorId2", true);
        $coordinatorId3 = $this->input->post("coordinatorId3", true);

        $ids = array();

        $i = 1;

        if ($coordinatorId1 != 0) {
            $obj       = new stdClass();
            $obj->id   = $coordinatorId1;
            $obj->room = '';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($coordinatorId2 != 0) {
            $obj       = new stdClass();
            $obj->id   = $coordinatorId2;
            $obj->room = '';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($coordinatorId3 != 0) {
            $obj       = new stdClass();
            $obj->id   = $coordinatorId3;
            $obj->room = '';
            $ids[$i]   = $obj;
        }

        if ($this->summercamp_model->updateAllCampStaffByFunction($summerCampId, $ids, 1)) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function existStaffByFunction()
    {
        $summerCampId = $this->input->post("camp_id", true);
        $func         = $this->input->post("func", true);

        if (($this->summercamp_model->getCampStaffByFunction($summerCampId, $func)) != null) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function updateRoommate()
    {

        $colonistId   = $this->input->post("colonist_id", true);
        $summerCampId = $this->input->post("summer_camp_id", true);
        $roommate1    = $this->input->post("roommate1", true);
        $roommate2    = $this->input->post("roommate2", true);
        $roommate3    = $this->input->post("roommate3", true);

        $result = $this->summercamp_model->updateRoomates($colonistId, $summerCampId, $roommate1, $roommate2, $roommate3);

        if ($result) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function changeCamp()
    {

        $colonistId   = $this->input->post("colonist_id", true);
        $summerCampId = $this->input->post("camp_id", true);
        $newCampId = $this->input->post("new_camp_id", true);

        $result = $this->summercamp_model->changeCamp($colonistId, $summerCampId,$newCampId);

        if ($result == true) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function deleteCoordinator()
    {
        $summerCampId = $this->input->post("camp_id", true);

        if ($this->summercamp_model->deleteAllCoordinatorsBySummercamp($summerCampId)) {
            echo "true";
        } else {
            echo "false";
        }
    }

    public function deleteAssistant()
    {
        $personId     = $this->input->post("person_id", true);
        $summerCampId = $this->input->post("camp_id", true);

        if ($this->summercamp_model->deleteCampStaff($personId, $summerCampId, 2)) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function updateDoctor()
    {
        $personId     = $this->input->post("person_id", true);
        $summerCampId = $this->input->post("camp_id", true);

        if ($this->summercamp_model->updateCampStaff($personId, $summerCampId, 3)) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function deleteDoctor()
    {
        $summerCampId = $this->input->post("camp_id", true);

        if ($this->summercamp_model->deleteAllDoctorsBySummercamp($summerCampId)) {
            echo "true";
        } else {
            echo "false";
        }
    }

    public function addAssistant()
    {
        $personId     = $this->input->post("person_id", true);
        $summerCampId = $this->input->post("camp_id", true);

        if (($this->summercamp_model->getCampStaff($summerCampId)) != null) {
            $staff = $this->summercamp_model->getCampStaff($summerCampId);

            foreach ($staff as $s) {
                if ($s->staff_function == 2 && $s->person_id == $personId) {
                    echo "false";
                    return;
                }
            }
        }

        if ($this->summercamp_model->updateCampStaff($personId, $summerCampId, 2)) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function updateMonitor()
    {
        $summerCampId = $this->input->post("camp_id", true);
        $monitorId1   = $this->input->post("monitorId1", true);
        $monitorId2   = $this->input->post("monitorId2", true);
        $monitorId3   = $this->input->post("monitorId3", true);
        $monitorId4   = $this->input->post("monitorId4", true);
        $monitorId5   = $this->input->post("monitorId5", true);
        $monitorId6   = $this->input->post("monitorId6", true);
        $monitorId7   = $this->input->post("monitorId7", true);
        $monitorId8   = $this->input->post("monitorId8", true);
        $monitorId9   = $this->input->post("monitorId9", true);
        $monitorId10  = $this->input->post("monitorId10", true);
        $monitorId11  = $this->input->post("monitorId11", true);
        $monitorId12  = $this->input->post("monitorId12", true);
        $monitorId13  = $this->input->post("monitorId13", true);

        $ids = array();

        $i = 1;

        if ($monitorId1 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId1;
            $obj->room = '1F';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId2 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId2;
            $obj->room = '2F';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId3 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId3;
            $obj->room = '3F';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId4 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId4;
            $obj->room = '4F';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId5 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId5;
            $obj->room = '5F';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId6 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId6;
            $obj->room = '6F';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId7 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId7;
            $obj->room = '7F';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId8 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId8;
            $obj->room = '1M';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId9 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId9;
            $obj->room = '2M';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId10 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId10;
            $obj->room = '3M';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId11 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId11;
            $obj->room = '4M';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId12 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId12;
            $obj->room = '5M';
            $ids[$i]   = $obj;
            $i++;
        }
        if ($monitorId13 != 0) {
            $obj       = new stdClass();
            $obj->id   = $monitorId13;
            $obj->room = '6M';
            $ids[$i]   = $obj;
            $i++;
        }

        if ($this->summercamp_model->updateAllCampStaffByFunction($summerCampId, $ids, 2)) {
            echo "true";
        } else {
            echo "false";
        }

    }

    public function deleteMonitor()
    {
        $summerCampId = $this->input->post("camp_id", true);

        if ($this->summercamp_model->deleteAllMonitorsBySummercamp($summerCampId)) {
            echo "true";
        } else {
            echo "false";
        }
    }

    public function staffMedicalFile()
    {
        $data             = array();
        $personId         = $this->session->userdata("user_id");
        $data['personId'] = $personId;
        $medicalFile      = $this->medical_file_model->getMedicalFile($personId);
        if ($medicalFile != null) {
            //TODO
        } else {
            //TODO
        }
    }

    public function monitorRoom()
    {
        $data = array();

        $years       = array();
        $start       = 2015;
        $date        = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        while ($start <= $end) {
            $years[] = $start;
            $start++;
        }
        $year = null;

        if (isset($_GET['ano_f'])) {
            $year = $_GET['ano_f'];
        } else {
            $year = date('Y');
        }

        $data['ano_escolhido'] = $year;
        $data['years']         = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps    = array();
        $start    = $campsQtd;
        $end      = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f'])) {
            $campChosen = $_GET['colonia_f'];
        }

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen) {
                $campChosenId = $camp->getCampId();
            }

        }

        $data['summer_camp_id']    = $campChosenId;
        $data['colonia_escolhida'] = $campChosen;
        $data['camps']             = $camps;

        if ($campChosenId != null) {
            $data['room_data'] = $this->summercamp_model->getMonitorRooms($this->session->userdata("user_id"));
            if (isset($_GET['quarto']) && $quarto > 0 && $quarto < 7) {
                $quarto         = $_GET['quarto'];
                $data["quarto"] = $quarto;
            }
            $colonists = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year, SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED, $campChosenId, $this->session->userdata("gender"));

            $colonistsSelected = $this->filterColonists($colonists, $quarto, $pavilhao);
            $data['colonists'] = $colonistsSelected;
        }

        $this->loadView("summercamps/monitorRooms", $data);
    }
}
