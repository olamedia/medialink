<?php
/**
 * Description of youkuMediaLinkDriver
 * http://v.youku.com/v_show/id_XMjAyODAxMDA0.html
 * http://player.youku.com/player.php/sid/XMjAyODAxMDA0/v.swf
 * @author olamedia
 */
class youkuMediaLinkDriver extends mediaLinkDriver{
	/**
	 * Try to load driver
	 * @param mediaLink $link
	 * @return boolean true if url can be parsed by this driver
	 */
	public function load(){
		if ($this->getDomainName()=='v.youku.com'){
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
	}
	public function getVideoId(){
		if (preg_match("#/v_show/id_([a-z0-9\._-]+)\.html#ims", $this->getUrl(), $subs)){
			return $subs[1];
		}
		return false;
	}
	public function getEmbedUrl(){
		if ($videoId = $this->getVideoId()){
			return 'http://player.youku.com/player.php/sid/'.$videoId.'/v.swf';
		}
		return false;
	}
}