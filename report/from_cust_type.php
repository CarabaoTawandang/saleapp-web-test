<?
//------------------------------------------------------แก้ไข โดย PONG 30/06/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
		$('#btn_add2').button();
		$('#btn_search').click(function(){
					if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_cust_type.php',
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
        
        <h3>ค้นหาประเภทร้านค้า</h3>
            
          <p>รายชื่อประเภทร้านค้าหลัก-ย่อย<h5>
	<input type="button" value="เพิ่มประเภทร้านค้า" id="btn_add" onclick="window.location='?page=add_cust_type_main';"  class="inner_position_right">
	<input type="button" value="เพิ่มรูปแบบร้านค้า" id="btn_add2" onclick="window.location='?page=add_cust_type_sub';"  class="inner_position_right">
    </h5>        
    </div>
        
    <div class="sep"></div><br>
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  align="center" border="0"><tr><td align="center">
	รหัสประเภทร้านค้าหลัก&nbsp;<input type="text" id="txt_id" name="txt_id">&nbsp;&nbsp;
	ชื่อประเภทร้านค้าหลัก&nbsp;<input type="text" id="txt_name" name="txt_name">
	<input type="checkbox" value="all" id="txt_all" name="txt_all">ดูทั้งหมด
	<input type="button" value="ค้นหา" class="myButton_form" id="btn_search" name="btn_search">
	
	<br><br><div id="txt_search"></div>
	</td></tr></table>
	
</div>
</div>
<br><br>



</form>
