<?//------------------------------------------------------แก้ไข โดย PONG 17/09/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

?>
<script type="text/javascript">
$(function(){	
	$('#BACK').button();
	$("#tabs").tabs(); 

	
	$("#tabs").tabs().find(".ui-tabs-nav").sortable({axis:'x'});
	
	$("#tabs").tabs({collapsible: true});


		$('#search').click(function(){
					if(($('#count').prop('value')==''))
					{alert("โปรดใส่จำนวนรายการ !");}
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
						
						url:'report/data_Maintenance_tab_from.php',
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
						
						url:'report/data_Maintenance_tab_from.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
					
		});}
	
		
		});//function	
</script>

<style type="text/css">  
 
.ui-tabs{  
    font-family:tahoma;  
    font-size:12px; 
	height:auto;  
	
} 
</style> 

<div class="container_box">
             
  <div id="box">
 <div class="header">
        
        <h3>Maintenance and Log User</h3>
            
          <p>ค้นหารายการ Maintenance and Log User</p>
  
            
    </div>
	<div class="sep"></div><br>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Maintenance</a></li>
		<li><a href="#tabs-2">Log User</a></li>
	
	</ul>
	<div id="tabs-1">
	<?

$S=$_GET['S'];
$E=$_GET['E'];
$C=$_GET['C'];
$page__=$_GET['page__'];
$do=$_GET['do'];
	?>
	<form method="post" id="frmSearch" name="frmSearch" >
	<table  align="center" border="0" width="1050px">
	<tr><td align="center">
	<input value="<?=$id;?>" type="hidden" id="id" name="id" >
	<input value="<?=$page__;?>" type="hidden" id="page__" name="page__" >
	<input value="<?=$do;?>" type="hidden" id="do" name="do" >
	Serial No.&nbsp;<input type="text" value="<?=$S;?>" id="txt_id" name="txt_id" >&nbsp;&nbsp;
	อุปกรณ์&nbsp;<select id="Equipment" name="Equipment"  style="width:150px;" >
	<?if ($E=$_GET['E']){?>
	<option value="<?=$E;?>"><?if($E="TL"){echo "Tablet";}else{echo "Mobile Printer";}?></option><?}?>
	<?if (!$E=$_GET['E']){?>
	<option value="">--เลือก--</option><?}?>
	<option value="TL">Tablet</option>
	<option value="MP">Mobile Printer</option>
	</select>
	
	จำนวนรายการ&nbsp;<select id="count" name="count"  style="width:75px;" >
	<?if ($C=$_GET['C']){?>
	<option value="<?=$C;?>"><?=$C;?></option><?}?>
	<?if (!$C=$_GET['C']){?>
	<option value="">--เลือก--</option><?}?>
	<?for($X=1; $X<=100; $X++){?>
	<option value="<?=$X;?>"><?=$X;?></option>
	<?}?>
	</select>
	
	
	&nbsp;&nbsp;<input type="button" value="ค้นหา" class="myButton_form" id="search" name="search">
	<input type="button" value="เพิ่มรายการซ่อมบำรุง" id="btn_add" class="myButton_form" onclick="window.location='?page=add_Maintenance';" class="inner_position_right">
	<br><br><div id="txt_search"></div>
	</td></tr>
	</table>
	</form>


	</div>
	<div id="tabs-2">
		<p>รายละเอียดย่อยหัวข้อแท็บที่ 2</p>
	</div>
	
</div>
<br>
<h5><input type="button" value="กลับหน้าเดิม" id="BACK" onclick="window.location='?page=from_asset';" ></h5>

</div><!--/-box-->
</div><!--/-container_box-->
