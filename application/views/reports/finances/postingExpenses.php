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


    </head>
    <body>
        <script>

        function post(path, params, method) {
            method = method || "post"; // Set method to post by default if not specified.

            // The rest of this code assumes you are not using a library.
            // It can be made less wordy if you use one.
            var form = document.createElement("form");
            form.setAttribute("method", method);
            form.setAttribute("action", path);

            for (var key in params) {
                if (params.hasOwnProperty(key)) {
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", key);
                    hiddenField.setAttribute("value", params[key]);
                    form.appendChild(hiddenField);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }

        function getCSVName() {

            var nomePadrao = "lancamentos-";
            var mes = $("#month").val();
            var ano = $("#year").val();
            var mesReal = "";

            switch(mes) {
	            case "0":
	            	mesReal = "todos-os-meses-";
	                break;
	            case "1":
	            	mesReal="janeiro-";
	                break;
	            case "2":
	            	mesReal="fevereiro-";
	                break;
	            case "3":
	            	mesReal="março-";
	                break;
	            case "4":
	            	mesReal="abril-";
	                break;
	            case "5":
	            	mesReal="maio-";
	                break;
	            case "6":
	            	mesReal="junho-";
	                break;
	            case "7":
	            	mesReal="julho-";
	                break;
	            case "8":
	            	mesReal="agosto-";
	                break;
	            case "9":
	            	mesReal="setembro-";
	                break;
	            case "10":
	            	mesReal="outubro-";
	                break;
	            case "11":
	            	mesReal="novembro-";
	                break;
	            case "12":
	            	mesReal="dezembro-";
	                break;
	        }
            
            nomePadrao = nomePadrao.concat(mesReal);
            nomePadrao = nomePadrao.concat(ano);
            
            return nomePadrao;
        }


        function sendTableToCSV() {
            var data = [];
            var table = document.getElementById("tablebody");
            var name = getCSVName();
            var elements = document.getElementsByName('document_description');
            var tablehead = document.getElementsByTagName("thead")[0];
            
            for (var i = 0, row; row = table.rows[i]; i++) {
                var data2 = []
                //Nome, retira pega o que esta entre um <> e outro <>
                var description = elements[i].getAttribute('id');

                data2.push(row.cells[0].innerHTML);
                data2.push(description);
                data2.push(row.cells[5].innerHTML);
                data2.push(row.cells[4].innerHTML);
                data.push(data2)
            }
            if (i == 0) {
                alert('Não há dados para geração da planilha');
                return;
            }


            var dataToSend = JSON.stringify(data);
            var columName = ["Data", "Descrição", "Nome da Conta", "Valor"];
            var columnNameToSend = JSON.stringify(columName);
            post('<?= $this->config->item('url_link'); ?>reports/toCSV', {data: dataToSend, name: name, columName: columnNameToSend});
        }


        
        $(function() {
            $(".sortable-table").tablesorter();
            $(".datepicker").datepicker();
        });
        </script>
        <br />
        <div class="scroll">
        	<form method="GET">
                <input type="hidden" name="option" value="<?= $option ?>"/>
                Ano: <select name="year" onchange="this.form.submit()" id="year">
                    <?php
                    foreach ($years as $y) {
                        $selected = "";
                        if ($y == $year)
                            $selected = "selected";
                        echo "<option $selected value='$y'>$y</option>";
                    }
                    ?>
                </select>

                Mês: <select name="month" onchange="this.form.submit()" id="month">
                    <option value="0" <?php if (!isset($mes)) echo "selected"; ?>>Todos</option>
                    <?php

                    function getMonthName($m) {
                        switch ($m) {
                            case 1: return "Janeiro";
                            case 2: return "Fevereiro";
                            case 3: return "Março";
                            case 4: return "Abril";
                            case 5: return "Maio";
                            case 6: return "Junho";
                            case 7: return "Julho";
                            case 8: return "Agosto";
                            case 9: return "Setembro";
                            case 10: return "Outubro";
                            case 11: return "Novembro";
                            case 12: return "Dezembro";
                        }
                    }

                    for ($m = 1; $m <= 12; $m++) {
                        $selected = "";
                        if ($m == $month)
                            $selected = "selected";
                        echo "<option $selected value='$m'>" . getMonthName($m) . "</option>";
                    }
                    ?>
                </select>
            </form>
             <button class="button btn btn-primary col-lg-2" onclick="sendTableToCSV()" value="">Exportar</button>
            <br /> <br />
           
                <div class = "row">
                    <div class="col-lg-12 middle-content">
                        <table class="table table-bordered table-striped table-min-td-size" style="width:1030px" id="sortable-table">
                            <thead>
                                <tr>
                                    <th style="width:100px; text-align: center" > Data </th>
                                    <th style="width:170px; text-align: center" > Documento </th>
                                    <th style="width:170px; text-align: center"> Tipo </th>
                                    <th style="width:80px; text-align: center"> Parcela </th>
                                    <th style="width:100px; text-align: center"> Valor </th>
                                    <th colspan=3 style="width:400px; text-align: center"> Conta </th>
                                </tr>
                                <tr>
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                	<th style="width:100px; text-align: center"> Nome </th>
                                	<th style="width:200px; text-align: center"> Descrição </th>
                                	<th style="width:100px; text-align: center"> Tipo </th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                                <?php
                                
                                if($info){
                                foreach ($info as $i) {
                                    ?>
                                    <tr>
                                    	<input type="hidden" id="<?= $i->document_description?>" name="document_description" />
                                        <td><?= $i->posting_date ?></td>
                                        <td><?= $i->document_type ?></td>
                                        <td><?= $i->posting_type ?></td>
                                        <td><?= $i->portion ?>/<?= $portions[$i->document_expense_id]?></td>
                                        <td><?= $i->posting_value ?></td>
                                        <td><?= $i->account_name ?></td>
                                        <td><?= $i->account_description ?></td>
                                        <td><?= $i->account_type ?></td>
                                    </tr>
                                    <?php
                                }}
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </body>
</html>