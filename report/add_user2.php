<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
	session_start();  //เปิดseeion	
	set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
	include("includes/config.php"); //connect database db.carabao.com
	ini_set('session.gc_maxlifetime', 3600); //การกำหนดค่า Session Timeout
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<title>WEB SaleApp</title>

<link href="css2/css.css" rel="stylesheet" type="text/css">
 <script src="css2/ddmenu.js" type="text/javascript"></script>
 <!---------เดิม---->
<script type='text/javascript' src='jQuery/jquery-1.9.1.min.js'></script>
<script type='text/javascript' src='jQuery/jquery-ui-1.10.0.custom.min.js'></script>
<link rel='stylesheet' type='text/css' href='jQuery/ui-lightness/jquery-ui-1.10.0.custom.css'>
<link rel='stylesheet' type='text/css' href='jQuery/ui-lightness/jquery-ui-1.10.0.custom.min.css'>

<script type="text/javascript" src="jQuery/path.js"></script>
<script type='text/javascript' src='jQuery/time/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='jQuery/time/jquery-ui.js'></script>
<script type='text/javascript' src='jQuery/time/jquery.ui.timepicker.js'></script>
<link rel='stylesheet' type='text/css' href='jQuery/time/jquery.ui.timepicker.css'>
<script type="text/javascript">
	 function readURL(input) {
			//alert("Test");
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_band')
                        .attr('src', e.target.result)
                        .width('100px')
                        .height('100px')
                        .show();
                };

                reader.readAsDataURL(input.files[0]);
            } 

        }

	 $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            if(($(this).attr("value")=="ผจส") ||($(this).attr("value")=="ผจภ") || ($(this).attr("value")=="Admin")){
               $("#DIV_VL").hide();
			   $("#DIV_Sale1").hide();
            }
            else if($(this).attr("value")=="ขาย1"){
                $("#DIV_VL").show();
				$("#DIV_Sale1").hide();
            }
			else if($(this).attr("value")=="ขาย2"){
                $("#DIV_Sale1").show();
				$("#DIV_VL").hide();
            }
      
        });
	});
	
	
	$(function(){	
			
		$('#save').button();
		$('#reset').button();
		$('#btn_add').button();
		
		$('#txtType').change(function(){
				
				$.ajax({
					url:'report/Role2.php',
					type:'POST',
					data:'value='+$('#txtType').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txtType2').html(result);
					}
				});
		});
		$('#save').click(function(){
					if($('#txtUsername').prop('value')=='')  {alert("โปรดใส่Username !");}
					else if($('#txtPass').prop('value')=='')  {alert("โปรดใส่Password  !");}
					else if($('#txtName').prop('value')=='')  {alert("โปรดใส่ชื่อผู้ใช้  !"); }
					else if($('#txtType').prop('value')=='')  {alert("โปรดใส่ตำแหน่ง  !"); }
					/*else if(document.frmuser.txtLv1.checked == false  && 
								document.frmuser.txtLv2.checked == false &&
								document.frmuser.txtLv3.checked == false)  {alert("โปรดใส่Lavel  !"); }
					else if ((document.frmuser.txtLv2.checked == true )&& $('#txtLvMg').prop('value')=='')
						{alert("โปรดใส่Managerที่ดูแลคุณ  !"); } 
						else if ((document.frmuser.txtLv3.checked == true )&& $('#txtLvSale1').prop('value')=='')
						{alert("โปรดใส่ ขาย1 ที่ดูแลคุณ  !"); } */
					//else if($('#txtDC').prop('value')=='')  {alert("โปรดใส่ DC  !"); }
					
					else {
					$('#txt_check').html("<img src='images/89.gif'>");
					/*$.ajax({
						
						url:'save_user.php',
						type:'POST',
						data:$('#frmuser').serialize(),
						success:function(result){
							$('#txt_check').html(result);
							}
							});*/
						$(document).ready(function (e) { //alert("TEST"); 
						$("#frmuser").on('submit',(function(e) {// alert("TEST"); 
						e.preventDefault();
						$.ajax({
						url: "report/save_user.php", // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
						contentType: false,       // The content type used when sending data to the server.
						cache: false,             // To unable request pages to be cached
						processData:false,        // To send DOMDocument or non processed data file it is set to false
						success:function(result){
													$('#txt_check').html(result);
													}
						});
						}));
						});

					
							
			}	
		});
		
	







		
		});//function	
</script>
<style type="text/css">  
.inner_position_right{  
    
    top:0px; /* css กำหนดชิดด้านบน  */  
    left:60%; /* css กำหนดชิดขวา  */  
    z-index:999;  
}  
</style>
</head>
<body>
<form  method="post" name="frmuser" id="frmuser"  enctype="multipart/form-data">
<div class="container_box">
    <div id="box">
	<div class="header"><h3>สมัคร User</h3><!---หัวเรื่องหลัก-->
           <p>สมัคร Username เพื่อเข้าใช้ Web SaleApp
		    <input type="button" value="ข้อมูล User" id="btn_add" onclick="window.location='?page=data_user';" align="center" class="inner_position_right">
		   </p><!---หัวเรื่องรอง-->
		   
	</div><div class="sep"></div>
		<!---เนื้อหา-->
		<table cellpadding="0" cellspacing="0"  border="0">
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		<td align="left" width="160px"><B style="color:black;text-align:center;">Username :</B></td>
		<td align="left"><input type="text" id="txtUsername" name ="txtUsername" >
		<B style="color:red;text-align:center;">*</B>
		(สำหรับเข้าระบบ) </td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">Password:</B></td>
		<td align="left" valign="top">
		<input type="password" id="txtPass" name ="txtPass">
		<B style="color:red;text-align:center;">*</B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">ชื่อผู้ใช้:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtName" name ="txtName" >
		<B style="color:red;text-align:center;">*</B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">นามสกุล:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtSurname" name ="txtSurname" >
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">ตำแหน่ง:</B></td>
		<td align="left" valign="top">
			<select id="txtType" name="txtType"  style="width:170px;">
				<option value> - เลือกตำแหน่ง -</option>
				<?	$sql="SELECT  RoleID ,RoleName  FROM st_user_rolemaster_head   ";
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
					$qry=sqlsrv_query($con,$sql,$params,$options);
					$row=sqlsrv_num_rows($qry);
					for($j=0;$j<$row;$j+=1){
					$detail=sqlsrv_fetch_array($qry);
				?>
				<option value="<?print $detail['RoleID']?>" ><?print $detail['RoleName']?></option>
				<?}?>
			</select> 
			<B style="color:red;text-align:center;">*</B>
			&nbsp;ย่อย:
			<select id="txtType2" name="txtType2"  style="width:170px;">
				<option value=""> - Selete -</option>
			</select>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>


		<!---
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">Lavel:</B></td>
		<td align="left" valign="top">
			<input type="radio" id="txtLv1" name ="txtLv" value="ผจภ" >Admin
			<input type="radio" id="txtLv1" name ="txtLv" value="ผจภ" >ผจภ
			<input type="radio" id="txtLv1" name ="txtLv" value="ผจส" >ผจส
			<input type="radio" id="txtLv2" name ="txtLv" value="ขาย1" >ขาย1
			<input type="radio" id="txtLv3" name ="txtLv" value="ขาย2" >ขาย2
			<div id="DIV_VL" style="display:none"><br>
				<select id="txtLvMg" name="txtLvMg"  style="width:170px;">
				<option value=""> - manager ที่ดูแลคุณ-</option>
				<?	$sql="SELECT  manager_id,manager_name FROM st_user_lv_manager ";
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
					$qry=sqlsrv_query($con,$sql,$params,$options);
					$row=sqlsrv_num_rows($qry);
					for($j=0;$j<$row;$j+=1){
					$detail=sqlsrv_fetch_array($qry);
				?>
				<option value="<?print $detail['manager_id']?>" ><?print $detail['manager_name']?></option>
				<?}?>
			</select>
			</div>
			<div id="DIV_Sale1" style="display:none"><br>
				<select id="txtLvSale1" name="txtLvSale1"  style="width:170px;">
				<option value=""> - ขาย1 ที่ดูแลคุณ-</option>
				<?	$sql="SELECT  sale_1_id,sale_1_name FROM st_user_lv_sale_1 ";
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
					$qry=sqlsrv_query($con,$sql,$params,$options);
					$row=sqlsrv_num_rows($qry);
					for($j=0;$j<$row;$j+=1){
					$detail=sqlsrv_fetch_array($qry);
				?>
				<option value="<?print $detail['sale_1_id']?>" ><?print $detail['sale_1_name']?></option>
				<?}?>
			</select>
			</div>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		--->

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">DC พื้นที่ดูแล:</B></td>
		<td align="left" valign="top">
			<select id="txtDC" name="txtDC"  style="width:170px;">
				<option value=""> - เลือก DC -</option>
				<?	$sql="SELECT  dc_groupid ,dc_groupname  FROM st_user_group_dc  order by  dc_groupid asc ";
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
					$qry=sqlsrv_query($con,$sql,$params,$options);
					$row=sqlsrv_num_rows($qry);
					for($j=0;$j<$row;$j+=1){
					$detail=sqlsrv_fetch_array($qry);
				?>
				<option value="<?print $detail['dc_groupid']?>" ><?print $detail['dc_groupname']?></option>
				<?}?>
			</select>
			<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">ทะเบียนรถ:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtCar_plate" name ="txtCar_plate" >
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">เลข imei tablet:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtimei" name ="txtimei" >
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">เบอร์ซิมของ tablet:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtphone_sim" name ="txtphone_sim" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" maxlength="10">
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">รูปประจำตัวของคุณ :</B></td>
		<td align="left" valign="top">
		<input type="file" id="txtpic" name ="txtpic" onchange="readURL(this);" >
		<input type="hidden" name="MAX_FILE_SIZE"  value="51200" />
		<br>
		<img id="image_band" src="#" alt="Picture"  style="display: none"/>
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		
	<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">เบอร์โทรที่สามารถติดต่อได้:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtphone" name ="txtphone" >
		
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
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
	</select>
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
		<tr>	
		<td colspan="2" align="left" >
			<input type="hidden" id="hd_cmd"  name="hd_cmd" />
						
						<input type="submit" id="save" name="save" value="save">
						<input type="reset" id="reset" name="reset" value="reset">						
		</tr>	
		</table>


	</div><!--/-box-->
</div><!--/-container_box-->
<br><br>


</form>
<div id="txt_check"></div>

</body>
</html>
