<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTrasladoAlmacenDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTrasladoAlmacenDetalle {

    public $TadId;
	public $TalId;
	public $ProId;
	public $UmeId;
	public $TadCantidad;
	public $TadEstado;
	public $TadTiempoCreacion;
	public $TadTiempoModificacion;
    public $TadEliminado;
	
	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	
	public $UmeNombre;
	public $UmeIdOrigen;
	
    public $InsMysql;

    public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}
	
	public function __destruct(){

	}

	private function MtdGenerarTrasladoAlmacenDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(TadId,5),unsigned)) AS "MAXIMO"
			FROM tbltadtrasladoalmacendetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TadId = "TAD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->TadId = "TAD-".$fila['MAXIMO'];					
			}
				
	}
	
	
	  public function MtdObtenerTrasladoAlmacenDetalle(){

        $sql = 'SELECT 
       		tad.TadId,			
			tad.TalId,	
			
			tad.TadEstado,
			DATE_FORMAT(tad.TadTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTadTiempoCreacion",
	        DATE_FORMAT(tad.TadTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTadTiempoModificacion"
						
			FROM tbltadtrasladoalmacendetalle tad
			
        WHERE tad.TadId = "'.$this->TadId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$InsTrasladoAlmacenDetalle = new ClsTrasladoAlmacenDetalle();
			
				
			$this->TadId = $fila['TadId'];			
			$this->TalId = $fila['TalId'];
			
			$this->TadEstado = $fila['TadEstado'];
			$this->TadTiempoCreacion = $fila['NTadTiempoCreacion'];
			$this->TadTiempoModificacion = $fila['NTadTiempoModificacion'];
				
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }


    public function MtdObtenerTrasladoAlmacenDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TadId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoAlmacen=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

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
		
		if(!empty($oTrasladoAlmacen)){
			$amovimiento = ' AND tad.TalId = "'.$oTrasladoAlmacen.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND tad.TadEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (tad.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oFechaInicio)){
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(tal.TalFecha)>="'.$oFechaInicio.'" AND DATE(tal.TalFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(tal.TalFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(tal.TalFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			tad.TadId,	
			tad.TalId,
			
			tad.ProId,
			tad.UmeId,
			tad.TadCantidad,
			tad.TadCantidadReal,
			
			tad.TadCosto,
			tad.TadImporte,
			
			tad.TadEstado,
			DATE_FORMAT(tad.TadTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTadTiempoCreacion",
	        DATE_FORMAT(tad.TadTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTadTiempoModificacion",
			
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			
			ume.UmeNombre
	
			FROM tbltadtrasladoalmacendetalle tad
				
				LEFT JOIN tbltaltrasladoalmacen tal
				ON tad.TalId = tal.TalId
				
					LEFT JOIN tblproproducto pro
					ON tad.ProId = pro.ProId
						LEFT JOIN tblumeunidadmedida ume
						ON tad.UmeId = ume.UmeId
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$fecha.$ocompra.$cocompra.$cliente.$vddetalle.$pcestado.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTrasladoAlmacenDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TrasladoAlmacenDetalle = new $InsTrasladoAlmacenDetalle();
                    $TrasladoAlmacenDetalle->TadId = $fila['TadId'];
                    $TrasladoAlmacenDetalle->TalId = $fila['TalId'];
					
					$TrasladoAlmacenDetalle->ProId = $fila['ProId'];
					$TrasladoAlmacenDetalle->UmeId = $fila['UmeId'];
					$TrasladoAlmacenDetalle->TadCantidad = $fila['TadCantidad'];
					$TrasladoAlmacenDetalle->TadCantidadReal = $fila['TadCantidadReal'];
					$TrasladoAlmacenDetalle->TadCosto = $fila['TadCosto'];
					$TrasladoAlmacenDetalle->TadImporte = $fila['TadImporte'];
	
					$TrasladoAlmacenDetalle->TadEstado = $fila['TadEstado'];
					$TrasladoAlmacenDetalle->TadTiempoCreacion = $fila['NTadTiempoCreacion'];  
					$TrasladoAlmacenDetalle->TadTiempoModificacion = $fila['NTadTiempoModificacion']; 	
					
					
					$TrasladoAlmacenDetalle->ProNombre = $fila['ProNombre'];
					$TrasladoAlmacenDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$TrasladoAlmacenDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
					
					$TrasladoAlmacenDetalle->RtiId = $fila['RtiId'];
					$TrasladoAlmacenDetalle->UmeIdOrigen = $fila['UmeIdOrigen'];
					
					$TrasladoAlmacenDetalle->UmeNombre = $fila['UmeNombre'];
					
				
					$TrasladoAlmacenDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TrasladoAlmacenDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarTrasladoAlmacenDetalle($oElementos) {
		
//		$InsTrasladoAlmacenDetalleOrigen = new ClsTrasladoAlmacenDetalleOrigen();
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (TadId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (TadId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
				
				$sql = 'DELETE FROM tbltadtrasladoalmacendetalle 
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
	
	
	public function MtdRegistrarTrasladoAlmacenDetalle() {
		
		$this->MtdGenerarTrasladoAlmacenDetalleId();

		$sql = 'INSERT INTO tbltadtrasladoalmacendetalle (
		TadId,
		TalId,	
		ProId,			
		UmeId,			
		
		TadCosto,
		TadImporte,
		
		TadCantidad,		
		TadCantidadReal,		
		TadEstado,
		TadTiempoCreacion,
		TadTiempoModificacion) 
		VALUES (
		"'.($this->TadId).'", 
		"'.($this->TalId).'", 
		"'.($this->ProId).'", 			
		"'.($this->UmeId).'", 	
		
		'.($this->TadCosto).',	
		'.($this->TadImporte).',	
						
		'.($this->TadCantidad).',	
		'.($this->TadCantidadReal).',	
						
		'.($this->TadEstado).',
		"'.($this->TadTiempoCreacion).'",
		"'.($this->TadTiempoModificacion).'");';
		
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
	
	public function MtdEditarTrasladoAlmacenDetalle() {

			$sql = 'UPDATE tbltadtrasladoalmacendetalle SET 
			ProId = "'.($this->ProId).'",
			UmeId = "'.($this->UmeId).'",
			
			TadCosto = '.($this->TadCosto).',
			TadImporte = '.($this->TadImporte).',
			
			TadCantidad = '.($this->TadCantidad).',
			TadCantidadReal = '.($this->TadCantidadReal).',
			
			TadEstado = '.($this->TadEstado).',
			TadTiempoModificacion = "'.($this->TadTiempoModificacion).'"
			WHERE TadId = "'.($this->TadId).'";';

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
		
		public function MtdEditarTrasladoAlmacenDetalleDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tbltadtrasladoalmacendetalle SET 
	
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			
			TadTiempoModificacion = NOW()
			WHERE TadId = "'.($oId).'";';
			
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