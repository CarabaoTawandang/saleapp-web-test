
<?
$page = $_GET['page'];
	
	switch($page)
	
	{			
				case "fromReportAve";
				include "report/fromReportAve.php";
				break;
				
				case "fromReportMTD";
				include "report/fromReportMTD.php";
				break;
				
				case "fromReportByUser";
				include "report/fromReportByUser.php";
				break;
				
			
	}
	
		

	?>
	