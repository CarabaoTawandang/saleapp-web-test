<?
//------------------------------------------------------แก้ไข โดย DREAM  30/6/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =array("Scrollable"=>SQLSRV_CURSOR_KEYSET);



if($_GET['do']=="edit")
{
$id=$_POST['id_district'];
$txt_districtname=$_POST['txt_districtname'];

	$sqlUpdate="update dc_district set DISTRICT_NAME='$txt_districtname'
	where DISTRICT_ID='$id'";
	
	$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
	if($qryUpdate)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_district';";
		echo "</script>";
	  }
	
}

else if($_GET['do']=="del")
{
	  $id=$_GET['id'];
	  $sqlDel="delete dc_district where DISTRICT_ID='$id'";
	  $qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
	  
	  $SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	  $qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($qryDel)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_district';";
		echo "</script>";
	  }
	
}

else
{
		$txt_geo=$_POST['txt_geo']; //รับรหัสภาค
		$txt_pro= $_POST['txt_pro']; //รับ Code จังหวัด
		$txt_aum =$_POST['txt_aum']; //รับชื่ออำเภอ
		$txt_dis=$_POST['txt_dis'];//รับชื่อตำบล
		$txt_zip=$_POST['txt_zip'];//รับรหัสไปรษณีย์
		
		$sql1=" select max(cast(DISTRICT_ID AS INT)) as MAXID from dc_district"; //หาค่า  DISTRICT_ID สูงสุด
		$sql1 =sqlsrv_query($con,$sql1,$params,$options);
		$re1=sqlsrv_fetch_array($sql1);
		$MAXID =$re1['MAXID'];//รหัส DISTRICT_ID
		$MAXID=$MAXID+1;
		
		$sql4=" select max(id)as ZIPMAXID from dc_zipcodes"; //หาค่า  ZIP_ID สูงสุด
		$sql4 =sqlsrv_query($con,$sql4,$params,$options);
		$re4=sqlsrv_fetch_array($sql4);
		$ZIPMAXID =$re4['ZIPMAXID'];//รหัส Zip_ID
		$ZIPMAXID=$ZIPMAXID+1;
		
		//เปิดหา Id จังหวัด
		$opent1="select PROVINCE_ID from dc_province where PROVINCE_CODE='$txt_pro' ";
		$opent1 =sqlsrv_query($con,$opent1,$params,$options);
		$op1=sqlsrv_fetch_array($opent1);
		//เปิดหา Id อำเภอ
		$opent2="select AMPHUR_ID from dc_amphur where AMPHUR_CODE='$txt_aum' ";
		$opent2 =sqlsrv_query($con,$opent2,$params,$options);
		$op2=sqlsrv_fetch_array($opent2);
		
	
		$sql2=" select max(cast(DISTRICT_CODE AS INT)) as DISTRICT_CODEMax from dc_district where AMPHUR_ID='$op2[AMPHUR_ID]' "; //หาค่า  AMPHUR_CODE สูงสุด
		$sql2 =sqlsrv_query($con,$sql2,$params,$options);
		$re2=sqlsrv_fetch_array($sql2);
		$DISTRICT_CODEMax = $re2['DISTRICT_CODEMax'];
		$DISTRICT_CODEMax=$DISTRICT_CODEMax+1;
			
		
		


	/*echo*/ $SQLIn2="insert into dc_district(DISTRICT_ID,DISTRICT_CODE,DISTRICT_NAME,GEO_ID,PROVINCE_ID,AMPHUR_ID)values
	('$MAXID','$DISTRICT_CODEMax','$txt_dis','$txt_geo','$op1[PROVINCE_ID]','$op2[AMPHUR_ID]')";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);
	
	/*echo*/ $SQLIn3="insert into dc_zipcodes(id,district_code,zipcode,Updatestatus)values
	('$ZIPMAXID','$DISTRICT_CODEMax','$txt_zip','1')";
	$QryIn3 =sqlsrv_query($con,$SQLIn3,$params,$options);
		
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);

		if($QryIn2&&$QryIn3)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"บันทึกข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_district';";
		echo "</script>";
	  }
	

	

}
?>