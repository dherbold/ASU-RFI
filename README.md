# ASU-GApremium-RFI-script
php script for connecting drupal7 webforms with ASU's Google Analytics Premium

For ASU's GA Premium code to work, it has to be implimented in the (drupal7 webform) webform-confirmation.tpl.php file which - if not already created - must be copied from the webform module’s /tempate/ directory over to the active theme’s template directory. From there, it can be editted. 

Each RFI’s node id ($nid) needs to be set in the "if (in_array())” statement on line 77. Then a switch statement for each needs to be built.

In order to pull user submitted data, for each “case” the component integer of the relevant form component needs to be set. for this instance, those fileds are country, zip and plancode which equate to integers 16, 17 and 14 for case 736, for example: Those numbers get the data from those form components that the user filled out and submitted. 
