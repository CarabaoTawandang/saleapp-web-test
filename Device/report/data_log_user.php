<?
//------------------------------------------------------โดย PONG 14/10/2015-------------------
session_start();
set_time_limit(0);
include("../../includes/config.php");

$txt_imei3 =$_POST['txt_imei3'];
$date_from =$_POST['date_from'];
$date_to =$_POST['date_to'];
$User =$_POST['User'];
$count3 =$_POST['count3'];
$per_page =$count3;

$sql="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY st_device_log_login.CreateDate desc) AS
rownum,st_device_log_login.imei,sim_id,phone_sim,st_device_log_login.User_id,name,dc_groupid,st_device_log_login.CreateDate
FROM st_device_log_login 
left join st_user on st_user.talet_no_imei=st_device_log_login.imei
left join st_device_tablet_detail on st_user.talet_no_imei=st_device_tablet_detail.imei
where cast(st_device_log_login.CreateDate as date)BETWEEN '$date_from' AND'$date_to'
and st_device_log_login.imei like '%$txt_imei3%'
and st_device_log_login.User_id like '%$User%')AS Table1  "; 
$result=sqlsrv_query($con,$sql,$params,$options);
$num_rows=sqlsrv_num_rows($result);
?>
<html>
<body>
<?if($num_rows==0){echo"<p align='center'><b>----------ไม่พบข้อมูล------------</b></p>";}else{	?>
<table cellpadding="0" cellspacing="0"  border="0" align="left"  class="box" width="1050px">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0" BORDERCOLOR="#FF9933" border="1" align="left"  width="1050px">
	<tr bgcolor="#FFCC99">
	<td align="center"><font size="2">ลำดับ</font></td>
	<td align="center"><font size="2">IMEI</font></td>
	<td align="center"><font size="2">Serial Sim.</font></td>
	<td align="center"><font size="2">Sim No.</font></td>
	<td align="center"><font size="2">User</font></td>
	<td align="center"><font size="2">DC</font></td>
	<td align="center"><font size="2">วันที่และเวลา</font></td>
	</tr>
<style type="text/css">	
#container {
    width: 0 auto;
    margin: 0 auto;
    padding: 0px;

}

.pagination {
    background: #f2f2f2;
    padding: 20px;
    margin-bottom: 20px;
}

.page {
    display: inline-block;
    padding: 0px 9px;
    margin-right: 4px;
    border-radius: 3px;
    border: solid 1px #c0c0c0;
    background: #e9e9e9;
    box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
}

</style> 
<?

$P=$per_page;
if(!$page_)

	if($_POST['do3']=="NOW")
	{
	$page__3=$_POST['page__3'];
	$page_=$page__3;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do3']=="NEXT")
	{
	$page__3=$_POST['page__3'];
	$page_=$page__3+1;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do3']=="BEFORE")
	{
	$page__3=$_POST['page__3'];
	$page_=$page__3-1;
	$P=$per_page*$page_;

	}
	else{	
	$page_=1;
	
	}
	$prev_page=$page_-1;
	$next_page=$page_+1;

	$page_start=($per_page*$page_)-$per_page+1;
	
if($num_rows<=$per_page)
	$num_pages=1;
else if(($num_rows%$per_page)==0)
	$num_pages=($num_rows/$per_page);
else
	$num_pages=($num_rows/$per_page)+1;
	$num_pages=(int)$num_pages;

if(($page_>$num_pages)||($page_<0))
	echo"จำนวนรายการ เท่ากับ 0 รายการ";
	
	
$sql_="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY st_device_log_login.CreateDate desc) AS
rownum,st_device_log_login.imei,sim_id,phone_sim,st_device_log_login.User_id,name,dc_groupid,st_device_log_login.CreateDate
FROM st_device_log_login 
left join st_user on st_user.talet_no_imei=st_device_log_login.imei
left join st_device_tablet_detail on st_user.talet_no_imei=st_device_tablet_detail.imei
where cast(st_device_log_login.CreateDate as date)BETWEEN '$date_from' AND'$date_to'
and st_device_log_login.imei like '%$txt_imei3%'
and st_device_log_login.User_id like '%$User%')AS Table1
where rownum >= $page_start AND rownum <= $P ";

$result_=sqlsrv_query($con,$sql_,$params,$options);


while ($re = sqlsrv_fetch_array($result_))
	{{ $col="#FFFFCC";}

	$U="select * from st_user where User_id='$re[User_id]'  ";
	$U= sqlsrv_query($con,$U,$params,$options);
	$U=sqlsrv_fetch_array($U);
	
	$DC="select dc_groupname from st_user_group_dc where dc_groupid='$U[dc_groupid]'  ";
	$DC= sqlsrv_query($con,$DC,$params,$options);
	$DC=sqlsrv_fetch_array($DC);
	
	$phone="select * from st_Device_PhoneSim where sim_id='$re[sim_id]'  ";
	$phone= sqlsrv_query($con,$phone,$params,$options);
	$phone=sqlsrv_fetch_array($phone);
?>
	
	<tr bgcolor="<?=$col;?>" height="30">
	<td align="left"><font size="2">&nbsp;<?=$re['rownum']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['imei']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['sim_id'];?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$phone['phone_no']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$U['name']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$DC['dc_groupname']; ?></font></td>
	
	
	<td align="left"><font size="2"><?=$re['CreateDate'];?></font></td>
	


	
	<? 
	}	
	?>

		</table><tr><td>
จำนวนรายการทั้งหมด:<b><?echo $num_rows;?></b>&nbsp;&nbsp;หน้าทั้งหมด:<b><?echo $num_pages?></b>
<div id="container">
	<div class="pagination">
<?
if($prev_page)
	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do3=BEFORE&page__3=$page_&txt_imei3=$txt_imei3&date_from=$date_from&date_to=$date_to&C3=$count3&User=$User#tabs-4\">กลับไป&nbsp;</a>";
	
for($i=1;$i<=$num_pages;$i++)
{
if($i!=$page_)
	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do3=NOW&page__3=$i&txt_imei3=$txt_imei3&date_from=$date_from&date_to=$date_to&C3=$count3&User=$User#tabs-4\">$i</a>";
	
	else
	echo"<b class='page active'>$i</b>";
	}
if($page_!=$num_pages)

	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do3=NEXT&page__3=$page_&txt_imei3=$txt_imei3&date_from=$date_from&date_to=$date_to&C3=$count3&User=$User#tabs-4\">&nbsp;หน้าต่อไป</a>";
?></div></div>

<?}?></tr></td>


</td>
</tr>
</table>
</body>
</html>