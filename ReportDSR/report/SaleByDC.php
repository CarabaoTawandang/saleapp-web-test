<?include("../includes/config.php");

$value=$_POST['value'];


?>
<option value=' '>- เลือกพนักงานขาย -</option>
<?
			$sqlDC="select userinfo_details.userid
,user_info.usernames
from userinfo_details left join user_info
on userinfo_details.userid=user_info.userid
where userinfo_details.dist_cd='$value'  and userinfo_details.userid like 'V%'
order by userinfo_details.userid asc";
	
	
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qryDC=sqlsrv_query($con,$sqlDC,$params,$options);
				$rowDC=sqlsrv_num_rows($qryDC);
				for($i=0;$i<$rowDC;$i+=1)
				{
				$reDC=sqlsrv_fetch_array($qryDC);
			?>
			<option value="<?print $reDC['userid']?>"><? print $reDC['userid']." ".$reDC['usernames'];?></option>
					
				<?
				
			
				}	
				
				
				
				?>
				