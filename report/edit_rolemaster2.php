<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$id=$_GET['id'];
		$sqlOpen="select st_user_rolemaster_detail.RoleID ,st_user_rolemaster_head.RoleName 
			,st_user_rolemaster_detail.RoleID_Lineid ,st_user_rolemaster_detail.RoleName_Linename 
			,st_user_rolemaster_detail.warehouse_locationNo ,st_warehouse_location.locationname 
			,st_user_rolemaster_head.COMPANYCODE
			,st_user_rolemaster_detail.COMPANYCODE
			from st_user_rolemaster_detail left join st_user_rolemaster_head 
			on st_user_rolemaster_detail.RoleID=st_user_rolemaster_head.RoleID left join st_warehouse_location 
			on st_user_rolemaster_detail.warehouse_locationNo = st_warehouse_location.locationno  left join st_companyinfo_exp
			on st_user_rolemaster_head.COMPANYCODE =st_companyinfo_exp.COMPANYCODE
			where st_user_rolemaster_detail.RoleID_Lineid='$id' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$rowOpen=sqlsrv_num_rows($qryOpen);
		$re=sqlsrv_fetch_array($qryOpen);
		
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
	/*	
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
	*/	
		
		});//function	
</script>
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>แก้ไขตำแหน่ง</h3>
            
          <p>
		  <input type="button" value="ค้นหาตำแหน่ง" id="btn_add" onclick="window.location='?page=from_rolemaster';"  class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_rolemaster2" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>ตำแหน่งหลัก</B></td><td>
	<select id="txt_Role" name="txt_Role"  style="width:170px;" required/>
	<option value="<?print $re['RoleID']?>" > <?print $re['RoleName']?></option>
	<?	$sql="SELECT RoleID,RoleName  FROM st_user_rolemaster_head   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['RoleID']?>" ><?print $detail['RoleName']?></option>
		
			<?
			}

		
	
	?>
	</select>&nbsp;<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>ชื่อตำแหน่งย่อย</B></td><td><input type="text" id="txtRole" name="txtRole"  value="<?=$re['RoleName_Linename'];?>" required/>
&nbsp;<B style="color:red;text-align:center;">*</B>
<input type="hidden" id="do" name="do"  value="edit" >
<input type="hidden" id="id" name="id"  value="<?=$id;?>" >
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td ><B>ประเภทร้านที่เปิด</B></td><td>
	<? 	
	$sqlOpen="select cust_type_id,cust_type_name from st_cust_type";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$rowOpen=sqlsrv_num_rows($qryOpen);
	$i=1;
		while($open1=sqlsrv_fetch_array($qryOpen)){
			$sqlCkeck="select cust_type_id from st_user_rolemaster_head_type where RoleID='$id' and cust_type_id='$open1[cust_type_id]'";
			$qryChech=sqlsrv_query($con,$sqlCkeck,$params,$options);
			$rowCheck=sqlsrv_num_rows($qryChech);
	?>
	<input type="checkbox"  name="txtType[]" value="<?=$open1['cust_type_id'];?>" <? if($rowCheck>0){echo "checked";} ?>/><?=$open1['cust_type_name'];?>
	<? $i++;} ?> &nbsp;&nbsp;&nbsp;&nbsp;<font color="red">*(เลือกได้มากกว่า1ประเภท)</font>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td><B>บริษัท</B></td><td>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
		<?$company="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp where COMPANYCODE='$re[COMPANYCODE]' ";
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