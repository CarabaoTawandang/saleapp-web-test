
<?  //-------------------------------------------------by pong 21/09/2015
include("../includes/config.php");

$Type =$_POST['Type'];

?>

<script type="text/javascript">
$(function(){	

$('#PRODUCT').change(function(){
				$('#Z').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/Z.php',
					type:'POST',
						data:$('#frmuser').serialize(),
					success:function(result){
						$('#Z').html(result);
					}
				});
		});

		});
</script>
		
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B>สินค้า</B>&nbsp;&nbsp;&nbsp;&nbsp;
<select id="PRODUCT" name="PRODUCT"  style="width:200px;" required>
	<option value="">--เลือก--</option>
	<?			$P="select * from st_item_product where prd_type_id='$Type' ";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$P = @sqlsrv_query($con,$P,$params,$options);				
			while($P_=sqlsrv_fetch_array($P))
			{
?>
<option value="<?=$P_['P_Code'];?>"><?=$P_['PRODUCTNAME'];?></option>
<? } ?>
	</select>
	&nbsp;<B style="color:red;text-align:center;">*</B>


	
	


			
		
		
		