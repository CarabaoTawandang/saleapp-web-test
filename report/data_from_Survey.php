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
#mouseOver {
        display: inline;
        position: relative;
    }
    
    #mouseOver #img2 {
        position: absolute;
        left: 50%;
        transform: translate(-100%);
        bottom: 0em;
        opacity: 0;
        pointer-events: none;
        transition-duration: 800ms; 
		top: 50px;
    }
    
    #mouseOver:hover #img2 {
        opacity: 1;
        transition-duration: 400ms;
    }
</style> 
</head>
<body>

	<table  align="center" class="tables" >
	<tr>
	<th align="center"width="30px">ลำดับ</th>
	<th align="center"width="200px">รหัสFromSurvey</th>
	<th align="center"width="200px">หัวข้อFromSurvey</th>
	<th align="center"width="200px">วันที่แสดง</th>
	<th style="width:150px">DC ที่ใช้ </th>
	<th style="width:200px">ตำแหน่ง ที่ใช้</th>
	<th style="width:200px">ข้อ</th>
	<th style="width:150px">ประเภทการถาม</th>
	<th style="width:150px">ถาม</th>
	<th style="width:150px">ประเภทการตอบ</th>
	<th style="width:150px">ตอบ</th>
    <th> หมายเหตุ</th>
	<th> ลบ</th>
	</tr>
	<?
	$sqlH="select * from st_Master_Survey order by SurveyID  ";
	$sqlH= sqlsrv_query($con,$sqlH,$params,$options);
	$X=1;
	while($show = sqlsrv_fetch_array($sqlH))
	{
	?>
	<tr class="mousechange">
	<td><?=$X; ?></td>
	<td><?=$show['SurveyID']; ?></td>
	<td><?=$show['SurveyName']; ?></td>
	<td><?=date_format($show['SurveyDate'],'d/m/Y H:i:s'); ?></td>
	<td>--</td>
	<td>--</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td>
	<!----<a href="?page=delete_MasterSurvey&do=del&id=<?=$show['SurveyID'];?>" onclick="return confirm('คุณต้องการลบใช่หรือไม่?');" >
		<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>--->
		
		</td>
	</tr>
	
	<?
	$Question="select * from st_Master_Survey_detail where SurveyID ='$show[SurveyID]'
				order by Row";
	$Question= sqlsrv_query($con,$Question,$params,$options);

	while($Question_ = sqlsrv_fetch_array($Question))
	{


	?>
	<tr class="mousechange">
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td><?=$Question_['Row']; ?></td>
	<td><? if($Question_['QuestionType']=="อื่นๆ" or $Question_['QuestionType']=="อื่นๆ2")
 { echo $Question_['QuestionType']; }else 
 { $QuestionType =  $Question_['QuestionType']; 
  $sql2="select prd_type_nm from st_item_type where prd_type_id ='$QuestionType'";
  $sql2=sqlsrv_query($con,$sql2);
  $sql2=sqlsrv_fetch_array($sql2);
  echo $sql2['prd_type_nm'];
 }
 ?></td>

<td>
<?
	$message = $Question_['Question'];
     
    if(strpos($message,"#")) {
  
	$a = $Question_['Question'];
	$b = explode("#", $a);
		
	for($i=0;$i<count($b);$i++)
	{	
	/*echo "$b[$i]<br>"; */

	$XX=TRIM($b[$i]);
	$Q_NAME="select PRODUCTNAME from st_item_product where P_Code ='$XX'";
	$Q_NAME= sqlsrv_query($con,$Q_NAME,$params,$options);
	$show_Q_NAME = sqlsrv_fetch_array($Q_NAME);	

	echo $show_Q_NAME['PRODUCTNAME']."<br>";
	
	
	}
							} 
		else {
     
			echo $Question_['Question'];
     
			 }				
	?>
</td>
	<td><?=$Question_['AnswerType']; ?></td>
	<td>
	<?
	$message_A = $Question_['Answer'];
     
    if(strpos($message_A,"#")) {
  
	$aa = $Question_['Answer'];
	$bb = explode("#", $aa);
	for($ii=0;$ii<count($bb);$ii++)
	{
	echo "$bb[$ii]<br>";
	}
	} 
	else {
     
	echo $Question_['Answer'];
     
	}				
	?>
		
	</td>
	<td><?=$Question_['detail']; ?></td>
	<td></td>
	</tr>
	<?}?>
	
	<?$X++;}?>
	</table>
</div></div><br><br>


</body>
</html>
