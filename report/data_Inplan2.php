<?include("../includes/config.php");

			
			
			

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
  
 <script type="text/javascript">
$(function(){	
			
		
		$('#Edit').button();
		
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
?><div id="txt_save" align="center"></div>
<form  method="post" name="frmSave" id="frmSave" action="?page=Edit_planMonth" > 
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
	$txt_User= $_POST['txt_User'];
	echo $monthTH;
echo " - ";
echo $YEAR;
/*echo "<br>";
	echo "กรุณษเลือกแผนในช่อง => ";
	echo '<select style="width:100px;">'; คุณต้องการลบข้อมูล Planทั้งเดือน ของ  User หรือไม่?
	echo '</select>';*/
?>  
<input type="hidden" id="txt_userPlan" name="txt_userPlan" value="<?=$txt_User;?>">
<input type="hidden" id="txt_month" name="txt_month" value="<?=$MONTH;?>">
<input type="hidden" id="txt_year" name="txt_year"  value="<?=$YEAR;?>">
<div align="right">
	<button id="" ><img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
	
	<!--<a href="#" onclick="return confirm('ยังไม่สามารถลบข้อมูลได้');" >
	<img src="./images/del.gif" style="cursor:pointer" alt="Complete">
	</a>--->
	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
	
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
    <td  class="mousechange"   <?=(date("j")==$i-$start_td &&$MONTH==date("m"))?"class=\"current\"":""?>>
	<? echo $day=($i-$start_td>=1 && $i-$start_td <=$num_day)?$i-$start_td:" "?><br>
	<? 
	if($day>=1)
	{			
	
				$YMD=$YEAR."-".$MONTH."-".$day;
				
				$sql3="SELECT Plan_Docno,Plan_topic ,Plan_start_date,Plan_Remark 
				FROM st_plan_head 
				where User_id ='$txt_User' and cast(Plan_start_date as date)='$YMD'";
				$qry3=sqlsrv_query($con,$sql3); 
				
				$detail3=sqlsrv_fetch_array($qry3);
				echo '<a href="report/InPlanByUserByDay.php?&id='.$detail3['Plan_Docno'].'" target="_blank" >';
				//echo '<span style="cursor: pointer">'
				echo '<select id="txt_plan[]" name="txt_plan[]"   style="width:150px;color:#000;" >';
				echo '<option value="'.$detail3['Plan_id'].'">'.$detail3['Plan_topic'].'</option></font>';
				echo '<select>';
				echo '</a>';
				if($detail3){$qry33=sqlsrv_query($con,$sql3); $detail33=sqlsrv_fetch_array($qry33); }
	
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
	<input type="text" id="txt_remark"align="center" name="txt_remark" size="35" value="<?=$detail33['Plan_Remark']; ?>" disabled><br><br>
	
</form>

</body>
</html>
