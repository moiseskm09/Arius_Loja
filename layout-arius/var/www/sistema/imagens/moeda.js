function chkMaskMOEDA(field,event) {
	var ns = ((document.layers || document.getElementById) && (!document.all));
	var ie = document.all;
	var keySet = '-0123456789';
	var actionSet = '0,8,13';
	var keyCode = (ie) ? window.event.keyCode : event.which;
	var key = String.fromCharCode(keyCode);
	var negative = false;
	var fieldValue = field.value;
	var newValue = "";
	if ((parseFloat(fieldValue) < 0) || (field.value.charAt(0) == "-")) {
		negative = true;
	}
	if ((keySet.indexOf(key) == -1) && (actionSet.indexOf(keyCode) == -1)) {
		return false;
	} else if (actionSet.indexOf(keyCode) != -1) {
		return true;
	} else if (field.value.length == field.maxLength) {
		return false;
	} else if ((key == "-") && (field.value.length > 0)) {
		return false;
	} else {
		fieldValue = field.value.replace(".","");
		fieldValue = fieldValue.replace("-","");
		while (fieldValue.indexOf('.') != -1) fieldValue = fieldValue.replace(".","");
		var inicio   = fieldValue.substr(0,((fieldValue.length-1)%3));
		var centavos = fieldValue.substr(fieldValue.length-1,1);
		var resto    = fieldValue.substr(((fieldValue.length-1)%3),fieldValue.length-1-((fieldValue.length-1)%3));

		if (negative) {
			newValue = newValue + "-";
		}
		if (inicio != "") {
			newValue = newValue + inicio;
		}
		for (i=0; i<resto.length; i++) {
			if (((i>0) && ((i%3)==0)) || ((i==0) && (inicio != ""))) {
				newValue = newValue + '';
			}
			newValue = newValue + resto.charAt(i);
		}
		if (fieldValue.length >= 2) {
			newValue = newValue + '.';
		}
		newValue = newValue + centavos;
		field.value = newValue;
	}
/*     keySet = '0123456789';
    key = String.fromCharCode(event.keyCode);
    if ((keySet.indexOf(key) == -1) && (event.keyCode != 13))
      return false;
    val = event.srcElement;
    size = tam_campo(val);
    if (size <= 18) val = retira_chars(val);
    size = tam_campo(val);
    if (size > 18) return false;
    if ((size >= 3) && (size <= 5))
      val.value = val.value.substr(0,size-2) + ',' + val.value.substr(size-2,1);
    if ((size >= 6) && (size <= 8))
      val.value = val.value.substr(0,size-5) + '.' + val.value.substr(size-5,3) + ',' + val.value.substr(size-2,1);
    if ((size >= 9) && (size <= 11))
      val.value = val.value.substr(0,size-8) + '.' + val.value.substr(size-8,3) + '.' + val.value.substr(size-5,3) + ',' + val.value.substr(size-2,1);
    if ((size >= 12) && (size <= 14))
      val.value = val.value.substr(0,size-11) + '.' + val.value.substr(size-11,3) + '.' + val.value.substr(size-8,3) + '.' + val.value.substr(size-5,3) + ',' + val.value.substr(size-2,1);
 */
}

function chkMaskMOEDA2(field,event) {
	var ns = ((document.layers || document.getElementById) && (!document.all));
	var ie = document.all;
	var keySet = '-0123456789';
	var actionSet = '0,8,13';
	var keyCode = (ie) ? window.event.keyCode : event.which;
	var key = String.fromCharCode(keyCode);
	var negative = false;
	var fieldValue = field.value;
	var newValue = "";
	if ((parseFloat(fieldValue) < 0) || (field.value.charAt(0) == "-")) {
		negative = true;
	}
	if ((keySet.indexOf(key) == -1) && (actionSet.indexOf(keyCode) == -1)) {
		return false;
	} else if (actionSet.indexOf(keyCode) != -1) {
		return true;
	} else if (field.value.length == field.maxLength) {
		return false;
	} else if ((key == "-") && (field.value.length > 0)) {
		return false;
	} else {
		fieldValue = field.value.replace(".","");
		fieldValue = fieldValue.replace("-","");
		while (fieldValue.indexOf('.') != -1) {
			fieldValue = fieldValue.replace(".","");			
		}
		
		var inicio   = fieldValue.substr(0,((fieldValue.length-1)%3));
		var centavos = fieldValue.substr(fieldValue.length-1,1);
		var resto    = fieldValue.substr(((fieldValue.length-1)%3),fieldValue.length-1-((fieldValue.length-1)%3));

		if (negative) {
			newValue = newValue + "-";
		}
		if (inicio != "") {
			newValue = newValue + inicio;
		}
		for (i=0; i<resto.length; i++) {
			if (((i>0) && ((i%3)==0)) || ((i==0) && (inicio != ""))) {
				newValue = newValue + '.';
			}
			newValue = newValue + resto.charAt(i);
		}
		
		if (fieldValue.length >= 2) {
			newValue = newValue + '.';
		}
		newValue = newValue + centavos;
		field.value = newValue;
	}
}