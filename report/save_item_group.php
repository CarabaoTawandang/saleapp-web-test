<?
//------------------------------------------------------แก้ไข โดย Pong 06/07/2015-----------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =array("Scrollable"=>SQLSRV_CURSOR_KEYSET);



if($_GET['do']=="edit")
{
$id_g=$_POST['id_g'];
$txt_g=$_POST['txt_g'];
$txt_COMPANY=$_POST['txt_COMPANY'];
$remark=$_POST['remark'];

	$sqlUpdate="update st_item_group set prd_grp_nm='$txt_g',Remark='$remark',COMPANYCODE='$txt_COMPANY'
	,Updateby='$USER_id'
	,UpdateDate=GETDATE()
	where prd_grp_id='$id_g'";
	
	$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
	if($qryUpdate)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_item';";
		echo "</script>";
	  }
	
}

else if($_GET['do']=="del")
{
	  $id=$_GET['id'];
	  $sqlDel="delete st_item_group where prd_grp_id='$id'";
	  $qryDel=sqlsrv_query($con,$sqlDel,$params,$options);
	  
	  $SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	  $qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($qryDel)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_item';";
		echo "</script>";
	  }
	
}

else
{
$txtITEM=$_POST['txtITEM'];//กลุ่มสินค้า
$txt_remark=$_POST['txt_remark'];//หมายเหตุ
$txt_COMPANY=$_POST['txt_COMPANY'];//บริษัท
	
	$sql1="select max(substring( prd_grp_id,1,4)) as MAXID from st_item_group "; //หาค่า  ID__ สูงสุด

	$sql1 =sqlsrv_query($con,$sql1,$params,$options);
	$re1=sqlsrv_fetch_array($sql1);
	$MAXID =$re1['MAXID'];//รหัส ID__
	$MAXID=$MAXID+1;
	$CODE="0".str_pad($MAXID,2, "0", STR_PAD_LEFT);
	
		
  $SQLIn2="insert into st_item_group ([prd_grp_id]
      ,[prd_grp_nm]
      ,[Createby]
      ,[Updateby]
      ,[CreateDate]
      ,[UpdateDate]
      ,[Remark]
      ,[COMPANYCODE]) values('$CODE','$txtITEM','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_remark','$txt_COMPANY')";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);

		
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);

		if($QryIn2&&$qryUp_tbUser)
	  {?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=from_item';
				</script>
				<?
			}
			
		
		



	

}
?>