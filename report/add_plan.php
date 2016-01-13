<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		
		$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
		 $RoleID =$_SESSION["RoleID"];
		
		$sqlOpen="select cust_type_id,cust_type_name from st_cust_type";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$rowOpen=sqlsrv_num_rows($qryOpen);
		
		
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<script type="text/javascript">
$(function(){	
			
		$('#Next').button();
		$('#btn_add').button();
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
		
		$('#datefrom').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                                });
		$('#dateTo').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
								
		
		$('#txt_userPlan').change(function(){
				
				$.ajax({
					url:'report/PlanByDC.php',
					type:'POST',
					data:'value='+$('#txt_userPlan').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_plan').html(result);
					}
				});
		});
		
		
});//function	
</script>
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>วางแผนเข้าพื้นที่ให้ลูกน้อง/วัน</h3>
            
          <p>
		  <input type="button" value="ค้นหาการวางแผน" id="btn_add" onclick="window.location='?page=from_Inplan';"  class="inner_position_right">
		  </p>

            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_plan" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วางแผนให้ : </B></td><td>
<select  id="txt_userPlan" name="txt_userPlan" style="width:170px;" required/>
	<option value="">-เลือกพนักงานขาย-</option>
		<? $sqlOp="select st_user_lv_Detail.user_id_head
			,st_user_lv_Detail.user_id_detail
			,st_user.*
			from st_user_lv_Detail left join st_user
			on st_user_lv_Detail.user_id_detail = st_user.User_id
			where  st_user_lv_Detail.user_id_head ='$USER_id' 
			order by st_user.Salecode asc ";
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['user_id_detail']." '>";
			echo $deOp['Salecode']." ".$deOp['name']." ".$deOp['surname'];
			echo "</option>";
			}
		?>
	</select>
</td></tr> 

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วันที่เข้าพื้นที่ : </B></td><td><input type="text" id="datefrom" name="datefrom" required/></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>แผน : </B></td><td>
	<select id="txt_plan" name="txt_plan"   style="width:250px;" required/>
		<option value="" > - Selete -</option>
	</select>
</td></tr> 

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>หมายเหตุ</B></td><td><input type="text" id="txt_remark"align="center" name="txt_remark" size="35"></td></tr>

<tr><tr><td colspan="2">&nbsp;</td></tr>
<td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="Next" name="Next" value="บันทึก">			</tr>	
</table>
</form>
</div>
</div>

</body>
</html>