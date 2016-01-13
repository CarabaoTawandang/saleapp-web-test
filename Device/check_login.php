<?//	//------------------------------------------------------------------สร้างโดย Numphung(น้ำผึ้ง) ปี2557
session_start();  //เปิดseeion	
	set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
	include("../includes/config.php"); //connect database db.carabao.com
	ini_set('session.gc_maxlifetime', 3600); //การกำหนดค่า Session Timeout

	
		
		$pwd = base64_encode(trim($_POST["txt_pwd"]));
		$username	= trim($_POST['txt_username']);
		
		$sql2="SELECT  *  ";
		$sql2.="FROM st_user  ";
		$sql2.="where User_name='$username' and User_Pass='$pwd'  ";
		 //echo $sql2;
		
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qry2=sqlsrv_query($con,$sql2,$params,$options);
		$row2=sqlsrv_num_rows($qry2);	
		$detail2=sqlsrv_fetch_array($qry2);
		
		if($row2>=1)
		{
			$_SESSION["USER_name"] = $detail2['User_name'];		//username เข้าระบบ
			$_SESSION["NAME"]=$detail2['name'];			//ชื่อของUser
			$_SESSION["USER_id"]=$detail2['User_id'];			//รหัสUser
			$_SESSION["RoleID"] = $detail2['RoleID'];		//ตำแหน่ง
			echo "<script type='text/javascript'>";
			echo "location='index.php?page=fromOriginal';";
			echo "</script>";
		
		}
		else
		{
			echo '<script type="text/javascript">';
			echo 'alert("ตรวจสอบชื่อผู้ใช้และรหัสชื่อผู้ใช้งานใหม่");';
			echo "location='index.php';";
			echo '</script>';
		}
	
	?>