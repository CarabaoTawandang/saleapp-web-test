<?//--------------------------------------by pong 11/09/58
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
$params=array();
$options=array( "Scrollable" => SQLSRV_CURSOR_KEYSET);

if($_GET['do']=="edit")
{
$mac__=$_POST['mac__'];

$Serial=$_POST['Serial'];
$mac=$_POST['mac'];
$Manufacturer=$_POST['Manufacturer'];
$Model=$_POST['Model'];
$Warranty=$_POST['Warranty'];
$Supplier=$_POST['Supplier'];
$PO=$_POST['PO'];
$Serial=$_POST['Serial'];
$status=$_POST['status'];
$Receive=$_POST['Receive'];
$Receive_ = date("Y-m-d",strtotime($Receive));
if($Receive_==date("Y-m-d",strtotime('01/01/1970'))){$X=date("Y-m-d");}else{$X=$Receive_;}

$edit_Check=$_POST['edit_Check'];
if($edit_Check!='on'){
			echo '<script type="text/javascript">';
			echo 'alert("บันทึกข้อมูลไม่สำเร็จ ");';
			echo "window.location='?page=from_asset';";
			echo '</script>';
		}else{
		$OPEN=" select *from st_Device_Mobile_Printer where Mac ='$mac__'  ";
		$OPEN=sqlsrv_query($con,$OPEN,$params,$options);
		$OPEN=sqlsrv_fetch_array($OPEN);
		
		$check ="select * from st_Device_Mobile_Printer  where Mac='$mac' and Mac<>'$OPEN[Mac]' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryCheck=sqlsrv_query($con,$check,$params,$options);
		$reCheck=sqlsrv_fetch_array($qryCheck);
		if($reCheck){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จรหัส Serial NO.นี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=from_asset#tabs-2';";
			echo '</script>';
		}
	else{


	$sqlUpdate="update st_Device_Mobile_Printer set Manufacturer='$Manufacturer',Model='$Model'
	,Warranty='$Warranty',PO_No='$PO',Receive_date='$X',Supplier='$Supplier'
	,UpdateDate=GETDATE(),Updateby='$USER_id',Status='$status'
	where Mac='$mac__' ";
	$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
	
	}
	if($qryUpdate)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_asset#tabs-2';";
		echo "</script>";
	  }
	}
	}
else




{
$Serial=$_POST['Serial'];
$mac=$_POST['mac'];
$Manufacturer=$_POST['Manufacturer'];
$Model=$_POST['Model'];
$Warranty=$_POST['Warranty'];
$Supplier=$_POST['Supplier'];
$PO=$_POST['PO'];
$Serial=$_POST['Serial'];
$status=$_POST['status'];
$Receive=$_POST['Receive'];
$Receive_ = date("Y-m-d",strtotime($Receive));
if($Receive_==date("Y-m-d",strtotime('01/01/1970'))){$X=date("Y-m-d");}else{$X=$Receive_;}
		
		$check1 ="select Mac from st_Device_Mobile_Printer  where Mac='$mac' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$check1=sqlsrv_query($con,$check1,$params,$options); 
		$check1=sqlsrv_fetch_array($check1);

		if($check1){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จรหัส Macนี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=from_asset#tabs-2';";
			echo '</script>';
		}
		$check ="select Serial_No from st_Device_Mobile_Printer  where Serial_No='$Serial' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$check=sqlsrv_query($con,$check,$params,$options); 
		$check=sqlsrv_fetch_array($check);

		if($check){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จรหัส Serial numberนี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=from_asset#tabs-2';";
			echo '</script>';
		}
		
		
	else{




$add="insert into st_Device_Mobile_Printer(Serial_No,Manufacturer,Model
      ,Warranty,PO_No,Receive_date,Supplier,Mac
      ,UpdateDate,CreateDate,Updateby,Createby,Status) values
('$Serial','$Manufacturer','$Model'
,'$Warranty','$PO','$X','$Supplier','$mac',GETDATE(),GETDATE()
,'$USER_id','$USER_id','$status')  ";
$add=sqlsrv_query($con,$add,$params,$options);


if($add)
	{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกข้อมูลเรียบร้อยแล้ว ");';
			echo "window.location='?page=add_Mobile_Printer';";
			echo '</script>';
	}
}	
}		?>