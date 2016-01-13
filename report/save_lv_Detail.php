<?
session_start();
		set_time_limit(0);
		include("../includes/config.php");
		
		$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$user_under = $_POST['user_under'];
$user_id_head =$_POST['user_id_head'];
$txt_COMPANY =$_POST['txt_COMPANY'];

$del1="delete st_user_lv_Detail where user_id_head='$user_id_head'";
		$qrydel1=sqlsrv_query($con,$del1,$params,$options);
		
	foreach ($user_under as $user_unders=>$user_under) 
	{   $user_under; //เอาจังหวัดใน Array $txtPro[] ใส่ใน  Array $ProGet[]
		//echo"<br>";
		$add1="insert into st_user_lv_Detail
		(user_id_head,user_id_detail ,Createby,Updateby,CreateDate,UpdateDate,COMPANYCODE ,Updatestatus)
		values
		('$user_id_head','$user_under' ,'$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','1')";
		$qryadd1=sqlsrv_query($con,$add1,$params,$options);
	}
	if($qryadd1||$qrydel1){
				echo '<script type="text/javascript">';
				echo 'alert("บันทึก User ที่ต้องการผูก เรียบร้อบแล้ว");';
				echo "window.location='?page=from_user';";
				echo '</script>';
				
			}
	else{
				echo '<script type="text/javascript">';
				echo 'alert("ไม่สำเร็จ");';
				echo '</script>';
				
			}
?>