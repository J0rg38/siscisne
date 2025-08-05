<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsDesembolsoComprobante
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsDesembolsoComprobante {

    public $DcoId;
    public $DesId;
    public $AmoId;
	
	public $DcoEstado;	
    public $DcoTiempoCreacion;
    public $DcoTiempoModificacion;
    public $DcoEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarDesembolsoComprobanteId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(DcoId,5),unsigned)) AS "MAXIMO"
		FROM tbldcodesembolsocomprobante';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->DcoId = "DCO-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->DcoId = "DCO-".$fila['MAXIMO'];					
		}	
				
	}
		
    public function MtdObtenerDesembolsoComprobante(){

        $sql = 'SELECT 
        dco.DcoId,
		dco.DesId,
		dco.AmoId,

        FROM tbldcodesembolsocomprobante dco
        WHERE DcoId = "'.$this->DcoId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->DcoId = $fila['DcoId'];
			$this->DesId = $fila['DesId'];
			$this->AmoId = $fila['AmoId'];
		
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerDesembolsoComprobantes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'DcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oDesembolso=NULL) {

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

		
		if(!empty($oDesembolso)){
			$desembolso = ' AND dco.DesId = "'.$oTarjeta.'"';
		}
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				dco.DcoId,
				dco.DesId,
				dco.AmoId

				FROM tbldcodesembolsocomprobante dco

				WHERE 1 = 1 '.$filtrar.$desembolso.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsDesembolsoComprobante = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$DesembolsoComprobante = new $InsDesembolsoComprobante();				
					
                    $DesembolsoComprobante->DcoId = $fila['DcoId'];
					$DesembolsoComprobante->DesId= $fila['DesId'];
					$DesembolsoComprobante->AmoId = $fila['AmoId'];
					
                    $DesembolsoComprobante->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $DesembolsoComprobante;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarDesembolsoComprobante($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (DcoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (DcoId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tbldcodesembolsocomprobante WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarDesembolsoComprobante() {
	
			$this->MtdGenerarDesembolsoComprobanteId();
		
			$sql = 'INSERT INTO tbldcodesembolsocomprobante (
			DcoId,
			DesId,
			AmoId
			) 
			VALUES (
			"'.($this->DcoId).'", 
			"'.($this->DesId).'",
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
	
	public function MtdEditarDesembolsoComprobante() {
		

			$sql = 'UPDATE tbldcodesembolsocomprobante SET		

			'.(empty($this->AmoId)?'AmoId = NULL, ':'AmoId = "'.$this->AmoId.'",').'
			
			DesId = "'.($this->DesId ).'"

			WHERE DcoId = "'.($this->DcoId).'";';
			
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