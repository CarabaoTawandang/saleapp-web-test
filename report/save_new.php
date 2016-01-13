<?//--------------------------------------pong 10/7/58
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
$params=array();
$options=array( "Scrollable" => SQLSRV_CURSOR_KEYSET);

if($_GET['do']=="edit")
{
$id_new=$_POST['id_new'];//รหัสข่าว
$name_new=$_POST['name_new'];//ชื่อเรื่อง
$txt_day=$_POST['txt_day'];//วันที่ของข่าว
$txt_day1=$_POST['txt_day1'];//วันที่สิ้นสุด
$remark=$_POST['remark'];//รายละเอียด
$txt_COMPANY=$_POST['txt_COMPANY'];


	$sqlUpdate=" update  st_message_new set 
	Subject='$name_new',Remark='$remark'
	,DateFrom='$txt_day' ,DateTo='$txt_day1' ,Updateby='$USER_id' ,UpdateDate=GETDATE() 
	,COMPANYCODE='$txt_COMPANY'
 where Code='$id_new' ";
	$eiei=sqlsrv_query($con,$sqlUpdate,$params,$options);
	
	$sqlDel=" delete st_message_new_detail where Code ='$id_new' ";
	$QryDel =sqlsrv_query($con,$sqlDel,$params,$options);
	
	$txtType = $_POST['txtType'];	
	foreach ($txtType as $txtTypes=>$txtType) 
	{   $txtType; 
		$SQLIn1="insert into st_message_new_detail 
		([Code],[RoleID_Lineid])values
		('$id_new','$txtType')";
		$QryIn1 =sqlsrv_query($con,$SQLIn1,$params,$options);
	}
	
	if($eiei&&$QryDel)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_new';";
		echo "</script>";
	  }
	
}

else if($_GET['do']=="del")
{
	  $id=$_GET['id'];
	  $sqlDel="delete st_message_new where Code='$id'";
	  $qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
	  
	  $sqlDel="delete st_message_new_detail where Code='$id'";
	  $qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
	  
	  $SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	  $qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($qryDel)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_new';";
		echo "</script>";
	  }
	
}

else
{
$txtnew=$_POST['txtnew'];
$txt_day=$_POST['txt_day'];
$txt_day1=$_POST['txt_day1'];
$remark=$_POST['remark'];

$txt_COMPANY=$_POST['txt_COMPANY'];

 $sql1="select max(substring( Code,4,5)) as MAXID from st_message_new 
where substring( Code,1,2) ='$year' "; //หาค่า  ID__ สูงสุด
	$sql1 =sqlsrv_query($con,$sql1,$params,$options);
	$re1=sqlsrv_fetch_array($sql1);
	$MAXID =$re1['MAXID'];//รหัส ID__
	$MAXID=$MAXID+1;
    $CODE="".str_pad($MAXID,5, "0", STR_PAD_LEFT);
	
	$code =$year."-".$CODE;
	

		
	$SQLIn1="insert into st_message_new 
		([Code],[Subject]
      ,[Remark]
      ,[DateFrom]
      ,[DateTo]
      ,[Createby]
      ,[Updateby]
      ,[CreateDate]
      ,[UpdateDate]
      ,[COMPANYCODE])values
		('$code','$txtnew','$remark','$txt_day','$txt_day1','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY')";
	$QryIn1 =sqlsrv_query($con,$SQLIn1,$params,$options);

	$txtType = $_POST['txtType'];
foreach ($txtType as $txtTypes=>$txtType) 
	{   $txtType; 
		
	$SQLIn2="insert into st_message_new_detail 
		([Code],[RoleID_Lineid])values
		('$code','$txtType')";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);
	}
		
 
		
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);

		if($SQLIn2&&$qryUp_tbUser)
	  {?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=from_new';
				</script>
				<?
			}
			}
			
			?>