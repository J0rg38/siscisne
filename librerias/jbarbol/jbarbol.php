<?php
function FncArbolAux($oArrayAux,$oAtrId,$oAtrSub){

	$cadena='';
		
	foreach($oArrayAux as $DatArrayAux){
		
		$cadena.=",".$DatArrayAux->$oAtrId;

		if(is_array($DatArrayAux->$oAtrSub)){
			$cadena.=FncArbolAux($DatArrayAux->$oAtrSub,$oAtrId,$oAtrSub);
		}
		
	}	
	
	return $cadena;
				
}

function FncArbol($oArray,$oNivel=0,$Aux=false,$oSeleccionado=NULL,$oAtrNombre,$oAtrId,$oAtrSub,$oCarga=true,$oMostrarNivel=false,$oArtPadre=NULL){

		$cadena='';
		
		if($Aux){
			$oNivel++;
		}
		
		foreach($oArray as $Dat){
			
			$lineas ='';
			$estilo = '';
			$seleccionado = '';
			
			for($i=0;$i<$oNivel;$i++){
				$lineas .= '&nbsp;&nbsp;&nbsp;';
			}			
						
		if($oNivel==0){
			$estilo = 'EstArbolNivelPrincipal';
		}else{
			$estilo = 'EstArbolNivelSecundario';
		}			
		
		//echo $oSeleccionado."-<br><br>";		
		//if(!is_null($oSeleccionado) & $Dat->$oAtrId==$oSeleccionado){
		$hijos='';
		$padres='';
		$value='';
			//if(!empty($oSeleccionado) & $Dat->$oAtrId==$oSeleccionado){
//				$seleccionado = 'selected="selected"';
//			}

			if($oCarga and empty($oArtPadre)){
				
				if(is_array($Dat->$oAtrSub)){
					$hijos .= FncArbolAux($Dat->$oAtrSub,$oAtrId,$oAtrSub);
				}
				
				if(!empty($oSeleccionado) & $Dat->$oAtrId.$hijos==$oSeleccionado){
					$seleccionado = 'selected="selected"';
				}
				
				$value = $Dat->$oAtrId.$hijos;
				
			}elseif(!empty($oArtPadre)){
								
				$padres = $Dat->$oArtPadre;
								
				if(!empty($oSeleccionado) & $Dat->$oAtrId.$padres==$oSeleccionado){
					$seleccionado = 'selected="selected"';
				}
				
				$value = $Dat->$oAtrId.$padres;
				
			}else{
			
				if(!empty($oSeleccionado) & $Dat->$oAtrId==$oSeleccionado){
					$seleccionado = 'selected="selected"';
				}
				
				$value = $Dat->$oAtrId;
				
			}
			
			if($oMostrarNivel){
				$nivel = 'N'.($oNivel+1).' - ';
			}
				
				
			
		$cadena .= '<option '.$seleccionado.' class="'.$estilo.'" value = "'.$value.'">'.$nivel.$lineas.' '.$Dat->$oAtrNombre.'</option>';

				
				if(is_array($Dat->$oAtrSub)){
					
					$cadena.=FncArbol($Dat->$oAtrSub,$oNivel,true,$oSeleccionado,$oAtrNombre,$oAtrId,$oAtrSub,$oCarga,$oMostrarNivel,$oArtPadre);
					
				}
			}
			
			return $cadena;
			
		}
?>