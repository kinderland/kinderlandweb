<script>

    function toggle(div_id) {
        var el = document.getElementById(div_id);
        if (el.style.display == 'none') {
            el.style.display = 'block';
        } else {
            el.style.display = 'none';
        }
    }

    function popup(windowname, colonistId, summerCampId) {
        toggle(windowname);
        toggle('all');
        $(this).scrollTop(0);
    }

    var colonistsToDonate = 0;

    function donation(colonistId, summerCampId, colonistName) {
        var url = "<?= $this->config->item('url_link'); ?>summercamps/paySummerCampSubscription?camp_id=" + summerCampId + "&colonist_id=" + colonistId;
        if (colonistsToDonate > 1) {
            $("#buttonOneDonation").attr("onclick", "window.location = '" + url + "'")
            $("#buttonOneDonation").text("Doar e inscrever somente o colonista: " + colonistName)
            popup('popUpDiv', colonistId, summerCampId);

        } else {
            window.location = url
        }
    }

</script>


<script>
    function excluir(camp_id, colonist_id, name, subscribed) {

    	if (subscribed) {
                if (confirm("A solicitação de exclusão será encaminhada à secretaria, que entrará em contato para confirmar e tratar de eventual reembolso, seguindo os critérios estabelecidos pela Associação Kinderland. Confirma a solicitação?")) {
                    window.location.replace("<?= $this->config->item('url_link'); ?>summercamps/excludeColonist?camp_id=" + camp_id + "&colonist_id=" + colonist_id);
                    alert("Solicitação de exclusão realizada. Aguarde contato da secretaria.");
                    location.reload();
                }
        } else {
        	if (confirm("Tem certeza que deseja excluir o colonista " + name + " ?")) {
                window.location.replace("<?= $this->config->item('url_link'); ?>summercamps/deleteColonist?camp_id=" + camp_id + "&colonist_id=" + colonist_id);
            }
        }
    }

    function returnToEditSubscription(camp_id, colonist_id) {
        if (confirm("Ao voltar para a elaboração, você poderá editar todas as informações da inscrição. Ao final da edição, não se esqueça de 'enviar pré-inscrição' para que seja realizado o processo de validação. Confirma o retorno para elaboração?")) {
            window.location.replace("<?= $this->config->item('url_link'); ?>summercamps/invalidateSubscription?camp_id=" + camp_id + "&colonist_id=" + colonist_id);
        }
    }

   function showReasonsMessage(info) {
	   $("#msg_body").html(info);
   }

   function alertMessage(){
	   $('a').removeAttr('href');
	   window.location = "<?= $this->config->item('url_link'); ?>summercamps/index";
	   alert("Lembre-se de ENVIAR a pré-inscrição quando finalizar o seu preenchimento.");
   }

   function alertMessage2(){
	   $('a').removeAttr('href');
	   window.location = "<?= $this->config->item('url_link'); ?>summercamps/index";
   }

   function changeCamp(colonistId,campId,newCampId){

	   if(confirm("Confirma a mudança de turma?")){

		   $.post("<?= $this->config->item('url_link') ?>summercamps/changeCamp",
	               {
	                   'colonist_id': colonistId,
	                   'camp_id': campId,
                       'new_camp_id': newCampId
	               },
	               function (data) {
	                   if (data == "true") {
	                       window.location.reload();
	                       alert("Pré-inscrição alterada com sucesso!");
	                   } else {
	                       alert("Ocorreu um erro ao gravar a alteração da pré-inscrição.");
	                   }
	               }
	       );
	   }


   }

</script>

<div class="row">
    <?php require_once APPPATH . 'views/include/common_user_left_menu.php'
    ?>

    <?php

    function insertFigure($object, $summer_camp_id, $colonist_id, $document_type, $validation) {
    	
        if ($object->summercamp_model->hasDocument($summer_camp_id, $colonist_id, $document_type)) {
            if ($validation) {
                if ($validation->verifyDocument($document_type)) {
                $oldSubscriptionRestored = $object -> summercamp_model -> isOldSubscriptionRestored($summer_camp_id,$colonist_id);
            	 
            	if($oldSubscriptionRestored){
            	
            		if($document_type == 3){
            			if($oldSubscriptionRestored->identification_document=='t'){
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
            				return 1;
            			}else if($oldSubscriptionRestored->identification_document=='f') {
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
            				return 0;
            			}
            		}else if($document_type == 5){
            			if($oldSubscriptionRestored->photo=='t'){
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
            				return 1;
            			}else if($oldSubscriptionRestored->photo=='f'){
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
            				return 0;
            			}
            		}else if($document_type == 1){
            			if($oldSubscriptionRestored->medical_file=='t'){
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
            				return 1;
            			}else if($oldSubscriptionRestored->medical_file=='f'){
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
            				return 0;
            			}
            		}
            	}
                    echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
                    return 1;
                } else {
                    echo '<img src="' . $object->config->item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
                    return 0;
                }
            } else {
            	$oldSubscriptionRestored = $object -> summercamp_model -> isOldSubscriptionRestored($summer_camp_id,$colonist_id);
            	 
            	if($oldSubscriptionRestored){
            	
            		if($document_type == 3){
            			if($oldSubscriptionRestored->identification_document=='t'){
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
            				return 1;
            			}else if($oldSubscriptionRestored->identification_document=='f') {
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
            				return 0;
            			}
            		}else if($document_type == 5){
            			if($oldSubscriptionRestored->photo=='t'){
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
            				return 1;
            			}else if($oldSubscriptionRestored->photo=='f'){
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
            				return 0;
            			}
            		}else if($document_type == 1){
            			if($oldSubscriptionRestored->medical_file=='t'){
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
            				return 1;
            			}else if($oldSubscriptionRestored->medical_file=='f'){
            				echo '<img src="' . $object->config->item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
            				return 0;
            			}
            		}
            	}
                echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
                return 1;
            }
        } else {
            echo '<img src="' . $object->config->item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
            return 0;
        }
    }

    function insertFigureRegister($object,$summer_camp_id, $colonist_id, $validation) {
        if ($validation) {
            if ($validation->verifySubscription()) {
            	$oldSubscriptionRestored = $object -> summercamp_model -> isOldSubscriptionRestored($summer_camp_id,$colonist_id);
            	
            	if($oldSubscriptionRestored){
            		if($oldSubscriptionRestored->register=='t'){
            			echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
            			return 1;
            		}else if($oldSubscriptionRestored->register=='f') {
            			echo '<img src="' . $object->config->item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
            			return 0;
            		}
            	}
                echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
                return 1;
            } else {
                echo '<img src="' . $object->config->item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
                return 0;
            }
        } else {
        	$oldSubscriptionRestored = $object -> summercamp_model -> isOldSubscriptionRestored($summer_camp_id,$colonist_id);
        	 
        	if($oldSubscriptionRestored){
        		if($oldSubscriptionRestored->register=='t'){
        			echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
        			return 1;
        		}else if($oldSubscriptionRestored->register=='f') {
        			echo '<img src="' . $object->config->item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
        			return 0;
        		}
        	}
            echo '<img src="' . $object->config->item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
            return 1;
        }
    }
    
    ?>

    <div class="col-lg-10" id="popUpDiv" style="display:none;">
        <form action="<?= $this->config->item('url_link'); ?>summercamps/donateMultipleColonists/" method="post" id="formMultipleDonations">

        </form>

        <table class="table table-bordered table-striped" style="max-width:550px; min-width:550px; table-layout: fixed;"  id="tableDonations">
            <thead>
                <tr>
                    <td colspan="3">
                        Você tem os seguintes colonistas no prazo para doaçao:
                        <input name="colonist_id[]" type="hidden" value="">
                        <input name="summer_camp_id[]" type="hidden" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Nome
                    </td>
                    <td>
                        Valor
                    </td>
                    <td>
                        Prazo
                    </td>
                </tr>
            </thead>
            <tbody id="bodyPopup">
                <tr>

                </tr>
            </tbody>
            <tend>
                <tr>
                    <td colspan="3">Você deseja:</td>
                </tr>
                <tr>
                    <td colspan="3"><button class="btn btn-primary" id="" onClick="$('#formMultipleDonations').submit()">Doar e inscrever todos os colonistas acima</button></td>
                </tr>
                <tr>
                    <td colspan="3"><button class="btn btn-primary" id="buttonOneDonation">Doar e inscrever somente o colonista X</button></td>
                </tr>
                <tr>
                    <td colspan="3"><button class="btn btn-primary" id="" onClick="popup('popUpDiv')">Cancelar</button></td>
                </tr>
            </tend>

        </table>
    </div>


    <div id="all" class = "col-lg-10">
        <h1>Inscrições nas Temporadas Kinderland</h1>
        <?php  if ($summerCamps) { 
		/*
        		if($i !== NULL){
        			echo "<script>setTimeout(alertMessage,50);</script>";
        		} */
            ?>
            <h4>Adicionar colonista na colônia:</h4>
            <?php foreach ($summerCamps as $summerCamp) { 
            			if($this->personuser_model->hasPreviousSubscriptions($this->session->userdata("user_id"))){
                ?>
                <button onclick="sendInfoToModalCamp(<?= $summerCamp->getCampId() ?>);" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalGetPreviousSubscriptions">
                                <?= $summerCamp->getCampName() ?>
                                <br/>     
                                <?= $summerCamp->getSchoolingDescription() ?> 
            				</button>
				<?php } else{?>
				
                <a href="<?= $this->config->item('url_link'); ?>summercamps/subscribeColonist?id=<?= $summerCamp->getCampId() ?>">

                    <button class=" btn btn-primary"><?= $summerCamp->getCampName() ?><br/><?= $summerCamp->getSchoolingDescription() ?></button>
<!--                    <input class=" btn btn-primary" type="button" value="<?= $summerCamp->getCampName() ?>  <?= $summerCamp->getSchoolingDescription() ?>" />
-->
                </a>
            <?php } } ?>
        <?php } else {
/* BUG ruben */
$hasTemporary = 0; 
        	if($hasTemporary){?>
        	Você indicou um CPF para pre-inscrição. Assim, não é mais possível fazer pré-inscrições como responsável.
        	<?php } else{?>
            Não é possível fazer inscrições no momento.
        <?php } }?>
        <?php if ($summerCampInscriptions) {
        	if($i !== NULL){
        		echo "<script>setTimeout(alertMessage2,50);</script>";
        	}
            ?>
            <br />
            <br />
<!--
            <span style="font-size:18px">Ao final do preenchimento dos dados da pré-inscrição, quando todos os ítens estiverem marcados com um
                <img src="<?= $this->config->item('assets') ?>images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>
                ,<br />não esquecer de <span style="color: red"><b>ENVIAR</b></span> a pré-inscrição. O status mudará para aguardando validação e um email automático será enviado, confirmando que a pré-inscrição foi encaminhada.</span> 
-->

            <table class="table-bordered table table-striped">
                <thead>
                <th>Inscrição</th>
                <th></th>
                <th>Ação</th>
                <th>Status</th>
                </thead>
                <?php
                $total = 0;
                foreach ($summerCampInscriptions as $summerCampInscription) {
                    if ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED)
                        $subscribed = "true";
                    else
                        $subscribed = "false";

                    $documents = 0;
                    $validation = $this->validation_model->getColonistValidationInfoObject($summerCampInscription->getColonistId(), $summerCampInscription->getSummerCampId());
                    if (
                            $summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_CANCELLED ||
                            $summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_EXCLUDED ||
                            $summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_GIVEN_UP
                    )
                        continue;
                    ?>
                    <tr>
                        <td><?php

                            if ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN ||
                                    ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS && !$validation->verifySubscription())) {
                                ?>
                            	<a> Status do envio da pré-inscrição</a>
                            	<br>
                            	<br>
                                <a href="<?= $this->config->item('url_link'); ?>summercamps/editSubscriptionColonistForm?colonistId=<?= $summerCampInscription->getColonistId() ?>&summerCampId=<?= $summerCampInscription->getSummerCampId() ?>">Cadastro:</a><?php } else { ?>
                            	<a> Pré-inscrição enviada </a>
                            	<br>
                            	<br>
                                <a href="<?= $this->config->item('url_link'); ?>summercamps/viewColonistInfo?colonistId=<?= $summerCampInscription->getColonistId() ?>&summerCampId=<?= $summerCampInscription->getSummerCampId() ?>">Cadastro:</a><?php } ?>
                            <?= $summerCampInscription->getFullname() ?>
                            <br>
                            <?php
                            $campName = $this->summercamp_model->getSummerCampById($summerCampInscription->getSummerCampId())->getCampName();
                            ?>
                            Colônia: <?= $campName ?>
                            <hr>
                            
                            <?php if($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN ||
                                    ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS && !$validation->verifyDocument(DOCUMENT_MEDICAL_FILE))){?>
                            <a href="<?= $this->config->item('url_link'); ?>summercamps/uploadDocument?camp_id=<?= $summerCampInscription->getSummerCampId() ?>&colonist_id=<?= $summerCampInscription->getColonistId() ?>&document_type=<?= DOCUMENT_MEDICAL_FILE ?>"> Ficha Médica </a>
                            <?php } else {?>
                            Ficha Médica
                            <?php }?>
                            <br>
                            <br>
                            <a href="<?= $this->config->item('url_link'); ?>summercamps/uploadDocument?camp_id=<?= $summerCampInscription->getSummerCampId() ?>&colonist_id=<?= $summerCampInscription->getColonistId() ?>&document_type=<?= DOCUMENT_TRIP_AUTHORIZATION ?>"> Autorização de viagem </a>
                            <br>
                            <br>
                            <a href="<?= $this->config->item('url_link'); ?>summercamps/uploadDocument?camp_id=<?= $summerCampInscription->getSummerCampId() ?>&colonist_id=<?= $summerCampInscription->getColonistId() ?>&document_type=<?= DOCUMENT_GENERAL_RULES ?>"> Normas gerais </a>
                            <br>
                            <br>
                            <?php if($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN ||
                                    ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS && !$validation->verifyDocument(DOCUMENT_IDENTIFICATION_DOCUMENT))){?>
                            <a href="<?= $this->config->item('url_link'); ?>summercamps/uploadDocument?camp_id=<?= $summerCampInscription->getSummerCampId() ?>&colonist_id=<?= $summerCampInscription->getColonistId() ?>&document_type=<?= DOCUMENT_IDENTIFICATION_DOCUMENT ?>"> Documento de identificação </a>
                            <?php } else {?>
                            Documento de identificação
                            <?php }?>
                            <br>
                            <br>
                            <?php if($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN ||
                                    ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS && !$validation->verifyDocument(DOCUMENT_PHOTO_3X4))){?>
                            <a href="<?= $this->config->item('url_link'); ?>summercamps/uploadDocument?camp_id=<?= $summerCampInscription->getSummerCampId() ?>&colonist_id=<?= $summerCampInscription->getColonistId() ?>&document_type=<?= DOCUMENT_PHOTO_3X4 ?>"> Foto 3x4 </a>
                            <?php } else{?>
                            Foto 3x4
                            <?php }?>
                            <br>
                            <br>
                            <?php if($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN ||
                                    ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS && !$validation->verifyDocument(DOCUMENT_MEDICAL_CARD))){?>
                            <a href="<?= $this->config->item('url_link'); ?>summercamps/uploadDocument?camp_id=<?= $summerCampInscription->getSummerCampId() ?>&colonist_id=<?= $summerCampInscription->getColonistId() ?>&document_type=<?= DOCUMENT_MEDICAL_CARD ?>"> Carteira do Plano de Saude </a>
                            <?php } else{?>
                            Carteira do Plano de Saude
                            <?php }?>
                            </td>

                       
                        <td>

                            <?php if($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN ||
                                    ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS && !$validation->verifyDocument(DOCUMENT_MEDICAL_FILE))){
            			echo '<img src="' . $this->config->item('assets') . 'images/payment/redicon.png" width="20px" height="20px"/>';
                            } else {
            			echo '<img src="' . $this->config->item('assets') . 'images/payment/greenicon.png" width="20px" height="20px"/>';
                            }?>
                            <br>
                            <br>
			    <?php $documents += insertFigureRegister($this,$summerCampInscription->getSummerCampId(), $summerCampInscription->getColonistId(), $validation); ?>
                            <br>
                            <br>
                            <hr>
                            <?php $documents += insertFigure($this, $summerCampInscription->getSummerCampId(), $summerCampInscription->getColonistId(), DOCUMENT_MEDICAL_FILE, $validation); ?>
                            <br>
                            <br>
                            <?php $documents += insertFigure($this, $summerCampInscription->getSummerCampId(), $summerCampInscription->getColonistId(), DOCUMENT_TRIP_AUTHORIZATION, $validation); ?>
                            <br>
                            <br>
                            <?php $documents += insertFigure($this, $summerCampInscription->getSummerCampId(), $summerCampInscription->getColonistId(), DOCUMENT_GENERAL_RULES, $validation); ?>
                            <br>
                            <br>
                            <?php $documents += insertFigure($this, $summerCampInscription->getSummerCampId(), $summerCampInscription->getColonistId(), DOCUMENT_IDENTIFICATION_DOCUMENT, $validation); ?>
                            <br>
                            <br>
                            <?php $documents += insertFigure($this, $summerCampInscription->getSummerCampId(), $summerCampInscription->getColonistId(), DOCUMENT_PHOTO_3X4, $validation); ?>
                            <br>
                            <br>
                            <?php $documents += insertFigure($this, $summerCampInscription->getSummerCampId(), $summerCampInscription->getColonistId(), DOCUMENT_MEDICAL_CARD, $validation); ?>
                            <br>
                            <br>
                        </td>

                        <td>
                            <?php
                            if ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS ||
                                    $summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN) {
                                ?>
                                <a href="<?= $this->config->item('url_link'); ?>summercamps/sendPreSubscription?documents=<?= $documents ?>&camp_id=<?= $summerCampInscription->getSummerCampId() ?>&colonist_id=<?= $summerCampInscription->getColonistId() ?>">
                                    <button class="btn btn-primary">
                                        Enviar pré-inscrição
                                    </button> </a>
                                <br>
                            <?php } ?>
                            <?php if ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) { ?>
                                <br>
                                <button class="btn btn-warning" onclick="returnToEditSubscription(<?= $summerCampInscription->getSummerCampId() ?>, <?= $summerCampInscription->getColonistId() ?>)">
                                    Voltar para elaboração
                                </button>
                            <?php } ?>
                            <br>

                            <?php
                            $summerCampPayment = $this->summercamp_model->getSummerCampPaymentPeriod($summerCampInscription->getSummerCampId());

                            if ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT && $summerCampPayment && $summerCampInscription->duringPaymentLimit()) {
                                if ($summerCampInscription->getDiscount() < 100) {
                                    $discount = 1 - ($summerCampInscription->getDiscount() / 100);
                                    $total += floor($summerCampPayment->getPrice() * $discount);
                                    $total_now= floor($summerCampPayment->getPrice() * $discount);
                                    ?>
                                    <script>
                                        colonistsToDonate++;
                                        $('#bodyPopup').append("<tr><td><?= $summerCampInscription->getFullname() ?></td><td>R$ <?= floor($summerCampPayment->getPrice() * $discount) ?>,00</td><td><?= $summerCampInscription->getDatePaymentLimitFormatted() ?></td></tr>");
                                        $('#formMultipleDonations').append("<input type='hidden' name='camp_id[]' value='<?= $summerCampInscription->getSummerCampId() ?>' /> <input type='hidden' name='colonist_id[]' value='<?= $summerCampInscription->getColonistId() ?>' /> <input type='hidden' name='price[]' value='<?php echo $total_now; ?>' />");
                                    </script>
                                    <a href="<?= $this->config->item('url_link'); ?>summercamps/uploadDocument?camp_id=<?= $summerCampInscription->getSummerCampId() ?>&colonist_id=<?= $summerCampInscription->getColonistId() ?>&document_type=<?= DOCUMENT_TRIP_AUTHORIZATION_SIGNED ?>"> 
										<button class="btn btn-primary">
											Autorização de viagem assinada										
										</button>
									</a>
									
									<br/><br/>

                                    <a <?php if(!$this->summercamp_model->getNewestDocument($summerCampInscription->getSummerCampId(), $summerCampInscription->getColonistId(), DOCUMENT_TRIP_AUTHORIZATION_SIGNED)){ echo 'onclick="message()"';}else{ ?> onclick="donation(<?= $summerCampInscription->getColonistId() ?>, <?= $summerCampInscription->getSummerCampId() ?>, '<?= addslashes($summerCampInscription->getFullname()) ?>')" <?php }?>>
                                        <button class="btn btn-primary">
                                            Doar R$ <?php echo $total_now; ?>,00
                                            <br>
                                            Prazo: <?= $summerCampInscription->getDatePaymentLimitFormatted() ?>
                                        </button> </a>
                                    <br>
                                    <?php
                                } else {
                                    ?>
                                    <a onclick='if (confirm("Confirma a inscrição de <?= $summerCampInscription->getFullname() ?> na colonia <?= $campName ?>?"))
                                                                window.location = "<?= $this->config->item('url_link'); ?>summercamps/paySummerCampSubscription?camp_id=<?= $summerCampInscription->getSummerCampId() ?>&colonist_id=<?= $summerCampInscription->getColonistId() ?>";' >
                                        <button class="btn btn-primary">
                                            Inscrever<br>
                                            Prazo: <?= $summerCampInscription->getDatePaymentLimitFormatted() ?>
                                        </button> </a>


                                    <?php
                                }
                            }
                            ?>
                            <br>
                            
                            <?php
                            if (($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED)) {  ?>
                                <button class="btn btn-danger" onclick="excluir(<?= $summerCampInscription->getSummerCampId() ?>,<?= $summerCampInscription->getColonistId() ?>, '<?= addslashes($summerCampInscription->getFullname()) ?>',<?= $subscribed ?>)" class="btn">
                                    Solicitar exclusão
                                </button>
                            <?php  } else { ?>
                                <button class="btn btn-warning" onclick="excluir(<?= $summerCampInscription->getSummerCampId() ?>,<?= $summerCampInscription->getColonistId() ?>, '<?= addslashes($summerCampInscription->getFullname()) ?>',<?= $subscribed ?>)" class="btn">
                                    Excluir pré-inscrição
                                </button>
                            
                            <?php } ?>
                            </button>
                            <?php
                            if (($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS)) {  ?>
                            <p><p><button class="btn btn-danger" data-toggle="modal" data-target="#myModal" onclick="showReasonsMessage('<?=$validation->describeValidation()?>');">Motivos da não validação</button>
                            	</p></p>
                            <?php  }
                            ?>
                            <?php
                            $number = explode(" ",$campName);
                            if (((($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS) || ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN)) && !$this->summercamp_model->getSummerCampById($summerCampInscription->getSummerCampId())->isMiniCamp())) {  ?>
<!--
                            <?php if(strcmp($number[0],"1a") == 0) {?>
                            <p><p><button class="btn btn-primary" onclick="changeCamp('<?=$summerCampInscription->getColonistId()?>','<?=$summerCampInscription->getSummerCampId()?>','2a');">Mudar pré-inscrição para <?php echo "2a Turma ".date("Y");  ?></button>
                            	</p></p>
                            <p><p><button class="btn btn-primary" onclick="changeCamp('<?=$summerCampInscription->getColonistId()?>','<?=$summerCampInscription->getSummerCampId()?>','3a');">Mudar pré-inscrição para <?php echo "3a Turma ".date("Y");  ?></button>
                                </p></p>
-->
                            <?php }if(strcmp($number[0],"2a") == 0) {?>
<!--
                            <p><p><button class="btn btn-primary" onclick="changeCamp('<?=$summerCampInscription->getColonistId()?>','<?=$summerCampInscription->getSummerCampId()?>','1a');">Mudar pré-inscrição para <?php echo "1a Turma ".date("Y");  ?></button>
                                </p></p>
-->
                            <p><p><button class="btn btn-primary" onclick="changeCamp('<?=$summerCampInscription->getColonistId()?>','<?=$summerCampInscription->getSummerCampId()?>','3a');">Mudar pré-inscrição para <?php echo "3a Turma ".date("Y");  ?></button>
                                </p></p>
                            <?php }if(strcmp($number[0],"3a") == 0) {?>
<!--
                            <p><p><button class="btn btn-primary" onclick="changeCamp('<?=$summerCampInscription->getColonistId()?>','<?=$summerCampInscription->getSummerCampId()?>','1a');">Mudar pré-inscrição para <?php echo "1a Turma ".date("Y");  ?></button>
                                </p></p>
-->
                            <p><p><button class="btn btn-primary" onclick="changeCamp('<?=$summerCampInscription->getColonistId()?>','<?=$summerCampInscription->getSummerCampId()?>','2a');">Mudar pré-inscrição para <?php echo "2a Turma ".date("Y");  ?></button>
                                </p></p>
                            <?php }?>
                            <?php  }
                            ?>
                            
                        </td>

                        <td>
                            <?php
                            for ($i = 0; $i <= 6; $i++) {
                                $color = "style='color:grey'";
                                if ($statusArray[$i]["database_id"] === $summerCampInscription->getSituationId())
                                    $color = "style='background-color:lightgreen; padding: 5px 5px; font-weight:bold'";

                                $statusArray[4]["text"] = "Número da pré-inscrição";
                                ?>
                                <p <?= $color ?> >
                                    <?= $statusArray[$i]["text"];?>
                                </p>
                                <?php
                                if ($statusArray[$i]["database_id"] === $summerCampInscription->getSituationId() &&
                                        !$summerCampInscription->duringPaymentLimit() &&
                                        $summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT) {
                                    ?>
                                    <p style='color:red; font-weight:bold' >
                                        &nbsp; &nbsp; &nbsp;Prazo expirado
                                    </p>
                                    <?php
                                } else if ($statusArray[$i]["database_id"] === $summerCampInscription->getSituationId()
                                    && ($summerCampInscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_QUEUE)) { 
$statusArray[4]["text"] = "Número de da pré-inscrição: " . $summerCampInscription->getQueueNumber(); 

                                        ?>  
                                    <p style='color:red; font-weight:bold' >
                                        &nbsp; &nbsp; &nbsp;Número de da pré-inscrição: <?= $summerCampInscription->getQueueNumber() ?>
                                    </p>
                                <?php
                                }
                            }

                            if ($summerCampInscription->getSituationId() < 0)
                                $color = "style='color:green'";
                            else
                                $color = "style='color:grey'";
                            echo "<p $color>";
                            echo $statusArray[7]["text"] . "/" . $statusArray[8]["text"] . "/" . $statusArray[9]["text"];
                            echo "</p>"
                            ?>
                           
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <script>
                $('#bodyPopup').append("<tr><td>Total:</td><td colspan='2'>R$ <?= $total ?>,00</td></tr>");
            </script>
        <?php } ?>
        
        <script>

        	function sendInfoToModalCamp(campId){
        		$("#modalsummercampId").html(campId);
        	}

        	function newSubscription(){
        		var summercampId = document.getElementById('modalsummercampId').textContent;
        		window.location.href= "<?= $this->config->item('url_link'); ?>summercamps/subscribeColonist?id=".concat(summercampId);
        	}

        	function fecharModal(){
				var inputElements = document.getElementsByClassName('checkboxColonist');
				
				for(var i=0; inputElements[i]; ++i){
				      if(inputElements[i].checked){
				    	  inputElements[i].checked = false;
				      }
				}

        	}

        	function message(){

            	alert("Para poder realizar a doação, faça o upload da autorização de viagem assinada. O documento para assinar, você deve gerar pelo link da autorização na inscrição.");
        	}
        	
			function getPreviousSubscriptions(){
				var checkedValue = ""; 
				var summercampId = document.getElementById('modalsummercampId').textContent;
				var inputElements = document.getElementsByClassName('checkboxColonist');
				
				for(var i=0; inputElements[i]; ++i){
				      if(inputElements[i].checked){
				           checkedValue = checkedValue.concat(inputElements[i].value,"-");
				      }
				}

				if(checkedValue == ""){
					alert("É necessário selecionar pelo menos um colonista para resgatar os dados.");

				}else{

					$.post("<?= $this->config->item('url_link') ?>summercamps/getPreviousSubscriptions",
	                        {
	                            colonists_id: checkedValue,
	                            summercampId: summercampId
	                        },
	                        function (data) {
	                            if (data == "true") {
	                                alert("Recuperação de dados executada com sucesso!");
	                                window.location.reload();
	                            } else {
	                                alert("Ocorreu um erro ao tentar recuperar os dados. Tente novamente!");
	                                window.location.reload();
	                            }
	                        }
	                );
				}
			}

        </script>
        
        <style>
        	.center-table
				{
				  margin: 0 auto !important;
				  float: none !important;
				}
        
        </style>
        
        
        <!-- Modal RESGATAR INSCRIÇÃO ANTIGA -->
		<div class="modal fade" id="myModalGetPreviousSubscriptions" tabindex="-1" role="dialog" aria-labelledby="solicitar-convite" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="create_account_name">Resgatar Dados de Inscrições Passadas</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 middle-content">
								<h5 style='color:red' >O resgate de dados só pode ser realizado uma vez por inscrição passada.
								<br> <br>Ao resgatar, não se esqueça de atualizar todas as informações, como Ano Escolar.</br>
								</h5>
								<br/>
								<input type="hidden" id="modalsummercampId" name="modalsummercampId" value="" />
																
								<div class="eventInsForm" name="form_subscribe" id="form_subscribe">
								
									<table class="center-table table table-bordered table-striped table-min-td-size" style="width:400px" id="sortable-table">
			                            <thead>
			                                <tr>
			                                    <th style="width:300px"> Colonista </th>
			                                    <th style="width:100px"> Resgatar </th>
			                                </tr>
			                            </thead>
			                            <tbody id="tablebody">
			                                <?php 
			                                $info = $this->summercamp_model->getOldSubscriptionByUserId($this->session->userdata("user_id"));
			                                if($info){
			                                foreach ($info as $i) {
			                                	$colonist = $this -> colonist_model ->getColonist($i -> colonist_id);
			                                    ?>
			                                    <tr>
			                                        <td><?= $colonist->getFullname(); ?></td>
			                                        <td><input type="checkbox" class="checkboxColonist" value="<?php echo $colonist->getColonistId(); ?>"></td>
			                                    </tr>
			                                    <?php
			                                }}
			                                ?>
			                                <tr>
			                                	<td></td>
			                                	<td><button type="button" class="btn btn-success" onClick="getPreviousSubscriptions()">Confirmar</button></td>
			                                </tr>
			                            </tbody>
			                            
			                        </table>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-header">
						<h4 class="modal-title" id="create_account_name3"> </h4>
					</div>
					<br/>
					<h4 class="modal-title" id="create_account_name2">&nbsp;&nbsp;&nbsp;&nbsp;Não Desejo Resgatar Dados de Inscrições Passadas</h4>
					<div class="modal-footer">
						<input type="button" class="col-lg-4 btn btn-primary" onclick="newSubscription()" value="Criar Nova Pré-inscrição"/>
						<button type="button" class="btn btn-danger" onclick="fecharModal()" data-dismiss="modal">Fechar</button>
						
					</div>
				</div>
			</div>
		</div>
		
<!-- Fim do RESGATAR INSCRIÇÃO ANTIGA -->

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="solicitar-convite" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 middle-content">			
								<div class="row">
									<div class="form-group">
										<div class="col-lg-12">
											<p> 
												<span id="msg_body"></span>
											</p>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					</div>
				</div>
			</div>
		</div>

    </div>
</div>
