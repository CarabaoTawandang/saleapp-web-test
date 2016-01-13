<?
include("../includes/config.php");

$txt_DC =$_POST['txt_DC'];
$txt_year =$_POST['txt_year'];
$txt_mouth =$_POST['txt_mouth'];

$MY=$txt_year.$txt_mouth;

$sql="select DIST_CD ,DIST_SHORTNAME ,DIST_NAME from DC_MASTER  where DIST_CD='$txt_DC'  ";
$params = array();
$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qry=sqlsrv_query($con,$sql,$params,$options);
$row=sqlsrv_num_rows($qry);
$detail=sqlsrv_fetch_array($qry);
						
						
$sql1="select userinfo_details.userid
,user_info.usernames
from userinfo_details left join user_info
on userinfo_details.userid=user_info.userid
where userinfo_details.dist_cd='$txt_DC'  and userinfo_details.userid like 'V%'  and user_info.userRole='4'
order by userinfo_details.userid asc";

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qry1=sqlsrv_query($con,$sql1,$params,$options);
$row1=sqlsrv_num_rows($qry1);

$monthNum=$txt_mouth;
if($monthNum=="01"){$monthThai="มกราคม";}
if($monthNum=="02"){$monthThai="กุมภาพันธ์";}
if($monthNum=="03"){$monthThai="มีนาคม";}
if($monthNum=="04"){$monthThai="เมษายน";}
if($monthNum=="05"){$monthThai="พฤษภาคม";}

if($monthNum=="06"){$monthThai="มิถุนายน";}
if($monthNum=="07"){$monthThai="กรกฏาคม";}

if($monthNum=="08"){$monthThai="สิงหาคม";}
if($monthNum=="09"){$monthThai="กันยายน";}
if($monthNum=="10"){$monthThai="ตุลาคม";}
if($monthNum=="11"){$monthThai="พฤศจิกายน";}
if($monthNum=="12"){$monthThai="ธันวาคม";}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<div class="fontBig">ศูนย์ <font color="#0066FF"><?=$detail['DIST_NAME'];?> </font> เดือน <font color="#0066FF"><?=$monthThai; ?></font> </div>
<div class="fontBig">สรุปยอดขายเฉลี่ย   <font color="#0066FF"> 24 </font> วันทำงาน </div>
<table border="1" cellspacing="1" cellpadding="1" align="center">



<tr>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">ลำดับ</td>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">เฉลี่ย</td>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">เยี่ยม</td>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">ซื้อ</td>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">บาท</td>
<td align="center"  colspan="4" bgcolor="#99CC99">คาราบาว</td> 
<td align="center"  colspan="4" bgcolor="#66CCFF">สตาร์ท พลัส ซิงค์</td> 

<tr>

<td width="100px" align="center" bgcolor="#99CC99">ลัง</td>
<td width="100px" align="center" bgcolor="#99CC99">แพ็ค</td>
<td width="100px" align="center" bgcolor="#99CC99">บาท</td>
<td width="100px" align="center" bgcolor="#99CC99">ร้านซื้อ</td>

<td width="100px" align="center" bgcolor="#66CCFF">ลัง</td>
<td width="100px" align="center" bgcolor="#66CCFF">แพ็ค</td>
<td width="100px" align="center" bgcolor="#66CCFF">บาท</td>
<td width="100px" align="center" bgcolor="#66CCFF">ร้านซื้อ</td>

</tr>

<? $r=1; while($re1=sqlsrv_fetch_array($qry1))
{?>
<tr align="center">
<td bgcolor="#F0F0F0" >&nbsp;&nbsp;<? print $r;?></td>
<td bgcolor="#F0F0F0" height="30" align="left">&nbsp;&nbsp;<? print $re1['userid']." ".$re1['usernames'];?></td>
<td bgcolor="#F0F0F0">
<?
$sqlTotalIn="select count(ID_CUSTOMER) as CustIn ,count(distinct DATE_VISI) as CountDate from VISI_PLAN where ID_SALE='$re1[userid]' and DATE_VISI like '$MY%'";
$qryTotalIn=sqlsrv_query($con,$sqlTotalIn,$params,$options);
$reTotalIn=sqlsrv_fetch_array($qryTotalIn);
$CountIn=round($reTotalIn['CustIn']/$reTotalIn['CountDate']); $CountInTotal=$CountInTotal+$CountIn;
echo number_format($CountIn);
?>
</td>
<td bgcolor="#F0F0F0">
<?
$sqlBy ="SELECT count(Customer_Id) as CountBy
  FROM Order_List where Orderdate like '$MY%' and SaleCode='$re1[userid]' and ApproverStatus='Y'
  and Canceled='N' and Customer_Id <>'' and ORDERTYPE='0'";
$qryBy=sqlsrv_query($con,$sqlBy,$params,$options);
$reBy=sqlsrv_fetch_array($qryBy);
$CountBy=round($reBy['CountBy']/$reTotalIn['CountDate']); $CountByTotal=$CountByTotal+$CountBy;
echo number_format($CountBy);

?>
</td>
<td bgcolor="#F0F0F0">
<?
$sqlPrice="SELECT 
sum(ORDER_DETAIL.Total) as OrderTotal

FROM Order_List left join ORDER_DETAIL
on Order_List.OrderID=ORDER_DETAIL.OrderID

where Order_List.Orderdate  like '$MY%' 
and Order_List.SaleCode='$re1[userid]' 
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'";
$qryPrice=sqlsrv_query($con,$sqlPrice,$params,$options);
$rePrice=sqlsrv_fetch_array($qryPrice);
$CountPrice=round($rePrice['OrderTotal']/$reTotalIn['CountDate']); $CountPriceTotal=$CountPriceTotal+$CountPrice;
echo number_format($CountPrice);
?>
</td>

<td bgcolor="#99CC99">
<?
$sqlCa="SELECT
(sum(QuantityMain)) as sumBoxCarabao
,(sum(QuantityMinor)) as PackCarabao
,sum(ORDER_DETAIL.Total) as OrderTotal

FROM Order_List left join ORDER_DETAIL
on Order_List.OrderID=ORDER_DETAIL.OrderID

where Order_List.Orderdate  like '$MY%' 
and Order_List.SaleCode='$re1[userid]'
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG101401' ";
$qryCa=sqlsrv_query($con,$sqlCa,$params,$options);
$reCa=sqlsrv_fetch_array($qryCa);
//echo $reCa['sumBoxCarabao'];
$CountBoxCarabao=round($reCa['sumBoxCarabao']/$reTotalIn['CountDate']); $CountBoxCarabaoTotal=$CountBoxCarabaoTotal+$CountBoxCarabao;
echo number_format($CountBoxCarabao);
?>
</td>
<td bgcolor="#99CC99">
<?
$CountPackCarabao=round($reCa['PackCarabao']/$reTotalIn['CountDate']); $CountPackCarabaoTotal=$CountPackCarabaoTotal+$CountPackCarabao;
echo number_format($CountPackCarabao);
?>
</td>
<td bgcolor="#99CC99">
<?
$CountOrderTotalCa=round($reCa['OrderTotal']/$reTotalIn['CountDate']); $CountOrderTotalCaTotal=$CountOrderTotalCaTotal+$CountOrderTotalCa;
echo number_format($CountOrderTotalCa);
?>
</td>
<td bgcolor="#99CC99">
<?
$sqlByIn="SELECT Order_List.Orderdate,Order_List.Customer_Id,count( Order_List.Customer_Id) as CountByStart
FROM Order_List left join ORDER_DETAIL
on Order_List.OrderID=ORDER_DETAIL.OrderID

where Order_List.Orderdate   like '$MY%'
and Order_List.SaleCode='$re1[userid]' 
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG101401'
group by Order_List.Orderdate,Order_List.Customer_Id ";
$qryByIn=sqlsrv_query($con,$sqlByIn,$params,$options);
$rowByIn=sqlsrv_num_rows($qryByIn);
$detailByIn=sqlsrv_fetch_array($qryByIn);
$CountByIn=round($rowByIn/$reTotalIn['CountDate']); $CountByInTotal=$CountByInTotal+$CountByIn;
echo number_format($CountByIn);

?>
</td>
	<!--------------Start ++------------>
<td bgcolor="#66CCFF">
<?
$sqlSP="SELECT
(sum(QuantityMain)) as sumBoxStart
,(sum(QuantityMinor)) as PackStart
,sum(ORDER_DETAIL.Total) as OrderTotalSP

FROM Order_List left join ORDER_DETAIL
on Order_List.OrderID=ORDER_DETAIL.OrderID

where Order_List.Orderdate  like '$MY%' 
and Order_List.SaleCode='$re1[userid]'
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG201401' ";
$qrySP=sqlsrv_query($con,$sqlSP,$params,$options);
$reSP=sqlsrv_fetch_array($qrySP);
//echo $reCa['sumBoxCarabao'];
$CountBoxSP=round($reSP['sumBoxStart']/$reTotalIn['CountDate']); $CountBoxSPTotal=$CountBoxSPTotal+$CountBoxSP;
echo number_format($CountBoxSP);
?>
</td>
<td bgcolor="#66CCFF">
<?
$CountPackSP=round($reSP['PackStart']/$reTotalIn['CountDate']); $CountPackSPTotal=$CountPackSPTotal+$CountPackSP;
echo number_format($CountPackSP);
?>
</td>
<td bgcolor="#66CCFF">
<?
$CountOrderSP=round($reSP['OrderTotalSP']/$reTotalIn['CountDate']); $CountOrderSPTotal=$CountOrderSPTotal+$CountOrderSP;
echo number_format($CountOrderSP);
?>
</td>
<td bgcolor="#66CCFF">
<?
$sqlByIn2="SELECT Order_List.Orderdate,Order_List.Customer_Id,count( Order_List.Customer_Id) as CountByStart
FROM Order_List left join ORDER_DETAIL
on Order_List.OrderID=ORDER_DETAIL.OrderID

where Order_List.Orderdate   like '$MY%'
and Order_List.SaleCode='$re1[userid]' 
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG201401'
group by Order_List.Orderdate,Order_List.Customer_Id ";
$qryByIn2=sqlsrv_query($con,$sqlByIn2,$params,$options);
$rowByIn2=sqlsrv_num_rows($qryByIn2);
$detailByIn2=sqlsrv_fetch_array($qryByIn2);
$CountByIn2=round($rowByIn2/$reTotalIn['CountDate']); $CountByIn2Total=$CountByIn2Total+$CountByIn2;
echo number_format($CountByIn2);

?>
</td>
</tr>
<? $r++;}
?>
<tr align="center">
<td colspan="2" align="center"  bgcolor="#F0F0F0" height="30">ยอดขายเฉลี่ย/ศูนย์/วัน</td>
<td bgcolor="#F0F0F0"><?=number_format($CountInTotal);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountByTotal);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountPriceTotal);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountBoxCarabaoTotal);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountPackCarabaoTotal);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountOrderTotalCaTotal); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountByInTotal); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountBoxSPTotal); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountPackSPTotal);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountOrderSPTotal); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountByIn2Total);?></td>
</tr>
<tr align="center">
<td colspan="2" align="center"  bgcolor="#F0F0F0" height="30">ยอดขายเฉลี่ย/ศูนย์/คัน</td>
<td bgcolor="#F0F0F0"><?=number_format($CountInTotal/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountByTotal/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountPriceTotal/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountBoxCarabaoTotal/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountPackCarabaoTotal/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountOrderTotalCaTotal/$row1); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountByInTotal/$row1); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountBoxSPTotal/$row1); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountPackSPTotal/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountOrderSPTotal/$row1); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountByIn2Total/$row1);?></td>
</tr>
<tr align="left"><td colspan="10"  bgcolor="#FFF" height="50">
*หมายเหตุ<br>
ยอดขายเฉลี่ย/ศูนย์/วัน คือ ยอดรวมของ Column <br>
ยอดขายเฉลี่ย/ศูนย์/คัน คือ ยอดรวมของ Column(หาร/)  จำนวนวรถของศูนย์
 </td>
 </tr>
</table>

</body>
</html>