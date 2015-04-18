
<script type="text/javascript" charset="utf-8">

    function validateForm(event) {

        var cpfInvalidErr = false;
        var cpfExistingErr = false;
        var emailErr = false;
        var emailExistingErr = false;
        var passErr = false;
        var msgGeneral = "Os seguintes campos possuem um erro:";
        var msgInvalidCPF = "Este CPF não é válido.";
        var msgExistingCPF = "Este CPF já está cadastrado.";
        var msgEmail = "E-mail e confirmação de e-mail não estão iguais.";
        var msgExistingEmail = "Este email já está cadastrado.";
        var msgPass = "Senha e confirmação de senha não estão iguais.";

        var email = document.getElementById("email");
        var confirm_email = document.getElementById("confirm_email");
        if (email.value != confirm_email.value) {
            emailErr = true;
            event.preventDefault();
        }

        var password = document.getElementById("password");
        var confirm_password = document.getElementById("confirm_password");
        if (password.value != confirm_password.value) {
            passErr = true;
            event.preventDefault();
        }

        var cpf = document.getElementById("cpf");

        if (!TestaCPF(cpf.value)) {
            cpfInvalidErr = true;
            event.preventDefault();
        }

        var cpfNoMask = cpf.value.replace(".", "");
        cpfNoMask = cpfNoMask.replace(".","");
        cpfNoMask = cpfNoMask.replace("-","");

        $.get(
                "<?= $this->config->item('url_link') ?>login/checkExistingEmail?email=" + $("#email").val(),
                function (data) {
                    if (data == "true") {
                        alert(msgExistingEmail);
                        emailExistingErr = true;
                        event.preventDefault();
                    }
                });

        $.get(
                "<?= $this->config->item('url_link') ?>login/checkExistingCpf?cpf=" + cpfNoMask,
                function (data) {
                    if (data == "true") {
                        cpfExistingErr = true;
                        event.preventDefault();
                    }
                    if (passErr && emailErr && cpfExistingErr) {
                        alert(msgGeneral + '\n\n' + msgExistingCPF + '\n' + msgEmail + '\n' + msgPass);
                    }
                    else if (passErr && emailErr && cpfInvalidErr) {
                        alert(msgGeneral + '\n\n' + msgInvalidCPF + '\n' + msgEmail + '\n' + msgPass);
                    }
                    else if (emailErr && cpfExistingErr) {
                        alert(msgGeneral + '\n\n' + msgExistingCPF + '\n' + msgEmail);
                    }
                    else if (passErr && cpfExistingErr) {
                        alert(msgGeneral + '\n\n' + msgExistingCPF + '\n' + msgPass);
                    }
                    else if (passErr && emailErr) {
                        alert(msgGeneral + '\n\n' + msgEmail + '\n' + msgPass);
                    }
                    else if (passErr && cpfInvalidErr) {
                        alert(msgGeneral + '\n\n' + msgInvalidCPF + '\n' + msgPass);
                    }
                    else if (emailErr && cpfInvalidErr) {
                        alert(msgGeneral + '\n\n' + msgInvalidCPF + '\n' + msgEmail);
                    }
                    else if (cpfInvalidErr) {
                        alert(msgInvalidCPF);
                    }
                    else if (passErr) {
                        alert(msgPass);
                    }
                    else if (emailErr) {
                        alert(msgEmail);
                    }
                    else if (cpfExistingErr) {
                        alert(msgExistingCPF);
                    }
                });
        
        cpf.value = cpfNoMask;
        $("#signup_form").submit();
    }

    /* permite apenas numeros, tab e backspace*/
    function validateNumberInput(evt) {

        var key_code = (evt.which) ? evt.which : evt.keyCode;
        if ((key_code >= 48 && key_code <= 57) || key_code == 9 || key_code == 8) {
            return true;
        }
        return false;
    }
    /* permite letras, letras com acentos, hifen e espaco */
    function validateLetterInput(evt) {

        var key_code = (evt.which) ? evt.which : evt.keyCode;

        if ((key_code >= 65 && key_code <= 90) || (key_code >= 97 && key_code <= 122) || key_code == 9 || key_code == 39
                || key_code == 8 || key_code == 45 || key_code == 32 || (key_code >= 180 && key_code <= 252)) {

            return true;
        }
        return false;
    }
    /* permite letras e numeros */
    function validateLetterAndNumberInput(evt) {

        var key_code = (evt.which) ? evt.which : evt.keyCode;

        if (((key_code >= 65 && key_code <= 90) || (key_code >= 97 && key_code <= 122))
                || ((key_code >= 48 && key_code <= 57) || key_code == 9 || key_code == 8)) {

            return true;
        }
        return false;
    }
    /* tirado diretamente do site da receita federal */
    function TestaCPF(strCPF) {
        var cpf = strCPF.replace(".", "");
        cpf = cpf.replace(".","");
        cpf = cpf.replace("-","");
        var Soma;
        var Resto;
        Soma = 0;
        //strCPF  = RetiraCaracteresInvalidos(strCPF,11);
        //pequena modificaçao para verificar todos os cpfs com todos os digitos iguais, antes so era verificado o primeiro caso
        if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" ||
                cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" ||
                cpf == "88888888888" || cpf == "99999999999")
            return false;
        for (i = 1; i <= 9; i++)
            Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (11 - i);cpf
        Resto = (Soma * 10) % 11;
        if ((Resto == 10) || (Resto == 11))
            Resto = 0;
        if (Resto != parseInt(cpf.substring(9, 10)))
            return false;
        Soma = 0;
        for (i = 1; i <= 10; i++)
            Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;
        if ((Resto == 10) || (Resto == 11))
            Resto = 0;
        if (Resto != parseInt(cpf.substring(10, 11)))
            return false;
        return true;
    }

    function funcCpf() {
        var cpfCheck = document.getElementById("cpf");

        cpfCheck.onchange = function () {
            if (TestaCPF(cpfCheck.value)) {
                cpfCheck.style.backgroundColor = "#FFFFFF";
                $.get(
                        "<?= $this->config->item('url_link') ?>login/checkExistingCpf?cpf=" + $("#cpf").val(),
                        function (data) {
                            if (data == "true")
                                alert("Este CPF já está cadastrado.");
                        });
                return true;
            }
            else {
                cpfCheck.style.backgroundColor = "#F78D8D";
                alert("Este CPF não é válido.");
                return false;
            }
        };
    }

    function funcEmail() {
        var email = document.getElementById("email");
        var confirm_email = document.getElementById("confirm_email");
        confirm_email.onchange = function () {
            if (email.value === confirm_email.value) {
                confirm_email.style.backgroundColor = "#FFFFFF";
            }
            else {
                confirm_email.style.backgroundColor = "#F78D8D";
                alert("E-mail e confirmação de e-mail não estão iguais. Favor verificar.");
            }
        };
    }

    function funcPassword() {
        var password = document.getElementById("password");
        var confirm_password = document.getElementById("confirm_password");
        confirm_password.onchange = function () {
            if (password.value === confirm_password.value) {
                confirm_password.style.backgroundColor = "#FFFFFF";
            }
            else {
                confirm_password.style.backgroundColor = "#F78D8D";
                alert("Senha e confirmação de senha não estão iguais. Favor verificar.");
                //$("#confirm_password > div").attr("class", "has-error");
            }
        };
    }

    function funcExistingEmail() {

        var email = document.getElementById("email");
        email.onchange = function () {
            $.get(
                    "<?= $this->config->item('url_link') ?>login/checkExistingEmail?email=" + $("#email").val(),
                    function (data) {
                        if (data == "true") {
                            alert("Este email já está cadastrado.");
                            event.preventDefault();
                            return true;
                        }
                    });
        };
        return false;
    }


    $(document).ready(function ($) {
        var SPMaskBehavior = function (val) {
          return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
          onKeyPress: function(val, e, field, options) {
              field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };
        $(".phone").mask(SPMaskBehavior, spOptions);
        $("#cep").mask("00000-000");
        $("#cpf").mask("000.000.000-00");
    });


</script>

<div class="row">
    <div class="col-lg-12 middle-content">
        <div class="row">
            <div class="col-lg-8"><h4>Cadastro de usuário</h4></div>
            <div class="col-lg-4"><h6><span class="red_letters">Campos com * são de preenchimento obrigatório.</span></h6></div>
        </div>
        <hr />

        <form name="edit_form" method="POST" action="<?= $this->config->item('url_link') ?>login/completeSignup" id="edit_form">
            <div class="row">
                <div class="form-group">
                    <label for="fullname" class="col-lg-1 control-label"> Nome Completo*: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Nome Completo"
                               name="fullname" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php if (!empty($_POST['fullname'])) {
    echo $_POST['fullname'];
} ?>"/>

                    </div>

                    <label for="cpf" class="col-lg-1 control-label"> CPF*: </label>
                    <div class="col-lg-3">
                        <input type="text" id="cpf" class="form-control" placeholder="CPF"
                               name="cpf" maxlength="11" onkeypress="return validateNumberInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php if (!empty($_POST['cpf'])) {
    echo $_POST['cpf'];
} ?>"/>
                        <script type="text/javascript">
                            window.onload = funcCpf();
                        </script>

                    </div>

                    <label for="gender" class="col-lg-1 control-label"> Sexo*: </label>
                    <div class="col-lg-3">
                        <select  class="form-control" id="gender" name="gender" >
                            <option value="" selected>-- Selecione --</option>
                            <option value="M"
<?php if (!empty($_POST['gender']) && ($_POST['gender'] == "M")) echo "selected" ?> >Masculino</option>
                            <option value="F"
<?php if (!empty($_POST['gender']) && ($_POST['gender'] == "F")) echo "selected" ?>>Feminino</option>
                        </select>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="email" class="col-lg-1 control-label"> E-mail*: </label>
                    <div class="col-lg-3">
                        <input type="email" id="email" class="form-control" placeholder="Email"
                               name="email" required title ="Favor incluir '@' e '.' ."
                               oninvalid="this.setCustomValidity('Este campo requer um endereço de email.')"
                               oninput="setCustomValidity('')"
                               value="<?php if (!empty($_POST['email'])) {
    echo $_POST['email'];
} ?>"/>
                        <script type="text/javascript">
                            window.onload = funcExistingEmail();
                        </script>
                    </div>

                    <label for="confirm_email" class="col-lg-1 control-label"> Confirme o E-mail*: </label>
                    <div class="col-lg-3">
                        <input type="email" id="confirm_email" class="form-control" placeholder="Email"
                               name="confirm_email" required title ="Favor incluir '@'' e '.' ."
                               oninvalid="this.setCustomValidity('Este campo requer um endereço de email.')"
                               oninput="setCustomValidity('')"
                               value="<?php if (!empty($_POST['confirm_email'])) {
    echo $_POST['confirm_email'];
} ?>"/>
                        <script type="text/javascript">
                            window.onload = funcEmail();
                        </script>
                    </div>

                    <label for="occupation" class="col-lg-1 control-label"> Ocupação: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Ocupação"
                               name="occupation" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value=""/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="street" class="col-lg-1 control-label"> Logradouro*: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Logradouro"
                               name="street" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php if (!empty($_POST['street'])) {
    echo $_POST['street'];
} ?>"/>
                    </div>

                    <label for="number" class="col-lg-1 control-label"> Número*: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Número"
                               name="number" onkeypress="return validateLetterAndNumberInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php if (!empty($_POST['number'])) {
    echo $_POST['number'];
} ?>"/>
                    </div>

                    <label for="complement" class="col-lg-2 control-label"> Complemento: </label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="Complemento"
                               name="complement"
                               value="<?php if (!empty($_POST['complement'])) {
    echo $_POST['complement'];
} ?>"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="city" class="col-lg-1 control-label"> Cidade*: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Cidade"
                               name="city" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php if (!empty($_POST['city'])) {
    echo $_POST['city'];
} ?>"/>
                    </div>

                    <label for="cep" class="col-lg-1 control-label"> CEP*: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="CEP"
                               name="cep" maxlength="8" onkeypress="return validateNumberInput(event);"
                               pattern=".{8,}" required id="cep"
                               oninvalid="this.setCustomValidity('O CEP precisa ter 8 dígitos.')"
                               oninput="setCustomValidity('')" onblur="maskCEP(this)"
                               value="<?php if (!empty($_POST['cep'])) {
    echo $_POST['cep'];
} ?>"/>
                    </div>
                    <label for="neighborhood" class="col-lg-1 control-label"> Bairro: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Bairro"
                               name="neighborhood" onkeypress="return validateLetterInput(event);"
                               value="<?php if (!empty($_POST['neighborhood'])) {
    echo $_POST['neighborhood'];
} ?>"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="phone1" class="col-lg-1 control-label"> Telefone*: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control phone" placeholder="(ddd) Telefone de contato"
                               name="phone1" id="phone1" maxlength="25" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               class="phone1"
                               value="<?php if (!empty($_POST['phone1'])) {
    echo $_POST['phone1'];
} ?>"/>
                    </div>

                    <label for="phone2" class="col-lg-1 control-label"> Telefone Secundário: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control phone" placeholder="(ddd) Telefone secundário"
                               name="phone2" maxlength="25" onkeypress="return validateNumberInput(event);"
                               value="<?php if (!empty($_POST['phone2'])) {
    echo $_POST['phone2'];
} ?>"/>
                    </div>

                    <label for="uf" class="col-lg-1 control-label"> Estado*: </label>
                    <div class="col-lg-3">
                        <select  class="form-control" id="uf" name="uf" required
                                 oninvalid="this.setCustomValidity('Favor escolher um item da lista.')"
                                 oninput="setCustomValidity('')">
                            <option value="" selected> -- Selecione -- </option>
                            <option value="RJ" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "RJ")) echo "selected" ?>>RJ</option>
                            <option value="AC" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "AC")) echo "selected" ?>>AC</option>
                            <option value="AL" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "AL")) echo "selected" ?>>AL</option>
                            <option value="AM" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "AM")) echo "selected" ?>>AM</option>
                            <option value="AP" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "AP")) echo "selected" ?>>AP</option>
                            <option value="BA" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "BA")) echo "selected" ?>>BA</option>
                            <option value="CE" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "CE")) echo "selected" ?>>CE</option>
                            <option value="DF" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "DF")) echo "selected" ?>>DF</option>
                            <option value="ES" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "ES")) echo "selected" ?>>ES</option>
                            <option value="GO" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "GO")) echo "selected" ?>>GO</option>
                            <option value="MA" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "MA")) echo "selected" ?>>MA</option>
                            <option value="MG" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "MG")) echo "selected" ?>>MG</option>
                            <option value="MS" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "MS")) echo "selected" ?>>MS</option>
                            <option value="MT" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "MT")) echo "selected" ?>>MT</option>
                            <option value="PA" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "PA")) echo "selected" ?>>PA</option>
                            <option value="PB" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "PB")) echo "selected" ?>>PB</option>
                            <option value="PE" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "PE")) echo "selected" ?>>PE</option>
                            <option value="PI" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "PI")) echo "selected" ?>>PI</option>
                            <option value="PR" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "PR")) echo "selected" ?>>PR</option>
                            <option value="RN" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "RN")) echo "selected" ?>>RN</option>
                            <option value="RO" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "RO")) echo "selected" ?>>RO</option>
                            <option value="RR" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "RR")) echo "selected" ?>>RR</option>
                            <option value="RS" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "RS")) echo "selected" ?>>RS</option>
                            <option value="SC" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "SC")) echo "selected" ?>>SC</option>
                            <option value="SE" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "SE")) echo "selected" ?>>SE</option>
                            <option value="SP" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "SP")) echo "selected" ?>>SP</option>
                            <option value="TO" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "TO")) echo "selected" ?>>TO</option>
                        </select>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="password" class="col-lg-1 control-label"> Senha*: </label>
                    <div class="col-lg-3">
                        <input type="password" id="password" class="form-control" placeholder="" name="password" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"/>
                    </div>

                    <label for="confirm_password" class="col-lg-2 control-label"> Confirme a senha*: </label>
                    <div class="col-lg-3">
                        <input type="password" id="confirm_password" class="form-control" name="confirm_password" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"/>
                        <script type="text/javascript">
                            window.onload = funcPassword();
                        </script>
                    </div>
                </div>
            </div>

            <br /><br /><br />

            <div class="form-group">
                <div class="col-lg-10">
                    <button class="btn btn-primary" style="margin-right:40px" onClick="validateForm(event)">Confirmar</button>
                </div>
            </div>

        </form>
    </div>
</div>