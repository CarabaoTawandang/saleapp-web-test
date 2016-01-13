<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);

if($_GET['do']=="edit")
{
	$id=$_POST['id_location'];
	$txt_locationname=$_POST['txt_locationname'];
	$txt_detail=$_POST['txt_detail'];
	$Phonenumber =$_POST['Phonenumber'];
	$AddressNum =$_POST['AddressNum'];
	$AddressMu =$_POST['AddressMu'];
	$txt_pro =$_POST['txt_pro'];
	$txt_aum =$_POST['txt_aum'];
	$txt_dis =$_POST['txt_dis'];
	$txt_AX=$_POST['txt_AX'];
	$txt_COMPANY =$_POST['txt_COMPANY'];
	$Branch=$_POST['Branch'];
	$TAX=$_POST['TAX'];
	$txt_ACC=$_POST['txt_ACC'];
		$zipcodes="SELECT * FROM dc_zipcodes where DISTRICT_CODE ='$txt_dis' ";
		$zipcodes=sqlsrv_query($con,$zipcodes,$params,$options);
		$zipcodes=sqlsrv_fetch_array($zipcodes);	

	$sqlUpdate="update st_warehouse_location set 
	locationname='$txt_locationname'
	,Updateby='$USER_id'
	,UpdateDate=GETDATE()
	,Remark='$txt_detail'
	,Updatestatus='1'
	,locationAx ='$txt_AX'
	,Phone='$Phonenumber',AddressNum='$AddressNum',DISTRICT_CODE='$txt_dis',AMPHUR_CODE='$txt_aum'
	,PROVINCE_CODE='$txt_pro',zipcode='$zipcodes[zipcode]',AddressMu='$AddressMu',Companyname='$txt_COMPANY',Tax_ID='$TAX',Branch='$Branch',Acc_Doc='$txt_ACC'
	where locationno='$id' ";
	$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
	if($qryUpdate)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_warehouse_location';";
		echo "</script>";
	  }
	
}

else if($_GET['do']=="del")
{
	  $id=$_GET['id'];
	  $sqlDel="delete st_warehouse_location where locationno='$id'";//ลบคลัง
	  $qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
	  
	  $sqlDel2="delete st_warehouse_stock where locationno='$id'";//ลบ Stock ในคลัง
	  $qryDel2=sqlsrv_query($con,$sqlDel2,$params,$options);
	  
	  $opent1="select receive_no from st_warehouse_stock_receive_head where receive_locationno='$id'";//เปิดใบรับของเข้าคลังหลัก
	  $opent1=sqlsrv_query($con,$opent1,$params,$options);
	  while($opent1=sqlsrv_fetch_array($opent1))
	  {
		  $sqlDel3="delete st_warehouse_stock_receive_detail where receive_no='$opent1[receive_no]'";//ลบใบรับของเข้าคลัง detail
		  $qryDel3=sqlsrv_query($con,$sqlDel3,$params,$options);
	  }
	  
	  $sqlDel4="delete st_warehouse_stock_receive_head where receive_locationno='$id'";//ลบใบรับของเข้าคลังหลัก
	  $qryDel4=sqlsrv_query($con,$sqlDel4,$params,$options);
	  
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($qryDel)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_warehouse_location';";
		echo "</script>";
	  }
	
}

else
{
$txt_locationname=$_POST['txt_locationname'];
$txt_detail= $_POST['txt_detail'];
$txt_COMPANY =$_POST['txt_COMPANY'];
$TAX=$_POST['TAX'];
		$sqlMax="select max(locationno) as MaxID from st_warehouse_location ";
		$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
		$reMax=sqlsrv_fetch_array($qryMax);
		$CodeId=$reMax['MaxID']; //รหัสMaxID
		$MaxID = explode("W",$CodeId);
		$MaxID= $MaxID[1]+1;
		$CodeIdShow =str_pad($MaxID,4,"0",STR_PAD_LEFT);
		$locationno ="W".$CodeIdShow ;
$Phonenumber =$_POST['Phonenumber'];
$AddressNum =$_POST['AddressNum'];
$AddressMu =$_POST['AddressMu'];
$txt_pro =$_POST['txt_pro'];
$txt_aum =$_POST['txt_aum'];
$txt_dis =$_POST['txt_dis'];
$txt_AX=$_POST['txt_AX'];
$Branch=$_POST['Branch'];
$txt_ACC=$_POST['txt_ACC'];
		$zipcodes="SELECT * FROM dc_zipcodes where DISTRICT_CODE ='$txt_dis' ";
		$zipcodes=sqlsrv_query($con,$zipcodes,$params,$options);
		$zipcodes=sqlsrv_fetch_array($zipcodes);


	$SQLIn2="insert into st_warehouse_location (locationno,locationname,Createby,Updateby,CreateDate,UpdateDate,Remark,
	Phone,AddressNum,DISTRICT_CODE,AMPHUR_CODE,PROVINCE_CODE,zipcode,AddressMu,Companyname,Updatestatus,locationAx,Tax_ID,Branch,Acc_Doc)values
	('$locationno','$txt_locationname','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_detail',
	'$Phonenumber','$AddressNum','$txt_dis','$txt_aum','$txt_pro','$zipcodes[zipcode]','$AddressMu','$txt_COMPANY','1','$txt_AX','$TAX','$Branch','$txt_ACC')";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);
		
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	//P_Code,stock_count,status,COMPANYCODE,locationno,locationname,stock_min,Updatestatus
	 //FROM SALES_DB.dbo.st_warehouse_stock
	$sqlProduct="select P_Code, PRODUCTNAME from st_item_product where prd_type_id not like 'SV%' and prd_type_id not like 'P%'";
	$qryProduct =sqlsrv_query($con,$sqlProduct,$params,$options);
	while($reP=sqlsrv_fetch_array($qryProduct)){
		$SQLIn3="insert into st_warehouse_stock 
		(P_Code,stock_count,status,COMPANYCODE,locationno,locationname,stock_min,Updatestatus)values
		('$reP[P_Code]','0','Y','$txt_COMPANY','$locationno','','0','1')";
		$QryIn3 =sqlsrv_query($con,$SQLIn3,$params,$options);
	}
	
	if($SQLIn2&&$qryUp_tbUser)
	{	echo "<script type=\"text/javascript\">";
		echo "alert(\"บันทึกข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_warehouse_location';";
		echo "</script>";
	}
	else
	{
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ตรวจสอบอีกครั้ง!!!\");";
		echo "</script>";
		echo $SQLIn2;
	}
}
				?>