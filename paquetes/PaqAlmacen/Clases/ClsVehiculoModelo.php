<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoModelo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoModelo {

    public $VmoId;
	public $VmaId;
	public $VtiId;
    public $VmoNombre;
	public $VmoNombreComercial;
	public $VmoVigenciaVenta;
	
	public $VmoPlanMantenimiento;
	public $VmoEstado;
    public $VmoTiempoCreacion;
    public $VmoTiempoModificacion;
    public $VmoEliminado;
	
	public $VmoFoto;
	public $VmoFotoCaracteristica;
	public $VmaNombre;
	public $VtiNombre;
	
	public $VehiculoModeloCaracteristica;
	
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
	

	public function MtdGenerarVehiculoModeloId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VmoId,5),unsigned)) AS "MAXIMO"
			FROM tblvmovehiculomodelo';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VmoId ="VMO-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VmoId = "VMO-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoModelo(){

        $sql = 'SELECT 
        vmo.VmoId,
		vmo.VmaId,
		vmo.VtiId,
        vmo.VmoNombre,
		vmo.VmoFoto,
		vmo.VmoFotoCaracteristica,
		
		vmo.VmoNombreComercial,
		
		vmo.VmoVigenciaVenta,
		
		CASE
		WHEN EXISTS (
			SELECT 
			pma.PmaId
			FROM tblpmaplanmantenimiento pma
		WHERE 
			pma.VmoId = vmo.VmoId
		LIMIT 1
		) THEN "Si"
		ELSE "No"
		END AS VmoPlanMantenimiento,
		
		vmo.VmoEstado,
		DATE_FORMAT(vmo.VmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmoTiempoCreacion",
        DATE_FORMAT(vmo.VmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmoTiempoModificacion"
        FROM tblvmovehiculomodelo vmo
        WHERE vmo.VmoId = "'.$this->VmoId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			
			
			$this->VmoId = $fila['VmoId'];
			$this->VmaId = $fila['VmaId'];
			$this->VtiId = $fila['VtiId'];
			$this->VmoNombre = $fila['VmoNombre'];
			$this->VmoNombreComercial = $fila['VmoNombreComercial'];
			$this->VmoVigenciaVenta = $fila['VmoVigenciaVenta'];
			$this->VmoFoto = $fila['VmoFoto'];
			$this->VmoFotoCaracteristica = $fila['VmoFotoCaracteristica'];
			
		
			$this->VmoPlanMantenimiento = $fila['VmoPlanMantenimiento'];
			$this->VmoEstado = $fila['VmoEstado'];
			$this->VmoTiempoCreacion = $fila['NVmoTiempoCreacion'];
			$this->VmoTiempoModificacion = $fila['NVmoTiempoModificacion']; 
			
//			$InsVehiculoModeloCaracteristica = new ClsVehiculoModeloCaracteristica();
//			$ResVehiculoModeloCaracteristica = $InsVehiculoModeloCaracteristica-> MtdObtenerVehiculoModeloCaracteristicas(NULL,NULL,'VmcId','Desc',NULL,$fila['VmoId']);
//			$this->VehiculoModeloCaracteristica = $ResVehiculoModeloCaracteristica['Datos'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	public function MtdIdentificarVehiculoModelo($oFiltro){
	
		$ResVehiculoModelo = $this->MtdObtenerVehiculoModelos("VehModelo",$oFiltro,'VmoId','Desc','1',NULL,NULL);
		$ArrVehiculoModelos = $ResVehiculoModelo['Datos'];
		
		$VehiculoModeloId = "";
		
		if(!empty($ArrVehiculoModelos)){
			foreach($ArrVehiculoModelos as $DatVehiculoModelo){

				$VehiculoModeloId = $DatVehiculoModelo->VmoId;
				
			}
		}
		
		return $VehiculoModeloId;
	}

    public function MtdObtenerVehiculoModelos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$vmarca = '';
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
		
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.($oVehiculoMarca).'"';
		}
		
		if(!empty($oVigenciaVenta)){
			$vventa = ' AND vmo.VmoVigenciaVenta = '.$oVigenciaVenta;
		}
		
		if(!empty($oEstado)){
			$estado = ' AND vmo.VmoEstado = '.$oEstado;
		}


			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vmo.VmoId,
				vmo.VmaId,
				
				vmo.VtiId,
				vmo.VmoNombre,
				vmo.VmoNombreComercial,
				vmo.VmoVigenciaVenta,
				
				
			
			
			vmo.VmoFoto,
		vmo.VmoFotoCaracteristica,
				vmo.VmoEstado,
				DATE_FORMAT(vmo.VmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmoTiempoCreacion",
                DATE_FORMAT(vmo.VmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmoTiempoModificacion",

				vma.VmaNombre,
				vti.VtiNombre
				
				FROM tblvmovehiculomodelo vmo
					LEFT JOIN tblvmavehiculomarca vma
					ON vmo.VmaId = vma.VmaId
						LEFT JOIN tblvtivehiculotipo vti
						ON vmo.VtiId = vti.VtiId
				WHERE  1 = 1 '.$filtrar.$vmarca.$vventa.$estado.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoModelo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoModelo = new $InsVehiculoModelo();
                    $VehiculoModelo->VmoId = $fila['VmoId'];
					$VehiculoModelo->VmaId = $fila['VmaId'];
					$VehiculoModelo->VtiId = $fila['VtiId'];
                    $VehiculoModelo->VmoNombre = $fila['VmoNombre'];
					$VehiculoModelo->VmoNombreComercial = $fila['VmoNombreComercial'];
					$VehiculoModelo->VmoVigenciaVenta = $fila['VmoVigenciaVenta'];
					
					
					
					$VehiculoModelo->VmoFoto = $fila['VmoFoto'];
					$VehiculoModelo->VmoFotoCaracteristica = $fila['VmoFotoCaracteristica'];
					
			
		
					$VehiculoModelo->VmoEstado = $fila['VmoEstado'];
                    $VehiculoModelo->VmoTiempoCreacion = $fila['NVmoTiempoCreacion'];
                    $VehiculoModelo->VmoTiempoModificacion = $fila['NVmoTiempoModificacion'];

					$VehiculoModelo->VmaNombre = $fila['VmaNombre'];
					$VehiculoModelo->VtiNombre = $fila['VtiNombre'];
					
					$VehiculoModelo->InsMysql = NULL;      
					$Respuesta['Datos'][]= $VehiculoModelo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal ? $filaTotal['TOTAL'] : 0;
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoModelo($oElementos) {
		
		// Inicializar variable para evitar warnings
		$eliminar = '';
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' VmoId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VmoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VmoId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblvmovehiculomodelo WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarVehiculoModelo() {
	
		global $Resultado;
		
		$this->MtdGenerarVehiculoModeloId();
			
			$sql = 'INSERT INTO tblvmovehiculomodelo (
				VmoId,
				VmaId,
				VtiId,
				VmoNombre, 
				VmoNombreComercial,
				VmoVigenciaVenta,
				
				VmoFoto,
				VmoFotoCaracteristica,
				VmoEstado,
				VmoTiempoCreacion,
				VmoTiempoModificacion) 
				VALUES (
				"'.($this->VmoId).'", 
				"'.($this->VmaId).'", 
				"'.($this->VtiId).'", 
				"'.($this->VmoNombre).'",
				"'.($this->VmoNombreComercial).'", 
				'.($this->VmoVigenciaVenta).', 
				
				"'.($this->VmoFoto).'", 
				"'.($this->VmoFotoCaracteristica).'", 
				'.($this->VmoEstado).', 
				"'.($this->VmoTiempoCreacion).'", 
				"'.($this->VmoTiempoModificacion).'");';	
				
			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		

//			if(!$error){		
//			
//				if (!empty($this->VehiculoModeloCaracteristica)){		
//				
//					$validar = 0;				
//					$InsVehiculoModeloCaracteristica = new ClsVehiculoModeloCaracteristica();		
//							
//					foreach ($this->VehiculoModeloCaracteristica as $DatVehiculoModeloCaracteristica){
//						$InsVehiculoModeloCaracteristica->VmoId = $this->VmoId;
//						$InsVehiculoModeloCaracteristica->VcaId = $DatVehiculoModeloCaracteristica->VcaId;
//						$InsVehiculoModeloCaracteristica->VmcValor = $DatVehiculoModeloCaracteristica->VmcValor;
//						$InsVehiculoModeloCaracteristica->VmcTiempoCreacion = $DatVehiculoModeloCaracteristica->VmcTiempoCreacion;
//						$InsVehiculoModeloCaracteristica->VmcTiempoModificacion = $DatVehiculoModeloCaracteristica->VmcTiempoModificacion;
//						
//						if($InsVehiculoModeloCaracteristica->MtdRegistrarVehiculoModeloCaracteristica()){
//									$validar++;					
//						}else{
//							$Resultado.='#ERR_VMO_201';
//							$Resultado.='#Item Numero: '.($validar+1);	
//						}
//										
//					}					
//					
//					if(count($this->VehiculoModeloCaracteristica) <> $validar ){
//						$error = true;
//					}	
//					
//				}
//				
//			}
			
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
			
	}
	
	public function MtdEditarVehiculoModelo() {
		
		global $Resultado;
		
			$sql = 'UPDATE tblvmovehiculomodelo SET 
				VmaId = "'.($this->VmaId).'",
				VtiId = "'.($this->VtiId).'",
				VmoNombre = "'.($this->VmoNombre).'",
				VmoNombreComercial = "'.($this->VmoNombreComercial).'",
				
				VmoVigenciaVenta = '.($this->VmoVigenciaVenta).',
				
				VmoFoto = "'.($this->VmoFoto).'",
				VmoFotoCaracteristica = "'.($this->VmoFotoCaracteristica).'",
			
				VmoEstado = '.($this->VmoEstado).',
				VmoTiempoModificacion = "'.($this->VmoTiempoModificacion).'"
				WHERE VmoId = "'.($this->VmoId).'";';
				 
			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);       
			
			if(!$resultado) {						
				$error = true;
			} 		
			
					
			
//			if(!$error){
//				if (!empty($this->VehiculoModeloCaracteristica)){		
//
//					$validar = 0;				
//					$InsVehiculoModeloCaracteristica = new ClsVehiculoModeloCaracteristica();		
//
//					foreach ($this->VehiculoModeloCaracteristica as $DatVehiculoModeloCaracteristica){
//
//						$InsVehiculoModeloCaracteristica->VmcId = $DatVehiculoModeloCaracteristica->VmcId;
//						$InsVehiculoModeloCaracteristica->VmoId = $this->VmoId;
//						$InsVehiculoModeloCaracteristica->VcaId = $DatVehiculoModeloCaracteristica->VcaId;
//						$InsVehiculoModeloCaracteristica->VmcValor = $DatVehiculoModeloCaracteristica->VmcValor;
//						$InsVehiculoModeloCaracteristica->VmcTiempoCreacion = $DatVehiculoModeloCaracteristica->VmcTiempoCreacion;
//						$InsVehiculoModeloCaracteristica->VmcTiempoModificacion = $DatVehiculoModeloCaracteristica->VmcTiempoModificacion;
//						$InsVehiculoModeloCaracteristica->VmcEliminado = $DatVehiculoModeloCaracteristica->VmcEliminado;
//
//						if(empty($InsVehiculoModeloCaracteristica->VmcId)){
//							if($InsVehiculoModeloCaracteristica->VmcEliminado<>2){
//								if($InsVehiculoModeloCaracteristica->MtdRegistrarVehiculoModeloCaracteristica()){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_VMO_201';
//									$Resultado.='#Item Numero: '.($validar+1);	
//								}
//							}else{
//								$validar++;	
//							}
//							
//						}else{						
//							if($InsVehiculoModeloCaracteristica->VmcEliminado==2){
//								if($InsVehiculoModeloCaracteristica->MtdEliminarVehiculoModeloCaracteristica($InsVehiculoModeloCaracteristica->VmcId)){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_VMO_203';
//									$Resultado.='#Item Numero: '.($validar+1);	
//								}
//							}else{
//								if($InsVehiculoModeloCaracteristica->MtdEditarVehiculoModeloCaracteristica()){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_VMO_202';
//									$Resultado.='#Item Numero: '.($validar+1);	
//								}
//							}
//						}	
//								
//					}					
//					
//					if(count($this->VehiculoModeloCaracteristica) <> $validar ){
//						$error = true;
//					}	
//					
//				}
//			} 
			

			
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
		}	
		
	
	//
//	 public function MtdIdentificarVehiculoModelo(){
//		
//        $sql = 'SELECT 
//        VmoId
//        FROM tblvmovehiculomodelo
//        WHERE VmoNombre = "'.htmlentities($this->VmoNombre).'"';
//		
//        $resultado = $this->InsMysql->MtdConsultar($sql);
//
//		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
//		
//			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
//			{
//				$this->VmoId = $fila['VmoId'];
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
//	
//	
}
?>