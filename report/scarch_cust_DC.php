<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสUser
$txt_geo=trim($_POST['txt_geo']);//ภาค
$txt_pro=trim($_POST['txt_pro']);//จังหวัด
$txt_aum=trim($_POST['txt_aum']);//อำเภอ
$txt_dis=trim($_POST['txt_dis']);//ตำบล
$sql="select  * from st_View_User_DC 
where User_id ='$USER_id' ";
//if($txt_geo){$sql.="and dc_GeoId='$txt_geo' ";}
if($txt_pro){$sql.="and PROVINCE_CODE='$txt_pro' ";}
if($txt_aum){$sql.="and AMPHUR_CODE='$txt_aum' ";}
if($txt_dis){$sql.="and DISTRICT_CODE='$txt_dis' ";}
//echo $sql;
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qry=sqlsrv_query($con,$sql,$params,$options);
$row=sqlsrv_num_rows($qry);
$r=0;
?>
<br>
<table cellpadding="0" cellspacing="0"  border="1"   width="1224px">
	<tr><td colspan="9">Total : <?=$row;?></td></tr>
	<tr>
	<td align="center" width="150">ชื่อร้านค้า </td>
	<td align="center" width="150">ที่อยู่</td>
	<td align="center" width="150">เบอร์โทร</td>
	<td align="center" width="150">ตำบล</td>
	<td align="center" width="150">อำเภอ</td>
	<td align="center" width="150">จังหวัด</td>
	<td align="center" width="150">ภาค</td>
	<td align="center">ยกเลิก</td>
	</tr>
	<? while($re=sqlsrv_fetch_array($qry)){ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	<tr bgcolor="<?=$col;?>" height="30" >
	<td align="left"><?=$re['CustName'];?></td>
	<td align="left"><?=$re['AddressNum'];?></td>
	<td align="left"> <?=$re['Phone'];?>&nbsp;</td>
	<td align="left"><?=$re['DISTRICT_NAME'];?></td>
	<td align="left"><?=$re['AMPHUR_NAME'];?></td>
	<td align="left"><?=$re['PROVINCE_NAME'];?></td>
	<td align="left"><?=$re['GEO_NAME'];?></td>
	<TD align="left"></TD>
	</tr>
	<? 
	$r++;}//while ?>
	</table>
	
	
	 