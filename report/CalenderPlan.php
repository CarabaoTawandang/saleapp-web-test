<?include("../includes/config.php");

			$txt_userPlan=$_POST['txt_userPlan'];
			$sql="SELECT dc_groupid FROM st_user where User_id='$txt_userPlan' ";
			$qry=sqlsrv_query($con,$sql);
			$de=sqlsrv_fetch_array($qry);
			
			

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
  
 <script type="text/javascript">
$(function(){	
			
		$('#Save').button();
		$('#Save').click(function(){
				
				//$('#txt_save').html("<img src='images/89.gif'>");
				$(".alert_box").css("display", "block").html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/save_CalenderPlan.php',
					type:'POST',
					data:$('#frmSave').serialize(),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#alert_box').html(result);
					}
				});
				
		});
		
		
		
});//function	
</script>
 <style type="text/css">  
#calendar_css {  
    background-color:#F0F0F0;  
    border-style:solid;  
    border-width:0px;  
    border-right-width:0px;  
    border-bottom-width:0px;  
    border-color:#cccccc;  
}  
 td.monthTitle{  
    background-color:#666666;  
    text-align:center;  
	font:21px tahoma;    
	color:#FFFFFF; 
}
#calendar_css thead{  /*--------จ อ พ พฟ ศ ส อา----*/
    text-align:center;  
    font:21px tahoma;  
    width:200PX;  
    height:80px;   
    background-color:#333333;  
    color:#FFFFFF;  
}  
#calendar_css .current{  
    text-align:center;  
    font:11px tahoma;  
    width:200PX;  
    height:80px;   
    background-color:#C0C0C0 ;  
    color:#FFFFFF;  
}  
col.holidayCol{  
    background-color:#FDDFE4;  
    color:#FF0000;  
}  
  
#calendar_css td{  
    text-align:center;  
    font:11px tahoma;  
    width:200PX;  
    height:80px;  
} 
 </style>
</head>
<body>
<?php  
$MONTH= $_POST['txt_month'];//intval(date("m")-9);   
$YEAR=$_POST['txt_year'];
$day_now=array("Sun"=>"1","Mon"=>"2","Tue"=>"3","Wed"=>"4","Thu"=>"5","Fri"=>"6","Sat"=>"7");     
$first_day=date("D",mktime(0,0,1,$MONTH,1,$YEAR));     
$start_td=$day_now[$first_day]-1;        
$num_day=date("t");     
$num_day2=($num_day+$start_td);     
$num_day3=(7*ceil($num_day2/7));     
?><div id="alert_box"  class="alert_box" align="center"></div>
<form  method="post" name="frmSave" id="frmSave" action="" > 
<table id="calendar_css"  border="1" cellspacing="0" cellpadding="0">     
<colgroup>     
<col class="holidayCol" />     
<col span="5" />     
<col class="holidayCol" />     
</colgroup>     
<thead>     
<tr>  
<td colspan="7" class="monthTitle">  
<input type="hidden" id="txt_userPlan" name="txt_userPlan" value="<? echo $txt_userPlan;?>">
<input type="hidden" id="txt_MONTH" name="txt_MONTH" value="<? echo $MONTH;?>">
<input type="hidden" id="txt_YEAR" name="txt_YEAR" value="<? echo $YEAR;?>">
<?
	switch($MONTH)
	{ 
	case 1 : $monthTH="มกราคม"; break;
	case 2 : $monthTH="กุมภาพันธ์"; break;
	case 3 : $monthTH="มีนาคม"; break;
	case 4 : $monthTH="เมษายน"; break;
	case 5 : $monthTH="พฤษภาคม"; break;
	case 6 : $monthTH="มิถุนายน"; break;
	case 7 : $monthTH="กรกฎาคม"; break;
	case 8 : $monthTH="สิงหาคม"; break;
	case 9 : $monthTH="กันยายน"; break;
	case 10 : $monthTH="ตุลาคม"; break;
	case 11 : $monthTH="พฤศจิกายน"; break;
	case 12 : $monthTH="ธันวาคม"; break;
	}
	echo $monthTH;
echo " - ";
echo $YEAR;
/*echo "<br>";
	echo "กรุณษเลือกแผนในช่อง => ";
	echo '<select style="width:100px;">';
	echo '</select>';*/
?>  
</td>  
</tr>  
  <tr>     
    <td>อา </td>     
    <td>จ </td>     
    <td>อ </td>     
    <td>พ </td>     
    <td>พฤ </td>     
    <td>ศ </td>     
    <td>ส </td>     
  </tr>     
</thead>     
<?php 
for($i=1;$i <=$num_day3;$i++){ ?>     
<?php if($i%7==1){ ?>     
  <tr>     
  <?php } ?>     
    <td <?=(date("j")==$i-$start_td &&$MONTH==date("m"))?"class=\"current\"":""?>>
	<? echo $day=($i-$start_td>=1 && $i-$start_td <=$num_day)?$i-$start_td:" "?><br>
	<? 
	if($day>=1)
	{			//echo $txt_plan= "txt_plan".$day."-".$MONTH."-".$YEAR;
				
				$sql3="SELECT Plan_id ,Plan_name FROM st_Master_plan where DC_id ='$de[dc_groupid]' 
				and Plan_status is null  ";
				if($_POST['txt_like']){$sql3.=" and Plan_name like '%$_POST[txt_like]%' ";}
				$sql3.=" order by Plan_name asc  ";
				//echo $sql3;
				$qry3=sqlsrv_query($con,$sql3,$params,$options);
				$row3=sqlsrv_num_rows($qry3);
				if($row3>0){echo "<option value='' >- เลือกแผน-</option>";}
				else if($row3<=0){echo "<option value=''>-ไม่มีแผน-</option>";}
				$qry3=sqlsrv_query($con,$sql3); $a=1;
				echo '<select id="txt_plan[]" name="txt_plan[]"   style="width:150px;color:#000;">';
				echo "<option value=''></option>";
				
				while($detail3=sqlsrv_fetch_array($qry3))
				{
					
					echo '<option value="'.$detail3['Plan_id'].'">['.$a.']'.$detail3['Plan_name'].'</option></font>';
				$a++;}
				echo '<select>';
			
			
	
	}?>
	</td>
	
	
	<!---<td   <?=(date("j")==$i-$start_td)?"class=\"current\"":""?>> <?=($i-$start_td>=1 && $i-$start_td <=$num_day)?$i-$start_td:" "?> </td> --เดิม---->
<?php if($i%7==0){ ?>     
  </tr>     
  <?php } ?>     
<?php } ?>     
</table> 
<br>   
<B>หมายเหตุ : </B>
	<input type="text" id="txt_remark"align="center" name="txt_remark" size="35"><br><br>
	<input type="button" id="Save" name="Save" value="SAVE">
</form>

</body>
</html>
