<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$CUST=$_POST['txt_CUST'];
if($_POST['txtDC']){$DC=$_POST['txtDC'];}
else{$DC=$_POST['txt_DC'];}
$txt_COMPANY=$_POST['txt_COMPANY'];

$sqlIn1="insert into st_user_group_dc_cust 
(dc_groupid  ,CustNum,Createby ,Updateby,CreateDate,UpdateDate,COMPANYCODE,Updatestatus) values
('$DC' ,'$CUST','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','1')";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qryIn1=sqlsrv_query($con,$sqlIn1,$params,$options);

$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);


		
if($qryIn1&&$qryUp_tbUser){	?>
				<script type="text/javascript">
					alert("บันทึกร้านค้าเข้า DC เรียบร้อยแล้ว ");
					window.location='?page=data_DC&id=<?=$DC;?>';
				</script>
				<?
			}//if
				else{?>
						<script type="text/javascript">
							alert("ตรวจสอบข้อมูลอีกที");
						</script>
				<? echo $sql;
				}
				
				?>
	
?>