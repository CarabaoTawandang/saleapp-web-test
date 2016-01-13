<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id				=	$_SESSION["USER_id"];	//รหัสUser

		
		
		$txtUsername= $_POST['txtUsername'];
		$txtPass= $_POST['txtPass'];
		$pwd = base64_encode(trim($_POST["txtPass"]));
		$txtName= $_POST['txtName'];
		$txtSurname= $_POST['txtSurname'];
		$txtType= $_POST['txtType'];
		$txtType2= $_POST['txtType2'];
		$txtLv= $_POST['txtLv'];
		$txtLvMg= $_POST['txtLvMg'];
		$txtLvSale1=$_POST['txtLvSale1'];
		$txtDC= $_POST['txtDC'];
		$Car_plate=$_POST['txtCar_plate'];
		$txtimei =$_POST['txtimei'];
		//$txtphone_sim =$_POST['txtphone_sim'];
		$txt_Mac =$_POST['txt_Mac'];
		$txtphone =$_POST['txtphone'];
		$txt_COMPANY=$_POST['txt_COMPANY'];
		$txtAx=$_POST['txtAx'];
		$do=$_POST['do'];
		$id=$_POST['id'];
		$st_warehouse_location=$_POST['st_warehouse_location'];//คลังที่ผูก
		$txt_saletype = $_POST['txt_saletype'];
		
if($do=="edit")
{//echo $id;
			$photo = $_FILES['txtpic']['tmp_name'];//เท็มสำหรับการอัพโหลดเก็บที่อยู่ไฟล์ชั่วคราว
			$photo_name=$_FILES['txtpic']['name'];//ชื่อไฟล์ที่อัพโหลด
			$photo_type=$_FILES['txtpic']['type'];//ประเภทชนิดของไฟล์
			$photo_size=$_FILES['txtpic']['size'];//ขนาดไฟล์หน่วยเก็บเป็นไบต์
			$array_last = explode(".", $photo_name);//แยกข้อความให้อยู่ในรูปของอะเรย์
			$c = count($array_last)-1;
			$lastname = strtolower($array_last[$c]);//เปลี่ยนอักษรในสติงเป็นอักษรเล็ก
			if ($photo_name and($lastname=="gif" or $lastname=="jpg" or $lastname=="jpeg" or $lastname=="png"))//เซฟรูปที่นามสกุลถูก 
				{ 	$img='./imagesUser/'.$id.'.jpg';
					unlink($img);
					$set_photo = explode("." ,$photo_name);
					$pname = "001";//ชื่อไฟล์ที่ตั้งใหม่
					$plname = $set_photo[1];
					$photoname = $pname .".".$plname;//รวมชื่อไฟล์กับนามสกุลเข้าด้วยกัน
					$photoname = $id.".".jpg;//รวมชื่อไฟล์กับนามสกุลเข้าด้วยกัน
					$photoname ='../imagesUser/'.$photoname;
					copy ($photo, $photoname);//โพร์เดอร์สำหรับเก็บรูปภาพ
					if (copy($photo,$photoname)) {$img='imagesUser/'.$id.".".jpg;}
					
				}
		$sql="update st_user set User_name='$txtUsername'
		,User_Pass='$pwd'
		,name='$txtName'
		,surname='$txtSurname'
		,status='Y'
		,RoleID='$txtType'
		,Updateby='$USER_id'
		,UpdateDate=GETDATE()
		,COMPANYCODE='$txt_COMPANY'
		,dc_groupid='$txtDC'
		,RoleID_Lineid='$txtType2'
		,Updatestatus='1'
		,UserID_byAX='$txtAx'
		,Car_plate='$Car_plate'
		,talet_no_imei='$txtimei'
		,Pinter_no='$txt_Mac'
		,phone='$txtphone' 
		,warehouse_locationNo='$st_warehouse_location'
		,st_saletype='$txt_saletype'
		";
		
		if($img){$sql.=",User_pic='$img'";}
		
		$sql.="where User_id ='$id'";
			
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qry=sqlsrv_query($con,$sql,$params,$options); // ***add st_user
		if($qry){	
				echo '<script type="text/javascript">';
				echo 'alert("แก้ไขเรียบร้อยแล้ว ");';
				echo "window.location='?page=from_user';";
				echo '</script>';
				
			}//if
		else{
				echo '<script type="text/javascript">';
				echo 'alert("ตรวจสอบข้อมูลอีกที");';
				echo '</script>';
				 echo $sql;
			}
				
		
}
		
else
{
		
		$check ="select User_name from st_user where User_name ='$txtUsername'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryCheck=sqlsrv_query($con,$check,$params,$options); // ***check username
		$reCheck=sqlsrv_fetch_array($qryCheck);
		if($reCheck)
		{
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จ username นี้มีผู้ใช้แล้ว!!! ");';
			//echo "window.location='?page=add_user';";
			echo '</script>';
		}
		else
		{
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
					//echo $img;
					
				}
		
		$sql="insert into st_user(User_id,User_name,User_Pass,name,surname,status,RoleID,Createby ,Updateby,CreateDate,UpdateDate
		,COMPANYCODE,dc_groupid,RoleID_Lineid,Updatestatus,Car_plate,talet_no_imei,User_pic,Pinter_no,phone,UserID_byAX,warehouse_locationNo,st_saletype) 
			('$CodeId','$txtUsername','$pwd','$txtName','$txtSurname','Y','$txtType','$USER_id','$USER_id',GETDATE(),GETDATE()
			,'$txt_COMPANY','$txtDC','$txtType2','1','$Car_plate','$txtimei','$img','$txt_Mac','$txtphone','$txtAx','$st_warehouse_location','$txt_saletype')";
			
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qry=sqlsrv_query($con,$sql); // ***add st_user
		
		$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
		$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options); //****update st_user 
		
		
		$sqlProduct="select P_Code, PRODUCTNAME ,st_unit_id from st_item_product where prd_type_id not like 'SV%' and prd_type_id not like 'P%'";
		$qryProduct =sqlsrv_query($con,$sqlProduct,$params,$options);
			while($reP=sqlsrv_fetch_array($qryProduct)){
				$sale_stock="insert into st_warehouse_sale_stock
				(P_Code,wh_stock_qty,status,User_id,st_unit_id,st_unit_name,Updatestatus) values
				('$reP[P_Code]','0','A','$CodeId','$reP[st_unit_id]' ,'$reP[st_unit_id]' ,'1')";
				$qrySale_stock =sqlsrv_query($con,$sale_stock,$params,$options); //*********ตั้งต้น st_warehouse_sale_stock
			}//วน PRODUCT
		
		
		
		if($qry){	
				echo '<script type="text/javascript">';
				echo 'alert("บันทึกเรียบร้อยแล้ว ");';
				//echo "window.location='?page=add_lv_Detail&id=".$CodeId."';";
				echo "window.location='?page=from_user';";
				
				echo '</script>';
				
			}//if
		else{
				echo '<script type="text/javascript">';
				echo 'alert("ตรวจสอบข้อมูลอีกที");';
				echo '</script>';
				 echo $sql;
			}
			
				
				
				
		}//else		
}
		
				?>
				
				

