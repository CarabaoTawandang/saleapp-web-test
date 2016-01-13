<?//------------------------------------------------------แก้ไข โดย PONG 17/09/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

?>
<script type="text/javascript">
$(function(){	

	$('#date_from').datepicker({
					dateFormat:'yy-mm-dd'
				});
				
	$('#date_to').datepicker({
					dateFormat:'yy-mm-dd'
				});
	$("#tabs").tabs(); 

	$.fn.clearForm = function() {
  return this.each(function() {
    var type = this.type, tag = this.tagName.toLowerCase();
    if (tag == 'form')
      return $(':input',this).clearForm();
    if (type == 'text' || type == 'password' || tag == 'textarea')
      this.value = '';
    else if (type == 'checkbox' || type == 'radio')
      this.checked = false;
    else if (tag == 'select')
      this.selectedIndex = -1;
  });
};
	
	$('#txt_all').change(function(){
    if (this.checked) {

		$('#txt_id').attr("disabled", true); 
		$('#txt_id').clearForm();
				
		} else {

	  $('#txt_id').removeAttr("disabled");
	  }
	  });

	
	$('#search').click(function(){
					if(($('#txt_id').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการค้นหา !");}
					else {
					if($('#do').val()=='NOW')
							{
								$('#page__').val('1');

							}
	
					if($('#do').val()=='NEXT')
							{
								$('#page__').val('0');

							}
	
					if($('#do').val()=='BEFORE')
							{
								$('#page__').val('2');		

							}

					$('#txt_search').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_Tablet.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
			}			
		});

	if($('#page__').val()!=''){
	$('#search').ready(function(){
				
					$('#txt_search').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_Tablet.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
					
		});}
		
		
	$('#txt_all1').change(function(){
    if (this.checked) {

		$('#txt_id1').attr("disabled", true); 
		$('#txt_id1').clearForm();
				
		} else {

	  $('#txt_id1').removeAttr("disabled");
	  }
	  });
	
		
		$('#search1').click(function(){
					if(($('#txt_id1').prop('value')=='')&&(document.getElementById("txt_all1").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการค้นหา !");}
					else {
					if($('#do1').val()=='NOW')
							{
								$('#page__1').val('1');

							}
	
					if($('#do1').val()=='NEXT')
							{
								$('#page__1').val('0');

							}
	
					if($('#do1').val()=='BEFORE')
							{
								$('#page__1').val('2');		

							}

					$('#txt_search1').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_Mobile_Printer.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search1').html(result);
							}
							});
							
			}			
		});

	if($('#page__1').val()!=''){
	$('#search1').ready(function(){
				
					$('#txt_search1').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_Mobile_Printer.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search1').html(result);
							}
							});
							
					
		});}
		
	$('#txt_all2').change(function(){
    if (this.checked) {

		$('#txt_id2').attr("disabled", true); 
		$('#txt_id2').clearForm();
		$('#txt_imei').attr("disabled", true); 
		$('#txt_imei').clearForm();		
		} else {

	  $('#txt_id2').removeAttr("disabled");
	  $('#txt_imei').removeAttr("disabled");
	  }
	  });
	$('#search2').click(function(){
					if(($('#txt_id2').prop('value')=='')&&($('#txt_imei').prop('value')=='')&&(document.getElementById("txt_all2").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการค้นหา !");}
					else {
					if($('#do2').val()=='NOW')
							{
								$('#page__2').val('1');

							}
	
					if($('#do2').val()=='NEXT')
							{
								$('#page__2').val('0');

							}
	
					if($('#do2').val()=='BEFORE')
							{
								$('#page__2').val('2');		

							}

					$('#txt_search2').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_Maintenance_tab_from.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search2').html(result);
							}
							});
							
			}			
		});

	if($('#page__2').val()!=''){
	$('#search2').ready(function(){
				
					$('#txt_search2').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_Maintenance_tab_from.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search2').html(result);
							}
							});
							
					
		});}
		
		$('#search3').click(function(){
					if(($('#date_from').prop('value')=='')||($('#date_to').prop('value')==''))
					{alert("โปรดใส่วันที่ !");}
					else {
					if($('#do3').val()=='NOW')
							{
								$('#page__3').val('1');

							}
	
					if($('#do3').val()=='NEXT')
							{
								$('#page__3').val('0');

							}
	
					if($('#do3').val()=='BEFORE')
							{
								$('#page__3').val('2');		

							}

					$('#txt_search3').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_log_user.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search3').html(result);
							}
							});
							
			}			
		});

	if($('#page__3').val()!=''){
	$('#search3').ready(function(){
				
					$('#txt_search3').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_log_user.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search3').html(result);
							}
							});
							
					
		});}
		
		$('#search4').click(function(){
					if(($('#Tel').prop('value')=='')&&($('#sim').prop('value')=='')&&(document.getElementById("text_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการค้นหา !");}
					else {
					if($('#do4').val()=='NOW')
							{
								$('#page__4').val('1');

							}
	
					if($('#do4').val()=='NEXT')
							{
								$('#page__4').val('0');

							}
	
					if($('#do4').val()=='BEFORE')
							{
								$('#page__4').val('2');		

							}

					$('#txt_search4').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_Tel.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search4').html(result);
							}
							});
				}			
			});
			
			if($('#page__4').val()!=''){
	$('#search4').ready(function(){
				
					$('#txt_search4').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_Tel.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search4').html(result);
							}
							});
							
					
		});}
		
		$('#text_all').change(function(){
    if (this.checked) {

		$('#Tel').attr("disabled", true); 
		$('#Tel').clearForm();
		$('#sim').attr("disabled", true); 
		$('#sim').clearForm();
				
		} else {

	  $('#Tel').removeAttr("disabled");
	  $('#sim').removeAttr("disabled");
	  }
	  });
	  

	  
	  $('#btn_report').button();
		
		});//function	
</script>

<style type="text/css">  
 
.ui-tabs{  
    font-family:tahoma;  
    font-size:13px; 
	height:auto;  
	
} 
</style> 
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>ทรัพย์สิน</h3>
            
          <p>รายชื่อทรัพย์สินและรายการซ่อมบำรุง </p>  
   <h5><input type="button" value="รายงานทรัพย์สิน" id="btn_report" onclick="window.location='?page=from_report_asset';" class="inner_position_right"></h5>
	<div class="sep"></div><br>
        
        

             

 

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Tablet</a></li>
		<li><a href="#tabs-2">Mobile Printer</a></li>
		<li><a href="#tabs-3">Maintenance</a></li>
		<li><a href="#tabs-4">Log User</a></li>
		<li><a href="#tabs-5">Serial Sim.</a></li>
	
	</ul>
	<div id="tabs-1">
	<?
$A=$_GET['A'];
$S=$_GET['S'];
$C=$_GET['C'];
$page__=$_GET['page__'];
$do=$_GET['do'];
	?>
	<form method="post" id="frmSearch" name="frmSearch" >
	<table  align="center" border="0" width="1050px">
	<tr><td align="right"><input type="button" value="เพิ่ม Tablet" id="btn_add" class="myButton_form" onclick="window.location='?page=add_Tablet';"></td></tr>
	<tr><td align="center">
	
	<input type="hidden" id="id" name="id" ><!--...-->
	
	<input value="<?=$page__;?>" type="hidden" id="page__" name="page__" >
	<input value="<?=$do;?>" type="hidden" id="do" name="do" >
	IMEI&nbsp;<input type="text" value="<?=$S;?>" id="txt_id" name="txt_id" <?if($A=='all'){echo "disabled";}?>>&nbsp;&nbsp;
	
	
	จำนวนรายการ&nbsp;<select id="count" name="count"  style="width:75px;" >
	<?if ($C=$_GET['C']){?>
	<option value="<?=$C;?>"><?=$C;?></option><?}?>
	<?if (!$C=$_GET['C']){?>
	<option value="50">50</option>
	<option value="100">100</option>
	<option value="150">150</option>
	<option value="200">200</option>
	<option value="250">250</option>
	<option value="300">300</option>
	<?}?>

	</select>
	
	&nbsp;&nbsp;<input type="checkbox" value="all" id="txt_all" name="txt_all" <?if($A=='all'){echo "checked";}?>>ดูทั้งหมด
	&nbsp;&nbsp;<input type="button" value="ค้นหา" class="myButton_form" id="search" name="search">
	<br><br><div id="txt_search"></div>
	</td></tr>
	</table>
	</form>


	</div>
	<div id="tabs-2">
		<?
$A1=$_GET['A1'];
$S1=$_GET['S1'];
$C1=$_GET['C1'];
$page__1=$_GET['page__1'];
$do1=$_GET['do1'];
	?>
		<form method="post" id="frmSearch" name="frmSearch" >
	<table  align="center" border="0" width="1050px">
	<tr><td align="right"><input type="button" value="เพิ่ม Mobile Printer" id="btn_add1" class="myButton_form" onclick="window.location='?page=add_Mobile_Printer';"></td></tr>
	<tr><td align="center">
	
	<input value="<?=$page__1;?>" type="hidden" id="page__1" name="page__1" >
	<input value="<?=$do1;?>" type="hidden" id="do1" name="do1" >
	Mac&nbsp;<input type="text" value="<?=$S1;?>" id="txt_id1" name="txt_id1" <?if($A1=='all'){echo "disabled";}?>>&nbsp;&nbsp;
	
	
	จำนวนรายการ&nbsp;<select id="count1" name="count1"  style="width:75px;" >
	<?if ($C1=$_GET['C1']){?>
	<option value="<?=$C1;?>"><?=$C1;?></option><?}?>
	<?if (!$C1=$_GET['C1']){?>
	<option value="50">50</option>
	<option value="100">100</option>
	<option value="150">150</option>
	<option value="200">200</option>
	<option value="250">250</option>
	<option value="300">300</option><?}?>
	
	</select>
	
	&nbsp;&nbsp;<input type="checkbox" value="all" id="txt_all1" name="txt_all1" <?if($A1=='all'){echo "checked";}?>>ดูทั้งหมด
	&nbsp;&nbsp;<input type="button" value="ค้นหา" class="myButton_form" id="search1" name="search1">
	
	<br><br><div id="txt_search1"></div>
	</td></tr>
	</table>
	</form>
	</div>
	<div id="tabs-3">
	<?
$A2=$_GET['A2'];
$txt_imei=$_GET['txt_imei'];
$S2=$_GET['S2'];
$E2=$_GET['E2'];
$C2=$_GET['C2'];
$page__2=$_GET['page__2'];
$do2=$_GET['do2'];
	?>
	<form method="post" id="frmSearch" name="frmSearch" >
	<table  align="center" border="0" width="1050px">
	<tr><td align="right"><input type="button" value="เพิ่มรายการซ่อมบำรุง" id="btn_add2" class="myButton_form" onclick="window.location='?page=add_Maintenance';"></td></tr>
	<tr><td align="center"><br>

	<input value="<?=$page__2;?>" type="hidden" id="page__2" name="page__2" >
	<input value="<?=$do2;?>" type="hidden" id="do2" name="do2" >
	IMEI&nbsp;<input type="text" value="<?=$txt_imei;?>" id="txt_imei" name="txt_imei" <?if($A2=='all'){echo "disabled";}?>>&nbsp;&nbsp;
	Mac&nbsp;<input type="text" value="<?=$S2;?>" id="txt_id2" name="txt_id2" <?if($A2=='all'){echo "disabled";}?>>&nbsp;&nbsp;
	อุปกรณ์&nbsp;<select id="Equipment" name="Equipment"  style="width:150px;" >
	<?if ($E=$_GET['E']){?>
	<option value="<?=$E;?>"><?if($E="TL"){echo "Tablet";}else{echo "Mobile Printer";}?></option><?}?>
	<?if (!$E=$_GET['E']){?>
	<option value="">--เลือก--</option><?}?>
	<option value="TL">Tablet</option>
	<option value="MP">Mobile Printer</option>
	</select>
	
	จำนวนรายการ&nbsp;<select id="count2" name="count2"  style="width:75px;" >
	<?if ($C2=$_GET['C2']){?>
	<option value="<?=$C2;?>"><?=$C2;?></option><?}?>
	<?if (!$C2=$_GET['C2']){?>
	<option value="50">50</option>
	<option value="100">100</option>
	<option value="150">150</option>
	<option value="200">200</option>
	<option value="250">250</option>
	<option value="300">300</option><?}?>
	
	</select>
	
	&nbsp;&nbsp;<input type="checkbox" value="all" id="txt_all2" name="txt_all2" <?if($A2=='all'){echo "checked";}?>>ดูทั้งหมด
	&nbsp;&nbsp;<input type="button" value="ค้นหา" class="myButton_form" id="search2" name="search2">
	
	<br><br><div id="txt_search2"></div>
	</td></tr>
	</table>
	</form>


	</div>
	<div id="tabs-4">
	<?
$txt_imei3=$_GET['txt_imei3'];
$date_from=$_GET['date_from'];
$date_to=$_GET['date_to'];
$C3=$_GET['C3'];
$page__3=$_GET['page__3'];
$do3=$_GET['do3'];
$User=$_GET['User'];
	?>
	<form method="post" id="frmSearch" name="frmSearch" >
	<table  align="center" border="0" width="1050px">
	
	<tr><td align="center">

	วันที่ <input type="text" id="date_from" name="date_from" value="<?=$date_from?>">
	ถึง <input type="text" id="date_to" name="date_to" value="<?=$date_to?>">
	
	<input value="<?=$page__3;?>" type="hidden" id="page__3" name="page__3" >
	<input value="<?=$do3;?>" type="hidden" id="do3" name="do3" >
	
	

	
	จำนวนรายการ&nbsp;<select id="count3" name="count3"  style="width:75px;" >
	<?if ($C3=$_GET['C3']){?>
	<option value="<?=$C3;?>"><?=$C3;?></option><?}?>
	<?if (!$C3=$_GET['C3']){?>
	<option value="50">50</option>
	<option value="100">100</option>
	<option value="150">150</option>
	<option value="200">200</option>
	<option value="250">250</option>
	<option value="300">300</option><?}?>
	
	</select>
	
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="ค้นหา" class="myButton_form" id="search3" name="search3">
	</td></tr>
	<tr><td align="center">
	IMEI&nbsp;<input type="text" value="<?=$txt_imei3;?>" id="txt_imei3" name="txt_imei3" >&nbsp;&nbsp;
	User&nbsp;<select  style="width:150px;" id="User" name="User">
			<?
			$UU="select * from st_user where User_id='$User' ";
			$UU	=sqlsrv_query($con,$UU,$params,$options);
			$UU=sqlsrv_fetch_array($UU);
			if ($User=$_GET['User']){?>
	<option value="<?=$User;?>"><?=$UU['User_id']." ".$UU['name'];?></option><?}?>
	<?if (!$User=$_GET['User']){?>
	
			
			<option value="">-USER-</option><?}?>
			<?
			$sql2="select * from st_user order by User_id asc ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry2	 = @sqlsrv_query($con,$sql2,$params,$options);
			while($re2=sqlsrv_fetch_array($qry2))
				{
			?>
				<option value="<?=$re2['User_id'];?>"><?=$re2['User_id']." ".$re2['name'];?></option>
			<? } ?>
			</select>
	<br><br><div id="txt_search3"></div>
	</tr></td>
	</table>
	</form>


	</div>
	
	<div id="tabs-5">
<?
$T=$_GET['T'];
$T_all=$_GET['T_all'];
$SS=$_GET['SS'];
$page__4=$_GET['page__4'];
$do4=$_GET['do4'];
$N=$_GET['N'];
?>
	<form method="post" id="frmSearch" name="frmSearch" >
	<table  align="center" border="0" width="1050px">
	<tr><td align="right"><input type="button" value="เพิ่มหมายเลขโทรศัพท์" id="_tel" class="myButton_form" onclick="window.location='?page=add_Tel';"></td></tr>
	<tr><td align="center">
	
	<input value="<?=$page__4;?>" type="hidden" id="page__4" name="page__4" >
	<input value="<?=$do4;?>" type="hidden" id="do4" name="do4" >

	
	Serial Sim.&nbsp;<input type="text" id="sim" name="sim" value="<?=$SS;?>" <?if($T_all=='all'){echo "disabled";}?>>
	&nbsp;&nbsp;Sim No.&nbsp;<input type="text" id="Tel" name="Tel" value="<?=$T;?>" <?if($T_all=='all'){echo "disabled";}?>>
	จำนวนรายการ&nbsp;<select id="number" name="number"  style="width:75px;" >
	<?if ($N=$_GET['N']){?>
	<option value="<?=$N;?>"><?=$N;?></option><?}?>
	<?if (!$N=$_GET['N']){?>
	<option value="50">50</option>
	<option value="100">100</option>
	<option value="150">150</option>
	<option value="200">200</option>
	<option value="250">250</option>
	<option value="300">300</option><?}?>
	
	</select>
	
	&nbsp;&nbsp;<input type="checkbox" value="all" id="text_all" name="text_all" <?if($T_all=='all'){echo "checked";}?>>ดูทั้งหมด
	&nbsp;&nbsp;<input type="button" value="ค้นหา" class="myButton_form" id="search4" name="search4">
	<br><br><div id="txt_search4"></div>
	</td></tr>

	</table>
	</form>
</div>



</div>
