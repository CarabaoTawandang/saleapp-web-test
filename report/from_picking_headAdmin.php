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
		$('#txt_location').change(function(){
				$.ajax({
					url:'report/saleByLoc.php',
					type:'POST',
					data:'value='+$('#txt_location').prop('value'),
					//alert("phung");
					//data:{name:'1'}
					success:function(result){
						$('#txt_sale').html(result);
					}
				});
		});	
		
		$('#btn,#btn_Search').button();
		$('#dateStart,#dateEnd').datepicker({ dateFormat:'dd-mm-yy'});
		$('#btn_Search').click(function(){
		if($('#txt_location').prop('value')==''){alert("โปรดเลือกคลังที่ต้องการดูข้อมูล !");}
		else if(($('#dateStart').prop('value')=='')&&($('#dateEnd').prop('value')=='')&&($('#txt_sale').prop('value')==''))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_Search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_picking_headAdmin.php',
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
		  <!----<input type="button" value="-จ่ายของเข้ารถ" id="btn" onclick="window.location='?page=add_picking_head';" class="inner_position_right" >
			---->
	</div><div class="sep"></div><br>
<form method="post" action="" id="frmSearch" name="frmSearch">
<table cellpadding="0" cellspacing="0"  border="0" align="center"  >
<tr><td colspan="2" align="center">
	<b>คลัง : </b>
	<select id="txt_location" name="txt_location"  style="width:170px;" required/>
	<option value="" > - เลือกคลังสินค้า - </option>
	<?	$sqlLoc="select * from st_warehouse_location ";
			$qryLoc=sqlsrv_query($con,$sqlLoc);
			$row=sqlsrv_num_rows($qryLoc);
			while($detail=sqlsrv_fetch_array($qryLoc))
			{
			?>
			<option value="<?print $detail['locationno']?>" ><?print $detail['locationname']?></option>
		
			<?
			}
		?>
	</select>
	<b>จ่ายให้</b>
		<select  id="txt_sale" name="txt_sale" style="width:170px;" required/>
		<option value="">-All-</option>
		
		</select>
	<b>วันที่จ่ายของเข้ารถ</b><input type="text" id="dateStart" name="dateStart" value="<? echo date('d-m-Y');?>">
	<b> ถึง </b><input type="text" id="dateEnd" name="dateEnd" value="<? echo date('d-m-Y');?>">
	
	<br><br>
	<input type="button" id="btn_Search" name="btn_Search" value="ค้นหา">
	
</td></tr>
</table>
</form>
</div><!--/-box-->
</div><!--/-container_box-->
<br>
<div align="center" id="txt_Search"></div>
</body>
</html>

