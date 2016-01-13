
<?//------------------------------------------------------แก้ไข โดย DREAM 10/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">

$(function(){	
		$('#txt_date1,#txt_date2').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

        });
		$('#txt_DC').change(function(){
				//alert("phung**");
				$.ajax({
					
					url:'report/SaleByDC.php',
					type:'POST',
					data:'value='+$('#txt_DC').prop('value'),
					//alert("phung");
					//data:{name:'1'}
					success:function(result){
						$('#txt_Sale').html(result);
					}
				});
		});
		/*$('#txt_DC').change(function(){
				//alert("phung**");
				$.ajax({
					
					url:'report/SaleCodeByDC.php',
					type:'POST',
					data:'value='+$('#txt_DC').prop('value'),
					//alert("phung");
					//data:{name:'1'}
					success:function(result){
						$('#txt_Salecode').html(result);
					}
				});
		});*/
		
		
		$('#btn_search,#btn_excel').button();
		$('#btn_search').click(function(){
					if($('#txt_DC').prop('value')=='')
					{ alert("โปรดใส่ศุนย์ที่ต้องการค้นหา");
					}
					else if($('#txt_date1,#txt_date2').prop('value')==' ')
					{ alert("โปรดใส่วันที่ที่ต้องการค้นหา");
					}
					
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/ReportDetailProductSales.php',
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
					else if($('#txt_date1,#txt_date2').prop('value')==' ')
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
        
        <h3>รายงานสรุปบิลรายวัน</h3>
            
          
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" id="frmSearch" name="frmSearch"   action="report/ExcelReportDetailProductSales.php">
	<table  align="center" border="0">
	<tr><td align="center">
	<B>วันที่: </B><input type="text" id="txt_date1" name="txt_date1" value="<?=date('Y-m-d'); ?>">
	<B> ถึง : </B><input type="text" id="txt_date2" name="txt_date2" value="<?=date('Y-m-d'); ?>">
	<B>DC: </B>
	<select  id="txt_DC" name="txt_DC" style="width:170px;" >
	<option value="">-เลือก DC-</option>
		<? $sqlOp="select a.dc_groupname,a.dc_groupid
			from st_user_group_dc a   ";
			if($userType <>"7" and $userType2<>""){
				$sqlOp.=" left join st_user u
				on u.dc_groupid =a.dc_groupid
				where u.User_id= '$USER_id'"; }
			echo $sqlOp;
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['dc_groupid']." '>";
			echo $deOp['dc_groupname'];
			echo "</option>";
			}
		?>
	</select>
	<br><br>
	<!---<b style="color:black;text-align:center;">Sales code</b>
		<select id="txt_Salecode" name="txt_Salecode"   style="width:150px;"><option value=""> - Selete -</option></select>
	---><b style="color:black;text-align:center;">พนักงานขาย</b>
		<select id="txt_Sale" name="txt_Sale"   style="width:150px;"><option value=""> - All -</option></select>
	<B>สินค้า: </B>
	<select  id="txt_item" name="txt_item" style="width:170px;" >
	<option value="">-เลือกสินค้า-</option>
		<? $sqlOpPro="select P_Code,PRODUCTNAME
			from st_item_product where prd_type_id = 'S001' ";
			$sqlOpPro=sqlsrv_query($con,$sqlOpPro);
			while($OpPro=sqlsrv_fetch_array($sqlOpPro)){
			echo "<option value='".$OpPro['P_Code']." '>";
			echo $OpPro['PRODUCTNAME'];
			echo "</option>";
			}
		?>
	</select>
	
	<br><br>
	<a href="#/btn_search" id="btn_search" style="width:200px;text-align:center;" >Search Report</a>
	<a href="#/btn_excel" id="btn_excel" style="width:200px;text-align:center;" >Export Excel</a>
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->

<br><br><div id="txt_search" align="center"></div>
</form>

