// Zdroj: https://www.w3schools.com/js/js_cookies.asp
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  
function getCookie(cname) {
    if (checkCookie)
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie(username) {
    let user = getCookie(username);
    if (user != "") {
        return true;
    } else {
        return false;
    }
}

function pridatPolozkuKosiku(knihaID) {
    let cookie = getCookie('kosik');
    if (cookie != '') {
        setCookie(kosik, knihaID, 2);
    } else {
        
    }
}

/*function pridatPolozkuKosiku($kniha_id) { //pridava polozku do kosiku
    $kosik_string = null;
    if (isset($_COOKIE['kosik'])) { // existujici cookie kosiku 
        $kosik_string = $_COOKIE['kosik'];
        if ($kosik_string != '') {
            $kosik_string = $kosik_string . ',' . $kniha_id;
        } else {
            $kosik_string = $kniha_id;
        }
    } else {
        $kosik_string = $kniha_id;
    }

    setcookie('kosik', $kosik_string, time() + 2 * 24 * 60 * 60); // 2 dny na expiraci cookie
}*/