<script type="text/javascript" charset="utf-8">

    function validateForm(event) {
        var donation_value = document.getElementById("donation_value");

        if (parseInt(donation_value.value, 10) < 50) {
            alert("O valor mínimo para doação é de R$50,00.");
            event.preventDefault();
        }
    }

    function setValue(value){
          document.getElementById("donation_value").value= value;
    }

</script>

<div class="row">
    <?php require_once APPPATH . 'views/include/common_user_left_menu.php' ?>
    <div class="col-lg-10 middle-content">
        <h3>DOAÇÃO EMERGENCIAL para a ASSOCIAÇÃO KINDERLAND </h3>
        <div class="row">
            <div class="col-lg-9">
                <p align="justify">
                    <br />
                    <?= ($gender = "M") ? "Prezado" : "Prezada" ?> <?= $fullname ?>, <br />
                    <br />

                <p align="justify">A Associação KINDERLAND é uma entidade sem fins lucrativos que necessita de contribuições e doações regulares. Elas são utilizadas na manutenção e investimentos no espaço onde a Colônia de Férias é realizada, além de ajudar com os demais custos institucionais.</p>

                <p align="justify">Estas doações podem ser espontâneas e feitas a qualquer momento, como contribuições de itens úteis para a colônia de férias, material de construção ou equipamentos em geral. Agradecemos a todos que indistintamente contribuem regularmente a cada ano.</p>

                <p align="justify">A Associação Kinderland realiza projetos sociais com jovens de comunidades carentes, oferece bolsas parciais ou integrais para colonistas nas temporadas de verão e participa de várias outras iniciativas comunitárias. Somente com estas doações, tudo isto se torna possível.</p>

                <p align="justify">Para colaborar com a Associação Kinderland basta escolher como realizar sua doação (opções de cartão de crédito ou débito) - e definir o valor. Você será redirecionado para uma tela da operadora de cartões Cielo, para entrada dos dados do cartão. Em alguns casos, pode aparecer outra tela de validação e confirmação da doação, um controle adicional do próprio banco emissor do cartão. Cabe observar que, para a segurança de todos, nem a Kinderland nem a Cielo guardam os dados do cartão em seus bancos de dados.</p>

                <p align="justify">Ao final do processo, um email será enviado automaticamente confirmando ou não o sucesso da operação. Também mantemos em sua página nos Sistemas Kinderland o histórico de doações efetuadas. Agradecemos, antecipadamente, pelo interesse em contribuir com a Kinderland!</p>
                <p align="justify">Devido aos custos operacionais e taxas bancárias, pedimos apenas que o valor da doação seja igual ou superior a R$<?= number_format(50, 2, ',', '.') ?>.

                <p align="justfy">Atenção: as doações referentes aos associados do ano corrente devem ser feitas pela opção dos Sistemas Kinderland “Campanha de Sócios”.</p>

                <p align="justfy">Se houver dúvidas, favor entrar em contato conosco por telefone (21) 2266-1980 ou e-mail secretaria@kinderland.com.br.</p><br /><br />

                </p>
            </div>
        </div>


        <form action="<?= $this->config->item('url_link') ?>donations/checkoutFreeDonation" method="POST">
            <div class="row">
                <label for="fullname" class="col-lg-2 control-label"> Valor da doação: </label>
                <div class="col-lg-4">
                    <input type="button" onclick="setValue(170)" value="170">
                    <input type="button" onclick="setValue(360)" value="360">
                    <input type="text" min="20" class="form-control" value=""
                           name="donation_value" id="donation_value"
                           oninvalid="this.setCustomValidity('O valor mínimo para doação é de R$50,00.')"/>

                </div>
            </div>
            <br>
            <h3 style="color:red"> Doação avulsa e NÃO RELACIONADA com inscrições nas temporadas de colônias de férias, eventos (MaCK e outros) ou campanha de associados Kinderland. </h3>
            <div class="row">
                <div class="col-lg-4">
                    <input type="submit" class="btn btn-primary" value="Prosseguir" onClick="validateForm(event)"/>
                </div>
            </div>

        </form>

    </div>
</div>