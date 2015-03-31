<?php
header("Content-type: text/html;charset=utf-8");

$dsn = 'mysql:host=localhost;dbname=web';
$username = 'root';
$passwd = '';
$dbh = new PDO($dsn,$username,$passwd);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$dbh->exec('set names utf8');


$perNumber=5; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值

//获取信息求总页数和总记录数
$sql = "SELECT * FROM page";
$res = $dbh-> prepare($sql);
$res->execute();
$totalNumber = $res->fetchALL(PDO::FETCH_ASSOC);
$totalPage=ceil($totalNumber/$perNumber);

//判断是否存在数据
if (!isset($page)) {
	$page=1;
}

//开始分页
$startCount=($page-1)*$perNumber;
$sql = "SELECT * FROM page limit $startCount,$perNumber";
$res = $dbh-> prepare($sql);
$res->execute();
$result = $res->fetchALL(PDO::FETCH_ASSOC);

//输出记录
foreach ($result as $key => $value) {
	print_r($result);
}

//分页判断与跳转
for ($i=1;$i<=$totalPage;$i++) { 
	?>
	<a href="fenye.php?page=<?php echo $i;?>"><?php echo $i ;?></a>
	<?php
}
?>
<br></br>
<?php
if ($page != 1) { 
	?>
	<a href="fenye.php?page=<?php echo "1";?>">第一页 </a> 
	<a href="fenye.php?page=<?php echo $page - 1;?>">上一页 </a> 
	<?php
}
if ($page < $totalPage) { //如果page小于总页数,显示下一页链接
	?>
	<a href="fenye.php?page=<?php echo $page + 1;?>">下一页</a>
	<a href="fenye.php?page=<?php echo $totalPage;?>">最后一页</a>
        <?php
} ?>
