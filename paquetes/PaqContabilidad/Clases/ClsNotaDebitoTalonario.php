<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsNotaDebitoTalonario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsNotaDebitoTalonario {

    public $NdtId;
    public $NdtNumero;
	public $NdtInicio;
    public $NdtTiempoCreacion;
    public $NdtTiempoModificacion;
    public $NdtEliminado;
    	public $InsMysql;
	
	// Propiedades adicionales para evitar warnings
	public $SucId;
	public $NdtDescripcion;
	public $NdtEstado;
	public $NdtEstadoDescripcion;
	public $NdtEstadoIcono;
	public $NdtMultisucursal;
	public $NdtSucursal;
	public $NdtSucursalNombre;
	public $NdtSucursalDireccion;
	public $NdtSucursalDistrito;
	public $NdtSucursalProvincia;
	public $NdtSucursalDepartamento;
	public $NdtSucursalCodigoUbigeo;

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

	public function MtdGenerarNotaDebitoTalonarioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(NdtId,5),unsigned)) AS "MAXIMO"
			FROM tblndtnotadebitotalonario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->NdtId = "NDT-10000";
			}else{
				$fila['MAXIMO']++;
				$this->NdtId = "NDT-".$fila['MAXIMO'];					
			}
			
				
		}
		
    public function MtdObtenerNotaDebitoTalonario(){

        $sql = 'SELECT 
        NdtId,
		SucId,
		
        NdtNumero,
		NdtInicio,
		NdtDescripcion,
		
		DATE_FORMAT(NdtTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdtTiempoCreacion",
        DATE_FORMAT(NdtTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNdtTiempoModificacion"	
        FROM tblndtnotadebitotalonario
        WHERE NdtId = "'.$this->NdtId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->NdtId = $fila['NdtId'];
			$this->SucId = $fila['SucId'];
			
            $this->NdtNumero = $fila['NdtNumero'];
			$this->NdtInicio = $fila['NdtInicio'];
			$this->NdtDescripcion = $fila['NdtDescripcion'];
			
			$this->NdtTiempoCreacion = $fila['NNdtTiempoCreacion'];
			$this->NdtTiempoModificacion = $fila['NNdtTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerNotaDebitoTalonarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NdtId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oMultisucursal=false) {

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
				$sucursal = ' AND (ndt.SucId = "'.$oSucursal.'" OR ndt.SucId IS NULL)';				
			}	
			
		}else{
				
			if(!empty($oSucursal)){
				$sucursal = ' AND ndt.SucId = "'.($oSucursal).'"';
			}
			
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ndt.NdtId,
				ndt.SucId,
				
				ndt.NdtNumero,
				ndt.NdtInicio,
				ndt.NdtDescripcion,
				
				DATE_FORMAT(ndt.NdtTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdtTiempoCreacion",
                DATE_FORMAT(ndt.NdtTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNdtTiempoModificacion",
				
				suc.SucNombre
				
				FROM tblndtnotadebitotalonario ndt
					LEFT JOIN tblsucsucursal suc
					ON ndt.SucId = suc.SucId
					
				WHERE  1 = 1 '.$filtrar.$sucursal.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsNotaDebitoTalonario = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$NotaDebitoTalonario = new $InsNotaDebitoTalonario();
                    $NotaDebitoTalonario->NdtId = $fila['NdtId'];
                    $NotaDebitoTalonario->SucId = $fila['SucId'];
					
                    $NotaDebitoTalonario->NdtNumero= $fila['NdtNumero'];
					$NotaDebitoTalonario->NdtInicio= $fila['NdtInicio'];
					$NotaDebitoTalonario->NdtDescripcion= $fila['NdtDescripcion'];
					
                    $NotaDebitoTalonario->NdtTiempoCreacion = $fila['NNdtTiempoCreacion'];
                    $NotaDebitoTalonario->NdtTiempoModificacion = $fila['NNdtTiempoModificacion'];                   
					
					$NotaDebitoTalonario->SucNombre = $fila['SucNombre'];                   
					
                    $NotaDebitoTalonario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $NotaDebitoTalonario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	//Accion eliminar	 
	
	public function MtdEliminarNotaDebitoTalonario($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		// Inicializar variable para evitar warnings
		$eliminar = '';
		
		if(!count($elementos)){
			$eliminar .= ' NdtId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (NdtId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (NdtId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
			
			$sql = 'DELETE FROM tblndtnotadebitotalonario WHERE '.$eliminar;
		
		
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
	
	
	public function MtdRegistrarNotaDebitoTalonario() {
	
			$this->MtdGenerarNotaDebitoTalonarioId();
		
			$sql = 'INSERT INTO tblndtnotadebitotalonario (
			NdtId,
			SucId,
			
			NdtNumero, 
			NdtInicio,
			NdtDescripcion,
			
			NdtTiempoCreacion,
			NdtTiempoModificacion
			) 
			VALUES (
			"'.($this->NdtId).'", 
			'.(empty($this->SucId)?'NULL, ':'"'.$this->SucId.'",').'
			
			"'.($this->NdtNumero).'",
			"'.($this->NdtInicio).'",
			"'.($this->NdtDescripcion).'",
			 
			"'.($this->NdtTiempoCreacion).'", 
			"'.($this->NdtTiempoModificacion).'");';					

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
	
	public function MtdEditarNotaDebitoTalonario() {
		
			$sql = 'UPDATE tblndtnotadebitotalonario SET 
			'.(empty($this->SucId)?'SucId = NULL, ':'SucId = "'.$this->SucId.'",').'
			
			 NdtNumero = "'.($this->NdtNumero).'",
			 NdtInicio = "'.($this->NdtInicio).'",
			 NdtDescripcion = "'.($this->NdtDescripcion).'",
			 NdtTiempoModificacion = "'.($this->NdtTiempoModificacion).'"
			 WHERE NdtId = "'.($this->NdtId).'";';
			
		
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