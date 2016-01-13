<?//--------------------------------------by pong 24/09/58
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
$params=array();
$options=array( "Scrollable" => SQLSRV_CURSOR_KEYSET);



if($_GET['do']=="edit"){
$ID_M=$_POST['ID_M'];		


		$OPEN=" select Equipment from st_D_Maintenance where ID_Maintenance ='$ID_M'  ";
		$OPEN=sqlsrv_query($con,$OPEN,$params,$options);
		$OPEN=sqlsrv_fetch_array($OPEN);

if($OPEN['Equipment']=='TL'){
$edit_Check_TL=$_POST['edit_Check_TL'];
if($edit_Check_TL!='on'){
			echo '<script type="text/javascript">';
			echo 'alert("บันทึกข้อมูลไม่สำเร็จ ");';
			echo "window.location='?page=edit_Maintenance&id=$ID_M';";
			echo '</script>';
		}else{
$IMEI=$_POST['IMEI'];
$Serial=$_POST['Serial'];
$Category=$_POST['Category'];
$Description=$_POST['Description'];
$Status=$_POST['Status'];
$Cost=$_POST['Cost'];
$Date_receiver=$_POST['Date_receiver'];
$Date_receiver_ = date("Y-m-d",strtotime($Date_receiver));
if($Date_receiver_==date("Y-m-d",strtotime('01/01/1970'))){$X=date("Y-m-d");}else{$X=$Date_receiver_;}

    $Update="update st_D_Maintenance set Serial_No='$Serial',IMEI='$IMEI',Category='$Category',Description='$Description'
	,Status='$Status',Cost='$Cost',Date_receiver='$X',UpdateDate=GETDATE(),Updateby='$USER_id'
	where ID_Maintenance='$ID_M' ";
	$Update=sqlsrv_query($con,$Update,$params,$options);
	
	
	
	if($Update)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_asset&page__2=1&C2=50&A2=all#tabs-3';";
		echo "</script>";
	  }


}} else if($OPEN['Equipment']=='MP'){
$edit_Check_MP=$_POST['edit_Check_MP'];
if($edit_Check_MP!='on'){
			echo '<script type="text/javascript">';
			echo 'alert("บันทึกข้อมูลไม่สำเร็จ ");';
			echo "window.location='?page=edit_Maintenance&id=$ID_M';";
			echo '</script>';
		}else{
$mac=$_POST['mac'];
$Serial1=$_POST['Serial1'];
$Category1=$_POST['Category1'];
$Description1=$_POST['Description1'];
$Status1=$_POST['Status1'];
$Cost1=$_POST['Cost1'];
$Date_receiver1=$_POST['Date_receiver1'];
$Date_receiver_ = date("Y-m-d",strtotime($Date_receiver1));
if($Date_receiver_==date("Y-m-d",strtotime('01/01/1970'))){$X=date("Y-m-d");}else{$X=$Date_receiver_;}

 $Update="update st_D_Maintenance set Serial_No='$Serial1',Category='$Category1',Description='$Description1'
	,Status='$Status1',Cost='$Cost1',Date_receiver='$X',UpdateDate=GETDATE(),Updateby='$USER_id',Mac='$mac'
	where ID_Maintenance='$ID_M' ";
	$Update=sqlsrv_query($con,$Update,$params,$options);
	
	
	
	if($Update)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_asset&page__2=1&C2=50&A2=all#tabs-3';";
		echo "</script>";
	  }


}}

}else
if($_GET['do']=="del")
{
	  $id=$_GET['id'];
	
	  $Delete="delete st_D_Maintenance where ID_Maintenance='$id'";
	  $Delete=sqlsrv_query($con,$Delete,$params,$options);

	  if($Delete)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_asset&page__2=1&C2=50&A2=all#tabs-3';";
		echo "</script>";
	  }
}else

{
$Equipment=$_POST['Equipment'];

if($Equipment=='TL'){

$IMEI=$_POST['IMEI'];
$Serial=$_POST['Serial'];
$Category=$_POST['Category'];
$Description=$_POST['Description'];
$Status=$_POST['Status'];
$Cost=$_POST['Cost'];
$Date_receiver=$_POST['Date_receiver'];
$Date_receiver_ = date("Y-m-d",strtotime($Date_receiver));
if($Date_receiver_==date("Y-m-d",strtotime('01/01/1970'))){$X=date("Y-m-d");}else{$X=$Date_receiver_;}



$sqlMax="select SUBSTRING(max(ID_Maintenance),5,5) as MaxID from st_D_Maintenance
where SUBSTRING(ID_Maintenance,1,2) ='M-' and SUBSTRING(ID_Maintenance,3,2) ='$year' ";
$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
$reMax=sqlsrv_fetch_array($qryMax);
$MaxID=$reMax['MaxID']; 
$MaxID= $MaxID+1;
$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
$MaxID ="M-".$year.$MaxID ;

$add="insert into st_D_Maintenance(ID_Maintenance ,Serial_No,IMEI,Category
      ,Description,Status,Cost,Equipment,Date_receiver,UpdateDate
      ,CreateDate,Updateby,Createby,Mac) values
('$MaxID','$Serial','$IMEI','$Category'
,'$Description','$Status','$Cost','$Equipment','$X'
,GETDATE(),GETDATE(),'$USER_id','$USER_id','-') ";
$add=sqlsrv_query($con,$add,$params,$options);
if($add)
	{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกข้อมูลเรียบร้อยแล้ว ");';
			echo "window.location='?page=from_asset&page__2=1&C2=50&A2=all#tabs-3';";
			echo '</script>';
	}


}
if($Equipment=='MP'){

$mac=$_POST['mac'];
$Serial1=$_POST['Serial1'];
$Category1=$_POST['Category1'];
$Description1=$_POST['Description1'];
$Status1=$_POST['Status1'];
$Cost1=$_POST['Cost1'];
$Date_receiver1=$_POST['Date_receiver1'];
$Date_receiver_ = date("Y-m-d",strtotime($Date_receiver1));
if($Date_receiver_==date("Y-m-d",strtotime('01/01/1970'))){$X=date("Y-m-d");}else{$X=$Date_receiver_;}

$sqlMax="select SUBSTRING(max(ID_Maintenance),5,5) as MaxID from st_D_Maintenance
where SUBSTRING(ID_Maintenance,1,2) ='M-' and SUBSTRING(ID_Maintenance,3,2) ='$year' ";
$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
$reMax=sqlsrv_fetch_array($qryMax);
$MaxID=$reMax['MaxID']; 
$MaxID= $MaxID+1;
$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
$MaxID ="M-".$year.$MaxID ;

$add="insert into st_D_Maintenance(ID_Maintenance ,Serial_No,IMEI,Category
      ,Description,Status,Cost,Equipment,Date_receiver,UpdateDate
      ,CreateDate,Updateby,Createby,Mac) values
('$MaxID','$Serial1','-','$Category1'
,'$Description1','$Status1','$Cost1','$Equipment','$X'
,GETDATE(),GETDATE(),'$USER_id','$USER_id','$mac') ";
$add=sqlsrv_query($con,$add,$params,$options);
if($add)
	{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกข้อมูลเรียบร้อยแล้ว ");';
			echo "window.location='?page=from_asset&page__2=1&C2=50&A2=all#tabs-3';";
			echo '</script>';
	}




}
}

		?>