Khumbaya Weather Plugin
=================
About
-----
* website: https://github.com/lmmrssa/cakephp_weather_plugin/
* description: Displays weather using account from http://www.wunderground.com
* author: Laxman Maharjan (HT Solution Pvt. Ltd.)
* author website: http://mlaxman.com.np

Description
-----------------
*Displays weather using api from http://www.wunderground.com
*For free account http://www.wunderground.com gives limitation so cache option available to hit url on that time interval


Installation
----------------
* Copy the entire /KhumWeather/ directory into your /plugins/ directory.
* In helper list add KhumWeather.Weather with options
* options for KhumWeather.Weather
# *apiKey* : key from http://www.wunderground.com (default: null; accepts: string of key from wunderground)
# *SSL* : true to enable https (default: false; accepts: true, false)
# *apiUrl* : to change apiUrl to use from another api need to give complete url (default: false; accepts: string of url for api)
# *feature* : feature of api (default: empty; accpets: string of feature)
# *settings* : extra parameters on request url for api (default: empty; accpets: string of options)
# *format* : format of response from api (default: json; accepts: json, xml)
# *requestType* : request type for the api (default: null; accepts: curl)
# *iconUrl* : url to fetch icon from (default: false; accepts: string of url)
# *iconSet* : set of icon to use (default: a)
# *return* : format to return data by helper (default: html; accepts: html, array, response)
# *cacheEngine* : format of cache engine to be used for cache purpose (default: File; accepts: types of cache from cakephp),
# *cacheDuration* : duration of cache (default: false; accepts: time number in seconds)
# *bindDomain* : to bind the key within domain useful in multidomain and testing not to use same key(default: false)

* Sample Code

	'KhumWeather.Weather' => array('apiKey' => 'a1b2keyc3', 'feature' => 'conditions', 'requestType' => 'curl', 'cacheDuration' => 300, 'domainBind' => 'example.com')
	
put your key from wunderground and your domain