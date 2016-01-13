<?//------------------------------------------------------แก้ไข โดย PONG 25/06/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =array("Scrollable"=>SQLSRV_CURSOR_KEYSET);

if($_GET['do']=="edit")
{
$id=$_POST['id_amuphur'];
$txt_amuphurname=$_POST['txt_amuphurname'];


	$sqlUpdate="update dc_amphur set AMPHUR_NAME='$txt_amuphurname'
	where AMPHUR_CODE='$id'";
	
	$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
	if($qryUpdate)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_amuphur';";
		echo "</script>";
	  }
	
}
else if($_GET['do']=="del")
{	 
	  $id=$_GET['id'];
	  $sqlDel="delete dc_amphur where AMPHUR_CODE='$id'";
	  $qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
		//echo $sqlDel;

	  $SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	  $qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($qryDel)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_amuphur';";
		echo "</script>";
	  }
	
}

else
{			//echo "Add";
		$txt_geo=$_POST['txt_geo']; //รับรหัสภาค
		$txt_pro= $_POST['txt_pro']; //รับ Code จังหวัด
		$txt_aum =$_POST['txt_aum']; //รับชื่ออำเภอ
		
		$sql1=" select max(cast(AMPHUR_ID AS INT)) as MAXID from dc_amphur"; //หาค่า  AMPHUR_ID สูงสุด
		$sql1 =sqlsrv_query($con,$sql1,$params,$options);
		$re1=sqlsrv_fetch_array($sql1);
		$MAXID =$re1['MAXID'];//รหัส AMPHUR_ID
		$MAXID=$MAXID+1;
		
		//เปิดหา Id จังหวัด
		$opent1="select PROVINCE_ID from dc_province where PROVINCE_CODE='$txt_pro' ";
		$opent1 =sqlsrv_query($con,$opent1,$params,$options);
		$op1=sqlsrv_fetch_array($opent1);
		
		$sql2=" select max(cast(AMPHUR_CODE AS INT)) as AMPHUR_CODEMax from dc_amphur where PROVINCE_ID='$op1[PROVINCE_ID]' "; //หาค่า  AMPHUR_CODE สูงสุด
		$sql2 =sqlsrv_query($con,$sql2,$params,$options);
		$re2=sqlsrv_fetch_array($sql2);
		$AMPHUR_CODEMax = $re2['AMPHUR_CODEMax'];
		$AMPHUR_CODEMax=$AMPHUR_CODEMax+1;
		
		
		


	$SQLIn2="insert into dc_amphur (AMPHUR_ID,AMPHUR_CODE,AMPHUR_NAME ,GEO_ID,PROVINCE_ID,Updatestatus)values
	('$MAXID','$AMPHUR_CODEMax','$txt_aum' ,'$txt_geo','$op1[PROVINCE_ID]','1')";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);
		
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);

		if($QryIn2)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"บันทึกข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_amuphur';";
		echo "</script>";
	  }
	

	
}

?>