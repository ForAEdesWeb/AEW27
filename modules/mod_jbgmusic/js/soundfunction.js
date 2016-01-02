<!--
function JBGSound(storageUnit, loopSound, playList, notFound) {
    var notFoundFiles;
    var nfiles = ''; 

    this.storageUnit = storageUnit;
    this.trackName = "unique trackName";
    this.trackNo = 0;
    this.nowTime = 0;
    this.playStatus = 1;
    this.firstPlay = 1;
    this.volumeLevel = 1;
    this.loopSound = loopSound;
    this.lastDateUsed = new Date();
    this.nextPlayTime = this.lastDateUsed;  
    this.playList = playList;
    
    if (notFound != null){
        if (notFound.length > 0){
		notFoundFiles = notFound.split(',');
		for (var i = 0; i < notFoundFiles.length; i++){
		     nfiles = nfiles + notFoundFiles [i] + "\n";
		}
		alert ("The following files are not found:\n\n" + nfiles + "\n\nBoth audio versions must exist for cross browser compatibility.");
        }
    }
}

function retrieveStoredSound(audioObject, audioAttrib, autoPlaySound, autoResumeSound) {
    var retrievedObject = localStorage.getItem(audioAttrib.storageUnit);
    var arr = new Array("storageUnit", "trackName", "trackNo", "nowTime", "playStatus", "firstPlay", "volumeLevel", "loopSound", "lastDateUsed","nextPlayTime","playList");
    var localSoundValid = 0;
    var localaudioAttrib = new JBGSound(audioAttrib.storageUnit, 1, ' ');


    if (retrievedObject == null) {
        localStorage.setItem(audioAttrib.storageUnit, JSON.stringify(audioAttrib));
    } else {
        for (var i = 0; i < arr.length; i++) {
            var value = arr[i];
            if (retrievedObject.search(value) > 0) {
                localSoundValid += 1;
            }
        }
        if (localSoundValid == arr.length) {
            localaudioAttrib = JSON.parse(retrievedObject);
            audioAttrib.storageUnit = localaudioAttrib.storageUnit;
            audioAttrib.trackName = localaudioAttrib.trackName;
            audioAttrib.trackNo = localaudioAttrib.trackNo;
            if (autoResumeSound === 1) {
                audioAttrib.nowTime = localaudioAttrib.nowTime;
            } else {
                audioAttrib.nowTime = 0;
            }
            if (autoPlaySound === 1 && localaudioAttrib.playStatus === 1 ) {
                audioAttrib.playStatus = 1;
            } else {
                audioAttrib.playStatus = localaudioAttrib.playStatus;
            }
            audioAttrib.firstPlay = 1; //set to first play
            audioAttrib.volumeLevel = localaudioAttrib.volumeLevel;
            audioAttrib.loopSound = localaudioAttrib.loopSound;
            audioAttrib.lastDateUsed = localaudioAttrib.lastDateUsed;
            audioAttrib.nextPlayTime = localaudioAttrib.nextPlayTime;
            
            if (audioAttrib.playList != localaudioAttrib.playList){
               
            	audioAttrib.trackNo = 0; // reset to the first track
                audioAttrib.nowTime = 0; // reset to start time
                localStorage.setItem(audioAttrib.storageUnit, JSON.stringify(audioAttrib));
            }
            else {
            	audioAttrib.playList = localaudioAttrib.playList;
           	audioAttrib.trackNo = localaudioAttrib.trackNo;
            }
        } else {
            localStorage.removeItem(audioAttrib.storageUnit);
            localStorage.setItem(audioAttrib.storageUnit, JSON.stringify(audioAttrib));
        }
    }
}



function checkLastUsed(audioAttrib) {
    var now = new Date();
    var nextPlayTime = new Date(audioAttrib.nextPlayTime);
    var nowTime = now.getTime ();
    var playTime = nextPlayTime.getTime ();

    var lastDateUsed = new Date(audioAttrib.lastDateUsed);
    var elapsed_time = nextPlayTime - lastDateUsed;

    if (elapsed_time > 0 ) {
       if (nowTime >= playTime) {        
		audioAttrib.lastDateUsed = now;
		audioAttrib.nextPlayTime = now;
		audioAttrib.nowTime = 0;
	    }
	    else{
		return 0;
	    }
    }
    return 1;

}


function loadAudioTrack(audioObject, audioAttrib) {

    var myPlaylist = audioAttrib.playList.split(','); 

	// set audio object to the current track chosen
    if (audioObject.canPlayType ("audio/mp3") === "") {
    	audioObject.src = myPlaylist [audioAttrib.trackNo] + ".ogg";
    }
    else {
        audioObject.src = myPlaylist [audioAttrib.trackNo] + ".mp3";
    }
	// Set autoplay status of audio object
	audioObject.autoplay=false;
	if (audioAttrib.playStatus == 1 && checkLastUsed(audioAttrib) === 1) {
	    audioObject.volume = 0; // set to no sound temporarily
        audioObject.autoplay=true;
    }
	// load audio
    audioObject.load();
}

function playSound(audioObject, audioAttrib) {
    audioObject.play();
	audioAttrib.playStatus = 1;    
}

function pauseSound(audioObject, audioAttrib) {
    audioObject.pause();
    audioAttrib.playStatus = 0;
    localStorage.setItem(audioAttrib.storageUnit, JSON.stringify(audioAttrib));
}

function decreaseSoundVolume(audioObject, audioAttrib) {
    audioObject.volume -= 0.1;
    audioAttrib.volumeLevel = audioObject.volume;
    localStorage.setItem(audioAttrib.storageUnit, JSON.stringify(audioAttrib));
}

function increaseSoundVolume(audioObject, audioAttrib) {
    audioObject.volume += 0.1;
    audioAttrib.volumeLevel = audioObject.volume;
    localStorage.setItem(audioAttrib.storageUnit, JSON.stringify(audioAttrib));
}

function updateSound(audioObject, audioAttrib) {
    var now = new Date();

    if (audioAttrib.firstPlay === 1) {
        audioObject.currentTime = audioAttrib.nowTime;
        audioAttrib.firstPlay = 0;
    }
    audioObject.volume = audioAttrib.volumeLevel;
    audioAttrib.nowTime = audioObject.currentTime + 0.15;
    audioAttrib.lastDateUsed = now;
    audioAttrib.nextPlayTime = now;
    localStorage.setItem(audioAttrib.storageUnit, JSON.stringify(audioAttrib));
}

function endSound(audioObject, audioAttrib) {
    var now = new Date();
    var myPlaylist = audioAttrib.playList.split(','); 
    var allowed_time = (1000 * 60 * 60 * 3); // 3 hours

    audioAttrib.trackNo ++;      
    audioAttrib.nowTime = 0;
    audioAttrib.nextPlayTime = now;
    audioAttrib.lastDateUsed = now;
    if (audioAttrib.trackNo < myPlaylist.length){  
        localStorage.setItem(audioAttrib.storageUnit, JSON.stringify(audioAttrib));
		audioAttrib.playStatus = 1;
        loadAudioTrack(audioObject, audioAttrib);
    }
    else {
        audioAttrib.trackNo = 0;
        localStorage.setItem(audioAttrib.storageUnit, JSON.stringify(audioAttrib));
	if (audioAttrib.loopSound === 1) {
	    audioAttrib.playStatus = 1;
		loadAudioTrack(audioObject, audioAttrib)
	}
	else{
             audioAttrib.nextPlayTime = new Date(allowed_time + now.getTime());
             localStorage.setItem(audioAttrib.storageUnit, JSON.stringify(audioAttrib));
        }
    }
}

function setupSound(audioObject, audioAttrib, autoPlaySound, autoResumeSound) {
    retrieveStoredSound(audioObject, audioAttrib, autoPlaySound, autoResumeSound);
    checkLastUsed(audioAttrib);
    loadAudioTrack(audioObject, audioAttrib);
    audioObject.addEventListener('timeupdate', function () {
        updateSound(audioObject, audioAttrib)
    },false);
    audioObject.addEventListener('ended', function () {
        endSound(audioObject, audioAttrib)
    },false);
}
-->
