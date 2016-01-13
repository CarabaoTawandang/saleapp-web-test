<?//------------------------------------------------------แก้ไข โดย pong 30/09/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">

$(function(){	
			
		$('#btn_add').button();
		$('#btn_search').click(function(){
					if(($('#txt_name').prop('value')=='')&&($('#txt_id').prop('value')=='')
					&&($('#txt_side').prop('value')=='')&&($('#txt_tax').prop('value')=='')
					&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_warehouse_location.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
		
		$('#add_warehouse_location').button();
	
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
        
        <h3>ค้นหาคลังสินค้า</h3>
            
          <p>ข้อมูลคลังสินค้า
		  <input type="button" value="เพิ่มคลังสินค้า" id="add_warehouse_location" onclick="window.location='?page=add_warehouse_location';" class="inner_position_right" >
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  align="center" border="0">
	<tr><td align="center" colspan="2">
	ชื่อคลังสินค้า&nbsp;<input type="text" id="txt_name" name="txt_name">
	&nbsp;&nbsp;รหัสคลังสินค้า&nbsp;<input type="text" id="txt_id" name="txt_id">
	</td></tr>
	<tr><td align="center">
	&nbsp;&nbsp;เลขสาขา&nbsp;<input type="text" id="txt_side" name="txt_side">
	&nbsp;&nbsp;เลขกำกับภาษี&nbsp;<input type="text" id="txt_tax" name="txt_tax">
	</td></tr>
	<tr><td align="center">
	<input type="checkbox" value="all" id="txt_all" name="txt_all">ดูทั้งหมด
	<input type="button" value="ค้นหา" class="myButton_form" id="btn_search" name="btn_search">
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->
<br><br>    

<div id="txt_search" align="center"></div>
