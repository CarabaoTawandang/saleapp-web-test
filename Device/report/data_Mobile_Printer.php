<?
//------------------------------------------------------โดย PONG 14/10/2015-------------------
session_start();
set_time_limit(0);
include("../../includes/config.php");

$txt_id1 =$_POST['txt_id1'];
$count1 =$_POST['count1'];
$txt_all1=$_POST['txt_all1'];
if($txt_all1){
$sql="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY CreateDate) AS
rownum,Serial_No,Manufacturer,Model,Warranty,PO_No,user_type,Mac
,Supplier,Assign_to_User,UpdateDate,CreateDate,Receive_date,Status
FROM st_Device_Mobile_Printer) AS Table1  ";
}else {
$sql="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY CreateDate) AS
rownum,Serial_No,Manufacturer,Model,Warranty,PO_No,user_type,Mac
,Supplier,Assign_to_User,UpdateDate,CreateDate,Receive_date,Status
FROM st_Device_Mobile_Printer where Mac like '%$txt_id1%') AS Table1  ";
}

$result=sqlsrv_query($con,$sql,$params,$options);
$num_rows=sqlsrv_num_rows($result);
?>


<html>
<body>
<?if($num_rows==0){echo"<p align='center'><b>----------ไม่พบข้อมูล------------</b></p>";}else{	?>
<table cellpadding="0" cellspacing="0"  border="0" align="left"  class="box" width="1200px">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0" BORDERCOLOR="#FF9933" border="1" align="left"  width="1200px">
	<tr bgcolor="#FFCC99">
	<td align="center"><font size="2">ลำดับ</font></td>
	
	<td align="center"><font size="2">Mac</font></td>
	<td align="center"><font size="2">Serial No.</font></td>
	
	<td align="center"><font size="2">ยี่ห้อ</font></td>
	<td align="center"><font size="2">Model</font></td>
	<td align="center"><font size="2">รับประกัน</font></td>
	<td align="center"><font size="2">วันที่รับของ</font></td>
	<td align="center"><font size="2">ดูแลโดย</font></td>
	<td align="center"><font size="2">DC</font></td>
	<td align="center"><font size="2">สถานะ</font></td>
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



$per_page = $count1;

$P=$per_page;
if(!$page_)

	if($_POST['do1']=="NOW")
	{
	$page__1=$_POST['page__1'];
	$page_=$page__1;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do1']=="NEXT")
	{
	$page__1=$_POST['page__1'];
	$page_=$page__1+1;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do1']=="BEFORE")
	{
	$page__1=$_POST['page__1'];
	$page_=$page__1-1;
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
	
if($txt_all1){	
$sql_="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY CreateDate) AS
rownum,Serial_No,Manufacturer,Model,Warranty,PO_No,user_type,Mac
,Supplier,Assign_to_User,UpdateDate,CreateDate,Receive_date,Status
FROM st_Device_Mobile_Printer) AS Table1
WHERE rownum >= $page_start AND rownum <= $P ";
}else{
$sql_="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY CreateDate) AS
rownum,Serial_No,Manufacturer,Model,Warranty,PO_No,user_type,Mac
,Supplier,Assign_to_User,UpdateDate,CreateDate,Receive_date,Status
FROM st_Device_Mobile_Printer where Mac like '%$txt_id1%') AS Table1
WHERE rownum >= $page_start AND rownum <= $P ";
}

$result_=sqlsrv_query($con,$sql_,$params,$options);


while ($re = sqlsrv_fetch_array($result_)){?>
	
	<tr bgcolor="<?=$col;?>" height="30">
	<td align="left"><font size="2">&nbsp;<?=$re['rownum']; ?></font></td>
	
	<td align="left"><font size="2">&nbsp;<?=$re['Mac']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Serial_No']; ?></font></td>
	
	<td align="left"><font size="2">&nbsp;<?=$re['Manufacturer']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Model']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Warranty']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Receive_date'];?></font></td>

<?
		$ST=" select *from st_user where Pinter_no ='$re[Mac]'  ";
		$ST=sqlsrv_query($con,$ST,$params,$options);
		$ST=sqlsrv_fetch_array($ST);
		$DC_="select * from st_user_group_dc where dc_groupid ='$ST[dc_groupid]'  ";
		$DC_=sqlsrv_query($con,$DC_,$params,$options);
		$DC_=sqlsrv_fetch_array($DC_);		
		$_USER="select * from st_user where User_id ='$ST[User_id]'  ";
		$_USER=sqlsrv_query($con,$_USER,$params,$options);
		$_USER=sqlsrv_fetch_array($_USER);?>
	<td align="left"><font size="2">&nbsp;<?=$_USER['name'];?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$DC_['dc_groupname'];?></font></td>
		<td align="left"><font size="2">&nbsp;<?=$re['Status'];?></font></td>
	<td align="center">
		<a href="?page=edit_Mobile_Printer&id=<?=$re['Mac'];?>"  >
		<img src=".././images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>


	
	<? 
	}	?>
	
	</table><tr><td>
จำนวนรายการทั้งหมด:<b><?echo $num_rows;?></b>&nbsp;&nbsp;หน้าทั้งหมด:<b><?echo $num_pages?></b>
<div id="container">
	<div class="pagination">
<?
if($prev_page)
	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do1=BEFORE&page__1=$page_&S1=$txt_id&C1=$count1&A1=$txt_all1#tabs-2\">กลับไป&nbsp;</a>";
	
for($i=1;$i<=$num_pages;$i++)
{
if($i!=$page_)
	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do1=NOW&page__1=$i&S1=$txt_id&C1=$count1&A1=$txt_all1#tabs-2\">$i</a>";
	
	else
	echo"<b class='page active'>$i</b>";
	}
if($page_!=$num_pages)

	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do1=NEXT&page__1=$page_&S1=$txt_id&C1=$count1&A1=$txt_all1#tabs-2\">&nbsp;หน้าต่อไป</a>";
?></div></div>

<?}?></tr></td>

		</table>
</td></tr>
</table>
</body>
</html>

