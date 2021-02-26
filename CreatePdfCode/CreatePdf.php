<?php
ini_set('memory_limit', '-1');
include("../include/db1.php"); // Include DB connection
include("../include/classes/jobs/notes.php"); // Include DB connection
include("../include/functions.php"); // Include DB functions
require_once(dirname(dirname(__FILE__)) .'/include/functions/db_functions.php'); // Include DB functions
//include("../include/session_check_off.php"); // To check Session if valid
include("../phpMailer/class.phpmailer.php");
include("../phpMailer/class.smtp.php");
$fields_value = $_POST;

global $conn;

//$html .= "<pre>"; print_r($fields_value); die;
//echo "<pre>";print_r($_POST);

//echo "<pre>";print_r($_POST); 
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
 //Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */
require_once('tcpdf_include.php');

class MYTCPDF extends TCPDF {
  public function Header(){
     $html = '<table cellspacing="0" cellpadding="1" border="0"><tr><td style="height:50px;">&nbsp;</td>
                  </tr><tr><td style="text-align:center"><h1 style="margin-top:30px;text-transform:capitalization;">'.strtoupper($_POST[header_company_name]).'</h1></td></tr><tr><td style="text-align:center"><h5 style="margin:0;">'.$_POST[header_company_number].'</h1></td></tr></table>';
     $this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
  }
   public function Footer(){
     $html = '<table cellspacing="0" cellpadding="1" border="0"><tr><td  style="text-align:center;font-size: 12px;margin-top:150px;"><i>Phone Number:'.$_POST[footer_company_number].' Fax #: 718-873-9323, E-mail:'.$_POST[footer_email].'</i></td></tr></table>';
     $this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
  }
}
//$pdf1 = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf1->setHeaderData($ln='', $lw=0, $ht='', $hs='<table cellspacing="0" cellpadding="1" border="1">tr><td rowspan="3">test</td><td>test</td></tr></table>', $tc=array(0,0,0), $lc=array(0,0,0));

// Include the main TCPDF library (search for installation path).
// create new PDF document
$pdf = new MYTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs='<table cellspacing="0" cellpadding="1" border="1"><tr><td rowspan="3">test</td><td>test</td></tr></table>', $tc=array(0,0,0), $lc=array(0,0,0));
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Skiper Receipt');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide'); 
//$pdf->SetHeaderDatatest($_POST[header_company_name]);    
//$pdf->SetFont(‘times’, ‘BI’, 20, “, ‘false’);
//$pdf->SetFont('verdana_bold', 'B', 12);

// set default header data
 //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

/* set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

 convert TTF font to TCPDF format and store it on the fonts folder
$fontname = TCPDF_FONTS::addTTFfont('/path-to-font/FreeSerifItalic.ttf', 'TrueTypeUnicode', '', 96);*/

// use the font
$pdf->SetFont($fontname, '', 14, '', false);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
//$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
//$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

$pdf->setFontSubsetting(false);
//$pdf->SetFont('helvetica', '', 10);

//$pdf->SetMargins(10, 10, 10, true);
//echo $_SERVER['SERVER_NAME'];
//$html .= '<style>'.file_get_contents($_SERVER['SERVER_NAME']/managedev.'stylesheet.css').'</style>';
//$html .= '<style>'.file_get_contents('http://skiper.us/managedev/proposal/base.min.css').'</style>'; 
//$html .= '<style>'.file_get_contents('home/skiper/public_html/managedev/proposal/main.css').'</style>';
$cust_qry = mysqli_query($conn,"select * from job_master where job_id='$fields_value[job_id]'");
 while($rowt = mysqli_fetch_assoc($cust_qry))
 {
   $industry = $rowt[industry];
 }

 if($industry == '0'){
   $ind = "Our technicians are highly trained and have many years of experience in the field.";
 }else{
   $ind = "Our technicians are highly trained and have many years of experience in the field";
 }



$html .= '<html><head><meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>'; 

$html .= '<style>
.block-first {
         width: 160px;
         }

  body{font-family: Verdana,Geneva,sans-serif; font-size: 12px;}
         body{"Times New Roman", Times, serif; font-size: 16px;}
         .input-border {
         border: none;
         border-bottom: solid 1px #000;
         text-transform: lowercase;
         }
         input.input-border:focus ,textarea:focus{
    outline: none;
      }
      strong {
          border-bottom: solid 1px #000;
          vertical-align: middle;
      }
</style>';
$html .='</head><body>';
$html .= '<table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                     <td style="height:60px;">
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <table  class="top-block" width="100%" cellpadding="0" cellspacing="0" >
                           <tr>
                              <td class="block-first"><strong style="text-decoration:underline;">'.date('F j, Y').':</strong>
                              </td>
                              <td>  &nbsp;
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" style="height:40px;">
                                 &nbsp;
                              </td>
                           </tr>
                           <tr>
                              <td class="block-first"><strong>PROPOSAL FOR: </strong>
                              </td>
                              <td>'.$_POST[proposal_for].'
                              </td>
                           </tr>
                           <tr>
                              <td class="block-first"><strong>ADDRESS: </strong>
                              </td>
                              <td>'.$_POST[proposal_address].' 
                              </td>
                           </tr>
                            <tr>
                              <td colspan="2" style="height:20px;">
                                 &nbsp;
                              </td>
                           </tr>
                           <tr>
                              <td class="block-first"><strong>TEL. NO: </strong>
                              </td>
                              <td>'.$_POST[proposal_phone].'
                              </td>
                           </tr>
                           <tr>
                              <td class="block-first"><strong>EMAIL: </strong>
                              </td>
                              <td>'.$_POST[upperemail].'
                              </td>
                           </tr>
                        </table>
                        <!--top-block-->
                     </td>
                  </tr>
                  <tr>
                     <td style="height:30px;">
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td>Thank you for giving <b style="text-transform:uppercase;font-size:12px;">('.stripcslashes($_POST[proposal_cmp_name]).')</b> the opportunity to quote you for the fore-mentioned job. We are committed to providing our customers with a level of service which is second to none. '.$ind.'
                     </td>
                  </tr>
                  <tr>
                     <td style="height:30px;">
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td>If approved, please send a signed copy of all three pages of this proposal via email or fax. This price is valid for 90 days. Should you have any questions, please feel free to contact us at <b style="text-transform: uppercase;font-size:12px;">'.$_POST[proposal_cmp_number].'</b>
                     </td>
                  </tr>
                  <tr>
                     <td style="height:30px;">
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td>We look forward to doing business with you. 
                     </td>
                  </tr>
                  <tr>
                     <td style="height:20px;">
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td>Yours truly, 
                     </td>
                  </tr>
                  <tr>
                     <td style="height:20px;">
                        &nbsp;
                     </td>
                  </tr>
                    
                  <tr>
                     <td>'.$_POST[office_assistant_email].'
                     </td>
                  </tr>
                  <tr>
                     <td>'.$_POST[office_assistant_position].'
                     </td>
                  </tr>
                  <tr>
                     <td style="font-size:12px;font-weight:bold;">'.strtoupper($_POST[mount]).'
                     </td>
                  </tr>
                  <tr>
                     <td>'.$_POST[mount_company_number].'
                     </td>
                  </tr>
                  <br pagebreak="true" />
                  <tr>
                     <td style="height:120px;">
                        &nbsp;
                     </td>
                  </tr>
                     <tr>
                     <td><strong style="text-decoration:underline;">ESTIMATED COST </strong>
                     </td>
                  </tr>
                  <tr>
                     <td>'.stripcslashes($_POST[labor]).': $'.$_POST[total_amount].'
                     </td>
                  </tr>
                  <tr>
                     <td style="height:50px;">
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td><strong style="text-decoration:underline;">EXISTING ISSUE</strong>
                     </td>
                  </tr>
                  <tr>
                     <td>';
                     $cont = 1;
                     $count = 1;
                     if(!empty($fields_value[existing])){
                      // die("yess");
                     $html .='<tr><td class="t-right">'.'-'.' '.stripslashes($fields_value[existing]).'</td></tr>';   
                  }else{
                    // die("nooo");

                  }                     
                     $existing = $fields_value[existfields];
                     //$html .= print_r($existing);
                     //print_r($existing); die;                  
                        foreach ($existing as $key => $value) {
                           //$html .= print_r($value);
                        $count++;       
                        $html .='<tr><td class="t-right">'.'-'.' '.stripcslashes($value).'</td></tr>';             
                        }  
                     $html .='</td>
                  </tr>
                  <tr>
                     <td style="height:50px;">
                        &nbsp;
                     </td>
                  </tr>
                  <tr> 
                     <td><strong style="text-decoration:underline;">SCOPE OF WORK </strong>
                     </td>
                  </tr>
                  <tr>
                     <td>';
                     $cont = 1;
                     $count = 1;
                     if(!empty($fields_value[step])){
                     $html .='<tr><td class="t-right">'.'-'.' '.stripcslashes($fields_value[step]).'</td></tr>';   
                  }else{

                  }                     
                     $additionalFields = $fields_value[additionalFields];                  
                        foreach ($additionalFields as $key => $value) {
                        $count++;                    
                              $html .='<tr><td class="t-right">'.'-'.' '.stripcslashes($value[step]).'</td></tr>';
                       }
                $html.='</td>
                  </tr>
                   <tr>
                     <td style="height:50px;">
                        &nbsp;
                     </td>
                  </tr>  
                  <tr>
                     <td><strong style="text-decoration:underline;">TERMS OF PAYMENT: </strong>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <ul>
                           <li>'.stripcslashes($_POST[acceptance1]).'</li>
                           <li>'.stripcslashes($_POST[acceptance2]).'</li>';
                     //$term = array();                    
                       $term1 = $fields_value[term];                  
                        foreach($term1 as $key => $value) {
                           //$html .= print_r($value); 
                        //$count++;                    
                              $html .='<li>'.stripcslashes($value).'</li>';
                       }
                       //die;
                    $html.='</ul>
                     </td>
                  </tr>
                   <tr>
                     <td style="height:50px;">
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td valign="top">*NOTE:'.stripcslashes($_POST[notes]).' 
                     </td>
                  </tr>

                    <br pagebreak="true" />
                  <tr>
                     <td>
                        <table class="top-block" width="100%" cellpadding="0" cellspacing="0" >
                           <tbody>
                             <tr>
                     <td style="height:60px;">
                        &nbsp;
                     </td>
                  </tr>
                              <tr>
                                 <td class="block-first"><strong>PROPOSAL FOR: </strong>
                                 </td>
                                 <td>'.$_POST[proposal_for1].'
                                 </td>
                              </tr>
                              <tr>
                                 <td class="block-first"><strong>ADDRESS: </strong>
                                 </td>
                                 <td>'.$_POST[proposal_address1].'
                                 </td>
                              </tr>
                              <tr>
                     <td style="height:20px;">
                        &nbsp;
                     </td>
                  </tr>
                              <tr>
                                 <td class="block-first"><strong>TEL. NO: </strong>
                                 </td>
                                 <td>'.$_POST[proposal_phone1].'
                                 </td>
                              </tr>
                              <tr>
                                 <td class="block-first"><strong>EMAIL ADDRESS: </strong>
                                 </td>
                                 <td>'.$_POST[upperemail].'
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                        <!--top-block-->
                     </td>
                  </tr>
                  <tr>
                     <td style="height:60px;">
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td>We are pleased to quote you for the above net prices to complete this work. Any alterations or deviations from the above mentioned work involving extra costs will be executed upon a written order. We trust that this will meet with your approval.
                     </td>
                  </tr>
                  <tr>
                     <td style="height:60px;">
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td><strong style="text-decoration:underline;">PROPOSAL IS ACCEPTED BY:</strong>
                     </td>
                  </tr>
                  <tr>
                     <td style="height:30px;">
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td><strong>ADDRESS: ________________________________</strong>  <input type="text" name="" value="TODAYS DATE" class="input-border">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td><strong>NAME: ________________________________</strong>  &nbsp;<input type="text" name="" value="TODAYS DATE" class="input-border">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td><strong>DATE: ________________________________</strong>   <input type="text" name="" value="TODAYS DATE" class="input-border">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td><strong>SIGNATURE: ________________________________</strong>   <input type="text" name="" value="TODAYS DATE" class="input-border">
                     </td>
                  </tr>
                    <tr>
                     <td style="height:40px;">
                        &nbsp;
                     </td>
                  </tr>
               </table>
           ';
$html .='</body></html>';
//echo $html; die; 
$pdf->writeHTML(utf8_encode($html), true, false, false, false, '');
//$pdf->Output('uu.pdf', 'I');


$dirPath = $_SERVER['DOCUMENT_ROOT'] .'manage/receipt/'.$_POST['job_id'];
$date = date('m-d-Y h:i:s', time());
 if (!file_exists($dirPath)){ 
        mkdir($dirPath);
        $path_date = $date;

        if($_POST['edit_info'] == 'Y'){

           $filepath = $_POST[job_id].'_'.$path_date.'_'.$_POST[title].'.pdf';

          // echo $filepath; die;

        $pro_id = mysqli_real_escape_string($conn,$_POST[ppiidd]);
        $title = mysqli_real_escape_string($conn,$_POST[title]);    
        $job_id = mysqli_real_escape_string($conn,$_POST[job_id]);
        $header_company_name = mysqli_real_escape_string($conn,$_POST[header_company_name]);
        $header_company_number = mysqli_real_escape_string($conn,$_POST[header_company_number]);   
        $proposal_for = mysqli_real_escape_string($conn,$_POST[proposal_for]); 
        $proposal_address = mysqli_real_escape_string($conn,$_POST[proposal_address]);
        $proposal_phone = mysqli_real_escape_string($conn,$_POST[proposal_phone]);
        $upperemail  =  mysqli_real_escape_string($conn,$_POST[upperemail]); 
        $proposal_cmp_name =          mysqli_real_escape_string($conn,$_POST[proposal_cmp_name]); 
        $proposal_cmp_number =        mysqli_real_escape_string($conn,$_POST[proposal_cmp_number]); 
        $office_assistant_email =     mysqli_real_escape_string($conn,$_POST[office_assistant_email]) ; 
        $office_assistant_position =  mysqli_real_escape_string($conn,$_POST[office_assistant_position]); 
        $mount =  mysqli_real_escape_string($conn,$_POST[mount]);
        $mount_company_number =  mysqli_real_escape_string($conn,$_POST[mount_company_number]); 
        $labor= htmlspecialchars(addslashes(stripslashes($_POST[labor])));
        $total_amount= htmlspecialchars(addslashes(stripslashes($_POST[total_amount])));
        $existing =  mysqli_real_escape_string($conn,$_POST[existing]); 
        $step =      mysqli_real_escape_string($conn,$_POST[step]); 
        $acceptance1 =   mysqli_real_escape_string($conn,$_POST[acceptance1]);
        $acceptance2 =    mysqli_real_escape_string($conn,$_POST[acceptance2]); 
        $notes =         mysqli_real_escape_string($conn,$_POST[notes]); 
        $proposal_for1 =          mysqli_real_escape_string($conn,$_POST[proposal_for1]); 
        $proposal_address1 =      mysqli_real_escape_string($conn,$_POST[proposal_address1]);
        $proposal_phone1 =        mysqli_real_escape_string($conn,$_POST[proposal_phone1]);
        $proposal_email1 =        mysqli_real_escape_string($conn,$_POST[proposal_email1]);
        $footer_company_number  = mysqli_real_escape_string($conn,$_POST[footer_company_number]); 
        $footer_email =         mysqli_real_escape_string($conn,$_POST[footer_email]);
        $file_path =         $filepath;


        $filepath = select_single_record("proposal","*","pid = '$pro_id'");
        $file_new_path = $filepath['filePath'];
        $newfile = $dirPath.'/'.$_POST[job_id].$file_new_path;
        unlink($newfile);

         $stepval = array(); 

        foreach($additionalFields as $key => $value) {
         //echo "<pre>";print_r($value[step]);
         $stepval[] = $value[step];
         $implode_scope = implode('||',$stepval);
           # code...
        }

      foreach($existfields as $key => $value) {
         //echo "<pre>";print_r($value);
         $exist[] = $value[existing];
         $implode_exist = implode('||',$exist);
           # code...
        }

        $cfields = "title = '$title', job_id = '$job_id',header_company_name = '$header_company_name',header_company_number = '$header_company_number',proposal_for ='$proposal_for',proposal_address = '$proposal_address',proposal_phone='$proposal_phone',upperemail='$upperemail',proposal_cmp_name = '$proposal_cmp_name',proposal_cmp_number='$proposal_cmp_number',office_assistant_email = '$office_assistant_email',office_assistant_position ='$office_assistant_position',mount='$mount',mount_company_number = '$mount_company_number',total_amount='$total_amount',existing='$existing',step='$step',additionalFields = '$implode_scope',acceptance1='$acceptance1',acceptance2='$acceptance2',notes='$notes',proposal_for1='$proposal_for1',proposal_address1='$proposal_address1',proposal_phone1='$proposal_phone1',proposal_email1 = '$proposal_email1',footer_company_number = '$footer_company_number',footer_email='$footer_email',filePath='$file_path'"; 
         //unlink($newfile);
        // /echo $cfields; die;
         update_table("proposal",$cfields," pid ='$pro_id' ");
         //unlink($newfile);

        }else{

         //echo "<pre>";print_r($_POST); die;

           $filepath = $_POST[job_id].'_'.$path_date.'_'.$_POST[title].'.pdf';

        $title = mysqli_real_escape_string($conn,$_POST[title]);    
        $job_id = mysqli_real_escape_string($conn,$_POST[job_id]);
        $header_company_name = mysqli_real_escape_string($conn,$_POST[header_company_name]);
        $header_company_number = mysqli_real_escape_string($conn,$_POST[header_company_number]);   
        $proposal_for = mysqli_real_escape_string($conn,$_POST[proposal_for]); 
        $proposal_address = mysqli_real_escape_string($conn,$_POST[proposal_address]); 
        $proposal_phone = mysqli_real_escape_string($conn,$_POST[proposal_phone]);
        $upperemail  =  mysqli_real_escape_string($conn,$_POST[upperemail]); 
        $proposal_cmp_name =  mysqli_real_escape_string($conn,$_POST[proposal_cmp_name]); 
        $proposal_cmp_number =   mysqli_real_escape_string($conn,$_POST[proposal_cmp_number]); 
        $office_assistant_email = mysqli_real_escape_string($conn,$_POST[office_assistant_email]); 
        $office_assistant_position =  mysqli_real_escape_string($conn,$_POST[office_assistant_position]); 
        $mount =          mysqli_real_escape_string($conn,$_POST[mount]);
        $mount_company_number =  mysqli_real_escape_string($conn,$_POST[mount_company_number]);
        $labor= htmlspecialchars(addslashes(stripslashes($_POST[labor])));
        $total_amount= htmlspecialchars(addslashes(stripslashes($_POST[total_amount]))); 
        $existing =   mysqli_real_escape_string($conn,$_POST[existing]);
        $existfields =       $_POST[existfields]; 
        $step =              $_POST[step];
        $additionalFields =  $_POST[additionalFields];
        $acceptance1 =       mysqli_real_escape_string($conn,$_POST[acceptance1]);
        $acceptance2 =       mysqli_real_escape_string($conn,$_POST[acceptance2]);
        $term =       mysqli_real_escape_string($conn,$_POST[term]); 
        $notes =       mysqli_real_escape_string($conn,$_POST[notes]); 
        $proposal_for1 =          mysqli_real_escape_string($conn,$_POST[proposal_for1]); 
        $proposal_address1 =      mysqli_real_escape_string($conn,$_POST[proposal_address1]);
        $proposal_phone1 =        mysqli_real_escape_string($conn,$_POST[proposal_phone1]);
        $proposal_email1 =        mysqli_real_escape_string($conn,$_POST[proposal_email1]);
        $footer_company_number  = mysqli_real_escape_string($conn,$_POST[footer_company_number]); 
        $footer_email =         mysqli_real_escape_string($conn,$_POST[footer_email]);

         $stepval = array(); 

        foreach($additionalFields as $key => $value) {
         //echo "<pre>";print_r($value[step]);
         $stepval[] = $value[step];
         $implode_scope = implode('||',$stepval);
           # code...
        }

       // die("sdfasdf");  

        foreach($existfields as $key => $value) {
         //echo "<pre>";print_r($value);
         $exist[] = $value[existing];
         $implode_exist = implode('||',$exist);
           # code...
        }

        foreach($term as $key => $value) {
         //echo "<pre>";print_r($value);
         $terms[] = $value[term];
         $implode_term = implode('||',$terms);
           # code...
        }

         $implode_exist = str_replace("'", '', $implode_exist);
        $implode_term = str_replace("'", '', $implode_term);
        $implode_scope = str_replace("'", '', $implode_scope);

        //print_r($implode_exist); die;

        //echo "laboot".$labor; die;

        $cfields = "title,job_id,header_company_name,header_company_number,proposal_for,proposal_address,proposal_phone,upperemail,proposal_cmp_name,proposal_cmp_number,office_assistant_email,office_assistant_position,mount,mount_company_number,labor,total_amount,existing,existfields,step,additionalFields,acceptance1,acceptance2,term,notes,proposal_for1,proposal_address1,proposal_phone1,proposal_email1,footer_company_number,footer_email,filePath";
       $cvalues = "'".$title."','".$job_id."','".$header_company_name."','".$header_company_number."','".$proposal_for."','".$proposal_address."','".$proposal_phone."','".$upperemail."','".$proposal_cmp_name."','".$proposal_cmp_number."','".$office_assistant_email."','".$office_assistant_position."','".$mount."','".$mount_company_number."','".$labor."','".$total_amount."','".$existing."','".$implode_exist."','".$step."','".$implode_scope."','".$acceptance1."','".$acceptance2."','".$implode_term."','".$notes."','".$proposal_for1."','".$proposal_address1."','".$proposal_phone1."','".$proposal_email1."','".$footer_company_number."','".$footer_email."','".$filepath."'";         
       $insert = insert_table("proposal",$cfields,$cvalues);
       if($insert){
          echo "yess";
       }else{
          echo "noo";
       }
}

        ob_clean();
        $pdf->Output($_POST[job_id].'_'.$path_date.'_'.$_POST[title].'.pdf', 'D');
       /* $pdf->Output('prposal.pdf', 'D');*/
         if($_POST['title']=="PROPOSAL"){
          echo "<h2>Proposal Create successfully!<h2>";
        }else{}
        //$pdf->Output('uu.pdf', 'I');
         echo '<script type="text/javascript">
              window.location = "http://54.177.3.153/manage/homes.php?comd=new_jobb&edit=1&id='.$_POST[job_id].'"
          </script>';
        
      }else{ 
         $path_date = $date;

          if($_POST['edit_info'] == 'Y'){

           //echo print_r($_POST); die;
           //$newfile = $dirPath.'/'.$_POST[job_id].'_'.$path_date.'_'.$_POST[title].'.pdf';
            $filepath = $_POST[job_id].'_'.$path_date.'_'.$_POST[title].'.pdf';

        $pro_id = mysqli_real_escape_string($conn,$_POST[ppiidd]);
        $title = mysqli_real_escape_string($conn,$_POST[title]);    
        $job_id = mysqli_real_escape_string($conn,$_POST[job_id]);
        $header_company_name = mysqli_real_escape_string($conn,$_POST[header_company_name]);
        $header_company_number = mysqli_real_escape_string($conn,$_POST[header_company_number]);   
        $proposal_for = mysqli_real_escape_string($conn,$_POST[proposal_for]); 
        $proposal_address = mysqli_real_escape_string($conn,$_POST[proposal_address]);
        $proposal_phone = mysqli_real_escape_string($conn,$_POST[proposal_phone]);
        $upperemail  =  mysqli_real_escape_string($conn,$_POST[upperemail]); 
        $proposal_cmp_name =   mysqli_real_escape_string($conn,$_POST[proposal_cmp_name]); 
        $proposal_cmp_number =   mysqli_real_escape_string($conn,$_POST[proposal_cmp_number]); 
        $office_assistant_email =  mysqli_real_escape_string($conn,$_POST[office_assistant_email]); 
        $office_assistant_position = mysqli_real_escape_string($conn,$_POST[office_assistant_position]); 
        $mount =  mysqli_real_escape_string($conn,$_POST[mount]);
        $mount_company_number =  mysqli_real_escape_string($conn,$_POST[mount_company_number]); 
        $labor= htmlspecialchars(addslashes(stripslashes($_POST[labor])));
        $total_amount= htmlspecialchars(addslashes(stripslashes($_POST[total_amount]))); 
        $existing =         mysqli_real_escape_string($conn,$_POST[existing]);
        $existfields =      $_POST[existfields];  
        $step =         $_POST[step];
        $additionalFields = $_POST[additionalFields]; 
        $acceptance1 =      mysqli_real_escape_string($conn,$_POST[acceptance1]);
        $acceptance2 =      mysqli_real_escape_string($conn,$_POST[acceptance2]); 
        $term =      mysqli_real_escape_string($conn,$_POST[term]);
        $notes =     mysqli_real_escape_string($conn,$_POST[notes]); 
        $proposal_for1 =    mysqli_real_escape_string($conn,$_POST[proposal_for1]); 
        $proposal_address1 =  mysqli_real_escape_string($conn,$_POST[proposal_address1]);
        $proposal_phone1 =    mysqli_real_escape_string($conn,$_POST[proposal_phone1]);
        $proposal_email1 =   mysqli_real_escape_string($conn,$_POST[proposal_email1]);
        $footer_company_number  =   mysqli_real_escape_string($conn,$_POST[footer_company_number]); 
        $footer_email =   mysqli_real_escape_string($conn, $_POST[footer_email]);
        $file_path =         $filepath;

        $filepath = select_single_record("proposal","*","pid = '$pro_id'");
        $file_new_path = $filepath['filePath'];

        $stepval = array(); 

        foreach($additionalFields as $key => $value) {
         //echo "<pre>";print_r($value[step]);
         $stepval[] = $value[step];
         $implode_scope = implode('||',$stepval);
           # code...
        }


          $exist = array();
         foreach($existfields as $key => $value) {
         // /echo "<pre>";print_r($value); die;
         $exist[] = $value;
         //print_r($exist); 
         $implode_exist = implode('||',$exist);
           # code...
        }

        $terms = array();
         foreach($term as $key => $value) {
         // /echo "<pre>";print_r($value); die;
         $terms[] = $value;
         //print_r($exist); 
         $implode_term = implode('||',$terms);
           # code...
        }

        $implode_exist = str_replace("'", '', $implode_exist);
        $implode_term = str_replace("'", '', $implode_term);
        $implode_scope = str_replace("'", '', $implode_scope);

        $newfile = $dirPath.'/'.$file_new_path;
        unlink($newfile); 
       // echo "filepatttt". $file_path; die;
        $cfields = "title = '$title', job_id = '$job_id',header_company_name = '$header_company_name',header_company_number = '$header_company_number',proposal_for ='$proposal_for',proposal_address = '$proposal_address',proposal_phone='$proposal_phone',upperemail='$upperemail',proposal_cmp_name = '$proposal_cmp_name',proposal_cmp_number='$proposal_cmp_number',office_assistant_email = '$office_assistant_email',office_assistant_position ='$office_assistant_position',mount='$mount',mount_company_number = '$mount_company_number',labor='$labor',total_amount='$total_amount',existing='$existing',existfields='$implode_exist',step='$step',additionalFields= '$implode_scope',acceptance1='$acceptance1',acceptance2='$acceptance2',term='$implode_term',notes='$notes',proposal_for1='$proposal_for1',proposal_address1='$proposal_address1',proposal_phone1='$proposal_phone1',proposal_email1 = '$proposal_email1',footer_company_number = '$footer_company_number',footer_email='$footer_email',filePath='$file_path'";


         
         update_table("proposal",$cfields," pid ='$pro_id'");

         
         //unlink($newfile);
        }else{ 

         //echo "<pre>";print_r($_POST); die;

          $filepath = $_POST[job_id].'_'.$path_date.'_'.$_POST[title].'.pdf';
              $title = $_POST[title];    
        $job_id = mysqli_real_escape_string($conn,$_POST[job_id]);
        $header_company_name = mysqli_real_escape_string($conn,$_POST[header_company_name]);
        $header_company_number = mysqli_real_escape_string($conn,$_POST[header_company_number]);   
        $proposal_for = mysqli_real_escape_string($conn,$_POST[proposal_for]); 
        $proposal_address = mysqli_real_escape_string($conn,$_POST[proposal_address]);
        $proposal_phone = mysqli_real_escape_string($conn,$_POST[proposal_phone]);
        $upperemail  =  mysqli_real_escape_string($conn,$_POST[upperemail]); 
        $proposal_cmp_name =  mysqli_real_escape_string($conn,$_POST[proposal_cmp_name]); 
        $proposal_cmp_number =   mysqli_real_escape_string($conn,$_POST[proposal_cmp_number]); 
        $office_assistant_email =  mysqli_real_escape_string($conn,$_POST[office_assistant_email]); 
        $office_assistant_position = mysqli_real_escape_string($conn,$_POST[office_assistant_position]); 
        $mount =  mysqli_real_escape_string($conn,$_POST[mount]);
        $mount_company_number = mysqli_real_escape_string($conn,$_POST[mount_company_number]);
        $labor= htmlspecialchars(addslashes(stripslashes($_POST[labor])));
        $total_amount= htmlspecialchars(addslashes(stripslashes($_POST[total_amount])));
        $existing = mysqli_real_escape_string($conn,$_POST[existing]);
        $existfields =  $_POST[existfields];
        $step =          $_POST[step];
        $additionalFields =   $_POST[additionalFields];
        $acceptance1 =       mysqli_real_escape_string($conn,$_POST[acceptance1]);
        $acceptance2 =       mysqli_real_escape_string($conn,$_POST[acceptance2]); 
        $notes =        mysqli_real_escape_string($conn,$_POST[notes]);
        $term =     mysqli_real_escape_string($conn,$_POST[term]); 
        $proposal_for1 =     mysqli_real_escape_string($conn,$_POST[proposal_for1]); 
        $proposal_address1 =  mysqli_real_escape_string($conn,$_POST[proposal_address1]);
        $proposal_phone1 =    mysqli_real_escape_string($conn,$_POST[proposal_phone1]);
        $proposal_email1 =    mysqli_real_escape_string($conn,$_POST[proposal_email1]);
        $footer_company_number  =  mysqli_real_escape_string($conn,$_POST[footer_company_number]); 
        $footer_email =  mysqli_real_escape_string($conn,$_POST[footer_email]);

        $stepval = array(); 

        foreach($additionalFields as $key => $value) {
         //echo "<pre>";print_r($value[step]);
         $stepval[] = $value[step];
         $implode_scope = implode('||',$stepval);
           # code...
        }

         $exist = array();
         foreach($existfields as $key => $value) {
         //echo "<pre>";print_r($value);
         $exist[] = $value;
         //print_r($exist); 
         $implode_exist = implode('||',$exist);
           # code...
        }


        $terms = array();
         foreach($term as $key => $value) {
         //echo "<pre>";print_r($value);
         $terms[] = $value;
         //print_r($exist); 
         $implode_term = implode('||',$terms);
           # code...
        }

        $implode_exist = str_replace("'", '', $implode_exist);
        $implode_term = str_replace("'", '', $implode_term);
        $implode_scope = str_replace("'", '', $implode_scope);

        //echo "<pre>";print_r($implode_exist); die;


        $cfields = "title,job_id,header_company_name,header_company_number,proposal_for,proposal_address,proposal_phone,upperemail,proposal_cmp_name,proposal_cmp_number,office_assistant_email,office_assistant_position,mount,mount_company_number,labor,total_amount,existing,existfields,step,additionalFields,acceptance1,acceptance2,term,notes,proposal_for1,proposal_address1,proposal_phone1,proposal_email1,footer_company_number,footer_email,filePath";
       $cvalues = "'".$title."','".$job_id."','".$header_company_name."','".$header_company_number."','".$proposal_for."','".$proposal_address."','".$proposal_phone."','".$upperemail."','".$proposal_cmp_name."','".$proposal_cmp_number."','".$office_assistant_email."','".$office_assistant_position."','".$mount."','".$mount_company_number."','".$labor."','".$total_amount."','".$existing."','".$implode_exist."','".$step."','".$implode_scope."','".$acceptance1."','".$acceptance2."','".$implode_term."','".$notes."','".$proposal_for1."','".$proposal_address1."','".$proposal_phone1."','".$proposal_email1."','".$footer_company_number."','".$footer_email."','".$filepath."'";         
       $insert = insert_table("proposal",$cfields,$cvalues);
       if($insert){
          echo "yess";
       }else{
          echo "noo";
       }
     }
      ob_clean();
         $pdf->Output($_POST[job_id].'_'.$path_date.'_'.$_POST[title].'.pdf', 'D');
         /*$pdf->Output('proposal.pdf', 'D');*/
         //$pdf->Output('uu.pdf', 'I');
         //echo "<h2>Receipt Create successfully!<h2>";
       } 

//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
//$pdf->Output('gdg.pdf', 'I');    
// ---------------------------------------------------------
//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//echo $actual_link; die; 

// Close and output PDF document
// This method has several options, check the source code documentation for more information.

 //$pdf->output('/home/harmeetsingh/Documents/'.$_POST[full_name].'receipt'.$_POST[Ended_date].'.pdf', 'F');
//$pdf->Output('kuitti'.$_POST['job_id'].'.pdf', 'FI');
//$pdf->Output('/home/harmeetsingh/Desktop/factuur.pdf','F');
//$pdf->Output('name.pdf', 'F');
//die("sdfsdfsd");
//============================================================+
// END OF FILE
//============================================================+
?>
