<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsIngresoDestino
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsIngresoDestino {

    public $IdeId;
    public $IngId;
    public $CliId;
	public $PrvId;
	public $PadId;

	public $IdeEstado;	
    public $IdeTiempoCreacion;
    public $IdeTiempoModificacion;
    public $IdeEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarIngresoDestinoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(IdeId,5),unsigned)) AS "MAXIMO"
		FROM tblideingresodestino';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->IdeId = "IDE-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->IdeId = "IDE-".$fila['MAXIMO'];					
		}	
				
	}
		
    public function MtdObtenerIngresoDestino(){

        $sql = 'SELECT 
        dde.IdeId,
		dde.IngId,
		dde.CliId,
		dde.PrvId,
		dde.PadId

        FROM tblideingresodestino dde
        WHERE IdeId = "'.$this->IdeId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->IdeId = $fila['IdeId'];
			$this->IngId = $fila['IngId'];
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

    public function MtdObtenerIngresoDestinos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'IdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oIngreso=NULL) {

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

		
		if(!empty($oIngreso)){
			$desembolso = ' AND dde.IngId = "'.$oIngreso.'"';
		}
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				dde.IdeId,
				dde.IngId,
				dde.CliId,
				dde.PrvId,
				dde.PadId,
				

				prv.PrvNombreCompleto,
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.PrvNumeroDocumento,
				prv.TdoId
				
				FROM tblideingresodestino dde
					LEFT JOIN tblprvproveedor prv
					ON dde.PrvId =  prv.PrvId
					
							
				WHERE 1 = 1 '.$filtrar.$desembolso.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsIngresoDestino = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$IngresoDestino = new $InsIngresoDestino();				
					
                    $IngresoDestino->IdeId = $fila['IdeId'];
					$IngresoDestino->IngId= $fila['IngId'];
					$IngresoDestino->CliId = $fila['CliId'];
					$IngresoDestino->PrvId = $fila['PrvId'];
					$IngresoDestino->PadId = $fila['PadId'];
					
					$IngresoDestino->PrvNombreCompleto = $fila['PrvNombreCompleto'];
					$IngresoDestino->PrvNombre = $fila['PrvNombre'];
					$IngresoDestino->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$IngresoDestino->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$IngresoDestino->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
					$IngresoDestino->TdoId = $fila['TdoId'];

                    $IngresoDestino->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $IngresoDestino;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarIngresoDestino($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (IdeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (IdeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblideingresodestino WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarIngresoDestino() {
	//deb($this);
		//	deb($this->IngId." aa");
			$this->MtdGenerarIngresoDestinoId();
		
			$sql = 'INSERT INTO tblideingresodestino (
			IdeId,
			
			CliId,
			PrvId,
			PadId,
			
			IngId
			) 
			VALUES (
			"'.($this->IdeId).'", 
			
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			'.(empty($this->PadId)?'NULL, ':'"'.$this->PadId.'",').'
			
			"'.($this->IngId).'");';					

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
	
	public function MtdEditarIngresoDestino() {
		

			$sql = 'UPDATE tblideingresodestino SET		

			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			'.(empty($this->PadId)?'PadId = NULL, ':'PadId = "'.$this->PadId.'",').'

			IngId = "'.($this->IngId ).'"

			WHERE IdeId = "'.($this->IdeId).'";';
			
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