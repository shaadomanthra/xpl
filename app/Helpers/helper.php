<?php

if (! function_exists('summernote_imageupload')) {
    function summernote_imageupload($user,$editor_data)
    {
    	$detail=$editor_data;
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $images = $dom->getElementsByTagName('img');

        foreach($images as $k => $img){
            $data = $img->getAttribute('src');
            if(!strpos($data, ';'))
            	break;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= "/img/upload/" .$user->username.'_'. time().'_'.$k.'.png';
            $path = public_path() . $image_name;
            file_put_contents($path, $data);
            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
        }
        $detail = $dom->saveHTML();
        return $detail;
    }
}