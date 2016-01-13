<?//------------------------------------------------------แก้ไข โดย DREAM 10/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$txt_date1 =trim($_POST['txt_date1']);
		$txt_date2 =trim($_POST['txt_date2']);
		
		
		$txt_DC =trim($_POST['txt_DC']);
		$txt_item =trim($_POST['txt_item']);
		$txt_Sale = trim($_POST['txt_Sale']);


	

		$sqlShowDC="select dc.dc_groupid,dc.dc_groupname from st_user_group_dc dc where dc.dc_groupid ='$txt_DC' ";
		$sqlShowDC=sqlsrv_query($con,$sqlShowDC);
		$sqlShowDC=sqlsrv_fetch_array($sqlShowDC);
		
		$sqlShowU="select u.name,u.surname from st_user u  where u.user_id ='$txt_Sale' ";
		$sqlShowU=sqlsrv_query($con,$sqlShowU);
		$sqlShowU=sqlsrv_fetch_array($sqlShowU);
		
		$sqlShowI="select I.P_Code, I.PRODUCTNAME from st_item_product I where I.P_Code ='$txt_item' ";
		$sqlShowI=sqlsrv_query($con,$sqlShowI);
		$sqlShowI=sqlsrv_fetch_array($sqlShowI);
		
?>
<BR><?=$sqlaa['COMPANYNAME'];?>
<BR>รายงานการขายประจำวัน
<BR>ณ วันที่ &nbsp;<?$date=date_create($txt_date1); $date2=date_create($txt_date2); echo date_format($date,"d-m-Y"); echo " ถึง ".date_format($date2,"d-m-Y");?>
<BR><BR>
<BR>DC : <?=$sqlShowDC['dc_groupname'];?> 
<BR>พนักงานขาย : <?=$sqlShowU['User_id']." ".$sqlShowU['name']." ".$sqlShowU['surname']; if(!$txt_Sale){echo 'ALL';}?> 
<BR>รหัสสินค้า : <?=$sqlShowI['P_Code']." ".$sqlShowI['PRODUCTNAME']; if(!$txt_item){echo 'ALL';}?> 



<table border="1" cellspacing="0" cellpadding="0">
<tr align="center"  bgcolor="#A0CD64">
<td width="100px">DC</td>
<td width="100px">รหัสสินค้า</td>
<td width="100px">ชื่อสินค้า</td>
<td width="100px">วันที่</td>
<td width="200px">เลขที่เอกสาร</td>
<td width="200px">ร้านค้า</td>
<td width="100px">Sale code</td>
<td width="200px">พนักงานขาย</td>
<td width="100px">จำนวน</td>
<td width="100px">ลัง</td>
<td width="100px">จำนวน</td>
<td width="100px">แพ็ค</td>
<td width="100px">เงิน</td>
<td width="100px">Vat</td>
<td width="100px">รวมเงิน</td>
</tr>
<? // distinct 
		$sql="
select  a.Sales_Docno,cast(a.Sales_Docdate as date) as dateShow ,a.Createby
,U.name,U.surname,U.dc_groupid,U.Salecode
,cust.custnum,cust.CustName,b.P_Code ,I.PRODUCTNAME ,b.st_unit_qty_3
,b.totalvat,b.totalamount,b.totaldiscount 
,c.st_unit_id,c.st_unit_qty 
,d.st_unit_id,d.st_unit_qty 
,b.st_unit_qty_3 / c.st_unit_qty as box 
,b.st_unit_qty_3 % c.st_unit_qty as balBox 
,(b.st_unit_qty_3 % c.st_unit_qty ) / d.st_unit_qty as pack 
,(b.st_unit_qty_3 % c.st_unit_qty ) % d.st_unit_qty as balpack
 , (b.totalamount *100 )/107as Amount 
 , (((b.totalamount *100 )/107)*7 )/100 as Vat 
 
 from st_Sale_head a 
 left join st_Sale_detail b on a.Sales_Docno=b.Sales_Docno 
 left join st_item_unit_con c  on b.P_Code = c.P_Code and c.st_unit_id='ลัง'
 left join st_item_unit_con d on b.P_Code = d.P_Code and  d.st_unit_id='แพ็ค'
 left join st_cust cust on a.CustNum = cust.CustNum 
 left join st_user U on a.Createby = U.User_id  
 left join st_item_product I on b.P_Code = I.P_Code
 
 where   cast(a.Sales_Docdate as date)  between '$txt_date1'  and '$txt_date2' 

 and  c.st_unit_id ='ลัง'  and  d.st_unit_id ='แพ็ค'  ";
 
	if($txt_DC){$sql.="and U.dc_groupid='$txt_DC' ";}
	if($txt_Sale){ $sql.="and a.Createby ='$txt_Sale'  "; }
	if($txt_item){ $sql.="and b.P_Code='$txt_item'  "; }
	
  

$sql.="order by U.Salecode asc, Sales_Docno asc";
//echo $sql;
$sql=sqlsrv_query($con,$sql);
while($re=sqlsrv_fetch_array($sql)){ ?>
<tr align="center" class="mousechange">
<td><?=$re['dc_groupid'];?></td>
<td><?=$re['P_Code'];?></td>
<td><?=$re['PRODUCTNAME'];?></td>
<td><?=date_format($re['dateShow'],'d-m-Y');?></td>
<td><?=$re['Sales_Docno'];?></td>
<td align="left" >&nbsp;&nbsp;<?=$re['CustName'];?></td>

<td><?=$re['Salecode'];?></td>
<td><?=$re['name']." ".$re['surname'];?></td>
<td align="right"><?=$re['box']; $TotalBox=$TotalBox+$re['box']; ?></td>
<td>ลัง</td>
<td align="right"><?=$re['pack']; $TotalPack=$TotalPack+$re['pack'];?></td>
<td>แพ็ค</td>
<td align="right" ><?=number_format($re['Amount'],2); $TotalMount=$TotalMount+$re['Amount'];?></td>
<td align="right"><?=number_format($re['Vat'],2); $TotalVat=$TotalVat+$re['Vat'];?></td>
<td align="right"><?=number_format($re['totalamount'],2); $Totalamount=$Totalamount+$re['totalamount']; ?>

</td>
</tr>
<?
$SQLCheckCN="select  a.Ref_Docno,cast(a.Ref_Docdate as date) as dateShow ,a.Createby
,U.name,U.surname,U.dc_groupid,U.Salecode
,cust.custnum,cust.CustName,b.P_Code ,I.PRODUCTNAME ,b.st_unit_qty_3
,b.totalvat,b.totalamount,b.totaldiscount 
,c.st_unit_id,c.st_unit_qty 
,d.st_unit_id,d.st_unit_qty 
,b.st_unit_qty_3 / c.st_unit_qty as box 
,b.st_unit_qty_3 % c.st_unit_qty as balBox 
,(b.st_unit_qty_3 % c.st_unit_qty ) / d.st_unit_qty as pack 
,(b.st_unit_qty_3 % c.st_unit_qty ) % d.st_unit_qty as balpack
 , (b.totalamount *100 )/107as Amount 
 , (((b.totalamount *100 )/107)*7 )/100 as Vat 
 
 from st_CN_head a 
 left join st_CN_detail b on a.Ref_Docno=b.Ref_Docno 
 left join st_item_unit_con c  on b.P_Code = c.P_Code and c.st_unit_id='ลัง'
 left join st_item_unit_con d on b.P_Code = d.P_Code and  d.st_unit_id='แพ็ค'
 left join st_cust cust on a.CustNum = cust.CustNum 
 left join st_user U on a.Createby = U.User_id  
 left join st_item_product I on b.P_Code = I.P_Code
 where a.Ref_Docno='$re[Sales_Docno]' and b.P_Code='$re[P_Code]' and a.CN_id='1'";
$QtyCheckCN=sqlsrv_query($con,$SQLCheckCN);
while($CheckCN=sqlsrv_fetch_array($QtyCheckCN)){
echo "<tr bgcolor='red' align='center'><td>CN</td>";?>
<td><?=$CheckCN['P_Code'];?></td>
<td><?=$CheckCN['PRODUCTNAME'];?></td>
<td><?=date_format($CheckCN['dateShow'],'d-m-Y');?></td>
<td><?=$CheckCN['Ref_Docno'];?></td>
<td align="left" >&nbsp;&nbsp;<?=$CheckCN['CustName'];?></td>

<td><?=$CheckCN['Salecode'];?></td>
<td><?=$CheckCN['name']." ".$CheckCN['surname'];?></td>
<td align="right"><?=($CheckCN['box'])*-1; $TotalBox=$TotalBox+(($CheckCN['box'])*-1); ?></td>
<td>ลัง</td>
<td align="right"><?=($CheckCN['pack'])*-1; $TotalPack=$TotalPack+(($CheckCN['pack'])*-1);?></td>
<td>แพ็ค</td>
<td align="right" ><?=number_format(($CheckCN['Amount']*-1),0); $TotalMount=$TotalMount+($CheckCN['Amount']*-1);?></td>
<td align="right"><?=number_format(($CheckCN['Vat']*-1),0); $TotalVat=$TotalVat+($CheckCN['Vat']*-1);?></td>
<td align="right"><?=number_format(($CheckCN['totalamount']*-1),0); $Totalamount=$Totalamount+($CheckCN['totalamount']*-1); ?>

</td>


<?echo "</tr>";
?>
<?
}
?>

<? } ?>
<tr class="mousechange">
<td colspan="8" align="right">รวม</td>
<td align="right"><?=number_format($TotalBox,0);  ?></td>
<td align="center">ลัง</td>
<td align="right"><?=number_format($TotalPack,0);  ?></td>
<td align="center">แพ็ค</td>
<td align="right"><?=number_format($TotalMount,2);  ?></td>
<td align="right"><?=number_format($TotalVat,2);  ?></td>
<td align="right"><?=number_format($Totalamount,2);  ?></td>
</tr>
</table>