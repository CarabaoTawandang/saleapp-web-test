<?//------------------------------------------------------27 Oct 2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">

$(function(){	
			
		$('#btn_add').button();$('#btn_add2').button();
		
		$('#txt_DC').change(function(){
				
				$.ajax({
					url:'report/UserByDC.php',
					type:'POST',
					data:'value='+$('#txt_DC').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_User').html(result);
					}
				});
		});
		
		
		$('#btn_search').click(function(){
					if(($('#dateTo').prop('value')=='')&&
					($('#dateEnd').prop('value')=='')&&
					($('#txt_User').prop('value')=='')&&
					($('#txt_DC').prop('value')=='') )
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_dailysales.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
	$('#dateTo,#dateEnd').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

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
        
        <h3>สรุปยอดขายรายวัน</h3>
            
        
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  align="center" border="0">
	<tr><td align="center">
	<B>วันที่: </B><input type="text" id="dateTo" name="dateTo" value="<?=date('Y-m-d')?>">
<!--	<B>DC: </B>
	<select  id="txt_DC" name="txt_DC" style="width:170px;" >
	<option value="">-เลือก DC-</option>
		<? /* $sqlOp="select dc_groupname,dc_groupid
			from st_user_group_dc";
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['dc_groupid']." '>";
			echo $deOp['dc_groupname'];
			echo "</option>";
			}
		*/?>
	</select>
   -->
	<br><br>
	<input type="button" value="ค้นหา" class="myButton_form" id="btn_search" name="btn_search">
	<br><br><div id="txt_search"></div>
	
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->
<br><br>
