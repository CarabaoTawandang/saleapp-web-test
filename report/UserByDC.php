<?include("../includes/config.php");

			$value=$_POST['value'];
			
			

?>
<?			
	
			$sql3="select User_id,User_name,name,surname,Salecode
			from st_user where dc_groupid='$value' order by st_user.Salecode asc ";
				
				$qry3=sqlsrv_query($con,$sql3,$params,$options);
				$row3=sqlsrv_num_rows($qry3);
				if($row3>0){echo "<option value=''>-All-</option>";}
				else if($row3<=0){echo "<option value=''>-ไม่มี User-</option>";}
				for($i=0;$i<$row3;$i+=1)
				{
				$detail3=sqlsrv_fetch_array($qry3);
			?>
			<option value="<?print $detail3['User_id']?>"><?print $detail3['Salecode']." ".$detail3['name']." ".$detail3['surname']  ?></option>
					
				<?
				
			
				}	
				
				
				
				?>