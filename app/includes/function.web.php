<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

function protect($string) {
	$protection = htmlspecialchars(trim($string), ENT_QUOTES);
	return $protection;
}

function randomHash($lenght = 7) {
	$random = substr(md5(rand()),0,$lenght);
	return $random;
}

function isValidURL($url) {
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

function CE_secure_directory() {
	global $db, $settings;
	$secure_directory = md5($settings['name']);
	$secure_directory = substr($secure_directory,0,15);
	$secure_directory = md5($secure_directory);
	$secure_directory = substr($secure_directory,0,15);
	$secure_directory = md5($secure_directory);
	$secure_directory = substr($secure_directory,0,20);
	return $secure_directory;
}


function croptext2($text,$chars) {
	$string = $text;
	if(strlen($string) > $chars) $string = substr($string, 0, $chars).'***************';
	echo $string;
}

function decodeTitle($a,$b,$c,$from,$to,$id,$prefix) {
	global $db, $settings, $lang;
	if($a == "login") {
		return $lang['title_login']." - ".$settings['name'];
	} elseif($a == "password") {
		if($b == "reset") {
			return $lang['title_reset_password']." - ".$settings['name'];
		} elseif($b == "change") {
			return $lang['title_change_password']." - ".$settings['name'];
		} else {
			return $settings['title'];
		}
	} elseif($a == "reserve_request") {
		return $lang['title_reserve_request']." - ".$settings['name'];
	} elseif($a == "order") {
		$query = $db->query("SELECT * FROM ce_orders WHERE order_hash='$id'");
		$row = $query->fetch_assoc();
		return $lang['order']." #".$row['id']." ".$lang['overview']." - ".$settings['name'];
	} elseif($a == "pay") {
		$query = $db->query("SELECT * FROM ce_orders WHERE order_hash='$id'");
		$row = $query->fetch_assoc();
		return $lang['pay_order']." #".$row['id']." - ".$settings['name'];	
	} elseif($a == "contacts") {
		return $lang['title_contacts']." - ".$settings['name'];
	} elseif($a == "exchange") {
		if(gatewayinfo($from,"merchant_source") == "stripe" or gatewayinfo($from,"merchant_source") == "2checkout") {
			$gateway_send = 'VISA/MasterCard '.gatewayinfo($from,"currency");
		} else { 
			$gateway_send = gatewayinfo($from,"name").' '.gatewayinfo($from,"currency");
		}
		if(gatewayinfo($to,"merchant_source") == "stripe" or gatewayinfo($to,"merchant_source") == "2checkout") {
			$gateway_receive = 'VISA/MasterCard '.gatewayinfo($to,"currency");
		} else {
			$gateway_receive = gatewayinfo($to,"name").' '.gatewayinfo($to,"currency");
		}
		return $lang['exchange']." ".$gateway_send." ".$lang['to']." ".$gateway_receive." - ".$settings['name'];
	} elseif($a == "reviews") {
		return $lang['title_customer_reviews']." - ".$settings['name'];	
	} elseif($a == "page") { 
		if($prefix == "discount_system") {
			return $lang['title_discount_system']." - ".$settings['name'];
		} elseif($prefix == "affiliate_program") {
			return $lang['title_affiliate_program']." - ".$settings['name'];
		} elseif($prefix == "faq") {
			return $lang['title_faq']." - ".$settings['name'];
		} else {
			$query = $db->query("SELECT * FROM ce_pages WHERE prefix='$prefix'");
			$row = $query->fetch_assoc();
			return $row['title']." - ".$settings['name'];	
		}
	} elseif($a == "news") {
		if($b == "view") {
			$query = $db->query("SELECT * FROM ce_news WHERE id='$id'");
			$row = $query->fetch_assoc();
			return $row['title']." - ".$lang['title_news']." - ".$settings['name'];
		} else {
			return $lang['title_news']." - ".$settings['name'];
		}
	} elseif($a == "sitemap") {
		return $lang['title_sitemap']." ".$settings['name'];
	} elseif($a == "payment") {
		if($b == "success") {
			return $lang['payment_success']." - ".$settings['name'];
		} elseif($b == "fail") {
			return $lang['payment_fail']." - ".$settings['name'];
		} else {
			return $settings['name'];
		}
	} elseif($a == "register") {
		return $lang['title_create_account']." - ".$settings['name'];
	} elseif($a == "account") {
		if($b == "dashboard") {
			return $lang['title_account']." ".$lang['menu_dashboard']." - ".$settings['name'];
		} elseif($b == "exchanges") {
			return $lang['title_account']." ".$lang['menu_exchanges']." - ".$settings['name'];
		} elseif($b == "reviews") {
			return $lang['title_account']." ".$lang['menu_reviews']." - ".$settings['name'];
		} elseif($b == "tickets") {
			return $lang['title_account']." ".$lang['menu_support_tickets']." - ".$settings['name'];
		} elseif($b == "referrals") {
			return $lang['title_account']." ".$lang['menu_referrals']." - ".$settings['name'];
		} elseif($b == "discount_system") {
			return $lang['title_account']." ".$lang['menu_discount_system']." - ".$settings['name'];
		} elseif($b == "settings") {
			if($c == "profile") {
				return $lang['title_account']." ".$lang['menu_title_settings']." - ".$lang['menu_profile']." - ".$settings['name'];
			} elseif($c == "security") {
				return $lang['title_account']." ".$lang['menu_title_settings']." - ".$lang['menu_security']." - ".$settings['name'];
			} elseif($c == "verification") {
				return $lang['title_account']." ".$lang['menu_title_settings']." - ".$lang['menu_verification']." - ".$settings['name'];
			} else {	
				return $lang['title_account']." ".$lang['menu_title_settings']." - ".$settings['name'];
			}
		} elseif($b == "close") {
			return $lang['title_close_account']." - ".$settings['name'];	
		} else {
			return $settings['title'];
		}
	} else {
		return $settings['title'];
	}
}


function getCountries() {
	$countries = array('AL' => 'Albania',
	'DZ' => 'Algeria',
	'AD' => 'Andorra',
	'AO' => 'Angola',
	'AI' => 'Anguilla',
	'AG' => 'Antigua &amp; Barbuda',
	'AR' => 'Argentina',
	'AM' => 'Armenia',
	'AW' => 'Aruba',
	'AU' => 'Australia',
	'AT' => 'Austria',
	'AZ' => 'Azerbaijan',
	'BS' => 'Bahamas',
	'BH' => 'Bahrain',
	'BB' => 'Barbados',
	'BY' => 'Belarus',
	'BE' => 'Belgium',
	'BZ' => 'Belize',
	'BJ' => 'Benin',
	'BM' => 'Bermuda',
	'BT' => 'Bhutan',
	'BO' => 'Bolivia',
	'BA' => 'Bosnia &amp; Herzegovina',
	'BW' => 'Botswana',
	'BR' => 'Brazil',
	'VG' => 'British Virgin Islands',
	'BN' => 'Brunei',
	'BG' => 'Bulgaria',
	'BF' => 'Burkina Faso',
	'BI' => 'Burundi',
	'KH' => 'Cambodia',
	'CM' => 'Cameroon',
	'CA' => 'Canada',
	'CV' => 'Cape Verde',
	'KY' => 'Cayman Islands',
	'TD' => 'Chad',
	'CL' => 'Chile',
	'C2' => 'China',
	'CO' => 'Colombia',
	'KM' => 'Comoros',
	'CG' => 'Congo - Brazzaville',
	'CD' => 'Congo - Kinshasa',
	'CK' => 'Cook Islands',
	'CR' => 'Costa Rica',
	'CI' => 'Cote d’Ivoire',
	'HR' => 'Croatia',
	'CY' => 'Cyprus',
	'CZ' => 'Czech Republic',
	'DK' => 'Denmark',
	'DJ' => 'Djibouti',
	'DM' => 'Dominica',
	'DO' => 'Dominican Republic',
	'EC' => 'Ecuador',
	'EG' => 'Egypt',
	'SV' => 'El Salvador',
	'ER' => 'Eritrea',
	'EE' => 'Estonia',
	'ET' => 'Ethiopia',
	'FK' => 'Falkland Islands',
	'FO' => 'Faroe Islands',
	'FJ' => 'Fiji',
	'FI' => 'Finland',
	'FR' => 'France',
	'GF' => 'French Guiana',
	'PF' => 'French Polynesia',
	'GA' => 'Gabon',
	'GM' => 'Gambia',
	'GE' => 'Georgia',
	'DE' => 'Germany',
	'GI' => 'Gibraltar',
	'GR' => 'Greece',
	'GL' => 'Greenland',
	'GD' => 'Grenada',
	'GP' => 'Guadeloupe',
	'GT' => 'Guatemala',
	'GN' => 'Guinea',
	'GW' => 'Guinea-Bissau',
	'GY' => 'Guyana',
	'HN' => 'Honduras',
	'HK' => 'Hong Kong SAR China',
	'HU' => 'Hungary',
	'IS' => 'Iceland',
	'IN' => 'India',
	'ID' => 'Indonesia',
	'IE' => 'Ireland',
	'IL' => 'Israel',
	'IT' => 'Italy',
	'JM' => 'Jamaica',
	'JP' => 'Japan',
	'JO' => 'Jordan',
	'KZ' => 'Kazakhstan',
	'KE' => 'Kenya',
	'KI' => 'Kiribati',
	'KW' => 'Kuwait',
	'KG' => 'Kyrgyzstan',
	'LA' => 'Laos',
	'LV' => 'Latvia',
	'LS' => 'Lesotho',
	'LI' => 'Liechtenstein',
	'LT' => 'Lithuania',
	'LU' => 'Luxembourg',
	'MK' => 'Macedonia',
	'MG' => 'Madagascar',
	'MW' => 'Malawi',
	'MY' => 'Malaysia',
	'MV' => 'Maldives',
	'ML' => 'Mali',
	'MT' => 'Malta',
	'MH' => 'Marshall Islands',
	'MQ' => 'Martinique',
	'MR' => 'Mauritania',
	'MU' => 'Mauritius',
	'YT' => 'Mayotte',
	'MX' => 'Mexico',
	'FM' => 'Micronesia',
	'MD' => 'Moldova',
	'MC' => 'Monaco',
	'MN' => 'Mongolia',
	'ME' => 'Montenegro',
	'MS' => 'Montserrat',
	'MA' => 'Morocco',
	'MZ' => 'Mozambique',
	'NA' => 'Namibia',
	'NR' => 'Nauru',
	'NP' => 'Nepal',
	'NL' => 'Netherlands',
	'AN' => 'Netherlands Antilles',
	'NC' => 'New Caledonia',
	'NZ' => 'New Zealand',
	'NI' => 'Nicaragua',
	'NE' => 'Niger',
	'NG' => 'Nigeria',
	'NU' => 'Niue',
	'NF' => 'Norfolk Island',
	'NO' => 'Norway',
	'OM' => 'Oman',
	'PW' => 'Palau',
	'PA' => 'Panama',
	'PG' => 'Papua New Guinea',
	'PY' => 'Paraguay',
	'PE' => 'Peru',
	'PH' => 'Philippines',
	'PN' => 'Pitcairn Islands',
	'PL' => 'Poland',
	'PT' => 'Portugal',
	'QA' => 'Qatar',
	'RE' => 'Reunion',
	'RO' => 'Romania',
	'RU' => 'Russia',
	'RW' => 'Rwanda',
	'WS' => 'Samoa',
	'SM' => 'San Marino',
	'ST' => 'Sao Tome &amp; Principe',
	'SA' => 'Saudi Arabia',
	'SN' => 'Senegal',
	'RS' => 'Serbia',
	'SC' => 'Seychelles',
	'SL' => 'Sierra Leone',
	'SG' => 'Singapore',
	'SK' => 'Slovakia',
	'SI' => 'Slovenia',
	'SB' => 'Solomon Islands',
	'SO' => 'Somalia',
	'ZA' => 'South Africa',
	'KR' => 'South Korea',
	'ES' => 'Spain',
	'LK' => 'Sri Lanka',
	'SH' => 'St. Helena',
	'KN' => 'St. Kitts &amp; Nevis',
	'LC' => 'St. Lucia',
	'PM' => 'St. Pierre &amp; Miquelon',
	'VC' => 'St. Vincent &amp; Grenadines',
	'SR' => 'Suriname',
	'SJ' => 'Svalbard &amp; Jan Mayen',
	'SZ' => 'Swaziland',
	'SE' => 'Sweden',
	'CH' => 'Switzerland',
	'TW' => 'Taiwan',
	'TJ' => 'Tajikistan',
	'TZ' => 'Tanzania',
	'TH' => 'Thailand',
	'TG' => 'Togo',
	'TO' => 'Tonga',
	'TT' => 'Trinidad &amp; Tobago',
	'TN' => 'Tunisia',
	'TM' => 'Turkmenistan',
	'TC' => 'Turks &amp; Caicos Islands',
	'TV' => 'Tuvalu',
	'UG' => 'Uganda',
	'UA' => 'Ukraine',
	'AE' => 'United Arab Emirates',
	'GB' => 'United Kingdom',
	'US' => 'United States',
	'UY' => 'Uruguay',
	'VU' => 'Vanuatu',
	'VA' => 'Vatican City',
	'VE' => 'Venezuela',
	'VN' => 'Vietnam',
	'WF' => 'Wallis &amp; Futuna',
	'YE' => 'Yemen',
	'ZM' => 'Zambia',
	'ZW' => 'Zimbabwe');
	return $countries;
}

 /**
     * Function to see if a string is a UK postcode or not. The postcode is also 
     * formatted so it contains no strings. Full or partial postcodes can be used.
     * 
     * @param string $toCheck
     * @return boolean 
     */
    function postcode_check(&$toCheck) {
		// Permitted letters depend upon their position in the postcode.
		$alpha1 = "[abcdefghijklmnoprstuwyz]";                          // Character 1
		$alpha2 = "[abcdefghklmnopqrstuvwxy]";                          // Character 2
		$alpha3 = "[abcdefghjkstuw]";                                   // Character 3
		$alpha4 = "[abehmnprvwxy]";                                     // Character 4
		$alpha5 = "[abdefghjlnpqrstuwxyz]";                             // Character 5
	   
		// Expression for postcodes: AN NAA, ANN NAA, AAN NAA, and AANN NAA with a space
		// Or AN, ANN, AAN, AANN with no whitespace
		$pcexp[0] = '^(' . $alpha1 . '{1}' . $alpha2 . '{0,1}[0-9]{1,2})([[:space:]]{0,})([0-9]{1}' . $alpha5 . '{2})?$';
	   
		// Expression for postcodes: ANA NAA
		// Or ANA with no whitespace
		$pcexp[1] = '^(' . $alpha1 . '{1}[0-9]{1}' . $alpha3 . '{1})([[:space:]]{0,})([0-9]{1}' . $alpha5 . '{2})?$';
	   
		// Expression for postcodes: AANA NAA
		// Or AANA With no whitespace
		$pcexp[2] = '^(' . $alpha1 . '{1}' . $alpha2 . '[0-9]{1}' . $alpha4 . ')([[:space:]]{0,})([0-9]{1}' . $alpha5 . '{2})?$';
	   
		// Exception for the special postcode GIR 0AA
		// Or just GIR
		$pcexp[3] = '^(gir)([[:space:]]{0,})?(0aa)?$';
	   
		// Standard BFPO numbers
		$pcexp[4] = '^(bfpo)([[:space:]]{0,})([0-9]{1,4})$';
	   
		// c/o BFPO numbers
		$pcexp[5] = '^(bfpo)([[:space:]]{0,})(c\/o([[:space:]]{0,})[0-9]{1,3})$';
	   
		// Overseas Territories
		$pcexp[6] = '^([a-z]{4})([[:space:]]{0,})(1zz)$';
	   
		// Anquilla
		$pcexp[7] = '^(ai\-2640)$';
	   
		// Load up the string to check, converting into lowercase
		$postcode = strtolower($toCheck);
	   
		// Assume we are not going to find a valid postcode
		$valid = false;
	   
		// Check the string against the six types of postcodes
		foreach ($pcexp as $regexp) {
		  if (preg_match('/' . $regexp . '/i', $postcode, $matches)) {
	   
			// Load new postcode back into the form element
			$postcode = strtoupper($matches[1]);
			if (isset($matches[3])) {
			  $postcode .= ' ' . strtoupper($matches[3]);
			}
	   
			// Take account of the special BFPO c/o format
			$postcode = preg_replace('/C\/O/', 'c/o ', $postcode);
	   
			// Remember that we have found that the code is valid and break from loop
			$valid = true;
			break;
		  }
		}
	   
		// Return with the reformatted valid postcode in uppercase if the postcode was 
		// valid
		if ($valid) {
		  $toCheck = $postcode;
		  return true;
		} else {
		  return false;
		}
	  }

	  function VerifyGoogleRecaptcha($response) {
		global $db, $settings;
		$secret = $settings['recaptcha_privatekey'];
		$ch = curl_init();
		$url = "https://www.google.com/recaptcha/api/siteverify";
		$data = "secret=$secret&response=$response";
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		$json = json_decode($result, true);
		if($json['success'] == true) {
			return true;
		} else {
			return false;
		}
	}

function CE_CheckExpiredOrders() {
	global $db, $settings;
	$expired_time = time()-$settings['expire_uncompleted_time'];
	$query = $db->query("SELECT * FROM ce_orders WHERE created < $expired_time and status < 3");
	if($query->num_rows>0) {
		$time = time();
		while($row = $query->fetch_assoc()) {
			$update = $db->query("UPDATE ce_orders SET status='6',expired='$time' WHERE id='$row[id]'");
		}
	}
}

function validated_wallet_id($wallet_id,$uid)
{
	global $db;	
	if($wallet_id == null || $wallet_id == '') {
		$wallet_id = generate_wallet_id($uid);
		$db->query("UPDATE `ce_users` SET `wallet_id` = '$wallet_id' WHERE `id` = '$uid'");
		return $wallet_id;
	}
	return $wallet_id;
}

function generate_wallet_id($uid)
{
	$wallet_id = "VIRSM";
	for($i = 1; $i <= (6 - strlen($uid)); $i++)
	{
		$wallet_id .= "0";
	}
	$wallet_id .= $uid; 
	return $wallet_id;
}

function get_last_inserted_id($table)
{
	global $db;
	$result = $db->query("SELECT MAX(`id`) AS `id` FROM `$table`");
	$result = $result->fetch_assoc()['id'];
	$id = 0;
	if($result != null && $result != '')
	{
		$id = $result;
	}
	return $id;
}

function getFiatCurrencies() {
	$currencies = array('AED' => 'AED - United Arab Emirates Dirham',
											'AFN' => 'AFN - Afghanistan Afghani',
											'ALL' => 'ALL - Albania Lek',
											'AMD' => 'AMD - Armenia Dram',
											'ANG' => 'ANG - Netherlands Antilles Guilder',
											'AOA' => 'AOA - Angola Kwanza',
											'ARS' => 'ARS - Argentina Peso',
											'AUD' => 'AUD - Australia Dollar',
											'AWG' => 'AWG - Aruba Guilder',
											'AZN' => 'AZN - Azerbaijan New Manat',
											'BAM' => 'BAM - Bosnia and Herzegovina Convertible Marka',
											'BBD' => 'BBD - Barbados Dollar',
											'BDT' => 'BDT - Bangladesh Taka',
											'BGN' => 'BGN - Bulgaria Lev',
											'BHD' => 'BHD - Bahrain Dinar',
											'BIF' => 'BIF - Burundi Franc',
											'BMD' => 'BMD - Bermuda Dollar',
											'BND' => 'BND - Brunei Darussalam Dollar',
											'BOB' => 'BOB - Bolivia Boliviano',
											'BRL' => 'BRL - Brazil Real',
											'BSD' => 'BSD - Bahamas Dollar',
											'BTN' => 'BTN - Bhutan Ngultrum',
											'BWP' => 'BWP - Botswana Pula',
											'BYR' => 'BYR - Belarus Ruble',
											'BZD' => 'BZD - Belize Dollar',
											'CAD' => 'CAD - Canada Dollar',
											'CDF' => 'CDF - Congo/Kinshasa Franc',
											'CHF' => 'CHF - Switzerland Franc',
											'CLP' => 'CLP - Chile Peso',
											'CNY' => 'CNY - China Yuan Renminbi',
											'COP' => 'COP - Colombia Peso',
											'CRC' => 'CRC - Costa Rica Colon',
											'CUC' => 'CUC - Cuba Convertible Peso',
											'CUP' => 'CUP - Cuba Peso',
											'CVE' => 'CVE - Cape Verde Escudo',
											'CZK' => 'CZK - Czech Republic Koruna',
											'DJF' => 'DJF - Djibouti Franc',
											'DKK' => 'DKK - Denmark Krone',
											'DOP' => 'DOP - Dominican Republic Peso',
											'DZD' => 'DZD - Algeria Dinar',
											'EGP' => 'EGP - Egypt Pound',
											'ERN' => 'ERN - Eritrea Nakfa',
											'ETB' => 'ETB - Ethiopia Birr',
											'EUR' => 'EUR - Euro Member Countries',
											'FJD' => 'FJD - Fiji Dollar',
											'FKP' => 'FKP - Falkland Islands (Malvinas) Pound',
											'GBP' => 'GBP - United Kingdom Pound',
											'GEL' => 'GEL - Georgia Lari',
											'GGP' => 'GGP - Guernsey Pound',
											'GHS' => 'GHS - Ghana Cedi',
											'GIP' => 'GIP - Gibraltar Pound',
											'GMD' => 'GMD - Gambia Dalasi',
											'GNF' => 'GNF - Guinea Franc',
											'GTQ' => 'GTQ - Guatemala Quetzal',
											'GYD' => 'GYD - Guyana Dollar',
											'HKD' => 'HKD - Hong Kong Dollar',
											'HNL' => 'HNL - Honduras Lempira',
											'HPK' => 'HRK - Croatia Kuna',
											'HTG' => 'HTG - Haiti Gourde',
											'HUF' => 'HUF - Hungary Forint',
											'IDR' => 'IDR - Indonesia Rupiah',
											'ILS' => 'ILS - Israel Shekel',
											'IMP' => 'IMP - Isle of Man Pound',
											'INR' => 'INR - India Rupee',
											'IQD' => 'IQD - Iraq Dinar',
											'IRR' => 'IRR - Iran Rial',
											'ISK' => 'ISK - Iceland Krona',
											'JEP' => 'JEP - Jersey Pound',
											'JMD' => 'JMD - Jamaica Dollar',
											'JOD' => 'JOD - Jordan Dinar',
											'JPY' => 'JPY - Japan Yen',
											'KES' => 'KES - Kenya Shilling',
											'KGS' => 'KGS - Kyrgyzstan Som',
											'KHR' => 'KHR - Cambodia Riel',
											'KMF' => 'KMF - Comoros Franc',
											'KPW' => 'KPW - Korea (North) Won',
											'KRW' => 'KRW - Korea (South) Won',
											'KWD' => 'KWD - Kuwait Dinar',
											'KYD' => 'KYD - Cayman Islands Dollar',
											'KZT' => 'KZT - Kazakhstan Tenge',
											'LAK' => 'LAK - Laos Kip',
											'LBP' => 'LBP - Lebanon Pound',
											'LKR' => 'LKR - Sri Lanka Rupee',
											'LRD' => 'LRD - Liberia Dollar',
											'LSL' => 'LSL - Lesotho Loti',
											'LYD' => 'LYD - Libya Dinar',
											'MAD' => 'MAD - Morocco Dirham',
											'MDL' => 'MDL - Moldova Leu',
											'MGA' => 'MGA - Madagascar Ariary',
											'MKD' => 'MKD - Macedonia Denar',
											'MMK' => 'MMK - Myanmar (Burma) Kyat',
											'MNT' => 'MNT - Mongolia Tughrik',
											'MOP' => 'MOP - Macau Pataca',
											'MRO' => 'MRO - Mauritania Ouguiya',
											'MUR' => 'MUR - Mauritius Rupee',
											'MVR' => 'MVR - Maldives (Maldive Islands) Rufiyaa',
											'MWK' => 'MWK - Malawi Kwacha',
											'MXN' => 'MXN - Mexico Peso',
											'MYR' => 'MYR - Malaysia Ringgit',
											'MZN' => 'MZN - Mozambique Metical',
											'NAD' => 'NAD - Namibia Dollar',
											'NGN' => 'NGN - Nigeria Naira',
											'NTO' => 'NIO - Nicaragua Cordoba',
											'NOK' => 'NOK - Norway Krone',
											'NPR' => 'NPR - Nepal Rupee',
											'NZD' => 'NZD - New Zealand Dollar',
											'OMR' => 'OMR - Oman Rial',
											'PAB' => 'PAB - Panama Balboa',
											'PEN' => 'PEN - Peru Nuevo Sol',
											'PGK' => 'PGK - Papua New Guinea Kina',
											'PHP' => 'PHP - Philippines Peso',
											'PKR' => 'PKR - Pakistan Rupee',
											'PLN' => 'PLN - Poland Zloty',
											'PYG' => 'PYG - Paraguay Guarani',
											'QAR' => 'QAR - Qatar Riyal',
											'RON' => 'RON - Romania New Leu',
											'RSD' => 'RSD - Serbia Dinar',
											'RUB' => 'RUB - Russia Ruble',
											'RWF' => 'RWF - Rwanda Franc',
											'SAR' => 'SAR - Saudi Arabia Riyal',
											'SBD' => 'SBD - Solomon Islands Dollar',
											'SCR' => 'SCR - Seychelles Rupee',
											'SDG' => 'SDG - Sudan Pound',
											'SEK' => 'SEK - Sweden Krona',
											'SGD' => 'SGD - Singapore Dollar',
											'SHP' => 'SHP - Saint Helena Pound',
											'SLL' => 'SLL - Sierra Leone Leone',
											'SOS' => 'SOS - Somalia Shilling',
											'SRL' => 'SPL* - Seborga Luigino',
											'SRD' => 'SRD - Suriname Dollar',
											'STD' => 'STD - Sao Tome and Principe Dobra',
											'SVC' => 'SVC - El Salvador Colon',
											'SYP' => 'SYP - Syria Pound',
											'SZL' => 'SZL - Swaziland Lilangeni',
											'THB' => 'THB - Thailand Baht',
											'TJS' => 'TJS - Tajikistan Somoni',
											'TMT' => 'TMT - Turkmenistan Manat',
											'TND' => 'TND - Tunisia Dinar',
											'TOP' => 'TOP - Tonga Paanga',
											'TRY' => 'TRY - Turkey Lira',
											'TTD' => 'TTD - Trinidad and Tobago Dollar',
											'TVD' => 'TVD - Tuvalu Dollar',
											'TWD' => 'TWD - Taiwan New Dollar',
											'TZS' => 'TZS - Tanzania Shilling',
											'UAH' => 'UAH - Ukraine Hryvnia',
											'UGX' => 'UGX - Uganda Shilling',
											'USD' => 'USD - United States Dollar',
											'UYU' => 'UYU - Uruguay Peso',
											'UZS' => 'UZS - Uzbekistan Som',
											'VEF' => 'VEF - Venezuela Bolivar',
											'VND' => 'VND - Viet Nam Dong',
											'VUV' => 'VUV - Vanuatu Vatu',
											'WST' => 'WST - Samoa Tala',
											'XAF' => 'XAF - Communaute Financiere Africaine (BEAC) CFA Franc BEAC',
											'XCD' => 'XCD - East Caribbean Dollar',
											'XDR' => 'XDR - International Monetary Fund (IMF) Special Drawing Rights',
											'XOF' => 'XOF - Communaute Financiere Africaine (BCEAO) Franc',
											'XPF' => 'XPF - Comptoirs Francais du Pacifique (CFP) Franc',
											'YER' => 'YER - Yemen Rial',
											'ZAR' => 'ZAR - South Africa Rand',
											'ZMW' => 'ZMW - Zambia Kwacha',
											'ZWD' => 'ZWD - Zimbabwe Dollar');
	return $currencies;
}
?>