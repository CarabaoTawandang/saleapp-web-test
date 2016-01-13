<?/*tablet-----------------*/
include("../../includes/config.php");
$mac_ =$_POST['mac_'];
			
			$open="SELECT Serial_No FROM st_Device_Mobile_Printer WHERE Mac ='$mac_' ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$open=sqlsrv_query($con,$open,$params,$options);
			$open=sqlsrv_fetch_array($open);
	
?>

<input  id="Serial1" name="Serial1" type="text" style="width:200px; background-color:#EDEDED;" value="<?=$open['Serial_No']?>" readonly/>