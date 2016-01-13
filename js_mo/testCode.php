<?
session_start();
		set_time_limit(0);
		include("includes/config.php");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>TEST CODE Check โอนเงิน row เบิ้ล
<?
		$a=1;
$sqlSelect1="select user_id,Date_pay ,count(Date_pay) as c, pay
from st_dailysales
group by user_id,Date_pay , pay
having count(Date_pay)>1
order by count(Date_pay) desc
";
$qrySelect1 =sqlsrv_query($con,$sqlSelect1);
while($Select1=sqlsrv_fetch_array($qrySelect1)){
	echo '<br>'.$a.' '.$Select1['user_id'].'  = '.$Select1['Date_pay'].'  = '.$Select1['pay'].'  = '.$Select1['c'];
	
	echo ' = '.$sqlDel="set rowcount 1
	delete from st_dailysales
	where user_id='$Select1[user_id]'
	and Date_pay ='$Select1[Date_pay]'
	and pay ='$Select1[pay]'	";
	//$qtyDel =sqlsrv_query($con,$sqlDel);if($qtyDel){echo '  ==  Del แล้ว';};
	$a++;}//วน PRODUCT
?>
























<?
//echo substr("KK5812-580011-0056",1,-5)."<br>";
?>
</body>
</html>