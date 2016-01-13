<?
//------------------------------------------------------แก้ไข โดย PONG 06/07/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_name =	trim($_POST['txt_name']);
$txt_id =trim($_POST['txt_id']);

$sql="select st_item_unit.* from  st_item_unit " ;
if($txt_id){$sql.="where st_unit_id like '%$txt_id'  "; }
else if($txt_name){$sql.="where st_unit_name like '%$txt_name%'  "; }
else if($txt_all){}

/*echo $sql;*/
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qrySearch=sqlsrv_query($con,$sql,$params,$options);
$rowSearch=sqlsrv_num_rows($qrySearch);
$r=1;

		
?>


</head>
<body>
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="1000px">
	<tr><td align="center">รหัสหน่วยของสินค้า</td>
	<td align="center">ชื่อหน่วยของสินค้า</td>
	<TD align="center">แก้ไข</TD>
	<td align="center">ลบ</td>


	</tr>
	<? while($re=sqlsrv_fetch_array($qrySearch)){ 
		if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}
		?>
	<tr class="mousechange"  bgcolor="<?=$col;?>" height="30">
	<td align="left"><?=$st_unit_id=$re['st_unit_id']; ?></td>
	<td align="left"><?=$re['st_unit_name']; ?></td>

	
	
	<td align="center">
		<a href="?page=edit_item_unit&id=<?=$st_unit_id;?>"  >
		<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	
	<td align="center">
		<!--<a href="?page=save_item_unit&do=del&id=<?=$st_unit_id;?>" onclick="return confirm('คุณต้องการลบหน่วยของสินค้านี้ใช่หรือไม่?');" >
		<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>-->
	</td>
	</tr>
	
<? $r++;}?>

	</table>
</td></tr>
</table>
</body>
</html>
