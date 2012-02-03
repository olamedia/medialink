<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of veohMediaLinkDriver
 * http://www.veoh.com/browse/videos/category/animation/watch/v15487996p4NXDNa
 * @author olamedia
 */
class veohMediaLinkDriver extends mediaLinkDriver{
	/**
	 * Try to load driver
	 * @param mediaLink $link
	 * @return boolean true if url can be parsed by this driver
	 */
	public function load(){
		if ($this->getDomainName()=='veoh.com'){
			return true;
		}
		return false;
	}
	/**
	 * Get thumbnail image url
	 * http://ll-images.veoh.com/media/w120/media-v15487996p4NXDNa1196250172Med.jpg
	 * @param mediaLink $link
	 * @return string Url of remote image file
	 */
	public function getPreviewUrl(){
		return parent::getPreviewUrl();
		// REST: http[s]://www.veoh.com/rest/v2/execute.xml?method=veoh.video.getVideoThumbnails
		// http://p-images.veoh.com/image.out?imageId=thumb-v891059AqzRAHhs-5.jpg
		// www.veoh.com/rest/video/v891059AqzRAHhs/details
		if ($videoId = $this->getVideoId()){
			if ($info = simplexml_load_file('http://www.veoh.com/rest/video/'.$videoId.'/details')){
				$video = $info->xpath('//video');
				return strval($video['fullHighResImagePath']);
			}
			return 'http://p-images.veoh.com/image.out?imageId=thumb-'.$videoId.'-30.jpg';
		}
		return parent::getPreviewUrl();
		return false;
	}
	public function getVideoId(){
		if (preg_match("#/watch/([a-z0-9\._-]+)#ims", $this->getUrl(), $subs)){
			return $subs[1];
		}
		return false;
	}
	public function getEmbedUrl(){
		// flashVars: playerVars=showStats=no|autoPlay=yes|videoTitle=Kawaii Girl Cosplay Yuki Nagato
		//http://www.metacafe.com/fplayer/2974795/kawaii_girl_cosplay_yuki_nagato.swf
		if ($videoId = $this->getVideoId()){
			return 'http://www.veoh.com/static/swf/webplayer/WebPlayer.swf?version=AFrontend.5.5.2.1062&permalinkId='.$videoId.'&player=videodetailsembedded&videoAutoPlay=1&id=anonymous';
		}
		return false;
	}
}

