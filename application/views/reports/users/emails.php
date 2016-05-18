<script type="text/javascript">

	$(document).ready(function() {
		$('#sortable-table').tablesorter();
	});

	function comparaPorData(l, r) {
		var a = arrumaData(l);
		var b = arrumaData(r);
		return a.toLowerCase().localeCompare(b.toLowerCase());
	}

	function showEmailMessage(time, subject, message) {
		$("#time_sent").html(time);
		$("#subject").html(subject);
		$("#msg_body").html(message);
	}

</script>

<div class="row">
	<div class="col-lg-12">

		<div class="row">
			<div class="col-lg-10">
				<h3> Detalhamento de emails enviados para: <?= $person->getFullname() ?> </h3>
			</div>
			<div class="col-lg-2">
				<a href="<?=$this->config->item('url_link');?>admin/writeEmail/<?=$person->getPersonId()?>">
			<!-- 		<button class="btn btn-primary" style="float:right"> Escrever e-mail </button> -->
				</a>
			</div>
		</div>
		<table class="table table-bordered tablesorter table-striped table-min-td-size" id="sortable-table">
			<thead>
				<tr>
					<th> Data de envio </th>
					<th> Assunto </th>
					<th> Enviado </th>
					<th> Ações </th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($emails as $email) {
					$contentSplit = explode("Body:", $email->content);
					$subject = $contentSplit[0];
					$emailBody = $contentSplit[1];
				?>
				<tr>
					<td><?= $email->date_sent ?></td>
					<td><?= $subject ?></td>
					<td><?php if($email->successfully_sent == 't' || $email->successfully_sent == true){
						echo '<img src="' . $this -> config -> item('assets') . 'images/payment/greenicon.png" width="20px" height="20px"/>';
					} else {
						echo '<img src="' . $this -> config -> item('assets') . 'images/payment/redicon.png" width="20px" height="20px"/>';
					} ?></td>
					<td><button class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="showEmailMessage('<?=$email->date_sent ?>', '<?= $subject ?>', '<?=str_replace("\n", "", $emailBody);?>');"> Ler mensagem </button></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>

		<button class="btn btn-warning" style="margin-right:40px" onClick="history.back(-1)">Voltar</button>


		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="solicitar-convite" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modal_title">Detalhes da mensagem</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 middle-content">			
								<div class="row">
									<div class="form-group">
										<div class="col-lg-12">
											<h5> <strong>Enviado para:</strong> <?= $person->getEmail(); ?> </h5>
											<h5> <strong>Horário de envio:</strong> <span id="time_sent"></span></h5>
											<h5> <strong>Assunto:</strong> <span id="subject"></span></h5>
											<p> 
												<strong>Mensagem:</strong> <br /><br />
												<span id="msg_body"></span>
											</p>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>