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

<div class = "row">
    <?php if ($fullname != 'Visitante') require_once APPPATH . 'views/include/common_user_left_menu.php' ?>

    <tr>

<div class="col-lg-10 middle-content">
        <div class="row">
            <div class="col-lg-8">
                <p align="right" style="border: 1px;font-size:16px;color:#428bca;"><button style="border: 3px solid #428bca;color:black;background-color:white;border-radius:5px;pointer-events:none">Valor arrecadado (atualizado às 11:30): R$ 294.474</button></p>
            </div>
            <div class="col-lg-8">
                <img src="<?= $this->config->item('assets'); ?>images/kinderland/KinderlandDoeoeoa.jpeg" align="center" height=360/>

        <p></p>
        <h4><p align="right">Kinderland,<br>onde passei os melhores momentos, talvez os melhores da vida!</p></h4>
<!--
            <p align="right" style="border: 1px;font-size:16px;color:#428bca;"><button style="border: 3px solid #428bca;color:#428bca;background-color:white;border-radius:5px;pointer-events:none">Valor arrecadado (atualizado às 20:00): R$ 180.123</button></p>a
-->
            </div>
        </div>

        <br></br>

        <h4>AJUDE A COLÔNIA!</h4>
        <p></p>
        <h4>A NOSSA META É DE R$ 550.000 ATÉ O DIA 20/12.</h4>
        <p></p>

        <div class="row">
            <div class="col-lg-8">
        <p align="justify">Basta escolher o valor entre as opções abaixo que poderão ser pagas no cartão de crédito em até 8 vezes ou no cartão de débito à vista. </b> Tomamos como referência o valor equivalente a um colonista da temporada da 2ª Turma.</p>  
        
        <p align="justfy">Agradecemos muito o seu carinho e colaboração para mantermos a KINDERLAND viva neste momento delicado.</p> 

        <p align="justfy">Se houver dúvidas, favor entrar em contato conosco pelo e-mail secretaria@kinderland.com.br ou pelo Whataspp: (21) 98344-9449</p>

        <br></br>
        <form action="<?= $this->config->item('url_link') ?>donations/checkoutFreeDonation" method="POST">
            <div class="row">
                    <label for="fullname" class="col-lg-3 control-label"> Valor da doação: </label>
            </div>

                    <div class="btn_room_row" >
                        <table>
                            <tr>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="900" onClick="setValue(900);validateForm(event)"/> </th>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="1800" onClick="setValue(1800);validateForm(event)"/> </th>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="2700" onClick="setValue(2700);validateForm(event)"/> </th>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="3600" onClick="setValue(3600);validateForm(event)"/> </th>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="5400" onClick="setValue(5400);validateForm(event)"/> </th>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="7200" onClick="setValue(7200);validateForm(event)"/> </th>
                                <th> <input type="submit" class="btn btn-primary" style="margin-left:5px" value="9000" onClick="setValue(9000);validateForm(event)"/> </th>                                                              
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

        </form>

        </div>
        
<!--
        <h3>DOAÇÃO EMERGENCIAL para a ASSOCIAÇÃO KINDERLAND </h3>
-->
        <div class="row">
            <div class="col-lg-9">
                <p align="justify">
<!--
                    <br />
                    <?= ($gender = "M") ? "Prezado" : "Prezada" ?> <?= $fullname ?>, <br />
                    <br />
-->
<!--
                <p align="right">Kinderland,<br>onde passei os melhores momentos, talvez os melhores da vida!</p>

                <p align="justify">Diante da pandemia do Coronavírus e seguindo as orientações da Comissão Médica, infelizmente decidimos cancelar as temporadas da MiniK/2020 e Verão/2021 da tradicional Colônia de Férias, realizada desde 1952.</p>

                <p align="justify">Entendemos que a Kinderland é um lugar onde não há espaço para o distanciamento. É um lugar de abraços, de proximidade. Um lugar onde não é possível viver de máscara. Portanto, não teríamos como garantir, neste momento, o cumprimento dos protocolos de segurança.</p>

                <p align="justify">Somos uma entidade sem fins lucrativos e a manutenção da nossa estrutura física bem como dos nossos funcionários depende quase exclusivamente do valor arrecadado nas temporadas. A não realização das mesmas nos coloca em uma situação delicada, que ameaça a nossa própria existência. Para garantir a sobrevivência da KINDERLAND, precisaremos de todo apoio possível.</p>

                <p align="justify">Para viabilizar os custos de 2021 e os necessários investimentos no patrimônio da Colônia para promover as devidas adequações do espaço físico, <b>precisamos atingir a meta de R$ 550.000 até 20/12.</b> Contamos com a sua ajuda para passar por esse difícil período e continuar a oferecer, por muitos anos, a melhor colônia de todas!</p>

                <p align="justify">Basta escolher o valor entre as opções abaixo que poderão ser pagas no <b>cartão de crédito em até 8 vezes ou no cartão de débito à vista.</b> Tomamos como referência o valor equivalente a um colonista da temporada da 2ª Turma.</p>

                <p align="justfy">Agradecemos muito o seu carinho e colaboração para mantermos a KINDERLAND viva neste momento delicado.</p>

                <p align="justfy">Se houver dúvidas, favor entrar em contato conosco pelo e-mail secretaria@kinderland.com.br ou pelo Whataspp: (21) 98344-9449</p>

                </p>
-->
<!--                 
                 <p align="right" style="border: 1px;font-size:16px;color:#428bca;"><button style="border: 3px solid #428bca;color:#428bca;background-color:white;border-radius:5px">Valor arrecadado (atualizado às 17:30): R$ 175.523</button></p>
-->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <p align="right"><a href="http://www.kinderland.com.br/colonias-atuais/" target="_blank"><button align="right" class="btn btn-secondary" style="background-color:white;font-size:14px;color:#428bca;border-radius:5px;border:3px solid #428bca">SOBRE A CAMPANHA</button></a></p>
            </div>
        </div>



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