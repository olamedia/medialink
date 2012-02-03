<?php
/**
 * watTvMediaLinkDriver
 * @url wat.tv
 * French video hosting
 * http://www.wat.tv/video/shakugan-no-shana-episode-w2gw_2gv9f_.html
 * http://www.wat.tv/swf2/951366nIc0K111496192
 * Supports facebook tags:
 * <link rel="image_src" href="http://s0.wat.fr/f/shakugan-no-shana-episode_w2gw_150x85_63c5o.jpg" /> 
 * <link rel="video_src" href="http://www.wat.tv/swf2/951366nIc0K111496192"/> 
 * Not working (10.11.2010): text/xml+oembed, application/json+oembed
 * http://www.wat.tv/interface/oembed/xml?url=http%3A%2F%2Fwww.wat.tv%2Fvideo%2Fshakugan-no-shana-episode-w2gw_2gv9f_.html
 * http://www.wat.tv/interface/oembed/json?url=http%3A%2F%2Fwww.wat.tv%2Fvideo%2Fshakugan-no-shana-episode-w2gw_2gv9f_.html
 * @author olamedia
 */
class watTvMediaLinkDriver extends mediaLinkDriver{
	/**
	 * Try to load driver
	 * @param mediaLink $link
	 * @return boolean true if url can be parsed by this driver
	 */
	public function load(){
		if ($this->getDomainName()=='wat.tv'){
			if ($videoId = $this->getVideoId()){
				return true;
			}
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
		if ($videoId = $this->getVideoId()){
			$ida = explode('-',$videoId);
			$last = array_pop($ida);
			$id = implode('-',$ida).'_'.$last;
			return 'http://s0.wat.fr/f/'.$id.'_150x85_aaaaa.jpg';
		}
		return false;
	}
	public function getVideoId(){
		if (preg_match("#/video/([^\._]+)_[a-z0-9_]+\.html#ims", $this->getUrl(), $subs)){
			return $subs[1];
		}
		return false;
	}
	public function getEmbedUrl(){
		//return false;
		if ($videoId = $this->getVideoId()){
			$oembed = new oembed();
			$oembed->setApi('http://www.wat.tv/interface/oembed/xml');
			$oembed->setFormat('xml');
			$oembed->setUrl($this->getUrl());
			if ($oembed->getType() == 'video'){
				//echo ' Type: video';
				if ($src = $oembed->getEmbedSrc()){
					//echo ' Src: '.$src;
					return $src;
				}
			}
		}
		return false;
	}
}