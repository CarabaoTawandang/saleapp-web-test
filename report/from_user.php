<?
session_start();
set_time_limit(0);
include("../includes/config.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
		
		$('#btn_add,#btn_Search').button();
		
		//$('#dateStart,#dateEnd').datepicker({ dateFormat:'dd-mm-yy'});
		$('#txtType').change(function(){
				
				$.ajax({
					url:'report/Role2.php',
					type:'POST',
					data:'value='+$('#txtType').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txtType2').html(result);
					}
				});
		});
		$('#btn_Search').click(function(){
					$('#txt_Search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_user.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_Search').html(result);
							}
							});
							
							
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
<style type="text/css">
#mouseOver {
        display: inline;
        position: relative;
    }
    
    #mouseOver #img2 {
        position: absolute;
        left:250px;
        transform: translate(-100%);
        bottom: 0em;
        opacity: 0;
        pointer-events: none;
        transition-duration: 800ms; 
		top: 50px;
    }
    
    #mouseOver:hover #img2 {
        opacity: 1;
        transition-duration: 400ms;
    }
</style> 

</head>
<body>
<div class="container_box">
             
  <div id="box">

    <div class="header"><h3>ข้อมูล User</h3>
        <p>พนักงาน SaleApp
		  <input type="button" value="สมัคร User" id="btn_add" onclick="window.location='?page=add_user';" align="center" class="inner_position_right">
		</p>       
    </div>
        
    <div class="sep"></div><br>
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table cellpadding="0" cellspacing="0"  border="0" align="center"  >
	<tr><td colspan="2" align="center">
	<B>คลัง</B>
			<select id="txt_warehouse_location" name="txt_warehouse_location"  style="width:200px;">
			<option value="" > - ALL- </option>
			<?	$sql="SELECT * FROM st_warehouse_location   ";
					$qry=sqlsrv_query($con,$sql);
					while($detail=sqlsrv_fetch_array($qry)){

				
					?>
					<option value="<?print $detail['locationno']?>" ><?print $detail['locationname']?></option>
				
					<?
					}

				
			
			?>
			</select>
			<B>DC</B>
			<select id="txtDC" name="txtDC"  style="width:200px;">
				<option value="">-ALL-</option>
				<?	$sql="SELECT  dc_groupid ,dc_groupname  FROM st_user_group_dc  order by  dc_groupid asc ";
					$qry=sqlsrv_query($con,$sql);
					while($detail=sqlsrv_fetch_array($qry)){
				?>
				<option value="<?print $detail['dc_groupid']?>" ><?print $detail['dc_groupname']?></option>
				<?}?>
			</select>
			<B>ประเภทขาย</B>
			<select id="txt_saletype" name="txt_saletype"  style="width:170px;">
			<option value="" > - ALL- </option>
			<?	$sql="SELECT SaleType,SaleTypeName FROM st_saletype   ";
					$qry=sqlsrv_query($con,$sql);
					while($detail=sqlsrv_fetch_array($qry)){

				
					?>
					<option value="<?print $detail['SaleType']?>" ><?print $detail['SaleTypeName']?></option>
				
					<?
					}

				
			
			?>
			</select>
			
			<br><br>
		<b>ชื่อ</b><input type="text" id="txt_name" name="txt_name" value="">
		<b> นามสกุล </b><input type="text" id="txt_surname" name="txt_surname" value="">
		<br><br><b> Username </b><input type="text" id="txt_username" name="txt_username" value="">
		<b> UserId </b><input type="text" id="txt_userId" name="txt_userId" value="">
			<br><br>
			<b> ประเภทตำแหน่ง: </b>
				<select id="txtType" name="txtType"  style="width:170px;">
				<option value="">-ALL-</option>
				<?	$sql="SELECT  RoleID ,RoleName  FROM st_user_rolemaster_head   ";
					$qry=sqlsrv_query($con,$sql);
					while($detail=sqlsrv_fetch_array($qry)){
				?>
				<option value="<?print $detail['RoleID']?>" ><?print $detail['RoleName']?></option>
				<?}?>
			</select> 
			<b> ตำแหน่ง:</b>
			<select id="txtType2" name="txtType2"  style="width:190px;">
				<option value="">-ALL-</option>
			</select>
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
<?
if($_GET['do']=="del")
{
	$id=$_GET['id'];
	$img='./imagesUser/'.$id.'.jpg';
	unlink($img);
	$del="delete from st_user where User_id='$id'";
	$qrydel=sqlsrv_query($con,$del);//tb user
	
	$del2="delete from st_user_lv_Detail where user_id_head='$id'";
	$qrydel2=sqlsrv_query($con,$del2); //tb user ที่อยู่ภายใต้
		
		$del4="delete from st_user_lv_Detail where user_id_detail='$id'";
		$qrydel4=sqlsrv_query($con,$del4); //tb user ที่อยู่ภายใต้
		
	$del3="delete from st_warehouse_sale_stock where User_id='$id'";
	$qrydel3=sqlsrv_query($con,$del3); //tb stock ท้ายรถ
	
	
	  
	  $opent1="select picking_no from st_warehouse_stock_picking_head where picking_user_id='$id'";//เปิดใบรับของเข้าท้ายรถ หลัก
	  $opent1=sqlsrv_query($con,$opent1);
	  while($op1=sqlsrv_fetch_array($opent1))
	  {	//echo "<br>";
		$sqlDel3="delete st_warehouse_stock_picking_detail where picking_no='$op1[picking_no]'";//ลบใบรับของเข้าท้ายรถ detail
		$qryDel3=sqlsrv_query($con,$sqlDel3);
		  
	  }
	  
	  $sqlDel4="delete st_warehouse_stock_picking_head where picking_user_id='$id'";//เปิดใบรับของเข้าท้ายรถ หลัก
	$qryDel4=sqlsrv_query($con,$sqlDel4);
	
	
	if($qrydel)
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบ User เรียบร้อยแล้ว ");';
			echo "window.location='?page=from_user';";
			echo '</script>';
	}
	else
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบ User ไม่สำเร็จ ");';
			echo '</script>';
	}
	
	
}
if($_GET['do']=="canceled")
{	$id=$_GET['id'];
	
	$canc="update  st_user  set status='N'  where User_id='$id'";
	$canc=sqlsrv_query($con,$canc);//tb user
	
	$del4="delete from st_user_lv_Detail where user_id_detail='$id'";
		$qrydel4=sqlsrv_query($con,$del4); //tb user ที่อยู่ภายใต้
	if($canc)
	{
			echo'<script type="text/javascript">';
			echo'alert("ยกเลิก User เรียบร้อยแล้ว ");';
			echo "window.location='?page=from_user';";
			echo '</script>';
	}
	else
	{
			echo'<script type="text/javascript">';
			echo'alert("ยกเลิก User ไม่สำเร็จ ");';
			echo '</script>';
	}
}
?>