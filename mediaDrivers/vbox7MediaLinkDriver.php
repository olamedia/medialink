<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vbox7MediaLinkDriver
 * Bulgarian video hosting
 * http://www.vbox7.com/play:bac01584
 * @author olamedia
 */
class vbox7MediaLinkDriver extends mediaLinkDriver{
	/**
	 * Try to load driver
	 * @param mediaLink $link
	 * @return boolean true if url can be parsed by this driver
	 */
	public function load(){
		if ($this->getDomainName()=='vbox7.com'){
			return true;
		}
		return false;
	}
	/**
	 * Get thumbnail image url
	 * globalImageServers = ['http://i47.vbox7.com/','http://i48.vbox7.com/'];
	 * http://i47.vbox7.com/p/401d5f591.jpg
	 * @param mediaLink $link
	 * @return string Url of remote image file
	 */
	public function getPreviewUrl(){
		if ($videoId = $this->getVideoId()){
			return 'http://i4'.rand(7, 8).'.vbox7.com/p/'.$videoId.'5.jpg'; // large
		} 
		return false;
	}
	public function getVideoId(){
		if (preg_match("#http://(www\.)?vbox7\.com/play\:([a-z0-9\._-]+)#ims", $this->getUrl(), $subs)){
			return $subs[2];
		}
		return false;
	}
	public function getEmbedUrl(){
		// http://i47.vbox7.com/player/ext.swf?vid=bac01584
		if ($videoId = $this->getVideoId()){
			return 'http://i4'.rand(7, 8).'.vbox7.com/player/ext.swf?vid='.$videoId.'';
		}
		return false;
	}
}

