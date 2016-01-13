<?//------------------------------------------------------แก้ไข โดย DREAM 23/07/2558------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
		$id=$_GET['id'];
		$id_=$_GET['id_'];
		$id__=$_GET['id__'];
		
		$sqlOpen="select PRODUCTNAME,st_unit_id,P_Code from st_item_product where P_Code='$id' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$re=sqlsrv_fetch_array($qryOpen);
		
		
		$sqlOpen2="select *from st_item_price where st_unit_id='$id_'and P_Code='$id' and SaleType='$id__' ";
		$qryOpen2=sqlsrv_query($con,$sqlOpen2,$params,$options);
		$re2=sqlsrv_fetch_array($qryOpen2);


		$op="select SaleTypeName from st_saletype  where SaleType='$id__' ";
		$op=sqlsrv_query($con,$op,$params,$options);
		$op=sqlsrv_fetch_array($op);
		
		$qry="SELECT * from st_item_unit_con  where P_Code= '$id' and st_unit_id='$id_' ";
		$qry=sqlsrv_query($con,$qry,$params,$options);
		$qry=sqlsrv_fetch_array($qry);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>


<script type="text/javascript">
$(function(){	
			
		$('#save').button();
		$('#add').button();
		
	
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
		
		
		});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>แก้ไขหน่วย+สินค้า&nbsp;<?=$re['PRODUCTNAME'];?></h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		  <h5> <input type="button" value="ค้นหาหน่วย+สินค้า " id="add" onclick="window.location='?page=from_item';" class="inner_position_right" ></h5>
	</div><div class="sep"></div><br>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" action="?page=save_unit_price&do=edit" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"  ><div class="h_head"></div></td></tr>
<tr><td colspan="2" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td width="150"><B>สินค้า</td><td><input type="text" id="id_P" name="id_P" value="<?=$re['PRODUCTNAME'];?>" style="width:100px;" disabled></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>หน่วยสินค้า</td><td><input type="text" id="unit" name="unit"value="<?=$id_ ?>"  style="width:100px;" disabled></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>ประเภท</td><td><input type="text" id="type" name="type"value="<?=$op['SaleTypeName']; ?>"  style="width:100px;" disabled></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>จำนวน</B></td><td><input  id='count' name="count" type="text" value="<?=$qry['st_unit_qty']; ?>"style="width:100px;"  disabled>&nbsp;<?=$re1['st_unit_qty']; ?>&nbsp;&nbsp;<?=$re['st_unit_id'];?></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>ราคาซื้อ</B></td><td><input type="text" id="buy" name="buy" value="<?=$re2['st_buy_price']; ?>" style="width:100px;"onKeyUp="if(this.value*1!=this.value) this.value='' ;">&nbsp;(บาท)</select>&nbsp;<B style="color:red;text-align:center;">*</B></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>ราคาขาย</B></td><td><input type="text" id="sell" name="sell" value="<?=$re2['st_sell_price']; ?>"style="width:100px;" onKeyUp="if(this.value*1!=this.value) this.value='' ;">&nbsp;(บาท)</select>&nbsp;<B style="color:red;text-align:center;">*</B></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">			</tr>	
<input type="hidden" id="id_P" name="id_P" value="<?=$re['P_Code'];?>">	
<input type="hidden" id="id_type" name="id_type" value="<?=$id__;?>">	
<input type="hidden" id="id_unit" name="id_unit" value="<?=$id_;?>">	
</table>
</form>
</div> <!--/-box-->
</div> <!--/-container_box-->
<div id="DivSave" ></div>
</body>
</html>