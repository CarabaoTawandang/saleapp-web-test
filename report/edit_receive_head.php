<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
		
		$receive_no=$_GET['id'];
$sql1="select st_warehouse_stock_receive_head.receive_locationno ,st_warehouse_location.locationname 
, st_warehouse_stock_receive_head.receive_no
, cast(st_warehouse_stock_receive_head.receive_date as date) receive_date2 
 ,st_warehouse_stock_receive_head.ref_pack ,st_warehouse_stock_receive_head.ref_docno
,st_warehouse_stock_receive_head.receive_user_id
,uu.name as receive_user ,zz.COMPANYNAME as receive_company 
,st_warehouse_stock_receive_detail.P_Code ,st_item_product.PRODUCTNAME 
,st_warehouse_stock_receive_head.receive_Remark
,st_warehouse_stock_receive_detail.receive_qty 
 ,A.st_unit_qty as A
,B.st_unit_qty as B
,(st_warehouse_stock_receive_detail.receive_qty )/(A.st_unit_qty) as TatalBox
,(st_warehouse_stock_receive_detail.receive_qty )%(A.st_unit_qty) as balance1
,((st_warehouse_stock_receive_detail.receive_qty )%(A.st_unit_qty))/B.st_unit_qty as TatalPack
,((st_warehouse_stock_receive_detail.receive_qty )%(A.st_unit_qty))%B.st_unit_qty as TatalBottle
,st_warehouse_stock_receive_head.Update_byAX

  from st_user left join st_warehouse_stock_receive_head 
  on st_user.warehouse_locationNo =st_warehouse_stock_receive_head.receive_locationno left join st_warehouse_location 
  on st_warehouse_stock_receive_head.receive_locationno = st_warehouse_location.locationno left join st_warehouse_stock_receive_detail 
  on st_warehouse_stock_receive_head.receive_no = st_warehouse_stock_receive_detail.receive_no left join st_item_product 
  on st_warehouse_stock_receive_detail.P_Code=st_item_product.P_Code left join st_user uu 
  on st_warehouse_stock_receive_head.receive_user_id = uu.User_id left join st_companyinfo_exp zz 
  on st_warehouse_stock_receive_head.receive_user_id = zz.COMPANYCODE left join  st_item_unit_con A
on st_item_product.P_Code = A.P_Code and A.st_unit_id='ลัง' left join  st_item_unit_con B
on st_item_product.P_Code = B.P_Code and B.st_unit_id='แพ็ค' 
where st_user.User_id='$USER_id'";
if($receive_no){ $sql1.="and st_warehouse_stock_receive_head.receive_no='$receive_no' ";}

$sql1.="order by
st_warehouse_stock_receive_head.CreateDate asc
,cast(st_warehouse_stock_receive_head.receive_date as date) asc
,st_item_product.PRODUCTNAME asc";


//echo $sql;
$qry=sqlsrv_query($con,$sql1);
$re=sqlsrv_fetch_array($qry);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function()
{	
			
		$('#edit').button();$('#btn').button();
		
		$('#txt_receive_date').datepicker({
			
				dateFormat:'dd-mm-yy'
			});
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
	$('#txt_typePro').change(function(){
				$('#show_product').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/show_product.php',
					type:'POST',
					data:$('#frmuser').serialize(),
					//data:'value='+$('#txt_typePro').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#show_product').html(result);
					}
				});
	});	
	$('#txt_location').change(function(){
				$('#show_product').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/show_product.php',
					type:'POST',
					data:$('#frmuser').serialize(),
					//data:'value='+$('#txt_typePro').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#show_product').html(result);
					}
				});
	});		
});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>แก้ไขรับของเข้าคลัง  :<?=$re['locationname'];?> เลขเอกสาร : <?=$re['receive_no'];?></h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		   <input type="button" value="ข้อมูลรับของเข้าคลัง" id="btn" onclick="window.location='?page=from_receive_head';" class="inner_position_right" >
	</div><div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_receive_head&do=edit" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วันที่ตามใบส่งของ</B></td>
	<td >
	<input type="hidden" id="txt_receive_no" name="txt_receive_no" value="<?=$re['receive_no'];?>">
	<input type="text" id="txt_receive_date" name="txt_receive_date" value="<? echo date_format($re['receive_date2'],'d-m-Y'); ?>" required/></td>
	
	</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>เลขที่D/O No.(PS)</B></td><td>
	<input type="text" id="txt_ref_pack" name="txt_ref_pack" value="<? echo $re['ref_pack'];?>">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>ใบสั่งซื้อเลขที่ (PO)</B></td><td>
	<input type="text" id="txt_ref_docno" name="txt_ref_docno" value="<? echo $re['ref_docno'];?>">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>รับจาก :  </B></td><td>
	<select  id="txt_packName" name="txt_packName" style="width:170px;" required/>
	
	<option value="<?echo$re['receive_user_id']; ?>"><?  if($re['receive_user']){echo$re['receive_user'];} else if($re['receive_company']){echo$re['receive_company'];}?></option>
		<?	$sql="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp   ";
			
			$qry=sqlsrv_query($con,$sql);
			$row=sqlsrv_num_rows($qry);
			while ($detail=sqlsrv_fetch_array($qry))
			{
		?>
			<option value="<?print $detail['COMPANYCODE']?>" ><?print $detail['COMPANYNAME']?></option>
		<?
			}?>
			
		<? $sqlOp="select st_user_lv_Detail.user_id_head
			,st_user_lv_Detail.user_id_detail
			,st_user.*
			from st_user_lv_Detail left join st_user
			on st_user_lv_Detail.user_id_detail = st_user.User_id
			where  st_user_lv_Detail.user_id_head ='$USER_id' 
			order by name asc";
			$qryOp=sqlsrv_query($con,$sqlOp);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['user_id_detail']." '>";
			echo $deOp['name']." ".$deOp['surname'];
			echo "</option>";
			}
		?>
	</select>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>คลังสินค้า</B></td>
<td >
	<select id="txt_location" name="txt_location"  style="width:170px;" required/>
	<option value="<?echo$re['receive_locationno']; ?>"><?echo$re['locationname']; ?></option>
	<?	$sql="select st_user.warehouse_locationNo
,st_warehouse_location.locationname
from st_user  left join st_warehouse_location
on st_user.warehouse_locationNo = st_warehouse_location.locationno
where st_user.User_id='$USER_id'  ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			while($detail=sqlsrv_fetch_array($qry))
			{
			?>
			<option value="<?print $detail['warehouse_locationNo']?>" ><?print $detail['locationname']?></option>
		
			<?
			}

		
	
	?>
	</select>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>ประเภทสินค้า :  </B></td><td>
	<select  id="txt_typePro" name="txt_typePro" style="width:170px;" >
	<option value="">-เลือกประเภทสินค้า-</option>
		<?  $sqlOp="select prd_type_id,prd_type_nm
			from st_item_type
			order by prd_type_nm asc";
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['prd_type_id']." '>";
			echo $deOp['prd_type_nm'];
			echo "</option>";
			}
		?>
	</select>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>สินค้า </B></td>
<td><div id="show_product">
	<?
		$qry1=sqlsrv_query($con,$sql1);
		while ($re1=sqlsrv_fetch_array($qry1))
		{
			ECHO '<input type="CHECKBOX" id="checkItem_'.$re1['P_Code'].'" name="checkItem_'.$re1['P_Code'].'" value="'.$re1['P_Code'].'" checked >';
			echo $re1['PRODUCTNAME']; echo "&nbsp;&nbsp;&nbsp;"; $arrayShowItem[]=$P_Code =$re1['P_Code'];

			
							$sql2="  select st_unit_id,st_unit_name,P_Code
								  from st_item_unit_con
								  where P_Code ='$re1[P_Code]' order by st_unit_qty desc ";
								$qry2=sqlsrv_query($con,$sql2);
								$tt=1;
								while($re2=sqlsrv_fetch_array($qry2))
								{	//echo 'NumP_'.$P_Code.'_U_'.$re2['st_unit_id'];
									echo '<input    type="text" id="NumP_'.$P_Code.'_U_'.$re2['st_unit_id'].'" name="NumP_'.$P_Code.'_U_'.$re2['st_unit_id'].'" size="5" value="';
									if($tt=="1"){echo $re1['TatalBox'];}
									else if($tt=="2"){echo $re1['TatalPack'];}
									else if($tt=="3"){echo $re1['TatalBottle'];}
									echo '">';
									echo $re2['st_unit_id']; echo "&nbsp;";
								$tt++;}
			
			
			echo "<input type='hidden' id='txt_Bottle_".$re1['P_Code']."' name='txt_Bottle_".$re1['P_Code']."' value='".$re1['receive_qty']."'>"; //echo "txt_Bottle_".$re1['P_Code'];
			echo "<br><br>";
			
		}
		
		?>
		<?	
			
			$sql="SELECT P_Code,PRODUCTNAME  FROM st_item_product  where P_Code <>'$arrayShowItem[0]' ";
			for($i=1;$i<count($arrayShowItem);$i++)
			{$sql.="and  P_Code <>'$arrayShowItem[$i]' ";}
			//echo $sql;
			$qry=sqlsrv_query($con,$sql);
			while($detail=sqlsrv_fetch_array($qry))
			{	//echo "<br>";
				$P_Code=$detail['P_Code'];
			
		
?>
	
		
				
				<input type="hidden" id="checkItem_<?=$P_Code;?>" name="checkItem_<?=$P_Code;?>"  ><? //echo $detail['PRODUCTNAME'];?>
				<? 		$sql2="  select st_unit_id,st_unit_name,P_Code
								  from st_item_unit_con
								  where P_Code ='$detail[P_Code]' order by st_unit_id asc ";
								$qry2=sqlsrv_query($con,$sql2);
								while($re2=sqlsrv_fetch_array($qry2))
								{
								
						?>
						<input  type="hidden" id="NumP_<?=$P_Code;?>_U_<?=$re2['st_unit_id']?>" name="NumP_<?=$P_Code;?>_U_<?=$re2['st_unit_id']?>" size="5">
						<? //echo $re2['st_unit_id']?>
						
								<?}//while หน่วย ?>
	
		<? }//while P_Code ?>


</div></td>

		

				
		
</td></tr><tr><td colspan="2">&nbsp;</td></tr>
<tr><td  ><B>หมายเหตุ</B></td><td >
	<input type="text" id="txt_receive_Remark" name="txt_receive_Remark" size="70" value="<?print $re['receive_Remark']?>">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="edit" name="edit" value="Edit">			</tr>	
</table>
</form>
</div><!--/-box-->
</div><!--/-container_box-->
<div id="DivSave" ></div>
</body>
</html>