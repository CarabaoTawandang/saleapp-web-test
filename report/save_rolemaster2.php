<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$txt_Role=$_POST['txt_Role'];//ตำแหน่งหลัก
$txtRole= $_POST['txtRole'];//ชื่อตำแหน่งย่อย
$txt_COMPANY=$_POST['txt_COMPANY'];//บริษัท
$st_warehouse_location=$_POST['st_warehouse_location'];//คลังที่ผูก


$do=$_POST['do'];
if($do=="edit")
{
	//echo "EDIT";
	$id=$_POST['id'];
	$sqlUp="update  st_user_rolemaster_detail set
		RoleID='$txt_Role'
		,ActiveStatus='Y'
		,Updateby ='$USER_id'
		,UpdateDate = GETDATE()
		,COMPANYCODE = '$txt_COMPANY'
		,RoleName_Linename = '$txtRole'
		,Updatestatus = '1'
		,warehouse_locationNo = '$st_warehouse_location'
		where RoleID_Lineid='$id'";
	$QryUp =sqlsrv_query($con,$sqlUp,$params,$options);
	
	$sqlDel="delete st_user_rolemaster_head_type where RoleID ='$id' ";
	$QryDel =sqlsrv_query($con,$sqlDel,$params,$options);
	
	$txtType = $_POST['txtType'];	
	foreach ($txtType as $txtTypes=>$txtType) 
	{   $txtType; 
		$SQLIn1="insert into st_user_rolemaster_head_type 
		(RoleID,ActiveStatus,Createby ,Updateby,CreateDate,UpdateDate,cust_type_id ,Updatestatus)values
		('$id','Y','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txtType' ,'1')";
		$QryIn1 =sqlsrv_query($con,$SQLIn1,$params,$options);
	}
	
	if($QryUp&&$sqlUp)
	{
		echo'<script type="text/javascript">
					alert("แก้ไขเรียบร้อยแล้ว ");
					window.location="?page=from_rolemaster";
				</script>';
	}
	else
	{
		echo'<script type="text/javascript">
					alert("ไม่สำเร็จ ");
			</script>';
		
	}
}
else
{
		 $sqlMax="select max(RoleID_Lineid) as MaxID from st_user_rolemaster_detail where RoleID ='$txt_Role'";
		$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
		$reMax=sqlsrv_fetch_array($qryMax);
		$CodeId=$reMax['MaxID']; //รหัสMaxID
		$MaxID = explode("_",$CodeId);
		$MaxID= $MaxID[1];
		$MaxID=$MaxID+1;
		
		$RoleID_Lineid=$txt_Role."_".$MaxID;//รหัสตำแหน่งย่อย
		//$CodeIdShow =str_pad($CodeId,6,"0",STR_PAD_LEFT);

	$txtType = $_POST['txtType'];
	foreach ($txtType as $txtTypes=>$txtType) 
	{   $txtType; 
		$SQLIn1="insert into st_user_rolemaster_head_type 
		(RoleID,ActiveStatus,Createby ,Updateby,CreateDate,UpdateDate,cust_type_id ,Updatestatus)values
		('$RoleID_Lineid','Y','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txtType' ,'1')";
		$QryIn1 =sqlsrv_query($con,$SQLIn1,$params,$options);
	}

	 $SQLIn2="insert into st_user_rolemaster_detail 
		(RoleID,ActiveStatus,Createby ,Updateby,CreateDate,UpdateDate,COMPANYCODE,RoleID_Lineid,RoleName_Linename,Updatestatus,warehouse_locationNo)values
		('$txt_Role','Y','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','$RoleID_Lineid','$txtRole','1','$st_warehouse_location')";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);
		
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);

	if($SQLIn2&&$qryUp_tbUser){	?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=from_rolemaster';
				</script>
				<?
			}//if
				else{?>
						<script type="text/javascript">
							alert("ตรวจสอบข้อมูลอีกที");
						</script>
				<? echo $SQLIn1;
				}
}
				?>