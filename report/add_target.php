<?//--------------------------------------pong 21/9/58
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#save').button();
		$('#btn_add').button();
		$('#start').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                                });
		$('#end_').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//

		
		$('#Z').change(function(){
		if ($('#Z').val() == '') {
			$('#qty').removeAttr("disabled");	
			
		} else {
			$('#qty').attr("disabled", true);	
	
		}
		});
		
		$('#Type').change(function(){
				$('#X').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/X.php',
					type:'POST',
						data:$('#frmuser').serialize(),
					success:function(result){
						$('#X').html(result);
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
        
        <h3>เพิ่มเป้ายอดขาย</h3>
            
          <p>
		  <input type="button" value="ค้นหาเป้ายอดขาย" id="btn_add" onclick="window.location='?page=from_target';"  class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_target" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="4" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>เป้าหมาย</B></td><td><input type="text" id="target" name="target" style="width:300px;"  required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>DC</B></td>
<td><select id="DC" name="DC"  style="width:150px;" required >
	<option value="">--เลือก--</option>
	<?$sql2="select * from st_user_group_dc order by dc_groupid asc";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry2	 = @sqlsrv_query($con,$sql2,$params,$options);				
			while($re2=sqlsrv_fetch_array($qry2))
			{
?>
<option value="<?=$re2['dc_groupid'];?>"><?=$re2['dc_groupname']; ?></option>
<? } ?>
	</select>&nbsp;<B style="color:red;text-align:center;">*</B></td>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>วันที่เริ่มต้น</B></td><td><input type="text" id="start" name="start" required/>
&nbsp;<B>ถึง</B>&nbsp;<input type="text" id="end_" name="end_" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr >
<td width="120" ><B>ประเภทสินค้า</B></td><td colspan="4">
<select id="Type" name="Type"  style="width:200px;" required>
	<option value="">--เลือก--</option>
	<?			$T="select * from st_item_type ";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$T	 = @sqlsrv_query($con,$T,$params,$options);				
			while($T_=sqlsrv_fetch_array($T))
			{
?>
<option value="<?=$T_['prd_type_id'];?>"><?=$T_['prd_type_nm'];?></option>
<? } ?>
	</select>&nbsp;<B style="color:red;text-align:center;">*</B>

<text id="X" ></text><!--ดึงจากไฟล์ X.php-->
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>จำนวนเป้า</B></td><td><input type="text" id="qty" name="qty" style="width:100px;" onKeyUp="if(this.value*1!=this.value) this.value='' ;" disabled required/><text id="Z" ></text><!--ดึงจากไฟล์ X.php--></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>ผลตอบแทน</B></td><td><input type="text" id="amount" name="amount" style="width:300px;"  required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>	
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>บริษัท</B></td><td>
<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
	<?	$sql="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['COMPANYCODE']?>" ><?print $detail['COMPANYNAME']?></option>
		
			<?
			}

		
	
	?>

	</select>&nbsp;<B style="color:red;text-align:center;">*</B>
	</td></tr>




	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">			</tr>	
</table>
</form>
</div>
</div>
<div id="DivSave" ></div>
</body>
</html>