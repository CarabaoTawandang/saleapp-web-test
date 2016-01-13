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
$filter="select h.Quotation_Docno
,cast(h.Quotation_Docdate as date) as Quotation_date
,cast(h.Quotation_Docdate as time) as Quotation_time

,cast(h.Delivery_date as date) as Delivery_date
,cast(h.Delivery_date as time) as Delivery_time
,h.CustNum as Cust1 
,h.Qua_name
,h.SaleType
,ST.SaleTypeName
,c.CustName
,c.AddressNum
,c.AddressMu
,c.DISTRICT_NAME
,c.AMPHUR_NAME
,c.PROVINCE_NAME,c.PROVINCE_CODE
,c.cust_type_name
,h.Approveby  as 'by'
,h.TaxInv
,h.Remark
,cast(h.TaxInvDate as date) as TaxInvDate
from st_Quotation_head h left join st_View_cust_web c
on c.CustNum =  h.CustNum left join st_saletype ST
on h.SaleType = ST.SaleType ";
if($txtdate1 || $txtdate2 )
{	$filter.="where cast(h.Quotation_Docdate as date) between '$txtdate1' and '$txtdate2' ";
	if($txt_status){$filter.="and h.Qua_id = '$txt_status'  "; } 
	if($txt_saleType){$filter.="and h.SaleType = '$txt_saleType'  "; } 
	if($txt_id){$filter.="and h.Quotation_Docno like '$txt_id%'"; } 
	if($txt_name){$filter.="and c.CustName like '$txt_name%'  "; } 
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($Delivery_date){$filter.="and cast(h.Delivery_date as date) like '$Delivery_date%'  "; }  	
}
else if($txt_status )
{	$filter.="where h.Qua_id = '$txt_status'  "; 
	if($txt_saleType){$filter.="and h.SaleType = '$txt_saleType'  "; } 
	if($txt_id){$filter.="and h.Quotation_Docno like '$txt_id%'"; } 
	if($txt_name){$filter.="and c.CustName like '$txt_name%'  "; } 
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($Delivery_date){$filter.="and cast(h.Delivery_date as date) like '$Delivery_date%'  "; }  	
}
else if($txt_saleType )
{	$filter.="where  h.SaleType = '$txt_saleType'  "; 
	if($txt_id){$filter.="and h.Quotation_Docno like '$txt_id%'"; } 
	if($txt_name){$filter.="and c.CustName like '$txt_name%'  "; } 
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($Delivery_date){$filter.="and cast(h.Delivery_date as date) like '$Delivery_date%'  "; }  	
}
else if($txt_id )
{	$filter.="where h.Quotation_Docno like '$txt_id%'"; 
	if($txt_name){$filter.="and c.CustName like '$txt_name%'  "; } 
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($Delivery_date){$filter.="and cast(h.Delivery_date as date) like '$Delivery_date%'  "; }  	
}
else if($txt_name )
{	$filter.="where c.CustName like '$txt_name%'  "; 
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($Delivery_date){$filter.="and cast(h.Delivery_date as date) like '$Delivery_date%'  "; }  	
}
else if($ProDCString )
{	$filter.="where c.PROVINCE_CODE in ($ProDCString) "; 
	if($txt_pro){$filter.="and c.PROVINCE_CODE like '$txt_pro%'  "; } 
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($Delivery_date){$filter.="and cast(h.Delivery_date as date) like '$Delivery_date%'  "; }  	
}
else if($txt_pro )
{	$filter.="where c.PROVINCE_CODE like '$txt_pro%'  ";
	if($txt_aum){$filter.="and c.AMPHUR_CODE like '$txt_aum%'  "; } 
	if($txt_dis){$filter.="and c.DISTRICT_CODE like '$txt_dis%'  "; } 
	if($Delivery_date){$filter.="and cast(h.Delivery_date as date) like '$Delivery_date%'  "; }  	
}
else if($Delivery_date )
{	$filter.="where cast(h.Delivery_date as date) like '$Delivery_date%'  "; 
}
if($_POST['order_n']){$order_n=$_POST['order_n'];}else{$order_n="cast(h.Quotation_Docdate as date)";}
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

ใบเสนอขายของการค้นหา
	<table  align="center" class="tables" >
	<tr>
	<th align="center"width="30px">ลำดับ</th>
	<th align="center"width="100px">ประเภทขาย</th>
	<th align="center"width="200px">วันที่เปิดบิล</th>
	<th align="center"width="200px">รหัสบิล</th>
	<th align="center"width="150px">ร้านค้า</th>
	<th align="center"width="200px">ที่อยู่</th>
	<th align="center"width="100px">จังหวัด</th>
	<th align="center"width="100px">ประเภทร้าน</th>
	<th align="center"width="200px">DC</th>
	<th align="center"width="200px">Update โดย</th>
	<th align="center"width="100px">สถานะ</th>
	<th align="center"width="200px">วันที่นัดส่งของ</th>
	<th align="center"width="200px">Invoice</th>
	<th align="center"width="200px">Invoice Date</th>
	<th align="center"width="100px">เหตุผล</th>
	<th align="center"width="20px">จัดการ</th>
	</tr>
	<? 	$filter=sqlsrv_query($con,$filter); $r=1;
		while($fil=sqlsrv_fetch_array($filter)){
			$Qua_name = trim($fil['Qua_name']);
			if($Qua_name=="เสนอราคา"){$color="#000";}
			else if($Qua_name=="ยกเลิก"){$color="#F5BCA9";}
			else if($Qua_name=="อนุมัติ"){$color="#01DF3A";}
			else if($Qua_name=="ยกเลิกCN"){$color="#FF4000";}
			else {$color="#0101DF";}
	//onMouseover="this.bgColor='#FFFF6F',this.fontcolor='black';" onMouseout="this.bgColor=''" 
	?>
	<tr class="mousechange" >
	<td><?=$r;$r++; ?>.</td>
	<td><?=$fil['SaleTypeName'];?></td>
	<td><?echo date_format($fil['Quotation_date'],'d-m-Y'); echo " ".date_format($fil['Quotation_time'],'H:i');?></td>
	<td><?=$fil['Quotation_Docno'];?></td>
	<td><?=$fil['CustName'];?></td>
	<td>
	<?
					if($fil['AddressNum']){echo "  ที่อยู่  ".$fil['AddressNum'];}
					if($fil['AddressMu']){echo " ม.  ".$fil['AddressMu'];}
					if($fil['DISTRICT_NAME']){echo " ต.  ".$fil['DISTRICT_NAME'];}
					if($fil['AMPHUR_NAME']){echo " อ.  ".$fil['AMPHUR_NAME'];}
					if($fil['PROVINCE_NAME']){echo " จ.  ".$fil['PROVINCE_NAME'];}
					
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
	<td><b><? $fil['by'];
		 $sqlBy="select u.name,u.surname,u.dc_groupid,dc.dc_groupname
			FROM st_user u left join st_user_group_dc dc on u.dc_groupid = dc.dc_groupid
			where User_id='$fil[by]'";
			$sqlBy=sqlsrv_query($con,$sqlBy); 
			$sqlBy=sqlsrv_fetch_array($sqlBy);
			echo $sqlBy['name']." ".$sqlBy['surname'];?></b>
			<? if($sqlBy['dc_groupname']){echo " DC: ".$sqlBy['dc_groupname'];} ?>
	</td>
	<td  ><?=$fil['Remark']; ?></td>
	<td><font color="<?=$color; ?>"><b><?echo $Qua_name;?></b></font>
	<? if($Qua_name=="ยืนยัน") {?><img src="./images/printer.png"  width="20px" height="20px"><? } ?>
	</td>
	<td><?echo date_format($fil['Delivery_date'],'d-m-Y');?></td>
	<td><?echo $fil['TaxInv'];?></td>
	<td  ><?=$fil['Remark']; ?></td>
	<td align="center"  >
	<a href="?page=edit_Quotation&id=<?=$fil['Quotation_Docno']; ?>" >
	<img src="./images/edit.gif" style="cursor:pointer" alt="Complete">
	</a>
	</td>
	
	</tr>
	<? } ?>
	</table>
</div></div><br><br>


</body>
</html>
