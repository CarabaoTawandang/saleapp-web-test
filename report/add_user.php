<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
	session_start();  //เปิดseeion	
	set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
	include("includes/config.php"); //connect database db.carabao.com
	

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
		
		/*$('#save').click(function(){
					
					if($('#txtUsername').prop('value')=='')  {alert("โปรดใส่Username !");}
					else if($('#txtPass').prop('value')=='')  {alert("โปรดใส่Password  !");}
					else if($('#txtName').prop('value')=='')  {alert("โปรดใส่ชื่อผู้ใช้  !"); }
					else if($('#txtType').prop('value')=='')  {alert("โปรดใส่ตำแหน่ง  !"); }
					
					else {
					$('#txt_check').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/save_user5555.php',
						type:'POST',
						data:$('#frmuser').serialize(),
						success:function(result){
							$('#txt_check').html(result);
							}
					});
					}	
		});*/
		
	







		
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
<form  method="post" name="frmuser" id="frmuser"  enctype="multipart/form-data" action="?page=save_user">
<div class="container_box">
    <div id="box">
	<div class="header"><h3>เพิ่ม User <?=$re['User_name'];?></h3><!---หัวเรื่องหลัก-->
           <p>
		    <input type="button" value="ค้นหา User" id="btn_add" onclick="window.location='?page=from_user';" align="center" >
		   </p><!---หัวเรื่องรอง-->
		   
	</div><div class="sep"></div>
		<!---เนื้อหา-->
		<table cellpadding="0" cellspacing="0"  border="0">
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		<td align="left" width="160px"><B style="color:black;text-align:center;">Username :</B></td>
		<td align="left"><input type="text" id="txtUsername" name ="txtUsername"  required/>
		<B style="color:red;text-align:center;">*</B>
		(สำหรับเข้าระบบ) </td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">Password:</B></td>
		<td align="left" valign="top">
		<input type="password" id="txtPass" name ="txtPass" required/>
		<B style="color:red;text-align:center;">*</B>
		</td>
		</tr>
		<!--  Edit เพิ่ม Salecode   27 Oct 2015  -->
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">Salecode:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtSalecode" name ="txtSalecode"/ >
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>

		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">ชื่อผู้ใช้:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtName" name ="txtName" required/ >
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
		<td align="left" valign="top"><B style="color:black;text-align:center;">ประเภทตำแหน่ง:</B></td>
		<td align="left" valign="top">
			<select id="txtType" name="txtType"  style="width:170px;"required/>
				<option value="">-ประเภทตำแหน่ง-</option>
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
			<select id="txtType2" name="txtType2"  style="width:170px;" >
				<option value="">-เลือกประเภทตำแหน่งก่อน-</option>
			</select>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>


		
		<tr><td width="150"><B>คลังที่ผูก</B></td><td>
	<select id="st_warehouse_location" name="st_warehouse_location"  style="width:170px;">
	<option value="" > - เลือกคลังที่ผูก- </option>
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
	</select>&nbsp;<B style="color:red;text-align:center;"></B>
</td></tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr><td width="150"><B>ประเภทขาย</B></td><td>
	<select id="txt_saletype" name="txt_saletype"  style="width:170px;">
	<option value="" > - เลือกประเภทขาย- </option>
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
	</select>&nbsp;<B style="color:red;text-align:center;"></B>
</td></tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">DC พื้นที่ดูแล:</B></td>
		<td align="left" valign="top">
			<select id="txtDC" name="txtDC"  style="width:170px;">
				<option value="">-เลือกDC-</option>
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
		<td align="left" valign="top"><B style="color:black;text-align:center;">ชื่อ User AX:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtAx" name ="txtAx" >
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">ทะเบียนรถ:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtCar_plate" name ="txtCar_plate"  >
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;">เลข imei tablet:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txtimei" name ="txtimei"  >
		<B style="color:red;text-align:center;"></B>
		</td>
		</tr>
		<tr><td colspan="2" align="left">&nbsp;</td></tr>
		<tr>
		<td align="left" valign="top"><B style="color:black;text-align:center;"> Mac Printer:</B></td>
		<td align="left" valign="top">
		<input type="text" id="txt_Mac" name ="txt_Mac">
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
		<img id="image_band" >
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
<div id="txt_check" align="center"></div>
<br><br>

</body>
</html>
<?
/*

if($_GET['do']=="add")
{echo "TEST ข้อมูล <br>  ";
$sqlMax="select SUBSTRING(max(User_id),3,6) as MaxID from st_user where SUBSTRING(User_id,1,2)='$year'";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
			$reMax=sqlsrv_fetch_array($qryMax);
			$CodeId=$reMax['MaxID']; //รหัสtaxi
			$CodeId=$CodeId+1;
			$CodeId =$year.str_pad($CodeId,4,"0",STR_PAD_LEFT);
		
			$photo = $_FILES['txtpic']['tmp_name'];//เท็มสำหรับการอัพโหลดเก็บที่อยู่ไฟล์ชั่วคราว
			$photo_name=$_FILES['txtpic']['name'];//ชื่อไฟล์ที่อัพโหลด
			$photo_type=$_FILES['txtpic']['type'];//ประเภทชนิดของไฟล์
			$photo_size=$_FILES['txtpic']['size'];//ขนาดไฟล์หน่วยเก็บเป็นไบต์
			$array_last = explode(".", $photo_name);//แยกข้อความให้อยู่ในรูปของอะเรย์
			$c = count($array_last)-1;
			$lastname = strtolower($array_last[$c]);//เปลี่ยนอักษรในสติงเป็นอักษรเล็ก
			if ($photo_name and($lastname=="gif" or $lastname=="jpg" or $lastname=="jpeg" or $lastname=="png"))//เซฟรูปที่นามสกุลถูก 
				{ 	
					$set_photo = explode("." ,$photo_name);
					$pname = "001";//ชื่อไฟล์ที่ตั้งใหม่
					$plname = $set_photo[1];
					$photoname = $pname .".".$plname;//รวมชื่อไฟล์กับนามสกุลเข้าด้วยกัน
					$photoname = $CodeId.".".jpg;//รวมชื่อไฟล์กับนามสกุลเข้าด้วยกัน
					$photoname ='imagesUser/'.$photoname;
					$saveImg=copy ($photo,$photoname);//โพร์เดอร์สำหรับเก็บรูปภาพ
					if ($saveImg) {$img='imagesUser/'.$CodeId.".".jpg;}
					echo $img;
					
				}
}

*/
?>
