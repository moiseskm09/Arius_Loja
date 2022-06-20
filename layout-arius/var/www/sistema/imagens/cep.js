function chkMaskCEP(objeto){
  keySet = '0123456789-';
  key = String.fromCharCode(event.keyCode);
   if ((keySet.indexOf(key) == -1) && (event.keyCode != 13))
      return false;
    val = event.srcElement;
	if (objeto.value.indexOf("-") == -1 && objeto.value.length > 5){ objeto.value = ""; }
	if (objeto.value.length == 5){
		objeto.value += "-";
	}
}