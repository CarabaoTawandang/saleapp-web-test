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
						
						
$sql1="select distinct DATE_VISI 
from VISI_PLAN left join user_info
on VISI_PLAN.ID_SALE =user_info.userid left join userinfo_details
 on userinfo_details.userid=ID_SALE
where  DATE_VISI  like  '$MY%' and userinfo_details.dist_cd='$txt_DC'
 and user_info.userRole='4' and userinfo_details.userid like 'V%'
 and (VISI_PLAN.TIME_PLAN <>'88888'and VISI_PLAN.TIME_PLAN <>'99999' )
 order by DATE_VISI asc
";

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
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">ตลาดการทำงาน</td>
<td align="center"  colspan="5" bgcolor="#F3E2A9">ร้านค้าเยี่ยมและร้านค้าซื้อ</td> 

<td align="center"  colspan="5" bgcolor="#99CC99">คาราบาว</td> 
<td align="center"  colspan="5" bgcolor="#66CCFF">สตาร์ท พลัส ซิงค์</td> 
<td align="center"  colspan="3" bgcolor="#D8D8D8">ยอดขายรวมทุกผลิตภัณฑ์</td> 
<tr>
<td width="100px" align="center" bgcolor="#F3E2A9">ร้านครอบคลุม</td>
<td width="100px" align="center" bgcolor="#F3E2A9">ร้านเยี่ยม</td>
<td width="100px" align="center" bgcolor="#F3E2A9">ร้านชื้อ</td>
<td width="100px" align="center" bgcolor="#F3E2A9">%ซื้อ vs ครอบคลุม</td>
<td width="100px" align="center" bgcolor="#F3E2A9">%ซื้อ vs เยี่ยม</td>

<td width="100px" align="center" bgcolor="#99CC99">ลัง</td>
<td width="100px" align="center" bgcolor="#99CC99">แพ็ค</td>
<td width="100px" align="center" bgcolor="#99CC99">บาท</td>
<td width="100px" align="center" bgcolor="#99CC99">ร้านซื้อ</td>
<td width="100px" align="center" bgcolor="#99CC99">% เยี่ยม</td>

<td width="100px" align="center" bgcolor="#66CCFF">ลัง</td>
<td width="100px" align="center" bgcolor="#66CCFF">แพ็ค</td>
<td width="100px" align="center" bgcolor="#66CCFF">บาท</td>
<td width="100px" align="center" bgcolor="#66CCFF">ร้านซื้อ</td>
<td width="100px" align="center" bgcolor="#66CCFF">% เยี่ยม</td>

<td width="100px" align="center" bgcolor="#D8D8D8">ยอดขาย(ลัง)</td>
<td width="100px" align="center" bgcolor="#D8D8D8">ยอดขาย(แพ็ค)</td>
<td width="100px" align="center" bgcolor="#D8D8D8">ยอดขาย(บาท)</td>
</tr>

<? $r=1; while($re1=sqlsrv_fetch_array($qry1))
{?>
<tr align="center">
<td bgcolor="#F0F0F0" >&nbsp;&nbsp;<? print $r;?></td>
<td bgcolor="#F0F0F0" height="30" align="left">&nbsp;&nbsp;<?=date('d/m/Y',strtotime($re1['DATE_VISI'])); ?></td>
<td bgcolor="#F3E2A9">
<?
$sqlAllbyDate="select 
 count(ID_CUSTOMER) as countCustAll 
 
 FROM VISI_PLAN  left join userinfo_details
 on userinfo_details.userid=ID_SALE left join user_info
on VISI_PLAN.ID_SALE =user_info.userid

where userinfo_details.dist_cd='$txt_DC'
and DATE_PLAN =  '$re1[DATE_VISI]' and (TIME_PLAN <>'88888'and TIME_PLAN <>'99999' )
and user_info.userRole='4' and userinfo_details.userid like 'V%'";
$qryAllbyDate=sqlsrv_query($con,$sqlAllbyDate,$params,$options);
$reAllbyDate=sqlsrv_fetch_array($qryAllbyDate);
echo number_format($reAllbyDate['countCustAll']); $countCustAll=$countCustAll+$reAllbyDate['countCustAll'];
?>
</td>
<td bgcolor="#F3E2A9">
<?
$sqlIn ="select count(VISI_PLAN.ID_CUSTOMER)  as CountIn

 from VISI_PLAN  left join userinfo_details
 on userinfo_details.userid=ID_SALE left join user_info
on VISI_PLAN.ID_SALE =user_info.userid
where  VISI_PLAN.DATE_VISI = '$re1[DATE_VISI]'
and userinfo_details.dist_cd='$txt_DC' and user_info.userRole='4' and userinfo_details.userid like 'V%' ";
$qryIn=sqlsrv_query($con,$sqlIn,$params,$options);
$reIn=sqlsrv_fetch_array($qryIn);
echo $reIn['CountIn']; $CountIn =$CountIn+$reIn['CountIn'];
?>
</td>
<td bgcolor="#F3E2A9">
<?
$sqlBy ="SELECT count(Order_List.Customer_Id) as CountBy
 
 
  FROM Order_List left join userinfo_details
on userinfo_details.userid=Order_List.SaleCode left join user_info
on Order_List.SaleCode =user_info.userid


  where Order_List.Orderdate ='$re1[DATE_VISI]' 
   and Order_List.ApproverStatus='Y' and Order_List.Canceled='N' and Order_List.Customer_Id <>'' and Order_List.ORDERTYPE='0'
 and userinfo_details.dist_cd='$txt_DC' and user_info.userRole='4' and userinfo_details.userid like 'V%' ";
$qryBy=sqlsrv_query($con,$sqlBy,$params,$options);
$reBy=sqlsrv_fetch_array($qryBy);
echo $reBy['CountBy']; $CountBy=$CountBy+$reBy['CountBy'];

?>
</td>
<td bgcolor="#F3E2A9">
<?  //ร้านชื้อ/ร้านครอบคลุม
$vs1=($reBy['CountBy']/$reAllbyDate['countCustAll'])*100; 
echo number_format($vs1)."%"; 
$vs1Total=$vs1Total+$vs1;
?>
</td>
<td bgcolor="#F3E2A9">
<? //ร้านชื้อ/ร้านค้าเยี่ยม
$vs2=($reBy['CountBy']/$reIn['CountIn'])*100; 
echo number_format($vs2)."%";
$vs2Total=$vs2Total+$vs2;
?>
</td>
<!--------------Carabao----------->

<td bgcolor="#99CC99">
<?
$sqlCa="SELECT sum(QuantityMain) ,sum(QuantityMinor) ,(sum(QuantityMinor))
,(sum(QuantityMain)) as sumBoxCarabao
,(sum(QuantityMinor)) as PackCarabao
,sum(ORDER_DETAIL.Total) as OrderTotal

FROM Order_List left join ORDER_DETAIL
on Order_List.OrderID=ORDER_DETAIL.OrderID  left join userinfo_details
on userinfo_details.userid=Order_List.SaleCode left join user_info
on Order_List.SaleCode =user_info.userid

where Order_List.Orderdate ='$re1[DATE_VISI]' 
 and userinfo_details.dist_cd='$txt_DC' and user_info.userRole='4' and userinfo_details.userid like 'V%'
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG101401'  ";
$qryCa=sqlsrv_query($con,$sqlCa,$params,$options);
$reCa=sqlsrv_fetch_array($qryCa);
echo $reCa['sumBoxCarabao'];
$sumBoxCarabao =$sumBoxCarabao+$reCa['sumBoxCarabao'];

?>
</td>
<td bgcolor="#99CC99"><? echo $reCa['PackCarabao']; $PackCarabao=$PackCarabao+$reCa['PackCarabao'];?></td>
<td bgcolor="#99CC99"><? echo  number_format($reCa['OrderTotal']); $OrderTotal=$OrderTotal+$reCa['OrderTotal'];?></td>
<td bgcolor="#99CC99">
<?
$sqlByCa="SELECT count( distinct Order_List.Customer_Id) as CountByCArabao
FROM Order_List left join ORDER_DETAIL
on Order_List.OrderID=ORDER_DETAIL.OrderID left join userinfo_details
on userinfo_details.userid=Order_List.SaleCode left join user_info
on Order_List.SaleCode =user_info.userid

where Order_List.Orderdate ='$re1[DATE_VISI]' 
 and userinfo_details.dist_cd='$txt_DC' and user_info.userRole='4' and userinfo_details.userid like 'V%'
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG101401'";
$qryByCa=sqlsrv_query($con,$sqlByCa,$params,$options);
$reByCa=sqlsrv_fetch_array($qryByCa);
$rowByCa=sqlsrv_num_rows($qryByCa);
echo $reByCa['CountByCArabao']; $CountByCArabao=$CountByCArabao+$reByCa['CountByCArabao']; 

?>
</td>
<td bgcolor="#99CC99"><? $vs3=($reByCa['CountByCArabao']/$reIn['CountIn'])*100; echo number_format($vs3)."%"; $vs3Total=$vs3Total+$vs3;?></td>
	<!--------------Start ++------------>
<td bgcolor="#66CCFF">
<?
$sqlSP="SELECT sum(QuantityMain) ,sum(QuantityMinor) ,(sum(QuantityMinor))
,(sum(QuantityMain)) as sumBoxStart
,(sum(QuantityMinor))as PackStart
,sum(ORDER_DETAIL.Total) as OrderTotal

FROM Order_List left join ORDER_DETAIL
on Order_List.OrderID=ORDER_DETAIL.OrderID  left join userinfo_details
on userinfo_details.userid=Order_List.SaleCode left join user_info
on Order_List.SaleCode =user_info.userid

where Order_List.Orderdate ='$re1[DATE_VISI]' 
 and userinfo_details.dist_cd='$txt_DC' and user_info.userRole='4' and userinfo_details.userid like 'V%'
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG201401'";
$qrySP=sqlsrv_query($con,$sqlSP,$params,$options);
$reSP=sqlsrv_fetch_array($qrySP);
echo $reSP['sumBoxStart']; $sumBoxStart=$sumBoxStart+$reSP['sumBoxStart'];

?>
</td>
<td bgcolor="#66CCFF"><? echo $reSP['PackStart']; $PackStart=$PackStart+$reSP['PackStart'];?></td>
<td bgcolor="#66CCFF"><? echo  number_format($reSP['OrderTotal']); $OrderTotalSP=$OrderTotalSP+$reSP['OrderTotal'];?></td>
<td bgcolor="#66CCFF">
<?
$sqlBySP="SELECT count( distinct Order_List.Customer_Id) as CountByStart
FROM Order_List left join ORDER_DETAIL
on Order_List.OrderID=ORDER_DETAIL.OrderID left join userinfo_details
on userinfo_details.userid=Order_List.SaleCode left join user_info
on Order_List.SaleCode =user_info.userid

where Order_List.Orderdate ='$re1[DATE_VISI]' 
 and userinfo_details.dist_cd='$txt_DC' and user_info.userRole='4' and userinfo_details.userid like 'V%'
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG201401' ";
$qryBySP=sqlsrv_query($con,$sqlBySP,$params,$options);
$reBySP = sqlsrv_fetch_array($qryBySP);
$rowBySP=sqlsrv_num_rows($qryBySP);
echo $reBySP['CountByStart']; $CountByStart=$CountByStart+$reBySP['CountByStart'];

?>
</td>
<td bgcolor="#66CCFF"><? $vs33=($reBySP['CountByStart']/$reIn['CountIn'])*100; echo number_format($vs33)."%"; $vs33Total=$vs33Total+$vs33?></td>
	<!--------------รวม------------>
<td bgcolor="#D8D8D8"><? echo $sumBox=$reCa['sumBoxCarabao']+$reSP['sumBoxStart']; 					$sumBoxTotal=$sumBoxTotal+$sumBox;?></td>
<td bgcolor="#D8D8D8"><? echo $Pack=$reCa['PackCarabao']+$reSP['PackStart']; 						$PackTotal=$PackTotal+$Pack;?></td>
<td bgcolor="#D8D8D8"><?  $Order=$reCa['OrderTotal']+$reSP['OrderTotal']; echo number_format($Order);		$OrderTTotal=$OrderTTotal+$Order;?></td>
</tr>
<? $r++;}
?>


<tr align="center">
<td bgcolor="#D8D8D8" colspan="2"  height="30">ยอดรวมทั้งหมด</td>
<td bgcolor="#D8D8D8"><?=number_format($countCustAll);?></td>
<td bgcolor="#D8D8D8"><?=number_format($CountIn); ?></td>
<td bgcolor="#D8D8D8"><?=number_format($CountBy) ?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs1Total/$row1)."%";?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs2Total/$row1)."%";?></td>
<!--------------Carabao----------->

<td bgcolor="#D8D8D8"><?=number_format($sumBoxCarabao);?></td>
<td bgcolor="#D8D8D8"><?=number_format($PackCarabao); ?></td>
<td bgcolor="#D8D8D8"><?=number_format($OrderTotal); ?></td>
<td bgcolor="#D8D8D8"><?=number_format($CountByCArabao);?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs3Total/$row1)."%"; ?></td>
	<!--------------Start ++------------>
<td bgcolor="#D8D8D8"><?=number_format($sumBoxStart);?></td>
<td bgcolor="#D8D8D8"><?=number_format($PackStart);?></td>
<td bgcolor="#D8D8D8"><?=number_format($OrderTotalSP);?></td>
<td bgcolor="#D8D8D8"><?=number_format($CountByStart);?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs33Total/$row1)."%";?></td>

	<!--------------รวม------------>
<td bgcolor="#D8D8D8"><?=number_format($sumBoxTotal);?></td>
<td bgcolor="#D8D8D8"><?=number_format($PackTotal);?></td>
<td bgcolor="#D8D8D8"><?=number_format($OrderTTotal);?></td>
</tr>


<tr align="center">
<td bgcolor="#D8D8D8" colspan="2"  height="30">ยอดรวมเฉลี่ย/วัน/ศูนย์</td>
<td bgcolor="#D8D8D8"><?=number_format($countCustAll/$row1);?></td>
<td bgcolor="#D8D8D8"><?=number_format($CountIn/$row1); ?></td>
<td bgcolor="#D8D8D8"><?=number_format($CountBy/$row1) ?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs1Total/$row1)."%";?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs2Total/$row1)."%";?></td>
<!--------------Carabao----------->
<td bgcolor="#D8D8D8"><?=number_format($sumBoxCarabao/$row1);?></td>
<td bgcolor="#D8D8D8"><?=number_format($PackCarabao/$row1); ?></td>
<td bgcolor="#D8D8D8"><?=number_format($OrderTotal/$row1); ?></td>
<td bgcolor="#D8D8D8"><?=number_format($CountByCArabao/$row1);?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs3Total/$row1)."%"; ?></td>
	<!--------------Start ++------------>
<td bgcolor="#D8D8D8"><?=number_format($sumBoxStart/$row1);?></td>
<td bgcolor="#D8D8D8"><?=number_format($PackStart/$row1);?></td>
<td bgcolor="#D8D8D8"><?=number_format($OrderTotalSP/$row1);?></td>
<td bgcolor="#D8D8D8"><?=number_format($CountByStart/$row1);?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs33Total/$row1)."%";?></td>
	<!--------------รวม------------>
<td bgcolor="#D8D8D8"><?=number_format($sumBoxTotal/$row1);?></td>
<td bgcolor="#D8D8D8"><?=number_format($PackTotal/$row1);?></td>
<td bgcolor="#D8D8D8"><?=number_format($OrderTTotal/$row1);?></td>
</tr>
<?
$sql2="select userinfo_details.userid
,user_info.usernames
from userinfo_details left join user_info
on userinfo_details.userid=user_info.userid
where userinfo_details.dist_cd='$txt_DC'  and userinfo_details.userid like 'V%'  and user_info.userRole='4'
order by userinfo_details.userid asc";

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qry2=sqlsrv_query($con,$sql2,$params,$options);
$row2=sqlsrv_num_rows($qry2);
?>
<tr align="center">
<td bgcolor="#D8D8D8" colspan="2"  height="30">ยอดรวมเฉลี่ย/วัน/คัน  : <?=$row2;?></td>
<td bgcolor="#D8D8D8"><?=number_format(($countCustAll/$row1)/$row2);?></td>
<td bgcolor="#D8D8D8"><?=number_format(($CountIn/$row1)/$row2); ?></td>
<td bgcolor="#D8D8D8"><?=number_format(($CountBy/$row1)/$row2) ?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs1Total/$row1)."%";?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs2Total/$row1)."%";?></td>
<!--------------Carabao----------->

<td bgcolor="#D8D8D8"><?=number_format(($sumBoxCarabao/$row1)/$row2);?></td>
<td bgcolor="#D8D8D8"><?=number_format(($PackCarabao/$row1)/$row2); ?></td>
<td bgcolor="#D8D8D8"><?=number_format(($OrderTotal/$row1)/$row2); ?></td>
<td bgcolor="#D8D8D8"><?=number_format(($CountByCArabao/$row1)/$row2);?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs3Total/$row1)."%"; ?></td>
	<!--------------Start ++------------>
<td bgcolor="#D8D8D8"><?=number_format(($sumBoxStart/$row1)/$row2);?></td>
<td bgcolor="#D8D8D8"><?=number_format(($PackStart/$row1)/$row2);?></td>
<td bgcolor="#D8D8D8"><?=number_format(($OrderTotalSP/$row1)/$row2);?></td>
<td bgcolor="#D8D8D8"><?=number_format(($CountByStart/$row1)/$row2);?></td>
<td bgcolor="#D8D8D8"><?=number_format($vs33Total/$row1)."%";?></td>
	<!--------------รวม------------>
<td bgcolor="#D8D8D8"><?=number_format(($sumBoxTotal/$row1)/$row2);?></td>
<td bgcolor="#D8D8D8"><?=number_format(($PackTotal/$row1)/$row2);?></td>
<td bgcolor="#D8D8D8"><?=number_format(($OrderTTotal/$row1)/$row2);?></td>
</tr>
</tr>
<tr align="left"><td colspan="10"  bgcolor="#FFF" height="70">
*หมายเหตุ<br>
ยอดรวมทั้งหมด คือ ยอดรวมของ Column <br>
ยอดรวมเฉลี่ย/วัน/ศูนย์ คือ ยอดรวมของ Column (หาร/)  จำนวนวันที่ทำงาน <br>
ยอดรวมเฉลี่ย/คัน/ศูนย์ คือ  ยอดรวมของ Column (หาร/)  จำนวนวนรถของศูนย์ <br>
 </tr>
</table>

</body>
</html>