<?
//------------------------------------------------------แก้ไข โดย PONG 03/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

?>
<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
		$('#btn_add2').button();
		$('#btn_add3').button();
		$('#btn_add4').button();
		$('#btn_add5').button();
		$('#btn_add6').button();
		$('#btn_search').click(function(){
					if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_item.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
							}
							});
							
		$('#btn_search2').click(function(){
					if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_item_group.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
							}
							});
		$('#btn_search3').click(function(){
					if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_item_unit.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
							}
							});
		$('#btn_search4').click(function(){
					if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_item_product.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
							}
							});
		
		$('#btn_search6').click(function(){
					if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_unit_con.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
							}
							});
		$('#btn_search7').click(function(){
					if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_unit_price.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
							}
							});
							
	});//function	
</script>

<style type="text/css">  
.inner_position_right{  
    
    top:0px; /* css กำหนดชิดด้านบน  */  
    left:50%; /* css กำหนดชิดขวา  */  
    z-index:999;  
} 
</style>

<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>ค้นหา</h3>
             
          <p>รายชื่อ<h5>
	
	<input type="button" value="เพิ่มประเภทสินค้า" id="btn_add" onclick="window.location='?page=add_item_type';" class="inner_position_center">
	<input type="button" value="เพิ่มกลุ่มสินค้า" id="btn_add3" onclick="window.location='?page=add_item_group';" class="inner_position_center" >
	<input type="button" value="เพิ่มหน่วย" id="btn_add4" onclick="window.location='?page=add_item_unit';" class="inner_position_center" >
	<input type="button" value="เพิ่มสินค้า" id="btn_add2" onclick="window.location='?page=add_item_product';" class="inner_position_center" >
	<input type="button" value="เพิ่มสินค้าผูกหน่วย" id="btn_add5" onclick="window.location='?page=add_unit_con';" class="inner_position_center">	
	<input type="button" value="เพิ่มสินค้า+หน่วยผูกราคา" id="btn_add6" onclick="window.location='?page=add_unit_price';" class="inner_position_center">
	</h5>
	
  </p>      
    </div>
	
        
    <div class="sep"></div><br>
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  align="center" border="0" width="1050px"><tr><td align="center">
	รหัส&nbsp;<input type="text" id="txt_id" name="txt_id"  style="width:85px;">&nbsp;&nbsp;
	ชื่อ&nbsp;<input type="text" id="txt_name" name="txt_name"style="width:200px;">
	<input type="checkbox" value="all" id="txt_all" name="txt_all">ดูทั้งหมด <br><br>
	<input type="button" value="ค้นหาประเภทสินค้า" class="myButton_form" id="btn_search" name="btn_search">
	<input type="button" value="ค้นหากลุ่มสินค้า" class="myButton_form" id="btn_search2" name="btn_search2">
	<input type="button" value="ค้นหาหน่วย" class="myButton_form" id="btn_search3" name="btn_search3">
	<input type="button" value="ค้นหาสินค้า" class="myButton_form" id="btn_search4" name="btn_search4" >
	<input type="button" value="ค้นหาสินค้าผูกหน่วย" class="myButton_form" id="btn_search6" name="btn_search6" >
	<input type="button" value="ค้นหาสินค้า+หน่วยผูกราคา" class="myButton_form" id="btn_search7" name="btn_search7" >
	
	</td></tr></table>
	
	</form>
	
	
</div>
</div>
<br><br><div id="txt_search" align="center"></div>




