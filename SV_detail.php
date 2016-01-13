
<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
	session_start();  //เปิดseeion	
	set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
	include("includes/config.php"); //connect database db.carabao.com
	date_default_timezone_set('Asia/Bangkok');
	
	/*header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=SV".date('Ymd').".xls"); 
	header("Content-Transfer-Encoding: binary");*/
	
$Sql1="select  cast(w.CreateDate as date ) as date , w.*
,u.Salecode,u.name,u.surname,u.dc_groupid,dc.dc_groupname
,Md.Question,Md.QuestionType
from st_Master_Survey_answer w left join st_user u 
on w.Createby = u.User_id left join st_user_group_dc dc
on u.dc_groupid = dc.dc_groupid left join st_Master_Survey_detail Md
on w.SurveyID = Md.SurveyID and w.Row= Md.Row
where u.dc_groupid='DC5800001' and cast(w.CreateDate as date ) like '2015-12%'

order by cast(w.CreateDate as date ) asc,
dc.dc_groupname desc,
u.Salecode asc,
w.custnum asc,
w.Row asc

";
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
<div align="center">ข้อมูลดิบตามใบSuevey แต่ละร้านแบบละเอียด</div>

	<table  align="center" border='1' >
	<tr>
	<th align="center"width="30px">ลำดับ</th>
	<th align="center"width="200px">วันที่</th>
	<th align="center"width="100px">Salecode</th>
	<th align="center"width="100px">ขาย</th>
	
	
	<th align="center"width="200px">ร้านค้า</th>
	<th align="center"width="50px">ข้อ</th>
	<th align="center"width="250px">คำถาม</th>
	<th align="center"width="200px">ถามย่อย</th>
	<th align="center"width="200px">ตอบ</th>
	<th align="center"width="200px">DC</th>
	
	</tr>
	<? 	$Sql1=sqlsrv_query($con,$Sql1); $r=1;
		while($fil=sqlsrv_fetch_array($Sql1)){
			
	?>
	<tr class="mousechange" bgcolor="#00FFBF">
	<td><?
	if($fil['CustNum'] <> $CheckCustNum)
	{ echo $r; $r++; }
	
	?></td>
	<td><?echo date_format($fil['date'],'d-m-Y'); ?></td>
	<td><?echo $fil['Salecode'];?></td>
	<td><?echo $fil['name']."".$fil['surname'];?></td>
	<td><? $fil['CustNum'];
		$CheckCustNum= $fil['CustNum'];
		$sqlCust="select CustName from st_View_cust_web where CustNum ='$fil[CustNum]'";
		$sqlCust=sqlsrv_query($con,$sqlCust);
		$sqlCust=sqlsrv_fetch_array($sqlCust);
		echo $sqlCust['CustName'];
		
	?></td>
	<td><?=$fil['Row'];?></td>
	<td><? if($fil['QuestionType']=="อื่นๆ" or $fil['QuestionType']=="อื่นๆ2")
	{ echo $fil['Question']; }else 
	{ $QuestionType =  $fil['QuestionType']; 
		$sql2="select prd_type_nm from st_item_type where prd_type_id ='$QuestionType'";
		$sql2=sqlsrv_query($con,$sql2);
		$sql2=sqlsrv_fetch_array($sql2);
		echo $sql2['prd_type_nm'];
	}
	?></td>
	<td>
	
	</td>
	<td>
	<?
		$expArray = explode("#",$fil['Answer']);
		if(!$expArray[1]){echo $fil['Answer'];}
		
	?>
	</td>
	<td><? if($fil['dc_groupname']){echo " ".$fil['dc_groupname'];}?></td>
	</tr>
	
	<?
		$expArray = explode("#",$fil['Answer']);	
		if($expArray[0])	
		{foreach($expArray as $expArrays){
				//echo '<br>'.$expArrays;
				$expArray2 = explode(",",$expArrays);
				$idSv= trim($expArray2[0]);
				$sql3="select PRODUCTNAME from st_item_product where P_Code ='$idSv'";
				$sql3=sqlsrv_query($con,$sql3);
				$sql3=sqlsrv_fetch_array($sql3);
				echo "<tr><td colspan='7'><td>".$sql3['PRODUCTNAME']."</td>";
				echo "<td> ".trim($expArray2[1])."</td><td></td></tr>";
				
			}
		}
		else
		{
		 echo '<td></td>';
		}
	}//while
	?>
	</table>



</body>
</html>