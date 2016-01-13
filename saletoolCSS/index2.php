<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
	session_start();  //เปิดseeion	
	set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
	include("includes/config.php"); //connect database db.carabao.com
	ini_set('session.gc_maxlifetime', 3600); //การกำหนดค่า Session Timeout
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WEB SaleApp</title>
<link href="css2/css.css" rel="stylesheet" type="text/css">
 <script src="css2/ddmenu.js" type="text/javascript"></script>
</head>

<body>

	
<header></header>

<?php include 'header.php'; ?>
           <Br>   <Br>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>รายชื่อพนักงาน</h3>
            
          <p>พนักงาน Operation</p>
  
            
    </div>
        
    <div class="sep"></div>

      <table width="100%" align="center" class="tables">
  <thead>
    <tr>
      <th width="2"> ลำดับ</th>
      <th>ชื่อ</th>
      <th>นามสกุล</th>
      <th width="1">&nbsp;</th>
      <th width="1">&nbsp;</th>
    </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tr>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td > <a href="#" class="myButton_form">แก้ไข</a></td>
    <td > <a href="#" class="myButton_form">ลบ</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</div></div>

<br>
<div id="show">
<?
$page = $_GET['page'];
	
	switch($page)
	
	{			
	
				case "add_amuphur";
				include "report/add_amuphur.php";
				break;
				
				case "add_district";
				include "report/add_district.php";
				break;
				
				case "add_DC";
				include "report/add_DC.php";
				break;
				
				case "add_DC2";
				include "report/add_DC2.php";
				break;
				
				case "add_DC3";
				include "report/add_DC3.php";
				break;
				
				case "New_DC";
				include "report/New_DC.php";
				break;
				
				case "add_user";
				include "report/add_user.php";
				break;
				
				case "add_CustInDC";
				include "report/add_CustInDC.php";
				break;
				
				//rolemaster
				case "add_rolemaster";
				include "report/add_rolemaster.php";
				break;
				
				case "save_rolemaster";
				include "report/save_rolemaster.php";
				break;
				
				//rolemaster2
				case "add_rolemaster2";
				include "report/add_rolemaster2.php";
				break;
				
				case "save_rolemaster2";
				include "report/save_rolemaster2.php";
				break;
				
				//warehouse_location
				case "add_warehouse_location";
				include "report/add_warehouse_location.php";
				break;
				
				case "save_warehouse_location";
				include "report/save_warehouse_location.php";
				break;
				
				case "data_warehouse_location";
				include "report/data_warehouse_location.php";
				break;
				
				case "edit_warehouse_location";
				include "report/edit_warehouse_location.php";
				break;
				
				//warehouse_stock
				case "add_warehouse_stock";
				include "report/add_warehouse_stock.php";
				break;
				
				case "save_warehouse_stock";
				include "report/save_warehouse_stock.php";
				break;
				
				case "data_warehouse_stock";
				include "report/data_warehouse_stock.php";
				break;
				
				case "add_receive_head";
				include "report/add_receive_head.php";
				break;
				
				case "save_receive_head";
				include "report/save_receive_head.php";
				break;
				
				case "data_rolemaster2";
				include "report/data_rolemaster2.php";
				break;
				
				case "data_rolemaster";
				include "report/data_rolemaster.php";
				break;
				
				case "data_DC";
				include "report/data_DC.php";
				break;
				
				case "data_user";
				include "report/data_user.php";
				break;
				
				case "from_cust";
				include "report/from_cust.php";
				break;
				
				case "data_receive_head";
				include "report/data_receive_head.php";
				break;
				
				case "stockTotal";
				include "report/stockTotal.php";
				break;
				
				//บันทึกจ่ายของเข้ารถ
				case "add_picking_head";
				include "report/add_picking_head.php";
				break;
				
			
	}
	
		

	?>
</div>
<table width="80%" align="center">
  <thead>
    <tr>
      <th width="2"> <a href="#" class="myButton_number">หน้า 1 จาก 3</a> <a href="#" class="myButton_number"> 1 </a><a href="#" class="myButton_number"> 2</a><a href="#" class="myButton_number">3</a></th>
    </tr>
  </thead>
  <tfoot>
  </tfoot>
</table>
<br><br>
<?php include 'footer.php'; ?>
</body>
</html>
