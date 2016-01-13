<?//------------------------------------------------------แก้ไข โดย PONG 24/06/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
		$userType= $_SESSION["RoleID"];
		$userType2 = $_SESSION["RoleID_Lineid"];
		//echo $userType." / ".$userType2;

$txt_status=trim($_POST['txt_status']);
$txt_remark=$_POST['txt_remark'];

$txt_CNid=$_POST['txt_CNid'];
$txt_Saleid =$_POST['txt_Saleid'];

if($txt_status)
{$sqlStatus="select  CN_id,CN_name from st_CN_status  where  CN_id='$txt_status'";
$sqlStatus=sqlsrv_query($con,$sqlStatus);
$sqlStatus=sqlsrv_fetch_array($sqlStatus);
$sqlStatusName = $sqlStatus['CN_name'];
}



if($txt_status=='1')//ถ้ายืนยัน อนุมัติ
{
	//open คลังของuser
	$sqlLoc="select a.locationname,a.locationno,a.Acc_Doc
	from st_warehouse_location a  left join st_user u
	on u.warehouse_locationNo =a.locationno
	where u.User_id= '$USER_id' "; 
	//echo $sqlLoc;
	$sqlLoc=sqlsrv_query($con,$sqlLoc);
	$sqlLoc=sqlsrv_fetch_array($sqlLoc);
	$userLoc= trim($sqlLoc['locationno']);
	$userAcc_Doc=trim($sqlLoc['Acc_Doc']);		

	
	// open รหัส นำของออกคลัง เข้าท้ายรถ
	$sqlMax="select SUBSTRING(max(picking_no),12,16) as MaxID from st_warehouse_stock_picking_head
	where   SUBSTRING(picking_no,2,2) ='$year' and SUBSTRING(picking_no,5,6) ='$txt_Saleid'";
	$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
	$reMax=sqlsrv_fetch_array($qryMax);
	$MaxID=$reMax['MaxID']; 
	$MaxID= $MaxID+1;
	$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
	$MaxID ="P".$year."-".$txt_Saleid."-".$MaxID ; //----------------------ID CODE 
	
	//เปิดสินค้าที่บิลขอยกเลิก
	$sqlQdetailsql="select q.Ref_Docno,q.P_Code ,pro.PRODUCTNAME,pro.st_unit_id as unit123 
	,q.st_unit_qty_1 ,q.st_unit_qty_2 ,q.st_unit_qty_3 ,q.st_unit_qty_1*u1.st_unit_qty as AA ,q.st_unit_qty_2*u2.st_unit_qty as BB ,q.st_unit_qty_3 As CC 
	,(isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0)) as total
	,(isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))/u1.st_unit_qty as box 
	,((isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))%u1.st_unit_qty)/u2.st_unit_qty as pack
	,((isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))%u1.st_unit_qty)%u2.st_unit_qty as unil 
	,q.totalamount ,q.PromotionId ,q.PromotionName ,q.PromotionRemark ,q.totaldiscount ,q.totalamount-q.totaldiscount as amount 
	,q.TaxInv,q.CN_Docno
	from st_CN_detail q left join st_item_product pro 
	on q.P_Code =pro.P_Code left join st_item_unit_con u1 
	on u1.P_Code = q.P_Code and u1.st_unit_id= 'ลัง' left join st_item_unit_con u2 
	on u2.P_Code = q.P_Code and u2.st_unit_id= 'แพ็ค'
	where q.Ref_Docno ='$txt_CNid' ";
	$sqlQdetail=sqlsrv_query($con,$sqlQdetailsql); 
	
	//วนเปิดสินค้าที่บิลขอยกเลิก
	while($Qdetail=sqlsrv_fetch_array($sqlQdetail))
	{
		$QdetailCreateby=$Qdetail['Createby'];
		$Quotation_Docdate =date_format($Qdetail['Quotation_Docdate'],'Y-m-d');
		$QCustNum =$Qdetail['CustNum'];
		$QSaleType=$Qdetail['SaleType'];
		$QDelivery_date=date_format($Qdetail['Delivery_date'],'Y-m-d');
		$item=$Qdetail['P_Code']; 
		$itemsName=$Qdetail['PRODUCTNAME'];
		$Total= $Qdetail['total']; 
		$unit123 =$Qdetail['unit123'];
		
		//----เปิดstock ท้ายรถ
		$stockSale ="select *
		from st_warehouse_sale_stock 
		where P_Code='$item'
		and User_id='$txt_Saleid'";
		$stockSale=sqlsrv_query($con,$stockSale);
		$stockSale=sqlsrv_fetch_array($stockSale);
		$stockSale_count=$stockSale['wh_stock_qty'];
		$stockTRUE=$stockSale_count+$Total;		
						
		//add-detail สินค้าคืนท้ายรถ
		$sqlInTrues="insert into st_warehouse_stock_picking_detail 
		(picking_no,P_Code,PRODUCTNAME,picking_qty,picking_unit,picking_Remark,Createby,Updateby,CreateDate 
		,UpdateDate,Updatestatus) values
		('$MaxID','$item','','$Total','$unit123',' ยกเลิกบิล   = $txt_CNid','$USER_id','$USER_id',GETDATE(),GETDATE(),'1')";
		$qryInTrue=sqlsrv_query($con,$sqlInTrues);	
					
		//update ยอดของ ท้ายรถ
		$stockUpTrues="update st_warehouse_sale_stock set wh_stock_qty='$stockTRUE' where P_Code='$item' 
		and User_id='$txt_Saleid' ";
		$qryUpTrues=sqlsrv_query($con,$stockUpTrues);
		
		//echo "<br>*";echo $stockUpTrues;		
		$t++;
	}// while 
	
	//add head บิลคืน ท้ายรถ
	$sqlInTruesH="insert into st_warehouse_stock_picking_head
	(picking_no,picking_date,picking_user_id,picking_Remark,Createby,Updateby,CreateDate,UpdateDate,Updatestatus,picking_locationno) values
	('$MaxID',GETDATE(),'$txt_Saleid','ยกเลิกบิล   = $txt_CNid','$USER_id','$USER_id',GETDATE(),GETDATE(),'1','$userLoc')";
	$qryInTruesH=sqlsrv_query($con,$sqlInTruesH);

	//
	$sqlQdetailTaxInv=sqlsrv_query($con,$sqlQdetailsql);
	$QdetailTaxInv=sqlsrv_fetch_array($sqlQdetailTaxInv);
	$QTaxInv=$QdetailTaxInv['TaxInv'];
	$strQTaxInv=substr($QdetailTaxInv['TaxInv'],0,-5);
	
	$YY=substr(date('Y')+543,2);
	$MM=date('m');
	$sqlCN="select SUBSTRING(max(CN_Docno),18,20) as MaxIDCN from st_CN_head  
	where   SUBSTRING(CN_Docno,11,6) ='$txt_Saleid' and SUBSTRING(CN_Docno,6,2) ='$YY'  and SUBSTRING(CN_Docno,8,2) ='$MM' ";
	
	
	$sqlCN=sqlsrv_query($con,$sqlCN);
	$reCN=sqlsrv_fetch_array($sqlCN);
	$MaxIDCN=$reCN['MaxIDCN']; 
	$MaxIDCN= $MaxIDCN+1;
	$MaxIDCN =str_pad($MaxIDCN,4,"0",STR_PAD_LEFT);
	$MaxIDCN ="CN-".$strQTaxInv."-".$MaxIDCN;

}//if

//update CN
$SQLUpCN="update st_CN_head
set CN_id ='$txt_status'
,CN_name='$sqlStatusName' ,CN_Remark='$txt_remark' 
,Approveby='$USER_id' 
,Approvedate=GETDATE()
,Updateby='$USER_id'
,UpdateDate=GETDATE()
";
if($MaxIDCN){$SQLUpCN.=",CN_Docno='$MaxIDCN',CN_Docdate=GETDATE() ";}
$SQLUpCN.="where Ref_Docno='$txt_CNid' ";

//echo "<br> update st_CN_head === ".$SQLUpCN;
$UpCN=sqlsrv_query($con,$SQLUpCN);


if($UpCN && $qryInTruesH)
	{
			echo'<script type="text/javascript">';
			echo'alert(	"อนุมัติ ยกเลิกบิล เรียบร้อยแล้ว ");';
			//echo "window.location='?page=data_picking_head&picking_no=$MaxID&doCN=".$txt_CNid."';";
			echo "window.location='?page=from_CreditNote';";
			echo '</script>';
	}
else if($UpCN)
	{
			echo'<script type="text/javascript">';
			echo'alert(	"บันทึกการ ยกเลิกบิล เรียบร้อยแล้ว ");';
			echo "window.location='?page=from_CreditNote&id=$txt_CNid';";
			echo '</script>';
	}
 else 
 {
	echo'<script type="text/javascript">';
	echo'alert("ไม่สำเร็จ!!!!! ");';
	echo '</script>';
	echo $SQLUpCN;
 }

?>