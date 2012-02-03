<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mediaDriver
 *
 * @author olamedia
 */
class mediaLinkDriver{
	protected $_width = '100%';
	protected $_height = '400';
	/**
	 * @var mediaLink
	 */
	protected $_link = null;
	public function __construct($link){
		$this->_link = $link;
	}
	/**
	 * @return string
	 */
	public function getUrl(){
		return $this->_link->getUrl();
	}
	public function getFixedUrl(){
		return $this->_link->getUrl();
	}
	public function getDomainName(){
		return $this->_link->getDomainName();
	}
	public function fetchUrl(){
		return file_get_contents($this->getUrl());
	}
	public function load(){
		return false;
	}
	protected function _px($size){
		if (strval(intval($size))==strval($size)){
			return $size.'px';
		}
		return $size;
	}
	public function setWidth($width){
		$this->_width = $width;
	}
	public function setHeight($height){
		$this->_height = $height;
	}
	public function getWidth(){
		return $this->_width;
	}
	public function getHeight(){
		return $this->_height;
	}
	public function getFlashVars(){
		return '';
	}
	public function getEmbedHtml(){
		$h =
				'<div style="width: '.$this->_px($this->getWidth()).';height: '.$this->_px($this->getHeight()).'">
					<object width="'.$this->getWidth().'" height="'.$this->getHeight().'">
						<param name="movie" value="'.$this->getEmbedUrl().'"></param>
						<param name="flashVars" value="'.$this->getFlashVars().'"></param>
						<param name="allowFullScreen" value="true"></param>
						<param name="wmode" value="transparent"></param>
						<param name="allowscriptaccess" value="sameDomain"></param>
						<embed src="'.$this->getEmbedUrl().'"
							type="application/x-shockwave-flash"
							allowscriptaccess="sameDomain"
							allowfullscreen="true"
							wmode="transparent"
							flashvars="'.$this->getFlashVars().'"
							width="'.$this->getWidth().'"
							height="'.$this->getHeight().'">
						</embed>
					</object>
				</div>';
		return $h;
	}
	public function getTitle(){
		// any video
		$results = googleVideo::search($this->getFixedUrl());
		foreach ($results as $k => $result){
			//var_dump($result);
			$pubDate = strtotime(strval($result->pubDate));
			$link = (strval($result->link));
			$link = str_replace('http://www.google.com/url?q=', '', $link);
			$link = preg_replace("#^(.*)&source=video&vgc=rss.*$#is", '\1', $link);
			$link = urldecode($link);
			//$tm = $result->xpath('media:group/media:thumbnail');
			$tm = strval($result['thumbnail'][0]['url']);
			$desc = $result['description'][0]['url'];
			$desc = strip_tags(html_entity_decode(htmlspecialchars_decode($desc[0])));
			$title = $result['title'][0]['#text'];
			if (is_array($title)) $title = implode('', $title);
			$title = strip_tags(html_entity_decode(htmlspecialchars_decode($title)));
			return $title;
		}
		return false;
	}
	public function getPreviewUrl(){
		// any video
		$results = googleVideo::search($this->getFixedUrl());
		foreach ($results->xpath("//item") as $k => $result){
			$pubDate = strtotime(strval($result->pubDate));
			$link = (strval($result->link));
			$link = str_replace('http://www.google.com/url?q=', '', $link);
			$link = preg_replace("#^(.*)&source=video&vgc=rss.*$#is", '\1', $link);
			$link = urldecode($link);
			$tm = $result->xpath('media:group/media:thumbnail');
			$tm = strval($tm[0]['url']);
			$desc = $result->xpath('media:group/media:description');
			$desc = strip_tags(html_entity_decode(htmlspecialchars_decode($desc[0])));
			$title = strip_tags(html_entity_decode(htmlspecialchars_decode(str_replace(array('<title>', '</title>'), '', $result->title->asXML()))));
			return $tm;
		}
		return false;
	}
	public function getEmbedUrl(){
		return false;
	}
	public function getIframeUrl(){
		return false;
	}
	public function getOnClick($playerId){
		if ($this->getEmbedUrl()){
			return "video.show('preview-".$playerId."')";
			//,'".($this->getEmbedUrl())."','".$this->getFlashVars()."'
		}
		if ($this->getIframeUrl()){
			return "showIframe('preview-".$playerId."','".$this->getIframeUrl()."','".$this->getUrl()."')";
		}
	}
}
?>
