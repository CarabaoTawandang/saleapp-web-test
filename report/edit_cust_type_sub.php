<?
//------------------------------------------------------แก้ไข โดย PONG 02/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id				=	$_SESSION["USER_id"];	
		$id=$_GET['id'];
		

		$sqlOpen="select *from st_cust_group where cust_group_id='$id'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$re=sqlsrv_fetch_array($qryOpen);
		
		$opent1="select [cust_type_id] from [st_cust_group] where [cust_group_id]='$id' ";
		$opent1 =sqlsrv_query($con,$opent1,$params,$options);
		$op1=sqlsrv_fetch_array($opent1);
		
		$sql1="SELECT cust_type_name,cust_type_id from st_cust_type where cust_type_id='$op1[cust_type_id]' ";
		$sql1=sqlsrv_query($con,$sql1,$params,$options);
		$kk=sqlsrv_fetch_array($sql1);
			
			

?>

<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
	});//function	
</script>
<script type="text/javascript">
$(function(){	
			
		$('#save').button();
	
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
		
		
		});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>แก้ไขรูปแบบร้านค้า&nbsp;<?=$id;?></h3><!---หัวเรื่องหลัก-->
           <p><!---หัวเรื่องรอง-->
		  		  <input type="button" value="ค้นหาประเภทร้านค้า" id="btn_add" onclick="window.location='?page=from_cust_type';" align="center" class="inner_position_right" >
	</p>
	</div><div class="sep"></div><br>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" action="?page=save_cust_type_sub&do=edit" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"  ><div class="h_head"> 
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ประเภทร้านค้า</B></td><td>
	<input type="hidden" id="id_" name="id_" value="<?=$id;?>" style="width:50px;"readonly >
	<select id="txt_cust" name="txt_CUST"  style="width:170px;" required/>
	<option value="<?=$kk['cust_type_id'];?>" ><?=$kk['cust_type_name'];?></option>
	
	<?	$sql="SELECT cust_type_id,cust_type_name  FROM st_cust_type";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

			?>
			
	
			<option value="<?print $detail['cust_type_id']?>" ><?print $detail['cust_type_name']?></option>
		
			<?
			}

		
	
	?>
	</select>&nbsp;<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="180"><B>ชื่อรูปแบบร้านค้า</td><td><input type="text" value="<?=$re['cust_group_name'];?>" id="name_" name="name_" style="width:300px;" required/>
&nbsp;<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td><B>บริษัท</B></td><td>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
	<?$company="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp where COMPANYCODE='$re[COMPANYCODE]' ";
		$company=sqlsrv_query($con,$company,$params,$options);
		$company=sqlsrv_fetch_array($company);?>
	<option value="<?=$re['COMPANYCODE'];?>" > **<?=$company['COMPANYNAME'];?>** </option>
	<?	$sql="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['COMPANYCODE']?>" ><?print $detail['COMPANYNAME']?></option>
		
			<?
			}

		
	
	?>
	</select>&nbsp;<B style="color:red;text-align:center;">*</B>
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>


<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">			</tr>	
</table>
</form>
</div> <!--/-box-->
</div> <!--/-container_box-->
<div id="DivSave" ></div>
</body>
</html>