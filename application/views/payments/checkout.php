

        <script type="text/javascript">
            $(document).ready(function(){
                $("input:radio[name='card_flag']").change(function() {
                    if($('select#payment_portions option').length > 1) {
                         var toggle = ($(this).val() == 'visaelectron' || $(this).val() == 'maestro') ? true : false;
                        $('#payment_portions option:eq(1)').prop('selected', toggle);
                        $("#payment_portions").attr("disabled", toggle);
                    }
                   
                }); 
             });    
            
            function validateForm(thisForm) {
                var x = thisForm.valorPagamento.value;
                if (x == null || x == "") {
                    alert("O valor para doação deve ser preenchido.");
                    return false;
                }
            }
            
            function verificaValor(objTextBox){
                var valorMinimo = '20,00';
                var valorString = objTextBox.value;
                valorString = valorString.replace('.','');
                var valorCampo = parseFloat(valorString);
                var minimo = parseFloat(valorMinimo); 
                if((Math.round(parseFloat(valorCampo)*100)/100) < (Math.round(parseFloat(minimo)*100)/100) || (valorString.length == 0)){
                    objTextBox.value = valorMinimo;
                    alert('Desculpe, o menor valor para a doação é R$ '+valorMinimo);
                }
            }

            function verificaParcelas(){
                var parcelas = $("#payment_portions").val();
                if(parcelas < 1){
                    alert("Por favor, selecione a quantidade de parcelas.");
                } else {
                    $("#form_checkout").submit();
                }
            }

            function formataMoeda(objTextBox,SeparadorMilesimo, SeparadorDecimal,e){
                var sep = 0;
                var key = '';
                var i = j = 0;
                var len = len2 = 0;
                var strCheck = '0123456789';
                var aux = aux2 = '';
                if(navigator.appName == "Netscape") 
                    var whichCode = (window.Event) ? e.which : e.charCode;
                else 
                    var whichCode = (window.Event) ? e.which : e.keyCode;

                var whichCode = (window.Event) ? e.which : e.keyCode;
                if ((whichCode == 13) ||(whichCode == 8))
                    return true;
                key = String.fromCharCode(whichCode);
                if (strCheck.indexOf(key) == -1) 
                    return false;
                len = objTextBox.value.length;
                for(i = 0; i < len; i++)
                    if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
                aux = '';
                for(; i < len; i++)
                    if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
                aux += key;
                len = aux.length;
                if (len == 0) objTextBox.value = '';
                if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
                if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
                if (len > 2) {
                    aux2 = '';
                    for (j = 0, i = len - 3; i >= 0; i--) {
                        if (j == 3) {
                            aux2 += SeparadorMilesimo;
                            j = 0;
                        }
                        aux2 += aux.charAt(i);
                        j++;
                    }
                    objTextBox.value = '';
                    len2 = aux2.length;
                    for (i = len2 - 1; i >= 0; i--)
                    objTextBox.value += aux2.charAt(i);
                    objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
                }
                return false;
            }

        </script>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <form action="<?=$this->config->item('url_link')?>payments/executarPagamentoSimples" method="post" id="form_checkout">
            <table style="width: 100%;">
                <tr>
                    <th colspan='6' align='center'
                    style="border-bottom-color:white;
                    border-bottom-style: solid; border-bottom-width: 1px;">
                    <h3>Selecione a bandeira de
                            pagamento</h3></th>
                </tr>
                <tr>
                    <td colspan='3' align='center'
                        style="border-bottom-color:gray; border-right-color:gray; 
                        border-bottom-style: solid; border-bottom-width: 1px; 
                        border-right-style: solid; border-width: 1px;">
                        <strong>Cartões de Crédito<br /></strong>
                    </td>
                    <td colspan="2" align='center'
                        style="border-bottom-color:gray;
                        border-bottom-style:solid; border-bottom-width:1px;">
                        <strong>Cartão de Débito<br /></strong></td>
                </tr>
                <tr style="border-bottom-color:gray;
                        border-bottom-style:solid; border-bottom-width:1px;">
                    <td style="width: 20%;">
                        <center>
                        <img src="<?=$this->config->item('assets')?>images/payment/visa.png" alt="Visa" width="80px" height="80px"/>
                        <br>
                        <input type="radio" style="width:20px; height:20px;" name="card_flag" checked value="visa">
                        </center>
                    </td>
                    <td style="width: 20%;">
                        <center>
                        <img src="<?=$this->config->item('assets')?>images/payment/mastercard.png" alt="MasterCard" width="80px" height="80px"/>
                        <br>
                        <input type="radio" style="width:20px; height:20px;" name="card_flag" value="mastercard">
                        </center>
                    </td>
                    <td style="width: 20%;border-right-style:solid; border-right-color:gray; border-right-width:1px">
                        <center>
                        <img src="<?=$this->config->item('assets')?>images/payment/amex.png" alt="American Express" width="80px" height="80px"/>
                        <br>
                        <input type="radio" style="width:20px; height:20px;" name="card_flag" value="amex">
                        </center>
                    </td>
                
                    <td style="width: 20%;">
                        <center>
                        <img src="<?=$this->config->item('assets')?>images/payment/visaelectron.png" alt="Visa Electron" width="68px" style="margin-top:20px" />
                        <br>
                        <input type="radio" style="width:20px; height:20px;" name="card_flag" value="visaelectron">
                        </center>
                    </td>
                
                    <td style="width: 20%;">
                        <center>
                        <img src="<?=$this->config->item('assets')?>images/payment/maestro.png" alt="MasterCard Maestro" width="80px" height="80px"/>
                        <br>
                        <input type="radio" style="width:20px; height:20px;" name="card_flag" value="maestro">
                        </center>
                    </td>
                
                </tr>
                <tr>
                    <td colspan='6'>
                        &nbsp;
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>Valor da doação:</strong><br/>
                    </td>
                    <td colspan='2'>
                        <p>R$ <?=number_format($donation->getDonatedValue(), 2, ',', '.')?></p>
                         <!--Onblur="verificaValor(this)"-->
                    </td>
                    <td>
                        <strong>Número de parcelas:</strong><br/>
                    </td>
                    <td colspan='2'>
                        <?php if($portions == 1) { ?>
                            <select class="form-control" id="payment_portions" name="payment_portions" disabled> 
                                <option value="1" selected>1</option>
                            </select>
                        <?php } else { ?>
                        <select class="form-control" id="payment_portions" name="payment_portions">
                            <option value="" selected>----</option>
                            <?php 
                                for($i = 1; $i <= $portions; $i++) { 
                            ?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?php
                                }
                            }
                            ?>
                        </select> 
                    </td>
                </tr>   

                <tr>
                    <td colspan='5'>
                        <br/>
                        <center>
                            <button type="button" onClick="verificaParcelas()" class="btn btn-primary">
                                Prosseguir com a doação.
                            </button>
                        </center>
                        <input type="hidden" name="description" value="<?=$donation->getDonationType() ?>">
                        <input type="hidden" name="donation_id" value="<?=$donation->getDonationId() ?>">
                        
                    </td>
                </tr>  
                <tr>
                    <td colspan='5'>
                        <br/>
                        <center>
                            <button type="button" class="btn btn-danger" onClick="history.back(-1)">
                                Não desejo prosseguir com a doação agora.
                            </button>
                        </center>                
                    </td>
                </tr>  

            </table>
        </form>
    </div>
</div>