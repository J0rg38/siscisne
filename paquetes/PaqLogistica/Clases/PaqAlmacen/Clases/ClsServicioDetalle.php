<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsServicioDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsServicioDetalle {

    public $SdeId;
	public $SerId;
	public $ProId;
    public $SdeCantidad;
	public $SdeImporte;	
	public $SdeEstado;	
	public $SdeTiempoCreacion;
	public $SdeTiempoModificacion;
    public $SdeEliminado;

	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $ProNombre;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarServicioDetalleId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(SdeId,5),unsigned)) AS "MAXIMO"
			FROM tblsdeserviciodetalle sde';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->SdeId = "SDE-10000";
			}else{
				$fila['MAXIMO']++;
				$this->SdeId = "SDE-".$fila['MAXIMO'];					
			}
				
		}


		public function MtdObtenerServicioDetalle(){

        $sql = 'SELECT
			sde.SdeId,			
			sde.SerId,
			sde.ProId,
			sde.SdeCantidad,
			sde.SdeImporte,
			sde.UmeId,
			
			sde.SdeEstado,
			DATE_FORMAT(sde.SdeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSdeTiempoCreacion",
	        DATE_FORMAT(sde.SdeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSdeTiempoModificacion",
			
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			ume.UmeNombre
	       
			FROM tblsdeserviciodetalle sde			
				LEFT JOIN tblproproducto pro
				ON sde.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON sde.UmeId = ume.UmeId		
										
        WHERE sde.SdeId = "'.$this->SdeId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
		
			 $this->SdeId = $fila['SdeId'];
                    $this->SerId = $fila['SerId'];
					$this->ProId = $fila['ProId'];
					$this->SdeCantidad = $fila['SdeCantidad'];
			        $this->SdeImporte = $fila['SdeImporte'];  				
					$this->UmeId = $fila['UmeId'];  					
					$this->SdeEstado = $fila['SdeEstado'];  
			
					$this->SdeTiempoCreacion = $fila['NSdeTiempoCreacion'];
					$this->SdeTiempoModificacion = $fila['NSdeTiempoModificacion'];
					
                    $this->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$this->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
					$this->ProNombre = (($fila['ProNombre']));
					$this->RtiId = (($fila['RtiId']));
					$this->UmeNombre = (($fila['UmeNombre']));
	
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
    public function MtdObtenerServicioDetalles($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'SdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oServicio=NULL,$oEstado=NULL,$oProducto=NULL) {

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
		
		if(!empty($oServicio)){
			$amovimiento = ' AND sde.SerId = "'.$oServicio.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND sde.SdeEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (sde.ProId = "'.$oProducto.'") ';
		}

	
			
		 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			sde.SdeId,			
			sde.SerId,
			sde.ProId,
			sde.SdeCantidad,
			sde.SdeImporte,
			sde.UmeId,
			
			sde.SdeEstado,
			DATE_FORMAT(sde.SdeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSdeTiempoCreacion",
	        DATE_FORMAT(sde.SdeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSdeTiempoModificacion",
			
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			ume.UmeNombre
	       
			FROM tblsdeserviciodetalle sde
			
				LEFT JOIN tblproproducto pro
				ON sde.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON sde.UmeId = ume.UmeId		
								
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$fecha.$cpendiente.$moneda.$cliente.$coreferencia.$cdespacho.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsServicioDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ServicioDetalle = new $InsServicioDetalle();
					
                    $ServicioDetalle->SdeId = $fila['SdeId'];
                    $ServicioDetalle->SerId = $fila['SerId'];
					$ServicioDetalle->ProId = $fila['ProId'];
					$ServicioDetalle->SdeCantidad = $fila['SdeCantidad'];					
			        $ServicioDetalle->SdeImporte = $fila['SdeImporte']; 	
					 $ServicioDetalle->UmeId = $fila['UmeId']; 	
					 				 
					$ServicioDetalle->SdeEstado = $fila['SdeEstado'];  	
					$ServicioDetalle->SdeTiempoCreacion = $fila['NSdeTiempoCreacion'];  
					$ServicioDetalle->SdeTiempoModificacion = $fila['NSdeTiempoModificacion'];  					
					
					$ServicioDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];  	
					$ServicioDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];  	
					$ServicioDetalle->ProNombre = $fila['ProNombre'];  	
					$ServicioDetalle->RtiId = $fila['RtiId'];
					$ServicioDetalle->UmeNombre = $fila['UmeNombre'];

					
                    $ServicioDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ServicioDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarServicioDetalle($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (SdeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (SdeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblsdeserviciodetalle 
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
	
	
	public function MtdRegistrarServicioDetalle() {
	
			$this->MtdGenerarServicioDetalleId();
			
			$sql = 'INSERT INTO tblsdeserviciodetalle (
			SdeId,
			SerId,	
			ProId,
			SdeCantidad,
			SdeImporte,
			UmeId,			
			
			SdeEstado,
			SdeTiempoCreacion,
			SdeTiempoModificacion
			) 
			VALUES (
			"'.($this->SdeId).'", 
			"'.($this->SerId).'", 
			"'.($this->ProId).'", 
			'.($this->SdeCantidad).',
			'.($this->SdeImporte).', 
			"'.($this->UmeId).'", 
			
			'.($this->SdeEstado).',
			"'.($this->SdeTiempoCreacion).'",
			"'.($this->SdeTiempoModificacion).'");';
		
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
	
	public function MtdEditarServicioDetalle() {

		$sql = 'UPDATE tblsdeserviciodetalle SET 	
		UmeId = "'.($this->UmeId).'",
		SdeCantidad = '.($this->SdeCantidad).',
		SdeImporte = '.($this->SdeImporte).',		
	
		SdeEstado = '.($this->SdeEstado).',
		SdeTiempoModificacion = "'.($this->SdeTiempoModificacion).'"			
		WHERE SdeId = "'.($this->SdeId).'";';
				
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
	
	
	
		public function MtdEditarServicioDetalleDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblsdeserviciodetalle SET 
			'.$oCampo.' = "'.($oDato).'"
			
			WHERE SdeId = "'.($oId).'";';

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