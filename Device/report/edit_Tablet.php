<?//---------------------------------แก้ไข โดย pong 15/09/2015-------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
		$id=$_GET['id'];

		$OPEN=" select *from st_device_tablet_detail where imei ='$id'  ";
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
		
		
		$('#edit_Check').change(function(){
		if (this.checked) {
			$("input.eiei").removeAttr("disabled");
			$('#Type').removeAttr("disabled");
			$('#status').removeAttr("disabled");
			$('#remark').removeAttr("disabled");
		
		} else {
			$("input.eiei").attr("disabled", true);	  
			$('#Type').attr("disabled", true);	
			$('#status').attr("disabled", true);
			$('#remark').attr("disabled", true);				

		}
		});
		$("#tabs").tabs(); 
		
		$('#day_gps').datepicker({
				maxDate: ' +0D',
				dateFormat:'yy-mm-dd'
			});	
	
		$('#time_gps').timepicker({
				dateFormat:'H:i'
		});
		
		$('#search_gps').click(function(){
					if(($('#day_gps').prop('value')==''))
					{alert("โปรดใส่สิ่งที่ต้องการค้นหา !");}
					else {
					$('#gps').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/map_tablet.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#gps').html(result);
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

      <div class="header">
        
        <h3>แก้ไข Tablet รหัส IMEI:&nbsp;<?=$OPEN['imei'];?></h3>
            
          <p>
		 
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_Tablet&do=edit" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="4" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td width="120"><B>IMEI</B></td><td width="250"><input value="<?=$OPEN['imei'];?>" type="hidden" id="IMEI__" name="IMEI__" ><input value="<?=$OPEN['imei'];?>" type="text" id="IMEI" name="IMEI" disabled required/>&nbsp;<B style="color:red;text-align:center;">*</B></td>
<td width="120"><B>ยี่ห้อ</B></td><td><input value="<?=$OPEN['manufacturer'];?>" type="text" id="Manufacturer" name="Manufacturer" disabled></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>

<tr>
<td width="120"><B>Serial number</B></td><td><input value="<?=$OPEN['serail_number'];?>" type="hidden" id="Serial__" name="Serial__" ><input value="<?=$OPEN['serail_number'];?>" type="text" id="Serial" name="Serial" disabled required/>&nbsp;<B style="color:red;text-align:center;">*</B></td>
<td width="120"><B>ผู้จัดจำหน่าย</B></td><td><input value="<?=$OPEN['supplier'];?>" type="text" id="Supplier" name="Supplier" class="eiei" disabled>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td width="120"><B>Serial Sim.</B></td><td><input value="<?=$OPEN['sim_id'];?>" type="text" id="SIM" name="SIM" disabled></td>
<td width="120"><B>RAM</B></td><td><input value="<?=$OPEN['ram'];?>" type="text" id="RAM" name="RAM" disabled></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td width="120"><B>PO No.</B></td><td><input value="<?=$OPEN['po_num'];?>" type="text" id="PO" name="PO" class="eiei" disabled></td>
<td width="120"><B>ROM</B></td><td><input value="<?=$OPEN['memory'];?>" type="text" id="Memory" name="Memory" disabled></td>
</tr>

<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td width="120"><B>Model</B></td><td><input value="<?=$OPEN['model_num'];?>" type="text" id="Model_num" name="Model_num" disabled></td>
<td width="120"><B>Total ROM</B></td><td><input value="<?=$OPEN['memory_available'];?>" type="text" id="size_M" name="size_M" disabled></td>

</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td width="120"><B>วันที่รับของ</B></td><td><input value="<?=$OPEN['receive_date'];?>" type="text" id="Receive" name="Receive" class="eiei" disabled></td>
<?	$phone_="select * from st_Device_PhoneSim where sim_id='$OPEN[sim_id]'  ";
	$phone_= sqlsrv_query($con,$phone_,$params,$options);
	$phone_=sqlsrv_fetch_array($phone_);
	?>
<td width="120"><B>รับประกัน</B></td><td><input value="<?=$OPEN['warranty'];?>" type="text" id="Warranty" name="Warranty" class="eiei" disabled></td>

</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<?		$ST=" select *from st_user where talet_no_imei ='$OPEN[imei]'  ";
		$ST=sqlsrv_query($con,$ST,$params,$options);
		$ST=sqlsrv_fetch_array($ST);
		$DC_="select * from st_user_group_dc where dc_groupid ='$ST[dc_groupid]'  ";
		$DC_=sqlsrv_query($con,$DC_,$params,$options);
		$DC_=sqlsrv_fetch_array($DC_);
		$_USER="select * from st_user where User_id ='$ST[User_id]'  ";
		$_USER=sqlsrv_query($con,$_USER,$params,$options);
		$_USER=sqlsrv_fetch_array($_USER);?>
<td width="120"><B>DC</B></td><td><input size="25" value="<?=$DC_['dc_groupname'];?>" type="text" id="dc" name="dc" disabled></td>

<td width="120"><B>Sim No.</B></td><td><input size="25" value="<?=$phone_['phone_no'];?>" type="text" id="tel" name="tel" disabled></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>

<td width="120"><B>Sale</B></td><td><input size="25" value="<?echo $_USER['User_id']."&nbsp;".$_USER['name'];?>" type="text" id="_user" name="_user" disabled></td>
<td width="120"><B>สถานะ</B></td><td>

<select id="status" name="status"  style="width:150px;" disabled>
<?
$Status__=$OPEN['Status'];
if ($Status__=='NULL'&&$Status__=='NULL'){?>
	<option value="">--เลือก--</option><?}else{?>
	<option value="<?=$OPEN['Status'];?>"><?=$OPEN['Status'];?></option><?}?>
	<option value="Stand by">Stand by</option>
	<option value="In used">In used</option>
	<option value="Repair">Repair</option>
	<option value="Life off">Life off</option>
	<option value="Develop">Develop</option>
	<option value="Salestools">Salestools</option>
	<option value="Spare DC">Spare DC</option>
	
	</select></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td width="120"><B>หมายเหตุ</B></td><td colspan="4"><textarea type="text" id="remark" name="remark" rows="3" cols="75" disabled><?=$OPEN['Remark'];?></textarea></td>

</tr>
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr><td colspan="4"><input type="checkbox" id="edit_Check" name="edit_Check" >&nbsp;<b style="color:blue;text-align:center;">แก้ไข</b></td></tr>
	<tr><td colspan="4">&nbsp;</td></tr>


<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">
<input type="button" value="cancel" id="cancel" onclick="window.location='?page=from_asset';" ></tr>	
<tr><td colspan="4">&nbsp;</td></tr>
</table>
</form>
<style type="text/css">  
 
.ui-tabs{  
    font-family:tahoma;  
    font-size:12px; 
	height:auto;  
	background: #FFFFFF;
	border: none;
	
} 

#container {
    width: 0 auto;
    margin: 0 auto;
    padding: 0px;

}

.pagination {
    background: #f2f2f2;
    padding: 20px;
    margin-bottom: 20px;
}

.page {
    display: inline-block;
    padding: 0px 9px;
    margin-right: 4px;
    border-radius: 3px;
    border: solid 1px #c0c0c0;
    background: #e9e9e9;
    box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
}
</style> 
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Maintenance</a></li>
		<li><a href="#tabs-2">Log User</a></li>
		<li><a href="#tabs-3">Maps</a></li>
	
	</ul>
	<div id="tabs-1" >
<?
$sql="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY ID_Maintenance) AS
rownum,ID_Maintenance,Serial_No,IMEI,Category,Description,Status
      ,Cost,Equipment,Date_receiver,UpdateDate,Createby FROM st_D_Maintenance where IMEI like '$id' 
	  ) AS Table1  ";

$result=sqlsrv_query($con,$sql,$params,$options);
$num_rows=sqlsrv_num_rows($result);?>
<table cellpadding="0" cellspacing="0" border="0" align="left"  width="1050px">
	<tr><td align="right"><p><input type="button" value="เพิ่มรายการซ่อมบำรุง" id="btn_add" class="myButton_form" onclick="window.location='?page=add_Maintenance_for_edit_tablet&id=<?=$OPEN['imei'];?>';"></p></td></tr>
	<?
if($num_rows==0){echo"<tr><td><p align='center'><b>----------ไม่พบข้อมูล------------</b></p></td></tr>";}else{	?>
	</table>
<table cellpadding="0" cellspacing="0"  border="0" align="left"  class="box" width="1050px">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0" BORDERCOLOR="#FF9933" border="1" align="left"  width="1050px">
	<tr bgcolor="#FFCC99">
	<td align="center"><font size="2">ลำดับ</font></td>
	<td align="center"><font size="2">NO.</font></td>
	<td align="center"><font size="2">อุปกรณ์</font></td>
	<td align="center"><font size="2">IMEI</font></td>
	<td align="center"><font size="2">Serial No.</font></td>
	<td align="center"><font size="2">การซ่อม</font></td>
	<td align="center"><font size="2">คำอธิบาย</font></td>
	<td align="center"><font size="2">สถานะ</font></td>
	<td align="center"><font size="2">ค่าซ่อม</font></td>
	<td align="center"><font size="2">คนรับของ</font></td>
	<td align="center"><font size="2">วันที่ส่งซ่อม</font></td>
	<td align="center"><font size="2">วันที่อับเดต</font></td>
	
	<td align="center"><font size="2">แก้ไข</font></td>
	<td align="center"><font size="2">ลบ</font></td>


	</tr>

<?


	$TOP=" SELECT TOP 1 rownum FROM  (SELECT ROW_NUMBER() OVER(ORDER BY ID_Maintenance) AS
	rownum,ID_Maintenance,Serial_No,IMEI,Category,Description,Status
      ,Cost,Equipment,Date_receiver,UpdateDate,Createby FROM st_D_Maintenance where IMEI like '$id') AS Table1";
		$TOP=sqlsrv_query($con,$TOP,$params,$options);
		$TOP=sqlsrv_fetch_array($TOP);
		
		
$per_page = 50;
$P=$per_page+$TOP['rownum']-1;
if(!$page_)

	if($_GET['do']=="NOW")
	{
	$page__=$_GET['page__'];
	$page_=$page__;
	$P=$per_page*$page_+$TOP['rownum']-1;

	}else
	
	if($_GET['do']=="NEXT")
	{
	$page__=$_GET['page__'];
	$page_=$page__+1;
	$P=$per_page*$page_+$TOP['rownum']-1;

	}else
	
	if($_GET['do']=="BEFORE")
	{
	$page__=$_GET['page__'];
	$page_=$page__-1;
	$P=$per_page*$page_+$TOP['rownum']-1;

	}
	else{	
	$page_=1;
	
	}
	$prev_page=$page_-1;
	$next_page=$page_+1;
	


	$page_start=($per_page*$page_)-$per_page+$TOP['rownum'];
	
	
	
	
if($num_rows<=$per_page)
	$num_pages=1;
else if(($num_rows%$per_page)==0)
	$num_pages=($num_rows/$per_page);
else
	$num_pages=($num_rows/$per_page)+1;
	$num_pages=(int)$num_pages;

if(($page_>$num_pages)||($page_<0))
	echo"จำนวนรายการ เท่ากับ 0 รายการ";
	
	
		
	
$sql_="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY ID_Maintenance) AS
rownum,ID_Maintenance,Serial_No,IMEI,Category,Description,Status
      ,Cost,Equipment,Date_receiver,UpdateDate,Createby FROM st_D_Maintenance where IMEI like '$id') AS Table1
WHERE rownum >= '$page_start' AND rownum <= '$P'  ";

$result_=sqlsrv_query($con,$sql_,$params,$options);


while ($re = sqlsrv_fetch_array($result_))
	
	/*while($re=sqlsrv_fetch_array($qrySearch))*/
	{{ $col="#FFFFCC";}
	
	$c="select Category_name from st_D_Maintenance_Category where Category_ID='$re[Category]' ";
	$c =sqlsrv_query($con,$c,$params,$options);
	$c=sqlsrv_fetch_array($c);
		
	$s="select  Status_NAME from st_D_Status where Status_ID='$re[Status]' ";
	$s =sqlsrv_query($con,$s,$params,$options);
	$s=sqlsrv_fetch_array($s);
	
	$uu="select  name from st_user where user_id='$re[Createby]' ";
	$uu =sqlsrv_query($con,$uu,$params,$options);
	$uu=sqlsrv_fetch_array($uu);
	
?>
	
	<tr bgcolor="<?=$col;?>" height="30">
	<td align="left"><font size="2">&nbsp;<?=$re['rownum']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['ID_Maintenance']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?if($re['Equipment']=='TL'){echo "Tablet";}else if($re['Equipment']=='MP'){echo "Moblie printer";}?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['IMEI']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Serial_No']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$c['Category_name']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Description']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$s['Status_NAME']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=number_format($re['Cost'],2); ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$uu['name']; ?></font></td>
	<td align="left"><font size="2"><?=date_format($re['Date_receiver'],'d/m/Y');?></font></td>
	<td align="left"><font size="2"><?=date_format($re['UpdateDate'],'d/m/Y');?></font></td>
	
	<td align="center">
		<a href="?page=edit_Maintenance_for_edit_tablet&id=<?=$re['ID_Maintenance'];?>"  >
		<img src=".././images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	<td align="center">
		<a href="?page=save_Maintenance_for_edit_tablet&do=del&id=<?=$re['ID_Maintenance'];?>&IMEI=<?=$re['IMEI']; ?>" onclick="return confirm('คุณต้องการลบรายการซ่อมบำรุงนี้ใช่หรือไม่?');" >
		<img src=".././images/del.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	


	
	<? 
	}	
	?>

		</table><tr><td>
จำนวนรายการทั้งหมด:<b><?echo $num_rows;?></b>&nbsp;&nbsp;หน้าทั้งหมด:<b><?echo $num_pages?></b>
<div id="container">
	<div class="pagination">
<?
if($prev_page)
	echo"<a class='page' href=\"$PHP_SELF?page=edit_Tablet&id=$id&do=BEFORE&page__=$page_\">กลับไป&nbsp;</a>";
	
for($i=1;$i<=$num_pages;$i++)
{
if($i!=$page_)
	echo"<a class='page' href=\"$PHP_SELF?page=edit_Tablet&id=$id&do=NOW&page__=$i\">$i</a>";
	
	else
	echo"<b class='page active'>$i</b>";
	}
if($page_!=$num_pages)

	echo"<a class='page' href=\"$PHP_SELF?page=edit_Tablet&id=$id&do=NEXT&page__=$page_\">&nbsp;หน้าต่อไป</a>";
?></div></div>

<?}?></tr></td>


</td>
</tr>
</table>


	</div>
	<div id="tabs-2">

		<? 
$sql1="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY st_device_log_login.CreateDate desc) AS
rownum,st_device_log_login.imei,sim_id,phone_sim,st_user.User_id,name,dc_groupid,st_device_log_login.CreateDate
FROM st_device_log_login 
left join st_user on st_user.talet_no_imei=st_device_log_login.imei
left join st_device_tablet_detail on st_user.talet_no_imei=st_device_tablet_detail.imei
where st_device_log_login.imei = '$id' )AS Table1  "; 
$result1=sqlsrv_query($con,$sql1,$params,$options);
$num_rows1=sqlsrv_num_rows($result1);
if($num_rows1==0){echo"<p align='center'><b>----------ไม่พบข้อมูล------------</b></p>";}else{	

/*for($H=1;$H<=$num_rows1;$H++){
echo "<p>&nbsp;</p>";
};*/
?>
<table cellpadding="0" cellspacing="0"  border="0" align="left" width="1050px">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0" BORDERCOLOR="#FF9933" border="1" align="left"  width="1050px">
	<tr bgcolor="#FFCC99">
	<td align="center"><font size="2">ลำดับ</font></td>
	<td align="center"><font size="2">IMEI</font></td>
	<td align="center"><font size="2">Serial Sim.</font></td>
	<td align="center"><font size="2">Sim No.</font></td>
	<td align="center"><font size="2">User</font></td>
	<td align="center"><font size="2">DC</font></td>
	<td align="center"><font size="2">วันที่และเวลา</font></td>
	</tr>
<?	
$TOP1="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY st_device_log_login.CreateDate desc) AS
rownum,st_device_log_login.imei,sim_id,phone_sim,st_device_log_login.User_id,name,dc_groupid,st_device_log_login.CreateDate
FROM st_device_log_login 
left join st_user on st_user.talet_no_imei=st_device_log_login.imei
left join st_device_tablet_detail on st_user.talet_no_imei=st_device_tablet_detail.imei
where st_device_log_login.imei = '$id')AS Table1 ";
		$TOP1=sqlsrv_query($con,$TOP1,$params,$options);
		$TOP1=sqlsrv_fetch_array($TOP1);

$per_page1 = 50;		
$P1=$per_page1+$TOP1['rownum']-1;
if(!$page_1)

	if($_GET['do1']=="NOW")
	{
	$page__1=$_GET['page__1'];
	$page_1=$page__1;
	$P1=$per_page1*$page_1;

	}else
	
	if($_GET['do1']=="NEXT")
	{
	$page__1=$_GET['page__1'];
	$page_1=$page__1+1;
	$P1=$per_page1*$page_1;

	}else
	
	if($_GET['do1']=="BEFORE")
	{
	$page__1=$_GET['page__1'];
	$page_1=$page__1-1;
	$P1=$per_page1*$page_1;

	}
	else{	
	$page_1=1;
	
	}
	$prev_page1=$page_1-1;
	$next_page1=$page_1+1;

	$page_start1=($per_page1*$page_1)-$per_page1+1;
	
if($num_rows1<=$per_page1)
	$num_pages1=1;
else if(($num_rows1%$per_page1)==0)
	$num_pages1=($num_rows1/$per_page1);
else
	$num_pages1=($num_rows1/$per_page1)+1;
	$num_pages1=(int)$num_pages1;

if(($page_1>$num_pages1)||($page_1<0))
	echo"จำนวนรายการ เท่ากับ 0 รายการ";
	
	
$sql_1="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY st_device_log_login.CreateDate desc) AS
rownum,st_device_log_login.imei,sim_id,phone_sim,st_device_log_login.User_id,name,dc_groupid,st_device_log_login.CreateDate
FROM st_device_log_login 
left join st_user on st_user.talet_no_imei=st_device_log_login.imei
left join st_device_tablet_detail on st_user.talet_no_imei=st_device_tablet_detail.imei
where st_device_log_login.imei = '$id')AS Table1    
where rownum >= $page_start1 AND rownum <= $P1 ";

$result_1=sqlsrv_query($con,$sql_1,$params,$options);


while ($re1 = sqlsrv_fetch_array($result_1))
	{{ $col="#FFFFCC";}

	$U="select * from st_user where User_id='$re1[User_id]'  ";
	$U= sqlsrv_query($con,$U,$params,$options);
	$U=sqlsrv_fetch_array($U);
	
	$DC="select dc_groupname from st_user_group_dc where dc_groupid='$U[dc_groupid]'  ";
	$DC= sqlsrv_query($con,$DC,$params,$options);
	$DC=sqlsrv_fetch_array($DC);
	
	$phone="select * from st_Device_PhoneSim where sim_id='$re1[sim_id]'  ";
	$phone= sqlsrv_query($con,$phone,$params,$options);
	$phone=sqlsrv_fetch_array($phone);
?>
	
	<tr bgcolor="<?=$col;?>" height="30">
	<td align="left"><font size="2">&nbsp;<?=$re1['rownum']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re1['imei']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re1['sim_id'];?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$phone['phone_no']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$U['name']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$DC['dc_groupname']; ?></font></td>
	
	
	<td align="left"><font size="2"><?=$re1['CreateDate'];?></font></td>
	


	
	<? 
	}	
	?>

		</table><tr><td>
จำนวนรายการทั้งหมด:<b><?echo $num_rows1;?></b>&nbsp;&nbsp;หน้าทั้งหมด:<b><?echo $num_pages1?></b>
<div id="container">
	<div class="pagination">
<?
if($prev_page1)
	echo"<a class='page' href=\"$PHP_SELF?page=edit_Tablet&do1=BEFORE&page__1=$page_1&id=$id#tabs-2\">กลับไป&nbsp;</a>";
	
for($i=1;$i<=$num_pages1;$i++)
{
if($i!=$page_1)
	echo"<a class='page' href=\"$PHP_SELF?page=edit_Tablet&do1=NOW&page__1=$i&id=$id#tabs-2\">$i</a>";
	
	else
	echo"<b class='page active'>$i</b>";
	}
if($page_1!=$num_pages1)

	echo"<a class='page' href=\"$PHP_SELF?page=edit_Tablet&do1=NEXT&page__1=$page_1&id=$id#tabs-2\">&nbsp;หน้าต่อไป</a>";
?></div></div>                           

<?}?></tr></td>


</td>
</tr>
</table>

	</div>
	<div id="tabs-3">
	<form method="post" id="frmSearch" name="frmSearch" >
	<table  align="center" border="0" width="1050px">
	<tr><td align="center">
	<?$GPS_last="SELECT top 1 *,cast(date_time as datetime) as date_time_ FROM st_gps_tracking 
				where imei = '$id'
				ORDER BY date_time desc ";
		$GPS_last=sqlsrv_query($con,$GPS_last,$params,$options);
		$GPS_L=sqlsrv_fetch_array($GPS_last);?>
	
	IMEI&nbsp;<input type="text" id="ID_GPS" name="ID_GPS" value="<?=$id;?>">&nbsp;&nbsp;
	วันที่&nbsp;<input type="text" id="day_gps" name="day_gps" <?/*=date_format($GPS_L['date_time_'],'Y-m-d');*/?>>
	&nbsp;&nbsp;เวลา&nbsp;<input type="text" id="time_gps" name="time_gps">

	
	&nbsp;&nbsp;<input type="button" value="ค้นหา" class="myButton_form" id="search_gps" name="search_gps">
	<br><br><div id="gps"></div>
	</td></tr>

	</table>
	</form>
	</div>
	
	
</div>


</div>
</div>
</body>
</html>