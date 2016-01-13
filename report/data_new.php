<?
//------------------------------------------------------แก้ไข โดย PONG 13/07/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$day_first =$_POST['day_first'];
$day_second =$_POST['day_second'];


 $sql="select  st_message_new.* 
,cast(DateFrom as date) as dateFrom2
,cast(DateTo as date) as DateTo2
from st_message_new ";

if($day_first){$sql.=" where DateFrom between '$day_first' and '$day_second' or DateTo between '$day_first' and '$day_second' "; }
else if($txt_all){ }

$sql.=" order by Code asc";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qry=sqlsrv_query($con,$sql,$params,$options);
$r=0;


	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

</head>
<body>
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="90%">
<tr><td colspan="2">
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  >
	<tr>
	<td align="center" width="200px">ชื่อเรื่อง</td>
	<td align="center" width="200px">รายละเอียด</td>
	<td align="center" width="200px">ตำแหน่ง</td>
	<td align="center" width="100px">วันที่เริ่มต้น</td>
	<td align="center" width="100px">วันที่สิ้นสุด</td>
	<TD align="center" width="30px">แก้ไข</TD>
	<td align="center" width="30px">ลบ</td>

	</tr>
	
	<? while($re=sqlsrv_fetch_array($qry))
	
	{ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	
	<tr class="mousechange" bgcolor="<?=$col;?>" height="30" >
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=$re['Subject'];?></td>
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=$re['Remark'];?></td>
	
	<td align="left "><? $code =$re['Code'];
	$sql2="select st_message_new_detail.* 
,st_user_rolemaster_detail.RoleName_Linename
from st_message_new_detail left join st_user_rolemaster_detail
on st_message_new_detail.RoleID_Lineid = st_user_rolemaster_detail.RoleID_Lineid
where st_message_new_detail.Code='$code'";
$qry2=sqlsrv_query($con,$sql2,$params,$options);	
while($re2=sqlsrv_fetch_array($qry2))
{
echo "<br>&nbsp;&nbsp;&nbsp";
echo $re2['RoleName_Linename'];

}
	?>
	
	</td>
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=date_format($re['dateFrom2'],'d/m/Y');?> </td>
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=date_format($re['DateTo2'],'d/m/Y');?> </td>
	
	
	<td align="center">
		<a href="?page=edit_new&id=<?=$code;?>"  >
		<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	
	<td align="center">
		<!--<a href="?page=save_new&do=del&id=<?=$code;?>" onclick="return confirm('คุณต้องการลบข้อมูลข่าวนี้ใช่หรือไม่?');" >
		<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>-->
	</td>
	</tr>
	
<? 
  $r++;}//while
  
  ?>

	</table>
</td></tr>
</table>
</body>
</html>
