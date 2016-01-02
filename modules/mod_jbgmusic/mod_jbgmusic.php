<?php
/**
* version 1.0 JBGMusic
* @copyright Copyright (C) 2008 Jfriendly.net. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* 
* <object type="audio/mpeg" data="data/test.mp3" width="200" height="20">
*  <param name="src" value="data/test.mp3">
*  <param name="autoplay" value="false">
*  <param name="autoStart" value="0">
*  alt : <a href="data/test.mp3">test.mp3</a>
*</object>
*
*
*     <audio id="jbgmodule'.$module->id.'" preload="auto">
*		<source src="'.$jaudio.'.ogg" type="audio/ogg" />
*		<source src="'.$jaudio.'.mp3" type="audio/mp3" />
*   </audio>';	
*  jbgaudio'.$module->id.'=document.getElementById("jbgmodule'.$module->id.'");
*
*/


// no direct access
defined('_JEXEC') or die('Restricted access');

$JVersion = 3.0;
if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
   $JVersion = 3.0;
}


require_once dirname(__FILE__).DS.'includes'.DS.'support_license.php';
require_once dirname(__FILE__).DS.'includes'.DS.'helper.php';


// Add the path parameter if the path is different than 'media/system/js/'
$path = JText::_("modules/mod_jbgmusic");

if ($JVersion < 3.0){
	JHTML::stylesheet('buttons.css', $path."/css/");
	JHTML::script('soundfunction.js', $path."/js/");
} else {
  	JHTML::stylesheet($path.'/css/buttons.css');
	JHTML::script($path.'/js/soundfunction.js');
}

//$url = JURI::base(true).DS;
$url = JURI::base();


// Set Local Environment variables
$JUSER_AGENT = $_SERVER['HTTP_USER_AGENT'];
$ip = str_replace(".","", $_SERVER['REMOTE_ADDR']);


$browser = modJBGMusicHelper::detectBrowser(); 

if ($browser['name'] === 'msie' && $browser['version'] < 9.0) {
  $use_flash_player = 1;
}elseif ($browser['name'] === 'safari' && $browser['version'] < 4.0) {
  $use_flash_player = 1;
}elseif ($browser['name'] === 'safari' && $browser['platform'] === 'windows' && $browser['version'] < 6.0) {
  $use_flash_player = 1;
}elseif ($browser['name'] === 'firefox' && $browser['version'] < 4.0) {
  $use_flash_player = 1;
}elseif ($browser['name'] === 'opera' && $browser['platform'] === 'windows') {
  $use_flash_player = 1;
}else {
  $use_flash_player = 0;
}

//echo $browser['name'].'<br />';
//echo $browser['version'].'<br />';
//echo $browser['platform'].'<br />';
//echo $use_flash_player.'<br />';


$OPERATING_SYSTEM = 'O';
if (preg_match ("/Windows/i", $JUSER_AGENT)) $OPERATING_SYSTEM = 'W';
if (preg_match ("/Linux/i", $JUSER_AGENT)) $OPERATING_SYSTEM = 'L';

if ($OPERATING_SYSTEM == 'O') $LINE_BRK = "\r";
if ($OPERATING_SYSTEM == 'W') $LINE_BRK = "\r\n";
if ($OPERATING_SYSTEM == 'L') $LINE_BRK = "\n";


$u =& JURI::getInstance( JURI::base () );
$thisuri = '&amp;thisuri='.str_replace('www.', '', strtolower ($u->getHost ()));
$thismodule = '&amp;thismodule=jbgmusic';

$JBGParams = modJBGMusicHelper::getJBGMusicParams ($params);

$moduleclass_sfx = $params->get('moduleclass_sfx', '');
$jsound_location = $params->get('jsound_location', '');
$jaudio_files = $params->get('jsound_file', '');
$jrandom_play = $params->get('jrandom_play', '1');
$jshuffle_play = $params->get('jshuffle_play', '1');
$jauto_resume = $params->get('jautoresume', '1');
$jtemp_location = $params->get('jtemp_location', '');
$jbutton_color = $params->get('jbutton_color', '');
$jhide_controls = $params->get('jhidden_controls', '0');
$junique_key = '&amp;unique_key='.$params->get('jkeycode', '');

$jaudio_list = explode(',', $jaudio_files);
$jaudio_hash = md5 ($jaudio_files);


modJBGMusicHelper::cleanJBGMusicOldFiles ($jtemp_location);

// choose player
if ($params->get('jplayertype')){
    $jplayer = 'xspf_player_small.swf';
    $jplayer_type = "&amp;playertype=small";
}
else{
    $jplayer = 'xspf_player_slim.swf';
    $jplayer_type = "&amp;playertype=full";
}


$jsound_files = trim($jaudio_list[0]);

// Create a new audio list
if ($jrandom_play == '0'){
    $jsound_files = $jaudio_list[rand(0,(count($jaudio_list) - 1))];
}


// Get first audio from list
$extension = array (".ogg", ".mp3", ".wav");
// check if valid url
if (preg_match ("/^http:|^ftp:/i", $jaudio_list[0]))
{
    $jaudio = str_replace($extension, '', trim($jaudio_list[0]));
}
 else{
    $jaudio = str_replace($extension, '', $url.$jsound_location.'/'.trim($jaudio_list[0]));
}

if ($params->get('jloop_sound')){
   $jloopy = "&amp;repeat_playlist=true";
   $jloop_sound = 1;
}
else{
   $jloopy = "";
   $jloop_sound = 0;
}

if ($params->get('jforce_flash')) {
  $use_flash_player = 1;
}

$turn_off_alert_status = false;
if ($params->get('jalert_status')) {
  $turn_off_alert_status = true;
}


if ($params->get('jautostart')){
   $jautostart = '&amp;autoplay=true';
   $jautoplay = 1;
}
else{
   $jautostart = "";
   $jautoplay = 0;
}

if ($params->get('jautoresume')){
   $jautoresume = '&amp;autoresume=1';
   $jresumeaudio = 1;
}
else{
   $jautoresume = "";
   $jresumeaudio = 0;
}

//Get Flash Player Height
list($jflashplayer_width, $jflashplayer_height, $type, $attr) = getimagesize($url.'modules/mod_jbgmusic/swf/'.$jplayer);
$jplaylist = "";
$jplayer_height = $jflashplayer_height - 16;
$notFound = ',';
if ( c_VerifyLicense::of_CheckLicense ($module->id,$jloop_sound, $jplaylist, $notFound, $params->get('jkeycode', ''), "JBGMusic", false))
{
    if (!$jplayer_height <= 1) $jflashplayer_height = $jflashplayer_height - 16;
}


if ($params->get('jhidden_controls'))
{
   $jplayer = 'xspf_player_small.swf';
   $jplayer_type = "&amp;playertype=small";
   $jhide_player = "&amp;hideplayer=true";
   $jautostart = "&amp;autoplay=true";
   $jflashplayer_height = $jflashplayer_height - $jplayer_height;
}
else
{   
   $jhide_player = "&amp;hideplayer=false";
}

// create shuffle playlist
if ($jshuffle_play == '1') shuffle($jaudio_list);



// create a new .xspf file

// $keywords = explode(".", JText::_($jsound_files));

// create a unique file using ip, year, month, date, and Hour


$File = $jtemp_location.'/'.$ip.$module->id.'jbg.xspf';
$FileHash = $jtemp_location.'/'.$ip.$module->id.'jbg.hsh';


//Check for audio list differences
$jplaylist = "!change!";  
defined('jfile') or die;
if (file_exists($FileHash)){
   $Handle = fopen($FileHash, 'r');
   $jstored_hash = trim(fgets ($Handle));
   $jplaylist = trim(fgets ($Handle));
   fclose ($Handle);
   if ($jstored_hash <> $jaudio_hash){ 
        unlink ($File);
        unlink ($FileHash);  
	$jplaylist = "!change!";  
   }
}

$notFound = ',';
// create playlist for HTML5 player
if ($jplaylist == "!change!") {
	$jplaylist = "";
	if ($jrandom_play == '0'){

	    // check if valid url
	    if (preg_match ("/^http:|^ftp:/i", $jsound_files))
	    {
	       $Data = str_replace($extension, '', trim($jsound_files));
               $tData = "";
	    }
	    else{
	       $Data = str_replace($extension, '', trim($url.$jsound_location.'/'.trim($jsound_files)));
               $tData = str_replace($extension, '', trim($jsound_location.'/'.trim($jsound_files)));
	    }           
        
            $jplaylist = $jplaylist.$Data;
             
            if ($tData <> ""){
		    if (!file_exists($tData.'.ogg')){
		       $notFound = $notFound.$tData.'.ogg,';
		    }

		    if (!file_exists($tData.'.mp3')){
		       $notFound = $notFound.$tData.'.mp3,';
		    }    
            }           
	    

	}
	else
	{
		$i = 0;
		foreach ($jaudio_list as $value){
		
			if (preg_match ("/^http:|^ftp:/i", $value)){
				$Data = str_replace($extension, '', trim($value));
                                $tData = "";
		    	}
			else{
			$Data = str_replace($extension, '', trim($url.$jsound_location.'/'.trim($value)));
              		$tData = str_replace($extension, '', trim($jsound_location.'/'.trim($value)));
		  	}  
			$jplaylist = $jplaylist.$Data.',';
			$i = $i + 1;
                        
		}
		$jplaylist = substr($jplaylist, 0, strlen($jplaylist) - 1);   
         
           if ($tData <> ""){
		    if (!file_exists($tData.'.ogg')){
		       $notFound = $notFound.$tData.'.ogg,';
		    }

		    if (!file_exists($tData.'.mp3')){
		       $notFound = $notFound.$tData.'.mp3,';
		    }    
            }      
                
        }
}

if ($turn_off_alert_status) {
  $notFound = ',';
}

$notFound = substr($notFound, 1, strlen($notFound) - 1);

// echo $notFound;

if (!file_exists($File)) {
        $Handle = fopen($FileHash, 'w');
        fwrite ($Handle, $jaudio_hash.$LINE_BRK);
        fwrite ($Handle, $jplaylist.$LINE_BRK);
        fclose ($Handle);

	$Handle = fopen($File, 'w');


	fwrite ($Handle, '<?xml version="1.0" encoding="UTF-8"?>'.$LINE_BRK);
	fwrite ($Handle, '<playlist version="1" xmlns="http://xspf.org/ns/0/">'.$LINE_BRK);
	fwrite ($Handle, '<title>Powered by JBGMusic</title>'.$LINE_BRK);
	fwrite ($Handle, '<trackList>'.$LINE_BRK);



	if ($jrandom_play == '0'){

	    // check if valid url
	    if (preg_match ("/^http:|^ftp:/i", $jsound_files))
	    {
	       $Data = trim($jsound_files);
	    }
	    else{
	       $Data = $url.$jsound_location.'/'.trim($jsound_files);
	    }

           fwrite($Handle, "<track>".$LINE_BRK);
           fwrite($Handle, "<title>".$jsound_files."</title>".$LINE_BRK);
           fwrite($Handle, "<location>".$Data."</location>".$LINE_BRK);
	   fwrite($Handle, "</track>".$LINE_BRK);
	}
	else
	{	
           
              
	   $i = 0;	  
	   foreach ($jaudio_list as $value){
		
		 if (preg_match ("/^http:|^ftp:/i", $value))
		{
		     $Data = trim($value);
		}
		else{
		     $Data = $url.$jsound_location.'/'.trim($value);
		}

                fwrite($Handle, "<track>".$LINE_BRK);
                fwrite($Handle, "<title>".$value."</title>".$LINE_BRK);
                fwrite($Handle, "<location>".$Data."</location>".$LINE_BRK);
	        fwrite($Handle, "</track>".$LINE_BRK);

	       	$i = $i + 1;
	   }
           
	}


	fwrite ($Handle, '</trackList>'.$LINE_BRK);
	fwrite ($Handle, '</playlist>'.$LINE_BRK);
	fclose($Handle); 
}

// Prepare HTML5 player
  if ($use_flash_player == 0){
        
        // Verify Unique Key
        c_VerifyLicense::of_CheckLicense ($module->id,$jloop_sound, $jplaylist, $notFound, $params->get('jkeycode', ''), "JBGMusic", true);
	echo '<script>setupSound(jbgaudio'.$module->id.',jbgattrib'.$module->id.','.$jautoplay.','.$jresumeaudio.');</script>';



	// Show HTML5 Controls
	  if ($jhide_controls == '0' && $use_flash_player == 0)
	       echo '<div class="JBGHTML5Background">
		     <div class="JBGHTML5Player">
		     <a href="#" onclick="javascript:playSound(jbgaudio'.$module->id.',jbgattrib'.$module->id.'); return false;"  class="'.$jbutton_color.'"><img src="'.$url.'modules/mod_jbgmusic/images/play_bn.png" height="10" width="10" border=0/></a>
		     <a href="#" onclick="javascript:pauseSound(jbgaudio'.$module->id.',jbgattrib'.$module->id.'); return false;" class="'.$jbutton_color.'"><img src="'.$url.'modules/mod_jbgmusic/images/pause_bn.png" height="10" width="10" border=0/></a> 
		     <a href="#" onclick="javascript:decreaseSoundVolume(jbgaudio'.$module->id.',jbgattrib'.$module->id.'); return false;"  class="'.$jbutton_color.'"><img src="'.$url.'modules/mod_jbgmusic/images/volume-dn.png" height="10" width="10" border=0/></a> 
		     <a href="#" onclick="javascript:increaseSoundVolume(jbgaudio'.$module->id.',jbgattrib'.$module->id.'); return false;" class="'.$jbutton_color.'"><img src="'.$url.'modules/mod_jbgmusic/images/volume-up.png" height="10" width="10" border=0/></a>
		    </div>
		    </div>';
}


// Use Legacy Flash player
  if ($use_flash_player == 1)
       echo '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="'.$jflashplayer_width.'" height="'.$jflashplayer_height.'" id="mod_jbgplayer_<?php echo mt_rand()?>" align="middle">
			<param name="movie" value="'.$url.'modules/mod_jbgmusic/swf/'.$jplayer.'?playlist_url='.$url.$File.$thisuri.$thismodule.$jplayer_type.$jautostart.$jloopy.$jhide_player.$jautoresume.$junique_key.'" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="#ffffff" />
			<param name="play" value="true" />
			<param name="loop" value="true" />
			<param name="wmode" value="transparent" />
			<param name="scale" value="showall" />
			<param name="menu" value="true" />
			<param name="devicefont" value="false" />
			<param name="salign" value="" />
			<param name="allowScriptAccess" value="sameDomain" />
				<!--[if !IE]>-->
			<object type="application/x-shockwave-flash" data="'.$url.'modules/mod_jbgmusic/swf/'.$jplayer.'?playlist_url='.$url.$File.$thisuri.$thismodule.$jplayer_type.$jautostart.$jloopy.$jhide_player.$jautoresume.$junique_key.'" width="'.$jflashplayer_width.'" height="'.$jflashplayer_height.'">
				<param name="movie" value="xspf_player_small.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#ffffff" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="transparent" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowScriptAccess" value="sameDomain" />
				<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflash">
					<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					</a>
				<!--[if !IE]>-->
			</object>
				<!--<![endif]-->
		</object>';

?>



      










 


