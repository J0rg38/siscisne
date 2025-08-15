<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoVersionAduanaCaracteristica
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoVersionAduanaCaracteristica {

    public $VacId;
	public $VveId;
	public $VcsId;
	public $VacAnoModelo;
	public $VacDescripcion;
    public $VacValor;
	
    public $VacTiempoCreacion;
    public $VacTiempoModificacion;
    public $VacEliminado;

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
	
	public function MtdGenerarVehiculoVersionAduanaCaracteristicaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VacId,5),unsigned)) AS "MAXIMO"
			FROM tblvacvehiculoversionaduanacaracteristica';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VacId ="VAC-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VacId = "VAC-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoVersionAduanaCaracteristica(){

        $sql = 'SELECT 
        vac.VacId,
		vac.VveId,
		vac.VcsId,
		vac.VacAnoModelo,
		vac.VacDescripcion,
        vac.VacValor,
		DATE_FORMAT(vac.VacTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVacTiempoCreacion",
        DATE_FORMAT(vac.VacTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVacTiempoModificacion"
        FROM tblvacvehiculoversionaduanacaracteristica vac
			
        WHERE vac.VacId = "'.$this->VacId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VacId = $fila['VacId'];
			$this->VveId = $fila['VveId'];
			$this->VacId = $fila['VacId'];
			
			$this->VacAnoModelo = $fila['VacAnoModelo'];
			$this->VacDescripcion = $fila['VacDescripcion'];
			$this->VacValor = $fila['VacValor'];
			
			$this->VacTiempoCreacion = $fila['NVacTiempoCreacion'];
			$this->VacTiempoModificacion = $fila['NVacTiempoModificacion']; 
		;
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoVersionAduanaCaracteristicas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoVersion=NULL,$oAnoModelo=NULL) {

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
		
		if(!empty($oVehiculoVersion)){
			$vmodelo = ' AND vac.VveId = "'.($oVehiculoVersion).'"';
		}
		
		if(!empty($oAnoModelo)){
			$amodelo = ' AND vac.VacAnoModelo = "'.($oAnoModelo).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vac.VacId,
				vac.VveId,
				vac.VcsId,
				vac.VacAnoModelo,
				vac.VacDescripcion,
				vac.VacValor,
				
				DATE_FORMAT(vac.VacTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVacTiempoCreacion",
                DATE_FORMAT(vac.VacTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVacTiempoModificacion"
				FROM tblvacvehiculoversionaduanacaracteristica vac
				WHERE  1 = 1 '.$filtrar.$vmodelo.$amodelo.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoVersionAduanaCaracteristica = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoVersionAduanaCaracteristica = new $InsVehiculoVersionAduanaCaracteristica();
                    $VehiculoVersionAduanaCaracteristica->VacId = $fila['VacId'];
					$VehiculoVersionAduanaCaracteristica->VveId = $fila['VveId'];
					$VehiculoVersionAduanaCaracteristica->VcsId = $fila['VcsId'];
					
					$VehiculoVersionAduanaCaracteristica->VacAnoModelo = $fila['VacAnoModelo'];
					$VehiculoVersionAduanaCaracteristica->VacDescripcion = $fila['VacDescripcion'];
                    $VehiculoVersionAduanaCaracteristica->VacValor = $fila['VacValor'];
					
                    $VehiculoVersionAduanaCaracteristica->VacTiempoCreacion = $fila['NVacTiempoCreacion'];
                    $VehiculoVersionAduanaCaracteristica->VacTiempoModificacion = $fila['NVacTiempoModificacion'];

					$VehiculoVersionAduanaCaracteristica->InsMysql = NULL;
					$Respuesta['Datos'][]= $VehiculoVersionAduanaCaracteristica;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoVersionAduanaCaracteristica($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VacId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VacId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
	
			$sql = 'DELETE FROM tblvacvehiculoversionaduanacaracteristica WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarVehiculoVersionAduanaCaracteristica() {
	
		$this->MtdGenerarVehiculoVersionAduanaCaracteristicaId();
			
			$sql = 'INSERT INTO tblvacvehiculoversionaduanacaracteristica (
				VacId,
				VveId,
				VcsId,
				VacAnoModelo,
				VacDescripcion,
				VacValor, 
				
				VacTiempoCreacion,
				VacTiempoModificacion) 
				VALUES (
				"'.($this->VacId).'", 
				"'.($this->VveId).'", 
				"'.($this->VcsId).'", 
				"'.($this->VacAnoModelo).'", 
				"'.($this->VacDescripcion).'", 
				"'.($this->VacValor).'", 
				
				"'.($this->VacTiempoCreacion).'", 
				"'.($this->VacTiempoModificacion).'");';	
				
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
	
	public function MtdEditarVehiculoVersionAduanaCaracteristica() {
		
			$sql = 'UPDATE tblvacvehiculoversionaduanacaracteristica SET 
				VveId = "'.($this->VveId).'",
				VcsId = "'.($this->VcsId).'",

				VacAnoModelo = "'.($this->VacAnoModelo).'",
				VacDescripcion = "'.($this->VacDescripcion).'",
				VacValor = "'.($this->VacValor).'",

				VacTiempoModificacion = "'.($this->VacTiempoModificacion).'"
				WHERE VacId = "'.($this->VacId).'";';
				 
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