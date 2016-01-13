
<?
$page = $_GET['page'];
	
	switch($page)
	
	{			
				case "from_asset";
				include "report/from_asset.php";
				break;
				
				case "add_Tablet";
				include "report/add_Tablet.php";
				break;
				
				case "add_Mobile_Printer";
				include "report/add_Mobile_Printer.php";
				break;
				
				case "save_Tablet";
				include "report/save_Tablet.php";
				break;
				
				case "save_Mobile_Printer";
				include "report/save_Mobile_Printer.php";
				break;
				
				case "edit_Tablet";
				include "report/edit_Tablet.php";
				break;
				
				case "edit_Mobile_Printer";
				include "report/edit_Mobile_Printer.php";
				break;
				//-------------------------------------1.12 การซ่อมบำรุง by N'pong+dream
				
				case "from_Maintenance";
				include "report/from_Maintenance.php";
				break;
				
				case "add_Maintenance";
				include "report/add_Maintenance.php";
				break;
				
				case "save_Maintenance";
				include "report/save_Maintenance.php";
				break;
				
				case "edit_Maintenance";
				include "report/edit_Maintenance.php";
				break;
				
				//----------------------------------------------ตัวเสริม
				case "add_Maintenance_for_edit_tablet";
				include "report/add_Maintenance_for_edit_tablet.php";
				break;
				
				case "save_Maintenance_for_edit_tablet";
				include "report/save_Maintenance_for_edit_tablet.php";
				break;
				
				case "edit_Maintenance_for_edit_tablet";
				include "report/edit_Maintenance_for_edit_tablet.php";
				break;
				
				case "add_Maintenance_for_edit_Mobile_Printer";
				include "report/add_Maintenance_for_edit_Mobile_Printer.php";
				break;
				
				case "save_Maintenance_for_edit_Mobile_Printer";
				include "report/save_Maintenance_for_edit_Mobile_Printer.php";
				break;
				
				case "edit_Maintenance_for_edit_Mobile_Printer";
				include "report/edit_Maintenance_for_edit_Mobile_Printer.php";
				break;
				//--------------tel
				case "add_Tel";
				include "report/add_Tel.php";
				break;
				
				case "save_Tel";
				include "report/save_Tel.php";
				break;
				
				case "edit_Tel";
				include "report/edit_Tel.php";
				break;
				
				//--------------tel
				case "from_report_asset";
				include "report/from_report_asset.php";
				break;
							
				
	}
	
		

	?>
	