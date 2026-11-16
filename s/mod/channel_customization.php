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

    #solidcolor {
        vertical-align: middle;
        text-shadow: 0 1px 0 #fff;
        border-color: #ccc #ccc #aaa;
        background-color: #e0e0e0;
        -moz-box-shadow: inset 0 0 1px #fff;
        -ms-box-shadow: inset 0 0 1px #fff;
        -webkit-box-shadow: inset 0 0 1px #fff;
        box-shadow: inset 0 0 1px #fff;
        background-image: -moz-linear-gradient(top, #fafafa 0, #dcdcdc 100%);
        background-image: -ms-linear-gradient(top, #fafafa 0, #dcdcdc 100%);
        background-image: -o-linear-gradient(top, #fafafa 0, #dcdcdc 100%);
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #fafafa), color-stop(100%, #dcdcdc));
        background-image: -webkit-linear-gradient(top, #fafafa 0, #dcdcdc 100%);
        background-image: linear-gradient(to bottom, #fafafa 0, #dcdcdc 100%);
        height: 32px;
        border: 0;
    }

    .example-dropzone {
    background-color: #6DB65B;
    flex-basis: 100%;
    flex-grow: 1;
    padding: 10px;
    }

    .www-header-item {
        margin: 0px !important;
    }

    .channel-customization-options {
        float: right;
    }

    .label-with-info {
        display: inline-block;
        width: 200px;
    }

    .channel-layout-selector {
        display: inline-block;
        height: 300px;
        width: 18%;
        vertical-align: top;
        margin-top: 9px;
        padding: 10px;
    }

    .channel-layout-selector img {
        width: 134px;
    }

    .grey-text-options input {
        vertical-align: top;
    }

    .grey-text-options {
        position: relative;
        top: 3px;
    }

    .user-header-bottom table {
        width: 970px;
        padding: 10px;
        background-color: rgb(239, 239, 239);
        position: relative;
        top: -2px;
    }

    td .thin-line-darker {
        border-bottom: 1px dotted #bbb;
    }

    .right-side-customization {
        vertical-align: top;
        width: 450px;
        border-left: 1px dotted #bbb;
        left: 4px;
        padding: 5px;
    }

    .right-side-customization b, .right-side-customization .grey-text {
        position: relative;
        left:4px;
    }

    .right-side-customization .thin-line-darker {
        width: 100%;
    }

    .www-header-list table {
        background: rgb(232,232,232);
        background: linear-gradient(0deg, rgba(232,232,232,1) 0%, rgba(250,250,250,1) 100%); 
    }

    .left-side-customization {
        width: 450px;
        vertical-align: top;
        padding-left: 25px;
    }

    
        .right-side-customization input[type="submit"], .left-side-customization input[type="submit"] {
            color: #039;
            background: #c6d7f3 url(/yt/imgbin/spritesheet_main.png)repeat-x center -1602px;
            border: 1px solid #a0b1dc;
            text-decoration: none;
            border-radius: 3px;
            padding: 3px 0.833em;
            font-weight: bold;
        }
    

    .customization-module {
        display: inline-block;
        float:right;
    }

    .user-header-bottom table {
        border: 1px solid #999;
        border-top: 0px;
    }

    .www-header-list {
        margin-top: 0px;
        width: 101%;
        background-image: linear-gradient(to bottom,#f0f0f0 0,#e6e6e6 100%);
        height: 43px;
        position: relative;
        left: 1px;
        bottom: 2px;
        width: 968px;
    }

    #biomd {
        position: relative;
        top: 6px;
    }

    .channel-customization-bg {
        background: url(/s/img/chnanel-customization-bg.png);
    }

    .channel-customization-base {
        width: 960px;
        margin: auto;
        position: relative;
        right: 5px;
    }

    .channel-custom-top {
        margin: auto;
        width: 970px;
    }

    .www-header-list .yt-uix-button {
        width: 128px;
        height: 100%;
    }

    .www-header-list .yt-uix-button:nth-child(n+1) {
        margin-left: -5px;
    }

    .www-header-list .yt-uix-button {
        background: rgb(239, 239, 239);
        font-weight: lighter;
        font-size: 13px;
        outline: 0;
    }

    .www-header-list .yt-uix-button:focus {
        outline: 0;
        box-shadow: none;
    }
</style>

<div class="channel-customization-bg" style="display: none;">
    <br>
    <div class="channel-custom-top">
        <h1 style="color: white;font-weight: bolder;font-weight:normal;display:inline-block;">Edit my channel</h1>
        <button style="float: right;" onclick='fadechannel();' class="yt-uix-button yt-uix-button-default">Cancel</button>
    </div>
    <br>
    <div class="channel-customization-base" id="channel-customize">
        <div class="user-header-bottom">
            <div class="www-header-list">
                <script>
                    function selectTable(showDom) {
                        doms = ['#pictures-table', '#misc-table', '#bg-table', '#color-table', '#layout-table']; 
                        var dlen = doms.length;
                        for (var i = 0; i < dlen; i++) {
                            $(doms[i]).hide()
                        }
                        $(showDom).show();
                    };

                    $("#biom").change(function(){
                        
                    }); 
                </script>
                <a class="www-header-item" href="#" id="pictures-table-button" onclick="selectTable('#pictures-table');">
                    <button class="yt-uix-button yt-uix-button-default" style="margin-left: 0px;">Apperance</button>
                </a>
                <a class="www-header-item" href="#" id="misc-table-button" onclick="selectTable('#misc-table');">
                    <button class="yt-uix-button yt-uix-button-default">Custom Tab</button>
                </a>
                <a class="www-header-item" href="#" id="bg-table-button" onclick="selectTable('#bg-table');">
                    <button class="yt-uix-button yt-uix-button-default">Info and Settings</button>
                </a>
                <a class="www-header-item" href="#" id="layout-table-button" onclick="selectTable('#layout-table');">
                    <button class="yt-uix-button yt-uix-button-default">Tabs</button>
                </a>
                <div class="channel-customization-options">
                </div>
            </div>

            <table id="pictures-table" style="width: 970px;padding: 10px;">
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <form method="post" id="picturesform" action="/d/channel_update" enctype="multipart/form-data">
                    <td class="left-side-customization">
                        <h2>Avatar</h2>
                        <p style="font-size: 11px;color: grey;">
                            Choose image. Non-square images wil be cropped.<br>
                            Suggested dimensions: 800x800 pixels. Max size: 1MB.
                        </p>
                        <?php if($_user['pfp'] != "default.png") { ?>
                            <a style="font-size: 11px;" href="/get/remove_profile_pic">Remove Profile Picture</a><br>
                        <?php } ?>
                        <br>
                        <a id="browse" href="javascript:;">
                            <button class="yt-uix-button yt-uix-button-default">
                                Browse
                            </button>
                        </a>  
                        <a id="start-upload" href="javascript:;">                                    
                            <button class="yt-uix-button yt-uix-button-default">
                                Upload
                            </button>
                        </a>
                        <div class="customization-module" id="pfp" action="/d/channel_update" enctype="multipart/form-data">
                        </div><br><br>
                        <ul id="filelist"></ul>
                            <pre id="console"></pre>

                            <script type="text/javascript">
                            var alerts = 0;

                            var uploader = new plupload.Uploader({
                                browse_button: 'browse', 
                                url: '/d/channel_update?n=pfp',
                                multi_selection: false,
                                
                                filters: {
                                    ime_types : [
                                        { title : "Image files", extensions : "jpg,jpeg,gif,png" },
                                    ],
                                    max_file_size: "1024kb"
                                },

                                resize: {
                                    width: 100,
                                    height: 100,
                                    preserve_headers: false
                                }
                            });
                            
                            uploader.init();
                            
                            uploader.bind('FilesAdded', function(up, files) {
                                var html = '';
                                plupload.each(files, function(file) {
                                    console.log("file added");
                                });
                            });
                            
                            uploader.bind('UploadFile', function(up, file) {

                            });

                            uploader.bind('FileUploaded', function(up, file, response) {
                                alerts++;  
                                response = JSON.parse(response.response);
                                $("#photo-update").attr("src", "/dynamic/pfp/" + response.profile_picture);
                            });
                            
                            uploader.bind('Error', function(up, err) {
                                document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
                            });
                            
                            document.getElementById('start-upload').onclick = function() {
                            uploader.start();
                            };
                            
                            </script>
                            <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                            <br>
                            <h2>Background Options</h2>
                            <span style="font-size: 11px;color:grey;">Choose image (Max file size: 1MB)</span><br><br>
                            <div id="backgroundoptions" method="post" action="/d/channel_update" enctype="multipart/form-data">
                                <select class="yt-uix-button yt-uix-button-default" name="bgoption" value="<?php echo htmlspecialchars($_user['2012_bgoption']); ?>">
                                    <option value="repeaty" <?php if ($_user['2012_bgoption'] == 'repeaty') {echo 'selected="selected"';} ?>>Repeat only vertically</option>
                                    <option value="repeatx" <?php if ($_user['2012_bgoption'] == 'repeatx') {echo 'selected="selected"';} ?>>Repeat only horrizontaly</option>
                                    <option value="norepeat" <?php if ($_user['2012_bgoption'] == 'norepeat') {echo 'selected="selected"';} ?>>Don't Repeat</option>
                                    <option value="repeatxy" <?php if ($_user['2012_bgoption'] == 'repeatxy') {echo 'selected="selected"';} ?>>Repeat</option>
                                    <option value="stretch" <?php if ($_user['2012_bgoption'] == 'stretch') {echo 'selected="selected"';} ?>>Stretch to fit</option>
                                    <option value="solid" <?php if ($_user['2012_bgoption'] == 'solid') {echo 'selected="selected"';} ?>>Solid</option>
                                </select>
                                <input style="vertical-align: middle;" class="colourpicker" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['primary_color']); ?>">
                            </div><br>
                            <h2>Background</h2>
                            <span style="font-size: 11px;color:grey;" class="grey-text">Choose Image (Max file size: 10MB)</span><br>
                            <div id="backgroundimage" method="post" action="/d/channel_update" enctype="multipart/form-data">
                                <input type="file" name="backgroundbgset" accept=".png,.jpg,.jpeg,.gif" id="background-upload">
                                <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                            </div><br>

                            
                                <h2>Watch Page Subscribe Button</h2>
                                <span style="font-size: 11px;color:grey;" class="grey-text">Choose Image (Max file size: 10MB)</span><br>
                                <?php if($_user['subbutton'] != "") { ?>
                            <a style="font-size: 11px;" href="/get/remove_watch_banner">Remove Watch Page Subscribe Button</a><br>
                        <?php } ?>
                                <div id="watchsub" method="post" action="/d/channel_update" enctype="multipart/form-data">
                                    <input type="file" name="videopagebanner" accept=".png,.jpg,.jpeg,.gif" id="watch-upload">
                                    <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                                </div><br><br>

                        <h2>Custom Font</h2>
                        <span style="font-size: 10px;color: grey;">This will set a custom font on your profile page.<br>SEPERATE BY COMMAS AND PUT EACH FONT WITH SPACES IN QUOTES, ex: "Segoe Print", cursive</span><br>
                        <input class="yt-uix-form-input-text" style="width: 225px;" id="fontmd" placeholder="Custom Font" value="<?php echo htmlspecialchars($_user['font']); ?>" name="font"><br><br>
                            
                            <input class="yt-uix-button yt-uix-button-default" style="position: absolute;top: -89px;right: -412px;" type="submit" value="Done Editing"><br><br>
                    </td>
                    <td class="right-side-customization">
                        <h2>Custom CSS</h2>
                        
                        <div id="bio" action="/d/channel_update" enctype="multipart/form-data">
                            <span style="font-size: 10px;color: grey;">Prefix every image url() with //images.weserv.nl/?url=</span><br>    
                            <textarea class="yt-uix-form-input-text"  style="height: 55px;width: 334px;background-color:white;border: 1px solid #d3d3d3;padding: 0px;" id="biomd" placeholder="Custom CSS" name="css"><?php echo htmlspecialchars($_user['css']); ?></textarea><br><br>
                        </div><br><br>

                                <h2>Banner<h2>
                                <span style="font-size: 11px;color:grey;" class="grey-text">Choose Image (Max file size: 10MB)</span><br>
<?php if($_user['banner'] != "") { ?>
                            <a style="font-size: 11px;" href="/get/remove_channel_banner">Remove Banner</a><br>
                        <?php } ?>
                                <div id="thebanner" method="post" action="/d/channel_update" enctype="multipart/form-data">
                                    <input type="file" name="bannerset" accept=".png,.jpg,.jpeg,.gif" id="watch-upload">
                                    <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                                </div><br><br>

                                <h2>Banner Image Map<h2>
                                <span style="font-size: 11px;color:grey;" class="grey-text">Add an HTML image map to make your profile banner clickable. Map name should be "#imgmap"</span><br>
                                <div id="bannerimagemap" method="post" action="/d/channel_update" enctype="multipart/form-data">
                                    <textarea class="yt-uix-form-input-text"  style="height: 55px;width: 334px;background-color:white;border: 1px solid #d3d3d3;padding: 0px;" id="biomd" placeholder="Banner Image Map" name="banner_image_map"><?php echo htmlspecialchars($_user['banner_image_map']); ?></textarea><br><br>
                                </div><br><br>

<h2>Toggle Layout<h2>
                                <span style="font-size: 11px;color:grey;" class="grey-text">Switch between the 2012 and 2009 channel layouts.</span><br>
                                <a style="font-size: 11px;" href="/get/toggle_layout">Toggle Layout</a><br><br>

<h2>Toggle Profile Commenting<h2>
                                <span style="font-size: 11px;color:grey;" class="grey-text">Turns profile commenting on or off.</span><br>
                                <a style="font-size: 11px;" href="/get/toggle_profile_commenting">Toggle Profile Commenting</a><br><br>

<h2>Toggle Profile Snow<h2>
                                <span style="font-size: 11px;color:grey;" class="grey-text">Turns profile snow effects on or off.</span><br>
                                <a style="font-size: 11px;" href="/get/toggle_profile_snow">Toggle Profile Snow</a><br><br>

<!--
			<div style="position: relative;top: 7px;padding-bottom: 6px;">
                            <h2>Transparency</h2>
                            <span style="font-size: 10px;color: grey;">This will decide the visibility of ALL of your modules.</span><br><br>
                            <div class="customization-module" id="channellayout" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;bottom: 30px;">
                                <select class="yt-uix-button yt-uix-button-default" name="transparency" value="<?php echo htmlspecialchars($_user['transparency']); ?>">
                                <?php
                                $trans = array(
                                    "1.1","1.0","0.9","0.8","0.7","0.6","0.5","0.4","0.3","0.2","0.1",
                                );
                                ?>
                                    <option value="1.0" <?php if ($_user['transparency'] == '1.0') {echo 'selected="selected"';} ?>>100% (Visible)</option>
                                    <option value="0.9" <?php if ($_user['transparency'] == '0.9') {echo 'selected="selected"';} ?>>90%</option>
                                    <option value="0.8" <?php if ($_user['transparency'] == '0.8') {echo 'selected="selected"';} ?>>80%</option>
                                    <option value="0.7" <?php if ($_user['transparency'] == '0.7') {echo 'selected="selected"';} ?>>70%</option>
                                    <option value="0.6" <?php if ($_user['transparency'] == '0.6') {echo 'selected="selected"';} ?>>60%</option>
                                    <option value="0.5" <?php if ($_user['transparency'] == '0.5') {echo 'selected="selected"';} ?>>50%</option>
                                    <option value="0.4" <?php if ($_user['transparency'] == '0.4') {echo 'selected="selected"';} ?>>40%</option>
                                    <option value="0.3" <?php if ($_user['transparency'] == '0.3') {echo 'selected="selected"';} ?>>30%</option>
                                    <option value="0.2" <?php if ($_user['transparency'] == '0.2') {echo 'selected="selected"';} ?>>20%</option>
                                    <option value="0.1" <?php if ($_user['transparency'] == '0.1') {echo 'selected="selected"';} ?>>10%</option>
                                </select>
                            </div>
                        </div>
-->
                    </td>
                    </form>
                </tr>
            </table>

            <table id="layout-table" style="width: 970px;padding: 10px;display: none;">
                <tr>
                    <th></th>
                </tr>
                <tr>
                    <form method="post" id="layoutform" action="/d/channel_update" enctype="multipart/form-data">
                    <td>
                        <center>
                            <div class="channel-layout-selector">
                                <button onclick=";upload_layout('feed');return false;">
                                    <img src="/s/img/creator.png">
                                    <h2>Feed</h2>
                                    <p>
                                        A list of recent comments<br>
                                        and videos from you
                                    </p>
                                </button>
                            </div>
                            <div class="channel-layout-selector">
                                <button onclick=";upload_layout('featured');return false;">
                                    <img src="/s/img/blogger.png">
                                    <h2>Blogger</h2>
                                    <p>
                                        A reverse chronological list of<br>
                                        your recent uploads or a<br>
                                        featured playlist<br>
                                    </p>
                                </button>
                            </div>
                            <div class="channel-layout-selector">
                                <button onclick=";upload_layout('playlists');return false;">
                                    <img src="/s/img/network.png">
                                    <h2>Network</h2>
                                    <p>
                                        A featured video from a playlist <br>
                                        with a group of featured<br>
                                        channels
                                    </p>
                                </button>
                            </div>
                            <div class="channel-layout-selector">
                                <button onclick=";upload_layout('everything');return false;">
                                    <img src="/s/img/everything.png">
                                    <h2>Everything</h2>
                                    <p>
                                        A featured video from a playlist<br>
                                        with a group of featured playlists<br>
                                        and channels.
                                    </p>
                                </button>
                            </div>
                            <div class="channel-layout-selector">
                                <button onclick=";upload_layout('custom');return false;">
                                    <img src="/s/img/blogger.png">
                                    <h2>Custom</h2>
                                    <p>
                                        Your own channel layout in<br>
                                        HTML. You can edit this in the<br>
                                        "custom tab" section.
                                    </p>
                                </button>
                            </div>
                        </center>
                    </td>
                    </form>
                </tr>
            </table>

            <table id="misc-table" style="width: 970px;padding: 10px;display:none;">
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                <form method="post" id="miscform" action="/d/channel_update" enctype="multipart/form-data">
                    <td class="left-side-customization">
                        <h2>Custom Header</h2>
                        <span style="font-size: 10px;color: grey;">This will set the header in the custom tab.</span><br>
                        <input class="yt-uix-form-input-text" style="width: 225px;" id="biomd" placeholder="Custom Header" value="<?php echo htmlspecialchars($_user['real_custom_header']);?>" name="realheader"><br><br>
                        <input class="yt-uix-button yt-uix-button-default" type="submit" style="position: absolute;top: -89px;right: 66px;" value="Done Editing">
                    </td>
                    <td class="right-side-customization">
                        <h2>Custom Text<h2>
                        <div id="custom-text" action="/d/channel_update" enctype="multipart/form-data">
                            <span style="font-size: 10px;color: grey;">This will set the text in the custom tab. HTML is also supported.</span><br>
                            <textarea class="yt-uix-form-input-text"  style="height: 55px;width: 334px;background-color:white;border: 1px solid #d3d3d3;padding: 0px;" id="biomd" placeholder="Custom Text" name="customtext"><?php echo htmlspecialchars($_user['custom_text']); ?></textarea><br><br>
                        </div><br><br>
                    </td>
                </form>
                </tr>
            </table>

            <table id="bg-table" style="display:none;width: 970px;padding: 10px;">
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                <form method="post" id="bgform" action="/d/channel_update" enctype="multipart/form-data">
                    <td class="left-side-customization" style="width: 247px;">
                        <h2>Channel information & Settings</h2>
			<span style="font-size: 10px;color: grey;">Channel Title</span><br>
                        <input class="yt-uix-form-input-text" style="width: 225px;" id="biomd" placeholder="<?php echo htmlspecialchars($_user['username']);?>" value="<?php echo htmlspecialchars($_user['custom_header']);?>" name="header"><br><br>
                        <span style="font-size: 10px;color: grey;">Featured Video</span><br>
                        <input class="yt-uix-form-input-text" style="width: 225px;" id="biomd" placeholder="Video ID" value="<?php echo htmlspecialchars($_user['featured']);?>" name="videoid"><br><br>
                        <span style="font-size: 10px;color: grey;">Description</span><br>
                        <div id="bio" action="/d/channel_update" enctype="multipart/form-data">
                            <textarea class="yt-uix-form-input-text" style="height: 55px;width: 225px;background-color:white;border: 1px solid #d3d3d3;" id="readthisbio" placeholder="Bio" name="bio"><?php echo htmlspecialchars($_user['bio']); ?></textarea><br>
<select onchange="insertThisInThere(this.value,'readthisbio');this.selectedIndex=0;">
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
</select><br>
                        </div>


                        <br><input class="yt-uix-button yt-uix-button-default" type="submit" style="position: absolute;top: -89px;right: 66px;" value="Done Editing"><br><br>
                    </td>
                    <td class="right-side-customization" style="width: 630px;border: 0px;padding:0px;">
                        <h2>Advanced</h2>
                        <span style="font-size: 10px;color: grey;">Website URL</span><br>
                        <div id="featuredvid" action="/d/channel_update" enctype="multipart/form-data">
                        <input class="yt-uix-form-input-text" style="width: 225px;" id="websiteurlinp" placeholder="Website URL" value="<?php echo htmlspecialchars($_user['website']);?>" name="website">
                        </div><br>
                        <div>
                            <span style="font-size: 10px;color: grey;">Featured Channels</span>
                            <div id="featuredvid" action="/d/channel_update" enctype="multipart/form-data">
                            <input class="yt-uix-form-input-text" style="width: 291px;"  id="biomd" placeholder="Seperate by commas!" value="<?php echo htmlspecialchars($_user['featured_channels']);?>" name="featuredchannels">
                            </div>
                        </div><br>

                        <span style="font-size: 10px;color: grey;">Country</span><br>
                        <div id="countryselect" action="/d/channel_update" enctype="multipart/form-data">
                            <select style="width: 246px;" class="yt-uix-button yt-uix-button-default" id="country_input" name="country" value="<?php echo $_user['country']?>">
                            <?php
                            $countries = ["None","Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas (The)","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia (Plurinational State of)","Bonaire, Sint Eustatius and Saba","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory (the)","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cabo Verde","Cambodia","Cameroon","Canada","Cayman Islands (the)","Central African Republic (the)","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands (the)","Colombia","Comoros (the)","Congo (the Democratic Republic of the)","Congo (the)","Cook Islands (the)","Costa Rica","Croatia","Cuba","Curaçao","Cyprus","Czechia","Côte d'Ivoire","Denmark","Djibouti","Dominica","Dominican Republic (the)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini","Ethiopia","Falkland Islands (the) [Malvinas]","Faroe Islands (the)","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Territories (the)","Gabon","Gambia (the)","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Heard Island and McDonald Islands","Holy See (the)","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran (Islamic Republic of)","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea (the Democratic People's Republic of)","Korea (the Republic of)","Kuwait","Kyrgyzstan","Lao People's Democratic Republic (the)","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macao","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands (the)","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia (Federated States of)","Moldova (the Republic of)","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands (Kingdom of the)","New Caledonia","New Zealand","Nicaragua","Niger (the)","Nigeria","Niue","Norfolk Island","North Macedonia","Northern Mariana Islands (the)","Norway","Oman","Pakistan","Palau","Palestine, State of","Panama","Papua New Guinea","Paraguay","Peru","Philippines (the)","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Romania","Russian Federation (the)","Rwanda","Réunion","Saint Barthélemy","Saint Helena, Ascension and Tristan da Cunha","Saint Kitts and Nevis","Saint Lucia","Saint Martin (French part)","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Sint Maarten (Dutch part)","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia and the South Sandwich Islands","South Sudan","Spain","Sri Lanka","Sudan (the)","Suriname","Svalbard and Jan Mayen","Sweden","Switzerland","Syrian Arab Republic (the)","Taiwan (Province of China)","Tajikistan","Tanzania, the United Republic of","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkmenistan","Turks and Caicos Islands (the)","Tuvalu","Türkiye","Uganda","Ukraine","United Arab Emirates (the)","United Kingdom of Great Britain and Northern Ireland (the)","United States Minor Outlying Islands (the)","United States of America (the)","Uruguay","Uzbekistan","Vanuatu","Venezuela (Bolivarian Republic of)","Viet Nam","Virgin Islands (British)","Virgin Islands (U.S.)","Wallis and Futuna","Western Sahara*","Yemen","Zambia","Zimbabwe","Åland Islands"];

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
                        </div>

                        <?php $categories = ["None", "Director", "Musician", "Comedian", "Guru", "Nonprofit"]; ?>
                        <div style="position: relative;top: 7px;padding-bottom: 6px;">
                            <span style="font-size: 10px;color: grey;">Channel Genre</span><br>
                            <div id="channellayout" action="/d/channel_update" enctype="multipart/form-data">
                                <select style="width: 246px;" class="yt-uix-button yt-uix-button-default" name="genre" value="<?php echo $_user['genre']; ?>">
                                    <?php foreach($categories as $category) { ?>
                                        <option value="<?php echo $category; ?>" <?php if (strtolower($category) == $_user['genre']) {echo 'selected="selected"';} ?>><?php echo $category; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div><br><br>
                    </td>
                </form>
                </tr>
            </table>
        </div>
    </div>
</div>
<script>
    var alerts = 0; 
    $('#picturesform').submit(
        function( e ) {
            var data = new FormData(this);
            d = 0;
            $.each($("input[type='file']")[0].files, function(i, file) {
                data.append('file', file + "_" + d);
                d++;
            });

            $.ajax( {
                url: '/d/channel_update',
                type: 'POST',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(result){
                    alerts++;
                    addAlert("editsuccess_" + alerts, "Successfully updated your channel!");
                    showAlert("#editsuccess_" + alerts);
                    $("#bio-changeme").text($("#biom").val());
                }
            } );
            e.preventDefault();
        } 
    );

    $('#miscform').submit(
        function( e ) {
            var data = new FormData(this);

            $.ajax( {
                url: '/d/channel_update',
                type: 'POST',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(result){
                    alerts++;
                    addAlert("editsuccess_" + alerts, "Successfully updated your channel!");
                    showAlert("#editsuccess_" + alerts);
                    $("#bio-changeme").text($("#biom").val());
                }
            } );
            e.preventDefault();
        } 
    );

    $('#bgform').submit(
        function( e ) {
            var data = new FormData(this);

            $.ajax( {
                url: '/d/channel_update',
                type: 'POST',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(result){
                    alerts++;
                    addAlert("alert__" + alerts, "Successfully updated your channel!");
                    showAlert("#editsuccess_" + alerts);
                    $("#bio-changeme").text($("#readthisbio").val());
                    $("#website_url_change").text($("#websiteurlinp").val());
                    $("#country_change").text($("#country_input").val());
                }
            } );
            e.preventDefault();
        } 
    );

    function upload_layout(layout) {
        $.post("/d/channel_update",
        {
            layout_channel: layout
        },
        function(data, status){
            alerts++;
            addAlert("editsuccess_" + alerts, "Successfully updated your channel!");
            showAlert("#editsuccess_" + alerts);
        });
    }
function fadechannel() {
    if ($(".channel-customization-bg").first().is(":hidden")) {
      $(".channel-customization-bg").fadeIn(300);
    } else {
      $(".channel-customization-bg").fadeOut(300);
    }
  }
</script>
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
<script src="/s/js/channelEdit.js"></script>
<script src="/s/js/alert.js"></script>
