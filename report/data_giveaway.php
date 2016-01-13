<?
//------------------------------------------------------โดย PONG 30/09/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_name =$_POST['txt_name'];
$txt_id =$_POST['txt_id'];

$sql="select PromotionId,PromotionName,PromotionRemark
,cast(DateBegin as date)as DateBegin1
,cast(DateEnd as date)as DateEnd1,RoleName
from st_promotion_head where PromotionTypeId='002'  ";
if($txt_id){$sql.="where  PromotionId like '%$txt_id%'  "; }
else if($txt_name){$sql.="where PromotionName like '%$txt_name%'  "; }
else if($txt_all){ }

$sql.="order by PromotionId asc ";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qrySearch=sqlsrv_query($con,$sql,$params,$options);

$r=0;


?>


<html>
<body>
<table cellpadding="0" cellspacing="0"  border="0" align="left"  class="box" width="1200px">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0"  border="1" align="left"  width="1200px">
	<tr bgcolor="#F2FAEB">
	<td align="center">ชื่อโปรโมชั่น</td>
	<td align="center">รายละเอียด</td>
	<td align="center">วันที่เริ่มต้น</td>
	<td align="center">วันที่สิ้นสุด</td>
	<td align="center">ตำแหน่ง</td>
	<td align="center">สินค้า</td>
	<td align="center">จำนวน/หน่วย</td>
	<td align="center">ของแถม</td>
	<td align="center">จำนวน/หน่วย</td>
	<td align="center">แก้ไข</td>
	<td align="center">ลบ</td>

	</tr>
	<? while($re=sqlsrv_fetch_array($qrySearch))
	{{ $col="#EEEEEE";}?>
	
	<tr class="mousechange" bgcolor="<?=$col;?>" height="30">
	<td align="left">&nbsp;<?=$re['PromotionName']; ?></td>
	<td align="left">&nbsp;<?=$re['PromotionRemark']; ?></td>
	<td align="left">&nbsp;<?=date_format($re['DateBegin1'],'d/m/Y');?></td>
	<td align="left">&nbsp;<?=date_format($re['DateEnd1'],'d/m/Y');?></td>
	<td align="left">&nbsp;<?=$re['RoleName']; ?></td>
	<td align="left ">&nbsp;&nbsp;&nbsp;</td>
	<td align="left ">&nbsp;&nbsp;&nbsp;</td>
	<td align="left ">&nbsp;&nbsp;&nbsp;</td>
	<td align="left ">&nbsp;&nbsp;&nbsp;</td>
	<td align="center">
		<a href="?page=edit_giveaway&id=<?=$re['PromotionId'];?>"  >
		<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	
	<td align="center">
		<!--<a href="?page=save_giveaway&do=del__&id=<?=$re['PromotionId'];?>" onclick="return confirm('คุณต้องการลบโปรโมชั่นนี้ใช่หรือไม่?');" >
		<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>-->
	</td>


	
	<? 
	$sql3="select * from st_promotion_detail where PromotionId ='$re[PromotionId]' ";
	$qry3=sqlsrv_query($con,$sql3,$params,$options); $t=1;
	
	while($re3=sqlsrv_fetch_array($qry3))
	
	{if($t%2==0){ $col2="#F0F0F0";}else{$col2="#FFFFFF  ";}
	
	$name="SELECT * from st_item_product where P_Code ='$re3[P_Code_end]' ";
	$name=sqlsrv_query($con,$name,$params,$options);
	$name=sqlsrv_fetch_array($name);
	
		echo '<tr class="mousechange" bgcolor="'.$col2.'"><td align="center"></td>';
		echo '<TD align="center">';
		echo '<TD align="center">';
		echo '<TD align="center">';
		echo '<TD align="center">';
		echo'<td align="left">&nbsp;'.$re3['PRODUCTNAME_start'].'</td>';
		echo '<td align="center">&nbsp;'. $re3['QtyChk'] .'</td>';
	echo'<td align="left">&nbsp;'.$name['PRODUCTNAME'].'</td>';
	echo'<td align="center">&nbsp;'.$re3['Qty_P_Code_end'].'</td>';
		echo '<TD align="center">';
	
		echo '</TD>';
		echo '<TD align="center">'; 
			/*echo "<a href=\"?page=save_giveaway&do=del&id=".$re3['PromotionId']."&id_=".$re3['P_Code_start']."\" onclick=\"return confirm('คุณต้องการลบสินค้านี้ออกจากโปรโมชั่นใช่หรือไม่?');\" >";
			 echo '<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>';*/
		echo '</TD></tr>';
		
	$t++;} 
	$r++;}	?>

		</table>
</td></tr>
</table>
</body>
</html>

