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
		$('#search').button();
		$('#search2').button();
		$('#SAVE').button();
		$('#search').click(function(){
					$('#selectDC').hide();
					$('#DivSearch').show();
					if($('#txtSearch').prop('value')=='')  {alert("โปรดใส่คำที่ต้องการค้นหา !");}
					else {
					$('#DivSearch').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/SearchDC.php',
						type:'POST',
						data:$('#frmuser').serialize(),
						success:function(result){
							$('#DivSearch').html(result);
							}
							});
							
						}	
		});
		$('#search2').click(function(){
					$('#DivSearchCust').show();
					if(($('#txt_geo').prop('value')=='')&& ($('#txt_pro').prop('value')=='') && ($('#txt_aum').prop('value')=='')
					 && ($('#txt_dis').prop('value')==''))
					{alert("โปรดใส่ภาค หรือ จังหวัด หรือ อำเภอ หรือ ตำบล ที่ต้องการค้นหา !");}
					else {
					$('#DivSearchCust').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/SearchCust.php',
						type:'POST',
						data:$('#frmuser').serialize(),
						success:function(result){
							$('#DivSearchCust').html(result);
							}
							});
							
						}	
		});
		$('#SAVE').click(function(){
					if(($('#txt_DC').prop('value')=='')&&($('#txtDC').prop('value')=='') ){alert("โปรดใส่ DC ที่ต้องการ !");}
					else if(($('#txt_CUST').prop('value')=='')){alert("โปรดใส่ ร้านค้า ที่ต้องการ !");}
					
					else {
					$('#DivSave').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/save_CustInDC.php',
						type:'POST',
						data:$('#frmuser').serialize(),
						success:function(result){
							$('#DivSave').html(result);
							}
							});
							
						}	
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
        
        <h3>เพิ่ม ร้านค้าเข้า DC</h3>
            
          <p>
		  <input type="button" value="ค้นหาDC" id="btn_add" onclick="window.location='?page=from_DC';" align="center" class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  >
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td align="left" width="100"  valign= "top" ><B>DC</B></td><td align="left" valign= "top">
	<div id="selectDC"  style="float:left;valign=middle">
	<select id="txtDC" name="txtDC"  style="width:300px;height:25px;">
		<option value=""> - เลือกDC -</option>
		<?	$sql="SELECT  dc_groupid ,dc_groupname  FROM st_user_group_dc  order by  dc_groupid asc ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);
		?>
		<option value="<?print $detail['dc_groupid']?>" ><?print $detail['dc_groupid']?>&nbsp;<?print $detail['dc_groupname']?></option>
		<?}?>
	</select>&nbsp; หรือ&nbsp;
	</div>
	<input type="text" id="txtSearch"name="txtSearch" placeholder=" ใส่รหัสหรือชื่อDCที่ต้องการค้นหา" size="30"/>&nbsp;
	<input type="button" id="search" name="search" value="ค้นหาDC" >
	<tr><td >&nbsp;</td><td  align="left" valign= "middle">
	<br><div id="DivSearch" style="display:none"><select id="txt_DC" name="txt_DC"   style="width:300px;background:#FFFFCC;"></select></div>
	
	</td></tr>
</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td align="left" width="100"  valign= "middle" ><B>ร้านค้า</B></td><td align="left" valign= "middle">
<select id="txt_geo" name="txt_geo"  style="width:150px;">
		<option value=""> - เลือกภาค -</option>
	<?	$sql="SELECT  GEO_CODE ,GEO_NAME  FROM dc_geography   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['GEO_CODE']?>" ><?print $detail['GEO_NAME']?></option>
		
			<?
			}

		
	
	?>
	</select>
<select id="txt_pro" name="txt_pro"   style="width:150px;">
		<option value="" > - เลือกจังหวัด -</option>
		</select>
<select id="txt_aum" name="txt_aum"   style="width:150px;">
		<option value="" > - เลือกอำเภอ -</option>
		</select>

<select id="txt_dis" name="txt_dis"   style="width:150px;">
		<option value="" > - เลือกตำบล -</option>
		</select>
<input type="button" id="search2" name="search2" value="ค้นหาร้านค้า" >
</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td >&nbsp;</td><td >
	<div id="DivSearchCust" style="display:none" >
		<select id="txt_CUST" name="txt_CUST"   style="width:300px;background:#FFFFCC;"></select>
	</div>
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td><B>บริษัท<B></td><td>
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
	</select>
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td >&nbsp;</td><td ><input type="button" id="SAVE" name="SAVE" value="SAVE" ></td></tr>
</table>
</form>
</div>
</div>
<div id="DivSave" ></div>
</body>
</html>