    <div class = "row">
    <?php $actual_screen = "COLONIA"; ?>
    <?php require_once APPPATH . 'views/include/director_left_menu.php' ?>
        <script>
            $(function() {
                $("#sortable-table").tablesorter({widgets: ['zebra']});
                $(function() {
                    $( ".datepicker" ).datepicker({
                        showOn: "button",
                        dateFormat: "yy-mm-dd",
                        buttonImage: "<?= $this->config->item('assets'); ?>images/calendar.gif",
                        buttonImageOnly: true,
                        buttonText: "Selecionar data"
                    });
                });
            });

            function validateInfo() {
                var formValid = true;
                var alertMsg = "Os seguintes campos estão inválidos:";

                if($("#camp_name").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nNome da colônia";
                }

                if($("#date_start").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nData início da colônia";
                }

                if($("#date_finish").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nData fim da colônia";
                }

                if($("#date_start_pre").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nData início das pré-inscrições";
                }

                if($("#date_finish_pre").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nData fim das pré-inscrições";
                }

                if(isNaN($("#capacity_male").val()) || $("#capacity_male").val() <= 0){
                    formValid = false;
                    alertMsg = alertMsg + "\nVagas Masculino";
                }
                if(isNaN($("#capacity_female").val()) || $("#capacity_female").val() <= 0){
                    formValid = false;
                    alertMsg = alertMsg + "\nVagas Feminino";
                }

                if(formValid)
                    $("#form_insert_camp").submit();
                else
                    alert(alertMsg);
            }
        </script>
        <div class="col-lg-9 middle-content">
            <div class="row">
                <div class="col-lg-6">
                    <h3> Criar colônia </h3>
                </div>
            </div>
            <div class="row">
                &nbsp;
            </div>
            <form name="form_insert_camp" method="POST" action="<?=$this->config->item('url_link')?>admin/insertNewCamp" id="form_insert_camp">
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label for="camp_name" class="col-lg-2 control-label"> Nome da colônia: </label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control"
                                name="camp_name" id="camp_name"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    &nbsp;
                </div>
                <div class="row">    
                    <div class="col-lg-12 form-group">
                        <label for="date_start" class="col-lg-2 control-label"> Data Início: </label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_start" id="date_start"/>
                        </div>

                        <label for="date_finish" class="col-lg-2 control-label"> Data Fim: </label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_finish" id="date_finish"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    &nbsp;
                </div>
                <div class="row">
                    <div class="col-lg-4 form-group">
                        Número máximo de colonistas:
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label for="capacity_male" class="col-lg-2 control-label"> Masculino: </label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" name="capacity_male" id="capacity_male" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label for="capacity_female" class="col-lg-2 control-label"> Feminino: </label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" name="capacity_female" id="capacity_female" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    &nbsp;
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        Período de pré-inscrições para associados:
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label for="date_start_pre_associate" class="col-lg-2 control-label"> Data Início: </label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_start_pre_associate" id="date_start_pre_associate"/>
                        </div>

                        <label for="date_finish_pre_associate" class="col-lg-2 control-label"> Data Fim: </label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_finish_pre_associate" id="date_finish_pre_associate"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    &nbsp;
                </div>

                <div class="row">
                    <div class="col-lg-4 form-group">
                        Período de pré-inscrições:
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label for="date_start_pre" class="col-lg-2 control-label"> Data Início: </label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_start_pre" id="date_start_pre"/>
                        </div>

                        <label for="date_finish_pre" class="col-lg-2 control-label"> Data Fim: </label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_finish_pre" id="date_finish_pre"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    &nbsp;
                </div>
                <div class="row">
                    &nbsp;
                </div>
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-primary" onClick="validateInfo()">Confirmar</button>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-warning" onClick="history.back(-1)">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
        