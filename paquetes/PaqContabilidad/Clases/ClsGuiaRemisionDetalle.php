<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGuiaRemisionDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGuiaRemisionDetalle {

    public $GrdId;
    public $GreId;
	public $GrtId;

	public $GrdCodigo;	
	public $GrdDescripcion;
	public $GrdCantidad;	
	public $GrdUnidadMedida;
	public $GrdPesoNeto;
	public $GrdPesoTotal;
	
	public $GrdEstado;
	public $GrdTiempoCreacion;
	public $GrdTiempoModificacion;
    public $GrdEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarGuiaRemisionDetalleId() {

			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(GrdId,5),unsigned)) AS "MAXIMO"
			FROM tblgrdguiaremisiondetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->GrdId = "GRD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->GrdId = "GRD-".$fila['MAXIMO'];					
			}
			
					
		}


    public function MtdObtenerGuiaRemisionDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'GrdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oGuiaRemision=NULL,$oTalonario=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oGuiaRemision) and !empty($oTalonario)){
			$guiaremision = ' AND grd.GreId = "'.$oGuiaRemision.'" AND grd.GrtId = "'.$oTalonario.'" ';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				grd.GrdId,
				grd.GrdCodigo,
				grd.GrdDescripcion,
                grd.GrdCantidad,
				grd.GrdUnidadMedida,
				grd.GrdPesoNeto,
				grd.GrdPesoTotal,
				DATE_FORMAT(grd.GrdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGrdTiempoCreacion",
	        	DATE_FORMAT(grd.GrdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGrdTiempoModificacion"
				FROM tblgrdguiaremisiondetalle grd
				WHERE 1 = 1 '.$filtrar.$guiaremision.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGuiaRemisionDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$GuiaRemisionDetalle = new $InsGuiaRemisionDetalle();
                    $GuiaRemisionDetalle->GrdId = $fila['GrdId'];

					$GuiaRemisionDetalle->GrdCodigo = $fila['GrdCodigo'];	
                    $GuiaRemisionDetalle->GrdDescripcion = (($fila['GrdDescripcion']));	
                    $GuiaRemisionDetalle->GrdCantidad = $fila['GrdCantidad'];
					$GuiaRemisionDetalle->GrdUnidadMedida = (($fila['GrdUnidadMedida']));

					$GuiaRemisionDetalle->GrdPesoNeto = (($fila['GrdPesoNeto']));
					$GuiaRemisionDetalle->GrdPesoTotal = $fila['GrdPesoTotal'];
					$GuiaRemisionDetalle->GrdTiempoCreacion = $fila['NGrdTiempoCreacion'];  
					$GuiaRemisionDetalle->GrdTiempoModificacion = $fila['NGrdTiempoModificacion']; 

					$GuiaRemisionDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $GuiaRemisionDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	
	//Accion eliminar	 
	
	public function MtdEliminarGuiaRemisionDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (GrdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (GrdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM tblgrdguiaremisiondetalle 
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
	
	
	public function MtdRegistrarGuiaRemisionDetalle() {
	
			$this->MtdGenerarGuiaRemisionDetalleId();
		
			$sql = 'INSERT INTO tblgrdguiaremisiondetalle (
			GrdId,
			GreId, 
			GrtId,
			GrdCodigo,
			GrdDescripcion,
			GrdCantidad,
			GrdUnidadMedida,
			GrdPesoNeto,
			GrdPesoTotal,
			GrdTiempoCreacion,		
			GrdTiempoModificacion) 
			VALUES (
			"'.($this->GrdId).'", 
			"'.($this->GreId).'", 
			"'.($this->GrtId).'", 
			"'.($this->GrdCodigo).'",
			"'.addslashes($this->GrdDescripcion).'",
			"'.($this->GrdCantidad).'",
			"'.addslashes($this->GrdUnidadMedida).'",			
			"'.($this->GrdPesoNeto).'",
			"'.($this->GrdPesoTotal).'",			
			"'.($this->GrdTiempoCreacion).'", 				
			"'.($this->GrdTiempoModificacion).'");';

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
	
	public function MtdEditarGuiaRemisionDetalle() {
		
			$sql = 'UPDATE tblgrdguiaremisiondetalle SET
			 GrdCodigo = "'.($this->GrdCodigo).'",
			 GrdDescripcion = "'.addslashes($this->GrdDescripcion).'",
			 GrdCantidad = "'.($this->GrdCantidad).'",	
			 GrdUnidadMedida = "'.addslashes($this->GrdUnidadMedida).'",		 
			 GrdPesoNeto = "'.($this->GrdPesoNeto).'",
			 GrdPesoTotal = "'.($this->GrdPesoTotal).'",
			 GrdTiempoModificacion = "'.($this->GrdTiempoModificacion).'" 			 
			 WHERE GrdId = "'.($this->GrdId).'";';
					
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