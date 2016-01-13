<?//---------------------------------แก้ไข โดย pong 26/10/2015-------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#save').button();
		$('#cancel').button();
		

    $("input[name^='telNo_']").keyup(function(event){  
        if(event.keyCode==8){  
            if($(this).val().length==0){  
                $(this).prev("input").focus();    
            }  
            return false;  
        }             
        if($(this).val().length==$(this).attr("maxLength")){  
            $(this).next("input").focus();  
        }  
    });   


    $("input[name^='sim_']").keyup(function(event){  
        if(event.keyCode==8){  
            if($(this).val().length==0){  
                $(this).prev("input").focus();    
            }  
            return false;  
        }             
        if($(this).val().length==$(this).attr("maxLength")){  
            $(this).next("input").focus();  
        }  
    });   


		
		
				});//function	
</script>
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>เพิ่มหมายเลขโทรศัพท์</h3>
            
          <p>
		
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_Tel" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>Sim No.</B></td><td>
	<input  type="text" id="sim_1" name="sim_1" maxlength="6" style="width:55px;text-align:center;" required/>
	- 
	<input  type="text" id="sim_2" name="sim_2" maxlength="4" style="width:40px;text-align:center;" required/> 
	-
	<input  type="text" id="sim_3" name="sim_3" maxlength="4" style="width:40px;text-align:center;" required/> 
	-
	<input  type="text" id="sim_4" name="sim_4" maxlength="4" style="width:40px;text-align:center;" required/> 
	-
	<input  type="text" id="sim_5" name="sim_5" maxlength="1" style="width:15px;text-align:center;" required/> 

&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td width="150"><B>เบอร์โทรศัพท์</B></td><td> 
	<input name="telNo_1" type="text" id="telNo_1" maxlength="3" style="width:35px;text-align:center;" onKeyUp="if(this.value*1!=this.value) this.value='' ;" required/>
	- 
	<input name="telNo_2" type="text" id="telNo_2" maxlength="3" style="width:35px;text-align:center;" onKeyUp="if(this.value*1!=this.value) this.value='' ;" required/> 
	-
	<input name="telNo_3" type="text" id="telNo_3" maxlength="4" style="width:40px;text-align:center;" onKeyUp="if(this.value*1!=this.value) this.value='' ;" required/> 
	
  &nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">
<input type="button" value="cancel" id="cancel" onclick="window.location='?page=from_asset#tabs-5';" ></tr>	
</table>
</form>
</div>
</div>
<div id="DivSave" ></div>
</body>
</html>