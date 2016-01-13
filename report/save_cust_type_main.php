<?
//------------------------------------------------------แก้ไข โดย PONG 01/07/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);


if($_GET['do']=="edit")
{
$id__=$_POST['id__'];
$name__=$_POST['name__'];
$txt_COMPANY=$_POST['txt_COMPANY'];

	$sqlUpdate="update st_cust_type set cust_type_name='$name__',Updateby='$USER_id',COMPANYCODE='$txt_COMPANY'
	,UpdateDate=GETDATE()
	where cust_type_id='$id__'";
	
	$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
	if($qryUpdate)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_cust_type';";
		echo "</script>";
	  }
	
}
else if($_GET['do']=="del")
{	 
	  $id=$_GET['id'];
	  $sqlDel="delete st_cust_type where cust_type_id='$id'";
	  $qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
	  $sqlDel1="delete  st_cust_group  where cust_type_id='$id'";
	  $qryDel1=sqlsrv_query($con,$sqlDel1,$params,$options);

	  $SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	  $qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($qryDel&&$sqlDel1)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบประเภทร้านค้าหลักและร้านค้าย่อย เรียบร้อยแล้ว\");";
		echo "window.location='?page=from_cust_type';";
		echo "</script>";
	  }
	
}
else{
$txtCUST=$_POST['txtCUST'];   //รับชื่อร้านค้า
$txt_cust=$_POST['txt_cust']; //รับชื่อย่อ
$txt_COMPANY=$_POST['txt_COMPANY']; //รับรหัสบริษัท
	
	
	$check ="select cust_type_id from st_cust_type  where cust_type_id='$txt_cust'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryCheck=sqlsrv_query($con,$check,$params,$options); // ***check ชื่อย่อ
		$reCheck=sqlsrv_fetch_array($qryCheck);
		if($reCheck){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จชื่อย่อประเภทร้านค้านี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=add_cust_type_main';";
			echo '</script>';
		}
else{
	
		
		
	$SQLIn2="insert into st_cust_type(cust_type_name,cust_type_id,Createby,Updateby,CreateDate
	,UpdateDate,COMPANYCODE,Updatestatus)values
	('$txtCUST','$txt_cust','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','1')";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);
	
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);

		if($QryIn2&&$qryUp_tbUser)
	  {?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=from_cust_type';
				</script>
				<?
			}
				
				}
}				?>