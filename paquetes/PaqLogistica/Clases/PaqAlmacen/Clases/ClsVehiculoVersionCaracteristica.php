<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoVersionCaracteristica
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoVersionCaracteristica {

    public $VvcId;
	public $VveId;
	public $VcsId;
	public $VvcAnoModelo;
	public $VvcDescripcion;
    public $VvcValor;
	
    public $VvcTiempoCreacion;
    public $VvcTiempoModificacion;
    public $VvcEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	public function MtdGenerarVehiculoVersionCaracteristicaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VvcId,5),unsigned)) AS "MAXIMO"
			FROM tblvvcvehiculoversioncaracteristica';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VvcId ="VVC-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VvcId = "VVC-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoVersionCaracteristica(){

        $sql = 'SELECT 
        vvc.VvcId,
		vvc.VveId,
		vvc.VcsId,
		vvc.VvcAnoModelo,
		vvc.VvcDescripcion,
        vvc.VvcValor,
		
		DATE_FORMAT(vvc.VvcTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVvcTiempoCreacion",
        DATE_FORMAT(vvc.VvcTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVvcTiempoModificacion"

		
        FROM tblvvcvehiculoversioncaracteristica vvc
			
        WHERE vvc.VvcId = "'.$this->VvcId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VvcId = $fila['VvcId'];
			$this->VveId = $fila['VveId'];
			$this->VvcId = $fila['VvcId'];
			
			$this->VvcAnoModelo = $fila['VvcAnoModelo'];
			$this->VvcDescripcion = $fila['VvcDescripcion'];
			$this->VvcValor = $fila['VvcValor'];
			
			$this->VvcTiempoCreacion = $fila['NVvcTiempoCreacion'];
			$this->VvcTiempoModificacion = $fila['NVvcTiempoModificacion']; 
		;
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoVersionCaracteristicas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VvcId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oSeccion=NULL,$oVehiculoModelo=NULL) {

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
			$vmodelo = ' AND vvc.VveId = "'.($oVehiculoVersion).'"';
		}
		
		if(!empty($oAnoModelo)){
			$amodelo = ' AND vvc.VvcAnoModelo = "'.($oAnoModelo).'"';
		}
		/*	if(!empty($oSeccion)){
			$seccion = ' AND vvc.VcsId = "'.($oSeccion).'"';
		}
		*/
		if(!empty($oSeccion)){

			$elementos = explode(",",$oSeccion);

				$i=1;
				$seccion .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$seccion .= '  (vvc.VcsId = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$seccion .= ' OR ';	
						}
				$i++;		
				}
				
				$seccion .= ' ) ';

		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId= "'.($oVehiculoModelo).'"';
		}
		
		
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vvc.VvcId,
				vvc.VveId,
				vvc.VcsId,
				vvc.VvcAnoModelo,
				vvc.VvcDescripcion,
				vvc.VvcValor,
				
				DATE_FORMAT(vvc.VvcTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVvcTiempoCreacion",
                DATE_FORMAT(vvc.VvcTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVvcTiempoModificacion",
				
				vcs.VcsNombre
				
				FROM tblvvcvehiculoversioncaracteristica vvc
					LEFT JOIN tblvvevehiculoversion vve
					ON vvc.VveId = vve.VveId
						LEFT JOIN tblvcsvehiculocaracteristicaseccion vcs
						ON vvc.VcsId = vcs.VcsId
						
				WHERE  1 = 1 '.$filtrar.$vmodelo.$vmodelo.$seccion.$amodelo.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoVersionCaracteristica = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoVersionCaracteristica = new $InsVehiculoVersionCaracteristica();
                    $VehiculoVersionCaracteristica->VvcId = $fila['VvcId'];
					$VehiculoVersionCaracteristica->VveId = $fila['VveId'];
					$VehiculoVersionCaracteristica->VcsId = $fila['VcsId'];
					
					$VehiculoVersionCaracteristica->VvcAnoModelo = $fila['VvcAnoModelo'];
					$VehiculoVersionCaracteristica->VvcDescripcion = $fila['VvcDescripcion'];
                    $VehiculoVersionCaracteristica->VvcValor = $fila['VvcValor'];
					
                    $VehiculoVersionCaracteristica->VvcTiempoCreacion = $fila['NVvcTiempoCreacion'];
                    $VehiculoVersionCaracteristica->VvcTiempoModificacion = $fila['NVvcTiempoModificacion'];
					
					$VehiculoVersionCaracteristica->VcsNombre = $fila['VcsNombre'];

					$VehiculoVersionCaracteristica->InsMysql = NULL;
					$Respuesta['Datos'][]= $VehiculoVersionCaracteristica;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoVersionCaracteristica($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VvcId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VvcId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
	
			$sql = 'DELETE FROM tblvvcvehiculoversioncaracteristica WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarVehiculoVersionCaracteristica() {
	
		$this->MtdGenerarVehiculoVersionCaracteristicaId();
			
			$sql = 'INSERT INTO tblvvcvehiculoversioncaracteristica (
				VvcId,
				VveId,
				VcsId,
				VvcAnoModelo,
				VvcDescripcion,
				VvcValor, 
				
				VvcTiempoCreacion,
				VvcTiempoModificacion) 
				VALUES (
				"'.($this->VvcId).'", 
				"'.($this->VveId).'", 
				"'.($this->VcsId).'", 
				"'.($this->VvcAnoModelo).'", 
				"'.($this->VvcDescripcion).'", 
				"'.($this->VvcValor).'", 
				
				"'.($this->VvcTiempoCreacion).'", 
				"'.($this->VvcTiempoModificacion).'");';	
				
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
	
	public function MtdEditarVehiculoVersionCaracteristica() {
		
			$sql = 'UPDATE tblvvcvehiculoversioncaracteristica SET 
				VveId = "'.($this->VveId).'",
				VcsId = "'.($this->VcsId).'",

				VvcAnoModelo = "'.($this->VvcAnoModelo).'",
				VvcDescripcion = "'.($this->VvcDescripcion).'",
				VvcValor = "'.($this->VvcValor).'",

				VvcTiempoModificacion = "'.($this->VvcTiempoModificacion).'"
				WHERE VvcId = "'.($this->VvcId).'";';
				 
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