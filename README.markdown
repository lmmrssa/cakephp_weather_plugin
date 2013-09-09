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
1. *apiKey* : key from http://www.wunderground.com (default: null; accepts: string of key from wunderground)
2. *SSL* : true to enable https (default: false; accepts: true, false)
3. *apiUrl* : to change apiUrl to use from another api need to give complete url (default: false; accepts: string of url for api)
4. *feature* : feature of api (default: empty; accpets: string of feature)
5. *settings* : extra parameters on request url for api (default: empty; accpets: string of options)
6. *format* : format of response from api (default: json; accepts: json, xml)
7. *requestType* : request type for the api (default: null; accepts: curl)
8. *iconUrl* : url to fetch icon from (default: false; accepts: string of url)
9. *iconSet* : set of icon to use (default: a)
10. *return* : format to return data by helper (default: html; accepts: html, array, response)
11. *cacheEngine* : format of cache engine to be used for cache purpose (default: File; accepts: types of cache from cakephp),
12. *cacheDuration* : duration of cache (default: false; accepts: time number in seconds)
13. *bindDomain* : to bind the key within domain useful in multidomain and testing not to use same key(default: false)

## Sample Code

	'KhumWeather.Weather' => array('apiKey' => 'a1b2keyc3', 'feature' => 'conditions', 'requestType' => 'curl', 'cacheDuration' => 300, 'domainBind' => 'example.com')
	
put your key from wunderground and your domain