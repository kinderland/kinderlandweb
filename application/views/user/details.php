<div class="row">
    <div class="col-lg-12 middle-content">

        <div class="row">
                <div class="form-group">
                    <label for="fullname" class="col-lg-1 control-label"> Nome Completo: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Nome Completo"
                               name="fullname" value="<?= $user->fullname ?>"
                               onkeypress="return validateLetterInput(event);" disabled
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"/>
                    </div>

                    <label for="cpf" class="col-lg-1 control-label"> CPF: </label>
                    <div class="col-lg-3">
                        <input type="text" id="cpf" class="form-control" placeholder="CPF"
                               name="cpf" value="<?= $user->cpf ?>" disabled
                               maxlength="11" onkeypress="return validateNumberInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"/>
                        <script type="text/javascript">
                            window.onload = funcCpf();
                        </script>
                    </div>

                    <label for="gender" class="col-lg-1 control-label"> Sexo: </label>
                    <div class="col-lg-3">
                        <select  class="form-control" id="gender" name="gender" disabled
                                 oninvalid="this.setCustomValidity('Favor escolher um item da lista.')"
                                 oninput="setCustomValidity('')">>
                            <option value="M" <?php if ($user->gender == "M") echo "selected" ?> >Masculino</option>
                            <option value="F" <?php if ($user->gender == "F") echo "selected" ?> >Feminino</option>
                        </select>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="email" class="col-lg-1 control-label"> E-mail: </label>
                    <div class="col-lg-3">
                        <input type="email" id="email" class="form-control" placeholder="Email"
                               name="email" value="<?= $user->email ?>" disabled
                               required title ="Favor incluir '@'' e '.' ."
                               oninvalid="this.setCustomValidity('Este campo requer um endereço de email.')"
                               oninput="setCustomValidity('')"/>
                    </div>

    

                    <label for="occupation" class="col-lg-1 control-label"> Ocupação: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Ocupação" disabled
                               name="occupation"  value="<?= $user->occupation ?>"
                               onkeypress="return validateLetterInput(event);"
                               />
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="street" class="col-lg-1 control-label"> Rua: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Logradouro"
                               name="street" value="<?= $user->street ?>"
                               onkeypress="return validateLetterInput(event);" disabled
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"/>
                    </div>

                    <label for="number" class="col-lg-1 control-label"> Número*: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Número"
                               name="number" value="<?= $user->place_number ?>"
                               onkeypress="return validateLetterAndNumberInput(event);" disabled
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"/>
                    </div>

                    <label for="complement" class="col-lg-2 control-label"> Complemento: </label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="Complemento" disabled
                               name="complement" value="<?= $user->complement ?>" />
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="city" class="col-lg-1 control-label"> Cidade: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Cidade" disabled
                               name="city" value="<?= $user->city ?>"
                               onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"/>
                    </div>

                    <label for="cep" class="col-lg-1 control-label"> CEP: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="CEP" disabled
                               name="cep" value="<?= $user->cep ?>" maxlength="8"
                               pattern=".{8,}" required id="cep"
                               onkeypress="return validateNumberInput(event);"
                               oninvalid="this.setCustomValidity('O CEP precisa ter 8 dígitos.')"
                               oninput="setCustomValidity('')"/>
                    </div>

                    <label for="neighborhood" class="col-lg-1 control-label"> Bairro: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Bairro" disabled
                               name="neighborhood" value="<?= $user->neighborhood ?>"
                               onkeypress="return validateLetterInput(event);"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="phone1" class="col-lg-1 control-label"> Telefone: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control phone" placeholder="(ddd) Telefone de contato"
                               name="phone1" value="<?= $user->phone1 ?>" id="phone1"
                               onkeypress="return validateNumberInput(event);" disabled
                               class = "phone1"
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"/>
                    </div>

                    <label for="phone2" class="col-lg-1 control-label"> Telefone Secundário: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control phone" placeholder="(ddd) Telefone secundário"
                               name="phone2" value="<?= $user->phone2 ?>" disabled
                               onkeypress="return validateNumberInput(event);"/>
                    </div>

                    <label for="uf" class="col-lg-1 control-label"> Estado: </label>
                    <div class="col-lg-3">
                        <select  class="form-control" id="uf" name="uf" disabled>
                            <option value="RJ" <?php if ($user->uf == "RJ") echo "selected" ?> >RJ</option>
                            <option value="AC" <?php if ($user->uf == "AC") echo "selected" ?> >AC</option>
                            <option value="AL" <?php if ($user->uf == "AL") echo "selected" ?> >AL</option>
                            <option value="AM" <?php if ($user->uf == "AM") echo "selected" ?> >AM</option>
                            <option value="AP" <?php if ($user->uf == "AP") echo "selected" ?> >AP</option>
                            <option value="BA" <?php if ($user->uf == "BA") echo "selected" ?> >BA</option>
                            <option value="CE" <?php if ($user->uf == "CE") echo "selected" ?> >CE</option>
                            <option value="DF" <?php if ($user->uf == "DF") echo "selected" ?> >DF</option>
                            <option value="ES" <?php if ($user->uf == "ES") echo "selected" ?> >ES</option>
                            <option value="GO" <?php if ($user->uf == "GO") echo "selected" ?> >GO</option>
                            <option value="MA" <?php if ($user->uf == "MA") echo "selected" ?> >MA</option>
                            <option value="MG" <?php if ($user->uf == "MG") echo "selected" ?> >MG</option>
                            <option value="MS" <?php if ($user->uf == "MS") echo "selected" ?> >MS</option>
                            <option value="MT" <?php if ($user->uf == "MT") echo "selected" ?> >MT</option>
                            <option value="PA" <?php if ($user->uf == "PA") echo "selected" ?> >PA</option>
                            <option value="PB" <?php if ($user->uf == "PB") echo "selected" ?> >PB</option>
                            <option value="PE" <?php if ($user->uf == "PE") echo "selected" ?> >PE</option>
                            <option value="PI" <?php if ($user->uf == "PI") echo "selected" ?> >PI</option>
                            <option value="PR" <?php if ($user->uf == "PR") echo "selected" ?> >PR</option>
                            <option value="RN" <?php if ($user->uf == "RN") echo "selected" ?> >RN</option>
                            <option value="RO" <?php if ($user->uf == "RO") echo "selected" ?> >RO</option>
                            <option value="RR" <?php if ($user->uf == "RR") echo "selected" ?> >RR</option>
                            <option value="RS" <?php if ($user->uf == "RS") echo "selected" ?> >RS</option>
                            <option value="SC" <?php if ($user->uf == "SC") echo "selected" ?> >SC</option>
                            <option value="SE" <?php if ($user->uf == "SE") echo "selected" ?> >SE</option>
                            <option value="SP" <?php if ($user->uf == "SP") echo "selected" ?> >SP</option>
                            <option value="TO" <?php if ($user->uf == "TO") echo "selected" ?> >TO</option>
                        </select>
                    </div>
                </div>
            </div>
            

        <br /><br /><br />

        <div class="form-group">
            <div class="col-lg-10">
                <button class="btn btn-primary" style="margin-right:40px" onClick="history.back(-1)">Voltar</button>
            </div>
        </div>
    </div>
</div>