
<?  //-------------------------------------------------by pong 23/07/2015
include("../includes/config.php");

$txt_location =$_POST['txt_location'];
$sql="select st_unit_id from st_item_product where P_Code='$txt_location'";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			$detail=sqlsrv_fetch_array($qry);
			echo $detail['st_unit_id'];

		

		
?>

	
	


			
		
		
		