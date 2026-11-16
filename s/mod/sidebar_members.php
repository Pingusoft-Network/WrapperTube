<?php
    $__tabs = (object) [
        "members" => (object) [
            "label" => "Newest Members",
            "url" => "/members",
            "selected" => false,
        ],
        "members2" => (object) [
            "label" => "Most Subscribed",
            "url" => "/most_subscribed",
            "selected" => false,
        ],
        "members3" => (object) [
            "label" => "Popular",
            "url" => "/popular_members",
            "selected" => false,
        ],
        "recently" => (object) [
            "label" => "Recent Visitors",
            "url" => "/recently_logged_in",
            "selected" => false,
        ],
        "members4" => (object) [
            "label" => "Nones",
            "url" => "/nones",
            "selected" => false,
        ],
        "members5" => (object) [
            "label" => "Directors",
            "url" => "/directors",
            "selected" => false,
        ],
        "members6" => (object) [
            "label" => "Musicians",
            "url" => "/musicians",
            "selected" => false,
        ],
        "members7" => (object) [
            "label" => "Comedians",
            "url" => "/comedians",
            "selected" => false,
        ],
        "members8" => (object) [
            "label" => "Gurus",
            "url" => "/gurus",
            "selected" => false,
        ],
        "members9" => (object) [
            "label" => "Nonprofits",
            "url" => "/nonprofits",
            "selected" => false,
        ],
    ];
?>
<div id="browse-side-column" class="ytg-2col ytg-last">
    <ol class="navigation-menu">
        <?php foreach($__tabs as $_tab) { 
            if(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) != $_tab->url)
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
