<?//------------------------------------------------------แก้ไข โดย PONG 03/12/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../../includes/config.php");

?>
<script type="text/javascript">
$(function(){	

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

	  $('#search5').click(function(){
					if(($('#IMEI_data').prop('value')=='')&&($('#MAC_data').prop('value')=='')&&($('#User_data').prop('value')=='')
					&&(document.getElementById("all_").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการค้นหา !");}
					else {
					if($('#do5').val()=='NOW')
							{
								$('#page__5').val('1');

							}
	
					if($('#do5').val()=='NEXT')
							{
								$('#page__5').val('0');

							}
	
					if($('#do5').val()=='BEFORE')
							{
								$('#page__5').val('2');		

							}

					$('#txt_search5').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_report_device.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search5').html(result);
							}
							});
				}			
			});
	  
	 if($('#page__5').val()!=''){
	$('#search5').ready(function(){
				
					$('#txt_search5').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/data_report_device.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search5').html(result);
							}
							});
							
					
		});}
							
							
	$('#all_').change(function(){
    if (this.checked) {

		$('#IMEI_data').attr("disabled", true); 
		$('#IMEI_data').clearForm();
		$('#MAC_data').attr("disabled", true); 
		$('#MAC_data').clearForm();
		$('#User_data').attr("disabled", true); 
		$('#User_data').prop('selectedIndex', 0);		
		} else {

	  $('#IMEI_data').removeAttr("disabled");
	  $('#MAC_data').removeAttr("disabled");
	  $('#User_data').removeAttr("disabled");
	  }
	  });
	  $('#btn_back').button();
	  
	  $("#tabs").tabs(); 
	  
	  		});//function	
</script>
<style type="text/css">  
 
.ui-tabs{  
    font-family:tahoma;  
    font-size:13px; 
	height:auto; 
	background-color: #ffffff;
	border-style: none;;
} 
</style> 




<?
$IMEI_data=$_GET['IMEI_data'];
$MAC_data=$_GET['MAC_data'];
$all_d=$_GET['all_d'];
$page__5=$_GET['page__5'];
$do5=$_GET['do5'];
$number_d=$_GET['number_d'];
$User_data=$_GET['User_data'];
?>

        <div class="container_box">
             
  <div id="box">  
 <div class="header">  
  <h3>รายงานทรัพย์สิน</h3>
      <p>รายการทรัพย์สินทั้งหมด</p>      
          
   <h5><input type="button" value="ทรัพย์สิน" id="btn_back" onclick="window.location='?page=from_asset';" class="inner_position_right"></h5>
	<div class="sep"></div><br>
  
<form method="post" id="frmSearch" name="frmSearch" >
	<table  align="center" border="0" width="1050px">
	<tr><td align="center">
	<input value="<?=$page__5;?>" type="hidden" id="page__5" name="page__5" >
	<input value="<?=$do5;?>" type="hidden" id="do5" name="do5" >

	
	IMEI&nbsp;<input type="text" id="IMEI_data" name="IMEI_data" value="<?=$IMEI_data;?>" <?if($all_d=='all'){echo "disabled";}?>>
	&nbsp;&nbsp;MAC&nbsp;<input type="text" id="MAC_data" name="MAC_data" value="<?=$MAC_data;?>" <?if($all_d=='all'){echo "disabled";}?>>
	&nbsp;&nbsp;USER&nbsp;
	<select  style="width:150px;" id="User_data" name="User_data"<?if($all_d=='all'){echo "disabled";}?> >
			<?
			$U_data="select * from st_user where User_id='$User_data' ";
			$U_data	=sqlsrv_query($con,$U_data,$params,$options);
			$U_data=sqlsrv_fetch_array($U_data);
			if ($User_data=$_GET['User_data']){?>
	<option value="<?=$User_data;?>"><?=$U_data['User_id']." ".$U_data['name'];?></option><?}?>
	<?if (!$User_data=$_GET['User_data']){?>
	
			
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
	จำนวนรายการ&nbsp;<select id="number_data" name="number_data"  style="width:75px;" >
	<?if ($number_d=$_GET['number_d']){?>
	<option value="<?=$number_d;?>"><?=$number_d;?></option><?}?>
	<?if (!$number_d=$_GET['number_d']){?>
	<option value="50">50</option>
	<option value="100">100</option>
	<option value="150">150</option>
	<option value="200">200</option>
	<option value="250">250</option>
	<option value="300">300</option><?}?>
	
	</select>
	&nbsp;&nbsp;<input type="checkbox" value="all" id="all_" name="all_"<?if($all_d=='all'){echo "checked";}?>>ดูทั้งหมด
	&nbsp;&nbsp;<input type="button" value="ค้นหา" class="myButton_form" id="search5" name="search5">
	</td></tr>
	
	

	</table>
	</div>
	</div>
	</div>	
	<div id="tabs">
	<br><br><div id="txt_search5" align="center"></div>
	</form>
	</div>

