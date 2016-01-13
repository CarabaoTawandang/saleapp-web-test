
<?include("../includes/config.php");

			$value=$_POST['value'];
			$sql="SELECT dc_groupid FROM st_user where User_id='$value' ";
			
			$qry=sqlsrv_query($con,$sql);
			$de=sqlsrv_fetch_array($qry);
			
			

?>
<?			
	
			$sql3="SELECT Plan_id ,Plan_name FROM st_Master_plan where DC_id ='$de[dc_groupid]' 
			and st_Master_plan.Plan_status is null 
			order by Plan_name asc  ";
				
				$qry3=sqlsrv_query($con,$sql3,$params,$options);
				$row3=sqlsrv_num_rows($qry3);
				if($row3>0){echo "<option value=''>- เลือกแผน-</option>";}
				else if($row3<=0){echo "<option value=''>-ไม่มีแผน-</option>";}
				for($i=0;$i<$row3;$i+=1)
				{
				$detail3=sqlsrv_fetch_array($qry3);
			?>
			<option value="<?print $detail3['Plan_id']?>"><?print $detail3['Plan_name']   ?></option>
					
				<?
				
			
				}	
				
				
				
				?>