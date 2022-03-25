<?php

    session_start();
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header("Access-Control-Allow-Headers: X-Requested-With");

    //mengambil konfigurasi
    require $_SERVER['DOCUMENT_ROOT']."/config.php";

    if (!empty($_GET['p'])){
        $QueryUserPage = stripslashes(trim(htmlspecialchars($_GET['p'])));
        $QueryUser = '?page='.$QueryUserPage;
    }else{
        $QueryUser = '';
    }
	
    require_once(DIR_SITUS.'/simple_html_dom.php');
    
    $html = file_get_html('https://nhentai.net/' . $QueryUser);
    
    $serverData['title'] = 'Popular and New Uploads';
    
    foreach($html->find('div.container.index-container > div.gallery') as $element){
        $id = get_string_between($element, '<a href="/g/', '/" class="cover"');
        $Listing[$id]['cover'] = get_string_between($element, '<img src="', '" width=');
        $Listing[$id]['caption'] = get_string_between($element, '<div class="caption">', '</div></a>');
        $headerMeta['og-image'] = URL_SITUS.'/get-cover.php?media='.$Listing[$id]['cover'];
    }
    
    foreach($html->find('section.pagination > a') as $element){
        $id = get_string_between($element, 'page=', '" class="');
        $Pagination[$id]['caption'] = 'Page '.$id;
    }
    
    $headerMeta['url'] = URL_SITUS;
    $headerMeta['title'] = 'Popular and New Uploads | NH Browser';
    $headerMeta['keywords'] = 'NH Browser, images downloader, nhentai downloader, nhentai reader, Popular, New Uploads';
    $headerMeta['ogimage'] = $headerMeta['og-image'];

    $Output['status'] = '200';
    $Output['title'] = $serverData;
    $Output['listing'] = $Listing;
    $Output['pagination'] = $Pagination;
    $Output['meta'] = $headerMeta;

    echo json_encode($Output);
?>
