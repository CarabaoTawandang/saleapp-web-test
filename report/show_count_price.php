<?
include("../includes/config.php");
$txt_location =$_POST['txt_location'];
$unit=$_POST['unit'];
?>


<?
			$open="SELECT st_unit_qty FROM st_item_unit_con WHERE P_Code ='$txt_location'and st_unit_id='$unit' ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$open=sqlsrv_query($con,$open,$params,$options);
			$open=sqlsrv_fetch_array($open);
			
			
?>

<input  id="count" name="count" type="text" style="width:100px;" value="<?=$open['st_unit_qty'];?>" disabled />

		