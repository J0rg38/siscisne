<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsMoneda
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsMoneda {

    public $MonId;
	public $MonSigla;
	public $MonAbreviacion;
	public $MonNombre;
    public $MonSimbolo;
	public $MonEstado;
    public $MonEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarMonedaId() {
		
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(MonId,5),unsigned)) AS "MAXIMO"
			FROM tblmonmoneda';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->MonId = "MON-10000";

			}else{
				$fila['MAXIMO']++;
				$this->MonId = "MON-".$fila['MAXIMO'];					
			}	
			
			
					
		}
		
    public function MtdObtenerMoneda(){

        $sql = 'SELECT 
        MonId,
		MonSigla,
		MonAbreviacion,
		MonNombre,
        MonSimbolo
        FROM tblmonmoneda
        WHERE MonId = "'.$this->MonId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->MonId = $fila['MonId'];
			$this->MonSigla = $fila['MonSigla'];
			$this->MonAbreviacion = $fila['MonAbreviacion'];	
			$this->MonNombre = $fila['MonNombre'];	
            $this->MonSimbolo = $fila['MonSimbolo'];			
		}	
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerMonedas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'MonId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {
		
		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$estado = '';
		
		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' = "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			
		}
		
		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oEstado)){
			$estado = ' AND MonEstado = '.($oEstado);
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				MonId,
				MonSigla,
				
				MonAbreviacion,
				MonNombre,
				MonSimbolo
				FROM tblmonmoneda 
				WHERE 1 = 1 '.$estado.$filtrar.$orden.$paginacion;
											
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsMoneda = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Moneda = new $InsMoneda();
                    $Moneda->MonId = $fila['MonId'];
                    $Moneda->MonSigla = $fila['MonSigla'];
					
					$Moneda->MonAbreviacion = $fila['MonAbreviacion'];
					$Moneda->MonNombre= $fila['MonNombre'];			
                    $Moneda->MonSimbolo= $fila['MonSimbolo'];
                    $Moneda->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Moneda;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		


	//Accion eliminar	 
	
	public function MtdEliminarMoneda($oElementos) {
		
		$elementos = explode("#",$oElementos);
		$eliminar = ''; // Initialize variable to avoid undefined variable warning
		
		if(!count($elementos)){
			$eliminar .= ' MonId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (MonId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (MonId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
		
			$sql = 'DELETE FROM tblmonmoneda WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarMoneda() {
	
			//$this->MtdGenerarMonedaId();
		
			$sql = 'INSERT INTO tblmonmoneda (
			MonId,
			MonAbreviacion,
			MonSigla,
			
			MonNombre,
			MonSimbolo
			) 
			VALUES (
			"'.($this->MonId).'", 
			"'.($this->MonAbreviacion).'", 
			"'.($this->MonSigla).'", 
			
			"'.($this->MonNombre).'",
			"'.($this->MonSimbolo).'");';					

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
	
	public function MtdEditarMoneda() {
		
			$sql = 'UPDATE tblmonmoneda SET 
			 MonAbreviacion = "'.($this->MonAbreviacion).'",
			 MonSigla = "'.($this->MonSigla).'",
			
			
			 MonNombre = "'.($this->MonNombre).'",
			 MonSimbolo = "'.($this->MonSimbolo).'"
			 WHERE MonId = "'.($this->MonId).'";';
			
		
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