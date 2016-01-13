<?
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
		$('#btn_add2').button();
		
		$.fn.clearForm = function() {
  return this.each(function() {
    var type = this.type, tag = this.tagName.toLowerCase();
    if (tag == 'form')
      return $(':input',this).clearForm();
    if (type == 'text' || type == 'password' || tag == 'textarea')
      this.value = '';
    else if (type == 'checkbox' || type == 'radio')
      this.checked = false;
    else if (tag == 'select')
      this.selectedIndex = -1;
  });
};
		
		$('#btn_search').click(function(){
					
					 
					 if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='')&&($('#geo').prop('value')=='')&&($('#txt_pro').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_DC.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
		
		
		$('#geo').change(function(){
				
				$.ajax({
					url:'report/province_from_Dc.php',
					type:'POST',
					data:'value='+$('#geo').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_pro').html(result);
					}
				});
			});
			
	$('#txt_all').change(function(){
    if (this.checked) {

		$('#txt_id').attr("disabled", true); 
		$('#txt_id').clearForm();
		$('#txt_name').attr("disabled", true); 
		$('#txt_name').clearForm();
		$('#geo').attr("disabled", true); 
		$('#geo').prop('selectedIndex', 0);
		$('#txt_pro').attr("disabled", true); 
		$('#txt_pro').prop('selectedIndex', 0);
				
		} else {

	  $('#txt_id').removeAttr("disabled");
	  $('#txt_name').removeAttr("disabled");
	  $('#geo').removeAttr("disabled");
	  $('#txt_pro').removeAttr("disabled");
	  }
	  });
			
	});//function	
</script>

<style type="text/css">  
.inner_position_right{  
    
    top:0px; /* css กำหนดชิดด้านบน  */  
    left:70%; /* css กำหนดชิดขวา  */  
    z-index:999;  
} 
</style>

<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>ค้นหาDC</h3>
            
          <p>รายชื่อ DC
		  <input type="button" value="เพิ่ม DC" id="btn_add" onclick="window.location='?page=add_DC';"  class="inner_position_right">
		   <input type="button" value="เพิ่มร้านค้าเข้าDC" id="btn_add2" onclick="window.location='?page=add_CustInDC';"  class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  align="center" border="0"><tr><td align="center">
	<font style="color:black;text-align:center;">รหัสDC :</font>
	<input type="text" id="txt_id" name="txt_id">&nbsp;
	<font style="color:black;text-align:center;">ชื่อDC :</font>
	<input type="text" id="txt_name" name="txt_name">&nbsp;
	<font style="color:black;text-align:center;">ภาค :</font>
	<select id="geo" name="geo"  style="width:150px;" >
	<option value="">-เลือก-</option>
			<?
			$sql2="select * from dc_geography order by GEO_ID asc ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry2	 = @sqlsrv_query($con,$sql2,$params,$options);
			while($re2=sqlsrv_fetch_array($qry2))
				{
			?>
				<option value="<?=$re2['GEO_ID'];?>"><?=$re2['GEO_NAME'];?></option>
			<? } ?>

	</select>
	<font style="color:black;text-align:center;">จังหวัด :</font>
	<select style="width:150px;text-align:left;" id="txt_pro"  name="txt_pro" >
	<option value="">-เลือก -</option>
		<?
			$sql2="select * from dc_province order by PROVINCE_CODE asc ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry2	 = @sqlsrv_query($con,$sql2,$params,$options);
			while($re2=sqlsrv_fetch_array($qry2))
				{
			?>
				<option value="<?=$re2['PROVINCE_CODE'];?>"><?=$re2['PROVINCE_NAME'];?></option>
			<? } ?>
		
	</select>&nbsp;&nbsp;<br><br>
	<input type="checkbox" value="all" id="txt_all" name="txt_all">ดูทั้งหมด
	<input type="button" value="ค้นหา" class="myButton_form" id="btn_search" name="btn_search">
	<br><br><div id="txt_search"></div>
	</td></tr></table>
	
</div>
</div>




</form>
<?
if($_GET['do']=="del")
{
	$id=$_GET['id'];
	$del="delete from st_user_group_dc where dc_groupid='$id'";
	$qrydel=sqlsrv_query($con,$del,$params,$options);
	$del2="delete from st_user_group_dc_detail where dc_groupid='$id'";
	$qrydel2=sqlsrv_query($con,$del2,$params,$options);
	
	$del3="delete from st_user_group_dc_cust where dc_groupid='$id'";
	$qrydel3=sqlsrv_query($con,$del3,$params,$options);
	if($qrydel && $qrydel2)
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบ DC เรียบร้อยแล้ว ");';
			echo "window.location='?page=from_DC';";
			echo '</script>';
	}
	
}
?>