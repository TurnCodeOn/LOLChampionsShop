<?php

function select_theme($theme)
{
    switch ($theme) {
        case "1":
            extract_and_update_urls('../themes/food/public_html/index.html');
            break;
        case "2":
            extract_and_update_urls('../themes/coffee/index.html');
            break;
        case "3":
            extract_and_update_urls('../themes/ice/index.html');
            break;
        case "4":
            extract_and_update_urls('../themes/wine/index.html');
            break;
        case "5":
            extract_and_update_urls('../themes/spicyo/index.html');
            break;
        case "6":
            extract_and_update_urls('../themes/Band/index.html');
            break;
        default:
            extract_and_update_urls('../themes/food/public_html/index.html');
    }
}

function extract_and_update_urls($html_file)
{
    $html = file_get_contents($html_file);
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    // Set $doc_root based on server environment
    if ($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '::1') {
        $doc_root = 'C:\xampp\htdocs';
    } else {
        $doc_root = $_SERVER['DOCUMENT_ROOT'];
    }

    $file_dir = dirname($html_file);
    $base_url = 'http://localhost'; // Change this to the desired base URL

    // Update all <img> tags
    foreach ($dom->getElementsByTagName('img') as $img) {
        $src = $img->getAttribute('src');
        $url = make_url($src, $doc_root, $file_dir, $base_url);
        $img->setAttribute('src', $url);
    }

    // Update all <link> tags with rel="stylesheet"
    foreach ($dom->getElementsByTagName('link') as $link) {
        if ($link->getAttribute('rel') == 'stylesheet') {
            $href = $link->getAttribute('href');
            $url = make_url($href, $doc_root, $file_dir, $base_url);
            $link->setAttribute('href', $url);
        }
    }

    // Update all <script> tags
    foreach ($dom->getElementsByTagName('script') as $script) {
        $src = $script->getAttribute('src');
        if ($src) {
            $url = make_url($src, $doc_root, $file_dir, $base_url);
            $script->setAttribute('src', $url);
        }
    }

    $newTitle = 'mikel';
    
    // Check if the HTML has a <title> tag
    $titleTag = $dom->getElementsByTagName('title')->item(0);
    if (!$titleTag) {
        $titleTag = $dom->createElement('title');
        $headTag = $dom->getElementsByTagName('head')->item(0);
        $headTag->appendChild($titleTag);
    }

    // Set the new title
    $titleTag->nodeValue = $newTitle;



    // Echo the updated HTML
    echo $dom->saveHTML();
}

function make_url($path, $doc_root, $file_dir, $base_url)
{
    if (preg_match('/^https?:\/\//i', $path)) {
        return $path;
    }
    if (preg_match('/^\/(.*)/', $path, $matches)) {
        $url = $base_url . $matches[0];
    } else {
        $full_path = realpath($file_dir . '/' . $path);
        $url = str_replace('\\', '/', str_replace($doc_root, $base_url, $full_path));
    }
    return $url;
}
