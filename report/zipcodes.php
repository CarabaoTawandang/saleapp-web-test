<?include("../includes/config.php");

		$value=$_POST['value'];

//print  $value;

		$sql5="select dc_amphur.*
from dc_amphur 
where 	AMPHUR_CODE='$value'";
		//echo $sql5;
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry5=sqlsrv_query($con,$sql5,$params,$options);
				$row5=sqlsrv_num_rows($qry5);
				
				$detail5=sqlsrv_fetch_array($qry5);
				
				print $detail5['POSTCODE'];
			?>	
				
