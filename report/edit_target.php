<?//--------------------------------------pong 21/9/58
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
	
	$id=$_GET['id'];
	
	$show="select * from st_Sales_target where ID='$id' ";
	$show=sqlsrv_query($con,$show,$params,$options);	
	$show=sqlsrv_fetch_array($show);
	$DC__="SELECT * from st_user_group_dc where dc_groupid='$show[dc_groupid]' ";
	$DC__=sqlsrv_query($con,$DC__,$params,$options);
	$DC__=sqlsrv_fetch_array($DC__);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#save').button();
		$('#btn_add').button();
		$('#start').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                                });
		$('#end_').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//

		
		
		
		$('#Type').ready(function(){
				$('#Z_edit').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/Z_edit.php',
					type:'POST',
						data:$('#frmuser').serialize(),
					success:function(result){
						$('#Z_edit').html(result);
					}
				});
		});
		$('#Type').change(function(){
				$('#Z_edit').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/Z_edit.php',
					type:'POST',
						data:$('#frmuser').serialize(),
					success:function(result){
						$('#Z_edit').html(result);
					}
				});
		});
		
		
		
		
		});//function	
		
		
</script>
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>แก้ไขเป้ายอดขาย_<?=$DC__['dc_groupname'];?>+<?=$show['PRODUCTNAME'];?></h3>
            
          <p>
		  <input type="button" value="ค้นหาเป้ายอดขาย" id="btn_add" onclick="window.location='?page=from_target';"  class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_target&do=edit&id=<?=$show['ID'];?>" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="4" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>เป้าหมาย</B></td><td><input value="<?=$show['tar_name']; ?>" type="text" id="target" name="target" style="width:300px;"  required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>DC</B></td>
<td>
	
<input value="<?=$DC__['dc_groupname'];?>" type="text" id="DC" name="DC" disabled></td>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>วันที่เริ่มต้น</B></td><td><input value="<?=date_format($show['tar_start'],'Y/m/d');?>" type="text" id="start" name="start" required/>
&nbsp;<B>ถึง</B>&nbsp;<input value="<?=date_format($show['tar_end'],'Y/m/d');?>" type="text" id="end_" name="end_" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr >
<td width="120" ><B>ประเภทสินค้า</B></td><td colspan="4">

	<?$T_pro="select prd_type_id,prd_type_nm from st_item_product where P_Code='$show[P_Code]' ";
		$T_pro=sqlsrv_query($con,$T_pro,$params,$options);
		$T_pro=sqlsrv_fetch_array($T_pro);?>

<input value="<?=$T_pro['prd_type_nm'];?>" type="text" id="type" name="type" disabled>

&nbsp;&nbsp;<B>สินค้า</B>&nbsp;&nbsp;<input value="<?=$show['PRODUCTNAME'];?>" type="text" id="PCODE" name="PCODE" disabled>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>จำนวนเป้า</B></td><td><input value="<?=$show['tar_qty']; ?>" type="text" id="qty" name="qty" style="width:100px;" onKeyUp="if(this.value*1!=this.value) this.value='' ;" required/>
<input value="<?=$show['tar_unit'];?>" type="hidden" id="TUNIT" name="TUNIT" >
<input value="<?=$show['P_Code'];?>" type="hidden" id="PRODUCT" name="PRODUCT" >
<text id="Z_edit" ></text><!--ดึงจากไฟล์ X.php--></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>ผลตอบแทน</B></td><td><input value="<?=$show['tar_amount']; ?>" type="text" id="amount" name="amount" style="width:300px;"  required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>	
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>บริษัท</B></td><td>
<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">

		<?$company="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp where COMPANYCODE='$show[COMPANYCODE]' ";
		$company=sqlsrv_query($con,$company,$params,$options);
		$company=sqlsrv_fetch_array($company);?>
	<option value="<?=$re['COMPANYCODE'];?>" > **<?=$company['COMPANYNAME'];?>** </option>
	
	<?	$sql="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['COMPANYCODE']?>" ><?print $detail['COMPANYNAME']?></option>
		
			<?
			}

		
	
	?>

	</select>&nbsp;<B style="color:red;text-align:center;">*</B>
	</td></tr>




	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">			</tr>	
</table>
</form>
</div>
</div>
<div id="DivSave" ></div>
</body>
</html>