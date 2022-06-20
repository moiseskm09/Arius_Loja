function chkMaskINTEGER(field,event) {
	var ns = ((document.layers || document.getElementById) && (!document.all));
	var ie = document.all;
	var keySet = '0123456789';
	var actionSet = '0,8,13';
	var keyCode = (ie) ? window.event.keyCode : event.which;
	var key = String.fromCharCode(keyCode);
	if ((keySet.indexOf(key) == -1) && (actionSet.indexOf(keyCode) == -1)) {
		return false;
	} else {
		return true;
	}
}