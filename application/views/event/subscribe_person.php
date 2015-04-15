<script type="text/javascript" charset="utf-8">

    $("document").ready(function () {
        var peopleJson = <?= $peoplejson ?>;

        $("#box_options").change(function () {
            var person = peopleJson[parseInt($("#box_options").val())];
            if (person != null) {
                $("#fullname").val(person.fullname);
                $("#gender").val(person.gender.toUpperCase());
                $("#person_id").val(person.personId);
            }
            else {
                $("#fullname").val("");
                $("#gender").val("");
                $("#person_id").val("");
            }

        });
    });

    function validateFormInfo() {
        // TODO: Validate info

        $("#form_subscribe").submit();
    }

</script>

<div class="row">
    <?php require_once APPPATH . 'views/include/common_user_left_menu.php' ?>
    <div class="col-lg-10 middle-content">
        <div class="row">
            <div class="col-lg-8"><h4>Inscrição de pessoa no evento: <?= $event->getEventName() ?></h4></div>
        </div>
        <hr />

        <?php if (isset($people) && is_array($people) && count($people) > 0) { ?>
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="box_options" class="col-lg-3 control-label"> Opções de pessoas: </label>
                    <div class="col-lg-6">
                        <select class="form-control" id="box_options" name="box_options">
                            <option value="" selected>-- Selecione --</option>
                            <?php
                            $i = 0;
                            foreach ($people as $person) {
                                ?>
                                <option value="<?= $i++ ?>"><?= $person->getFullname() ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <br />
        <?php } ?>

        <form name="form_subscribe" method="POST" action="<?= $this->config->item('url_link') ?>events/subscribePerson" id="form_subscribe">
            <div class="row">
                <input type="hidden" id="event_id" name="event_id" value="<?= $event->getEventId() ?>" />
                <input type="hidden" id="user_id" name="user_id" value="<?= $user_id ?>" />
                <input type="hidden" id="person_id" name="person_id" value="" />
                <div class="form-group">
                    <label for="fullname" class="col-lg-1 control-label"> Nome Completo: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Nome Completo"
                               name="fullname" id="fullname"/>
                    </div>

                    <label for="gender" class="col-lg-1 control-label"> Sexo: </label>
                    <div class="col-lg-3">
                        <select class="form-control" id="gender" name="gender" >
                            <option value="" selected>-- Selecione --</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-lg-4">
                        <p>
                            <label for="associate" class="control-label"> Dependente de sócio: </label>
                            <input type="checkbox" class="" name="associate" id="associate"/>
                        </p>
                    </div>

                    <label for="age_group" class="col-lg-1 control-label"> Faixa Etária: </label>
                    <div class="col-lg-3">
                        <select class="form-control" id="age_group" name="age_group" >
                            <option value="" selected>-- Selecione --</option>
                            <?php
                            foreach ($age_group as $group) {
                                echo "<option value='" . $group->age_group_id . "'>" . $group->description . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <br /><br /><br />

                <div class="form-group">
                    <div class="col-lg-10">
                        <button class="btn btn-primary" style="margin-right:40px" onClick="validateFormInfo()">Solicitar convite</button>
                        <button class="btn btn-warning">Voltar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
