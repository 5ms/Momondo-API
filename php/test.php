<?php
/**
 * Test Momondo API (http://www.momondo.com/)
 *
 * @analyzed Secator.com
 * @author 5ms.ru
 * @link https://github.com/5ms/Momondo-API
 * @date 11.06.2015
 */

require('momondo.php');

$momondo = new Momondo();

// Complete Airports
$airport = $momondo->airport('led');
print_r($airport);

// Get Search Link
$url = $momondo->search_url('LED', 'MOW', '2015-07-01', '2015-07-03');
if ($url) {
	// Get Search Results
	$results = $momondo->search_results($url);
	print_r($results);
}

// Search (include search_url && search_results)
$results = $momondo->search('LED', 'MOW', '2015-07-01', '2015-07-03', '1', 'ECO', array(6, 10));    // Children: 6 && 10 years
print_r($results);

// Price Calendar
$calendar = $momondo->calendar('LED', 'MOW', '2015-07-01', '2015-07-08');
print_r($calendar);

// 1 EUR = ? XXX
$currency = $momondo->currency();
print_r($currency);