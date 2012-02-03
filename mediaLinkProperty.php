<?php
class mediaLinkProperty extends stringProperty{
	protected static $_id = 0;
	public function getMediaLinks($limit = false){
		$links = array();
		if (preg_match_all("#(http://\S+(?:\#|\s|$))#i", $this->getValue(), $subs)){
			foreach ($subs[1] as $url){
				$links[] = new mediaLink($url);
			}
			return $links;
		}
		return false;
		//http://
	}
	public function html(){
		$ah = '';
		if ($mediaLinks = $this->getMediaLinks()){
			$mediaWidth = '150px';
			$limit = 8;
			$shown = 0;
			$showId = 0;
			if (count($mediaLinks)){
				foreach ($mediaLinks as $mediaLink){
					//$h .= '<div>fixed: '.$mediaLink->getFixedUrl().'</div>';
					self::$_id++;
					$previewId = self::$_id;
					if ($shown >= $limit) continue;
					if ($mediaLink->getDriver()!==null){
						$title = '';
						if ($title = $mediaLink->getTitle()){
							$etitle = htmlspecialchars($title,ENT_QUOTES);
							$text = str_replace(htmlspecialchars($mediaLink->getUrl()), '<a href="'.$mediaLink->getFixedUrl().'" target="_blank" class="external">'.$etitle.'</a>', $text);
						}
						$etitle = htmlspecialchars($title,ENT_QUOTES);
						$onclick = htmlspecialchars($mediaLink->getOnClick($previewId),ENT_QUOTES);
						if ($previewUrl = $mediaLink->getPreviewUrl()){
							$shown++;
							//$ah .= $mediaLink->getEmbedHtml();
							$ah .= '<div id="preview-'.$previewId.'" class="video video-block">'."\r\n";
							$ah .= '<div class="video-thumb">';
							$ah .= '<div class="preview-load"></div>'."\r\n";
							$ah .= '<div class="preview-alt" 
							embed-url="'.htmlspecialchars($mediaLink->getEmbedUrl(),ENT_QUOTES).'" 
							flashvars="'.htmlspecialchars($mediaLink->getFlashVars(),ENT_QUOTES).'"
							>';
							$ah .= '<div title="'.$etitle.'" onclick="'.$onclick.'" class="play"><img style="width: '.$mediaWidth.';" src="'.$previewUrl.'" /></div>'."\r\n";
							$ah .= '<img class="block" title="'.$etitle.'" style="width: '.$mediaWidth.';" src="'.$previewUrl.'" />'."\r\n";
							$ah .= '</div>';
							$ah .= '</div>';
							$ah .= '</div>';
						}else{
							/*$ah .= '<div id="preview-'.$previewId.'" class="video video-block">';
							$ah .= '<div class="video-thumb">';
							$ah .= '<div class="preview-load"></div>';
							$ah .= '<div class="preview-alt">';
							$ah .= '<div title="'.$etitle.'" onclick="'.$onclick.'">'.$etitle.'</div>';
							$ah .= '</div>';
							$ah .= '</div>';
							$ah .= '</div>';*/
						}
					}
				}
				if (strlen($ah)) return $ah;
				
			}
			
		}
		return $this->getValue();
		
	}
}