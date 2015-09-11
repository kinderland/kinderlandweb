<div class = "row">
    <?php $actual_screen = "COLONIA"; ?>
    <?php 
        require_once APPPATH . 'core/menu_helper.php';
        require_once renderMenu($permissions); 
    ?>
    
    <script type="text/javascript">
        $(function() {
            $( "#spinner" ).spinner();
        } 
        
        function openRoomDisposal( roomFilter ) {
            if($("#anos").val() != null && $("#colonia").val() != 0 && $("#pavilhao").val() != "") {
                $("#room").val(roomFilter);
                $("#form_selection").submit();
            } else {
                alert("Preencha todas as caixas de seleção no topo da tela para seguir");
            }
        }

    </script>

    <div class = "row">
        <div class="col-lg-12">
            <form id="form_selection" method="POST">
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
                <select name="colonia_f" id="colonia">
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
                <select name="pavilhao" id="pavilhao">
                    <option value="" <?php if(!isset($pavilhao)) echo "selected"; ?>> Selecionar </option>
                    <option value="M" <?php if(isset($pavilhao) && $pavilhao == "M") echo "selected"; ?>> Masculino </option>
                    <option value="F" <?php if(isset($pavilhao) && $pavilhao == "F") echo "selected"; ?>> Feminino </option>
                </select>

                <input type="hidden" id="room" name="quarto" value = "<?= (isset($quarto)) ? $quarto : '' ?>" />

                <br /><br />

                <button class="btn btn-primary" style="margin-left:5px" onclick="openRoomDisposal(0)"> Sem Quarto </button>
                <button class="btn btn-primary" style="margin-left:5px" onclick="openRoomDisposal(1)"> Quarto 1 </button>
                <button class="btn btn-primary" style="margin-left:5px" onclick="openRoomDisposal(2)"> Quarto 2 </button>
                <button class="btn btn-primary" style="margin-left:5px" onclick="openRoomDisposal(3)"> Quarto 3 </button>
                <button class="btn btn-primary" style="margin-left:5px" onclick="openRoomDisposal(4)"> Quarto 4 </button>
                <button class="btn btn-primary" style="margin-left:5px" onclick="openRoomDisposal(5)"> Quarto 5 </button>
                <button class="btn btn-primary" style="margin-left:5px" onclick="openRoomDisposal(6)"> Quarto 6 </button>
                <button class="btn btn-primary"  onclick="openRoomDisposal(-1)"> Todos os quartos </button>

            </form>
        </div>

        <?php if(isset($colonists)) { ?>

            <br /><br />
            <table class="table table-bordered table-striped table-min-td-size" style="max-width: 800px; font-size:15px" id="sortable-table">
                <thead>
                    <tr>
                        <th> Colonista </th>
                        <th> Idade </th>
                        <th> Escola </th>
                        <th> Amigo 1 </th>
                        <th> Amigo 2 </th>
                        <th> Amigo 3 </th>
                        <th> Amigos no quarto </th>
                        <th> Quarto </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($colonists as $colonist) { ?>
                        <tr>
                            <td><?= $colonist->colonist_name ?></td>
                            <td><?= $colonist->age ?></td>
                            <td><?= $colonist->school_name ?></td>
                            <td><?= $colonist->roommate1 ?></td>
                            <td><?= $colonist->roommate2 ?></td>
                            <td><?= $colonist->roommate3 ?></td>
                            <td><?= 0 ?></td>  
                            <td><input id="spinner" name="colonist_room_<?= $colonist->colonist_id ?>"></td>  
                        </tr>                                   
                    <?php } ?>  
                </tbody>
            </table>

        <?php } ?>
    </div>

</div>