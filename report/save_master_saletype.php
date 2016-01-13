<?//--------------------------------------pong 10/7/58
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
$params=array();
$options=array( "Scrollable" => SQLSRV_CURSOR_KEYSET);

if($_GET['do']=="edit")
{
$txt_id=$_POST['txt_id'];
$txtsalename=$_POST['txtsalename'];
$txtsalety=$_POST['txtsalety'];
$txt_COMPANY=$_POST['txt_COMPANY'];

		$check ="select Saletype from st_saletype  where Saletype ='$txtsalename' and not Saletype ='$txt_id' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryCheck=sqlsrv_query($con,$check,$params,$options); // ***check ชื่อtype
		$reCheck=sqlsrv_fetch_array($qryCheck);
		if($reCheck){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จชื่อรหัสประเภทการขายนี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=from_master_saletype';";
			echo '</script>';
			
		}
else {
	$Update=" update st_saletype set 
	SaleType='$txtsalename',SaleTypeName='$txtsalety',Updateby='$USER_id',UpdateDate=GETDATE(),COMPANYCODE='$txt_COMPANY'	
	where Saletype='$txt_id' ";
	$Update=sqlsrv_query($con,$Update,$params,$options);
	
	
	
	if($Update)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_master_saletype';";
		echo "</script>";
	  }
		
		}
		
}
else if($_GET['do']=="del")
{
	  $id=$_GET['id'];
	  $delete="delete st_saletype where Saletype='$id'";
	  $delete=sqlsrv_query($con,$delete,$params,$options);

	  
	 
	  if($delete)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_master_saletype';";
		echo "</script>";
	  }
	
}

else
{
$txtsalename=$_POST['txtsalename'];
$txtsalety=$_POST['txtsalety'];
$txt_COMPANY=$_POST['txt_COMPANY'];

		$check ="select Saletype from st_saletype  where Saletype ='$txtsalename'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryCheck=sqlsrv_query($con,$check,$params,$options); // ***check ชื่อtype
		$reCheck=sqlsrv_fetch_array($qryCheck);
		if($reCheck){
			echo '<script type="text/javascript">';
			echo 'alert("ไม่สำเร็จชื่อรหัสประเภทการขายนี้ถูกใช้แล้ว!!! ");';
			echo "window.location='?page=from_master_saletype';";
			echo '</script>';
			
		}

 
	$add="insert into st_saletype (SaleType,SaleTypeName
      ,Createby,Updateby,CreateDate,UpdateDate,COMPANYCODE,Updatestatus)values
		('$txtsalename','$txtsalety','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','1')";
	$add =sqlsrv_query($con,$add,$params,$options);

	

		if($add)
	  {?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=from_master_saletype';
				</script>
				<?
			}
	}		
			?>