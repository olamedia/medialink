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
class nicovideoMediaLinkDriver extends mediaLinkDriver{
	// http://ext.nicovideo.jp/api/getthumbinfo/nm6336973
	// http://flapi.nicovideo.jp/api/getflv/nm6336973
	// http://wescript.net/scripts/6066
	// http://userscripts.org/scripts/show/28910
	const prefixes = 'sm|nm|fz|ax|ca|cd|cw|ig|na|nl|om|sd|sk|yk|yo|za|zb|zc|zd|ze|fx|so';
	public function load(){
		if ($this->getDomainName()=='nicovideo.jp'){
			return true;
		}
		return false;
	}
	public function getPreviewUrl(){
		if ($videoId2 = $this->getVideoId2()){
			return 'http://tn-skr'.rand(1, 3).'.smilevideo.jp/smile?i='.$videoId2.'';
		}
	}
	public function getVideoId(){
		if (preg_match("#http://(www\.)?nicovideo\.jp/watch/((".self::prefixes.")([0-9]+))([^\"]*)#ims", $this->getUrl(), $subs)){
			return $subs[2];
		}
		return false;
	}
	public function getVideoId2(){
		if (preg_match("#http://(www\.)?nicovideo\.jp/watch/((".self::prefixes.")([0-9]+))([^\"]*)#ims", $this->getUrl(), $subs)){
			return $subs[4];
		}
		return false;
	}
	public function getOnClick($playerId){
		return "showNicoVideo('preview-".$playerId."','".$this->getVideoId()."','".$this->getUrl()."')";
	}
	public function getEmbedUrl(){
		return false;
	}
}

