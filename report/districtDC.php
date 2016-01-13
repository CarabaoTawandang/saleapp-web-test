<?include("../includes/config.php");

			$value=$_POST['value'];
			$sql="SELECT * FROM dc_amphur where AMPHUR_CODE='$value' ";
			$params = array();
			$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$de=sqlsrv_fetch_array($qry);


?>
<option value=''>- Select* -</option>
<?
			$sql4="SELECT * FROM dc_district where AMPHUR_ID='$de[AMPHUR_ID]' order by DISTRICT_NAME asc  ";
	
	
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry4=sqlsrv_query($con,$sql4,$params,$options);
				$row4=sqlsrv_num_rows($qry4);
				for($h=0;$h<$row4;$h+=1)
				{
				$detail4=sqlsrv_fetch_array($qry4);
			?>
			<option value="<?print $detail4['DISTRICT_CODE']?>"><?print $detail4['DISTRICT_NAME']   ?></option>
					
				<?
				
			
				}	
				
				
				
				?>
				
