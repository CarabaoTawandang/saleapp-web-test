
<?//------------------------------------------------------แก้ไข โดย DREAM 10/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">

$(function(){	
			
		$('#btn_search,#btn_excel').button();
		$('#txt_date1,#txt_date2').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

        });
		
		$('#btn_search').click(function(){
					if($('#txt_loca').prop('value')=='')
					{ alert("โปรดใส่คลังที่ต้องการค้นหา");
					}
					else if($('#txt_date1,#txt_date2').prop('value')=='')
					{ alert("โปรดใส่วันที่ที่ต้องการค้นหา");
					}
					
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/ReportTax.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
		$('#btn_excel').click(function(){
				//alert("test");
					if($('#txt_DC').prop('value')=='')
					{ alert("โปรดใส่ศุนย์ที่ต้องการค้นหา");
					}
					else if($('#txt_date1,#txt_date2').prop('value')=='')
					{ alert("โปรดใส่วันที่ที่ต้องการค้นหา");
					}
					else {
					$('#frmSearch').submit();
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
        
        <h3>รายงานภาษีการขาย</h3>
            
          
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" id="frmSearch" name="frmSearch"   action="report/ExcelReportTax.php">
	<table  align="center" border="0">
	<tr><td align="center">
	<B>วันที่: </B><input type="text" id="txt_date1" name="txt_date1" value="<?=date('Y-m-d'); ?>">
	<B> ถึง : </B><input type="text" id="txt_date2" name="txt_date2" value="<?=date('Y-m-d'); ?>">
	<B>คลัง: </B>
	<select  id="txt_loca" name="txt_loca" style="width:170px;" >
	<option value="">-เลือกคลัง-</option>
		<? $sqlOp="select locationno,locationname
			from st_warehouse_location";
			$qryOp=sqlsrv_query($con,$sqlOp);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['locationno']." '>";
			echo $deOp['locationname'];
			echo "</option>";
			}
		?>
	</select>
	
	
	<br><br>
	<a href="#/btn_search" id="btn_search" style="width:200px;text-align:center;" >Search </a>
	<a href="#/btn_excel" id="btn_excel" style="width:200px;text-align:center;" >Export Excel</a>
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->

<br><br><div id="txt_search" align="center"></div>
</form>

