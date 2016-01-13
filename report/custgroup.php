<?include("../includes/config.php");

			echo$value=$_POST['value'];
			$sql="SELECT * FROM st_cust_group where cust_type_id='$value' ";
			$params = array();
			$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row3=sqlsrv_num_rows($qry);
			if($row3<=0){echo "<option value=''>- ไม่มีรูปแบบ-</option>";}
			else if($row3>0){echo "<option value=''>- เลือกรูปแบบ-</option>";}

?>

<?			
	
			
				
				for($i=0;$i<$row3;$i+=1)
				{
				$detail=sqlsrv_fetch_array($qry);
			?>
			<option value="<?print $detail['cust_group_id']?>"><?print $detail['cust_group_name']   ?></option>
					
				<?
				
			
				}	
				
				
				
				?>