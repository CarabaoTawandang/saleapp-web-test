
<? 
include("../includes/config.php");
 $values=$_POST['txtSearch'];
$sql="select dc_groupid,dc_groupname from st_user_group_dc where dc_groupid like '%$values%' or dc_groupname like '%$values%'";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			
?>
<select id="txt_DC" name="txt_DC"   style="width:300px;background:#FFFFCC;">

<? if($row>0){echo"<option value=''>- เลือกDC -</option>";}else{echo"<option value=''>- ไม่มีDC -</option>";}
			
				for($i=0;$i<$row;$i+=1)
				{
				$detail3=sqlsrv_fetch_array($qry);
			?>
			<option value="<?print $detail3['dc_groupid']?>"><?print $detail3['dc_groupname']   ?></option>
					
				<?
				
			
				}	
				
				
			
				?>
				</select>