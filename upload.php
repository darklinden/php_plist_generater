<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>上传文件</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>

<div class="card">
<?PHP

require_once 'php-sdk-7.0.5/autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

	$file = $_GET["file"];
	
	if ($file) {
	
		$accessKey = '-';
		$secretKey = '-';

		$auth = new Auth($accessKey, $secretKey);

		$bucket = '-';
		$prefix = $file;
		$marker = '';
		$limit = 10;
		
		$token = $auth->uploadToken($bucket);
		$uploadMgr = new UploadManager();
		
		// 上传文件到七牛
		$filePath = './plist/'.$file;
		$key = $file;
		
		list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
		
		if ($err !== null){
			echo "<p class=\"text\">生成下载链接 \"itms-services://?action=download-manifest&url=https://-.qbox.me/" . $file . "\" 失败！</p>";			
			echo "<p class=\"text\">".var_dump($err)."<p>";
		}
		else {
			echo "<p class=\"text\">生成下载链接 \"itms-services://?action=download-manifest&url=https://-.qbox.me/" . $file . "\" 成功！</p>";
		}	
	}
	else {
		echo "<p class=\"text\">参数错误！</p>";
	}
		
?>
</div>
</body>
</html>
