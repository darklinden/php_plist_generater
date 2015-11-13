<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>开发版Android自动打包</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>

<div class="card">
<p class="heading">下载链接（url）</p>
<input class="input" type="text" id="urlstr" value="http://download.6513.com/phoneGame/789BY.ipa">
</div>

<div class="card">
<p class="heading">包名（bundle-identifier）</p>
<input class="input" type="text" id="identifier" value="com.789game.buyufish">
</div>

<div class="card">
<p class="heading">版本号（bundle-version）</p>
<input class="input" type="text" id="version" value="1.0">
</div>

<div class="card">
<p class="heading">安装名称（title）</p>
<input class="input" type="text" id="title" value="街机千炮捕鱼">
</div>

<script>

function makeplist() {
    
    var cmd = "";
    
    var urlstr = document.getElementById("urlstr").value;
    cmd += "urlstr=" + urlstr;
    
    var identifier = document.getElementById("identifier").value;
    cmd += "&identifier=" + identifier;
    
    var version = document.getElementById("version").value;
    cmd += "&version=" + version;
    
    var title = document.getElementById("title").value;
    cmd += "&title=" + title;
    
    window.open("maker.php?" + cmd);
}

</script>

<div class="card">
<button class="pkgbtn" onclick="makeplist()">生       成       plist       文       件</button>


<?PHP

	$urlstr = $_GET["urlstr"];
	$identifier = $_GET["identifier"];
	$version = $_GET["version"];
	$title = $_GET["title"];
	
	if ( $urlstr && $identifier && $version && $title ) {
		$cmd = "/usr/local/bin/mkplist -s /Library/WebServer/Documents/plistmaker/src.plist".
				   " -d /Library/WebServer/Documents/plistmaker/plist/".
				   " -urlstr " . $urlstr.
				   " -identifier ". $identifier.
				   " -version ". $version.
				   " -title ". $title;
	
		echo "<p class=\"text\">正在执行: " . $cmd . "</p>";
	
		$cmd = $cmd . " 2>&1";
	
		exec($cmd, $retArr, $retVal);
 	
 		foreach ($retArr as $result) {
 			echo "<p class=\"text\">" . $result . "</p>";
 		}
 	}
	
	

?>

</div>

</body>
</html>
