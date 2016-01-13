<?////---------------------------------แก้ไข โดย pong 03/07/2015-------------------
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);


if($_GET['do']=="edit")
{
		$code=$_POST['code'];
		$txtITEM=$_POST['txtITEM'];
		$txtITEM_=$_POST['txtITEM_'];
		$txt_type=$_POST['txt_type'];
		$txt_remark=$_POST['txt_remark'];
		$txt_group=$_POST['txt_group'];
		$txt_COMPANY=$_POST['txt_COMPANY'];
		
			$opent1="select prd_type_nm from st_item_type where prd_type_id='$txt_type'  ";
			$opent1 =sqlsrv_query($con,$opent1,$params,$options);
			$op1=sqlsrv_fetch_array($opent1);
			
			$opent2="select prd_grp_nm from st_item_group where prd_grp_id='$txt_group'  ";
			$opent2 =sqlsrv_query($con,$opent2,$params,$options);
			$op2=sqlsrv_fetch_array($opent2);//เข้า tb สินค้า	


		 $sqlUpdate="update st_item_product set PRODUCTNAME='$txtITEM',PRODUCTSHORTNAME='$txtITEM_',
			prd_type_id='$txt_type',prd_type_nm='$op1[prd_type_nm]',prd_grp_id='$txt_group',prd_grp_nm='$op2[prd_grp_nm]'
			,Remark='$txt_remark',Updateby='$USER_id'
			,UpdateDate=GETDATE(),COMPANYCODE='$txt_COMPANY'
			where P_Code='$code' "; 
		$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
			if($qryUpdate)
			  {
				echo "<script type=\"text/javascript\">";
				echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
				echo "window.location='?page=from_item';";
				echo "</script>";
				}
}
else  if($_GET['do']=="del")
{	 
	  $id=$_GET['id'];
	  
		$sqlDel=" delete st_item_product where P_Code='$id' "; //----------ลบในTABLEสินค้า
		$qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
	
		$sqlDe2=" delete st_item_unit_con where P_Code='$id' "; //----------ลบในTABLE หน่วยที่ผูก
		$qryDe2=sqlsrv_query($con,$sqlDe2,$params,$options);
		
		$sqlDe3=" delete st_item_price where P_Code='$id' "; //----------ลบในTABLE ราคาที่ผูก
		$qryDe3=sqlsrv_query($con,$sqlDe3,$params,$options);
		
		$sqlDe4=" delete st_warehouse_stock where P_Code='$id' "; //----------ลบในTABLE Stock คลัง
		$qryDe4=sqlsrv_query($con,$sqlDe4,$params,$options);
		
		$sqlDe5=" delete st_warehouse_sale_stock where P_Code='$id' "; //----------ลบในTABLE Stock ท้ายรถทุกคน
		$qryDe5=sqlsrv_query($con,$sqlDe5,$params,$options);
		

	  $SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	  $qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($qryDel&&$sqlDe2&&$sqlDe3)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบสินค้า เรียบร้อยแล้ว\");";
		echo "window.location='?page=from_item';";
		echo "</script>";
	  }
	
}
else
{
	$txt_type=$_POST['txt_type'];//ประเภทสินค้า
	$txtITEM= $_POST['txtITEM'];//ชื่อสินค้า
	$txtITEM_=$_POST['txtITEM_'];//ชื่อย่อสินค้า
	$txt_group= $_POST['txt_group'];//กลุ่ม
	$txt_unit= $_POST['txt_unit'];//หน่วย
	
	$txt_COMPANY=$_POST['txt_COMPANY'];//บริษัท
	$P_code=$_POST['P_code'];//รหัส
	$txt_remark=$_POST['txt_remark'];//หมายเหตุ
	
			$file = $_FILES['txt_file']['tmp_name'];//เท็มสำหรับการอัพโหลดเก็บที่อยู่ไฟล์ชั่วคราว
			$file_name=$_FILES['txt_file']['name'];//ชื่อไฟล์ที่อัพโหลด
			$file_type=$_FILES['txt_file']['type'];//ประเภทชนิดของไฟล์
			$file_size=$_FILES['txt_file']['size'];//ขนาดไฟล์หน่วยเก็บเป็นไบต์
	$array_last = explode(".", $file_name);//แยกข้อความให้อยู่ในรูปของอะเรย์
			$c = count($array_last)-1;
			$lastname = strtolower($array_last[$c]);//เปลี่ยนอักษรในสติงเป็นอักษรเล็ก
				if ($file_name and($lastname=="gif" or $lastname=="jpg" or $lastname=="jpeg" or $lastname=="png"))//เซฟรูปที่นามสกุลถูก 
				{ 		$fileNew='./imagesItem/'.$P_code.'.jpg';
					unlink($fileNew);
					
					$set_file = explode("." ,$file_name);
					$filenameNew = $P_code;//ชื่อไฟล์ที่ตั้งใหม่
					//$plname = $set_file[1];
					$filenameNew = $filenameNew .".jpg";//รวมชื่อไฟล์กับนามสกุลเข้าด้วยกัน
					 $folder ='./imagesItem/'.$filenameNew;
					copy ($file, $folder);//โพร์เดอร์สำหรับเก็บรูปภาพ
					if (copy($file,$folder)) {//echo "นำ file PDF เข้า Foder แล้ว ";
						$img='imagesItem/'.$P_code.".".jpg;
						echo '<script type="text/javascript">';
						echo 'alert("Save รูป");';
						echo '</script>';
					}
					else{$img='';}
				}
	
	$check =" select P_Code from st_item_product  where P_Code='$P_code' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryCheck=sqlsrv_query($con,$check,$params,$options); // ***check ชื่อย่อ
		$reCheck=sqlsrv_fetch_array($qryCheck);
		if($reCheck){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จ  รหัส นี้ถูกใช้แล้ว!!! ");';
			//echo "window.location='?page=add_item_product';";
			echo '</script>';
		}
	else
	{
	
	
	$opent1="select prd_type_nm from st_item_type where prd_type_id='$txt_type'  ";
	$opent1 =sqlsrv_query($con,$opent1,$params,$options);
	$op1=sqlsrv_fetch_array($opent1);
	
	$opent2="select prd_grp_nm from st_item_group where prd_grp_id='$txt_group'  ";
	$opent2 =sqlsrv_query($con,$opent2,$params,$options);
	$op2=sqlsrv_fetch_array($opent2);
		
	$SQLIn2="insert into st_item_product([P_Code]
      ,[PRODUCTNAME],[PRODUCTSHORTNAME],[ActiveStatus],[PIC_FILENAME],[min_stock]
      ,[count_stock],[prd_type_id],[prd_type_nm],[prd_grp_id],[prd_grp_nm]
      ,[Createby],[Updateby],[CreateDate],[UpdateDate],[COMPANYCODE],[Updatestatus]
      ,[st_unit_id],[Remark])values
	('$P_code','$txtITEM','$txtITEM_','Y','$img','0','0','$txt_type','$op1[prd_type_nm]','$txt_group','$op2[prd_grp_nm]','$USER_id','$USER_id'
	,GETDATE(),GETDATE(),'$txt_COMPANY','1','$txt_unit','$txt_remark')";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);//-----------Add เข้า tb สินค้า
	
	
	$sql3="insert into st_item_unit_con(st_unit_id,st_unit_name,P_Code,st_unit_qty,Createby ,Updateby,CreateDate,UpdateDate)values
	('$txt_unit','$txt_unit','$P_code','1','$USER_id','$USER_id',GETDATE(),GETDATE())";
	$QryIn3 =sqlsrv_query($con,$sql3,$params,$options);//----------Add เข้า tbหน่วย  Converse
	
	$SelectLocation="select locationno from st_warehouse_location ";
	$SelectLocation =sqlsrv_query($con,$SelectLocation);
	while($SeLocation=sqlsrv_fetch_array($SelectLocation))		// ---------------------------เพิ่มสินค้าใหม่ในStock คลัง
		{	$Location=$SeLocation['locationno'];
			$AddWhereHStock="insert into st_warehouse_stock 
							(P_Code,stock_count,status,COMPANYCODE,locationno,locationname,stock_min,Updatestatus)values
							('$P_code','0','Y','$txt_COMPANY','$Location','','0','1')";
			$AddWhereHStock =sqlsrv_query($con,$AddWhereHStock);
		}
	
	$SeleUser ="select User_id from st_user ";
	$SeleUser =sqlsrv_query($con,$SeleUser);
	while($ReUser=sqlsrv_fetch_array($SeleUser))		// ---------------------------เพิ่มสินค้าใหม่ในStock ท้ายรถทุกคน
		{	$User_Sale =$ReUser['User_id'];
			$AddSaleStock="insert into st_warehouse_sale_stock
				(P_Code,wh_stock_qty,status,User_id,Updatestatus) values
				('$P_code','0','A','$User_Sale','1')";
			$AddSaleStock =sqlsrv_query($con,$AddSaleStock);
			
		}
	
	
		
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);

		if($QryIn2&&$qryUp_tbUser)
		{		echo '<script type="text/javascript">';
				echo 'alert("บันทึกเรียบร้อยแล้ว ");';
				echo "window.location='?page=from_item';";
				echo '</script>';
		}
		else
		{
			echo '<script type="text/javascript">';
				echo 'alert("ไม่สำเร็จ ");';
				echo $SQLIn2;
				echo '</script>';
		}
				
	}			
}
?>