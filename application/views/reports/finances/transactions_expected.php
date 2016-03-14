<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css" rel="stylesheet" />
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css">
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>datatable/js/datatable.min.js"></script>
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>datatable/css/datatable-bootstrap.min.css" />
    	
        <script>

        function changeData() {
            if(document.getElementById("data").style.display == "none") {
        		document.getElementById("data").style.display = "inline-block";
            }
            else
            	document.getElementById("data").style.display = "none";
        }

        function number_format( numero, decimal, decimal_separador, milhar_separador ){	
            numero = (numero + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+numero) ? 0 : +numero,
                prec = !isFinite(+decimal) ? 0 : Math.abs(decimal),
                sep = (typeof milhar_separador === 'undefined') ? ',' : milhar_separador,
                dec = (typeof decimal_separador === 'undefined') ? '.' : decimal_separador,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix para IE: parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }

            return s.join(dec);
        }
        
        function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
			var valor = parseFloat(0);
			var table = document.getElementById("tablebody");
			var valores = document.getElementsByName("value");

        	for (var i = 0; i < valores.length; i++) {
                valorAtual = parseFloat(valores[i].getAttribute("id"));
                valor += valorAtual;
            }
			
           	valor = number_format(valor,2,',','');
            return 'Valor Total: ' + valor;
        }

        function handlePeriodFields(){
            if($("#periodos").val() == "Específico"){
                $("#data").show();
            } else {
            	$("#data").hide();
            	$("#form_periodo").submit();
            }
        }

	    </script>
	
	</head>
	<style>
	
	div.pad{
	
		padding-left:8%
	}		
			
	</style>
	<body>
	    <script>
	        $(document).ready(function () {
	            $('#sortable-table').datatable({
	                pageSize: Number.MAX_VALUE,
	                sort: [true, true],
	                filters: [true, true],
	                filterText: 'Escreva para filtrar... ',
	                counterText: showCounter
	            });
	            $(".datepicker").mask("00/00/0000", {
	            	placeholder: "__/__/____"
	        	});	
	        	$(function() {
	                $( ".datepicker" ).datepicker({
	                    dateFormat: "dd/mm/yy",
	                    buttonImage: "<?= $this->config->item('assets'); ?>images/calendar.gif",
	                    buttonImageOnly: true,
	                    buttonText: "Selecionar data"
	                });
	            });
	            
	        });
	    </script>
	    <div class="main-container-report">
	        <div class = "row">
	            <div class="col-lg-12">
	                <form id="form_periodo" method="GET">
	                   Período: <select name="periodo_f" id="periodos" onchange="handlePeriodFields()">
	
	                        <?php
	                        foreach ($periods as $period) {
	                            $selected = "";
	                            if ($periodo_escolhido == $period) {
	                                $selected = "selected";
	                            }
	                            echo "<option $selected value='$period'>$period</option>";
	                        }
	                        ?>
	                    </select>
	                   Doação: <select name="doacao_f" id="doacoes">
	
	                        <?php
	                        foreach ($donations as $donation) {
	                            $selected = "";
	                            if ($doacao_escolhida == $donation)
	                                $selected = "selected";
	                            echo "<option $selected value='$donation'>$donation</option>";
	                        }
	                        ?>
	                    </select>
	                    <br/>
	                    <br/>
	                    <div id="data" <?=(($periodo_escolhido=="Específico")?"":"style='display:none;'") ?>>
	                    	<table border="0">
	                    		<tr>
	                    			<td>Data Inicial:</td>
	                    			<td> <input name="periodo_inicial_f" type="text" class="form-control datepicker" style="width:120px !important"/></td>
	                    		</tr>
	                    		<tr>
	                    			<td>Data Final:</td>
	                    			<td> <input name= "periodo_final_f" type="text" class="form-control datepicker" style="width:120px !important"/></td>
	                    		</tr>
	                    	</table>
	                    	<br />
	                    	
	                    </div>
	                    <div class="pad">
	                    <button class="btn btn-primary" onclick="this.form.submit()">Gerar Tabela</button>
	                </form>
	                <br /> <br />
	                <div class="counter"></div> <br>
	                <?php if(isset($transactions)) {?>
	                
	                <table class="table table-bordered table-striped table-min-td-size" style="max-width: 700px; font-size:15px" id="sortable-table">
	                    <thead>
	                        <tr>
	                            <th>Data</th>
	                            <th>Valor</th>
	                        </tr>
	                    </thead>
	                    <tbody id="tablebody">
	                        <?php
	
	                        foreach ($transactions as $transaction) {
	                        	if($transaction -> valueDay!=0){
	                            ?>
	                            <tr>
	                                <td><?= $transaction -> day?></td>
	                                <td name="value" id="<?php echo $transaction -> valueDay?>"><?= number_format($transaction -> valueDay,2,',','')?></td>
	                            </tr>
	                            <?php
	                        } }
	                        ?>
	                    </tbody>
	                </table>
	                </div>
	                <?php }?>
	            </div>
	        </div>
	    </div>
	</body>
</html>