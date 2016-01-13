<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
$picking_no =$_GET['picking_no'];
$sql="select a.User_id,a.warehouse_locationNo,b.locationname
	from st_user a left join st_warehouse_location b
	on a.warehouse_locationNo=b.locationno
	where a.user_id='$USER_id'";

//echo $sql;



$qry1=sqlsrv_query($con,$sql);
$re1=sqlsrv_fetch_array($qry1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
		$('#btn,#btn_Search').button();
		$('#dateStart,#dateEnd').datepicker({ dateFormat:'dd-mm-yy'});
		$('#btn_Search').click(function(){
		if(($('#dateStart').prop('value')=='')&&($('#dateEnd').prop('value')=='')&&($('#txt_sale').prop('value')=='')
		&&($('#txt_detail').prop('value')==''))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_Search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_picking_head.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_Search').html(result);
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
	<div class="header"><h3>ข้อมูลจ่ายของเข้ารถ จากคลัง:<?=$re1['locationname'];?> </h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		  <input type="button" value="-จ่ายของเข้ารถ" id="btn" onclick="window.location='?page=add_picking_head';" class="inner_position_right" >
	</div><div class="sep"></div><br>
<form method="post" action="" id="frmSearch" name="frmSearch">
<table cellpadding="0" cellspacing="0"  border="0" align="center"  >
<tr><td colspan="2" align="center">
	<b>วันที่จ่ายของเข้ารถ</b><input type="text" id="dateStart" name="dateStart" value="">
	<b> ถึง </b><input type="text" id="dateEnd" name="dateEnd" value="">
	<b>จ่ายให้</b>
		<select  id="txt_sale" name="txt_sale" style="width:170px;" required/>
		<option value="">-เลือกพนักงานขาย-</option>
		<? $sqlOp="select st_user_lv_Detail.user_id_head
			,st_user_lv_Detail.user_id_detail
			,st_user.*
			from st_user_lv_Detail left join st_user
			on st_user_lv_Detail.user_id_detail = st_user.User_id
			where  st_user_lv_Detail.user_id_head ='$USER_id' 
			order by st_user.Salecode asc ";
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['user_id_detail']." '>";
			echo $deOp['Salecode']." ".$deOp['name']." ".$deOp['surname'];
			echo "</option>";
			}
		?>
		</select>
	<br><br>
	<b> หมายเหตุ </b><input type="text" id="txt_detail" name="txt_detail" value="" size="50">
	<br><br><input type="button" id="btn_Search" name="btn_Search" value="ค้นหา">
	
</td></tr>
</table>
</form>
</div><!--/-box-->
</div><!--/-container_box-->
<br>
<div align="center" id="txt_Search"></div>
</body>
</html>

