<?//------------------------------------------------------แก้ไข โดย DREAM 10/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		$txt_loca =trim($_POST['txt_loca']);
		$txt_date1 =trim($_POST['txt_date1']);
		$txt_date2 =trim($_POST['txt_date2']);
		//$txt_aDate =date("Y-m-d",strtotime("-1 days",strtotime($txt_date1 )));
		
		$sqlShow ="select L.locationno,L.locationname,L.Tax_ID,L.Branch,L.locationAx,L.AddressNum,L.AddressMu
		,L.DISTRICT_CODE,L.AMPHUR_CODE,L.PROVINCE_CODE
		,D.DISTRICT_NAME,A.AMPHUR_NAME,P.PROVINCE_NAME,A.POSTCODE
		,C.COMPANYNAME

		from st_warehouse_location L left join   dbo.dc_district D ON L.DISTRICT_CODE = D.DISTRICT_CODE
		left join dbo.dc_amphur  A ON L.AMPHUR_CODE = A.AMPHUR_CODE 
		left join dbo.dc_province P ON L.PROVINCE_CODE = P.PROVINCE_CODE 
		left join st_companyinfo_exp C ON L.Companyname = C.COMPANYCODE
		where L.locationno ='$txt_loca'
		";
		$sqlShow=sqlsrv_query($con,$sqlShow);
		$sqlShow=sqlsrv_fetch_array($sqlShow);
		
		
?>

<BR>Company name : <?=$sqlShow['COMPANYNAME'];?>
<BR>Company address : 
<? 
if($sqlShow['AddressNum']){echo "เลขที่ ".$sqlShow['AddressNum'];}
if($sqlShow['AddressMu']){echo " หมู่ที่ ".$sqlShow['AddressMu'];}
if($sqlShow['DISTRICT_NAME']){echo " ต.".$sqlShow['DISTRICT_NAME'];}
if($sqlShow['AMPHUR_NAME']){echo " อ.".$sqlShow['AMPHUR_NAME'];}
if($sqlShow['PROVINCE_NAME']){echo " จ.".$sqlShow['PROVINCE_NAME'];}
if($sqlShow['POSTCODE']){echo " ".$sqlShow['POSTCODE'];}
?>
<BR><BR>
<BR>Tax payer identification number : <?=$sqlShow['Tax_ID'];?>
<BR>Name of place of business : <?=$sqlShow['Branch'];?> 
<BR><?=$sqlShow['locationname'];?>
<table width="980" border="1" cellspacing="0" cellpadding="0">
<tr align="center"  bgcolor="#A0CD64">
<td width="100px">No.</td>
<td width="100px">Tax invoice date</td>
<td width="200px">Tax invoice number</td>
<td width="100px">Customer name</td>
<td width="100px">Tax ID. Number</td>
<td width="100px">Branch</td>
<td width="100px">amount </td>
<td width="100px"> Tax amount </td>
<td width="100px"> Total amount </td>
</tr>
<?



$SQLdelail="select  * , cast(sales_Docdate as date) as dateShow 
from st_View_SumOrderH_web 
where cast(sales_Docdate as date) between '$txt_date1' and '$txt_date2' and warehouse_locationNo='$txt_loca'
and SUM_totalamount is not null ";
$r=1;
//echo $SQLdelail;
$SQLdelail=sqlsrv_query($con,$SQLdelail);
while($delail=sqlsrv_fetch_array($SQLdelail)){
?>
<tr align="left" class="mousechange"  >
<td align="center"><?=$r;?></td>
<td align="center"><?=date_format($delail['dateShow'],'Y-m-d');?></td>
<td ><?=$delail['TaxInv']; ?></td>
<td ><?=$delail['CustName']; ?></td>
<td ></td>
<td ></td>
<td align="right"><?=$SUM_amount=number_format($delail['SUM_amount'],2);  $TotalSUM_amount=$TotalSUM_amount+$SUM_amount;?></td>
<td align="right"><?=$SUM_TaxAmount = number_format($delail['SUM_TaxAmount'],2); ?></td>
<td align="right"><?=$SUM_totalamount = number_format($delail['SUM_totalamount'],2); ?></td>
</tr>


<?
$SQLCheckCN="select  ww.* , cast(ww.sales_Docdate as date) as dateShow
from  st_CN_head h 
left join st_View_SumOrderH_web ww on h.Ref_Docno = ww.Sales_Docno
where  h.Ref_Docno='$delail[Sales_Docno]' and h.CN_id='1'";
$QtyCheckCN=sqlsrv_query($con,$SQLCheckCN);
while($CheckCN=sqlsrv_fetch_array($QtyCheckCN)){
echo "<tr bgcolor='red' align='left'><td  align='center'>CN</td>";?>
<td align="center"><?=date_format($CheckCN['dateShow'],'Y-m-d');?></td>
<td ><?=$CheckCN['TaxInv']; ?></td>
<td ><?=$delail['CustName']; ?></td>
<td ></td>
<td ></td>
<td align="right"><?=$SUM_amount2=number_format(($CheckCN['SUM_amount'])*-1,2); $TotalSUM_amount=$TotalSUM_amount+$SUM_amount2?></td>
<td align="right"><?=number_format(($CheckCN['SUM_TaxAmount'])*-1,2); ?></td>
<td align="right"><?=number_format(($CheckCN['SUM_totalamount'])*-1,2); ?></td>
</tr>


<? 
}
$r++;} ?>
<!--------
<tr align="right">
<td colspan="6">รวม</td>
<td align="right"><?=number_format($TotalSUM_amount,2); ?></td>
</tr>--------->



</table>