<?//------------------------------------------------------แก้ไข โดย DREAM 10/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
		$userType= $_SESSION["RoleID"];
		$userType2 = $_SESSION["RoleID_Lineid"];
		//echo $userType." / ".$userType2;
		
?>
<script type="text/javascript">

$(function(){	
		$('#txtdate1,#txtdate2,#Delivery_date,#txtdateCN').datepicker({ dateFormat:'dd-mm-yy' });	
		$('#btn_add').button();$('#btn_add2').button();
		$('#btn_search').click(function(){
					if(($('#txt_DC').prop('value')=='')&&($('#txt_name').prop('value')=='')
					&&($('#txtdateCN').prop('value')=='')&&($('#txtdateCN2').prop('value')=='')
					&&($('#txt_pro').prop('value')=='')&&($('#txt_aum').prop('value')=='')
					&&($('#txtdate1').prop('value')=='')&&($('#txtdate2').prop('value')=='')
					&&($('#txt_CNid').prop('value')=='')&&($('#txt_status').prop('value')=='')
					&&($('#txt_dis').prop('value')=='')&&($('#txt_saleType').prop('value')=='')
					&&($('#txt_id').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_CreditNote.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
		$('#txtdate1').change(function(){
			var x1 =$('#txtdate1').prop('value');
			document.frmSearch.txtdate2.value = x1;
			
		});	
		$('#txtdateCN').change(function(){
			var x11 =$('#txtdateCN').prop('value');
			document.frmSearch.txtdateCN2.value = x11;
			
		});
		
		$('#txt_DC').change(function(){
				
				$.ajax({
					url:'report/province_from_plan.php',
					type:'POST',
					data:'value='+$('#txt_DC').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_pro').html(result);
					}
				});
			});	
			
		$('#txt_pro').change(function(){
				
				$.ajax({
					url:'report/aumphur.php',
					type:'POST',
					data:'value='+$('#txt_pro').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_aum').html(result);
					}
				});
			});
		
		$('#txt_aum').change(function(){
				
				$.ajax({
					url:'report/district.php',
					type:'POST',
					data:'value='+$('#txt_aum').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_dis').html(result);
					}
				});
			});
		
	$('#order_n').change(function(){
		if($('#order_n').val()=='') {

		$('#sort').attr("disabled", true); 
	
		} else {

	  $('#sort').removeAttr("disabled");
	 
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

<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>ยกเลิกบิล</h3>
            
          <p>
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  cellpadding="0" cellspacing="0" align="center" border="0">
	<tr><td align="center">
	
	วันที่เปิดบิล :&nbsp;<input type="text" id="txtdate1" name="txtdate1" value="">
	&nbsp;&nbsp;
	ถึง :&nbsp;<input type="text" id="txtdate2" name="txtdate2" value="">
	&nbsp;&nbsp;
	รหัสบิล:&nbsp;<input type="text" id="txt_id" name="txt_id">
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td align="center">
	&nbsp;&nbsp;ชื่อร้านค้า :&nbsp;<input type="text" id="txt_name" name="txt_name">&nbsp;&nbsp;
	<B>สถานะ: </B>
	<select id="txt_status" name="txt_status"><option value="">-ALL-</option>
	<? 
	$sqlStatus="select  CN_id,CN_name from st_CN_status  order by CN_id asc";
	$sqlStatus=sqlsrv_query($con,$sqlStatus); 
		while($Status=sqlsrv_fetch_array($sqlStatus))
		{ echo '<option value="'.$Status['CN_id'].'">'.$Status['CN_name'].'</option>';
		}
	?>
	</select>
	&nbsp;&nbsp;<B>ประเภทขาย: </B>
	<select id="txt_saleType" name="txt_saleType"><option value="">-ALL-</option>
	<? 
	$sqlSaleType="select  SaleType,SaleTypeName from st_saletype order by SaleTypeName asc";
	$sqlSaleType=sqlsrv_query($con,$sqlSaleType); 
		while($SaleType=sqlsrv_fetch_array($sqlSaleType))
		{ echo '<option value="'.$SaleType['SaleType'].'">'.$SaleType['SaleTypeName'].'</option>';
		}
	?>
	</select>
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	
	<tr><td align="center">
	<B>DC: </B>
	<select  id="txt_DC" name="txt_DC" style="width:170px;" >
	<option value="">-All-</option>
		<? $sqlOp="select a.dc_groupname,a.dc_groupid
			from st_user_group_dc a   ";
			if($userType <>"7" and $userType2<>""){
				$sqlOp.=" left join st_user u
				on u.dc_groupid =a.dc_groupid
				where u.User_id= '$USER_id'"; }
			//echo $sqlOp;
			$qryOp=sqlsrv_query($con,$sqlOp);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['dc_groupid']." '>";
			echo $deOp['dc_groupname'];
			echo "</option>";
			}
		?>
	</select>
	<B style="color:black;text-align:center;">จังหวัด  :</B>
	<select style="width:150px;text-align:left;" id="txt_pro"  name="txt_pro" >
	<option value="">-All-</option>
	<?	$sql3="SELECT * FROM dc_Province  order by PROVINCE_NAME asc  ";
			$qry3=sqlsrv_query($con,$sql3);
			while($detail3=sqlsrv_fetch_array($qry3))
				{
				echo '<option value="'.$detail3['PROVINCE_CODE'].'">'.$detail3['PROVINCE_NAME'].'</option>';
				}
		?>
	
	</select>&nbsp;&nbsp;
	<B style="color:black;text-align:center;">อำเภอ / แขวง  :</B>
	<select style="width:150px;text-align:left;" id="txt_aum"  name="txt_aum" >
	<option value="">-All -</option>
		
	</select>&nbsp;&nbsp;
	<B style="color:black;text-align:center;">ตำบล / แขวง  :</B>
	<select style="width:150px;text-align:left;" id="txt_dis"  name="txt_dis" >
	<option value="">-All -</option>
		
	</select></td></tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	
	<tr><td align="center">
	<!----ประเภทร้าน
	<select style="width:150px;text-align:left;" id="txt_custType"  name="txt_custType" >
	<option value="">-เลือก -</option>
		
	</select>&nbsp;&nbsp;--->
	เลขที่ CN:&nbsp;<input type="text" id="txt_CNid" name="txt_CNid">&nbsp;
	วันที่ยกเลิกCN :&nbsp;<input type="text" id="txtdateCN" name="txtdateCN" value="">
	ถึง :&nbsp;<input type="text" id="txtdateCN2" name="txtdateCN2" value="">
	<input type="checkbox" value="all" id="txt_all" name="txt_all">ดูทั้งหมด
	<br><br>
	
	เรียง  :
	<select style="width:100px;text-align:left;" id="order_n"  name="order_n" >
	<option value="">-เลือก-</option>
	<option value="cast(h.Ref_Docdate as date)">วันที่เปิดบิล</option>
	<option value="c.CustName">ชื่อร้าน</option>
	<option value="c.PROVINCE_NAME">จังหวัด</option>
	<option value="c.cust_type_name">ประเภทร้าน</option>
	<option value="h.CN_id">สถานะ</option>
	</select>&nbsp;&nbsp;
	<select style="width:100px;text-align:left;" id="sort"  name="sort" disabled>
	<option value="">-แบบ-</option>
	<option value="ASC">น้อยไปมาก</option>
	<option value="DESC">มากไปน้อย</option>
	</select>
	<input type="button" value="ค้นหา" class="myButton_form" id="btn_search" name="btn_search" align="center">
	
	
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->
<br><br>
<div id="txt_search" align="center">
ยกเลิกบิลของเดือนปัจจุบัน
<div>  **หมายเหตุ : บิลที่ยังไม่อนุมัติ จำนวนเงินCN เป็น0</div>
<table  align="center" class="tables" >
	<tr>
	<th align="center"width="30px">ลำดับ</th>
	<th align="center"width="100px">ประเภทขาย</th>
	<th align="center"width="200px">Sale</th>
	<th align="center"width="150px">วันที่เปิดบิล</th>
	<th align="center"width="200px">รหัสบิล</th>
	<th align="center"width="200px">Invoice</th>
	<th align="center"width="100px">ร้านค้า</th>
	<th align="center"width="250px">ที่อยู่</th>
	<th align="center"width="100px">จังหวัด</th>
	<th align="center"width="100px">ประเภทร้าน</th>
	<th align="center"width="200px">DC</th>
	<th align="center"width="100px">หมายเหตุที่ขอยกเลิก</th>
	
	<th align="center"width="100px">สถานะ</th>
	<th align="center"width="200px">Approve โดย</th>
	<th align="center"width="100px">เหตุผล</th>
	<th align="center"width="100px">เลขที่ CN</th>
	<th align="center"width="20px">จำนวนเงินCN</th>
	<th align="center"width="20px">จัดการ</th>
	</tr>
	<? 	
	$Ym=date('Y-m');
	$filter="select h.Ref_Docno 
	,cast(h.Ref_Docdate as date) as Quotation_date 
	,cast(h.Ref_Docdate as time) as Quotation_time 
	,h.SaleType ,ST.SaleTypeName 
	,cast(h.Delivery_date as date) as Delivery_date
	,cast(h.Delivery_date as time) as Delivery_time
	,h.CustNum as Cust1 ,h.CN_id ,h.CN_name
	,h.TaxInv 	
	,h.Remark
	,h.CN_Remark
	,h.CN_Docno
	,h.Createby as sale,UserSale.Salecode ,UserSale.name as saleName,UserSale.surname as SaleSurname
	,c.CustName ,c.AddressNum ,c.AddressMu 
	,c.DISTRICT_NAME ,c.AMPHUR_NAME ,c.PROVINCE_NAME
	,c.PROVINCE_CODE ,c.cust_type_name ,h.Approveby as 'by' 
	,sum(d.totalamount) as totalamount
	,sum(d.totaldiscount) as totaldiscount
	,
	case when h.CN_id=1 then sum(d.totalamount)-sum(d.totaldiscount) 
	else 0
	end total 
	from st_CN_head h 
	left join st_View_cust_web c on c.CustNum =  h.CustNum  
	left join st_saletype ST on h.SaleType = ST.SaleType 
	left join st_user UserSale on h.Createby=UserSale.User_id
	left join st_CN_detail d on h.Ref_Docno=d.Ref_Docno
	";

if($_GET['id']){$filter.=" where  h.Ref_Docno  = '$_GET[id]' "; } 
else
{	$filter.=" where cast(h.Ref_Docdate as date) like '$Ym%'  "; 
	if($userType <>'7')
	{ 	$sqlProDC="select dc_ProId
		FROM st_view_Open_cust  where User_id='$USER_id'  ";
		$sqlProDC=sqlsrv_query($con,$sqlProDC);
			while($ProDC=sqlsrv_fetch_array($sqlProDC)){
			if($ProDCString==""){$ProDCString =$ProDCString."".$ProDC['dc_ProId'];}
			else{ $ProDCString =$ProDCString." ,".$ProDC['dc_ProId']."  ";}
			}
	 $ProDCString;
	}
	if($ProDCString){$filter.="and c.PROVINCE_CODE in ($ProDCString) "; } 
 }
 $filter.="group by h.Ref_Docno ,cast(h.Ref_Docdate as date) ,cast(h.Ref_Docdate as time)  ,h.SaleType 
	,ST.SaleTypeName ,cast(h.Delivery_date as date)  ,cast(h.Delivery_date as time) ,h.CustNum 
	,h.CN_id ,h.CN_name ,h.TaxInv ,h.Remark ,h.CN_Remark ,h.CN_Docno ,h.Createby,UserSale.Salecode ,UserSale.name,UserSale.surname 
	,c.CustName ,c.AddressNum ,c.AddressMu ,c.DISTRICT_NAME ,c.AMPHUR_NAME ,c.PROVINCE_NAME ,c.PROVINCE_CODE ,c.cust_type_name ,h.Approveby ";
	
$filter.=" order by cast(h.Ref_Docdate as date)  asc "; 
//echo $filter;

	$filter=sqlsrv_query($con,$filter); $r=1;
	while($fil=sqlsrv_fetch_array($filter)){
			$Qua_name = trim($fil['CN_name']);
			 if($Qua_name=="อนุมัติ"){$color="#01DF3A";}
			else if($Qua_name=="ไม่อนุมัติ"){$color="#FF4000";}
			else {$color="#000";$Qua_name='ขอยกเลิก'; }
	//onMouseover="this.bgColor='#FFFF6F',this.fontcolor='black';" onMouseout="this.bgColor=''" 
	?>
	<tr class="mousechange" >
	<td><?=$r;$r++; ?>.</td>
	<td><?=$fil['SaleTypeName'];?></td>
	<td><?=$fil['Salecode']." ".$fil['saleName']." ".$fil['SaleSurname'];?></td>
	<td><?echo date_format($fil['Quotation_date'],'d-m-Y'); echo " ".date_format($fil['Quotation_time'],'H:i');?></td>
	
	<td><?=$fil['Ref_Docno'];?></td>
	<td><?echo $fil['TaxInv'];?></td>
	<td><?=$fil['CustName'];?></td>
	<td>
	<?
					if($fil['AddressNum']){echo "  ที่อยู่  ".$fil['AddressNum'];}
					if($fil['AddressMu']){echo " ม.  ".$fil['AddressMu'];}
					if($fil['DISTRICT_NAME']){echo " ต.  ".$fil['DISTRICT_NAME'];}
					if($fil['AMPHUR_NAME']){echo " อ.  ".$fil['AMPHUR_NAME'];}
					//if($fil['PROVINCE_NAME']){echo " จ.  ".$fil['PROVINCE_NAME'];}
					
	?>
	</td>
	<td><?echo $fil['PROVINCE_NAME'];?></td>
	<td><? if($fil['cust_type_name']){echo " ".$fil['cust_type_name'];}?></td>
	<td>
	<? 		$PROVINCE_CODE= $fil['PROVINCE_CODE'];
			$sqlProVince="select d.dc_groupid,d.dc_ProId,h.dc_groupname
			FROM st_user_group_dc_detail d left join st_user_group_dc h
			on d.dc_groupid = h.dc_groupid
			group by d.dc_groupid,d.dc_ProId,h.dc_groupname
			having  dc_ProId='$PROVINCE_CODE'";
			$sqlProVince=sqlsrv_query($con,$sqlProVince); 
			while($ProVince=sqlsrv_fetch_array($sqlProVince)){
			echo $ProVince['dc_groupname']."<br>";
			}
	?>
	</td>
	<td  ><?=$fil['Remark']; ?></td>
	
	
	<td><font color="<?=$color; ?>"><b><?echo $Qua_name;?></b></font>
	<? if($Qua_name=="ยืนยัน") {?><img src="./images/printer.png"  width="20px" height="20px"><? } ?>
	</td>
	<td><b><? $fil['by'];
		 $sqlBy="select u.name,u.surname,u.dc_groupid,dc.dc_groupname
			FROM st_user u left join st_user_group_dc dc on u.dc_groupid = dc.dc_groupid
			where User_id='$fil[by]'";
			$sqlBy=sqlsrv_query($con,$sqlBy); 
			$sqlBy=sqlsrv_fetch_array($sqlBy);
			echo $sqlBy['name']." ".$sqlBy['surname'];?></b>
			<? if($sqlBy['dc_groupname']){echo " DC: ".$sqlBy['dc_groupname'];} ?>
	</td>
	<td  ><?=$fil['CN_Remark']; ?></td>
	<td  ><?=$fil['CN_Docno']; ?></td>
	<td align="center"  ><?=number_format($fil['total']); $total=$total+$fil['total'];?></td>
	<td align="center"  >
	<a href="?page=edit_CreditNote&id=<?=$fil['Ref_Docno']; ?>" >
	<img src="./images/edit.gif" style="cursor:pointer" alt="Complete">
	</a>
	</td>
	</tr>
	<? } ?>
	<tr class="mousechange" bgColor="#A0CD64" align="right" ><td colspan="16">รวม</td>
	<td align="center"  ><?=number_format($total); ?></td>
	</tr>
	</table>
</div>
<?
if($_GET['do']=="del")
{
	$id=$_GET['id'];
	
	$del3="delete from st_Master_plan where Plan_id=$id ";
	$qrydel3=sqlsrv_query($con,$del3,$params,$options); //tb stock ท้ายรถ
	
	
	  
	  
	$sqlDel4="delete st_Master_PlanDetail  where Plan_id=$id ";//เปิดใบรับของเข้าท้ายรถ หลัก
	$qryDel4=sqlsrv_query($con,$sqlDel4,$params,$options);
	
	
	if($qrydel3)
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบแผนเรียบร้อยแล้ว ");';
			echo "window.location='?page=from_plan';";
			echo '</script>';
	}
	else
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบ  ไม่สำเร็จ ");';
			echo "window.location='?page=from_plan';";
			echo '</script>';
	}
	
	
}
?>