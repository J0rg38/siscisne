<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCotizacionVehiculoFoto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCotizacionVehiculoFoto {

    public $CvfId;	
    public $CveId;
	public $CvfArchivo;
	public $CvfEstado;
    public $CvfTiempoCreacion;
    public $CvfTiempoModificacion;
    public $CvfEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }

	public function __destruct(){

	}

	public function MtdGenerarCotizacionVehiculoFotoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CvfId,5),unsigned)) AS "MAXIMO"
			FROM tblcvfcotizacionvehiculofoto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CvfId ="CVF-10000";
			}else{
				$fila['MAXIMO']++;
				$this->CvfId = "CVF-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerCotizacionVehiculoFoto(){

        $sql = 'SELECT 
        vif.CvfId,
		vif.CvfArchivo,
        vif.CveId,
		vif.CvfEstado,
		DATE_FORMAT(vif.CvfTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCvfTiempoCreacion",
        DATE_FORMAT(vif.CvfTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCvfTiempoModificacion"
        FROM tblcvfcotizacionvehiculofoto vif
        WHERE vif.CvfId = "'.$this->CvfId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CvfId = $fila['CvfId'];
			$this->CvfArchivo = $fila['CvfArchivo'];
			$this->CveId = $fila['CveId'];
			$this->CvfEstado = $fila['CvfEstado'];
			$this->CvfTiempoCreacion = $fila['NCvfTiempoCreacion'];
			$this->CvfTiempoModificacion = $fila['NCvfTiempoModificacion']; 
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCotizacionVehiculoFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CvfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionVehiculo=NULL) {

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
		
		
		if(!empty($oCotizacionVehiculo)){
			$vingreso = ' AND vif.CveId = "'.($oCotizacionVehiculo).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vif.CvfId,
				vif.CvfArchivo,
				vif.CveId,
				vif.CvfEstado,
				DATE_FORMAT(vif.CvfTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCvfTiempoCreacion",
                DATE_FORMAT(vif.CvfTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCvfTiempoModificacion"
				
				FROM tblcvfcotizacionvehiculofoto vif
				
						
				WHERE  1 = 1 '.$filtrar.$vingreso.$cliente.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionVehiculoFoto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$CotizacionVehiculoFoto = new $InsCotizacionVehiculoFoto();
                    $CotizacionVehiculoFoto->CvfId = $fila['CvfId'];
					$CotizacionVehiculoFoto->CvfArchivo = $fila['CvfArchivo'];
                    $CotizacionVehiculoFoto->CveId = $fila['CveId'];
					
					$CotizacionVehiculoFoto->CvfEstado = $fila['CvfEstado'];
                    $CotizacionVehiculoFoto->CvfTiempoCreacion = $fila['NCvfTiempoCreacion'];
					$CotizacionVehiculoFoto->CvfTiempoModificacion = $fila['NCvfTiempoModificacion'];
					
					$CotizacionVehiculoFoto->InsMysql = NULL;      
					$Respuesta['Datos'][]= $CotizacionVehiculoFoto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarCotizacionVehiculoFoto($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' CvfId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CvfId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CvfId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblcvfcotizacionvehiculofoto WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarCotizacionVehiculoFoto() {
	
		$this->MtdGenerarCotizacionVehiculoFotoId();
			
			$sql = 'INSERT INTO tblcvfcotizacionvehiculofoto (
				CvfId,
				CvfArchivo,
				CveId, 
				CvfEstado,
				CvfTiempoCreacion,
				CvfTiempoModificacion) 
				VALUES (
				"'.($this->CvfId).'", 
				"'.($this->CvfArchivo).'", 
				"'.($this->CveId).'", 
				'.($this->CvfEstado).', 
				"'.($this->CvfTiempoCreacion).'", 
				"'.($this->CvfTiempoModificacion).'");';	
				
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
	
	
		public function MtdEditarCotizacionVehiculoFoto() {
		
			$sql = 'UPDATE tblcvfcotizacionvehiculofoto SET 
				CvfArchivo = "'.($this->CvfArchivo).'",
				CvfEstado = '.($this->CvfEstado).',
				CvfTiempoModificacion = "'.($this->CvfTiempoModificacion).'"
				WHERE CvfId = "'.($this->CvfId).'";';
				 
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