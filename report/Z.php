
<?  //------------------------------------------by pong 21/09/2015
include("../includes/config.php");

$PRODUCT =$_POST['PRODUCT'];
?>

	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B>หน่วย</B>&nbsp;&nbsp;&nbsp;&nbsp;
<select id="unit" name="unit"  style="width:200px;" required>
	<option value="">--เลือก--</option>
	<?			$P="select * from st_item_unit_con where P_Code='$PRODUCT'  ";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$P = @sqlsrv_query($con,$P,$params,$options);				
			while($P_=sqlsrv_fetch_array($P))
			{
?>
<option value="<?=$P_['st_unit_id'];?>"><?=$P_['st_unit_name'];?></option>
<? } ?>
	</select>
	&nbsp;<B style="color:red;text-align:center;">*</B>
		

		

	
	


			
		
		
		