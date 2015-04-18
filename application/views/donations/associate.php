<div class="row">
    <?php require_once APPPATH . 'views/include/common_user_left_menu.php' ?>
    <div class="col-lg-10 middle-content">
        <h3> Campanha de sócios <?= date("Y") ?> </h3>

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
                        que contribuírem com um valor igual a <b>R$ 720,00 (setecentos e vinte reais) até o dia 30 de junho.</b>
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
                </p>
            </div>
        </div>

        <!-- Button trigger modal -->
        <a href="<?= $this->config->item('url_link') ?>donations/checkoutAssociate">
            <button type="button" class="btn btn-primary btn-lg">
                Quero ser sócio
            </button>
        </a>
    </div>
</div>