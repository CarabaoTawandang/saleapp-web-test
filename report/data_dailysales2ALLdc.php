<?
session_start();
set_time_limit(0);
include("../includes/config.php");

//$dateTo = $_POST['dateTo'];
$time = strtotime($_POST['dateTo']);
$dateTo = date('m/d/Y',$time);
$Start= date('m/01/Y',$time);
$txt_DC=trim($_POST['txt_DC']);
$usernum = "-";
$all_qty_carabao = 0;
$all_qty_start = 0;
$total = 0;
$do = "insert";


$sqlOp="select dc_groupname,dc_groupid from st_user_group_dc 

 ";

if($txt_DC=="all"){ $sqlOp.="   order by dc_groupid asc";}
else{ $sqlOp.=" where dc_groupid='$txt_DC'";}
//echo $sqlOp;
//exit();
$qryOp=sqlsrv_query($con,$sqlOp);
 

echo $dateTo;
////////////////////////
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#save').button();

		$('#save').click(function(){
					
					$('#txt_check').html("<img src='images/89.gif'>");
					
						$(document).ready(function (e) { //alert("TEST"); 
						$("#frmuser").on('submit',(function(e) {// alert("TEST"); 
						e.preventDefault();
						$.ajax({
						url: "report/save_dailysales.php", // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
						contentType: false,       // The content type used when sending data to the server.
						cache: false,             // To unable request pages to be cached
						processData:false,        // To send DOMDocument or non processed data file it is set to false
						success:function(result){
													$('#txt_check').html(result);
													}
						});
						}));
						});
		});
		
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

	<form  method="post" name="frmuser" id="frmuser"  enctype="multipart/form-data">
	
	<? $numLoc=1;
	
	while($deOp=sqlsrv_fetch_array($qryOp)) {
	
	$txt_ww=trim($_POST['txt_w']);
	$txt_DC=trim($deOp['dc_groupid']);
	
	$sqlAcc="select jj.* ,ww.locationname,ww.Acc_Doc,dc.dc_groupname
	from st_DcJoinLocation jj  
	left join st_warehouse_location ww on jj.locationno = ww.locationno
	left join st_user_group_dc dc on jj.dc_groupid = dc.dc_groupid
	where jj.dc_groupid='$txt_DC' ";
	$sqlAcc=sqlsrv_query($con,$sqlAcc);
	$sqlAcc=sqlsrv_fetch_array($sqlAcc);
	?>
     <div align="left"><b><? echo $numLoc.". ".$deOp["dc_groupname"]; $numLoc++;?><b></div>
	 <div align="left">
	 <?
	$CheckFile="select id_file from st_dailysales_file where Dc_groupid='$txt_DC' and Date_pay='$dateTo' ";
	$CheckFile=sqlsrv_query($con,$CheckFile);
	$CheckFile=sqlsrv_fetch_array($CheckFile);
	if($CheckFile['id_file'])
	{echo "<a  target='_blank'  href='dailysales_file/".$CheckFile['id_file']." '>ดู FIle PDF ที่แนบ</a>";; }
	 ?>
	 </div>
	 <br>
     <input type="hidden" id="dc_group" name ="dc_group"  value="<?=$txt_DC;?>">
     <input type="hidden" id="date_to" name ="date_to"  value="<?=$dateTo;?>">
      <input type="hidden" id="do" name ="do"  value="<?=$do;?>">
	<table  align="center" class="tables" width="100%">
	<tr align="center">
	<th align="center" rowspan="2">สาขา</th>
	<th align="center" rowspan="2">ลำดับ</th>
	<th align="center" rowspan="2">รหัส User</th>
	<th align="center" rowspan="2">Sales code</th>
	<th align="center" rowspan="2">Sales name</th>
	<? $ProductBy="select P_Code,PRODUCTNAME from st_item_product where prd_type_id='S001' and P_Code not like 'FG9001%' 
	order  by P_Code asc ";
		$ProductBy=sqlsrv_query($con,$ProductBy);$countProduct=0;
		while($By=sqlsrv_fetch_array($ProductBy)) 
		{	$ByPro[]=$By['P_Code'];
			echo '<th align="center" colspan="3">'.$By['PRODUCTNAME'].'-CN</th>';
			 $countProduct++;
		}
	
	?>
	
	
	<th align="center" rowspan="2">ส่วนลด S+</th>
	
	<th align="center" rowspan="2">ยอดขายสุทธิ-CNแล้ว</th>
	<th align="center" rowspan="2">โอนเงิน<br>ขาด/เกิน</th>
	<th align="center" rowspan="2">เงินโอนสุทธิ</th>
    <th align="center" rowspan="2">Receipt number</th>
	<th align="center" rowspan="2">หมายเหตุ</th>
	
	<th align="center" colspan="6" width="200px">ยอดสะสมเดือน : <?=date('m/Y',$time); ?> วันที่  01- <?=date('d',$time); ?></th>
	</tr>
	<tr align="center">
	<?
	for($i=0;$i<$countProduct;$i++)
	{
		echo '<th align="center">ลัง</th>
		<th align="center">แพ็ค</th>
		<th align="center">จำนวนเงิน</th>';
	}
	?>
	<th align="center">รวมขาย-CNแล้ว</th>
	<th align="center">รวมCN</th>
	<th align="center">รวมส่วนลด S+</th>
	<th align="center">ขายสุทธิ</th>
	<th align="center">โอน</th>
	<th align="center">ผลต่าง</th>
	</tr>
	<? 
	
	
	
	
	//echo $sql;
	$r=0; $pp=0;
	
	$sqlUDC="select User_id as UID,name,surname,Salecode,dc_groupid,RoleID,RoleID_Lineid from st_user 
				where RoleID_Lineid ='6_2'and Dc_groupid='$txt_DC'  and status ='Y'
				order by Salecode asc ";
	$qryUDC=sqlsrv_query($con,$sqlUDC);			
	while($reUDC=sqlsrv_fetch_array($qryUDC))
	{ 	//echo "<br>**".$reUDC['UID'];
		$pp++;echo '<tr class="mousechange" height="30" valign= "top" >
			<td align="left ">'.$sqlAcc['Acc_Doc'].'</td>
			<td align="left ">'.$pp.'</td>
			<td align="left ">'.$reUDC['UID'].'</td>
			<td align="left ">'.$reUDC['Salecode'].'</td>
			<td align="left ">'.$reUDC['name'].'</td> ';
			
			//echo ' === '.count($ByPro);
			for($i=0;$i<$countProduct;$i++)
			{	$Pro=$ByPro[$i];
				$sqlSum1="select 
				st_Sale_detail.P_Code,st_Sale_detail.PRODUCTNAME,
				sum(st_Sale_detail.st_unit_qty_3)/con1.st_unit_qty as box 
				,(sum(st_Sale_detail.st_unit_qty_3)%con1.st_unit_qty)/con2.st_unit_qty as pack
				,sum(st_Sale_detail.totalamount) as totalamount
				from st_Sale_detail left join st_Sale_head on st_Sale_detail.Sales_Docno = st_Sale_head.Sales_Docno 
				LEFT OUTER JOIN  dbo.st_item_unit_con con1 ON dbo.st_Sale_detail.P_Code = con1.P_Code AND con1.st_unit_id = 'ลัง' 
				LEFT OUTER JOIN  dbo.st_item_unit_con con2 ON dbo.st_Sale_detail.P_Code = con2.P_Code AND con2.st_unit_id = 'แพ็ค'  
				left join st_CN_detail CNd on st_Sale_detail.Sales_Docno = CNd.Ref_Docno and st_Sale_detail.P_Code=CNd.P_Code
				left join st_CN_head CNh on CNd.Ref_Docno=CNh.Ref_Docno 
				where  st_Sale_detail.Createby='$reUDC[UID]' 
				and cast(st_Sale_head.Sales_Docdate  as date) = '$dateTo'  
				and st_Sale_detail.P_Code='$Pro'
				and (CNd.Ref_Docno is null or  CNh.CN_id <>'1'  )
				group by st_Sale_detail.P_Code,st_Sale_detail.PRODUCTNAME,con1.st_unit_qty,con2.st_unit_qty ";
				$sqlSum=sqlsrv_query($con,$sqlSum1);
				$sqlSum=sqlsrv_fetch_array($sqlSum);
				echo '<td align="center">';
				echo $sqlSum['box'];
				echo '</td>';
				echo '<td align="center">';
				echo $sqlSum['pack']; 
				echo '</td><td align="center">';
				if($sqlSum['totalamount']<>0){echo number_format($sqlSum['totalamount']); }
				echo '</td>';
				if($i==$i)
				{ 
				 $sum[$i]=$sum[$i]+$sqlSum['box'];
				 $sumpack[$i]=$sumpack[$i]+$sqlSum['pack'];
				 $sumtotalamount[$i]=$sumtotalamount[$i]+$sqlSum['totalamount'];				 
				}
			}
			?>
			
			<td align="center ">
			<? //ส่วนลด S+
			  $usernum =$reUDC['UID'];
			  $sql002="select * from st_dailysales where  Date_pay = '$dateTo' and User_id = '$usernum'  ";
			  $qry002=sqlsrv_query($con,$sql002);
			  $re002=sqlsrv_fetch_array($qry002); 
			  $Pay_diff = $re002['Pay_diff'];
			  $Pay   = $re002['Pay'];
			  $Bank = $re002['Bank'];
			  $R_num = $re002['Receipt_number'];
			  $detail = $re002['detail'];
			  $disS= $re002['disS'];
			  if($disS>0){$disS=$disS*-1;}
			  echo number_format($disS,2,'.',',');
			  $SUM_disS =$SUM_disS+$disS;?>
			</td>
			
			<td align="center ">
			<? 
			//ยอดขายสุทธิ
			$sqlTotal="select sum(st_Sale_detail.totalamount) as totalamount 
			from st_Sale_detail left join st_Sale_head 
			on st_Sale_detail.Sales_Docno = st_Sale_head.Sales_Docno LEFT OUTER JOIN dbo.st_item_unit_con con1 ON dbo.st_Sale_detail.P_Code = con1.P_Code AND con1.st_unit_id = 'ลัง'
			LEFT OUTER JOIN dbo.st_item_unit_con con2 ON dbo.st_Sale_detail.P_Code = con2.P_Code AND con2.st_unit_id = 'แพ็ค'
			left join st_CN_detail CNd on st_Sale_detail.Sales_Docno = CNd.Ref_Docno and st_Sale_detail.P_Code=CNd.P_Code 
			left join st_CN_head CNh on CNd.Ref_Docno=CNh.Ref_Docno 
			where st_Sale_detail.Createby='$reUDC[UID]'
			and cast(st_Sale_head.Sales_Docdate as date) = '$dateTo' 
			and (CNd.Ref_Docno is null or CNh.CN_id <>'1' ) ";
			$sqlTotal=sqlsrv_fetch_array(sqlsrv_query($con,$sqlTotal));
			$amount=($sqlTotal['totalamount']+$disS);
			echo number_format($amount,2,'.',','); 
			$sum_amount=$sum_amount+$amount;?>
			</td>
			<td align="center ">
			<? 
				echo $Pay_diff; $SUM_Pay_diff=$SUM_Pay_diff+$Pay_diff;?>
			</td>
			<td align="center "><?=number_format($Pay,2);$SUM_Pay=$SUM_Pay+$Pay;?></td>
			<!---<td align="center "><?=$Bank?></td>--->
			<td align="center "><?=$R_num?></td>
			<td align="center "><?=$detail;?></td>
			<td align="center ">
			<? 	//ยอดขายรวม
				$sqlTotalby1="select sum(st_Sale_detail.totalamount) as SumBy1 
				from st_Sale_detail 
				left join st_Sale_head on st_Sale_detail.Sales_Docno = st_Sale_head.Sales_Docno
				left join st_CN_detail CNd on st_Sale_detail.Sales_Docno = CNd.Ref_Docno and st_Sale_detail.P_Code=CNd.P_Code 
				left join st_CN_head CNh on CNd.Ref_Docno=CNh.Ref_Docno 
				where  st_Sale_detail.Createby='$reUDC[UID]' 
				and cast(st_Sale_head.Sales_Docdate  as date) between '$Start'  and '$dateTo'
				and (CNd.Ref_Docno is null or CNh.CN_id <>'1' ) ";
				$sqlTotalby1=sqlsrv_query($con,$sqlTotalby1);
				$sqlTotalby1=sqlsrv_fetch_array($sqlTotalby1);
				echo number_format($sqlTotalby1['SumBy1'],2,'.',','); 
				$TotalSumBy1=$TotalSumBy1+$sqlTotalby1['SumBy1'];
			?>
			</td>
			<td align="center ">
				<?
                 // CN  
				$sqlCN2= "select sum(st_CN_detail.totalamount) as SumByGroup from st_CN_detail left join st_CN_head
				on st_CN_detail.Ref_Docno = st_CN_head.Ref_Docno
				where  st_CN_detail.Createby='$reUDC[UID]' 
				and cast(st_CN_head.Ref_Docdate as date)  between '$Start'  and '$dateTo' 
				and st_CN_head.CN_id='1' ";
	            $sqlCN2=sqlsrv_query($con,$sqlCN2);
				$sqlCN2=sqlsrv_fetch_array($sqlCN2);
				echo number_format($sqlCN2['SumByGroup'],2,'.',',');  
				$TotalSumByGroup=$TotalSumByGroup+$sqlCN2['SumByGroup'];
				
			     //echo number_format($TotalCNBy,2,'.',',');  
				//
				?>

			</td>
			<td align="center ">
				<?
                 // ส่วนลด 	s+ รวม
				$sqlS_sum=" select sum(cast(disS as int)) as SUM_disS
				from st_dailysales 
				where Dc_groupid='$txt_DC' 
				and Date_pay between  '$Start'  and '$dateTo'
				and User_id = '$usernum'";
				$sqlS_sum=sqlsrv_query($con,$sqlS_sum);
				$sqlS_sum=sqlsrv_fetch_array($sqlS_sum);
				if($sqlS_sum['SUM_disS']>0){$sqlS_sum['SUM_disS']=$sqlS_sum['SUM_disS']*-1;}
				echo number_format($sqlS_sum['SUM_disS'],2,'.',',');
				$TotalSUM_disS=$TotalSUM_disS+$sqlS_sum['SUM_disS'];
				//
				?>

			</td>
			<td align="center ">
			<? 	
				$SumBy11=($sqlTotalby1['SumBy1'])+$sqlS_sum['SUM_disS'];
				echo number_format($SumBy11,2,'.',',');  
				$TotalSumBy=$TotalSumBy+$SumBy11;

		


			?>
			</td>
			<td align="center ">
			<? 	
				$sqlTotalPay="select SUM( cast(Pay as int))  as sumPay  from st_dailysales 
				where  User_id = '$reUDC[UID]'
				and Date_pay between  '$Start'  and '$dateTo'  ";
				$sqlTotalPay=sqlsrv_query($con,$sqlTotalPay);
				$sqlTotalPay=sqlsrv_fetch_array($sqlTotalPay);
				echo number_format($sqlTotalPay['sumPay'],2,'.',',');  $TotalsumPay =$TotalsumPay+$sqlTotalPay['sumPay'];
			?>
			</td>
			<td align="center ">
			<? //ผลต่าง
			$new=$SumBy11-$sqlTotalPay['sumPay'];
			echo number_format($new,2,'.',',');  $Totalnew =$Totalnew+$new;
			
			?>
			</td>
         
   
	<?
	
	$r++; 
	
	echo "</tr>";
}//user	
	?>
	
	<tr class="mousechange" >
			<td align="center " colspan="5"></td>
			<? for($i=0;$i<$countProduct;$i++)
			{	
				
				echo '<td align="center">'.number_format($sum[$i],2).'</td>';
				echo '<td align="center">'.number_format($sumpack[$i],2).'</td>';
				echo '<td align="center">'.number_format($sumtotalamount[$i],2).'</td>';
				
			}
			?>
			
			<td ><?=number_format($SUM_disS,2); $SUM_disS=0;?> </td>
			
			<td ><?=number_format($sum_amount,2); $sum_amount=0;?></td>
			<td ><?=number_format($SUM_Pay_diff,2); $SUM_Pay_diff=0;?> </td>
			<td ><?=number_format($SUM_Pay,2); $SUM_Pay=0;?> </td>
			<td></td><td></td>
			<td ><?=number_format($TotalSumBy1,2); $TotalSumBy1=0;?> </td>
			<td ><?=number_format($TotalSumByGroup,2); $TotalSumByGroup=0;?> </td>
			<td ><?=number_format($TotalSUM_disS,2); $TotalSUM_disS=0;?> </td>
			<td ><?=number_format($TotalSumBy,2); $TotalSumBy=0;?> </td>
			<td ><?=number_format($TotalsumPay,2); $TotalsumPay=0;?> </td>
			<td ><?=number_format($Totalnew,2); $Totalnew=0;?></td>
	</tr>
	
	</table>
<? } ?>
<br><br><div>**หมายเหตุ: ดึงยอดขายจากวันที่ขายจริงก่อนเที่ยงคืน </div>
</form>
<div id="txt_check" align="center"></div>
</body>
</html>



<!-------------
<? 
	    if($usernum != "-"){
		$c_carabao = $all_qty_carabao/50;
           		$p_carabao = ($all_qty_carabao % 50)/10;

           		$c_start = $all_qty_start/24;
           		$p_start = ($all_qty_start % 24)/6;
            ?>
			<tr  height="30" valign= "top" >
			<td align="left "><?=$dateTo;?> </td>
			<td align="left "><?=$temp_salecode;?> </td>
			<td align="left "><?=$temp_namesale;?> </td>
			<td align="center "><?=floor($c_carabao);?></td>
			<td align="center "><?=floor($p_carabao);?> </td>
			<td align="center "><?=floor($c_start);?></a>
			<td align="center "><?=floor($p_start);?></a>	
			<td align="right"><?=number_format($total,2,'.',','); ?></a>	
				<input type="hidden" id="total_<?=$usernum;?>" name ="total_<?=$usernum;?>"  value="<?=$total;?>">
		    <?  
		  $sql002="select * from st_dailysales where Dc_groupid='$txt_DC' and Date_pay = '$dateTo' and User_id = '$usernum'  ";
		  $qry002=sqlsrv_query($con,$sql002);
          $re002=sqlsrv_fetch_array($qry002); 
          $Pay_diff = $re002['Pay_diff'];
          $Pay   = $re002['Pay'];
          $Bank = $re002['Bank'];
          $R_num = $re002['Receipt_number'];
		 ?>
		    <td align="center "><?=$Pay_diff?></a>
			<td align="center "><?=$Pay?></a>	
		  <td align="center "><?=$Bank?></a>
			<td align="center "><?=$R_num?></a>		
			</td>
			</tr>
       <? } ?>
------------->
