<?
//------------------------------------------------------โดย PONG 14/10/2015-------------------
session_start();
set_time_limit(0);
include("../../includes/config.php");

$Tel =$_POST['Tel'];
$sim=$_POST['sim'];
$text_all=$_POST['text_all'];
$number =$_POST['number'];
$per_page =$number;
if($text_all){
$sql="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY phone_no desc) AS
rownum,phone_no,sim_id FROM st_Device_PhoneSim where sim_id is not null)AS Table1 "; 
}else {
$sql="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY phone_no desc) AS
rownum,phone_no,sim_id FROM st_Device_PhoneSim 
where sim_id like '%$sim%' and phone_no like '%$Tel%' and sim_id is not null)AS Table1 "; 
}
$result=sqlsrv_query($con,$sql,$params,$options);
$num_rows=sqlsrv_num_rows($result);
?>
<html>
<body>
<?if($num_rows==0){echo"<p align='center'><b>----------ไม่พบข้อมูล------------</b></p>";}else{	?>
<table cellpadding="0" cellspacing="0"  border="0" align="left"  class="box" width="1050px">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0" BORDERCOLOR="#FF9933" border="1" align="center"  width="450px">
	<tr bgcolor="#FFCC99">
	<td align="center"><font size="2">ลำดับ</font></td>
	<td align="center"><font size="2">Serial Sim.</font></td>
	<td align="center"><font size="2">Sim No.</font></td>	

	<!--<td align="center"><font size="2">IMEI Tablet</font></td>
	<td align="center"><font size="2">User</font></td>
	<td align="center"><font size="2">DC</font></td>-->
	<td align="center"><font size="2">แก้ไข</font></td>
	</tr>
<style type="text/css">	
#container {
    width: 0 auto;
    margin: 0 auto;
    padding: 0px;

}

.pagination {
    background: #f2f2f2;
    padding: 20px;
    margin-bottom: 20px;
}

.page {
    display: inline-block;
    padding: 0px 9px;
    margin-right: 4px;
    border-radius: 3px;
    border: solid 1px #c0c0c0;
    background: #e9e9e9;
    box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
}

</style> 
<?

$P=$per_page;
if(!$page_)

	if($_POST['do4']=="NOW")
	{
	$page__4=$_POST['page__4'];
	$page_=$page__4;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do4']=="NEXT")
	{
	$page__4=$_POST['page__4'];
	$page_=$page__4+1;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do4']=="BEFORE")
	{
	$page__4=$_POST['page__4'];
	$page_=$page__4-1;
	$P=$per_page*$page_;

	}
	else{	
	$page_=1;
	
	}
	$prev_page=$page_-1;
	$next_page=$page_+1;

	$page_start=($per_page*$page_)-$per_page+1;
	
if($num_rows<=$per_page)
	$num_pages=1;
else if(($num_rows%$per_page)==0)
	$num_pages=($num_rows/$per_page);
else
	$num_pages=($num_rows/$per_page)+1;
	$num_pages=(int)$num_pages;

if(($page_>$num_pages)||($page_<0))
	echo"จำนวนรายการ เท่ากับ 0 รายการ";
	
	

if($text_all){
$sql_="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY phone_no desc) AS
rownum,phone_no,sim_id FROM st_Device_PhoneSim where sim_id is not null )AS Table1 
where rownum >= $page_start AND rownum <= $P "; 
}else {
$sql_="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY phone_no desc) AS
rownum,phone_no,sim_id FROM st_Device_PhoneSim 
where sim_id like '%$sim%' and phone_no like '%$Tel%' and sim_id is not null)AS Table1 
where rownum >= $page_start AND rownum <= $P "; 
}
$result_=sqlsrv_query($con,$sql_,$params,$options);


while ($re = sqlsrv_fetch_array($result_))
	{{ $col="#FFFFCC";}
	
	if($re['sim_id']==''){$ID_SS='0';}else{$ID_SS=$re['sim_id'];}
	
	$IM="select imei from st_device_tablet_detail where sim_id ='$ID_SS'  ";
	$IM= sqlsrv_query($con,$IM,$params,$options);
	$IM=sqlsrv_fetch_array($IM);
	
	if($IM['imei']==''){$ID_MM='0';}else{$ID_MM=$IM['imei'];}
	
	$UU="select name,dc_groupid from st_user where talet_no_imei='$ID_MM'  ";
	$UU= sqlsrv_query($con,$UU,$params,$options);
	$UU=sqlsrv_fetch_array($UU);
	
	$DC="select dc_groupname from st_user_group_dc where dc_groupid='$UU[dc_groupid]'  ";
	$DC= sqlsrv_query($con,$DC,$params,$options);
	$DC=sqlsrv_fetch_array($DC);
	
?>
	
	<tr bgcolor="<?=$col;?>" height="30">
	<td align="left"><font size="2">&nbsp;<?=$re['rownum']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['sim_id']; ?></font></td>	
	<td align="left"><font size="2">&nbsp;<?=$re['phone_no'];?></font></td>
	
	<!--<td align="left"><font size="2">&nbsp;<?=$IM['imei']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$UU['name']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$DC['dc_groupname']; ?></font></td>-->
	<td align="center">
		<a href="?page=edit_Tel&id=<?=$re['sim_id'];?>"  >
		<img src=".././images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	
	<? 
	}	
	?>

		</table><tr><td align="center">
จำนวนรายการทั้งหมด:<b><?echo $num_rows;?></b>&nbsp;&nbsp;หน้าทั้งหมด:<b><?echo $num_pages?></b>
<div id="container" align="center">
	<div class="pagination" >
<?
if($prev_page)
	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do4=BEFORE&page__4=$page_&T=$Tel&SS=$sim&N=$number&T_all=$text_all#tabs-5\">กลับไป&nbsp;</a>";
	
for($i=1;$i<=$num_pages;$i++)
{
if($i!=$page_)
	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do4=NOW&page__4=$i&T=$Tel&SS=$sim&N=$number&T_all=$text_all#tabs-5\">$i</a>";
	
	else
	echo"<b class='page active'>$i</b>";
	}
if($page_!=$num_pages)

	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do4=NEXT&page__4=$page_&T=$Tel&SS=$sim&N=$number&T_all=$text_all#tabs-5\">&nbsp;หน้าต่อไป</a>";
?></div></div>

<?}?></td></tr>


</td>
</tr>
</table>
</body>
</html>