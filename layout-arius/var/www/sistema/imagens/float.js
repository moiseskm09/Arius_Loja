function chkMaskFLOAT(field,event) {
	var ns = ((document.layers || document.getElementById) && (!document.all));
	var ie = document.all;
	var keySet = '0123456789.';
	var actionSet = '0,8,13';
	var keyCode = (ie) ? window.event.keyCode : event.which;
	var key = String.fromCharCode(keyCode);
	if ((keySet.indexOf(key) == -1) && (actionSet.indexOf(keyCode) == -1)) {
		return false;
	} else {
		if ((key == '.') && (field.value.indexOf('.') != -1)) {
			return false;
		} else if ((key == '.') && (field.value == "")) {
			field.value = '0';
			return true;
		} else if ((key == '0') && (field.value.charAt(field.value.length-1) == '0') && (field.value.length == 1)) {
			field.value = field.value + '.';
			return true;
		} else {
			return true;
		}
	}
}
