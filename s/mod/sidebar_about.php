<?php
    $__tabs = (object) [
        "help" => (object) [
            "label" => "Help",
            "url" => "/t/help",
            "selected" => false,
        ],

        "blog" => (object) [
            "label" => "Blog",
            "url" => "/blog",
            "selected" => false,
        ],

        "plugin_tutorial" => (object) [
            "label" => "Plugin Tutorial",
            "url" => "/t/plugin_tutorial",
            "selected" => false,
        ],

        "about" => (object) [
            "label" => "About WrapperTube",
            "url" => "/t/about_wrappertube",
            "selected" => false,
        ],

        "Donate" => (object) [
            "label" => "Donate",
            "url" => "/t/donate",
            "selected" => false,
        ],

        "statistics" => (object) [
            "label" => "Statistics",
            "url" => "/t/statistics",
            "selected" => false,
        ],

        "community" => (object) [
            "label" => "Community Guidelines",
            "url" => "/t/community_guidelines",
            "selected" => false,
        ]
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
