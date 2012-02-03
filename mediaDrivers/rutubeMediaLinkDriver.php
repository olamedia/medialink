<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of youtubeMediaDriver
 *
 * @author Администратор
 */
class rutubeMediaLinkDriver extends mediaLinkDriver{
	public function load(){
		if ($this->getDomainName()=='rutube.ru'){
			return true;
		}
		return false;
	}
	public function getPreviewUrl(){
		if ($videoId = $this->getVideoId($link)){
			return 'http://img-'.rand(1, 4).'.rutube.ru/thumbs/'.substr($videoId, 0, 2).'/'.substr($videoId, 2, 2).'/'.$videoId.'-1.jpg';
		}
		return false;
	}
	public function getVideoId(){
		if (preg_match("#http://(www\.)?rutube.ru/tracks/[0-9]+\.html\?v=([a-z0-9]+)#ims", $this->getUrl(), $subs)){
			return $subs[2];
		}
		return false;
	}
	public function getEmbedUrl(){
		if ($videoId = $this->getVideoId()){
			return 'http://video.rutube.ru/'.$videoId.'?autoload=true&autoPlay=true&autoplay=true&autoStart=1&ap=1&autoplay=1&fsb=true&logo=false&newWnd=false';
		}
		return false;
	}
}

