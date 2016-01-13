<?//------------------------------------------------------แก้ไข โดย PONG 23/06/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">

$(function(){	
			
		$('#btn_add').button();
		$('#btn_search').click(function(){
					if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='') ){alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_amuphur.php',
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
        
        <h3>ค้นหาอำเภอ</h3>
            
          <p>รายชื่ออำเภอ
		  <input type="button" value="เพิ่มอำเภอ" id="btn_add" onclick="window.location='?page=add_amuphur';" align="center" class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  align="center" border="0">
	<tr><td align="center">
	รหัส<input type="text" id="txt_id" name="txt_id">
	ชื่อ<input type="text" id="txt_name" name="txt_name">
	<input type="button" value="ค้นหา" class="myButton_form" id="btn_search" name="btn_search">
	<br><br><div id="txt_search"></div>
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->
<br><br>