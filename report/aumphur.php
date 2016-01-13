<?include("../includes/config.php");

			$value=$_POST['value'];
			$sql="SELECT * FROM dc_province where PROVINCE_CODE='$value' ";
			$qry=sqlsrv_query($con,$sql);
			$de=sqlsrv_fetch_array($qry);
			
			

?>
<option value=''>- เลือกอำเภอ -</option>
<?			
	
			$sql3="SELECT * FROM dc_amphur where PROVINCE_ID='$de[PROVINCE_ID]' order by AMPHUR_NAME asc  ";
				
				$qry3=sqlsrv_query($con,$sql3);
				while($detail3=sqlsrv_fetch_array($qry3))
				{
				
			?>
			<option value="<?print $detail3['AMPHUR_CODE']?>"><?print $detail3['AMPHUR_NAME']   ?></option>
					
				<?
				
			
				}	
				
				
				
				?>
				
