function vPIWS (strValue) // validate Positive Integer With Spaces
{
    var objRegExp = /^\s*\d+\s*$/;
    return objRegExp.test(strValue);
}

function vPINZWS (strValue) // validate Positive Integer Not Zero With Spaces
{
    var objRegExp = /^\s*0*([1-9]\d*)\s*$/;
    return objRegExp.test(strValue);
}

function vINN (strValue) // validate Is Not Null
{
    var objRegExp = /\w/;
    return objRegExp.test(strValue);
}

function vPFNZ (strValue) // validate Positive Float Not Zero
{
    var objRegExp = /^\d+([.,]\d\d?)?$/;

    if (objRegExp.test(strValue)) {
        if (strValue.replace(",", ".") + 0 == 0) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function vPFWS (strValue) // validate Positive Float
{
    var objRegExp = /^\d+([.,]\d\d?)?$/;

    if (objRegExp.test(strValue)) {
        return true;
    } else {
        return false;
    }
}

function vPFWS3 (strValue) // validate Positive Float
{
    var objRegExp = /^\d+([.,]\d\d\d?)?$/;

    if (objRegExp.test(strValue)) {
        return true;
    } else {
        return false;
    }
}

function vPINZWSW1U3 (strValue) // validate Positive Integer Not Zero With Spaces With 1 until 3 digits
{
    var objRegExp = /^\s*0*([1-9]\d?\d?)\s*$/;
    return objRegExp.test(strValue);
}

function vPINZWSW1U4 (strValue) // validate Positive Integer Not Zero With Spaces With 1 until 4 digits
{
    var objRegExp = /^\s*0*([1-9]\d?\d?\d?)\s*$/;
    return objRegExp.test(strValue);
}

function vPINZWSW1U6 (strValue) // validate Positive Integer Not Zero With Spaces With 1 until 6 digits
{
    var objRegExp = /^\s*0*([1-9]\d?\d?\d?\d?\d?)\s*$/;
    return objRegExp.test(strValue);
}

function valida_cpf (cpf)
{
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;

    if (cpf.length < 11) {
        return false;
    }
    for (i = 0; i < cpf.length - 1; i++) {
        if (cpf.charAt(i) != cpf.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    }

    if (!digitos_iguais) {
        numeros = cpf.substring(0,9);
        digitos = cpf.substring(9);
        soma = 0;
        for (i = 10; i > 1; i--) {
            soma += numeros.charAt(10 - i) * i;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)) {
            return false;
        }
        numeros = cpf.substring(0,10);
        soma = 0;
        for (i = 11; i > 1; i--) {
            soma += numeros.charAt(11 - i) * i;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1)) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function valida_cnpj (cnpj)
{
    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    digitos_iguais = 1;

    if (cnpj.length < 14 && cnpj.length < 15) {
        return false;
    }

    for (i = 0; i < cnpj.length - 1; i++) {
        if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    }

    if (!digitos_iguais) {
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) {
                pos = 9;
            }
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)) {
            return false;
        }

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) {
                pos = 9;
            }
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1)) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}