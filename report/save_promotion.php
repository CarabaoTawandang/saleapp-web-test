<?//--------------------------------------by pong 28/7/58
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
$params=array();
$options=array( "Scrollable" => SQLSRV_CURSOR_KEYSET);

if($_GET['do']=="edit")
{	 
	 $txt_promotion=$_POST['txt_promotion'];
	 $detail=$_POST['detail'];
	 $txt_day=$_POST['txt_day'];
	 $txt_day1=$_POST['txt_day1'];
	 $txt_Role=$_POST['txt_Role'];
	 $txt_COMPANY=$_POST['txt_COMPANY'];
	 $ID_PRO=$_POST['ID_PRO'];
	$sql="SELECT * from st_item_product where prd_type_id ='S001' ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);

$sqlDe1=" delete st_promotion_detail where PromotionId='$ID_PRO' ";
		$qryDe1=sqlsrv_query($con,$sqlDe1,$params,$options);
		
for($j=0;$j<$row;$j+=1) 
			{	
				$eiei=sqlsrv_fetch_array($qry); 
				$P_Code=$eiei['P_Code'];
				$checkItem ="checkItem_".$P_Code;//ชื่อ
				$count ="count_".$P_Code;//จำนวน
				$discount ="discount_".$P_Code;//ราคาลด
				
			$item=$_POST[$checkItem];//ชื่อสินค้าที่มีการติก
			$count_=$_POST[$count];//จำนวนที่มีการติก
			$discount_=$_POST[$discount];//ราคาลดที่มีการติก
			
				$rate=round(($discount_/$count_),2);
				
		$opent2="SELECT * from st_item_product where P_Code='$item' ";
		$opent2 =sqlsrv_query($con,$opent2,$params,$options);
		$op2=sqlsrv_fetch_array($opent2);
		
	$sqlIn2="insert into st_promotion_detail
(PromotionId,P_Code_start,TypeList,PRODUCTNAME_start,AmountChk,QtyChk,ExchangeItem
,Createby,Updateby,CreateDate,UpdateDate,COMPANYCODE,Updatestatus,Condition,Parameter) values
('$ID_PRO','$item','0','$op2[PRODUCTNAME]','$discount_','$count_','$rate'
,'$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','1','>=','*') ";
$qryIn2=sqlsrv_query($con,$sqlIn2,$params,$options);	

$sqlDe2=" delete st_promotion_detail where P_Code_start='' "; 
		$qryDe2=sqlsrv_query($con,$sqlDe2,$params,$options);
		
		}// **ปิดloop		
		
		$opent1="select  RoleName_Linename,RoleID_Lineid from st_user_rolemaster_detail where RoleID_Lineid='$txt_Role' ";
		$opent1 =sqlsrv_query($con,$opent1,$params,$options);
		$op1=sqlsrv_fetch_array($opent1);

	$sqlUpdate2="update st_promotion_head set PromotionName='$txt_promotion',PromotionRemark='$detail',DateBegin='$txt_day',DateEnd='$txt_day1'
	,RoleID='$op1[RoleID_Lineid]',RoleName='$op1[RoleName_Linename]',Updateby=GETDATE(),UpdateDate=GETDATE(),COMPANYCODE='$txt_COMPANY'
	where  PromotionId='$ID_PRO' "; 		
		$qryUpdate2=sqlsrv_query($con,$sqlUpdate2,$params,$options);
		
			if($qryIn2&&$sqlUpdate2)
			  {
				echo "<script type=\"text/javascript\">";
				echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
				echo "window.location='?page=from_promotion';";
				echo "</script>";
				}
					
	}else

if($_GET['do']=="del")
{	 
	 $id=$_GET['id'];
	 $id_=$_GET['id_'];
	
		$sqlDe=" delete st_promotion_detail
		where PromotionId='$id' and P_Code_start ='$id_' "; 
		$qryDe=sqlsrv_query($con,$sqlDe,$params,$options);
		
	
	  if($sqlDe)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบสินค้านี้ออกจากโปรโมชั่น เรียบร้อยแล้ว\");";
		echo "window.location='?page=from_promotion';";
		echo "</script>";
	  }
	}
	

else if($_GET['do']=="del__")
{	 
	 $id=$_GET['id'];
	 
	
		$sqlDe=" delete st_promotion_head
		where PromotionId='$id' "; 
		$qryDe=sqlsrv_query($con,$sqlDe,$params,$options);//ลบหลัก
		
		$sqlDe1=" delete st_promotion_detail
		where PromotionId='$id' ";
		$qryDe1=sqlsrv_query($con,$sqlDe1,$params,$options); //ลบย่อย
		
		

	  if($sqlDe&&$qryDe1)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบโปรโมชั่น เรียบร้อยแล้ว\");";
		echo "window.location='?page=from_promotion';";
		echo "</script>";
	  }
	}
	

else
{
$txt_promotion=$_POST['txt_promotion'];//ชื่อโปร
$detail=$_POST['detail'];//รายละเอียด
$DC=$_POST['DC'];
$txt_day1=$_POST['txt_day1'];//วันสิ้นสุด
$txt_Role=$_POST['txt_Role'];//ตำแหน่ง
$txt_day=$_POST['txt_day'];//วันเริ่ม

$txt_COMPANY=$_POST['txt_COMPANY'];//บริษัท
$sqlMax="select SUBSTRING(max(PromotionId),6,5) as MaxID from st_promotion_head
where SUBSTRING(PromotionId,1,3) ='PM-' and SUBSTRING(PromotionId,4,2) ='$year' ";
$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
$reMax=sqlsrv_fetch_array($qryMax);
$MaxID=$reMax['MaxID']; 
$MaxID= $MaxID+1;
$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
$MaxID ="PM-".$year.$MaxID ; //----------------------ID 


$sql="SELECT * from st_item_product where prd_type_id ='S001' ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);


for($j=0;$j<$row;$j+=1) 
			{	$eiei=sqlsrv_fetch_array($qry); 
				$P_Code=$eiei['P_Code'];
				$checkItem ="checkItem_".$P_Code;//ชื่อ
				$count ="count_".$P_Code;//จำนวน
				$discount ="discount_".$P_Code;//ราคาลด
				
			$item=$_POST[$checkItem];//ชื่อสินค้าที่มีการติก
			$count_=$_POST[$count];//จำนวนที่มีการติก
			$discount_=$_POST[$discount];//ราคาลดที่มีการติก
			
				$rate=round(($discount_/$count_),2);
				
		
		$opent2="SELECT * from st_item_product where P_Code='$item' ";
		$opent2 =sqlsrv_query($con,$opent2,$params,$options);
		$op2=sqlsrv_fetch_array($opent2);
		
	$sqlIn2="insert into st_promotion_detail
(PromotionId,P_Code_start,TypeList,PRODUCTNAME_start,AmountChk,QtyChk,ExchangeItem
,Createby,Updateby,CreateDate,UpdateDate,COMPANYCODE,Updatestatus,Condition,Parameter) values
('$MaxID','$item','0','$op2[PRODUCTNAME]','$discount_','$count_','$rate'
,'$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','1','>=','*') ";
$qryIn2=sqlsrv_query($con,$sqlIn2,$params,$options);	

$sqlDe2=" delete st_promotion_detail where P_Code_start='' "; 
		$qryDe2=sqlsrv_query($con,$sqlDe2,$params,$options);
		}//ปิดloop
		
		
		$opent1="select  RoleName_Linename,RoleID_Lineid from st_user_rolemaster_detail where RoleID_Lineid='$txt_Role' ";
		$opent1 =sqlsrv_query($con,$opent1,$params,$options);
		$op1=sqlsrv_fetch_array($opent1);
		
	
$sqlIn1="insert into [st_promotion_head]
([PromotionId],[PromotionName],[PromotionRemark],[DateBegin] ,[DateEnd]
      ,[RoleID],[RoleName],[Createby],[Updateby]
	  ,[CreateDate],[UpdateDate],[COMPANYCODE],[Updatestatus],PromotionTypeId,dc_groupid,PromotionTypeName) values
('$MaxID','$txt_promotion','$detail','$txt_day','$txt_day1'
,'$op1[RoleID_Lineid]','$op1[RoleName_Linename]','$USER_id','$USER_id'
,GETDATE(),GETDATE(),'$txt_COMPANY','1','001','$DC','ส่วนลด') ";
$qryIn1=sqlsrv_query($con,$sqlIn1,$params,$options);//add--หลัก



if($qryIn1&&$qryIn2)
	{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกข้อมูลเรียบร้อยแล้ว ");';
			echo "window.location='?page=from_promotion';";
			echo '</script>';
	}
	

		}	?>