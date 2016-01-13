<?
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$id=$_GET['id'];
		$sqlRe="select dc_groupname from st_user_group_dc where dc_groupid='$id'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryRe=sqlsrv_query($con,$sqlRe,$params,$options);
		$Re=sqlsrv_fetch_array($qryRe);
		
		$sqlSelectGeo="SELECT  GEO_ID ,GEO_NAME  FROM dc_geography   ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qrySelectGeo=sqlsrv_query($con,$sqlSelectGeo,$params,$options);
		$rowSelectGeo=sqlsrv_num_rows($qrySelectGeo);
		
		$sqlPro1="SELECT PROVINCE_NAME,PROVINCE_ID FROM dc_Province where GEO_ID='1' order by PROVINCE_NAME asc  ";
		$qryPro1=sqlsrv_query($con,$sqlPro1,$params,$options);
		$rowPro1=sqlsrv_num_rows($qryPro1); 
		
		$sqlPro2="SELECT PROVINCE_NAME,PROVINCE_ID FROM dc_Province where GEO_ID='2' order by PROVINCE_NAME asc  ";
		$qryPro2=sqlsrv_query($con,$sqlPro2,$params,$options);
		$rowPro2=sqlsrv_num_rows($qryPro2); 
		
		$sqlPro3="SELECT PROVINCE_NAME,PROVINCE_ID FROM dc_Province where GEO_ID='3' order by PROVINCE_NAME asc  ";
		$qryPro3=sqlsrv_query($con,$sqlPro3,$params,$options);
		$rowPro3=sqlsrv_num_rows($qryPro3); 
		
		$sqlPro4="SELECT PROVINCE_NAME,PROVINCE_ID FROM dc_Province where GEO_ID='4' order by PROVINCE_NAME asc  ";
		$qryPro4=sqlsrv_query($con,$sqlPro4,$params,$options);
		$rowPro4=sqlsrv_num_rows($qryPro4); 
		
		$sqlPro5="SELECT PROVINCE_NAME,PROVINCE_ID FROM dc_Province where GEO_ID='5' order by PROVINCE_NAME asc  ";
		$qryPro5=sqlsrv_query($con,$sqlPro5,$params,$options);
		$rowPro5=sqlsrv_num_rows($qryPro5); 
		
		$sqlPro6="SELECT PROVINCE_NAME,PROVINCE_ID FROM dc_Province where GEO_ID='6' order by PROVINCE_NAME asc  ";
		$qryPro6=sqlsrv_query($con,$sqlPro6,$params,$options);
		$rowPro6=sqlsrv_num_rows($qryPro6); 
		
?>

<script type="text/javascript">
	$(function(){	
			
		
		<? for($i=1;$i<=6;$i++){ ?>
		$('#txtGeo<?=$i;?>').click(function(){
					if($(this).is(":checked")){
					$(".boxT").hide();
					$(".showPro<?=$i;?>").show();
					document.getElementById("showPro<?=$i;?>").style.display="block"
					document.getElementById("notshowPro<?=$i;?>").style.display="none";
					} 
					else{
					$(".boxT").hide();
					$(".notshowPro<?=$i;?>").show();
					document.getElementById("notshowPro<?=$i;?>").style.display="block";
					document.getElementById("showPro<?=$i;?>").style.display="none";
					}
		});//txtGeo1
		<? } ?>
		
	var requiredCheckboxes = $(':checkbox[name="txtGeo[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
	
	
	$('#txtProAll1').click(function(){
					if($(this).is(":checked")){
					<? for($i=1;$i<=$rowPro1;$i++){ ?>
					 document.getElementById("txtPro1_<?=$i; ?>").checked = true;
					 document.getElementById("txtPro1_<?=$i; ?>").disabled = true;
					 <? } ?>
							} //if
					else{
					 <? ;for($i=1;$i<=$rowPro1;$i++){ ?>
					 document.getElementById("txtPro1_<?=$i; ?>").checked = false;
					 document.getElementById("txtPro1_<?=$i; ?>").disabled = false;
					 <? } ?>
					}
					
		});//Pro1All
	$('#txtProAll2').click(function(){
					if($(this).is(":checked")){
					<? for($i=1;$i<=$rowPro2;$i++){ ?>
					 document.getElementById("txtPro2_<?=$i; ?>").checked = true;
					 document.getElementById("txtPro2_<?=$i; ?>").disabled = true;
					 <? } ?>
							} //if
					else{
					 <? ;for($i=1;$i<=$rowPro2;$i++){ ?>
					 document.getElementById("txtPro2_<?=$i; ?>").checked = false;
					 document.getElementById("txtPro2_<?=$i; ?>").disabled = false;
					 <? } ?>
					}
					
		});//Pro1All2
		$('#txtProAll3').click(function(){
					if($(this).is(":checked")){
					<? for($i=1;$i<=$rowPro3;$i++){ ?>
					 document.getElementById("txtPro3_<?=$i; ?>").checked = true;
					 document.getElementById("txtPro3_<?=$i; ?>").disabled = true;
					 <? } ?>
							} //if
					else{
					 <? ;for($i=1;$i<=$rowPro3;$i++){ ?>
					 document.getElementById("txtPro3_<?=$i; ?>").checked = false;
					 document.getElementById("txtPro3_<?=$i; ?>").disabled = false;
					 <? } ?>
					}
					
		});//Pro1All3
		$('#txtProAll4').click(function(){
					if($(this).is(":checked")){
					<? for($i=1;$i<=$rowPro4;$i++){ ?>
					 document.getElementById("txtPro4_<?=$i; ?>").checked = true;
					 document.getElementById("txtPro4_<?=$i; ?>").disabled = true;
					 <? } ?>
							} //if
					else{
					 <? ;for($i=1;$i<=$rowPro4;$i++){ ?>
					 document.getElementById("txtPro4_<?=$i; ?>").checked = false;
					 document.getElementById("txtPro4_<?=$i; ?>").disabled = false;
					 <? } ?>
					}
					
		});//Pro1All4
		$('#txtProAll5').click(function(){
					if($(this).is(":checked")){
					<? for($i=1;$i<=$rowPro5;$i++){ ?>
					 document.getElementById("txtPro5_<?=$i; ?>").checked = true;
					 document.getElementById("txtPro5_<?=$i; ?>").disabled = true;
					 <? } ?>
							} //if
					else{
					 <? ;for($i=1;$i<=$rowPro5;$i++){ ?>
					 document.getElementById("txtPro5_<?=$i; ?>").checked = false;
					 document.getElementById("txtPro5_<?=$i; ?>").disabled = false;
					 <? } ?>
					}
					
		});//Pro1All5
		$('#txtProAll6').click(function(){
					if($(this).is(":checked")){
					<? for($i=1;$i<=$rowPro6;$i++){ ?>
					 document.getElementById("txtPro6_<?=$i; ?>").checked = true;
					 document.getElementById("txtPro6_<?=$i; ?>").disabled = true;
					 <? } ?>
							} //if
					else{
					 <? ;for($i=1;$i<=$rowPro6;$i++){ ?>
					 document.getElementById("txtPro6_<?=$i; ?>").checked = false;
					 document.getElementById("txtPro6_<?=$i; ?>").disabled = false;
					 <? } ?>
					}
					
		});//Pro1All6
		
	});//function
	
	
	
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
<style type="text/css">
    .boxT{
        padding: 1px;
        display: none;
        margin-top: 0px;
        border: 0px solid #000;
    }
    .red{ background: #ff0000; }
    .green{ background: #00ff00; }
    .blue{ background: #0000ff; }
</style>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>แก้ไข <? echo $id;?></h3>
            
          <p>
		  <input type="button" value="ค้นหาDC" id="btn_add" onclick="window.location='?page=from_DC';" align="center" class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser"  action="?page=edit_DC2">
<table cellpadding="0" cellspacing="0"  border="0" >
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
<td align="left" width="100px"><B style="color:black;text-align:center;">ชื่อDC :</B></td>
<td align="left">
		<input type="text" id="txtNameDC" name ="txtNameDC"  value="<?=$Re['dc_groupname'];?>"required> 
		<input type="hidden" id="txtID" name ="txtID"  value="<?=$id;?>" >
</td>
</tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr>
<td align="left" valign="top"><B style="color:black;text-align:center;">พื้นที่ดูแล:</B></td>
<td align="left" valign="top">
<?$i=1;while($detailGeo=sqlsrv_fetch_array($qrySelectGeo)){?>
<div>
<input type="checkbox" id="txtGeo<?=$i;?>" name="txtGeo[]" value="<?print $detailGeo['GEO_ID'];?>" required/>
<font color="red"><b><?print $detailGeo['GEO_NAME']." ";?></b></font>
<div id="showPro<?=$i;?>" style="display:none">&nbsp;&nbsp;&nbsp;
	<? if($i==1){
	for($j=1;$j<=$rowPro1;$j++){$detailPro1=sqlsrv_fetch_array($qryPro1);?> 
	<input type="checkbox" id="txtPro1_<?=$j;?>" name="txtPro1[]" value="<?print $detailPro1['PROVINCE_ID'];?>" >
	<?print $detailPro1['PROVINCE_NAME']." "; ?>
	<? 
	
	} //for?>
	<input type="checkbox" id="txtProAll1" name="txtPro1[]" value="Pro1All" ><u>Allเลือกทุกจังหวัดในภาคเหนือ</u>
	<?}//if?>
	
	<? if($i==2){
	for($j=1;$j<=$rowPro2;$j++){$detailPro2=sqlsrv_fetch_array($qryPro2);?> 
	<input type="checkbox" id="txtPro2_<?=$j;?>" name="txtPro2[]" value="<?print $detailPro2['PROVINCE_ID'];?>">
	<?print $detailPro2['PROVINCE_NAME']." "; ?>
	<? 
	
	} //for?>
	<input type="checkbox" id="txtProAll2" name="txtPro2[]" value="Pro1All2" ><u>Allเลือกทุกจังหวัดในภาคกลาง</u>
	<?}//if?>
	
	<? if($i==3){
	for($j=1;$j<=$rowPro3;$j++){$detailPro3=sqlsrv_fetch_array($qryPro3);?> 
	<input type="checkbox" id="txtPro3_<?=$j;?>" name="txtPro3[]" value="<?print $detailPro3['PROVINCE_ID'];?>" >
	<?print $detailPro3['PROVINCE_NAME']." "; ?>
	<? 
	
	} //for?>
	<input type="checkbox" id="txtProAll3" name="txtPro3[]" value="Pro1All3" ><u>Allเลือกทุกจังหวัดในภาคตะวันออกเฉียงเหนือ</u>
	<?}//if?>
	
	<? if($i==4){
	for($j=1;$j<=$rowPro4;$j++){$detailPro4=sqlsrv_fetch_array($qryPro4);?> 
	<input type="checkbox" id="txtPro4_<?=$j;?>" name="txtPro4[]" value="<?print $detailPro4['PROVINCE_ID'];?>" >
	<?print $detailPro4['PROVINCE_NAME']." "; ?>
	<? 
	
	} //for?>
	<input type="checkbox" id="txtProAll4" name="txtPro4[]" value="Pro1All4" ><u>Allเลือกทุกจังหวัดในภาคตะวันตก</u>
	<?}//if?>
	
	<? if($i==5){
	for($j=1;$j<=$rowPro5;$j++){$detailPro5=sqlsrv_fetch_array($qryPro5);?> 
	<input type="checkbox" id="txtPro5_<?=$j;?>" name="txtPro5[]" value="<?print $detailPro5[''];?>" >
	<?print $detailPro5['PROVINCE_NAME']." "; ?>
	<? 
	
	} //for?>
	<input type="checkbox" id="txtProAll5" name="txtPro5[]" value="Pro1All5" ><u>Allเลือกทุกจังหวัดในภาคตะวันออก</u>
	<?}//if?>
	
	<? if($i==6){
	for($j=1;$j<=$rowPro6;$j++){$detailPro6=sqlsrv_fetch_array($qryPro6);?> 
	<input type="checkbox" id="txtPro6_<?=$j;?>" name="txtPro6[]" value="<?print $detailPro6['PROVINCE_ID'];?>">
	<?print $detailPro6['PROVINCE_NAME']." "; ?>
	<? 
	
	} //for?>
	<input type="checkbox" id="txtProAll6" name="txtPro6[]" value="Pro1All6" ><u>Allเลือกทุกจังหวัดในภาคใต้</u>
	<?}//if?>
	
</div>
<div id="notshowPro<?=$i;?>" style="display:none"></div>		
<?$i++;}//while?>
</div>
</td>
</tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>

<tr>	
<td colspan="2" align="left" >
	<input type="hidden" id="hd_cmd"  name="hd_cmd" />
				
				<input type="submit" class="myButton_form" id="NEXT1" name="NEXT1" value="NEXT">			
</tr>	
</table>
</form>
<div id="DIV_NEXT"></div>

</div>
</div>