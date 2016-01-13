<?
session_start();
set_time_limit(0);
include("../includes/config.php");
//$txt_DC=$_POST['txt_DC'];
$USER_DC =	$_SESSION["USER_id"];
$sqlOp1="select * from st_user  where User_id ='$USER_DC'";
$qryOp1=sqlsrv_query($con,$sqlOp1);
$deOp1=sqlsrv_fetch_array($qryOp1); 
$txt_DC = $deOp1["dc_groupid"];
//$dateTo = $_POST['dateTo'];
$time = strtotime($_POST['dateTo']);
$dateTo = date('m/d/Y',$time);
echo $dateTo;
$usernum = "-";
$all_qty_carabao = 0;
$all_qty_start = 0;
$total = 0;
$do = "insert";
$sqlOp="select dc_groupname,dc_groupid from st_user_group_dc where dc_groupid='$txt_DC'";
$qryOp=sqlsrv_query($con,$sqlOp);
$deOp=sqlsrv_fetch_array($qryOp); 

///////////////////////   Check ว่าเคย Insert รึยัง 
$sql001="select * from st_dailysales where Dc_groupid='$txt_DC' and Date_pay = '$dateTo'";
$qry001=sqlsrv_query($con,$sql001);
$re001=sqlsrv_fetch_array($qry001); 
if($re001)
		{
          $do = "update";
		}
//echo $do;

////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
		$('#txt_file').change(function(){
			//alert('file');
			var fty=new Array(".pdf",".PDF"); // ประเภทไฟล์ที่อนุญาตให้อัพโหลด     
			var a= $('#txt_file').prop('value'); //กำหนดค่าของไฟล์ใหกับตัวแปร a     
			var permiss=0; // เงื่อนไขไฟล์อนุญาต  
			a=a.toLowerCase();      
			if(a !="")
			{  
            for(i=0;i<fty.length;i++){ // วน Loop ตรวจสอบไฟล์ที่อนุญาต     
                if(a.lastIndexOf(fty[i])>=0){  // เงื่อนไขไฟล์ที่อนุญาต     
                    permiss=1;  
                    break;  
                }else{  
                    continue;  
                }  
            }    
            if(permiss==0){   
                alert("อัพโหลดได้เฉพาะไฟล์  .pdf");  
				document.frmuser.txt_file.value	='';				
                return false;                 
            }         
			}     
		});
		     
             
        
		$('#save').button();

		$('#save').click(function(){
					
					if($('#txt_file').prop('value')==''  && $('#txt_fileCheckFile').prop('value')=='' )
					{ var r = confirm('คุณยังไม่ได้ แนบไฟล์ PDF คะ!!! \n\nถ้าต้องการบันทึกแบบไม่แนบไฟล์ กดยกเลิก');
						
						
					}
					if (r == true) {alert('กลับไปแนบไฟล์ PDF');}
					else
					{
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
					}
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
     <div align="left"><b><? echo $deOp["dc_groupname"]; ?><b></div>
	 <div align="left">
	 <?
	$CheckFile="select id_file from st_dailysales_file where Dc_groupid='$txt_DC' and Date_pay='$dateTo' ";
	$CheckFile=sqlsrv_query($con,$CheckFile);
	$CheckFile=sqlsrv_fetch_array($CheckFile);
	if($CheckFile['id_file'])
	{echo "<a  target='_blank'  href='dailysales_file/".$CheckFile['id_file']." '>ดู FIle PDF ที่แนบ</a>";; }
	 ?>
	 </div>
	 <br><input type="hidden" id="txt_fileCheckFile" name="txt_fileCheckFile" value="<?=$CheckFile['id_file'];?>">
	 <br><div align="left"><input type="file" id="txt_file" name="txt_file">
	  <font color="red" align="left">**กรุณาแนบเอกสารยืนยันต้องเป็นนามสกุล .pdf เท่านั้น</font></div><br>
     <input type="hidden" id="dc_group" name ="dc_group"  value="<?=$txt_DC;?>">
     <input type="hidden" id="date_to" name ="date_to"  value="<?=$dateTo;?>">
      <input type="hidden" id="do" name ="do"  value="<?=$do;?>">
	<table  align="center" class="tables" width="100%">
	<tr>
	<th align="center" rowspan="2">ลำดับ</th>
	<th align="center" rowspan="2">วันที่</th>
	<th align="center" rowspan="2">รหัส User</th>
	<th align="center" rowspan="2">Sales code</th>
	<th align="center" rowspan="2">Sales name</th>
	<? $ProductBy="select P_Code,PRODUCTNAME from st_item_product where prd_type_id='S001' and P_Code not like 'FG9001%' order  by P_Code asc ";
		$ProductBy=sqlsrv_query($con,$ProductBy);$countProduct=0;
		while($By=sqlsrv_fetch_array($ProductBy)) 
		{	$ByPro[]=$By['P_Code'];
			echo '<th align="center" colspan="2">'.$By['PRODUCTNAME'].'</th>';
			 $countProduct++;
		}
	
	?>
	
	<th align="center" rowspan="2">ยอดขาย</th>
	<th align="center" rowspan="2">CN</th>
	<th align="center" rowspan="2">ส่วนลด S+</th>
	<th align="center" rowspan="2">+/-<br>โอนเงิน<br>ขาด/เกิน <br> <font color="red">(กรอกเฉพาะเลข)</font></th>
	<th align="center" rowspan="2">เงินโอนสุทธิ <br> <font color="red">(กรอกเฉพาะเลข)</font></th>
	<!--<th align="center" rowspan="2">Bank</th>--->
    <th align="center" rowspan="2">Receipt number</th>
	<th align="center" rowspan="2">หมายเหตุ</th>
	</tr>
	<tr>
	<?
	for($i=0;$i<$countProduct;$i++)
	{
		echo '<th align="center">ลัง</th>
		<th align="center">แพ็ค</th>';
	}
	?>
	</tr>
	<? 
	/*echo $sql="select st_Sale_detail.*,st_user.name,st_user.surname,st_user.Salecode,st_user.dc_groupid
	from st_Sale_detail left join st_user  on st_Sale_detail.Createby = st_user.User_id
	where cast(st_Sale_detail.CreateDate as date) = '$dateTo'  and st_user.dc_groupid  = '$txt_DC'
    order by st_Sale_detail.Createby asc
	";

	$qry=sqlsrv_query($con,$sql);
	//echo $sql;
	$r=0;
	while($re=sqlsrv_fetch_array($qry))
	{ */
	$r=0; $pp=0;
	
	$sqlUDC="select User_id as UID,name,surname,Salecode,dc_groupid,RoleID,RoleID_Lineid from st_user 
				where RoleID_Lineid ='6_2'and Dc_groupid='$txt_DC'  and status ='Y'
				order by Salecode asc ";
	$qryUDC=sqlsrv_query($con,$sqlUDC);			
	while($reUDC=sqlsrv_fetch_array($qryUDC))
	{ 	//echo "<br>**".$reUDC['UID'];
		$pp++;echo '<tr class="mousechange"  height="30" valign= "top" >
			<td align="left ">'.$pp.'</td>
			<td align="left ">'.$dateTo.'</td>
			<td align="left ">'.$reUDC['UID'].'</td>
			<td align="left ">'.$reUDC['Salecode'].'</td>
			<td align="left ">'.$reUDC['name'].'</td> ';
       
			for($i=0;$i<$countProduct;$i++)
			{	$Pro=$ByPro[$i];
				$sqlSum="select 
				sum(st_unit_qty_3)/con1.st_unit_qty as box
				,(sum(st_unit_qty_3)%con1.st_unit_qty)/con2.st_unit_qty as pack

				from st_Sale_detail left join st_Sale_head
				on st_Sale_detail.Sales_Docno = st_Sale_head.Sales_Docno LEFT OUTER JOIN  dbo.st_item_unit_con con1
				 ON dbo.st_Sale_detail.P_Code = con1.P_Code AND con1.st_unit_id = 'ลัง' LEFT OUTER JOIN  dbo.st_item_unit_con con2
				 ON dbo.st_Sale_detail.P_Code = con2.P_Code AND con2.st_unit_id = 'แพ็ค'  

				where  st_Sale_detail.Createby='$reUDC[UID]' 
				and cast(st_Sale_head.Sales_Docdate  as date) = '$dateTo'  
				and st_Sale_detail.P_Code='$Pro'

				group by con1.st_unit_qty,con2.st_unit_qty ";
				$sqlSum=sqlsrv_query($con,$sqlSum);
				$sqlSum=sqlsrv_fetch_array($sqlSum);
				echo '<td align="center">';
				echo $sqlSum['box'];
				echo '</td>';
				echo '<td align="center">';
				echo $sqlSum['pack']; 
				echo '</td>';
				if($i==$i)
				{ 
				 $sum[$i]=$sum[$i]+$sqlSum['box'];
				 $sumpack[$i]=$sumpack[$i]+$sqlSum['pack']; 
				}
			}
            ?>
			
			
		<td align="right">
			<?
			$sqlTotal="select sum(st_Sale_detail.totalamount) as totalamount from st_Sale_detail left join st_Sale_head
			on st_Sale_detail.Sales_Docno = st_Sale_head.Sales_Docno
			where  st_Sale_detail.Createby='$reUDC[UID]' 
			and cast(st_Sale_head.Sales_Docdate  as date) = '$dateTo'";
			
			/*$sqlTotal="select sum(totalamount) as totalamount from st_Sale_detail
			where  st_Sale_detail.Createby='$reUDC[UID]' 
			and cast(st_Sale_detail.CreateDate as date) = '$dateTo' ";*/
			$qryTotal=sqlsrv_query($con,$sqlTotal);
			$reTotal=sqlsrv_fetch_array($qryTotal);
			//and cast(st_Sale_detail.CreateDate as date) = '$dateTo' ";
			$qryTotal=sqlsrv_query($con,$sqlTotal);
			$reTotal=sqlsrv_fetch_array($qryTotal);
			
			echo number_format($reTotal['totalamount'],2,'.',','); 
			$SUM_totalamount=$SUM_totalamount+$reTotal['totalamount']; 
			?>
			</td>
		 <input type="hidden" id="total_<?=$usernum;?>" name ="total_<?=$usernum;?>"  value="<?=$total;?>">
		 <?  $usernum =$reUDC['UID'];
		  $sql002="select * from st_dailysales where Dc_groupid='$txt_DC' and Date_pay = '$dateTo' and User_id = '$usernum'  ";
		  $qry002=sqlsrv_query($con,$sql002);
          $re002=sqlsrv_fetch_array($qry002); 
          $Pay_diff = $re002['Pay_diff']; $SUM_Pay_diff=$SUM_Pay_diff+$Pay_diff;
          $Pay   = $re002['Pay'];   $SUM_Pay=$SUM_Pay+$Pay;
          $Bank = $re002['Bank'];
          $R_num = $re002['Receipt_number'];
		  $detail = $re002['detail'];
		  $disS= $re002['disS']; $SUM_disS =$SUM_disS+$disS;
		 ?>
		 <td align="center ">
	      <?
                 // CN  
 					$sqlCN= "select sum(st_CN_detail.totalamount) as SumBy from st_CN_detail left join st_CN_head
				on st_CN_detail.Ref_Docno = st_CN_head.Ref_Docno
				where  st_CN_detail.Createby='$reUDC[UID]' 
				and cast(st_CN_head.Ref_Docdate as date) = '$dateTo'";
	            $sqlCN=sqlsrv_query($con,$sqlCN);
				$sqlCN=sqlsrv_fetch_array($sqlCN);
				echo number_format($sqlCN['SumBy'],2,'.',',');  
				$TotalCNBy=$TotalCNBy+$sqlCN['SumBy'];
			     //echo number_format($TotalCNBy,2,'.',',');  
				//
				 ?>
		 	</td>
		   <td align="center "><input type="text" id="txtdis_S_<?=$usernum;?>" name ="txtdis_S_<?=$usernum;?>"  size="8" value="<?=$disS?>"></td>
		    <td align="center "><input type="text" id="txtPay_diff_<?=$usernum;?>" name ="txtPay_diff_<?=$usernum;?>"  size="8" value="<?=$Pay_diff?>"></td>
			<td align="center "><input type="text"  onKeyUp="if(this.value*1!=this.value) this.value='' ;" id="txtPay_total_<?=$usernum;?>" name ="txtPay_total_<?=$usernum;?>" size="8"  value="<?=$Pay?>"></td>	
		  <!---<td align="center "><input type="text" id="txtBank_<?=$usernum;?>" name ="txtBank_<?=$usernum;?>"  size="8" value="<?=$Bank?>"></td>
		--->	<td align="center "><input type="text" id="txtR_num_<?=$usernum;?>" name ="txtR_num_<?=$usernum;?>" size="8"  value="<?=$R_num?>"></td>		
			</td>
			
			<td align="center "><input type="text" id="txtR_Detail_<?=$usernum;?>" name ="txtR_Detail_<?=$usernum;?>" size="8"  value="<?=$detail?>"></td>		
			</tr>
         
   
	<?
	
	$r++;} $colspan=($countProduct*2)+5;?>
	<tr>
			<td align="center " colspan="<?=$colspan;?>"></td>
			<td align="center "><?=number_format($SUM_totalamount,2,'.',',');?> </td>

			<td align="center "><?=number_format($TotalCNBy,2,'.',','); ?> </td>
			<td align="center "><?=number_format($SUM_disS,2,'.',',');?> </td>
			<td align="center "><?=number_format($SUM_Pay_diff,2,'.',',');?> </td>
			<td align="center "><?=number_format($SUM_Pay,2,'.',',');?> </td>
	</tr>
	
	</table>
<br><br><div>**หมายเหตุ: ดึงยอดขายจากวันที่ขายจริงก่อนเที่ยงคืน </div>

<input type="submit" id="save" name="save" value="save">
</form>
<div id="txt_check" align="center"></div>
</body>
</html>

























<!-----------
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
		    <td align="center "><input type="text" id="txtPay_diff_<?=$usernum;?>" name ="txtPay_diff_<?=$usernum;?>"  size="8" value="<?=$Pay_diff?>"></a>
			<td align="center "><input type="text" id="txtPay_total_<?=$usernum;?>" name ="txtPay_total_<?=$usernum;?>" size="8"  value="<?=$Pay?>"></a>	
		  <td align="center "><input type="text" id="txtBank_<?=$usernum;?>" name ="txtBank_<?=$usernum;?>"  size="8" value="<?=$Bank?>"></a>
			<td align="center "><input type="text" id="txtR_num_<?=$usernum;?>" name ="txtR_num_<?=$usernum;?>" size="8"  value="<?=$R_num?>"></a>		
			</td>
			</tr>
       <? } ?>
---------->
