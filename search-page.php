<?php

    session_start();
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header("Access-Control-Allow-Headers: X-Requested-With");

    //mengambil konfigurasi
    require $_SERVER['DOCUMENT_ROOT']."/config.php";

    if (!empty($_GET['q'])){
		$QueryUser = stripslashes(trim(htmlspecialchars($_GET['q'])));
	}else{
		$QueryUser = '';
	}
	$QueryUserInput = $QueryUser;
	if (!empty($_GET['page'])){
		$QueryUser = $QueryUser.'&page='.stripslashes(trim(htmlspecialchars($_GET['page'])));
	}
	
    require_once(DIR_SITUS.'/simple_html_dom.php');
    
    if (!empty($QueryUser)){
    
        $html = file_get_html('https://nhentai.net/search/?q='.$QueryUser);
        
        $serverData['title'] = $QueryUserInput;
        $serverData['count'] = get_string_between($html->find('h1',0), '<i class="fa fa-search color-icon"></i>', ' results');
        
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
        $headerMeta['title'] = ($serverData['title']).' Search | NH Browser';
        $headerMeta['keywords'] = 'NH Browser, images downloader, nhentai downloader, nhentai reader, '.$QueryUser;
        $headerMeta['ogimage'] = $headerMeta['og-image'];

        $Output['status'] = '200';
        $Output['title'] = $serverData;
        $Output['listing'] = $Listing;
        $Output['pagination'] = $Pagination;
        $Output['meta'] = $headerMeta;

        echo json_encode($Output);

        
    }
    die();
?>
<div class="header-layout">
    <div class="navbar">
        <div class="navbar-left-non">
            
        </div>
        <form class="navbar-center" method="GET">
            <input type="text" id="codeinput" placeholder="Keyword" name="q" value="<?php echo $QueryUserInput; ?>">
        </form>
        <div class="navbar-right">
            <a class="navbar-button" href="/popular"><i class="fal fa-fire"></i></a>
            <a class="navbar-button" href="/g?q=<?php echo rand(1,270000); ?>"><i class="fal fa-repeat"></i></a>
            <a class="navbar-button" href="https://trakteer.id/greenrunchly/tip" ><i class="fal fa-gift"></i></a>
        </div>
    </div>
    <div class="header-layout-top">
        <h1 id="titleManga"><?php echo ($serverData['title']); ?></h1>
    </div>
    <div class="header-layout-bottom">
        <h2><span id="totalPagesManga"><?php echo $serverData['count']; ?></span> Results</h2>
    </div>
</div>
<div id="mediaLayout" class="tiles-gallery">
<?php
    if (!empty($QueryUser)){
        foreach ($Listing as $id => $data) {
?>
    <a class="media-gallery" href="/g?q=<?php echo $id; ?>">
        <div class="media-gallery-thumb">
            <img src="<?php echo URL_SITUS; ?>/get-cover.php?media=<?php echo $data['cover']; ?>">
        </div>
        <div class="media-gallery-desc">
            <h2><?php echo substr($data['caption'], 0, 50); ?>...</h2>
        </div>
    </a>
<?php
        }
    }
?>
</div>
<div class="load-button-container">
<?php
    if (!empty($QueryUser)){
        foreach ($Pagination as $id => $data) {
?>
    <a class="load-button" href="?q=<?php echo $QueryUserInput; ?>&page=<?php echo $id; ?>"><p><?php echo $data['caption']; ?></p></a>
<?php
        }
    }
?>
</div>

