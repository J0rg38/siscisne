<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsClienteVehiculoIngreso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsClienteVehiculoIngreso {

    public $CviId;
	public $CliId;
	public $EinId;
   
    public $CviEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarClienteVehiculoIngresoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CviId,5),unsigned)) AS "MAXIMO"
			FROM tblcviclientevehiculoingreso';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CviId = "CVI-10000";

			}else{
				$fila['MAXIMO']++;
				$this->CviId = "CVI-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerClienteVehiculoIngreso(){

        $sql = 'SELECT 
        cvi.CviId,
		cvi.CliId,
		cvi.EinId
		
        FROM tblcviclientevehiculoingreso cvi
			
        WHERE CviId = "'.$this->CviId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CviId = $fila['CviId'];
			$this->CliId = $fila['CliId'];
			$this->EinId = $fila['EinId'];	
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerClienteVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CviId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCliente=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
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
			
			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
			
				
		if(!empty($oCliente)){
			$cliente = ' AND cvi.CliId = '.$oCliente;
		}	
		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cvi.CviId,
				cvi.CliId,
				cvi.EinId	
				
				FROM tblcviclientevehiculoingreso cvi	
					
				WHERE 1 = 1 '.$filtrar.$cliente.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsClienteVehiculoIngreso = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ClienteVehiculoIngreso = new $InsClienteVehiculoIngreso();				
					
                    $ClienteVehiculoIngreso->CviId = $fila['CviId'];
					$ClienteVehiculoIngreso->CliId = $fila['CliId'];
					$ClienteVehiculoIngreso->EinId= $fila['EinId'];
					
                    $ClienteVehiculoIngreso->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ClienteVehiculoIngreso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarClienteVehiculoIngreso($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CviId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CviId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblcviclientevehiculoingreso WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarClienteVehiculoIngreso() {

			$this->MtdGenerarClienteVehiculoIngresoId();
		
			$sql = 'INSERT INTO tblcviclientevehiculoingreso (
			CviId,
			CliId,
			EinId
			) 
			VALUES (
			"'.($this->CviId).'", 
			"'.($this->CliId).'",
			"'.($this->EinId).'");';

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
	

	public function MtdEditarClienteVehiculoIngreso() {
		

			$sql = 'UPDATE tblcviclientevehiculoingreso SET 
			EinId = "'.($this->EinId).'"
			WHERE CviId = "'.($this->CviId).'";';
			
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