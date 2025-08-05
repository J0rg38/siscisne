<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsDesembolsoDestino
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsDesembolsoDestino {

    public $DdeId;
    public $DesId;
    public $CliId;
	public $PrvId;
	public $PadId;

	public $DdeEstado;	
    public $DdeTiempoCreacion;
    public $DdeTiempoModificacion;
    public $DdeEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarDesembolsoDestinoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(DdeId,5),unsigned)) AS "MAXIMO"
		FROM tblddedesembolsodestino';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->DdeId = "DDE-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->DdeId = "DDE-".$fila['MAXIMO'];					
		}	
				
	}
		
    public function MtdObtenerDesembolsoDestino(){

        $sql = 'SELECT 
        dde.DdeId,
		dde.DesId,
		dde.CliId,
		dde.PrvId,
		dde.PadId

        FROM tblddedesembolsodestino dde
        WHERE DdeId = "'.$this->DdeId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->DdeId = $fila['DdeId'];
			$this->DesId = $fila['DesId'];
			$this->CliId = $fila['CliId'];
			$this->PrvId = $fila['PrvId'];
			$this->PadId = $fila['PadId'];
			
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerDesembolsoDestinos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'DdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oDesembolso=NULL) {

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
			$desembolso = ' AND dde.DesId = "'.$oDesembolso.'"';
		}
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				dde.DdeId,
				dde.DesId,
				dde.CliId,
				dde.PrvId,
				dde.PadId,
				

				prv.PrvNombreCompleto,
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.PrvNumeroDocumento,
				prv.TdoId
				
				FROM tblddedesembolsodestino dde
					LEFT JOIN tblprvproveedor prv
					ON dde.PrvId =  prv.PrvId
					
							
				WHERE 1 = 1 '.$filtrar.$desembolso.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsDesembolsoDestino = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$DesembolsoDestino = new $InsDesembolsoDestino();				
					
                    $DesembolsoDestino->DdeId = $fila['DdeId'];
					$DesembolsoDestino->DesId= $fila['DesId'];
					$DesembolsoDestino->CliId = $fila['CliId'];
					$DesembolsoDestino->PrvId = $fila['PrvId'];
					$DesembolsoDestino->PadId = $fila['PadId'];
					
					$DesembolsoDestino->PrvNombreCompleto = $fila['PrvNombreCompleto'];
					$DesembolsoDestino->PrvNombre = $fila['PrvNombre'];
					$DesembolsoDestino->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$DesembolsoDestino->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$DesembolsoDestino->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
					$DesembolsoDestino->TdoId = $fila['TdoId'];

                    $DesembolsoDestino->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $DesembolsoDestino;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarDesembolsoDestino($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (DdeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (DdeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblddedesembolsodestino WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarDesembolsoDestino() {
	//deb($this);
		//	deb($this->DesId." aa");
			$this->MtdGenerarDesembolsoDestinoId();
		
			$sql = 'INSERT INTO tblddedesembolsodestino (
			DdeId,
			
			CliId,
			PrvId,
			PadId,
			
			DesId
			) 
			VALUES (
			"'.($this->DdeId).'", 
			
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			'.(empty($this->PadId)?'NULL, ':'"'.$this->PadId.'",').'
			
			"'.($this->DesId).'");';					

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
	
	public function MtdEditarDesembolsoDestino() {
		

			$sql = 'UPDATE tblddedesembolsodestino SET		

			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			'.(empty($this->PadId)?'PadId = NULL, ':'PadId = "'.$this->PadId.'",').'

			DesId = "'.($this->DesId ).'"

			WHERE DdeId = "'.($this->DdeId).'";';
			
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