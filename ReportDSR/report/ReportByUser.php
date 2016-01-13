<?
include("../includes/config.php");

$sale=$_POST['txt_Sale'];
$month=$_POST['txt_year'].$_POST['txt_mouth'];
 /*$sql1="select VISI_PLAN.ID_SALE, VISI_PLAN.DATE_PLAN 
,user_info.usernames , count(ID_CUSTOMER) as countCustAll
FROM VISI_PLAN left join user_info
on VISI_PLAN.ID_SALE =user_info.userid
where VISI_PLAN.ID_SALE='$sale' 
and VISI_PLAN.DATE_PLAN like '$month%' and (VISI_PLAN.TIME_PLAN <>'88888'and VISI_PLAN.TIME_PLAN <>'99999' ) 
group by VISI_PLAN.ID_SALE,  VISI_PLAN.DATE_PLAN ,user_info.usernames
order by VISI_PLAN.DATE_PLAN  asc ";
*/

$sql1="select distinct DATE_PLAN  ,user_info.usernames
from VISI_PLAN left join user_info
on VISI_PLAN.ID_SALE =user_info.userid
where ID_SALE='$sale' and DATE_VISI  like  '$month%' order by DATE_PLAN asc";

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qry1=sqlsrv_query($con,$sql1,$params,$options);
$row1=sqlsrv_num_rows($qry1);

$qry=sqlsrv_query($con,$sql1,$params,$options);
$re=sqlsrv_fetch_array($qry);

$monthNum=substr($month,4,2);
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
<div class="fontBig">ใบสรุปยอดขายประจำวัน</div>
<div class="fontBig">เดือน <font color="#0066FF"><?=$monthThai;?> </font> จำนวนวันทำงาน <font color="#0066FF"><?=$row1; ?></font> </div>
<div class="fontBig">ชื่อพนักงานขาย <font color="#0066FF"><?=$re['usernames'];?></font>    ผู้ช่วย<font color="#0066FF">........................</font></div>
<div class="fontBig">รหัสเขตการขาย <font color="#0066FF"><?=$sale;?></font> Trainer<font color="#0066FF">........................</font></div>
<table border="1" cellspacing="1" cellpadding="1" align="center">



<tr>

<td width="200px" align="center" rowspan="3">วัน/เดือน/ปี</td>
<td align="center"  colspan="2">ชื่อตลาดทำงาน</td>
<td align="center"  colspan="5" bgcolor="#FFFFCC">ร้านค้าเยี่ยมและร้านค้าซื้อ</td>
<td width="100px" align="center"  colspan="10" bgcolor="#99CC99">Sales (Baht) และ Effective Call  รายผลิตภัณฑ์</td>
<td align="center"  colspan="3" bgcolor="#F0F0F0">ยอดขายรวมทุกผลิตภัณฑ์</td>
</tr>

<tr>
<td width="100px" align="center"  rowspan="2">ตำบล</td>
<td width="100px" align="center"  rowspan="2">อำเภอ</td>

<td width="100px" align="center" rowspan="2" bgcolor="#FFFFCC">ร้านครอบคลุม</td>
<td width="100px" align="center" rowspan="2" bgcolor="#FFFFCC">ร้านเยี่ยม</td>
<td width="100px" align="center" rowspan="2" bgcolor="#FFFFCC">ร้านชื้อ</td>
<td width="100px" align="center" rowspan="2" bgcolor="#FFFFCC">%ซื้อ vs ครอบคลุม</td>
<td width="100px" align="center" rowspan="2" bgcolor="#FFFFCC">%ซื้อ vs เยี่ยม</td>



<td align="center"  colspan="5" bgcolor="#99CC99">คาราบาว</td> 
<td align="center"  colspan="5" bgcolor="#66CCFF">สตาร์ท พลัส ซิงค์</td> 

<td width="100px" align="center" rowspan="2" bgcolor="#F0F0F0">ยอดขาย(ลัง)</td>
<td width="100px" align="center" rowspan="2" bgcolor="#F0F0F0">ยอดขาย(แพ็ค)</td>
<td width="100px" align="center" rowspan="2" bgcolor="#F0F0F0">ยอดขาย(บาท)</td>
</tr>


<tr>

<td width="100px" align="center" bgcolor="#99CC99">ยอดขาย(ลัง)</td>
<td width="100px" align="center" bgcolor="#99CC99">ยอดขาย(แพ็ค)</td>
<td width="100px" align="center" bgcolor="#99CC99">ยอดขาย(บาท)</td>
<td width="100px" align="center" bgcolor="#99CC99">ร้านซื้อ</td>
<td width="100px" align="center" bgcolor="#99CC99">% เยี่ยม</td>
<td width="100px" align="center" bgcolor="#66CCFF">ยอดขาย(ลัง)</td>
<td width="100px" align="center" bgcolor="#66CCFF">ยอดขาย(แพ็ค)</td>
<td width="100px" align="center" bgcolor="#66CCFF">ยอดขาย(บาท)</td>
<td width="100px" align="center" bgcolor="#66CCFF">ร้านซื้อ</td>
<td width="100px" align="center" bgcolor="#66CCFF">% เยี่ยม</td>

</tr>

<?while($re1=sqlsrv_fetch_array($qry1))
{ 		//if($a%2==0){$col="#EEEEEE";}else{$col="#F2FAEB";}? 
		$expArray2 = explode(" ",$re1['usernames']);
		//echo "ตัวแปร \$explode2[0] = $expArray2[0]< br>";
?>
<tr align="center">

<td height="25"><?=date('d/m/Y',strtotime($re1['DATE_PLAN'])); ?></td>

<td>
<?
$sqlDis="select 
BCAR2.billsubdist as dis
,TB_Town.Town_Name  as disName
,count(BCAR2.billsubdist) as disCount

,TB_Section.Section_Name as amuName
,TB_Department.Department_Name as ProName
FROM VISI_PLAN  left join BCAR2 
on VISI_PLAN.ID_CUSTOMER=BCAR2.Code left join TB_Town
on BCAR2.billsubdist  = TB_Town.Town_ID left join TB_Section
on BCAR2.GroupCode= TB_Section.Section_ID left join TB_Department
on BCAR2.RouteID= TB_Department.Department_ID


where VISI_PLAN.ID_SALE='$sale' 
and VISI_PLAN.DATE_PLAN = '$re1[DATE_PLAN]' 
and (VISI_PLAN.TIME_PLAN <>'88888'and VISI_PLAN.TIME_PLAN <>'99999' )


group by BCAR2.billsubdist ,TB_Town.Town_Name  ,TB_Section.Section_Name ,TB_Department.Department_Name 

order by  count(BCAR2.billsubdist) desc";
$qryDis=sqlsrv_query($con,$sqlDis,$params,$options);
$reD=sqlsrv_fetch_array($qryDis);
echo $reD['disName'];
?>
</td>
<td><?=$reD['amuName'];?></td>

<td bgcolor="#FFFFCC">
<? 
	$sql2="select count(ID_CUSTOMER) as countCustAll FROM VISI_PLAN where ID_SALE='$sale' and DATE_PLAN = '$re1[DATE_PLAN]' and (TIME_PLAN <>'88888'and TIME_PLAN <>'99999' ) ";
	$qry2=sqlsrv_query($con,$sql2,$params,$options);
	$re2=sqlsrv_fetch_array($qry2);
	echo $re2['countCustAll']; $countCustAll=$countCustAll+$re2['countCustAll'];
?></td>
<td bgcolor="#FFFFCC">
<?
$sqlIn ="select count(ID_CUSTOMER)  as CountIn from VISI_PLAN
where ID_SALE='$sale' and DATE_VISI = '$re1[DATE_PLAN]'";
$qryIn=sqlsrv_query($con,$sqlIn,$params,$options);
$reIn=sqlsrv_fetch_array($qryIn);
echo $reIn['CountIn']; $CountIn=$CountIn+$reIn['CountIn'];
?>
</td>
<td bgcolor="#FFFFCC">
<?
$sqlBy ="SELECT count(Customer_Id) as CountBy
  FROM Order_List where Orderdate ='$re1[DATE_PLAN]' and SaleCode='$sale' and ApproverStatus='Y'
  and Canceled='N' and Customer_Id <>'' and ORDERTYPE='0'";
$qryBy=sqlsrv_query($con,$sqlBy,$params,$options);
$reBy=sqlsrv_fetch_array($qryBy);
echo $reBy['CountBy']; $CountBy=$CountBy+$reBy['CountBy'];

?>
</td>
<td bgcolor="#FFFFCC"><? $vs1=($reBy['CountBy']/$re2['countCustAll'])*100; echo number_format($vs1)."%"; $vs1Total=$vs1Total+$vs1;?></td>
<td bgcolor="#FFFFCC"><? $vs2=($reBy['CountBy']/$reIn['CountIn'])*100; echo number_format($vs2)."%"; $vs2Total=$vs2Total+$vs2;?></td>


<!-----------------Carabao--->
<td bgcolor="#99CC99">
<?
$sqlCa="SELECT sum(QuantityMain) ,sum(QuantityMinor) ,(sum(QuantityMinor))
,(sum(QuantityMain)) as sumBoxCarabao
,(sum(QuantityMinor)) as PackCarabao
,sum(ORDER_DETAIL.Total) as OrderTotal

FROM Order_List left join ORDER_DETAIL
on Order_List.OrderID=ORDER_DETAIL.OrderID

where Order_List.Orderdate ='$re1[DATE_PLAN]' 
and Order_List.SaleCode='$sale' 
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG101401' ";
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
on Order_List.OrderID=ORDER_DETAIL.OrderID

where Order_List.Orderdate ='$re1[DATE_PLAN]' 
and Order_List.SaleCode='$sale' 
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG101401'
 ";
$qryByCa=sqlsrv_query($con,$sqlByCa,$params,$options);
$reByCa=sqlsrv_fetch_array($qryByCa);
$rowByCa=sqlsrv_num_rows($qryByCa);
echo $reByCa['CountByCArabao']; $CountByCArabao=$CountByCArabao+$reByCa['CountByCArabao']; 

?>
</td>
<td bgcolor="#99CC99"><? $vs3=($reByCa['CountByCArabao']/$reIn['CountIn'])*100; echo number_format($vs3)."%"; $vs3Total=$vs3Total+$vs3;?></td>


<!-----------------StartP++--->
<td bgcolor="#66CCFF">
<?
$sqlSP="SELECT sum(QuantityMain) ,sum(QuantityMinor) ,(sum(QuantityMinor))
,(sum(QuantityMain)) as sumBoxStart
,(sum(QuantityMinor))as PackStart
,sum(ORDER_DETAIL.Total) as OrderTotal

FROM Order_List left join ORDER_DETAIL
on Order_List.OrderID=ORDER_DETAIL.OrderID

where Order_List.Orderdate ='$re1[DATE_PLAN]' 
and Order_List.SaleCode='$sale' 
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG201401' ";
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
on Order_List.OrderID=ORDER_DETAIL.OrderID

where Order_List.Orderdate ='$re1[DATE_PLAN]' 
and Order_List.SaleCode='$sale' 
and Order_List.ApproverStatus='Y'
and Order_List.Canceled='N' 
and Order_List.Customer_Id <>'' 
and Order_List.ORDERTYPE='0'
and ORDER_DETAIL.ProductID='FG201401'
 ";
$qryBySP=sqlsrv_query($con,$sqlBySP,$params,$options);
$reBySP = sqlsrv_fetch_array($qryBySP);
$rowBySP=sqlsrv_num_rows($qryBySP);
echo $reBySP['CountByStart']; $CountByStart=$CountByStart+$reBySP['CountByStart'];

?>
</td>
<td bgcolor="#66CCFF"><? $vs33=($reBySP['CountByStart']/$reIn['CountIn'])*100; echo number_format($vs33)."%"; $vs33Total=$vs33Total+$vs33?></td>

<td bgcolor="#F0F0F0"><? echo $sumBox=$reCa['sumBoxCarabao']+$reSP['sumBoxStart']; 					$sumBoxTotal=$sumBoxTotal+$sumBox;?></td>
<td bgcolor="#F0F0F0"><? echo $Pack=$reCa['PackCarabao']+$reSP['PackStart']; 						$PackTotal=$PackTotal+$Pack;?></td>
<td bgcolor="#F0F0F0"><?  $Order=$reCa['OrderTotal']+$reSP['OrderTotal']; echo number_format($Order);		$OrderTTotal=$OrderTTotal+$Order;?></td>

</tr>
<? } ?>

<tr align="center">
<td colspan="3" align="center"  bgcolor="#F0F0F0" height="30">ยอดรวมทั้งหมด</td>
<td bgcolor="#F0F0F0"><?=number_format($countCustAll);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountIn);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountBy);?></td>
<td bgcolor="#F0F0F0"><?=number_format($vs1Total/$row1)."%";?></td>
<td bgcolor="#F0F0F0"><?=number_format($vs2Total/$row1)."%";?></td>

<td bgcolor="#F0F0F0"><?=number_format($sumBoxCarabao); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($PackCarabao); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($OrderTotal); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountByCArabao);?></td>
<td bgcolor="#F0F0F0"><?=number_format($vs3Total/$row1)."%"; ?></td>

<td bgcolor="#F0F0F0"><?=number_format($sumBoxStart);?></td>
<td bgcolor="#F0F0F0"><?=number_format($PackStart);?></td>
<td bgcolor="#F0F0F0"><?=number_format($OrderTotalSP);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountByStart);?></td>
<td bgcolor="#F0F0F0"><?=number_format($vs33Total/$row1)."%";?></td>

<td bgcolor="#F0F0F0"><?=number_format($sumBoxTotal);?></td>
<td bgcolor="#F0F0F0"><?=number_format($PackTotal);?></td>
<td bgcolor="#F0F0F0"><?=number_format($OrderTTotal);?></td>
</tr>

<tr  align="center">
<td colspan="3" align="center"  bgcolor="#F0F0F0"  height="30" >ยอดรวมเฉลี่ย/วัน</td>
<td bgcolor="#F0F0F0"><?=number_format($countCustAll/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountIn/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountBy/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($vs1Total/$row1)."%";?></td>
<td bgcolor="#F0F0F0"><?=number_format($vs2Total/$row1)."%";?></td>

<td bgcolor="#F0F0F0"><?=number_format($sumBoxCarabao/$row1); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($PackCarabao/$row1); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($OrderTotal/$row1); ?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountByCArabao/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($vs3Total/$row1)."%"; ?></td>

<td bgcolor="#F0F0F0"><?=number_format($sumBoxStart/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($PackStart/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($OrderTotalSP/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($CountByStart/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($vs33Total/$row1)."%";?></td>

<td bgcolor="#F0F0F0"><?=number_format($sumBoxTotal/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($PackTotal/$row1);?></td>
<td bgcolor="#F0F0F0"><?=number_format($OrderTTotal/$row1);?></td>
</tr>
<tr align="left"><td colspan="10"  bgcolor="#FFF" height="70">
*หมายเหตุ<br>
ยอดรวมทั้งหมด คือ ยอดรวมของ Column <br>
ยอดรวมเฉลี่ย/วัน  คือ ยอดรวมของ Column (หาร/)  จำนวนวันที่ทำงาน <br>
 </tr>
</table>

</body>
</html>