
<?
$page = $_GET['page'];
	
	switch($page)
	
	{			
	
				//--------------------------------------ข่าว กราฟฟิกออกแบบมา by phung
				case "fromOriginal";
				include "report/fromOriginal.php";
				break;
				
				//--------------------------------user by phung
				case "from_user";
				include "report/from_user.php";
				break;
				
				case "data_user";
				include "report/data_user.php";
				break;
				
				case "add_user";
				include "report/add_user.php";
				break;
				
				case "save_user";
				include "report/save_user.php";
				break;
				
				case "add_lv_Detail";
				include "report/add_lv_Detail.php";
				break;
				
				case "edit_user";
				include "report/edit_user.php";
				break;
				//------------------------------------------------------------------อำเภอ by phung +N'pong
				case "from_amuphur";
				include "report/from_amuphur.php";
				break;
				
				case "add_amuphur";
				include "report/add_amuphur.php";
				break;
				
				case "save_amuphur";
				include "report/save_amuphur.php";
				break;
				
				case "edit_amuphur";
				include "report/edit_amuphur.php";
				break;
				
				
				
				//----------------------------------------------------------------ตำบล by phung + N'dream
				case "from_district";
				include "report/from_district.php";
				break;
				
				case "add_district";
				include "report/add_district.php";
				break;
				
				case "save_district";
				include "report/save_district.php";
				break;
				
				case "edit_district";
				include "report/edit_district.php";
				break;
				
				//----------------------------------DC by phung
				case "from_DC";
				include "report/from_DC.php";
				break;
		
				case "data_DC";
				include "report/data_DC.php";
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
				
				case "save_DC";
				include "save_DC.php";
				break;
				
				case "show_DC";
				include "report/show_DC.php";
				break;
				
				
				case "add_CustInDC";//-----------------------------------ร้านค้า  DC
				include "report/add_CustInDC.php";
				break;
				
				case "edit_DC";
				include "report/edit_DC.php";
				break;
				
				case "edit_DC2";
				include "report/edit_DC2.php";
				break;
				
				case "edit_DC3";
				include "report/edit_DC3.php";
				break;
				
				//-------------------------------------------------------------คลัง     by phung
				case "from_warehouse_location";
				include "report/from_warehouse_location.php";
				break;
				
				case "data_warehouse_location";
				include "report/data_warehouse_location.php";
				break;
				
				case "add_warehouse_location";
				include "report/add_warehouse_location.php";
				break;
				
				case "save_warehouse_location";
				include "report/save_warehouse_location.php";
				break;
				
				case "edit_warehouse_location";
				include "report/edit_warehouse_location.php";
				break;
				//-------------------------------------------------------------  ตำแหน่ง    by phung
				case "from_rolemaster";
				include "report/from_rolemaster.php";
				break;
				
				case "data_rolemaster";
				include "report/data_rolemaster.php";
				break;
				
				case "add_rolemaster";
				include "report/add_rolemaster.php";
				break;
				
				case "save_rolemaster";
				include "report/save_rolemaster.php";
				break;
				
				case "edit_rolemaster";
				include "report/edit_rolemaster.php";
				break;
				
				
				case "add_rolemaster2";
				include "report/add_rolemaster2.php";
				break;
				
				case "save_rolemaster2";
				include "report/save_rolemaster2.php";
				break;
				
				case "edit_rolemaster2";
				include "report/edit_rolemaster2.php";
				break;
				
				//-------------------------------------------------------------ประเภทร้าน-    --by N'pong+dream
				 case "from_cust_type";
				include "report/from_cust_type.php";
				break;
				
				case "data_cust_type";
				include "report/data_cust_type.php";
				break;
				
				case "add_cust_type_sub";
				include "report/add_cust_type_sub.php";
				break;
				
				case "add_cust_type_main";
				include "report/add_cust_type_main.php";
				break;
				
				case "save_cust_type_main";
				include "report/save_cust_type_main.php";
				break;
				
				case "save_cust_type_sub";
				include "report/save_cust_type_sub.php";
				break;
				
				case "edit_cust_type_main";
				include "report/edit_cust_type_main.php";
				break;
				
				case "edit_cust_type_sub";
				include "report/edit_cust_type_sub.php";
				break;
				
				//---------------------------------------------------------------------สินค้า       -by N'pong+dream
 
				case "from_item";
				include "report/from_item.php";
				break;

				
				case "data_from_item";
				include "report/data_from_item.php";
				break;
				
				case "add_item_type";
				include "report/add_item_type.php";
				break;
				
				case "add_item_product";
				include "report/add_item_product.php";
				break;
				
					case "save_item_type";
				include "report/save_item_type.php";
				break;
				
				case "edit_item_type";
				include "report/edit_item_type.php";
				break;
				
				case "edit_item_product";
				include "report/edit_item_product.php";
				break;

					case "save_item_product";
				include "report/save_item_product.php";
				break;
				
					case "data_item_group";
				include "report/data_item_group.php";
				break;
				
					case "data_item_unit";
				include "report/data_item_unit.php";
				break;
				
					case "add_item_group";
				include "report/add_item_group.php";
				break;
			
					case "add_item_unit";
				include "report/add_item_unit.php";
				break;
			
				case "edit_item_group";
				include "report/edit_item_group.php";
				break;
					
					case "edit_item_unit";
				include "report/edit_item_unit.php";
				break;
				
				
					case "save_item_unit";
				include "report/save_item_unit.php";
				break;
				
					case "save_item_group";
				include "report/save_item_group.php";
				break;
				
				
				
				case "add_unit_con";
				include "report/add_unit_con.php";
				break;
			
				case "edit_unit_con";
				include "report/edit_unit_con.php";
				break;
				
				case "data_unit_con";
				include "report/data_unit_con.php";
				break;
				
				case "save_unit_con";
				include "report/save_unit_con.php";
				break;
				
				case "add_unit_price";
				include "report/add_unit_price.php";
				break;
			
				case "edit_unit_price";
				include "report/edit_unit_price.php";
				break;
				
				case "data_unit_price";
				include "report/data_unit_price.php";
				break;
				
				case "save_unit_price";
				include "report/save_unit_price.php";
				break;


				
				//------------------------------------------------------------------- ข่าว     -by N'pong+dream
				case "from_new"; 
				include "report/from_new.php"; 
				break; 
								
				case "data_new"; 
				include "report/data_new.php"; 
				break; 
								
				case "add_new"; 
				include "report/add_new.php"; 
				break; 
								
				case "save_new"; 
				include "report/save_new.php"; 
				break; 
								
				case "edit_new"; 
				include "report/edit_new.php"; 
				break;

				//--------------------------------------------------------------   ร้านค้า by phung
				case "from_cust";
				include "report/from_cust.php";
				break;
				
				case "add_cust";
				include "report/add_cust.php";
				break;
				
				//------------------------------------------------------------- โปรโมชั่น               by N'pong+dream
				
				case "from_promotion";
				include "report/from_promotion.php";
				break;
				
				case "add_promotion";
				include "report/add_promotion.php";
				break;
				
				case "edit_promotion";
				include "report/edit_promotion.php";
				break;
				
				case "save_promotion";
				include "report/save_promotion.php";
				break;
				
				case "add_giveaway";
				include "report/add_giveaway.php";
				break;
				
				case "edit_giveaway";
				include "report/edit_giveaway.php";
				break;
				
				case "save_giveaway";
				include "report/save_giveaway.php";
				break;
			
				
				//-----------------------------------------stock   by phung
				case "stockBalance";
				include "report/stockBalance.php";
				break;
				
				case "from_receive_head";
				include "report/from_receive_head.php";
				break;
				
				case "data_receive_head";
				include "report/data_receive_head.php";
				break;
				
				case "add_receive_head";
				include "report/add_receive_head.php";
				break;
				
				case "save_receive_head";
				include "report/save_receive_head.php";
				break;
				
				case "edit_receive_head";
				include "report/edit_receive_head.php";
				break;
				
				
				
				//----------------------------------------------stock   by phung
				
				case "stoc_salekBalance";
				include "report/stoc_salekBalance.php";
				break;
				
				case "from_picking_head";
				include "report/from_picking_head.php";
				break;
				
				case "data_picking_head";
				include "report/data_picking_head.php";
				break;
				
				case "add_picking_head";
				include "report/add_picking_head.php";
				break;
				
				case "save_picking_head";
				include "report/save_picking_head.php";
				break;
				
				//------------------------------------------------------------------------------------วาง แผนเ 
				case "from_plan";
				include "report/from_plan.php";
				break;
				
				case "add_plan";
				include "report/add_plan.php";
				break;
				
				case "add_planMonth";
				include "report/add_planMonth.php";
				break;
				
				case "save_plan";
				include "report/save_plan.php";
				break;
				
				case "add_Masterplan";
				include "report/add_Masterplan.php";
				break;
				
				case "from_Inplan";
				include "report/from_Inplan.php";
				break;
				
				case "edit_Masterplan";
				include "report/edit_Masterplan.php";
				break;
				
				case "showDetailPlan";
				include "report/showDetailPlan.php";
				break;
				
				case "from_Inplan2";
				include "report/from_Inplan2.php";
				break;
				
				case "Edit_planMonth";
				include "report/Edit_planMonth.php";
				break;
				
				//--------------------------------------------------------------------- เป้าหมาย by N'pong+dream
				case "from_target";
				include "report/from_target.php";
				break;
				
				case "add_target";
				include "report/add_target.php";
				break;
				
				case "save_target";
				include "report/save_target.php";
				break;
				
				case "edit_target";
				include "report/edit_target.php";
				break;

				
				//----------------------------------------------------------------------------ร้านค้า DC by phung
				case "from_cust_DC";
				include "report/from_cust_DC.php";
				break;
				
				
				//----------------------------------------------------------------------- บริษัท by N'pong+dream
				case "from_company";
				include "report/from_company.php";
				break;
				
				case "add_company";
				include "report/add_company.php";
				break;
				
				case "save_company";
				include "report/save_company.php";
				break;
				
				case "edit_company";
				include "report/edit_company.php";
				break;
				
				//------------------------------------------------------------------------------------ประเภทการขาย
				case "from_master_saletype";
				include "report/from_master_saletype.php";
				break;
				
				case "add_master_saletype";
				include "report/add_master_saletype.php";
				break;
				
				case "save_master_saletype";
				include "report/save_master_saletype.php";
				break;
				
				case "edit_master_saletype";
				include "report/edit_master_saletype.php";
				break;
				
			//--------------------บัญชี
				case "StoctCard";
				include "report/StoctCard.php";
				break;
				
				case "DetailProductSales";
				include "report/DetailProductSales.php";
				break;
				
				case "fromTax";
				include "report/fromTax.php";
				break;
				
			//-----------------การเงิน     Edit Mink 29 Oct2015
					case "form_dailysales";
				include "report/form_dailysales.php";
				break;
					case "form_dailysales2";
				include "report/form_dailysales2.php";
				break;
				
				
				case "add_chenge_product";
				include "report/add_chenge_product.php";
				break;
				
				case "save_receive_chenge";
				include "report/save_receive_chenge.php";
				break;
				
			//-------------แพทเทร์น Survey
				case "from_Survey";
				include "report/from_Survey.php";
				break;
				
				case "add_from_Survey";
				include "report/add_from_Survey.php";
				break;
				
				
				case "from_Quotation";
				include "report/from_Quotation.php";
				break;
				
				case "edit_Quotation";
				include "report/edit_Quotation.php";
				break;
				
				case "delete_MasterSurvey";
				include "report/delete_MasterSurvey.php";
				break;
			//----------stock ที่ดูได้หลายคลัง	
				case "stockBalanceAdmin";
				include "report/stockBalanceAdmin.php";
				break;
				
				case "stoc_salekBalanceAdmin";
				include "report/stoc_salekBalanceAdmin.php";
				break;
				
				case "from_receive_headAdmin";
				include "report/from_receive_headAdmin.php";
				break;
				
				case "from_picking_headAdmin";
				include "from_picking_headAdmin.php";
				break;
				
				//-------ใบเสนอราคา
				case "CN_saleCreadit";
				include "report/CN_saleCreadit.php";
				break;
				
				
				//--------ยกเลิกบิล
				case "from_CreditNote";
				include "report/from_CreditNote.php";
				break;
				
				case "edit_CreditNote";
				include "report/edit_CreditNote.php";
				break;
				
				
				
				//----------เปลี่ยนPW
				case "Privacy_settings";
				include "report/Privacy_settings.php";
				break;
				
				case "save_privacysettings";
				include "report/save_privacysettings.php";
				break;
				
				case "form_dailysales2ALLdc";
				include "report/form_dailysales2ALLdc.php";
				break;
				
				case "form_ReportCN";
				include "report/form_ReportCN.php";
				break;
				
				
				
				
	}
	
		

	?>
	