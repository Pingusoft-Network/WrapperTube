// initialize
var UNIQUE_KEY;
var k;
if (typeof (k) === "undefined") {
	(document.head || document.getElementsByTagName("head")[0]).insertAdjacentHTML('beforeEnd', '<link rel="stylesheet" href="/long_captcha/captcha.css">');
	k = 0;
}
k++;

// setup
UNIQUE_KEY = gen_key();
document.write('\
<table id="ka' + k + '" class="captcha" style="width:auto" cellpadding="0"><tbody>\
	<tr>\
		<td class="ka_challenge">\
			<img class="ka_image" src="" alt="" width="180" height="60">\
		</td>\
		<td class="k_btns" rowspan="2" width="64" height="64" valign="TOP">\
			<small>[<a href="javascript:void(0);" onclick="ka_reload(false);">Reload</a>]</small>\
			<a href="javascript:void(0);" onclick="alert(\'Enter the text you see on the image, then click [Check] to verify your answer. If you cannot read the text, click [Reload].\');" class="ka_q">?</a>\
			<small>[<a href="javascript:void(0);" onclick="ka_check(this);">Check</a>]</small>\
		</td>\
	</tr>\
	<tr>\
		<td valign="BOTTOM">\
			<input size="10" type="text" name="_LONG_CAPTCHA" value="" class="ka_input" placeholder="Please enter the text above" autocomplete="off" />\
			<input type="hidden" name="_LONG_CAPTCHA_KEY" value="' + UNIQUE_KEY + '">\
		</td>\
	</tr>\
</tbody></table>\
');

function ka_reload(a) {
	a = (typeof a !== "undefined") ? a : true;
	var xhttp;
	if (window.XMLHttpRequest)
		xhttp = new XMLHttpRequest();
	else
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	xhttp.onreadystatechange = function () {
		if (xhttp.readyState != 4) return;
                if (xhttp.status != 200) return;
		for (var i = k; i; i--) {
			var ka = document.getElementById("ka" + i);
			if (typeof (ka) === "undefined") continue;
			if (startsWith(xhttp.responseText, "NONE"))
				ka.querySelectorAll(".ka_challenge")[0].querySelector("img").src = "/long_captcha/vip.jpg";
			if (!startsWith(xhttp.responseText, "NEW")) return;
			ka.querySelectorAll(".ka_challenge")[0].querySelector("img").src = xhttp.responseText.slice(4);
			ka.querySelectorAll(".ka_input")[0].value = "";
		}
	};
	xhttp.open("GET", "/long_captcha/captcha.php?key=" + UNIQUE_KEY);
	xhttp.send();

	if (a) setTimeout(ka_reload, 43200000);
}

function ka_check(form) {
	var guess = document.querySelector("#ka" + k + " input").value;
	var xhttp;
	if (window.XMLHttpRequest)
		xhttp = new XMLHttpRequest();
	else
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	xhttp.onreadystatechange = function () {
                if (xhttp.readyState != 4) return;
                if (xhttp.status != 200) return;
		if (!startsWith(xhttp.responseText, "CHECK")) return;
		if (xhttp.responseText.search("CHECK correct") != -1) {
			for (var i = k; i > 0; i--) {
				var ka = document.getElementById("ka" + i);
				if (typeof (ka) === "undefined") continue;
				ka.querySelectorAll(".ka_challenge")[0].querySelector("img").src = "/long_captcha/complete.png";
			}
		} else {
			ka_reload(false);
		}
	};
	xhttp.open("GET", "/long_captcha/captcha.php?key=" + UNIQUE_KEY + "&_LONG_CAPTCHA=" + guess);
	xhttp.send();
}

function gen_key() {
	var result = "";
	var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789=-";
	for (var i = 0; i < 64; i++)
		result += characters.charAt(Math.floor(Math.random() * 64));
	return result;
}

function startsWith(str, word) {
    return str.lastIndexOf(word, 0) === 0;
}

if (document.addEventListener) {
	document.addEventListener("DOMContentLoaded", function () {
		ka_reload();
	});
} else if (document.attachEvent) {
	document.attachEvent('onreadystatechange', function() {
		if (document.readyState === 'complete') {
			ka_reload();
		}
	});
}
