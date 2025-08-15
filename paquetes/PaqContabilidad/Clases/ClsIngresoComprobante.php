<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Ingcription of ClsIngresoComprobante
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsIngresoComprobante {

    public $IcoId;
    public $IngId;
    public $AmoId;
	
	public $IcoEstado;	
    public $IcoTiempoCreacion;
    public $IcoTiempoModificacion;
    public $IcoEliminado;

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
		
	public function MtdGenerarIngresoComprobanteId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(IcoId,5),unsigned)) AS "MAXIMO"
		FROM tblicoingresocomprobante';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->IcoId = "ICO-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->IcoId = "ICO-".$fila['MAXIMO'];					
		}	
				
	}
		
    public function MtdObtenerIngresoComprobante(){

        $sql = 'SELECT 
        ico.IcoId,
		ico.IngId,
		ico.AmoId,

        FROM tblicoingresocomprobante ico
        WHERE IcoId = "'.$this->IcoId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->IcoId = $fila['IcoId'];
			$this->IngId = $fila['IngId'];
			$this->AmoId = $fila['AmoId'];
		
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerIngresoComprobantes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'IcoId',$oSentido = 'Ingc',$oPaginacion = '0,10',$oIngembolso=NULL) {

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

		
		if(!empty($oIngembolso)){
			$desembolso = ' AND ico.IngId = "'.$oTarjeta.'"';
		}
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ico.IcoId,
				ico.IngId,
				ico.AmoId

				FROM tblicoingresocomprobante ico

				WHERE 1 = 1 '.$filtrar.$desembolso.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsIngresoComprobante = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$IngresoComprobante = new $InsIngresoComprobante();				
					
                    $IngresoComprobante->IcoId = $fila['IcoId'];
					$IngresoComprobante->IngId= $fila['IngId'];
					$IngresoComprobante->AmoId = $fila['AmoId'];
					
                    $IngresoComprobante->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $IngresoComprobante;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarIngresoComprobante($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (IcoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (IcoId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblicoingresocomprobante WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarIngresoComprobante() {
	
			$this->MtdGenerarIngresoComprobanteId();
		
			$sql = 'INSERT INTO tblicoingresocomprobante (
			IcoId,
			IngId,
			AmoId
			) 
			VALUES (
			"'.($this->IcoId).'", 
			"'.($this->IngId).'",
			"'.($this->AmoId).'");';					

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
	
	public function MtdEditarIngresoComprobante() {
		

			$sql = 'UPDATE tblicoingresocomprobante SET		

			'.(empty($this->AmoId)?'AmoId = NULL, ':'AmoId = "'.$this->AmoId.'",').'
			
			IngId = "'.($this->IngId ).'"

			WHERE IcoId = "'.($this->IcoId).'";';
			
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