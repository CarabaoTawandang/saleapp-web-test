<?include("../includes/config.php");

$value=$_POST['value'];


?>
<option value=''>- เลือกจังหวัด -</option>
<?
			$sql3="SELECT * FROM dc_Province where GEO_ID='$value' order by PROVINCE_NAME asc  ";
	
	
				$qry3=sqlsrv_query($con,$sql3);
				while($detail3=sqlsrv_fetch_array($qry3))
				{
				
			?>
			<option value="<?print $detail3['PROVINCE_CODE']?>"><?print $detail3['PROVINCE_NAME']   ?></option>
					
				<?
				
			
				}	
				
				
				
				?>
				
