
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css" rel="stylesheet" />
        <!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css"></script>
    <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>

</head>
<body>
    <div id="thisdiv">
        <div class="row">
            <?php require_once APPPATH . 'views/include/common_user_left_menu.php' ?>
            <div class="col-lg-10 middle-content">
                <?php if ($date_finish > $dataatual || $date_finish == $dataatual ) { ?>
                    <h3><strong>Campanha de sócios <?php echo $campaign->getCampaignYear(); ?></strong></h3>
                    <hr class="footer-hr"/>
             <div class="row">
            <div class="col-lg-9">
                <p align="justify">
                <p align="justify"> A Associação KINDERLAND é uma entidade sem fins lucrativos que necessita de contribuições e doações regulares. Elas são utilizadas na manutenção e investimentos no espaço onde a Colônia de Férias é realizada, além de ajudar com os demais custos institucionais.</p>
                <p align="justify"> Estas doações podem ser espontâneas e feitas a qualquer momento, como contribuições de ítens úteis para a colônia de férias, material de construção ou equipamentos em geral. Agradecemos a todos que indistintamente contribuem regularmente como associados ou doadores avulsos.</p>
                <p align="justify"> A Associação Kinderland realiza projetos sociais com jovens de comunidades carentes, oferece bolsas parciais ou integrais para colonistas nas temporadas de verão e participa de várias outras iniciativas comunitárias. Somente com estas doações tudo isto torna-se possível.</p>
                <p align="justify"> Todos os anos realizamos uma campanha de associados Kinderland, visando obter recursos financeiros para as nossos projetos, investimentos e operações ao longo do ano. Os associados da Kinderland têm, entre outros, os seguintes benefícios:</p>
                <ul>
                    <li>
                        Desconto nas doações pela cessão do espaço físico da colônia Kinderland para festas de aniversário, finais de semana com amigos ou outros eventos particulares;
                    </li>
                    <li>
                        Desconto nos eventos especiais organizados e realizados pela Associação Kinderland (ex. evento MaCK - Mostre a Colônia Kinderland);
                    </li>
                    <li>
                        Pré-inscrição antecipada <b>sem garantia de vaga</b> para a temporada de verão (verificar <u><a target="_blank" href="http://www.kinderland.com.br/como-ajudar/quero-ser-socio/">Restrições</a></u> em nosso site).
                    </li>
                </ul>

                <p align="justify">
                    A Associação Kinderland considera como associado as pessoas pertencentes ao nosso cadastro
<!--                </p>
                <p align="justify">
-->
                    <?php if (isset($benemerito) && $benemerito) { ?>
                        identificadas como beneméritas ou membros da diretoria. Nestes casos, não há necessidade de doação. Entretanto, se houver interesse e possibilidade, sugerimos aos beneméritos que utilizem a opção de “Doação Avulsa” do Sistema Kinderland.
                    <?php } else { ?>
                        que contribuírem com um valor igual a <b>R$ <?php echo $campaign->getPrice(); ?> a partir do dia <?php echo $date_start ?> às 00:00 até o dia <?php echo $date_finish ?> às 23:59.</b>
                    <?php } ?>

                </p>
                <p align="justify">
                    O valor da colaboração do associado pode ser doado em pagamento por cartão de crédito, em uma ou até 3 (três) parcelas iguais sem acréscimo, em função da quantidade de meses restantes até o final do mês de junho. Também há a opção de doação por cartão de débito. <i>Por questões de segurança e controle administrativo, não é possível receber doações por outros meios (transferência bancária, DOC), cheque ou dinheiro</i>.
                </p>
                <p align="justify">
                    Se você <span style="font-weight:bold"> concorda com as condições </span>para ser um associado Kinderland, basta confirmar abaixo em “Quero ser Sócio” e escolher como realizar sua doação. Ao final do processo, e com a devida autorização da administradora do seu cartão, um email será enviado automaticamente, confirmando a condição de associado. A doação também aparecerá em seu “Histórico de Doações” uma vez confirmada.
                </p>
                <p align="justify">
                    Caso não receba a mensagem de confirmação, por alguma demora na autorização por parte da Cielo ou da administradora de cartões, pedimos para entrar em contato conosco por telefone (21 2266-1980) ou e-mail (secretaria@kinderland.com.br) antes de efetuar nova tentativa de doação.
                </p>
                
                <?php }
                    else if($year == date('h')) {
                    ?>
                    <p align="justify">
                    <strong> Aguarde, em breve iniciaremos a campanha de sócios <?php echo $year ?>.</strong>
                    </p>
                <?php }
              		 else if ($date_finish < $dataatual){  ?>
               		<p align="justify">
                	<strong> A campanha de sócios <?php echo $year ?> já foi encerrada.</strong>
                	</p>
                <?php }?>
                			
            </div>
        </div>

         
                			
                
                


            </div>
        </div>
    </div>
</body>
</html>
