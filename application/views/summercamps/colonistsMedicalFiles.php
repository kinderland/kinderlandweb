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
            $("#room").val(roomFilter);
            if($("#anos").val() != null && $("#colonia").val() != 0 && $("#pavilhao").val() != "") {
                $("#form_selection").submit();
            } else {
                alert("Preencha todas as caixas de seleção no topo da tela para seguir");
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
        
        function createPDFMedicalFiles() {
            window.location.href = "<?= $this->config->item('url_link'); ?>summercamps/generatePDFWithColonistMedicalFiles/<?=$ano_escolhido?>/<?=$summer_camp_id?>/<?=$pavilhao?>/<?=$quarto?>";
        }


        $(document).ready(function() {
            $('#sortable-table').datatable({
                pageSize : Number.MAX_VALUE,
                sort : [sortLowerCase],
                filters : [true],
                filterText : 'Escreva para filtrar...'
            });
            
            if($("#room").val() != null)
                $("#btn_room_"+$("#room").val()).switchClass("btn-default", "btn-primary");
        });

    </script>
    <?php require_once APPPATH . "views/include/doctor_left_menu.php"; ?>
    <div class = "col-lg-9">
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

        </div>

        <?php if(isset($colonists)) { ?>
            <br /><br />
            <button class="btn btn-primary" onclick="createPDFMedicalFiles()" value="">PDF com fichas médicas</button>
            <br /><br />
            <table class="table table-bordered table-striped table-min-td-size" style="max-width: 700px; font-size:15px" id="sortable-table">
                <thead>
                    <tr>
                        <th>Nome do Colonista</th>
                        <th>Quarto</th>
                    </tr>
                </thead>
                <tbody id="tablebody">
                    <?php
                    foreach ($colonists as $colonist) {
                        ?>
                        <tr>
                            <td><a name= "colonista" id="<?= $colonist->colonist_name ?>" key="<?= $colonist->colonist_id ?>" target="_blank" href="<?= $this->config->item('url_link') ?>summercamps/viewMedicalFile/<?= $colonist->colonist_id ?>/<?= $colonist->summer_camp_id ?>"><?= $colonist->colonist_name ?></a></td>
                            <td><?= $colonist->room_number ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>