<?php
/**
 * oohembedMediaLinkDriver
 * @url http://oohembed.com/
 *
 * http://*.5min.com/Video/* Provides the flash video embed code
 * http://*.amazon.(com|co.uk|de|ca|jp)/*\/(gp/product|o/ASIN|obidos/ASIN|dp)/* Product images
 * http://*.blip.tv/* (original endpoint: http://blip.tv/oembed/) Provides the flash video embed code
 * http://*.collegehumor.com/video:* Provides the flash video embed code
 * http://*.thedailyshow.com/video/* Provides the flash video embed code
 * http://*.dailymotion.com/* (http://www.dailymotion.com/services/oembed)  Provides the flash video embed code
 * http://dotsub.com/view/* Provides the flash video embed code
 * http://*.flickr.com/photos/* (http://www.flickr.com/services/oembed/)
 * http://*.funnyordie.com/videos/* Provides the flash video embed code
 * http://video.google.com/videoplay?* Provides the flash video embed code
 * http://www.hulu.com/watch/* proxy
 * http://*.livejournal.com/ Avatar image for LiveJournal user. Uses http://ljpic.seacrow.com/
 * http://*.metacafe.com/watch/* Provides the flash video embed code
 * http://*.nfb.ca/film/* proxy Provides video embed codes for nfb.ca - the National Film Board of Canada.
 * http://*.phodroid.com\/*\/*\/* Provider for phodroid.com photos.
 * http://qik.com/* proxy 
 * http://*.revision3.com/* proxy
 * http://*.scribd.com/* proxy
 * http://*.slideshare.net/* Provides the embed code for slideshow
 * http://*.twitpic.com/* Photo and thumbnail for TwitPic.com photos.
 * http://twitter.com/*\/statuses\/* Provides info on a particular tweet as a link type oEmbed response
 * http://*.viddler.com/explore/* proxy
 * http://www.vimeo.com/* and http://www.vimeo.com/groups\/*\/videos\/* proxy
 * http://*.wikipedia.org/wiki/*  Returns lead content from a Wikipedia page as 'html' attribute of link type oEmbed response
 * http://*.wordpress.com/yyyy/mm/dd/* Returns lead content from a Wordpress.com blog post page as 'html' attribute of link type oEmbed response
 * http://*.xkcd.com/*\/ Provides the comic image link for an xkcd.com comic page
 * http://yfrog.(com|ru|com.tr|it|fr|co.il|co.uk|com.pl|pl|eu|us)/* Photo and thumbnail for yfrog.com photos. Uses API described here - http://code.google.com/p/imageshackapi/wiki/YFROGurls
 * http://yfrog.(com|ru|com.tr|it|fr|co.il|co.uk|com.pl|pl|eu|us)/* Provides the Yfrog video embed code.
 * http://*.youtube.com/watch* proxy
 * @author olamedia
 */
class oohembedMediaLinkDriver extends mediaLinkDriver{
	protected $_masks = array(
	'5min.com'=>'http://*.5min.com/Video/*',
	'blip.tv'=>'http://*.blip.tv/*',
	'collegehumor.com'=>'http://*.collegehumor.com/video:*',
	'thedailyshow.com'=>'http://*.thedailyshow.com/video/*',
	'dotsub.com'=>'http://dotsub.com/view/*',
	'funnyordie.com'=>'http://*.funnyordie.com/videos/*',
	'hulu.com'=>'http://www.hulu.com/watch/*',
	'nfb.ca'=>'http://*.nfb.ca/film/*',
	'qik.com'=>'http://qik.com/*',
	'revision3.com'=>'http://*.revision3.com/*',
	'viddler.com'=>'http://*.viddler.com/explore/*',
	'google.com'=>'http://*.google.com/videoplay*',
	//'DOMAIN'=>'MASKMASKMASK',

	);
	/**
	 * Try to load driver
	 * @param mediaLink $link
	 * @return boolean true if url can be parsed by this driver
	 */
	public function load(){
		foreach ($this->_masks as $domain => $mask){
			if ($this->getDomainName()==$domain){
				$regexp = $mask;
				$regexp = preg_quote($regexp, '#');
				$regexp = str_replace('\*', '.*', $regexp);
				$regexp = str_replace('http\://.*\.', 'http\://(.*\.)?', $regexp);
				$regexp = '#'.$regexp.'#ims';
				if (preg_match($regexp, $this->getUrl())){
					return true; 
				}
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
		if (preg_match("#/video/#ims", $this->getUrl(), $subs)){
			return true;
		}
		return false;
	}
	public function getEmbedUrl(){
		//return false;
		$domain = $this->getDomainName();
		$regexp = $this->_masks[$domain];
		$regexp = preg_quote($regexp, '#');
		$regexp = str_replace('\*', '.*', $regexp);
		$regexp = str_replace('http\://.*\.', 'http\://(.*\.)?', $regexp);
		$regexp = '#'.$regexp.'#ims';
		//echo $regexp;
		if (preg_match($regexp, $this->getUrl())){
			$oembed = new oembed();
			$oembed->setApi('http://oohembed.com/oohembed/');
			$oembed->setFormat('json');
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