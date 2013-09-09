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
* Displays weather using api from http://www.wunderground.com
* For free account http://www.wunderground.com gives limitation so cache option available to hit url on that time interval


Installation
----------------
* Copy the entire /KhumWeather/ directory into your /plugins/ directory.
* In helper list add KhumWeather.Weather with options
* options for KhumWeather.Weather

1. __apiKey__ : key from http://www.wunderground.com (default: null; accepts: string of key from wunderground)
2. __SSL__ : true to enable https (default: false; accepts: true, false)
3. __apiUrl__ : to change apiUrl to use from another api need to give complete url (default: false; accepts: string of url for api)
4. __feature__ : feature of api (default: empty; accpets: string of feature)
5. __settings__ : extra parameters on request url for api (default: empty; accpets: string of options)
6. __format__ : format of response from api (default: json; accepts: json, xml)
7. __requestType__ : request type for the api (default: null; accepts: curl)
8. __iconUrl__ : url to fetch icon from (default: false; accepts: string of url)
9. __iconSet__ : set of icon to use (default: a)
10. __return__ : format to return data by helper (default: html; accepts: html, array, response)
11. __cacheEngine__ : format of cache engine to be used for cache purpose (default: File; accepts: types of cache from cakephp)
12. __cacheDuration__ : duration of cache (default: false; accepts: time number in seconds)
13. __bindDomain__ : to bind the key within domain useful in multidomain and testing not to use same key(default: false)

### Sample Code

	'KhumWeather.Weather' => array('apiKey' => 'a1b2keyc3', 'feature' => 'conditions', 'requestType' => 'curl', 'cacheDuration' => 300, 'domainBind' => 'example.com')
	
put your key from wunderground and your domain
