<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css" rel="stylesheet" />
        <!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css"></script>
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

    </head>
    <body>
        <script>
            $(function() {
                $(".sortable-table").tablesorter();
                $(".datepicker").datepicker();
            });
            
            function newOperation() {
                var secretary_id = $('#secretary option:selected').val();
                var value = $("#value").val();

                if(secretary_id != null || value != null){
                    $.post("<?= $this->config->item('url_link'); ?>admin/newOperation",
                        { secretary_id: secretary_id, value: value },
                            function ( data ){
                                if(data == "true"){
                                    alert("Operação realizada");
                                    location.reload();
                                }
                                else{
                                    alert("Erro ao realizar a operação");
                                    location.reload();
                                }
                            }
                    );
                } else {
                    alert("Por favor, selecione todos os campos para realizar a operação.");
                    location.reload();
                }
            }
            
        </script>
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
                <?php if($balances) {?>
                	<h2>Secretários:</h2>
                	<table class="sortable-table" style="max-width: 500px;" >
                		<thead> 
                            <tr>
                                <th>Nome</th>
                            	<th>Saldo</th>
                            </tr>
                        </thead> 
                        <tbody>
                    <?php foreach($balances as $b) {?>
                            <tr>
                                <td><?php echo $b-> fullname;?></td>
                                <td><?php echo $b-> balance;?></td>
			                </tr>
			                                 
                    <?php }}?> 
                    	</tbody>
                    </table>
                    <h2>Nova operação:</h2>
                        <table class="sortable-table" style="max-width: 500px;" >
                         <thead> 
                            <tr>
                                <th>Nome</th>
                            	<th>Valor</th>
                            	<th>Ação</th>
                            </tr>
                        </thead> 
                        <tbody> 
                            <tr>
                                <td><select name="secretary" id="secretary">
			                            <option value="">-- Selecione --</option>
			                            <?php
			                            foreach ( $secretaries as $s ) {
			                                $selected = "";
			                                echo "<option $selected value='".$s->getPersonId()."'>".$s->getFullname()."</option>";
			                            }
			                            ?>
			                        </select></td>
                                <td><input type="text" placeholder="Valor" id="value""></td>
                                <td><button class="btn btn-primary" onClick="newOperation()">Confirmar</button></td>
			                </tr>
			             </tbody>
			           </table>               
                </div>
            </div>
        </div>
    </body>
</html>