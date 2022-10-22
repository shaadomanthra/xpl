<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('s3_upload')) {
    function s3_upload($name,$path)
    {
        Storage::disk('s3')->put('summernote/'.$name,file_get_contents($path),'public'); 
        return  Storage::disk('s3')->url('summernote/'.$name);
    }
}

if (! function_exists('isJson')) {
function isJson($string) {
 json_decode($string);
 return (json_last_error() == JSON_ERROR_NONE);
}
}

if (! function_exists('isMobileDevice')) {
function isMobileDevice() { 
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
, $_SERVER["HTTP_USER_AGENT"]); 
}
}

if (! function_exists('image_resize')) {
    function image_resize($image_path,$size)
    {
        $base_folder = '/app/public/';
        $path = storage_path() . $base_folder . $image_path;

        $explode= explode('.', $image_path);
        
        $new_path = storage_path() . $base_folder .$explode[0];

        $imgr = Image::make($path)->save(storage_path('app/public/' . $filename));

        //$imgr = Image::make($path)->encode('webp', 100);
       
        $imgr->resize($size, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
        });
        $imgr->save($new_path.'_'.$size.'.webp');  
        Storage::disk('s3')->put('articles/'.$name.'_'.$size.'.webp', (string)$imgr,'public');

        $imgr2 = Image::make($path)->encode('jpg', 100);
        $imgr2->resize($size, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
        });
        $imgr2->save($new_path.'_'.$size.'.jpg');      
        Storage::disk('s3')->put('articles/'.$name.'_'.$size.'.jpg', (string)$imgr2,'public');
        

        return true;
    }
}

if (! function_exists('image_resize')) {
    function image_resize($image_path,$size)
    {
        $base_folder = '/app/public/';
        $path = storage_path() . $base_folder . $image_path;
        $explode= explode('.', $image_path);
        $new_path = storage_path() . $base_folder .$explode[0];
        $imgr = Image::make($path)->save(storage_path('app/public/' . $filename));

        //$imgr = Image::make($path)->encode('webp', 100);
       
        // $imgr->resize($size, null, function ($constraint) {
        //                 $constraint->aspectRatio();
        //                 $constraint->upsize();
        // });
        // $imgr->save($new_path.'_'.$size.'.webp');  
        // Storage::disk('s3')->put('resized_images/'.$name.'_'.$size.'.webp', (string)$imgr,'public');

        $imgr2 = Image::make($path)->encode('jpg', 100);
        $imgr2->resize($size, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
        });
        $imgr2->save($new_path.'_'.$size.'.jpg');      
        Storage::disk('s3')->put('resized_images/'.$name.'_'.$size.'.jpg', (string)$imgr2,'public');
        return true;
    }
}


if (! function_exists('jpg_resize')) {
    function jpg_resize($name,$path,$size)
    {
        $storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        $base_folder = '/app/public/';
        $new_path = storage_path() . $base_folder . $name.'.jpg';
        $npath = $storagePath.$path;

        $imgr = Image::make($npath)->encode('jpg', 100);

        $imgr->resize($size, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
        });
        $imgr->save($new_path);      
        
        return $imgr;
    }
}

if (! function_exists('first_letters')) {

function first_letters($string) {
$temp = explode(' ', $string);
$result = '';
foreach($temp as $t)
    if(isset($t[0]))
        $result .= $t[0];
if($result)
    return $result;
else
    return $string;
}
}
if (! function_exists('get_tld')) {
function get_tld($domain) {
    $domain=str_replace("http://","",$domain); //remove http://
    $domain=str_replace("www","",$domain); //remowe www
    $nd=explode(".",$domain);
    $domain_name=$nd[0];
    $tld=str_replace($domain_name.".","",$domain);
    return $tld;
}
}

if (! function_exists('random_color')) {

function random_color() {
    $a = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    $b = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    $c = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    return $a . $b . $c;
}
}


if (! function_exists('word_imageupload')) {
    function word_imageupload($user,$k,$data)
    {
       
                if(strpos($data, ';'))
                {
                    $d = $data;
                
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = trim(base64_decode($data));

                    
                    $base_folder = '/app/public/';
                    $web_path = env('APP_URL').'/storage/';
                    $image_name=  $user->username.'_'. time().'_'.$k.'_'.rand().'.png';

                    $temp_path = storage_path() . $base_folder . 'temp_' . $image_name;
                    //$path = storage_path() . $base_folder . $image_name;
                    file_put_contents($temp_path, $data);
                    //resize
                    $imgr = Image::make($temp_path);
                    $imgr->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $imgr->save($temp_path);

                    $url = s3_upload($image_name,$temp_path);
                    unlink(trim($temp_path));

                    return $url;
                }
    }
}

if (! function_exists('summernote_imageupload')) {
    function summernote_imageupload($user,$editor_data)
    {
    	$detail=$editor_data;
        if($detail){
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml(mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
            $images = $dom->getElementsByTagName('img');
            $data = null;

            foreach($images as $k => $img){

                $data = $img->getAttribute('src');



                if(strpos($data, ';'))
                {
                    $d = $data;
                
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = trim(base64_decode($data));

                    
                    $base_folder = '/app/public/';
                    $web_path = env('APP_URL').'/storage/';
                    $image_name=  $user->username.'_'. time().'_'.$k.'_'.rand().'.png';

                    $temp_path = storage_path() . $base_folder . 'temp_' . $image_name;
                    //$path = storage_path() . $base_folder . $image_name;
                    file_put_contents($temp_path, $data);
                    //resize
                    $imgr = Image::make($temp_path);
                    $imgr->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $imgr->save($temp_path);

                    $url = s3_upload($image_name,$temp_path);
                    unlink(trim($temp_path));

                    $img->removeAttribute('src');
                    $img->setAttribute('src', $url);
                    $img->setAttribute('class', 'image');
                }

                
            }

            if($data)
                $detail = $dom->saveHTML();
            else
                $details = $editor_data;
        }
        return $detail;
    }
}

if (! function_exists('summernote_imageremove')) {
    function summernote_imageremove($editor_data)
    {
        $detail=$editor_data;
        if($detail){
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml(mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
            $images = $dom->getElementsByTagName('img');

            foreach($images as $k => $img){
                $data = $img->getAttribute('src');

                $imgr= parse_url($data);
                if(file_exists(ltrim($imgr['path'],'/')))
                unlink(ltrim($imgr['path'],'/'));
            
            }
            $detail = $dom->saveHTML();
        }
        return $detail;
    }
}

if (! function_exists('scriptStripper')) {
    function scriptStripper($input)
    {
        return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input);
    }
}

if (! function_exists('url_exists')) {
function url_exists($url) {
    if (!$fp = curl_init($url)) return false;
    return true;
}
}

if (! function_exists('urlexists')) {
function urlexists($url) {
    $array = get_headers($url);
$string = $array[0];
if(strpos($string,"200"))
  {
    return true;
  }
  else
  {
    return false;
  }
}
}



if (! function_exists('youtube_video_exists')) {
function youtube_video_exists($url) {

    if(is_numeric($url)){   
        return false;
    }
    $videoUrl = "http://www.youtube.com/watch?v=".$url;
    $videoJson = "http://www.youtube.com/oembed?url=$videoUrl&format=json";
    $headers = get_headers($videoJson);
    $code = substr($headers[0], 9, 3);
    if ($code != "404") {
       return true;
    }
    return false;    

}
}

if (! function_exists('youtube_id')) {
function youtube_id($link) {
    $video=$link;
    $video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
    if (empty($video_id[1]))
        $video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..

    if(isset($video_id[1])){
        $video_id = explode("&", $video_id[1]);
    }
    
    $video = $video_id[0];
    
    return $video;

}
}





if (! function_exists('subdomain')) {
function subdomain() {
    $url = url()->full();

    if($_SERVER['HTTP_HOST'] == 'piofx.com' || $_SERVER['HTTP_HOST'] == 'piofx.in'  || $_SERVER['HTTP_HOST'] == 'onlinelibrary.test')
            return 'piofx';
    if($_SERVER['HTTP_HOST'] == 'gradable.test' || $_SERVER['HTTP_HOST'] == 'gradable.in' )
            return 'gradable';
    if($_SERVER['HTTP_HOST'] == 'corporate.onlinelibrary.test' )
            return 'rguktn';
    if($_SERVER['HTTP_HOST'] == 'xplore.co.in' || $_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.in.net' || $_SERVER['HTTP_HOST'] == 'app1.xplore.co.in' || $_SERVER['HTTP_HOST'] == 'app2.xplore.co.in' )
            return 'xplore';
    if($_SERVER['HTTP_HOST'] == 'learn.pp.test' || $_SERVER['HTTP_HOST'] == 'learn.packetprep.com'  )
            return 'packetprep';
    if($_SERVER['HTTP_HOST'] == 'devshala.gradable.test')
            return 'exam';
    if($_SERVER['HTTP_HOST'] == 'rgon.xplore.co.in')
            return 'rgukton';
    if($_SERVER['HTTP_HOST'] == 'rgsk.xplore.co.in')
            return 'rguktsk';
    // if($_SERVER['HTTP_HOST'] == 'rguknuzvid.xplore.in.net')
    //         return 'rguktong';
    if($_SERVER['HTTP_HOST'] == 'demo.xp.test' )
            return 'bits';

    $parsed = parse_url($url);
    $exploded = explode('.', $parsed["host"]);
     if(count($exploded) > 2){
        $parsed = parse_url($url);
            $exploded = explode('.', $parsed["host"]);
            $subdomain = $exploded[0];
            return $subdomain;
     }
     else
        return null;
    

}
}

if (! function_exists('domain')) {
function domain() {
    $url = url()->full();
    $parsed = parse_url($url);
    $exploded = explode('.', $parsed["host"]);
     if(count($exploded) > 2){
        $parsed = parse_url($url);
        $exploded = explode('.', $parsed["host"]);
        $domain = $exploded[1];
        
     }
     else{
         $parsed = parse_url($url);
        $exploded = explode('.', $parsed["host"]);
        $domain = $exploded[0];
     }


    if($domain == 'piofx' || $domain == 'p24' || $domain == 'onlinelibrary' )
            $domain  = 'piofx';
    if($_SERVER['HTTP_HOST'] == 'gradable')
            return 'gradable';
    if($domain == 'xplore' || $domain == 'xp' )
            $domain =  'xplore';

    return $domain;

}
}

if (! function_exists('subdomain_name')) {
function subdomain_name() {
    return null;

}
}

if (! function_exists('subdomain_contact')) {
function subdomain_contact() {
    $url = url()->full();

    $parsed = parse_url($url);
        $exploded = explode('.', $parsed["host"]);
     if(count($exploded) > 2){
        $parsed = parse_url($url);
            $exploded = explode('.', $parsed["host"]);
            $subdomain = $exploded[0];

            $json = json_decode(file_get_contents('http://json.onlinelibrary.co/json/'.$subdomain.'.json'));
            
            return htmlspecialchars_decode($json->contact);

     }
     else
        return null;

}
}

if (! function_exists('vimeoVideoDuration')) {
function vimeoVideoDuration($id) {

 try {
$authorization = 'your_vimeo_api_authorization_token_goes_here';
$ch = curl_init();

curl_setopt_array($ch, array(
    CURLOPT_URL => "https://api.vimeo.com/videos/$id?fields=duration",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "authorization: Bearer {$authorization}",
        "cache-control: no-cache",
    ),
));

    $res = curl_exec($ch);
    $obj = json_decode($res, true);
    return $obj['duration'];

} catch (Exception $e) {
   # returning 0 if the Vimeo API fails for some reason.
   return "0";
}
}
}
