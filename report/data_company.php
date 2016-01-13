<?
//------------------------------------------------------แก้ไข โดย PONG 30/09/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_name =$_POST['txt_name'];
$txt_tel=$_POST['txt_tel'];


$sql="select * from st_companyinfo_exp where COMPANYNAME like '%%'";

if($txt_name){$sql.=" and COMPANYNAME like '%$txt_name%' "; }
if($txt_tel){$sql.=" and TELEPHONE like '%$txt_tel%' "; }
else if($txt_all){ }

$sql.=" order by COMPANYCODE asc";
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
<tr><td colspan="2">
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="1124px">
	<tr><td align="center">ชื่อบริษัท</td>
	<td align="center">ที่อยู่</td>
	<td align="center">เบอร์โทร</td>

	<TD align="center">แก้ไข</TD>
	<td align="center">ลบ</td>

	</tr>
	
	<? while($re=sqlsrv_fetch_array($qry))
	
	{ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	
	<tr class="mousechange"  bgcolor="<?=$col;?>" height="30" >
	<td align="left ">&nbsp;<?=$re['COMPANYNAME'];?></td>
	<td align="left ">&nbsp;<?=$re['ADDRESS'];?></td>
	
	<td align="left ">&nbsp;<?=$re['TELEPHONE']?></td>
	
	
	<td align="center">
		<a href="?page=edit_company&id=<?=$re['COMPANYCODE'];?>"  >
		<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	
	<td align="center">
		<!--<a href="?page=save_company&do=del&id=<?=$re['COMPANYCODE'];?>" onclick="return confirm('คุณต้องการลบบริษัทนี้ใช่หรือไม่?');" >
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
