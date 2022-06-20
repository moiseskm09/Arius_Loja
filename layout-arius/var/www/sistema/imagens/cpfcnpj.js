  function checkCPFCNPJ(s)
  {
		if(s == '') {
			return true;
		}
		if (s.length == 14)
    {
       soma1 = (s.charAt(0) * 5) +
               (s.charAt(1) * 4) +
               (s.charAt(2) * 3) +
               (s.charAt(3) * 2) +
               (s.charAt(4) * 9) +
               (s.charAt(5) * 8) +
               (s.charAt(6) * 7) +
               (s.charAt(7) * 6) +
               (s.charAt(8) * 5) +
               (s.charAt(9) * 4) +
               (s.charAt(10) * 3) +
               (s.charAt(11) * 2);
       resto = soma1 % 11;
       digito1 = resto < 2 ? 0 : 11 - resto;
       soma2 = (s.charAt(0) * 6) +
               (s.charAt(1) * 5) +
               (s.charAt(2) * 4) +
               (s.charAt(3) * 3) +
               (s.charAt(4) * 2) +
               (s.charAt(5) * 9) +
               (s.charAt(6) * 8) +
               (s.charAt(7) * 7) +
               (s.charAt(8) * 6) +
               (s.charAt(9) * 5) +
               (s.charAt(10) * 4) +
               (s.charAt(11) * 3) +
               (s.charAt(12) * 2);
       resto = soma2 % 11;
       digito2 = resto < 2 ? 0 : 11 - resto;
       return ((s.charAt(12) == digito1) && (s.charAt(13) == digito2));
    }
    else if (s.length == 11)
    {
       soma1 = (s.charAt(0) * 10) +
               (s.charAt(1) * 9) +
               (s.charAt(2) * 8) +
               (s.charAt(3) * 7) +
               (s.charAt(4) * 6) +
               (s.charAt(5) * 5) +
               (s.charAt(6) * 4) +
               (s.charAt(7) * 3) +
               (s.charAt(8) * 2);
       resto = soma1 % 11;
       digito1 = resto < 2 ? 0 : 11 - resto;
       soma2 = (s.charAt(0) * 11) +
               (s.charAt(1) * 10) +
               (s.charAt(2) * 9) +
               (s.charAt(3) * 8) +
               (s.charAt(4) * 7) +
               (s.charAt(5) * 6) +
               (s.charAt(6) * 5) +
               (s.charAt(7) * 4) +
               (s.charAt(8) * 3) +
               (s.charAt(9) * 2);
       resto = soma2 % 11;
       digito2 = resto < 2 ? 0 : 11 - resto;
       return ((s.charAt(9) == digito1) && (s.charAt(10) == digito2));

    } else {
       return false;
    }

  }

  function chkMaskCPFCNPJ()
  {
		keySet = '0123456789';
		key = String.fromCharCode(event.keyCode);
		if ((keySet.indexOf(key) == -1) && (event.keyCode != 13)) {
				return false;
		}
  }