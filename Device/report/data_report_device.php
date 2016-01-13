<?
//------------------------------------------------------โดย PONG 14/10/2015-------------------
session_start();
set_time_limit(0);
include("../../includes/config.php");

$IMEI_data =$_POST['IMEI_data'];
$MAC_data =$_POST['MAC_data'];
$User_data=$_POST['User_data'];
$all_=$_POST['all_'];


if($all_){
$sql="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY st_device_tablet_detail.CreateDate) AS
rownum,serail_number,model_num,ram
,memory,memory_available,sim_id
,imei
,Mac
,User_id
,(st_device_tablet_detail.manufacturer) as manufacturer1
,(st_device_tablet_detail.Receive_date) as Receive_date1
,(st_device_tablet_detail.supplier) as supplier1
,(st_device_tablet_detail.warranty) as warranty1 
,(st_device_tablet_detail.po_num) as po_num1  
,(st_device_tablet_detail.Status) as Status1  
,st_device_tablet_detail.CreateDate,name,dc_groupid
,st_Device_Mobile_Printer.Serial_No,st_Device_Mobile_Printer.Model
,(st_Device_Mobile_Printer.manufacturer) as manufacturer2
,(st_Device_Mobile_Printer.Receive_date) as Receive_date2 
,(st_Device_Mobile_Printer.Supplier) as supplier2
,(st_Device_Mobile_Printer.Warranty) as warranty2
,(st_Device_Mobile_Printer.PO_No) as po_num2
,(st_Device_Mobile_Printer.Status) as Status2
FROM st_device_tablet_detail 
left join st_user on st_device_tablet_detail.imei=st_user.talet_no_imei
left join st_Device_Mobile_Printer on st_Device_Mobile_Printer.Mac=st_user.Pinter_no 
) AS Table1  ";
}else {
$sql="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY st_device_tablet_detail.CreateDate) AS
rownum,serail_number,model_num,ram
,memory,memory_available,sim_id
,imei
,Mac
,User_id
,(st_device_tablet_detail.manufacturer) as manufacturer1
,(st_device_tablet_detail.Receive_date) as Receive_date1
,(st_device_tablet_detail.supplier) as supplier1
,(st_device_tablet_detail.warranty) as warranty1 
,(st_device_tablet_detail.po_num) as po_num1  
,(st_device_tablet_detail.Status) as Status1  
,st_device_tablet_detail.CreateDate,name,dc_groupid
,st_Device_Mobile_Printer.Serial_No,st_Device_Mobile_Printer.Model
,(st_Device_Mobile_Printer.manufacturer) as manufacturer2
,(st_Device_Mobile_Printer.Receive_date) as Receive_date2 
,(st_Device_Mobile_Printer.Supplier) as supplier2
,(st_Device_Mobile_Printer.Warranty) as warranty2
,(st_Device_Mobile_Printer.PO_No) as po_num2
,(st_Device_Mobile_Printer.Status) as Status2
FROM st_device_tablet_detail 
left join st_user on st_device_tablet_detail.imei=st_user.talet_no_imei
left join st_Device_Mobile_Printer on st_Device_Mobile_Printer.Mac=st_user.Pinter_no 
where ISNULL(imei , '') like '%$IMEI_data%' 
and ISNULL(st_Device_Mobile_Printer.Mac , '') like '%$MAC_data%' 
and ISNULL(User_id , '') like '%$User_data%') AS Table1 ";
}
$result=sqlsrv_query($con,$sql,$params,$options);
$num_rows=sqlsrv_num_rows($result);
?>


<html>
<body>
<?if($num_rows==0){echo"<p align='center'><b>----------ไม่พบข้อมูล------------</b></p>";}else{	?>
<table cellpadding="0" cellspacing="0"  border="0" align="left"  class="box" width="2500">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0" BORDERCOLOR="#ffffff" border="1" align="left"  width="2500">
	<tr >
	<td align="center" colspan="1" bgcolor="#ffb266"><font size="2"></font></td>
	<td align="center" colspan="14" bgcolor="#ffa266"><font size="2">Tablet</font></td>
	<td align="center" colspan="9" bgcolor="#ffe680"><font size="2">Mobile Printer</font></td>
	<td align="center" colspan="2" bgcolor="#cdcdb2"><font size="2">User</font></td>
	</tr>
	<tr >
	<td align="center" bgcolor="#ffbf80"><font size="2">ลำดับ</font></td>
	
	<td align="center" bgcolor="#ffc199"><font size="2" >IMEI</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">Serial No.</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">ยี่ห้อ</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">Model</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">RAM</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">ROM</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">Tatol ROM</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">Serial Sim.</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">Sim No.</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">วันที่รับของ</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">ผู้จัดจำหน่าย</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">รับประกัน</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">PO No.</font></td>
	<td align="center" bgcolor="#ffc199"><font size="2">สถานะ</font></td>
	
	<td align="center" bgcolor="#ffeb99"><font size="2">Mac</font></td>
	<td align="center" bgcolor="#ffeb99"><font size="2">Serial No.</font></td>
	<td align="center" bgcolor="#ffeb99"><font size="2">ยี่ห้อ</font></td>
	<td align="center" bgcolor="#ffeb99"><font size="2">Model</font></td>
	<td align="center" bgcolor="#ffeb99"><font size="2">วันที่รับของ</font></td>
	<td align="center" bgcolor="#ffeb99"><font size="2">ผู้จัดจำหน่าย</font></td>
	<td align="center" bgcolor="#ffeb99"><font size="2">รับประกัน</font></td>
	<td align="center" bgcolor="#ffeb99"><font size="2">PO No.</font></td>
	<td align="center" bgcolor="#ffeb99"><font size="2">สถานะ</font></td>
	
	<td align="center" bgcolor="#d7d7c1"><font size="2">ดูแลโดย</font></td>
	<td align="center" bgcolor="#d7d7c1"><font size="2">DC</font></td>
	


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
    box-shado5w: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shado5w: 0px 1px 0px rgba(255,255,255, 1);
}

</style> 
<?

$number_data=$_POST['number_data'];
$per_page =$number_data;

$P=$per_page;
if(!$page_)

	if($_POST['do5']=="NOW")
	{
	$page__5=$_POST['page__5'];
	$page_=$page__5;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do5']=="NEXT")
	{
	$page__5=$_POST['page__5'];
	$page_=$page__5+1;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do5']=="BEFORE")
	{
	$page__5=$_POST['page__5'];
	$page_=$page__5-1;
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
	
if($all_){	
$sql_="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY st_device_tablet_detail.CreateDate) AS
rownum,serail_number,model_num,ram
,memory,memory_available,sim_id
,imei
,Mac
,User_id
,(st_device_tablet_detail.manufacturer) as manufacturer1
,(st_device_tablet_detail.Receive_date) as Receive_date1
,(st_device_tablet_detail.supplier) as supplier1
,(st_device_tablet_detail.warranty) as warranty1 
,(st_device_tablet_detail.po_num) as po_num1  
,(st_device_tablet_detail.Status) as Status1  
,st_device_tablet_detail.CreateDate,name,dc_groupid
,st_Device_Mobile_Printer.Serial_No,st_Device_Mobile_Printer.Model
,(st_Device_Mobile_Printer.manufacturer) as manufacturer2
,(st_Device_Mobile_Printer.Receive_date) as Receive_date2 
,(st_Device_Mobile_Printer.Supplier) as supplier2
,(st_Device_Mobile_Printer.Warranty) as warranty2
,(st_Device_Mobile_Printer.PO_No) as po_num2
,(st_Device_Mobile_Printer.Status) as Status2
FROM st_device_tablet_detail 
left join st_user on st_device_tablet_detail.imei=st_user.talet_no_imei
left join st_Device_Mobile_Printer on st_Device_Mobile_Printer.Mac=st_user.Pinter_no 
) AS Table1 
WHERE rownum >= $page_start AND rownum <= $P ";
}else {
$sql_="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY st_device_tablet_detail.CreateDate) AS
rownum,serail_number,model_num,ram
,memory,memory_available,sim_id
,imei
,Mac
,User_id
,(st_device_tablet_detail.manufacturer) as manufacturer1
,(st_device_tablet_detail.Receive_date) as Receive_date1
,(st_device_tablet_detail.supplier) as supplier1
,(st_device_tablet_detail.warranty) as warranty1 
,(st_device_tablet_detail.po_num) as po_num1  
,(st_device_tablet_detail.Status) as Status1  
,st_device_tablet_detail.CreateDate,name,dc_groupid
,st_Device_Mobile_Printer.Serial_No,st_Device_Mobile_Printer.Model
,(st_Device_Mobile_Printer.manufacturer) as manufacturer2
,(st_Device_Mobile_Printer.Receive_date) as Receive_date2 
,(st_Device_Mobile_Printer.Supplier) as supplier2
,(st_Device_Mobile_Printer.Warranty) as warranty2
,(st_Device_Mobile_Printer.PO_No) as po_num2
,(st_Device_Mobile_Printer.Status) as Status2
FROM st_device_tablet_detail 
left join st_user on st_device_tablet_detail.imei=st_user.talet_no_imei
left join st_Device_Mobile_Printer on st_Device_Mobile_Printer.Mac=st_user.Pinter_no 
where ISNULL(imei , '') like '%$IMEI_data%' 
and ISNULL(st_Device_Mobile_Printer.Mac , '') like '%$MAC_data%' 
and ISNULL(User_id , '') like '%$User_data%') AS Table1 
where rownum >= $page_start AND rownum <= $P ";
}
$result_=sqlsrv_query($con,$sql_,$params,$options);


while ($re = sqlsrv_fetch_array($result_)){?>
	
	<tr bgcolor="<?=$col;?>" height="30">
	<td align="left" bgcolor="#FFCC99"><font size="2">&nbsp;<?=$re['rownum']; ?></font></td>
	
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['imei']; ?></font></td>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['serail_number']; ?></font></td>	
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['manufacturer1']; ?></font></td>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['model_num']; ?></font></td>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['ram']; ?></font></td>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['memory']; ?></font></td>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['memory_available']; ?></font></td>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['sim_id']; ?></font></td>
	<?$tel="SELECT * FROM st_Device_PhoneSim where sim_id = '$re[sim_id]'  ";
	$tel= sqlsrv_query($con,$tel,$params,$options);
	$tel=sqlsrv_fetch_array($tel);?>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$tel['phone_no'];?></font></td>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['Receive_date1'];?></font></td>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['supplier1'];?></font></td>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['warranty1'];?></font></td>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['po_num1'];?></font></td>
	<td align="left" bgcolor="#ffe0cc"><font size="2">&nbsp;<?=$re['Status1'];?></font></td>
	
	<td align="left" bgcolor="#fff5cc"><font size="2">&nbsp;<?=$re['Mac']; ?></font></td>
	<td align="left" bgcolor="#fff5cc"><font size="2">&nbsp;<?=$re['Serial_No']; ?></font></td>	
	<td align="left" bgcolor="#fff5cc"><font size="2">&nbsp;<?=$re['manufacturer2']; ?></font></td>
	<td align="left" bgcolor="#fff5cc"><font size="2">&nbsp;<?=$re['Model']; ?></font></td>
	<td align="left" bgcolor="#fff5cc"><font size="2">&nbsp;<?=$re['Receive_date2'];?></font></td>
	<td align="left" bgcolor="#fff5cc"><font size="2">&nbsp;<?=$re['supplier2'];?></font></td>
	<td align="left" bgcolor="#fff5cc"><font size="2">&nbsp;<?=$re['warranty2'];?></font></td>
	<td align="left" bgcolor="#fff5cc"><font size="2">&nbsp;<?=$re['po_num2'];?></font></td>
	<td align="left" bgcolor="#fff5cc"><font size="2">&nbsp;<?=$re['Status2'];?></font></td>

	
	
	<?
		
		
		$DC_="select * from st_user_group_dc where dc_groupid ='$re[dc_groupid]'  ";
		$DC_=sqlsrv_query($con,$DC_,$params,$options);
		$DC_=sqlsrv_fetch_array($DC_);		
		?>
	<td align="left" bgcolor="#ebebe0"><font size="2">&nbsp;<?=$re['name'];?></font></td>
	<td align="left" bgcolor="#ebebe0"><font size="2">&nbsp;<?=$DC_['dc_groupname'];?></font></td>

		

	


	


	
	


	
	<? 
	}	?>
	</table><tr><td>
จำนวนรายการทั้งหมด:<b><?echo $num_rows;?></b>&nbsp;&nbsp;หน้าทั้งหมด:<b><?echo $num_pages?></b>
<div id="container">
	<div class="pagination">
<?
if($prev_page)
	echo"<a class='page' href=\"$PHP_SELF?page=from_report_asset&do5=BEFORE&page__5=$page_&IMEI_data=$IMEI_data&MAC_data=$MAC_data&User_data=$User_data&number_d=$number_data&all_d=$all_\">กลับไป&nbsp;</a>";
	
for($i=1;$i<=$num_pages;$i++)
{
if($i!=$page_)
	echo"<a class='page' href=\"$PHP_SELF?page=from_report_asset&do5=NOW&page__5=$i&IMEI_data=$IMEI_data&MAC_data=$MAC_data&User_data=$User_data&number_d=$number_data&all_d=$all_\">$i</a>";
	
	else
	echo"<b class='page active'>$i</b>";
	}
if($page_!=$num_pages)

	echo"<a class='page' href=\"$PHP_SELF?page=from_report_asset&do5=NEXT&page__5=$page_&IMEI_data=$IMEI_data&MAC_data=$MAC_data&User_data=$User_data&number_d=$number_data&all_d=$all_\">&nbsp;หน้าต่อไป</a>";
?></div></div>

<?}?></tr></td>

		</table>
</td></tr>

</body>
</html>

