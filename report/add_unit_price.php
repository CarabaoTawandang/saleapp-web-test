<?//-----------------------------------------------------------------by PONG 21/07/2015
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
		
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function()
{	
			
		$('#save').button();$('#btn').button();
		
		$('#btn_add').button();
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });
	$('#txt_location').change(function(){
				$('#show_Unit').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/show_unit.php',
					type:'POST',
						data:$('#frmuser').serialize(),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#show_Unit').html(result);
					}
				});
	});
	$('#txt_location').change(function(){
				$('#unit').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/show_unit_price.php',
					type:'POST',
						data:$('#frmuser').serialize(),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#unit').html(result);
					}
				});
	});
	
	$('#unit').change(function(){
				$('#Typesale').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/Typesale.php',
					type:'POST',
						data:$('#frmuser').serialize(),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#Typesale').html(result);
					}
				});
	});
	$('#unit').change(function(){
				$('#count').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/show_count_price.php',
					type:'POST',
						data:$('#frmuser').serialize(),
					success:function(result){
						$('#count').html(result);
					}
				});
	});
	$('#txt_location').change(function(){
				$('#count').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/show_count_price.php',
					type:'POST',
						data:$('#frmuser').serialize(),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#count').html(result);
					}
				});
	});
	
	
	
});//function	
</script>

<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>เพิ่มหน่วย+ราคา</h3>
            
          <p>
		  <input type="button" value="ค้นหาหน่วย+ราคา" id="btn_add" onclick="window.location='?page=from_item';"  class="inner_position_right">
		  </p>

            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_unit_price" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"  ><div class="h_head"></div></td></tr>
<tr><td colspan="2" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td width="150"><B>สินค้า</B></td><td>
<select  id="txt_location" name="txt_location" style="width:170px;" required>
	<option value="">-เลือกสินค้า-</option>
		<? $sql="SELECT P_Code,PRODUCTNAME  FROM st_item_product ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['P_Code']?>" ><?print $detail['PRODUCTNAME']?></option>
		
			<?
			}

		
	
	?>
	</select>&nbsp;<B style="color:red;text-align:center;">*</B>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td width="150"><B>หน่วย</B></td><td>
<select  id="unit" name="unit" style="width:170px;" required>	
	<option value="">-เลือกหน่วย-</option>


</select>&nbsp;<B style="color:red;text-align:center;">*</B>

<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td width="150"><B>ประเภทขาย</B></td><td>
	
<select  id="Typesale" name="Typesale" style="width:170px;" required>	
	<option value="">-ประเภทขาย-</option>


</select>&nbsp;<B style="color:red;text-align:center;">*</B>



<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>จำนวน</B></td><td>
<text id="count"></text>&nbsp;&nbsp;
<text id="show_Unit"></text>
</td></tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td ><B>ราคาซื้อ</B></td>
	<td colspan="1"><input type="text" id="buy" name="buy" style="width:100px;"onKeyUp="if(this.value*1!=this.value) this.value='' ;" required/>&nbsp;(บาท)</select>&nbsp;<B style="color:red;text-align:center;">*</B>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>ราคาขาย</B></td>
	<td colspan="1"><input type="text" id="sell" name="sell" style="width:100px;"onKeyUp="if(this.value*1!=this.value) this.value='' ;" required/>&nbsp;(บาท)</select>&nbsp;<B style="color:red;text-align:center;">*</B>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">			</tr>	
</table>
</form>
</div>
</div>

</body>
</html>