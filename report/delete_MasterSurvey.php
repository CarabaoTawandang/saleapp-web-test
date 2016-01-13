<?//------------------------------------------------------แก้ไข โดย Pong 17/12/2015-----------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ

if($_GET['do']=="del")
{
$id=$_GET['id'];
	  $sqlDel="delete st_Master_Survey where SurveyID='$id'";
	  $qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
	  
	  $sqlDel_="delete st_Master_Survey_detail where SurveyID='$id'";
	  $qryDel_=sqlsrv_query($con,$sqlDel_,$params,$options);
	  
	  $SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	  $qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($qryDel&&qryDel_)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_Survey';";
		echo "</script>";
	  }
	  
}	  
	  
?>	  