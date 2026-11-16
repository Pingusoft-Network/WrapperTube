
<?php if($_user['groups'] != 0) { ?>
<div class="channel-box-profle">
    <div class="channel-box-no-bg" style="border-radius: 3px;padding: 7px;min-height: 137px;">
        <h2 style="font-weight: normal;">Groups (<?php echo $_user['groups']; ?>)</h2><br>
        <?php
            $stmt = $conn->prepare("SELECT * FROM group_members WHERE username = ? ORDER BY id DESC LIMIT 7");
            $stmt->bind_param("s", $_user['username']);
            $stmt->execute();
            $result = $stmt->get_result();
            while($subscriber = $result->fetch_assoc()) {
                $subscriber = $_video_fetch_utils->fetch_group_id($subscriber['togroup']);
                if ($subscriber) {
        ?>
                <div class="grid-item" style="width: 80px;">
                    <a href="/group/<?php echo $subscriber['id']; ?>">
                    <img style="width: 60px;height: 60px;" class="channel-pfp" src="/dynamic/thumbs/<?php echo htmlspecialchars($subscriber['group_picture']); ?>"><br>
                    </a>
                    <a style="font-size: 10px;text-decoration: none;" href="/group/<?php echo $subscriber['id']; ?>"><?php echo htmlspecialchars($subscriber['group_title']); ?></a>
                </div>
        <?php } } $stmt->close(); ?>
        <br>
        <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/groups" style="float: right;font-weight: bold;margin-right: 18px;">see all</a>
    </div>
</div><br>
<?php } ?>
