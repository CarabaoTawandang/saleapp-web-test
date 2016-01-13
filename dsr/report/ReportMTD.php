<?
include("../../includes/config.php");

$txt_DC =$_POST['txt_DC'];
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
where b.dc_groupid='$txt_DC'   and cast(a.Visit_Docdate  as date) like '$Ym%'
group by cast(a.Visit_Docdate  as date) order by cast(a.Visit_Docdate  as date)  asc ";
$qryVisit=sqlsrv_query($con,$sqlVisit);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<div class="fontBig">ศูนย์ <font color="#0066FF"><?=$deOp['dc_groupname'];?></font> เดือน <font color="#0066FF"><?=$monthThai; ?></font> </div>
<div class="fontBig">สรุปยอดขายเฉลี่ย   <font color="#0066FF"> <? $row1=sqlsrv_query($con,$sqlVisit,$params,$options);  $row1=sqlsrv_num_rows($row1);  echo number_format($row1); ?> </font> 
วันทำงาน </div>
<table border="1" cellspacing="1" cellpadding="1" align="center">



<tr>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">ลำดับ</td>
<td width="200px" align="center" rowspan="2" bgcolor="#F0F0F0">ตลาดการทำงาน<br>(วันที่)</td>
<td align="center"  colspan="5" bgcolor="#F3E2A9">ร้านค้าเยี่ยมและร้านค้าซื้อ</td> 

<!--<td align="center"  colspan="5" bgcolor="#99CC99">คาราบาว</td> 
<td align="center"  colspan="5" bgcolor="#66CCFF">สตาร์ท พลัส ซิงค์</td> --->
<? 
		$ProductBy="select P_Code,PRODUCTNAME from st_item_product where prd_type_id='S001'  order  by P_Code asc ";
		$ProductBy=sqlsrv_query($con,$ProductBy,$params,$options); 
		$rowProductBy=sqlsrv_num_rows($ProductBy);
		$colsapan=$rowProductBy*5;
		$countProduct=0;
while($By=sqlsrv_fetch_array($ProductBy)) 
		{	$ByPro[]=$By['P_Code'];
			if($countProduct%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
			echo '<td align="center" colspan="5" bgcolor="'.$color.'">'.$By['PRODUCTNAME'].'</td>';
			 $countProduct++;
		}
?>

<td align="center"  colspan="3" bgcolor="#D8D8D8">ยอดขายรวมทุกผลิตภัณฑ์</td> 
<tr>
<td width="100px" align="center" bgcolor="#F3E2A9">ร้านครอบคลุม</td>
<td width="100px" align="center" bgcolor="#F3E2A9">ร้านเยี่ยม</td>
<td width="100px" align="center" bgcolor="#F3E2A9">ร้านชื้อ</td>
<td width="100px" align="center" bgcolor="#F3E2A9">%ซื้อ vs ครอบคลุม</td>
<td width="100px" align="center" bgcolor="#F3E2A9">%ซื้อ vs เยี่ยม</td>
<!---
<td width="100px" align="center" bgcolor="#99CC99">ลัง</td>
<td width="100px" align="center" bgcolor="#99CC99">แพ็ค</td>
<td width="100px" align="center" bgcolor="#99CC99">บาท</td>
<td width="100px" align="center" bgcolor="#99CC99">ร้านซื้อ</td>
<td width="100px" align="center" bgcolor="#99CC99">% เยี่ยม</td>

<td width="100px" align="center" bgcolor="#66CCFF">ลัง</td>
<td width="100px" align="center" bgcolor="#66CCFF">แพ็ค</td>
<td width="100px" align="center" bgcolor="#66CCFF">บาท</td>
<td width="100px" align="center" bgcolor="#66CCFF">ร้านซื้อ</td>
<td width="100px" align="center" bgcolor="#66CCFF">% เยี่ยม</td>---->
<?
	for($i=0;$i<$countProduct;$i++)
	{	if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		echo '<td width="100px" align="center" bgcolor="'.$color.'">ลัง</td>
		<td width="100px" align="center" bgcolor="'.$color.'">แพ็ค</td>
		<td width="100px" align="center" bgcolor="'.$color.'">บาท</td>
		<td width="100px" align="center" bgcolor="'.$color.'">ร้านซื้อ</td>
		<td width="100px" align="center" bgcolor="'.$color.'">% เยี่ยม</td>';
	}
	?>
<td width="100px" align="center" bgcolor="#D8D8D8">ยอดขาย(ลัง)</td>
<td width="100px" align="center" bgcolor="#D8D8D8">ยอดขาย(แพ็ค)</td>
<td width="100px" align="center" bgcolor="#D8D8D8">ยอดขาย(บาท)</td>
</tr>
<? $r=1; while($re1=sqlsrv_fetch_array($qryVisit))
{?>

<tr class="mousechange"  align="center">
<td bgcolor="#F0F0F0" class="mousechange" >&nbsp;&nbsp;<? print $r;?></td>
<td bgcolor="#F0F0F0" class="mousechange" height="30" align="left">&nbsp;&nbsp;<? echo date_format($re1['dateVisit'],'d/m/Y'); $Ymd=date_format($re1['dateVisit'],'Y-m-d');?></td>
<td bgcolor="#F3E2A9" class="mousechange">
	<?
		$sqlPlan="select count(CustNum) as CountCustPlan from st_plan_detail a left join st_user b on a.User_id = b.User_id where b.dc_groupid ='$txt_DC' 
		and cast(a.Plan_start_date as date) ='$Ymd' and (b.Salecode) like 'V%' ";//---cast(a.Plan_start_date as date),a.User_id,a.Plan_Docno,a.Plan_line,a.CustNum,b.dc_groupid
		$sqlPlan=sqlsrv_query($con,$sqlPlan);
		$sqlPlan=sqlsrv_fetch_array($sqlPlan);
		echo number_format($sqlPlan['CountCustPlan']); 	$CountPlan =$CountPlan+$sqlPlan['CountCustPlan'];//รวมร้านคลอบคลุม
	?>
</td>
<td bgcolor="#F3E2A9" class="mousechange">
	<?
		/*--เดิม$sqlVisitIn="select Count(a.Plan_Docno) as VisitIn  from st_plan_visit_head  a left join st_user b on  a.Createby =b.User_id
		where  b.dc_groupid='$txt_DC'    and cast(a.Visit_Docdate as date) ='$Ymd' and a.Check_status='I'";*/
		
		$sqlVisitIn="select Count(distinct a.CustNum) as VisitIn  from st_plan_visit_head  a left join st_user b on  a.Createby =b.User_id
		where  b.dc_groupid='$txt_DC'    and cast(a.Visit_Docdate as date) ='$Ymd' and a.Check_status='O'
		and (b.Salecode) like 'V%' ";
		$sqlVisitIn=sqlsrv_query($con,$sqlVisitIn);
		$sqlVisitIn=sqlsrv_fetch_array($sqlVisitIn);
		echo $sqlVisitIn['VisitIn'];   					$VisitIn =$VisitIn+$sqlVisitIn['VisitIn']; //รวมร้านเยี่ยม
	?>
</td>
<td class="mousechange" bgcolor="#F3E2A9">
	<?
		$sqlVisitBy=" SELECT Count(distinct a.CustNum) as CountBy FROM st_Sale_head a 
		left join st_user b on  a.Createby =b.User_id 
		LEFT OUTER JOIN st_CN_head  ON a.Sales_Docno = st_CN_head.Ref_Docno
		where   b.dc_groupid='$txt_DC'    
		and cast(a.Sales_Docdate as date) ='$Ymd' and (b.Salecode) like 'V%'
		AND a.totalall >0 AND (st_CN_head.CN_id != 1 OR st_CN_head.CN_id is null) ";
		$sqlVisitBy=sqlsrv_query($con,$sqlVisitBy);
		$sqlVisitBy=sqlsrv_fetch_array($sqlVisitBy);
		echo $sqlVisitBy['CountBy'];			$CountBy = $CountBy+$sqlVisitBy['CountBy'];//รวมร้านซื้อ
		
		
		/*$sqlVisitBy="SELECT Count(distinct st_Sale_head.CustNum) as CountBy
		FROM st_Sale_head
		LEFT OUTER JOIN st_CN_head  ON st_Sale_head.Sales_Docno = st_CN_head.Ref_Docno
		where st_Sale_head.Createby='$sale' and cast(st_Sale_head.Sales_Docdate as date) ='$Ymd'
		AND st_Sale_head.totalall >0 AND (st_CN_head.CN_id != 1 OR st_CN_head.CN_id is null) ";
		*/
	?>
</td>
<td class="mousechange" bgcolor="#F3E2A9"><? $vs1=($sqlVisitBy['CountBy']/$sqlPlan['CountCustPlan'])*100; echo number_format($vs1)."%";$vs1Total=$vs1Total+$vs1;?></td>
<td class="mousechange" bgcolor="#F3E2A9"><? $vs2=($sqlVisitBy['CountBy']/$sqlVisitIn['VisitIn'])*100; echo number_format($vs2)."%"; 	$vs2Total=$vs2Total+$vs2;?></td>










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
			on b.P_Code =c.P_Code and c.st_unit_id ='ลัง' left join  st_item_unit_con d
			on b.P_Code = d.P_Code and d.st_unit_id ='แพ็ค'  left join st_user z
			on  a.Createby =z.User_id
			left join st_CN_detail CNd on a.Sales_Docno = CNd.Ref_Docno and b.P_Code=CNd.P_Code
			left join st_CN_head CNh on CNd.Ref_Docno=CNh.Ref_Docno 
			where 
			z.dc_groupid='$txt_DC'    
			and cast(a.Sales_Docdate as date) ='$Ymd' and
			b.P_Code='$Pro'
			and z.Salecode  like 'V%'
			and (CNd.Ref_Docno is null or  CNh.CN_id <>'1'  )
			group by c.st_unit_qty,d.st_unit_qty";
		$sqlfor1=sqlsrv_query($con,$sqlfo1);
		$sqlfor1=sqlsrv_fetch_array($sqlfor1);
		//echo number_format($sqlfor1['QtyBox']); 
		$QtyBox1=$QtyBox1+$sqlfor1['QtyBox'];
		//	left join st_CN_head CNh on CNd.Ref_Docno=CNh.Ref_Docno 
		//  and (CNd.Ref_Docno is null or  CNh.CN_id <>'1'  )	
		 $sqlfor11="select count(distinct a.CustNum) as CountBy
		from st_Sale_head a  left join st_Sale_detail b
		on a.Sales_Docno=b.Sales_Docno left join st_user z
		on  a.Createby =z.User_id
		left join st_CN_detail CNd on a.Sales_Docno = CNd.Ref_Docno and b.P_Code=CNd.P_Code 
		left join st_CN_head CNh on CNd.Ref_Docno=CNh.Ref_Docno 
		where cast(a.Sales_Docdate as date)='$Ymd' 
		and z.dc_groupid='$txt_DC'
		and b.P_Code='$Pro' 
		and b.st_unit_qty_3 <>0 and (CNd.Ref_Docno is null or  CNh.CN_id <>'1'  )	
		and z.Salecode  like 'V%'";
		$sqlfor11=sqlsrv_query($con,$sqlfor11);
		$sqlfor11=sqlsrv_fetch_array($sqlfor11);
		$vs=($sqlfor11['CountBy']/$sqlVisitIn['VisitIn'])*100;
		if($i==$i)
				{ 
				 $sum[$i]=$sum[$i]+$sqlfor1['QtyBox'];
				 $sumpack[$i]=$sumpack[$i]+$sqlfor1['QtyPack']; 
				 $sumTotalPriceBy[$i]=$sumTotalPriceBy[$i]+$sqlfor1['TotalPrice_by'];
				 $CountBy2[$i]=$CountBy2[$i]+$sqlfor11['CountBy'];
				 $vsTotal[$i]=$vsTotal[$i]+$vs;		 
				}
		 // echo number_format($vs33)."%";	
		echo '<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sqlfor1['QtyBox']).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sqlfor1['QtyPack']).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sqlfor1['TotalPrice_by']).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sqlfor11['CountBy']).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($vs).'% </td>';
	$QtyBoxTotal=$QtyBoxTotal+$sqlfor1['QtyBox'];
	$QtyPackTotal=$QtyPackTotal+$sqlfor1['QtyPack'];
	$TotalPrice_by=$TotalPrice_by+$sqlfor1['TotalPrice_by'];
	}
	
	?>
	<!--------------รวม------------>
<td class="mousechange"><? echo number_format($QtyBoxTotal); $SumQtyBoxTotal=$SumQtyBoxTotal+$QtyBoxTotal;?></td>
<td class="mousechange"><? echo number_format($QtyPackTotal); $SumQtyPackTotal=$SumQtyPackTotal+$QtyPackTotal;?></td>
<td class="mousechange"><? echo number_format($TotalPrice_by);$SumTotalPrice_byTotal=$SumTotalPrice_byTotal+$TotalPrice_by;?></td>

</tr>

<? $QtyBoxTotal="";
	$QtyPackTotal="";
	$TotalPrice_by="";
$r++;}//tr ?>




<tr class="mousechange"  align="center" bgcolor="#D8D8D8" >
<td class="mousechange" colspan="2"  height="30">ยอดรวมทั้งหมด</td>
<td class="mousechange" bgcolor="#D8D8D8"><?=number_format($CountPlan);?></td>
<td class="mousechange" bgcolor="#D8D8D8"><?=number_format($VisitIn); ?></td>
<td class="mousechange" bgcolor="#D8D8D8"><?=number_format($CountBy); ?></td>
<td class="mousechange" bgcolor="#D8D8D8"><?=number_format($vs1Total/$row1)."%";?></td>
<td class="mousechange" bgcolor="#D8D8D8"><?=number_format($vs2Total/$row1)."%";?></td>
<?
	for($i=0;$i<$countProduct;$i++)
	{	if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		echo '<td class="mousechange" width="100px" align="center" >'.number_format($sum[$i]).'</td>
		<td class="mousechange" width="100px" align="center" >'.number_format($sumpack[$i]).'</td>
		<td class="mousechange" width="100px" align="center" >'.number_format($sumTotalPriceBy[$i]).'</td>
		<td class="mousechange" width="100px" align="center" >'.number_format($CountBy2[$i]).'</td>
		<td class="mousechange" width="100px" align="center" >'.number_format($vsTotal[$i]/$row1).'% </td>';
	}
	?>

	<!--------------รวม------------>
<td bgcolor="#D8D8D8" class="mousechange"><?=number_format($SumQtyBoxTotal);?></td>
<td bgcolor="#D8D8D8" class="mousechange"><?=number_format($SumQtyPackTotal);?></td>
<td bgcolor="#D8D8D8" class="mousechange"><?=number_format($SumTotalPrice_byTotal);?></td>
</tr>


<tr class="mousechange"  align="center" bgcolor="#F0F0F0">
<td class="mousechange" bgcolor="#F0F0F0" colspan="2"  height="30">ยอดรวมเฉลี่ย/วัน/ศูนย์: <?=number_format($row1);?></td>
<td class="mousechange"><?=number_format($CountPlan/$row1);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($VisitIn/$row1);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($CountBy/$row1);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($vs1Total/$row1)."%";?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($vs2Total/$row1)."%";?></td>
<?
	for($i=0;$i<$countProduct;$i++)
	{	if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		echo '<td width="100px" align="center" >'.number_format($sum[$i]/$row1).'</td>
		<td width="100px" align="center" >'.number_format($sumpack[$i]/$row1).'</td>
		<td width="100px" align="center" >'.number_format($sumTotalPriceBy[$i]/$row1).'</td>
		<td width="100px" align="center" >'.number_format($CountBy2[$i]/$row1).'</td>
		<td width="100px" align="center" >'.number_format($vsTotal[$i]/$row1).'% </td>';
	}
	?>

<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($SumQtyBoxTotal/$row1);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($SumQtyPackTotal/$row1);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($SumTotalPrice_byTotal/$row1);?></td>
</tr>
<?
$sql2="select count(a.User_id) as CountSale from st_user a where a.dc_groupid='$txt_DC' and a.RoleID_Lineid='6_2' and (a.Salecode) like 'V%'  ";
$sql2=sqlsrv_query($con,$sql2);
$sql2=sqlsrv_fetch_array($sql2);
$row2=$sql2['CountSale'];
?>
<tr class="mousechange"  align="center" bgcolor="#D8D8D8">
<td class="mousechange" bgcolor="#D8D8D8" colspan="2"  height="30">ยอดรวมเฉลี่ย/วัน/คัน  : <?=number_format($row2);?><br>Cash Van</td>
<td class="mousechange" ><?=number_format(($CountPlan/$row1)/$row2);?></td>
<td class="mousechange" bgcolor="#D8D8D8"><?=number_format(($VisitIn/$row1)/$row2);?></td>
<td class="mousechange" bgcolor="#D8D8D8"><?=number_format(($CountBy/$row1)/$row2);?></td>
<td class="mousechange" bgcolor="#D8D8D8"><?=number_format($vs1Total/$row1)."%";?></td>
<td class="mousechange" bgcolor="#D8D8D8"><?=number_format($vs2Total/$row1)."%";?></td>

<?
	for($i=0;$i<$countProduct;$i++)
	{	if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		echo '<td class="mousechange" width="100px" align="center" >'.number_format($sum[$i]/$row2).'</td>
		<td class="mousechange" width="100px" align="center" >'.number_format($sumpack[$i]/$row2).'</td>
		<td class="mousechange" width="100px" align="center" >'.number_format($sumTotalPriceBy[$i]/$row2).'</td>
		<td class="mousechange" width="100px" align="center" >'.number_format($CountBy[$i]/$row2).'</td>
		<td class="mousechange" width="100px" align="center" >'.number_format($vsTotal[$i]/$row2).'% </td>';
	}
	?>

<td class="mousechange" bgcolor="#D8D8D8"><?=number_format(($SumQtyBoxTotal/$row1)/$row2);?></td>
<td class="mousechange" bgcolor="#D8D8D8"><?=number_format(($SumQtyPackTotal/$row1)/$row2);?></td>
<td class="mousechange" bgcolor="#D8D8D8"><?=number_format(($SumTotalPrice_byTotal/$row1)/$row2);?></td>
</tr>
<tr class="mousechange"  align="left"><td colspan="100"  bgcolor="#FFF" height="70">
*หมายเหตุ<br>
ยอดรวมทั้งหมด คือ ยอดรวมของ Column <br>
ยอดรวมเฉลี่ย/วัน/ศูนย์ คือ ยอดรวมของ Column (หาร/)  จำนวนวันที่ทำงาน <br>
ยอดรวมเฉลี่ย/คัน/ศูนย์ คือ  ยอดรวมของ Column (หาร/)  จำนวนวนรถของศูนย์ <br>
 </tr>
</table>

</body>
</html>