<?php
/**
 * http://www.oembed.com/
 * @author olamedia
 */
class oembed{
	protected $_apiEndpoint = null;
	protected $_apiFormat = null;
	protected $_url = null;
	protected $_plainResponse = null;
	public function __construct($url = null){
		$this->_url = $url;
	}
	public function setUrl($url){
		$this->_url = $url;
	}
	public function setApi($url){
		$this->_apiEndpoint = $url;
	}
	public function setFormat($format){
		$this->_apiFormat = $format;
	}
	public function discoverApi(){
		// <link rel="alternate" type="application/json+oembed"	href="
		// <link rel="alternate" type="text/xml+oembed"	href="
		
	}
	protected function _isXml(){
		if (!$this->_getPlainResponse()) return false;
		return (substr($this->_plainResponse,0,5) == '<?xml');
	}
	protected function _getArray(){
		if (!$this->_getPlainResponse()) return false;
		//echo htmlspecialchars($this->_plainResponse);
		if ($this->_isXml()){
			return (array) simplexml_load_string($this->_plainResponse);
		}
		return json_decode($this->_plainResponse, true);
	}
	protected function _getRequestUrl(){
		$url = $this->_apiEndpoint.'?url='.urlencode($this->_url);
		if ($this->_apiFormat == 'json') {
			$url .= '&format=json';
		}else{
			$url .= '&format=xml';
		}
		//echo $url;
		return $url;
	}
	protected function _getPlainResponse(){
		if ($this->_plainResponse !== null) return true;
		if ($this->_plainResponse === false) return false;
		if ($this->_url === null) return false;
		$this->_plainResponse = file_get_contents($this->_getRequestUrl());
		if ($this->_plainResponse) return true;
	}
	public function getType(){ // photo/video/link/rich
		if ($a = $this->_getArray()){
			return $a['type'];
		}
		return false;
	}
	public function getEmbedSrc(){ // photo/video/link/rich
		if ($a = $this->_getArray()){
			$html = $a['html'];
			if (preg_match("#<embed[^>]* src='([^']+)'#ims", $html, $subs)){
				$src = $subs[1];
				return $src;
			}elseif (preg_match("#<embed[^>]* src=\"([^\"]+)\"#ims", $html, $subs)){
				$src = $subs[1];
				return $src;
			}else{
				echo htmlspecialchars($html);
			}
		}
		return false;
	}
}