<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAlmacen
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAlmacen {

    public $AlmId;
    public $AlmNombre;
	
	public $AlmDireccion;
	public $AlmDistrito;
	public $AlmProvincia;
	public $AlmDepartamento;
	public $AlmCodigoUbigeo;
	
	public $AlmEstado;
    public $AlmTiempoCreacion;
    public $AlmTiempoModificacion;
    public $AlmEliminado;

	// Propiedades adicionales para evitar warnings
	public $SucId;
	public $AlmSigla;

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
	

	public function MtdGenerarAlmacenId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(AlmId,5),unsigned)) AS "MAXIMO"
			FROM tblalmalmacen';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->AlmId ="ALM-10000";

			}else{
				$fila['MAXIMO']++;
				$this->AlmId = "ALM-".$fila['MAXIMO'];					
			}		
			
					
		}
		
    public function MtdObtenerAlmacen(){

        $sql = 'SELECT 
        alm.AlmId,
		alm.SucId,
		
		alm.AlmNombre,
		alm.AlmSigla,
		
		alm.AlmDireccion,
		alm.AlmDistrito,
		alm.AlmProvincia,
		alm.AlmDepartamento,
		alm.AlmCodigoUbigeo,
		
		alm.AlmEstado,
		DATE_FORMAT(alm.AlmTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAlmTiempoCreacion",
        DATE_FORMAT(alm.AlmTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAlmTiempoModificacion"
        FROM tblalmalmacen alm
        WHERE alm.AlmId = "'.$this->AlmId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->AlmId = $fila['AlmId'];
			$this->SucId = $fila['SucId'];
			
            $this->AlmNombre = $fila['AlmNombre'];
			$this->AlmSigla = $fila['AlmSigla'];
			
			$this->AlmDireccion = $fila['AlmDireccion'];
			$this->AlmDistrito = $fila['AlmDistrito'];
			$this->AlmProvincia = $fila['AlmProvincia'];
			$this->AlmDepartamento = $fila['AlmDepartamento'];
			$this->AlmCodigoUbigeo = $fila['AlmCodigoUbigeo'];
			
			$this->AlmEstado = $fila['AlmEstado'];
			$this->AlmTiempoCreacion = $fila['NAlmTiempoCreacion'];
			$this->AlmTiempoModificacion = $fila['NAlmTiempoModificacion']; 
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
		return $Respuesta;

    }

    public function MtdObtenerAlmacenes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AlmId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL) {

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$sucursal = '';

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
		
		if(!empty($oSucursal)){
			$sucursal = ' AND alm.SucId = "'.($oSucursal).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				alm.AlmId,
				alm.SucId,
				
				alm.AlmNombre,
				alm.AlmSigla,
				
				alm.AlmDireccion,
				alm.AlmDistrito,
				alm.AlmProvincia,
				alm.AlmDepartamento,
				alm.AlmCodigoUbigeo,

				alm.AlmEstado,
				DATE_FORMAT(alm.AlmTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAlmTiempoCreacion",
                DATE_FORMAT(alm.AlmTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAlmTiempoModificacion",
				
				suc.SucNombre
				
				FROM tblalmalmacen alm
					LEFT JOIN tblsucsucursal suc
					ON alm.SucId = suc.SucId
					
				WHERE 1 = 1'.$filtrar.$sucursal.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();

            $InsAlmacen = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Almacen = new $InsAlmacen();
                    $Almacen->AlmId = $fila['AlmId'];
					$Almacen->SucId = $fila['SucId'];
					
                    $Almacen->AlmNombre= $fila['AlmNombre'];
					$Almacen->AlmSigla= $fila['AlmSigla'];
					
					 $Almacen->AlmDireccion= $fila['AlmDireccion'];
					  $Almacen->AlmDistrito= $fila['AlmDistrito'];
					   $Almacen->AlmProvincia= $fila['AlmProvincia'];
					    $Almacen->AlmDepartamento= $fila['AlmDepartamento'];
						$Almacen->AlmCodigoUbigeo= $fila['AlmCodigoUbigeo'];
					
	
					 $Almacen->AlmEstado = $fila['AlmEstado'];
                    $Almacen->AlmTiempoCreacion = $fila['NAlmTiempoCreacion'];
                    $Almacen->AlmTiempoModificacion = $fila['NAlmTiempoModificacion'];  
					   
					$Almacen->SucNombre = $fila['SucNombre'];                   
					
					$Respuesta['Datos'][]= $Almacen;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal ? $filaTotal['TOTAL'] : 0;
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarAlmacen($oElementos) {
		
		// Inicializar variable
		$eliminar = '';
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (AlmId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (AlmId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblalmalmacen WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarAlmacen() {
	
		$this->MtdGenerarAlmacenId();
			
		
			$sql = 'INSERT INTO tblalmalmacen (
				AlmId,
				SucId,
				
				AlmNombre, 
				AlmSigla,
				
				AlmDireccion,
					
				AlmDistrito,
				AlmProvincia,
				AlmDepartamento,
				AlmCodigoUbigeo,
				
				AlmEstado,
				AlmTiempoCreacion,
				AlmTiempoModificacion
				) 
				VALUES (
				"'.($this->AlmId).'", 
				"'.($this->SucId).'", 
				
				"'.htmlentities($this->AlmNombre).'", 
				"'.($this->AlmSigla).'", 
				
				"'.htmlentities($this->AlmDireccion).'", 
				
				"'.htmlentities($this->AlmDistrito).'", 
				"'.htmlentities($this->AlmProvincia).'", 
				"'.htmlentities($this->AlmDepartamento).'", 
				"'.($this->AlmCodigoUbigeo).'", 
		
				'.($this->AlmEstado).', 
				"'.($this->AlmTiempoCreacion).'", 
				"'.($this->AlmTiempoModificacion).'"				
				);';	
				
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
	
	public function MtdEditarAlmacen() {
				
		$sql = 'UPDATE tblalmalmacen SET 
		 SucId = "'.($this->SucId).'",
			 AlmNombre = "'.($this->AlmNombre).'",
			 AlmSigla = "'.($this->AlmSigla).'",
			 AlmNombre = "'.($this->AlmNombre).'",
			 
			  AlmDireccion = "'.($this->AlmDireccion).'",
			  
			 AlmDistrito = "'.($this->AlmDistrito).'",
			 AlmProvincia = "'.($this->AlmProvincia).'",
			 AlmDepartamento = "'.($this->AlmDepartamento).'",
			 AlmCodigoUbigeo = "'.($this->AlmCodigoUbigeo).'",
			 
			 AlmEstado = '.($this->AlmEstado).',
			 AlmTiempoModificacion = "'.($this->AlmTiempoModificacion).'"
			 WHERE AlmId = "'.($this->AlmId).'";';
				 
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