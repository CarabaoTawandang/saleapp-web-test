
<?//------------------------------------------------------แก้ไข โดย PONG 25/06/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =array("Scrollable"=>SQLSRV_CURSOR_KEYSET);

$pass_old = base64_encode(trim($_POST["pass_old"]));
$pass_new = base64_encode(trim($_POST["pass_new"]));
$pass_complete = base64_encode(trim($_POST["pass_complete"]));
$name_ =$_POST['name_'];
$name_s =$_POST['name_s'];

	
$check_pass_old="select * from st_user where User_id='$USER_id' ";
$check_pass_old=sqlsrv_query($con,$check_pass_old,$params,$options);
$check_pass_old=sqlsrv_fetch_array($check_pass_old);

$pass = $check_pass_old['User_Pass'];

if($pass_old==$pass){
	if($pass_new==$pass_complete){
	
	
	$Update="update st_user set 
      User_Pass='$pass_new'
      ,name='$name_'
      ,surname='$name_s'
	  ,Updateby='$USER_id'
	  ,UpdateDate=GETDATE()
	where User_id='$USER_id' ";
	
	$Update=sqlsrv_query($con,$Update,$params,$options);
	if($Update)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=fromOriginal';";
		echo "</script>";
	  }
	}else{
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ใส่รหัสผ่านไม่ตรงกัน\");";
		echo "window.location='?page=Privacy_settings';";
		echo "</script>";
		}

} else  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ใส่รหัสผ่านเก่าผิด\");";
		echo "window.location='?page=Privacy_settings';";
		echo "</script>";
		}	
		




?>