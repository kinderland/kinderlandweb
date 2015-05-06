
<script>
	$(function() {
		$( "#accordion" ).accordion({
	        collapsible: true
		});
	});
</script>
<div class="col-lg-2  left-action-bar">
	<div id="accordion">
		<h3>Usuários</h3>
		<div>
			<a href="#">
				Administração
			</a>
			<br />
			<a href="<?= $this->config->item('url_link'); ?>reports/user_reports">
				Relatórios
			</a>
		</div>
		<h3>Campanha de sócios</h3>
		<div>
			
		</div>
		<h3>Colônia</h3>
		<div>

		</div>
		<h3>Eventos</h3>
		<div>
			
		</div>
		<h3>Financeiro</h3>
		<div>
			Administração <br />
			<a href="<?= $this->config->item('url_link'); ?>reports/finance_reports">Relatórios</a>
		</div>
	</div>
</div>