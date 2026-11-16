<?php
    $__tabs = (object) [
        "admin" => (object) [
            "label" => "Home",
            "url" => "/vivat_shuravi/",
            "selected" => false,
        ],

        "ban" => (object) [
            "label" => "Manage Accounts",
            "url" => "/vivat_shuravi/bans",
            "selected" => false,
        ],

        "reports" => (object) [
            "label" => "Reports",
            "url" => "/vivat_shuravi/reports",
            "selected" => false,
        ],

        "pms" => (object) [
            "label" => "All PMs",
            "url" => "/vivat_shuravi/all_pms",
            "selected" => false,
        ],

        "hidden_videos" => (object) [
            "label" => "Hidden Videos",
            "url" => "/vivat_shuravi/hidden_videos",
            "selected" => false,
        ],

        "logs" => (object) [
            "label" => "Moderator Logs",
            "url" => "/vivat_shuravi/logs",
            "selected" => false,
        ],
    ];
?>
<div id="browse-side-column" class="ytg-2col ytg-last">
    <ol class="navigation-menu">
        <?php foreach($__tabs as $_tab) { 
            if($_SERVER['REQUEST_URI'] != $_tab->url)
                $_tab->selected = true;
            ?>
            <li class="menu-item">
                <a class="<?php echo $_tab->selected ? true : "selected"; ?>" href="<?php echo $_tab->url; ?>">
                    <?php echo $_tab->label; ?>
                </a>
            </li>
        <?php } ?>
    </ol>
</div>
