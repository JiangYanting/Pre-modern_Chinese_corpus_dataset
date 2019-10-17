<?php
	header("Content-Type:text/html;charset=utf-8");
	// 1.连接服务器：mysql_connect($host,$user,$pw)
	$all_dynasty = 0; //是否为全朝代
	$all_type = 0; //是否为全文体
	
	$d0 = "null0";
	$d1 = "null1";
	$d2 = "null2";
	$d3 = "null3";
	$d4 = "null4";
	$d5 = "null5";   // 6个朝代
	
	$t0 = "null0";   //10个文体类别
	$t1 = "null1";
	$t2 = "null2";
	$t3 = "null3";
	$t4 = "null4";
	$t5 = "null5";
	$t6 = "null6";
	$t7 = "null7";
	$t8 = "null8";
	$t9 = "null9";

	
	if (isset($_POST["dynasty"]))
	{
		// print(gettype($_POST["dynasty"]));  // $_POST["dynasty"]的变量类型是array数组
		// print_r($_POST["dynasty"]);
		if(in_array("全部",$_POST["dynasty"]))  //判断$_POST["dynasty"]这个数组是否有“quanbu”这个元素
		{
			$all_dynasty = 1;  //全朝代设置为1
			echo "检索范围：全朝代。\n";
		}
		else  //没有选择“全部”项。
		{
			for($i=0 ; $i < count($_POST["dynasty"]) ; $i++)
			{
				$c = "d" ."". strval($i);  //拼接起d和后面的数字,如d1
				//echo $c." ";  //$c输出了d0，d1等
				$$c = $_POST["dynasty"][$i];  //给变量$d0,$d1等赋予新值
				//echo $_POST["dynasty"][$i]." ";  //输出了勾选的朝代,表单的value可以是中文字符。
			}
			//echo "朝代".$d0;   //勾选了“宋”时，$d0就输出了“宋”
			//echo "\n";
			//echo "朝代".$d1;     //勾选了“元”时，$d1就输出了“元”
			echo "\n"; 
		}
  }
  else
  {
  	echo "未选择朝代！\n";
  }
  
  if (isset($_POST["wenti"]))
  {
  	if(in_array("suoyou",$_POST["wenti"]))
  	{
  		$all_type = 1;
  		echo "检索范围：全文体。\n";
  	}
  	else  //没有选择“所有文体”项
  	{
  		for($i=0 ; $i < count($_POST["wenti"]) ; $i++)
  		{
  			$s = "t"."".strval($i);  //拼接成为t0,t1等
  			$$s = $_POST["wenti"][$i];
  		}
  		//echo "文体".$t0." ";  //$t0、$t1等成功输出复选框勾选的文体
  		//echo "文体".$t1;
  	}
  }
  else
  {
  	echo "未选择文体！\n";
  }
  
  if(isset($_POST["jiansuo"]))  //如果检索框中输入了内容
  {
  	//print(gettype($_POST["jiansuo"])); //检索内容的变量$_POST["jiansuo"]类型是string
  	print("      您检索的内容是：  ");
  	print($_POST["jiansuo"]);
  	echo '<br/><br/>';
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
	$ok = mysqli_select_db($conn,"corpus");
	if(mysqli_errno($conn))  //没出错，则返回0.
	{
		die("<br/>".mysqli_error($conn)."<br/>"); //die方法：输出一条信息，并退出当前脚本。
	}
	else
	{
		echo "      链接近代汉语corpus成功！<br/><br/>";
	}
	
   //3.sql语句：查询书籍信息
  
  $sql3 = "select * from pre_modern where content like  '%{$_POST["jiansuo"]}%' and dynasty in ('{$d0}','{$d1}','{$d2}','{$d3}','{$d4}','{$d5}') and type in ('{$t0}','{$t1}','{$t2}','{$t3}','{$t4}','{$t5}','{$t6}','{$t7}','{$t8}','{$t9}')";
  $result = mysqli_query($conn,$sql3) or die("<br/>ERROR：".mysqli_error($conn));
  echo "      检索结果的数量为：";
  echo mysqli_num_rows($result);
  echo "<br/>";
  //尝试先用sql语句查询获取数据，用php变量保存，再写入文件。
  $file = "C:/result.txt";  //输出的路径 
  $file_string = strval($file) ;
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

<style>
body{
     background-image: url("anhua1.jpg");
     background-size: cover;
     background-position: center center;
     background-repeat: no-repeat;
     background-attachment: fixed;
}
</style> 
	
	
	
<a href="003download_test_library.php"> 点我下载查询结果 </a>
<p>
<table width="50%" border="1" cellpadding="0" cellspacing="1"> 
  <tr align="center">
  	<td><strong>ID</strong></td>
  	<td><strong>content</strong></td>
		<td><strong>dynasty</strong></td>
		<td><strong>type</strong></td>
		<td><strong>author</strong></td>
		<td><strong>title</strong></td>
	</tr>

<?php
  while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
  {
?>
  <tr align="center">
  	<td><?php echo $row["ID"];?></td>
  	<td><?php echo $row["content"];?></td>
  	<td><?php echo $row["dynasty"];?></td>
  	<td><?php echo $row["type"];?></td>
  	<td><?php echo $row["author"];?></td>
  	<td><?php echo $row["title"];?></td>
  </tr>
<?php  	
  	$string = $row["ID"] . "\t" . $row["content"] . "\t" . $row["dynasty"] . "\t" . $row["type"] . "\t" . $row["author"] . "\t" . $row["title"]. "\n";
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

