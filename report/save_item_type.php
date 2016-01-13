<?
//------------------------------------------------------แก้ไข โดย PONG 15/07/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);


if($_GET['do']=="edit")
{
$id_=$_POST['id_'];
$name_=$_POST['name_'];
$remark=$_POST['remark'];
$txt_COMPANY=$_POST['txt_COMPANY'];
	$sqlUpdate="update st_item_type set 
	prd_type_nm='$name_'
	,Remark='$remark'
	,COMPANYCODE='$txt_COMPANY'
	,Updateby='$USER_id'
	,UpdateDate=GETDATE()
	where prd_type_id='$id_'";
	
	$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
	if($qryUpdate)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_item';";
		echo "</script>";
	  }
	
}
else if($_GET['do']=="del")
{	 
	  $id=$_GET['id'];
	  $sqlDel="delete st_item_type where prd_type_id='$id'";
	  $qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
	  $sqlDel1="delete  st_item_product where prd_type_id='$id'";
	  $qryDel1=sqlsrv_query($con,$sqlDel1,$params,$options);

	  $SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	  $qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($qryDel&&$sqlDel1)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบประเภทสินค้าและสินค้า เรียบร้อยแล้ว\");";
		echo "window.location='?page=from_item';";
		echo "</script>";
	  }
	
}
else{
$txtITEM=$_POST['txtITEM'];   //รับชื่อประเภท
$txt_ITEM=$_POST['txt_ITEM']; //รับชื่อย่อ
$txt_COMPANY=$_POST['txt_COMPANY']; //รับรหัสบริษัท
$txt_remark=$_POST['txt_remark']; //รับหมายเหตุ
	
	$check ="select prd_type_id from st_item_type  where prd_type_id='$txt_ITEM'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryCheck=sqlsrv_query($con,$check,$params,$options); // ***check ชื่อย่อ
		$reCheck=sqlsrv_fetch_array($qryCheck);
		if($reCheck){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จชื่อย่อประเภทร้านค้านี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=add_item_type';";
			echo '</script>';
		}
else{
	
		
		
	$SQLIn2="insert into st_item_type(prd_type_id,prd_type_nm,Createby,Updateby,CreateDate
	,UpdateDate,Remark,COMPANYCODE,Updatestatus)values
	('$txt_ITEM','$txtITEM','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_remark','$txt_COMPANY','1')
	";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);
	
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);

		if($QryIn2&&$qryUp_tbUser)
	  {?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=from_item';
				</script>
				<?
			}
				
				}
}			?>