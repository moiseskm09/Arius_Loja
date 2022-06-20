function chkMaskDATE(field,event) {
	var ns = ((document.layers || document.getElementById) && (!document.all));
	var ie = document.all;
	var keySet = '0123456789/';
	var actionSet = '0,8,13';
	var keyCode = (ie) ? window.event.keyCode : event.which;
	var key = String.fromCharCode(keyCode);
	if ((keySet.indexOf(key) == -1) && (actionSet.indexOf(keyCode) == -1)) {
		return false;
	} else {
		if ((field.value.length == 10) && (actionSet.indexOf(keyCode) == -1) && field.selectionEnd==0) {
			return false;
		} else if (key == '/') {
			if (((field.value.length == 1) || (field.value.length == 4)) && (field.value.charAt(field.value.length-1) != '0')) {
				field.value = field.value.substr(0,field.value.length-1) + '0' + field.value.substr(field.value.length-1,1);
				return true;
			} else if ((field.value.length != 2) && (field.value.length != 5)) {
				return false;
			}
		} else if (actionSet.indexOf(keyCode) != -1) {
			return true;
		} else {
			if ((field.value.length == 2) || (field.value.length == 5)) {
				field.value = field.value + '/';
				return true;
			}
		}
	}
}

function checkDATE(s){
	if (s.length == 0) {
		return true;
	}

	var objRegExp = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/
	if(!objRegExp.test(s)) {
		return false; //doesn't match pattern, bad date
	}

	d = parseInt(s.substr(0, 2), 10);
	m = parseInt(s.substr(3, 2), 10);
	y = parseInt(s.substr(6, 4), 10);

	bin_m = (1 << (m-1));

	// 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31
	m31 = 0xAD5;

	if (( y < 1000) || (m < 1) || (m > 12) || (d < 1) || (d > 31) || ((d == 31 && ((bin_m & m31) == 0))) || ((d == 30 && m == 2)) || ((d == 29 && m == 2 && !isLeap(y))) ) {
		return false;
	}
	return true;
}

function isLeap(year) {
	return (year % 4 == 0) && (year % 100 != 0 || year % 400 == 0);
}