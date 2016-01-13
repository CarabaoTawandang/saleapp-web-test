<?
//------------------------------------------------------โดย PONG 11/09/2015-------------------
session_start();
set_time_limit(0);
include("../../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_id =$_POST['txt_id'];
$Equipment=$_POST['Equipment'];

$sql="select * from st_D_Maintenance where  Serial_No like '%%' ";
if($txt_id){$sql.="and Serial_No like '%$txt_id%'  "; }
if($Equipment){$sql.="and Equipment like '%$Equipment%'  "; }
else if($txt_all){ }

$sql.="order by ID_Maintenance asc ";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qrySearch=sqlsrv_query($con,$sql,$params,$options);

$r=0;

?>


<html>
<body>
<table cellpadding="0" cellspacing="0"  border="0" align="left"  class="box" width="1124px">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0"  border="1" align="left"  width="1124px">
	<tr bgcolor="#F2FAEB">
	<td align="center"><font size="2">NO.</font></td>
	<td align="center"><font size="2">อุปกรณ์</font></td>
	<td align="center"><font size="2">Serial No.</font></td>
	<td align="center"><font size="2">IMEI</font></td>
	<td align="center"><font size="2">การซ่อม</font></td>
	<td align="center"><font size="2">คำอธิบาย</font></td>
	<td align="center"><font size="2">สถานะ</font></td>
	<td align="center"><font size="2">ค่าซ่อม</font></td>
	<td align="center"><font size="2">วันที่ส่งซ่อม</font></td>
	
	<td align="center"><font size="2">แก้ไข</font></td>
	<td align="center"><font size="2">ลบ</font></td>


	</tr>
	<? while($re=sqlsrv_fetch_array($qrySearch))
	{{ $col="#EEEEEE";}
	
	$c="select Category_name from st_D_Maintenance_Category where Category_ID='$re[Category]' ";
	$c =sqlsrv_query($con,$c,$params,$options);
	$c=sqlsrv_fetch_array($c);
		
	$s="select  Status_NAME from st_D_Status where Status_ID='$re[Status]' ";
	$s =sqlsrv_query($con,$s,$params,$options);
	$s=sqlsrv_fetch_array($s);
	
?>
	
	<tr bgcolor="<?=$col;?>" height="30">
	<td align="left"><font size="2">&nbsp;<?=$re['ID_Maintenance']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?if($re['Equipment']=='TL'){echo "Tablet";}else if($re['Equipment']=='MP'){echo "Moblie printer";}?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Serial_No']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['IMEI']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$c['Category_name']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Description']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$s['Status_NAME']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=number_format($re['Cost'],2); ?></font></td>
	
	<td align="left"><font size="2"><?=date_format($re['Date_receiver'],'d/m/Y');?></font></td>

	<td align="center">
		<a href="?page=edit_Maintenance&id=<?=$re['ID_Maintenance'];?>"  >
		<img src=".././images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	<td align="center">
		<a href="?page=save_Maintenance&do=del&id=<?=$re['ID_Maintenance'];?>" onclick="return confirm('คุณต้องการลบรายการซ่อมบำรุงนี้ใช่หรือไม่?');" >
		<img src=".././images/del.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	


	
	<? 
	$r++;}	?>

		</table>
</td></tr>
</table>
</body>
</html>

