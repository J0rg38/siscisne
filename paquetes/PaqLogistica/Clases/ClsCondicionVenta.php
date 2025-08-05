<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCondicionVenta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCondicionVenta {

    public $CovId;
    public $CovNombre;
	public $CovSigla;
	public $CovDescripcion;	
	public $CovUso;
	public $CovEstado;
    public $CovTiempoCreacion;
    public $CovTiempoModificacion;
    public $CovEliminado;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarCondicionVentaId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CovId,5),unsigned)) AS "MAXIMO"
			FROM tblcovcondicionventa';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CovId = "MIN-10000";
			}else{
				$fila['MAXIMO']++;
				$this->CovId = "MIN-".$fila['MAXIMO'];					
			}		
			
					
		}
		
    public function MtdObtenerCondicionVenta(){

        $sql = 'SELECT 
        cov.CovId,
        cov.CovNombre,
		cov.CovSigla,
		cov.CovDescripcion,
		cov.CovUso,
		DATE_FORMAT(cov.CovTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCovTiempoCreacion",
        DATE_FORMAT(cov.CovTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCovTiempoModificacion"	
        FROM tblcovcondicionventa cov
		WHERE cov.CovId = "'.$this->CovId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CovId = $fila['CovId'];
            $this->CovNombre = $fila['CovNombre'];
			$this->CovSigla = $fila['CovSigla'];
			$this->CovDescripcion = $fila['CovDescripcion'];
			$this->CovUso = $fila['CovUso'];
			$this->CovEstado = $fila['CovEstado'];
			$this->CovTiempoCreacion = $fila['NCovTiempoCreacion'];
			$this->CovTiempoModificacion = $fila['NCovTiempoModificacion']; 

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCondicionVentas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CovId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL) {

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
		

		if(!empty($oUso)){

			$elementos = explode(",",$oUso);

			$i=1;
			$uso .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$uso .= '  (CovUso = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$uso .= ' OR ';	
				}
			$i++;		
			}

			$uso .= ' ) 
			)
			';

		}

//		if(!empty($oUso)){
//			$uso = ' AND CovUso = '.$oUso;
//		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				CovId,
				CovNombre,
				CovSigla,
				CovDescripcion,
				CovUso,
				CovEstado,
				DATE_FORMAT(CovTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCovTiempoCreacion",
                DATE_FORMAT(CovTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCovTiempoModificacion"				
				FROM tblcovcondicionventa
				WHERE 1  = 1 '.$filtrar.$uso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCondicionVenta = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				
					$CondicionVenta = new $InsCondicionVenta();
                    $CondicionVenta->CovId = $fila['CovId'];
                    $CondicionVenta->CovNombre= $fila['CovNombre'];
					$CondicionVenta->CovSigla = $fila['CovSigla'];
					$CondicionVenta->CovDescripcion= $fila['CovDescripcion'];
					
					
					$CondicionVenta->CovUso= $fila['CovUso'];
					$CondicionVenta->CovEstado= $fila['CovEstado'];
                    $CondicionVenta->CovTiempoCreacion = $fila['NCovTiempoCreacion'];
                    $CondicionVenta->CovTiempoModificacion = $fila['NCovTiempoModificacion'];    
					
					$CondicionVenta->InsMysql = NULL;                    
					
					$Respuesta['Datos'][]=$CondicionVenta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	
	//Accion eliminar	 
	
	public function MtdEliminarCondicionVenta($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CovId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CovId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
	
			$sql = 'DELETE FROM tblcovcondicionventa WHERE '.$eliminar;
		
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
	
	
	public function MtdRegistrarCondicionVenta() {
	
			$this->MtdGenerarCondicionVentaId();
			
			$sql = 'INSERT INTO tblcovcondicionventa (
			CovId,
			CovNombre, 
			CovSigla,
			CovDescripcion,
			CovUso,
			CovEstado,
			CovTiempoCreacion,
			CovTiempoModificacion) 
			VALUES (
			"'.($this->CovId).'", 
			"'.($this->CovNombre).'", 
			"'.($this->CovSigla).'", 
			"'.($this->CovDescripcion).'", 
			'.($this->CovUso).', 
			'.($this->CovEstado).', 
			"'.($this->CovTiempoCreacion).'", 
			"'.($this->CovTiempoModificacion).'");';

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
	
	public function MtdEditarCondicionVenta() {
		
		$sql = 'UPDATE tblcovcondicionventa SET 
		 CovNombre = "'.($this->CovNombre).'",
		 CovSigla = "'.($this->CovSigla).'",
		 CovDescripcion = "'.($this->CovDescripcion).'",
		 CovUso = '.($this->CovUso).',			 
		 CovEstado = '.($this->CovEstado).',
		 CovTiempoModificacion = "'.($this->CovTiempoModificacion).'"
		 WHERE CovId = "'.($this->CovId).'";';
		
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