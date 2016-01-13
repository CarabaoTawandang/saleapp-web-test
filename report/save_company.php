<?//--------------------------------------pong 10/7/58
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
$params=array();
$options=array( "Scrollable" => SQLSRV_CURSOR_KEYSET);

if($_GET['do']=="edit")
{
$ID=$_POST['ID'];
$txtcompany=$_POST['txtcompany'];
$address=$_POST['address'];
$telephone=$_POST['telephone'];


	$Update=" update st_companyinfo_exp set 
	COMPANYNAME='$txtcompany',ADDRESS='$address',TELEPHONE='$telephone' ,Updateby='$USER_id' ,UpdateDate=GETDATE() 
 where COMPANYCODE='$ID' ";
	$Update=sqlsrv_query($con,$Update,$params,$options);
	
	
	
	if($Update)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_company';";
		echo "</script>";
	  }
	
}

else if($_GET['do']=="del")
{
	  $id=$_GET['id'];
	  $delete="delete st_companyinfo_exp where COMPANYCODE='$id'";
	  $delete=sqlsrv_query($con,$delete,$params,$options);

	  
	 
	  if($delete)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_company';";
		echo "</script>";
	  }
	
}

else
{
$txtcompany=$_POST['txtcompany'];
$address=$_POST['address'];
$telephone=$_POST['telephone'];


 $sql1="select max(substring( COMPANYCODE,1,3)) as MAXID from st_companyinfo_exp  "; //หาค่า  ID__ สูงสุด
	$sql1 =sqlsrv_query($con,$sql1,$params,$options);
	$re1=sqlsrv_fetch_array($sql1);
	$MAXID =$re1['MAXID'];//รหัส ID__
	$MAXID=$MAXID+1;
    $CODE="".str_pad($MAXID,3, "0", STR_PAD_LEFT);
	

	

		
	$add="insert into st_companyinfo_exp(COMPANYCODE,COMPANYNAME
      ,ADDRESS,TELEPHONE,Createby,Updateby
      ,CreateDate,UpdateDate)values
		('$CODE','$txtcompany','$address','$telephone','$USER_id','$USER_id',GETDATE(),GETDATE())";
	$add =sqlsrv_query($con,$add,$params,$options);

	

		if($add)
	  {?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=from_company';
				</script>
				<?
			}
			}
			
			?>