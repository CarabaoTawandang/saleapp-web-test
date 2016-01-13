<?//-----------------------------------------pong 22/09/2015
include("../includes/config.php");
$txt_location =$_POST['txt_location'];
$unit =$_POST['unit'];
?>



<option value="">-เลือกประเภท-</option>
<?
$sql="SELECT SaleType,SaleTypeName FROM st_saletype 
WHERE SaleType NOT IN (SELECT SaleType from st_item_price  where P_Code= '$txt_location'and st_unit_id='$unit') ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);
			?>
			<option value="<?print $detail['SaleType']?>" ><?print $detail['SaleTypeName']?></option>
	
			<?
			}
?>