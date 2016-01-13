<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสUser
$value=$_POST['value'];
?>
<script type='text/javascript'>
$(function(){
	$('#custAll').change(function()
	{		
				if (this.checked) 
				{ 	//alert('checked'); 
					$(".id_Question").attr("checked", "true");
				} 
				else 
				{ 	//alert('no');
					//$(".id_Question").attr("checked", "false");
					$(".id_Question").removeAttr("checked"); 
				}
				
	});
});//function	



</script>
<br>
<table border="0" style='width:200px'>

<?
if($value=="อื่นๆ"){echo "<tr><td ><input type='text' class='id_Question'  style='width:200px'></td></tr>";}
else
{	
	$SQLSearch="select P_Code,PRODUCTNAME from st_item_product where prd_type_id='$value' ";
	$SQLSearch=sqlsrv_query($con,$SQLSearch,$params,$options);
	$rowSearch=sqlsrv_num_rows($SQLSearch);
				if($rowSearch>=1){echo '<input type="checkbox" id="custAll">All';}
				while($Search=sqlsrv_fetch_array($SQLSearch)){
				echo '<tr><td  style="width:200px"> <input type="checkbox" class="id_Question" value ="'.$Search['P_Code'].'">'.$Search['PRODUCTNAME'];
				echo "</td></tr>";
				}
				
}

?>
</table>
<br>