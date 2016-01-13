<?
////----------------------------------------------------------------------------------------------------------------------ค้นหาตำบล by pong 23/6/58
session_start();  //เปิดseeion	
set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
include("../includes/config.php"); //connect database db.carabao.com
$txt_id= $_POST['txt_id'];//รหัสที่จะค้นหา
$txt_name= $_POST['txt_name'];//ชื่อที่จะค้นหา

$sqlSearch="select 
dc_district.*
,dc_amphur.AMPHUR_NAME		
,dc_province.PROVINCE_NAME
 from dc_district left join dc_amphur
 on dc_district.AMPHUR_ID = dc_amphur.AMPHUR_ID  left join dc_province
 on dc_district.PROVINCE_ID = dc_province.PROVINCE_ID ";
 
 
if($txt_id <>"" ){$sqlSearch.="where DISTRICT_ID='$txt_id' ";}
else if($txt_name <>"" ){$sqlSearch.="where DISTRICT_NAME like '$txt_name%' ";}
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qrySearch=sqlsrv_query($con,$sqlSearch,$params,$options);
$rowSearch=sqlsrv_num_rows($qrySearch);
$r=1;
//echo $sqlSearch;
?>
	<table  cellpadding="0" cellspacing="0"   align="center" border="1" width="700">
	<tr><td align="center">รหัสตำบล</td><td align="center">ชื่อตำบล</td><td align="center">ชื่ออำเภอ</td><td align="center">ชื่อจังหวัด</td><td align="center">แก้ไข</td><td align="center">ลบ</td></tr>
	<?  while($re=sqlsrv_fetch_array($qrySearch)){ 
		if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}
		//for($i=0;$i<$rowSearch;$i++){ $test=sqlsrv_fetch_array($qrySearch);
	?>
	<tr bgcolor="<?=$col;?>">
	<td align="center"><?=$re['DISTRICT_ID']; ?></td>
	<td align="left"><?=$re['DISTRICT_NAME']; ?></td>
	<td align="left"><?=$re['AMPHUR_NAME']; ?></td>
	<td align="left"><?=$re['PROVINCE_NAME']; ?></td>
	<td align="center"></td>
	<td align="center"></td>
	</tr>
	<? $r++;} ?>
	</table>