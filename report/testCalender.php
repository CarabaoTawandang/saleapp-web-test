<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">  
 
 <style type="text/css">  
#calendar_css {  
    background-color:#F0F0F0;  
    border-style:solid;  
    border-width:0px;  
    border-right-width:0px;  
    border-bottom-width:0px;  
    border-color:#cccccc;  
}  
#calendar_css td{  
    text-align:center;  
    font:11px tahoma;  
    width:100PX;  
    height:80px;  
}  
#calendar_css thead{  
    text-align:center;  
    font:11px tahoma;  
    width:100PX;  
    height:80px;   
    background-color:#333333;  
    color:#FFFFFF;  
}  
#calendar_css .current{  
    text-align:center;  
    font:11px tahoma;  
   width:100PX;  
    height:80px;   
    background-color:#FF0000;  
    color:#FFFFFF;  
}  
col.holidayCol{  
    background-color:#FDDFE4;  
    color:#FF0000;  
}  
td.monthTitle{  
    background-color:#666666;  
    text-align:center;  
    font:11px bold tahoma;    
}  
 </style>
</head>
<body>
test
<?php  
$MONTH= $_POST['txt_month'];//intval(date("m")-9);   
$YEAR=$_POST['txt_year'];
$day_now=array("Sun"=>"1","Mon"=>"2","Tue"=>"3","Wed"=>"4","Thu"=>"5","Fri"=>"6","Sat"=>"7");     
$first_day=date("D",mktime(0,0,1,$MONTH,1,$YEAR));     
$start_td=$day_now[$first_day]-1;        
$num_day=date("t");     
$num_day2=($num_day+$start_td);     
$num_day3=(7*ceil($num_day2/7));     
?>     
<table id="calendar_css"  border="1" cellspacing="0" cellpadding="0">     
<colgroup>     
<col class="holidayCol" />     
<col span="5" />     
<col class="holidayCol" />     
</colgroup>     
<thead>     
<tr>  
<td colspan="7" class="monthTitle">  
<?=$MONTH." - ".$YEAR;?>  
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
<?php for($i=1;$i <=$num_day3;$i++){ ?>     
<?php if($i%7==1){ ?>     
  <tr>     
  <?php } ?>     
    <td>
	<? echo $day=($i-$start_td>=1 && $i-$start_td <=$num_day)?$i-$start_td:" "?><br>
	<? if($day>=1){echo "***";}?>
	</td>
	
	
	<!---<td   <?=(date("j")==$i-$start_td)?"class=\"current\"":""?>> <?=($i-$start_td>=1 && $i-$start_td <=$num_day)?$i-$start_td:" "?> </td> --เดิม---->
<?php if($i%7==0){ ?>     
  </tr>     
  <?php } ?>     
<?php } ?>     
</table>    
</body>
</html>
