<?php
/**
 * Description of youkuMediaLinkDriver
 * http://irc.lv/video?id=689kHzxkYXuX
 * http://irc.lv/player.swf?id=689kHzxkYXuX
 * @author olamedia
 */
class ircLvMediaLinkDriver extends mediaLinkDriver{
	/**
	 * Try to load driver
	 * @param mediaLink $link
	 * @return boolean true if url can be parsed by this driver
	 */
	public function load(){
		if ($this->getDomainName()=='irc.lv'){
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
		// REST: http[s]://www.veoh.com/rest/v2/execute.xml?method=veoh.video.getVideoThumbnails
		// http://p-images.veoh.com/image.out?imageId=thumb-v891059AqzRAHhs-5.jpg
		// www.veoh.com/rest/video/v891059AqzRAHhs/details
		/*if ($videoId = $this->getVideoId()){
			if ($info = simplexml_load_file('http://www.veoh.com/rest/video/'.$videoId.'/details')){
				$video = $info->xpath('//video');
				return strval($video['fullHighResImagePath']);
			}
			return 'http://p-images.veoh.com/image.out?imageId=thumb-'.$videoId.'-30.jpg';
		}*/
		return false;
	}
	public function getVideoId(){
		if (preg_match("#/video\?id=([a-z0-9\._-]+)#ims", $this->getUrl(), $subs)){
			return $subs[1];
		}
		return false;
	}
	public function getEmbedUrl(){
		if ($videoId = $this->getVideoId()){
			return 'http://irc.lv/player.swf?id='.$videoId.'';
		}
		return false;
	}
}