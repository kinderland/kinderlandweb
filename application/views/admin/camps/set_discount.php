<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>


		<script>

		
		
			function verifyOtherDiscountReason() {
				var val = $("#discount_reason").val();
				if (val == -2) {
					$("#discount_other").fadeIn();
					$("#discount_other").prop('disabled', false);
				} else {
					$("#discount_other").fadeOut();
					$("#discount_other").prop('disabled', true);
				}
			}

			function toggle(div_id) {
				var el = document.getElementById(div_id);
				if (el.style.display == 'none') {
					el.style.display = 'block';
				} else {
					el.style.display = 'none';
				}
			}

			function blanket_size(popUpDivVar) {
				if ( typeof window.innerWidth != 'undefined') {
					viewportheight = window.innerHeight;
				} else {
					viewportheight = document.documentElement.clientHeight;
				}
				if ((viewportheight > document.body.parentNode.scrollHeight) && (viewportheight > document.body.parentNode.clientHeight)) {
					blanket_height = viewportheight;
				} else {
					if (document.body.parentNode.clientHeight > document.body.parentNode.scrollHeight) {
						blanket_height = document.body.parentNode.clientHeight;
					} else {
						blanket_height = document.body.parentNode.scrollHeight;
					}
				}
				var blanket = document.getElementById('blanket');
				blanket.style.height = blanket_height + 'px';
				var popUpDiv = document.getElementById(popUpDivVar);
				popUpDiv_height = 0;
				popUpDiv.style.top = popUpDiv_height + 'px';
			}

			function window_pos(popUpDivVar) {
				popUpDiv.style.left = '0px';
			}

			function popup(windowname, colonistId, summerCampId) {
				blanket_size(windowname);
				window_pos(windowname);
				toggle('blanket');
				toggle(windowname);
				var colonistName = "#colonistName_" + colonistId + "_" + summerCampId;
				var colonistDiscount = "#colonistDiscount_" + colonistId + "_" + summerCampId;
				var colonistDiscountReason = "#colonistDiscountReason_" + colonistId + "_" + summerCampId;
				$(".namepopup").empty();
				$(colonistName).clone().appendTo(".namepopup");
				$(".colonist_id").val(colonistId);
				$(".summer_camp_id").val(summerCampId);
				$("#discount_value").val($(colonistDiscount).text());
				if($(colonistDiscountReason).attr('valueId'))
					$("#discount_reason").val($(colonistDiscountReason).attr('valueId'));

			}

		</script>

		<style>

			#discount_other, #discount_reason, #discount_value{
				max-width: 160px;
				width: 160px;
				word-wrap: break-word;
			}

			input {
				max-width: 120px;
				word-wrap: break-word;
			}

			select {
				max-width: 110px;
				word-wrap: break-word;
			}
			option {
				border: solid 1px #DDDDDD;
			}

			#blanket {
				background-color: #111;
				opacity: 0.65;
				filter: alpha(opacity=65);
				position: absolute;
				top: 0px;
				left: 0px;
				width: 100%;
			}
			#popUpDiv {
				position: absolute;
				background-color: #eeeeee;
				width: 400px;
				height: 200px;
			}
			
			div.scroll{
    	
    			width:100%;
    			height:100%;
    			overflow-x:hidden;
    
   		 	}
		</style>

        <link href="<?= $this -> config -> item('assets'); ?>css/basic.css" rel="stylesheet" />
        <link href="<?= $this -> config -> item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/bootstrap-switch.min.css">
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/theme.default.css" />
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/ui/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquerysettings.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery/jquery.redirect.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery/jquery.mask.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>datatable/js/datatable.min.js"></script>
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>datatable/css/datatable-bootstrap.min.css" />

        <script>
			var selectTodos = {
				element : null,
				values : "auto",
				empty : "Todos",
				multiple : false,
				noColumn : false,
			}

			$(document).ready(function() {
				$('#sortable-table').datatable({
					pageSize : Number.MAX_VALUE,
					sort : [
					function(l, r) {
						return l.toLowerCase().localeCompare(r.toLowerCase());
					}, //Evita problemas com caps-lock
					function(l, r) {
						return l.toLowerCase().localeCompare(r.toLowerCase());
					}, //Evita problemas com caps-lock
					function(l, r) {
						return l.toLowerCase().localeCompare(r.toLowerCase());
					}, //Evita problemas com caps-lock
					function(l, r) {
						return l.toLowerCase().localeCompare(r.toLowerCase());
					}, //Evita problemas com caps-lock
					false, false, false],
					filters : [true, selectTodos, true, selectTodos, false, false, false]
				});
			});

		</script>
		

    </head>
    <body>
    	<script type="text/javascript">
    																																												function openDiscountTab(colonist_id, summer_camp_id) {
    			$("#discount_tab_"+colonist_id+"_"+summer_camp_id).fadeIn();
    		}
    		function closeDiscountTab(colonist_id, summer_camp_id) {
    			$("#discount_tab_"+colonist_id+"_"+summer_camp_id).fadeOut();
    		}

            function confirmDiscount() {
            	colonist_name = $( ".namepopup" ).text();
                colonist_id = $( ".colonist_id" ).val();
                summer_camp_id = $( ".summer_camp_id" ).val();
                
                if(confirm("Deseja realmente confirmar o desconto para o colonista "+colonist_name+"?")) {
                    var discountReasonId = "#discount_reason";
                    var discountValueId = "#discount_value";

                    var discountValue = $(discountValueId).val();
                
                    var discountReason = $(discountReasonId).val();
                    if(discountReason == -1 && discountValue != 0){
                        alert("Você está colocando um desconto sem motivo, por favor selecione um motivo")                       	
                        return;
                    } else if(discountReason != -1 && discountValue == 0){
                        alert("Você está colocando um motivo sem desconto, por favor selecione um desconto");
                        return;                    	
                    } else if (discountReason == -2){
	                    var discountReasonOther = "#discount_other";
	                    discountReasonOther = $(discountReasonOther).val();
	                    if(discountReasonOther == ""){
	                    	alert("Por favor insira um motivo para o desconto");
	                    	return;
	                    }
	                    var url = "<?= $this -> config -> item('url_link') ?>
						admin/setDiscountValue?colonist_id="+colonist_id+"&summer_camp_id="+summer_camp_id+"&discount_value="+discountValue+"&discount_reason_id="+discountReason+"&discount_reason_other="+discountReasonOther
						window.location.href = url;
						return;                	
                    }
                    var url = "<?= $this -> config -> item('url_link') ?>
						admin/setDiscountValue?colonist_id="+colonist_id+"&summer_camp_id="+summer_camp_id+"&discount_value="+discountValue+"&discount_reason_id="+discountReason
						window.location.href = url;
						}
					}

    	</script>
		<div class="scroll">
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
					<form method="GET">
                        <select name="ano_f" onchange="this.form.submit()" id="anos">

                            <?php
                            foreach ($years as $year) {
                                $selected = "";
                                if ($ano_escolhido == $year)
                                    $selected = "selected";
                                echo "<option $selected value='$year'>$year</option>";
                            }
                            ?>
                        </select>
                    </form>
                    <table class="table table-bordered table-striped" style="width: 93%; font-size:12px; display:block;" id="sortable-table">
                        <thead>
                            <tr>
                                <th style="min-width: 100px; max-width: 100px"> Nome do Colonista </th>
                                <th style="min-width: 140px; max-width: 140px"> Colônia </th>
                                <th style="min-width: 100px; max-width: 100px"> Responsável </th>
                                <th style="min-width: 140px; max-width: 140px"> Status da inscrição </th>
                                <th style="min-width: 70px; max-width: 70px"> % Desconto </th>
                                <th style="min-width: 80px; max-width: 70px"> Motivo </th>
                                <th style="min-width: 80px; max-width: 70px"> Editar </th>
                            </tr>
                        </thead>
                        
                        <tbody id="tablebody">
                            <?php
                            foreach ($colonists as $colonist) {
                            ?>
                                <tr>
                                    <td ><a name="<?= $colonist -> colonist_name ?>" id="colonistName_<?=$colonist -> colonist_id ?>_<?=$colonist -> summer_camp_id ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> summer_camp_id ?>"><?= $colonist -> colonist_name ?></a></td>
                                    <td ><?= $colonist -> camp_name ?></td>
                                    <td ><a id="<?= $colonist -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> person_user_id ?>"><?= $colonist -> user_name ?></a></td>
                                    <td id="colonist_situation_<?=$colonist -> colonist_id ?>_<?=$colonist -> summer_camp_id ?>"><?= $colonist -> situation_description ?></td>
                                    <td ><p id="colonistDiscount_<?=$colonist -> colonist_id ?>_<?=$colonist -> summer_camp_id ?>"><?=$colonist -> discount ?></p></td>
                                    <td ><p id="colonistDiscountReason_<?=$colonist -> colonist_id ?>_<?=$colonist -> summer_camp_id ?>" valueid="<?=$colonist -> discount_reason_id ?>"><?=$colonist -> discount_reason ?></p></td>
                                    <td style="max-width:80px">
                                    	<?php if($colonist -> situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED) { ?>
					                    	<button class="btn btn-primary" id="submit_btn_<?=$colonist -> colonist_id ?>_<?=$colonist -> summer_camp_id ?>" onClick="popup('popUpDiv','<?=$colonist -> colonist_id ?>', '<?=$colonist -> summer_camp_id ?>')">Editar</button>
					                    <?php } ?>
                                    </td>
                                </tr>
                            	</form>
	                            </td>
                            </tr>
                            <?php
							}
                            ?>
                        </tbody>
                    </table>

		<div id="blanket" style="display:none;"></div>
			<div id="popUpDiv" style="display:none;">
				<table class="table table-bordered table-striped">
					<tr>
						<td colspan="2">
							Alterando dados de desconto para o colonista:
							<input class="colonist_id" type="hidden" value="">
							<input class="summer_camp_id" type="hidden" value="">
						</td>
					</tr>
					<tr>
						<td class="namepopup" colspan="2"></td>
					</tr>


					<tr>
						<td>
							Desconto %
	                    </td>

						<td>
							<select id="discount_value" class="select" id="discount_value" class="form-control">
        	                	<?php for($i=0;$i<=100;$i++){
		                    	?>
                    			<option value="<?=$i ?>" ><?=$i ?></option>
    	                		<?php } ?>
	                    	</select>
	                    </td>
					</tr>
					<tr>
						<td >
							Motivo do desconto:
	                    </td>

						<td >
							<select id="discount_reason" onchange="verifyOtherDiscountReason();" class="select" name="discount_reason" class="form-control">
								<option value="-1"></option>
        	                	<?php $discountReasons; foreach($discountReasons as $discountReason){
		                    	?>
                    			<option value="<?=$discountReason -> discount_reason_id ?>" ><?=$discountReason -> discount_reason ?></option>
    	                		<?php } ?>
								<option value="-2">Outra</option>
	                    	</select>
	                    	<br>
	                        <input type="text" class="form-control" placeholder="Motivo do desconto"
                               name="discount_other" id="discount_other" disabled style="display: none;" />
	                    </td>
					</tr>
					<tr>
						<td colspan="2">
		                    <button class="btn btn-primary" id="" onClick="confirmDiscount()">Salvar desconto</button>						
		                    <button class="btn btn-primary" id="" onClick="popup('popUpDiv')">Fechar popup</button>						
						</td>
					</tr>
				</table>
		</div>
	</div>
   </div>
  </div>
  </div>
    </body>
</html>