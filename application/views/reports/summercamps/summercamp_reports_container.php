<div class = "row">
    <?php $actual_screen = "COLONIA"; ?>
    <?php 
        require_once APPPATH . 'core/menu_helper.php';
        require_once renderMenu($permissions); 
    ?>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/select.box.iframe.js"></script>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-8">
                <select class="report-select" name="report_select" id="report_select">
                	<?php if (in_array(SYSTEM_ADMIN, $permissions) || in_array(SECRETARY, $permissions) || in_array(DIRECTOR, $permissions) || in_array(COORDINATOR, $permissions) || in_array(DOCTOR, $permissions)){ ?>
                    <option value="<?= $this->config->item('url_link');?>reports/all_registrations">Estatísticas de Inscrições por Status</option>
                	<option selected="selected" value="<?= $this->config->item('url_link'); ?>reports/statistics_bycamp">Estatísticas de Inscrições por Turma</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/registrations_deleted">Estatísticas de Inscrições Descartadas</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/colonist_registered">Listagem de Inscrições</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/colonists_byschool">Colonistas por Escola</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/colonist_byage">Colonistas por Idade</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/colonists_byassociated">Inscrições por Sócio</option>
                	<!-- <option value="<?= $this->config->item('url_link'); ?>reports/subscriptions_bycamp">Pré-inscrições por Colônia</option> -->
                	<option value="<?= $this->config->item('url_link'); ?>reports/parents_notregistered">Pais Cadastrados por Colonista</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/responsables_notparents">Responsáveis que não são os Pais</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/same_parents">Responsáveis com mais de um Colonista</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/subscriptions_notsubmitted">Pré-inscrições não Enviadas</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/multiples_subscriptions">Inscrições Múltiplas</option>
                	<?php } ?>
                	<option value="<?= $this->config->item('url_link'); ?>reports/rooms">Quartos</option>
                	<option value="<?php echo $this->config->item('url_link'); ?>reports/staff">Equipe</option>
                	 <?php if (in_array(SYSTEM_ADMIN, $permissions)){ ?>
                	<option value="<?= $this->config->item('url_link'); ?>reports/discounts">Descontos</option>
                	<?php } ?>
                	 <?php if (in_array(SYSTEM_ADMIN, $permissions) || in_array(SECRETARY, $permissions)|| in_array(COORDINATOR, $permissions)){ ?>
                	<option value="<?= $this->config->item('url_link'); ?>reports/queue">Fila de Espera por Turma e Pavilhão</option>
                	<?php } ?>
                	<?php //Ainda terminando de fazer<option value="<?= $this->config->item('url_link'); reports/colonist_exclusion">Cancelamentos e Exclusões</option> ?>
                	<!-- <option value="<?php // $this->config->item('url_link'); ?>reports/colonist_exclusion">Cancelamentos e exclusões</option>-->
                </select>
            </div>
        </div>
        <hr class="footer-hr" />

        <div class="row">
            <iframe class="frame-section" src="<?= $this->config->item('url_link'); ?>reports/all_registrations"/></iframe>
        </div>
    </div>

</div>


  