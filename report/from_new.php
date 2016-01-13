<?//------------------------------------------------------แก้ไข โดย DREAM 10/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">

$(function(){	

		$('#day_first').datepicker({                    
                        dateFormat:'yy-mm-dd'

                                                });
		$('#day_second').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });	
		$('#btn_add').button();
		$('#btn_search').click(function(){
					if(($('#day_first').prop('value')=='')&&($('#day_second').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่วันที่ในการค้นหาให้ครบ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_new.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});

	
	$('#txt_all').change(function(){
    if (this.checked) {

		$('#day_first').attr("disabled", true); 
		$('#day_second').attr("disabled", true); 	
		} else {

	  $('#day_first').removeAttr("disabled");
	  $('#day_second').removeAttr("disabled");
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
        
        <h3>ค้นหาข่าว</h3>
            
          <p>รายชื่อข้อมูลข่าว
		  <input type="button" value="เพิ่มข่าว" id="btn_add" onclick="window.location='?page=add_new';" align="center" class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  align="center" border="0">
	<tr><td align="center">
	
	
	วันที่&nbsp;<input type="text" id="day_first" name="day_first" value="<?=date('Y-m-d')?>">
	&nbsp;ถึง&nbsp;<input type="text" id="day_second" name="day_second" value="<?=date('Y-m-d')?>">
	<input type="checkbox" value="all" id="txt_all" name="txt_all">ดูทั้งหมด
	<input type="button" value="ค้นหา" class="myButton_form" id="btn_search" name="btn_search">
	<br><br>
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->
<br><br>

<div id="txt_search"></div>