<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>查询文件</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>

<div class="card">
<?PHP

require_once 'php-sdk-7.0.5/autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

	$file = $_GET["file"];
	
	if ($file) {

		$accessKey = '-';
		$secretKey = '-';

		$auth = new Auth($accessKey, $secretKey);
		$bucketMgr = new BucketManager($auth);

		$bucket = '-';
		$prefix = $file;
		$marker = '';
		$limit = 10;

		list($iterms, $marker, $err) = $bucketMgr->listFiles($bucket, $prefix, $marker, $limit);
		if ($err !== null) {
			echo "<p class=\"text\">查询失败！";
			var_dump($err);
			echo "</p>";
		} else {
			if ($iterms.count == 1) {
				echo "<p class=\"text\">下载链接 ". "itms-services://?action=download-manifest&url=https://-.qbox.me/" . $file . " 已存在！</p>";
			}
			else {
				echo "<p class=\"text\">下载链接 ". "itms-services://?action=download-manifest&url=https://-.qbox.me/" . $file . " 不存在！</p>";
			}
		}
	}
	else {
		echo "<p class=\"text\">参数错误！</p>";
	}
		
?>

</div>
</body>
</html>
