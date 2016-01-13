<?
//------------------------------------------------------แก้ไข โดย PONG 21/07/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=$_POST['txt_all'];
$txt_name =	trim($_POST['txt_name']);
$txt_id =trim($_POST['txt_id']);

$sql="select P_Code,PRODUCTNAME from st_item_product  " ;
if($txt_id){$sql.="where  st_item_product.P_Code like '%$txt_id%'  "; }
else if($txt_name){$sql.="where PRODUCTNAME like'$txt_name%'  "; }
else if($txt_all){}

$sql.="order by st_item_product.PRODUCTNAME asc  ";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
//echo $sql;
$qrySearch=sqlsrv_query($con,$sql,$params,$options);
$rowSearch=sqlsrv_num_rows($qrySearch);
$r=0;


?>


</head>
<body>
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="700px">
	<tr >
	<td align="center">ชื่อสินค้า</td>
	<td align="center">ประเภทขาย</td>
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
		
	<tr class="mousechange"  bgcolor="<?=$col;?>" height="30">
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['PRODUCTNAME']; ?></td>
	
	<td align="left">&nbsp;&nbsp;&nbsp;</td>
	<td align="left">&nbsp;&nbsp;&nbsp;</td>

	<td align="left">&nbsp;&nbsp;&nbsp;</td>
	<td align="left">&nbsp;&nbsp;&nbsp;</td>
	<td align="left">&nbsp;&nbsp;&nbsp;</td>
	<td align="left">&nbsp;&nbsp;&nbsp;</td>
	<td align="left">&nbsp;&nbsp;&nbsp;</td>

	
	
	
	

<?

		
	 $sql3="select * from st_item_price where  P_Code = '$re[P_Code]' order by SaleType asc,st_unit_qty desc ";
	$qry3=sqlsrv_query($con,$sql3,$params,$options); $t=1;
	
	while($re3=sqlsrv_fetch_array($qry3))	
	{if($t%2==0){ $col2="#F0F0F0";}else{$col2="#FFFFFF  ";}

	$open="SELECT SaleTypeName FROM st_saletype 
		WHERE SaleType ='$re3[SaleType]'  ";
	$open=sqlsrv_query($con,$open,$params,$options);
	$open=sqlsrv_fetch_array($open);
		echo '<tr class="mousechange"  bgcolor="'.$col2.'"><td align="center"></td>';

		echo'<td align="center">'.$open['SaleTypeName'].'</td>';
		echo'<td align="center">'.$re3['st_unit_id'].'</td>';
		?>
		<td align="center"><?if($re3['st_unit_qty']=="0.00"){echo "0.00";}else{echo $re3['st_unit_qty'];}?></td>
		<td align="right"><?if($re3['st_buy_price']=="0.00"){echo "0.00";}else{echo $re3['st_buy_price'];}?></td>
		<td align="right"><?if($re3['st_sell_price']=="0.00"){echo "0.00";}else{echo $re3['st_sell_price'];}?></td>
		<?
		echo '<TD align="center">';
		echo '<a href="?page=edit_unit_price&id__='.$re3['SaleType'].'&id='.$re['P_Code'].'&id_='.$re3['st_unit_id'].'"  >';
			echo '<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>';
		echo '</TD>';
		echo '<TD align="center">'; 
			/*echo "<a href=\"?page=save_unit_price&do=del&id__=".$re3['SaleType']."&id=".$re['P_Code']."&id_=".$re3['st_unit_id']."\" onclick=\"return confirm('คุณต้องการลบหน่วย+ราคานี้ใช่หรือไม่?');\" >";
			 echo '<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>';*/
		echo '</TD></tr>';
	 $t++;} $r++;}?>
		</table>
</td></tr>
</table>
</body>
</html>

