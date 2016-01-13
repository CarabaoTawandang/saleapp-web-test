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

	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="700px">
	<tr >
	<td align="center">ชื่อสินค้า</td>

	<td align="center">หน่วย</td>
	<TD align="center">จำนวน : 1</TD>
	

	<td align="center">แก้ไข</td>
	<td align="center">ลบ</td>

	</tr>
	<? while($re=sqlsrv_fetch_array($qrySearch))
	{  if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}
		
	$main="select * from st_item_unit_con where  P_Code = '$re[P_Code]' 
	and st_unit_id in(select st_unit_id from st_item_product where P_Code='$re[P_Code]') ";
	$main=sqlsrv_query($con,$main,$params,$options);
	$main=sqlsrv_fetch_array($main);
		?>
		
	<tr class="mousechange"  bgcolor="<?=$col;?>" height="30">
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['PRODUCTNAME']; ?></td>
	
	<td align="center"><?=$main['st_unit_id'];?></td>
	<td align="center"><?=$main['st_unit_qty'];?></td>

	<td align="left">&nbsp;&nbsp;&nbsp;</td>
	<td align="left">&nbsp;&nbsp;&nbsp;</td>


	
	
	
	

<?

		
	$sql3="select * from st_item_unit_con where  P_Code = '$re[P_Code]' 
	and st_unit_id not in(select st_unit_id from st_item_product where P_Code='$re[P_Code]')";
	$qry3=sqlsrv_query($con,$sql3,$params,$options); $t=1;
	
	while($re3=sqlsrv_fetch_array($qry3))	
	{if($t%2==0){ $col2="#F0F0F0";}else{$col2="#FFFFFF  ";}

	
		echo '<tr class="mousechange"  bgcolor="'.$col2.'"><td align="center"></td>';

		
		echo'<td align="center">'.$re3['st_unit_id'].'</td>';
		
		echo '<td align="center">'. $re3['st_unit_qty'] .'</td>';

		echo '<TD align="center">';
		echo '<a href="?page=edit_unit_con&id='.$re['P_Code'].'&id_='.$re3['st_unit_id'].'"  >';
			echo '<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>';
		echo '</TD>';
		echo '<TD align="center">'; 
			/*echo "<a href=\"?page=save_unit_con&do=del&id=".$re['P_Code']."&id_=".$re3['st_unit_id']."\" onclick=\"return confirm('คุณต้องการลบหน่วย+สินค้านี้ใช่หรือไม่?');\" >";
			 echo '<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>';*/
		echo '</TD></tr>';
	 $t++;} $r++;}?>
		</table>
</td></tr>
</table>
</body>
</html>

