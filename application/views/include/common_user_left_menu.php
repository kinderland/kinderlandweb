<div class="col-lg-2  left-action-bar">
    <ul class="nav nav-pills nav-stacked">
        <li><a href="<?= $this->config->item('url_link'); ?>user/edit">Cadastro</a></li>
        <li><a href="<?= $this->config->item('url_link'); ?>donations/freeDonation">Doação Avulsa</a></li>
        <li><a href="<?= $this->config->item('url_link'); ?>campaigns/index">Campanha de sócios</a></li>
        <?php if($this -> personuser_model -> isAssociateAndNotTemporary($this->session->userdata("user_id"))){?>
        	<li><a href="<?= $this->config->item('url_link'); ?>admin/createTemporaryAssociate">Indicar CPF</a></li>
        <?php }?>
        <li><a href="<?= $this->config->item('url_link'); ?>events/index">Inscrições MaCK</a></li>
        <li><a href="<?= $this->config->item('url_link'); ?>summercamps/indexm">Inscrições Colônia</a></li>
        <li><a href="<?= $this->config->item('url_link'); ?>payments/history">Histórico de doações</a></li>
      <li><a href="<?php echo $this->config->item('url_link'); ?>user/emails">Histórico de <br>e-mails</a></li>
    </ul>
</div>