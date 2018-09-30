<?php

function get_url_contents($url){
        $crl = curl_init();
        $timeout = 5;
        curl_setopt ($crl, CURLOPT_URL,$url);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $ret = curl_exec($crl);
        
        curl_close($crl);

        return $ret;
}

function fixJSON($json) {
    $regex = <<< 'REGEX'
~
    "[^"\\]*(?:\\.|[^"\\]*)*"
    (*SKIP)(*F)
  | '([^'\\]*(?:\\.|[^'\\]*)*)'
~x
REGEX;

    return preg_replace_callback($regex, function($matches) {
        return '"' . preg_replace('~\\\\.(*SKIP)(*F)|"~', '\\"', $matches[1]) . '"';
    }, $json);
}
		
// __ MAIN ___

      $defaultTimeZone='UTC';
      date_default_timezone_set($defaultTimeZone);
		
      $ini_time = new DateTime();
      echo "\nTime init : ". $ini_time->format('Y/m/d H:i:s')." UTC";
      
      // get gentcat data
      $url_target = "http://static-m.meteo.cat/content/opendata/dadesobertes_pg.json";
      $gentCatData = get_url_contents($url_target);
		
      //echo $gentCatData;		

      $fixedContent = json_decode(fixJSON(utf8_encode($gentCatData)));
      echo "\nDecoding content ";			
      //var_dump($fixedContent);

      echo "\n";
      //var_dump($fixedContent[0]);
		
      echo "\n Reported day " .$fixedContent[0]->diaPredit;

      $defaultTimeZone='Europe/Madrid';
      date_default_timezone_set($defaultTimeZone);
      $local_time = new DateTime();
      	  
      $afternoon_sample = strtotime( $local_time->format('Y/m/d 12:00:00'));
      $current_time = time();
      
      if($current_time < $afternoon_sample ) {
        echo "\nMORNING REPORT\n";
      	$estatDelCel = $fixedContent[0]->versio->mati->simbols->estatDelCel;
      }      
      else {
	echo "\nAFTERNOON REPORT\n";
      	$estatDelCel = $fixedContent[0]->versio->tarda->simbols->estatDelCel;
      }

      var_dump($estatDelCel);

	
// REFERENCES
// gentCat data weather map
   /*
"codi":1"descripcio":"sol"
"codi":2"descripcio":"sol i núvols alts"
"codi":3"descripcio":"entre poc i mig ennuvolat"
"codi":4"descripcio":"cobert"
"codi":5"descripcio":"plugim"
"codi":6"descripcio":"pluja"
"codi":7"descripcio":"xàfec"  
"codi":8"descripcio":"tempesta"
"codi":9"descripcio":"tempesta calamarsa"
"codi":10"descripcio":"neu"
"codi":11"descripcio":"boira"
"codi":12"descripcio":"boirina"
"codi":13"descripcio":"xàfec neu"
"codi":20"descripcio":"entre mig i molt ennuvolat"
"codi":21"descripcio":"cobert"
"codi":22"descripcio":"calitja"
"codi":23"descripcio":"ruixat"
"codi":24"descripcio":"xàfec amb tempesta"
"codi":25"descripcio":"xàfec"
"codi":26"descripcio":"ruixat"
"codi":27"descripcio":"neu feble"
"codi":28"descripcio":"temperatura neu"
"codi":29"descripcio":"xàfec"
"codi":30"descripcio":"aiguaneu"
"codi":31"descripcio":"ruixat"
"codi":32"descripcio":"plugim"
"codi":50"descripcio":"plana"
"codi":51"descripcio":"arrissada"
"codi":52"descripcio":"marejol"
"codi":53"descripcio":"maror"
"codi":54"descripcio":"forta maror"
"codi":55"descripcio":"maregassa"
"codi":56"descripcio":"mar brava"
"codi":57"descripcio":"mar desfeta"
"codi":58"descripcio":"mar molt alta"
"codi":59"descripcio":"mar enorme"
"codi":60"descripcio":"mar de fons
   */

//s 8:00, amb informació pel dia present i per l'endemà, a les 11:30 i a les 19:30

	
?>
