<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>
        
        <?php include_once APPPATH . 'libraries/logger.php'; 
        	include_once 'system/core/Loader.php';
        ?>
        
        

        <link href="<?= $this->config->item('assets'); ?>css/basic.css" rel="stylesheet" />
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css">
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
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>datatable/js/datatable.min.js"></script>
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>datatable/css/datatable-bootstrap.min.css" />
        
        <script>

        var defaultDiacriticsRemovalap = [
                                                                                    {'base':'A', 'letters':'\u0041\u24B6\uFF21\u00C0\u00C1\u00C2\u1EA6\u1EA4\u1EAA\u1EA8\u00C3\u0100\u0102\u1EB0\u1EAE\u1EB4\u1EB2\u0226\u01E0\u00C4\u01DE\u1EA2\u00C5\u01FA\u01CD\u0200\u0202\u1EA0\u1EAC\u1EB6\u1E00\u0104\u023A\u2C6F'},
                                                                                    {'base':'AA','letters':'\uA732'},
                                                                                    {'base':'AE','letters':'\u00C6\u01FC\u01E2'},
                                                                                    {'base':'AO','letters':'\uA734'},
                                                                                    {'base':'AU','letters':'\uA736'},
                                                                                    {'base':'AV','letters':'\uA738\uA73A'},
                                                                                    {'base':'AY','letters':'\uA73C'},
                                                                                    {'base':'B', 'letters':'\u0042\u24B7\uFF22\u1E02\u1E04\u1E06\u0243\u0182\u0181'},
                                                                                    {'base':'C', 'letters':'\u0043\u24B8\uFF23\u0106\u0108\u010A\u010C\u00C7\u1E08\u0187\u023B\uA73E'},
                                                                                    {'base':'D', 'letters':'\u0044\u24B9\uFF24\u1E0A\u010E\u1E0C\u1E10\u1E12\u1E0E\u0110\u018B\u018A\u0189\uA779'},
                                                                                    {'base':'DZ','letters':'\u01F1\u01C4'},
                                                                                    {'base':'Dz','letters':'\u01F2\u01C5'},
                                                                                    {'base':'E', 'letters':'\u0045\u24BA\uFF25\u00C8\u00C9\u00CA\u1EC0\u1EBE\u1EC4\u1EC2\u1EBC\u0112\u1E14\u1E16\u0114\u0116\u00CB\u1EBA\u011A\u0204\u0206\u1EB8\u1EC6\u0228\u1E1C\u0118\u1E18\u1E1A\u0190\u018E'},
                                                                                    {'base':'F', 'letters':'\u0046\u24BB\uFF26\u1E1E\u0191\uA77B'},
                                                                                    {'base':'G', 'letters':'\u0047\u24BC\uFF27\u01F4\u011C\u1E20\u011E\u0120\u01E6\u0122\u01E4\u0193\uA7A0\uA77D\uA77E'},
                                                                                    {'base':'H', 'letters':'\u0048\u24BD\uFF28\u0124\u1E22\u1E26\u021E\u1E24\u1E28\u1E2A\u0126\u2C67\u2C75\uA78D'},
                                                                                    {'base':'I', 'letters':'\u0049\u24BE\uFF29\u00CC\u00CD\u00CE\u0128\u012A\u012C\u0130\u00CF\u1E2E\u1EC8\u01CF\u0208\u020A\u1ECA\u012E\u1E2C\u0197'},
                                                                                    {'base':'J', 'letters':'\u004A\u24BF\uFF2A\u0134\u0248'},
                                                                                    {'base':'K', 'letters':'\u004B\u24C0\uFF2B\u1E30\u01E8\u1E32\u0136\u1E34\u0198\u2C69\uA740\uA742\uA744\uA7A2'},
                                                                                    {'base':'L', 'letters':'\u004C\u24C1\uFF2C\u013F\u0139\u013D\u1E36\u1E38\u013B\u1E3C\u1E3A\u0141\u023D\u2C62\u2C60\uA748\uA746\uA780'},
                                                                                    {'base':'LJ','letters':'\u01C7'},
                                                                                    {'base':'Lj','letters':'\u01C8'},
                                                                                    {'base':'M', 'letters':'\u004D\u24C2\uFF2D\u1E3E\u1E40\u1E42\u2C6E\u019C'},
                                                                                    {'base':'N', 'letters':'\u004E\u24C3\uFF2E\u01F8\u0143\u00D1\u1E44\u0147\u1E46\u0145\u1E4A\u1E48\u0220\u019D\uA790\uA7A4'},
                                                                                    {'base':'NJ','letters':'\u01CA'},
                                                                                    {'base':'Nj','letters':'\u01CB'},
                                                                                    {'base':'O', 'letters':'\u004F\u24C4\uFF2F\u00D2\u00D3\u00D4\u1ED2\u1ED0\u1ED6\u1ED4\u00D5\u1E4C\u022C\u1E4E\u014C\u1E50\u1E52\u014E\u022E\u0230\u00D6\u022A\u1ECE\u0150\u01D1\u020C\u020E\u01A0\u1EDC\u1EDA\u1EE0\u1EDE\u1EE2\u1ECC\u1ED8\u01EA\u01EC\u00D8\u01FE\u0186\u019F\uA74A\uA74C'},
                                                                                    {'base':'OI','letters':'\u01A2'},
                                                                                    {'base':'OO','letters':'\uA74E'},
                                                                                    {'base':'OU','letters':'\u0222'},
                                                                                    {'base':'OE','letters':'\u008C\u0152'},
                                                                                    {'base':'oe','letters':'\u009C\u0153'},
                                                                                    {'base':'P', 'letters':'\u0050\u24C5\uFF30\u1E54\u1E56\u01A4\u2C63\uA750\uA752\uA754'},
                                                                                    {'base':'Q', 'letters':'\u0051\u24C6\uFF31\uA756\uA758\u024A'},
                                                                                    {'base':'R', 'letters':'\u0052\u24C7\uFF32\u0154\u1E58\u0158\u0210\u0212\u1E5A\u1E5C\u0156\u1E5E\u024C\u2C64\uA75A\uA7A6\uA782'},
                                                                                    {'base':'S', 'letters':'\u0053\u24C8\uFF33\u1E9E\u015A\u1E64\u015C\u1E60\u0160\u1E66\u1E62\u1E68\u0218\u015E\u2C7E\uA7A8\uA784'},
                                                                                    {'base':'T', 'letters':'\u0054\u24C9\uFF34\u1E6A\u0164\u1E6C\u021A\u0162\u1E70\u1E6E\u0166\u01AC\u01AE\u023E\uA786'},
                                                                                    {'base':'TZ','letters':'\uA728'},
                                                                                    {'base':'U', 'letters':'\u0055\u24CA\uFF35\u00D9\u00DA\u00DB\u0168\u1E78\u016A\u1E7A\u016C\u00DC\u01DB\u01D7\u01D5\u01D9\u1EE6\u016E\u0170\u01D3\u0214\u0216\u01AF\u1EEA\u1EE8\u1EEE\u1EEC\u1EF0\u1EE4\u1E72\u0172\u1E76\u1E74\u0244'},
                                                                                    {'base':'V', 'letters':'\u0056\u24CB\uFF36\u1E7C\u1E7E\u01B2\uA75E\u0245'},
                                                                                    {'base':'VY','letters':'\uA760'},
                                                                                    {'base':'W', 'letters':'\u0057\u24CC\uFF37\u1E80\u1E82\u0174\u1E86\u1E84\u1E88\u2C72'},
                                                                                    {'base':'X', 'letters':'\u0058\u24CD\uFF38\u1E8A\u1E8C'},
                                                                                    {'base':'Y', 'letters':'\u0059\u24CE\uFF39\u1EF2\u00DD\u0176\u1EF8\u0232\u1E8E\u0178\u1EF6\u1EF4\u01B3\u024E\u1EFE'},
                                                                                    {'base':'Z', 'letters':'\u005A\u24CF\uFF3A\u0179\u1E90\u017B\u017D\u1E92\u1E94\u01B5\u0224\u2C7F\u2C6B\uA762'},
                                                                                    {'base':'a', 'letters':'\u0061\u24D0\uFF41\u1E9A\u00E0\u00E1\u00E2\u1EA7\u1EA5\u1EAB\u1EA9\u00E3\u0101\u0103\u1EB1\u1EAF\u1EB5\u1EB3\u0227\u01E1\u00E4\u01DF\u1EA3\u00E5\u01FB\u01CE\u0201\u0203\u1EA1\u1EAD\u1EB7\u1E01\u0105\u2C65\u0250'},
                                                                                    {'base':'aa','letters':'\uA733'},
                                                                                    {'base':'ae','letters':'\u00E6\u01FD\u01E3'},
                                                                                    {'base':'ao','letters':'\uA735'},
                                                                                    {'base':'au','letters':'\uA737'},
                                                                                    {'base':'av','letters':'\uA739\uA73B'},
                                                                                    {'base':'ay','letters':'\uA73D'},
                                                                                    {'base':'b', 'letters':'\u0062\u24D1\uFF42\u1E03\u1E05\u1E07\u0180\u0183\u0253'},
                                                                                    {'base':'c', 'letters':'\u0063\u24D2\uFF43\u0107\u0109\u010B\u010D\u00E7\u1E09\u0188\u023C\uA73F\u2184'},
                                                                                    {'base':'d', 'letters':'\u0064\u24D3\uFF44\u1E0B\u010F\u1E0D\u1E11\u1E13\u1E0F\u0111\u018C\u0256\u0257\uA77A'},
                                                                                    {'base':'dz','letters':'\u01F3\u01C6'},
                                                                                    {'base':'e', 'letters':'\u0065\u24D4\uFF45\u00E8\u00E9\u00EA\u1EC1\u1EBF\u1EC5\u1EC3\u1EBD\u0113\u1E15\u1E17\u0115\u0117\u00EB\u1EBB\u011B\u0205\u0207\u1EB9\u1EC7\u0229\u1E1D\u0119\u1E19\u1E1B\u0247\u025B\u01DD'},
                                                                                    {'base':'f', 'letters':'\u0066\u24D5\uFF46\u1E1F\u0192\uA77C'},
                                                                                    {'base':'g', 'letters':'\u0067\u24D6\uFF47\u01F5\u011D\u1E21\u011F\u0121\u01E7\u0123\u01E5\u0260\uA7A1\u1D79\uA77F'},
                                                                                    {'base':'h', 'letters':'\u0068\u24D7\uFF48\u0125\u1E23\u1E27\u021F\u1E25\u1E29\u1E2B\u1E96\u0127\u2C68\u2C76\u0265'},
                                                                                    {'base':'hv','letters':'\u0195'},
                                                                                    {'base':'i', 'letters':'\u0069\u24D8\uFF49\u00EC\u00ED\u00EE\u0129\u012B\u012D\u00EF\u1E2F\u1EC9\u01D0\u0209\u020B\u1ECB\u012F\u1E2D\u0268\u0131'},
                                                                                    {'base':'j', 'letters':'\u006A\u24D9\uFF4A\u0135\u01F0\u0249'},
                                                                                    {'base':'k', 'letters':'\u006B\u24DA\uFF4B\u1E31\u01E9\u1E33\u0137\u1E35\u0199\u2C6A\uA741\uA743\uA745\uA7A3'},
                                                                                    {'base':'l', 'letters':'\u006C\u24DB\uFF4C\u0140\u013A\u013E\u1E37\u1E39\u013C\u1E3D\u1E3B\u017F\u0142\u019A\u026B\u2C61\uA749\uA781\uA747'},
                                                                                    {'base':'lj','letters':'\u01C9'},
                                                                                    {'base':'m', 'letters':'\u006D\u24DC\uFF4D\u1E3F\u1E41\u1E43\u0271\u026F'},
                                                                                    {'base':'n', 'letters':'\u006E\u24DD\uFF4E\u01F9\u0144\u00F1\u1E45\u0148\u1E47\u0146\u1E4B\u1E49\u019E\u0272\u0149\uA791\uA7A5'},
                                                                                    {'base':'nj','letters':'\u01CC'},
                                                                                    {'base':'o', 'letters':'\u006F\u24DE\uFF4F\u00F2\u00F3\u00F4\u1ED3\u1ED1\u1ED7\u1ED5\u00F5\u1E4D\u022D\u1E4F\u014D\u1E51\u1E53\u014F\u022F\u0231\u00F6\u022B\u1ECF\u0151\u01D2\u020D\u020F\u01A1\u1EDD\u1EDB\u1EE1\u1EDF\u1EE3\u1ECD\u1ED9\u01EB\u01ED\u00F8\u01FF\u0254\uA74B\uA74D\u0275'},
                                                                                    {'base':'oi','letters':'\u01A3'},
                                                                                    {'base':'ou','letters':'\u0223'},
                                                                                    {'base':'oo','letters':'\uA74F'},
                                                                                    {'base':'p','letters':'\u0070\u24DF\uFF50\u1E55\u1E57\u01A5\u1D7D\uA751\uA753\uA755'},
                                                                                    {'base':'q','letters':'\u0071\u24E0\uFF51\u024B\uA757\uA759'},
                                                                                    {'base':'r','letters':'\u0072\u24E1\uFF52\u0155\u1E59\u0159\u0211\u0213\u1E5B\u1E5D\u0157\u1E5F\u024D\u027D\uA75B\uA7A7\uA783'},
                                                                                    {'base':'s','letters':'\u0073\u24E2\uFF53\u00DF\u015B\u1E65\u015D\u1E61\u0161\u1E67\u1E63\u1E69\u0219\u015F\u023F\uA7A9\uA785\u1E9B'},
                                                                                    {'base':'t','letters':'\u0074\u24E3\uFF54\u1E6B\u1E97\u0165\u1E6D\u021B\u0163\u1E71\u1E6F\u0167\u01AD\u0288\u2C66\uA787'},
                                                                                    {'base':'tz','letters':'\uA729'},
                                                                                    {'base':'u','letters': '\u0075\u24E4\uFF55\u00F9\u00FA\u00FB\u0169\u1E79\u016B\u1E7B\u016D\u00FC\u01DC\u01D8\u01D6\u01DA\u1EE7\u016F\u0171\u01D4\u0215\u0217\u01B0\u1EEB\u1EE9\u1EEF\u1EED\u1EF1\u1EE5\u1E73\u0173\u1E77\u1E75\u0289'},
                                                                                    {'base':'v','letters':'\u0076\u24E5\uFF56\u1E7D\u1E7F\u028B\uA75F\u028C'},
                                                                                    {'base':'vy','letters':'\uA761'},
                                                                                    {'base':'w','letters':'\u0077\u24E6\uFF57\u1E81\u1E83\u0175\u1E87\u1E85\u1E98\u1E89\u2C73'},
                                                                                    {'base':'x','letters':'\u0078\u24E7\uFF58\u1E8B\u1E8D'},
                                                                                    {'base':'y','letters':'\u0079\u24E8\uFF59\u1EF3\u00FD\u0177\u1EF9\u0233\u1E8F\u00FF\u1EF7\u1E99\u1EF5\u01B4\u024F\u1EFF'},
                                                                                    {'base':'z','letters':'\u007A\u24E9\uFF5A\u017A\u1E91\u017C\u017E\u1E93\u1E95\u01B6\u0225\u0240\u2C6C\uA763'}
                                                                                ];
                                          
                                                                                var diacriticsMap = {};
                                                                                for (var i=0; i < defaultDiacriticsRemovalap.length; i++){
                                                                                    var letters = defaultDiacriticsRemovalap[i].letters;
                                                                                    for (var j=0; j < letters.length ; j++){
                                                                                        diacriticsMap[letters[j]] = defaultDiacriticsRemovalap[i].base;
                                                                                        
                                                                                    }
                                                                                }
                                          
                                                                                // "what?" version ... http://jsperf.com/diacritics/12
                                                                                function removeDiacritics (str) {
                                                                                    return str.replace(/[^\u0000\u007E]/g, function(a){ 
                                                                                       return diacriticsMap[a] || a; 
                                                                                    });
                                                                                }   


            function post(path, params, method) {
                method = method || "post"; // Set method to post by default if not specified.

                // The rest of this code assumes you are not using a library.
                // It can be made less wordy if you use one.
                var form = document.createElement("form");
                form.setAttribute("method", method);
                form.setAttribute("action", path);

                for (var key in params) {
                    if (params.hasOwnProperty(key)) {
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", key);
                        hiddenField.setAttribute("value", params[key]);
                        form.appendChild(hiddenField);
                    }
                }

                document.body.appendChild(form);
                form.submit();
            }

            function getCSVName(type) {
            	var filtroColonia = $("#colonia option:selected").text();
    			var filtroGenero = $("#pavilhao option:selected").text();
    			var filtroGeneroVal = $("#pavilhao option:selected").val();
    			var filtroQuarto = $("#room").val();
    			var nomePadrao = type.concat("");

    			if(filtroQuarto == 0)
        			filtroQuarto = "Sem-Quarto".concat(filtroGenero);
        		else if(filtroQuarto == -1)
            		filtroQuarto = "Todos-os-Quartos".concat(filtroGenero);
            	else {
                	filtroQuarto = filtroQuarto.concat(filtroGeneroVal);
            	}	

    			nomePadrao = nomePadrao.concat(filtroQuarto);
    			nomePadrao = nomePadrao.concat("-");	
    			return nomePadrao.concat(filtroColonia);   			
            }

            function getFilters() {
            	var filtroColonia = $("#colonia option:selected").text();
    			var filtroGenero = $("#pavilhao option:selected").text();
    			var filtroGeneroVal = $("#pavilhao option:selected").val();
    			var filtroQuarto = $("#room").val();
                var saida = [];
                var temp = "";

                if (filtroColonia == false) {
                    saida.push("Colônias: todas");
                }
                else {
                    temp = "Colônia: ";
                    temp = temp.concat(filtroColonia);
                    saida.push(temp);
                }

                if (filtroQuarto == 0) {
                    if(filtroGeneroVal == 'M')
                        temp = "Maculino - ";
                    else
                        temp = "Feminino - ";
                    
                    temp = temp.concat("Sem Quarto");
                    saida.push(temp);
                }
                else if (filtroQuarto == -1) {
                	if(filtroGeneroVal == 'M')
                        temp = "Maculino - ";
                    else
                        temp = "Feminino - ";
                    
                    temp = temp.concat("Todos os Quartos");
                    saida.push(temp);
                }
                else {
                    temp = "Quarto: ";
                    temp = temp.concat(filtroQuarto);
                    temp = temp.concat(filtroGeneroVal);
                    saida.push(temp);
                }
                
                return saida;

            }


            

            function geraAutorizacaoPDF(camp_id){
            	var data = [];
                var table = document.getElementById("tablebody");
                var elements = document.getElementsByName('colonista');
                var tablehead = document.getElementsByTagName("thead")[0];
                var filtroColonia = $("#colonia option:selected").text();
                for (var i = 0, row; row = table.rows[i]; i++) {
                    var data2 = []
                    //Nome, retira pega o que esta entre um <> e outro <>
                    var colonist_id = elements[i].getAttribute('id');

                    data2.push(colonist_id);
                    data.push(data2)
                }
                if (i == 0) {
                    alert('Não há dados para geração da planilha');
                    return;
                }
                var dataToSend = JSON.stringify(data);
                var type = "Vários";

                var filtroGeneroVal = $("#pavilhao option:selected").val();
    			var filtroQuarto = $("#room").val();
    			var nomePadrao = "";

    			if(filtroQuarto == 0)
        			filtroQuarto = "Sem-Quarto";
        		else if(filtroQuarto == -1)
            		filtroQuarto = "Todos-os-Quartos";
            	else {
                	filtroQuarto = filtroQuarto.concat(filtroGeneroVal);
            	}	

            	if(filtroQuarto == "Sem-Quarto" || filtroQuarto == "Todos-os-Quartos")
                	if(filtroGeneroVal == 'M')
                		filtroQuarto = filtroQuarto.concat("-Masculino");
                	else
                		filtroQuarto = filtroQuarto.concat("-Feminino");
            	
    			nomePadrao = nomePadrao.concat("Autorização-de-Viagem-");
    			nomePadrao = nomePadrao.concat(filtroQuarto);
    			nomePadrao = nomePadrao.concat("-");
    			nomePadrao = nomePadrao.concat(filtroColonia);
                
        		post('<?= $this->config->item('url_link'); ?>summercamps/generatePDFTripAuthorization', {name: nomePadrao, data: dataToSend, camp_id: camp_id, type: type});
        	}

            function sendTableToCSV() {
               var data = [];
              var table = document.getElementById("tablebody");
              var name = getCSVName('Email');
               var elements = document.getElementsByName('responsavel');
              var tablehead = document.getElementsByTagName("thead")[0];
                for (var i = 0, row; row = table.rows[i]; i++) {
                  var data2 = []
                  //Nome, retira pega o que esta entre um <> e outro <>
                  var email = elements[i].getAttribute('key');
				var nome = elements[i].getAttribute('id');
				
                   data2.push(email);
                    data2.push(nome);
                   data.push(data2)
              }
             if (i == 0) {
                   alert('Não há dados para geração da planilha');
                   return;
             }
              var dataToSend = JSON.stringify(data);
               var columName = ["Email", "Nome"];
              var columnNameToSend = JSON.stringify(columName);

               post('<?= $this->config->item('url_link'); ?>reports/toCSV', {data: dataToSend, name: name, columName: columnNameToSend});
 							}

            function gerarTXTcomTelefones() {

            	var data1 = [];
                var table = document.getElementById("tablebody");
                var tablehead = document.getElementsByTagName("thead")[0];
                var name = getCSVName('SMS');
                var colonists = document.getElementsByName('colonista');
                var telephoneRes = [];
                var telephoneMom = [];
                var telephoneDad = [];
                var tels = [];
                var names = [];
                var q = 0;
                var n;
                var colonFather;
                var colonMother;
                var colonRes;
                var exist;
                
                var add = 1;
                var colonistsId = document.getElementById("colonistsId").getAttribute('key');
				colonistsId = colonistsId.split("|");

				var colonistsFather = document.getElementById("colonistsFather").getAttribute('key');
				colonistsFather = colonistsFather.split("|"); 

            	var colonistsFatherT = document.getElementById("colonistsFatherT").getAttribute('key');
            	colonistsFatherT = colonistsFatherT.split("|"); 

            	var colonistsMother = document.getElementById("colonistsMother").getAttribute('key');
            	colonistsMother = colonistsMother.split("|");         	            	

				var colonistsMotherT = document.getElementById("colonistsMotherT").getAttribute('key');
				colonistsMotherT = colonistsMotherT.split("|");

				var colonistsResponsable = document.getElementById("colonistsResponsable").getAttribute('key');
				colonistsResponsable = colonistsResponsable.split("|");

				var colonistsResponsableT = document.getElementById("colonistsResponsableT").getAttribute('key');
				colonistsResponsableT = colonistsResponsableT.split("|");
				var data2 = [];

			

				for (var i = 0, row; row = table.rows[i]; i++) {
					data2 = [];
                    var data3 = [];
                    var data4 = [];

					var colonist_id = colonists[i].getAttribute('id');

					for( var j = 0; j < colonists.length ; j++){
						
						if(colonist_id == colonistsId[j]){
							
							if(colonistsFatherT[j] != "" && colonistsFatherT[j] != null){
								n = 0;
								var r = 0;
								add = 1;
								var z = 0;
								exist = false;
								var telephone = colonistsFatherT[j];
								telephone = telephone.split("");

								var telephoneFinal;

								for(var k = 0; k < telephone.length; k++){
									if((telephone[k] == ' ') || (telephone[k] == '(') || (telephone[k] == ')') || (telephone[k] == '+') || (telephone[k] == '-')){
									}
									else if(telephone[k] == "*"){
											telephoneDad[n] = telephoneFinal;
											n++;
									}
									else{
										if(z==0){
											if((telephone[k] + telephone[k + 1]).localeCompare("55") == 0)
												telephoneFinal = telephone[k];
											else
												telephoneFinal = "55" + telephone[k];
												
											z++;
										}
										else
											telephoneFinal = telephoneFinal + telephone[k];
									}
								}

								telephoneDad[n] = telephoneFinal;

								colonFather = colonistsFather[j].split(" ");

								for(var r = 0; r < telephoneDad.length; r++){
									if(telephoneDad[r] != " "){
										for( var s = 0; s < tels.length; s++){
												if(telephoneDad[r].localeCompare(tels[s]) == 0){
													exist = true;
													break;
												}
										}
										if(exist === false){
											tels[q] = telephoneDad[r];
											data2.push(telephoneDad[r]);
											data2.push(removeDiacritics(colonFather[0]));
											data1.push(data2);
											q++;
										}
									}
								}
									
							}

							if(colonistsMotherT[j] != "" && colonistsMotherT[j] != null){
								n = 0;
								add = 1;
								var r = 0;
								var z = 0;
								exist = false;
								var telephone = colonistsMotherT[j];
								telephone = telephone.split("");

								var telephoneFinal;

								for(var k = 0; k < telephone.length; k++){
									if((telephone[k] == ' ') || (telephone[k] == '(') || (telephone[k] == ')') || (telephone[k] == '+') || (telephone[k] == '-')){

									}
									else if(telephone[k] == "*"){
											telephoneMom[n] = telephoneFinal;
											n++;
									}
									else{
										if(z==0){
											if((telephone[k]+telephone[k+1]).localeCompare("55") == 0)
												telephoneFinal = telephone[k];
											else
												telephoneFinal = "55"+telephone[k];
												
											z++;
										}
										else
											telephoneFinal = telephoneFinal + telephone[k];
									}
								}

								telephoneMom[n] = telephoneFinal;
								colonMother = colonistsMother[j].split(" ");

								for(var r = 0; r < telephoneMom.length; r++){
									if(telephoneMom[r] != " "){
										for( var s = 0; s < tels.length; s++){
											if(telephoneMom[r].localeCompare(tels[s]) == 0){
												exist = true;
												break;
											}
										}
										if(exist === false){
											tels[q] = telephoneMom[r];
											data3.push(telephoneMom[r]);
											data3.push(removeDiacritics(colonMother[0]));
											data1.push(data3);
											q++;
										}
									}
								}
							}

							if(colonistsResponsableT[j] != "" && colonistsResponsableT[j] != null){
								n = 0;
								add = 1;
								var r = 0;
								var z = 0;
								exist = false;
								var telephone = colonistsResponsableT[j];
								telephone = telephone.split("");

								var telephoneFinal;

								for(var k = 0; k < telephone.length; k++){
									if((telephone[k] == ' ') || (telephone[k] == '(') || (telephone[k] == ')') || (telephone[k] == '+') || (telephone[k] == '-')){

									}
									else if(telephone[k] == "*"){
											telephoneRes[n] = telephoneFinal;
											n++;
									}
									else{
										if(z==0){
											if((telephone[k]+telephone[k+1]).localeCompare("55") == 0)
												telephoneFinal = telephone[k];
											else
												telephoneFinal = "55"+telephone[k];
												
											z++;
										}
										else
											telephoneFinal = telephoneFinal + telephone[k];
									}
								}

								telephoneRes[n] = telephoneFinal;
								colonRes = colonistsResponsable[j].split(" ");

								for(var r = 0; r < telephoneRes.length; r++){
									if(telephoneRes[r] != " " ){
										for( var s = 0; s < tels.length; s++){
											if(telephoneRes[r].localeCompare(tels[s]) == 0){
												exist = true;
												break;
											}
										}
										if(exist === false){
											tels[q] = telephoneRes[r];
											data4.push(telephoneRes[r]);
											data4.push(removeDiacritics(colonRes[0]));
											data1.push(data4);
											q++;
										}
									}
								}
							}

						}
						
					}
					
				}	

				 if (i == 0) {
	                    alert('Não há dados para geração da planilha');
	                    return;
	                }
	                var dataToSend = JSON.stringify(data1);
	                var columName = [""];
	                var columnNameToSend = JSON.stringify(null);

	                post('<?= $this->config->item('url_link'); ?>reports/toTXT', {data: dataToSend, name: name, columName: columnNameToSend});

            }

            function gerarPDFcomDadosCadastrais(type) {
                var data = [];
                var table = document.getElementById("tablebody");
                var name = getCSVName(type);
                var summercamp = $("#colonia option:selected").text();
                var summercampId = document.getElementById("colonia").getAttribute('key');
                var filtroGeneroVal = $("#pavilhao option:selected").val();
    			var filtroQuarto = $("#room").val();
    			var room;
    			var cadastroType = null;

    			if(filtroQuarto == -1) {
					if(filtroGeneroVal == 'M') {
						room = "Masculino - Todos os Quartos";
					} else {
						room = "Feminino - Todos os Quartos";
					}
    			}
    			else if(filtroQuarto == 0) {
						if(filtroGeneroVal == 'M') {
							room = "Masculino - Sem Quarto";
						} else {
							room = "Feminino - Sem Quarto";
						}					
    			} else {        			
    	    		room = filtroQuarto.concat(filtroGeneroVal);
    			}
                var filtersWindow = getFilters();
                var elements = document.getElementsByName('colonista');
                var tablehead = document.getElementsByTagName("thead")[0];
                for (var i = 0, row; row = table.rows[i]; i++) {
                    var data2 = []
                    //Nome, retira pega o que esta entre um <> e outro <>
                    var email = elements[i].getAttribute('key');

                    data2.push(email);
                    data2.push(row.cells[3].innerHTML.split("<")[1].split(">")[1]);
                    data.push(data2)
                }
                if (i == 0) {
                    alert('Não há dados para geração da planilha');
                    return;
                }
                var dataToSend = JSON.stringify(data);
                var filtersToSend = JSON.stringify(filtersWindow);
                var columName = ["Email", "Nome"];
                var columnNameToSend = JSON.stringify(columName);

               
                post('<?= $this->config->item('url_link'); ?>summercamps/generatePDFWithColonistData', {data: dataToSend, filters: filtersToSend, name: name, columName: columnNameToSend, type: type, summercamp: summercamp, summercampId: summercampId, room: room});
                
            }
            function createPDFMedicalFiles() {
                window.location.href = "<?= $this->config->item('url_link'); ?>summercamps/generatePDFWithColonistMedicalFiles/<?=$ano_escolhido?>/<?=(isset($summer_camp_id)?$summer_camp_id:'')?>/<?=(isset($pavilhao)?$pavilhao:'')?>/<?=(isset($quarto)?$quarto:'')?>/varios";
            }

            function openDisposal(){
            	$("#room").val(-1);
            	
                if($("#pavilhao").val() != "")
                    $(".btn_room_row").show();
                else
                    $(".btn_room_row").hide();

                if($("#anos").val() != null && $("#colonia").val() != 0 && $("#pavilhao").val() != "" && $("#room").val != "") {
                    $("#form_selection").submit();
                }
            }

            function openRoomDisposal( roomFilter ) {
                if($("#anos").val() != null && $("#colonia").val() != 0 && $("#pavilhao").val() != "") {
                    $("#room").val(roomFilter);
                    $("#form_selection").submit();
                } else {
                    alert("Preencha todas as caixas de seleção no topo da tela para seguir");
                }
            }

            var selectTodas = {
                element: null,
                values: "auto",
                empty: "Todas",
                multiple: false,
                noColumn: false,
            }

            var selectTodos = {
                element: null,
                values: "auto",
                empty: "Todos",
                multiple: false,
                noColumn: false,
            }

            function sortLowerCase(l, r) {
                return l.toLowerCase().localeCompare(r.toLowerCase());
            }

            function sortNumber(a,b) {
                return a-b;
            }

            function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
                return 'Apresentando ' + totalRow + ' inscrições, de um total de ' + totalRowUnfiltered + ' inscrições';
            }

        </script>

    </head>
    <body>
        <script>
            $(document).ready(function () {
                $('#sortable-table').datatable({
                    pageSize: Number.MAX_VALUE,
                    sort: [sortLowerCase, sortNumber, false, false],
                    filters: [false],
                    filterText: 'Escreva para filtrar... ',
                    counterText: showCounter
                });

                if($("#room").val() != null)
                    $("#btn_room_"+$("#room").val()).switchClass("btn-default", "btn-primary");
            });
        </script>
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
                     <form id="form_selection" method="GET">
                   Ano: <select name="ano_f" onchange="this.form.submit()" id="anos">
                
                        <?php
                        foreach ( $years as $year ) {
                            $selected = "";
                            if ($ano_escolhido == $year)
                                $selected = "selected";
                            echo "<option $selected value='$year'>$year</option>";
                        }
                        ?>
                    </select>
                    Colônia: <select name="colonia_f" id= "colonia" key="<?php echo $summer_camp_id; ?>" onchange="openDisposal()">
                        <option value="0" <?php if(!isset($colonia_escolhida)) echo "selected"; ?>>Selecionar</option>
                        <?php
                        foreach ( $camps as $camp ) {
                            $selected = "";
                            if ($colonia_escolhida == $camp)
                                $selected = "selected";
                            echo "<option $selected value='$camp'>$camp</option>";
                        }
                        ?>
                    </select>
                   Gênero: <select name="pavilhao" id="pavilhao" onchange="openDisposal()">
                        <option value=""  <?php if(!isset($pavilhao)) echo "selected"; ?>> Selecionar </option>
                        <option value="M" <?php if(isset($pavilhao) && $pavilhao == "M") echo "selected"; ?>> Masculino </option>
                        <option value="F" <?php if(isset($pavilhao) && $pavilhao == "F") echo "selected"; ?>> Feminino </option>
                    </select>

                    <input type="hidden" id="room" name="quarto" value = "<?= (isset($quarto)) ? $quarto : '' ?>" />

                    <br /><br />

                    <div class="btn_room_row" style="<?= ((isset($quarto))?'':'display:none')?>" >
                        <table>
                            <tr>
                                <th> <button class="btn btn-default" id="btn_room_0" style="margin-left:5px" onclick="openRoomDisposal(0)"> Sem Quarto </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_1" style="margin-left:5px" onclick="openRoomDisposal(1)"> 1<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_2" style="margin-left:5px" onclick="openRoomDisposal(2)"> 2<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_3" style="margin-left:5px" onclick="openRoomDisposal(3)"> 3<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_4" style="margin-left:5px" onclick="openRoomDisposal(4)"> 4<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_5" style="margin-left:5px" onclick="openRoomDisposal(5)"> 5<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_6" style="margin-left:5px" onclick="openRoomDisposal(6)"> 6<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_-1" onclick="openRoomDisposal(-1)"> Todos os quartos </button> </th>
                            </tr>
                           <?php if(isset($room_occupation)){ ?>
                                <tr>
                                    <td align="center"><?=$room_occupation[0] ?></td>
                                    <td align="center"><?=$room_occupation[1] ?></td>
                                    <td align="center"><?=$room_occupation[2] ?></td>
                                    <td align="center"><?=$room_occupation[3] ?></td>
                                    <td align="center"><?=$room_occupation[4] ?></td>
                                    <td align="center"><?=$room_occupation[5] ?></td>
                                    <td align="center"><?=$room_occupation[6] ?></td>
                                    <td align="center"><?= $room_occupation[1]+
                                            $room_occupation[2]+
                                            $room_occupation[3]+
                                            $room_occupation[4]+
                                            $room_occupation[5]+
                                            $room_occupation[6] ?>
                                        <img src="<?= $this->config->item('assets') ?>images/kinderland/help.png" width="15" height="15"
                                            title="Número de colonistas por quarto."/>
                                    <td>
                                    
                                </tr>
                            <?php } ?> 
                        </table>
					</div>
					
					
                </form>
            </div>

        </div>

        <?php if(isset($colonists)) { ?>
            <div class = "row">
                <br /><br />

                <div class="col-lg-12">
                  <button class="btn btn-primary" onclick="gerarPDFcomDadosCadastrais('Lista')" value="">Lista</button>&nbsp;<button class="btn btn-primary" onclick="gerarPDFcomDadosCadastrais('Documentos')" value="">Documentos</button>&nbsp;
                  <button class="btn btn-primary" onclick="gerarPDFcomDadosCadastrais('Cadastros')" value="">Cadastros</button>&nbsp;<button class="btn btn-primary" onclick="createPDFMedicalFiles()" value="">Fichas Médicas</button>&nbsp;
                  <button class="btn btn-primary" onclick="geraAutorizacaoPDF('<?=$summer_camp_id?>')" value="">Autorizações</button>&nbsp;<button class="btn btn-primary" onclick="gerarPDFcomDadosCadastrais('Contatos')" value="">Contatos</button>&nbsp;
                  <button class="btn btn-primary" onclick="sendTableToCSV()" value="">E-mails</button>&nbsp;<button class="btn btn-primary" onclick="gerarTXTcomTelefones()" value="">SMS</button>
                  <br /><br />
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 700px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Colonista </th>
                                <th> Idade </th>
                                <th> Data de Nascimento </th>
                                <th> Ano Escolar </th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            
                            $colonistsId = array();
                            $colonistsFather = array();
                            $colonistsFatherE = array();
                            $colonistsFatherT = array();
                            $colonistsMother = array();
                            $colonistsMotherE = array();
                            $colonistsMotherT = array();
                            $colonistsResponsable = array();
                            $colonistsResponsableE = array();
                            $colonistsResponsableT = array();
                            
                            $k = 0;
                            
                            foreach ($colonists as $colonist) { 
                            	$colonistsId[$k] = $colonist -> colonist_id;
                            	$colonistsFather[$k] = $colonist -> fatherName;
                            	$colonistsFatherE[$k] = $colonist -> fatherEmail;
                            	$colonistsFatherT[$k] = $colonist -> fatherTel;
                            	$colonistsMother[$k] = $colonist -> motherName;
                            	$colonistsMotherE[$k] = $colonist -> motherEmail;
                            	$colonistsMotherT[$k] = $colonist -> motherTel;
                            	$colonistsResponsable[$k] = $colonist -> responsableName;
                            	$colonistsResponsableE[$k] = $colonist -> responsableEmail;
                            	$colonistsResponsableT[$k] = $colonist -> responsableTel;
                            	
                            	
                            	$k++;

                            	
                            	?>
                                <tr>
                                    <td><a name= "colonista" id="<?= $colonist->colonist_id ?>" key="<?= $colonist->colonist_id ?>" target="_blank" href="<?= $this->config->item('url_link') ?>admin/viewColonistInfo?type=report&colonistId=<?= $colonist->colonist_id ?>&summerCampId=<?= $colonist->summer_camp_id ?>"><?= $colonist->colonist_name ?></a></td>
                                    <td><?= explode(" ", $colonist->age)[0] ?></td>
                                    <td><?= date('d/m/Y', strtotime(substr($colonist->birth_date, 0, 10))) ?></td>
                                    <td><a name="responsavel" id="<?= $colonist -> user_name?>" key="<?= $colonist -> email?>"></a><?= $colonist->school_year ?></td>
                                </tr>
                            <?php }
                            
                            
                            $colonistsId = implode("|",$colonistsId);
                            $colonistsFather = implode("|",$colonistsFather);
                            $colonistsFatherE = implode("|",$colonistsFatherE);
                            $colonistsFatherT = implode("|",$colonistsFatherT);
                            $colonistsMother = implode("|",$colonistsMother);
                            $colonistsMotherE = implode("|",$colonistsMotherE);
                            $colonistsMotherT = implode("|",$colonistsMotherT);
                            $colonistsResponsable = implode("|",$colonistsResponsable);
                            $colonistsResponsableE = implode("|",$colonistsResponsableE);
                            $colonistsResponsableT = implode("|",$colonistsResponsableT);

                            
                           
                            ?>  
                            
                            <div id="colonistsId" key="<?php echo $colonistsId;?>" style = "display:none"></div>
                            <div id="colonistsFather" key="<?php echo $colonistsFather;?>" style = "display:none"></div>
                            <div id="colonistsFatherE" key="<?php echo $colonistsFatherE;?>" style = "display:none"></div>
                            <div id="colonistsFatherT" key="<?php echo $colonistsFatherT;?>" style = "display:none"></div>
                            <div id="colonistsMother" key="<?php echo $colonistsMother;?>" style = "display:none"></div>
                            <div id="colonistsMotherE" key="<?php echo $colonistsMotherE;?>" style = "display:none"></div>
                            <div id="colonistsMotherT"  key="<?php echo $colonistsMotherT;?>" style = "display:none"></div>
                            <div id="colonistsResponsable" key="<?php echo $colonistsResponsable;?>" style = "display:none"></div>
                            <div id="colonistsResponsableE" key="<?php echo $colonistsResponsableE;?>" style = "display:none"></div>
                            <div id="colonistsResponsableT"  key="<?php echo $colonistsResponsableT;?>" style = "display:none"></div>
 

                        </tbody>
                    </table>
                </div>
            </div>
		<?php } ?>
    </div>
</div>
