<?php


if (! function_exists('image_resize')) {
    function image_resize($image_path,$size)
    {
        $base_folder = '/app/public/';
        $path = storage_path() . $base_folder . $image_path;

        $explode= explode('.', $path);
        dd($path);
        
        $imgr = Image::make($path)->encode('jpg', 100);
       
        $imgr->resize($size, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
        });
              
        $imgr->save($explode[0].'_'.$size.'.jpg');  

        return true;
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

            foreach($images as $k => $img){

                $data = $img->getAttribute('src');

                if(strpos($data, ';'))
                {
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);

                    $base_folder = '/app/public/summernote/';
                    $web_path = env('APP_URL').'/storage/summernote/';
                    $image_name=  $user->username.'_'. time().'_'.$k.'_'.rand().'.png';

                    $temp_path = storage_path() . $base_folder . 'temp_' . $image_name;
                    $path = storage_path() . $base_folder . $image_name;
                    file_put_contents($temp_path, $data);
                    //resize
                    $imgr = Image::make($temp_path);
                    $imgr->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $imgr->save($path);

                    $imgr = Image::make($temp_path);
                    $imgr->resize(400, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $imgr->save($path);

                    unlink(trim($temp_path));

                    $img->removeAttribute('src');
                    $img->setAttribute('src', $web_path.$image_name);
                    $img->setAttribute('class', 'image');
                }
                
            }
            $detail = $dom->saveHTML();
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

if (! function_exists('youtube_video_exists')) {
function youtube_video_exists($url) {
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


if (! function_exists('subdomain')) {
function subdomain() {
    $url = url()->full();

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

if (! function_exists('subdomain_name')) {
function subdomain_name() {
    $url = url()->full();

    $parsed = parse_url($url);
        $exploded = explode('.', $parsed["host"]);
     if(count($exploded) > 2){
        $parsed = parse_url($url);
            $exploded = explode('.', $parsed["host"]);
            $subdomain = $exploded[0];

            
            $json = json_decode(file_get_contents('http://json.onlinelibrary.co/json/'.$subdomain.'.json'));
            

            return $json->name;

     }
     else
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
