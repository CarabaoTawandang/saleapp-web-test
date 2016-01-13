<?include("../includes/config.php");

			$value=$_POST['value'];

			
			$sqlPro="select * from  dc_province where GEO_ID like '%$value%' ";
			$qryPro=sqlsrv_query($con,$sqlPro,$params,$options);
			
			?><option value=''>-จังหวัด-</option>
			<?while($rePro=sqlsrv_fetch_array($qryPro)){
		?>
		<option value="<?=$rePro['PROVINCE_CODE']; ?>" ><?=$rePro['PROVINCE_NAME']; ?></option>
		<? }?>
