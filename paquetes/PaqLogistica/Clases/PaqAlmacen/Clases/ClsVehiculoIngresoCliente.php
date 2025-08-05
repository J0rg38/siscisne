<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoIngresoCliente
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoIngresoCliente {

    public $VicId;
	public $CliId;
    public $EinId;
	public $VicEstado;
    public $VicTiempoCreacion;
    public $VicTiempoModificacion;
    public $VicEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }

	public function __destruct(){

	}

	public function MtdGenerarVehiculoIngresoClienteId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VicId,5),unsigned)) AS "MAXIMO"
			FROM tblvicvehiculoingresocliente';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VicId ="VIC-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VicId = "VIC-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoIngresoCliente(){

        $sql = 'SELECT 
        vic.VicId,
		vic.CliId,
        vic.EinId,
		vic.VicEstado,
		DATE_FORMAT(vic.VicTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVicTiempoCreacion",
        DATE_FORMAT(vic.VicTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVicTiempoModificacion"
        FROM tblvicvehiculoingresocliente vic
        WHERE vic.VicId = "'.$this->VicId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VicId = $fila['VicId'];
			$this->CliId = $fila['CliId'];
			$this->EinId = $fila['EinId'];
			$this->VicEstado = $fila['VicEstado'];
			$this->VicTiempoCreacion = $fila['NVicTiempoCreacion'];
			$this->VicTiempoModificacion = $fila['NVicTiempoModificacion']; 
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoIngresoClientes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VicId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoIngreso=NULL,$oCliente=NULL) {

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
		
		
		if(!empty($oVehiculoIngreso)){
			$vingreso = ' AND vic.EinId = "'.($oVehiculoIngreso).'"';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND vic.CliId = "'.($oCliente).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vic.VicId,
				vic.CliId,
				vic.EinId,
				
				DATE_FORMAT(vic.VicFecha, "%d/%m/%Y") AS "NVicFecha",
				
				
				vic.VicEstado,
				DATE_FORMAT(vic.VicTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVicTiempoCreacion",
                DATE_FORMAT(vic.VicTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVicTiempoModificacion",
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliNumeroDocumento,
				cli.TdoId,
				
				cli.CliTelefono,
				cli.CliCelular,
				cli.CliEmail,

				tdo.TdoNombre,
				
				ein.EinPlaca,
				ein.EinVIN,
				ein.EinColor,
				
				vve.VveNombre,
				vmo.VmoNombre,
				vma.VmaNombre,
				
				ein.EinEstado
				
				FROM tblvicvehiculoingresocliente vic
					LEFT JOIN tblclicliente cli
					ON vic.CliId  = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId	
							LEFT JOIN tbleinvehiculoingreso ein
							ON vic.EinId = ein.EinId
								LEFT JOIN tblvvevehiculoversion vve
								ON ein.VveId = vve.VveId
									LEFT JOIN tblvmovehiculomodelo vmo
									ON vve.VmoId = vmo.VmoId 
										LEFT JOIN tblvmavehiculomarca vma
										ON vmo.VmaId = vma.VmaId
				WHERE  1 = 1 '.$filtrar.$vingreso.$cliente.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoIngresoCliente = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoIngresoCliente = new $InsVehiculoIngresoCliente();
                    $VehiculoIngresoCliente->VicId = $fila['VicId'];
					$VehiculoIngresoCliente->CliId = $fila['CliId'];
                    $VehiculoIngresoCliente->EinId = $fila['EinId'];
					
					
					$VehiculoIngresoCliente->VicFecha = $fila['NVicFecha'];
					$VehiculoIngresoCliente->VicEstado = $fila['VicEstado'];
                    $VehiculoIngresoCliente->VicTiempoCreacion = $fila['NVicTiempoCreacion'];
					$VehiculoIngresoCliente->VicTiempoModificacion = $fila['NVicTiempoModificacion'];
					
					$VehiculoIngresoCliente->CliNombreCompleto = $fila['CliNombreCompleto'];
					$VehiculoIngresoCliente->CliNombre = $fila['CliNombre'];
					$VehiculoIngresoCliente->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$VehiculoIngresoCliente->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$VehiculoIngresoCliente->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$VehiculoIngresoCliente->TdoId = $fila['TdoId'];
					$VehiculoIngresoCliente->TdoNombre = $fila['TdoNombre'];
					
					$VehiculoIngresoCliente->CliTelefono = $fila['CliTelefono'];
					$VehiculoIngresoCliente->CliCelular = $fila['CliCelular'];
					$VehiculoIngresoCliente->CliEmail = $fila['CliEmail'];
					
					$VehiculoIngresoCliente->EinPlaca = $fila['EinPlaca'];
					$VehiculoIngresoCliente->EinVIN = $fila['EinVIN'];
					$VehiculoIngresoCliente->EinColor = $fila['EinColor'];
					
					$VehiculoIngresoCliente->VveNombre = $fila['VveNombre'];
					$VehiculoIngresoCliente->VmoNombre = $fila['VmoNombre'];
					$VehiculoIngresoCliente->VmaNombre = $fila['VmaNombre'];
					
					$VehiculoIngresoCliente->EinEstado = $fila['EinEstado'];
				
					switch($VehiculoIngresoCliente->EinEstado){
						
						case 1:
							$VehiculoIngresoCliente->EinEstadoDescripcion = "Activo";
						break;
						
						case 2:
							$VehiculoIngresoCliente->EinEstadoDescripcion = "Inactivo";
						break;
					}
					
					$VehiculoIngresoCliente->InsMysql = NULL;      
					$Respuesta['Datos'][]= $VehiculoIngresoCliente;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoIngresoCliente($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' VicId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VicId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VicId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblvicvehiculoingresocliente WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarVehiculoIngresoCliente() {
	
		$this->MtdGenerarVehiculoIngresoClienteId();
			
			$sql = 'INSERT INTO tblvicvehiculoingresocliente (
				VicId,
				CliId,
				EinId, 
				VicFecha,
				VicEstado,
				VicTiempoCreacion,
				VicTiempoModificacion) 
				VALUES (
				"'.($this->VicId).'", 
				"'.($this->CliId).'", 
				"'.($this->EinId).'", 
				'.(empty($this->VicFecha)?'NULL, ':'"'.$this->VicFecha.'",').'				
				'.($this->VicEstado).', 
				"'.($this->VicTiempoCreacion).'", 
				"'.($this->VicTiempoModificacion).'");';	
				
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
	
	
		public function MtdEditarVehiculoIngresoCliente() {
		
			$sql = 'UPDATE tblvicvehiculoingresocliente SET 
				CliId = "'.($this->CliId).'",
				'.(empty($this->VicFecha)?'VicFecha = NULL, ':'VicFecha = "'.$this->VicFecha.'",').'
				VicEstado = '.($this->VicEstado).',
				 
				VicTiempoModificacion = "'.($this->VicTiempoModificacion).'"
				WHERE VicId = "'.($this->VicId).'";';
				 
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
		
		


	public function MtdEditarVehiculoIngresoDato($oCampo,$oDato,$oVehiculoIngresoId) {
	
		global $Resultado;
	
		$sql = 'UPDATE tblvicvehiculoingresocliente SET 
		'.$oCampo.' = "'.($oDato).'"
		WHERE VicId = "'.($oVehiculoIngresoId).'";';
		
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

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
	

		
}
?>