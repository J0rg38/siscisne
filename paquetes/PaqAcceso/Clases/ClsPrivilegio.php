<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPrivilegio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPrivilegio {

    public $PriId;
	public $PriNombre;
	public $PriAlias;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarPrivilegioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PriId,5),unsigned)) AS "MAXIMO"
			FROM tblpriprivilegio';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PriId = "PRI-10000";

			}else{
				$fila['MAXIMO']++;
				$this->PriId = "PRI-".$fila['MAXIMO'];					
			}			
		}
		
    public function MtdObtenerPrivilegio(){

        $sql = 'SELECT 
        PriId,
		PriNombre,
		PriAlias
        FROM tblpriprivilegio
        WHERE PriId = "'.$this->PriId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PriId = $fila['PriId'];
			$this->PriNombre = $fila['PriNombre'];
				$this->PriAlias = $fila['PriAlias'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerPrivilegios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PriId',$oSentido = 'Desc',$oPaginacion = '0,10') {

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
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				PriId,
				PriNombre,
				PriAlias					
				FROM tblpriprivilegio
				WHERE 1 = 1 '.$filtrar.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPrivilegio = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Privilegio = new $InsPrivilegio();
                    $Privilegio->PriId = $fila['PriId'];
                 	$Privilegio->PriNombre= $fila['PriNombre'];	
                 	$Privilegio->PriAlias= $fila['PriAlias'];								
                   
					$Privilegio->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Privilegio;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		
		
	//Accion eliminar	 
	
	public function MtdEliminarPrivilegio($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' PriId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PriId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PriId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE from tblpriprivilegio WHERE '.$eliminar;
		
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
	
	
	public function MtdRegistrarPrivilegio() {
	
			$this->MtdGenerarPrivilegioId();
		
			$sql = 'INSERT INTO tblpriprivilegio (
			PriId,			
			PriNombre,
			PriAlias) 
			VALUES (
			"'.($this->PriId).'", 
			"'.($this->PriNombre).'", 			
			"'.($this->PriAlias).'");';					

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
	
	public function MtdEditarPrivilegio() {
		
			$sql = 'UPDATE tblpriprivilegio SET 			
			 PriNombre = "'.($this->PriNombre).'",	
			 PriAlias = "'.($this->PriAlias).'"			
			 WHERE PriId = "'.($this->PriId).'";';
			
		
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