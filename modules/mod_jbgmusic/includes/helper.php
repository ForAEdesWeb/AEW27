<?php
/**
* version 1.5 JBGMusic
* @copyright Copyright (C) 2008 Jfriendly.net. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* 
* <object type="audio/mpeg" data="data/test.mp3" width="200" height="20">
*  <param name="src" value="data/test.mp3">
*  <param name="autoplay" value="false">
*  <param name="autoStart" value="0">
*  alt : <a href="data/test.mp3">test.mp3</a>
*</object>

*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class modJBGMusicHelper
{

     function getJBGMusicParams (&$params)
     {
     }

     function cleanJBGMusicOldFiles (&$temp_dir)
     {
        // Clean up leftover .xspf created 3 hours ago.

	$dir = JPATH_BASE.DS.$temp_dir.DS ;
	$dp = opendir($dir) or die ('Could not open '.$dir);
	while (($filename = readdir($dp)) !== false) {
		if (preg_match("/jbg./i", $filename) && filemtime($dir.$filename) < strtotime ("-3 hours") ) unlink ($dir.$filename) ;
	
	}

	closedir($dp);
     }


     public static function detectBrowser() { 
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']); 

        // Identify the browser. Check Opera and Safari first in case of spoof. Let Google Chrome be identified as Safari. 
 

        if (preg_match('/chrome/', $userAgent)) { 
            $name = 'chrome';
        }elseif (preg_match('/opera/', $userAgent)) { 
            $name = 'opera'; 
        } 
        elseif (preg_match('/webkit/', $userAgent)) { 
             $name = 'safari'; 
        } 
        elseif (preg_match('/msie/', $userAgent)) { 
            $name = 'msie'; 
        }  
        elseif (preg_match('/firefox/', $userAgent)) { 
            $name = 'firefox'; 
        }  
        elseif (preg_match('/mozilla/', $userAgent) && !preg_match('/compatible/', $userAgent)) { 
            $name = 'mozilla'; 
        } 
        else { 
            $name = 'unrecognized'; 
        } 

        
        // What version? 
        if (preg_match('/.+(?:rv|it|ra|ie|chrome|firefox|version)[\/: ]([\d.]+)/', $userAgent, $matches)) { 
            $version = $matches[1]; 
        } 
        else { 
            $version = 'unknown'; 
        } 
        
        // Running on what platform? 
        if (preg_match('/linux/', $userAgent)) { 
            $platform = 'linux'; 
        } 
        elseif (preg_match('/macintosh|mac os x/', $userAgent)) { 
            $platform = 'mac'; 
        } 
        elseif (preg_match('/windows|win32/', $userAgent)) { 
            $platform = 'windows'; 
        } 
        else { 
            $platform = 'unrecognized'; 
        } 

        return array( 
            'name'      => $name, 
            'version'   => $version, 
            'platform'  => $platform, 
            'userAgent' => $userAgent
        ); 
    }

   
}




?>

