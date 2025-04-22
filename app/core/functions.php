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


function generateCustomID($db, $table, $prefix, $idColumn = 'id') {
    $query = "SELECT AUTO_INCREMENT 
              FROM information_schema.TABLES 
              WHERE TABLE_SCHEMA = DATABASE() 
              AND TABLE_NAME = :table";

    $params = [':table' => $table];
    $result = $db->query($query, $params);

    if (!$result || !isset($result[0]['AUTO_INCREMENT'])) {
        $_SESSION['error'] = "ID creation failed";
        return false;
    }

    $nextID = $result[0]['AUTO_INCREMENT'];
    return $prefix . str_pad($nextID, 6, '0', STR_PAD_LEFT);
}

