<?php

/**
 * mediaLink driver for smotri.com
 * @author olamedia
 */
class smotriMediaLinkDriver extends mediaLinkDriver{
	/**
	 * Try to load driver
	 * @param mediaLink $link
	 * @return boolean true if url can be parsed by this driver
	 */
	public function load(){
		if ($this->getDomainName()=='smotri.com'){
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
			//<link rel="image_src" href="http://frame2.loadup.ru/41/45/1491961.3.3.jpg" />
			$url = false;
			if ($f = fopen($this->getUrl(), 'rb')){
				if ($d = fread($f, 1024)){
					if (preg_match('#(<link rel="image_src" href="([^>]+)" />)#ims', $d, $subs)){
						$url = $subs[2];
					}
					//echo htmlspecialchars($d);
				}
				fclose($f);
			}
			return $url; 
		}
		return false;
		if ($videoId = $this->getVideoId()){
			$vid = substr($videoId, 0, strlen($videoId)-4);
			$e = substr($videoId, strlen($vid), 2);
			$e2 = substr($videoId, strlen($vid)+2, 2);
			// 568e => /a3/3e/ (1493032)
			// a062 => /41/45/ (1491961)
			// b836 => /e6/1b/ (1680311)
			// a766 => /d4/0a/ (1489199)
			// /broadcast/ => /2a/a9/
			// 0-f 1-e 2-d 3-c 4-b 5-a 6-9 7-8 8-7
			return 'http://frame'.rand(1, 6).'.loadup.ru/a3/3e/'.$vid.'.3.2.jpg';
		}
		return false;
	}
	/**
	 * Get video ID, internal use only
	 * @param mediaLink $link
	 * @return string ID of media file
	 */
	protected function getVideoId(){
		// http://smotri.com/video/view/?id=v35615022af
		if (preg_match("#http://(www\.)?smotri\.com/video/view/\?id=([^&]+).*#ims", $this->getUrl(), $subs)){
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
			return 'http://pics.smotri.com/player.swf?file='.$videoId.'&bufferTime=3&autoStart=true&str_lang=rus&xmlsource=http%3A%2F%2Fpics.smotri.com%2Fcskins%2Fblue%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.smotri.com%2Fskin_ng.xml';
		}
		return false;
	}
}

