<?//------------------------------------------------------แก้ไข โดย PONG 24/06/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
		$userType= $_SESSION["RoleID"];
		$userType2 = $_SESSION["RoleID_Lineid"];
		//echo $userType." / ".$userType2;
		$id=$_GET['id'];
		
		$filter="select h.Ref_Docno,cast(h.Delivery_date as date) as Delivery_date ,cast(h.Delivery_date as time) as Delivery_time
		,h.CustNum as Cust1 ,h.CN_id ,h.CN_name ,h.Remark ,c.CustName ,c.AddressNum ,c.AddressMu ,c.DISTRICT_NAME ,c.AMPHUR_NAME 
		,c.PROVINCE_NAME,c.PROVINCE_CODE ,c.cust_type_name ,h.Createby ,st_user.Salecode,st_user.name,st_user.surname 
		from st_CN_head h left join st_View_cust_web c on c.CustNum = h.CustNum left join st_user 
		on h.Createby = st_user.User_id where Ref_Docno='$id' ";
		// echo $filter;
		$filter=sqlsrv_query($con,$filter); 
		$fil=sqlsrv_fetch_array($filter);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title></title>


<script type="text/javascript">

$(function(){	
			
		$('#save').button();
		$('#add').button();
		$('#datefrom').datepicker({ dateFormat:'dd-mm-yy' });
	
	 $("#txt_status").change(function(){
		//if($('#txt_status').prop('value')=='7') {alert('สถานะ ยืนยัน จะมีการตัด Stock ในคลัง');}
		//if($('#txt_status').prop('value')=='5') {alert('กรุณาใส่เหตุผลที่ยกเลิกด้วยคะ'); $('#txt_remark').focus(); } 
    });
	$('#save').click(function(){
				if($('#txt_status').prop('value')=='2' &&$('#txt_remark').prop('value')==''  ){alert('กรุณาใส่เหตุผลที่ไม่อนุมัติด้วยคะ!!!');}
				else{
				$('#DivSave').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/saveEdit_CreditNote.php',
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
	<div class="header"><h3>ยกเลิกบิล<?=$re['AMPHUR_NAME'];?></h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		   <input type="button" value="ค้นหา" id="add" onclick="window.location='?page=from_CreditNote';" class="inner_position_right" >
		   **หมายเหตุ : แก้ไขข้อมูลได้ต่อเมื่อ สิทธิเป็นแม่ทัพหรือAdminsale และสถานะขอยกเลิกเท่านั้น
	</div><div class="sep"></div><br>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr class="mousechange">
<td ><B>ใบเสนอขาย</td>
<td><? echo $fil['Ref_Docno'];?> <input type="hidden" id="txt_CNid" name="txt_CNid" value="<? echo $fil['Ref_Docno'];?>">

</td></tr>
<tr ><td colspan="2">&nbsp;</td></tr>
<tr class="mousechange">
<td ><B>พนักงานขาย</td>
<td>
<?  echo $fil['Createby'];?>
<? echo $fil['Salecode']." ".$fil['name']." ".$fil['surname'];?>
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
	$sqlQdetail="select q.Ref_Docno,q.P_Code ,pro.PRODUCTNAME,pro.st_unit_id as unit123 
	,q.st_unit_qty_1 ,q.st_unit_qty_2 ,q.st_unit_qty_3 ,q.st_unit_qty_1*u1.st_unit_qty as AA ,q.st_unit_qty_2*u2.st_unit_qty as BB ,q.st_unit_qty_3 As CC 
	,(isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0)) as total
	,(isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))/u1.st_unit_qty as box 
	,((isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))%u1.st_unit_qty)/u2.st_unit_qty as pack
	,((isnull(q.st_unit_qty_1*u1.st_unit_qty,0)+isnull(q.st_unit_qty_2*u2.st_unit_qty,0)+ isnull(q.st_unit_qty_3,0))%u1.st_unit_qty)%u2.st_unit_qty as unil 
	,q.totalamount ,q.PromotionId ,q.PromotionName ,q.PromotionRemark ,q.totaldiscount ,q.totalamount-q.totaldiscount as amount 
	from st_CN_detail q left join st_item_product pro 
	on q.P_Code =pro.P_Code left join st_item_unit_con u1 
	on u1.P_Code = q.P_Code and u1.st_unit_id= 'ลัง' left join st_item_unit_con u2 
	on u2.P_Code = q.P_Code and u2.st_unit_id= 'แพ็ค'
	where q.Ref_Docno ='$id' ";
//echo $sqlQdetail;
	$sqlQdetail=sqlsrv_query($con,$sqlQdetail); 
	while($Qdetail=sqlsrv_fetch_array($sqlQdetail))
	{
?>
<tr  class="mousechange" ><td ><B><? if($i==0){echo 'สินค้า';} ?></td><td>
<? echo $Qdetail['P_Code']." ".$Qdetail['PRODUCTNAME']." ";

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

<tr><td colspan="2">&nbsp;</td></tr>
<tr ><td ><B>สถานะ</B></td><td >
<select id="txt_status" name="txt_status" <?if($fil['CN_id'] <> "3" and  $userType2!=" 7_6"){echo 'disabled';} ?> >
<option value="<? echo $fil['CN_id'];?>"><? echo $fil['CN_name'];?></option>
<? 

$sqlStatus="select  CN_id,CN_name from st_CN_status where   CN_id <>'3' ";
$sqlStatus.="order by CN_id asc";
echo $sqlStatus;
$sqlStatus=sqlsrv_query($con,$sqlStatus); 
	while($Status=sqlsrv_fetch_array($sqlStatus))
	{ if($fil['CN_id'] ==$Status['CN_id']){}
	  else {echo '<option value="'.$Status['CN_id'].'">'.$Status['CN_name'].'</option>';}
	}

?>
</select></td>

</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr ><td ><B>เหตุผล : </B></td><td >
<input type="text" size="50" id="txt_remark" name="txt_remark" value="<? echo $fil['CN_Remark'];?>" 
 <?if($fil['CN_id']<> "3" and   $userType2!=" 7_6"){echo 'disabled';} ?>>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<? if($fil['CN_id']== "3" and   ($userType2 =="7_6" or $userType2 =="7_1")){ ?>
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