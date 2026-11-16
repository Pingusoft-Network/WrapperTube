<?php
  if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES["openImage"]))
  {
    $uploaddir = './upload/';
    $file = $_FILES['openImage']['name'];
    $ext = (strpos($file, '.') === FALSE) ? '' : substr($file, strrpos($file, '.'));
    $uploadfile = $uploaddir . $_SERVER['REMOTE_ADDR'];
    if ($ext != ".png" && $ext != ".jpg" && $ext != ".jpeg" && $ext != ".bmp" && $ext != ".gif" && $ext != ".pch") {
        $errmsg = "Invalid File Type. Supported types: png jpg jpeg bmp gif pch";
        goto skip;
    }
    if ($_FILES['openImage']['size'] > 31457280) {
        $errmsg = "Max file size is 30MB.";
        goto skip;
    }

    $success = TRUE;

    $success = $success && move_uploaded_file($_FILES['openImage']['tmp_name'], $uploadfile . $ext);
    if ($success) {
      if ($ext == ".pch") {
        $kakiFile = $uploadfile . $ext;
      } else {
        $kakiImage = $uploadfile . $ext;
      }
    } else {
      $errmsg = "Failed to load file.";
      goto skip;
    }
  }
  skip:
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<title>PaintBBS Neo - WrapperTube</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="content-script-type" content="text/javascript">
    <meta http-equiv="content-style-type" content="text/css">
    <meta name="theme-color" content="red">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <script src="/static/js/core-js.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<link rel="stylesheet" href="neo.css?20250130" type="text/css">
	<script src="neo.js?20250130"></script>
	<script>
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }
var params = location.search.substring(1).split('&').reduce(function (result, query) {
  var _query$split = query.split('='),
    _query$split2 = _slicedToArray(_query$split, 2),
    k = _query$split2[0],
    v = _query$split2[1];
  result[k] = decodeURI(v);
  return result;
}, {});
var w = params.w || 300;
var h = params.h || 300;
var appw = parseInt(w) + 150;
var apph = parseInt(h) + 180;
if (apph < 560) {
  apph = 560;
} //Lowest height
	</script>
        <?php
        if (!empty($errmsg)) {
        ?>
        <script type="text/javascript" language="JavaScript">
        alert(<?php echo json_encode($errmsg); ?>);
        </script>
        <?php
        }
        ?>
	<style>
		body{overscroll-behavior-x: none !important; }
		
		select.canvas_select {
			height: 25px;
		}

		input[type="submit"] {
			height: 25px;
		}

		form {
			display: inline-block;
			margin: 0 0 12px;
		}

		img.sample {
			border: 1px solid black;
			margin-bottom: 5px;
			display: block;
			margin: 10px auto;
		}

		.app_select {
			margin: 8px auto 0;
		}


		.appstage {
			margin: 0 auto;
			display: table;
		}
		.app {
			display: table-cell;
		}

		label {
			cursor: pointer;
		}

		.palette_wrap {
			display: table-cell;
			vertical-align: middle;
			width: 160px;
			padding: 0 0 0 10px;
		}

		.palette_select {
			min-width: 130px;
		}

		h1 {
			margin: 8px 0;
			font-size: 30px;
		}
	.toolpalette_label {
		margin:0 5px 0 10px;
	}
	.stabilizer_label {
		margin:0 10px;
	}
	select:focus {
		outline: none;
	}
	</style>
</head>
<body>
<script>
//	BBS Note: Dynamic Palettes & Matrices 22 June 2003
//	(C) Noraneko WonderCatStudio http://wondercatstudio.com/
var DynamicColor = 1;	// Display colours in the palette list
var Palettes = new Array();
	Palettes[0] = "#000000\n#FFFFFF\n#B47575\n#888888\n#FA9696\n#C096C0\n#FFB6FF\n#8080FF\n#25C7C9\n#E7E58D\n#E7962D\n#99CB7B\n#FCECE2\n#F9DDCF";Palettes[1] = "#FFF0DC\n#52443C\n#FFE7D0\n#5E3920\n#FFD6C0\n#B06A54\n#FFCBB3\n#C07A64\n#FFC0A3\n#DEA197\n#FFB7A2\n#ECA385\n#000000\n#FFFFFF";Palettes[2] = "#FFEEF7\n#FFE6E6\n#FFCAE4\n#FFC4C4\n#FF9DCE\n#FF7D7D\n#FF6AB5\n#FF5151\n#FF2894\n#FF0000\n#CF1874\n#BF0000\n#851B53\n#800000";Palettes[3] = "#FFE3D7\n#FFFFDD\n#FFCBB3\n#FFFFA2\n#FFA275\n#FFFF00\n#FF8040\n#D9D900\n#FF5F11\n#AAAA00\n#DB4700\n#7D7D00\n#BD3000\n#606000";Palettes[4] = "#C6FDD9\n#E8FACD\n#8EF09F\n#B9E97E\n#62D99D\n#9ADC65\n#1DB67C\n#65B933\n#1A8C5F\n#4F8729\n#136246\n#2B6824\n#0F3E2B\n#004000";Palettes[5] = "#DFF4FF\n#C1FFFF\n#80C6FF\n#6DEEFC\n#60A8FF\n#44D0EE\n#1D56DC\n#209CCC\n#273D8F\n#2C769A\n#1C2260\n#295270\n#000040\n#003146";Palettes[6] = "#E9D2FF\n#E1E1FF\n#DAB5FF\n#C1C1FF\n#CE9DFF\n#8080FF\n#B366FF\n#6262FF\n#9428FF\n#3D44C9\n#6900D2\n#33309E\n#3F007D\n#252D6B";Palettes[7] = "#ECD3BD\n#F7E2BD\n#E4C098\n#DBC7AC\n#C8A07D\n#D9B571\n#896952\n#C09450\n#825444\n#AE7B3E\n#5E4435\n#8E5C2F\n#493830\n#5F492C";Palettes[8] = "#FFEADD\n#DED8F5\n#FFCAAB\n#9C89C4\n#F19D71\n#CF434A\n#52443C\n#F09450\n#5BADFF\n#FDF666\n#0077D9\n#4AA683\n#000000\n#FFFFFF";Palettes[9] = "#F6CD8A\n#FFF99D\n#89CA9D\n#C7E19E\n#8DCFF4\n#8CCCCA\n#9595C6\n#94AAD6\n#AE88B8\n#9681B7\n#F49F9B\n#F4A0BD\n#8C6636\n#FFFFFF";Palettes[10] = "#C7E19E\n#D1E1FF\n#A8D59D\n#8DCFE0\n#7DC622\n#00A49E\n#528413\n#CBB99C\n#00B03B\n#766455\n#007524\n#5B3714\n#0F0F0F\n#FFFFFF";Palettes[11] = "#FFFF80\n#F4C1D4\n#EE9C00\n#F4BDB0\n#C45914\n#ED6B9E\n#FEE7DB\n#E76568\n#FFC89D\n#BD3131\n#ECA385\n#AE687E\n#0F0F0F\n#FFFFFF";Palettes[12] = "#FFFFFF\n#7F7F7F\n#EFEFEF\n#5F5F5F\n#DFDFDF\n#4F4F4F\n#CFCFCF\n#3F3F3F\n#BFBFBF\n#2F2F2F\n#AFAFAF\n#1F1F1F\n#0F0F0F\n#000000";function setPalette(){d=document;d.paintbbs.setColors(Palettes[d.Palette.select.selectedIndex]);d.grad.view.checked&&GetPalette()}function PaletteSave(){Palettes[0]=String(document.paintbbs.getColors())}var cutomP=0;
function setPalette(){d=document;d.paintbbs.setColors(Palettes[d.Palette.select.selectedIndex]);d.grad.view.checked&&GetPalette()}function PaletteSave(){Palettes[0]=String(document.paintbbs.getColors())}var cutomP=0;
function PaletteNew(){d=document;p=String(d.paintbbs.getColors());s=d.Palette.select;Palettes[s.length]=p;cutomP++;str=prompt("Pallet name','Pallet "+cutomP);null==str||""==str?cutomP--:(s.options[s.length]=new Option(str),30>s.length&&(s.size=s.length),PaletteListSetColor())}function PaletteRenew(){d=document;Palettes[d.Palette.select.selectedIndex]=String(d.paintbbs.getColors());PaletteListSetColor()}
function PaletteDel(){p=Palettes.length;s=document.Palette.select;i=s.selectedIndex;if(-1!=i&&(flag=confirm("'"+s.options[i].text + "'Is it OK to delete this?'"))){for(s.options[i]=null;p>i;)Palettes[i]=Palettes[i+1],i++;30>s.length&&(s.size=s.length)}}
function P_Effect(a){a=parseInt(a);x=1;255==a&&(x=-1);d=document.paintbbs;p=String(d.getColors()).split("\n");l=p.length;var f="";for(n=0;l>n;n++)R=a+parseInt("0x"+p[n].substring(1,3))*x,G=a+parseInt("0x"+p[n].substring(3,5))*x,B=a+parseInt("0x"+p[n].substring(5,7))*x,255<R?R=255:0>R&&(R=0),255<G?G=255:0>G&&(G=0),255<B?B=255:0>B&&(B=0),f+="#"+Hex(R)+Hex(G)+Hex(B)+"\n";d.setColors(f);PaletteListSetColor()}
function PaletteMatrixGet(){d=document.Palette;p=Palettes.length;s=d.select;m=d.m_m.selectedIndex;t=d.setr;switch(m){default:t.value="";for(c=n=0;p>n;)null!=s.options[n]&&(t.value=t.value+"\n!"+s.options[n].text+"\n"+Palettes[n],c++),n++;alert("Number of pallets: "+c+"\nThe palette matrix has been retrieved");break;case 1:t.value="!Palette\n"+String(document.paintbbs.getColors()),
alert("I have retrieved the information on the pallets currently in use")}t.value=
t.value.trim()+"\n!Matrix"}
function PalleteMatrixSet(){m=document.Palette.m_m.selectedIndex;str="Set the palette matrix.";switch(m){default:flag=confirm(str+"\nAre you sure you want to proceed? All current pallet data will be lost.");break;case 1:flag=confirm(str+"\nIs it OK if I replace the palette you are currently using?");break;
case 2:flag=confirm(str+"\nWould you like me to add this to the current pallet information?")}flag&&(PaletteSet(),s.size=30>s.length?s.length:30,DynamicColor&&PaletteListSetColor())}
function PalleteMatrixHelp(){alert("★PALETTE MATRIX\nThe Palette Matrix allows you to configure palettes freely by using a text file that lists palette information.\n\n□ Retrieving the Matrix\n1) Click the ‘Retrieve’ button to obtain the palette matrix.\n2) The retrieved information will appear in the text area below; copy the entire contents.\n3) Save this matrix information as a text file.\n\n□Setting the Matrix\n1) Paste the copied matrix into the text area below.\n2) If you have saved it to a file, copy it from there and paste it in.\n3) Press the ‘Set’ button to use the saved palette.\nPlease note that the palette will not be set correctly if there is any extra information.")}
function PaletteSet(){d=document.Palette;se=d.setr.value;s=d.select;m=d.m_m.selectedIndex;l=se.length;if(1>l)alert("No matrix information available.");else{e=o=n=0;switch(m){default:for(n=s.length;0<n;)n--,s.options[n]=null;case 2:i=s.options.length;n=se.indexOf("!",0)+1;if(0==n)return;Matrix1=1;for(Matrix2=-1;n<l;){e=se.indexOf("\n#",n);if(-1==e)return;pn=se.substring(n,e+Matrix1);o=se.indexOf("!",e);if(-1==o)return;pa=se.substring(e+1,o+Matrix2);
"Palette"!=pn?(0<=i&&(s.options[i]=new Option(pn)),Palettes[i]=pa,i++):document.paintbbs.setColors(pa);n=o+1}break;case 1:n=se.indexOf("!",0)+1;if(0==n)return;e=se.indexOf("\n#",n);o=se.indexOf("!",e);0<=e&&(pa=se.substring(e+1,o-1));document.paintbbs.setColors(pa)}PaletteListSetColor()}}function PaletteListSetColor(){var a=document.Palette.select;for(i=1;a.options.length>i;i++){var f=Palettes[i].split("\n");a.options[i].style.background=f[4];a.options[i].style.color=GetBright(f[4])}}
function GetBright(a){r=parseInt("0x"+a.substring(1,3));g=parseInt("0x"+a.substring(3,5));b=parseInt("0x"+a.substring(5,7));a=r>=g?r>=b?r:b:g>=b?g:b;return 128>a?"#FFFFFF":"#000000"}function Chenge_(){var a=document.grad.pst.value,f=document.grad.ped.value;isNaN(parseInt("0x"+a))||isNaN(parseInt("0x"+f))||GradView("#"+a,"#"+f)}
function ChengeGrad(){var a=document,f=a.grad.pst.value,h=a.grad.ped.value;Chenge_();var u=parseInt("0x"+f.substring(0,2)),v=parseInt("0x"+f.substring(2,4));f=parseInt("0x"+f.substring(4,6));var k=parseInt((u-parseInt("0x"+h.substring(0,2)))/15),q=parseInt((v-parseInt("0x"+h.substring(2,4)))/15);h=parseInt((f-parseInt("0x"+h.substring(4,6)))/15);isNaN(k)&&(k=1);isNaN(q)&&(q=1);isNaN(h)&&(h=1);var w=new String;cnt=0;m1=u;m2=v;for(m3=f;14>cnt;cnt++,m1-=k,m2-=q,m3-=h){if(255<m1||0>m1)k*=-1,m1-=k;if(255<m2||0>m2)q*=-1,
m2-=q;if(255<m3||0>m3)h*=-1,m2-=h;w+="#"+Hex(m1)+Hex(m2)+Hex(m3)+"\n"}a.paintbbs.setColors(w)}function Hex(a){a=parseInt(a);0>a&&(a*=-1);for(var f=new String,h;16<a;)h=a,16<a&&(a=parseInt(a/16),h-=16*a),h=Hex_(h),f=h+f;h=Hex_(a);for(f=h+f;2>f.length;)f="0"+f;return f}function Hex_(a){isNaN(a)?a="":10==a?a="A":11==a?a="B":12==a?a="C":13==a?a="D":14==a?a="E":15==a&&(a="F");return a}
function GetPalette(){d=document;p=String(d.paintbbs.getColors());"null"!=p&&""!=p&&(ps=p.split("\n"),st=d.grad.p_st.selectedIndex,ed=d.grad.p_ed.selectedIndex,d.grad.pst.value=ps[st].substring(1,7),d.grad.ped.value=ps[ed].substring(1,7),GradSelC(),GradView(ps[st],ps[ed]),PaletteListSetColor())}
function GradSelC(){if(d.grad.view.checked){d=document.grad;l=ps.length;pe="";for(n=0;l>n;n++)R=255+-1*parseInt("0x"+ps[n].substring(1,3)),G=255+-1*parseInt("0x"+ps[n].substring(3,5)),B=255+-1*parseInt("0x"+ps[n].substring(5,7)),255<R?R=255:0>R&&(R=0),255<G?G=255:0>G&&(G=0),255<B?B=255:0>B&&(B=0),pe+="#"+Hex(R)+Hex(G)+Hex(B)+"\n";pe=pe.split("\n");for(n=0;l>n;n++)d.p_st.options[n].style.background=ps[n],d.p_st.options[n].style.color=pe[n],d.p_ed.options[n].style.background=ps[n],d.p_ed.options[n].style.color=
pe[n]}}function GradView(a,f){d=document}function showHideLayer(){d=document;var a=d.layers?d.layers.psft:d.all("psft").style;d.grad.view.checked||(a.visibility="hidden");d.grad.view.checked&&(a.visibility="visible",GetPalette())};
</script>
	<NOSCRIPT>
		<H3>This page will not work properly as JavaScript is disabled.</H3>
	</NOSCRIPT>
	<div class="app_select">
			<form>
				<input type="number" class=canvas_select name="w" title=Width placeholder=Width> <input type="number" class="canvas_select" name="h" title=Height placeholder=Height>
				<input type="submit" value="New">
			</form>
			<input type="button" value="Open" onclick="$('#openImage').click();return false;">
			<span class="toolpalette_label">Tools</span> <input type="radio" name="1" id="1" onclick="Neo.setToolSide(true)" class="nts_radio"><label
				class="ntslabel" for="1">Left</label>
			<input type="radio" name="1" id="2" onclick="Neo.setToolSide(false)" checked="checked" class="nts_radio"><label
				class="ntslabel" for="2">Right</label>
			<span class="stabilizer_label">Image stabilisation</span>
				<select onchange="Neo.setStabilizLevel(this.value)" class="canvas_select">
					<option value="0">0</option>
					<option value="1" selected>1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</span>
		</div>
	<div class="appstage">
		<div class="app">
			<div id="appletdummy"></div>
			<script>
var html = "<applet-dummy name=\"paintbbs\" width=\"".concat(appw, "\" height=\"").concat(apph, "\" mayscript code=\"pbbs.PaintBBS.class\" archive=\"./PaintBBS.jar\">\n                                        <param name=\"image_width\" value=\"").concat(w, "\">\n                                        <param name=\"image_height\" value=\"").concat(h, "\">\n                                        <param name=\"thumbnail_type\" value=\"animation\">\n                                        <param name=\"neo_disable_grid_touch_move\" value=\"true\">\n                     <param name=\"neo_confirm_layer_info_notsaved\" value=\"true\">\n          <param name=\"neo_animation_skip\" value=\"true\">\n           <param name=\"neo_show_right_button\" value=\"true\">\n        <param name=\"neo_confirm_unload\" value=\"true\">\n         <?php if($kakiFile) { ?><param name=\"pch_file\" value=\"<?php echo $kakiFile; ?>\">\n<?php } ?>      <?php if($kakiImage) { ?><param name=\"image_canvas\" value=\"<?php echo $kakiImage; ?>\">\n<?php } ?>                  <param name=\"neo_enable_zoom_out\" value=\"true\">\n                    <param name=\"image_size\" value=\"0\">\n       <param name=\"thumbnail_width\" value=\"100%\">\n                         <param name=\"thumbnail_height\" value=\"100%\">\n                      </applet-dummy>");
var appletdummy = document.getElementById("appletdummy");
appletdummy.insertAdjacentHTML('afterbegin', html);
document.paintBBSCallback = function (str) {
  if (str === 'check') {
    var image = Neo.painter.getImage();
    var animation = Neo.painter.getThumbnail('animation');
    var img = document.createElement('img');
    img.src = image.toDataURL('image/png');
    img.className = "sample";
    var a = document.createElement('a');
    a.href = URL.createObjectURL(animation);
    a.innerHTML = a.download = new Date() - 0 + ".pch";
    var top = document.querySelector('img.sample');
    document.body.insertBefore(img, top);
    document.body.insertBefore(a, top);
    return false;
  }
};
checkd_if_formval_equal_val(document.forms[0].w, w);
checkd_if_formval_equal_val(document.forms[0].h, h);
function checkd_if_formval_equal_val(docformsname, val) {
  var j;
  docformsname.value = val;
}
var app_select = document.querySelector(".app_select");
app_select.style.width = Number(w) + 317 + "px";
			</script>
		</div>
		<div class="palette_wrap">
			<div class="palette">
				<form name="Palette">
					<span class="palette_desc">PALETTE</span> <input type="button" value="Temporary save"
						onclick="PaletteSave()"><br>
					<select name="select" size="13" onChange="setPalette()" class="palette_select">
						<option>Temporary palette</option>
						<option>skin tones</option>
						<option>red tones</option>
						<option>Yellow &amp; orange tones</option>
						<option>green tones</option>
						<option>bluish tones</option>
						<option>purple tones</option>
						<option>Sepia</option>
						<option>People</option>
						<option>Pastel</option>
						<option>Grasslands</option>
						<option>Moe Sakura</option>
						<option>Black &amp; white</option>
					</select><br>
					<input type="button" value="Create" onclick="PaletteNew()">
					<input type="button" value="Change" onclick="PaletteRenew()">
					<input type="button" value="Delete" onclick="PaletteDel()"><br>
					<input type="button" value="Brighten" onclick="P_Effect(10)">
					<input type="button" value="Darken" onclick="P_Effect(-10)">
					<input type="button" value="Invert" onclick="P_Effect(255)">
					<hr class="palette_hr"><span class="palette_desc">MATRIX</span>
					<select name="m_m">
						<option value="0">Whole</option>
						<option value="1">Now</option>
						<option value="2">Add</option>
					</select><br>
					<input name="m_g" type="button" value="Obtain" onclick="PaletteMatrixGet()">
					<input name="m_s" type="button" value="Set" onclick="PalleteMatrixSet()">
					<input name="m_h" type="button" value=" ? " onclick="PalleteMatrixHelp()"><br>
					<textarea rows="1" name="setr" cols="13" onMouseOver="this.select()"></textarea><br>
				</form>
			</div>
			<div class="palette_gradation">
				<form name="grad">
					<label class="palette_desc checkbox"><INPUT type="checkbox" name="view" onclick="showHideLayer()"
							id="grdchk">GRADATION&nbsp;</label><INPUT type="button" value=" OK "
						onclick="ChengeGrad()"><br>
					<select name="p_st" onChange="GetPalette()">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>13</option>
						<option>14</option>
					</select><input type="text" name="pst" size="8" onKeyPress="Chenge_()" onChange="Chenge_()"><br>
					<select name="p_ed" onChange="GetPalette()">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option selected>12</option>
						<option>13</option>
						<option>14</option>
					</select><input type="text" name="ped" size="8" onKeyPress="Chenge_()" onChange="Chenge_()">
				</form>
			</div>
			<script>
				if (DynamicColor) PaletteListSetColor();
			</script>
		</div>
	</div>
    <form id="imageOpen" method="post" enctype='multipart/form-data' style="display:none;">
        <input type="file" name="openImage" id="openImage" onchange="$('#imageOpen').submit();">
    </form>
</body>
</html>
<!-- This is a modified version of the sample from https://github.com/funige/neo/. The dynamic palette is a script developed by WonderCatStudio. Modified by https://github.com/satopian/shi-local-PaintBBS Satopia -->
