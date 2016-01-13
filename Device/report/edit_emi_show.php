<?/*tablet-----------------*/
include("../../includes/config.php");
$imei_show =$_POST['imei_show'];
			
			$open="SELECT serail_number FROM st_device_tablet_detail WHERE imei ='$imei_show' ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$open=sqlsrv_query($con,$open,$params,$options);
			$open=sqlsrv_fetch_array($open);
	
?>

<input  id="Serial" name="Serial" type="text" style="width:200px; background-color:#EDEDED;" value="<?=$open['serail_number']?>" readonly/>