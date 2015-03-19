<?php 
if(isset($_GET['input_file'])){
$array = explode('.',$_GET['input_file']);
$count = sizeof($array);
if($array[$count-1] != 'html')
exit;
$html = file_get_contents($_GET['input_file']);
	include("mpdf/mpdf.php");
	$mpdf=new mPDF('en-GB-x','A4','','',5,5,10,10,6,3);
	$mpdf->SetTitle('DWD-DTU');
        $mpdf->SetAuthor('DWD');
        $mpdf->SetCreator('hostels.dce.edu');
        $mpdf->SetKeywords('form');
	$mpdf->SetDisplayMode('fullpage');

	$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

	$stylesheet = file_get_contents('stylesheets2/960.css');
	$stylesheet .= file_get_contents('stylesheets2/reset.css');
	$stylesheet .= file_get_contents('stylesheets2/text.css');
	$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
	$mpdf->WriteHTML($html);
	
	$mpdf->Output('dwd-dtu.pdf','I');
	
	exit;
}

?>
