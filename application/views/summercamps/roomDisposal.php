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
                sort : [sortLowerCase, true, sortLowerCase],
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

    </script>

    <style>
        .T { color: green; }
        .TF, .M1, .M2, .M3, .M4, .M5, .M6, .F1, .F2, .F3, .F4, .F5, .F6 { color: brown; }
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
                        <tbody>
                            <?php foreach ($colonists as $colonist) { ?>
                                <tr>
                                    <td><?= $colonist->colonist_name ?></td>
                                    <td><?= explode(" ", $colonist->age)[0] ." anos" ?></td>
                                    <td><?= $colonist->school_name ?></td>
                                    <td><?= $colonist->school_year ?></td>
                                    <td><span class="<?=$colonist->roommate1_status ?>"><?= $colonist->roommate1 ?> <?=(($colonist->roommate1_status != "T" && $colonist->roommate1_status != "F" && $colonist->roommate1_status != "TF")?"<br />[".$colonist->roommate1_status."]":'')?></span></td>
                                    <td><span class="<?=$colonist->roommate2_status ?>"><?= $colonist->roommate2 ?> <?=(($colonist->roommate2_status != "T" && $colonist->roommate2_status != "F" && $colonist->roommate2_status != "TF")?"<br />[".$colonist->roommate2_status."]":'')?></span></td>
                                    <td><span class="<?=$colonist->roommate3_status ?>"><?= $colonist->roommate3 ?> <?=(($colonist->roommate3_status != "T" && $colonist->roommate3_status != "F" && $colonist->roommate3_status != "TF")?"<br />[".$colonist->roommate3_status."]":'')?></span></td>
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