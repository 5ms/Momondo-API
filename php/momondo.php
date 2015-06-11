<?php
/**
 * Momondo API (http://www.momondo.com/)
 *
 * @analyzed Secator.com
 * @author 5ms.ru
 * @link https://github.com/5ms/Momondo-API
 * @date 11.06.2015
 */

class Momondo {

	const LOG = false;

	const LANGUAGE = 'en';
	const CURRENCY = 'EUR';

	private static $proxy = '';     // TOR: 127.0.0.1:9050, Fiddler: 127.0.0.1:8888

	private static $endpoints = array(
		'currency' => 'http://android.momondo.com/api/3.0/Currency/List?all=all',
		'airports' => 'http://android.momondo.com/api/2.1/services.asmx/CompleteAirports',
		'search'   => 'http://android.momondo.com/api/3.0/FlightSearch',
		'calendar' => 'http://android.momondo.com/api/3.0/Flights.PriceCalendar/Post',
	);

	private static $options = array(
		CURLOPT_CONNECTTIMEOUT => 5,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 10,
		CURLOPT_ENCODING => 'gzip',
		CURLOPT_USERAGENT => 'Dalvik/1.6.0 (Linux; U; Android 4.4.4)',
		CURLOPT_HTTPHEADER => array('Accept-Language: en'),
	);

	public function __construct() { }

	/**
	 * Rate EUR:XXX
	 *
	 * @return bool|mixed
	 */
	public function currency() {
		return $this->call(self::$endpoints['currency']);
	}


	/**
	 * @param $text
	 * @return bool|mixed
	 */
	public function airport($text) {

		$data = array(
			'count' => '10',
			'language' => self::LANGUAGE,
			'prefixText' => $text,
		);

		return $this->call(self::$endpoints['airports'], $data);
	}

	/**
	 * @param $origin
	 * @param $destination
	 * @param $depart
	 * @param string $return
	 * @param string $adult
	 * @param string $class
	 * @param array $child
	 * @return array|bool
	 */
	public function search($origin, $destination, $depart, $return = '', $adult = '1', $class = 'ECO', $child = array()) {

		$url  = $this->search_url($origin, $destination, $depart, $return, $adult, $class, $child);

		return $url ? $this->search_results($url) : false;
	}

	/**
	 * @param $origin
	 * @param $destination
	 * @param $depart
	 * @param string $return
	 * @param string $adult
	 * @param string $class
	 * @param array $child
	 * @return bool|string
	 */
	public function search_url($origin, $destination, $depart, $return = '', $adult = '1', $class = 'ECO', $child = array()) {

		$data = array(
			'Culture'     => 'en-US',
			'Market'      => 'US',
			'Application' => 'Android',
			'Consumer'    => 'momondo',
			'Mix'         => 'NONE',
			'Mobile'      => true,
			'TicketClass' => $class,
			'AdultCount'  => $adult,
			'ChildAges'   => $child,
			'Segments'    => array(
				array(
					'Origin'      => $origin,
					'Destination' => $destination,
					'Departure'   => $depart,
				)
			),
		);

		if ($return != '') {
			$data['Segments'][] = array(
				'Origin'      => $destination,
				'Destination' => $origin,
				'Departure'   => $return,
			);
		}

		$data = $this->call(self::$endpoints['search'], $data);

		if (isset($data['SearchId']) && isset($data['EngineId'])) {
			return self::$endpoints['search'] . '/' . $data['SearchId'] . '/' . $data['EngineId'];
		}

		return false;
	}

	/**
	 * @param $url
	 * @return array|bool
	 */
	public function search_results($url) {

		$results = array();

		do {
			$data = $this->call($url);
			if (!$data) {
				return false;
			}
			$results[] = $data;
			sleep(3);
		} while (!isset($data['Done']) || !$data['Done']);

		return $results;
	}


	/**
	 * @param $origin
	 * @param $destination
	 * @param $date_from
	 * @param $date_to
	 * @return bool|mixed
	 */
	public function calendar($origin, $destination, $date_from, $date_to) {

		$data = array(
			'culture'       => self::LANGUAGE,
			'currency'      => self::CURRENCY,
			'destCode'      => $destination,
			'firstDate'     => $date_from,
			'origCode'      => $origin,
			'lastDate'      => $date_to,
			'maxStops'      => 2,
			'isMobile'      => false,
			'includeNearby' => true,
			'requestId'     => 14,
			'segment'       => 0,
			'segments'      => 1,
		);

		return $this->call(self::$endpoints['calendar'], $data);
	}


	/**
	 * @param $url
	 * @param null $data
	 * @return bool|mixed
	 */
	private function call($url, $data = null) {

		$ch = curl_init($url);

		$options = self::$options;

		if (!is_null($data)) {
			$options += array(
				CURLOPT_POST       => true,
				CURLOPT_POSTFIELDS => json_encode($data)
			);
			$options[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
		}

		if (self::$proxy != '') {
			$options += array(
				CURLOPT_PROXY     => self::$proxy,
//				CURLOPT_PROXYTYPE => CURLPROXY_SOCKS5   // for TOR
			);
		}

		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);

		self::LOG && $this->log($url, $options, $result, curl_getinfo($ch));

		if ($result === false || curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			curl_close($ch);
			return false;
		}

		curl_close($ch);

		$data = json_decode($result, true);
		return json_last_error() == JSON_ERROR_NONE ? $data : false;
	}

	/**
	 *
	 */
	private function log() {
		$dir = __DIR__ . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR;
		if (!is_dir($dir)) {
			mkdir($dir, 0777);
			chmod($dir, 0777);
		}
		if (is_writable($dir)) {
			file_put_contents($dir . microtime(true), print_r(func_get_args(), true));
		}
	}
}