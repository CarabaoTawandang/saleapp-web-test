<?//--------------------------------------by pong 24/09/58
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
$params=array();
$options=array( "Scrollable" => SQLSRV_CURSOR_KEYSET);

if($_GET['do']=="edit"){

$sim_1=$_POST['sim_1'];
$sim_2=$_POST['sim_2'];
$sim_3=$_POST['sim_3'];
$sim_4=$_POST['sim_4'];
$sim_5=$_POST['sim_5'];

$telNo_1=$_POST['telNo_1'];
$telNo_2=$_POST['telNo_2'];
$telNo_3=$_POST['telNo_3'];

$No_1=$_POST['No_1'];
$No_2=$_POST['No_2'];
$No_3=$_POST['No_3'];

$sim=$sim_1.$sim_2.$sim_3.$sim_4.$sim_5;
$tel=$telNo_1.$telNo_2.$telNo_3;
$No=$No_1.$No_2.$No_3;
	
$Y=strlen($tel);	

		$checkTel ="select * from st_Device_PhoneSim  where phone_no='$tel'and phone_no <>'$No' ";
		$checkTel=sqlsrv_query($con,$checkTel,$params,$options); 
		$checkTel=sqlsrv_fetch_array($checkTel);		
		

if($Y!=10){
			echo '<script type="text/javascript">';
			echo 'alert("กรอก เบอร์โทรศัพท์ ไม่ครบ");';
			echo "window.location='?page=edit_Tel&id=$sim';";
			echo '</script>';
		}

if($checkTel){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จ เบอร์โทรศัพท์ นี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=edit_Tel&id=$sim';";
			echo '</script>';
		}
if($Y==10&&!$checkTel){		
	    $add="update st_Device_PhoneSim set phone_no='$tel' where sim_id='$sim' ";
		$add=sqlsrv_query($con,$add,$params,$options);
		if($add)
		{	echo'<script type="text/javascript">';
			echo'alert("บันทึกข้อมูลเรียบร้อยแล้ว ");';
			echo "window.location='?page=from_asset#tabs-5';";
			echo '</script>';
						}
	}else{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกข้อมูลไม่สำเร็จ ");';
			echo "window.location='?page=edit_Tel&id=$sim';";
			echo '</script>';
			}

}
else
{
$sim_1=$_POST['sim_1'];
$sim_2=$_POST['sim_2'];
$sim_3=$_POST['sim_3'];
$sim_4=$_POST['sim_4'];
$sim_5=$_POST['sim_5'];

$telNo_1=$_POST['telNo_1'];
$telNo_2=$_POST['telNo_2'];
$telNo_3=$_POST['telNo_3'];

$sim=$sim_1.$sim_2.$sim_3.$sim_4.$sim_5;
$tel=$telNo_1.$telNo_2.$telNo_3;

$X=strlen($sim);		
$Y=strlen($tel);	

		$checksim ="select * from st_Device_PhoneSim  where sim_id='$sim' ";
		$checksim=sqlsrv_query($con,$checksim,$params,$options); 
		$checksim=sqlsrv_fetch_array($checksim);
		
		$checkTel ="select * from st_Device_PhoneSim  where phone_no='$tel'";
		$checkTel=sqlsrv_query($con,$checkTel,$params,$options); 
		$checkTel=sqlsrv_fetch_array($checkTel);		
		
if($X!=19){
			echo '<script type="text/javascript">';
			echo 'alert("กรอก Sim No. ไม่ครบ");';
			echo "window.location='?page=add_Tel';";
			echo '</script>';
		}
if($Y!=10){
			echo '<script type="text/javascript">';
			echo 'alert("กรอก เบอร์โทรศัพท์ ไม่ครบ");';
			echo "window.location='?page=add_Tel';";
			echo '</script>';
		}
if($checksim){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จรหัส Sim No. นี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=add_Tel';";
			echo '</script>';
		}
if($checkTel){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จ เบอร์โทรศัพท์ นี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=add_Tel';";
			echo '</script>';
		}

if($X==19&&$Y==10&&!$checksim&&!$checkTel){		
		$add="insert into st_Device_PhoneSim(phone_no,sim_id) values('$tel','$sim') ";
		$add=sqlsrv_query($con,$add,$params,$options);
		if($add)
		{	echo'<script type="text/javascript">';
			echo'alert("บันทึกข้อมูลเรียบร้อยแล้ว ");';
			echo "window.location='?page=from_asset#tabs-5';";
			echo '</script>';
						}
	}else{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกข้อมูลไม่สำเร็จ ");';
			echo "window.location='?page=add_Tel';";
			echo '</script>';
			}

}
		?>