<?
    session_start();
	set_time_limit(0);
	include("../includes/config.php");
	
	$_USER_TYPE=$_SESSION["_USER_TYPE"];

?>
<script type="text/javascript">
	$(function(){	
		
		$('#btSearch,#btExport2').button();
	
		$('#btSearch').click(function(){
		
					if($('#txt_DC').prop('value')==' ')
					{ alert("โปรดใส่ศุนย์ที่ต้องการค้นหา");
					}
					else if($('#txt_mouth').prop('value')==' ')
					{ alert("โปรดใส่เดือนที่ต้องการค้นหา");
					}
					else {
					$('#show_detail').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/ReportMTD.php',
						type:'POST',
						data:$('#frmuser').serialize(),
						success:function(result){
							$('#show_detail').html(result);
							}
							});
							
						}	
		});
		$('#btExport2').click(function(){
				//alert("test");
				if($('#txt_DC').prop('value')==' ')
					{ alert("โปรดใส่ศุนย์ที่ต้องการค้นหา");
					}
					else if($('#txt_mouth').prop('value')==' ')
					{ alert("โปรดใส่เดือนที่ต้องการค้นหา");
					}
				else {
					$('#frmuser').submit();
				}
			});
	});
				
</script>
<form  method="post" name="frmuser" id="frmuser"  action="report/ExcelReportMTD.php">

	<div id='divShow' style='border:0px solid #000;text-align:center;' >
	  <table width="1120" border="0" align="center" cellpadding="3" cellspacing="0"  class="box">
	    <tr><td colspan="10" ><div class="h_head">ค้นหาMTDสรุปยอดขายประจำวัน </div> </tr>
	    <tr><td colspan="10" style="color:red;text-align:center;font-weight:bold;"> &nbsp;<br /></td></tr>
		
	    <tr>
			
			<td align="center"><b style="color:black;text-align:center;">ศูนย์</b>
				<select id="txt_DC" name="txt_DC"   style="width:150px;">
					<?	$sql1="select DIST_CD ,DIST_SHORTNAME ,DIST_NAME from DC_MASTER  ";
					
						if($_USER_TYPE=="admin")
						{	$sql1.="where DIST_CD='540' or DIST_CD='541' or DIST_CD='545' or DIST_CD='531'  "; 
							echo '<option value=" " > - Selete -</option>';
						}
						else {$sql1.="where DIST_CD='$_USER_TYPE' ";}
						$params = array();
						$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
						$qry1=sqlsrv_query($con,$sql1,$params,$options);
						$row1=sqlsrv_num_rows($qry1);
						for($i=0;$i<$row1;$i+=1)
						{
						$detail1=sqlsrv_fetch_array($qry1);
					?>
					<option value="<?print $detail1['DIST_CD']?>"><?print $detail1['DIST_NAME']   ?></option>
					<?}	?>
				</select>
			
			<b style="color:black;text-align:center;">เดือน</b>
			<select id="txt_mouth" name="txt_mouth"   style="width:100px;">
				<option value=" "> -เลือกเดือน- </option>
				<option value="01">มกราคม</option>
				<option value="02">กุมภาพันธ์</option>
				<option value="03">มีนาคม</option>
				<option value="04">เมษายน</option>
				<option value="05">พฤษภาคม</option>
				<option value="06">มิถุนายน</option>
				<option value="07">กรกฏาคม</option>
				<option value="08">สิงหาคม</option>
				<option value="09">กันยายน</option>
				<option value="10">ตุลาคม</option>
				<option value="11">พฤศจิกายน</option>
				<option value="06">มิถุนายน</option>
			</select>
			<b style="color:black;text-align:center;">ปี</b>
			<select id="txt_year" name="txt_year"   style="width:100px;">
				<option value="<?=date('Y');?>"><?=date('Y');?></option>
				<option value="<?=date('Y')-3;?>"><?=date('Y')-3;?></option>
				<option value="<?=date('Y')-2;?>"><?=date('Y')-2;?></option>
				<option value="<?=date('Y')-1;?>"><?=date('Y')-1;?></option>
				<option value="<?=date('Y');?>"><?=date('Y');?></option>
				<option value="<?=date('Y')+1;?>"><?=date('Y')+1;?></option>
				<option value="<?=date('Y')+2;?>"><?=date('Y')+2;?></option>
				<option value="<?=date('Y')+3;?>"><?=date('Y')+3;?></option>
			</select>
			
			</td>
			
			
        </tr>
	    <tr><td style="text-align:center;"  colspan="10" >&nbsp;</br>
	        <a href="#/btSearch" id="btSearch" style="width:150px;text-align:center;" >Search Report</a>
			<a href="#/export2" id="btExport2" style="width:150px;text-align:center;" >Export Excel</a>
	        <!--<a href="#/export3" id="btExport3" style="width:150px;text-align:center;" >Export SMS</a>-->
			</td>
        </tr>
      </table>
	<div id="show_detail">

</div>
</form>

