<script src='/static/js/channelEdit.js'></script>
<style>
    .example-parent {
    color: black;
    display: flex;
    font-family: sans-serif;
    font-weight: bold;
    }

    .example-origin {
    flex-basis: 100%;
    flex-grow: 1;
    padding: 10px;
    }

    .example-draggable {
        background-color: #f2f2f2;
    font-weight: normal;
    margin-bottom: 10px;
    margin-top: 10px;
    padding: 10px;
    }

    .example-dropzone {
    background-color: #6DB65B;
    flex-basis: 100%;
    flex-grow: 1;
    padding: 10px;
    }
</style>
<script>

</script>
<div class="channel-customization-base" id="channel-customize" style="display: none;">
    <div class="user-header-bottom" style="margin: -5px;">
        <div class="www-header-list" style="margin-top: 0px;">
            <a class="www-header-item" href="#" onclick="pictures_table()">Main</a>
            <a class="www-header-item" href="#" onclick="bg_table()">Background</a>
            <a class="www-header-item" href="#" onclick="text_table()">Colors</a>
            <a class="www-header-item" href="#" onclick="layout_table()">Layout</a>
        </div>
    </div>

    <table id="pictures-table" style="width: 960px;padding: 10px;">
        <tr>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <h1>Pictures</h1>
                <b>Avatar</b><br>
                <span style="font-size: 11px;" class="grey-text">Preview your avatar below. To upload a new avatar, choose a new file.</span><br>
                <?php if($_user['pfp'] != "default.png") { ?>
                    <a href="/get/remove_profile_pic">Remove Profile Picture</a><br>
                <?php } ?>
                <img src="/dynamic/pfp/<?php echo $_user['pfp']; ?>" style="width: 50px; height: 50px;margin-left: 146px;"><br>
                <form method="post" id="pfp" action="/post/channel_update_new" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="avatar-upload" accept=".png,.jpg,.jpeg,.gif">
                    <!--<button class="www-button www-button-grey" id="av-uplod">Select File</button>-->
                    <input class="www-button www-button-grey" type="submit" value="Upload Image" name="pfpset">
                </form><br><br><hr class="thin-line">
                <b>Channel Banner</b><br>
                <span style="font-size: 11px;" class="grey-text">Preview your banner that will be displayed on your channel page.</span><br>
                <br>
                <form method="post" id="banner" action="/post/channel_update_new" enctype="multipart/form-data">
                    <?php if(!empty($_user['banner'])) { ?>
                        <a href="/get/remove_channel_banner">Remove Channel Banner</a><br>
                    <?php } ?>
                    <input type="file" name="fileToUpload" id="avatar-upload" accept=".png,.jpg,.jpeg,.gif">
                    <!--<button class="www-button www-button-grey" id="av-uplod">Select File</button>-->
                    <input class="www-button www-button-grey" type="submit" value="Upload Image" name="bannerset">
                </form><br><br><hr class="thin-line">

                <h1>Banner Image Map</h1>
                        <form method="post" action="/post/channel_update2" enctype="multipart/form-data">
                             Add an HTML image map to make your profile banner clickable. Map name should be "#imgmap"<br>
                            <textarea class="yt-uix-form-input-text"  style="width: 288px;padding: 0px;background-color:white;border: 1px solid #d3d3d3;" id="biomd" placeholder="" name="banner_image_map"><?php echo htmlspecialchars($_user['banner_image_map']); ?></textarea><br><br>
                           <input class="yt-uix-button yt-uix-button-default" name="bannerimagemap" type="submit" value="Set">
                        </form><br><br>
<hr class="thin-line">
                <b>Watch Page Subscribe Button</b><br>
                <span style="font-size: 11px;" class="grey-text">Preview your banner that will be displayed on your videos.</span><br>
                <br>
                <form method="post" id="watchbanner" action="/post/channel_update_new" enctype="multipart/form-data">
                    <?php if(!empty($_user['subbutton'])) { ?>
                        <a href="/get/remove_watch_banner">Remove Watch Page Subscribe Button</a><br>
                    <?php } ?>
                    <input type="file" name="fileToUpload" id="avatar-upload" accept=".png,.jpg,.jpeg,.gif">
                    <!--<button class="www-button www-button-grey" id="av-uplod">Select File</button>-->
                    <input class="www-button www-button-grey" type="submit" value="Upload Image" name="videopageset">
                </form><br><br><hr class="thin-line">
                <h1>Channel Title</h1>
                <form method="post" action="/post/channel_update2" enctype="multipart/form-data">
                <input style="padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3;width: 345px;" id="biomd" placeholder="<?php echo htmlspecialchars($_user['username']);?>'s Channel" value="<?php echo htmlspecialchars(@$_user['channel_title']);?>" name="videoid">
                    <input class="yt-uix-button yt-uix-button-default" name="headerset" type="submit" value="Set">
                </form><br><br>
<hr class="thin-line">
                <b>Custom CSS</b><br>
                <span style="font-size: 11px;" class="grey-text">Don't use if you don't know what you're doing. [MAX 10,000 CHARS]<br>
                You MUST use an image proxy for XSS protection. Prefix every image url() with //images.weserv.nl/?url=</span><br>
                <form method="post" id="bio" action="/post/channel_update_new" enctype="multipart/form-data">
                    <textarea style="width: 345px;padding: 0px;background-color:white;border: 1px solid #d3d3d3;" id="biomd" placeholder="Custom CSS" name="css"><?php echo htmlspecialchars($_user['css']); ?></textarea><br><br>
                    <input class="www-button www-button-grey" style="margin: 0px;" name="cssset" type="submit" value="Set">
                </form><br><br><hr class="thin-line">
                <b>Border Radius</b><br>
                <span style="font-size: 11px;" class="grey-text">This will set the border radius of the channel boxes.</span><br>
                <form method="post" id="borderradius" action="/post/channel_update_new" enctype="multipart/form-data">
                <input style="padding: 5px;background-color: white;border: 1px solid #999;width: 345px;height: 12px;" id="radiusmd" placeholder="Border Radius" type="number" min="0" max="99" value="<?php echo htmlspecialchars($_user['border_radius']);?>" name="radius">
                    <input class="www-button www-button-grey" name="radiusset" type="submit" value="Set">
                </form><br><hr class="thin-line">

                <b>Custom Font</b><br>
                <span style="font-size: 11px;" class="grey-text">This will set a custom font on your profile page.<br>SEPERATE BY COMMAS AND PUT EACH FONT WITH SPACES IN QUOTES, ex: "Segoe Print", cursive</span><br>
                <form method="post" id="customfont" action="/post/channel_update_new" enctype="multipart/form-data">
                <input style="padding: 5px;background-color: white;border: 1px solid #999;width: 345px;height: 12px;" id="fontmd" placeholder="Custom Font" value="<?php echo htmlspecialchars($_user['font']);?>" name="font">
                    <input class="www-button www-button-grey" name="fontset" type="submit" value="Set">
                </form><br><hr class="thin-line">
            </td>
            <td style="vertical-align: top;     padding-left: 94px; width: 432px;">
                <h1>Profile</h1>
                <b>Bio</b><br>
                <span style="font-size: 11px;" class="grey-text">Set text (Max 2000 characters)</span><br>
                <form method="post" id="bio" action="/post/channel_update_new" enctype="multipart/form-data">
                    <textarea style="width: 345px;padding: 0px;background-color:white;border: 1px solid #d3d3d3;" id="biomdbio" placeholder="Bio" name="bio"><?php echo htmlspecialchars($_user['bio']); ?></textarea><br>
<select onchange="insertThisInThere(this.value,'biomdbio');this.selectedIndex=0">
  <option value="" disabled selected>--Kaomoji--</option>
  <option value="ｷﾀ━━━(ﾟ∀ﾟ)━━━!!">ｷﾀ━━━(ﾟ∀ﾟ)━━━!!</option>
  <option value="(;´Д`)">(;´Д`)</option>
  <option value="ヽ(´∇`)ノ">ヽ(´∇`)ノ</option>
  <option value="(´ー`)">(´ー`)</option>
  <option value="( ´ー｀)y-~~">( ´ー｀)y-~~</option>
  <option value="（ ’～’）">（ ’～’）</option>
  <option value="ヽ(`Д´)ノ">ヽ(`Д´)ノ</option>
  <option value="( ´ω`)">( ´ω`)</option>
  <option value="(・∀・)">(・∀・)</option>
  <option value="(´・ω・｀)">(´・ω・｀)</option>
  <option value="( ´,_ゝ｀)">( ´,_ゝ｀)</option>
  <option value="Σ(;ﾟДﾟ)">Σ(;ﾟДﾟ)</option>
  <option value="(;｀Д´)">(;｀Д´)</option>
  <option value="( ﾟ ヮﾟ) Mittens!">( ﾟ ヮﾟ)</option>
  <option value="^°^">^°^</option>
  <option value="=^..^=">=^..^=</option>
  <option value="^v^">^v^</option>
  <option value="VvV">VvV</option>
  <option value="UwU">UwU</option>
  <option value="( ° _ ° )">( ° _ ° )</option>
  <option value="&gt;v^">&gt;v^</option>
  <option value="^_&lt;">^_&lt;</option>
  <option value="&gt_^">&gt;_^</option>
  <option value="^v&lt;">^v&lt;</option>
  <option value="( &gt; v &lt; )">( &gt; v &lt; )</option>
  <option value="&gt;v&lt;">&gt;v&lt;</option>
</select><br><br>
                    <input class="www-button www-button-grey" style="margin: 0px;" name="bioset" type="submit" value="Set">
                </form><br><br><hr class="thin-line">

                <b>Featured Video</b><br>
                <span style="font-size: 11px;" class="grey-text">Must not have extra whitespace/spaces at the end. Example: MTYwNTQ4ODc4Mja=24 is valid. DO NOT INCLUDE THE SITE DOMAIN, JUST THE ID</span><br>
                <form method="post" id="featuredvid" action="/post/channel_update_new" enctype="multipart/form-data">
                <input style="padding: 5px;background-color: white;border: 1px solid #999;width: 345px;height: 12px;" id="biomd" placeholder="Video ID" value="<?php echo htmlspecialchars($_user['featured']);?>" name="videoid">
                    <input class="www-button www-button-grey" name="featuredset" type="submit" value="Set">
                </form><br><br><hr class="thin-line">

                <b>Website</b><br>
                <span style="font-size: 11px;" class="grey-text">Include the HTTP/HTTPS part.</span><br>
                <form method="post" id="featuredvid" action="/post/channel_update_new" enctype="multipart/form-data">
                <input style="padding: 5px;background-color: white;border: 1px solid #999;width: 345px;height: 12px;" id="biomd" placeholder="Website URL" value="<?php echo htmlspecialchars($_user['website']);?>" name="website">
                    <input class="www-button www-button-grey" name="websiteset" type="submit" value="Set">
                </form><br><hr class="thin-line">

                <?php $categories = ["None", "Director", "Musician", "Comedian", "Guru", "Nonprofit"]; ?>
                <b>2009 Channel Layout</b><br>
                <span style="font-size: 11px;" class="grey-text">Users will be redirected to the layout that you choose.</span><br>
                <form method="post" id="channellayout" action="/post/channel_update_new" enctype="multipart/form-data">
                    <select style="background: transparent url(/static/img/spritesheet_main.png) repeat-x scroll 0 -800px;border: 1px solid #333;"  name="layout">
                        <option value="1" <?php if($_user['layout']=="1"){ ?>selected<?php } ?>>1.0</option>
                        <option value="2" <?php if($_user['layout']!="1"){ ?>selected<?php } ?>>2.0</option>
                    </select>
                    <input class="www-button www-button-grey" name="layset" type="submit" value="Set">
                </form><br><hr class="thin-line">
<h1>Toggle Layout</h1>
                                Switch between the 2012 and 2009 channel layouts.<br>
                                <a href="/get/toggle_layout">Toggle Layout</a><br><br>
<hr class="thin-line">
<h1>Toggle Profile Commenting</h1>
                                Turns profile commening on or off.<br>
                                <a href="/get/toggle_profile_commenting">Toggle Profile Commenting</a><br><br>
<hr class="thin-line">
<h1>Toggle Profile Snow</h1>
                                Turns profile snow effects on or off.<br>
                                <a href="/get/toggle_profile_snow">Toggle Profile Snow</a><br><br>
<hr class="thin-line">
                <b>Channel Genre</b><br>
                <span style="font-size: 11px;" class="grey-text">This will show what type of channel you are to other users.</span><br>
                <form method="post" id="channellayout" action="/post/channel_update_new" enctype="multipart/form-data">
                    <select style="background: transparent url(/static/img/spritesheet_main.png) repeat-x scroll 0 -800px;border: 1px solid #333;"  name="genre">
                        <?php foreach($categories as $category) { ?>
                            <option value="<?php echo $category; ?>" <?php if(strtolower($_user['genre'])==strtolower($category)){ ?>selected<?php } ?>><?php echo $category; ?></option>
                        <?php } ?>
                    </select>
                    <input class="www-button www-button-grey" name="genreset" type="submit" value="Set">
                </form><br><hr class="thin-line">

                <b>Transparency</b><br>
                <span style="font-size: 11px;" class="grey-text">This will decide the visibility of ALL of your modules.</span><br>
                <form method="post" id="channellayout" action="/post/channel_update_new" enctype="multipart/form-data">
                    <select style="background: transparent url(/static/img/spritesheet_main.png) repeat-x scroll 0 -800px;border: 1px solid #333;"  name="transparency">
                        <option value="1.0" <?php if($_user['transparency']=="1.0"){ ?>selected<?php } ?>>100% (Visible)</option>
                        <option value="0.9" <?php if($_user['transparency']=="0.9"){ ?>selected<?php } ?>>90%</option>
                        <option value="0.8" <?php if($_user['transparency']=="0.8"){ ?>selected<?php } ?>>80%</option>
                        <option value="0.7" <?php if($_user['transparency']=="0.7"){ ?>selected<?php } ?>>70%</option>
                        <option value="0.6" <?php if($_user['transparency']=="0.6"){ ?>selected<?php } ?>>60%</option>
                        <option value="0.5" <?php if($_user['transparency']=="0.5"){ ?>selected<?php } ?>>50%</option>
                        <option value="0.4" <?php if($_user['transparency']=="0.4"){ ?>selected<?php } ?>>40%</option>
                        <option value="0.3" <?php if($_user['transparency']=="0.3"){ ?>selected<?php } ?>>30%</option>
                        <option value="0.2" <?php if($_user['transparency']=="0.2"){ ?>selected<?php } ?>>20%</option>
                        <option value="0.1" <?php if($_user['transparency']=="0.1"){ ?>selected<?php } ?>>10%</option>
                    </select>
                    <input class="www-button www-button-grey" name="transparencyset" type="submit" value="Set">
                </form><br><hr class="thin-line">

                <b>Country</b><br>
                <span style="font-size: 11px;" class="grey-text">Users will be able to see what country you're from.</span><br>
                <form method="post" id="channellayout" action="/post/channel_update_new" enctype="multipart/form-data">
                    <select style="background: transparent url(/static/img/spritesheet_main.png) repeat-x scroll 0 -800px;border: 1px solid #333;" id="country" name="country">
                                                <?php
                            $countries = array(
                                "None","Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas (The)","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia (Plurinational State of)","Bonaire, Sint Eustatius and Saba","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory (the)","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cabo Verde","Cambodia","Cameroon","Canada","Cayman Islands (the)","Central African Republic (the)","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands (the)","Colombia","Comoros (the)","Congo (the Democratic Republic of the)","Congo (the)","Cook Islands (the)","Costa Rica","Croatia","Cuba","Curaçao","Cyprus","Czechia","Côte d'Ivoire","Denmark","Djibouti","Dominica","Dominican Republic (the)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini","Ethiopia","Falkland Islands (the) [Malvinas]","Faroe Islands (the)","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Territories (the)","Gabon","Gambia (the)","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Heard Island and McDonald Islands","Holy See (the)","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran (Islamic Republic of)","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea (the Democratic People's Republic of)","Korea (the Republic of)","Kuwait","Kyrgyzstan","Lao People's Democratic Republic (the)","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macao","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands (the)","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia (Federated States of)","Moldova (the Republic of)","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands (Kingdom of the)","New Caledonia","New Zealand","Nicaragua","Niger (the)","Nigeria","Niue","Norfolk Island","North Macedonia","Northern Mariana Islands (the)","Norway","Oman","Pakistan","Palau","Palestine, State of","Panama","Papua New Guinea","Paraguay","Peru","Philippines (the)","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Romania","Russian Federation (the)","Rwanda","Réunion","Saint Barthélemy","Saint Helena, Ascension and Tristan da Cunha","Saint Kitts and Nevis","Saint Lucia","Saint Martin (French part)","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Sint Maarten (Dutch part)","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia and the South Sandwich Islands","South Sudan","Spain","Sri Lanka","Sudan (the)","Suriname","Svalbard and Jan Mayen","Sweden","Switzerland","Syrian Arab Republic (the)","Taiwan (Province of China)","Tajikistan","Tanzania, the United Republic of","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkmenistan","Turks and Caicos Islands (the)","Tuvalu","Türkiye","Uganda","Ukraine","United Arab Emirates (the)","United Kingdom of Great Britain and Northern Ireland (the)","United States Minor Outlying Islands (the)","United States of America (the)","Uruguay","Uzbekistan","Vanuatu","Venezuela (Bolivarian Republic of)","Viet Nam","Virgin Islands (British)","Virgin Islands (U.S.)","Wallis and Futuna","Western Sahara*","Yemen","Zambia","Zimbabwe","Åland Islands"
                            );

                            $countryLength = sizeof($countries);
                            $i = 0;
                            for($i = 0;$i < $countryLength; $i++)
                            {
                                $c = $countries[$i];
                                if ($c == $_user['country'])
                                //country is the same as in database
                                {
                                ?>
                                <option value="<?php echo $c; ?>" selected="selected"><?php echo $c; ?></option>
                                <?php
                                }
                                else
                                {
                                ?>
                                <option value="<?php echo $c;?>"><?php echo $c; ?></option>
                                <?php
                                }
                            }
                            ?>

                    </select>
                    <input class="www-button www-button-grey" name="countryset" type="submit" value="Set">
                </form><br><hr class="thin-line">
            </td>
        </tr>
    </table>

    <table id="misc-table" style="display: none;width: 960px;padding: 10px;">
        <tr>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <h1>Color Pallete</h1>
                <b>Primary Color</b><br>
                <span style="font-size: 11px;display: inline-block;width: 256px;" class="grey-text">This will change the text color of your channel ribbon.</span>
                <form method="post" id="primarycolor" style="float: right;position: relative;bottom: 15px;" action="/post/channel_update_new" enctype="multipart/form-data">
                    <input class="colourpicker" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['primary_color']); ?>">
                    <input class="www-button www-button-grey" name="primary" type="submit" value="Set">
                </form><br><br><hr class="thin-line">
                <b>Channel Box Color</b><br>
                <span style="font-size: 11px;display: inline-block;width: 256px;" class="grey-text">This will change the background color of the channel info box and the channel ribbon at top.</span><br>
                <form method="post" id="channelboxcolor" style="float: right;position: relative;bottom: 30px;" action="/post/channel_update_new" enctype="multipart/form-data">
                    <input class="colourpicker" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['secondary_color']); ?>">
                    <input class="www-button www-button-grey" name="secondary" type="submit" value="Set">
                </form><br><br><hr class="thin-line">
                <b>Border Color (Channel 2.0 only)</b><br>
                <span style="font-size: 11px;display: inline-block;width: 256px;" class="grey-text">This will change the border color of all the elements.</span><br>
                <form method="post" id="bordercolor" style="float: right;position: relative;bottom: 30px;" action="/post/channel_update_new" enctype="multipart/form-data">
                    <input class="colourpicker" id="bordercolor" name="bordercolor" value="<?php echo htmlspecialchars($_user['border_color']); ?>">
                    <input class="www-button www-button-grey" name="border" type="submit" value="Set">
                </form><br><br><hr class="thin-line">
            </td>
            <td style="vertical-align: top;     padding-left: 94px; width: 432px;position: relative;bottom: 2px;">
                <br><br>
                <b>Background Color</b><br>
                <span style="font-size: 11px;display: inline-block;width: 256px;" class="grey-text">This will change the background of all the other boxes including the top featured area.</span><br>
                <form method="post" id="boxbackgroundcolor" style="float: right;position: relative;bottom: 30px;" action="/post/channel_update_new" enctype="multipart/form-data">
                    <input class="colourpicker" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['third_color']); ?>">
                    <input class="www-button www-button-grey" name="thirdb" type="submit" value="Set">
                </form><br><br><hr class="thin-line">
                
                <b>Text Color</b><br>
                <span style="font-size: 11px;" class="grey-text">This will change the color of the box ribbons.</span><br>
                <form method="post" action="/post/channel_update_new" enctype="multipart/form-data">
                    Choose a color: <input class="colourpicker" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['text_color']); ?>"><br>
                    <input class="www-button www-button-grey" name="textcolor" type="submit" value="Set">
                </form><br><br><hr class="thin-line">
                
                <b>Text Main Color</b><br>
                <span style="font-size: 11px;display: inline-block;width: 256px;" class="grey-text">This will change the color of the text for boxes.</span><br>
                <form method="post" id="textmaincolor" style="float: right;position: relative;bottom: 30px;" action="/post/channel_update_new" enctype="multipart/form-data">
                    <input class="colourpicker" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['primary_color_text']); ?>">
                    <input class="www-button www-button-grey" name="textprimarycolor" type="submit" value="Set">
                </form><br><br><hr class="thin-line">
            </td>
        </tr>
    </table>

    <table id="bg-table" style="display: none;width: 960px;padding: 10px;"> 
        <tr>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <h1>Background</h1>
                <b>Background Options</b> <br>
                <span style="font-size: 11px;" class="grey-text">Choose how your background will be displayed.</span><br>
                <form id="backgroundoptions" method="post" action="/post/channel_update_new" enctype="multipart/form-data">
                    <select style="position: relative;bottom: -3px;background: transparent url(/static/img/spritesheet_main.png) repeat-x scroll 0 -800px;border: 1px solid #333;"  name="bgoption" id="ifyouarereadingthisYOUSUCK">
                        <option value="repeaty" <?php if($_user['2012_bgoption']=="repeaty"){ ?>selected<?php } ?>>Repeat - Y</option>
                        <option value="repeatx" <?php if($_user['2012_bgoption']=="repeatx"){ ?>selected<?php } ?>>Repeat - X</option>
                        <option value="norepeat" <?php if($_user['2012_bgoption']=="norepeat"){ ?>selected<?php } ?>>No Repeat</option>
                        <option value="repeatxy" <?php if($_user['2012_bgoption']=="repeatxy"){ ?>selected<?php } ?>>Repeat - X and Y</option>
                        <option value="stretch" <?php if($_user['2012_bgoption']=="stretch"){ ?>selected<?php } ?>>Stretch</option>
                        <option value="solid" <?php if($_user['2012_bgoption']=="solid"){ ?>selected<?php } ?>>Solid</option>
                    </select>
                    <div style="float: right;">
                        <input style="position: relative;bottom: 3px;" class="colourpicker" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['2012_bgcolor']); ?>">
                        <input style="position: relative;bottom: 4px;" class="www-button www-button-grey" name="bgoptionset" type="submit" value="Set">
                    </div>
                </form><br><br>

                <hr class="thin-line">
            </td>
            <td style="vertical-align: top;     padding-left: 94px; width: 432px;">
                <h1>&nbsp;</h1>
                <b>Background</b> <br>
                <span style="font-size: 11px;" class="grey-text">Choose Image (Max file size: 10MB)</span><br>
                <form id="backgroundimage" method="post" action="/post/channel_update_new" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="background-upload" accept=".png,.jpg,.jpeg,.gif">
                    <!--<button class="www-button www-button-grey" id="av-uplod">Select File</button>-->
                    <input class="www-button www-button-grey" type="submit" value="Upload Background" name="bgset">
                </form><br><br> 

                <hr class="thin-line">
            </td>
        </tr>
    </table>

    <table id="layout-table" style="display: none;width: 960px;padding: 10px;"> 
        <tr>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <h1>Layout</h1>
                <b>Left Side (Channel 2.0 only)</b><br>
                <span style="font-size: 11px;" class="grey-text">Choose how your left part of your channel will be displayed. Type a module and separate them with semicolons.<br>MODULES: main, stat, subscription, recent, subscribers, friends, discussion, channels, groups, custom</span><br>
                <form id="leftlayoutset" method="post" action="/post/channel_update_new" enctype="multipart/form-data">
                    <input style="padding: 5px;background-color: white;border: 1px solid #999;width: 345px;height: 12px;" id="biomd" placeholder="Modules" value="<?php echo htmlspecialchars($_user['s_2009_user_left']);?>" name="left">
                    <input class="www-button www-button-grey" name="leftset" type="submit" value="Set"> 
                </form><br><br>
                <hr class="thin-line"> 

                <b>Custom Header (Channel 2.0 only)</b><br>
                <span style="font-size: 11px;" class="grey-text">This will set the header in the custom module named "custom"</span><br>
                <form method="post" id="featuredvid" action="/post/channel_update_new" enctype="multipart/form-data">
                <input style="padding: 5px;background-color: white;border: 1px solid #999;width: 345px;height: 12px;" id="biomd" placeholder="Custom Header" value="<?php echo htmlspecialchars($_user['custom_header']);?>" name="header">
                    <input class="www-button www-button-grey" name="headerset" type="submit" value="Set">
                </form><br><hr class="thin-line">

                <b>Featured Channels (Channel 2.0 only)</b><br>
                <span style="font-size: 11px;" class="grey-text">This will set the list of featured channels in the custom module named "channels"<br>SEPERATE BY COMMAS, ex: GoldAnimate,Wrapper Tube,Rainblue921</span><br>
                <form method="post" id="featuredvid" action="/post/channel_update_new" enctype="multipart/form-data">
                <input style="padding: 5px;background-color: white;border: 1px solid #999;width: 345px;height: 12px;" id="biomd" placeholder="Channels" value="<?php echo htmlspecialchars($_user['featured_channels']);?>" name="channels">
                    <input class="www-button www-button-grey" name="channelsset" type="submit" value="Set">
                </form><br><hr class="thin-line">
            </td>
            <td style="vertical-align: top;     padding-left: 94px; width: 432px;">
                <h1>&nbsp;</h1>
                <b>Right Side (Channel 2.0 only)</b><br>
                <span style="font-size: 11px;" class="grey-text">Choose how your right part of your channel will be displayed. Type a module and separate them with semicolons.<br>MODULES: main, stat, subscription, recent, subscribers, friends, discussion, channels, groups, custom</span><br>
                <form id="rightlayoutset" method="post" action="/post/channel_update_new" enctype="multipart/form-data">
                    <input style="padding: 5px;background-color: white;border: 1px solid #999;width: 345px;height: 12px;" id="biomd" placeholder="Modules" value="<?php echo htmlspecialchars($_user['s_2009_user_right']);?>" name="right">
                    <input class="www-button www-button-grey" name="rightset" type="submit" value="Set"> 
                </form><br><br>
                <hr class="thin-line"> 

                <b>Custom Text (Channel 2.0 only)</b><br>
                <span style="font-size: 11px;" class="grey-text">This will set the text in the custom module named "custom". HTML is also supported.</span><br>
                <form method="post" id="bio" action="/post/channel_update_new" enctype="multipart/form-data">
                    <textarea style="width: 345px;padding: 0px;background-color:white;border: 1px solid #d3d3d3;" id="biomd" placeholder="Custom Text" name="customtext"><?php echo htmlspecialchars($_user['custom_text']); ?></textarea><br><br>
                    <input class="www-button www-button-grey" style="margin: 0px;" name="customtextset" type="submit" value="Set">
                </form><br><br><hr class="thin-line">
                <h1>Contact Custom Text (Channel 1.0 only)</h1>
                <form method="post" action="/post/channel_update2" enctype="multipart/form-data">
                <input style="padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3;width: 345px;" id="biomd" placeholder="Contact with <?php echo htmlspecialchars($_user['username']);?>" value="<?php echo htmlspecialchars($_user['contact_custom_text']);?>" name="contact_custom_text">
                    <input class="yt-uix-button yt-uix-button-default" name="contactset" type="submit" value="Set">
                </form><br><br>
<hr class="thin-line">
            </td>
        </tr>
    </table>
</div>
<script>
$(".colourpicker").spectrum({
showAlpha: true,
showInput: true,
showPalette: true,
    palette: [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ],
preferredFormat: "rgb"
});
</script>
<script src='/static/js/channelEditJ.js'></script>
