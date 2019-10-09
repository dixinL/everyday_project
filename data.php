<?php
/**
 * Created by PhpStorm.
 * User: Dixin
 * Date: 2018/11/29/029
 * Time: 18:25
 */
header('Content-Type: text/html;charset=utf-8');
$page = $_GET["page"];
$limit = $_GET["limit"];
$field = $_GET["field"];
$order = $_GET["order"];
$response0 = select($page,$limit,$field,$order);
$response1 = substr($response0,0,-3);
$response = $response1.']}';
echo $response;
function select($a,$b,$f,$o) {
    $c = $a * $b;
    $d = $c - 20;
    $host="localhost";
    $username="dixin";
    $password="dixin";
    $connection= mysql_connect ($host, $username, $password);
    if (!$connection) {
        die ("数据库连接失败");
    }
    $result=mysql_select_db ("dixin");
    if (! $result) {
        die ("数据读取失败");
    }
    mysql_query("set character set 'utf8'");//读库
    mysql_query("set names 'utf8'");//写库
//这个是你要插入的数组
    $exc="SELECT * FROM dixin.everyday_project;";
    $result= mysql_query($exc);
    if (!$result){
        echo '数据读取失败';
    }
    else{
        $i = 0;
        $msg = '{"code":0,"msg":""';
        while($row = mysql_fetch_row($result)){
            $i=$i+1;
        }
        $init = $i;
        $msg = $msg .',"count":'.$init.',';
    }
	$exec="SELECT * FROM dixin.everyday_project ORDER BY date DESC LIMIT ".$d.",".$c.";";
    $result= mysql_query($exec);
    if (!$result){
        $msg = '数据读取失败';
    }
    else{
        $msg = $msg .'"data":[';
        $i = 0;
        while($row = mysql_fetch_row($result)){
            $msg = $msg .'{"title":"'.$row[1].'","author":"Dixin","date":"'.$row[2].'","link":"'.$row[3].'"},';
            $i=$i+1;
        }
        $msg = $msg .']}';
    }
    return $msg;
//这里是插入数据库的语句
    mysql_close($connection);
}
?>
