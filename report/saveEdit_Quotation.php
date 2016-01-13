<?//------------------------------------------------------แก้ไข โดย PONG 24/06/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
		$userType= $_SESSION["RoleID"];
		$userType2 = $_SESSION["RoleID_Lineid"];
		//echo $userType." / ".$userType2;
		
if($_POST['datefrom']){$datefrom = date('Y-m-d',strtotime($_POST['datefrom']));}
$txt_status=trim($_POST['txt_status']);
$txt_Qid=$_POST['txt_Qid'];
$txt_Saleid =$_POST['txt_Saleid'];
if($txt_status)
{$sqlStatus="select  Qua_id,Qua_name from st_Quotation_status where  Qua_id='$txt_status'";
$sqlStatus=sqlsrv_query($con,$sqlStatus);
$sqlStatus=sqlsrv_fetch_array($sqlStatus);
}
$txt_remark=$_POST['txt_remark'];


if($txt_status=='7')//ถ้ายืนยัน
{
	//open คลังของuser
	$sqlLoc="select a.locationname,a.locationno,a.Acc_Doc
	from st_warehouse_location a  left join st_user u
	on u.warehouse_locationNo =a.locationno
	where u.User_id= '$USER_id' "; 
	//echo $sqlOp;
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
	$sqlQdetail="select q.Quotation_Docno,q.Quo_line,q.P_Code ,pro.PRODUCTNAME,pro.st_unit_id as unit123
	,q.st_unit_qty_1
	,q.st_unit_qty_2
	,q.st_unit_qty_3
	,q.st_unit_qty_1*u1.st_unit_qty as AA
	,q.st_unit_qty_2*u2.st_unit_qty as BB
	,q.st_unit_qty_3 As CC
	,(isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))  as total 
	,(isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))/u1.st_unit_qty as box 
	,((isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))%u1.st_unit_qty)/u2.st_unit_qty as pack 
	,((isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))%u1.st_unit_qty)%u2.st_unit_qty as unil 
	,q.totalamount
	,q.PromotionId
	,q.PromotionName
	,q.PromotionRemark
	,q.totaldiscount
	,q.totalamount-q.totaldiscount  as amount
	,h.SaleType
	,ST.SaleTypeName
	from st_Quotation_detail q  left join st_item_product pro
	on q.P_Code =pro.P_Code left join st_item_unit_con u1
	on u1.P_Code = q.P_Code and u1.st_unit_id=  'ลัง' left join st_item_unit_con u2
	on u2.P_Code = q.P_Code and u2.st_unit_id=  'แพ็ค'  left join st_Quotation_head h 
	on q.Quotation_Docno = h.Quotation_Docno left join st_saletype ST
	on h.SaleType = ST.SaleType 
	where q.Quotation_Docno ='$txt_Qid'
	order by q.Quo_line asc ";

	//วนเปิดสินค้าที่บิลขอยกเลิก
	$sqlQdetail=sqlsrv_query($con,$sqlQdetail); 
	while($Qdetail=sqlsrv_fetch_array($sqlQdetail))
	{
	$saleOpenQ=$Qdetail['saleOpenQ'];
	$QSaleTypeName = $Qdetail['SaleTypeName'];
	//echo "<br>";
	$items[]=$Qdetail['P_Code']; 
	$itemsName[]=$Qdetail['PRODUCTNAME'];
	$Total[] = $Qdetail['total']; 
	$unit123[] =$Qdetail['unit123'];
	}$t=0;
	foreach($items as $item)//วนเปิดสินค้าที่บิลขอยกเลิก เพื่อเช็คว่ามีของในคลังพอจ่ายมั้ย
	{	
		//----เปิดstockคลัง
		$stock ="select stock_count
		from st_warehouse_stock 
		where P_Code='$item'
		and locationno='$userLoc'";
		$stock=sqlsrv_query($con,$stock);
		$stock=sqlsrv_fetch_array($stock);
		$stock_count=$stock['stock_count'];
		$Total[$t];
		if($stock_count<$Total[$t])
		{	$check++;
			echo'<script type="text/javascript">';
			echo'alert("ขออภัยสินค้า  : '. $itemsName[$t]. ' ยอดในคลัง ไม่พอจ่ายคะ  \n\n ใบเสนอขายนี้ ไม่สามารถ ยืนยันได้");';
			echo "window.location='?page=from_Quotation&id=".$txt_Qid."';";
			echo '</script>';
		}
		else
		{	
			$sqlIn2 ="insert into st_warehouse_stock_picking_detail 
			(picking_no,P_Code,picking_qty,picking_unit,picking_Remark
			,Createby,Updateby,CreateDate ,UpdateDate,Updatestatus) values
			('$MaxID','$item','$Total[$t]','$unit123[$t]',' จ่ายของให้ $QSaleTypeName = $txt_Qid'
			,'$USER_id','$USER_id',GETDATE(),GETDATE(),'1')";
			$sqlInTrue[] =$sqlIn2;
			
			
			echo '<br>'.$stockTRUE=$stock_count-$Total[$t];
			$stockUp="update st_warehouse_stock set stock_count='$stockTRUE' 
			where P_Code='$item' and locationno='$userLoc' ";
			$stockUpTrue[] =$stockUp;
			
			
		}
		$t++;
	}// foreach ---> items
	
	//ขอเลข TaxInvของ คลังปีเดือน-Sale-  เมื่อยืนยัน
	$YY=substr(date('Y')+543,2);
	$MM=date('m');
	$sqlTaxinV="select  max(SUBSTRING(TaxInv,15,18)) as TaxInv from st_Quotation_head where SUBSTRING(TaxInv,1,2) ='$userAcc_Doc'
	and SUBSTRING(TaxInv,3,2) ='$YY'  and SUBSTRING(TaxInv,5,2) ='$MM' and SUBSTRING(TaxInv,8,6) ='$txt_Saleid' ";
	$sqlTaxinV=sqlsrv_query($con,$sqlTaxinV);
	$sqlTaxinV=sqlsrv_fetch_array($sqlTaxinV);
	$TaxInv=$sqlTaxinV['TaxInv']; 
	$TaxInv= $TaxInv+1;
	$TaxInv =str_pad($TaxInv,4,"0",STR_PAD_LEFT);
	$TaxInv =$userAcc_Doc.$YY.$MM."-".$txt_Saleid."-".$TaxInv ; 
}//ถ้ายืนยัน



if($check<=0)	//ckect สินค้าในStock ทุกตัวต้องพอจ่าย
{
	foreach($sqlInTrue as $sqlInTrues)
	{	//echo '<br>'.$sqlInTrues;
		$qryInTrue=sqlsrv_query($con,$sqlInTrues);//---add detail นำของออกคลังเข้าท้ายรถ
	}
	foreach($stockUpTrue as $stockUpTrues)
	{	
		$qryUpTrues=sqlsrv_query($con,$stockUpTrues);//---update ยอดของในคลัง
	}
	
	//---add หัวนำของออกคลังเข้าท้ายรถ
	if($MaxID<>''){$sqlIn1="insert into st_warehouse_stock_picking_head
	(picking_no,picking_date,picking_user_id,picking_Remark,Createby,Updateby,CreateDate,UpdateDate
	,picking_locationno,Updatestatus) values
	('$MaxID',GETDATE(),'$txt_Saleid','จ่ายของให้ $QSaleTypeName = $txt_Qid','$USER_id','$USER_id',GETDATE(),GETDATE()
	,'$userLoc','1')";
	$qryIn1=sqlsrv_query($con,$sqlIn1);}//add--หลัก

	$sqlUp="Update st_Quotation_head set Qua_id='$txt_status'
	,Qua_name='$sqlStatus[Qua_name]'
	,Remark='$txt_remark' 
	,Approveby='$USER_id'
	,ApproveDate=GETDATE()
	,UpdateBy='$USER_id'
	,UpdateDate=GETDATE() ";
	if($datefrom){ $sqlUp.=" ,Delivery_date='$datefrom'";}
	if($TaxInv){ $sqlUp.=" ,TaxInv='$TaxInv',TaxInvDate=GETDATE() ";}
	$sqlUp.="where Quotation_Docno='$txt_Qid'";//Update สถานะใบเสนอขาย
	//echo $sqlUp;
	$QryUp=sqlsrv_query($con,$sqlUp);

}




if($qryUpTrues)
	{
			echo'<script type="text/javascript">';
			echo'alert(	"ยืนยันการจ่ายของตาม ใบเสนอขายเรียบร้อยแล้ว");';
			echo "window.location='?page=data_picking_head&picking_no=$MaxID&do=".$txt_Qid."';";
			echo '</script>';
	}
else if($QryUp)
 {
	echo'<script type="text/javascript">';
	echo'alert("บันทึกเรียบร้อยแล้ว ");';
	//echo "window.location='?page=edit_Quotation&id=".$txt_Qid."';";
	echo "window.location='?page=from_Quotation&id=".$txt_Qid."';";
	echo '</script>';
 }
 else 
 {
	echo'<script type="text/javascript">';
	echo'alert("ไม่สำเร็จ!!!!! ");';
	echo '</script>';
	echo $sqlUp;
 }


?>