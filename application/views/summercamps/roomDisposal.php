<div class = "row">
    <script type="text/javascript"> 

        var selectTodas = {
                element : null,
                values : "auto",
                empty : "Todas",
                multiple : false,
                noColumn : false,
            }
        
        var selectTodos = {
                element : null,
                values : "auto",
                empty : "Todos",
                multiple : false,
                noColumn : false,
            }
        
        function sortLowerCase(l, r) {
            return l.toLowerCase().localeCompare(r.toLowerCase());
        }

        
        $(document).ready(function() {
            $('#sortable-table').datatable({
                pageSize : Number.MAX_VALUE,
                sort : [sortLowerCase, sortNumber, sortLowerCase],
                filters : [true, selectTodas, true],
                filterText : 'Escreva para filtrar...'
            });
            
            if($("#room").val() != null)
                $("#btn_room_"+$("#room").val()).switchClass("btn-default", "btn-primary");
        });

        function openDisposal(){
            if($("#pavilhao").val() != "")
                $(".btn_room_row").show();
            else
                $(".btn_room_row").hide();

            if($("#anos").val() != null && $("#colonia").val() != 0 && $("#pavilhao").val() != "" && $("#room").val != "") {
                $("#form_selection").submit();
            }
        }

        function openRoomDisposal( roomFilter ) {
            if($("#anos").val() != null && $("#colonia").val() != 0 && $("#pavilhao").val() != "") {
                $("#room").val(roomFilter);
                $("#form_selection").submit();
            } else {
                alert("Preencha todas as caixas de seleção no topo da tela para seguir");
            }
        }

        function saveRoomNumber(colonistId, summerCampId){
            var roomNumber = $("#colonist_room_"+colonistId+"_"+summerCampId).val();
            if(roomNumber == "" || roomNumber == null || !(roomNumber > 0 && roomNumber <= 6)){
                alert("Número do quarto inválido. Favor entrar com números de 1 até 6.");
                return 0;
            } else {
                $.post("<?= $this->config->item('url_link') ?>summercamps/updateRoomNumber",
                    {
                        'colonist_id': colonistId,
                        'summer_camp_id': summerCampId,
                        'room_number': roomNumber
                    },
                    function (data) {
                        if (data == "true") {
                            window.location.reload();
                            //alert("Alteração de quarto gravada com sucesso!");
                        } else {
                            alert("Ocorreu um erro ao gravar a alteração de quarto.");
                        }
                    }
                );
            }
        }

        function autoDistribute(summerCampId, gender) {
            if(confirm("O sistema irá distribuir os colonistas automaticamente, por idade.\n\nAtenção: se já houver colonista(s) em quarto(s). Ao prosseguir, todos serão redistribuidos. Confirma?")){
                $.post("<?= $this->config->item('url_link') ?>summercamps/autoFillRooms",
                    {
                        'summer_camp_id': summerCampId,
                        'gender': gender
                    },
                    function (data) {
                        if (data == "true") {
                            window.location.reload();
                            //alert("Alteração de quarto gravada com sucesso!");
                        } else {
                            alert("Ocorreu um erro ao auto distribuir colonistas.");
                        }
                    }
                );
            }
            
        }

        function sortNumber(a,b) {
            return a-b;
        }

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

        function getCSVName(type) {
            var filtroColonia = $("#colonia option:selected").text();
            var filtroGenero = $("#pavilhao option:selected").text();
            var filtroGeneroVal = $("#pavilhao option:selected").val();
            var filtroQuarto = $("#room").val();
            var nomePadrao = type.concat("-");

            if(filtroQuarto == 0)
                filtroQuarto = "Sem-Quarto".concat(filtroGenero);
            else if(filtroQuarto == -1)
                filtroQuarto = "Todos-os-Quartos".concat(filtroGenero);
            else {
                filtroQuarto = filtroQuarto.concat(filtroGeneroVal);
            }   

            nomePadrao = nomePadrao.concat(filtroQuarto);
            nomePadrao = nomePadrao.concat("-");    
            return nomePadrao.concat(filtroColonia);            
        }

        function sendTableToCSV() {
            var data = [];
            var table = document.getElementById("tablebody");
            var name = getCSVName('DistQuarto');
            for (var i = 0, row; row = table.rows[i]; i++) {
                var data2 = []
                //Nome, retira pega o que esta entre um <> e outro <>
                
                data2.push(row.cells[0].innerHTML.split("<")[1].split(">")[1]);
                data2.push(row.cells[1].innerHTML);
                data2.push(row.cells[2].innerHTML);
                data2.push(row.cells[3].innerHTML);
                data2.push(row.cells[4].innerHTML.split("<")[1].split(">")[1]);
                data2.push(row.cells[5].innerHTML.split("<")[1].split(">")[1]);
                data2.push(row.cells[6].innerHTML.split("<")[1].split(">")[1]);
                data2.push(row.cells[7].innerHTML);
                data2.push(row.cells[8].innerHTML.split('value="')[1].split('"')[0]);
                data.push(data2);
            }
            if (i == 0) {
                alert('Não há dados para geração da planilha');
                return;
            }
            var dataToSend = JSON.stringify(data);
            var columName = ["Colonista", "Idade", "Escola", "Ano Escolar", "Amigo 1", "Amigo 2", "Amigo 3", "Amigos no quarto", "Quarto"];
            var columnNameToSend = JSON.stringify(columName);

            post('<?= $this->config->item('url_link'); ?>reports/toCSV', {data: dataToSend, name: name, columName: columnNameToSend});
        }
    </script>

    <style>
        .T { color: green; }
        .TF, .TF1M, .TF2M, .TF3M, .TF4M, .TF5M, .TF6M, .TF1F, .TF2F, .TF3F, .TF4F, .TF5F, .TF6F { color: brown; }
        .F { color: red; }
    </style>
    <div class = "col-lg-12">
        <div class = "row">
            <div class="col-lg-11">
                <form id="form_selection" method="GET">
                    <select name="ano_f" id="anos">
                
                        <?php
                        foreach ( $years as $year ) {
                            $selected = "";
                            if ($ano_escolhido == $year)
                                $selected = "selected";
                            echo "<option $selected value='$year'>$year</option>";
                        }
                        ?>
                    </select>
                    <select name="colonia_f" id="colonia" onchange="openDisposal()">
                        <option value="0" <?php if(!isset($colonia_escolhida)) echo "selected"; ?>>Selecionar</option>
                        <?php
                        foreach ( $camps as $camp ) {
                            $selected = "";
                            if ($colonia_escolhida == $camp)
                                $selected = "selected";
                            echo "<option $selected value='$camp'>$camp</option>";
                        }
                        ?>
                    </select>
                    <select name="pavilhao" id="pavilhao" onchange="openDisposal()">
                        <option value=""  <?php if(!isset($pavilhao)) echo "selected"; ?>> Selecionar </option>
                        <option value="M" <?php if(isset($pavilhao) && $pavilhao == "M") echo "selected"; ?>> Masculino </option>
                        <option value="F" <?php if(isset($pavilhao) && $pavilhao == "F") echo "selected"; ?>> Feminino </option>
                    </select>

                    <input type="hidden" id="room" name="quarto" value = "<?= (isset($quarto)) ? $quarto : '' ?>" />

                    <br /><br />

                    <div class="btn_room_row" style="<?= ((isset($quarto))?'':'display:none')?>" >
                        <table>
                            <tr>
                                <th> <button class="btn btn-default" id="btn_room_0" style="margin-left:5px" onclick="openRoomDisposal(0)"> Sem Quarto </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_1" style="margin-left:5px" onclick="openRoomDisposal(1)"> 1<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_2" style="margin-left:5px" onclick="openRoomDisposal(2)"> 2<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_3" style="margin-left:5px" onclick="openRoomDisposal(3)"> 3<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_4" style="margin-left:5px" onclick="openRoomDisposal(4)"> 4<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_5" style="margin-left:5px" onclick="openRoomDisposal(5)"> 5<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_6" style="margin-left:5px" onclick="openRoomDisposal(6)"> 6<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_-1" onclick="openRoomDisposal(-1)"> Todos os quartos </button> </th>
                            </tr>
                            <?php if(isset($room_occupation)){ ?>
                                <tr>
                                    <td align="center"><?=$room_occupation[0] ?></td>
                                    <td align="center"><?=$room_occupation[1] ?></td>
                                    <td align="center"><?=$room_occupation[2] ?></td>
                                    <td align="center"><?=$room_occupation[3] ?></td>
                                    <td align="center"><?=$room_occupation[4] ?></td>
                                    <td align="center"><?=$room_occupation[5] ?></td>
                                    <td align="center"><?=$room_occupation[6] ?></td>
                                    <td align="center"><?= $room_occupation[1]+
                                            $room_occupation[2]+
                                            $room_occupation[3]+
                                            $room_occupation[4]+
                                            $room_occupation[5]+
                                            $room_occupation[6] ?>
                                        <img src="<?= $this->config->item('assets') ?>images/kinderland/help.png" width="15" height="15"
                                            title="Número de colonistas por quarto."/>
                                    <td>
                                    
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
            

                </form>
            </div>

            <div class="col-lg-1">
                <?php if(isset($pavilhao)&&isset($colonia_escolhida)){ ?>
                    <button class="btn btn-info" onclick="autoDistribute(<?= $summer_camp_id ?>, '<?= $pavilhao ?>')"> Auto distribuir </button>
                <?php } ?>
            </div>
        </div>

        <?php if(isset($colonists)) { ?>
            <div class = "row">
                <br /><br />

                <div class="col-lg-12">
                    
                    <p>
                        Código de cores:
                        <br /><br />
                        <span class="T">Verde: Amigo encontrado e alocado no mesmo quarto</span><br />
                        <span class="TF">Marrom: Amigo encontrado e alocado em quartos diferentes ou sem quartos</span><br />
                        <span class="F">Vermelho: Amigo não encontrado no sistema</span><br />
                    </p>

                    <button class="btn btn-primary" onclick="sendTableToCSV()">Exportar para CSV</button>
                    <br /><br />
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 800px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Colonista </th>
                                <th> Idade </th>
                                <th> Escola </th>
                                <th> Ano Escolar </th>
                                <th> Amigo 1 </th>
                                <th> Amigo 2 </th>
                                <th> Amigo 3 </th>
                                <th> Amigos no quarto </th>
                                <th> Quarto </th>
                                <th> Ações </th>
                            </tr>
                        </thead>
                        <script>
                        function editName(colonistId,summerCampId,roommate1, roommate2, roommate3, number){
							if(number == 1)
                        		roommate1 = prompt("Digite o nome correto:",roommate1);
							else if(number == 2)
								roomate2 = prompt("Digite o nome correto:",roommate2);
							else
								roommate3 = prompt("Digite o nome correto:",roommate3);
                        	
                        	$.post("<?= $this->config->item('url_link'); ?>summercamps/updateRoommate",
                        				{ colonist_id: colonistId, summer_camp_id: summerCampId, roommate1: roommate1, roommate2: roommate2, roommate3: roommate3 },
                        				function(data){
                            				if(data=="true"){
                                				alert("Deu certo");
                                				location.reload();
                            				}
                            				else{
                                				alert("Deu errado");
                                				location.reload();
                            				}
                        				}
                        	);
                        }
                                				
                        										
                        </script>
                        
                        <tbody id="tablebody">
                            <?php foreach ($colonists as $colonist) { ?>
                                <tr>
                                    <td><a name= "colonista" id="<?= $colonist->colonist_name ?>" key="<?= $colonist->colonist_id ?>" target="_blank" href="<?= $this->config->item('url_link'); ?>admin/viewColonistInfo?type=report&colonistId=<?= $colonist->colonist_id ?>&summerCampId=<?= $colonist->summer_camp_id ?>"><?= $colonist->colonist_name ?></a></td>
                                    <td><?= explode(" ", $colonist->age)[0]?></td>
                                    <td><?= $colonist->school_name ?></td>
                                    <td><?= $colonist->school_year ?></td>
                                    <?php 
                                    if($colonist->roommate1_status == "F"){
                                    ?>
                                   	<td><span class="<?=$colonist->roommate1_status ?>"><?= $colonist->roommate1 ?> <?=(($colonist->roommate1_status != "T" && $colonist->roommate1_status != "F" && $colonist->roommate1_status != "TF")?"<br />[".substr($colonist->roommate1_status, 2, 2)."]":'')?><br><button class="btn btn-primary"  onclick=" editName('<?php echo $colonist->colonist_id;?>', '<?php echo $colonist->summer_camp_id;?>', '<?php echo $colonist->roommate1;?>', '<?php echo $colonist->roommate2;?>', '<?php echo $colonist->roommate3;?>', 1)">Editar</button>
                                    <?php }else{?>
                                    <td><span class="<?=$colonist->roommate1_status ?>"><?= $colonist->roommate1 ?> <?=(($colonist->roommate1_status != "T" && $colonist->roommate1_status != "F" && $colonist->roommate1_status != "TF")?"<br />[".substr($colonist->roommate1_status, 2, 2)."]":'')?>
                                    <?php }?>
                                    <?php 
                                    if($colonist->roommate2_status == "F"){
                                    ?>
                                    <td><span class="<?=$colonist->roommate2_status ?>"><?= $colonist->roommate2 ?> <?=(($colonist->roommate2_status != "T" && $colonist->roommate2_status != "F" && $colonist->roommate2_status != "TF")?"<br />[".substr($colonist->roommate2_status, 2, 2)."]":'')?><br><button class="btn btn-primary"  onclick=" editName('<?php echo $colonist->colonist_id;?>', '<?php echo $colonist->summer_camp_id;?>', '<?php echo $colonist->roommate1;?>', '<?php echo $colonist->roommate2;?>', '<?php echo $colonist->roommate3;?>', 2)">Editar</button>
                                    <?php }else{?>
                                    <td><span class="<?=$colonist->roommate2_status ?>"><?= $colonist->roommate2 ?> <?=(($colonist->roommate2_status != "T" && $colonist->roommate2_status != "F" && $colonist->roommate2_status != "TF")?"<br />[".substr($colonist->roommate2_status, 2, 2)."]":'')?></span></td>
                                    <?php }?>
                                    <?php if($colonist->roommate3_status == "F"){
                                    ?>
                                    <td><span class="<?=$colonist->roommate3_status ?>"><?= $colonist->roommate3 ?> <?=(($colonist->roommate3_status != "T" && $colonist->roommate3_status != "F" && $colonist->roommate3_status != "TF")?"<br />[".substr($colonist->roommate3_status, 2, 2)."]":'')?><br><button class="btn btn-primary"  onclick=" editName('<?php echo $colonist->colonist_id;?>', '<?php echo $colonist->summer_camp_id;?>', '<?php echo $colonist->roommate1;?>', '<?php echo $colonist->roommate2;?>', '<?php echo $colonist->roommate3;?>', 3)">Editar</button>	
                                    <?php }else{?>
                                    <td><span class="<?=$colonist->roommate3_status ?>"><?= $colonist->roommate3 ?> <?=(($colonist->roommate3_status != "T" && $colonist->roommate3_status != "F" && $colonist->roommate3_status != "TF")?"<br />[".substr($colonist->roommate3_status, 2, 2)."]":'')?></span></td>
                                    <?php }?>
                                    <td><?= $colonist->friend_roommates ?></td>  
                                    <td><input type="number" min="0" max="6" style="width:40px!important" value="<?= $colonist->room_number ?>" id="colonist_room_<?= $colonist->colonist_id ?>_<?= $colonist->summer_camp_id ?>"></td>  
                                    <td><button class="btn btn-primary" onclick="saveRoomNumber(<?= $colonist->colonist_id ?>,<?= $colonist->summer_camp_id ?>)">Salvar</button></td>
                                </tr>                                   
                            <?php } ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
        
    </div>
</div>
