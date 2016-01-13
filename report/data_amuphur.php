<?//------------------------------------------------------แก้ไข โดย PONG 23/06/2015------------------------------------

session_start();  //เปิดseeion	
set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
include("../includes/config.php"); //connect database db.carabao.com
$txt_id= $_POST['txt_id'];//รหัสที่จะค้นหา
$txt_name= $_POST['txt_name'];//ชื่อที่จะค้นหา

$sqlSearch="select dc_amphur.*
,dc_province.PROVINCE_NAME
from dc_amphur left join dc_province
on dc_amphur.PROVINCE_ID=dc_province.PROVINCE_ID ";
if($txt_id <>"" ){$sqlSearch.="where AMPHUR_CODE='$txt_id' ";}
else if($txt_name <>"" ){$sqlSearch.="where AMPHUR_NAME like '$txt_name%' ";}
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qrySearch=sqlsrv_query($con,$sqlSearch,$params,$options);
$rowSearch=sqlsrv_num_rows($qrySearch);
$r=1;
//echo $sqlSearch;
?>
	<table  cellpadding="0" cellspacing="0"   align="center" border="1" width="700">
	<tr>
	<!--<td align="center">รหัสอำเภอ</td>--->
	<td align="center">ชื่ออำเภอ</td>
	<td align="center">ชื่อจังหวัด</td>
	<td align="center">แก้ไข</td>
	<td align="center">ลบ</td></tr>
	<?  while($re=sqlsrv_fetch_array($qrySearch)){ 
		if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}
		//for($i=0;$i<$rowSearch;$i++){ $test=sqlsrv_fetch_array($qrySearch);
	?>
	<tr class="mousechange" bgcolor="<?=$col;?>">
	<!---<td align="center"><?=$re['AMPHUR_CODE']; ?></td>--->
	<td align="left"><?=$re['AMPHUR_NAME']; ?></td>
	<td align="left"><?=$re['PROVINCE_NAME']; ?></td>
	<TD align="center"><img src="./images/edit.gif" style="cursor:pointer" alt="Complete" onclick="window.location='?page=edit_amuphur&id=<?=$re['AMPHUR_CODE'];?>';" /></TD>
	<TD align="center"><!--<a href="?page=save_amuphur&do=del&id=<?=$re['AMPHUR_CODE']; ?>" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่?');" ><img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>--></TD>
	</tr>
	<? $r++;} ?>
	</table>
	