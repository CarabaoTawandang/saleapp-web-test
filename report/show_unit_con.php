<?
include("../includes/config.php");
$txt_location =$_POST['txt_location'];
?>



<option value="">-เลือกหน่วย-</option>
<?
$sql="SELECT st_unit_id,st_unit_name FROM st_item_unit
WHERE st_unit_id NOT IN (SELECT st_unit_id from st_item_unit_con where P_Code ='$txt_location') ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);
			?>
			<option value="<?print $detail['st_unit_id']?>" ><?print $detail['st_unit_name']?></option>
	
			<?
			}
?>



		