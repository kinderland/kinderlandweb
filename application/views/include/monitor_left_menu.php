<script>
    $(function () {
        $("#accordion").accordion({
            collapsible: true
        });
        $("#accordion").accordion('option', 'active', 2);

    });
</script>
<div class="col-lg-3  left-action-bar">
    <div id="accordion">
        <h3>Usuários</h3>
        <div>
        </div>
        <h3>Campanha de sócios</h3>
        <div>
        </div>
        <h3>Colônia</h3>
        <div>
            <a href="<?= $this->config->item('url_link'); ?>summercamps/staffMedicalFile"> Ficha médica </a><br />
            <a href="<?= $this->config->item('url_link'); ?>summercamps/monitorRoom"> Quartos </a>
        </div>
        <h3>Eventos</h3>
        <div>

        </div>
        <h3>Financeiro</h3>
        <div>
            
        </div>
        <h3>Sistema</h3>
        <div>
            
        </div>
    </div>
</div>