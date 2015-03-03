<html>
	<head>
		<title>Server Variables</title>
	</head>
	<body>
	<?php
	echo "Server Details -> <br />";
	echo "Server Name : ".$_SERVER['SERVER_NAME']."<br />";
	echo "Server Address : ".$_SERVER['SERVER_ADDR']."<br />";
	echo "Server Port : ".$_SERVER['SERVER_PORT']."<br />";
	echo "Document Root : ".$_SERVER['DOCUMENT_ROOT']."<br />";
	echo "<br />";
	echo "Page Details - <br />";
	echo "PHP Self : ".$_SERVER['PHP_SELF']."<br />";
	echo "Script Filename : ".$_SERVER['SCRIPT_FILENAME']."<br />";
	echo "<br />";
	echo "Request Details - <br />";
	echo "Remote Address : ".$_SERVER['REMOTE_ADDR']."<br />";
	echo "Remote Port : ".$_SERVER['REMOTE_PORT']."<br />";
	echo "Request URI : ".$_SERVER['REQUEST_URI']."<br />";
	echo "Query String : ".$_SERVER['QUERY_STRING']."<br />";
	echo "Request Method : ".$_SERVER['REQUEST_METHOD']."<br />";
	echo "Request Time : ".$_SERVER['REQUEST_TIME']."<br />";
	echo "HTTP Referer : ".$_SERVER['HTTP_REFERER']."<br />";
	echo "HTTP User Agent : ".$_SERVER['HTTP_USER_AGENT']."<br />";
	?>
	</body>
</html>
