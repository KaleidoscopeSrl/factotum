<?php

namespace Kaleidoscope\Factotum\Library;

use Illuminate\Support\Str;
use Image;


class Utility
{

	public static function debug($x)
	{
		echo '<pre>';
		print_r($x);
		echo '</pre>';
	}


	public static function jsonDebug( $debug )
	{
		header('Accept: application/json');
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		echo json_encode( ['debug' => $debug ] );
	}


	public static function getSqlQuery($query)
	{
		$params = array_map(function ($item) {
			return "'{$item}'";
		}, $query->getBindings());

		$query = Str::replaceArray('?', $params, $query->toSql());

		return $query;
	}


	public static function convertOptionsArrayToText($options)
	{
		return join(';', $options);
	}

	public static function convertOptionsTextToArray($options)
	{
		return explode(';', $options);
	}

	public static function convertOptionsTextToAssocArray($options)
	{
		$result = [];
		$options = explode(';', $options);
		foreach ($options as $opt) {
			if ( $opt && Str::contains($opt, ':') ) {
				list($value, $label) = explode(':', $opt);
				$result[$value] = $label;
			}
		}
		return $result;
	}

	public static function convertOptionsAssocArrayToString($values, $labels)
	{
		$tmp = [];
		foreach ( $values as $index => $value ) {
			$tmp[] = $value . ':' . $labels[ $index ];
		}
		return join(';', $tmp);
	}

	public static function convertHumanDateToIso($date)
	{
		return implode('-', array_reverse(explode('/', $date)));
	}

	public static function convertHumanDateTimeToIso($datetime)
	{
		list($date, $time) = explode(' ', $datetime);
		return self::convertHumanDateToIso($date) . ' ' . $time;
	}

	public static function convertIsoDateToHuman($date)
	{
		return implode('/', array_reverse(explode('-', $date)));
	}

	public static function convertIsoDateTimeToHuman($datetime)
	{
		list($date, $time) = explode(' ', $datetime);
		return self::convertIsoDateToHuman($date) . ' ' . $time;
	}

	public static function flatTree($collection, $tmp = array())
	{
		foreach ( $collection as $item ) {
			if  ( $item->parent_recursive ) {
				$newColl = $item->parent_recursive;
				$item->parent_recursive = null;
				$tmp[] = $item;
				return self::flatTree( $newColl , $tmp);
			}
			$tmp[] = $item;
		}
		return $tmp;
	}

	/**
	 * Format bytes to kb, mb, gb, tb
	 *
	 * @param  integer $size
	 * @param  integer $precision
	 * @return integer
	 */
	public static function formatBytes($size, $precision = 2)
	{
		if ($size > 0) {
			$size = (int) $size;
			$base = log($size) / log(1024);
			$suffixes = [ ' bytes', ' KB', ' MB', ' GB', ' TB' ];

			return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
		} else {
			return $size;
		}
	}

	public static function getCountries()
	{
		$countries = [];
		$countries['IT'] = 'Italia';
		$countries['AD'] = 'Andorra';
		$countries['AE'] = 'United Arab Emirates';
		$countries['AF'] = 'Afghanistan';
		$countries['AG'] = 'Antigua';
		$countries['AI'] = 'Anguilla';
		$countries['AL'] = 'Albania';
		$countries['AM'] = 'Armenia';
		$countries['AN'] = 'Netherlands Antilles';
		$countries['AO'] = 'Angola';
		$countries['AQ'] = 'Antarctica';
		$countries['AR'] = 'Argentina';
		$countries['AS'] = 'American Samoa';
		$countries['AT'] = 'Austria';
		$countries['AU'] = 'Australia';
		$countries['AW'] = 'Aruba';
		$countries['AX'] = 'Aland Islands';
		$countries['AZ'] = 'Azerbaijan';
		$countries['BA'] = 'Bosnia and Herzegovina';
		$countries['BB'] = 'Barbados';
		$countries['BD'] = 'Bangladesh';
		$countries['BE'] = 'Belgium';
		$countries['BF'] = 'Burkina Faso';
		$countries['BG'] = 'Bulgaria';
		$countries['BH'] = 'Bahrain';
		$countries['BI'] = 'Burundi';
		$countries['BJ'] = 'Benin';
		$countries['BL'] = 'Saint Barthélemy';
		$countries['BM'] = 'Bermuda';
		$countries['BN'] = 'Brunei';
		$countries['BO'] = 'Bolivia';
		$countries['BQ'] = 'Bonaire, Sint Eustatius and Saba';
		$countries['BR'] = 'Brazil';
		$countries['BS'] = 'The Bahamas';
		$countries['BT'] = 'Bhutan';
		$countries['BV'] = 'Bouvet Island';
		$countries['BW'] = 'Botswana';
		$countries['BY'] = 'Belarus';
		$countries['BZ'] = 'Belize';
		$countries['CA'] = 'Canada';
		$countries['CC'] = 'Cocos (Keeling) Islands';
		$countries['CD'] = 'Democratic Republic of the Congo';
		$countries['CF'] = 'Central African Republic';
		$countries['CG'] = 'Republic of the Congo';
		$countries['CH'] = 'Switzerland';
		$countries['CI'] = "'Côte d'Ivoire'";
		$countries['CK'] = 'Cook Islands';
		$countries['CL'] = 'Chile';
		$countries['CM'] = 'Cameroon';
		$countries['CN'] = 'China';
		$countries['CO'] = 'Colombia';
		$countries['CR'] = 'Costa Rica';
		$countries['CV'] = 'Cape Verde';
		$countries['CW'] = 'Curaçao';
		$countries['CX'] = 'Christmas Island';
		$countries['CY'] = 'Cyprus';
		$countries['CZ'] = 'Czech Republic';
		$countries['DE'] = 'Germany';
		$countries['DJ'] = 'Djibouti';
		$countries['DK'] = 'Denmark';
		$countries['DM'] = 'Dominica';
		$countries['DO'] = 'Dominican Republic';
		$countries['DZ'] = 'Algeria';
		$countries['EC'] = 'Ecuador';
		$countries['EE'] = 'Estonia';
		$countries['EG'] = 'Egypt';
		$countries['EH'] = 'Western Sahara';
		$countries['ER'] = 'Eritrea';
		$countries['ES'] = 'Spain';
		$countries['ET'] = 'Ethiopia';
		$countries['FI'] = 'Finland';
		$countries['FJ'] = 'Fiji';
		$countries['FK'] = 'Falkland Islands';
		$countries['FM'] = 'Federated States of Micronesia';
		$countries['FO'] = 'Faroe Islands';
		$countries['FR'] = 'France';
		$countries['GA'] = 'Gabon';
		$countries['GB'] = 'United Kingdom';
		$countries['GD'] = 'Grenada';
		$countries['GE'] = 'Georgia';
		$countries['GF'] = 'French Guiana';
		$countries['GG'] = 'Guernsey';
		$countries['GH'] = 'Ghana';
		$countries['GI'] = 'Gibraltar';
		$countries['GL'] = 'Greenland';
		$countries['GM'] = 'The Gambia';
		$countries['GN'] = 'Guinea';
		$countries['GP'] = 'Guadeloupe';
		$countries['GQ'] = 'Equatorial Guinea';
		$countries['GR'] = 'Greece';
		$countries['GS'] = 'South Georgia and the South Sandwich Islands';
		$countries['GT'] = 'Guatemala';
		$countries['GU'] = 'Guam';
		$countries['GW'] = 'Guinea-Bissau';
		$countries['GY'] = 'Guyana';
		$countries['HK'] = 'Hong Kong';
		$countries['HM'] = 'Heard Island and McDonald Islands';
		$countries['HN'] = 'Honduras';
		$countries['HR'] = 'Croatia';
		$countries['HT'] = 'Haiti';
		$countries['HU'] = 'Hungary';
		$countries['ID'] = 'Indonesia';
		$countries['IE'] = 'Ireland';
		$countries['IL'] = 'Israel';
		$countries['IM'] = 'Isle Of Man';
		$countries['IN'] = 'India';
		$countries['IO'] = 'British Indian Ocean Territory';
		$countries['IR'] = 'Iran';
		$countries['IQ'] = 'Iraq';
		$countries['IS'] = 'Iceland';
		$countries['JE'] = 'Jersey';
		$countries['JM'] = 'Jamaica';
		$countries['JO'] = 'Jordan';
		$countries['JP'] = 'Japan';
		$countries['KE'] = 'Kenya';
		$countries['KG'] = 'Kyrgyzstan';
		$countries['KH'] = 'Cambodia';
		$countries['KI'] = 'Kiribati';
		$countries['KM'] = 'Comoros';
		$countries['KN'] = 'Saint Kitts and Nevis';
		$countries['KP'] = 'North Korea';
		$countries['KR'] = 'South Korea';
		$countries['KW'] = 'Kuwait';
		$countries['KY'] = 'Cayman Islands';
		$countries['KZ'] = 'Kazakhstan';
		$countries['LA'] = 'Laos';
		$countries['LB'] = 'Lebanon';
		$countries['LC'] = 'St. Lucia';
		$countries['LI'] = 'Liechtenstein';
		$countries['LK'] = 'Sri Lanka';
		$countries['LR'] = 'Liberia';
		$countries['LS'] = 'Lesotho';
		$countries['LT'] = 'Lithuania';
		$countries['LU'] = 'Luxembourg';
		$countries['LV'] = 'Latvia';
		$countries['LY'] = 'Libya';
		$countries['MA'] = 'Morocco';
		$countries['MC'] = 'Monaco';
		$countries['MD'] = 'Moldova';
		$countries['ME'] = 'Montenegro';
		$countries['MF'] = 'Saint Martin';
		$countries['MG'] = 'Madagascar';
		$countries['MH'] = 'Marshall Islands';
		$countries['MK'] = 'Macedonia';
		$countries['ML'] = 'Mali';
		$countries['MM'] = 'Myanmar';
		$countries['MN'] = 'Mongolia';
		$countries['MO'] = 'Macau';
		$countries['MP'] = 'Northern Mariana Islands';
		$countries['MQ'] = 'Martinique';
		$countries['MR'] = 'Mauritania';
		$countries['MS'] = 'Montserrat';
		$countries['MT'] = 'Malta';
		$countries['MU'] = 'Mauritius';
		$countries['MV'] = 'Maldives';
		$countries['MW'] = 'Malawi';
		$countries['MX'] = 'Mexico';
		$countries['MY'] = 'Malaysia';
		$countries['MZ'] = 'Mozambique';
		$countries['NA'] = 'Namibia';
		$countries['NC'] = 'New Caledonia';
		$countries['NE'] = 'Niger';
		$countries['NF'] = 'Norfolk Island';
		$countries['NG'] = 'Nigeria';
		$countries['NI'] = 'Nicaragua';
		$countries['NL'] = 'Netherlands';
		$countries['NO'] = 'Norway';
		$countries['NP'] = 'Nepal';
		$countries['NR'] = 'Nauru';
		$countries['NU'] = 'Niue';
		$countries['NZ'] = 'New Zealand';
		$countries['OM'] = 'Oman';
		$countries['PA'] = 'Panama';
		$countries['PE'] = 'Peru';
		$countries['PF'] = 'French Polynesia';
		$countries['PG'] = 'Papua New Guinea';
		$countries['PH'] = 'Philippines';
		$countries['PK'] = 'Pakistan';
		$countries['PL'] = 'Poland';
		$countries['PM'] = 'Saint Pierre and Miquelon';
		$countries['PN'] = 'Pitcairn';
		$countries['PR'] = 'Puerto Rico';
		$countries['PS'] = 'Palestine';
		$countries['PT'] = 'Portugal';
		$countries['PW'] = 'Palau';
		$countries['PY'] = 'Paraguay';
		$countries['QA'] = 'Qatar';
		$countries['RE'] = 'Réunion';
		$countries['RO'] = 'Romania';
		$countries['RS'] = 'Serbia';
		$countries['RU'] = 'Russia';
		$countries['RW'] = 'Rwanda';
		$countries['SA'] = 'Saudi Arabia';
		$countries['SB'] = 'Solomon Islands';
		$countries['SC'] = 'Seychelles';
		$countries['SE'] = 'Sweden';
		$countries['SG'] = 'Singapore';
		$countries['SH'] = 'Saint Helena';
		$countries['SI'] = 'Slovenia';
		$countries['SJ'] = 'Svalbard and Jan Mayen';
		$countries['SK'] = 'Slovakia';
		$countries['SL'] = 'Sierra Leone';
		$countries['SM'] = 'San Marino';
		$countries['SN'] = 'Senegal';
		$countries['SO'] = 'Somalia';
		$countries['SR'] = 'Suriname';
		$countries['SS'] = 'South Sudan';
		$countries['ST'] = 'Sao Tome and Principe';
		$countries['SV'] = 'El Salvador';
		$countries['SX'] = 'Sint Maarten';
		$countries['SZ'] = 'Swaziland';
		$countries['TC'] = 'Turks and Caicos Islands';
		$countries['TD'] = 'Chad';
		$countries['TF'] = 'French Southern Territories';
		$countries['TG'] = 'Togo';
		$countries['TH'] = 'Thailand';
		$countries['TJ'] = 'Tajikistan';
		$countries['TK'] = 'Tokelau';
		$countries['TL'] = 'Timor-Leste';
		$countries['TM'] = 'Turkmenistan';
		$countries['TN'] = 'Tunisia';
		$countries['TO'] = 'Tonga';
		$countries['TR'] = 'Turkey';
		$countries['TT'] = 'Trinidad and Tobago';
		$countries['TV'] = 'Tuvalu';
		$countries['TW'] = 'Taiwan';
		$countries['TZ'] = 'Tanzania';
		$countries['UA'] = 'Ukraine';
		$countries['UG'] = 'Uganda';
		$countries['UM'] = 'United States Minor Outlying Islands';
		$countries['US'] = 'United States';
		$countries['UY'] = 'Uruguay';
		$countries['UZ'] = 'Uzbekistan';
		$countries['VA'] = 'Vatican City';
		$countries['VC'] = 'Saint Vincent and the Grenadines';
		$countries['VE'] = 'Venezuela';
		$countries['VG'] = 'British Virgin Islands';
		$countries['VI'] = 'US Virgin Islands';
		$countries['VN'] = 'Vietnam';
		$countries['VU'] = 'Vanuatu';
		$countries['WF'] = 'Wallis and Futuna';
		$countries['WS'] = 'Samoa';
		$countries['XK'] = 'Kosovo';
		$countries['YE'] = 'Yemen';
		$countries['YT'] = 'Mayotte';
		$countries['ZA'] = 'South Africa';
		$countries['ZM'] = 'Zambia';
		$countries['ZW'] = 'Zimbabwe';

		return $countries;
	}


	public static function getProvinceList() {

		return [
			'AG' => 'Agrigento',
			'AL' => 'Alessandria',
			'AN' => 'Ancona',
			'AO' => 'Aosta',
			'AR' => 'Arezzo',
			'AP' => 'Ascoli Piceno',
			'AT' => 'Asti',
			'AV' => 'Avellino',
			'BA' => 'Bari',
			'BT' => 'Barletta-Andria-Trani',
			'BL' => 'Belluno',
			'BN' => 'Benevento',
			'BG' => 'Bergamo',
			'BI' => 'Biella',
			'BO' => 'Bologna',
			'BZ' => 'Bolzano',
			'BS' => 'Brescia',
			'BR' => 'Brindisi',
			'CA' => 'Cagliari',
			'CL' => 'Caltanissetta',
			'CB' => 'Campobasso',
			'CI' => 'Carbonia-Iglesias',
			'CE' => 'Caserta',
			'CT' => 'Catania',
			'CZ' => 'Catanzaro',
			'CH' => 'Chieti',
			'CO' => 'Como',
			'CS' => 'Cosenza',
			'CR' => 'Cremona',
			'KR' => 'Crotone',
			'CN' => 'Cuneo',
			'EN' => 'Enna',
			'FM' => 'Fermo',
			'FE' => 'Ferrara',
			'FI' => 'Firenze',
			'FG' => 'Foggia',
			'FC' => 'Forlì-Cesena',
			'FR' => 'Frosinone',
			'GE' => 'Genova',
			'GO' => 'Gorizia',
			'GR' => 'Grosseto',
			'IM' => 'Imperia',
			'IS' => 'Isernia',
			'SP' => 'La Spezia',
			'AQ' => 'L\'Aquila',
			'LT' => 'Latina',
			'LE' => 'Lecce',
			'LC' => 'Lecco',
			'LI' => 'Livorno',
			'LO' => 'Lodi',
			'LU' => 'Lucca',
			'MC' => 'Macerata',
			'MN' => 'Mantova',
			'MS' => 'Massa-Carrara',
			'MT' => 'Matera',
			'ME' => 'Messina',
			'MI' => 'Milano',
			'MO' => 'Modena',
			'MB' => 'Monza e della Brianza',
			'NA' => 'Napoli',
			'NO' => 'Novara',
			'NU' => 'Nuoro',
			'OT' => 'Olbia-Tempio',
			'OR' => 'Oristano',
			'PD' => 'Padova',
			'PA' => 'Palermo',
			'PR' => 'Parma',
			'PV' => 'Pavia',
			'PG' => 'Perugia',
			'PU' => 'Pesaro e Urbino',
			'PE' => 'Pescara',
			'PC' => 'Piacenza',
			'PI' => 'Pisa',
			'PT' => 'Pistoia',
			'PN' => 'Pordenone',
			'PZ' => 'Potenza',
			'PO' => 'Prato',
			'RG' => 'Ragusa',
			'RA' => 'Ravenna',
			'RC' => 'Reggio Calabria',
			'RE' => 'Reggio Emilia',
			'RI' => 'Rieti',
			'RN' => 'Rimini',
			'RM' => 'Roma',
			'RO' => 'Rovigo',
			'SA' => 'Salerno',
			'VS' => 'Medio Campidano',
			'SS' => 'Sassari',
			'SV' => 'Savona',
			'SI' => 'Siena',
			'SR' => 'Siracusa',
			'SO' => 'Sondrio',
			'TA' => 'Taranto',
			'TE' => 'Teramo',
			'TR' => 'Terni',
			'TO' => 'Torino',
			'OG' => 'Ogliastra',
			'TP' => 'Trapani',
			'TN' => 'Trento',
			'TV' => 'Treviso',
			'TS' => 'Trieste',
			'UD' => 'Udine',
			'VA' => 'Varese',
			'VE' => 'Venezia',
			'VB' => 'Verbano-Cusio-Ossola',
			'VC' => 'Vercelli',
			'VR' => 'Verona',
			'VV' => 'Vibo Valentia',
			'VI' => 'Vicenza',
			'VT' => 'Viterbo'
		];
	}

}
