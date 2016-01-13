<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
	session_start();  //เปิดseeion	
	set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
	include("includes/config.php"); //connect database db.carabao.com
	date_default_timezone_set('Asia/Bangkok');
	
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=SV_ByAll".date('Ymd').".xls"); 
	header("Content-Transfer-Encoding: binary");
	
	

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

<div align="center">
ข้อมูลสำรวจทั้งหมด สรุป ณ วันที่ <?=date('d-m-Y H:i:s'); ?>
<br>เครื่องหมาย- หมายถึง:ไม่มีการกระทำใดๆ
</div>
	<table  align="center" border='1' >
	<tr bgcolor="#66FF66">
	<th align="center"width="200px">รหัสDC</th>
	<th align="center"width="200px">DC</th>
	<th align="center"width="200px">จำนวน/ครั้ง</th>
	
	</tr>
	<? 
$SqlTotal="select  u.dc_groupid,dc.dc_groupname 
from st_Master_Survey_answer w left join st_user u 
on w.Createby = u.User_id left join st_user_group_dc dc
on u.dc_groupid = dc.dc_groupid  
group by u.dc_groupid,dc.dc_groupname
order by u.dc_groupid asc ";
$SqlTotal=sqlsrv_query($con,$SqlTotal); 
while($reTotal=sqlsrv_fetch_array($SqlTotal)){

?>
	<tr >
	<td><? echo $reTotal['dc_groupid']; $dc_groupid[]=$reTotal['dc_groupid'];?></td>
	<td><? echo $reTotal['dc_groupname'];?></td>
	
	<td><? 
$sqlCount="select u.dc_groupid,dc.dc_groupname ,w.Row ,Md.Question,Md.QuestionType,count( w.CustNum) as TotalByDc
from st_Master_Survey_answer w left join st_user u on w.Createby = u.User_id left join st_user_group_dc dc on u.dc_groupid = dc.dc_groupid 
left join st_Master_Survey_detail Md on w.SurveyID = Md.SurveyID and w.Row= Md.Row
where   Md.QuestionType like 'อื่นๆ%' and u.dc_groupid='$reTotal[dc_groupid]'
group by u.dc_groupid,dc.dc_groupname ,w.Row ,Md.Question,Md.QuestionType
order by count( w.CustNum) desc ";
$sqlCount=sqlsrv_query($con,$sqlCount); 
$sqlCount=sqlsrv_fetch_array($sqlCount);
	echo number_format($sqlCount['TotalByDc']); $Total=$Total+$sqlCount['TotalByDc'];
	
	?></td>
	</tr>
<? } ?>
	<tr >
	<td colspan="2">รวม</td>
	<td><?=$Total;?></td>
	</tr>
	</table><br><br>
	
	
	
	
	
	
	<? 
	//$dc_groupid[]='DC5800001';
	foreach($dc_groupid as $dc_groupids){ $a=1;
	//echo '<br>'.$dc_groupids;
	//}
	?>
	<table  align="center" border='1' >
	<tr bgcolor="#66FF66">
	<th align="center"width="200px">DC</th>
	<th align="center"width="200px">ข้อ</th>
	<th align="center"width="200px">คำตอบ</th>
	<th align="center"width="200px">จำนวน/ครั้ง</th>
	</tr>
	<? 
$SqlTotalByDcByQuestion="select u.dc_groupid,dc.dc_groupname ,w.Row ,Md.Question,Md.QuestionType,w.Answer ,count( w.CustNum) as TotalByDcByQuestion 
from st_Master_Survey_answer w left join st_user u on w.Createby = u.User_id left join st_user_group_dc dc on u.dc_groupid = dc.dc_groupid 
left join st_Master_Survey_detail Md on w.SurveyID = Md.SurveyID and w.Row= Md.Row
where  w.Answer !='-' 
group by u.dc_groupid,dc.dc_groupname ,w.Row ,Md.Question,Md.QuestionType,w.Answer having Md.QuestionType like 'อื่นๆ%' 
and u.dc_groupid='$dc_groupids' order by u.dc_groupid asc,w.Row asc";
$SqlTotalByDcByQuestion=sqlsrv_query($con,$SqlTotalByDcByQuestion); 
while($reTotalByDcByQuestion=sqlsrv_fetch_array($SqlTotalByDcByQuestion)){
	
	
	
?>
	
	
	<tr >
	
	<td><? if($a==1) {echo $reTotalByDcByQuestion['dc_groupname'];} $a++;?></td>
	<td><? echo $reTotalByDcByQuestion['Row']." ".$reTotalByDcByQuestion['Question'];?></td>
	<td><? echo $reTotalByDcByQuestion['Answer'];?></td>
	
	<td><? echo number_format($reTotalByDcByQuestion['TotalByDcByQuestion']); 
	$Total=$Total+$reTotalByDcByQuestion['TotalByDcByQuestion'];?></td>
	</tr>
	
	
<?  
$dc_groupidON = $reTotalByDcByQuestion['dc_groupid'];
} ?>
<?

	$sqlQ="SELECT d.Row,d.QuestionType,t.prd_type_nm,d.Question
	FROM st_Master_Survey_detail  d  left join st_item_type t on d.QuestionType =t.prd_type_id
	where d.SurveyID='SV-58-00001' and d.Row>=4";
	$sqlQ=sqlsrv_query($con,$sqlQ); 
	while($reQ=sqlsrv_fetch_array($sqlQ)){
		$expArray = explode("#",$reQ['Question']);
	foreach($expArray as $expArrays){$expArrays=trim($expArrays);
	if($expArrays <>'')
	{			$sql3="select PRODUCTNAME from st_item_product where P_Code ='$expArrays'";
				$sql3=sqlsrv_query($con,$sql3);
				$sql3=sqlsrv_fetch_array($sql3);
			for($i=1;$i<=3;$i++){ if($i==1){$Type22='มี';}if($i==2){$Type22='ไม่มี';} //if($i==3){$Type22='-';} 
				echo '<tr><td></td>';
				echo '<td>'.$reQ['Row']." ".$sql3['PRODUCTNAME'].'</td>';
				echo '<td>'.$Type22.'</td>';
				
				$sqlQty="select count(  w.CustNum) as total3
				from st_Master_Survey_answer w left join st_user u 
				on w.Createby = u.User_id left join st_user_group_dc dc
				on u.dc_groupid = dc.dc_groupid left join st_Master_Survey_detail Md
				on w.SurveyID = Md.SurveyID and w.Row= Md.Row
				where   w.Answer like '%$expArrays,$Type22%' and u.dc_groupid='$dc_groupids'  ";
				$sqlQty=sqlsrv_query($con,$sqlQty);
				$sqlQty=sqlsrv_fetch_array($sqlQty);
				echo '<td>'.number_format($sqlQty['total3']).'</td></tr>';
			}
	}
	}
	}
	?>
	
	</table><br>
<? } ?>


</body>
</html>