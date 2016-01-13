<?//------------------------------------------------------แก้ไข โดย DREAM 10/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">

$(function(){	
			
		$('#btn_add').button();
		$('#btn_add1').button();
		$('#btn_search').click(function(){
					if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_promotion.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
		$('#btn_search1').click(function(){
					if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_giveaway.php',
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
    left:70%; /* css กำหนดชิดขวา  */  
    z-index:999;  
} 
</style>

<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>ค้นหาโปรโมชั่น</h3>
            
          <p>รายชื่อข้อมูลโปรโมชั่น
		  <input type="button" value="เพิ่มโปรโมชั่นส่วนลด" id="btn_add" onclick="window.location='?page=add_promotion';" align="center" class="inner_position_right">
		  <input type="button" value="เพิ่มโปรโมชั่นของแถม" id="btn_add1" onclick="window.location='?page=add_giveaway';" align="center" class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  align="center" border="0">
	<tr><td align="center">
	
	รหัส&nbsp;<input type="text" id="txt_id" name="txt_id" >&nbsp;&nbsp;
	ชื่อเรื่อง&nbsp;<input type="text" id="txt_name" name="txt_name">
	
	<input type="checkbox" value="all" id="txt_all" name="txt_all">ดูทั้งหมด
	<input type="button" value="โปรโมชั่นส่วนลด" class="myButton_form" id="btn_search" name="btn_search">
	<input type="button" value="โปรโมชั่นของแถม" class="myButton_form" id="btn_search1" name="btn_search1">
	<br><br><div id="txt_search"></div>
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->
<br><br>