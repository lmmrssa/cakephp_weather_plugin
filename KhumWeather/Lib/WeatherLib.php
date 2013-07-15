<?php
class WeatherLib {
	var $settings = '';
	var $requestUrl = '';
	var $data = false;
	var $error = false;
	
	var $iconUrl = 'icons-ak.wxug.com/i/c/';
	var $apiUrl = 'api.wunderground.com/api/';
	var $defaults = array(
		'apiKey' => '',
		'SSL' => false,
		'apiUrl' => false,
		'feature' => '',
		'settings' => '',
		'format' => 'json',
		'requestType' => '',
		'iconUrl' => false,
		'iconSet' => 'a',
		'return' => 'html', // html, array, response
		'cacheEngine' => 'File',
		'cacheDuration' => false,
	);

	var $formatType = array('json', 'xml');
	var $returnType = array('html', 'array', 'response');
	var $iconSet = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k');
	var $iconList = array(
		/* Day Set */
		'chanceflurries.gif', 'chancerain.gif', 'chancesleet.gif', 'chancesnow.gif',
		'chancetstorms.gif', 'clear.gif', 'cloudy.gif', 'flurries.gif',
		'fog.gif', 'hazy.gif', 'mostlycloudy.gif', 'mostlysunny.gif',
		'partlycloudy.gif', 'partlysunny.gif', 'rain.gif', 'sleet.gif',
		'snow.gif', 'sunny.gif', 'tstorms.gif',
		/* Night Set */
		'nt_chanceflurries.gif', 'nt_chancerain.gif', 'nt_chancesleet.gif', 'nt_chancesnow.gif',
		'nt_chancetstorms.gif', 'nt_clear.gif', 'nt_cloudy.gif', 'nt_flurries.gif',
		'nt_fog.gif', 'nt_hazy.gif', 'nt_mostlycloudy.gif', 'nt_mostlysunny.gif',
		'nt_partlycloudy.gif', 'nt_partlysunny.gif', 'nt_rain.gif', 'nt_sleet.gif',
		'nt_snow.gif', 'nt_sunny.gif', 'nt_tstorms.gif'
	);

	function generateUrl($query = '') {
		if($this->settings['apiUrl']) {
			$this->requestUrl = $this->settings['apiUrl'];
		} else {
			$this->requestUrl = ($this->settings['SSL']) ? 'https://' : 'http://';
			$this->requestUrl .= $this->apiUrl.$this->settings['apiKey'].'/';
			$this->requestUrl .= $this->settings['feature'].'/';
			$this->requestUrl .= $this->settings['settings'].'/';
			$this->requestUrl .= 'q/'.$query.'.'.strtolower($this->settings['format']);
		}
	}

	function getData() {
		if(!$this->settings['cacheDuration'] ||
		 (Cache::read('khumWeather.requestUrl') !== $this->requestUrl) ||
		 (($detail = Cache::read('khumWeather.data')) === false)) {
			debug('ok');
			if(strtolower($this->settings['requestType']) == 'curl') {
				$curlHandler = curl_init();
				$defaults = array(
					CURLOPT_HEADER => 0,
					CURLOPT_URL => $this->requestUrl,
					CURLOPT_FRESH_CONNECT => 1,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_FORBID_REUSE => 1,
					CURLOPT_TIMEOUT => 4,
				);
				curl_setopt_array($curlHandler, $defaults);
				$detail = curl_exec($curlHandler);
				if(curl_errno($curlHandler)){
					$this->error[] = 'Curl error: ' . curl_error($curlHandler);
				}
				curl_close($curlHandler);
			} else {
				$detail = file_get_contents($this->requestUrl);
			}
			if($this->settings['cacheDuration']) {
				Cache::write('khumWeather.data', $detail, 'khumWeather');
				Cache::write('khumWeather.requestUrl', $this->requestUrl, 'khumWeather');
			}
		}
		
		// For now xml does not have array or view
		if($this->settings['return'] == 'response' || $this->settings['format'] == 'xml') {
			$this->data = $detail;
		} else {
			if($this->settings['format'] == 'json') {
				$this->data = json_decode($detail, true);
				if(isset($this->data['response']['error'])) {
					$this->data = false;
					$this->error[] = $this->data['response']['error']['description'];
				}
				if(isset($this->data['cod']) && $this->data['cod'] == '404') {
					$this->data = false;
				}
			} if($this->settings['format'] == 'xml') {
			
			}
			if($this->settings['return'] == 'array') {
				$this->data = $this->transformData($this->settings['format']);
			}
		}
	}

	function transformData() {
		
	}

	function validate() {
		$this->error = array();
		if(empty($this->settings['apiKey'])) $this->error[] = 'Setup Error: Require apiKey.';
		if(!in_array($this->settings['return'], $this->returnType)) $this->error[] = 'Setup Error: Not valid return. Only accepts (\'html\', \'array\', \'response\').';
		if(!in_array($this->settings['format'], $this->formatType)) $this->error[] = 'Setup Error: Not valid format. Only accepts (\'json\', \'xml\').';
		if(!in_array($this->settings['iconSet'], $this->iconSet)) $this->error[] = 'Setup Error: Not valid icon set. Only accepts (\'a\', \'b\', \'c\', \'d\', \'e\', \'f\', \'g\', \'h\', \'i\', \'j\', \'k\').';
	}

}
?>