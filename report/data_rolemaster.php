<?
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_name =$_POST['txt_name'];
$txt_id =$_POST['txt_id'];
$sql="select st_user_rolemaster_head.* from  st_user_rolemaster_head ";
if($txt_id){$sql.="where RoleID like '$txt_id%'  "; }
else if($txt_name){$sql.="where RoleName like '%$txt_name%'  "; }
else if($txt_all){}
//$sql.="order by cast(st_user_rolemaster_head.RoleID as integer) asc ";
$sql.="order by RoleName asc ";
//echo $sql;
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
<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
	});//function	
</script>
</head>
<body>
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">
	<table width="100%" align="center" class="tables">
	<tr>
	<!--<th align="center">รหัสตำแหน่ง</th>-->
	<th align="center">ประเภทตำแหน่ง</th>
	
	<th align="center">ตำแหน่ง</th>
	
	<th align="center">ประเภทร้านที่เปิด</th>
	<th align="center">แก้ไข</th>
	<th align="center">ลบ</th>
	</tr>
	<? while($re=sqlsrv_fetch_array($qry))
	{ //if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	<tr class="mousechange"  bgcolor="<?=$col;?>" height="30" >
	<!--<td align="left ">&nbsp;&nbsp;&nbsp;<?=$RoleID= $re['RoleID'];?> </td>-->
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=$re['RoleName'];?> </td>
	<td align="left ">&nbsp;&nbsp;&nbsp;</td>
	<td align="left ">&nbsp;&nbsp;&nbsp;</td>

	<td align="center">
		<a href="?page=edit_rolemaster&id=<?=$RoleID;?>"  >
		<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	<td align="center">
		<!--<a href="?page=from_rolemaster&do=del&id=<?=$RoleID;?>" onclick="return confirm('คุณต้องการลบข้อมูลตำแหน่งหลักและตำแหน่งย่อยนี้ใช่หรือไม่?');" >
		<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>-->
	</td>
	</tr>
<?  $sql3="select st_user_rolemaster_detail.*,st_warehouse_location.locationname
			from st_user_rolemaster_detail  left join st_warehouse_location
			on st_user_rolemaster_detail.warehouse_locationNo = st_warehouse_location.locationno
			where RoleID='$RoleID' order by RoleName_Linename asc";
	$qry3=sqlsrv_query($con,$sql3,$params,$options); $t=1;
	while($re3=sqlsrv_fetch_array($qry3))
	{	//if($t%2==0){ $col2="#FFFFFF ";}else{$col2="#F0F0F0 ";}
		$sqlType="select st_user_rolemaster_head_type.RoleID ,st_user_rolemaster_head_type.cust_type_id ,st_cust_type.cust_type_name 
		from st_user_rolemaster_head_type left join st_cust_type on st_user_rolemaster_head_type.cust_type_id = st_cust_type.cust_type_id 
		where st_user_rolemaster_head_type.RoleID='$re3[RoleID_Lineid]'";
		$qryType=sqlsrv_query($con,$sqlType,$params,$options);
		
			
	
		echo '<tr class="mousechange"  bgcolor="'.$col2.'">';
		echo'<td align="center"></td>';
		
		echo '<td align="left">&nbsp;&nbsp;&nbsp;'. $re3['RoleName_Linename'] .'</td>';
		echo '<td align="left"><br>';
			while($re4=sqlsrv_fetch_array($qryType))
			{ 
				//echo $sqlType;
				echo "&nbsp;&nbsp;&nbsp;".$re4['cust_type_name']."<br>";
			}// while re4
		echo '<br></td>';
		echo '<TD align="center">';
			echo '<a href="?page=edit_rolemaster2&id='.$re3['RoleID_Lineid'].'"  >';
			echo '<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>';
		echo '</TD>';
		echo '<TD align="center">'; 
			 /*echo "<a href=\"?page=from_rolemaster&do=del2&id=".$re3['RoleID_Lineid']."\" onclick=\"return confirm('คุณต้องการลบข้อมูลตำแหน่งย่อยนี้ใช่หรือไม่?');\" >";
			 echo '<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>';*/
		echo '</TD></tr>';
	$t++;}//while $re3
 $r++;
 }//while $re2 ?>
	</table>
</td></tr>
</table>
</body>
</html>
