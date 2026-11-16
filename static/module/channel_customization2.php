<script>
function dropdownchannel() {
  if ($("#channel-customize").first().is(":hidden")) {
    $("#channel-customize").slideDown("slow");
  } else {
    $("#channel-customize").slideUp("slow");
  }
}

function pictures_table() {
    document.getElementById("misc-table").style.display = "none";
    document.getElementById("bg-table").style.display = "none";
    document.getElementById("pictures-table").style.display = "block";
    document.getElementById("pictures").className = "selected-user";
    document.getElementById("text").className = "non";
    document.getElementById("bg").className = "non";
};

function text_table() {
    document.getElementById("misc-table").style.display = "block";
    document.getElementById("bg-table").style.display = "none";
    document.getElementById("pictures-table").style.display = "none";
    document.getElementById("pictures").className = "non";
    document.getElementById("text").className = "selected-user";
    document.getElementById("bg").className = "non";
};

function bg_table() {
    document.getElementById("misc-table").style.display = "none";
    document.getElementById("bg-table").style.display = "block";
    document.getElementById("pictures-table").style.display = "none";
    document.getElementById("pictures").className = "non";
    document.getElementById("text").className = "non";
    document.getElementById("bg").className = "selected-user";
};
</script>
<div class="channel-customization-base" id="channel-customize" style="display: none;">
    <div class="user-header-bottom" style="margin: -5px;">
        <div class="www-header-list" style="margin-top: 0px;">
            <a class="www-header-item" href="#" onclick="pictures_table()">Main</a>
            <a class="www-header-item" href="#" onclick="bg_table()">Background</a>
            <a class="www-header-item" href="#" onclick="text_table()">Colors</a>
        </div>
    </div>

    <table id="pictures-table" style="position: relative;right: 43px;">
        <tr>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <h1>Avatar</h1>
                Preview your avatar below. To upload a new avatar, choose a new file.<br>
                <img src="/dynamic/pfp/<?php echo $_user['pfp']; ?>" style="width: 100px; height: 100px;"><br>
<?php if($_user['pfp'] != "default.png") { ?>
                            <a href="/get/remove_profile_pic">Remove Profile Picture</a><br>
                        <?php } ?>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="avatar-upload">
                    <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                    <input class="yt-uix-button yt-uix-button-default" type="submit" value="Upload Image" name="pfpset">
                </form><br><br>

                <h1>Channel Title</h1>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                <input style="padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3;width: 345px;" id="biomd" placeholder="<?php echo htmlspecialchars($_user['username']);?>'s Channel" value="<?php echo htmlspecialchars($_user['custom_header']);?>" name="videoid">
                    <input class="yt-uix-button yt-uix-button-default" name="headerset" type="submit" value="Set">
                </form><br><br>

<h1>Country</h1>
                        <form action="/post/channel_update" enctype="multipart/form-data" method="post">
                            <select class="yt-uix-button yt-uix-button-default" id="country" name="country" value="<?php echo $_user['country']?>">
                            <?php
                            $countries = array(
                                "Select country","Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"
                            );

                            $countryLength = sizeof($countries);
                            $i = 0;
                            for($i = 0;$i <= $countryLength; $i++)
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
<input class="yt-uix-button yt-uix-button-default" name="countryset" type="submit" value="Set">
                        </form><br><br>

<?php $categories = ["None", "Director", "Musician", "Comedian", "Guru", "Nonprofit"]; ?>
                        
                            <h1>Channel Genre</h1><br>
                            This will show what type of channel you are to other users.<br>
                            <form action="/post/channel_update" enctype="multipart/form-data" method="post">
                                <select class="yt-uix-button yt-uix-button-default" name="genre" value="<?php echo $_user['genre']; ?>">
                                    <?php foreach($categories as $category) { ?>
                                        <option value="<?php echo $category; ?>" <?php if (strtolower($category) == strtolower($_user['genre'])) {echo 'selected="selected"';} ?>><?php echo $category; ?></option>
                                    <?php } ?>
                                </select>
<input class="yt-uix-button yt-uix-button-default" name="genreset" type="submit" value="Set">
                            </form><br><br>
                        

            </td>
            <td style="vertical-align: top; width: 432px;">
                <h1>Bio</h1>
                Set text (Max 2000 characters)<br>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                    <textarea style="width: 345px;padding: 0px;background-color:white;border: 1px solid #d3d3d3;" id="biomd" placeholder="Bio" name="bio"><?php echo htmlspecialchars($_user['bio']); ?></textarea><br>
                    <input class="yt-uix-button yt-uix-button-default" name="bioset" type="submit" value="Set">
                </form><br><br>

                <h1>Featured Video</h1>
                Must not have extra whitespace/spaces at the end. Example: MTYwNTQ4ODc4Mja=24 is valid. DO NOT INCLUDE THE SITE DOMAIN, JUST THE ID<br>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                <input style="padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3;width: 345px;" id="biomd" placeholder="Video ID" value="<?php echo htmlspecialchars($_user['featured']);?>" name="videoid">
                    <input class="yt-uix-button yt-uix-button-default" name="featuredset" type="submit" value="Set">
                </form><br><br>

		<h1>Custom CSS</h1>
                        <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                            Prefix every image url() with //images.weserv.nl/?url=<br>    
                            <textarea class="yt-uix-form-input-text"  style="width: 288px;padding: 0px;background-color:white;border: 1px solid #d3d3d3;" id="biomd" placeholder="Custom CSS" name="css"><?php echo htmlspecialchars($_user['css']); ?></textarea><br><br>
			   <input class="yt-uix-button yt-uix-button-default" name="cssset" type="submit" value="Set">
                        </form><br><br>
                <h1>Contact Custom Text</h1>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                <input style="padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3;width: 345px;" id="biomd" placeholder="Contact with <?php echo htmlspecialchars($_user['username']);?>" value="<?php echo htmlspecialchars($_user['contact_custom_text']);?>" name="contact_custom_text">
                    <input class="yt-uix-button yt-uix-button-default" name="contactset" type="submit" value="Set">
                </form><br><br>
                <h1>Website URL</h1>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                <input style="padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3;width: 345px;" id="biomd" placeholder="Website URL" value="<?php echo htmlspecialchars($_user['website']);?>" name="customurl">
                    <input class="yt-uix-button yt-uix-button-default" name="urlset" type="submit" value="Set">
                </form><br><br>
                <h1>Watch Page Subscribe Button</h1>
                        <?php if(!empty($_user['subbutton'])) { ?>
                            <a href="/get/remove_watch_banner">Remove Watch Page Banner</a><br>
                        <?php } ?>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="avatar-upload">
                    <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                    <input class="yt-uix-button yt-uix-button-default" type="submit" value="Upload Image" name="ssubtset">
                </form><br><br>
<h1>Toggle Layout</h1>
                                Switch between the 2012 and 2009 channel layouts.<br>
                                <a href="/get/toggle_layout">Toggle Layout</a><br><br>


            </td>
            <!--
            <script>
                $('#bg-uplod').on('click', function() {
                    $('#background-upload').trigger('click');
                }); 

                $('#av-uplod').on('click', function() {
                    $('#avatar-upload').trigger('click');
                });

                $(document).ready(function(){
                    $("#background-upload").click(function(){
                        $(this).val("");
                    });

                    $("#background-upload").change(function(){
                        var path = $(this).val();
                        var filename = path.replace(/^.*\\/, "");
                        alert(filename);
                    });
                });

                $(document).ready(function(){
                    $("#avatar-upload").click(function(){
                        $(this).val("");
                    });

                    $("#avatar-upload").change(function(){
                        var path = $(this).val();
                        var filename = path.replace(/^.*\\/, "");
                        alert(filename);
                    });
                });
            </script>
            -->
        </tr>
    </table>

    <table id="misc-table" style="display: none;position: relative;right: 43px;">
        <tr>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <h1>Primary Color</h1>
                This will change the background of your boxes' tabs"<br>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                    Choose a color: <input type="color" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['primary_color']); ?>"><br>
                    <input class="yt-uix-button yt-uix-button-default" name="primary" type="submit" value="Set">
                </form><br><br>
                <h1>Channel Box Color</h1>
                This will change the infobox's background color.<br>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                    Choose a color: <input type="color" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['secondary_color']); ?>"><br>
                    <input class="yt-uix-button yt-uix-button-default" name="secondary" type="submit" value="Set">
                </form><br><br>

            </td>
            <td style="vertical-align: top;     padding-left: 94px; width: 432px;">
            <h1>Background Color</h1>
                This will change the background of all the other boxes.<br>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                    Choose a color: <input type="color" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['third_color']); ?>"><br>
                    <input class="yt-uix-button yt-uix-button-default" name="third" type="submit" value="Set">
                </form><br><br>
                <h1>Text Color</h1>
                This will change the color of the box ribbons.<br>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                    Choose a color: <input type="color" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['text_color']); ?>"><br>
                    <input class="yt-uix-button yt-uix-button-default" name="textcolor" type="submit" value="Set">
                </form><br><br>
                <h1>Text Main Color</h1>
                This will change the color of the box ribbons.<br>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                    Choose a color: <input type="color" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['primary_color_text']); ?>"><br>
                    <input class="yt-uix-button yt-uix-button-default" name="textprimarycolor" type="submit" value="Set">
                </form><br><br>
            </td>
            <!--
            <script>
                $('#bg-uplod').on('click', function() {
                    $('#background-upload').trigger('click');
                }); 

                $('#av-uplod').on('click', function() {
                    $('#avatar-upload').trigger('click');
                });

                $(document).ready(function(){
                    $("#background-upload").click(function(){
                        $(this).val("");
                    });

                    $("#background-upload").change(function(){
                        var path = $(this).val();
                        var filename = path.replace(/^.*\\/, "");
                        alert(filename);
                    });
                });

                $(document).ready(function(){
                    $("#avatar-upload").click(function(){
                        $(this).val("");
                    });

                    $("#avatar-upload").change(function(){
                        var path = $(this).val();
                        var filename = path.replace(/^.*\\/, "");
                        alert(filename);
                    });
                });
            </script>
            -->
        </tr>
    </table>

    <table id="bg-table" style="display: none;"> 
        <tr>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <h1>Background Options</h1>
                Choose how your background will be displayed.<br>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                    <select name="bgoption" id="ifyouarereadingthisYOUSUCK" value="<?php echo htmlspecialchars($_user['2012_bgoption']); ?>">
                        <option value="repeaty" <?php if ($_user['2012_bgoption'] == 'repeaty') {echo 'selected="selected"';} ?>>Repeat - Y</option>
                        <option value="repeatx" <?php if ($_user['2012_bgoption'] == 'repeatx') {echo 'selected="selected"';} ?>>Repeat - X</option>
                        <option value="norepeat" <?php if ($_user['2012_bgoption'] == 'norepeat') {echo 'selected="selected"';} ?>>No Repeat</option>
                        <option value="repeatxy" <?php if ($_user['2012_bgoption'] == 'repeatxy') {echo 'selected="selected"';} ?>>Repeat - X and Y</option>
                        <option value="stretch" <?php if ($_user['2012_bgoption'] == 'stretch') {echo 'selected="selected"';} ?>>Stretch</option>
                        <option value="solid" <?php if ($_user['2012_bgoption'] == 'solid') {echo 'selected="selected"';} ?>>Solid</option>
                    </select><br>
                    Choose a color: <input type="color" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['2012_bgcolor']); ?>"><br>
                    <input class="yt-uix-button yt-uix-button-default" name="bgoptionset" type="submit" value="Set">
                </form><br><br>
            </td>
            <td style="vertical-align: top;     padding-left: 94px; width: 432px;">
                <h1>Background</h1>
                Choose Image (Max file size: 10MB)<br>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="background-upload">
                    <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                    <input class="yt-uix-button yt-uix-button-default" type="submit" value="Upload Background" name="bgset">
                </form><br><br>
		<h1>Banner</h1>
                Choose Image (Max file size: 10MB)<br>
                        <?php if(!empty($_user['banner'])) { ?>
                            <a href="/get/remove_channel_banner">Remove Banner</a><br>
                        <?php } ?>
                <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="background-upload">
                    <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                    <input class="yt-uix-button yt-uix-button-default" type="submit" value="Upload Banner" name="bannerset">
                </form><br><br>
		<h1>Banner Image Map</h1>
                        <form method="post" action="/post/channel_update" enctype="multipart/form-data">
                             Map name should be "imgmap"<br>    
                            <textarea class="yt-uix-form-input-text"  style="width: 288px;padding: 0px;background-color:white;border: 1px solid #d3d3d3;" id="biomd" placeholder="" name="banner_image_map"><?php echo htmlspecialchars($_user['banner_image_map']); ?></textarea><br><br>
			   <input class="yt-uix-button yt-uix-button-default" name="bannerimagemap" type="submit" value="Set">
                        </form><br><br>
            </td>
            <!--
            <script>
                $('#bg-uplod').on('click', function() {
                    $('#background-upload').trigger('click');
                }); 

                $('#av-uplod').on('click', function() {
                    $('#avatar-upload').trigger('click');
                });

                $(document).ready(function(){
                    $("#background-upload").click(function(){
                        $(this).val("");
                    });

                    $("#background-upload").change(function(){
                        var path = $(this).val();
                        var filename = path.replace(/^.*\\/, "");
                        alert(filename);
                    });
                });

                $(document).ready(function(){
                    $("#avatar-upload").click(function(){
                        $(this).val("");
                    });

                    $("#avatar-upload").change(function(){
                        var path = $(this).val();
                        var filename = path.replace(/^.*\\/, "");
                        alert(filename);
                    });
                });
            </script>
            -->
        </tr>
    </table>
</div>
