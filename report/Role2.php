<?include("../includes/config.php");

$value=$_POST['value'];


?>

<?
			$sql3="SELECT RoleID,RoleName_Linename,RoleID_Lineid FROM st_user_rolemaster_detail where RoleID='$value' order by RoleName_Linename asc  ";
	
	
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry3=sqlsrv_query($con,$sql3,$params,$options);
				$row3=sqlsrv_num_rows($qry3);
				if($row3>0){echo "<option value=''>- เลือกตำแหน่ง -</option>";}
				else if($row3<=0){echo "<option value=''>- ไม่มีตำแหน่ง -</option>";}
				
				for($i=0;$i<$row3;$i+=1)
				{
				$detail3=sqlsrv_fetch_array($qry3);
				
			?>
			
			<option value="<?print $detail3['RoleID_Lineid']?>"><?print $detail3['RoleName_Linename']   ?></option>
					
				<?
				
			
				}	
				
				
				
				?>