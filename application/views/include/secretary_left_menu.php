<script>
    $(function () {
        $("#accordion").accordion({
            collapsible: true
        });
<?php if (isset($actual_screen)) { ?>
            switch ("<?= $actual_screen ?>") {
                case "USUARIOS":
                    $("#accordion").accordion('option', 'active', 0);
                    break;
                case "CAMPANHA_ASSOCIADOS":
                    $("#accordion").accordion('option', 'active', 1);
                    break;
                case "COLONIA":
                    $("#accordion").accordion('option', 'active', 2);
                    break;
                case "EVENTOS":
                    $("#accordion").accordion('option', 'active', 3);
                    break;
                case "FINANCEIRO":
                    $("#accordion").accordion('option', 'active', 4);
                    break;
            }

<?php } ?>

    });
</script>
<div class="col-lg-3  left-action-bar">
    <div id="accordion">
        <h3>Usuários</h3>
        <div>
            <a href="<?= $this->config->item('url_link'); ?>reports/user_reports">
                Relatórios
            </a>
        </div>
        <h3>Campanha de sócios</h3>
        <div>
            <a href="<?= $this->config->item('url_link'); ?>reports/associated_campaign">
                Relatórios
            </a>
        </div>
        <h3>Colônia</h3>
        <div>
            <a href="<?= $this->config->item('url_link'); ?>admin/camp">
                Administração
            </a>
            <br />
            <a href="<?= $this->config->item('url_link'); ?>reports/camp_reports"> Relatórios</a>
        </div>
        <h3>Eventos</h3>
        <div>

        </div>
    </div>
</div>