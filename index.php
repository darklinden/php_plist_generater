<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>iOS文件下载url生成</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>


<?PHP

	date_default_timezone_set('PRC');

	echo "<div class=\"card\">\n";
	echo "<p><label class=\"text\">plist文件自动上传七牛云</label></p>";
	echo "<p><label class=\"text\">文件上传时会耗费较长时间，请耐心等待！</label></p>";
	echo "<p><label class=\"text\">文件上传时会耗费较长时间，请耐心等待！</label></p>";
	echo "<p><label class=\"text\">文件上传时会耗费较长时间，请耐心等待！</label></p>";
	echo "</div>";
	
	$del = $_GET["del"];
	
	if ($del) {
		unlink("../test/" . $del);
		header("Location: index.php");
	}
	
	echo "<div class=\"card\">\n";
	echo "<p class=\"text\"><a href=\"maker.php\">plist文件制作</a></p>";
	echo "</div>";
		
    // output file list in HTML TABLE format
    function getFileList($dir) {
        // array to hold return value
        $retval = array();
        // add trailing slash if missing
        if (substr($dir, -1) != "/") $dir .= "/";
        
        // open pointer to directory and read list of files
        $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
        
        while(false !== ($entry = $d->read())) {
            // skip hidden files
            if($entry[0] == ".") continue;
            if(is_dir("$dir$entry")) {
                $retval[] = array(
                                  "name" => "$dir$entry/",
                                  "type" => filetype("$dir$entry"),
                                  "size" => 0,
                                  "lastmod" => filemtime("$dir$entry")
                                  );
            } elseif(is_readable("$dir$entry")) {
                $retval[] = array(
                                  "name" => "$dir$entry",
                                  "type" => mime_content_type("$dir$entry"),
                                  "size" => filesize("$dir$entry"),
                                  "lastmod" => filemtime("$dir$entry")
                                  );
            }
        }
        
        $d->close();
        return $retval;
    }
    
    $files = getFileList("./plist/");
    
    function sortFileByDate($a, $b) {
		$da = date("Y-m-d H:i:s", $a['lastmod']);
		$db = date("Y-m-d H:i:s", $b['lastmod']);
		
		if ($da > $db) {
			return -1;
		}
		else {
			return 1;
		}
	}

	usort($files, "sortFileByDate");
	
    foreach ($files as $file) {
	    if (basename($file['name']) == "index.php") continue;
        echo "<div class=\"card\">\n";
        echo "<p class=\"text\"><a href=\"{$file['name']}\">", basename($file['name']),"</a></p>\n";
        echo "<p class=\"text\"><button onclick=\"checkAli('".basename($file['name'])."')\">下载链接是否已存在</button><button onclick=\"uploadAli('".basename($file['name'])."')\">上传文件到七牛云生成下载链接</button></p>";
        echo "<p class=\"text\">最后修改时间: ", date("Y-m-d H:i:s", $file['lastmod']),"<button onclick=\"deleteFile('".basename($file['name'])."')\">删除文件</button></p>";
        echo "</div>";
    }
    
?>
    
<script>

function deleteFile(path) {

	if (window.confirm('你确定要删除 [' + path + '] 吗？')) {
	window.location.replace("index.php?&del=" + path);
		return true;
	}
}

function checkAli(path) {
	window.open("isFileExist.php?&file=" + path);
}

function uploadAli(path) {

	if (window.confirm('你确定要上传 [' + path + '] 吗？')) {
		window.open("upload.php?&file=" + path);
		return true;
	}
}

</script>

</body>
</html>
