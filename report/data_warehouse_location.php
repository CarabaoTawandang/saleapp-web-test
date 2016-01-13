  <?
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_name =$_POST['txt_name'];
$txt_id=$_POST['txt_id'];
$txt_side=$_POST['txt_side'];
$txt_tax=$_POST['txt_tax'];


$sql="select * from st_warehouse_location where locationno like '%%'";

if($txt_name){$sql.=" and locationname like '%$txt_name%' "; }
if($txt_id){$sql.=" and locationno like '%$txt_id%' "; }
if($txt_side){$sql.=" and Branch like '%$txt_side%' "; }
if($txt_tax){$sql.=" and Tax_ID like '%$txt_tax%' "; }
else if($txt_all){ }
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qry=sqlsrv_query($con,$sql,$params,$options);
$r=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" action="?page=save_warehouse_location" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1350px">
<tr><td colspan="2">
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="1350px">
	<tr bgcolor="#F2FAEB" ><td align="center" rowspan="2">รหัสคลัง</td>
	<td align="center" rowspan="2">ชื่อคลัง</td>
	<td align="center" rowspan="2">สาขาที่</td>
	<td align="center" rowspan="2">เลขกำกับภาษี</td>
	<td align="center" colspan="5">ที่อยู่</td>
	<td align="center" rowspan="2">รายละเอียดคลัง</td>
	<td align="center" rowspan="2">รหัสคลังสินค้าAX</td>
	<td align="center" rowspan="2">ตัวย่อบัญชี</td>
	<TD align="center" rowspan="2">แก้ไข</TD>
	<TD align="center" rowspan="2">ลบ</TD></tr>
	<tr bgcolor="#F2FAEB"><td align="center">เลขที่</td>
	<td align="center">หมู่</td>
	<td align="center">ตำบล</td>
	<td align="center">อำเภอ</td>
	<TD align="center">จังหวัด</TD>
	</tr>
	<? while($re=sqlsrv_fetch_array($qry)){ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	<tr class="mousechange"  class="mousechange"  bgcolor="<?=$col;?>" height="30" >
	<td align="center"><?=$re['locationno'];?></td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['locationname'];?></td>
	<td align="left">&nbsp;<?=$re['Branch'];?></td>
	<td align="left">&nbsp;<?=$re['Tax_ID'];?></td>
	<td align="left">&nbsp;<?=$re['AddressNum'];?></td>

	<td align="left">&nbsp;<?=$re['AddressMu'];?></td>
	<?				$province="SELECT * FROM dc_province where PROVINCE_CODE ='$re[PROVINCE_CODE]' ";
					$province=sqlsrv_query($con,$province,$params,$options);
					$province=sqlsrv_fetch_array($province);
					
					$amphur="SELECT * FROM dc_amphur where AMPHUR_CODE='$re[AMPHUR_CODE]' ";
					$amphur=sqlsrv_query($con,$amphur,$params,$options);
					$amphur=sqlsrv_fetch_array($amphur);
					
					$district="SELECT * FROM dc_district where DISTRICT_CODE='$re[DISTRICT_CODE]' ";
					$district=sqlsrv_query($con,$district,$params,$options);
					$district=sqlsrv_fetch_array($district);?>
					
	<td>&nbsp;<?echo $district['DISTRICT_NAME']?></td>
	<td>&nbsp;<?echo $amphur['AMPHUR_NAME']?></td>
	<td>&nbsp;<?echo $province['PROVINCE_NAME']?></td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['Remark'];?></td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['locationAx'];?></td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['Acc_Doc'];?></td>	
	<TD align="center"><img src="./images/edit.gif" style="cursor:pointer" alt="Complete" onclick="window.location='?page=edit_warehouse_location&id=<?=$re['locationno'];?>';" /></TD>
	<TD align="center"><!--<a href="?page=save_warehouse_location&do=del&id=<?=$re['locationno'];?>" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่?');" ><img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>--></TD>
	</tr>
	<? $r++;} ?>
	</table>
</td></tr>
</table>
</form>
</div><!--/-box-->
</div><!--/-container_box-->
</body>
</html>
