<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
	session_start();  //เปิดseeion	
	set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
	include("includes/config.php"); //connect database db.carabao.com
	ini_set('session.gc_maxlifetime', 3600); //การกำหนดค่า Session Timeout
$id=$_GET['id'];
$sql="select st_user.*
,st_saletype.SaleTypeName
,st_user_group_dc.dc_groupname ,st_user_rolemaster_head.RoleName,st_user_rolemaster_detail.RoleName_Linename
,st_warehouse_location.locationname
,st_companyinfo_exp.COMPANYNAME
from  st_user left join st_user_group_dc
on st_user.dc_groupid = st_user_group_dc.dc_groupid  left join st_user_rolemaster_head
on st_user.RoleID=st_user_rolemaster_head.RoleID left join st_user_rolemaster_detail
on st_user.RoleID_Lineid = st_user_rolemaster_detail.RoleID_Lineid left join st_warehouse_location
on st_user.warehouse_locationNo = st_warehouse_location.locationno left join st_saletype
on st_user.st_saletype = st_saletype.SaleType left join st_companyinfo_exp
on st_user.COMPANYCODE = st_companyinfo_exp.COMPANYCODE
where st_user.User_id ='$id'
order by name asc
 ";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qry=sqlsrv_query($con,$sql,$params,$options);
$re=sqlsrv_fetch_array($qry);
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
					else {
					$('#txt_check').html("<img src='images/89.gif'>");
					
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
    left:30%; /* css กำหนดชิดขวา  */  
    z-index:999;  
}  
</style>
</head>
<body>
<form  method="post" name="frmuser" id="frmuser"  enctype="multipart/form-data">
<div class="container_box">
    <div id="box">
	<div class="header"><h3>แก้ไข User <?=$re['User_name'];?></h3><!---หัวเรื่องหลัก-->
           <p>
		    <input type="button" value="ข้อมูล User" id="btn_add" onclick="window.location='?page=from_user';" >
		   </p><!---หัวเรื่องรอง-->
		   
	</div><div class="sep"></div>
		<!---เนื้อหา-->
		<table cellpadding="0" cellspacing="0"  border="0">
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		
		<td align="left" width="160px"><B style="color:black;text-align:center;">Username :</B></td>
		<td align="left"><input type="text" id="txtUsername" name ="txtUsername"  value="<?=$re['User_name'];?>">
		<input type="hidden" id="do" name ="do"  value="edit">
		<input type="hidden" id="id" name ="id"  value="<?=$re['User_id'];?>">
		<B style="color:red;text-align:center;">*</B>
		(สำหรับเข้าระบบ) </td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">Password:</B></td>
		<td align="left" valign="top">
		<input type="password" id="txtPass" name ="txtPass" value="<? echo imap_base64(trim($re['User_Pass']));?>">
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<!--  Edit เพิ่ม Salecode   27 Oct 2015  -->
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">Salecode:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtSalecode" name ="txtSalecode" value="<?=$re['Salecode'];?>"/ >
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">ชื่อผู้ใช้:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtName" name ="txtName" value="<?=$re['name'];?>" >
		<B style="color:red;text-align:center;">*</B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">นามสกุล:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtSurname" name ="txtSurname" value="<?=$re['surname'];?>">
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">ประเภทตำแหน่ง:</B></td>
		<td align="left" valign="top">
			<select id="txtType" name="txtType"  style="width:170px;">
				<option value="<?=$re['RoleID'];?>"><?=$re['RoleName'];?></option>
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
			&nbsp;ตำแหน่ง:
			<select id="txtType2" name="txtType2"  style="width:170px;">
				<option value="<?=$re['RoleID_Lineid'];?>"><?=$re['RoleName_Linename'];?></option>
				<option value="">-เลือกประเภทตำแหน่งก่อน-</option>
			</select>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
				<tr><td width="150"><B>คลังที่ผูก</B></td><td>
	<select id="st_warehouse_location" name="st_warehouse_location"  style="width:170px;">
	<option value="<?=$re['warehouse_locationNo'];?>" ><?=$re['locationname'];?> </option>
	<?	$sql="SELECT * FROM st_warehouse_location   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['locationno']?>" ><?print $detail['locationname']?></option>
		
			<?
			}

		
	
	?>
	<option value="" ></option>
	</select>&nbsp;<B style="color:red;text-align:center;"></B>
</td></tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr><td width="150"><B>ประเภทขาย</B></td><td>
	<select id="txt_saletype" name="txt_saletype"  style="width:170px;">
	<option value="<?=$re['st_saletype'];?> " ><?=$re['SaleTypeName'];?> </option>
	<?	$sql="SELECT SaleType,SaleTypeName FROM st_saletype   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['SaleType']?>" ><?print $detail['SaleTypeName']?></option>
		
			<?
			}

		
	
	?>
	<option value="" ></option>
	</select>&nbsp;<B style="color:red;text-align:center;"></B>
</td></tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>

	

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">DC พื้นที่ดูแล:</B></td>
		<td align="left" valign="top">
			<select id="txtDC" name="txtDC"  style="width:170px;">
				<option value="<?=$re['dc_groupid'];?>"><?=$re['dc_groupname'];?></option>
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
				<option value="" ></option>
			</select>
			<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">ชื่อ User AX:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtAx" name ="txtAx" value="<?print $re['UserID_byAX']?>" >
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">ทะเบียนรถ:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtCar_plate" name ="txtCar_plate" value="<?print $re['Car_plate']?>" >
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">เลข imei tablet:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtimei" name ="txtimei" value="<?print $re['talet_no_imei']?>" >
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;"> Mac Printer:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txt_Mac" name ="txt_Mac" value="<?print $re['Pinter_no']?>" >
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
		<? if($re['User_pic']){?>
		<img id="image_band" src="./<?=$re['User_pic'];?>" width="100px" height="100px" >
		<? }else ?><img id="image_band"  >
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		
	<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">เบอร์โทรที่สามารถติดต่อได้:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtphone" name ="txtphone" value="<?print $re['phone']?>"  >
		
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr><td><B>บริษัท</B></td><td>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
	<option value="<?print $re['COMPANYCODE']?>" ><?print $re['COMPANYNAME']?></option>
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
<div id="txt_check" align="center"></div>
<br><br>

</body>
</html>
