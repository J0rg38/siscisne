<?php

function FncSoloNumeros($oTexto){
	
	$respuesta = 0;
	
	$conservar = '0-9'; // juego de caracteres a conservar
	$regex = sprintf('~[^%s]++~i', $conservar); // case insensitive
	$string = preg_replace($regex, '', $oTexto);

	return $string;
}



function ExcelToPHP($EXCEL_DATE = 0) {
	
	$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
	$EXCEL_DATE = 25569 + ($UNIX_DATE / 86400);
	$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
	
	return $UNIX_DATE;
	
  /*  if ($ExcelBaseDate == 1900) {
        $myExcelBaseDate = 25569;
        //    Adjust for the spurious 29-Feb-1900 (Day 60)
        if ($dateValue < 60) {
            --$myExcelBaseDate;
        }
    } else {
        $myExcelBaseDate = 24107;
    }

    // Perform conversion
    if ($dateValue >= 1) {
        $utcDays = $dateValue - $myExcelBaseDate;
        $returnValue = round($utcDays * 86400);
        if (($returnValue <= PHP_INT_MAX) && ($returnValue >= -PHP_INT_MAX)) {
            $returnValue = (integer) $returnValue;
        }
    } else {
        $hours = round($dateValue * 24);
        $mins = round($dateValue * 1440) - round($hours * 60);
        $secs = round($dateValue * 86400) - round($hours * 3600) - round($mins * 60);
        $returnValue = (integer) gmmktime($hours, $mins, $secs);
    }

    // Return
    return $returnValue;*/
}


function html2text($Document) {
	
    $Rules = array ('&amp;',
                    '&aacute;',
					 '&eacute;',
					  '&iacute;',
					   '&oacute;',
					    '&uacute;',
						
						  '&Aacute;',
					 '&Eacute;',
					  '&Iacute;',
					   '&Oacute;',
					    '&Uacute;',
						
						'&ntilde;',
						'&Ntilde;',
						
                   
             );
    $Replace = array ('',
                      'a',
					  'e',
					  'i',
					  'o',
					  'u',
					  'A',
					  'E',
					  'I',
					  'O',
					  'U',
					  
					'ntilde;',
					'Ntilde;'
                     
                );
  return str_replace($Rules, $Replace, $Document);
}
function FncRestarFechas($oFechaInicio,$oFechaFin){

	$fechaInicial = $oFechaInicio;
	$fechaActual = $oFechaFin; // la fecha del ordenador
	 
	// Obtenemos la diferencia en milisegundos
	$diff = abs(strtotime($fechaActual) - strtotime($fechaInicial));
	 
	$years = floor($diff / (365*60*60*24));
	
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	
	return $days;
	
}

function primera_mayuscula($cadena){
$cadena=mb_convert_case($cadena, MB_CASE_TITLE, "utf8");
return($cadena);
}

function jbalog($oRuta,$oNombreArchivo,$oContenido){

	if(file_exists($oRuta.''.$oNombreArchivo)){
		unlink($oRuta.''.$oNombreArchivo);
	}
	$ddf = @fopen($oRuta.''.$oNombreArchivo,'a');
	@fwrite($ddf,$oContenido);
	@fclose($ddf);

}

function TimeToSec($time) {
    $sec = 0;
    foreach (array_reverse(explode(':', $time)) as $k => $v) $sec += pow(60, $k) * $v;
    return $sec;
}

function LimpiarNombreArchivo($oTexto){

	$nombre = quitar_tildes($oTexto);
	$nombre = str_replace(" ","_",$nombre);
	
	return $nombre;
	
}
function quitar_tildes($cadena) {
	
$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã");
$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
$texto = str_replace($no_permitidas, $permitidas ,$cadena);

return $texto;
}

function reemplazaMe($text) { 
utf8_encode($text); 
$codigo= array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&uuml;","&ntilde;"); 
$cambiar = array("á","é","í","ó","ú","ü","ñ"); 
$text = str_replace($codigo, $cambiar, $text); 
$text= strtolower($text); 
//$text = ereg_replace("[^A-Za-z0-9-]", "", $text); 
return $text; 
}  
function file_url($url){
  $parts = parse_url($url);
  $path_parts = array_map('rawurldecode', explode('/', $parts['path']));

  return
    $parts['scheme'] . '://' .
    $parts['host'] .
    implode('/', array_map('rawurlencode', $path_parts))
  ;
}

function storeUrlToFilesystem($url, $localFile) {
	try {
		$data = file_get_contents($source);
		$handle = fopen($destination, "w");
		fwrite($handle, $data);
		fclose($handle);
		return true;	
	} catch (Exception $e) {
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
	return false;
}
//
//function FncTiempoTranscurrido($fecha_inicio,$fecha_fin) {
//
//	if(empty($fecha_fin)) {
//		  return "No hay fecha";
//	}
//	
//	list($nfecha,$nhora) = explode(" ",$fecha_fin);
//	list($ndia,$nmes,$nano) = explode("/",$nfecha);
//
//	
//	$fecha_fin = $nano."/".$nmes."/".$ndia." ".$nhora;
//	
//	list($nfecha,$nhora) = explode(" ",$fecha_inicio);
//	list($ndia,$nmes,$nano) = explode("/",$nfecha);
//	
//	$fecha_inicio = $nano."/".$nmes."/".$ndia." ".$nhora;
//	
//	
//   
//	$intervalos = array("segundo", "minuto", "hora", "día", "semana", "mes", "año");
//	$duraciones = array("60","60","24","7","4.35","12");
//   
//	$ahora = strtotime($fecha_inicio);
//	$Fecha_Unix = strtotime($fecha_fin);
//	
//	if(empty($Fecha_Unix)) {   
//		  return "Fecha incorracta";
//	}
//	if($ahora > $Fecha_Unix) {   
//		  $diferencia     =$ahora - $Fecha_Unix;
//		  $tiempo         = "Hace";
//	} else {
//		  $diferencia     = $Fecha_Unix -$ahora;
//		  $tiempo         = "Dentro de";
//	}
//	for($j = 0; $diferencia >= $duraciones[$j] && $j < count($duraciones)-1; $j++) {
//	  $diferencia /= $duraciones[$j];
//	}
//   
//	$diferencia = round($diferencia);
//	
//	if($diferencia != 1) {
//		$intervalos[5].="e"; //MESES
//		$intervalos[$j].= "s";
//	}
//   
//    return "$tiempo $diferencia $intervalos[$j]";
//}



function FncRedondearCYC($oNumero){
	
	//15.35
	//16
	
	$redondeado = 0;
	
	list($entero,$decimal) = explode(".",$oNumero);
	
	if(($decimal)>0){
		
		$redondeado = $entero + 1;
		
	}else{
		
		$redondeado = $entero;
		
	}
	
	return $redondeado;
}


function stripAccents($string) {
    $accents = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','Þ','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ð','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ý','ý','þ','ÿ','Ŕ','ŕ');
    $string = str_replace($accents, '', $string);
    return $string;
}


function get_mime_type(&$structure) { 
    $primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"); 
    if($structure->subtype) { 
         return $primary_mime_type[(int) $structure->type] . '/' . $structure->subtype; 
     } 
     return "TEXT/PLAIN"; 
} 


function get_part($stream, $msg_number, $mime_type, $structure = false, $part_number = false) {
    if (!$structure) { 
         $structure = imap_fetchstructure($stream, $msg_number,FT_UID); 
     } 
    if($structure) { 
         if($mime_type == get_mime_type($structure)) { 
              if(!$part_number) { 
                   $part_number = "1"; 
               } 
              $text = imap_fetchbody($stream, $msg_number, $part_number); 
              if($structure->encoding == 3) { 
                   return imap_base64($text); 
               } else if ($structure->encoding == 4) { 
                   return imap_qprint($text); 
               } else { 
                   return $text; 
            } 
        } 
         if ($structure->type == 1) { /* multipart */ 
              while (list($index, $sub_structure) = each($structure->parts)) { 
                if ($part_number) { 
                    $prefix = $part_number . '.'; 
                } 
                $data = get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1)); 
                if ($data) { 
                    return $data; 
                } 
            } 
        } 
    } 
    return false; 
} 







function FncCantidadDiaMes($oAno,$oMes){
	$cantidad = -1;
	
	$cantidad = cal_days_in_month(CAL_GREGORIAN, $oMes, $oAno); // 31

	return $cantidad;
	
}


function FncObtenerIp() {
	
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
		return $_SERVER['HTTP_CLIENT_IP'];
		
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	
	return $_SERVER['REMOTE_ADDR'];
}


function FncConvertirNumeroALetraExcel($oNumero){
	
	$Letra = "";
	
	switch($oNumero){
		case 1:
			$Letra = "A";
		break;
		
		case 2:
			$Letra = "B";
		break;
		
		case 3:
			$Letra = "C";
		break;
		
		case 4:
			$Letra = "D";
		break;
		
		case 5:
			$Letra = "E";
		break;
		
		case 6:
			$Letra = "F";
		break;
		
		case 7:
			$Letra = "G";
		break;
		
		case 8:
			$Letra = "H";
		break;
		
		case 9:
			$Letra = "I";
		break;
		
		case 10:
			$Letra = "J";
		break;
		
		case 11:
			$Letra = "K";
		break;
		
		case 12:
			$Letra = "L";
		break;
		
		case 13:
			$Letra = "M";
		break;
		
		case 14:
			$Letra = "N";
		break;
		
		case 15:
			$Letra = "O";
		break;
		
		case 16:
			$Letra = "P";
		break;
		
		case 17:
			$Letra = "Q";
		break;
		
		case 18:
			$Letra = "R";
		break;
		
		case 19:
			$Letra = "S";
		break;
		
		case 20:
			$Letra = "T";
		break;
		
		case 21:
			$Letra = "U";
		break;
		
		case 22:
			$Letra = "V";
		break;
		
		case 23:
			$Letra = "W";
		break;
		
		case 24:
			$Letra = "X";
		break;
		
		case 25:
			$Letra = "Y";
		break;

		case 26:
			$Letra = "Z";
		break;

		case 27:
			$Letra = "AA";
		break;
		case 28:
			$Letra = "AB";
		break;
		case 29:
			$Letra = "AC";
		break;
		case 30:
			$Letra = "AD";
		break;
		case 31:
			$Letra = "AE";
		break;
		case 32:
			$Letra = "AF";
		break;
		case 33:
			$Letra = "AG";
		break;
		
		
		case 34:
			$Letra = "AH";
		break;
		
		case 35:
			$Letra = "AI";
		break;
		
		
		case 36:
			$Letra = "AJ";
		break;
		
		case 37:
			$Letra = "AK";
		break;
		
		case 38:
			$Letra = "AL";
		break;
	}
	
	return $Letra;
}

function FncLimpiarCaracteresEspeciales($s) {
	
	$s = ereg_replace("[áàâãª]","a",$s);
	$s = ereg_replace("[ÁÀÂÃ]","A",$s);
	$s = ereg_replace("[éèê]","e",$s);
	$s = ereg_replace("[ÉÈÊ]","E",$s);
	$s = ereg_replace("[íìî]","i",$s);
	$s = ereg_replace("[ÍÌÎ]","I",$s);
	$s = ereg_replace("[óòôõº]","o",$s);
	$s = ereg_replace("[ÓÒÔÕ]","O",$s);
	$s = ereg_replace("[úùû]","u",$s);
	$s = ereg_replace("[ÚÙÛ]","U",$s);
	$s = str_replace(" ","-",$s);
	$s = str_replace("ñ","n",$s);
	$s = str_replace("Ñ","N",$s);
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return $s;
}


function FncCortarTexto($texto, $limite=100){   
    $texto = trim($texto);
    $texto = strip_tags($texto);
    $tamano = strlen($texto);
    $resultado = '';
    if($tamano <= $limite){
        return $texto;
    }else{
        $texto = substr($texto, 0, $limite);
        $palabras = explode(' ', $texto);
        $resultado = implode(' ', $palabras);
        $resultado .= '...';
    }   
    return $resultado;
}


function FncLimpiarVariable($oVariable,$oTipo=NULL){

	return	 $oVariable;
	
}


  function FncTiempoTranscurrido($datefrom, $dateto = -1)
 {
	 
	// Defaults and assume if 0 is passed in that
	// its an error rather than the epoch
	if ($datefrom <= 0) {
	  return "A long time ago";
	}
	if($dateto==-1) {
	  $dateto = time();
	}
	// Calculate the difference in seconds betweeen
	// the two timestamps
	$difference = $dateto - $datefrom;
	
	$difference ;
	// If difference is less than 60 seconds,
	// seconds is a good interval of choice
	if($difference < 60) {
	  $interval = "s";
	}
	// If difference is between 60 seconds and
	// 60 minutes, minutes is a good interval
	elseif($difference >= 60 && $difference < 60*60) {
	  $interval = "n";
	}
	// If difference is between 1 hour and 24 hours
	// hours is a good interval
	elseif($difference >= 60*60 && $difference < 60*60*24) {
	  $interval = "h";
	}
	// If difference is between 1 day and 7 days
	// days is a good interval
	elseif($difference >= 60*60*24 && $difference < 60*60*24*7) {
	  $interval = "d";
	}
	// If difference is between 1 week and 30 days
	// weeks is a good interval
	elseif($difference >= 60*60*24*7 && $difference < 60*60*24*30) {
	  $interval = "ww";
	}
	// If difference is between 30 days and 365 days
	// months is a good interval, again, the same thing
	// applies, if the 29th February happens to exist
	// between your 2 dates, the function will return
	// the 'incorrect' value for a day
	elseif($difference >= 60*60*24*30 && $difference < 60*60*24*365) {
	  $interval = "m";
	}
	// If difference is greater than or equal to 365
	// days, return year. This will be incorrect if
	// for example, you call the function on the 28th April
	// 2008 passing in 29th April 2007. It will return
	// 1 year ago when in actual fact (yawn!) not quite
	// a year has gone by
	elseif($difference >= 60*60*24*365) {
	  $interval = "y";
	}
	// Based on the interval, determine the
	// number of units between the two dates
	// From this point on, you would be hard
	// pushed telling the difference between
	// this function and DateDiff. If the $datediff
	// returned is 1, be sure to return the singular
	// of the unit, e.g. 'day' rather 'days'
	switch($interval) {
	  case "m":
		$months_difference = floor($difference / 60 / 60 / 24 / 29);
		while (mktime(date("H", $datefrom), date("i", $datefrom),
		  date("s", $datefrom), date("n", $datefrom) + ($months_difference),
		  date("j", $dateto), date("Y", $datefrom)) < $dateto) {
		  $months_difference++;
		}
		$datediff = $months_difference;
		// We need this in here because it is possible
		// to have an 'm' interval and a months
		// difference of 12 because we are using 29 days
		// in a month
		if($datediff == 12) {
		  $datediff--;
		}
		$res = ($datediff==1) ? "Hace $datediff mes" : "Hace $datediff meses";
	  break;
	  case "y":
		$datediff = floor($difference / 60 / 60 / 24 / 365);
		$res = ($datediff==1) ? "Hace $datediff año" : "Hace $datediff años";
	  break;
	  case "d":
		$datediff = floor($difference / 60 / 60 / 24);
		$res = ($datediff==1) ? "Hace $datediff dia" : "Hace $datediff dias";
	  break;
	  case "ww":
		$datediff = floor($difference / 60 / 60 / 24 / 7);
		$res = ($datediff==1) ? "Hace $datediff semana" : "Hace $datediff semanas";
	  break;
	  case "h":
		$datediff = floor($difference / 60 / 60);
		$res = ($datediff==1) ? "Hace $datediff hora" : "Hace $datediff horas";
	  break;
	  case "n":
		$datediff = floor($difference / 60);
		$res = ($datediff==1) ? "Hace $datediff minuto" : "Hace $datediff minutos";
	  break;
	  case "s":
		$datediff = $difference;
		$res = ($datediff==1) ? "Hace $datediff segundo" : "Hace $datediff segundos";
	  break;
	}
	return $res;
}

function redondear_dos_decimal($valor) {

   $float_redondeado=round($valor * 100) / 100;
   
   return $float_redondeado;
} 



function FncConvetirTimestamp($oDate){
	
	$Aux = explode(" ",$oDate);
	$Fecha = $Aux[0];
	$Hora = $Aux[1];
	
	list($day, $month, $year) = explode('/', $Fecha);
	
	if(!empty($Hora) ){
		list($hora,$minuto,$segundo) = explode(":",$Hora);
		$timestamp = mktime($hora, $minuto, $segundo, $month, $day, $year);
		
		
	}else{
		$timestamp = mktime(0, 0, 0, $month, $day, $year);		
		
	}

	
	return $timestamp;

}



function FncCodigoRegenerar($oCodigo,$oContador=0){
	
	$ArrCodigo = explode("-",$oCodigo);

	if($oContador==0){
		$Numero = $ArrCodigo[1];		
	}else{
		$Numero = $ArrCodigo[1]+ 1;	
	}
	
	
	return $ArrCodigo[0]."-".$Numero;
	
}


/*
Funciones - Clases
*/

function createExcel($filename, $arrydata) {
	$excelfile = "xlsfile://tmp/".$filename;  
	$fp = fopen($excelfile, "wb");  
	if (!is_resource($fp)) {  
		die("Error al crear $excelfile");  
	}  
	fwrite($fp, serialize($arrydata));  
	fclose($fp);
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
	header ("Cache-Control: no-cache, must-revalidate");  
	header ("Pragma: no-cache");  
	header ("Content-type: application/x-msexcel");  
	header ("Content-Disposition: attachment; filename=\"" . $filename . "\"" );
	readfile($excelfile);  
}





/*
Funciones
*/
$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');


/*

function num2letras($num, $fem = false, $dec = true) {
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande");
   $matuni[2]  = "dos";
   $matuni[3]  = "tres";
   $matuni[4]  = "cuatro";
   $matuni[5]  = "cinco";
   $matuni[6]  = "seis";
   $matuni[7]  = "siete";
   $matuni[8]  = "ocho";
   $matuni[9]  = "nueve";
   $matuni[10] = "diez";
   $matuni[11] = "once";
   $matuni[12] = "doce";
   $matuni[13] = "trece";
   $matuni[14] = "catorce";
   $matuni[15] = "quince";
   $matuni[16] = "dieciseis";
   $matuni[17] = "diecisiete";
   $matuni[18] = "dieciocho";
   $matuni[19] = "diecinueve";
   $matuni[20] = "veinte";
   $matunisub[2] = "dos";
   $matunisub[3] = "tres";
   $matunisub[4] = "cuatro";
   $matunisub[5] = "quin";
   $matunisub[6] = "seis";
   $matunisub[7] = "sete";
   $matunisub[8] = "ocho";
   $matunisub[9] = "nove";

   $matdec[2] = "veint";
   $matdec[3] = "treinta";
   $matdec[4] = "cuarenta";
   $matdec[5] = "cincuenta";
   $matdec[6] = "sesenta";
   $matdec[7] = "setenta";
   $matdec[8] = "ochenta";
   $matdec[9] = "noventa";
   $matsub[3]  = 'mill';
   $matsub[5]  = 'bill';
   $matsub[7]  = 'mill';
   $matsub[9]  = 'trill';
   $matsub[11] = 'mill';
   $matsub[13] = 'bill';
   $matsub[15] = 'mill';
   $matmil[4]  = 'millones';
   $matmil[6]  = 'billones';
   $matmil[7]  = 'de billones';
   $matmil[8]  = 'millones de billones';
   $matmil[10] = 'trillones';
   $matmil[11] = 'de trillones';
   $matmil[12] = 'millones de trillones';
   $matmil[13] = 'de trillones';
   $matmil[14] = 'billones de trillones';
   $matmil[15] = 'de billones de trillones';
   $matmil[16] = 'millones de billones de trillones';

   $num = trim((string)@$num);
   if ($num[0] == '-') {
      $neg = 'menos ';
      $num = substr($num, 1);
   }else
      $neg = '';
   while ($num[0] == '0') $num = substr($num, 1);
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
   $zeros = true;
   $punt = false;
   $ent = '';
   $fra = '';
   for ($c = 0; $c < strlen($num); $c++) {
      $n = $num[$c];
      if (! (strpos(".,'''", $n) === false)) {
         if ($punt) break;
         else{
            $punt = true;
            continue;
         }

      }elseif (! (strpos('0123456789', $n) === false)) {
         if ($punt) {
            if ($n != '0') $zeros = false;
            $fra .= $n;
         }else

            $ent .= $n;
      }else

         break;

   }
   $ent = '     ' . $ent;
   if ($dec and $fra and ! $zeros) {
      $fin = ' con';
      for ($n = 0; $n < strlen($fra); $n++) {
         if (($s = $fra[$n]) == '0')
            $fin .= ' cero';
         elseif ($s == '1')
            $fin .= $fem ? ' una' : ' un';
         else
            $fin .= ' ' . $matuni[$s];
      }
   }else
      $fin = '';
   if ((int)$ent === 0) return 'Cero ' . $fin;
   $tex = '';
   $sub = 0;
   $mils = 0;
   $neutro = false;
   while ( ($num = substr($ent, -3)) != '   ') {
      $ent = substr($ent, 0, -3);
      if (++$sub < 3 and $fem) {
         $matuni[1] = 'una';
         $subcent = 'as';
      }else{
         $matuni[1] = $neutro ? 'un' : 'uno';
         $subcent = 'os';
      }
      $t = '';
      $n2 = substr($num, 1);
      if ($n2 == '00') {
      }elseif ($n2 < 21)
         $t = ' ' . $matuni[(int)$n2];
      elseif ($n2 < 30) {
         $n3 = $num[2];
         if ($n3 != 0) $t = 'i' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
      }else{
         $n3 = $num[2];
         if ($n3 != 0) $t = ' y ' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
      }
      $n = $num[0];
      if ($n == 1) {
         $t = ' ciento' . $t;
      }elseif ($n == 5){
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
      }elseif ($n != 0){
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
      }
      if ($sub == 1) {
      }elseif (! isset($matsub[$sub])) {
         if ($num == 1) {
            $t = ' mil';
         }elseif ($num > 1){
            $t .= ' mil';
         }
      }elseif ($num == 1) {
         $t .= ' ' . $matsub[$sub] . '&oacute;n';
      }elseif ($num > 1){
         $t .= ' ' . $matsub[$sub] . 'ones';
      }   
      if ($num == '000') $mils ++;
      elseif ($mils != 0) {
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
         $mils = 0;
      }
      $neutro = true;
      $tex = $t . $tex;
   }
   $tex = $neg . substr($tex, 1) . $fin;
   return ucfirst($tex);
}


//Funcion para pasar de numeros a letras

function unidad($numuero){
	switch ($numuero)
	{
		case 9:
		{
			$numu = "NUEVE";
			break;
		}
		case 8:
		{
			$numu = "OCHO";
			break;
		}
		case 7:
		{
			$numu = "SIETE";
			break;
		}		
		case 6:
		{
			$numu = "SEIS";
			break;
		}		
		case 5:
		{
			$numu = "CINCO";
			break;
		}		
		case 4:
		{
			$numu = "CUATRO";
			break;
		}		
		case 3:
		{
			$numu = "TRES";
			break;
		}		
		case 2:
		{
			$numu = "DOS";
			break;
		}		
		case 1:
		{
			$numu = "UN";
			break;
		}		
		case 0:
		{
			$numu = "";
			break;
		}		
	}
	return $numu;	
}

function decena($numdero){
	
		if ($numdero >= 90 && $numdero <= 99)
		{
			$numd = "NOVENTA ";
			if ($numdero > 90)
				$numd = $numd."Y ".(unidad($numdero - 90));
		}
		else if ($numdero >= 80 && $numdero <= 89)
		{
			$numd = "OCHENTA ";
			if ($numdero > 80)
				$numd = $numd."Y ".(unidad($numdero - 80));
		}
		else if ($numdero >= 70 && $numdero <= 79)
		{
			$numd = "SETENTA ";
			if ($numdero > 70)
				$numd = $numd."Y ".(unidad($numdero - 70));
		}
		else if ($numdero >= 60 && $numdero <= 69)
		{
			$numd = "SESENTA ";
			if ($numdero > 60)
				$numd = $numd."Y ".(unidad($numdero - 60));
		}
		else if ($numdero >= 50 && $numdero <= 59)
		{
			$numd = "CINCUENTA ";
			if ($numdero > 50)
				$numd = $numd."Y ".(unidad($numdero - 50));
		}
		else if ($numdero >= 40 && $numdero <= 49)
		{
			$numd = "CUARENTA ";
			if ($numdero > 40)
				$numd = $numd."Y ".(unidad($numdero - 40));
		}
		else if ($numdero >= 30 && $numdero <= 39)
		{
			$numd = "TREINTA ";
			if ($numdero > 30)
				$numd = $numd."Y ".(unidad($numdero - 30));
		}
		else if ($numdero >= 20 && $numdero <= 29)
		{
			if ($numdero == 20)
				$numd = "VEINTE ";
			else
				$numd = "VEINTI".(unidad($numdero - 20));
		}
		else if ($numdero >= 10 && $numdero <= 19)
		{
			switch ($numdero){
			case 10:
			{
				$numd = "DIEZ ";
				break;
			}
			case 11:
			{		 		
				$numd = "ONCE ";
				break;
			}
			case 12:
			{
				$numd = "DOCE ";
				break;
			}
			case 13:
			{
				$numd = "TRECE ";
				break;
			}
			case 14:
			{
				$numd = "CATORCE ";
				break;
			}
			case 15:
			{
				$numd = "QUINCE ";
				break;
			}
			case 16:
			{
				$numd = "DIECISEIS ";
				break;
			}
			case 17:
			{
				$numd = "DIECISIETE ";
				break;
			}
			case 18:
			{
				$numd = "DIECIOCHO ";
				break;
			}
			case 19:
			{
				$numd = "DIECINUEVE ";
				break;
			}
			}	
		}
		else
			$numd = unidad($numdero);
	return $numd;
}

	function centena($numc){
		if ($numc >= 100)
		{
			if ($numc >= 900 && $numc <= 999)
			{
				$numce = "NOVECIENTOS ";
				if ($numc > 900)
					$numce = $numce.(decena($numc - 900));
			}
			else if ($numc >= 800 && $numc <= 899)
			{
				$numce = "OCHOCIENTOS ";
				if ($numc > 800)
					$numce = $numce.(decena($numc - 800));
			}
			else if ($numc >= 700 && $numc <= 799)
			{
				$numce = "SETECIENTOS ";
				if ($numc > 700)
					$numce = $numce.(decena($numc - 700));
			}
			else if ($numc >= 600 && $numc <= 699)
			{
				$numce = "SEISCIENTOS ";
				if ($numc > 600)
					$numce = $numce.(decena($numc - 600));
			}
			else if ($numc >= 500 && $numc <= 599)
			{
				$numce = "QUINIENTOS ";
				if ($numc > 500)
					$numce = $numce.(decena($numc - 500));
			}
			else if ($numc >= 400 && $numc <= 499)
			{
				$numce = "CUATROCIENTOS ";
				if ($numc > 400)
					$numce = $numce.(decena($numc - 400));
			}
			else if ($numc >= 300 && $numc <= 399)
			{
				$numce = "TRESCIENTOS ";
				if ($numc > 300)
					$numce = $numce.(decena($numc - 300));
			}
			else if ($numc >= 200 && $numc <= 299)
			{
				$numce = "DOSCIENTOS ";
				if ($numc > 200)
					$numce = $numce.(decena($numc - 200));
			}
			else if ($numc >= 100 && $numc <= 199)
			{
				if ($numc == 100)
					$numce = "CIEN ";
				else
					$numce = "CIENTO ".(decena($numc - 100));
			}
		}
		else
			$numce = decena($numc);
		
		return $numce;	
}

	function miles($nummero){
		if ($nummero >= 1000 && $nummero < 2000){
			$numm = "MIL ".(centena($nummero%1000));
		}
		if ($nummero >= 2000 && $nummero <10000){
			$numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
		}
		if ($nummero < 1000)
			$numm = centena($nummero);
		
		return $numm;
	}

	function decmiles($numdmero){
		if ($numdmero == 10000)
			$numde = "DIEZ MIL";
		if ($numdmero > 10000 && $numdmero <20000){
			$numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));		
		}
		if ($numdmero >= 20000 && $numdmero <100000){
			$numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));		
		}		
		if ($numdmero < 10000)
			$numde = miles($numdmero);
		
		return $numde;
	}		

	function cienmiles($numcmero){
		if ($numcmero == 100000)
			$num_letracm = "CIEN MIL";
		if ($numcmero >= 100000 && $numcmero <1000000){
			$num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));		
		}
		if ($numcmero < 100000)
			$num_letracm = decmiles($numcmero);
		return $num_letracm;
	}	
	
	function millon($nummiero){
		if ($nummiero >= 1000000 && $nummiero <2000000){
			$num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
		}
		if ($nummiero >= 2000000 && $nummiero <10000000){
			$num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
		}
		if ($nummiero < 1000000)
			$num_letramm = cienmiles($nummiero);
		
		return $num_letramm;
	}	

	function decmillon($numerodm){
		if ($numerodm == 10000000)
			$num_letradmm = "DIEZ MILLONES";
		if ($numerodm > 10000000 && $numerodm <20000000){
			$num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));		
		}
		if ($numerodm >= 20000000 && $numerodm <100000000){
			$num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));		
		}
		if ($numerodm < 10000000)
			$num_letradmm = millon($numerodm);
		
		return $num_letradmm;
	}

	function cienmillon($numcmeros){
		if ($numcmeros == 100000000)
			$num_letracms = "CIEN MILLONES";
		if ($numcmeros >= 100000000 && $numcmeros <1000000000){
			$num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));		
		}
		if ($numcmeros < 100000000)
			$num_letracms = decmillon($numcmeros);
		return $num_letracms;
	}	

	function milmillon($nummierod){
		if ($nummierod >= 1000000000 && $nummierod <2000000000){
			$num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
		}
		if ($nummierod >= 2000000000 && $nummierod <10000000000){
			$num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
		}
		if ($nummierod < 1000000000)
			$num_letrammd = cienmillon($nummierod);
		
		return $num_letrammd;
	}	
			
		
function convertir($numero){
		   $numf = milmillon($numero);
		return $numf;
}*/

/*
function FncArbol(){
	
//	echo "<select></selected>";
}*/

	

function FncFechaHoy()
    {
     $mes=date(n);
     $dia=date(l);
     switch($mes)
        {         
         case 1:
            $mes='Enero';
           break;     
         case 2:
            $mes='Febrero';
            break;     
         case 3:
            $mes='Marzo';
           break;
         case 4:
            $mes='Abril';
            break;
         case 5:
            $mes='Mayo';
            break;
         case 6:
            $mes='Junio';
            break;
         case 7:
           $mes='Julio';
            break;
         case 8:
            $mes='Agosto';
            break;
         case 9:
            $mes='Septiembre';
            break;
         case 10:
            $mes='Octubre';
            break;
         case 11:
            $mes='Noviembre';
          break;
         case 12:
            $mes='Diciembre';
            break;
        }
     switch($dia)
        {         
         case 'Monday':
               $dia='Lunes';
               break;
         case 'Tuesday':
               $dia='Martes';
               break;
         case 'Wednesday':
               $dia='Miercoles';
               break;
         case 'Thursday':
               $dia='Jueves';
               break;
         case 'Friday':
               $dia='Viernes';
               break;
         case 'Saturday':
               $dia='Sabado';
               break;
         case 'Sunday':
               $dia='Domingo';
               break;
        }
     echo "".$dia." ";
     echo "".date(j)." de ".$mes;
    // echo "".date(H).":".date(i)."";   
   
}  
	
	
	/*
	
function FncConvertirFechaEnLetras($dia)
    {
     $mes=date(n);
     $dia=date(l);
     switch($mes)
        {         
         case 1:
            $mes='Enero';
           break;     
         case 2:
            $mes='Febrero';
            break;     
         case 3:
            $mes='Marzo';
           break;
         case 4:
            $mes='Abril';
            break;
         case 5:
            $mes='Mayo';
            break;
         case 6:
            $mes='Junio';
            break;
         case 7:
           $mes='Julio';
            break;
         case 8:
            $mes='Agosto';
            break;
         case 9:
            $mes='Septiembre';
            break;
         case 10:
            $mes='Octubre';
            break;
         case 11:
            $mes='Noviembre';
          break;
         case 12:
            $mes='Diciembre';
            break;
        }
     switch($dia)
        {         
         case 'Monday':
               $dia='Lunes';
               break;
         case 'Tuesday':
               $dia='Martes';
               break;
         case 'Wednesday':
               $dia='Miercoles';
               break;
         case 'Thursday':
               $dia='Jueves';
               break;
         case 'Friday':
               $dia='Viernes';
               break;
         case 'Saturday':
               $dia='Sabado';
               break;
         case 'Sunday':
               $dia='Domingo';
               break;
        }
     echo "".$dia." ";
     echo "".date(j)." de ".$mes;
    // echo "".date(H).":".date(i)."";   
   
}  */
	
	
function FncRepararClase($class, $object){
  return unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
}


function contar($dato){

	echo "<h1>:";
	echo count($dato);
	echo ":</h1>";
	
}


function deb($dato,$alin="i"){
//function FncDebug($dato){

	switch($alin){
		case "i":
			$ali = "left";
		break;
		
		case "d":
			$ali = "right";
		break;
		
		case "c":
			$ali = "center";
		break;
		
		default:
			$ali = "left";
		break;
	}
	echo "<div align='".$ali."'><pre>";
	var_dump($dato);
	echo "</pre></div><br>";
}


function FncCambiaFechaANormal($oFecha,$oVacio=false){
	
		$Afecha = explode(" ",$oFecha);
		
		if(count($AFecha)>1){
			$fecha = $AFecha[0];
			$hora = $AFecha[1];	
		}else{
			$fecha = $oFecha;
			$hora = "";
		}


		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
		//preg_match("/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha);
		
		if(empty($hora)){
		    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
		}else{
		    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]." ".$hora;		
		}
		
		
		/*
		   1. ereg('\.([^\.]*$)', $this->file_src_name, $extension);
		   
		   1. preg_match('/\.([^\.]*$)/', $this->file_src_name, $extension);
		   
		*/
	   // $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]." ".$hora;
	

		
	if(trim($lafecha)=="//"){
		
		if($oVacio){
			$lafecha="";		
		}else{
			if(empty($hora)){
				$lafecha="00/00/0000";			
			}else{
				$lafecha="00/00/0000 00:00:00";
			}					
		}
	}
	
    return $lafecha;
} 



function FncCambiaFechaAImpresion($oFecha){

		
		$AFecha = explode(" ",$oFecha);
		
		if(count($AFecha)>1){
			$fecha = $AFecha[0];
			$hora = $AFecha[1];	
		}else{
			$fecha = $oFecha;
			$hora = "";
		}
	
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);	
		//preg_match("/([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})/",$fecha, $mifecha);	
		
		if(empty($hora)){			
			$lafecha=$mifecha[1]." ".FncConvertirMes($mifecha[2])." ".$mifecha[3];			
		}else{
			$lafecha=$mifecha[1]." ".FncConvertirMes($mifecha[2])." ".$mifecha[3]." ".$hora;
		}
		
		
	if(trim($lafecha)==""){
		$lafecha="";
	}
	
	
	return $lafecha;
} 


function FncCambiaFechaAMysql($oFecha,$oVacio=false){

		
		$AFecha = explode(" ",$oFecha);
		
		if(count($AFecha)>1){
			$fecha = $AFecha[0];
			$hora = $AFecha[1];	
		}else{
			$fecha = $oFecha;
			$hora = "";
		}
	
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);		
		//preg_match("/([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})/", $fecha, $mifecha);
	//
	
		/*
		   1. ereg('\.([^\.]*$)', $this->file_src_name, $extension);
		   
		   1. preg_match('/\.([^\.]*$)/', $this->file_src_name, $extension);
		   
		*/
			
		if(empty($hora)){
			$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
		}else{
			$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]." ".$hora;
		}

		//$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]." ".$hora;
		
	//if($lafecha=="-- "){
//		$lafecha="0000-00-00";
//	}

//	echo $oFecha." A ".$fecha." B ".$lafecha." C<br>";


	if(trim($lafecha)=="--"){
		
		if($oVacio){
			$lafecha="";		
		}else{
			if(empty($hora)){
				$lafecha="0000-00-00";			
			}else{
				$lafecha="0000-00-00 00:00:00";
			}					
		}
	}
	
	

	return $lafecha;
} 
		
/*function cambiar_fechat($fecha){
	
		$fec = explode(" ",$fecha);		
		$aux = explode("-",$fec[0]);
		$fecha = $aux[2]."/".$aux[1]."/".$aux[0];	
		$nueva_fecha = $fecha." ".$fec[1];
	
    return $nueva_fecha;
} */

function FncConvertirMes($oMes,$oAbreviado=false){

	switch ($oMes){
	case 1:
				$mes='Enero';
				if($oAbreviado){
				$mes='Ene';
				}
			   break;     
			 case 2:
				$mes='Febrero';
				if($oAbreviado){
				$mes='Feb';
				}
				break;     
			 case 3:
				$mes='Marzo';
				if($oAbreviado){
				$mes='Mar';
				}
			   break;
			 case 4:
				$mes='Abril';
				if($oAbreviado){
				$mes='Abr';
				}
				break;
			 case 5:
				$mes='Mayo';
				if($oAbreviado){
				$mes='May';
				}
				break;
			 case 6:
				$mes='Junio';
				if($oAbreviado){
				$mes='Jun';
				}
				break;
			 case 7:
			   $mes='Julio';
			   if($oAbreviado){
				$mes='Jul';
				}
				break;
			 case 8:
				$mes='Agosto';
				if($oAbreviado){
				$mes='Ago';
				}
				break;
			 case 9:
				$mes='Septiembre';
				if($oAbreviado){
				$mes='Sep';
				}
				break;
			 case 10:
				$mes='Octubre';
				if($oAbreviado){
				$mes='Oct';
				}
				break;
			 case 11:
				$mes='Noviembre';
				if($oAbreviado){
				$mes='Nov';
				}
			  break;
			 case 12:
				$mes='Diciembre';
				if($oAbreviado){
				$mes='Dic';
				}
			break;
			
			default:
				$mes= '';
			break;
	}

	return $mes;
}

function FncMostrarImagen($oRuta=NULL,$oImagen,$ancho_fijo=NULL,$altura_fijo=NULL,$oBorde=0,$oExRuta=NULL){

	if(!empty($oImagen)){
		if(file_exists($oExRuta.$oRuta.$oImagen)){
			
			if(!empty($ancho_fijo) & !empty($altura_fijo)){
				
				$Imagen['error'] = 0;			
				$Imagen['path']=$oExRuta.$oRuta.$oImagen;
				$Imagen['ancho']=$ancho_fijo;	
				$Imagen['altura']=$altura_fijo;	
				
				$resolucion = getimagesize($Imagen['path']);	
				$res = explode(' ',$resolucion[3]);	
				$Imagen['ancho']=eregi_replace("[width,=,\"]",'',$res[0]);
				$Imagen['altura']=eregi_replace("[height,=,\"]",'',$res[1]);
				
				$dif=$Imagen['ancho']-$Imagen['altura'];	
				
				$dif_altura=$altura_fijo-$Imagen['altura'];
				$dif_ancho=$ancho_fijo-$Imagen['ancho'];
				
				if($dif_altura<0){
					if($dif_ancho<0){
						$resize=1;
					}else{
						$resize=2;
					}
				}else{
					if($dif_ancho<0){
						$resize=3;
					}else{
						$resize=4;
					}	
				}
				
				switch($resize){
					case 1:
					//echo 'ancho y altura son grandes';		
						$Imagen['altura']=($altura_fijo*$Imagen['altura'])/$Imagen['ancho'];
						$Imagen['ancho']=$ancho_fijo;
					
					break;
					case 2:
					//echo 'altura es grande';		
						$Imagen['ancho']=($altura_fijo*$Imagen['ancho'])/$Imagen['altura'];
						$Imagen['altura']=$altura_fijo;
					break;
					case 3:
					//echo 'ancho es grande';	
						$Imagen['altura']=($ancho_fijo*$Imagen['altura'])/$Imagen['ancho'];
						$Imagen['ancho']=$ancho_fijo;				
					break;
					
					case 4:
					//echo 'todo ok';					
					break;	
				}
			}
			///}else{
		
		//	}
			
	?>

<img src="<?php echo $Imagen['path'];?>" title="<?php echo $oImagen;?>"  <?php if(!empty($Imagen['ancho'])){ ?> width="<?php echo $Imagen['ancho'];?>"  <?php } ?> <?php if(!empty($Imagen['altura'])){ ?> height="<?php echo $Imagen['altura'];?>"  <?php } ?> alt="[<?php echo $oImagen;?>]" border="<?php echo $oBorde;?>" />

<?php					

		}else{
?>
<img src="<?php echo $oExRuta; ?>imagenes/noencontrado.jpg" width="<?php echo $ancho_fijo;?>" height="<?php echo $altura_fijo;?>" title="No se encontro la imagen" alt="[NoEncontrado]" border="<?php echo $oBorde;?>"  />
<?php
		}
	}else{
?>
<img src="<?php echo $oExRuta; ?>imagenes/default.jpg"  width="<?php echo $ancho_fijo;?>" height="<?php echo $altura_fijo;?>" title="Default" alt="[Default]"  border="<?php echo $oBorde;?>" />
<?php
	}

}
?>