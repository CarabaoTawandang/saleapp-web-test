<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);

$txt_location=$_POST['txt_location'];//คลังสินค้า
$txt_item= $_POST['txt_item'];//สินค้า
$txt_num=$_POST['txt_num'];//จำนวนสต็อก
$txt_COMPANY =$_POST['txt_COMPANY'];//บริษัท
$txt_min=$_POST['txt_min'];

	$sqlCheck="select * from st_warehouse_stock where locationno='$txt_location' and P_Code ='$txt_item'";
	$QryCheck =sqlsrv_query($con,$sqlCheck,$params,$options);
	$detailCheck=sqlsrv_fetch_array($QryCheck);
	if($detailCheck){
		echo'<script type="text/javascript">';
		echo 'alert("ไม่สำเร็จ คลังนี้มีการนับสินค้าชนิดนี้แล้ว!!!");';
		echo "window.location='?page=data_warehouse_stock';";
		echo '</script>';
	}
	else{
	$SQLIn="insert into st_warehouse_stock 
		(P_Code,stock_count,status,COMPANYCODE,locationno,locationname,stock_min,Updatestatus)values
		('$txt_item','$txt_num','Y','$txt_COMPANY','$txt_location','','$txt_min','1')";
	$QryIn =sqlsrv_query($con,$SQLIn,$params,$options);
		
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);

	if($QryIn&&$qryUp_tbUser){	?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=data_warehouse_stock';
				</script>
				<?
			}//if
				else{?>
						<script type="text/javascript">
							alert("ตรวจสอบข้อมูลอีกที");
						</script>
				<? echo $SQLIn;
				}
	}
				?>