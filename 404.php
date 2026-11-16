<?php header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>404 Not Found</title>
<style type="text/css">
body {font-family: 'Trebuchet MS', serif; text-align:center}
</style>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<h1 style="color: #E00;">Not Found</h1>
<p><img src="/static/img/404.png" border="1" width="50%" /></p>
<p>The requested URL <?php echo parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH); ?> was not found on this server. (;´Д`)</p>
<p>You may want to try going back to <a href="javascript:history.back();" style="color: #C00; text-decoration: none;">your last visited webpage</a> or <a href="/" style="color: #C00; text-decoration: none;">the homepage</a>!</p>
</body>
</html>
