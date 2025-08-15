<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFacturaTalonario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFacturaTalonario {

    public $FtaId;

    public $FtaNumero;
	public $FtaInicio;
	
	public $FtaDescripcion;
    public $FtaTiempoCreacion;
    public $FtaTiempoModificacion;
    public $FtaEliminado;
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

	public function MtdGenerarFacturaTalonarioId() {

		
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FtaId,5),unsigned)) AS "MAXIMO"
			FROM tblftafacturatalonario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FtaId = "FTA-10000";
			}else{
				$fila['MAXIMO']++;
				$this->FtaId = "FTA-".$fila['MAXIMO'];					
			}
			
				
		}
		
    public function MtdObtenerFacturaTalonario(){

        $sql = 'SELECT 
        FtaId,
		SucId,
		
        FtaNumero,
		FtaInicio,
		FtaDescripcion,
		DATE_FORMAT(FtaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFtaTiempoCreacion",
        DATE_FORMAT(FtaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFtaTiempoModificacion"	
        FROM tblftafacturatalonario
        WHERE FtaId = "'.$this->FtaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->FtaId = $fila['FtaId'];
			$this->SucId = $fila['SucId'];
			
            $this->FtaNumero = $fila['FtaNumero'];
			$this->FtaInicio = $fila['FtaInicio'];
			$this->FtaDescripcion = $fila['FtaDescripcion'];
			
			$this->FtaTiempoCreacion = $fila['NFtaTiempoCreacion'];
			$this->FtaTiempoModificacion = $fila['NFtaTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerFacturaTalonarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FtaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oMultisucursal=false) {

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
		
	
		
		if($oMultisucursal){
			
			if(!empty($oSucursal)){				
				$sucursal = ' AND (fta.SucId = "'.$oSucursal.'" OR fta.SucId IS NULL)';				
			}	
			
		}else{
				
			if(!empty($oSucursal)){
				$sucursal = ' AND fta.SucId = "'.($oSucursal).'"';
			}
			
		}

			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fta.FtaId,
				fta.SucId,
				
				fta.FtaNumero,
				fta.FtaInicio,
				fta.FtaDescripcion,
				
				DATE_FORMAT(fta.FtaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFtaTiempoCreacion",
                DATE_FORMAT(fta.FtaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFtaTiempoModificacion",
				
				suc.SucNombre
				
				FROM tblftafacturatalonario fta
					LEFT JOIN tblsucsucursal suc
					ON fta.SucId = suc.SucId
					
				WHERE 1 = 1'.$filtrar.$sucursal.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFacturaTalonario = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$FacturaTalonario = new $InsFacturaTalonario();
                    $FacturaTalonario->FtaId = $fila['FtaId'];
					$FacturaTalonario->SucId = $fila['SucId'];
					
                    $FacturaTalonario->FtaNumero= $fila['FtaNumero'];
					$FacturaTalonario->FtaInicio= $fila['FtaInicio'];
					$FacturaTalonario->FtaDescripcion= $fila['FtaDescripcion'];
					
                    $FacturaTalonario->FtaTiempoCreacion = $fila['NFtaTiempoCreacion'];
                    $FacturaTalonario->FtaTiempoModificacion = $fila['NFtaTiempoModificacion'];  
					$FacturaTalonario->SucNombre = $fila['SucNombre'];  
					
					                 
                    $FacturaTalonario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FacturaTalonario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}


	//Accion eliminar	 
	
	public function MtdEliminarFacturaTalonario($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (FtaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FtaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			
			$sql = 'DELETE FROM tblftafacturatalonario WHERE '.$eliminar;
		
		
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
	
	
	public function MtdRegistrarFacturaTalonario() {
	
			$this->MtdGenerarFacturaTalonarioId();
		
			$sql = 'INSERT INTO tblftafacturatalonario (
			FtaId,
			SucId,
			
			FtaNumero, 
			FtaInicio,
			FtaDescripcion,
			
			FtaTiempoCreacion,
			FtaTiempoModificacion
			) 
			VALUES (
			"'.($this->FtaId).'", 
			'.(empty($this->SucId)?'NULL, ':'"'.$this->SucId.'",').'
			
			"'.($this->FtaNumero).'",
			"'.($this->FtaInicio).'",
			 "'.($this->FtaDescripcion).'", 
			 
			"'.($this->FtaTiempoCreacion).'", 
			"'.($this->FtaTiempoModificacion).'");';					

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
	
	public function MtdEditarFacturaTalonario() {
		
			$sql = 'UPDATE tblftafacturatalonario SET 
			'.(empty($this->SucId)?'SucId = NULL, ':'SucId = "'.$this->SucId.'",').'
			
			 FtaNumero = "'.($this->FtaNumero).'",
			 FtaInicio = "'.($this->FtaInicio).'",
			 FtaDescripcion = "'.($this->FtaDescripcion).'",
			 FtaTiempoModificacion = "'.($this->FtaTiempoModificacion).'"
			 WHERE FtaId = "'.($this->FtaId).'";';
			
		
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