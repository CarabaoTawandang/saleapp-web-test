<?//------------------------------------------------------แก้ไข โดยpong 13/07/2558------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
		$id=$_GET['id'];
		
		$sqlOpen="select st_message_new.* 
,cast(DateFrom as date) as dateFrom2
,cast(DateTo as date) as DateTo2 from st_message_new where Code='$id'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		//$rowOpen=sqlsrv_num_rows($qryOpen);
		$re=sqlsrv_fetch_array($qryOpen);
		
		

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>


<script type="text/javascript">
$(function(){	
			
		$('#save').button();
		$('#add').button();
		$('#txt_day').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                                });
		$('#txt_day1').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
		
	
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
	<div class="header"><h3>แก้ไขข้อมูลข่าว&nbsp;<?=$re['Subject'];?></h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		  <h5> <input type="button" value="ค้นหาข่าว" id="add" onclick="window.location='?page=from_new';" class="inner_position_right" ></h5>
	</div><div class="sep"></div><br>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" action="?page=save_new&do=edit" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>ชื่อเรื่อง</td><td>
<input type="hidden" id="id_new" name="id_new" value="<?=$id;?>" style="width:100px;" readonly="readonly" >
<input type="text" value="<?=$re['Subject']; ?>" id="name_new" name="name_new" style="width:300px;" required/>
&nbsp;<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>วันที่ของข่าว</B></td><td><input type="text" value="<?=date_format($re['dateFrom2'],'Y/m/d');?>" id="txt_day" name="txt_day" >&nbsp;<B>ถึง</B>&nbsp;
<input type="text" value="<?=date_format($re['DateTo2'],'Y/m/d');?>" id="txt_day1" name="txt_day1" required/>
&nbsp;<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รายละเอียด</B></td><td><textarea type="text"  id="remark" name="remark" rows="5" cols="50"><?=$re['Remark'];?></textarea></td></tr>



<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>ตำแหน่งที่ใช้ในการแจ้งข่าว</B></td><td>
	<?
		$sql_T="select  RoleName_Linename,RoleID_Lineid from st_user_rolemaster_detail";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$sql_T=sqlsrv_query($con,$sql_T,$params,$options); 	
	$i=1;
		while($open1=sqlsrv_fetch_array($sql_T)){
		$sqlCkeck="select st_user_rolemaster_detail.RoleID_Lineid,st_message_new_detail.Code from st_user_rolemaster_detail
left join st_message_new_detail on st_message_new_detail.RoleID_Lineid=st_user_rolemaster_detail.RoleID_Lineid
left join st_message_new on st_message_new.Code=st_message_new_detail.Code
where st_message_new_detail.Code='$id' and st_user_rolemaster_detail.RoleID_Lineid='$open1[RoleID_Lineid]' ";
			$qryChech=sqlsrv_query($con,$sqlCkeck,$params,$options);
			$rowCheck=sqlsrv_num_rows($qryChech);
	?>
	<input type="checkbox"  name="txtType[]" value="<?=$open1['RoleID_Lineid'];?>" <? if($rowCheck>0){echo "checked";} ?>/><?=$open1['RoleName_Linename'];  ?>
	<? $i++;} ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B style="color:red;text-align:center;">*(เลือกได้มากกว่า1ประเภท)</B>
</td></tr>


<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>บริษัท</B></td><td>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
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
</div> <!--/-box-->
</div> <!--/-container_box-->
<div id="DivSave" ></div>
</body>
</html>