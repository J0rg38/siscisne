<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaAccionMantenimiento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaAccionMantenimiento {

    public $FaaId;
	public $FccId;
	public $PmtId;
	
	public $FiaId;
	
	public $ProId;
	public $UmeId;	
	public $FaaCantidad;
	
	public $FaaAccion;	
	public $FaaNivel;
	public $FaaVerificar1;
	public $FaaVerificar2;
	public $FaaEstado;	
	public $FaaTiempoCreacion;
	public $FaaTiempoModificacion;
    public $FaaEliminado;
	
	public $PmtNombre;
	

	public $FapId;
//	public $ProId;
//	public $UmeId;
	public $FapCantidad;
	public $FapCantidadReal;
	public $FapVerificar1;
	public $FapVerificar2;
	public $FapEstado;
		
	public $ProNombre;
	
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $ProCosto;
	public $ProPrecio;
	
	public $RtiId;
	public $UmeIdOrigen;
//	public $PmtNombre;


    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarFichaAccionMantenimientoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FaaId,5),unsigned)) AS "MAXIMO"
			FROM tblfaafichaaccionmantenimiento';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FaaId = "FAA-10000";
			}else{
				$fila['MAXIMO']++;
				$this->FaaId = "FAA-".$fila['MAXIMO'];					
			}
				
		}
		


    public function MtdObtenerFichaAccionMantenimiento(){

        $sql = 'SELECT
			SQL_CALC_FOUND_ROWS 
			faa.FaaId,			
			faa.FccId,
			faa.PmtId,
			
			faa.FiaId,
			
			faa.ProId,
			faa.UmeId,
			faa.FaaCantidad,
			
			faa.FaaAccion,
			faa.FaaNivel,
			faa.FaaVerificar1,
			faa.FaaVerificar2,
			faa.FaaEstado,
			DATE_FORMAT(faa.FaaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFaaTiempoCreacion",
	        DATE_FORMAT(faa.FaaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFaaTiempoModificacion",
			pmt.PmtNombre,
		

			pro.ProNombre,

			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProCosto,
			pro.ProPrecio,

			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
			
			
			fia.ProId AS ProIdFichaIngresoMantenimiento		

			FROM tblfaafichaaccionmantenimiento faa
			
				LEFT JOIN tblpmtplanmantenimientotarea pmt
				ON faa.PmtId = pmt.PmtId		
				
						LEFT JOIN tblproproducto pro
						ON faa.ProId = pro.ProId
						
							LEFT JOIN tblumeunidadmedida ume
							ON pro.UmeId = ume.UmeId
							
								LEFT JOIN tblfiafichaingresomantenimiento fia
								ON faa.FiaId = fia.FiaId
								
        WHERE faa.FaaId = "'.$this->FaaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->FaaId = $fila['FaaId'];
                    $this->FccId = $fila['FccId'];					
					$this->PmtId = $fila['PmtId'];	

					$this->FiaId = $fila['FiaId'];
					
					$this->ProId = $fila['ProId'];
					$this->UmeId = $fila['UmeId'];
					$this->FaaCantidad = $fila['FaaCantidad'];

					$this->FaaAccion = $fila['FaaAccion'];
					$this->FaaNivel = $fila['FaaNivel'];
					$this->FaaVerificar1 = $fila['FaaVerificar1'];
					$this->FaaVerificar2 = $fila['FaaVerificar2'];
					$this->FaaEstado = $fila['FaaEstado'];
					$this->FaaTiempoCreacion = $fila['NFaaTiempoCreacion'];  
					$this->FaaTiempoModificacion = $fila['NFaaTiempoModificacion']; 

					$this->PmtNombre = $fila['PmtNombre'];

					$this->FapId = $fila['FapId'];
					$this->ProId = $fila['ProId'];
					$this->UmeId = $fila['UmeId'];

					$this->FapCantidad = $fila['FapCantidad'];
					$this->FapCantidadReal = $fila['FapCantidadReal'];
					$this->FapVerificar1 = $fila['FapVerificar1'];
					$this->FapVerificar2 = $fila['FapVerificar2'];
					$this->FapEstado = $fila['FapEstado'];

					$this->ProNombre = $fila['ProNombre'];

					$this->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$this->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
					$this->ProCosto = $fila['ProCosto'];
					$this->ProPrecio = $fila['ProPrecio'];
					
					$this->RtiId = $fila['RtiId'];
					$this->UmeIdOrigen = $fila['UmeIdOrigen'];
					$this->UmeNombre = $fila['UmeNombre'];
					
					$this->ProIdFichaIngresoMantenimiento = $fila['ProIdFichaIngresoMantenimiento'];
					
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
		return $Respuesta;

    }
	
	
    public function MtdObtenerFichaAccionMantenimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FaaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL,$oNivel=NULL,$oSevero=false,$oAccion=NULL,$oPlanMantenimientoSeccion=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){

			$oFiltro = str_replace(" ","%",$oFiltro);			
			$elementos = explode(",",$oCampo);

			$i=1;
			$filtrar .= '  AND (';
			foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

		}
		
		
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFichaAccion)){
			$faccion = ' AND faa.FccId = "'.$oFichaAccion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND faa.FaaEstado = '.$oEstado.'';
		}
		
		if(!empty($oNivel)){
			$nivel = ' AND faa.FaaNivel = '.$oNivel.'';
		}		
		
		if(($oSevero)){
			$severo = ' AND (UPPER(faa.FaaAccion) <> "X" AND faa.FaaNivel = 2)';
		}
		
		if(!empty($oAccion)){
			$accion = ' AND faa.FaaAccion = "'.$oAccion.'"';
		}		
		
		if(!empty($oPlanMantenimientoSeccion)){
			$pseccion = ' AND pmt.PmsId = "'.$oPlanMantenimientoSeccion.'"';
		}	
		
		
		

//echo "<br><br>";
		 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			faa.FaaId,			
			faa.FccId,
			faa.PmtId,
			
			faa.FiaId,
			
			faa.ProId,
			faa.UmeId,
			faa.FaaCantidad,
			
			faa.FaaAccion,
			faa.FaaNivel,
			faa.FaaVerificar1,
			faa.FaaVerificar2,
			faa.FaaEstado,
			DATE_FORMAT(faa.FaaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFaaTiempoCreacion",
	        DATE_FORMAT(faa.FaaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFaaTiempoModificacion",
			pmt.PmtNombre,
			
			pro.ProNombre,

			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProCosto,
			pro.ProPrecio,

			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
			
			fia.ProId AS ProIdFichaIngresoMantenimiento,
			
			pmt.PmsId

			FROM tblfaafichaaccionmantenimiento faa
			
				LEFT JOIN tblpmtplanmantenimientotarea pmt
				ON faa.PmtId = pmt.PmtId		
				
						LEFT JOIN tblproproducto pro
						ON faa.ProId = pro.ProId
							LEFT JOIN tblumeunidadmedida ume
							ON pro.UmeId = ume.UmeId

								LEFT JOIN tblfiafichaingresomantenimiento fia
								ON faa.FiaId = fia.FiaId
			WHERE  1 = 1 '.$faccion.$estado.$nivel.$severo.$pseccion.$accion.$filtrar.$orden.$paginacion;	
		
		
		//echo $sql;
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaAccionMantenimiento = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaAccionMantenimiento = new $InsFichaAccionMantenimiento();
                    $FichaAccionMantenimiento->FaaId = $fila['FaaId'];
                    $FichaAccionMantenimiento->FccId = $fila['FccId'];					
					$FichaAccionMantenimiento->PmtId = $fila['PmtId'];	

					$FichaAccionMantenimiento->FiaId = $fila['FiaId'];
					
					$FichaAccionMantenimiento->ProId = $fila['ProId'];
					$FichaAccionMantenimiento->UmeId = $fila['UmeId'];
					$FichaAccionMantenimiento->FaaCantidad = $fila['FaaCantidad'];

					$FichaAccionMantenimiento->FaaAccion = $fila['FaaAccion'];
					$FichaAccionMantenimiento->FaaNivel = $fila['FaaNivel'];
					$FichaAccionMantenimiento->FaaVerificar1 = $fila['FaaVerificar1'];
					$FichaAccionMantenimiento->FaaVerificar2 = $fila['FaaVerificar2'];
					$FichaAccionMantenimiento->FaaEstado = $fila['FaaEstado'];
					$FichaAccionMantenimiento->FaaTiempoCreacion = $fila['NFaaTiempoCreacion'];  
					$FichaAccionMantenimiento->FaaTiempoModificacion = $fila['NFaaTiempoModificacion']; 

					$FichaAccionMantenimiento->PmtNombre = $fila['PmtNombre'];

					$FichaAccionMantenimiento->FapId = $fila['FapId'];
					$FichaAccionMantenimiento->ProId = $fila['ProId'];
					$FichaAccionMantenimiento->UmeId = $fila['UmeId'];

					$FichaAccionMantenimiento->FapCantidad = $fila['FapCantidad'];
					$FichaAccionMantenimiento->FapCantidadReal = $fila['FapCantidadReal'];
					$FichaAccionMantenimiento->FapVerificar1 = $fila['FapVerificar1'];
					$FichaAccionMantenimiento->FapVerificar2 = $fila['FapVerificar2'];
					$FichaAccionMantenimiento->FapEstado = $fila['FapEstado'];

					$FichaAccionMantenimiento->ProNombre = $fila['ProNombre'];

					$FichaAccionMantenimiento->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$FichaAccionMantenimiento->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
					$FichaAccionMantenimiento->ProCosto = $fila['ProCosto'];
					$FichaAccionMantenimiento->ProPrecio = $fila['ProPrecio'];
					
					$FichaAccionMantenimiento->RtiId = $fila['RtiId'];
					$FichaAccionMantenimiento->UmeIdOrigen = $fila['UmeIdOrigen'];
					$FichaAccionMantenimiento->UmeNombre = $fila['UmeNombre'];
					
					$FichaAccionMantenimiento->ProIdFichaIngresoMantenimiento = $fila['ProIdFichaIngresoMantenimiento'];
					
					$FichaAccionMantenimiento->PmsId = $fila['PmsId'];
					
					//deb($FichaAccionMantenimiento->FapVerificar2);
                    $FichaAccionMantenimiento->InsMysql = NULL;

					$Respuesta['Datos'][]= $FichaAccionMantenimiento;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaAccionMantenimiento($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FaaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FaaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfaafichaaccionmantenimiento 
				WHERE '.$eliminar;
							
				$error = false;
	
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
				if(!$resultado) {						
					$error = true;
				} 	
				
	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarFichaAccionMantenimiento() {
	

		$this->MtdGenerarFichaAccionMantenimientoId();
		
		$sql = 'INSERT INTO tblfaafichaaccionmantenimiento (
		FaaId,
		FccId,	
		PmtId,
		FiaId,
		
		ProId,
		UmeId,
		FaaCantidad,
		
		FaaAccion,
		FaaNivel,
		FaaVerificar1,
		FaaVerificar2,
		FaaEstado,
		FaaTiempoCreacion,
		FaaTiempoModificacion) 
		VALUES (
		"'.($this->FaaId).'", 
		"'.($this->FccId).'", 
		"'.($this->PmtId).'", 

		'.(empty($this->FiaId)?'NULL,':'"'.$this->FiaId.'",').'
		
		'.(empty($this->ProId)?'NULL,':'"'.$this->ProId.'",').'
		'.(empty($this->UmeId)?'NULL,':'"'.$this->UmeId.'",').'
		'.(empty($this->FaaCantidad)?'NULL,':'"'.$this->FaaCantidad.'",').'
	
		"'.($this->FaaAccion).'",
		'.($this->FaaNivel).',
		'.($this->FaaVerificar1).',
		'.($this->FaaVerificar2).',
		'.($this->FaaEstado).',
		"'.($this->FaaTiempoCreacion).'",
		"'.($this->FaaTiempoModificacion).'");';
		
//'.(empty($this->FiaId)?'FiaId = NULL, ':'FiaId = "'.$this->FiaId.'",').'	
//'.(empty($this->FiaId)?'NULL,':'"'.$this->FiaId.'",').'

		//	
		
		
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {						
			$error = true;
		} 	
		
		

		if($error) {						
			return false;
		} else {				
			return true;
		}			
			
	}
	
	public function MtdEditarFichaAccionMantenimiento() {
	// PmtId = "'.($this->PmtId).'",
		$sql = 'UPDATE tblfaafichaaccionmantenimiento SET 	
			
		'.(empty($this->ProId)?'ProId = NULL, ':'ProId = "'.$this->ProId.'",').'
		'.(empty($this->UmeId)?'UmeId = NULL, ':'UmeId = "'.$this->UmeId.'",').'
		'.(empty($this->FaaCantidad)?'FaaCantidad = NULL, ':'FaaCantidad = "'.$this->FaaCantidad.'",').'
		
		 FaaAccion = "'.($this->FaaAccion).'",
		 FaaNivel = '.($this->FaaNivel).',
		 FaaVerificar1 = '.($this->FaaVerificar1).',
		 FaaVerificar2 = '.($this->FaaVerificar2).'
		 WHERE FaaId = "'.($this->FaaId).'";';
				
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {						
			$error = true;
		} 		
		
		if($error) {						
			return false;
		} else {				
			return true;
		}						
				
	}
	
	
	public function MtdEditarFichaAccionMantenimientoAccion() {

		$sql = 'UPDATE tblfaafichaaccionmantenimiento SET 	
		 FaaAccion = "'.($this->FaaAccion).'"
		 WHERE FaaId = "'.($this->FaaId).'";';

		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {						
			$error = true;
		} 		
		
		if($error) {						
			return false;
		} else {				
			return true;
		}						
				
	}	
	


	public function MtdEditarFichaAccionMantenimientoVerificar1() {

		$sql = 'UPDATE tblfaafichaaccionmantenimiento SET 	
		 FaaVerificar1 = "'.($this->FaaVerificar1).'"
		 WHERE FaaId = "'.($this->FaaId).'";';

		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {						
			$error = true;
		} 		
		
		if($error) {						
			return false;
		} else {				
			return true;
		}						
				
	}		
	
	
	public function MtdEditarFichaAccionMantenimientoVerificar2() {

		$sql = 'UPDATE tblfaafichaaccionmantenimiento SET 	
		 FaaVerificar2 = "'.($this->FaaVerificar2).'"
		 WHERE FaaId = "'.($this->FaaId).'";';

		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {						
			$error = true;
		} 		
		
		if($error) {						
			return false;
		} else {				
			return true;
		}						
				
	}		
	
}
?>