<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFacturaExportacionTalonario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFacturaExportacionTalonario {

    public $FetId;

    public $FetNumero;
	public $FetInicio;
    public $FetTiempoCreacion;
    public $FetTiempoModificacion;
    public $FetEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarFacturaExportacionTalonarioId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FetId,5),unsigned)) AS "MAXIMO"
		FROM tblfetfacturaexportaciontalonario';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FetId = "FET-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FetId = "FET-".$fila['MAXIMO'];					
		}

	}
		
    public function MtdObtenerFacturaExportacionTalonario(){

        $sql = 'SELECT 
        FetId,
	
        FetNumero,
		FetInicio,
		DATE_FORMAT(FetTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFetTiempoCreacion",
        DATE_FORMAT(FetTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFetTiempoModificacion"	
        FROM tblfetfacturaexportaciontalonario
        WHERE FetId = "'.$this->FetId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->FetId = $fila['FetId'];
			
            $this->FetNumero = $fila['FetNumero'];
			$this->FetInicio = $fila['FetInicio'];
			$this->FetTiempoCreacion = $fila['NFetTiempoCreacion'];
			$this->FetTiempoModificacion = $fila['NFetTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerFacturaExportacionTalonarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FetId',$oSentido = 'Desc',$oPaginacion = '0,10') {

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
				FetId,
			
				FetNumero,
				FetInicio,
				DATE_FORMAT(FetTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFetTiempoCreacion",
                DATE_FORMAT(FetTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFetTiempoModificacion"				
				FROM tblfetfacturaexportaciontalonario
				WHERE  1 = 1 '.$filtrar.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFacturaExportacionTalonario = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$FacturaExportacionTalonario = new $InsFacturaExportacionTalonario();
                    $FacturaExportacionTalonario->FetId = $fila['FetId'];
					
                    $FacturaExportacionTalonario->FetNumero= $fila['FetNumero'];
					$FacturaExportacionTalonario->FetInicio= $fila['FetInicio'];
					
                    $FacturaExportacionTalonario->FetTiempoCreacion = $fila['NFetTiempoCreacion'];
                    $FacturaExportacionTalonario->FetTiempoModificacion = $fila['NFetTiempoModificacion'];                   
                    $FacturaExportacionTalonario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FacturaExportacionTalonario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		

	
	//Accion eliminar	 
	
	public function MtdEliminarFacturaExportacionTalonario($oElementos) {
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (FetId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FetId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
			
			$sql = 'DELETE FROM tblfetfacturaexportaciontalonario WHERE '.$eliminar;
		
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
	
	
	public function MtdRegistrarFacturaExportacionTalonario() {
	
			$this->MtdGenerarFacturaExportacionTalonarioId();
		
			$sql = 'INSERT INTO tblfetfacturaexportaciontalonario (
			FetId,
			
			FetNumero,
		  	FetInicio ,
			FetTiempoCreacion,
			FetTiempoModificacion
			) 
			VALUES (
			"'.($this->FetId).'", 
				
			"'.($this->FetNumero).'", 
			"'.($this->FetInicio).'", 
			
			"'.($this->FetTiempoCreacion).'", 
			"'.($this->FetTiempoModificacion).'");';					

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
	
	public function MtdEditarFacturaExportacionTalonario() {
		
			$sql = 'UPDATE tblfetfacturaexportaciontalonario SET 
			 FetNumero = "'.($this->FetNumero).'",
			 FetInicio = "'.($this->FetInicio).'",
			 FetTiempoModificacion = "'.($this->FetTiempoModificacion).'"
			 WHERE FetId = "'.($this->FetId).'";';
			
		
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