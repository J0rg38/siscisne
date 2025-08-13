<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoVersion
 *
 * @author Ing. Jonathan Blanco Alave
 */
class ClsVehiculoVersion {

    public $VveId;
	public $VmoId;
    public $VveNombre;
	public $VveVigenciaVenta;
	public $VveFoto;

	public $VveCaracteristica1;
	public $VveCaracteristica2;
	public $VveCaracteristica3;
	public $VveCaracteristica4;
	public $VveCaracteristica5;
	public $VveCaracteristica6;
	public $VveCaracteristica7;
	public $VveCaracteristica8;
	public $VveCaracteristica9;
	public $VveCaracteristica10;
	
	public $VveCaracteristica11;
	public $VveCaracteristica12;
	public $VveCaracteristica13;
	public $VveCaracteristica14;
	public $VveCaracteristica15;
	public $VveCaracteristica16;
	public $VveCaracteristica17;
	public $VveCaracteristica18;
	public $VveCaracteristica19;
	public $VveCaracteristica20;
	

	public $VveEstado;
    public $VveTiempoCreacion;
    public $VveTiempoModificacion;
    public $VveEliminado;

	public $VmoNombre;
	public $VveFotoLateral;
	public $VveFotoPosterior;
	public $VveFotoAdicional;
	public $VveFotoCaracteristica;
	public $VveArchivo;
	public $VmaId;
	public $VmaNombre;

	public $InsMysql;
	
	public $VehiculoVersionCaracteristica;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	

	public function MtdGenerarVehiculoVersionId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VveId,5),unsigned)) AS "MAXIMO"
			FROM tblvvevehiculoversion';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VveId ="VVE-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VveId = "VVE-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoVersion($oCompleto=true){

       $sql = 'SELECT 
        vve.VveId,
		vve.VmoId,
        vve.VveNombre,
		vve.VveVigenciaVenta,
		vve.VveFoto,
		vve.VveFotoLateral,
		vve.VveFotoPosterior,
		vve.VveFotoAdicional,
		vve.VveFotoCaracteristica,
		vve.VveArchivo,
		
		vve.VveCaracteristica1,
		vve.VveCaracteristica2,
		vve.VveCaracteristica3,
		vve.VveCaracteristica4,
		vve.VveCaracteristica5,
		vve.VveCaracteristica6,
		vve.VveCaracteristica7,
		vve.VveCaracteristica8,
		vve.VveCaracteristica9,
		vve.VveCaracteristica10,
		
		vve.VveCaracteristica10,
		vve.VveCaracteristica11,
		vve.VveCaracteristica12,
		vve.VveCaracteristica13,
		vve.VveCaracteristica14,
		vve.VveCaracteristica15,
		vve.VveCaracteristica16,
		vve.VveCaracteristica17,
		vve.VveCaracteristica18,
		vve.VveCaracteristica19,
		vve.VveCaracteristica20,
			
		vve.VveEstado,
		DATE_FORMAT(vve.VveTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVveTiempoCreacion",
        DATE_FORMAT(vve.VveTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVveTiempoModificacion",

		vmo.VmaId,
		
		vmo.VmoNombre
		
        FROM tblvvevehiculoversion vve
			LEFT JOIN tblvmovehiculomodelo vmo
			ON vve.VmoId = vmo.VmoId
				LEFT JOIN tblvmavehiculomarca vma
				ON vmo.VmaId = vma.VmaId
				
        WHERE vve.VveId = "'.$this->VveId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VveId = $fila['VveId'];
			$this->VmoId = $fila['VmoId'];
			$this->VveNombre = $fila['VveNombre'];
			
			$this->VveVigenciaVenta = $fila['VveVigenciaVenta'];
			
			$this->VveFoto = $fila['VveFoto'];
			$this->VveFotoLateral = $fila['VveFotoLateral'];
			$this->VveFotoPosterior = $fila['VveFotoPosterior'];
			$this->VveFotoAdicional = $fila['VveFotoAdicional'];
			$this->VveFotoCaracteristica = $fila['VveFotoCaracteristica'];
			$this->VveArchivo = $fila['VveArchivo'];

			$this->VveCaracteristica1 = $fila['VveCaracteristica1'];
			$this->VveCaracteristica2 = $fila['VveCaracteristica2'];
			$this->VveCaracteristica3 = $fila['VveCaracteristica3'];
			$this->VveCaracteristica4 = $fila['VveCaracteristica4'];
			$this->VveCaracteristica5 = $fila['VveCaracteristica5'];
			$this->VveCaracteristica6 = $fila['VveCaracteristica6'];
			$this->VveCaracteristica7 = $fila['VveCaracteristica7'];
			$this->VveCaracteristica8 = $fila['VveCaracteristica8'];
			$this->VveCaracteristica9 = $fila['VveCaracteristica9'];
			$this->VveCaracteristica10 = $fila['VveCaracteristica10'];
			
			$this->VveCaracteristica11 = $fila['VveCaracteristica11'];
			$this->VveCaracteristica12 = $fila['VveCaracteristica12'];
			$this->VveCaracteristica13 = $fila['VveCaracteristica13'];
			$this->VveCaracteristica14 = $fila['VveCaracteristica14'];
			$this->VveCaracteristica15 = $fila['VveCaracteristica15'];
			$this->VveCaracteristica16 = $fila['VveCaracteristica16'];
			$this->VveCaracteristica17 = $fila['VveCaracteristica17'];
			$this->VveCaracteristica18 = $fila['VveCaracteristica18'];
			$this->VveCaracteristica19 = $fila['VveCaracteristica19'];
			$this->VveCaracteristica20 = $fila['VveCaracteristica20'];
			
			$this->VmoNombre = $fila['VmoNombre'];
			
			$this->VveEstado = $fila['VveEstado'];
			$this->VveTiempoCreacion = $fila['NVveTiempoCreacion'];
			$this->VveTiempoModificacion = $fila['NVveTiempoModificacion']; 
			
			$this->VmaId = $fila['VmaId'];
			
			if($oCompleto){
				
				$InsVehiculoVersionCaracteristica = new ClsVehiculoVersionCaracteristica();
				$ResVehiculoVersionCaracteristica = $InsVehiculoVersionCaracteristica-> MtdObtenerVehiculoVersionCaracteristicas(NULL,NULL,'VvcId','ASC',NULL,$fila['VveId']);
				$this->VehiculoVersionCaracteristica = $ResVehiculoVersionCaracteristica['Datos'];
				
				//$InsVehiculoVersionAduanaCaracteristica = new ClsVehiculoVersionAduanaCaracteristica();
//				$ResVehiculoVersionAduanaCaracteristica = $InsVehiculoVersionAduanaCaracteristica-> MtdObtenerVehiculoVersionAduanaCaracteristicas(NULL,NULL,'VacId','ASC',NULL,$fila['VveId']);
//				$this->VehiculoVersionAduanaCaracteristica = $ResVehiculoVersionAduanaCaracteristica['Datos'];
				
			}
			
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	public function MtdIdentificarVehiculoVersion($oFiltro){
	
		$ResVehiculoVersion = $this->MtdObtenerVehiculoVersiones("VehVersion",$oFiltro,'VveId','Desc','1',NULL,NULL,NULL);
		$ArrVehiculoVersions = $ResVehiculoVersion['Datos'];
		
		$VehiculoVersionId = "";
		
		if(!empty($ArrVehiculoVersions)){
			foreach($ArrVehiculoVersions as $DatVehiculoVersion){

				$VehiculoVersionId = $DatVehiculoVersion->VveId;
				
			}
		}
		
		return $VehiculoVersionId;
	}

    public function MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$vmarca = '';
		$vmodelo = '';
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
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.($oVehiculoModelo).'"';
		}
		
		
		if(!empty($oVigenciaVenta)){
			$vventa = ' AND vve.VveVigenciaVenta = '.$oVigenciaVenta;
		}
		
		if(!empty($oEstado)){
			$estado = ' AND vve.VveEstado = '.$oEstado;
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vve.VveId,
				
				vve.VmoId,
				vve.VveNombre,
				vve.VveFoto,
				vve.VveFotoLateral,
				vve.VveFotoPosterior,
				vve.VveFotoAdicional,
				vve.VveFotoCaracteristica,
				vve.VveArchivo,
				
				vve.VveVigenciaVenta,
				
				vve.VveCaracteristica1,
				vve.VveCaracteristica2,
				vve.VveCaracteristica3,
				vve.VveCaracteristica4,
				vve.VveCaracteristica5,
				vve.VveCaracteristica6,
				vve.VveCaracteristica7,
				vve.VveCaracteristica8,
				vve.VveCaracteristica9,
				vve.VveCaracteristica10,
				
				vve.VveCaracteristica11,
				vve.VveCaracteristica12,
				vve.VveCaracteristica13,
				vve.VveCaracteristica14,
				vve.VveCaracteristica15,
				vve.VveCaracteristica16,
				vve.VveCaracteristica17,
				vve.VveCaracteristica18,
				vve.VveCaracteristica19,
				vve.VveCaracteristica20,
				
				vve.VveEstado,
				DATE_FORMAT(vve.VveTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVveTiempoCreacion",
                DATE_FORMAT(vve.VveTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVveTiempoModificacion",

				vmo.VmoNombre,
				vma.VmaNombre				
				
				FROM tblvvevehiculoversion vve
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
				WHERE  1 = 1 '.$filtrar.$vmarca.$vmodelo.$vventa.$estado.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoVersion = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoVersion = new $InsVehiculoVersion();
                    $VehiculoVersion->VveId = $fila['VveId'];
					$VehiculoVersion->VmoId = $fila['VmoId'];
                    $VehiculoVersion->VveNombre = $fila['VveNombre'];
					$VehiculoVersion->VveFoto = $fila['VveFoto'];
					$VehiculoVersion->VveFotoLateral = $fila['VveFotoLateral'];
					$VehiculoVersion->VveFotoPosterior = $fila['VveFotoPosterior'];
					$VehiculoVersion->VveFotoAdicional = $fila['VveFotoAdicional'];
					$VehiculoVersion->VveFotoCaracteristica = $fila['VveFotoCaracteristica'];
					$VehiculoVersion->VveArchivo = $fila['VveArchivo'];
					
					$VehiculoVersion->VveVigenciaVenta = $fila['VveVigenciaVenta'];
					
					$VehiculoVersion->VveCaracteristica1 = $fila['VveCaracteristica1'];
					$VehiculoVersion->VveCaracteristica2 = $fila['VveCaracteristica2'];
					$VehiculoVersion->VveCaracteristica3 = $fila['VveCaracteristica3'];
					$VehiculoVersion->VveCaracteristica4 = $fila['VveCaracteristica4'];
					$VehiculoVersion->VveCaracteristica5 = $fila['VveCaracteristica5'];
					$VehiculoVersion->VveCaracteristica6 = $fila['VveCaracteristica6'];
					$VehiculoVersion->VveCaracteristica7 = $fila['VveCaracteristica7'];
					$VehiculoVersion->VveCaracteristica8 = $fila['VveCaracteristica8'];
					$VehiculoVersion->VveCaracteristica9 = $fila['VveCaracteristica9'];
					$VehiculoVersion->VveCaracteristica10 = $fila['VveCaracteristica10'];
					
					$VehiculoVersion->VveCaracteristica11 = $fila['VveCaracteristica11'];
					$VehiculoVersion->VveCaracteristica12 = $fila['VveCaracteristica12'];
					$VehiculoVersion->VveCaracteristica13 = $fila['VveCaracteristica13'];
					$VehiculoVersion->VveCaracteristica14 = $fila['VveCaracteristica14'];
					$VehiculoVersion->VveCaracteristica15 = $fila['VveCaracteristica15'];
					$VehiculoVersion->VveCaracteristica16 = $fila['VveCaracteristica16'];
					$VehiculoVersion->VveCaracteristica17 = $fila['VveCaracteristica17'];
					$VehiculoVersion->VveCaracteristica18 = $fila['VveCaracteristica18'];
					$VehiculoVersion->VveCaracteristica19 = $fila['VveCaracteristica19'];
					$VehiculoVersion->VveCaracteristica20 = $fila['VveCaracteristica20'];
			
					$VehiculoVersion->VveEstado = $fila['VveEstado'];
                    $VehiculoVersion->VveTiempoCreacion = $fila['NVveTiempoCreacion'];
                    $VehiculoVersion->VveTiempoModificacion = $fila['NVveTiempoModificacion'];
					
					$VehiculoVersion->VmaNombre = $fila['VmaNombre'];
					$VehiculoVersion->VmoNombre = $fila['VmoNombre'];
					
					$VehiculoVersion->InsMysql = NULL;
					$Respuesta['Datos'][]= $VehiculoVersion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoVersion($oElementos) {
		
		// Inicializar variable para evitar warnings
		$eliminar = '';
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' VveId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VveId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VveId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblvvevehiculoversion WHERE '.$eliminar;
			
		
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				return true;
			}									
	}
	
	
	public function MtdRegistrarVehiculoVersion() {
	
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
	
		$this->MtdGenerarVehiculoVersionId();
			
			$sql = 'INSERT INTO tblvvevehiculoversion (
				VveId,
				VmoId,
				VveNombre, 
				VveFoto,
				
				VveFotoLateral,
				VveFotoPosterior,
				VveFotoAdicional,
				VveFotoCaracteristica,
				VveArchivo,
				
				VveVigenciaVenta,
				
				VveEstado,
				VveTiempoCreacion,
				VveTiempoModificacion) 
				VALUES (
				"'.($this->VveId).'", 
				"'.($this->VmoId).'", 
				"'.($this->VveNombre).'", 
				"'.($this->VveFoto).'", 
				"'.($this->VveFotoLateral).'", 
				"'.($this->VveFotoPosterior).'", 
				"'.($this->VveFotoAdicional).'", 
				"'.($this->VveFotoCaracteristica).'", 
				"'.($this->VveArchivo).'", 
				
				'.($this->VveVigenciaVenta).', 
				
				'.($this->VveEstado).', 
				"'.($this->VveTiempoCreacion).'", 
				"'.($this->VveTiempoModificacion).'");';	
				
				
	/*			VveCaracteristica1,
				VveCaracteristica2,
				VveCaracteristica3,
				VveCaracteristica4,
				VveCaracteristica5,
				VveCaracteristica6,
				VveCaracteristica7,
				VveCaracteristica8,
				VveCaracteristica9,
				VveCaracteristica10,
				
				VveCaracteristica11,
				VveCaracteristica12,
				VveCaracteristica13,
				VveCaracteristica14,
				VveCaracteristica15,
				VveCaracteristica16,
				VveCaracteristica17,
				VveCaracteristica18,
				VveCaracteristica19,
				VveCaracteristica20,*/								
			/*	"'.($this->VveCaracteristica1).'",
				"'.($this->VveCaracteristica2).'",
				"'.($this->VveCaracteristica3).'",
				"'.($this->VveCaracteristica4).'",
				"'.($this->VveCaracteristica5).'",
				"'.($this->VveCaracteristica6).'",
				"'.($this->VveCaracteristica7).'",
				"'.($this->VveCaracteristica8).'",
				"'.($this->VveCaracteristica9).'",
				"'.($this->VveCaracteristica10).'",
				
				"'.($this->VveCaracteristica11).'",
				"'.($this->VveCaracteristica12).'",
				"'.($this->VveCaracteristica13).'",
				"'.($this->VveCaracteristica14).'",
				"'.($this->VveCaracteristica15).'",
				"'.($this->VveCaracteristica16).'",
				"'.($this->VveCaracteristica17).'",
				"'.($this->VveCaracteristica18).'",
				"'.($this->VveCaracteristica19).'",
				"'.($this->VveCaracteristica20).'",			*/
				
				
				
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
			
			if(!$error){		
			
				if (!empty($this->VehiculoVersionCaracteristica)){		
				
					$validar = 0;				
					$InsVehiculoVersionCaracteristica = new ClsVehiculoVersionCaracteristica();		
							
					foreach ($this->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica){

						$InsVehiculoVersionCaracteristica->VveId = $this->VveId;
						$InsVehiculoVersionCaracteristica->VcsId = $DatVehiculoVersionCaracteristica->VcsId;
						$InsVehiculoVersionCaracteristica->VvcAnoModelo = $DatVehiculoVersionCaracteristica->VvcAnoModelo;
						$InsVehiculoVersionCaracteristica->VvcDescripcion = $DatVehiculoVersionCaracteristica->VvcDescripcion;
						$InsVehiculoVersionCaracteristica->VvcValor = $DatVehiculoVersionCaracteristica->VvcValor;
						$InsVehiculoVersionCaracteristica->VvcTiempoCreacion = $DatVehiculoVersionCaracteristica->VvcTiempoCreacion;
						$InsVehiculoVersionCaracteristica->VvcTiempoModificacion = $DatVehiculoVersionCaracteristica->VvcTiempoModificacion;

						if($InsVehiculoVersionCaracteristica->MtdRegistrarVehiculoVersionCaracteristica()){
									$validar++;					
						}else{
							$Resultado.='#ERR_VVE_201';
							$Resultado.='#Item Numero: '.($validar+1);	
						}
										
					}					
					
					if(count($this->VehiculoVersionCaracteristica) <> $validar ){
						$error = true;
					}	
					
				}
				
			}
				
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				return true;
			}				
			
	}
	
	public function MtdEditarVehiculoVersion() {

		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		
			$sql = 'UPDATE tblvvevehiculoversion SET 
				VmoId = "'.($this->VmoId).'",
				VveNombre = "'.($this->VveNombre).'",
				VveFoto = "'.($this->VveFoto).'",
				
				VveFotoLateral = "'.($this->VveFotoLateral).'",
				VveFotoPosterior = "'.($this->VveFotoPosterior).'",
				VveFotoAdicional = "'.($this->VveFotoAdicional).'",
				VveFotoCaracteristica = "'.($this->VveFotoCaracteristica).'",
				VveArchivo = "'.($this->VveArchivo).'",
				
				VveVigenciaVenta = '.($this->VveVigenciaVenta).',
				
				VveEstado = '.($this->VveEstado).',
				VveTiempoModificacion = "'.($this->VveTiempoModificacion).'"
				WHERE VveId = "'.($this->VveId).'";';
/*

	VveCaracteristica1 = "'.($this->VveCaracteristica1).'",
				VveCaracteristica2 = "'.($this->VveCaracteristica2).'",
				VveCaracteristica3 = "'.($this->VveCaracteristica3).'",
				VveCaracteristica4 = "'.($this->VveCaracteristica4).'",
				VveCaracteristica5 = "'.($this->VveCaracteristica5).'",
				VveCaracteristica6 = "'.($this->VveCaracteristica6).'",
				VveCaracteristica7 = "'.($this->VveCaracteristica7).'",
				VveCaracteristica8 = "'.($this->VveCaracteristica8).'",
				VveCaracteristica9 = "'.($this->VveCaracteristica9).'",
				VveCaracteristica10 = "'.($this->VveCaracteristica10).'",
				
				VveCaracteristica11 = "'.($this->VveCaracteristica11).'",
				VveCaracteristica12 = "'.($this->VveCaracteristica12).'",
				VveCaracteristica13 = "'.($this->VveCaracteristica13).'",
				VveCaracteristica14 = "'.($this->VveCaracteristica14).'",
				VveCaracteristica15 = "'.($this->VveCaracteristica15).'",
				VveCaracteristica16 = "'.($this->VveCaracteristica16).'",
				VveCaracteristica17 = "'.($this->VveCaracteristica17).'",
				VveCaracteristica18 = "'.($this->VveCaracteristica18).'",
				VveCaracteristica19 = "'.($this->VveCaracteristica19).'",
				VveCaracteristica20 = "'.($this->VveCaracteristica20).'",
				
				*/
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

			if(!$resultado) {						
				$error = true;
			}

			//deb($this->VehiculoVersionCaracteristica);
			if(!$error){
				if (!empty($this->VehiculoVersionCaracteristica)){		

					$validar = 0;				
					$InsVehiculoVersionCaracteristica = new ClsVehiculoVersionCaracteristica();		

					foreach ($this->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica){

						$InsVehiculoVersionCaracteristica->VvcId = $DatVehiculoVersionCaracteristica->VvcId;
						$InsVehiculoVersionCaracteristica->VveId = $this->VveId;
						$InsVehiculoVersionCaracteristica->VcsId = $DatVehiculoVersionCaracteristica->VcsId;
						
						$InsVehiculoVersionCaracteristica->VvcAnoModelo = $DatVehiculoVersionCaracteristica->VvcAnoModelo;
						$InsVehiculoVersionCaracteristica->VvcDescripcion = $DatVehiculoVersionCaracteristica->VvcDescripcion;
						$InsVehiculoVersionCaracteristica->VvcValor = $DatVehiculoVersionCaracteristica->VvcValor;
						$InsVehiculoVersionCaracteristica->VvcTiempoCreacion = $DatVehiculoVersionCaracteristica->VvcTiempoCreacion;
						
						$InsVehiculoVersionCaracteristica->VvcTiempoModificacion = $DatVehiculoVersionCaracteristica->VvcTiempoModificacion;
						$InsVehiculoVersionCaracteristica->VvcEliminado = $DatVehiculoVersionCaracteristica->VvcEliminado;

						if(empty($InsVehiculoVersionCaracteristica->VvcId)){
							if($InsVehiculoVersionCaracteristica->VvcEliminado<>2){
								if($InsVehiculoVersionCaracteristica->MtdRegistrarVehiculoVersionCaracteristica()){
									$validar++;					
								}else{
									$Resultado.='#ERR_VVE_201';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								$validar++;	
							}
							
						}else{						
							if($InsVehiculoVersionCaracteristica->VvcEliminado==2){
								if($InsVehiculoVersionCaracteristica->MtdEliminarVehiculoVersionCaracteristica($InsVehiculoVersionCaracteristica->VvcId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VVE_203';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								if($InsVehiculoVersionCaracteristica->MtdEditarVehiculoVersionCaracteristica()){
									$validar++;					
								}else{
									$Resultado.='#ERR_VVE_202';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}
						}	
								
					}					
					
					if(count($this->VehiculoVersionCaracteristica) <> $validar ){
						$error = true;
					}	
					
				}
			} 
			

			
			
			
			
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				return true;
			}						
				
		}	
		
	
	
	// public function MtdIdentificarVehiculoVersion(){
//		
//        $sql = 'SELECT 
//        VveId
//        FROM tblvvevehiculoversion
//        WHERE VveNombre = "'.htmlentities($this->VveNombre).'"';
//		
//        $resultado = $this->InsMysql->MtdConsultar($sql);
//
//		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
//		
//			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
//			{
//				$this->VveId = $fila['VveId'];
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
	
	
	public function MtdEditarVehiculoVersionDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblvvevehiculoversion SET 
			'.$oCampo.' = "'.($oDato).'",
			VveTiempoModificacion = NOW()
			WHERE VveId = "'.($oId).'";';
			
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