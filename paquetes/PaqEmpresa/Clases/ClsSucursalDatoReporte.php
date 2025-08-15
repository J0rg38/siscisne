<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsSucursalDatoReporte
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsSucursalDatoReporte {

    public $SdrId;	
    public $SucId;
	public $SdrFecha;
	public $SdrPersonalAsesoresServicio;
	public $SdrEstado;
    public $SdrTiempoCreacion;
    public $SdrTiempoModificacion;
    public $SdrEliminado;
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
	
	public function MtdVerificarExisteSucursalDatoReporte() {
		
		$Id = NULL;
		
		$sql = 'SELECT
		sdr.SdrId
		FROM tblsdrsucursaldatoreporte sdr 
		WHERE sdr.SucId = "'.$this->SucId.'" LIMIT 1';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);
		
		if(!empty($fila['SdrId'])){
			$Id = $fila['SdrId'];
		}
		
		
		return $Id;			
	}
	
	
	public function MtdGenerarSucursalDatoReporteId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(SdrId,5),unsigned)) AS "MAXIMO"
			FROM tblsdrsucursaldatoreporte';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->SdrId = "SDR-10000";

			}else{
				$fila['MAXIMO']++;
				$this->SdrId = "SDR-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerSucursalDatoReporte(){

        $sql = 'SELECT 
        SdrId,
        SucId,
		DATE_FORMAT(SdrFecha, "%d/%m/%Y") AS "NSdrFecha",
		
		SdrPersonalAsesoresServicio,
		SdrPersonalTecnicos,
		SdrPersonalOtros,
		SdrPersonalAsesorRepuestos,
		SdrPersonalAsistenteAlmacen
		
		SdrEstado,
		DATE_FORMAT(SdrTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSdrTiempoCreacion",
        DATE_FORMAT(SdrTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSdrTiempoModificacion"
        FROM tblsdrsucursaldatoreporte
        WHERE SdrId = "'.$this->SdrId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->SdrId = $fila['SdrId'];
			$this->SucId = $fila['SucId'];
			$this->SdrFecha = $fila['NSdrFecha'];
			
			$this->SdrPersonalAsesoresServicio = $fila['SdrPersonalAsesoresServicio'];
			$this->SdrPersonalTecnicos = $fila['SdrPersonalTecnicos'];
			$this->SdrPersonalOtros = $fila['SdrPersonalOtros'];
			
			$this->SdrPersonalAsesorRepuestos = $fila['SdrPersonalAsesorRepuestos'];
			$this->SdrPersonalAsistenteAlmacen = $fila['SdrPersonalAsistenteAlmacen'];
			
		
			$this->SdrEstado = $fila['SdrEstado'];
			$this->SdrTiempoCreacion = $fila['NSdrTiempoCreacion'];
			$this->SdrTiempoModificacion = $fila['NSdrTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerSucursalDatoReportes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'SdrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oVehiculoMarca=NULL) {

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
		
		if(!empty($oSucursal)){
			$uso = ' AND sdr.SucId = "'.($oSucursal).'"';
		}
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND sdr.VmaId = "'.($oVehiculoMarca).'"';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				SdrId,
				SucId,
				VmaId,
				
				DATE_FORMAT(SdrFecha, "%d/%m/%Y") AS "NSdrFecha",
				
				SdrPersonalAsesoresServicio,
				SdrPersonalTecnicos,
				SdrPersonalOtros,
				
						SdrPersonalAsesorRepuestos,
		SdrPersonalAsistenteAlmacen,
		
				SdrTarifaManoObra,
				
				sdr.SdrEstado,
				DATE_FORMAT(sdr.SdrTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSdrTiempoCreacion",
                DATE_FORMAT(sdr.SdrTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSdrTiempoModificacion"				
				FROM tblsdrsucursaldatoreporte sdr
				WHERE 1 = 1 '.$filtrar.$uso.$vmarca.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsSucursalDatoReporte = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$SucursalDatoReporte = new $InsSucursalDatoReporte();
                    $SucursalDatoReporte->SdrId = $fila['SdrId'];
					$SucursalDatoReporte->SucId= $fila['SucId'];
					$SucursalDatoReporte->SdrFecha= $fila['NSdrFecha'];
					
					$SucursalDatoReporte->SdrPersonalAsesoresServicio = $fila['SdrPersonalAsesoresServicio'];
					$SucursalDatoReporte->SdrPersonalTecnicos = $fila['SdrPersonalTecnicos'];
					$SucursalDatoReporte->SdrPersonalOtros = $fila['SdrPersonalOtros'];
					
					$SucursalDatoReporte->SdrPersonalAsesorRepuestos = $fila['SdrPersonalAsesorRepuestos'];
					$SucursalDatoReporte->SdrPersonalAsistenteAlmacen = $fila['SdrPersonalAsistenteAlmacen'];
					
					$SucursalDatoReporte->SdrTarifaManoObra = $fila['SdrTarifaManoObra'];					
					
					$SucursalDatoReporte->SdrEstado = $fila['SdrEstado'];
                    $SucursalDatoReporte->SdrTiempoCreacion = $fila['NSdrTiempoCreacion'];
                    $SucursalDatoReporte->SdrTiempoModificacion = $fila['NSdrTiempoModificacion'];                    
                    $SucursalDatoReporte->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $SucursalDatoReporte;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarSucursalDatoReporte($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (SdrId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (SdrId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblsdrsucursaldatoreporte WHERE '.$eliminar;

			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarSucursalDatoReporte() {
	
			$this->MtdGenerarSucursalDatoReporteId();
		
			$sql = 'INSERT INTO tblsdrsucursaldatoreporte (
			SdrId,
			SucId, 
			SdrFecha,
			SdrPersonalAsesoresServicio,
			SdrPersonalTecnicos,
			SdrPersonalOtros,
			
			SdrPersonalAsesorRepuestos,
			SdrPersonalAsistenteAlmacen,
			SdrTarifaManoObra,
			
			SdrEstado,
			SdrTiempoCreacion,
			SdrTiempoModificacion,
			SdrEliminado) 
			VALUES (
			"'.($this->SdrId).'", 
			"'.($this->SucId).'", 
			"'.($this->SdrFecha).'", 
			'.($this->SdrPersonalAsesoresServicio).', 
			'.($this->SdrPersonalTecnicos).', 
			'.($this->SdrPersonalOtros).', 
			
			'.($this->SdrPersonalAsesorRepuestos).', 
			'.($this->SdrPersonalAsistenteAlmacen).', 
			'.($this->SdrTarifaManoObra).', 
			
			'.($this->SdrEstado).', 
			"'.($this->SdrTiempoCreacion).'",
			"'.($this->SdrTiempoModificacion).'");';					

			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	public function MtdEditarSucursalDatoReporte() {
		
			$sql = 'UPDATE tblsdrsucursaldatoreporte SET 
			 SucId = "'.($this->SucId).'",
			 SdrFecha = "'.($this->SdrFecha).'",
			
			SdrPersonalAsesoresServicio = '.($this->SdrPersonalAsesoresServicio).',
			SdrPersonalTecnicos = '.($this->SdrPersonalTecnicos).',
			SdrPersonalOtros = '.($this->SdrPersonalOtros).',
			
			SdrPersonalAsesorRepuestos = '.($this->SdrPersonalAsesorRepuestos).',
			SdrPersonalAsistenteAlmacen = '.($this->SdrPersonalAsistenteAlmacen).',
			SdrTarifaManoObra = '.($this->SdrTarifaManoObra).',
			
			 SdrEstado = '.($this->SdrEstado).',
			 SdrTiempoModificacion = "'.($this->SdrTiempoModificacion).'"
			 WHERE SdrId = "'.($this->SdrId).'";';
			
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
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