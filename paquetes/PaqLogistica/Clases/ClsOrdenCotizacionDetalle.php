<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenCotizacionDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenCotizacionDetalle {

    public $OodId;
	public $OotId;
	public $ProId;
	public $UmeId;
	public $VddId;
	
	public $OodAno;
	public $OodModelo;
	public $OodPrecio;
	
	public $OodEstado;

	public $OodTiempoCreacion;
	public $OodTiempoModificacion;
    public $OodEliminado;
	
	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	
	public $UmeNombre;
	public $UmeIdOrigen;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarOrdenCotizacionDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(OodId,5),unsigned)) AS "MAXIMO"
			FROM tbloodordencotizaciondetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->OodId = "OOD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->OodId = "OOD-".$fila['MAXIMO'];					
			}
				
	}
	
	
	  public function MtdObtenerOrdenCotizacionDetalle(){

        $sql = 'SELECT 
       		ood.OodId,			
			ood.OotId,
			ood.ProId,
			ood.UmeId,
			
			ood.OodAno,
			ood.OodModelo,
			ood.OodPrecio,
			
			ood.OodEstado,
			DATE_FORMAT(ood.OodTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOodTiempoCreacion",
	        DATE_FORMAT(ood.OodTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOodTiempoModificacion",
			
			pro.ProNombre,
			pro.ProCodigoOriginal,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno
			
			FROM tbloodordencotizaciondetalle ood
				LEFT JOIN tblproproducto pro
				ON ood.ProId= pro.ProId
					LEFT JOIN tblootordencotizacion oot
					ON ood.OotId = oot.OotId
						LEFT JOIN tblprvproveedor prv
						ON oot.PrvId = prv.PrvId
						
        WHERE ood.OodId = "'.$this->OodId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$InsOrdenCotizacionDetalle = new ClsOrdenCotizacionDetalle();
			
				
			$this->OodId = $fila['OodId'];
			
			$this->OotId = $fila['OotId'];
			$this->ProId = $fila['ProId'];
			$this->UmeId = $fila['UmeId'];

			$this->OodAno = $fila['OodAno'];
			$this->OodModelo = $fila['OodModelo'];
			$this->OodPrecio = $fila['OodPrecio'];

			$this->OodEstado = $fila['OodEstado'];
			$this->OodTiempoCreacion = $fila['NOodTiempoCreacion'];
			$this->OodTiempoModificacion = $fila['NOodTiempoModificacion'];
		
			$this->ProNombre = $fila['ProNombre'];
			$this->ProCodigoOriginal = $fila['ProCodigoOriginal'];

			$this->PrvNombre = $fila['PrvNombre'];
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
		
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }


    public function MtdObtenerOrdenCotizacionDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OodId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenCotizacion=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oProveedor=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oOrdenCotizacionEstado=NULL,$oFecha="OotFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oProductoId=NULL) {

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
		
		if(!empty($oOrdenCotizacion)){
			$amovimiento = ' AND ood.OotId = "'.$oOrdenCotizacion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND ood.OodEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (ood.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oFechaInicio)){
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oFecha.')>="'.$oFechaInicio.'" AND DATE('.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE('.$oFecha.')>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oProveedor)){
			$cliente = ' AND (oot.PrvId = "'.$oProveedor.'") ';
		}
		
		if(!empty($oOrdenCotizacionEstado)){
			$pcestado = ' AND (oot.OotEstado = '.$oOrdenCotizacionEstado.') ';
		}
		
		if(!empty($oProductoId)){
			$producto = ' AND (ood.ProId = "'.$oProductoId.'") ';
		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ood.OodId,			
			ood.OotId,
			ood.ProId,
			ood.UmeId,
		
			ood.OodAno,
			ood.OodModelo,
			ood.OodPrecio,
			
			ood.OodEstado,
			DATE_FORMAT(ood.OodTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOodTiempoCreacion",
	        DATE_FORMAT(ood.OodTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOodTiempoModificacion",
			
			DATE_FORMAT(oot.OotFecha, "%d/%m/%Y") AS "NOotFecha",
			prv.PrvNombreCompleto,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno,

			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			ume.UmeNombre,

			pro.UmeId AS "UmeIdOrigen",

			oot.OotTipoCambio
			
			FROM tbloodordencotizaciondetalle ood
			
				LEFT JOIN tblootordencotizacion oot
				ON ood.OotId = oot.OotId
				
					LEFT JOIN tblprvproveedor prv
					ON oot.PrvId = prv.PrvId
					
					LEFT JOIN tblproproducto pro
					ON ood.ProId = pro.ProId
					
						LEFT JOIN tblumeunidadmedida ume
						ON ood.UmeId = ume.UmeId

			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$fecha.$ocompra.$cocompra.$cliente.$vddetalle.$pcestado.$recibida.$producto.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenCotizacionDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenCotizacionDetalle = new $InsOrdenCotizacionDetalle();
                    $OrdenCotizacionDetalle->OodId = $fila['OodId'];
                    $OrdenCotizacionDetalle->OotId = $fila['OotId'];
					$OrdenCotizacionDetalle->ProId = $fila['ProId'];
					
					$OrdenCotizacionDetalle->UmeId = $fila['UmeId'];
			
					$OrdenCotizacionDetalle->OodAno = $fila['OodAno'];  
					$OrdenCotizacionDetalle->OodModelo = $fila['OodModelo'];
					$OrdenCotizacionDetalle->OodPrecio = $fila['OodPrecio'];
		
					$OrdenCotizacionDetalle->OodEstado = $fila['OodEstado'];
														
					$OrdenCotizacionDetalle->OodTiempoCreacion = $fila['NOodTiempoCreacion'];  
					$OrdenCotizacionDetalle->OodTiempoModificacion = $fila['NOodTiempoModificacion']; 	
					
					$OrdenCotizacionDetalle->OotFecha = $fila['NOotFecha']; 
						
					$OrdenCotizacionDetalle->PrvNombreCompleto = $fila['PrvNombreCompleto']; 	
					
					$OrdenCotizacionDetalle->PrvNombre = $fila['PrvNombre']; 	
					$OrdenCotizacionDetalle->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 	
					$OrdenCotizacionDetalle->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 	
					
							
					$OrdenCotizacionDetalle->ProId = $fila['ProId'];	
                    $OrdenCotizacionDetalle->ProNombre = (($fila['ProNombre']));
					$OrdenCotizacionDetalle->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$OrdenCotizacionDetalle->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
					$OrdenCotizacionDetalle->RtiId = (($fila['RtiId']));
					
					$OrdenCotizacionDetalle->UmeNombre = (($fila['UmeNombre']));
					
					$OrdenCotizacionDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$OrdenCotizacionDetalle->OotTipoCambio = $fila['OotTipoCambio'];
					
				
				     $OrdenCotizacionDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenCotizacionDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarOrdenCotizacionDetalle($oElementos) {
		
//		$InsOrdenCotizacionDetalleOrigen = new ClsOrdenCotizacionDetalleOrigen();
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (OodId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (OodId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tbloodordencotizaciondetalle 
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
	
	
	public function MtdRegistrarOrdenCotizacionDetalle() {
	
			$this->MtdGenerarOrdenCotizacionDetalleId();
			
			$sql = 'INSERT INTO tbloodordencotizaciondetalle (
			OodId,
			OotId,	
			ProId,
			
			UmeId,
				
			OodAno,
			OodModelo,
			OodCodigo,
			
			OodPrecio,
			
			OodEstado,
			OodTiempoCreacion,
			OodTiempoModificacion) 
			VALUES (
			"'.($this->OodId).'", 
			"'.($this->OotId).'", 
			"'.($this->ProId).'", 
			
			"'.($this->UmeId).'", 
	
			"'.($this->OodAno).'", 
			"'.($this->OodModelo).'", 
			"'.($this->OodCodigo).'", 
			
			'.($this->OodPrecio).',
			
			'.($this->OodEstado).',
			"'.($this->OodTiempoCreacion).'",
			"'.($this->OodTiempoModificacion).'");';
		
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
	
	public function MtdEditarOrdenCotizacionDetalle() {

			$sql = 'UPDATE tbloodordencotizaciondetalle SET 
			ProId = "'.($this->ProId).'",
			
			UmeId = "'.($this->UmeId).'",

			OodAno = "'.($this->OodAno).'",
			OodModelo = "'.($this->OodModelo).'",
			OodCodigo = "'.($this->OodCodigo).'",
			OodPrecio = '.($this->OodPrecio).',

			OodEstado = '.($this->OodEstado).',
			OodTiempoModificacion = "'.($this->OodTiempoModificacion).'"
			WHERE OodId = "'.($this->OodId).'";';
				
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
		
		
		public function MtdEditarOrdenCotizacionDetalleDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tbloodordencotizaciondetalle SET 
	
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			
			OodTiempoModificacion = NOW()
			WHERE OodId = "'.($oId).'";';
			
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