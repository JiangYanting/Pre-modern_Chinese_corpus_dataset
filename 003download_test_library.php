<?php
  header("Content-Type:text/plain;charset=utf-8");  //指定下载的文件类型
  //header('Content-type: application/txtf');
	session_start();
	$file_path = $_SESSION [ 'filepath' ];  //能够输出文件路径结果了
	 
	$basename = pathinfo($file_path);

	//设置head头信息，告知该下载文件，并指定客户端，来临时存储名称
	header("Content-Disposition:attachment;filename=".$basename['basename']);
	//指定文件的大小
	header("Content-Length:".filesize($file_path));

	//将内容输出，以下载
	readfile($file_path);
?>


