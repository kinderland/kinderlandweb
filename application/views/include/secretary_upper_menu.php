<script>
    $(function () {
        $('#nav li a').click(function () {
            $('#nav li').removeClass();
            $($(this).attr('href')).addClass('active');
        });
    });
</script>
<style type="text/css">
    li:hover { /*Trocar a cor das opções principais ao passar o mouse por cima */
        background:#c2c2d6;


    }
    li:hover ul {  /*Faz as opções cairem direto da navbar ao passar o mouse ( não precisa clicar) */
        display: block;
    }


    ul.nav a:hover{ /*Muda coisas quando passa o mouse por cima de alguma opção */
        background:#c2c2d6;
        color:#000000;
        border-color:#cc0000;
        border-width:1px;
    }
    li a.active { /* Troca a cor da opção da navbar correspondente ao link atual */
        background-color:#BDBDBD;}

    ul li a.not-active { /*Para quando não quiser que o link seja acessado */
        pointer-events: none;
    }
</style>
<body>
    <nav class = " navbar navbar-default" style = "width:800px;margin-left:15%" >

        <div class = "container-fluid" >
            <div  id="nav">
                <?php
                $paginaLink = $_SERVER['PHP_SELF'];
                $extra = '"';
                ?>
                <ul class = "nav navbar-nav" >
                    <li class = "dropdown" >
                        <a  <?php
                        if ($paginaLink == "/index.php/reports/user_reports") {
                            echo 'class="link active';
                        } else {
                            echo 'class="';
                        }
                        ?> navbar-brand <?php echo $extra ?> data-toggle = "dropdown" href = "#" > Usuário
                            <span class = "caret" > </span></a >
                        <ul class = "dropdown-menu" >
                            <li > <a href = "<?= $this->config->item('url_link'); ?>reports/user_reports" > Relatórios </a></li >
                        </ul>
                    </li>
                    <li class = "dropdown" >
                        <a  <?php
                        if ($paginaLink == "/index.php/reports/associated_campaign") {
                            echo 'class="link active';
                        } else {
                            echo 'class="';
                        }
                        ?> navbar-brand <?php echo $extra ?> data-toggle = "dropdown" href = "#" > Campanha de sócios
                            <span class = "caret" > </span></a >
                        <ul class = "dropdown-menu" >
                            <li > <a href = "<?= $this->config->item('url_link'); ?>reports/associated_campaign" > Relatórios </a></li >
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a  <?php
                        if ($paginaLink == "/index.php/admin/camp") {
                            echo 'class="link active';
                        } else {
                            echo 'class="';
                        }
                        ?> navbar-brand <?php echo $extra ?> data-toggle = "dropdown" href = "#" > Colônia
                            <span class = "caret" > </span></a >
                        <ul class = "dropdown-menu" >
                            <li > <a href = "<?= $this->config->item('url_link'); ?>admin/camp" > Administração </a></li >
                            <li > <a href = "<?= $this->config->item('url_link'); ?>reports/camp_reports" > Relatórios </a></li >
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a  class="navbar-brand"  data-toggle = "dropdown" href = "#" > Eventos
                            <span class = "caret" > </span></a >
                    </li>
                    <li class="dropdown">
                        <a  <?php
                        if ($paginaLink == "/index.php/admin/finance_admin" || $paginaLink == "/index.php/reports/finance_reports") {
                            echo 'class="link active';
                        } else {
                            echo 'class="';
                        }
                        ?>  navbar-brand <?php echo $extra ?> data-toggle = "dropdown" href = "#" > Financeiro
                            <span class = "caret" > </span></a >
                        <ul class = "dropdown-menu" >
                        	<li > <a href = "<?= $this->config->item('url_link'); ?>admin/finance_cashoutflows" > Saídas </a></li >
                            <li > <a href = "<?= $this->config->item('url_link'); ?>reports/finance_reports" > Relatórios </a></li >
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>