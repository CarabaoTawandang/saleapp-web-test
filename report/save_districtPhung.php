<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?
$txt_geo = $_POST['txt_geo'];
$txt_pro = $_POST['txt_pro'];
 $txt_aum = $_POST['txt_aum'];
$txt_dis = $_POST['txt_dis'];
$zip	=	trim($_POST['txt_zip']);
			 $sql16="SELECT DISTRICT_ID from dc_district order by DISTRICT_CODE desc   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry16=sqlsrv_query($con,$sql16,$params,$options);
			$row16=sqlsrv_num_rows($qry16);
			$detail16=sqlsrv_fetch_array($qry16);
			 $num_id2=$detail16['DISTRICT_ID'];
			$code_d=$num_id2+1;
			
			
			$sql7="SELECT DISTRICT_CODE from dc_district order by DISTRICT_CODE desc   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry7=sqlsrv_query($con,$sql7,$params,$options);
			$row7=sqlsrv_num_rows($qry7);
			$detail7=sqlsrv_fetch_array($qry7);
			
			$num2=$detail7['DISTRICT_CODE'];
			$code2=$num2+1;
			$sql="Insert into dc_district (DISTRICT_ID,DISTRICT_CODE,DISTRICT_NAME,AMPHUR_ID,GEO_ID,PROVINCE_ID,Updatestatus) VALUES
			('$code_d', '$code2' ,'$txt_dis','$txt_aum ','$txt_geo','$txt_pro','1')";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);

					$sql19="SELECT id from dc_zipcodes order by id desc   ";
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
					$qry19=sqlsrv_query($con,$sql19,$params,$options);
					$row19=sqlsrv_num_rows($qry19);
					$detail19=sqlsrv_fetch_array($qry19);
					
					$num_id3=$detail19['id'];
					$code_d3=$num_id3+1;
		
				$sql13="Insert into dc_zipcodes(id,district_code,zipcode,Updatestatus) values( '$code_d3','$code2' ,'$zip','1' ) ";
				$qry13=sqlsrv_query($con,$sql13,$params,$options);
				
				$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
				$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
				
if($qry&&$qry13){	?>
				<script type="text/javascript">
					alert("บันทึกตำบลใหม่เรียบร้อย ");
					window.location='index.php';
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

</body>
</html>