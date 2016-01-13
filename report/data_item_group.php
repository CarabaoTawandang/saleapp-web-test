<?
//------------------------------------------------------แก้ไข โดย PONG 06/07/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_name =	trim($_POST['txt_name']);
$txt_id =trim($_POST['txt_id']);
$sql="select st_item_group.* from  st_item_group ";
if($txt_id){$sql.="where prd_grp_id like '%$txt_id%'  "; }
else if($txt_name){$sql.="where prd_grp_nm like '%$txt_name%'  "; }
else if($txt_all){}

$sql.="order by cast(st_item_group.prd_grp_id as char) asc ";
/*echo $sql;*/
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qrySearch=sqlsrv_query($con,$sql,$params,$options);
$rowSearch=sqlsrv_num_rows($qrySearch);
$r=1;
?>

<body>
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="1000px">
	<tr><td align="center">รหัสกลุ่มสินค้า</td>
	<td align="center">ชื่อกลุ่มสินค้า</td>
	<TD align="center">แก้ไข</TD>
	<td align="center">ลบ</td></tr>
	
	<? while($re=sqlsrv_fetch_array($qrySearch)){ 
		if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}
		?>
	<tr class="mousechange"  bgcolor="<?=$col;?> " height="30">
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=$prd_grp_id= $re['prd_grp_id'];?> </td>
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=$re['prd_grp_nm'];?> </td>
	
	<td align="center">
		<a href="?page=edit_item_group&id=<?=$prd_grp_id;?>"  >
		<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	
	<td align="center">
		<!--<a href="?page=save_item_group&do=del&id=<?=$prd_grp_id;?>" onclick="return confirm('คุณต้องการลบกลุ่มสินค้านี้ใช่หรือไม่?');" >
		<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>-->
	</td>
	</tr>
	
<? $r++;}?>

	</table>
</td></tr>
</table>
</body>
</html>
