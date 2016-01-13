<?
session_start();
		set_time_limit(0);
		include("includes/config.php");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>TEST CODE CN-----------ขอนแก่น
<?
//-------------CODE จำนวนสินค้าที่ต้องคืนแต่ละตัว
/*select  h.Ref_Docno,d.P_Code,d.PRODUCTNAME,d.st_unit_qty_3
 from st_CN_head h left join st_CN_detail d
 on h.Ref_Docno=d.Ref_Docno
where h.Ref_Docno in('S255812245801171645',
'S255812245801171729',
'S255812245800861244',
'S255812245800861246'
)
order by d.P_Code ASC
*/
		$a=1;
$sqlSelect1="select Sales_Docno,Sales_Docdate,CustNum,CustName,SaleType,SaleTypeName
,Delivery_date,Remark,Createby,Updateby,CreateDate
,UpdateDate,taxrate,totalamount
,discount_percent,totaldiscount,totaltrade
,totalvat,totalall,Updatestatus,Approveby
,ApproveDate,TaxInv,Sale_id,Sale_name
 from st_Sale_head 
where Sales_Docno in('S255812245801171645',
'S255812245801171729',
'S255812245800861244',
'S255812245800861246'
)
order by Sales_Docno ASC
";
$qrySelect1 =sqlsrv_query($con,$sqlSelect1);
while($Select1=sqlsrv_fetch_array($qrySelect1))
{
	ECHO "<br>".$a." ";
	echo $Sales_Docno = $Select1['Sales_Docno'];
	if($Select1['Sales_Docdate']){$Sales_Docdate = date_format($Select1['Sales_Docdate'],'Y-m-d H:i:s');}
	$CustNum = $Select1['CustNum'];
	$Createby = $Select1['Createby'];
	$Updateby = $Select1['Updateby'];
	if($Select1['CreateDate']){$CreateDate = date_format($Select1['CreateDate'],'Y-m-d H:i:s');}
	if($Select1['UpdateDate']){$UpdateDate = date_format($Select1['UpdateDate'],'Y-m-d H:i:s');}
	$TaxInv = $Select1['TaxInv'];
	
	
	//ขอเลข CN
	$strQTaxInv=substr($TaxInv,0,-5);
	$YY=substr(date('Y')+543,2);
	$MM=date('m');
	$sqlCN="select SUBSTRING(max(CN_Docno),18,20) as MaxIDCN from st_CN_head
	where  SUBSTRING(CN_Docno,11,6) ='$Createby' and SUBSTRING(CN_Docno,6,2) ='$YY'  and SUBSTRING(CN_Docno,8,2) ='$MM' ";
	$sqlCN=sqlsrv_query($con,$sqlCN);
	$reCN=sqlsrv_fetch_array($sqlCN);
	$MaxIDCN=$reCN['MaxIDCN']; 
	$MaxIDCN= $MaxIDCN+1;
	$MaxIDCN =str_pad($MaxIDCN,4,"0",STR_PAD_LEFT);
	$MaxIDCN ="CN-".$strQTaxInv."-".$MaxIDCN;
	
	
	
	$sqlInH="insert into st_CN_head 
		(Ref_Docno,Ref_Docdate
	,CustNum,SaleType
	,Remark,Createby,Updateby,CreateDate,UpdateDate
	,Approveby,ApproveDate,TaxInv
	,CN_id,CN_name,CN_Docno,CN_Docdate,CN_Remark)
	values

	('$Sales_Docno','$Sales_Docdate'
	,'$CustNum','S1'
	,'ยกเลิกแบบ Manual 	สุดท้ายสิ้นปี  ขอนแก่น','$Createby','$Updateby','$CreateDate','$UpdateDate'
	,'580013',GETDATE(),'$TaxInv'
	,'1','อนุมัติ','$MaxIDCN',GETDATE(),'อนุมัติแบบ Manual สุดท้ายสิ้นปี ขอนแก่น')";
	//$qtyInH=sqlsrv_query($con,$sqlInH); if($qtyInH){ echo '  ****add CNNead แล้ว';}
	
	$sqlSelect2="select P_Code,PRODUCTNAME,PromotionId,PromotionName,st_unit_qty_3,st_unit_id_3,totalamount
	 from st_Sale_detail 
	where Sales_Docno ='$Sales_Docno'
	order by Sales_Docno ASC
	";
	$qrySelect2 =sqlsrv_query($con,$sqlSelect2);
	while($Select2=sqlsrv_fetch_array($qrySelect2))
	{	$Sales_line =$Select2['Sales_line'];
		$P_Code =$Select2['P_Code'];
		$PRODUCTNAME =$Select2['PRODUCTNAME'];
		$PromotionId = $Select2['PromotionId'];
		$PromotionName =$Select2['PromotionName'];
		$st_unit_qty_3 =$Select2['st_unit_qty_3'];
		$st_unit_id_3 = $Select2['st_unit_id_3'];
		$totalamount = $Select2['totalamount'];
		
		$sqlInD="insert into st_CN_detail
		(Ref_Docno,Ref_line,P_Code,PRODUCTNAME,PromotionId,PromotionName
	,PromotionRemark
	,st_unit_qty_3
	,st_unit_id_3
	,totalamount
	,Createby,Updateby
	,CreateDate,UpdateDate,Updatestatus
	,Approveby,ApproveDate,TaxInv,CN_Docno)
	values
	('$Sales_Docno','$Sales_line','$P_Code','$PRODUCTNAME','$PromotionId','$PromotionName'
	,'ยกเลิกแบบ Manual 	สุดท้ายสิ้นปี  ขอนแก่น'
	,'$st_unit_qty_3'
	,'$st_unit_id_3'
	,'$totalamount'
	,'$Createby','$Updateby'
	,'$CreateDate','$UpdateDate','1'
	,'580013',GETDATE(),'$TaxInv','$MaxIDCN')
	";
	//$qtyInD=sqlsrv_query($con,$sqlInD); if($qtyInD){ echo '  <br>****add CNDetail แล้ว';}
	}
	
$a++;
}//วน PRODUCT



?>

</body>
</html>






















<?
//echo substr("KK5812-580011-0056",1,-5)."<br>";
?>
</body>
</html>