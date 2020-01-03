<?php
error_reporting(0);
function tokenNew($token){
  $newString	=	'';
  $str = $token;
  for($i=0;$i<strlen($str);$i++){
    if(!is_numeric($str[$i])){
      $stringufy	=	$str[$i];
      $newString	.=	++$stringufy;
    }else{
      $newString	.=	$str[$i];
    }
  }

  return $newString;
}

function crscgatau($e){
  $t = 0;
  $i = 0;
  $o = 0;
  for ($s = strlen($e); $o < $s; $o++){
    $o % 2 == 0 ? $t += ord($e[$o]) : $i += ord($e[$o]);
  }
  return $t * ($t+$i) * abs($t - $i);
}

for($i=1;$i<=134;$i++){
  $getHtmlListOfPage  = file_get_contents('https://idxx1.net/21cineplex/'.$i);
  $getContentList = explode('<div id="movie-featured" class="movies-list movies-list-full tab-pane in fade active">',$getHtmlListOfPage)[1];
  $closeExplodeListContent  = explode('<div style="clear:both;">',$getContentList)[0];
  //print_r(explode('<div data-movie-id=',$closeExplodeListContent));
  foreach(explode('<div data-movie-id=',$closeExplodeListContent) as $k=>$v){
    if(!empty($v)){
      $getUrlSub  = explode("'",substr($v,1))[0];
      $nameFilm = substr($getUrlSub,7);
      $fullLink = file_get_contents("https://idxx1.net".$getUrlSub."/play");// /movie/the-two-popes-2019-btes
      $getUniqueCodeTmdb  = explode('data-tmdb="',$fullLink)[1];
      $getUniqueCodeTmdbFinale  = explode('"',$getUniqueCodeTmdb)[0];
      $getCookieName  = explode('var cookie_name="',$fullLink)[1];
      $getCookieNameFinale  = explode('";',$getCookieName)[0];
      //$timeNow  = explode('ts2=',$fullLink)[1];
      $timeNow  = explode(';',explode('ts2=',$fullLink)[1])[0];

      $newK = crscgatau(base64_encode($timeNow.$getUniqueCodeTmdbFinale) . $timeNow . $getUniqueCodeTmdbFinale . crscgatau($getUniqueCodeTmdbFinale . $timeNow));

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, 'https://playmv2.kotakcoklat.casa/?token='.tokenNew($getCookieNameFinale).'&t='.$timeNow.'&k='.$newK.'&v=static8.js');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

      curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

      $headers = array();
      $headers[] = 'Host: playmv.kotakcoklat.casa';
      $headers[] = 'Accept: */*';
      $headers[] = 'Origin: https://idxx1.net';
      $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36';
      $headers[] = 'Sec-Fetch-Site: cross-site';
      $headers[] = 'Sec-Fetch-Mode: cors';
      $headers[] = 'Referer: https://idxx1.net/movie/'.$nameFilm.'/play';
      $headers[] = 'Accept-Language: en-US,en;q=0.9,id;q=0.8,und;q=0.7,ms;q=0.6';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $result = curl_exec($ch);
      if (curl_errno($ch)) {
          echo 'Error:' . curl_error($ch);
      }
      curl_close($ch);

      $from = 'ZYX10+/PONM765LKJIAzyTSRQGxwvuHWVFEDUCBtsrqdcba9843ponmlkjihgfe2';
      $to = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
      $resultInJson = base64_decode(strtr($result, $from, $to));

      //cek letak array json
      if(strpos(json_decode($resultInJson,true)[0]['sources'][0]['file'], 'docs.') !== false){
        $letak  = json_decode($resultInJson,true)[0]['sources'][0]['file'];
      }else if(strpos(json_decode($resultInJson,true)[1]['sources'][0]['file'], 'docs.') !== false){
        $letak  = json_decode($resultInJson,true)[1]['sources'][0]['file'];
      }else{
        $letak  = 'nol';
      }

      if($letak !== "nol"){
        if(!empty($timeNow)){
          $whatWeNeedIs = explode('?e=',explode('/*/',$letak)[1])[0];
          $tokenNow = crscgatau(base64_encode($timeNow.$whatWeNeedIs) . $timeNow . $whatWeNeedIs . crscgatau($whatWeNeedIs . $timeNow));
          $ch = curl_init();

          curl_setopt($ch, CURLOPT_URL, 'https://playdrv3.kotakcoklat.casa/mv/?dv='.urlencode($whatWeNeedIs).'&ts='.$timeNow.'&token='.$tokenNow.'&hs=0&epi=0');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

          curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

          $headers = array();
          $headers[] = 'Host: playdrv3.kotakcoklat.casa';
          $headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
          $headers[] = 'Origin: https://idxx1.net';
          $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36';
          $headers[] = 'Sec-Fetch-Site: cross-site';
          $headers[] = 'Sec-Fetch-Mode: cors';
          $headers[] = 'Referer: https://idxx1.net/movie/'.$nameFilm.'/play';
          $headers[] = 'Accept-Language: en-US,en;q=0.9,id;q=0.8,und;q=0.7,ms;q=0.6';
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          $resultJson = curl_exec($ch);
          if (curl_errno($ch)) {
              echo 'Error:' . curl_error($ch);
          }
          curl_close($ch);
          $stringToBuild = '';

          foreach(json_decode($resultJson,true)[0]['sources'] as $k=>$v){
            if(json_decode($resultJson,true)[0]['sources'][$k]['label'] == '360p' || json_decode($resultJson,true)[0]['sources'][$k]['label'] == '480p' || json_decode($resultJson,true)[0]['sources'][$k]['label'] == '720p' || json_decode($resultJson,true)[0]['sources'][$k]['label'] == '1080p'){
              //$stringToBuild .= '&link'.json_decode($resultJson,true)[0]['sources'][$k]['label'].'='.explode('/*/',explode('?e=',json_decode($resultJson,true)[0]['sources'][$k]['file'])[0])[1];
              echo $nameFilm."|".$timeNow."|".json_decode($resultJson,true)[0]['sources'][$k]['label']."|".$getUniqueCodeTmdbFinale."|".explode('/*/',explode('?e=',json_decode($resultJson,true)[0]['sources'][$k]['file'])[0])[1]."|".json_decode($resultJson,true)[0]['sources'][$k]['file']."
";
              // $linkNya  = explode('/*/',explode('?e=',json_decode($resultJson,true)[0]['sources'][$k]['file'])[0])[1];
            }
          }

        }else{
        }
      }else{
      }
    }
  }
}
