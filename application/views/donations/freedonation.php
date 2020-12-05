<script type="text/javascript" charset="utf-8">

    function validateForm(event) {
        var donation_value = document.getElementById("donation_value");

        if ((parseInt(donation_value.value, 10) < 50) || (donation_value.value == '')) {
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
<!--
                    <br />
                    <?= ($gender = "M") ? "Prezado" : "Prezada" ?> <?= $fullname ?>, <br />
                    <br />
-->
                <p align="right">Kinderland,<br>onde passei os melhores momentos, talvez os melhores da vida!</p>

                <p align="justify">Diante da pandemia do Coronavírus e seguindo as orientações da Comissão Médica, infelizmente decidimos cancelar as temporadas da MiniK/2020 e Verão/2021 da tradicional Colônia de Férias, realizada desde 1952.</p>

                <p align="justify">Entendemos que a Kinderland é um lugar onde não há espaço para o distanciamento. É um lugar de abraços, de proximidade. Um lugar onde não é possível viver de máscara. Portanto, não teríamos como garantir, neste momento, o cumprimento dos protocolos de segurança.</p>

                <p align="justify">Somos uma entidade sem fins lucrativos e a manutenção da nossa estrutura física bem como dos nossos funcionários depende quase exclusivamente do valor arrecadado nas temporadas. A não realização das mesmas nos coloca em uma situação delicada, que ameaça a nossa própria existência. Para garantir a sobrevivência da KINDERLAND, precisaremos de todo apoio possível.</p>

                <p align="justify">Para viabilizar os custos de 2021 e os necessários investimentos no patrimônio da Colônia para promover as devidas adequações do espaço físico, <b>precisamos atingir a meta de R$ 550.000 até 31/12.</b> Contamos com a sua ajuda para passar por esse difícil período e continuar a oferecer, por muitos anos, a melhor colônia de todas!</p>

                <p align="justify">Basta escolher o valor entre as opções abaixo que poderão ser pagas no <b>cartão de crédito em até 8 vezes ou no cartão de débito à vista.</b> Tomamos como referência o valor equivalente a um colonista da temporada da 2ª Turma.</p>

                <p align="justfy">Agradecemos muito o seu carinho e colaboração para mantermos a KINDERLAND viva neste momento delicado.</p>

                <p align="justfy">Se houver dúvidas, favor entrar em contato conosco pelo e-mail secretaria@kinderland.com.br ou pelo Whataspp: (21) 98344-9449</p>

                </p>              
                <tr>
<!--
                <p align="justify">A Associação KINDERLAND é uma entidade sem fins lucrativos que necessita de contribuições e doações regulares. Elas são utilizadas na manutenção e investimentos no espaço onde a Colônia de Férias é realizada, além de ajudar com os demais custos institucionais.</p>

                <p align="justify">Estas doações podem ser espontâneas e feitas a qualquer momento, como contribuições de itens úteis para a colônia de férias, material de construção ou equipamentos em geral. Agradecemos a todos que indistintamente contribuem regularmente a cada ano.</p>

                <p align="justify">A Associação Kinderland realiza projetos sociais com jovens de comunidades carentes, oferece bolsas parciais ou integrais para colonistas nas temporadas de verão e participa de várias outras iniciativas comunitárias. Somente com estas doações, tudo isto se torna possível.</p>

                <p align="justify">Para colaborar com a Associação Kinderland basta escolher como realizar sua doação (opções de cartão de crédito ou débito) - e definir o valor. Você será redirecionado para uma tela da operadora de cartões Cielo, para entrada dos dados do cartão. Em alguns casos, pode aparecer outra tela de validação e confirmação da doação, um controle adicional do próprio banco emissor do cartão. Cabe observar que, para a segurança de todos, nem a Kinderland nem a Cielo guardam os dados do cartão em seus bancos de dados.</p>

                <p align="justify">Ao final do processo, um email será enviado automaticamente confirmando ou não o sucesso da operação. Também mantemos em sua página nos Sistemas Kinderland o histórico de doações efetuadas. Agradecemos, antecipadamente, pelo interesse em contribuir com a Kinderland!</p>
                <p align="justify">Devido aos custos operacionais e taxas bancárias, pedimos apenas que o valor da doação seja igual ou superior a R$<?= number_format(50, 2, ',', '.') ?>.

                <p align="justfy">Atenção: as doações referentes aos associados do ano corrente devem ser feitas pela opção dos Sistemas Kinderland “Campanha de Sócios”.</p>

                <p align="justfy">Se houver dúvidas, favor entrar em contato conosco por telefone (21) 2266-1980 ou e-mail secretaria@kinderland.com.br.</p><br /><br />
-->
                </p>
                
                <p align="right" style="border: 1px;font-size:16px;color:#428bca;"><button style="border: 3px solid #428bca;color:#428bca;background-color:white">Arrecadado até ontem: R$ 41.900</button></p>

            </div>
        </div>

        <form action="<?= $this->config->item('url_link') ?>donations/checkoutFreeDonation" method="POST">
            <div class="row">
                    <label for="fullname" class="col-lg-2 control-label"> Valor da doação: </label>
            </div>

                    <div class="btn_room_row" >
                        <table>
                            <tr>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="900" onClick="setValue(900);validateForm(event)"/> </th>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="1800" onClick="setValue(1800);validateForm(event)"/> </th>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="2700" onClick="setValue(2700);validateForm(event)"/> </th>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="3600" onClick="setValue(3600);validateForm(event)"/> </th>
                                                              
                        </table>
                    </div>
            <br></br>
            <div class="row">
                    <label for="fullname" class="col-lg-2 control-label"> Outro valor: </label>
            </div>

                    <div class="btn_room_row" >
                        <table>
                            <tr>
                                <th> <input type="text" size="10" class="form-control" value=""
                           name="donation_value" id="donation_value" style="margin-left:5px;border:2px solid #008CBA" 
                           oninvalid="this.setCustomValidity('O valor mínimo para doação é de R$50,00.')"/> </th>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="Prosseguir" onClick="validateForm(event)"/> </th>                              
                        </table>
                    </div>

            <tr>
<!--
            <div class="row">
                <div class="col-lg-4">
                    <input type="submit" class="btn btn-primary" value="Prosseguir" onClick="validateForm(event)"/>
                </div>
            </div>
-->
        </form>


    </div>
</div>