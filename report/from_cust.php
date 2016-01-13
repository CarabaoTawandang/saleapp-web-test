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
			
		$('#btn_add').button();
		$('#btn_scarch,#btn_excel').button();
		
		$('#btn_scarch').click(function(){
					/*alert('Test');*/
					 if(($('#txtDC').prop('value')=='') &&($('#txt_geo').prop('value')=='') &&($('#txt_pro').prop('value')=='')&&($('#txt_aum').prop('value')=='')&&($('#txt_dis').prop('value')=='')
						&&($('#txt_idCust').prop('value')=='')&&($('#txt_name').prop('value')=='')
					 )
					 {alert("โปรดใส่ข้อมูลที่จะค้นหา !");}
					else {
					$('#DIV_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/scarch_cust.php',
						type:'POST',
						data:$('#frmuser').serialize(),
						success:function(result){
							$('#DIV_search').html(result);
							}
							});
							
						}	
		});
		$('#btn_excel').click(function(){
				//alert("test");
					if(($('#txtDC').prop('value')=='') &&($('#txt_geo').prop('value')=='') &&($('#txt_pro').prop('value')=='')&&($('#txt_aum').prop('value')=='')&&($('#txt_dis').prop('value')=='')
						&&($('#txt_idCust').prop('value')=='')&&($('#txt_name').prop('value')=='')
					 )
					 {alert("โปรดใส่ข้อมูลที่จะค้นหา !");}
					else {
					$('#frmuser').submit();
					}
		});
		
		
		$('#txtDC').change(function(){
				$.ajax({
					url:'report/provinceDC.php',
					type:'POST',
					data:'value='+$('#txtDC').prop('value'),
					//alert("phung");
					//data:{name:'1'}
					success:function(result){
						$('#txt_pro').html(result);
					}
				});
		});	
		$('#txt_geo').change(function(){
				$.ajax({
					url:'report/province.php',
					type:'POST',
					data:'value='+$('#txt_geo').prop('value'),
					//alert("phung");
					//data:{name:'1'}
					success:function(result){
						$('#txt_pro').html(result);
					}
				});
		});	
		$('#txt_pro').change(function(){
				
				$.ajax({
					url:'report/aumphur.php',
					type:'POST',
					data:'value='+$('#txt_pro').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_aum').html(result);
					}
				});
		});	
		$('#txt_aum').change(function(){
				
				$.ajax({
					url:'report/district.php',
					type:'POST',
					data:'value='+$('#txt_aum').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_dis').html(result);
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
        
        <h3>ค้นหาร้านค้า</h3>
            
          <p>รายชื่อร้านค้า
		  <input type="button" value="เพิ่มร้านค้า" id="btn_add" onclick="window.location='?page=add_cust';"  class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form id="frmuser" name="frmuser"  method="post" action="report/ExcelReportCust.php" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">

<tr><td colspan="2" align="center">
	
	
	รหัสร้าน : <input type="text" id="txt_idCust" name="txt_idCust" style="width:200px;"/>
	<B style="color:black;text-align:center;">ชื่อร้าน : </B><input type="text" id="txt_name" name="txt_name" style="width:200px;" >
	ภาค :
	<select id="txt_geo" name="txt_geo"  style="width:150px;">
		<option value=""> - Selete -</option>
	<?	  $sql="select GEO_CODE,GEO_NAME
			from dc_geography ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j++){

		$detail=sqlsrv_fetch_array($qry);
			?>
			<option value="<?print $detail['GEO_CODE']?>" ><?print $detail['GEO_NAME']?></option>
		
			<?
			}

		
	
	?>
	</select>
	<B>DC</B>
			<select id="txtDC" name="txtDC"  style="width:200px;">
				<option value="">- Selete -</option>
				<?	$sql="SELECT  dc_groupid ,dc_groupname  FROM st_user_group_dc  order by  dc_groupid asc ";
					$qry=sqlsrv_query($con,$sql);
					while($detail=sqlsrv_fetch_array($qry)){
				?>
				<option value="<?print $detail['dc_groupid']?>" ><?print $detail['dc_groupname']?></option>
				<?}?>
			</select>
	
</td></tr><tr><td colspan="2">&nbsp;</td></tr><tr><td align="center">	
	
	
	<B style="color:black;text-align:center;">จังหวัด  :</B>
	<select id="txt_pro" name="txt_pro"   style="width:150px;">
		<option value="" > - Selete -</option>
		<?	$sql3="SELECT * FROM dc_Province  order by PROVINCE_NAME asc  ";
			$qry3=sqlsrv_query($con,$sql3);
			while($detail3=sqlsrv_fetch_array($qry3))
				{
				echo '<option value="'.$detail3['PROVINCE_CODE'].'">'.$detail3['PROVINCE_NAME'].'</option>';
				}
		?>
	</select>
	<B style="color:black;text-align:center;">อำเภอ / แขวง  :</B>
	<select id="txt_aum" name="txt_aum"   style="width:150px;">
		<option value="" > - Selete -</option>
	</select>
	<B style="color:black;text-align:center;">ตำบล / แขวง  :</B>
	<select id="txt_dis" name="txt_dis"   style="width:150px;">
		<option value="" > - Selete -</option>
	</select>
</td></tr><tr><td colspan="2">&nbsp;</td></tr><tr><td align="center">	
	<input type="button" value="ค้นหา" id="btn_scarch">
	<input type="button" value="ExportExcel" id="btn_excel">
	</td>
</tr>
</table>

</form>
	
</div>
</div>
<div id="DIV_search" align="center"></div>
</body>
</html>

