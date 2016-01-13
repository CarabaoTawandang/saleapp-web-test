<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
if($_POST['txt_AddressNum2'])
{$txt_AddressNum = trim($_POST['txt_AddressNum1'])."/".trim($_POST['txt_AddressNum2']);//บ้านเลขที่
}else
{
$txt_AddressNum = trim($_POST['txt_AddressNum1']);
}
$txt_AddressNum; // บ้านเลขที่
$txt_AddressMu = trim($_POST['txt_AddressMu']);//หมู๋
$txt_geo = trim($_POST['txt_geo']); //code ภาค
$txt_pro = trim($_POST['txt_pro']);//------------code จังหวัด
$txt_aum =trim($_POST['txt_aum']);//code อำเภอ
$txt_dis = trim($_POST['txt_dis']);//code ตำบล
$txt_zip2 = trim($_POST['txt_zip2']);//รหัสโปรษณีย์
$txt_custType =$_POST['txt_custType'];//-----------ประเภทร้าน
$txt_custgroup =$_POST['txt_custgroup'];

$txt_name =$_POST['txt_name'];
$txt_Phone=$_POST['txt_Phone'];
$txt_idCust = $_POST['txt_idCust'];
$sqlCheck ="select CustNum from st_cust where AddressNum='$txt_AddressNum' and AddressMu='$txt_AddressMu'  
and PROVINCE_CODE='$txt_pro' and AMPHUR_CODE='$txt_aum' and DISTRICT_CODE='$txt_dis'";
$qryCheck=sqlsrv_query($con,$sqlCheck,$params,$options);
$reCheck=sqlsrv_fetch_array($qryCheck);

$sqlCheck2 ="select CustNum from st_cust where CustNum='$txt_idCust' ";
$qryCheck2=sqlsrv_query($con,$sqlCheck2,$params,$options);
$reCheck2=sqlsrv_fetch_array($qryCheck2);

if($reCheck){//echo "ที่อยู่ซ้ำ!!!";
			echo'<script type="text/javascript">';
			echo'alert("ไม่สำเร็จ ที่อยู่ซ้ำ!!! ");';
			//echo "window.location='?page=data_receive_head&receive_no=$MaxID';";
			echo '</script>';
			//echo $sqlSave;
}
else if($reCheck2)
{//echo "ที่อยู่ซ้ำ!!!";
			echo'<script type="text/javascript">';
			echo'alert("ไม่สำเร็จ รหัสร้านซ้ำ!!! ");';
			//echo "window.location='?page=data_receive_head&receive_no=$MaxID';";
			echo '</script>';
			//echo $sqlSave;
}
else
{
	if($txt_custType =='V' or $txt_custType =='S')
	{
		$sqlMax="select SUBSTRING(max(CustNum),5,5) as MaxID from st_cust
		where  CustNum like '$txt_custType%' and  SUBSTRING(CustNum,2,2) ='$txt_pro'";
		$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
		$reMax=sqlsrv_fetch_array($qryMax);
		$MaxID=$reMax['MaxID']; 
		$MaxID= $MaxID+1;
		$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
		 $MaxID =$txt_custType.$txt_pro."-".$MaxID ; //----------------------ID CODE 
 
		 $sqlSave="insert into st_cust
		 (CustNum ,CustName,Phone,AddressNum,AddressMu,DISTRICT_CODE,AMPHUR_CODE,PROVINCE_CODE,zipcode,Createby,Updateby,CreateDate,UpdateDate,CustStatus,GEO_ID,cust_group_id,cust_type_id)
		 values
		 ('$MaxID' ,'$txt_name','$txt_Phone','$txt_AddressNum','$txt_AddressMu','$txt_dis','$txt_aum','$txt_pro','$txt_zip2','$USER_id','$USER_id',GETDATE(),GETDATE(),'Y','$txt_geo','$txt_custgroup','$txt_custType')
		 ";
		 $qrySave=sqlsrv_query($con,$sqlSave,$params,$options);
	}
	else if($txt_custType !='V' or $txt_custType !='S')
	{
			$sqlSave="insert into st_cust
		 (CustNum ,CustName,Phone,AddressNum,AddressMu,DISTRICT_CODE,AMPHUR_CODE,PROVINCE_CODE,zipcode,Createby,Updateby,CreateDate,UpdateDate,CustStatus,GEO_ID,cust_group_id,cust_type_id)
		 values
		 ('$txt_idCust' ,'$txt_name','$txt_Phone','$txt_AddressNum','$txt_AddressMu','$txt_dis','$txt_aum','$txt_pro','$txt_zip2','$USER_id','$USER_id',GETDATE(),GETDATE(),'Y','$txt_geo','$txt_custgroup','$txt_custType')
		 ";
		 $qrySave=sqlsrv_query($con,$sqlSave,$params,$options);
	}
 
 
 
 if($qrySave)
 {
	echo'<script type="text/javascript">';
	echo'alert("บันทึกเรียบร้อยแล้ว ");';
	echo "window.location='?page=from_cust';";
	echo '</script>';
 }
 else 
 {
	echo'<script type="text/javascript">';
	echo'alert("ไม่สำเร็จ!!!!! ");';
	echo '</script>';
	echo $sqlSave;
 }
}
?>