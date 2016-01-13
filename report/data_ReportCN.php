<?
session_start();
set_time_limit(0);
include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
		$userType= $_SESSION["RoleID"];
		$userType2 = $_SESSION["RoleID_Lineid"];
		//echo $userType." / ".$userType2;
		
if($userType <>'7')
{ 	$sqlProDC="select dc_ProId
	FROM st_view_Open_cust  where User_id='$USER_id'  ";
	$sqlProDC=sqlsrv_query($con,$sqlProDC);
		while($ProDC=sqlsrv_fetch_array($sqlProDC)){
		if($ProDCString==""){$ProDCString =$ProDCString."".$ProDC['dc_ProId'];}
		else{ $ProDCString =$ProDCString." ,".$ProDC['dc_ProId']."  ";}
		}
 $ProDCString;
}
if($_POST['txtdateCN']){$txtdateCN = date('Y-m-d',strtotime($_POST['txtdateCN']));}	
if($_POST['txtdateCN2']){$txtdateCN2 = date('Y-m-d',strtotime($_POST['txtdateCN2']));}	 
if($_POST['txtdate1']){$txtdate1 = date('Y-m-d',strtotime($_POST['txtdate1']));}
if($_POST['txtdate2']){$txtdate2 = date('Y-m-d',strtotime($_POST['txtdate2'])); } 
$txt_status =$_POST['txt_status'];
$txt_saleType =$_POST['txt_saleType'];
$txt_id=$_POST['txt_id'];
$txt_name=$_POST['txt_name'];
$txt_DC=$_POST['txt_DC'];

$txt_pro=trim($_POST['txt_pro']);
$txt_aum=trim($_POST['txt_aum']);
$txt_dis=trim($_POST['txt_dis']);
$txt_CNid =trim($_POST['txt_CNid']);

if($_POST['Delivery_date']){$Delivery_date =date('Y-m-d',strtotime($_POST['Delivery_date']));}

if($txt_DC)
{ 	$sqlProDC="select d.dc_ProId
	FROM st_user_group_dc_detail d left join st_user_group_dc h
	on d.dc_groupid = h.dc_groupid
	group by d.dc_groupid,d.dc_ProId,h.dc_groupname
	having  d.dc_groupid='$txt_DC'    ";
	$sqlProDC=sqlsrv_query($con,$sqlProDC);
		while($ProDC=sqlsrv_fetch_array($sqlProDC)){
		if($ProDCString==""){$ProDCString =$ProDCString."".$ProDC['dc_ProId'];}
		else{ $ProDCString =$ProDCString." ,".$ProDC['dc_ProId']."  ";}
		}
 $ProDCString;
}
	$filter="select h.Ref_Docno ,cast(h.Ref_Docdate as date) as Quotation_date ,cast(h.Ref_Docdate as time) as Quotation_time ,h.SaleType 
	,ST.SaleTypeName ,cast(h.Delivery_date as date) as Delivery_date ,cast(h.Delivery_date as time) as Delivery_time ,h.CustNum as Cust1 
	,h.CN_id ,h.CN_name ,h.TaxInv ,h.Remark ,h.CN_Remark ,h.CN_Docno ,h.Createby as sale,UserSale.Salecode ,UserSale.name as saleName,UserSale.surname as SaleSurname 
	,c.CustName ,c.AddressNum ,c.AddressMu ,c.DISTRICT_NAME ,c.AMPHUR_NAME ,c.PROVINCE_NAME ,c.PROVINCE_CODE ,c.cust_type_name ,h.Approveby as 'by' 
	,sum(d.totalamount) as totalamount
	,sum(d.totaldiscount) as totaldiscount
	,
	case when h.CN_id=1 then sum(d.totalamount)-sum(d.totaldiscount) 
	else 0
	end total 
	from st_CN_head h 
	left join st_View_cust_web c on c.CustNum = h.CustNum 
	left join st_saletype ST on h.SaleType = ST.SaleType 
	left join st_user UserSale on h.Createby=UserSale.User_id 
	left join st_CN_detail d on h.Ref_Docno=d.Ref_Docno
	";
if($txtdateCN)
{	$filter.="where cast(h.CreateDate as date) between '$txtdateCN' and '$txtdateCN2' ";
	if($txt_status){$filter.="and h.CN_id = '$txt_status'  "; } 
	if($txt_saleType){$filter.="and h.SaleType = '$txt_saleType'  "; } 
	if($txt_id){$filter.="and h.Ref_Docno like '$txt_id%'"; } 
	if($txt_name){$filter.="and c.CustName like '$txt_name%'  "; } 
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($txt_CNid){$filter.="and h.CN_Docno like '$txt_CNid%'  "; } 
		
}

else if($txtdate1 || $txtdate2 )
{	$filter.="where cast(h.Ref_Docdate as date) between '$txtdate1' and '$txtdate2' ";
	if($txt_status){$filter.="and h.CN_id = '$txt_status'  "; } 
	if($txt_saleType){$filter.="and h.SaleType = '$txt_saleType'  "; } 
	if($txt_id){$filter.="and h.Ref_Docno like '$txt_id%'"; } 
	if($txt_name){$filter.="and c.CustName like '$txt_name%'  "; } 
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($txt_CNid){$filter.="and h.CN_Docno like '$txt_CNid%'  "; } 
		
}
else if($txt_status )
{	$filter.="where h.CN_id = '$txt_status'  "; 
	if($txt_saleType){$filter.="and h.SaleType = '$txt_saleType'  "; } 
	if($txt_id){$filter.="and h.Ref_Docno like '$txt_id%'"; } 
	if($txt_name){$filter.="and c.CustName like '$txt_name%'  "; } 
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($txt_CNid){$filter.="and h.CN_Docno like '$txt_CNid%'  "; } 
		
}
else if($txt_saleType )
{	$filter.="where h.SaleType = '$txt_saleType'  "; 
	if($txt_id){$filter.="and h.Ref_Docno like '$txt_id%'"; } 
	if($txt_name){$filter.="and c.CustName like '$txt_name%'  "; } 
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($txt_CNid){$filter.="and h.CN_Docno like '$txt_CNid%'  "; } 
		
}
else if($txt_id )
{	$filter.="where h.Ref_Docno like '$txt_id%'"; 
	if($txt_name){$filter.="and c.CustName like '$txt_name%'  "; } 
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($txt_CNid){$filter.="and h.CN_Docno like '$txt_CNid%'  "; } 
		
}
else if($txt_name )
{	$filter.="where c.CustName like '$txt_name%'  "; 
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($txt_CNid){$filter.="and h.CN_Docno like '$txt_CNid%'  "; } 
		
}
else if($ProDCString )
{	$filter.="where c.PROVINCE_CODE in ($ProDCString) "; 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($txt_CNid){$filter.="and h.CN_Docno like '$txt_CNid%'  "; } 
		
}
else if($txt_pro )
{	$filter.="where c.PROVINCE_CODE like '$txt_pro%'  "; 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($txt_CNid){$filter.="and h.CN_Docno like '$txt_CNid%'  "; } 
		
}
else if($txt_CNid )
{	$filter.="and h.CN_Docno like '$txt_CNid%'  ";
		
}
	$filter.="group by h.Ref_Docno ,cast(h.Ref_Docdate as date) ,cast(h.Ref_Docdate as time)  ,h.SaleType 
	,ST.SaleTypeName ,cast(h.Delivery_date as date)  ,cast(h.Delivery_date as time) ,h.CustNum 
	,h.CN_id ,h.CN_name ,h.TaxInv ,h.Remark ,h.CN_Remark ,h.CN_Docno ,h.Createby,UserSale.Salecode ,UserSale.name,UserSale.surname 
	,c.CustName ,c.AddressNum ,c.AddressMu ,c.DISTRICT_NAME ,c.AMPHUR_NAME ,c.PROVINCE_NAME ,c.PROVINCE_CODE ,c.cust_type_name ,h.Approveby ";
	
if($_POST['order_n']){$order_n=$_POST['order_n'];}
else{$order_n="cast(h.Ref_Docdate as date)";}
$sort=$_POST['sort'];
$txt_all=$_POST['txt_all'];
if($order_n){$filter.=" order by $order_n   $sort "; } 
//echo $filter;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
	});//function	
</script>

<style type="text/css">  
.inner_position_right{  
    
    top:0px; /* css กำหนดชิดด้านบน  */  
    left:70%; /* css กำหนดชิดขวา  */  
    z-index:999;  
}  
</style>
<style type="text/css">
#mouseOver {
        display: inline;
        position: relative;
    }
    
    #mouseOver #img2 {
        position: absolute;
        left: 50%;
        transform: translate(-100%);
        bottom: 0em;
        opacity: 0;
        pointer-events: none;
        transition-duration: 800ms; 
		top: 50px;
    }
    
    #mouseOver:hover #img2 {
        opacity: 1;
        transition-duration: 400ms;
    }
</style> 
</head>
<body>

ยกเลิกบิลของการค้นหา
<div>  **หมายเหตุ : บิลที่ยังไม่อนุมัติ จำนวนเงินCN เป็น0</div>
	<table  align="center" class="tables">
	<tr>
	<th align="center"width="30px">ลำดับ</th>
	<th align="center"width="100px">ประเภทขาย</th>
	<th align="center"width="200px">Sale</th>
	<th align="center"width="150px">วันที่เปิดบิล</th>
	<th align="center"width="200px">รหัสบิล</th>
	<th align="center"width="200px">Invoice</th>
	<th align="center"width="100px">ร้านค้า</th>
	<th align="center"width="250px">ที่อยู่</th>
	<th align="center"width="100px">จังหวัด</th>
	<th align="center"width="100px">ประเภทร้าน</th>
	<th align="center"width="200px">DC</th>
	<th align="center"width="100px">หมายเหตุที่ขอยกเลิก</th>
	
	<th align="center"width="100px">สถานะ</th>
	<th align="center"width="200px">Approve โดย</th>
	<th align="center"width="100px">เหตุผล</th>
	<th align="center"width="100px">เลขที่ CN</th>
	<th align="center"width="20px">จำนวนเงินCN</th>
	<th align="center"width="20px">ดูDetail</th>
	</tr>
	<? $filter=sqlsrv_query($con,$filter); $r=1;
	while($fil=sqlsrv_fetch_array($filter)){
			$Qua_name = trim($fil['CN_name']);
			 if($Qua_name=="อนุมัติ"){$color="#01DF3A";}
			else if($Qua_name=="ไม่อนุมัติ"){$color="#FF4000";}
			else {$color="#000";$Qua_name='ขอยกเลิก'; }
	//onMouseover="this.bgColor='#FFFF6F',this.fontcolor='black';" onMouseout="this.bgColor=''" 
	?>
	<tr class="mousechange" >
	<td><?=$r;$r++; ?>.</td>
	<td><?=$fil['SaleTypeName'];?></td>
	<td><?=$fil['Salecode']." ".$fil['saleName']." ".$fil['SaleSurname'];?></td>
	<td><?echo date_format($fil['Quotation_date'],'d-m-Y'); echo " ".date_format($fil['Quotation_time'],'H:i');?></td>
	
	<td><?=$fil['Ref_Docno'];?></td>
	<td><?echo $fil['TaxInv'];?></td>
	<td><?=$fil['CustName'];?></td>
	<td>
	<?
					if($fil['AddressNum']){echo "  ที่อยู่  ".$fil['AddressNum'];}
					if($fil['AddressMu']){echo " ม.  ".$fil['AddressMu'];}
					if($fil['DISTRICT_NAME']){echo " ต.  ".$fil['DISTRICT_NAME'];}
					if($fil['AMPHUR_NAME']){echo " อ.  ".$fil['AMPHUR_NAME'];}
					//if($fil['PROVINCE_NAME']){echo " จ.  ".$fil['PROVINCE_NAME'];}
					
	?>
	</td>
	<td><?echo $fil['PROVINCE_NAME'];?></td>
	<td><? if($fil['cust_type_name']){echo " ".$fil['cust_type_name'];}?></td>
	<td>
	<? 		$PROVINCE_CODE= $fil['PROVINCE_CODE'];
			$sqlProVince="select d.dc_groupid,d.dc_ProId,h.dc_groupname
			FROM st_user_group_dc_detail d left join st_user_group_dc h
			on d.dc_groupid = h.dc_groupid
			group by d.dc_groupid,d.dc_ProId,h.dc_groupname
			having  dc_ProId='$PROVINCE_CODE'";
			$sqlProVince=sqlsrv_query($con,$sqlProVince); 
			while($ProVince=sqlsrv_fetch_array($sqlProVince)){
			echo $ProVince['dc_groupname']."<br>";
			}
	?>
	</td>
	<td  ><?=$fil['Remark']; ?></td>
	
	
	<td><font color="<?=$color; ?>"><b><?echo $Qua_name;?></b></font>
	<? if($Qua_name=="ยืนยัน") {?><img src="./images/printer.png"  width="20px" height="20px"><? } ?>
	</td>
	<td><b><? $fil['by'];
		 $sqlBy="select u.name,u.surname,u.dc_groupid,dc.dc_groupname
			FROM st_user u left join st_user_group_dc dc on u.dc_groupid = dc.dc_groupid
			where User_id='$fil[by]'";
			$sqlBy=sqlsrv_query($con,$sqlBy); 
			$sqlBy=sqlsrv_fetch_array($sqlBy);
			echo $sqlBy['name']." ".$sqlBy['surname'];?></b>
			<? if($sqlBy['dc_groupname']){echo " DC: ".$sqlBy['dc_groupname'];} ?>
	</td>
	<td  ><?=$fil['CN_Remark']; ?></td>
	<td  ><?=$fil['CN_Docno']; ?></td>
	<td align="center"  ><?=number_format($fil['total']); $total=$total+$fil['total'];?></td>
	<td align="center"  >
	<? if(!$Excel) {?>
	<a href="?page=edit_CreditNote&id=<?=$fil['Ref_Docno']; ?>" >
	<img src="./images/zoom.png" width="25px" height="25px" style="cursor:pointer" alt="Complete">
	</a>
	<? } ?>
	</td>
	
	</tr>
	<? } ?>
	<tr class="mousechange" bgColor="#A0CD64" align="right" ><td colspan="16">รวม</td>
	<td align="center"  ><? echo number_format($total); ?></td>
	<td align="center"  ><? echo " "; ?></td>
	</tr>
	</table>
</div></div><br><br>


</body>
</html>
