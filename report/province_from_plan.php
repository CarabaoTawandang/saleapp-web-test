<?include("../includes/config.php");

			$value=$_POST['value'];

			
			$sqlPro="select stView_DC_Pro.dc_groupid
,stView_DC_Pro.dc_groupname
,stView_DC_Pro.dc_ProCode as PROVINCE_CODE
,dc_province.PROVINCE_NAME
from  stView_DC_Pro left join  dc_province
on stView_DC_Pro.dc_ProCode = dc_province.PROVINCE_CODE

where stView_DC_Pro.dc_groupid ='$value'

order by dc_province.PROVINCE_NAME asc";
			$qryPro=sqlsrv_query($con,$sqlPro,$params,$options);
			
			?><option value=''>- เลือกจังหวัดในDC -</option>
			<?while($rePro=sqlsrv_fetch_array($qryPro)){
		?>
		<option value="<?=$rePro['PROVINCE_CODE']; ?>" ><?=$rePro['PROVINCE_NAME']; ?></option>
		<? }?>
