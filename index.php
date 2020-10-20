<?php
require_once "library/simple_html_dom.php";

$html = file_get_html("http://bus.com.ua/cgi-bin/tablo.pl");

foreach ($html->find('table[style="font-size:60%;border: #528d5c 1px dashed;"]>tr>td>a') as $item) {
    $stripTags = strip_tags($item);
    preg_match_all('<a href="(.*?)">', $item, $out, PREG_SET_ORDER);
    $id = preg_replace('~\D+~', '', $out[0][1]);

    $insert = file_get_contents('stations.json');
    $arr_data = json_decode($insert, true);
//    unset($insert);
    $arr_data["stations"][] = array(
        'id' => $id,
        'station' => $stripTags
    );

    file_put_contents('stations.json', json_encode($arr_data, JSON_UNESCAPED_UNICODE));
//    unset($arr_data);
}