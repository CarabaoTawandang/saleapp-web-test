<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสUser
$value=$_POST['value'];
			$params = array();
			$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			

?>
<option value=''>- Select* -</option>
<?
			$sql3="select st_user.User_id,st_user.dc_groupid
				,st_user_group_dc_detail.dc_GeoId    as GEO_CODE
				,dc_geography.GEO_NAME
				,st_user_group_dc_detail.dc_ProId as PROVINCE_CODE
				,dc_province.PROVINCE_NAME
				,st_user_group_dc_detail.dc_ampId as AMPHUR_CODE
				,dc_amphur.AMPHUR_NAME

				from st_user left join st_user_group_dc_detail
				on st_user.dc_groupid =st_user_group_dc_detail.dc_groupid  left join  dc_geography
				on st_user_group_dc_detail.dc_GeoId = dc_geography.GEO_CODE left join dc_province
				on st_user_group_dc_detail.dc_ProId = dc_province.PROVINCE_CODE left join dc_amphur
				on st_user_group_dc_detail.dc_ampId =dc_amphur.AMPHUR_CODE
				 
				where st_user.User_id='$USER_id'
				and PROVINCE_CODE ='$value'

				group by  st_user.User_id,st_user.dc_groupid
				,st_user_group_dc_detail.dc_GeoId
				,dc_geography.GEO_NAME
				,st_user_group_dc_detail.dc_ProId
				,dc_province.PROVINCE_NAME
				,st_user_group_dc_detail.dc_ampId
				,dc_amphur.AMPHUR_NAME
				order by dc_amphur.AMPHUR_NAME asc";
	
	
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry3=sqlsrv_query($con,$sql3,$params,$options);
				$row3=sqlsrv_num_rows($qry3);
				for($i=0;$i<$row3;$i+=1)
				{
				$detail3=sqlsrv_fetch_array($qry3);
			?>
			<option value="<?print $detail3['AMPHUR_CODE']?>"><?print $detail3['AMPHUR_NAME']   ?></option>
					
				<?
				
			
				}	
				
				
				
				?>
				
