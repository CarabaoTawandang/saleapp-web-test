<?
include("../includes/config.php");

$value=$_POST['value'];


?>
<option value=' '>- All -</option>
<?
			$sqlDC="select User_id,name,surname,Salecode from st_user where dc_groupid='$value' order by Salecode asc";
	
	
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qryDC=sqlsrv_query($con,$sqlDC,$params,$options);
				$rowDC=sqlsrv_num_rows($qryDC);
				for($i=0;$i<$rowDC;$i+=1)
				{
				$reDC=sqlsrv_fetch_array($qryDC);
			?>
			<option value="<?print $reDC['User_id']?>"><? print $reDC['Salecode']."   ".$reDC['name']." ".$reDC['surname'];?></option>
					
				<?
				
			
				}	
				
				
				
				?>
				