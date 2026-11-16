<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $uploaddir = './pictures/';
    $uploadfile = $uploaddir . $_SERVER['REMOTE_ADDR'];

	$buffer = file_get_contents('php://input');
	if(!$buffer){
		//データの取得に失敗しました。お絵かき画像は保存されません。
		 http_response_code(401);
		 die("error\ninput is empty");
	}
	// 拡張ヘッダー長さを獲得
	$headerLength = substr($buffer, 1, 8);
	// 画像ファイルの長さを取り出す
	$imgLength = substr($buffer, 1 + 8 + $headerLength, 8);
	// 投稿容量制限を超えていたら保存しない
	if($imgLength > 31457280){
		//規定容量オーバー。お絵かき画像は保存されません。
		http_response_code(401);
		die("error\nimage is too big");
	}
	// 画像イメージを取り出す
	$imgdata = substr($buffer, 1 + 8 + $headerLength + 8 + 2, $imgLength);
	// 画像ヘッダーを獲得
	$imgh = substr($imgdata, 1, 5);
	// 拡張子設定
	if($imgh=="PNG\r\n"){
		$imgext = '.png';	// PNG
	}else{
		$imgext = '.jpg';	// JPEG
	}

	$imgfile = fopen($uploadfile . $imgext, "w");
	fwrite($imgfile, $imgdata);
	fclose($imgfile);

	//PCHファイルの長さを取り出す
	$pchLength = substr($buffer, 1 + 8 + $headerLength + 8 + 2 + $imgLength, 8);
	// ヘッダーを獲得
	$h = substr($buffer, 0, 1);
	// 拡張子設定
	$pchext="";
	if($h=='P'){ // EMBEDDED 'P DOCTOS
		$pchext = '.pch';
	}elseif($h=='S'){
		$pchext = '.spch';
	}

	if($pchext && $pchLength){
		// PCHイメージを取り出す
		$PCHdata = substr($buffer, 1 + 8 + $headerLength + 8 + 2 + $imgLength + 8, $pchLength);
		// PCHデータをファイルに書き込む
		$pchfile = fopen($uploadfile . $pchext, "w");
                fwrite($pchfile, $PCHdata);
                fclose($pchfile);
	}

	die("ok");

  }
  else
  {
    http_response_code(401);
    die("error\ni only accept post requests");
  }
