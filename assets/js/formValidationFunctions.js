function validateEmail(x){
	//var x = document.forms["signup_form"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Este e-mail não é válido.");
        return false;
    }

    return true;
}

function validateNotEmptyField(x){
    //var x = document.forms["signup_form"]["fullname"].value;
    if (x==null || x=="") {
        alert("O campo Nome é obrigatório.");
        return false;
    }

    return true;
}

function validateEmail(formName, emailFieldName, emailFieldUserName){
    var x = document.forms[formName][emailFieldName].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Este " + emailFieldUserName + " não é válido.");
        return false;
    }

    return true;
}

function validateNotEmptyField(formName, fieldName, fieldUserName){
    var x = document.forms[formName][fieldName].value;
    if (x==null || x=="") {
        alert("O campo " + fieldUserName + " é obrigatório.");
        return false;
    }

    return true;
}

function confirmField(field, confirmField, fieldUserName) {
    var field = document.getElementById(field).value
    var confField = document.getElementById(confirmField).value
    if(field != confField) {
        alert("Por favor, confirme " + fieldUserName + ".");
        return false;
    }

    return true;
}

function confirmPassword(password, confPassword) {
    var pass1 = document.getElementById(password).value;
    var pass2 = document.getElementById(confPassword).value;
    var ok = true;
    if (pass1 != pass2) {
        alert("O campo Senha não confere com o campo Confirmação de senha.");
        ok = false;
    }

    return ok;
}

jQuery.webshims.polyfill('forms');