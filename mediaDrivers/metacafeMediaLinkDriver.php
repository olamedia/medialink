<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of metacafeMediaDriver
 * http://www.metacafe.com/watch/2974795/kawaii_girl_cosplay_yuki_nagato/
 * @author olamedia
 */
class metacafeMediaLinkDriver extends mediaLinkDriver{
	/**
	 * Try to load driver
	 * @param mediaLink $link
	 * @return boolean true if url can be parsed by this driver
	 */
	public function load(){
		if ($this->getDomainName()=='metacafe.com'){
			return true;
		}
		return false;
	}
	/**
	 * Get thumbnail image url
	 * http://s4.mcstatic.com/thumb/2974795.jpg
	 * @param mediaLink $link
	 * @return string Url of remote image file
	 */
	public function getPreviewUrl(){
		if ($videoId = $this->getVideoId()){
			return 'http://s'.rand(1, 4).'.mcstatic.com/thumb/'.$videoId.'.jpg';
		}
		return false;
	}
	public function getVideoId(){
		if (preg_match("#http://(www\.)?metacafe.com/watch/([a-z0-9\._-]+)/#ims", $this->getUrl(), $subs)){
			return $subs[2];
		}
		return false;
	}
	public function getEmbedUrl(){
		// flashVars: playerVars=showStats=no|autoPlay=yes|videoTitle=Kawaii Girl Cosplay Yuki Nagato
		//http://www.metacafe.com/fplayer/2974795/kawaii_girl_cosplay_yuki_nagato.swf
		if ($videoId = $this->getVideoId()){
			return 'http://www.metacafe.com/fplayer/'.$videoId.'/embed.swf';
		}
		return false;
	}
}

