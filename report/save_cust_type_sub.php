<?//-----------------------------------------------by dream 30/6/2015
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);


if($_GET['do']=="edit")
{
$id_=$_POST['id_'];
$name_=$_POST['name_'];
$txt_CUST=$_POST['txt_CUST'];
$txt_COMPANY=$_POST['txt_COMPANY'];


$sqlUpdate="update st_cust_group set cust_group_name='$name_',Updateby='$USER_id',COMPANYCODE='$txt_COMPANY'
	,UpdateDate=GETDATE(),cust_type_id='$txt_CUST'
	where cust_group_id='$id_'";
	
	$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
	if($sqlUpdate)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_cust_type';";
		echo "</script>";
	  }
	
}
else if($_GET['do']=="del")
{	 
	  $id=$_GET['id'];
	  $sqlDel="delete st_cust_group where cust_group_id='$id'";
	  $qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
	

	  $SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	  $qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($qryDel)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบประเภทร้านค้าย่อย เรียบร้อยแล้ว\");";
		echo "window.location='?page=from_cust_type';";
		echo "</script>";
	  }
	
}
else{
$txt_CUST=$_POST['txt_CUST'];//ประเภทร้านค้า
$txtCUST= $_POST['txtCUST'];//ชื่อร้านค้าย่อย
$txt_COMPANY=$_POST['txt_COMPANY'];//บริษัท

	
	$sql1=" select max(substring( cust_group_id,2,5)) as MAXID 
from st_cust_group 
where cust_group_id  LIKE '$txt_CUST%'"; //หาค่า  ID__ สูงสุด

	$sql1 =sqlsrv_query($con,$sql1,$params,$options);
	$re1=sqlsrv_fetch_array($sql1);
	$MAXID =$re1['MAXID'];//รหัส ID__
	$MAXID=$MAXID+1;
	$CODE="$txt_CUST".str_pad($MAXID,4, "0", STR_PAD_LEFT);
	
		
 $SQLIn2="insert into st_cust_group(cust_group_id,cust_group_name,Createby,Updateby,CreateDate,UpdateDate,COMPANYCODE
,Updatestatus,cust_type_id)values
	('$CODE','$txtCUST','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','1','$txt_CUST')";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);

		
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);

		if($QryIn2&&$qryUp_tbUser)
	  {?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=from_cust_type';
				</script>
				<?
			}
				
				}?>