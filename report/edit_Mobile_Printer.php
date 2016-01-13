<?//---------------------------------แก้ไข โดย pong 15/09/2015-------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
		$id=$_GET['id'];
		
		$OPEN=" select *from st_Device_Mobile_Printer where Serial_No ='$id'  ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$OPEN=sqlsrv_query($con,$OPEN,$params,$options);
		$OPEN=sqlsrv_fetch_array($OPEN);
		
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#save').button();
		$('#cancel').button();
		$('#btn_back').button();
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
		$('#Receive').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
		$("#Type").ready(function(){
		 if($('#Type').val() == '2') {
            $('#C').show(); 
        } else {
            $('#C').hide(); 
        } 
		});
		
		$("#Type").ready(function(){
		 if($('#Type').val() == '6') {
            $('#U').show(); 
        } else {
            $('#U').hide(); 
        } 
		});
		$("#Type").click(function(){
		 if($('#Type').val() == '2') {
            $('#C').show(); 
        } else {
            $('#C').hide(); 
        } 
		});
		
		$("#Type").click(function(){
		 if($('#Type').val() == '6') {
            $('#U').show(); 
        } else {
            $('#U').hide(); 
        } 
		});		

		$('#edit_Check').change(function(){
		if (this.checked) {
			$("input.eiei").removeAttr("disabled");
			$('#Type').removeAttr("disabled");	
			$('#Center').removeAttr("disabled");	
			$('#user').removeAttr("disabled");			
		} else {
			$("input.eiei").attr("disabled", true);	  
			$('#Type').attr("disabled", true);	
			$('#Center').attr("disabled", true);
			$('#user').attr("disabled", true);	
		}
		});
		
	
		});//function	
</script>
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>แก้ไข Mobile Printer รหัส Serial NO.&nbsp;<?=$OPEN['Serial_No'];?></h3>
            
          <p>
		  <input type="button" value="ค้นหาทรัพย์สิน" id="btn_back" onclick="window.location='?page=from_asset';"  class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_Mobile_Printer&do=edit" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"  ><div class="h_head"></div></td></tr>
<tr><td colspan="2" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รหัส Serial number</B></td><td><input value="<?=$OPEN['Serial_No'];?>" type="hidden" id="Serial__" name="Serial__" ><input value="<?=$OPEN['Serial_No'];?>" type="text" id="Serial" name="Serial" class="eiei" disabled required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>รหัส PO No.</B></td><td><input value="<?=$OPEN['PO_No'];?>" type="text" id="PO" name="PO" class="eiei" disabled ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td width="120"><B>ยี่ห้อ</B></td><td><input value="<?=$OPEN['Manufacturer'];?>" type="text" id="Manufacturer" name="Manufacturer" class="eiei" disabled ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ผู้จัดจำหน่าย</B></td><td><input value="<?=$OPEN['Supplier'];?>" type="text" id="Supplier" name="Supplier" class="eiei" disabled ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>Model</B></td><td><input style="width:300px;" value="<?=$OPEN['Model'];?>" type="text" id="Model" name="Model" class="eiei" disabled ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>



<tr><td width="120"><B>รับประกัน</B></td><td><input value="<?=$OPEN['Warranty'];?>" type="text" id="Warranty" name="Warranty" class="eiei" disabled ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>วันที่รับของ</B></td><td><input value="<?=$OPEN['Receive_date'];?>" type="text" id="Receive" name="Receive" class="eiei" disabled></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>DC</B></td><td>
<select id="Type" name="Type"  style="width:150px;" disabled>
	<option value="<?=$OPEN['Type'];?>" >--<?if($OPEN['Type']=='2'){echo "ศูนย์กระจายสินค้า";}else if($OPEN['Type']=='6'){echo "sale";}?>--</option>
	<option value="">--เลือก--</option>
	<option value="2">ศูนย์กระจายสินค้า</option>
	<option value="6">sale</option>
	</select>
<abbr  hidden id="C" name="C">&nbsp;&nbsp;&nbsp;&nbsp;<B>ศูนย์</B>&nbsp;&nbsp;&nbsp;&nbsp;<select id="Center" name="Center"  style="width:200px;" disabled>
	
	<?
	$c1=" select * from st_user_rolemaster_detail where RoleID_Lineid ='$OPEN[Assign_to_User]'  ";
	$c1=sqlsrv_query($con,$c1,$params,$options);
	$c1=sqlsrv_fetch_array($c1);?>
		
	<option value="<?=$OPEN['Assign_to_User'];?>" >--<?=$c1['RoleName_Linename'];?>--</option>
	<option value="">--เลือก--</option>
	<?$sql2="select * from st_warehouse_location order by locationno asc";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry2	 = @sqlsrv_query($con,$sql2,$params,$options);				
			while($re2=sqlsrv_fetch_array($qry2))
			{
?>
<option value="<?=$re2['locationno'];?>"><?=$re2['locationname']; ?></option>
<? } ?>
	</select></abbr>
<abbr  hidden id="U" name="U">&nbsp;&nbsp;&nbsp;&nbsp;<B>ดูแลโดย</B>&nbsp;&nbsp;&nbsp;&nbsp;<select id="user" name="user"  style="width:150px;" disabled>
	<?
	$u1=" select * from st_user where User_id ='$OPEN[Assign_to_User]'  ";
	$u1=sqlsrv_query($con,$u1,$params,$options);
	$u1=sqlsrv_fetch_array($u1);?>


<option value="<?=$OPEN['Assign_to_User'];?>" >--<?echo $u1['User_id']."&nbsp;".$u1['name'];?>--</option>
<option value="">-USER-</option>
<?
				$sql2="select * from st_user order by User_id asc  ";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry2	 = @sqlsrv_query($con,$sql2,$params,$options);				
			while($re2=sqlsrv_fetch_array($qry2))
			{
?>
<option value="<?=$re2['User_id'];?>"><?echo $re2['User_id']."&nbsp;".$re2['name'];?></option>
<? } ?>
</select></abbr></td></tr>

	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="4"><input type="checkbox" id="edit_Check" name="edit_Check" >&nbsp;<b style="color:blue;text-align:center;">แก้ไข</b></td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">
<input type="button" value="cancel" id="cancel" onclick="window.location='?page=from_asset';" ></tr>	
</table>
</form>
</div>
</div>
<div id="DivSave" ></div>
</body>
</html>