<?php

/**
 * mediaLink driver for youtube.com
 * @author olamedia
 */
class youtubeMediaLinkDriver extends mediaLinkDriver{
	public function getFixedUrl(){
		if ($videoId = $this->getVideoId()){
			return 'http://youtube.com/watch?v='.$videoId.'';
		}
		return $this->_link->getUrl();
	}
	/**
	 * Try to load driver
	 * @param mediaLink $link
	 * @return boolean true if url can be parsed by this driver
	 */
	public function load(){
		if ($this->getDomainName()=='youtube.com'){
			return true;
		}
		return false;
	}
	/**
	 * Get thumbnail image url
	 * @param mediaLink $link
	 * @return string Url of remote image file
	 */
	public function getPreviewUrl(){
		if ($videoId = $this->getVideoId()){
			return 'http://i'.rand(1, 4).'.ytimg.com/vi/'.$videoId.'/0.jpg';
		}
		return false;
	}
	/**
	 * Get video ID, internal use only
	 * @param mediaLink $link
	 * @return string ID of media file
	 */
	protected function getVideoId(){
		//a-z0-9\._-
		if (preg_match("#http://(www\.)?youtube\.com/watch\?v=([^&]+).*#ims", $this->getUrl(), $subs)){
			return $subs[2];
		}
		return false;
	}
	/**
	 * Get swf embed url
	 * @param mediaLink $link
	 * @return string Url of remote .swf file
	 */
	public function getEmbedUrl(){
		if ($videoId = $this->getVideoId()){
			return 'http://www.youtube.com/v/'.$videoId.'&hl=en_US&fs=1&rel=0&showinfo=0&loop=1&autoplay=1';
		}
		return false;
	}
}

