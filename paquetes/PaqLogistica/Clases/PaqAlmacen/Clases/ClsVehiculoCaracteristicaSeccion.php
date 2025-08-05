<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoCaracteristicaSeccion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoCaracteristicaSeccion {

    public $VcsId;
    public $VcsNombre;
    public $VcsTiempoCreacion;
    public $VcsTiempoModificacion;
    public $VcsEliminado;
	
	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	public function MtdGenerarVehiculoCaracteristicaSeccionId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(VcsId,5),unsigned)) AS "MAXIMO"
		FROM tblvcsvehiculocaracteristicaseccion';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->VcsId ="VCS-10000";
		}else{
			$fila['MAXIMO']++;
		  $this->VcsId = "VCS-".$fila['MAXIMO'];					
		}	

	}
		
    public function MtdObtenerVehiculoCaracteristicaSeccion(){

        $sql = 'SELECT 
        vca.VcsId,
        vca.VcsNombre,
		DATE_FORMAT(vca.VcsTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVcsTiempoCreacion",
        DATE_FORMAT(vca.VcsTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVcsTiempoModificacion"	
        FROM tblvcsvehiculocaracteristicaseccion vca
        WHERE vca.VcsId = "'.$this->VcsId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VcsId = $fila['VcsId'];
            $this->VcsNombre = $fila['VcsNombre'];
			$this->VcsTiempoCreacion = $fila['NVcsTiempoCreacion'];
			$this->VcsTiempoModificacion = $fila['NVcsTiempoModificacion']; 
		
		}
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoCaracteristicaSecciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VcsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {

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
		
		if(!empty($oEstado)){
			$estado = ' AND vcs.VcsEstado = '.($oEstado);
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vcs.VcsId,
				vcs.VcsNombre,
				DATE_FORMAT(vcs.VcsTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVcsTiempoCreacion",
                DATE_FORMAT(vcs.VcsTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVcsTiempoModificacion"				
				FROM tblvcsvehiculocaracteristicaseccion vcs
				WHERE 1 = 1 '.$filtrar.$estado.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoCaracteristicaSeccion = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoCaracteristicaSeccion = new $InsVehiculoCaracteristicaSeccion();
                    $VehiculoCaracteristicaSeccion->VcsId = $fila['VcsId'];
                    $VehiculoCaracteristicaSeccion->VcsNombre= $fila['VcsNombre'];
                    $VehiculoCaracteristicaSeccion->VcsTiempoCreacion = $fila['NVcsTiempoCreacion'];
                    $VehiculoCaracteristicaSeccion->VcsTiempoModificacion = $fila['NVcsTiempoModificacion'];                   
					$Respuesta['Datos'][]= $VehiculoCaracteristicaSeccion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoCaracteristicaSeccion($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VcsId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VcsId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblvcsvehiculocaracteristicaseccion WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarVehiculoCaracteristicaSeccion() {
	
		$this->MtdGenerarVehiculoCaracteristicaSeccionId();
			
			$sql = 'INSERT INTO tblvcsvehiculocaracteristicaseccion (
				VcsId,
				VcsNombre, 
				VcsTiempoCreacion,
				VcsTiempoModificacion
				) 
				VALUES (
				"'.($this->VcsId).'", 
				"'.($this->VcsNombre).'", 
				"'.($this->VcsTiempoCreacion).'", 
				"'.($this->VcsTiempoModificacion).'");';	
				
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
	
	public function MtdEditarVehiculoCaracteristicaSeccion() {
		
			$sql = 'UPDATE tblvcsvehiculocaracteristicaseccion SET 
				 VcsNombre = "'.($this->VcsNombre).'",
				 VcsTiempoModificacion = "'.($this->VcsTiempoModificacion).'"
				 WHERE VcsId = "'.($this->VcsId).'";';
				 
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