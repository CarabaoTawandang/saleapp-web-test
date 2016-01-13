<?
//------------------------------------------------------แก้ไข โดย DREAM 01/10/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_name =$_POST['txt_name'];


 $sql="select  * from st_saletype ";

if($txt_name){$sql.=" where SaleTypeName like '%$txt_name%' "; }
else if($txt_all){ }

$sql.=" order by SaleType asc";
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
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="950px">
<tr><td colspan="2">
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="950">
	<tr><td align="center">รหัสประเภทการขาย</td>
	<td align="center">ประเภทการขาย</td>

	<TD align="center">แก้ไข</TD>
	<td align="center">ลบ</td>

	</tr>
	
	<? while($re=sqlsrv_fetch_array($qry))
	
	{ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	
	<tr class="mousechange" bgcolor="<?=$col;?>" height="30" >
	<td align="left ">&nbsp;<?=$re['SaleType'];?></td>
	<td align="left ">&nbsp;<?=$re['SaleTypeName'];?></td>
	

	
	
	<td align="center">
		<a href="?page=edit_master_saletype&id=<?=$re['SaleType'];?>"  >
		<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	
	<td align="center">
		<!--------<a href="?page=save_master_saletype&do=del&id=<?=$re['SaleType'];?>" onclick="return confirm('คุณต้องการลบประเภทการขายนี้ใช่หรือไม่?');" >
		<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>------->
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
