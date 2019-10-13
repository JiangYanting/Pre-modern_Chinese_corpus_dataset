<?php
	header("Content-Type:text/html;charset=utf-8");
	// 1.连接服务器：mysql_connect($host,$user,$pw)
	if (isset($_POST["dynasty"]))
	{
		// print_r($_POST["dynasty"]);
		foreach ($_POST["dynasty"] as $v)
		{
			echo $v.' ';
		}
  }
  
	$host = "localhost";
	$user = "root";
	$pw = "0831";
	$conn = mysqli_connect($host,$user,$pw);
	// -h主机 -P端口 -u用户名 -p密码(端口默认为3306)
  if ( mysqli_connect_errno ()) 
  {
    printf ( "连接失败 %s\n" ,  mysqli_connect_error ());
    exit();
  }
	
	// 2.选择数据库
	$ok = mysqli_select_db($conn,"mylibrary");
	if(mysqli_errno($conn))  //没出错，则返回0.
	{
		die("<br/>".mysqli_error($conn)."<br/>"); //die方法：输出一条信息，并退出当前脚本。
	}
	else
	{
		echo "选择数据库成功！<br/>";
		echo "指定日期范围的书目文件已成功输出！<br/>";
	}
	
   //3.sql语句：查询书籍信息
  //$sql1 = CONCAT("select * from intership_demo where time between '{$date1}' and '{$date3}' INTO OUTFILE ","C:/查询范围/",DATE_FORMAT(NOW(),'%Y%m%d%H%i%s'),".txt")
  //$sql2 = "select * from intership_demo where time between '{$date1}' and '{$date3}' INTO OUTFILE 'C:/output.txt'";  //查询语句中的日期必须要加单引号才行。
  $sql3 = "select * from intership_demo where time between '{$date1}' and '{$date3}'";
  $result = mysqli_query($conn,$sql3) or die("<br/>ERROR：".mysqli_error($conn));
  
  //尝试先用sql语句查询获取数据，用php变量保存，再写入文件。
  $timenow = date("Ymd H-i-s",strtotime("now"));
  //echo "timenow的数据类型:",gettype($timenow); 
  $file = "C:/ now$timenow"."range".$date1." to".$date2."txt";  //输出的路径 
  $file_string = (string)$file ;
  //echo $file_string;
  session_start();
  $_SESSION [ 'filepath' ] =  $file_string ;
?>



<html>
<head>
<title>书籍查询结果</title>
</head>
<center>
<body>
<a href="003download_test_library.php"> 点我下载查询结果 </a>
<p>
<table width="50%" border="1" cellpadding="0" cellspacing="1"> 
  <tr align="center">
  	<td><strong>code1</strong></td>
  	<td><strong>code2</strong></td>
		<td><strong>name</strong></td>
		<td><strong>clf</strong></td>
		<td><strong>time</strong></td>
	</tr>

<?php
  while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
  {
?>
  <tr align="center">
  	<td><?php echo $row["code1"];?></td>
  	<td><?php echo $row["code2"];?></td>
  	<td><?php echo $row["name"];?></td>
  	<td><?php echo $row["clf"];?></td>
  	<td><?php echo $row["time"];?></td>
  </tr>
<?php  	
  	$string = $row["code1"] . "\t" . $row["code2"] . "\t" . $row["name"] . "\t" . $row["clf"] . "\t" . $row["time"] . "\n";
  	file_put_contents($file,$string,FILE_APPEND); 
  }
?>

<?php
  mysqli_close($conn);
?>
</table>
</body>
</center>
</html>

