<?//------------------------------------------------------แก้ไข โดย phung 10/09/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");
	$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
	$txt_planID =trim($_POST['txt_planID']);
	$select_provider=trim($_POST['select_provider']); //รหัส DC
	$txt_planName =trim($_POST['txt_planName']); //แผน
	$txt_remark =trim($_POST['txt_remark']); //หมายเหตุ
	$txt_COMPANY =trim($_POST['txt_COMPANY']); //บริษัท
	
	
	$sqlUp1="update st_Master_plan set
	DC_id='$select_provider'
	,Plan_name='$txt_planName'
	,Updateby='$USER_id'
	,UpdateDate =GETDATE()
	,COMPANYCODE='$txt_COMPANY'
	,Remark='$txt_remark' where	Plan_id='$txt_planID'";
	$qryUp1=sqlsrv_query($con,$sqlUp1);

	
	$sqlDel2="delete st_Master_PlanDetail where Plan_id='$txt_planID'";
	$qryDel2=sqlsrv_query($con,$sqlDel2);
	
	
	/*$array = array( "นก","ไก่", "ปู", "นก","ปู", "ปลา" );
	$result = array_unique( $array );
	echo "<br>";print_r($result);*/
	
    $array_id = $_POST["array_id"];
	$array_id = array_unique($array_id);
	$a=1;
    foreach($array_id as $item){
       echo "<br>"; 
		//if($item !="undefined"){echo $a." = ".$item;$a++;}
	    if($item !="undefined")
		{
			$sqlAdd2="insert into st_Master_PlanDetail(Plan_id,Cust_num,row)values('$txt_planID','$item','$a')";
			$qryAdd2=sqlsrv_query($con,$sqlAdd2);
			$a++;
		}
    }
	
	if($qryAdd2)
	{
			echo'<script type="text/javascript">';
			echo'alert("แก้ไขแผนเรียบร้อยแล้วคะ");';
			echo "window.location='?page=showDetailPlan&id=".$txt_planID."';";
			echo '</script>';
	}
	else 
	{
			echo'<script type="text/javascript">';
			echo'alert("ไม่สำเร็จ");';
			
			echo '</script>';echo $sqlUp1;
	}
?>