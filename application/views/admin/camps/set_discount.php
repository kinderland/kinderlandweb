<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

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
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/formValidationFunctions.js"></script>
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
					false,false,false
					],
					filters : [true,selectTodos,true,selectTodos,false,false,false]
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

            function confirmDiscount(colonist_id, colonist_name, summer_camp_id) {
                if(confirm("Deseja realmente confirmar o desconto para o colonista "+colonist_name+"?")) {
                    var discountReasonId = "#discount_reason_"+colonist_id+"_"+summer_camp_id;
                    var discountValueId = "#discount_value_"+colonist_id+"_"+summer_camp_id;

                    var discountValue = $(discountValueId).val();

                    if(discountValue < 0){
                        alert("Desconto inválido");
                        return;
                    }
                    
                    var discountReason = $(discountReasonId).val();
                    if(discountReason == -1){
                        if(!confirm("Você está colocando um desconto sem motivo, deseja continuar?"))                       	
	                        return;
                    }
                    
                    var url = "<?= $this->config->item('url_link') ?>admin/setDiscountValue?colonist_id="+colonist_id+"&summer_camp_id="+summer_camp_id+"&discount_value="+discountValue+"&discount_reason_id="+discountReason
                    window.location.href = url;
                 }
            }

    	</script>

        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
					
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 500px; font-size:12px" id="sortable-table">
                        <thead>
                            <tr>
                                <th style="max-width: 30px"> Nome do Colonista </th>
                                <th style="max-width: 30px"> Colônia </th>
                                <th style="max-width: 30px"> Responsável </th>
                                <th style="max-width: 30px"> Status da inscrição </th>
                                <th style="max-width: 30px"> % Desconto </th>
                                <th style="max-width: 30px"> Motivo </th>
                                <th style="max-width: 30px"> Editar </th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            foreach ($colonists as $colonist) {
                            ?>
                                <tr>
                                    <td style="max-width: 30px"><a id="<?= $colonist -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> summer_camp_id ?>"><?= $colonist -> colonist_name ?></a></td>
                                    <td style="max-width: 30px"><?= $colonist -> camp_name ?></td>
                                    <td style="max-width: 30px"><a id="<?= $colonist -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> person_user_id ?>"><?= $colonist -> user_name ?></a></td>
                                    <td style="max-width: 30px" id="colonist_situation_<?=$colonist -> colonist_id ?>_<?=$colonist -> summer_camp_id ?>"><?= $colonist -> situation_description ?></td>
                                    <td style="max-width: 30px"><select id="discount_value_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>" class="select" name="discount_value" class="form-control">
                                    	<?php for($i=0;$i<=100;$i++){
                                    		$selected = "";
											if($i == $colonist->discount)
												$selected = "selected";
                                    	?>
                                    		<option value="<?=$i ?>" <?=$selected ?>><?=$i ?></option>
                                    	<?php } ?>
                                    </select></td>
                                    <td>
                                    	<select required id="discount_reason_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>" name="discount_reason" class="select">
			                    			<option value="-1"></option>
		                        			<?php foreach($discountReasons as $reason) {
		                        				$selected = "";
		                        				if($reason->discount_reason_id === $colonist->discount_reason_id)
													$selected = "selected"	 ?>
			                        			<option value ="<?=$reason -> discount_reason_id ?>" <?=$selected ?>><?=$reason -> discount_reason ?></option>
		                        			<?php } ?>
                        				</select>
                    				</td>
                                    <td>
					                    <button class="btn btn-primary" id="submit_btn_<?=$colonist -> colonist_id ?>_<?=$colonist -> summer_camp_id ?>" onClick="confirmDiscount(<?=$colonist -> colonist_id ?>, '<?=$colonist -> colonist_name ?>', <?=$colonist -> summer_camp_id ?>)">Submeter</button>
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
                </div>
            </div>
        </div>
    </body>
</html>