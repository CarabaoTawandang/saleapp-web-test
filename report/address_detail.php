<?
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>

<script type="text/javascript">
	$(function(){	
			
		$('#btSave').click(function(){
			//alert("phung");
			//checknull2();
			$('#frmuser').submit();
		});
		$('#txt_geo').change(function(){
				//alert("phung**");
				$.ajax({
					
					url:'login/province.php',
					type:'POST',
					data:'value='+$('#txt_geo').prop('value'),
					//alert("phung");
					//data:{name:'1'}
					success:function(result){
						$('#txt_pro2').html(result);
					}
				});
		});	
		$('#txt_pro2').change(function(){
				
				$.ajax({
					url:'login/aumphur2.php',
					type:'POST',
					data:'value='+$('#txt_pro2').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_aum2').html(result);
					}
				});
		});	
		$('#txt_aum2').change(function(){
				//$.getZipCode();
				$.ajax({
					url:'login/district2.php',
					type:'POST',
					data:'value='+$('#txt_aum2').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_dis2').html(result);
					}
				});
		});
		$('#txt_dis2').change(function(){
				//$.getZipCode();
				$.ajax({
					url:'login/zipcodes.php',
					type:'POST',
					data:'value='+$('#txt_dis2').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						//alert(result);
						$('#txt_zip2').prop('value',result);
					}
				});
		});
		$('#txt_name2').keypress(function(e){
				
				if(e.which==13 ){
					//alert("Enter");
					$('#txt_username2').focus();
					
				}
				
		});
		$('#txt_username2').keypress(function(e){
				
				if(e.which==13 ){
					//alert("Enter");
					$('#username2').focus();
					
				}
				
		});
		$('#username2').keypress(function(e){
				
				if(e.which==13 ){
					//alert("Enter");
					$('#password2').focus();
					
				}
				
		});
		$('#password2').keypress(function(e){
				
				if(e.which==13 ){
					//alert("Enter");
					$('#txt_status').focus();
					
				}
				
		});
	});
				
</script>
<form action="login/save_address.php" method="post" name="frmuser" id="frmuser" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box">
<tr><td colspan="2"  ><div class="h_head">ข้อมูลที่อยู่</div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
<td align="left"><B style="color:black;text-align:center;">ภาค :</B></td>
<td align="left"><select id="txt_geo" name="txt_geo"  style="width:150px;">
		<option> - Selete -</option>
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
<td align="left"><select id="txt_pro2" name="txt_pro2"   style="width:150px;">
		<option value="" > - Selete -</option>
		</select>
</td>
</tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr>
<td align="left"><B style="color:black;text-align:center;">อำเภอ / แขวง  :</B></td>
<td align="left"><select id="txt_aum2" name="txt_aum2"   style="width:150px;">
		<option value=""> - Selete -</option>
		</select>
		<B style="color:black;text-align:center;">หรือ :</B>
		<input id="txt_aum3" name="txt_aum3" type="text"   size="20"  value=""/></td>
</tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr>
<td align="left"><B style="color:black;text-align:center;">ตำบล / เขต :</B></td>
<td align="left">
		<select id="txt_dis2" name="txt_dis2"   style="width:150px;">
		<option value=""> - Selete -</option>
		</select>
		<B style="color:black;text-align:center;">หรือ :</B>
		<input id="txt_dis3" name="txt_dis3" type="text"   size="20"  value=""/></td>
</tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr>
<td align="left" ><B style="color:black;text-align:center;">รหัสไปรณีย์  :</B></td>

<td align=""><input id="txt_zip2" name="txt_zip2" type="text"   value=""  /></td>

</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>	
<td colspan="2" align="center" >
	<input type="hidden" id="hd_cmd"  name="hd_cmd" />
				
					<input type='button' value='save' id='btSave'>
				<input id="btn_reset" name="btn_reset" type="reset" value="Reset" />			
</tr>	
</table>
</form>