<?
//------------------------------------------------------แก้ไข โดย Pong 06/07/2015-----------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =array("Scrollable"=>SQLSRV_CURSOR_KEYSET);



if($_GET['do']=="edit")
{
$id=$_GET['id'];
$name_unit=$_POST['name_unit'];
$txt_COMPANY=$_POST['txt_COMPANY'];
$remark=$_POST['remark'];

$check ="select st_unit_id from st_item_unit  where st_unit_id='$name_unit' and not st_unit_id ='$id'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryCheck=sqlsrv_query($con,$check,$params,$options); // ***check ชื่อย่อ
		$reCheck=sqlsrv_fetch_array($qryCheck);
		if($reCheck){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จชื่อหน่วยของสินค้านี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=from_item';";
			echo '</script>';
		}
else {


	$sqlUpdate="update st_item_unit set st_unit_name='$name_unit',st_unit_id='$name_unit',Remark='$remark',COMPANYCODE='$txt_COMPANY'
	,Updateby='$USER_id'
	,UpdateDate=GETDATE()
	where st_unit_id='$id' ";
	
	$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
	if($qryUpdate)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_item';";
		echo "</script>";
	  }
	}
}

else if($_GET['do']=="del")
{
	  $id=$_GET['id'];
	  $sqlDel="delete st_item_unit where st_unit_id='$id'";
	  $qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
	  
	  $SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	  $qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($qryDel)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_item';";
		echo "</script>";
	  }
	
}

else
{
		
$unit=$_POST['unit'];//หน่วย
$txt_remark=$_POST['txt_remark'];//หมายเหตุ
$txt_COMPANY=$_POST['txt_COMPANY'];//บริษัท
$check ="select st_unit_id from st_item_unit  where st_unit_id='$unit'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryCheck=sqlsrv_query($con,$check,$params,$options); // ***check ชื่อunit
		$reCheck=sqlsrv_fetch_array($qryCheck);
		if($reCheck){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จชื่อหน่วยของสินค้านี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=add_item_unit';";
			echo '</script>';
		}
	
	else{
  $SQLIn2="insert into [st_item_unit] ([st_unit_id]
      ,[st_unit_name]
      ,[Createby]
      ,[Updateby]
      ,[CreateDate]
      ,[UpdateDate]
      ,[Remark]
      ,[COMPANYCODE]
      ,[Updatestatus]) values('$unit','$unit','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_remark','$txt_COMPANY','1')";
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
			
		
		



	

}}
?>