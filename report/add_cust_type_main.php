<?//-----------------------------------------------by dream 30/6/2015
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
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
			
		$('#save').button();
		$('#btn_add').button();
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
		
		
		});//function	
</script>
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>เพิ่มประเภทร้านค้า</h3>
            
          <p>
		  <input type="button" value="ค้นหาประเภทร้านค้า" id="btn_add" onclick="window.location='?page=from_cust_type';"  class="inner_position_right">
		  </p>

            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_cust_type_main" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รหัสย่อ</B></td><td><input type="text" id="txt_cust"align="center" name="txt_cust" size="1" maxlength="1" pattern="[A-Z]"
placeholder="A-Z" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>ชื่อประเภทร้านค้า</B></td><td><input type="text" id="txtCUST" name="txtCUST" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
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

</body>
</html>