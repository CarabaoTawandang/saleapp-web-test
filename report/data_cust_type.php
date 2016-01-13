<?
//------------------------------------------------------แก้ไข โดย PONG 1/07/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_name =$_POST['txt_name'];
$txt_id =$_POST['txt_id'];
$sql="select st_cust_type.* from  st_cust_type ";
if($txt_id){$sql.="where cust_type_id like '$txt_id%'  "; }
else if($txt_name){$sql.="where cust_type_name like '%$txt_name%'  "; }
else if($txt_all){}

$sql.="order by cast(st_cust_type.cust_type_id as char) asc ";
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
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="1000px">
	<tr><td align="center">รหัสประเภทร้านค้า</td>
	<td align="center">ชื่อประเภทร้านค้า</td>
	<td align="center">รูปแบบร้านค้า</td>
	<TD align="center">แก้ไข</TD>
	<td align="center">ลบ</td>

	</tr>
	<? while($re=sqlsrv_fetch_array($qry))
	{ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	<tr class="mousechange"  bgcolor="<?=$col;?>" height="30" >
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=$cust_type_id= $re['cust_type_id'];?> </td>
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=$re['cust_type_name'];?> </td>
	<td align="left "><br><?

	/*$qryType=sqlsrv_query($con,$sqlType,$params,$options);
	while($re2=sqlsrv_fetch_array($qryType))
	{ echo "&nbsp;&nbsp;&nbsp;".$re2['cust_group_name']."<br>";}*/
	
	?> <br></td>
	
	
	<td align="center">
		<a href="?page=edit_cust_type_main&id=<?=$cust_type_id;?>"  >
		<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	
	<td align="center">
		<!--<a href="?page=save_cust_type_main&do=del&id=<?=$cust_type_id;?>" onclick="return confirm('คุณต้องการลบข้อมูลประเภทร้านค้าหลักและร้านค้าย่อยนี้ใช่หรือไม่?');" >
		<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>-->
	</td>
	</tr>
	
<? $sql2="select st_cust_group.*
from st_cust_group left join st_cust_type on st_cust_group.cust_type_id = st_cust_type.cust_type_id 
	where st_cust_group.cust_type_id='$cust_type_id'";
	$qry2=sqlsrv_query($con,$sql2,$params,$options); $t=1;
	while($re3=sqlsrv_fetch_array($qry2))
	{	if($t%2==0){ $col2="#FFFFFF ";}else{$col2="#F0F0F0 ";}
		echo '<tr class="mousechange"  bgcolor="'.$col2.'"><td align="center"></td>';
		echo'<td align="center"></td>';
		echo '<td align="left">&nbsp;&nbsp;&nbsp;'. $re3['cust_group_id']." ".$re3['cust_group_name'] .'</td>';
		echo '<TD align="center">';
			echo "<a href=\"?page=edit_cust_type_sub&id=".$re3['cust_group_id']."\"  >";
			echo '<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>';
		echo '</TD>';
		echo '<TD align="center">'; 
			/*echo "<a href=\"?page=save_cust_type_sub&do=del&id=".$re3['cust_group_id']."\" onclick=\"return confirm('คุณต้องการลบข้อมูลประเภทร้านค้าย่อยนี้ใช่หรือไม่?');\" >";
			 echo '<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>';*/
		echo '</TD></tr>';
	$t++;}//while $re3
 $r++;
 }//while $re ?>

	</table>
</td></tr>
</table>
</body>
</html>
