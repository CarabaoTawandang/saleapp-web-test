<?
//------------------------------------------------------แก้ไข โดย PONG 21/07/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_name =$_POST['txt_name'];
$txt_id =$_POST['txt_id'];

$sql="select P_Code,PRODUCTNAME from st_item_product  " ;
if($txt_id){$sql.="where  st_item_product.P_Code like '%$txt_id%'  "; }
else if($txt_name){$sql.="where PRODUCTNAME like'%$txt_name%'  "; }
else if($txt_all){}

$sql.="order by st_item_product.PRODUCTNAME asc ";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qrySearch=sqlsrv_query($con,$sql,$params,$options);
$rowSearch=sqlsrv_num_rows($qrySearch);
$r=0;


?>


</head>
<body>
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="1000px">
	<tr >
	<td align="center">ชื่อสินค้า</td>
	<td align="center">หน่วย</td>
	<TD align="center">จำนวน : 1</TD>
	
	<td align="center">ราคาซื้อ</td>
	<td align="center">ราคาขาย</td>
	<td align="center">แก้ไข</td>
	<td align="center">ลบ</td>

	</tr>
	<? while($re=sqlsrv_fetch_array($qrySearch))
	{  if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}
		?>
	
	<?
$sql4="select st_item_unit_con.P_Code
,st_item_product.PRODUCTNAME
,st_item_unit_con.st_unit_id
,st_item_unit_con.st_unit_name
,st_item_unit_con.st_unit_qty

,st_item_price.st_unit_qty
,st_item_price.st_buy_price
,st_item_price.st_sell_price
from st_item_unit_con left join st_item_product
on  st_item_unit_con.P_Code=st_item_product.P_Code left join st_item_price
on  st_item_unit_con.P_Code=st_item_price.P_Code
and st_item_unit_con.st_unit_id =st_item_price.st_unit_id
where  st_item_product.P_Code = '$re[P_Code]' ";
	$qry4=sqlsrv_query($con,$sql4,$params,$options);
	$re99=sqlsrv_fetch_array($qry4);?>
		
	
		
	<tr bgcolor="<?=$col;?>" height="30">
	<td align="left"><?=$re['PRODUCTNAME']; ?></td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re99['st_unit_id']; ?></td>
<td align="left">&nbsp;&nbsp;&nbsp;<?=$re99['st_unit_qty']; ?></td>

<td align="left">&nbsp;&nbsp;&nbsp;<?=number_format($re99['st_buy_price']); ?></td>
<td align="left">&nbsp;&nbsp;&nbsp;<?=number_format($re99['st_sell_price']); ?></td>	
	<td align="left ">&nbsp;&nbsp;&nbsp;</td>
	<td align="left ">&nbsp;&nbsp;&nbsp;</td>


	
	
	
	

<?

 $opent1="select st_unit_id from st_item_product  where P_Code='$re[P_Code]' ";
		$opent1 =sqlsrv_query($con,$opent1,$params,$options);
		$op1=sqlsrv_fetch_array($opent1);	
	
 $sql3="select st_item_unit_con.P_Code
,st_item_product.PRODUCTNAME
,st_item_unit_con.st_unit_id
,st_item_unit_con.st_unit_name
,st_item_unit_con.st_unit_qty

,st_item_price.st_unit_qty
,st_item_price.st_buy_price
,st_item_price.st_sell_price
from st_item_unit_con left join st_item_product
on  st_item_unit_con.P_Code=st_item_product.P_Code left join st_item_price
on  st_item_unit_con.P_Code=st_item_price.P_Code
and st_item_unit_con.st_unit_id =st_item_price.st_unit_id 
where  st_item_product.P_Code = '$re[P_Code]'and st_item_unit_con.st_unit_id <>'$op1[st_unit_id]' ";
	$qry3=sqlsrv_query($con,$sql3,$params,$options); $t=1;
	while($re3=sqlsrv_fetch_array($qry3))
	
	{if($t%2==0){ $col2="#F0F0F0";}else{$col2="#FFFFFF  ";}
		echo '<tr bgcolor="'.$col2.'"><td align="center"></td>';
		echo'<td align="left">&nbsp;&nbsp;&nbsp;'.$re3['st_unit_id'].'</td>';
		echo '<td align="left">&nbsp;&nbsp;&nbsp;'. $re3['st_unit_qty'] .'</td>';
	echo'<td align="left">&nbsp;&nbsp;&nbsp;'.$re3['st_buy_price'].'</td>';
	echo'<td align="left">&nbsp;&nbsp;&nbsp;'.$re3['st_sell_price'].'</td>';
		echo '<TD align="center">';
			echo '<a href="?page=edit_unititem&id='.$re['P_Code'].'&id_='.$re3['st_unit_id'].'"  >';
			echo '<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>';
		echo '</TD>';
		echo '<TD align="center">'; 
			echo "<a href=\"?page=save_unititem&do=del&id=".$re['P_Code']."&id_=".$re3['st_unit_id']."\" onclick=\"return confirm('คุณต้องการลบหน่วย+สินค้านี้ใช่หรือไม่?');\" >";
			 echo '<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>';
		echo '</TD></tr>';
	$t++;} $r++;}?>
		</table>
</td></tr>
</table>
</body>
</html>

