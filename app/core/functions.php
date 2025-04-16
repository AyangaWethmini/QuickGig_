<?php

function show($stuff)
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
	exit;
}

function esc($str)
{
	return htmlspecialchars($str);
}


function redirect($path)
{
	header("Location: " . ROOT . "/" . $path);
	die;
}

//function to render advertisements
function renderAdvertisement($ad, $ROOT, $placeholder = 'placeholders/ad-size-banner.jpg', $containerClass = 'ad-cont flex-row', $contentClass = 'advertisement-content')
{
	$html = '<div class="' . $containerClass . '">
                <div class="' . $contentClass . '">';

	if (!empty($ad)) {
		if ($ad->img) {
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			$mimeType = $finfo->buffer($ad->img);
			$html .= '<a href="javascript:void(0)" onclick="recordAdClick(event, ' . $ad->advertisementID . ', \'' . addslashes($ad->link) . '\')">';
			$html .= '<img src="data:' . $mimeType . ';base64,' . base64_encode($ad->img) . '" alt="Advertisement image">';
			$html .= '</a>';
		} else {
			$html .= '<img src="' . $ROOT . '/assets/images/' . $placeholder . '" alt="No image available">';
		}
	} else {
		$html .= '<p>No active advertisements</p>';
	}

	$html .= '</div>
            </div>';

	return $html;
}
