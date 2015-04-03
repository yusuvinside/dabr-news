<?php
/*******************************************
CyberTwit News Script
Installasi :
1. Upload root 
2. Tambahkan kode di common/twitter.php
   require 'news.php';
3. Masih di twitter.php ,tambah kan kode di function menu register :
'news' => array(
    'hidden' => true,
    'callback' => 'twitter_news_page',
  ),
Selesai ...

http://yusuvinside.my.id
*****************************************/
function get_contents($url, $ua = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20120427 Firefox/15.0a1', $referer = 'http://www.google.com/') {
  if (function_exists('curl_exec')) {
    $header[0] = "Accept-Language: en-us,en;q=0.5";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, $ua);
    curl_setopt($curl, CURLOPT_REFERER, $referer);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    $content = curl_exec($curl);
    curl_close($curl);
  }
  else { 
    $content = file_get_contents($url);
  }
  return $content;
}
function cutter_r($content, $start, $end) {
	if($content && $start && $end) {
		$ex = explode($start, $content);
		$count = count($ex);
		if($count > 0) {
			for($i=1;$i<$count;$i++) {
				$ex2 = explode($end, $ex[$i]);
				$result[] = $ex2[0];
				unset($ex2);
			}
			return $result;
		}
	}
}
function gasrud($content){
preg_match('#<title>([^<]+)</title>#i', $content, $title);
preg_match('#<link>([^<]+)</link>#i', $content, $link);
preg_match('#<description>([^<]+)</description>#i', $content, $description);
preg_match('#<pubDate>([^<]+)</pubDate>#i', $content, $tgl);
$result['title'] = $title[1];
$result['link'] = $link[1];
$result['description'] = $description[1];
$result['tgl'] = $tgl[1];
$result['tgl'] = str_replace('+0700','',$result['tgl']);
return $result;
}
function twitter_news_page($query) {
	
	switch($query[1]) {
		case 'breakingnews':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/okezone/RSS2.0';
	  $judul = 'Breaking News';
	  break;
	  case 'international':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/international/RSS2.0';
	  $judul = 'International';
	  break;
	  case 'lifestyle':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/lifestyle/RSS2.0';
	  $judul = 'Lifestyle';
	  break;
	  case 'international':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/international/RSS2.0';
	  $judul = 'International';
	  break;
	  case 'celebrity':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/celebrity/RSS2.0';
	  $judul = 'Celebrity';
	  break;
	  case 'sports':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/sports/RSS2.0';
	  $judul = 'Sports';
	  break;
	  case 'bola':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/bola/RSS2.0';
	  $judul = 'Bola';
	  break;
	  case 'autos':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/autos/RSS2.0';
	  $judul = 'Autos';
	  break;
	  case 'techno':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/techno/RSS2.0';
	  $judul = 'Techno';
	  break;
	  case 'tokoh':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/tokoh/RSS2.0';
	  $judul = 'Tokoh';
	  break;
	  case 'economy':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/economy/RSS2.0';
	  $judul = 'Economy';
	  break;
	  case 'foto':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/foto/RSS2.0';
	  $judul = 'Foto';
	  break;
	  case 'pilkada':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/pilkada/RSS2.0';
	  $judul = 'Pilkada';
	  break;
	  case 'kampus':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/kampus/RSS2.0';
	  $judul = 'Kampus';
	  break;
    case 'kuliner':
	  $actionurl = 'http://sindikasi.okezone.com/index.php/okefood/RSS2.0';
	  $judul = 'Kuliner';
	  break;
	  default:
	  $actionurl = 'http://sindikasi.okezone.com/index.php/news/RSS2.0';
	  $judul = 'News';
	  break;
		
	}
	
	  //$actionurl = "http://sindikasi.okezone.com/index.php/okezone/RSS2.0";
		$data = get_contents($actionurl);
    $start = '<item>';
    $end = '</item>';
    $hasil = cutter_r($data,$start,$end);
    $content .= '<div class="navlow">CyberTwit News</div>
    <div class="opt"><a href="./news">NEWS</a> | 
    <a href="./news/breakingnews">BREAKING NEWS</a> | 
    <a href="./news/international">INTERNATIONAL</a> | 
    <a href="./news/celebrity">CELEBRITY</a> | 
    <a href="./news/sports">SPORTS</a> | 
    <a href="./news/bola">BOLA</a> | 
    <a href="./news/autos">AUTOS</a> | 
    <a href="./news/techno">TECHNO</a> | 
    <a href="./news/tokoh">TOKOH</a> | 
    <a href="./news/economy">ECONOMY</a> | 
    <a href="./news/foto">FOTO</a> | 
    <a href="./news/pilkada">PILKADA</a> | 
    <a href="./news/kampus">KAMPUS</a> | 
    <a href="./news/kuliner">KULINER</a></div>';
    if(is_array($hasil)) {

	    foreach($hasil as $v) {
	    
		  $searchresult = gasrud($v);
		  $su = $searchresult['link'];
		  $smstext = $searchresult['title'].' | '.$su;
		  $content .= '<div class="tweet even"><a href="./share?u='.urlencode($smstext).'">
		  <img src="./Assets/share.png" alt="Share it" title="Share to friend"/></a>
		  <a href="'.$su.'" target="_blank" rel="nofollow">'.$searchresult['title'].'</a><br>
		  <div class="small"><i>'.$searchresult['tgl'].'</i></div>
		  '.$searchresult['description'].'
		  </div>';
		  unset($searchresult);
	    }
    }
	
	theme('page',$judul, $content);
}
?>
