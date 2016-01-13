<?
//------------------------------------------------------แก้ไข โดย DREAM  30/6/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>

<script type="text/javascript">
	$(function(){	
			
		$('#btSave,#btn_reset').button();
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
					url:'report/aumphur.php',
					type:'POST',
					data:'value='+$('#txt_aum').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_dis').html(result);
					}
				});
		});	
		$('#btSave').click(function(){
					if($('#txt_geo').prop('value')=='')  {alert("โปรดใส่ภาค !");}
					else if($('#txt_pro').prop('value')=='')  {alert("โปรดใส่จังหวัด  !");}
					else if($('#txt_aum').prop('value')=='')  {alert("โปรดใส่อำเภอ  !"); }
					else if($('#txt_dis').prop('value')=='')  {alert("โปรดใส่ตำบล  !"); }
					else if($('#txt_zip').prop('value')=='')  {alert("โปรดใส่รหัสไปรษณีย์  !"); }
					else {
					$('#txt_check').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/save_district.php',
						type:'POST',
						data:$('#frmuser').serialize(),
						success:function(result){
							$('#txt_check').html(result);
							}
							});
							
						}	
		});
		
	});
				
</script>
<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
	});//function	
</script>

<style type="text/css">  
.inner_position_right{  
    
    top:0px; /* css กำหนดชิดด้านบน  */  
    left:70%; /* css กำหนดชิดขวา  */  
    z-index:999;  
} 
</style>

<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>เพิ่มตำบล</h3>
            
          <p>รายชื่อตำบล
		  <input type="button" value="ค้นหาตำบล" id="btn_add" onclick="window.location='?page=from_district';" align="center" class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" >
<table >

<tr>
<td align="left" width="120px"><B style="color:black;text-align:center;">ภาค :</B></td>
<td align="left"><select id="txt_geo" name="txt_geo"  style="width:150px;">
		<option> - Select -</option>
	<?	$sql="SELECT  GEO_ID ,GEO_NAME  FROM dc_geography   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['GEO_ID']?>" ><?print $detail['GEO_NAME']?></option>
		
			<?
			}

		
	
	?>
	</select>
</td>
</tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr>
<td align="left"><B style="color:black;text-align:center;">จังหวัด  :</B></td>
<td align="left">
	<select id="txt_pro" name="txt_pro"   style="width:150px;">
		<option value="" > - Select -</option>
		</select>
</td>
</tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr>
<td align="left"><B style="color:black;text-align:center;">อำเภอ / เขต  :</B></td>
<td align="left">
<select id="txt_aum" name="txt_aum"   style="width:150px;">
		<option value="" > - Select -</option>
		</select>
</td>
</tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr>
<td align="left"><B style="color:black;text-align:center;">ตำบล / แขวง  :</B></td>
<td align="left">
<input type="text" id="txt_dis" name="txt_dis"   style="width:150px;">
</td>
</tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr>
<td align="left"><B style="color:black;text-align:center;">รหัสไปรษณีย์  :</B></td>
<td align="left">
<input type="text" id="txt_zip" name="txt_zip"   style="width:150px;">
</td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>	
<td colspan="2" align="left" >
	<input type="hidden" id="hd_cmd"  name="hd_cmd" />
				
				<input type="button" id="btSave" name="btSave" value="save">
				<input type="reset" id="btn_reset" name="btn_reset" value="Reset" />			
</tr>	
</table>
<div id="txt_check"></div>	
</form>