<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mediaLink
 *
 * @author olamedia
 */
class mediaLink{
	protected $_driver = null;
	public function __construct($url){
		//$this->_url = $url;
		$this->url = $url;
		$this->getDriver();
	}
	public function getDomainName(){
		if (preg_match("#http://(www\.)?(([a-z0-9\.-]+)\.([a-z]+))/#ims", $this->getUrl(), $subs)){
			return $subs[2];
		}
		return false;
	}
	public function getUrl(){
		return $this->url->getValue();
	}
	public function getFixedUrl(){
		if ($this->getDriver()){
			return $this->getDriver()->getFixedUrl();
		}
		return $this->getUrl();
	}
	public function getPreviewUrl(){
		return $this->getDriver()->getPreviewUrl();
	}
	public function getOnClick($playerId){
		return $this->getDriver()->getOnClick($playerId);
	}
	public function getTitle(){
		return $this->getDriver()->getTitle();
	}
	public function getEmbedUrl(){
		return $this->getDriver()->getEmbedUrl();
	}
	public function getFlashVars(){
		return $this->getDriver()->getFlashVars();
	}
	public function getEmbedHtml(){
		return $this->getDriver()->getEmbedHtml();
	}
	public function getDriver(){
		if ($this->_driver===null){
			$path = dirname(__FILE__).'/mediaDrivers/';
			foreach (glob($path.'*') as $f){
				$class = array_shift(explode('.', basename($f)));
				require_once $f;
				/* @var $driver mediaLinkDriver */
				$driver = new $class($this);
				if ($driver->load()){
					$this->_driver = $driver;
				}
			}
		}
		return $this->_driver;
	}
}
