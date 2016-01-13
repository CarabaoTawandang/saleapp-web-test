
<?//------------------------------------------------------แก้ไข โดย phung 10/09/2015------------------------------------
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ




	$array_id = $_POST['array_id'];
	$array_id2 = $_POST['array_id2'];
	$array_id22 = $_POST['array_id22'];
	$array_id3 = $_POST['array_id3'];
	$array_id4 = $_POST['array_id4'];
	$array_detail = $_POST['array_detail'];
	$array_img = $_POST['array_img'];
	
	/*$a = $_POST["array_id2"];
	foreach($a as $key => $value){
			
        foreach($value as $key_sub => $value_sub){
			echo "<br>";
			echo "[".$key."][".$key_sub."]";
            echo $a[$key][$key_sub]. "\n";
        }
        echo '<br>------------------------- ';
    }*/
	
	/*echo '  ** '.$txtDC = $_POST['txtDC'];	
	foreach ($txtDC as $txtDCs=>$txtDC) 
	{   $txtDC; 
		echo '<br> == '.$SQLIn1="insert into st_message_new_detail 
		([Code],[RoleID_Lineid])values
		('$id_new','$txtDC')";
		$QryIn1 =sqlsrv_query($con,$SQLIn1,$params,$options);
	}
	
	
	
	$txtDC = $_POST['txtDC'];
foreach ($txtDC as $txtDCs=>$txtDC) 
	{   $txtDC; 
		
	$SQLIn3="insert into st_message_new_detail_dc 
		([Code],[DC_id])values
		('$id_new','$txtDC')";
	$QryIn3 =sqlsrv_query($con,$SQLIn3,$params,$options);
	}	
	
	*/
	
	$txt_planName =trim($_POST['txt_planName']); //แผน
$txt_remark =trim($_POST['txt_remark']); //หมายเหตุ
$txt_COMPANY =trim($_POST['txt_COMPANY']); //บริษัท			
$sqlMax="select SUBSTRING(max(SurveyID),7,5) as MaxID from st_Master_Survey
where   SUBSTRING(SurveyID,4,2) ='$year'";
$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
$reMax=sqlsrv_fetch_array($qryMax);
$MaxID=$reMax['MaxID']; 
$MaxID= $MaxID+1;
$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
$MaxID ="SV-".$year."-".$MaxID ; //----------------------ID CODE 58-DC5800001-0001 
if($_POST['txt_day']){ $txt_day=$_POST['txt_day'];}else{ $txt_day=date('Y-m-d');}
if($_POST['txt_day1']){ $txt_day1=$_POST['txt_day1'];}else{ $txt_day1=date('Y-m-d');}
$AddH="insert into st_Master_Survey
			(SurveyID,SurveyName,SurveyDate,Createby,Updateby,CreateDate,UpdateDate,COMPANYCODE,Remark,SurveyDateEnd)values
			('$MaxID','$txt_planName','$txt_day','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','$txt_remark','$txt_day1')";	
$AddH=sqlsrv_query($con,$AddH);
	$a=0; $t=1; //$Question='';
	 foreach($array_id as $array_ids)
	{	
		$QuestionType =trim($array_ids);
		IF(($array_id22[$a]!="") && ($array_id22[$a]!='undefined')){ $Question = $array_id22[$a];}
		for($b=0;$array_id2[$a][$b]<>'';$b++)
				{	
					//echo "<br>";
					//echo "[".$a."][".$b."] == ";
					$Q =$array_id2[$a][$b];
					$Question=$Question." # ".$Q;
					
					
				}
		
			$AnswerType  =$array_id3[$a];//echo " <br>ประเภท   ".$type[$a];
			$Answer = $array_id4[$a]; //echo "  <br> ตอบ   ".$Answer[$a];
			$detail = $array_detail[$a];
			$ViewImg =$array_img[$a]; 
			if(($ViewImg=="") || ($ViewImg=='undefined')){   $ViewImg='';}else{  $ViewImg='YES'; } 
		$AddDetail="insert into st_Master_Survey_detail
			(SurveyID,Row,QuestionType,Question,AnswerType,Answer,detail,Pic)values
			('$MaxID','$t','$QuestionType','$Question','$AnswerType','$Answer','$detail','$ViewImg')";	
		$AddDetail=sqlsrv_query($con,$AddDetail);

	$t++;$a++; $Question="";}
	
	
	
		
	
	
	if($AddH)
	{
			echo'<script type="text/javascript">';
			echo'alert("สร้าง From Surveyเรียบร้อยแล้วคะ");';
			echo "window.location='?page=from_Survey';";
			//echo "window.location='?page=showDetailPlan&id=".$MaxID."';";
			echo '</script>';
	}
	else 
	{
			echo'<script type="text/javascript">';
			echo'alert("ไม่สำเร็จ");';
			
			echo '</script>';
	}
	
?>

