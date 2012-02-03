<?php
/**
 * Description of myvideoDeMediaLinkDriver
 * http://www.myvideo.de/watch/3987225/Kotoko_Blaze
 * http://www.myvideo.de/movie/3987225
 * REST: http://statix.myvideo.de/bilder/MyVideo.de_REST_based_Webservices.pdf
 * @author olamedia
 */
class myvideoDeMediaLinkDriver extends mediaLinkDriver{
	/**
	 * Try to load driver
	 * @param mediaLink $link
	 * @return boolean true if url can be parsed by this driver
	 */
	public function load(){
		if ($this->getDomainName()=='myvideo.de'){
			return true;
		}
		return false;
	}
	/**
	 * Get thumbnail image url
	 * 
	 * @param mediaLink $link
	 * @return string Url of remote image file
	 */
	public function getPreviewUrl(){
		return false;
	}
	public function getVideoId(){
		if (preg_match("#/watch/([a-z0-9\._-]+)#ims", $this->getUrl(), $subs)){
			return $subs[1];
		}
		return false;
	}
	public function getEmbedUrl(){
		if ($videoId = $this->getVideoId()){
			return 'http://www.myvideo.de/movie/'.$videoId.'';
		}
		return false;
	}
}