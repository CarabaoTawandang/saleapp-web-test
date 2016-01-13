<?include("../includes/config.php");

$value=$_POST['value'];
			$sql="SELECT * FROM dc_amphur where AMPHUR_CODE='$value' ";
			$qry=sqlsrv_query($con,$sql);
			$de=sqlsrv_fetch_array($qry);


?>
<option value=''>- เลือกตำบล -</option>
<?
			$sql4="SELECT * FROM dc_district where AMPHUR_ID='$de[AMPHUR_ID]' order by DISTRICT_NAME asc  ";
	
	
				$qry4=sqlsrv_query($con,$sql4);
				while($detail4=sqlsrv_fetch_array($qry4))
				{
				
			?>
			<option value="<?print $detail4['DISTRICT_CODE']?>"><?print $detail4['DISTRICT_NAME']   ?></option>
					
				<?
				
			
				}	
				
				
				
				?>
				
