<?php
//function webform_rfi_post_webform_submission_insert($form_id, $submission) {
// The Webform node ID must appear here in the array(), separated by "," in order to call this module. Future plans to integrate this into the UI.
if
(in_array($node->nid, array(736, 2282, 2281)))
{

	//Print submission data to confirmation page
	//$sid = $_GET['sid'];
	//if(isset($sid)){
	// include_once drupal_get_path('module','webform') . '/includes/webform.submissions.inc';
	// $submission = webform_get_submission($node->nid, $sid);
	// $email = NULL;
	// $format = "html";
	// print render(webform_submission_render($node, $submission, $email, $format));
	// print $sid;
	//}

	//this is google analytics premium data gathering below.
	//Code is a modification of Archana Puliroju's apuliroj@asu.edu ASU-RFI module: https://github.com/ASU/asu-drupal-rfi

	$nid_webform = arg(1);
	$sid = $_GET['sid'];
	include_once drupal_get_path('module', 'webform') .'/includes/webform.submissions.inc';
	$submission = webform_get_submission($nid_webform, $sid);
	
	switch ($nid_webform)
	{
	case 736:
		$country = $submission->data[16][0];
		$zip = $submission->data[17][0];
		$plancode = $submission->data[14][0];
		break;
	case 2282:
		$country = $submission->data[14][0];
		$zip = $submission->data[13][0];
		$plancode = $submission->data[8][0];
		break;
	case 2281:
		$country = $submission->data[14][0];
		$zip = $submission->data[13][0];
		$plancode = $submission->data[7][0];
		break;
	}

	$zip_section = substr($zip, 0, 2);
	if ($country == "US") {
		if (!empty($zip_section)){
			if (($zip_section == "85") || ($zip_section == "86")) {
				$price = '100.00';
			} else {
				$price = '200.00';
			}
		} elseif(empty($zip_section)) {
			$price = '300.00' /*international pricing for empty zip*/;
		}
	}
	else {$price = '300.00';}

	$name = $price;

	if ($name = '300.00') {
		$name = 'International';
		}
	if ($name = '200.00') {
		$name = 'Out-of-State';
		}
	if ($name = '100.00') {
		$name = 'In-State';
	}
	else {}

	drupal_add_js(
	"(function ($) {
         SI_dataLayer = [{
            'event': 'ecommerce_event',
            'transactionId': 'MLFTC-' + '$sid',
            'transactionAffiliation': 'MLFTC',
			'transactionTotal': '$price',
           
            'transactionProducts': [{
            	'sku': 'CTE-' + '$plancode' + '-RFI',
				'name': 'RFI-' + '$name' + '-' + 'MLFTC',
				'category': 'RFI',
				'price': '$price',
                'quantity': '1'
             }]
        }];
      })(jQuery);",array(
      		'type' 		=> 	'inline', 
      		'scope' 	=> 	'header', 
      		'weight' 	=> 	0
      		)
      	);	
}?>
