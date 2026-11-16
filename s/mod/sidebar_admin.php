<?php
    $__tabs = (object) [
        "admin" => (object) [
            "label" => "Home",
            "url" => "/funny_casablanka/",
            "selected" => false,
        ],

        "ban" => (object) [
            "label" => "Manage Accounts",
            "url" => "/funny_casablanka/bans",
            "selected" => false,
        ],

        "reports" => (object) [
            "label" => "Reports",
            "url" => "/funny_casablanka/reports",
            "selected" => false,
        ],

        "pms" => (object) [
            "label" => "All PMs",
            "url" => "/funny_casablanka/all_pms",
            "selected" => false,
        ],

        "hidden_videos" => (object) [
            "label" => "Hidden Videos",
            "url" => "/funny_casablanka/hidden_videos",
            "selected" => false,
        ],

        "logs" => (object) [
            "label" => "Admin Logs",
            "url" => "/funny_casablanka/logs",
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
