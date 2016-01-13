<?
include("../../includes/config.php");
$txt_DC =$_POST['txt_DC'];
$sale=trim($_POST['txt_Sale']);
$txt_year=$_POST['txt_year'];
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

$ProductBy="select P_Code,PRODUCTNAME from st_item_product where prd_type_id='S001'  order  by P_Code asc ";
		$ProductBy=sqlsrv_query($con,$ProductBy,$params,$options); 
		$rowProductBy=sqlsrv_num_rows($ProductBy);
		$colsapan=$rowProductBy*5;
		$countProduct=0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?
$sqlSale="select User_id,name,surname,Salecode from st_user where dc_groupid='$txt_DC' ";
	if($sale !=""){$sqlSale.=" and User_id ='$sale' ";}
	$sqlSale.="order by Salecode asc "; //echo $sqlSale;
	$sqlSale=sqlsrv_query($con,$sqlSale);
while($reDC=sqlsrv_fetch_array($sqlSale))
{	$sale=$reDC['User_id'];
	$sqlOp="select dc_groupname,dc_groupid from st_user_group_dc where dc_groupid='$txt_DC'";
	
	$qryOp=sqlsrv_query($con,$sqlOp);
	$deOp=sqlsrv_fetch_array($qryOp); //สำหรับเปิดชื่อศูนย์

	$sqlVisit="select cast(a.Visit_Docdate  as date) as dateVisit 
	from st_plan_visit_head  a left join st_user b
	on  a.Createby =b.User_id
	where  b.dc_groupid='$txt_DC'   and cast(a.Visit_Docdate  as date) like '$Ym%'
	group by cast(a.Visit_Docdate  as date)"; 
	$qryVisit=sqlsrv_query($con,$sqlVisit);


	$sqlNameSale="select name,surname,Salecode  from st_user where User_id='$sale' order by Salecode asc";
	$sqlNameSale=sqlsrv_query($con,$sqlNameSale);
	$sqlNameSale=sqlsrv_fetch_array($sqlNameSale);
?>
<div class="fontBig">ใบสรุปยอดขายประจำวัน</div>
<div class="fontBig">เดือน <font color="#0066FF"><?=$monthThai;?> </font> จำนวนวันทำงาน <font color="#0066FF"><? $qry1=sqlsrv_query($con,$sqlVisit,$params,$options); $row1=sqlsrv_num_rows($qry1);  echo number_format($row1); ?></font> </div>
<div class="fontBig">Cash Van <font color="#0066FF"><?=$sqlNameSale['Salecode'];?></font></div>
<div class="fontBig">ชื่อพนักงานขาย <font color="#0066FF"><?=$sqlNameSale['name']." " .$sqlNameSale['surname'];?></font>    ผู้ช่วย<font color="#0066FF">........................</font></div>
<div class="fontBig">รหัสเขตการขาย <font color="#0066FF"><?  echo $deOp['dc_groupname'];?></font> Trainer
<font color="#0066FF">........................</font></div>

<table border="1" cellspacing="1" cellpadding="1" align="center">



<tr>

<td class="mousechange" width="200px" align="center" rowspan="3">วัน/เดือน/ปี</td>
<td class="mousechange" align="center"  colspan="2">ชื่อตลาดทำงาน/เยี่ยม</td>
<td class="mousechange" align="center"  colspan="5" bgcolor="#FFFFCC">ร้านค้าเยี่ยมและร้านค้าซื้อ</td>
<td class="mousechange" width="100px" align="center"  colspan="<?=$colsapan?>" bgcolor="#99CC99">Sales (Baht) และ Effective Call  รายผลิตภัณฑ์</td>
<td class="mousechange" align="center"  colspan="3" bgcolor="#F0F0F0">ยอดขายรวมทุกผลิตภัณฑ์</td>
</tr>

<tr>
<td class="mousechange" width="150px" align="center"  rowspan="2">ตำบล</td>
<td class="mousechange" width="150px" align="center"  rowspan="2">อำเภอ</td>

<td class="mousechange" width="100px" align="center" rowspan="2" bgcolor="#FFFFCC">ร้านครอบคลุม</td>
<td class="mousechange" width="100px" align="center" rowspan="2" bgcolor="#FFFFCC">ร้านเยี่ยม</td>
<td class="mousechange" width="100px" align="center" rowspan="2" bgcolor="#FFFFCC">ร้านชื้อ</td>
<td class="mousechange" width="100px" align="center" rowspan="2" bgcolor="#FFFFCC">%ซื้อ vs ครอบคลุม</td>
<td class="mousechange" width="100px" align="center" rowspan="2" bgcolor="#FFFFCC">%ซื้อ vs เยี่ยม</td>

<? 
		
while($By=sqlsrv_fetch_array($ProductBy)) 
		{	$ByPro[]=$By['P_Code'];
			if($countProduct%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
			echo '<td class="mousechange" align="center" colspan="5" bgcolor="'.$color.'">'.$By['PRODUCTNAME'].'</td>';
			 $countProduct++;
		}
?>

<td class="mousechange" width="100px" align="center" rowspan="2" bgcolor="#F0F0F0">ยอดขาย(ลัง)</td>
<td class="mousechange" width="100px" align="center" rowspan="2" bgcolor="#F0F0F0">ยอดขาย(แพ็ค)</td>
<td class="mousechange" width="100px" align="center" rowspan="2" bgcolor="#F0F0F0">ยอดขาย(บาท)</td>
</tr>


<tr>

<?
	for($i=0;$i<$countProduct;$i++)
	{	if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		echo '<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">ยอดขาย(ลัง)</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">ยอดขาย(แพ็ค)</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">ยอดขาย(บาท)</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">ร้านซื้อ</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">% เยี่ยม</td>';
	}
	?>
</tr>
<?while($reVisit=sqlsrv_fetch_array($qryVisit)){?>
<tr align="center">
<td class="mousechange" height="25"><? echo date_format($reVisit['dateVisit'],'d/m/Y');  $Ymd=date_format($reVisit['dateVisit'],'Y-m-d');  // date('d/m/Y',strtotime($reVisit['dateVisit']));
	//หาตำบลที่เข้ามากสุดในวันนั้นๆ
	$sqlDid="select B.DISTRICT_CODE
	,B.DISTRICT_NAME
	,B.AMPHUR_NAME
	,count(B.DISTRICT_CODE) as NumVisit
	from st_plan_visit_head A left join st_View_cust_web B
	on A.CustNum = B.CustNum
	where  A.Createby='$sale' and cast(A.Visit_Docdate as date ) ='$Ymd'
	group by 
	B.DISTRICT_CODE
	,B.DISTRICT_NAME
	,B.AMPHUR_NAME
	order by count(B.DISTRICT_CODE) desc ";
	$sqlDid=sqlsrv_query($con,$sqlDid);
	$sqlDid=sqlsrv_fetch_array($sqlDid);
 ?>
</td>

<td class="mousechange"><? echo $sqlDid['DISTRICT_NAME'];?></td>
<td class="mousechange"><? echo $sqlDid['AMPHUR_NAME'];?></td>

<td class="mousechange" bgcolor="#FFFFCC">
	<?
		$sqlCoustPlan="select count(Plan_Docno) as CountPlan from st_plan_detail where User_id='$sale'   and cast(Plan_start_date as date) ='$Ymd'";
		$sqlCoustPlan=sqlsrv_query($con,$sqlCoustPlan);
		$sqlCoustPlan=sqlsrv_fetch_array($sqlCoustPlan);
		echo $sqlCoustPlan['CountPlan']; 		$CountPlan =$CountPlan+$sqlCoustPlan['CountPlan'];//รวมร้านคลอบคลุม
		
	?>
</td>
<td class="mousechange" bgcolor="#FFFFCC">
	<?
		//---เดิม $sqlVisitIn="select Count(Plan_Docno) as VisitIn from st_plan_visit_head where Createby='$sale'   and cast(Visit_Docdate as date) ='$Ymd' and Check_status='I'";
		$sqlVisitIn="select Count(distinct CustNum) as VisitIn from st_plan_visit_head where Createby='$sale'   and cast(Visit_Docdate as date) ='$Ymd' and Check_status='O'";
		
		$sqlVisitIn=sqlsrv_query($con,$sqlVisitIn);
		$sqlVisitIn=sqlsrv_fetch_array($sqlVisitIn);
		echo $sqlVisitIn['VisitIn'];   			$VisitIn =$VisitIn+$sqlVisitIn['VisitIn']; //รวมร้านเยี่ยม
	?>
</td>
<td class="mousechange" bgcolor="#FFFFCC">
	<?
		//---เดิม $sqlVisitBy="SELECT Count(Sales_Docno) as CountBy FROM st_Sale_head where  Createby='$sale'    and cast(Sales_Docdate as date) ='$Ymd'";
		
		//$sqlVisitBy="SELECT Count(distinct CustNum) as CountBy FROM st_Sale_head where  Createby='$sale'  
		//and cast(Sales_Docdate as date) ='$Ymd'";
		
		$sqlVisitBy="SELECT Count(distinct st_Sale_head.CustNum) as CountBy
		FROM st_Sale_head
		LEFT OUTER JOIN st_CN_head  ON st_Sale_head.Sales_Docno = st_CN_head.Ref_Docno
		where st_Sale_head.Createby='$sale' and cast(st_Sale_head.Sales_Docdate as date) ='$Ymd'
		AND st_Sale_head.totalall >0
		AND (st_CN_head.CN_id != 1 OR st_CN_head.CN_id is null) ";
		
		$sqlVisitBy=sqlsrv_query($con,$sqlVisitBy);
		$sqlVisitBy=sqlsrv_fetch_array($sqlVisitBy);
		echo $sqlVisitBy['CountBy'];			$CountBy = $CountBy+$sqlVisitBy['CountBy'];//รวมร้านซื้อ
		
	?>
</td>
<td class="mousechange" bgcolor="#FFFFCC"><? $vs1=($sqlVisitBy['CountBy']/$sqlCoustPlan['CountPlan'])*100; echo number_format($vs1)."%";$vs1Total=$vs1Total+$vs1;?></td>
<td class="mousechange" bgcolor="#FFFFCC"><? $vs2=($sqlVisitBy['CountBy']/$sqlVisitIn['VisitIn'])*100; echo number_format($vs2)."%"; 	$vs2Total=$vs2Total+$vs2;?></td>










<?
	//	left join st_CN_head CNh on CNd.Ref_Docno=CNh.Ref_Docno 
		//  and (CNd.Ref_Docno is null or  CNh.CN_id <>'1'  )
	//echo number_format($sqlByC['QtyBox']); $QtyBox1=$QtyBox1+$sqlByC['QtyBox'];
	
	for($i=0;$i<$countProduct;$i++)
	{	
		$Pro=$ByPro[$i];
		$sqlBy="select 
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
			a.Createby='$sale'  and cast(a.Sales_Docdate as date) ='$Ymd' and
			b.P_Code='$Pro' and (CNd.Ref_Docno is null or  CNh.CN_id <>'1'  )
			group by c.st_unit_qty,d.st_unit_qty ";
		$sqlBy1=sqlsrv_query($con,$sqlBy);
		$sqlBy1=sqlsrv_fetch_array($sqlBy1);
		
		$sqlBy2="select count(distinct a.CustNum) as CountBy
		from st_Sale_head a  left join st_Sale_detail b
		on a.Sales_Docno=b.Sales_Docno
		left join st_CN_detail CNd on a.Sales_Docno = CNd.Ref_Docno and b.P_Code=CNd.P_Code
		left join st_CN_head CNh on CNd.Ref_Docno=CNh.Ref_Docno 
		where cast(a.Sales_Docdate as date)='$Ymd' and a.Createby='$sale' and b.P_Code='$Pro' and b.st_unit_qty_3 <>0
		and (CNd.Ref_Docno is null or  CNh.CN_id <>'1'  ) ";
		$sqlBy2=sqlsrv_query($con,$sqlBy2);
		$sqlBy2=sqlsrv_fetch_array($sqlBy2);
		
		//echo number_format($sqlBy1['QtyBox']); 
		$vs33=($sqlBy2['CountBy']/$sqlVisitIn['VisitIn'])*100; 
		if($i==$i)
				{ 
				 $sumQtyBox[$i]=$sumQtyBox[$i]+$sqlBy1['QtyBox'];
				 $sumQtyPack[$i]=$sumQtyPack[$i]+$sqlBy1['QtyPack'];
				 $sumTotalPrice_by[$i]=$sumTotalPrice_by[$i]+$sqlBy1['TotalPrice_by'];
				 $sumCountBy[$i]=$sumCountBy[$i]+$sqlBy2['CountBy'];
				 $sumvs33[$i]=$sumvs33[$i]+$vs33;
				 
				}
				$TotaBox=$TotaBox+$sqlBy1['QtyBox'];
				$TotalPack =$TotalPack+$sqlBy1['QtyPack'];
				$TotalPrice =$TotalPrice+$sqlBy1['TotalPrice_by'];
		if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		echo '<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sqlBy1['QtyBox']).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sqlBy1['QtyPack']).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sqlBy1['TotalPrice_by']).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sqlBy2['CountBy']).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($vs33)."%".'</td>';
	}
	?>


<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($TotaBox); $TotaBox2=$TotaBox2+$TotaBox;?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($TotalPack); $TotalPack2=$TotalPack2+$TotalPack;?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($TotalPrice); $TotalPrice2=$TotalPrice2+$TotalPrice;?></td>

</tr>

<? }?>
<tr align="center">
<td class="mousechange" colspan="3" align="center"  bgcolor="#F0F0F0" height="30">ยอดรวมทั้งหมด</td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($CountPlan);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($VisitIn);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($CountBy);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($vs1Total/$row1)."%";?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($vs2Total/$row1)."%";?></td>

<?
	for($i=0;$i<$countProduct;$i++)
	{	if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		echo '<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sumQtyBox[$i]).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sumQtyPack[$i]).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sumTotalPrice_by[$i]).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sumCountBy[$i]).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sumvs33[$i]/$row1).'% </td>';
		
	}
	?>

<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($TotaBox);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($TotalPack);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($TotalPrice);?></td>
</tr>

<tr  align="center">
<td class="mousechange" colspan="3" align="center"  bgcolor="#F0F0F0"  height="30" >ยอดรวมเฉลี่ย/วัน</td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($CountPlan/$row1);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($VisitIn/$row1);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($CountBy/$row1);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($vs1Total/$row1)."%";?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($vs2Total/$row1)."%";?></td>
<?
	for($i=0;$i<$countProduct;$i++)
	{	if($i%2==0){ $color="#99CC99";}else{$color="#66CCFF";}
		echo '<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sumQtyBox[$i]/$row1).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sumQtyPack[$i]/$row1).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sumTotalPrice_by[$i]/$row1).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sumCountBy[$i]/$row1).'</td>
		<td class="mousechange" width="100px" align="center" bgcolor="'.$color.'">'.number_format($sumvs33[$i]/$row1).'% </td>';
		
	}
	?>

<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($TotaBox/$row1);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($TotalPack/$row1);?></td>
<td class="mousechange" bgcolor="#F0F0F0"><?=number_format($TotalPrice/$row1);?></td>
</tr>

</table><br><br>
<? } ?>





*หมายเหตุ<br>
ยอดรวมทั้งหมด คือ ยอดรวมของ Column <br>
ยอดรวมเฉลี่ย/วัน  คือ ยอดรวมของ Column (หาร/)  จำนวนวันที่ทำงาน <br>
<br><br><br>
***เพิ่มเติมเอง จำนวนวันทำงานคือวันที่การเข้าเยี่ยมร้าน checkin จริง
<br>ร้านครอบคลุม คือ ร้านที่สร้างแผนไว้
<br>%ซื้อ vs ครอบคลุม คือ ร้านซื้อ/ร้านครอบคลุม *100
<br>%ซื้อ vs ร้านเยี่ยม คือ ร้านซื้อ/ร้านเยี่ยม *100
<br>คาราบาว  % เยี่ยม คือ ร้านซื้อ/ร้านเยี่ยม * 100
<br>****นับร้านไม่ซ้ำแล้ว
</body>
</html>