function windowOpen(mypage, myname, w, h, scroll) {
	var winl = (screen.width - w) / 2;
	var wint = (screen.height - h) / 2;
	
	winprops = "height=" + h + ", width=" + w + ", top=" + wint + ", left=" + winl + ", scrollbars=" + scroll + ", resizable";

	win = window.open(mypage, "", winprops);
	
	if (parseInt(navigator.appVersion) >= 4) { 
		win.window.focus(); 
	}
}

 function testeEnter (Event) {
    if (Event.keyCode == 13) {
        return true;
    } else {
        return false;
    }
 }