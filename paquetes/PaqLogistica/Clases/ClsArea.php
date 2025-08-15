<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsArea
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsArea {

    public $AreId;	
    public $AreNombre;
	public $AreDescripcion;
	public $AreUso;
	public $AreEstado;
    public $AreTiempoCreacion;
    public $AreTiempoModificacion;
    public $AreEliminado;
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
	
	public function MtdVerificarExisteArea() {
		
		$Id = NULL;
		
		$sql = 'SELECT
		are.AreId
		FROM tblarearea are 
		WHERE are.AreNombre = "'.$this->AreNombre.'" LIMIT 1';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);
		
		if(!empty($fila['AreId'])){
			$Id = $fila['AreId'];
		}
		
		
		return $Id;			
	}
	
	
	public function MtdGenerarAreaId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(AreId,5),unsigned)) AS "MAXIMO"
			FROM tblarearea';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->AreId = "ARE-10000";

			}else{
				$fila['MAXIMO']++;
				$this->AreId = "ARE-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerArea(){

        $sql = 'SELECT 
        AreId,
        AreNombre,
		AreDescripcion,
		AreUso,
		AreEstado,
		DATE_FORMAT(AreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAreTiempoCreacion",
        DATE_FORMAT(AreTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAreTiempoModificacion"
        FROM tblarearea
        WHERE AreId = "'.$this->AreId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->AreId = $fila['AreId'];
			$this->AreNombre = $fila['AreNombre'];
			$this->AreDescripcion = $fila['AreDescripcion'];
			$this->AreUso = $fila['AreUso'];
			$this->AreEstado = $fila['AreEstado'];
			$this->AreTiempoCreacion = $fila['NAreTiempoCreacion'];
			$this->AreTiempoModificacion = $fila['NAreTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerAreas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL) {

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
			$uso = ' AND are.AreUso = '.($oUso).'';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				are.AreId,
				are.AreNombre,
				are.AreDescripcion,
				are.AreUso,
				are.AreEstado,
				DATE_FORMAT(are.AreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAreTiempoCreacion",
                DATE_FORMAT(are.AreTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAreTiempoModificacion"				
				FROM tblarearea are
				WHERE 1 = 1 '.$filtrar.$uso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsArea = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Area = new $InsArea();
                    $Area->AreId = $fila['AreId'];
					$Area->AreNombre= $fila['AreNombre'];
					$Area->AreDescripcion= $fila['AreDescripcion'];
					$Area->AreUso = $fila['AreUso'];
					$Area->AreEstado = $fila['AreEstado'];
                    $Area->AreTiempoCreacion = $fila['NAreTiempoCreacion'];
                    $Area->AreTiempoModificacion = $fila['NAreTiempoModificacion'];                    
                    $Area->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Area;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarArea($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (AreId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (AreId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblarearea WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarArea() {
	
			$this->MtdGenerarAreaId();
		
			$sql = 'INSERT INTO tblarearea (
			AreId,
			AreNombre, 
			AreDescripcion,
			AreUso,
			AreEstado,
			AreTiempoCreacion,
			AreTiempoModificacion,
			AreEliminado) 
			VALUES (
			"'.($this->AreId).'", 
			"'.($this->AreNombre).'", 
			"'.($this->AreDescripcion).'", 
			'.($this->AreUso).', 
			'.($this->AreEstado).', 
			"'.($this->AreTiempoCreacion).'",
			"'.($this->AreTiempoModificacion).'");';					

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
	
	public function MtdEditarArea() {
		
			$sql = 'UPDATE tblarearea SET 
			 AreNombre = "'.($this->AreNombre).'",
			 AreDescripcion = "'.($this->AreDescripcion).'",
			 AreUso = '.($this->AreUso).',
			 AreEstado = '.($this->AreEstado).',
			 AreTiempoModificacion = "'.($this->AreTiempoModificacion).'"
			 WHERE AreId = "'.($this->AreId).'";';
			
		
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