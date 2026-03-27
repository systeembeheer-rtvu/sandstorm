<?php

$url = @$_GET['url'];

echo <<<DUMP
	<form action="embedcode.php" method="get">
	website link naar aflevering:<br>
	<input type="text" name="url" value="$url" size=80><br>
	<input type="submit" value="Submit">
	<br>

DUMP;


$link = $url;

if (preg_match('/RTVU_\d+/sim', $link, $regs)) {
	$media_sourceid = $regs[0];
} else {
 	if ($url) echo "Geen aflevering code gevonden in de link";
 	exit;   
}

$data = [
    [
        'filters' => [
            [
                'type' => 'mediaclip',
                'field' => 'sourceid',
                'operator' => 'equals',
                'value' => $media_sourceid
            ]
        ]
    ]
];

$searchjson = json_encode($data,JSON_FORCE_OBJECT);
$params = array(
    'filterset' => $searchjson
);
$url = "https://rtvutrecht.bbvms.com/sapi/mediaclip?".http_build_query($params);

$json = file_get_contents($url);
$tmp = json_decode($json);
//echo "<pre>";
// var_dump($tmp);
// echo "</pre>";
$bbw_id = @$tmp->items[0]->id;
$title = @$tmp->items[0]->title;
$media_sourceidint = (int) filter_var($media_sourceid, FILTER_SANITIZE_NUMBER_INT);

if (!$bbw_id) {
 	echo "Geen embedcode gevonden";
 	exit;   
}

$iframe = <<<DUMP
<iframe onload="if (this.src.indexOf('#!referrer=') === -1) this.src += '#!referrer='+encodeURIComponent(location.href)+'&realReferrer='+encodeURIComponent(document.referrer)" src="https://rtvutrecht.bbvms.com/p/rtv_utrecht_videoplayer_web_inline/c/$bbw_id.html?inheritDimensions=true&placementOption=default" width="720" height="405"  frameborder="0" webkitallowfullscreen mozallowFullscreen oallowFullscreen msallowFullscreen allowfullscreen allow="autoplay; fullscreen"></iframe>
DUMP;

$iframe = htmlspecialchars($iframe);

$javascript = <<<DUMP
<script type="text/javascript" src="https://rtvutrecht.bbvms.com/p/rtv_utrecht_videoplayer_web_inline/c/$bbw_id.js"  async="true"></script>
DUMP;

$javascript = htmlspecialchars($javascript);

echo <<<DUMP
<h3>Embed codes:</h3>
<p>Titel: $title</p>
<p><b>iFrame</b></p>
<p>$iframe</p>
<p><b>javascript</b></p>
<p>$javascript</p>

DUMP;
?>