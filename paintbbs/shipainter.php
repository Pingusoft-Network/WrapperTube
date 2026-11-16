<?php
$kakiWidth = intval($_GET['w']) ? intval($_GET['w']) : 300;
$kakiHeight = intval($_GET['h']) ? intval($_GET['h']) : 300;
$appWidth = max($kakiWidth + 510, 450);
$appHeight = max($kakiHeight + 120, 560);
  if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES["openImage"]))
  {
    $uploaddir = './upload/';
    $file = $_FILES['openImage']['name'];
    $ext = (strpos($file, '.') === FALSE) ? '' : substr($file, strrpos($file, '.'));
    $uploadfile = $uploaddir . $_SERVER['REMOTE_ADDR'];
    if ($ext != ".png" && $ext != ".jpg" && $ext != ".jpeg" && $ext != ".bmp" && $ext != ".gif" && $ext != ".spch") {
        $errmsg = "Invalid File Type. Supported types: png jpg jpeg bmp gif spch";
        goto skip;
    }
    if ($_FILES['openImage']['size'] > 31457280) {
        $errmsg = "Max file size is 30MB.";
        goto skip;
    }

    $success = TRUE;

    $success = $success && move_uploaded_file($_FILES['openImage']['tmp_name'], $uploadfile . $ext);
    if ($success) {
      if ($ext == ".spch") {
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
	<title>Shi-Painter - WrapperTube</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="content-script-type" content="text/javascript">
    <meta http-equiv="content-style-type" content="text/css">
    <meta name="theme-color" content="red">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/redmond/jquery-ui.css">
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
					<script>
 //Firefoxのメニューバーが開閉するのため、Altキーのデフォルトの処理をキャンセル
 document.addEventListener('keyup', function(e) {//しぃペインター NEO共通
 // e.key を利用して特定のキーのアップイベントを検知する
 if (e.key.toLowerCase() === 'alt') {
 e.preventDefault(); // Alt キーのデフォルトの動作をキャンセル
 }
 });
	</script>
	<script type="text/javascript" language="JavaScript">
        //java
        document.addEventListener("DOMContentLoaded", function() {
        var jEnabled = navigator.javaEnabled();
        if(!jEnabled){
        var sN = document.createElement("script");
        sN.src = "https://cjrtnc.leaningtech.com/4.2/loader.js";
        sN.integrity="sha384-uKhK9NUHrSpoCfjhgnQkV7vDjOB6IhQZY1esOxD+TF1yvLbbJS/DRhX7g6ATh/wX";
        sN.crossOrigin="anonymous";
        var s0 = document.getElementsByTagName("script")[0];
        s0.parentNode.insertBefore(sN, s0);
        sN.addEventListener("load", function(){ cheerpjInit({"/lt/8/lib/ext/meta-index":[0,131072],"/lt/8/jre/lib/rt.jar":[0,131072,9699328,11010048,11272192,11534336,11665408,12189696,12320768,12451840,15204352,15335424,15466496,15597568,15990784,16384000,16777216,16908288,17039360,17563648,17694720,17825792,18087936,18612224,18743296,18874368,19005440,19136512,19529728,19660800,20185088,20316160,20840448,21757952,21889024,26869760],"/lt/8/jre/lib/cheerpj-awt.jar":[0,131072],"/lt/8/jre/lib/jsse.jar":[0,131072,786432,917504],"/lt/8/jre/lib/jce.jar":[0,131072],"/lt/etc/users":[0,131072],"/lt/8/jre/lib/charsets.jar":[0,131072,1703936,1835008],"/lt/8/jre/lib/resources.jar":[0,131072,917504,1179648],"/lt/8/jre/lib/javaws.jar":[0,131072,1441792,1703936],"/lt/8/jre/lib/meta-index":[0,131072],"/lt/8/lib/security/java.security":[0,131072],"/lt/8/lib/security/java.policy":[0,131072],"/lt/etc/resolv.conf":[0,131072],"/lt/fc/fonts/fonts.conf":[0,131072],"/lt/fc/cache/e21edda6a7db77f35ca341e0c3cb2a22-le32d8.cache-7":[0,131072],"/lt/etc/localtime":[],"/lt/8/lib/ext":[],"/lt/8/lib/ext/index.list":[],"/lt/8/lib/ext/localedata.jar":[],"/lt/8/lib/ext/sunec.jar":[],"/lt/8/lib/ext/sunjce_provider.jar":[],"/lt/8/lib/ext/zipfs.jar":[],"/lt/8/jre/lib":[],"/lt/fc/ttf/LiberationSans-Regular.ttf":[0,131072,262144,393216],"/lt/8/lib/accessibility.properties":[],"/lt/8/lib/fonts/LucidaSansRegular.ttf":[],"/lt/8/lib/ext/*":[],"/lt/etc/hosts":[],"/lt/8/lib/fonts/badfonts.txt":[],"/lt/8/lib/fonts":[],"/lt/8/lib/fonts/fallback":[],"/lt/fc/ttf":[]}); }, false);
        }
        });
	</script>
        <!-- */ -->
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
        <script type="text/javascript" language="JavaScript">
            var isDirty = true;
            window.onbeforeunload = function () {
                if (isDirty) {
                    // Firefox will not use the string. IE use it
                    return "Are you sure you want to leave? Any unsaved changes will be lost.";
                }
                // if nothing returned, browser leave the page without any message
            }
        </script>
</head>
<body>
  	<!--動的パレットスクリプト ここから-->
 <script>
 //	BBS Note 動的パレット＆マトリクス 2003/06/22
 //	(C) のらネコ WonderCatStudio http://wondercatstudio.com/
 var DynamicColor=1,Palettes=[];
 // パレット配列作成
  
 Palettes[0] = "#000000\n#FFFFFF\n#B47575\n#888888\n#FA9696\n#C096C0\n#FFB6FF\n#8080FF\n#25C7C9\n#E7E58D\n#E7962D\n#99CB7B\n#FCECE2\n#F9DDCF";Palettes[1] = "#FFF0DC\n#52443C\n#FFE7D0\n#5E3920\n#FFD6C0\n#B06A54\n#FFCBB3\n#C07A64\n#FFC0A3\n#DEA197\n#FFB7A2\n#ECA385\n#000000\n#FFFFFF";Palettes[2] = "#FFEEF7\n#FFE6E6\n#FFCAE4\n#FFC4C4\n#FF9DCE\n#FF7D7D\n#FF6AB5\n#FF5151\n#FF2894\n#FF0000\n#CF1874\n#BF0000\n#851B53\n#800000";Palettes[3] = "#FFE3D7\n#FFFFDD\n#FFCBB3\n#FFFFA2\n#FFA275\n#FFFF00\n#FF8040\n#D9D900\n#FF5F11\n#AAAA00\n#DB4700\n#7D7D00\n#BD3000\n#606000";Palettes[4] = "#C6FDD9\n#E8FACD\n#8EF09F\n#B9E97E\n#62D99D\n#9ADC65\n#1DB67C\n#65B933\n#1A8C5F\n#4F8729\n#136246\n#2B6824\n#0F3E2B\n#004000";Palettes[5] = "#DFF4FF\n#C1FFFF\n#80C6FF\n#6DEEFC\n#60A8FF\n#44D0EE\n#1D56DC\n#209CCC\n#273D8F\n#2C769A\n#1C2260\n#295270\n#000040\n#003146";Palettes[6] = "#E9D2FF\n#E1E1FF\n#DAB5FF\n#C1C1FF\n#CE9DFF\n#8080FF\n#B366FF\n#6262FF\n#9428FF\n#3D44C9\n#6900D2\n#33309E\n#3F007D\n#252D6B";Palettes[7] = "#ECD3BD\n#F7E2BD\n#E4C098\n#DBC7AC\n#C8A07D\n#D9B571\n#896952\n#C09450\n#825444\n#AE7B3E\n#5E4435\n#8E5C2F\n#493830\n#5F492C";Palettes[8] = "#FFEADD\n#DED8F5\n#FFCAAB\n#9C89C4\n#F19D71\n#CF434A\n#52443C\n#F09450\n#5BADFF\n#FDF666\n#0077D9\n#4AA683\n#000000\n#FFFFFF";Palettes[9] = "#F6CD8A\n#FFF99D\n#89CA9D\n#C7E19E\n#8DCFF4\n#8CCCCA\n#9595C6\n#94AAD6\n#AE88B8\n#9681B7\n#F49F9B\n#F4A0BD\n#8C6636\n#FFFFFF";Palettes[10] = "#C7E19E\n#D1E1FF\n#A8D59D\n#8DCFE0\n#7DC622\n#00A49E\n#528413\n#CBB99C\n#00B03B\n#766455\n#007524\n#5B3714\n#0F0F0F\n#FFFFFF";Palettes[11] = "#FFFF80\n#F4C1D4\n#EE9C00\n#F4BDB0\n#C45914\n#ED6B9E\n#FEE7DB\n#E76568\n#FFC89D\n#BD3131\n#ECA385\n#AE687E\n#0F0F0F\n#FFFFFF";Palettes[12] = "#FFFFFF\n#7F7F7F\n#EFEFEF\n#5F5F5F\n#DFDFDF\n#4F4F4F\n#CFCFCF\n#3F3F3F\n#BFBFBF\n#2F2F2F\n#AFAFAF\n#1F1F1F\n#0F0F0F\n#000000";
 function setPalette(){document.paintbbs.setColors(Palettes[document.forms.Palette.select.selectedIndex]);document.forms.grad.view.checked&&GetPalette()}function PaletteSave(){Palettes[0]=String(document.paintbbs.getColors())}var cutomP=0;
function PaletteNew(){var a=String(document.paintbbs.getColors());var b=document.forms.Palette.select;Palettes[b.length]=a;cutomP++;a=prompt("Palette name","Palette "+cutomP);null==a||""==a?cutomP--:(b.options[b.length]=new Option(a),30>b.length&&(b.size=b.length),PaletteListSetColor())}function PaletteRenew(){Palettes[document.forms.Palette.select.selectedIndex]=String(document.paintbbs.getColors());PaletteListSetColor()}
function PaletteDel(){var a=Palettes.length,b=document.forms.Palette.select;var c=b.selectedIndex;if(-1!=c&&confirm("Are you sure you want to delete ["+b.options[c].text+"]?")){for(b.options[c]=null;a>c;)Palettes[c]=Palettes[c+1],c++;30>b.length&&(b.size=b.length)}}
function P_Effect(a){a=parseInt(a);var b,c=1;255==a&&(c=-1);var f=document.paintbbs;var e=String(f.getColors()).split("\n");var d=e.length;var g="";for(b=0;d>b;b++){var h=a+parseInt("0x"+e[b].substring(1,3))*c,k=a+parseInt("0x"+e[b].substring(3,5))*c,l=a+parseInt("0x"+e[b].substring(5,7))*c;255<h?h=255:0>h&&(h=0);255<k?k=255:0>k&&(k=0);255<l?l=255:0>l&&(l=0);g+="#"+Hex(h)+Hex(k)+Hex(l)+"\n"}f.setColors(g);PaletteListSetColor()}
function PaletteMatrixGet(){var a=Palettes.length;var b=document.forms.Palette;var c=b.select;var f=b.setr;switch(b.m_m.selectedIndex){default:f.value="";var e=b=0;for(;a>b;)null!=c.options[b]&&(f.value=f.value+"\n!"+c.options[b].text+"\n"+Palettes[b],e++),b++;alert("Number of pallets "+e+"\ngot the palette matrix.");break;case 1:f.value="!Palette\n"+String(document.paintbbs.getColors()),alert("got the palette information currently used.")}f.value=f.value.trim()+"\n!Matrix"}
function PalleteMatrixSet(){var a=document.forms.Palette;var b=a.select;switch(a.m_m.selectedIndex){default:a=confirm("Set the palette matrix.\nAll current palette information will be lost. Are you sure you want to proceed?");break;case 1:a=confirm("Set the palette matrix.\nAre you sure you want to replace the current palette?");break;case 2:a=confirm("Set the palette matrix.\nAre you sure you want to add this to the current palette?")}a&&(PaletteSet(),b.size=30>b.length?b.length:30,DynamicColor&&
PaletteListSetColor())}
function PalleteMatrixHelp(){alert("**ABOUT PALETTE MATRIX**\nThe palette matrix allows you to use free palette settings \nby using text that lists palette information.\n\nGet the matrix\n1)Get the palette matrix from the [Get] button.\n2)The retrieved information will appear in the text area below, copy it all.\n3)Let's save this matrix information as text in a file.\n\nto set matrix\n1)Paste the copied matrix into the text area below.\n2)If you have saved it in a file, copy and paste it.\n3)You can use the saved palette by pressing the [Set] button.\n\nPlease note that the palette will not be set correctly if there is unnecessary information.")}
function PaletteSet(){var a=document.forms.Palette;var b=a.setr.value,c=a.select;var f=a.m_m.selectedIndex;a=b.length;var e;if(1>a)alert("There is no matrix information.");else{var d;switch(f){default:for(d=c.length;0<d;)d--,c.options[d]=null;case 2:f=c.options.length;d=b.indexOf("!",0)+1;if(0==d)return;for(;d<a;){var g=b.indexOf("\n#",d);if(-1==g)return;var h=b.substring(d,g+1);d=b.indexOf("!",g);if(-1==d)return;e=b.substring(g+1,d+-1);"Palette"!=h?(0<=f&&(c.options[f]=new Option(h)),Palettes[f]=
e,f++):document.paintbbs.setColors(e);d+=1}break;case 1:d=b.indexOf("!",0)+1;if(0==d)return;g=b.indexOf("\n#",d);d=b.indexOf("!",g);0<=g&&(e=b.substring(g+1,d-1));document.paintbbs.setColors(e)}PaletteListSetColor()}}function PaletteListSetColor(){var a;var b=document.forms.Palette.select;for(a=1;b.options.length>a;a++){var c=Palettes[a].split("\n");b.options[a].style.background=c[4];b.options[a].style.color=GetBright(c[4])}}
function GetBright(a){var b=parseInt("0x"+a.substring(1,3)),c=parseInt("0x"+a.substring(3,5));a=parseInt("0x"+a.substring(5,7));a=b>=c?b>=a?b:a:c>=a?c:a;return 128>a?"#FFFFFF":"#000000"}function Chenge_(){var a=document.forms.grad,b=a.ped.value;isNaN(parseInt("0x"+a.pst.value))||isNaN(parseInt("0x"+b))||GradView()}
function ChengeGrad(){var a=document.forms.grad,b=a.pst.value,c=a.ped.value;Chenge_();var f=parseInt("0x"+b.substring(0,2)),e=parseInt("0x"+b.substring(2,4)),d=parseInt("0x"+b.substring(4,6));b=parseInt((f-parseInt("0x"+c.substring(0,2)))/15);a=parseInt((e-parseInt("0x"+c.substring(2,4)))/15);c=parseInt((d-parseInt("0x"+c.substring(4,6)))/15);isNaN(b)&&(b=1);isNaN(a)&&(a=1);isNaN(c)&&(c=1);var g="",h;for(h=0;14>h;h++,f-=b,e-=a,d-=c){if(255<f||0>f)b*=-1,f-=b;if(255<e||0>e)a*=-1,e-=a;if(255<d||
0>d)c*=-1,e-=c;g+="#"+Hex(f)+Hex(e)+Hex(d)+"\n"}document.paintbbs.setColors(g)}function Hex(a){a=parseInt(a);0>a&&(a*=-1);var b="";for(var c;16<a;)c=a,16<a&&(a=parseInt(a/16),c-=16*a),c=Hex_(c),b=c+b;c=Hex_(a);for(b=c+b;2>b.length;)b="0"+b;return b}function Hex_(a){isNaN(a)?a="":10==a?a="A":11==a?a="B":12==a?a="C":13==a?a="D":14==a?a="E":15==a&&(a="F");return a}
function GetPalette(){var a=String(document.paintbbs.getColors());if("null"!=a&&""!=a){a=a.split("\n");var b=document.forms.grad,c=b.p_ed.selectedIndex;b.pst.value=a[b.p_st.selectedIndex].substring(1,7);b.ped.value=a[c].substring(1,7);GradSelC();PaletteListSetColor()}}
function GradSelC(){var a=String(document.paintbbs.getColors());if("null"!=a&&""!=a){a=a.split("\n");var b=document.forms.grad,c;if(b.view.checked){var f=a.length,e="";for(c=0;f>c;c++){var d=255+-1*parseInt("0x"+a[c].substring(1,3)),g=255+-1*parseInt("0x"+a[c].substring(3,5)),h=255+-1*parseInt("0x"+a[c].substring(5,7));255<d?d=255:0>d&&(d=0);255<g?g=255:0>g&&(g=0);255<h?h=255:0>h&&(h=0);e+="#"+Hex(d)+Hex(g)+Hex(h)+"\n"}e=e.split("\n");for(c=0;f>c;c++)b.p_st.options[c].style.background=
a[c],b.p_st.options[c].style.color=e[c],b.p_ed.options[c].style.background=a[c],b.p_ed.options[c].style.color=e[c]}}}function GradView(){}function showHideLayer(){var a=document.forms.grad;var b=document.getElementById("psft");(b=b?b.style:null)&&!a.view.checked&&(b.visibility="hidden");b&&a.view.checked&&(b.visibility="visible",GetPalette())};
 </script>
	<NOSCRIPT>
		<H3>This page will not work properly as JavaScript is disabled.</H3>
	</NOSCRIPT>
	<div class="app_select" style="width:<?php echo $appWidth + 182; ?>px">
                        <input type="button" value="New" onclick="$('#newDialogue').dialog('open');">
			<input type="button" value="Open" onclick="$('#openImage').click();return false;">
		</div>
	<div class="appstage">
		<div class="app">
			  <applet code="c.ShiPainter.class" archive="spainter_all.jar" name="paintbbs" WIDTH="<?php echo $appWidth; ?>" HEIGHT="<?php echo $appHeight; ?>"
 mayscript>
 <param name=dir_resource value="./">
 <param name="tt.zip" value="tt_def.zip">
 <param name="res.zip" value="res.zip">
  <param name=tools value="normal">
 <param name=layer_count value="3">
  <param name=quality value="1">
   <!--しぃペインターPro個別設定-->
  <!--共通設定(変更不可)-->
 <param name="send_header_count" value="true">
 <param name="send_header_timer" value="true">
 <param name="image_width" value="<?php echo $kakiWidth; ?>">
 <param name="image_height" value="<?php echo $kakiHeight; ?>">
 <param name="image_jpeg" value="false">
 <param name="image_size" value="0">
 <param name="compress_level" value="15">
 <param name="undo" value="90">
 <param name="undo_in_mg" value="45">
   <param name="url_save" value="./chibiin.php">
 <param name="send_header"
 value="">
  <param name="url_exit" value="javascript:$('#saveDialogue').dialog('open');void(0);">
    <param name="thumbnail_type" value="animation">
<?php if ($kakiFile) { ?><param name="pch_file" value="<?php echo htmlspecialchars($kakiFile); ?>"><?php } ?>
<?php if ($kakiImage) { ?><param name="image_canvas" value="<?php echo htmlspecialchars($kakiImage); ?>"><?php } ?>
    <param name="poo" value="false">
 <param name="send_advance" value="true">
 <param name="thumbnail_width" value="100%">
 <param name="thumbnail_height" value="100%">
 <param name="tool_advance" value="true">
  </applet>
		</div>
		<div class="palette_wrap">
			<div class="palette">
				 <form name="Palette">
  <fieldset>
 <legend>PALETTE</legend>
 <select class="form palette_select" name="select" size="13" onchange="setPalette()">
 <option>saved palette</option>
   <option>skin</option>
  <option>red</option>
  <option>orange</option>
  <option>green</option>
  <option>blue</option>
  <option>purple</option>
  <option>sepia</option>
  <option>character</option>
  <option>pastel</option>
  <option>grass</option>
  <option>sakura</option>
  <option>grayscale</option>
   </select><br>
 <input class="button" type="button" value="Save" onclick="PaletteSave()"><br>
 <input class="button" type="button" value="New" onclick="PaletteNew()">
 <input class="button" type="button" value="Renew" onclick="PaletteRenew()">
 <input class="button" type="button" value="Del" onclick="PaletteDel()"><br>
 <input class="button" type="button" value="Bright" onclick="P_Effect(10)">
 <input class="button" type="button" value="Dark" onclick="P_Effect(-10)">
 <input class="button" type="button" value="Invert" onclick="P_Effect(255)">
 </fieldset>
 <fieldset>
 <legend>MATRIX</legend>
 <select class="form" name="m_m">
 <option value="0">Overall</option>
 <option value="1">Current</option>
 <option value="2">Add</option>
 </select>
 <input type="button" class="button" name="m_g" value="Get" onclick="PaletteMatrixGet()">
 <input type="button" class="button" name="m_h" value="Set" onclick="PalleteMatrixSet()">
 <input type="button" class="button" name="1" value=" ? " onclick="PalleteMatrixHelp()"><br>
 <textarea class="form" name="setr" rows="1" cols="13" onmouseover="this.select()"></textarea>
 </fieldset>
 </form>
 <form name="grad">
 <fieldset>
 <legend>GRADATION</legend>
 <input type="checkbox" name="view" onclick="showHideLayer()">
 <input type="button" class="button" value=" Ok " onclick="ChengeGrad()"><br>
 <select class="form" name="p_st" onchange="GetPalette()">
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
 </select>
 <input class="form" type="text" name="pst" size="8" onkeypress="Chenge_()" onchange="Chenge_()"><br>
 <select class="form" name="p_ed" onchange="GetPalette()">
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
 </select>
 <input class="form" type="text" name="ped" size="8" onkeypress="Chenge_()" onchange="Chenge_()">
 <div id="psft"></div>
 <script>
 if(DynamicColor) PaletteListSetColor();
 </script>
 </fieldset>
 <p class="c">DynamicPalette &copy;NoraNeko</p>
 </form>
			</div>
			<script>
				if (DynamicColor) PaletteListSetColor();
			</script>
		</div>
	</div>
    <div id="newDialogue" title="New Image">
        <form method="get">
        <p>Width <input type="number" name="w" value="<?php echo $kakiWidth; ?>"></p>
        <p>Height <input type="number" name="h" value="<?php echo $kakiHeight; ?>"></p>
        <input type="submit" value="New Image" style="display:none;">
        </form>
    </div>
    <div id="saveDialogue" title="Save Image">
        <p><a href="./pictures/<?php echo $_SERVER['REMOTE_ADDR']; ?>.png" target="_blank">Save Image</a></p>
        <p><a href="./pictures/<?php echo $_SERVER['REMOTE_ADDR']; ?>.spch" target="_blank">Save Shi-Painter File</a></p>
    </div>
    <form id="imageOpen" method="post" enctype='multipart/form-data' style="display:none;">
        <input type="file" name="openImage" id="openImage" onchange="$('#imageOpen').submit();">
    </form>
    <script type="text/javascript" language="JavaScript">
        $(function() {
            $( "#newDialogue" ).dialog({
                autoOpen: false,
                resizable: false,
                buttons: {
                    "New Image": function() { $(this).find('form').submit(); },
                    "Cancel": function() { $(this).dialog('close'); }
                },
                close: function() { $(this).find('form')[0].reset(); }
            });
            $( "#saveDialogue" ).dialog({
                autoOpen: false,
                resizable: false,
                buttons: {
                    "OK": function() { $(this).dialog('close'); }
                }
            });
        });
    </script>
</body>
</html>
<!-- This is a modified version of the sample from https://github.com/funige/neo/. The dynamic palette is a script developed by WonderCatStudio. Modified by https://github.com/satopian/shi-local-PaintBBS Satopia -->
