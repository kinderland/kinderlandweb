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

<div class = "row">
    <?php require_once APPPATH . 'views/include/common_user_left_menu.php' ?>
    <div class="col-lg-10" bgcolor="red">
        <h3>Bem <?= ($gender == "M") ? "vindo" : "vinda" ?>, <?= $fullname ?></h3>
    </div>
    <tr>

<div class="col-lg-10 middle-content">
        <h3>DOAÇÃO EMERGENCIAL para a ASSOCIAÇÃO KINDERLAND </h3>
        <div class="row">
            <div class="col-lg-9">
                <p align="justify">
                    <br />
                    <?= ($gender = "M") ? "Prezado" : "Prezada" ?> <?= $fullname ?>, <br />
                    <br />

                <p align="justify">Diante da pandemia do Coronavírus e seguindo as orientações da Comissão Médica, decidimos cancelar as temporadas da MiniK/2020 e Verão/2021 da nossa tradicional Colônia de Férias, realizada desde 1952.</p>

                <p align="justify">A Associação Kinderland é uma entidade sem fins lucrativos e a manutenção da nossa estrutura física bem como dos nossos funcionários depende quase exclusivamente do valor arrecadado nas temporadas. A não realização das mesmas, nos coloca em uma situação delicada, que ameaça a nossa própria existência. Para garantir a sobrevivência da nossa instituição, precisaremos de todo apoio possível.</p>

                <p align="justify">Nossos custos mensais são da ordem de R$ 40.000, considerando tanto a estrutura que temos no Rio de Janeiro quanto em Sacra Família do Tinguá.</p>

                <p align="justify">Para viabilizar os custos de 2021 e os necessários investimentos no patrimônio da Colônia para que possamos promover as devidas adequações do espaço físico, precisamos atingir a meta de R$ 550.000. Contamos com a sua ajuda para a passar por esse difícil período, permitindo-nos continuar a oferecer, por muitos anos, a melhor colônia de todas!</p>

                <p align="justify">Para colaborar com a Associação Kinderland basta escolher como realizar sua doação (opções de cartão de crédito ou débito) - e definir o valor (em até 6 vezes no cartão de crédito). Você será redirecionado para uma tela da operadora de cartões Cielo, para entrada dos dados do cartão. Em alguns casos, pode aparecer outra tela de validação e confirmação da doação, um controle adicional do próprio banco emissor do cartão. Cabe observar que, para a segurança de todos, nem a Kinderland nem a Cielo guardam os dados do cartão em seus bancos de dados.</p>

                <p align="justfy">Ao final do processo, um email será enviado automaticamente confirmando ou não o sucesso da operação. Também mantemos em sua página nos Sistemas Kinderland o histórico de doações efetuadas. Agradecemos, antecipadamente, pelo interesse em contribuir com a Kinderland!</p>

                <p align="justfy">Devido aos custos operacionais e taxas bancárias, pedimos apenas que o valor da doação seja igual ou superior a R$50,00. Se houver dúvidas, favor entrar em contato conosco pelo e-mail secretaria@kinderland.com.br.</p>

                </p>
            </div>
        </div>

        <form action="<?= $this->config->item('url_link') ?>donations/checkoutFreeDonation" method="POST">

            <div class="row">
                    <label for="fullname" class="col-lg-2 control-label"> Valor da doação: </label>
            </div>

                    <div class="btn_room_row" >
                        <table>
                            <tr>
                                <th> <input type="button" class="btn btn-default" style="margin-left:5px" onclick="setValue(180)" value="180"> </th>
                                <th> <input type="button" class="btn btn-default" style="margin-left:5px" onclick="setValue(360)" value="360"> </th>
                                <th> <input type="button" class="btn btn-default" style="margin-left:5px" onclick="setValue(720)" value="720"> </th>
                                <th> <input type="button" class="btn btn-default" style="margin-left:5px" onclick="setValue(1440)" value="1440"> </th>
                                <th> <input type="text" size="10" class="form-control" value=""
                           name="donation_value" id="donation_value" style="margin-left:20px;border:2px solid #008CBA" 
                           oninvalid="this.setCustomValidity('O valor mínimo para doação é de R$50,00.')"/> </th>
                           <th> <input type="submit" class="btn btn-primary" value="Prosseguir" onClick="validateForm(event)"/> </th>
                              
                        </table>
                    </div>


            <tr>

        </form>

    </div>



<!--
    <div class="col-lg-10" bgcolor="red">
        <p align="justify">Texto doação emergencial...</p>
    </div>

	<tr>

    <div class="col-lg-10" bgcolor="red">
         <a href="<?= $this->config->item('url_link'); ?>donations/freeDonation">
         <button  class="btn btn-primary" style="margin: auto;  ">Quero doar</button>
         </a>
    </div>
-->

</div>

