<?php
    $__tabs = (object) [
        "overview" => (object) [
            "label" => "Overview",
            "url" => "/account/",
            "selected" => false,
        ],

        "manage" => (object) [
            "label" => "Manage Account",
            "url" => "/account/manage",
            "selected" => false,
        ],

        "signature" => (object) [
            "label" => "Forum Signature",
            "url" => "/forum/signature",
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
