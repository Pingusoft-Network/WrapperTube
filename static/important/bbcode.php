<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use Nbbc\BBCode;
$bbcode = new BBCode();
$bbcode->SetDetectURLs(true);
$bbcode->SetWikiURL("http://wiki.wrappertube.org/");
$bbcode->SetSmileyDir($_SERVER['DOCUMENT_ROOT'] . '/static/smileys');
$bbcode->SetSmileyURL("/static/smileys");
$bbcode->AddRule('video',  Array(
    'mode' => $bbcode::BBCODE_MODE_CALLBACK,
    'method' => 'videom',
    'content' => $bbcode::BBCODE_VERBATIM,
    'allow_in' => Array('listitem', 'block', 'columns', 'inline', 'link', 'code'),
    'class' => 'image'
));
function videom($bbcode, $action, $name, $default, $params, $content) {
    if ($action == $bbcode::BBCODE_CHECK) {
        if (isset($params['width']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['width'])) {
            return false;
        }
        if (isset($params['height']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['height'])) {
            return false;
        }
        return true;
    }
    $width = isset($params['width']) ? $params['width'] : "560";
    $height = isset($params['height']) ? $params['height'] : "315";
    $id = $content;
    if (!id || !preg_match('/^[a-zA-Z0-9_-]{11}$/', $id)) {
        return "";
    }
    return "<iframe src=\"/embed/{$id}\" width=\"{$width}\" height=\"{$height}\" allowfullscreen=\"true\" frameborder=\"0\"></iframe>";
}
$bbcode->AddRule('youtube',  Array(
    'mode' => $bbcode::BBCODE_MODE_CALLBACK,
    'method' => 'youtube',
    'content' => $bbcode::BBCODE_VERBATIM,
    'allow_in' => Array('listitem', 'block', 'columns', 'inline', 'link', 'code'),
    'class' => 'image'
));
function youtube($bbcode, $action, $name, $default, $params, $content) {
    if ($action == $bbcode::BBCODE_CHECK) {
        if (isset($params['width']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['width'])) {
            return false;
        }
        if (isset($params['height']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['height'])) {
            return false;
        }
        return true;
    }
    $width = isset($params['width']) ? $params['width'] : "560";
    $height = isset($params['height']) ? $params['height'] : "315";
    $id = $content;
    if (!id || !preg_match('/^[a-zA-Z0-9_-]{11}$/', $id)) {
        return "";
    }
    return "<iframe src=\"//www.youtube-nocookie.com/embed/{$id}\" width=\"{$width}\" height=\"{$height}\" allowfullscreen=\"true\" frameborder=\"0\"></iframe>";
}
$bbcode->AddRule('scratchproject',  Array(
    'mode' => $bbcode::BBCODE_MODE_CALLBACK,
    'method' => 'scratchproject',
    'content' => $bbcode::BBCODE_VERBATIM,
    'allow_in' => Array('listitem', 'block', 'columns', 'inline', 'link', 'code'),
    'class' => 'image'
));
function scratchproject($bbcode, $action, $name, $default, $params, $content) {
    if ($action == $bbcode::BBCODE_CHECK) {
        if (isset($params['width']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['width'])) {
            return false;
        }
        if (isset($params['height']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['height'])) {
            return false;
        }
        return true;
    }
    $width = isset($params['width']) ? $params['width'] : "482";
    $height = isset($params['height']) ? $params['height'] : "412";
    $id = $content;
    if (!id || !preg_match('/^\d+$/', $id)) {
        return "";
    }
    return "<iframe src=\"//turbowarp.org/{$id}/embed?addons=pause,gamepad,mute-project,remove-curved-stage-border,drag-drop&amp;settings-button\" allowtransparency=\"true\" scrolling=\"no\" width=\"{$width}\" height=\"{$height}\" allowfullscreen=\"true\" frameborder=\"0\"></iframe>";
}
$bbcode->AddRule('vidlii',  Array(
    'mode' => $bbcode::BBCODE_MODE_CALLBACK,
    'method' => 'vidlii',
    'content' => $bbcode::BBCODE_VERBATIM,
    'allow_in' => Array('listitem', 'block', 'columns', 'inline', 'link', 'code'),
    'class' => 'image'
));
function vidlii($bbcode, $action, $name, $default, $params, $content) {
    if ($action == $bbcode::BBCODE_CHECK) {
        if (isset($params['width']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['width'])) {
            return false;
        }
        if (isset($params['height']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['height'])) {
            return false;
        }
        return true;
    }
    $width = isset($params['width']) ? $params['width'] : "560";
    $height = isset($params['height']) ? $params['height'] : "315";
    $id = $content;
    if (!id || !preg_match('/^[a-zA-Z0-9_-]{11}$/', $id)) {
        return "";
    }
    return "<iframe src=\"//www.vidlii.com/embed?v={$id}&amp;a=0\" width=\"{$width}\" height=\"{$height}\" allowfullscreen=\"true\" frameborder=\"0\"></iframe>";
}
$bbcode->AddRule('penguinmod',  Array(
    'mode' => $bbcode::BBCODE_MODE_CALLBACK,
    'method' => 'penguinmod',
    'content' => $bbcode::BBCODE_VERBATIM,
    'allow_in' => Array('listitem', 'block', 'columns', 'inline', 'link', 'code'),
    'class' => 'image'
));
function penguinmod($bbcode, $action, $name, $default, $params, $content) {
    if ($action == $bbcode::BBCODE_CHECK) {
        if (isset($params['width']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['width'])) {
            return false;
        }
        if (isset($params['height']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['height'])) {
            return false;
        }
        return true;
    }
    $width = isset($params['width']) ? $params['width'] : "482";
    $height = isset($params['height']) ? $params['height'] : "412";
    $id = $content;
    if (!id || !preg_match('/^\d+$/', $id)) {
        return "";
    }
    return "<iframe src=\"//studio.penguinmod.com/embed?addons=pause,gamepad,mute-project,remove-curved-stage-border,drag-drop&amp;settings-button#{$id}\" allowtransparency=\"true\" scrolling=\"no\" width=\"{$width}\" height=\"{$height}\" allowfullscreen=\"true\" frameborder=\"0\"></iframe>";
}
$bbcode->AddRule('snapproject',  Array(
    'mode' => $bbcode::BBCODE_MODE_CALLBACK,
    'method' => 'snapproject',
    'content' => $bbcode::BBCODE_PROHIBIT,
    'end_tag' => $bbcode::BBCODE_PROHIBIT,
    'allow_in' => Array('listitem', 'block', 'columns', 'inline', 'link', 'code'),
    'class' => 'image'
));
function snapproject($bbcode, $action, $name, $default, $params, $content) {
    if ($action == $bbcode::BBCODE_CHECK) {
        if (isset($params['width']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['width'])) {
            return false;
        }
        if (isset($params['height']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['height'])) {
            return false;
        }
        if (!isset($params['username'])) {
            return false;
        }
        if (!isset($params['projectname'])) {
            return false;
        }
        return true;
    }
    $width = isset($params['width']) ? $params['width'] : "480";
    $height = isset($params['height']) ? $params['height'] : "390";
    $projectusername = urlencode($params['username']);
    $projectname = urlencode($params['projectname']);
    return '<iframe width="' . $width . '" height="' . $height . '" frameBorder="0" allowfullscreen="true" allowtransparency="true" scrolling="no" src="//snap.berkeley.edu/embed?projectname=' . $projectname . '&username='. $projectusername . '&showTitle=true&showAuthor=true&editButton=true&pauseButton=true"></iframe>';
}
$bbcode->AddRule('img2',  Array(
    'mode' => $bbcode::BBCODE_MODE_CALLBACK,
    'method' => 'img2',
    'content' => $bbcode::BBCODE_VERBATIM,
    'allow_in' => Array('listitem', 'block', 'columns', 'inline', 'link', 'code'),
    'class' => 'image'
));
function img2($bbcode, $action, $name, $default, $params, $content) {
    if ($action == $bbcode::BBCODE_CHECK) {
        if (isset($params['width']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['width'])) {
            return false;
        }
        if (isset($params['height']) && !preg_match('/^0*[1-9]\d{0,3}$/', $params['height'])) {
            return false;
        }
        return true;
    }
    $width = isset($params['width']) ? (' width="' . $params['width'] . '"') : "";
    $height = isset($params['height']) ? (' height="' . $params['height'] . '"') : "";
    $imgurl = htmlspecialchars($content);
    if (!imgurl) {
        return "";
    }
    return "<img class=\"bbcode_img\" src=\"{$imgurl}\"{$width}{$height}>";
}
$bbcode->AddRule('scratchblocks',  Array(
    'simple_start' => '<pre class="blocks">',
    'simple_end' => '</pre>',
    'content' => $bbcode::BBCODE_VERBATIM,
    'allow_in' => Array('listitem', 'block', 'columns'),
    'class' => 'code'
));
$bbcode->AddRule('sjis',  Array(
    'simple_start' => '<span class="aagiko">',
    'simple_end' => '</span>',
    'allow_in' => Array('listitem', 'block', 'columns', 'inline', 'link'),
    'class' => 'inline'
));
$bbcode->AddRule('glow',  Array(
    'mode' => $bbcode::BBCODE_MODE_ENHANCED,
    'template' => '<span style="text-shadow:0px 0px 40px {$_default}, 0px 0px 2px {$_default}">{$_content}</span>',
    'allow' => Array(
        '_default' => '/(#(?:[0-9a-f]{2}){2,4}$|(#[0-9a-f]{3}$)|(rgb|hsl)a?\((-?\d+%?[,\s]+){2,3}\s*[\d\.]+%?\)$|black$|silver$|gray$|whitesmoke$|maroon$|red$|purple$|fuchsia$|green$|lime$|olivedrab$|yellow$|navy$|blue$|teal$|aquamarine$|orange$|aliceblue$|antiquewhite$|aqua$|azure$|beige$|bisque$|blanchedalmond$|blueviolet$|brown$|burlywood$|cadetblue$|chartreuse$|chocolate$|coral$|cornflowerblue$|cornsilk$|crimson$|currentcolor$|darkblue$|darkcyan$|darkgoldenrod$|darkgray$|darkgreen$|darkgrey$|darkkhaki$|darkmagenta$|darkolivegreen$|darkorange$|darkorchid$|darkred$|darksalmon$|darkseagreen$|darkslateblue$|darkslategray$|darkslategrey$|darkturquoise$|darkviolet$|deeppink$|deepskyblue$|dimgray$|dimgrey$|dodgerblue$|firebrick$|floralwhite$|forestgreen$|gainsboro$|ghostwhite$|goldenrod$|gold$|greenyellow$|grey$|honeydew$|hotpink$|indianred$|indigo$|ivory$|khaki$|lavenderblush$|lavender$|lawngreen$|lemonchiffon$|lightblue$|lightcoral$|lightcyan$|lightgoldenrodyellow$|lightgray$|lightgreen$|lightgrey$|lightpink$|lightsalmon$|lightseagreen$|lightskyblue$|lightslategray$|lightslategrey$|lightsteelblue$|lightyellow$|limegreen$|linen$|mediumaquamarine$|mediumblue$|mediumorchid$|mediumpurple$|mediumseagreen$|mediumslateblue$|mediumspringgreen$|mediumturquoise$|mediumvioletred$|midnightblue$|mintcream$|mistyrose$|moccasin$|navajowhite$|oldlace$|olive$|orangered$|orchid$|palegoldenrod$|palegreen$|paleturquoise$|palevioletred$|papayawhip$|peachpuff$|peru$|pink$|plum$|powderblue$|rosybrown$|royalblue$|saddlebrown$|salmon$|sandybrown$|seagreen$|seashell$|sienna$|skyblue$|slateblue$|slategray$|slategrey$|snow$|springgreen$|steelblue$|tan$|thistle$|tomato$|transparent$|turquoise$|violet$|wheat$|white$|yellowgreen$|rebeccapurple$)/i'
    ),
    'allow_in' => Array('listitem', 'block', 'columns', 'inline', 'link'),
    'class' => 'inline'
));
$bbcode->AddRule('rainbow',  Array(
    'simple_start' => '<span style="background: linear-gradient(to left, red, orange, yellow, green, cyan, blue, violet);-webkit-background-clip: text;-webkit-text-fill-color: transparent;">',
    'simple_end' => '</span>',
    'allow_in' => Array('listitem', 'block', 'columns', 'inline', 'link'),
    'class' => 'inline'
));
$bbcode->AddRule('highlight',  Array(
    'mode' => $bbcode::BBCODE_MODE_ENHANCED,
    'template' => '<span style="background-color:{$_default}">{$_content}</span>',
    'allow' => Array(
        '_default' => '/(#(?:[0-9a-f]{2}){2,4}$|(#[0-9a-f]{3}$)|(rgb|hsl)a?\((-?\d+%?[,\s]+){2,3}\s*[\d\.]+%?\)$|black$|silver$|gray$|whitesmoke$|maroon$|red$|purple$|fuchsia$|green$|lime$|olivedrab$|yellow$|navy$|blue$|teal$|aquamarine$|orange$|aliceblue$|antiquewhite$|aqua$|azure$|beige$|bisque$|blanchedalmond$|blueviolet$|brown$|burlywood$|cadetblue$|chartreuse$|chocolate$|coral$|cornflowerblue$|cornsilk$|crimson$|currentcolor$|darkblue$|darkcyan$|darkgoldenrod$|darkgray$|darkgreen$|darkgrey$|darkkhaki$|darkmagenta$|darkolivegreen$|darkorange$|darkorchid$|darkred$|darksalmon$|darkseagreen$|darkslateblue$|darkslategray$|darkslategrey$|darkturquoise$|darkviolet$|deeppink$|deepskyblue$|dimgray$|dimgrey$|dodgerblue$|firebrick$|floralwhite$|forestgreen$|gainsboro$|ghostwhite$|goldenrod$|gold$|greenyellow$|grey$|honeydew$|hotpink$|indianred$|indigo$|ivory$|khaki$|lavenderblush$|lavender$|lawngreen$|lemonchiffon$|lightblue$|lightcoral$|lightcyan$|lightgoldenrodyellow$|lightgray$|lightgreen$|lightgrey$|lightpink$|lightsalmon$|lightseagreen$|lightskyblue$|lightslategray$|lightslategrey$|lightsteelblue$|lightyellow$|limegreen$|linen$|mediumaquamarine$|mediumblue$|mediumorchid$|mediumpurple$|mediumseagreen$|mediumslateblue$|mediumspringgreen$|mediumturquoise$|mediumvioletred$|midnightblue$|mintcream$|mistyrose$|moccasin$|navajowhite$|oldlace$|olive$|orangered$|orchid$|palegoldenrod$|palegreen$|paleturquoise$|palevioletred$|papayawhip$|peachpuff$|peru$|pink$|plum$|powderblue$|rosybrown$|royalblue$|saddlebrown$|salmon$|sandybrown$|seagreen$|seashell$|sienna$|skyblue$|slateblue$|slategray$|slategrey$|snow$|springgreen$|steelblue$|tan$|thistle$|tomato$|transparent$|turquoise$|violet$|wheat$|white$|yellowgreen$|rebeccapurple$)/i'
    ),
    'allow_in' => Array('listitem', 'block', 'columns', 'inline', 'link'),
    'class' => 'inline'
));
$bbcode->AddSmiley(":mona2:", "mona2.gif");
$bbcode->AddSmiley(":nida:", "nida.gif");
$bbcode->AddSmiley(":af2:", "af2.gif");
$bbcode->AddSmiley(":nagato:", "nagato.gif");
$bbcode->AddSmiley(":iyahoo:", "iyahoo.gif");
$bbcode->AddSmiley(":purin:", "purin.gif");
$bbcode->AddSmiley(":araebi:", "araebi.gif");
$bbcode->AddSmiley(":mona3:", "2mona2.gif");
$bbcode->AddSmiley(":saitama:", "anime_saitama05.gif");
$bbcode->AddSmiley(":unko:", "u_unko.gif");
$bbcode->AddSmiley(":ranta:", "anime_imanouchi04.gif");
$bbcode->AddSmiley(":mosa:", "u_mosa.gif");
$bbcode->AddSmiley(":shii:", "anime_shii01.gif");
$bbcode->AddSmiley(":syobo:", "syobo2.gif");
$bbcode->AddSmiley(":iyou:", "2iyou_2.gif");
$bbcode->AddSmiley(":1san:", "1san32.gif");
$bbcode->AddSmiley(":zuri:", "zuri.gif");
$bbcode->AddSmiley(":13uo:", "13uo.gif");
$bbcode->AddSmiley(":monatya:", "monatya.gif");
$bbcode->AddSmiley(":pata:", "u_pata.gif");
$bbcode->AddSmiley(":kasari:", "kasa-ri.gif");
$bbcode->AddSmiley(":snowman:", "showman.gif");
$bbcode->AddSmiley(":depression:", "u_sasu.gif");
$bbcode->AddSmiley(":monapc:", "anime_miruna_pc.gif");
$bbcode->AddSmiley(":ppa:", "ppa.gif");
$bbcode->AddSmiley(":rocket:", "10ite.gif");
$bbcode->AddSmiley(":saitama2:", "anime_saitama06.gif");
$bbcode->AddSmiley(":eiki:", "eiki.gif");
$bbcode->AddSmiley(":banana:", "banana.gif");
$bbcode->AddSmiley(":sip:", "sip.gif");
$bbcode->AddSmiley(":meow:", "Meow.png");
$bbcode->AddSmiley(":gobo:", "Gobo_emoji.png");
$bbcode->AddSmiley(":waffle:", "Waffle_Emoji.png");
$bbcode->AddSmiley(":semicolon:", "Semicolon_Emoticon.png");
$bbcode->AddSmiley(":taco:", "Taco_emoji.png");
$bbcode->AddSmiley(":eggplant:", "Eggplant_emoji.png");
$bbcode->AddSmiley(":sushi:", "Sushi_emoji.png");
$bbcode->AddSmiley(":apple:", "Apple_emoji.png");
$bbcode->AddSmiley(":broccoli:", "Broccoli_emoji.png");
$bbcode->AddSmiley(":pizza:", "Pizza_emoji.png");
$bbcode->AddSmiley(":candycorn:", "Candycorn.png");
$bbcode->AddSmiley(":10mil:", "10milemoji.png");
$bbcode->AddSmiley(":map:", "Map_emoji.png");
$bbcode->AddSmiley(":camera:", "Camera_emoji.png");
$bbcode->AddSmiley(":suitcase:", "Suitcase_emoji.png");
$bbcode->AddSmiley(":compass:", "Compass.png");
$bbcode->AddSmiley(":binoculars:", "Binoculars.png");
$bbcode->AddSmiley(":ksllxmfcai:", "Ksllxmfcai-emoji.png");
$bbcode->AddSmiley(":cupcake:", "Cupcake.png");
$bbcode->AddSmiley(":cat:", "Cat-emoji.png");
$bbcode->AddSmiley(":awwcat:", "Aww-cat-emoji.png");
$bbcode->AddSmiley(":coolcat:", "Cool-cat-emoji.png");
$bbcode->AddSmiley(":tongueoutcat:", "Tongue-out-cat-emoji.png");
$bbcode->AddSmiley(":winkcat:", "Wink-cat-emoji.png");
$bbcode->AddSmiley(":lolcat:", "Lol-cat-emoji.png");
$bbcode->AddSmiley(":upsidedowncat:", "Upside-down-cat-emoji.png");
$bbcode->AddSmiley(":huhcat:", "Huh-cat-emoji.png");
$bbcode->AddSmiley(":loveitcat:", "Love-it-cat-emoji.png");
$bbcode->AddSmiley(":favitcat:", "Fav-it-cat-emoji.png");
$bbcode->AddSmiley(":rainbowcat:", "Rainbow-cat-emoji.png");
$bbcode->AddSmiley(":pizzacat:", "Pizza-cat-emoji.png");
?>
