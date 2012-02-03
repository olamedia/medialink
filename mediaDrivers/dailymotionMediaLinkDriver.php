<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of youtubeMediaDriver
 *
 * @author olamedia
 */
class dailymotionMediaLinkDriver extends mediaLinkDriver{
	public function load(){
		if ($this->getDomainName()=='dailymotion.com'){
			if ($this->getVideoId()){
				return true;
			}
		}
		return false;
	}
	public function getPreviewUrl(){
		if ($videoId = $this->getVideoId()){
			return 'http://www.dailymotion.com/thumbnail/800x600/video/'.$videoId.'';
		}
		return false;
	}
	public function getVideoId(){
		//a-z0-9\._-
		if (preg_match("#http://(www\.)?dailymotion\.com/video/([a-z0-9_-]+).*#ims", $this->getUrl(), $subs)){
			return $subs[2];
		}
		return false;
	}
	public function getEmbedUrl(){
		if ($videoId = $this->getVideoId($link)){
			return 'http://www.dailymotion.com/swf/video/'.$videoId.'';
		}
		return false;
	}
}

