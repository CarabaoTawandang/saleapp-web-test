<?/*tablet-----------------*/
include("../../includes/config.php");
$IMEI =$_POST['IMEI'];
			
			$open="SELECT serail_number FROM st_device_tablet_detail WHERE imei ='$IMEI' ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$open=sqlsrv_query($con,$open,$params,$options);
			$open=sqlsrv_fetch_array($open);
	
?>

<input  id="Serial" name="Serial" type="text" style="width:200px; background-color:#EDEDED;" value="<?=$open['serail_number']?>" readonly/>