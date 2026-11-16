<?php

/**
* @Auther: bhief
* @Version: 1.0
*
* Gets info from videos 
*
**/
class video_helper {
    public $__db;

    public function sh_exec(string $cmd, string $outputfile = "", string $pidfile = "", bool $mergestderror = true, bool $bg = false) {
        $fullcmd = $cmd;
        if(strlen($outputfile) > 0) $fullcmd .= " >> " . $outputfile;
        if($mergestderror) $fullcmd .= " 2>&1";
        
        if($bg) {
            $fullcmd = "nohup " . $fullcmd . " &";
            if(strlen($pidfile)) $fullcmd .= " echo $! > " . $pidfile;
        } else {
            if(strlen($pidfile) > 0) $fullcmd .= "; echo $$ > " . $pidfile;
        }
        shell_exec($fullcmd);
    }

    function file_get_contents_chunked($file, $chunk_size, $callback) {
        try {
            $handle = fopen($file, "r");
            $i = 0;
            while (!feof($handle)) {
                call_user_func_array($callback,array(fread($handle,$chunk_size),&$handle,$i));
                $i++;
            }
    
            fclose($handle);
        }
        catch(Exception $e) {
            trigger_error("file_get_contents_chunked::" . $e->getMessage(),E_USER_NOTICE);
            return false;
        }

        return true;
    }

	public function __construct($conn){
        $this->__db = $conn;
	}

    function fetch_video_views(string $id) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM views WHERE videoid = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_video_favourites(string $id) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM favorite_video WHERE reciever = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_views_from_user($user) {
        $stmt = $this->__db->prepare("SELECT `rid` FROM videos WHERE author = :username");
        $stmt->bindParam(":username", $user);
        $stmt->execute();
        
        $views = 0;
        while($video = $stmt->fetch(PDO::FETCH_ASSOC)) { 
            $views = $views + $this->fetch_video_views($video['rid']);
        }
        $stmt = null;
        return $views;
    }

    function get_comments_from_video($id) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM comments WHERE toid = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function get_groups_from_video($id) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM group_videos WHERE video = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_group_member_count($id) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM group_members WHERE togroup = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_group_video_count($id) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM group_videos WHERE toid = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_group_playlist_count($id) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM group_playlists WHERE toid = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    /* Function by daylin */
    function timeToSeekEquation($time) { 
        $times = preg_split('/:/', $time);
        $timesc = count($times);
        $final = '';
        if ($times[0] != 0) {
            for ($i = 0; $i < $timesc; $i++) {
                $remaining = $timesc - $i - 1;
                if ($i < $timesc - 1) {
                    $final.=$times[$i].'*'.(60 ** $remaining).'+';
                } else {
                    $final.=$times[$i];
                }
            }
        } else {
            $final = $times[1];
        }
        return $final;
    }

    function shorten_description(string $description, int $limit, bool $newlines = false) {
        $description = trim($description);
        if(strlen($description) >= $limit) {
            $description = substr($description, 0, $limit) . "...";
        } 

        $description = htmlspecialchars($description, ENT_SUBSTITUTE);
        $formatting_find = [
            //smileys
            "/(?<![\/\w])\:mona2\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:nida\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:af2\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:nagato\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:iyahoo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:purin\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:araebi\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:mona3\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:saitama\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:unko\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:ranta\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:mosa\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:shii\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:syobo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:iyou\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:1san\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:zuri\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:13uo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:monatya\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:pata\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:kasari\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:snowman\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:depression\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:monapc\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:ppa\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:rocket\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:saitama2\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:eiki\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:banana\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:sip\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:meow\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:gobo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:waffle\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:semicolon\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:taco\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:eggplant\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:sushi\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:apple\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:broccoli\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:pizza\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:candycorn\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:10mil\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:map\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:camera\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:suitcase\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:compass\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:binoculars\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:ksllxmfcai\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:cupcake\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:cat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:awwcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:coolcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:tongueoutcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:winkcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:lolcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:upsidedowncat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:huhcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:loveitcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:favitcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:rainbowcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:pizzacat\:(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;\:\(|&gt;\:\-\(|&gt;\=\(|&gt;\=\-\(|D\:|D\-\:|D\=|D\-\=)(?![^<>]*\>)/",
            "/(?<![\/\w])\^_\^(?![^<>]*\>)/",
            "/(?<![\/\w])(8\)|8\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;\:\)|&gt;\:\-\)|&gt;\=\)|&gt;\=\-\)|&gt;\:D|&gt;\:\-D|&gt;\=D|&gt;\=\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:D|\:\-D|\=D|\=\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;;\)|&gt;;\-\)|&gt;;D|&gt;;\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(;D|;\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])\:blue\:(?![^<>]*\>)/",
            "/(?<![\/\w])(o\.O|O\.o)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\?|\:\-\?|\=\?|\=\-\?)(?![^<>]*\>)/",
            "/(?<![\/\w])(B\)|B\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\(|\:\-\(|\=\(|\=\-\()(?![^<>]*\>)/",
            "/(?<![\/\w])&lt;3(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\/|\:\-\/|\=\/|\=\-\/|\:\\\\|\:\-\\\\|\=\\\\|\=\-\\\\)(?![^<>]*\>)/",
            "/(?<![\/\w])(XD|X\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(&lt;_&lt;|&lt;\.&lt;)(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;_&gt;|&gt;\.&gt;)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\||\:\-\||\=\||\=\-\||\:I|\\:\-\I|\=I|\=\-I)(?![^<>]*\>)/",
            "/(?<![\/\w])(O\:\)|O\:\-\)|O\=\)|O\=\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])\:zzz\:(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\)|\:\-\)|\=\)|\=\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(\:3|\:\-3|\=3|\=\-3)(?![^<>]*\>)/",
            "/(?<![\/\w])\:star\:(?![^<>]*\>)/",
            "/(?<![\/\w])(\:O|\:\-O|\=O|\=\-O)(?![^<>]*\>)/",
            "/(?<![\/\w])\^\^;(?![^<>]*\>)/",
            "/(?<![\/\w])(&lt;g&gt;|&lt;G&gt;)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:P|\:\-P|\=P|\=\-P|X\-P)(?![^<>]*\>)/",
            "/(?<![\/\w])(;\)|;\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(;3|;\-3)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:s |\:\-S |\=s|\=\-S)(?![^<>]*\>)/",
            //markdown
            '@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-~]*(\?\S+)?)?)?)@', //urls
            "/(?<=\s|^)@([a-zA-Z0-9-]+|\\+\\])/", //user profile ats
            "/(?<=\s|^)#([a-zA-Z0-9-]+|\\+\\])/", //hashtags
            "/^&gt;(.*)$/m", //greentext
            "/^&lt;(.*)$/m", //orange text
            "/^\^(.*)$/m", //light blue text
            "/==(.+?)==/s", //red text
            "/--(.+?)--/s", //blue text
            "/-=(.+?)-=/s", //purple text
            "/'''(.+?)'''/s", //bold
            "/''(.+?)''/s", //italic
            "/~~(.+?)~~/s", //strikethrough
            "/\*\*(.+?)\*\*/s", //spoiler
            "/__(.+?)__/s", //underline
            "/```(.+?)```/s", //code text
            "/\+=(.+?)=\+/s", //big text
            "/_=(.+?)=_/s", //tiny text
            "/@\\$(.+?)@\\$/s", //shift jis text
            "/%%(.+?)%%/s", //glow text
            "/\:\:(.+?)\:\:/s", //sneed text
            "/\!\!(.+?)\!\!/s", //red glow
            "/;;(.+?);;/s", //blue glow
            "/~\-~(.+?)~\-~/s", //rainbow text
            "/\-~\-(.+?)\-~\-/s" //pisces text
        ];
        $formatting_replace = [
            //smileys
            '<img src="/static/smileys/mona2.gif" alt=":mona2:" title=":mona2:" class="bbcode_smiley">',
            '<img src="/static/smileys/nida.gif" alt=":nida:" title=":nida:" class="bbcode_smiley">',
            '<img src="/static/smileys/af2.gif" alt=":af2:" title=":af2:" class="bbcode_smiley">',
            '<img src="/static/smileys/nagato.gif" alt=":nagato:" title=":nagato:" class="bbcode_smiley">',
            '<img src="/static/smileys/iyahoo.gif" alt=":iyahoo:" title=":iyahoo:" class="bbcode_smiley">',
            '<img src="/static/smileys/purin.gif" alt=":purin:" title=":purin:" class="bbcode_smiley">',
            '<img src="/static/smileys/araebi.gif" alt=":araebi:" title=":araebi:" class="bbcode_smiley">',
            '<img src="/static/smileys/2mona2.gif" alt=":mona3:" title=":mona3:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_saitama05.gif" alt=":saitama:" title=":saitama:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_unko.gif" alt=":unko:" title=":unko:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_imanouchi04.gif" alt=":ranta:" title=":ranta:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_mosa.gif" alt=":mosa:" title=":mosa:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_shii01.gif" alt=":shii:" title=":shii:" class="bbcode_smiley">',
            '<img src="/static/smileys/syobo2.gif" alt=":syobo:" title=":syobo:" class="bbcode_smiley">',
            '<img src="/static/smileys/2iyou_2.gif" alt=":iyou:" title=":iyou:" class="bbcode_smiley">',
            '<img src="/static/smileys/1san32.gif" alt=":1san:" title=":1san:" class="bbcode_smiley">',
            '<img src="/static/smileys/zuri.gif" alt=":zuri:" title=":zuri:" class="bbcode_smiley">',
            '<img src="/static/smileys/13uo.gif" alt=":13uo:" title=":13uo:" class="bbcode_smiley">',
            '<img src="/static/smileys/monatya.gif" alt=":monatya:" title=":monatya:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_pata.gif" alt=":pata:" title=":pata:" class="bbcode_smiley">',
            '<img src="/static/smileys/kasa-ri.gif" alt=":kasari:" title=":kasari:" class="bbcode_smiley">',
            '<img src="/static/smileys/showman.gif" alt=":snowman:" title=":snowman:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_sasu.gif" alt=":depression:" title=":depression:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_miruna_pc.gif" alt=":monapc:" title=":monapc:" class="bbcode_smiley">',
            '<img src="/static/smileys/ppa.gif" alt=":ppa:" title=":ppa:" class="bbcode_smiley">',
            '<img src="/static/smileys/10ite.gif" alt=":rocket:" title=":rocket:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_saitama06.gif" alt=":saitama2:" title=":saitama2:" class="bbcode_smiley">',
            '<img src="/static/smileys/eiki.gif" alt=":eiki:" title=":eiki:" class="bbcode_smiley">',
            '<img src="/static/smileys/banana.gif" alt=":banana:" title=":banana:" class="bbcode_smiley">',
            '<img src="/static/smileys/sip.gif" alt=":sip:" title=":sip:" class="bbcode_smiley">',
            '<img src="/static/smileys/Meow.png" alt=":meow:" title=":meow:" class="bbcode_smiley">',
            '<img src="/static/smileys/Gobo_emoji.png" alt=":gobo:" title=":gobo:" class="bbcode_smiley">',
            '<img src="/static/smileys/Waffle_Emoji.png" alt=":waffle:" title=":waffle:" class="bbcode_smiley">',
            '<img src="/static/smileys/Semicolon_Emoticon.png" alt=":semicolon:" title=":semicolon:" class="bbcode_smiley">',
            '<img src="/static/smileys/Taco_emoji.png" alt=":taco:" title=":taco:" class="bbcode_smiley">',
            '<img src="/static/smileys/Eggplant_emoji.png" alt=":eggplant:" title=":eggplant:" class="bbcode_smiley">',
            '<img src="/static/smileys/Sushi_emoji.png" alt=":sushi:" title=":sushi:" class="bbcode_smiley">',
            '<img src="/static/smileys/Apple_emoji.png" alt=":apple:" title=":apple:" class="bbcode_smiley">',
            '<img src="/static/smileys/Broccoli_emoji.png" alt=":broccoli:" title=":broccoli:" class="bbcode_smiley">',
            '<img src="/static/smileys/Pizza_emoji.png" alt=":pizza:" title=":pizza:" class="bbcode_smiley">',
            '<img src="/static/smileys/Candycorn.png" alt=":candycorn:" title=":candycorn:" class="bbcode_smiley">',
            '<img src="/static/smileys/10milemoji.png" alt=":10mil:" title=":10mil:" class="bbcode_smiley">',
            '<img src="/static/smileys/Map_emoji.png" alt=":map:" title=":map:" class="bbcode_smiley">',
            '<img src="/static/smileys/Camera_emoji.png" alt=":camera:" title=":camera:" class="bbcode_smiley">',
            '<img src="/static/smileys/Suitcase_emoji.png" alt=":suitcase:" title=":suitcase:" class="bbcode_smiley">',
            '<img src="/static/smileys/Compass.png" alt=":compass:" title=":compass:" class="bbcode_smiley">',
            '<img src="/static/smileys/Binoculars.png" alt=":binoculars:" title=":binoculars:" class="bbcode_smiley">',
            '<img src="/static/smileys/Ksllxmfcai-emoji.png" alt=":ksllxmfcai:" title=":ksllxmfcai:" class="bbcode_smiley">',
            '<img src="/static/smileys/Cupcake.png" alt=":cupcake:" title=":cupcake:" class="bbcode_smiley">',
            '<img src="/static/smileys/Cat-emoji.png" alt=":cat:" title=":cat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Aww-cat-emoji.png" alt=":awwcat:" title=":awwcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Cool-cat-emoji.png" alt=":coolcat:" title=":coolcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Tongue-out-cat-emoji.png" alt=":tongueoutcat:" title=":tongueoutcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Wink-cat-emoji.png" alt=":winkcat:" title=":winkcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Lol-cat-emoji.png" alt=":lolcat:" title=":lolcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Upside-down-cat-emoji.png" alt=":upsidedowncat:" title=":upsidedowncat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Huh-cat-emoji.png" alt=":huhcat:" title=":huhcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Love-it-cat-emoji.png" alt=":loveitcat:" title=":loveitcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Fav-it-cat-emoji.png" alt=":favitcat:" title=":favitcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Rainbow-cat-emoji.png" alt=":rainbowcat:" title=":rainbowcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Pizza-cat-emoji.png" alt=":pizzacat:" title=":pizzacat:" class="bbcode_smiley">',
            '<img src="/static/smileys/angry.gif" alt="&gt;:(" title="&gt;:(" class="bbcode_smiley">',
            '<img src="/static/smileys/anime.gif" alt="^_^" title="^_^" class="bbcode_smiley">',
            '<img src="/static/smileys/bigeyes.gif" alt="8)" title="8)" class="bbcode_smiley">',
            '<img src="/static/smileys/evil.gif" alt="&gt;:)" title="&gt;:)" class="bbcode_smiley">',
            '<img src="/static/smileys/bigsmile.gif" alt=":D" title=":D" class="bbcode_smiley">',
            '<img src="/static/smileys/sneaky.gif" alt="&gt;;)" title="&gt;;)" class="bbcode_smiley">',
            '<img src="/static/smileys/bigwink.gif" alt=";D" title=";D" class="bbcode_smiley">',
            '<img src="/static/smileys/blue.gif" alt=":blue:" title=":blue:" class="bbcode_smiley">',
            '<img src="/static/smileys/boggle.gif" alt="o.O" title="o.O" class="bbcode_smiley">',
            '<img src="/static/smileys/confuse.gif" alt=":?" title=":?" class="bbcode_smiley">',
            '<img src="/static/smileys/cool.gif" alt="B)" title="B)" class="bbcode_smiley">',
            '<img src="/static/smileys/frown.gif" alt=":(" title=":(" class="bbcode_smiley">',
            '<img src="/static/smileys/heart.gif" alt="&lt;3" title="&lt;3" class="bbcode_smiley">',
            '<img src="/static/smileys/irritated.gif" alt=":/" title=":/" class="bbcode_smiley">',
            '<img src="/static/smileys/laugh.gif" alt="XD" title="XD" class="bbcode_smiley">',
            '<img src="/static/smileys/lookleft.gif" alt="&lt_&lt;" title="&lt;_&lt;" class="bbcode_smiley">',
            '<img src="/static/smileys/lookright.gif" alt="&gt_&gt;" title="&gt;_&gt;" class="bbcode_smiley">',
            '<img src="/static/smileys/neutral.gif" alt=":|" title=":|" class="bbcode_smiley">',
            '<img src="/static/smileys/saint.gif" alt="O:)" title="O:)" class="bbcode_smiley">',
            '<img src="/static/smileys/sleepy.gif" alt=":zzz:" title=":zzz:" class="bbcode_smiley">',
            '<img src="/static/smileys/smile.gif" alt=":)" title=":)" class="bbcode_smiley">',
            '<img src="/static/smileys/smile3.gif" alt=":3" title=":3" class="bbcode_smiley">',
            '<img src="/static/smileys/star.gif" alt=":star:" title=":star:" class="bbcode_smiley">',
            '<img src="/static/smileys/surprise.gif" alt=":O" title=":O" class="bbcode_smiley">',
            '<img src="/static/smileys/sweatdrop.gif" alt="^^;" title="^^;" class="bbcode_smiley">',
            '<img src="/static/smileys/teeth.gif" alt="&lt;g&gt;" title="&lt;g&gt;" class="bbcode_smiley">',
            '<img src="/static/smileys/tongue.gif" alt=":P" title=":P" class="bbcode_smiley">',
            '<img src="/static/smileys/wink.gif" alt=";)" title=";)" class="bbcode_smiley">',
            '<img src="/static/smileys/wink3.gif" alt=";3" title=";3" class="bbcode_smiley">',
            '<img src="/static/smileys/worry.gif" alt=":s" title=":s" class="bbcode_smiley">',
            //markdown
            '<a href="$1" rel="noopener noreferrer nofollow ugc" target="_blank">$1</a>', //urls
            "<a href='/user/$1'>@$1</a>", //user profile ats
            "<a href='/search_query?q=%23$1'>#$1</a>", //hashtags
            "<span style='color:#789922;'>&gt;$1</span>", //greentext
            "<span style='color:#f6750b;'>&lt;$1</span>", //orange text
            "<span style='color:#6577E6;'>^$1</span>", //light blue text
            "<b style='color:#af0a0f;'>$1</b>", //red text
            "<b style='color:#2424ad;'>$1</b>", //blue text
            "<b style='color:#720b98;'>$1</b>", //purple text
            "<b>$1</b>", //bold
            "<i>$1</i>", //italic
            "<s>$1</s>", //strikethrough
            "<span class='bbcode_spoiler'>$1</span>", //spoiler
            "<u>$1</u>", //underline
            "<code>$1</code>", //code text
            "<span style='font-size:x-large'>$1</span>", //big text
            "<span style='font-size:x-small'>$1</span>", //tiny text
            "<span class='aagiko'>$1</span>", //shift jis text
            "<span style='text-shadow:0px 0px 40px #00fe20, 0px 0px 2px #00fe20'>$1</span>", //glow text
            "<span style='text-shadow:0px 0px 40px #fffb00, 0px 0px 2px #fffb00'>$1</span>", //sneed text
            "<span style='text-shadow:0px 0px 40px #bd0606, 0px 0px 2px #bd0606'>$1</span>", //red glow
            "<span style='text-shadow:0px 0px 40px #36d7f7, 0px 0px 2px #36d7f7'>$1</span>", //blue glow
            "<span style='background: linear-gradient(to left, red, orange, yellow, green, cyan, blue, violet);-webkit-background-clip: text;-webkit-text-fill-color: transparent;'>$1</span>", //rainbow text
            "<span style='color:#FD3D98; font-weight:bold;'><b>$1</b></span>" //pisces text
        ];
        $description = preg_replace($formatting_find, $formatting_replace, $description);
        $description = preg_replace_callback("/((\d{1,2}:)+\d{2})/", function($matches){ return "<a onclick=\"yt.www.watch.player.seekTo(".$this->timestamp_to_seconds($matches[0]).", false)\">".$matches[0]."</a>"; }, $description); //seek to
        if($newlines) { $description = str_replace(PHP_EOL, "<br>", $description); }
        return $description;
    }

    function timestamp_to_seconds(string $timestamp) {
$str_time = $timestamp;

sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

return $time_seconds;
    }

    function get_video_responses($id) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM video_response WHERE toid = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function get_video_likes($reciever, $liked) {
        if($liked) {
            $stmt = $this->__db->prepare("SELECT count(*) FROM likes WHERE reciever = :reciever AND type = 'l'");
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
        } else {
            $stmt = $this->__db->prepare("SELECT count(*) FROM likes WHERE reciever = :reciever AND type = 'd'");
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
        }
    }

    function check_view($vidid, $user) {
        $stmt = $this->__db->prepare("SELECT 1 FROM views WHERE viewer = :viewer AND videoid = :rid LIMIT 1");
        $stmt->bindParam(":viewer", $user);
        $stmt->bindParam(":rid", $vidid);
        $stmt->execute();
        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;
        if(!$rowExists) {
            $this->add_view($vidid, $user);
        }
    }

    function add_view($vidid, $user) {
        $stmt = $this->__db->prepare("INSERT INTO views (viewer, videoid) VALUES (:user, :vidid)");
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":vidid", $vidid);
        $stmt->execute();
        $stmt = null;
    }

    function get_comment_likes($reciever, $liked) {
        if($liked) {
            $stmt = $this->__db->prepare("SELECT count(*) FROM comment_likes WHERE reciever = :reciever AND type = 'l'");
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
        } else {
            $stmt = $this->__db->prepare("SELECT count(*) FROM comment_likes WHERE reciever = :reciever AND type = 'd'");
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
        }
    }

    function if_liked($user, $reciever, $liked) {
        if($liked) {
            $stmt = $this->__db->prepare("SELECT 1 FROM likes WHERE sender = :sender AND reciever = :reciever AND type = 'l' LIMIT 1");
            $stmt->bindParam(":sender", $user);
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

            return $rowExists;
        } else {
            $stmt = $this->__db->prepare("SELECT 1 FROM likes WHERE sender = :sender AND reciever = :reciever AND type = 'd' LIMIT 1");
            $stmt->bindParam(":sender", $user);
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

            return $rowExists;
        }
    }

    function if_comment_liked($user, $reciever, $liked) {
        if($liked) {
            $stmt = $this->__db->prepare("SELECT 1 FROM comment_likes WHERE sender = :sender AND reciever = :reciever AND type = 'l' LIMIT 1");
            $stmt->bindParam(":sender", $user);
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

            return $rowExists;
        } else {
            $stmt = $this->__db->prepare("SELECT 1 FROM comment_likes WHERE sender = :sender AND reciever = :reciever AND type = 'd' LIMIT 1");
            $stmt->bindParam(":sender", $user);
            $stmt->bindParam(":reciever", $reciever);
            $stmt->execute();

        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

            return $rowExists;
        }
    }

    function fetch_video_rid(string $rid) {
        $stmt = $this->__db->prepare("SELECT * FROM videos WHERE rid = :rid LIMIT 1");
        $stmt->bindParam(":rid", $rid);
        $stmt->execute();

        $valu = ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC));

        $stmt = null;

        return $valu;
    }

    function fetch_less_video_rid(string $rid) {
        $stmt = $this->__db->prepare("SELECT rid, title, thumbnail, duration, title, author FROM videos WHERE rid = :rid LIMIT 1");
        $stmt->bindParam(":rid", $rid);
        $stmt->execute();

        $valu = ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC));

        $stmt = null;

        return $valu;
    }

    function fetch_playlist_rid(string $rid) {
        $stmt = $this->__db->prepare("SELECT * FROM playlists WHERE rid = :rid LIMIT 1");
        $stmt->bindParam(":rid", $rid);
        $stmt->execute();

        $valu = ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC));

        $stmt = null;

        return $valu;
    }

    function fetch_comment_id(string $id) {
        $stmt = $this->__db->prepare("SELECT * FROM comments WHERE id = :id LIMIT 1");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $valu = ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC));

        $stmt = null;

        return $valu;
    }

    function fetch_rand_featured_vid() {
            $stmt = $this->__db->prepare("SELECT * FROM videos WHERE featured = 'v' AND visibility = 'n' ORDER BY rand() LIMIT 1");
            $stmt->execute();

        $valu = ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC));

        $stmt = null;

        return $valu;
    }

    function fetch_user_rating($id, $username) {
        $stmt = $this->__db->prepare("SELECT type FROM stars WHERE reciever = :r AND sender = :s LIMIT 1");
        $stmt->bindParam(":r", $id);
        $stmt->bindParam(":s", $username);
        $stmt->execute();

        $valu = ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC)['type']);

        $stmt = null;

        return $valu;
    }


    function parseTextNoLink($text) {
        $text = trim($text);
        if(strlen($text) >= 90) {
            $text = substr($text, 0, 100) . "...";
        } 
        $text = htmlspecialchars($text, ENT_SUBSTITUTE);
        $text = str_replace(PHP_EOL, "<br>", $text);
        return $text;
    }   

    function get_video_stars_level($id, $level) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM stars WHERE reciever = :id AND type = :lvl");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":lvl", $level, PDO::PARAM_INT);
        $stmt->execute();
    
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function get_video_stars($id) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM stars WHERE reciever = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    } 

    function video_exists($video) {
        $stmt = $this->__db->prepare("SELECT 1 FROM videos WHERE rid = :rid LIMIT 1");
        $stmt->bindParam(":rid", $video);
        $stmt->execute();
        
        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

        return $rowExists;
    }

    function if_favorited($user, $reciever) {
        $stmt = $this->__db->prepare("SELECT 1 FROM favorite_video WHERE sender = :user AND reciever = :reciever LIMIT 1");
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":reciever", $reciever);
        $stmt->execute();
        
        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

        return $rowExists;
    }

    function fetch_user_videos($v) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM videos WHERE author = :v AND visibility = 'n'");
        $stmt->bindParam(":v", $v);
        $stmt->execute(); 
    
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_all_user_videos($v) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM videos WHERE author = :v");
        $stmt->bindParam(":v", $v);
        $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_group_id($id) {
            $stmt = $this->__db->prepare("SELECT * FROM user_groups WHERE id = :v LIMIT 1");
            $stmt->bindParam(":v", $id);
            $stmt->execute();
        $valu = ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC));

        $stmt = null;

        return $valu;
    }


    function fetch_history_ammount($username) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM history WHERE author = :v");
        $stmt->bindParam(":v", $username);
        $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }
}


/* SHITTY FIX INCOMING FOR EMBEDS - MOVE SO IT'S IN EVERY PAGE WHEN POSSIBLE AND NOT LAZY */
$__server->page_embeds->page_title = "WrapperTube - " . $__server->page_title;
$__server->page_embeds->page_description = "WrapperTube is a site where you can upload your videos, animations, Scratch Projects, Artwork, music, and anything.";
$__server->page_embeds->page_url = "http://wrappertube.org/";
?>
