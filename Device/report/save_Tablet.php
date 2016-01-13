<?//--------------------------------------by pong 11/09/58
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
$params=array();
$options=array( "Scrollable" => SQLSRV_CURSOR_KEYSET);




if($_GET['do']=="edit")
{
$id=$_GET['id'];
$IMEI=$_POST['IMEI'];
$IMEI__=$_POST['IMEI__'];
$Serial=$_POST['Serial'];
$Serial__=$_POST['Serial__'];
$SIM=$_POST['SIM'];
$PO=$_POST['PO'];

$Manufacturer=$_POST['Manufacturer'];
$Type=$_POST['Type'];
$RAM=$_POST['RAM'];
$Memory=$_POST['Memory'];
$size_M=$_POST['size_M'];
$Warranty=$_POST['Warranty'];
$Model_num=$_POST['Model_num'];
$Supplier=$_POST['Supplier'];

$Receive=$_POST['Receive'];
$Receive_ = date("Y-m-d",strtotime($Receive));
$status=$_POST['status'];
$remark=$_POST['remark'];

$edit_Check=$_POST['edit_Check'];
if($edit_Check!='on'){
			echo '<script type="text/javascript">';
			echo 'alert("บันทึกข้อมูลไม่สำเร็จ ");';
			echo "window.location='?page=from_asset#tabs-1';";
			echo '</script>';
		}else{
		$OPEN="select *from st_device_tablet_detail where Serial_number ='$Serial__'  ";
		$OPEN=sqlsrv_query($con,$OPEN,$params,$options);
		$OPEN=sqlsrv_fetch_array($OPEN);
		
		$OPEN1="select *from st_device_tablet_detail where imei ='$IMEI__'  ";
		$OPEN1=sqlsrv_query($con,$OPEN1,$params,$options);
		$OPEN1=sqlsrv_fetch_array($OPEN1);
		
		$check2 ="select * from st_device_tablet_detail  where imei='$IMEI' and imei<>'$OPEN1[imei]' ";
		$check2=sqlsrv_query($con,$check2,$params,$options); 
		$check2=sqlsrv_fetch_array($check2);
		if($check2){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จรหัส IMEI นี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=from_asset#tabs-1';";
			echo '</script>';
		}
	    $check ="select * from st_device_tablet_detail  where Serial_number='$Serial' and Serial_number<>'$OPEN[Serial_number]' ";
		$check=sqlsrv_query($con,$check,$params,$options); 
		$check=sqlsrv_fetch_array($check);
		if($check){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จรหัส Serial NO.นี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=from_asset#tabs-1';";
			echo '</script>';
		}
		
	else{

	$sqlUpdate="update st_device_tablet_detail set warranty='$Warranty'
    ,po_num='$PO',receive_date='$Receive_',supplier='$Supplier'
	,UpdateDate=GETDATE(),UpdateBy='$USER_id',Status='$status',Remark='$remark'
	where imei='$IMEI__' ";
	$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
	
	
	if($qryUpdate)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_asset#tabs-1';";
		echo "</script>";
	  }
	}
}
}else

{
$IMEI=$_POST['IMEI'];
$Serial=$_POST['Serial'];
$SIM=$_POST['SIM'];
$PO=$_POST['PO'];

$Model_num=$_POST['Model_num'];
$Manufacturer=$_POST['Manufacturer'];

$Type=$_POST['Type'];
$RAM=$_POST['RAM'];
$Memory=$_POST['Memory'];
$size_M=$_POST['size_M'];
$Warranty=$_POST['Warranty'];

$Supplier=$_POST['Supplier'];
$status=$_POST['status'];
$remark=$_POST['remark'];

$Receive=$_POST['Receive'];
$Receive_ = date("Y-m-d",strtotime($Receive));
if($Receive_==date("Y-m-d",strtotime('01/01/1970'))){$X=date("Y-m-d");}else{$X=$Receive_;}

		$check1 ="select imei from st_device_tablet_detail  where imei='$IMEI' ";
		$check1=sqlsrv_query($con,$check1,$params,$options); 
		$check1=sqlsrv_fetch_array($check1);

		if($check1){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จรหัส IMEI นี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=add_Tablet';";
			echo '</script>';
		}
		$check ="select serail_number from st_device_tablet_detail  where serail_number='$Serial' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$check=sqlsrv_query($con,$check,$params,$options); 
		$check=sqlsrv_fetch_array($check);

		if($check){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จรหัส Serial numberนี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=add_Tablet';";
			echo '</script>';
		}
		
else{


$add="insert into st_device_tablet_detail(imei,Manufacturer,model_num
,serail_number,ram,memory,memory_available,sim_id
,po_num,supplier,warranty
,receive_date,UpdateDate,UpdateBy,CreateDate
,CreateBy,Status,Remark) values
('$IMEI','$Manufacturer','$Model_num'
,'$Serial','$RAM','$Memory','$size_M','$SIM'
,'$PO','$Supplier','$Warranty'
,'$X',GETDATE(),'$USER_id',GETDATE()
,'$USER_id','$status','$remark') ";
$add=sqlsrv_query($con,$add,$params,$options);


	
if($add)
	{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกข้อมูลเรียบร้อยแล้ว ");';
			echo "window.location='?page=from_asset&page__=1&C=50&A=all#tabs-1';";
			echo '</script>';
	}else{echo $add;}
}	
}
		?>