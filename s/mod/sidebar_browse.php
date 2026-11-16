<?php
    $__tabs = (object) [
        "videos" => (object) [
            "label" => "All Categories",
            "url" => "/videos",
            "selected" => false,
        ],

        "recommended" => (object) [
            "label" => "Recommended for You",
            "url" => "/recommended",
            "selected" => false,
        ],

        "featured" => (object) [
            "label" => "Featured",
            "url" => "/featured",
            "selected" => false,
        ],

        "recent" => (object) [
            "label" => "Recent",
            "url" => "/recent",
            "selected" => false,
        ],

        "popular" => (object) [
            "label" => "Most Popular",
            "url" => "/popular",
            "selected" => false,
        ],

        "highest_rated" => (object) [
            "label" => "Highest Rated",
            "url" => "/highest_rated",
            "selected" => false,
        ],

        "tags" => (object) [
            "label" => "Tags",
            "url" => "/tags",
            "selected" => false,
        ],

        "autos" => (object) [
            "label" => "Autos &amp; Vehicles",
            "url" => "/autos",
            "selected" => false,
        ],

        "comedy" => (object) [
            "label" => "Comedy",
            "url" => "/comedy",
            "selected" => false,
        ],

        "education" => (object) [
            "label" => "Education",
            "url" => "/education",
            "selected" => false,
        ],

        "entertainment" => (object) [
            "label" => "Entertainment",
            "url" => "/entertainment",
            "selected" => false,
        ],

        "film" => (object) [
            "label" => "Film &amp; Animation",
            "url" => "/film",
            "selected" => false,
        ],

        "gaming" => (object) [
            "label" => "Gaming",
            "url" => "/gaming",
            "selected" => false,
        ],

        "howto" => (object) [
            "label" => "Howto &amp; Style",
            "url" => "/howto",
            "selected" => false,
        ],

        "music" => (object) [
            "label" => "Music",
            "url" => "/music",
            "selected" => false,
        ],

        "news" => (object) [
            "label" => "News &amp; Politics",
            "url" => "/news",
            "selected" => false,
        ],

        "none" => (object) [
            "label" => "None",
            "url" => "/none",
            "selected" => false,
        ],

        "activism" => (object) [
            "label" => "Nonprofits &amp; Activism",
            "url" => "/activism",
            "selected" => false,
        ],

        "people" => (object) [
            "label" => "People &amp; Blogs",
            "url" => "/people",
            "selected" => false,
        ],

        "pets" => (object) [
            "label" => "Pets &amp; Animals",
            "url" => "/pets",
            "selected" => false,
        ],

        "poop" => (object) [
            "label" => "Poop-posting",
            "url" => "/poop_posting",
            "selected" => false,
        ],

        "science" => (object) [
            "label" => "Science &amp; Technology",
            "url" => "/science",
            "selected" => false,
        ],

        "sports" => (object) [
            "label" => "Sports",
            "url" => "/sports",
            "selected" => false,
        ],

        "travel" => (object) [
            "label" => "Travel &amp; Events",
            "url" => "/travel",
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
