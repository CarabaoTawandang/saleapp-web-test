<?
//------------------------------------------------------แก้ไข โดย PONG 06/07/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_all=trim($_POST['txt_all']);
$txt_name =trim($_POST['txt_name']);
$txt_id =trim($_POST['txt_id']);

$sql="select st_item_product.* from  st_item_product " ;
if($txt_id){$sql.="where P_Code like '%$txt_id'  "; }
else if($txt_name){$sql.="where PRODUCTNAME like '$txt_name%'  "; }
else if($txt_all){}

$sql.="order by st_item_product.prd_type_nm  asc ";

//echo $sql;

$qrySearch=sqlsrv_query($con,$sql,$params,$options);
$qrySearch2=sqlsrv_query($con,$sql,$params,$options);
$rowSearch=sqlsrv_num_rows($qrySearch2);
$r=1;

		
?>


</head>
<body>
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="100%">
<tr><td colspan="2">
	<table cellpadding="0" cellspacing="0"  border="1" align="center" width="100%">
	
	<tr>
	<td align="center" width="5px">ลำดับ</td>
	<td align="center" >ประเภท</td>
	<td align="center">กลุ่ม</td>
	<td align="center" width="100px">ลำดับ/ประเภท</td>
	<td align="center">รหัสสินค้า</td>
	<td align="center">ชื่อ</td>
	<TD align="center">ชื่อย่อ</TD>
	<td align="center">หน่วย:1</td>
	
	
	<td align="center">แก้ไข</td>
	<td align="center">ลบ</td>

	</tr>
	<? while($re=sqlsrv_fetch_array($qrySearch)){ 
		if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";  }
		if($prd_type_nm <> $re['prd_type_nm']){$rr=1;}
		?>
	<tr class="mousechange"  bgcolor="<?=$col;?>" height="30">
	<td align="center"><?=$r; ?></td>
	<td align="left"><? echo $prd_type_nm=$re['prd_type_nm']; ?></td>
	<td align="left"><?=$re['prd_grp_nm']; ?></td>
	
	<td align="center"><?=$rr;?></td>
	<td align="left"><?=$id=$re['P_Code']; ?></td>
	<td align="left"><?=$re['PRODUCTNAME']; ?></td>
	<td align="left"><?=$re['PRODUCTSHORTNAME']; ?></td>
	<td align="left"><?=$re['st_unit_id']; ?></td>
	

	
	
	<td align="center">
		<a href="?page=edit_item_product&id=<?=$id;?>"  >
		<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	
	<td align="center">
		<!--<a href="?page=save_item_product&do=del&id=<?=$id;?>" onclick="return confirm('คุณต้องการลบสินค้านี้ใช่หรือไม่?');" >
		<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>-->
	</td>
	</tr>
	
<? $r++; $rr++;}?>

	</table>
</td></tr>
</table>
</body>
</html>
