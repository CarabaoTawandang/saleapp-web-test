<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$txtRole=$_POST['txtRole'];
$txt_COMPANY=$_POST['txt_COMPANY'];

$do=$_POST['do'];
if($do=="edit")
{
	//echo "EDIT";
	$id=$_POST['id'];
	$sqlUp="update  st_user_rolemaster_head set
		RoleName='$txtRole'
		,Updateby='$USER_id'
		,UpdateDate=GETDATE()
		,COMPANYCODE='$txt_COMPANY'
		where RoleID='$id'";
	$QryUp =sqlsrv_query($con,$sqlUp,$params,$options);
	if($QryUp)
	{
		echo'<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location="?page=from_rolemaster";
				</script>';
	}
	else
	{
		echo'<script type="text/javascript">
					alert("ไม่สำเร็จ ");
			</script>';
		echo $sqlUp;
	}
}
else
{

		$sqlMax="select max(CAST(RoleID AS INT)) as MaxID from st_user_rolemaster_head ";
		$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
		$reMax=sqlsrv_fetch_array($qryMax);
		$CodeId=$reMax['MaxID']; //รหัสMaxID
		 $CodeId=$CodeId+1;//รหัสต่อไป
		//$CodeIdShow =str_pad($CodeId,6,"0",STR_PAD_LEFT);


	 $SQLIn2="insert into st_user_rolemaster_head 
		(RoleID,RoleName,ActiveStatus,Createby ,Updateby,CreateDate,UpdateDate,COMPANYCODE,Updatestatus)values
		('$CodeId','$txtRole','Y','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','1')";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);
		
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
				if($QryIn2)
				{	echo '<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location="?page=from_rolemaster";
					</script>';
				
				}
				else
				{
					echo '<script type="text/javascript">
					alert("ตรวจสอบข้อมูลอีกที");
					</script>';
					echo $SQLIn2;
				}
				
}?>