<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoModeloCaracteristica
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoModeloCaracteristica {

    public $VmcId;
	public $VmoId;
	public $VcaId;
    public $VmcValor;
	
    public $VmcTiempoCreacion;
    public $VmcTiempoModificacion;
    public $VmcEliminado;

	// Propiedades adicionales para evitar warnings
	public $VmaId;

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
	

	public function MtdGenerarVehiculoModeloCaracteristicaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VmcId,5),unsigned)) AS "MAXIMO"
			FROM tblvmcvehiculomodelocaracteristica';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VmcId ="VMC-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VmcId = "VMC-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoModeloCaracteristica(){

        $sql = 'SELECT 
        vmc.VmcId,
		vmc.VmoId,
		vmc.VcaId,
        vmc.VmcValor,
		
		DATE_FORMAT(vmc.VmcTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmcTiempoCreacion",
        DATE_FORMAT(vmc.VmcTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmcTiempoModificacion",

		vmo.VmaId
		
        FROM tblvmcvehiculomodelocaracteristica vmc
			LEFT JOIN tblvmovehiculomodelo vmo
			ON vmc.VmoId = vmo.VmoId
        WHERE vmc.VmcId = "'.$this->VmcId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VmcId = $fila['VmcId'];
			$this->VmoId = $fila['VmoId'];
			$this->VmcId = $fila['VmcId'];
			$this->VmcValor = $fila['VmcValor'];
			
			$this->VmcTiempoCreacion = $fila['NVmcTiempoCreacion'];
			$this->VmcTiempoModificacion = $fila['NVmcTiempoModificacion']; 
			
			$this->VmaId = $fila['VmaId'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoModeloCaracteristicas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmcId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoModelo=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$vehiculoModelo = '';

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
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vmc.VmoId = "'.($oVehiculoModelo).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vmc.VmcId,
				vmc.VmoId,
				vmc.VcaId,
				vmc.VmcValor,
				
				DATE_FORMAT(vmc.VmcTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmcTiempoCreacion",
                DATE_FORMAT(vmc.VmcTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmcTiempoModificacion"
				FROM tblvmcvehiculomodelocaracteristica vmc
				WHERE  1 = 1 '.$filtrar.$vmodelo.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoModeloCaracteristica = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoModeloCaracteristica = new $InsVehiculoModeloCaracteristica();
                    $VehiculoModeloCaracteristica->VmcId = $fila['VmcId'];
					$VehiculoModeloCaracteristica->VmoId = $fila['VmoId'];
					$VehiculoModeloCaracteristica->VcaId = $fila['VcaId'];
                    $VehiculoModeloCaracteristica->VmcValor = $fila['VmcValor'];
					
                    $VehiculoModeloCaracteristica->VmcTiempoCreacion = $fila['NVmcTiempoCreacion'];
                    $VehiculoModeloCaracteristica->VmcTiempoModificacion = $fila['NVmcTiempoModificacion'];

					$VehiculoModeloCaracteristica->InsMysql = NULL;
					$Respuesta['Datos'][]= $VehiculoModeloCaracteristica;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoModeloCaracteristica($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' VmcId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VmcId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VmcId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblvmcvehiculomodelocaracteristica WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarVehiculoModeloCaracteristica() {
	
		$this->MtdGenerarVehiculoModeloCaracteristicaId();
			
			$sql = 'INSERT INTO tblvmcvehiculomodelocaracteristica (
				VmcId,
				VmoId,
				VcaId,
				VmcValor, 
				
				VmcTiempoCreacion,
				VmcTiempoModificacion) 
				VALUES (
				"'.($this->VmcId).'", 
				"'.($this->VmoId).'", 
				"'.($this->VcaId).'", 
				"'.($this->VmcValor).'", 
				
				"'.($this->VmcTiempoCreacion).'", 
				"'.($this->VmcTiempoModificacion).'");';	
				
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
	
	public function MtdEditarVehiculoModeloCaracteristica() {
		
			$sql = 'UPDATE tblvmcvehiculomodelocaracteristica SET 
				VmoId = "'.($this->VmoId).'",
				VcaId = "'.($this->VcaId).'",
				VmcValor = "'.($this->VmcValor).'",
			
				VmcTiempoModificacion = "'.($this->VmcTiempoModificacion).'"
				WHERE VmcId = "'.($this->VmcId).'";';
				 
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