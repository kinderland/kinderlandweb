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

        function createPDFMedicalFiles() {
            window.location.href = "<?= $this->config->item('url_link'); ?>summercamps/generatePDFWithColonistMedicalFiles/<?=$ano_escolhido?>/<?=(isset($summer_camp_id)?$summer_camp_id:'')?>/<?=(isset($pavilhao)?$pavilhao:'')?>/<?=(isset($quarto)?$quarto:'')?>/varios";
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

                    <?php
                        if(isset($data_room) && is_array($data_room)){
                    ?>
                        <select name="pavilhao" id="pavilhao" onchange="openDisposal()">
                            <option value=""  <?php if(!isset($pavilhao)) echo "selected"; ?>> Selecionar </option>
                            <?php
                                foreach($data_room as $room){
                            ?>
                                <option value="<?=$room->room_number?>" <?php if(isset($quarto) && $quarto == "<?=$room->room_number?>") echo "selected"; ?>> <?=$room->room_number?> </option>
                            <?php
                                }
                            ?>
                        </select>
                    <?php
                        }
                    ?>
                    
                    </div>
                </form>
            </div>

        </div>

        <?php if(isset($colonists)) { ?>
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