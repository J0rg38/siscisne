<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoMarca
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoMarca {

    public $VmaId;
    public $VmaNombre;
	public $VmaNombreComercial;
	public $VmaFoto;
	public $VmaVigenciaVenta;
	public $VmaEstado;
    public $VmaTiempoCreacion;
    public $VmaTiempoModificacion;
    public $VmaEliminado;

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
	

	public function MtdGenerarVehiculoMarcaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VmaId,5),unsigned)) AS "MAXIMO"
			FROM tblvmavehiculomarca';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VmaId ="VMA-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VmaId = "VMA-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoMarca(){

        $sql = 'SELECT 
        vma.VmaId,
        vma.VmaNombre,
		vma.VmaNombreComercial,
		vma.VmaFoto,
		vma.VmaVigenciaVenta,
		vma.VmaEstado,
		DATE_FORMAT(vma.VmaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmaTiempoCreacion",
        DATE_FORMAT(vma.VmaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmaTiempoModificacion"
        FROM tblvmavehiculomarca vma
        WHERE vma.VmaId = "'.$this->VmaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VmaId = $fila['VmaId'];
			$this->VmaNombre = $fila['VmaNombre'];
			$this->VmaNombreComercial = $fila['VmaNombreComercial'];
			$this->VmaFoto = $fila['VmaFoto'];
			
			$this->VmaVigenciaVenta = $fila['VmaVigenciaVenta'];
			$this->VmaEstado = $fila['VmaEstado'];
			$this->VmaTiempoCreacion = $fila['NVmaTiempoCreacion'];
			$this->VmaTiempoModificacion = $fila['NVmaTiempoModificacion']; 
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	public function MtdIdentificarVehiculoMarca($oFiltro){
	
		$ResVehiculoMarca = $this->MtdObtenerVehiculoMarcas("VehMarca",$oFiltro,'VmaId','Desc','1',NULL,NULL);
		$ArrVehiculoMarcas = $ResVehiculoMarca['Datos'];
		
		$VehiculoMarcaId = "";
		
		if(!empty($ArrVehiculoMarcas)){
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){

				$VehiculoMarcaId = $DatVehiculoMarca->VmaId;
				
			}
		}
		
		return $VehiculoMarcaId;
	}

    public function MtdObtenerVehiculoMarcas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVigenciaVenta=NULL,$oEstado=NULL) {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$vventa = '';
		$estado = '';

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
		
		if(!empty($oVigenciaVenta)){
			$vventa = ' AND VmaVigenciaVenta = '.$oVigenciaVenta;
		}
		
		if(!empty($oEstado)){
			$estado = ' AND VmaEstado = '.$oEstado;
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				VmaId,
				VmaNombre,
				VmaNombreComercial,
				VmaFoto,
				VmaVigenciaVenta,
				VmaEstado,
				DATE_FORMAT(VmaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmaTiempoCreacion",
                DATE_FORMAT(VmaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmaTiempoModificacion"				
				FROM tblvmavehiculomarca
				WHERE  1 = 1'.$filtrar.$vventa.$estado.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoMarca = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoMarca = new $InsVehiculoMarca();
                    $VehiculoMarca->VmaId = $fila['VmaId'];
                    $VehiculoMarca->VmaNombre = $fila['VmaNombre'];
					$VehiculoMarca->VmaNombreComercial = $fila['VmaNombreComercial'];
					$VehiculoMarca->VmaFoto = $fila['VmaFoto'];
					
					$VehiculoMarca->VmaVigenciaVenta = $fila['VmaVigenciaVenta'];
					$VehiculoMarca->VmaEstado = $fila['VmaEstado'];
                    $VehiculoMarca->VmaTiempoCreacion = $fila['NVmaTiempoCreacion'];
                    $VehiculoMarca->VmaTiempoModificacion = $fila['NVmaTiempoModificacion'];
					$VehiculoMarca->InsMysql = NULL;      
					$Respuesta['Datos'][]= $VehiculoMarca;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal ? $filaTotal['TOTAL'] : 0;
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoMarca($oElementos) {
		
		// Inicializar variable para evitar warnings
		$eliminar = '';
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' VmaId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VmaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VmaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblvmavehiculomarca WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarVehiculoMarca() {
	
		$this->MtdGenerarVehiculoMarcaId();
			
			$sql = 'INSERT INTO tblvmavehiculomarca (
				VmaId,
				VmaNombre, 
				VmaNombreComercial,
				VmaFoto,
				VmaVigenciaVenta,
				VmaEstado,
				VmaTiempoCreacion,
				VmaTiempoModificacion) 
				VALUES (
				"'.($this->VmaId).'", 
				"'.($this->VmaNombre).'", 
				"'.($this->VmaNombreComercial).'", 
				"'.($this->VmaFoto).'", 
				'.($this->VmaVigenciaVenta).', 
				'.($this->VmaEstado).', 
				"'.($this->VmaTiempoCreacion).'", 
				"'.($this->VmaTiempoModificacion).'");';	
				
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
	
	public function MtdEditarVehiculoMarca() {
		
			$sql = 'UPDATE tblvmavehiculomarca SET 
				 VmaNombre = "'.($this->VmaNombre).'",
				 VmaNombreComercial = "'.($this->VmaNombreComercial).'",
				 VmaFoto = "'.($this->VmaFoto).'",
				 VmaVigenciaVenta = '.($this->VmaVigenciaVenta).',
				 VmaEstado = '.($this->VmaEstado).',
				 VmaTiempoModificacion = "'.($this->VmaTiempoModificacion).'"
				 WHERE VmaId = "'.($this->VmaId).'";';
				 
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
		
	
	
 
 
 
 
 
 	 //public function MtdIdentificarVehiculoMarca(){
//		
//        $sql = 'SELECT 
//        VmaId
//        FROM tblvmavehiculomarca
//        WHERE VmaNombre = "'.htmlentities($this->VmaNombre).'"';
//		
//        $resultado = $this->InsMysql->MtdConsultar($sql);
//
//		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
//		
//			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
//			{
//				$this->VmaId = $fila['VmaId'];
//			}
//        
//			$Respuesta =  $this;
//			
//		}else{
//			$Respuesta =   NULL;
//		}
//		
//        
//		return $Respuesta;
//
//    }
	
	
}
?>