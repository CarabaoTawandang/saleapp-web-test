<?//------------------------------------------------------แก้ไข โดย PONG 24/06/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
		$userType= $_SESSION["RoleID"];
		$userType2 = $_SESSION["RoleID_Lineid"];
		//echo $userType." / ".$userType2;
		$id=$_GET['id'];
		
		$filter="select h.Quotation_Docno,cast(h.Delivery_date as date) as Delivery_date
		,cast(h.Delivery_date as time) as Delivery_time
		,h.CustNum as Cust1 
		,h.Qua_id
		,h.Qua_name
		,h.Remark
		,c.CustName
		,c.AddressNum
		,c.AddressMu
		,c.DISTRICT_NAME
		,c.AMPHUR_NAME
		,c.PROVINCE_NAME,c.PROVINCE_CODE
		,c.cust_type_name
		,h.Createby ,st_user.Salecode,st_user.name,st_user.surname
		from st_Quotation_head h left join st_View_cust_web c
		on c.CustNum =  h.CustNum  left join st_user on h.Createby = st_user.User_id
		where Quotation_Docno='$id'
		
		 ";
		$filter=sqlsrv_query($con,$filter); 
		$fil=sqlsrv_fetch_array($filter);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title></title>


<script type="text/javascript">
function Confirm()
{
  var x = confirm("คุณต้องการยกเลิกการยืนยันบิลนี้ใช่หรือไม่");
  if (x)
     window.location.href = "?page=CN_saleCreadit&id=<?=$id; ?>";
  else
    return false;
}
$(function(){	
			
		$('#save').button();
		$('#add').button();
		$('#datefrom').datepicker({ dateFormat:'dd-mm-yy' });
	
	 $("#txt_status").change(function(){
		//if($('#txt_status').prop('value')=='7') {alert('สถานะ ยืนยัน จะมีการตัด Stock ในคลัง');}
		//if($('#txt_status').prop('value')=='5') {alert('กรุณาใส่เหตุผลที่ยกเลิกด้วยคะ'); $('#txt_remark').focus(); } 
    });
	$('#save').click(function(){
				if($('#txt_status').prop('value')=='5' && $('#txt_remark').prop('value')==''){alert('กรุณาใส่เหตุผลที่ยกเลิกด้วยคะ!!!');}
				else{
				$('#DivSave').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/saveEdit_Quotation.php',
					type:'POST',
					data:$('#frmuser').serialize(),
					success:function(result){
						$('#DivSave').html(result);
					}
				});
				}
		});
		
});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>ใบเสนอราคา<?=$re['AMPHUR_NAME'];?></h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		   <input type="button" value="ค้นหา" id="add" onclick="window.location='?page=from_Quotation';" class="inner_position_right" >
		   **หมายเหตุ : สถานะยกเลิก/ยืนยัน ไม่สามารถแก้ไขได้
	</div><div class="sep"></div><br>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr class="mousechange">
<td ><B>ใบเสนอขาย</td>
<td><? echo $fil['Quotation_Docno'];?> <input type="hidden" id="txt_Qid" name="txt_Qid" value="<? echo $fil['Quotation_Docno'];?>">

</td></tr>
<tr ><td colspan="2">&nbsp;</td></tr>
<tr class="mousechange">
<td ><B>พนักงานขาย</td>
<td><? echo $fil['Salecode']." ".$fil['name']." ".$fil['surname'];?>
<input type="hidden" id="txt_Saleid" name="txt_Saleid" value="<? echo $fil['Createby'];?>">
</td></tr>
<tr ><td colspan="2">&nbsp;</td></tr>
<tr class="mousechange">
<td ><B>ร้านค้า</td>
<td><? 				echo $fil['CustName'];
					if($fil['AddressNum']){echo "  ที่อยู่  ".$fil['AddressNum'];}
					if($fil['AddressMu']){echo " ม.  ".$fil['AddressMu'];}
					if($fil['DISTRICT_NAME']){echo " ต.  ".$fil['DISTRICT_NAME'];}
					if($fil['AMPHUR_NAME']){echo " อ.  ".$fil['AMPHUR_NAME'];}
					if($fil['PROVINCE_NAME']){echo " จ.  ".$fil['PROVINCE_NAME'];}
?></td></tr>
<tr ><td colspan="2">&nbsp;</td></tr>

<? 	$i=0;
$sqlQdetail="select q.Quotation_Docno,q.Quo_line,q.P_Code ,pro.PRODUCTNAME,pro.st_unit_id as unit123
,q.st_unit_qty_1
,q.st_unit_qty_2
,q.st_unit_qty_3
,q.st_unit_qty_1*u1.st_unit_qty as AA
,q.st_unit_qty_2*u2.st_unit_qty as BB
,q.st_unit_qty_3 As CC
,(isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))  as total 
,(isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))/u1.st_unit_qty as box 
,((isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))%u1.st_unit_qty)/u2.st_unit_qty as pack 
,((isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))%u1.st_unit_qty)%u2.st_unit_qty as unil 
,q.totalamount
,q.PromotionId
,q.PromotionName
,q.PromotionRemark
,q.totaldiscount
,q.totalamount-q.totaldiscount  as amount
from st_Quotation_detail q  left join st_item_product pro
on q.P_Code =pro.P_Code left join st_item_unit_con u1
on u1.P_Code = q.P_Code and u1.st_unit_id=  'ลัง' left join st_item_unit_con u2
on u2.P_Code = q.P_Code and u2.st_unit_id=  'แพ็ค'
where q.Quotation_Docno ='$id'
order by q.Quo_line asc ";
	$sqlQdetail=sqlsrv_query($con,$sqlQdetail); 
	while($Qdetail=sqlsrv_fetch_array($sqlQdetail))
	{
?>
<tr  class="mousechange" ><td ><B><? if($i==0){echo 'สินค้า';} ?></td><td><? echo $Qdetail['P_Code']." ".$Qdetail['PRODUCTNAME']." ";

if($Qdetail['box']) {echo $Qdetail['box']." ลัง ";}
if($Qdetail['pack']) {echo $Qdetail['pack']." แพ็ค ";}
if($Qdetail['unil']) {echo $Qdetail['unil']."  ".$Qdetail['unit123'];}
 ?>
</td>
<td  align="right"><? if($Qdetail['totalamount']) {echo $Qdetail['totalamount'];}?></td>
</tr>
<tr class="mousechange"><td >&nbsp;</td><td >&nbsp; 
<?
if($Qdetail['PromotionName']) {echo $Qdetail['PromotionName']."  ";}
if($Qdetail['PromotionRemark']) {echo " (".$Qdetail['PromotionRemark'].") ";}
?>
</td>
<td  align="right"><? if($Qdetail['totaldiscount']) {echo $Qdetail['totaldiscount'];}?></td>
</tr>
<tr class="mousechange"><td colspan="2"></td><td align="right">
<? if($Qdetail['amount']) {echo $Qdetail['amount'];}?>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

<? $i++;} ?>
<tr><td colspan="2">&nbsp;</td></tr>
<tr ><td ><B>วันที่นัดส่งของ</B></td><td >
<input type="text" <?if($fil['Qua_id']=='5' or $fil['Qua_id']=='7' or $fil['Qua_id']=='9' or $userType=="7"){echo 'disabled';} ?> id="datefrom" name="datefrom"
 value='<? echo date_format($fil['Delivery_date'],'d-m-Y');?>'></td>
 <? if($fil['Qua_id']=='7'){ ?>
<td rowspan="7" >
<button  <?if( $userType=="7"){echo 'disabled';} ?> type="button" name="but_cn" id="but_cn" onClick="Confirm();" style="width:150px; height:70px">
<img src="images/cancel.png" width="30" height="30" />
<span lang="th" xml:lang="th">CN.<br>ยกเลิกการยืนยัน</span>
</button>
</td>
<? } ?>
 </tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr ><td ><B>สถานะ</B></td><td >
<select id="txt_status" name="txt_status" <?if($fil['Qua_id']=='5' || $fil['Qua_id']=='7'  or $fil['Qua_id']=='9' or $userType=="7"){echo 'disabled';} ?> >
<option value="<? echo $fil['Qua_id'];?>"><? echo $fil['Qua_name'];?></option>
<? 
if($fil['Qua_id']<>'5' || $fil['Qua_id']=='7'){
$sqlStatus="select  Qua_id,Qua_name from st_Quotation_status where Qua_id <>'1' and Qua_id <>'9' ";
if($fil['Qua_id']=='1'){$sqlStatus.="and Qua_id <>'7' ";}
$sqlStatus.="order by Qua_id asc";
$sqlStatus=sqlsrv_query($con,$sqlStatus); 
	while($Status=sqlsrv_fetch_array($sqlStatus))
	{ if($fil['Qua_id'] ==$Status['Qua_id']){}
	  else {echo '<option value="'.$Status['Qua_id'].'">'.$Status['Qua_name'].'</option>';}
	}
}
?>
</select>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr ><td ><B>เหตุผล : </B></td><td >
<input type="text" size="50" id="txt_remark" name="txt_remark" value="<? echo $fil['Remark'];?>"  <?if($fil['Qua_id']=='5' or $fil['Qua_id']=='7'  or $fil['Qua_id']=='9' or $userType=="7"){echo 'disabled';} ?>>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<? if($fil['Qua_id']<>'5' && $fil['Qua_id']<>'7'  && $fil['Qua_id']<>'9' && $userType<>"7"){ ?>
<input type="button" id="save" name="save" value="save">	
<? } 

 ?>		
</tr>	
</table>
</form>
</div> <!--/-box-->
</div> <!--/-container_box-->
<div id="DivSave" align="center" ></div>
</body>
</html>