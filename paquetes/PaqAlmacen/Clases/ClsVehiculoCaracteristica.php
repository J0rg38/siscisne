<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoCaracteristica
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoCaracteristica {

    public $VcaId;
	public $VcsId;
	
    public $VcaNombre;
	public $VcaUnidad;
	public $VcaEstado;
    public $VcaTiempoCreacion;
    public $VcaTiempoModificacion;
    public $VcaEliminado;

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
	

	public function MtdGenerarVehiculoCaracteristicaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VcaId,5),unsigned)) AS "MAXIMO"
			FROM tblvcavehiculocaracteristica';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VcaId ="VCA-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VcaId = "VCA-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoCaracteristica(){

        $sql = 'SELECT 
        vca.VcaId,
		vca.VcsId,
        vca.VcaNombre,
		vca.VcaUnidad,
		vca.VcaEstado,
		DATE_FORMAT(vca.VcaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVcaTiempoCreacion",
        DATE_FORMAT(vca.VcaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVcaTiempoModificacion"
        FROM tblvcavehiculocaracteristica vca
        WHERE vca.VcaId = "'.$this->VcaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VcaId = $fila['VcaId'];
			$this->VcsId = $fila['VcsId'];
			$this->VcaNombre = $fila['VcaNombre'];
			$this->VcaUnidad = $fila['VcaUnidad'];
			$this->VcaEstado = $fila['VcaEstado'];
			$this->VcaTiempoCreacion = $fila['NVcaTiempoCreacion'];
			$this->VcaTiempoModificacion = $fila['NVcaTiempoModificacion']; 
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoCaracteristicas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VcaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoCaracteristicaSeccion=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$vehiculoCaracteristicaSeccion = '';

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
		
		
		if(!empty($oVehiculoCaracteristicaSeccion)){
			$vcseccion = ' AND VcsId = "'.($oVehiculoCaracteristicaSeccion).'"';
		}

		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vca.VcaId,
				vca.VcsId,
				
				vca.VcaNombre,
				vca.VcaUnidad,
				vca.VcaEstado,
				DATE_FORMAT(vca.VcaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVcaTiempoCreacion",
                DATE_FORMAT(vca.VcaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVcaTiempoModificacion"				
				FROM tblvcavehiculocaracteristica vca
				WHERE  1 = 1'.$filtrar.$vcseccion.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoCaracteristica = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoCaracteristica = new $InsVehiculoCaracteristica();
                    $VehiculoCaracteristica->VcaId = $fila['VcaId'];
					$VehiculoCaracteristica->VcsId = $fila['VcsId'];
					
                    $VehiculoCaracteristica->VcaNombre = $fila['VcaNombre'];
					$VehiculoCaracteristica->VcaUnidad = $fila['VcaUnidad'];
					$VehiculoCaracteristica->VcaEstado = $fila['VcaEstado'];
                    $VehiculoCaracteristica->VcaTiempoCreacion = $fila['NVcaTiempoCreacion'];
                    $VehiculoCaracteristica->VcaTiempoModificacion = $fila['NVcaTiempoModificacion'];
					$VehiculoCaracteristica->InsMysql = NULL;      
					$Respuesta['Datos'][]= $VehiculoCaracteristica;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoCaracteristica($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		// Inicializar variable para evitar warnings
		$eliminar = '';

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VcaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VcaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblvcavehiculocaracteristica WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarVehiculoCaracteristica() {
	
		$this->MtdGenerarVehiculoCaracteristicaId();
			
			$sql = 'INSERT INTO tblvcavehiculocaracteristica (
				VcaId,
				VcsId,
				VcaNombre, 
				VcaUnidad,
				VcaEstado,
				VcaTiempoCreacion,
				VcaTiempoModificacion) 
				VALUES (
				"'.($this->VcaId).'", 
				"'.($this->VcsId).'", 
				"'.($this->VcaNombre).'", 
				"'.($this->VcaUnidad).'", 
				'.($this->VcaEstado).', 
				"'.($this->VcaTiempoCreacion).'", 
				"'.($this->VcaTiempoModificacion).'");';	
				
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
	
	public function MtdEditarVehiculoCaracteristica() {
		
			$sql = 'UPDATE tblvcavehiculocaracteristica SET 
				 VcsId = "'.($this->VcsId).'",
				 VcaNombre = "'.($this->VcaNombre).'",
				 VcaUnidad = "'.($this->VcaUnidad).'",
				 VcaEstado = '.($this->VcaEstado).',
				 VcaTiempoModificacion = "'.($this->VcaTiempoModificacion).'"
				 WHERE VcaId = "'.($this->VcaId).'";';
				 
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