<div class="channel-box-profle">
    <div class="channel-box-description">
        <div style="display:inline-block;width:97px;">
        <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>">
        <img class="channel-pfp" src="/dynamic/pfp/<?php echo $_user['pfp']; ?>">
        </a>
        <?php $categories = ["director", "musician", "comedian", "guru", "nonprofit"]; ?>
        <?php if(in_array($_user['genre'], $categories)) { ?>  
            <img style="width:94px" src="/static/img/<?php echo htmlspecialchars($_user['genre']); ?>.gif">
        <?php } ?>
        </div>
        <span class="channel-stats channelsta2" style="width: 193px;">
            <h2 style="font-weight: normal;margin-bottom: 4px;<?php if (isset($banned)) { ?>text-decoration:line-through;color:grey;<?php } ?>"><?php echo htmlspecialchars($_user['username']); ?><?php if($_user['status']=='admin') { ?><span style="color:red;"> ## Admin</span><?php } ?><?php if($_user['status']=='moderator') { ?><span style="color:red;"> ## Mod</span><?php } ?><?php if($_user['partner']=="y") { ?> <img style="width: 29px;vertical-align: middle;margin-left: 10px;" title="This user is trusted" src="/yt/imgbin/RenderedImage.png"><?php } ?> <a href="/feed/channel?n=<?php echo htmlspecialchars($_user['username']); ?>" title="Videos RSS Feed"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h2>
            <?php if(@$_SESSION['siteusername'] != $_user['username']) { ?>
            <a href="javascript:void(0);" onclick="subscribe();return false;">
                <button style="margin: 0px;float: none;" class="sub_button"><?php if($_user['subscribed'] == true) { ?>Unsubscribe<?php } else { ?>Subscribe<?php } ?></button>
            </a>
            <?php } else { ?>
            <a href="#">
                <button style="margin: 0px;float: none;" class="sub_button" onclick="dropdownchannel()">Edit Channel</button>
            </a>
            <?php } ?>

            <br><br>
            <a href="/inbox/compose?to=<?php echo htmlspecialchars($_user['username']); ?>">Send Message</a> |
            <a href="#discussion">Add Comment</a> | 
            <a href="javascript:void(0);" onclick="copyToClipboard('http://wrappertube.org/user/<?php echo htmlspecialchars($_user['username']); ?>');alert('Link copied to your clipboard!');return false;">Share Channel</a> | 
            <?php if($_user_fetch_utils->if_blocked($_SESSION['siteusername'], $_user['username']) == false) { ?>
                <br><a href="javascript:void(0);" onclick="toggle_block();return false;" id="block_text">Block</a> | 
            <?php } else { ?>
                <a href="javascript:void(0);" onclick="toggle_block();return false;" id="block_text">Unblock</a> | 
            <?php } ?>
            <a href="javascript:void(0);" onclick="add_friend();return false;">Add Friend</a>
        </span><br>
    </div>
</div><br>
