<?
//------------------------------------------------------โดย PONG 14/10/2015-------------------
session_start();
set_time_limit(0);
include("../../includes/config.php");

$txt_id =$_POST['txt_id'];
$count =$_POST['count'];
$txt_all=$_POST['txt_all'];

if($txt_all){
$sql="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY CreateDate) AS
rownum,imei,manufacturer,model_num,model_name,serail_number,ram
,memory,memory_available,sim_id,po_num,supplier,warranty,printer_serail_num
,assign_user,user_type,receive_date,CreateDate,Status,Remark
FROM st_device_tablet_detail) AS Table1  ";
}else {
$sql="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY CreateDate) AS
rownum,imei,manufacturer,model_num,model_name,serail_number,ram
,memory,memory_available,sim_id,po_num,supplier,warranty,printer_serail_num
,assign_user,user_type,receive_date,CreateDate,Status,Remark
FROM st_device_tablet_detail where  imei like '%$txt_id%') AS Table1  ";
}
$result=sqlsrv_query($con,$sql,$params,$options);
$num_rows=sqlsrv_num_rows($result);
?>


<html>
<body>
<?if($num_rows==0){echo"<p align='center'><b>----------ไม่พบข้อมูล------------</b></p>";}else{	?>
<table cellpadding="0" cellspacing="0"  border="0" align="left"  class="box" width="1400px">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0" BORDERCOLOR="#FF9933" border="1" align="left"  width="1400px">
	<tr bgcolor="#FFCC99">
	<td align="center"><font size="2">ลำดับ</font></td>
	<td align="center"><font size="2">แก้ไข</font></td>
	<td align="center"><font size="2">IMEI</font></td>
	<td align="center"><font size="2">Serial No.</font></td>
	
	<td align="center"><font size="2">ยี่ห้อ</font></td>
	<td align="center"><font size="2">Model</font></td>
	<td align="center"><font size="2">RAM</font></td>
	<td align="center"><font size="2">ROM</font></td>
	<td align="center"><font size="2">Tatol ROM</font></td>
	<td align="center"><font size="2">รับประกัน</font></td>
	<td align="center"><font size="2">วันที่รับของ</font></td>
	<td align="center"><font size="2">ดูแลโดย</font></td>
	<td align="center"><font size="2">DC</font></td>
	<td align="center"><font size="2">Last User</font></td>
	<td align="center"><font size="2">Last Login</font></td>
	<td align="center"><font size="2">สถานะ</font></td>
	<td align="center" width="200px"><font size="2">หมายเหตุ</font></td>



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



$per_page = $count;

$P=$per_page;
if(!$page_)

	if($_POST['do']=="NOW")
	{
	$page__=$_POST['page__'];
	$page_=$page__;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do']=="NEXT")
	{
	$page__=$_POST['page__'];
	$page_=$page__+1;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do']=="BEFORE")
	{
	$page__=$_POST['page__'];
	$page_=$page__-1;
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
	
if($txt_all){	
$sql_="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY CreateDate) AS
rownum,imei,manufacturer,model_num,serail_number,ram
,memory,memory_available,sim_id,po_num,supplier,warranty,printer_serail_num
,assign_user,user_type
,cast(receive_date as date) as receive_date_
,CreateDate,Status,Remark
FROM st_device_tablet_detail ) AS Table1 
WHERE rownum >= $page_start AND rownum <= $P ";
}else {
$sql_="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY CreateDate) AS
rownum,imei,manufacturer,model_num,serail_number,ram
,memory,memory_available,sim_id,po_num,supplier,warranty,printer_serail_num
,assign_user,user_type
,cast(receive_date as date) as receive_date_
,CreateDate,Status,Remark
FROM st_device_tablet_detail where imei like '%$txt_id%' ) AS Table1 
WHERE rownum >= $page_start AND rownum <= $P ";
}
$result_=sqlsrv_query($con,$sql_,$params,$options);


while ($re = sqlsrv_fetch_array($result_)){?>
		<?
		$last_login="SELECT TOP 1 st_device_log_login.*,Status FROM st_device_log_login 
				left join st_device_tablet_detail on st_device_tablet_detail.imei =st_device_log_login.imei
				where st_device_log_login.imei = '$re[imei]'
				ORDER BY CreateDate desc  ";
		$last_login=sqlsrv_query($con,$last_login);
		$last_login=sqlsrv_fetch_array($last_login);
		
		$Status=$last_login['Status'];
		
		$last_user="select * from st_user where User_id ='$last_login[user_id]' ";
		$last_user=sqlsrv_query($con,$last_user);
		$last_user=sqlsrv_fetch_array($last_user);
		
		
		$DAY=date("d/m/Y", strtotime($last_login['CreateDate']));
		$start_date=$DAY;
		$today_date=date("d/m/Y ");

		$start_explode = explode("/", $start_date); 
		$start_day = $start_explode[0]; 
		$start_month = $start_explode[1]; 
		$start_year = $start_explode[2]; 
		
		$today_explode = explode("/", $today_date); 
		$today_day = $today_explode[0]; 
		$today_month = $today_explode[1]; 
		$today_year = $today_explode[2]; 
		
		$start = gregoriantojd($start_month,$start_day,$start_year); 
		$today = gregoriantojd($today_month,$today_day,$today_year);
		
		$DAY_COUNT=$today-$start;
		
		?>
	<tr <?if($DAY_COUNT>7&&($Status=='In used'||$Status=='')){?>bgcolor="#f07575"<?};?> height="30">
	<td align="left"><font size="2">&nbsp;<?=$re['rownum'];?></font></td>
	<td align="center">
		<a href="?page=edit_Tablet&id=<?=$re['imei'];?>"  >
		<img src=".././images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	<td align="left"><font size="2">&nbsp;<?=$re['imei']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['serail_number']; ?></font></td>
	
	<td align="left"><font size="2">&nbsp;<?=$re['manufacturer']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['model_num']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['ram']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['memory']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['memory_available']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['warranty']; ?></font></td>


	<td align="left"><font size="2">&nbsp;<?=date_format($re['receive_date_'],'d/m/Y');?></font></td>
	
	<?
		
		$ST=" select *from st_user where talet_no_imei ='$re[imei]'  ";
		$ST=sqlsrv_query($con,$ST,$params,$options);
		$ST=sqlsrv_fetch_array($ST);
		$DC_="select * from st_user_group_dc where dc_groupid ='$ST[dc_groupid]'  ";
		$DC_=sqlsrv_query($con,$DC_,$params,$options);
		$DC_=sqlsrv_fetch_array($DC_);		
		$_USER="select * from st_user where User_id ='$ST[User_id]'  ";
		$_USER=sqlsrv_query($con,$_USER,$params,$options);
		$_USER=sqlsrv_fetch_array($_USER);?>
	
	<td align="left"><font size="2">&nbsp;<?=$_USER['name'];?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$DC_['dc_groupname'];?></font></td>
	
	<?
	$L_name=$last_user['name']; 
	$N_name=$_USER['name'];
	?>

	<td align="left" <?if($L_name!=$N_name){?>bgcolor="#7575f0"<?};?>><font size="2">&nbsp;<?=$last_user['name'];?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$last_login['CreateDate'];?></font></td>
	
	<td align="left"><font size="2">&nbsp;<?=$re['Status'];?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Remark'];?></font></td>

		

	


	

	
	
	


	
	<? 
	}	?>
	</table><tr><td>
จำนวนรายการทั้งหมด:<b><?echo $num_rows;?></b>&nbsp;&nbsp;หน้าทั้งหมด:<b><?echo $num_pages?></b>
<div id="container">
	<div class="pagination">
<?
if($prev_page)
	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do=BEFORE&page__=$page_&S=$txt_id&C=$count&A=$txt_all#tabs-1\">กลับไป&nbsp;</a>";
	
for($i=1;$i<=$num_pages;$i++)
{
if($i!=$page_)
	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do=NOW&page__=$i&S=$txt_id&C=$count&A=$txt_all#tabs-1\">$i</a>";
	
	else
	echo"<b class='page active'>$i</b>";
	}
if($page_!=$num_pages)

	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do=NEXT&page__=$page_&S=$txt_id&C=$count&A=$txt_all#tabs-1\">&nbsp;หน้าต่อไป</a>";
?></div></div>

<?}?></tr></td>

		</table>
</td></tr>
</table>
</body>
</html>

