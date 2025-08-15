<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoRecepcionDetalleFoto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoRecepcionDetalleFoto {

    public $VrfId;
	public $VrdId;
    public $VrfArchivo;
	public $VrfEstado;
    public $VrfTiempoCreacion;
    public $VrfTiempoModificacion;
    public $VrfEliminado;

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
	

	public function MtdGenerarVehiculoRecepcionDetalleFotoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VrfId,5),unsigned)) AS "MAXIMO"
			FROM tblvrfvehiculorecepciondetallefoto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VrfId ="VRF-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VrfId = "VRF-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoRecepcionDetalleFoto(){

        $sql = 'SELECT 
        vrf.VrfId,
		vrf.VrdId,
        vrf.VrfArchivo,
		vrf.VrfEstado,
		DATE_FORMAT(vrf.VrfTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVrfTiempoCreacion",
        DATE_FORMAT(vrf.VrfTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVrfTiempoModificacion"
        FROM tblvrfvehiculorecepciondetallefoto vrf
        WHERE vrf.VrfId = "'.$this->VrfId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VrfId = $fila['VrfId'];
			$this->VrdId = $fila['VrdId'];
			$this->VrfArchivo = $fila['VrfArchivo'];
			$this->VrfEstado = $fila['VrfEstado'];
			$this->VrfTiempoCreacion = $fila['NVrfTiempoCreacion'];
			$this->VrfTiempoModificacion = $fila['NVrfTiempoModificacion']; 
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoRecepcionDetalleFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VrfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoRecepcionDetalle=NULL) {

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
		
		
		if(!empty($oVehiculoRecepcionDetalle)){
			$vdetalle = ' AND vrf.VrdId = "'.($oVehiculoRecepcionDetalle).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vrf.VrfId,
				vrf.VrdId,
				vrf.VrfArchivo,
				vrf.VrfEstado,
				DATE_FORMAT(vrf.VrfTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVrfTiempoCreacion",
                DATE_FORMAT(vrf.VrfTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVrfTiempoModificacion"
				FROM tblvrfvehiculorecepciondetallefoto vrf

				WHERE  1 = 1 '.$filtrar.$vdetalle.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoRecepcionDetalleFoto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoRecepcionDetalleFoto = new $InsVehiculoRecepcionDetalleFoto();
                    $VehiculoRecepcionDetalleFoto->VrfId = $fila['VrfId'];
					$VehiculoRecepcionDetalleFoto->VrdId = $fila['VrdId'];
                    $VehiculoRecepcionDetalleFoto->VrfArchivo = $fila['VrfArchivo'];
					$VehiculoRecepcionDetalleFoto->VrfEstado = $fila['VrfEstado'];
                    $VehiculoRecepcionDetalleFoto->VrfTiempoCreacion = $fila['NVrfTiempoCreacion'];
                    $VehiculoRecepcionDetalleFoto->VrfTiempoModificacion = $fila['NVrfTiempoModificacion'];

					$VehiculoRecepcionDetalleFoto->InsMysql = NULL;      
					$Respuesta['Datos'][]= $VehiculoRecepcionDetalleFoto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoRecepcionDetalleFoto($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' VrfId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VrfId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VrfId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblvrfvehiculorecepciondetallefoto WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarVehiculoRecepcionDetalleFoto() {
	
		$this->MtdGenerarVehiculoRecepcionDetalleFotoId();
			
			$sql = 'INSERT INTO tblvrfvehiculorecepciondetallefoto (
				VrfId,
				VrdId,
				VrfArchivo, 
				VrfEstado, 
				VrfTiempoCreacion,
				VrfTiempoModificacion) 
				VALUES (
				"'.($this->VrfId).'", 
				"'.($this->VrdId).'", 
				"'.($this->VrfArchivo).'", 
				'.($this->VrfEstado).', 
				"'.($this->VrfTiempoCreacion).'", 
				"'.($this->VrfTiempoModificacion).'");';	
				
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
	
	public function MtdEditarVehiculoRecepcionDetalleFoto() {
		
			$sql = 'UPDATE tblvrfvehiculorecepciondetallefoto SET 
				VrfArchivo = "'.($this->VrfArchivo).'",
				VrfEstado = '.($this->VrfEstado).',
				VrfTiempoModificacion = "'.($this->VrfTiempoModificacion).'"
				WHERE VrfId = "'.($this->VrfId).'";';
				 
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