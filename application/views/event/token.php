<div class="row">
	<div style="width:390px;" class="col-lg-6 col-lg-push-3 login-middle">
				<label for="login" class="col-lg-2 control-label" style="width:120px; margin-top:7px; padding-right:0px"> Digite o Token: </label>
				<div style="width:150px; padding-right:0px " class="col-lg-10">
					<input id="token"  style="width:200px;" type="text" class="form-control" placeholder="Token"
						name="token" />
				</div>
				
				<div style="width:80px; padding-left:0px; margin-top:0px; margin-left:0px" class="col-lg-4 col-lg-offset-2">
					<button class="btn btn-primary" onClick="validateToken()">Entrar</button>
					
				</div>
	</div>
</div>

<script>

	function validateToken(){
		var token = document.getElementById('token').value;

		if(token != ""){
			post('<?= $this->config->item('url_link'); ?>events/validateToken', {token: token},
					function(data){
						if(data !== true){
							alert("Token inválido. Tente novamente.");
							location.reload();
						}
			});

		}

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


</script>