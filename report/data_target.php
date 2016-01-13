<?
//------------------------------------------------------แก้ไข โดย PONG 21/09/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_name =$_POST['txt_name'];


 $sql="select  *,cast(tar_start as date) as start
,cast(tar_end as date) as end_
from st_View_target ";

if($txt_name){$sql.=" where tar_name like '%$txt_name%' "; }
else if($txt_all){ }

$sql.=" order by ID asc";
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
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr>
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="1124px" >
	<tr  height="35">
	<td align="center">DC</td>
	<td align="center">สินค้า</td>
	<td align="center">ประเภท</td>
	<td align="center">เป้าหมาย</td>
	<td align="center">วันที่เริ่มต้น-สิ้นสุด</td>
	<td align="center">จำนวนเป้า</td>
	<td align="center">ยอด</td>
	<td align="center">หน่วย</td>
	<td align="center">ผลตอบแทน</td>
	
	<TD align="center">แก้ไข</TD>
	<td align="center">ลบ</td>

	</tr>
	
	<? while($re=sqlsrv_fetch_array($qry))
	
	{ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	
	<tr class="mousechange" bgcolor="<?=$col;?>" height="30" >	
	<?
	$open="select* from st_user_group_dc where dc_groupid='$re[dc_groupid]' ";
	$open=sqlsrv_query($con,$open,$params,$options);	
	$open=sqlsrv_fetch_array($open);
	
	?>
	
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$open['dc_groupname'];?> </td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['PRODUCTNAME'];?> </td>
		<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['tar_typeName'];?></td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['tar_name'];?> </td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=date_format($re['start'],'d/m/Y');?>-<?=date_format($re['end_'],'d/m/Y');?></td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['tar_qty'];?> </td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['SumOrder'];?> </td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['SumOrder_unit'];?> </td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['tar_amount'];?></td>

	
	<td align="center">
		<a href="?page=edit_target&id=<?=$re['ID'];?>"  >
		<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	
	<td align="center">
		<!--<a href="?page=save_target&do=del&id=<?=$re['ID'];?>" onclick="return confirm('คุณต้องการลบเป้ายอดขายนี้ใช่หรือไม่?');" >
		<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>-->
	</td>
	</tr>
	
<? 
  $r++;}//while
  
  ?>

	</table>
</tr>
</table>
</body>
</html>
