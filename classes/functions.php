<?php 

function PaginationLink()
{
    $pageNumber = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
    $pageNumber = ($pageNumber < 1) ? 1 : $pageNumber;
    $arr = array();

    $arr['nextPage'] = "";
    $arr['prevPage'] = "";
    // Získání url
    $url = "http://" .  $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
    $url .= "?";

    $nextPageLink = $url;
    $prevPageLink = $url;
    $pageFound = false;

    $num = 0;
    foreach ($_GET as $key => $value) {
        $num++;
        if ($num == 1) {
            if ($key == "page") {
                $nextPageLink .= "&" . $key . "=" . ($pageNumber + 1);
                $prevPageLink .= "&" . $key . "=" . ($pageNumber - 1);
                $pageFound = true;
            } else {
                $nextPageLink .= "&" . $key . "=" . $value;
                $prevPageLink .= "&" . $key . "=" . $value;
            }
        } else {
            if ($key == "page") {
                $nextPageLink .= "&" . $key . "=" . ($pageNumber + 1);
                $prevPageLink .= "&" . $key . "=" . ($pageNumber - 1);
                $pageFound = true;
            } else {
                $nextPageLink .= "&" . $key . "=" . $value;
                $prevPageLink .= "&" . $key . "=" . $value;
            }
        }
    }
    $arr['nextPage'] = $nextPageLink;
    $arr['prevPage'] = $prevPageLink;
    
    if (!$pageFound){
        $arr['nextPage'] = $nextPageLink . "&page=2";
        $arr['prevPage'] = $prevPageLink . "&page=1"; 
    }
    return $arr;
}