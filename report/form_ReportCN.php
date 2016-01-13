<?//------------------------------------------------------27 Oct 2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">

$(function(){	
		$('#txtdate1,#txtdate2,#Delivery_date,#txtdateCN').datepicker({ dateFormat:'dd-mm-yy' });	
		$('#btn_add').button();$('#btn_add2').button();
		$('#btn_search').click(function(){
					if(($('#txt_DC').prop('value')=='')&&($('#txt_name').prop('value')=='')
					&&($('#txtdateCN').prop('value')=='')&&($('#txtdateCN2').prop('value')=='')
					&&($('#txt_pro').prop('value')=='')&&($('#txt_aum').prop('value')=='')
					&&($('#txtdate1').prop('value')=='')&&($('#txtdate2').prop('value')=='')
					&&($('#txt_CNid').prop('value')=='')&&($('#txt_status').prop('value')=='')
					&&($('#txt_dis').prop('value')=='')&&($('#txt_saleType').prop('value')=='')
					&&($('#txt_id').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_ReportCN.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
		$('#txtdate1').change(function(){
			var x1 =$('#txtdate1').prop('value');
			document.frmSearch.txtdate2.value = x1;
			
		});	
		$('#txtdateCN').change(function(){
			var x11 =$('#txtdateCN').prop('value');
			document.frmSearch.txtdateCN2.value = x11;
			
		});
		
		$('#txt_DC').change(function(){
				
				$.ajax({
					url:'report/province_from_plan.php',
					type:'POST',
					data:'value='+$('#txt_DC').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_pro').html(result);
					}
				});
			});	
			
		$('#txt_pro').change(function(){
				
				$.ajax({
					url:'report/aumphur.php',
					type:'POST',
					data:'value='+$('#txt_pro').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_aum').html(result);
					}
				});
			});
		
		$('#txt_aum').change(function(){
				
				$.ajax({
					url:'report/district.php',
					type:'POST',
					data:'value='+$('#txt_aum').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_dis').html(result);
					}
				});
			});
		
	$('#order_n').change(function(){
		if($('#order_n').val()=='') {

		$('#sort').attr("disabled", true); 
	
		} else {

	  $('#sort').removeAttr("disabled");
	 
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
        
        <h3>รายงานยกเลิกบิลCN</h3>
            
        
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" action="report/export_ReportCN.php" id="frmSearch" name="frmSearch" >
	<table  cellpadding="0" cellspacing="0" align="center" border="0">
	<tr><td align="center">
	
	วันที่เปิดบิล :&nbsp;<input type="text" id="txtdate1" name="txtdate1" value="">
	&nbsp;&nbsp;
	ถึง :&nbsp;<input type="text" id="txtdate2" name="txtdate2" value="">
	&nbsp;&nbsp;
	รหัสบิล:&nbsp;<input type="text" id="txt_id" name="txt_id">
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td align="center">
	&nbsp;&nbsp;ชื่อร้านค้า :&nbsp;<input type="text" id="txt_name" name="txt_name">&nbsp;&nbsp;
	<B>สถานะ: </B>
	<select id="txt_status" name="txt_status"><option value="">-ALL-</option>
	<? 
	$sqlStatus="select  CN_id,CN_name from st_CN_status  order by CN_id asc";
	$sqlStatus=sqlsrv_query($con,$sqlStatus); 
		while($Status=sqlsrv_fetch_array($sqlStatus))
		{ echo '<option value="'.$Status['CN_id'].'">'.$Status['CN_name'].'</option>';
		}
	?>
	</select>
	&nbsp;&nbsp;<B>ประเภทขาย: </B>
	<select id="txt_saleType" name="txt_saleType"><option value="">-ALL-</option>
	<? 
	$sqlSaleType="select  SaleType,SaleTypeName from st_saletype order by SaleTypeName asc";
	$sqlSaleType=sqlsrv_query($con,$sqlSaleType); 
		while($SaleType=sqlsrv_fetch_array($sqlSaleType))
		{ echo '<option value="'.$SaleType['SaleType'].'">'.$SaleType['SaleTypeName'].'</option>';
		}
	?>
	</select>
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	
	<tr><td align="center">
	<B>DC: </B>
	<select  id="txt_DC" name="txt_DC" style="width:170px;" >
	<option value="">-All-</option>
		<? $sqlOp="select a.dc_groupname,a.dc_groupid
			from st_user_group_dc a   ";
			if($userType <>"7" and $userType2<>""){
				$sqlOp.=" left join st_user u
				on u.dc_groupid =a.dc_groupid
				where u.User_id= '$USER_id'"; }
			//echo $sqlOp;
			$qryOp=sqlsrv_query($con,$sqlOp);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['dc_groupid']." '>";
			echo $deOp['dc_groupname'];
			echo "</option>";
			}
		?>
	</select>
	<B style="color:black;text-align:center;">จังหวัด  :</B>
	<select style="width:150px;text-align:left;" id="txt_pro"  name="txt_pro" >
	<option value="">-All-</option>
	<?	$sql3="SELECT * FROM dc_Province  order by PROVINCE_NAME asc  ";
			$qry3=sqlsrv_query($con,$sql3);
			while($detail3=sqlsrv_fetch_array($qry3))
				{
				echo '<option value="'.$detail3['PROVINCE_CODE'].'">'.$detail3['PROVINCE_NAME'].'</option>';
				}
		?>
	
	</select>&nbsp;&nbsp;
	<B style="color:black;text-align:center;">อำเภอ / แขวง  :</B>
	<select style="width:150px;text-align:left;" id="txt_aum"  name="txt_aum" >
	<option value="">-All -</option>
		
	</select>&nbsp;&nbsp;
	<B style="color:black;text-align:center;">ตำบล / แขวง  :</B>
	<select style="width:150px;text-align:left;" id="txt_dis"  name="txt_dis" >
	<option value="">-All -</option>
		
	</select></td></tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	
	<tr><td align="center">
	<!----ประเภทร้าน
	<select style="width:150px;text-align:left;" id="txt_custType"  name="txt_custType" >
	<option value="">-เลือก -</option>
		
	</select>&nbsp;&nbsp;--->
	เลขที่ CN:&nbsp;<input type="text" id="txt_CNid" name="txt_CNid">&nbsp;
	วันที่ยกเลิกCN :&nbsp;<input type="text" id="txtdateCN" name="txtdateCN" value="">
	ถึง :&nbsp;<input type="text" id="txtdateCN2" name="txtdateCN2" value="">
	<input type="checkbox" value="all" id="txt_all" name="txt_all">ดูทั้งหมด
	<br><br>
	
	เรียง  :
	<select style="width:100px;text-align:left;" id="order_n"  name="order_n" >
	<option value="">-เลือก-</option>
	<option value="cast(h.Ref_Docdate as date)">วันที่เปิดบิล</option>
	<option value="c.CustName">ชื่อร้าน</option>
	<option value="c.PROVINCE_NAME">จังหวัด</option>
	<option value="c.cust_type_name">ประเภทร้าน</option>
	<option value="h.CN_id">สถานะ</option>
	</select>&nbsp;&nbsp;
	<select style="width:100px;text-align:left;" id="sort"  name="sort" disabled>
	<option value="">-แบบ-</option>
	<option value="ASC">น้อยไปมาก</option>
	<option value="DESC">มากไปน้อย</option>
	</select>
	<input type="button" value="ค้นหา" class="myButton_form" id="btn_search" name="btn_search" align="center">
	<input type="submit" value="Eeport Excel" class="myButton_form" id="btn_export" name="btn_export" align="center">
	
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->
<br><br><div id="txt_search" align="center"></div>
