<?//--------------------------------------pong 21/09/2015
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
$params=array();
$options=array( "Scrollable" => SQLSRV_CURSOR_KEYSET);

if($_GET['do']=="edit")
{

$id=$_GET['id'];
$unit=$_POST['unit'];
$target=$_POST['target'];
$qty=$_POST['qty'];
$amount=$_POST['amount'];
$txt_COMPANY=$_POST['txt_COMPANY'];

$start=$_POST['start'];
$start_ = date("Y-m-d",strtotime($start));
$end_=$_POST['end_'];
$end__ = date("Y-m-d",strtotime($end_));

$begin_explode = explode('-', $start_);
$begin_day     = $begin_explode[2];
$begin_month   = $begin_explode[1];
$begin_year    = $begin_explode[0];

$end_explode = explode('-', $end__);
$end_day     = $end_explode[2];
$end_month   = $end_explode[1];
$end_year    = $end_explode[0];

$start = GregorianToJD($begin_month,$begin_day,$begin_year);
$end   = GregorianToJD($end_month,$end_day,$end_year);

$period_time  = $end-$start;
$period_month =round($period_time/30);
	$edit_=" update  st_Sales_target set 
	tar_name='$target',tar_start='$start_',tar_end='$end__' 
	,tar_qty='$qty' ,Updateby='$USER_id' ,UpdateDate=GETDATE() 
	,COMPANYCODE='$txt_COMPANY',tar_amount='$amount',Num_month='$period_month'
 where ID='$id' ";
	$edit_=sqlsrv_query($con,$edit_,$params,$options);
	if($edit_)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
		echo "window.location='?page=from_target';";
		echo "</script>";
	  }
	
}else
if($_GET['do']=="del")
{	 
	 $id=$_GET['id'];
	
		$sqlDe=" delete st_Sales_target  where ID='$id' "; 
		$qryDe=sqlsrv_query($con,$sqlDe,$params,$options);
		
	
	  if($sqlDe)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบเป้ายอดขาย เรียบร้อยแล้ว\");";
		echo "window.location='?page=from_target';";
		echo "</script>";
	  }
	}

else{
$unit=$_POST['unit'];
$PRODUCT=$_POST['PRODUCT'];
$target=$_POST['target'];
$DC=$_POST['DC'];

$qty=$_POST['qty'];
$amount=$_POST['amount'];
$txt_COMPANY=$_POST['txt_COMPANY'];

$start=$_POST['start'];
$start_ = date("Y-m-d",strtotime($start));
$end_=$_POST['end_'];
$end__ = date("Y-m-d",strtotime($end_));

$begin_explode = explode('-', $start_);
$begin_day     = $begin_explode[2];
$begin_month   = $begin_explode[1];
$begin_year    = $begin_explode[0];

$end_explode = explode('-', $end__);
$end_day     = $end_explode[2];
$end_month   = $end_explode[1];
$end_year    = $end_explode[0];

$start = GregorianToJD($begin_month,$begin_day,$begin_year);
$end   = GregorianToJD($end_month,$end_day,$end_year);

$period_time  = $end-$start;
$period_month =round($period_time/30);


	$check="select max(substring( ID,0,6)) as MAXID from st_Sales_target ";//หาค่า  ID__ สูงสุด
	$check =sqlsrv_query($con,$check,$params,$options);
	$check=sqlsrv_fetch_array($check);
	$MAXID =$check['MAXID'];//รหัส ID__
	$MAXID=$MAXID+1;
	$CODE="0".str_pad($MAXID,4, "0", STR_PAD_LEFT);
	
	$open="select PRODUCTNAME from st_item_product where P_Code='$PRODUCT' ";
	$open=sqlsrv_query($con,$open,$params,$options);	
	$open=sqlsrv_fetch_array($open);

		
	$SQLIn1="insert into st_Sales_target
		(dc_groupid,tar_name,tar_start,tar_end      
		,tar_qty,P_Code,PRODUCTNAME,Createby
        ,Updateby,CreateDate,UpdateDate,COMPANYCODE,Updatestatus
       ,tar_amount,tar_unit,Num_month,ID)values
		('$DC','$target','$start_','$end__'
		,$qty,'$PRODUCT','$open[PRODUCTNAME]','$USER_id'
		,'$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','1'
		,'$amount','$unit','$period_month','$CODE') ";
	$QryIn1 =sqlsrv_query($con,$SQLIn1,$params,$options);

	

		if($SQLIn1)
	  {?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=from_target';
				</script>
				<?
			}
			
}			
?>			