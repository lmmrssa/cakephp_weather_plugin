<?php
/**
 * WeatherHelper is the helper to the get weather info of weather.com
 * using api.wunderground.com
 *
 * @author: Laxman Maharjan
 * @version: 0.0.1
 * @email: email@mlaxman.com.np
 * @link: http://github.com/lmmrssa
 *
 */
App::uses('WeatherLib', 'KhumWeather.Lib');
App::uses('AppHelper','View/Helper');
class WeatherHelper extends AppHelper{
	var $helpers = array('Html', 'Form', 'Cache');
	var $settings = array();
	var $requestUrl = '';
	var $data = false;
	var $weatherLib = '';
	
	function __construct(View $View, $options = array()){
		$this->weatherLib = new WeatherLib;
		//setup settings
		$this->settings = array_merge($this->weatherLib->defaults, $options);
		$this->weatherLib->settings = $this->settings;
		parent::__construct($View, $options);
		$this->weatherLib->request = $this->request;
		$this->weatherLib->validate();
		if($this->settings['cacheDuration']) {
			Cache::config('khumWeather', array(
						'engine' => $this->settings['cacheEngine'],
					 	'prefix' => 'Khum_',
						'path' => CACHE,
						'serialize' => ($this->settings['cacheEngine'] === 'File'),
						'duration'=> $this->settings['cacheDuration'], // 5 minutes
						'probability'=> 100,
					 	'lock' => false,
			));
		}
	}
	
	function _render($params = array()) {
		$returnView = '';
		if($this->settings['iconUrl']) {
			$imgUrl = $this->settings['iconUrl'];
			$imgUrl .= $this->weatherLib->data['current_observation']['icon'].'.gif';
		} else {
			$imgUrl = ($this->settings['SSL']) ? 'https://' : 'http://';
			$imgUrl .= $this->weatherLib->iconUrl;
			$imgUrl .= $this->settings['iconSet'].'/';
			$imgUrl .= $this->weatherLib->data['current_observation']['icon'].'.gif';
		}
		if(!empty($this->weatherLib->data['current_observation'])) {
			$returnView .= $this->Html->image($imgUrl, array('alt' => $this->weatherLib->data['current_observation']['weather']));
			$returnView .= $this->Html->tag('span', $this->weatherLib->data['current_observation']['weather'], array('class' => 'weather-info'));
			if(!empty($this->weatherLib->data['current_observation']['temp_'.$params['temp']]))
				$returnView .= $this->Html->tag('span', $this->weatherLib->data['current_observation']['temp_'.$params['temp']].'&deg;'.strtoupper($params['temp']), array('class' => 'weather-info'));
			if(isset($params['link'])) return $this->Html->link($returnView, $params['link'], array('escape' => false));
		}
		return $returnView;
	}

	function weather($query = '', $options = array()) {
		if(!empty($options)) {
			if(isset($options['apiKey'])) $this->settings['apiKey'] = $options['apiKey'];
			if(isset($options['feature'])) $this->settings['feature'] = $options['feature'];
			if(isset($options['settings'])) $this->settings['settings'] = $options['settings'];
			//if(isset($options['query'])) $this->settings['query'] = $options['query'];
			if(isset($options['format'])) $this->settings['format'] = $options['format'];
			if(isset($options['iconUrl'])) $this->settings['iconUrl'] = $options['iconUrl'];
			if(isset($options['iconSet'])) $this->settings['iconSet'] = $options['iconSet'];
			if(isset($options['return'])) $this->settings['return'] = $options['return'];
			$this->weatherLib->settings = $this->settings;
			$this->weatherLib->validate();
		}
		if($this->weatherLib->error) {
			return $this->displayError();
		}
		$this->weatherLib->generateUrl($query);
		$this->weatherLib->getData();
		if($this->weatherLib->error) {
			return $this->displayError();
		}
		if($this->settings['return'] == 'html') {
			$params['temp'] = isset($options['temp']) ? $options['temp'] : 'c';
			if(isset($options['link'])) $params['link'] = $options['link'];
			return $this->_render($params);
		} else {
			return $this->weatherLib->data;
		}
	}
	
	function displayError() {
		if($this->settings['return'] == 'html') {
			$returnError = implode($this->weatherLib->error, '<br/>');
		} elseif($this->settings['return'] == 'response') {
			if($this->settings['format'] == 'json') {
				$returnError = json_encode($this->weatherLib->error);
			} elseif($this->settings['format'] == 'xml') {
				$returnError = '<response>';
				foreach($this->error as $err) {
					$returnError .= '<error>'.$err.'</error>';
				}
				$returnError .= '</response>';
			}
		}
		return $returnError;
	}
	
}
?>