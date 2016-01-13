<?
include("../../includes/config.php");

$txt_DC =trim($_POST['txt_DC']);
$txt_year =$_POST['txt_year'];
$txt_mouth =$_POST['txt_mouth'];
$Ym = $txt_year."-".$txt_mouth;

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

$sqlOp="select dc_groupname,dc_groupid from st_user_group_dc where dc_groupid='$txt_DC'";
$qryOp=sqlsrv_query($con,$sqlOp);
$deOp=sqlsrv_fetch_array($qryOp); //สำหรับเปิดชื่อศูนย์


$sqlVisit="select cast(a.Visit_Docdate  as date) as dateVisit 
from st_plan_visit_head  a left join st_user b
on  a.Createby =b.User_id
where  b.dc_groupid='$txt_DC'  and cast(a.Visit_Docdate  as date) like '$Ym%'
group by cast(a.Visit_Docdate  as date) ";
$qryVisit=sqlsrv_query($con,$sqlVisit);

//echo $sqlVisit;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>

<div class="fontBig">ศูนย์ <font color="#0066FF"><?=$deOp['dc_groupname'];?> </font> เดือน <font color="#0066FF"><?=$monthThai; ?></font> </div>
<div class="fontBig">สรุปยอดขายเฉลี่ย   <font color="#0066FF">  <? $row1=sqlsrv_query($con,$sqlVisit,$params,$options); $row1=sqlsrv_num_rows($row1); echo number_format($row1); ?></font> วันทำงาน </div>
<table border="1" cellspacing="1" cellpadding="1" align="center">



<tr class="mousechange">
<td width="10px" align="center" rowspan="2" bgcolor="#F0F0F0"  >ลำดับ</td>
<td width="150px" align="center" rowspan="2" bgcolor="#F0F0F0"  >เฉลี่ยCash Van</td>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">ชื่อ-นามสกุล</td>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">เยี่ยม</td>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">ซื้อ</td>

<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">บาท</td>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">CN</td>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">สุทธิ</td>
<!----
<td align="center"  colspan="4" bgcolor="#99CC99">คาราบาว</td> 
<td align="center"  colspan="4" bgcolor="#66CCFF">สตาร์ท พลัส ซิงค์</td> --->
<? 
		$ProductBy="select P_Code,PRODUCTNAME from st_item_product where prd_type_id='S001'  order  by P_Code asc ";
		$ProductBy=sqlsrv_query($con,$ProductBy,$params,$options); 
		$rowProductBy=sqlsrv_num_rows($ProductBy);
		$colsapan=$rowProductBy*5;
		$countProduct=0;
while($By=sqlsrv_fetch_array($ProductBy)) 
		{	$ByPro[]=$By['P_Code'];
			if($countProduct%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
			echo '<td align="center" colspan="4" bgcolor="'.$color.'">'.$By['PRODUCTNAME'].'</td>';
			 $countProduct++;
		}
?>
</tr>
<tr class="mousechange">
<!---
<td width="100px" align="center" bgcolor="#99CC99">ลัง</td>
<td width="100px" align="center" bgcolor="#99CC99">แพ็ค</td>
<td width="100px" align="center" bgcolor="#99CC99">บาท</td>
<td width="100px" align="center" bgcolor="#99CC99">ร้านซื้อ</td>

<td width="100px" align="center" bgcolor="#66CCFF">ลัง</td>
<td width="100px" align="center" bgcolor="#66CCFF">แพ็ค</td>
<td width="100px" align="center" bgcolor="#66CCFF">บาท</td>
<td width="100px" align="center" bgcolor="#66CCFF">ร้านซื้อ</td>--->
	<?
	for($i=0;$i<$countProduct;$i++)
	{	if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		echo '<td width="100px" align="center" bgcolor="'.$color.'">ลัง</td>
		<td width="100px" align="center" bgcolor="'.$color.'">แพ็ค</td>
		<td width="100px" align="center" bgcolor="'.$color.'">บาท</td>
		<td width="100px" align="center" bgcolor="'.$color.'">ร้านซื้อ</td>';
	}
	?>
</tr>

<? $r=1;  
$sql1="select User_id,name,surname,Salecode from st_user where dc_groupid='$txt_DC' and RoleID_Lineid='6_2'  and Salecode like 'V%'  
order by Salecode asc";
$qry1=sqlsrv_query($con,$sql1);	
while($re1=sqlsrv_fetch_array($qry1))  {?>
<tr class="mousechange">
<td bgcolor="#F0F0F0" class="mousechange">&nbsp;&nbsp;<? print $r;?></td>
<td bgcolor="#F0F0F0" class="mousechange">&nbsp;&nbsp;<?=$re1['Salecode'];?> </td>
<td bgcolor="#F0F0F0" class="mousechange">&nbsp;&nbsp;<?=$re1['name']." ".$re1['surname']; $sale=$re1['User_id'];?></td>
<td bgcolor="#F0F0F0" class="mousechange" align="center">
	<?
		
		$sqlVisitIn="select Count(distinct CustNum) as VisitIn from st_plan_visit_head where Createby='$sale'   and cast(Visit_Docdate as date)  like '$Ym%' and Check_status='O'";
		$sqlVisitIn=sqlsrv_query($con,$sqlVisitIn);
		$sqlVisitIn=sqlsrv_fetch_array($sqlVisitIn);
		echo $VisitIn= number_format($sqlVisitIn['VisitIn']/$row1);											
		$VisitInTotal =$VisitInTotal+$VisitIn; //รวมร้านเยี่ยม
	?>
</td>
<td bgcolor="#F0F0F0" align="center" class="mousechange">
	<?
		$sqlVisitBy="SELECT Count(distinct a.CustNum) as CountBy 
		FROM st_Sale_head a 
		LEFT OUTER JOIN st_CN_head  ON a.Sales_Docno = st_CN_head.Ref_Docno
		where  a.Createby='$sale'  
		and cast(a.Sales_Docdate as date)  like '$Ym%'
		AND a.totalall >0 AND (st_CN_head.CN_id != 1 OR st_CN_head.CN_id is null) ";
		$sqlVisitBy=sqlsrv_query($con,$sqlVisitBy);
		$sqlVisitBy=sqlsrv_fetch_array($sqlVisitBy);
		echo $CountBy=number_format($sqlVisitBy['CountBy']/$row1);											
		$CountByTotal = $CountByTotal+$CountBy;//รวมร้านซื้อ
		
	?>
</td>
<td bgcolor="#F0F0F0" align="center" class="mousechange">
	<?
		$sqlPrice="select sum(b.totalamount) as TotalPrice
			from st_Sale_head  a left join st_Sale_detail b
			on a.Sales_Docno = b.Sales_Docno 
			where a.Createby='$sale'  and cast(a.Sales_Docdate as date)  like '$Ym%' ";
		$sqlPrice=sqlsrv_query($con,$sqlPrice);
		$sqlPrice=sqlsrv_fetch_array($sqlPrice);
		$sumPrice=($sqlPrice['TotalPrice']/$row1);
		echo $TotalPrice= number_format($sqlPrice['TotalPrice']/$row1);										
		$SumTotalPrice = $SumTotalPrice+($sqlPrice['TotalPrice']/$row1);//รวมเงินบาท
	?>
</td>
<td align="center " bgcolor="#F0F0F0" class="mousechange">-
				<?
                 // CN  
				$sqlCN= "select sum(b.totalamount) as SumCN
				from st_Sale_head  a left join st_Sale_detail b
				on a.Sales_Docno = b.Sales_Docno  left join st_CN_detail CNd on a.Sales_Docno = CNd.Ref_Docno 
				and b.P_Code=CNd.P_Code left join st_CN_head CNh on CNd.Ref_Docno=CNh.Ref_Docno
				where a.Createby='$sale'  and cast(a.Sales_Docdate as date)  like '$Ym%'  and CNd.Ref_Docno is not null
				and CNh.CN_id='1'
				";
	            $sqlCN=sqlsrv_query($con,$sqlCN);
				$sqlCN=sqlsrv_fetch_array($sqlCN);
				$sumCN=($sqlCN['SumCN']/$row1);  
				echo number_format($sumCN);
				$TotalCNBy=$TotalCNBy+$sumCN;
			     //echo number_format($TotalCNBy,2,'.',',');  
				 
				//
				?>

			</td>
<td align="center " bgcolor="#F0F0F0" class="mousechange">
<? $net=$sumPrice-$sumCN;
 
 
 
 echo number_format($net);
 $Totalnet=$Totalnet+$net;
 ?>
</td>
<?
	for($i=0;$i<$countProduct;$i++)
	{	if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		$Pro=$ByPro[$i];
		//	left join st_CN_head CNh on CNd.Ref_Docno=CNh.Ref_Docno 
		//  and (CNd.Ref_Docno is null or  CNh.CN_id <>'1'  )
		$sqlfo1="select 
			sum(b.st_unit_qty_3) as QtyBottle
			,c.st_unit_qty as c
			,d.st_unit_qty as d
			,(sum(b.st_unit_qty_3)) / c.st_unit_qty as QtyBox
			,(sum(b.st_unit_qty_3)) % c.st_unit_qty as balanButtle
			,((sum(b.st_unit_qty_3)) % c.st_unit_qty)/(d.st_unit_qty) QtyPack
			 ,sum(b.totalamount) as TotalPrice_by
			from st_Sale_head  a left join st_Sale_detail b
			on a.Sales_Docno = b.Sales_Docno left join  st_item_unit_con c
			on b.P_Code =c.P_Code and c.st_unit_id ='ลัง'left join  st_item_unit_con d
			on b.P_Code = d.P_Code and d.st_unit_id ='แพ็ค' 
			left join st_CN_detail CNd on a.Sales_Docno = CNd.Ref_Docno and b.P_Code=CNd.P_Code
			left join st_CN_head CNh on CNd.Ref_Docno=CNh.Ref_Docno 
			where 
			a.Createby='$sale'  and cast(a.Sales_Docdate as date) like '$Ym%' 
			and b.P_Code='$Pro' 
			and (CNd.Ref_Docno is null or  CNh.CN_id <>'1'  )
			group by c.st_unit_qty,d.st_unit_qty ";
		$sqlfor1=sqlsrv_query($con,$sqlfo1);
		$sqlfor1=sqlsrv_fetch_array($sqlfor1);
		//echo number_format($sqlfor1['QtyBox']); 
		$QtyBox1=$QtyBox1+$sqlfor1['QtyBox'];
				
		$sqlfor11="select count(distinct a.CustNum) as CountBy
		from st_Sale_head a  left join st_Sale_detail b
		on a.Sales_Docno=b.Sales_Docno
		where cast(a.Sales_Docdate as date)  like '$Ym%'  and a.Createby='$sale' 
		and b.P_Code='$Pro' and b.st_unit_qty_3 <>0 ";
	
		$sqlfor11=sqlsrv_query($con,$sqlfor11);
		$sqlfor11=sqlsrv_fetch_array($sqlfor11);
		//$vs=($sqlfor11['CountBy']/$sqlVisitIn['VisitIn'])*100;
		 $QtyBox = number_format($sqlfor1['QtyBox']/$row1);
		 $QtyPack =number_format($sqlfor1['QtyPack']/$row1);
		 $TotalPrice_by =number_format($sqlfor1['TotalPrice_by']/$row1);
		 
		 $CountBy = number_format($sqlfor11['CountBy']/$row1);
		if($i==$i)
				{ 
				 $sum[$i]=$sum[$i]+($QtyBox);
				 $sumpack[$i]=$sumpack[$i]+($QtyPack); 
				 $sumTotalPriceBy[$i]=$sumTotalPriceBy[$i]+($sqlfor1['TotalPrice_by']/$row1);
				 //$TotalPrice_by=$TotalPrice_by+($sqlfor1['TotalPrice_by']/$row1);
				 $CountBy2[$i]=$CountBy2[$i]+$CountBy;
						 
				}
		 // echo number_format($vs33)."%";	
		 
		echo '<td width="100px" align="center" class="mousechange" bgcolor="'.$color.'">'.$QtyBox.'</td>
		<td width="100px" align="center" class="mousechange" bgcolor="'.$color.'">'.$QtyPack.'</td>
		<td width="100px" align="center" class="mousechange" bgcolor="'.$color.'">'.$TotalPrice_by.'</td>
		<td width="100px" align="center" class="mousechange" bgcolor="'.$color.'">'.$CountBy.'</td>';
	
	}
	
	?>


</tr>
<? $r++;} 

$row2=sqlsrv_query($con,$sql1,$params,$options);	
$row2=sqlsrv_num_rows($row2);
?>
<tr class="mousechange"  align="center">
<td colspan="3" align="center"  bgcolor="#F0F0F0" height="30">ยอดขายเฉลี่ย/ศูนย์/วัน  : <?=number_format($row1);?></td>
<td bgcolor="#F0F0F0" class="mousechange"><? echo number_format($VisitInTotal);?></td>
<td bgcolor="#F0F0F0" class="mousechange"><? echo number_format($CountByTotal);?></td>
<td bgcolor="#F0F0F0" class="mousechange"><? echo number_format($SumTotalPrice);?></td>
<td bgcolor="#F0F0F0" class="mousechange"><? echo number_format($TotalCNBy);?></td>
<td bgcolor="#F0F0F0" class="mousechange"><? echo number_format($Totalnet);?></td>
	<?
	for($i=0;$i<$countProduct;$i++)
	{	if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		echo '<td width="100px" align="center" class="mousechange" >'.number_format($sum[$i]).'</td>
		<td width="100px" align="center" class="mousechange" >'.number_format($sumpack[$i]).'</td>
		<td width="100px" align="center" class="mousechange" >'.number_format($sumTotalPriceBy[$i]).'</td>
		<td width="100px" align="center" class="mousechange" >'.number_format($CountBy2[$i]).'</td>';
	}
	?>
</tr>
<tr class="mousechange" class="mousechange"  align="center">
<td colspan="3" align="center"  bgcolor="#F0F0F0" height="30">ยอดขายเฉลี่ย/ศูนย์/คัน  : <?=number_format($row2);?></td>
<td bgcolor="#F0F0F0" class="mousechange"><? echo number_format($VisitInTotal/$row2);?></td>
<td bgcolor="#F0F0F0" class="mousechange"><? echo number_format($CountByTotal/$row2);?></td>
<td bgcolor="#F0F0F0" class="mousechange"><? echo number_format($SumTotalPrice/$row2);?></td>
<td bgcolor="#F0F0F0" class="mousechange"><? echo number_format($TotalCNBy/$row2);?></td>
<td bgcolor="#F0F0F0" class="mousechange"><? echo number_format($Totalnet/$row2);?></td>
	<?
	for($i=0;$i<$countProduct;$i++)
	{	if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		echo '<td width="100px" align="center" class="mousechange" >'.number_format($sum[$i]/$row2).'</td>
		<td width="100px" align="center"  class="mousechange">'.number_format($sumpack[$i]/$row2).'</td>
		<td width="100px" align="center"  class="mousechange" >'.number_format($sumTotalPriceBy[$i]/$row2).'</td>
		<td width="100px" align="center"  class="mousechange">'.number_format($CountBy2[$i]/$row2).'</td>';
	}
	?>
</tr>
<tr class="mousechange"  align="left"><td colspan="100"  bgcolor="#FFF" height="50">
*หมายเหตุ<br>
ยอดขายเฉลี่ย/ศูนย์/วัน คือ ยอดรวมของ Column <br>
ยอดขายเฉลี่ย/ศูนย์/คัน คือ ยอดรวมของ Column(หาร/)  จำนวนวรถของศูนย์
 </td>
 </tr>
</table>

</body>
</html>