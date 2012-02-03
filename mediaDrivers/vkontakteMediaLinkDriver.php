<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vkontakteMediaLinkDriver
 * http://vkontakte.ru/video-2248286_155082357
 * @author olamedia
 */
class vkontakteMediaLinkDriver extends mediaLinkDriver{
	public function load(){
		return false;
		if ($this->getDomainName()=='vkontakte.ru'){
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
	public function getVideoId(){ // video_id
		$url = $this->getUrl();
		$regexp = "#/video([0-9-]+)_([0-9]+)#ims";
		if (preg_match($regexp, $url, $subs)){ // ([0-9\-]+)_([0-9]+)
			return $subs[2];
		}else{
			//echo 'failed match:'.$url.' vs '.$regexp.' ';
		}
		return false;
	}
	public function getVideoId2(){ // owner_id
		if (preg_match("#/video([0-9-]+)_([0-9]+)#ims", $this->getUrl(), $subs)){
			return $subs[1];
		}
		return false;
	}
	protected function getHash(){
		//hash=40ff5a51a9ac01f5\
		//view-source:http://vkontakte.ru/video.php?act=a_embedbox&oid=-2248286&vid=155082357
		$embedBoxUrl = 'http://vkontakte.ru/video.php?act=a_embedbox&oid='.$this->getVideoId2().'&vid='.$this->getVideoId().'&hd=1&no_flv=1';
		if ($eh = file_get_contents($embedBoxUrl)){
			if (preg_match("#hash=([0-9a-z]+)#ims", $eh, $subs)){
				echo 'HASH='.$subs[1];
				return $subs[1];
			}else{
				echo 'can`t find hash '.htmlspecialchars($eh);
			}
		}else{
				echo 'can`t open url '.$embedBoxUrl;
		}
		return false;
	}
	public function getEmbedUrl(){
		return false;
	}
	public function getIframeUrl(){
		if ($videoId = $this->getVideoId()){
			return 'http://vkontakte.ru/video_ext.php?oid='.$videoId.'&id='.$this->getVideoId2().'&hash=a&hd=1';
			//'.$this->getHash().'
		}else{
			return ':(';
		}
		return false;
	}
}

