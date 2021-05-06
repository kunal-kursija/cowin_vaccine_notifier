<?php

/**
 * @file
 * Checks if vaccinations are available near a pin code in India.
 */

// Search for vaccines at below pincodes.
$pincodes = [400001, 421004, 431127, 431523, 413249, 431131, 414201, 416810, 431811, 110096];
// Vaccine Age Group.
$age = 18;
// Search For Vaccines starting from today's date.
$date = date('d-m-Y');


set_time_limit(0);
while (TRUE) {
  $output = [];
  // Assume no vaccines are found.
  $vaccines_found = FALSE;
  // Lookup Vaccine at below Pin-codes.
  foreach ($pincodes as $pincode) {
    $response = json_decode(get_availability($pincode, $date), JSON_HEX_QUOT);

    // Loop through the centers having vaccine.
    if (count($response) > 0 && count($response['centers']) > 0) {
      foreach ($response['centers'] as $center) {
        foreach ($center['sessions'] as $session) {
          if ($session['available_capacity'] > 0 && $session['min_age_limit'] == $age) {
            $vaccines_found = TRUE;
            $output[] = $pincode . " - FOUND | " . $session['date'] . ' | AGE: ' . $session['min_age_limit'] . '+ | ' . 'Quantity: ' . $session['available_capacity'] . ' | ' . $center['fee_type'] . ' | ' . $center['name'] . ', ' . $center['address'] . ' | ' . $center['block_name'] . ' | ' . $center['district_name'] . ' | ' . $center['state_name'];
          }
        }
      }
    }
  }

  // Let your system say it loud.
  if ($vaccines_found) {
    // Output the result on CLI.
    print_r(implode("\n", $output));
    print_r("\n");
    print_r("----------------------------------- REGISTER HERE : https://selfregistration.cowin.gov.in/ -----------------------------------");
    print_r("\n");
    exec("say 'Vaccines Found'");
  }
  else {
    print_r("\n");
    print_r("--------------- Could Not Find Any Vaccines ---------------");
    print_r("\n");
  }

  // Search Every 60 Seconds.
  sleep(60);
}

/**
 * Helper function to check availability of a vaccine at a particular pin-code on provided date.
 */
function get_availability($pincode, $date) {
  $url = get_url($pincode, $date);
  $command = "curl -s -H 'cache-control: no-cache' 'pragma: no-cache' 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36' '$url'";
  return exec($command);
}

/**
 * Helper function to create API url.
 */
function get_url($pincode, $date) {
  return 'https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/calendarByPin?pincode=' . $pincode .'&date=' . $date;
}
