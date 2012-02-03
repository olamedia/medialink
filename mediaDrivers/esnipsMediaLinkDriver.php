<?php
/**
 * Description of esnipsMediaLinkDriver
 * http://www.esnips.com/doc/7a3e781f-db48-449a-bb6d-4f063571a7b1
 * <embed quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" bgcolor="#FFFFFF" width="372" height="169" src="
 * http://www.esnips.com//escentral/images/widgets/flash/player_dj.swf" flashvars="
 autoPlay=yes&amp;theFile=http://www.esnips.com//nsdoc/8642e4ed-d300-4498-ab95-609e48d93132&amp;
 theName=KOTOKO - agony&amp;
 thePlayerURL=http://www.esnips.com//escentral/images/widgets/flash/mp3WidgetPlayer.swf"></embed>
 */
class esnipsMediaLinkDriver extends mediaLinkDriver{
	/**
	 * Try to load driver
	 * @param mediaLink $link
	 * @return boolean true if url can be parsed by this driver
	 */
	public function load(){
		if ($this->getDomainName()=='esnips.com'){
			return true;
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
		return false;
	}
	public function getVideoId(){
		if (preg_match("#/doc/([a-z0-9-]+)#ims", $this->getUrl(), $subs)){
			return $subs[1];
		}
		return false;
	}
	public function getFlashVars(){
		if ($videoId = $this->getVideoId()){
			$file = urlencode('http://www.esnips.com//nsdoc/'.$videoId);
			return 'autoPlay=yes&amp;theFile='.$file.'&amp;theName=name&amp;thePlayerURL=http://www.esnips.com//escentral/images/widgets/flash/mp3WidgetPlayer.swf';
		}
		return '';
	}
	public function getEmbedUrl(){
		if ($videoId = $this->getVideoId()){
			$file = urlencode('http://www.esnips.com//nsdoc/'.$videoId);
			return 'http://www.esnips.com//escentral/images/widgets/flash/player_dj.swf';
		}
		return false;
	}
}