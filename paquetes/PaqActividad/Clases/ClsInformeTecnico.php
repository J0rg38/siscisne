<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsInformeTecnico
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsInformeTecnico {

    public $IteId;
	public $FinId;
	public $PerId;
	
	public $IteCargo;
	public $IteConcesionario;
	public $IteSedeLocal;
	public $IteFecha;
	public $IteContactoGM;
	public $ItePlaca;
	public $ItePropietario;
	
	public $IteCondicion;
	public $IteCausa;	
	public $IteCorreccion;
	public $IteConclusion;
	
	public $IteSolucionSatisfactoria;
	
	public $IteMotor;
	public $IteTipoTransmision;
	public $IteTipoCarroceria;
	public $IteCarga;
	public $IteCiudad;
	public $IteDepartamento;
	public $IteUsoVehiculo;
	public $IteAltitud;
	
	public $MonId;
	public $IteTipoCambio;
	
	public $IteObservacion;
	public $IteEstado;
	public $IteTiempoCreacion;
	public $IteTiempoModificacion;
    public $IteEliminado;

	public $EinPlaca;
	public $EinVIN;
	public $FinVehiculoKilometraje;
	public $IteModelo;		
			
	public $VmaId;
	
    public $InsMysql;
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarInformeTecnicoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(ite.IteId,5),unsigned)) AS "MAXIMO"
		FROM tbliteinformetecnico ite;';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->IteId = "ITE-10000";
		}else{
			$fila['MAXIMO']++;
			$this->IteId = "ITE-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerInformeTecnico($oCompleto=true){

        $sql = 'SELECT 
        ite.IteId,
		ite.FinId,
		ite.PerId,
		ite.IteCargo,
		ite.IteConcesionario,
		ite.IteSedeLocal,
		DATE_FORMAT(ite.IteFecha, "%d/%m/%Y") AS "NIteFecha",
		DATE_FORMAT(ite.IteFechaVenta, "%d/%m/%Y") AS "NIteFechaVenta",
		ite.IteContactoGM,
		ite.ItePlaca,
		ite.ItePropietario,
		ite.IteCondicion,
		ite.IteCausa,
		ite.IteCorreccion,
		ite.IteConclusion,
		ite.IteSolucionSatisfactoria,
		
		ite.IteMotor,
		ite.IteTipoTransmision,
		ite.IteTipoCarroceria,
		ite.IteCarga,
		ite.IteCiudad,
		ite.IteDepartamento,
		ite.IteUsoVehiculo,
		ite.IteAltitud,


		ite.MonId,
		ite.IteTipoCambio,
		
		ite.IteObservacion,
		ite.IteEstado,
		DATE_FORMAT(ite.IteTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NIteTiempoCreacion",
        DATE_FORMAT(ite.IteTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NIteTiempoModificacion",
		
		ein.EinPlaca,
		ein.EinVIN,
		fin.FinVehiculoKilometraje,
		
		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre,
		
		ein.VmaId,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno
		
        FROM tbliteinformetecnico ite
			LEFT JOIN tblfinfichaingreso fin
			ON ite.FinId = fin.FinId
				LEFT JOIN tbleinvehiculoingreso ein
				ON fin.EinId = ein.EinId					
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId					
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId						
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per
								ON ite.PerId = per.PerId
							
								
	        WHERE ite.IteId = "'.$this->IteId.'"';

        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->IteId = $fila['IteId'];
			$this->FinId = $fila['FinId'];
			$this->PerId = $fila['PerId'];
			$this->IteCargo = $fila['IteCargo'];
			$this->IteConcesionario = $fila['IteConcesionario'];
			$this->IteSedeLocal = $fila['IteSedeLocal'];
			$this->IteFecha = $fila['NIteFecha']; 
			$this->IteFechaVenta = $fila['NIteFechaVenta']; 
			$this->IteContactoGM = $fila['IteContactoGM']; 
			$this->ItePlaca = $fila['ItePlaca']; 	
			$this->ItePropietario = $fila['ItePropietario']; 	
			$this->IteCondicion = $fila['IteCondicion']; 	
			$this->IteCausa = $fila['IteCausa']; 	
			$this->IteCorreccion = $fila['IteCorreccion']; 	
			$this->IteConclusion = $fila['IteConclusion']; 	
			$this->IteSolucionSatisfactoria = $fila['IteSolucionSatisfactoria']; 	
			
			$this->IteMotor = $fila['IteMotor']; 	
			$this->IteTipoTransmision = $fila['IteTipoTransmision']; 	
			$this->IteTipoCarroceria = $fila['IteTipoCarroceria']; 	
			$this->IteCarga = $fila['IteCarga']; 	
			$this->IteCiudad = $fila['IteCiudad']; 	
			$this->IteDepartamento = $fila['IteDepartamento']; 	
			$this->IteUsoVehiculo = $fila['IteUsoVehiculo']; 	
			$this->IteAltitud = $fila['IteAltitud']; 	
			
			$this->MonId = $fila['MonId'];
			$this->IteTipoCambio = $fila['IteTipoCambio'];
			
			$this->IteObservacion = $fila['IteObservacion']; 	
			$this->IteEstado = $fila['IteEstado']; 	
			$this->IteTiempoCreacion = $fila['NIteTiempoCreacion']; 	
			$this->IteTiempoModificacion = $fila['NIteTiempoModificacion']; 
			
			$this->EinPlaca = $fila['EinPlaca']; 
			$this->EinVIN = $fila['EinVIN']; 
			$this->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje']; 
			
			$this->VmaNombre = $fila['VmaNombre']; 
			$this->VmoNombre = $fila['VmoNombre']; 
			$this->VveNombre = $fila['VveNombre']; 
			
			$this->VmaId = $fila['VmaId']; 
			
			$this->PerNombre = $fila['PerNombre']; 
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno']; 
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno']; 
			
			if($oCompleto){
				
				// MtdObtenerInformeTecnicoOperaciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'ItoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oInformeTecnico=NULL,$oEstado=NULL) 
				$InsInformeTecnicoOperacion = new ClsInformeTecnicoOperacion();
				$ResInformeTecnicoOperacion = $InsInformeTecnicoOperacion->MtdObtenerInformeTecnicoOperaciones(NULL,NULL,'ItoId','ASC',NULL,$this->IteId,NULL);
				
				$this->InformeTecnicoOperacion = $ResInformeTecnicoOperacion['Datos'];
				
				 //MtdObtenerInformeTecnicoProductos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'ItpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oInformeTecnico=NULL,$oEstado=NULL,$oProducto=NULL) 
				 $InsInformeTecnicoProducto = new ClsInformeTecnicoProducto();
				 $ResInformeTecnicoProducto = $InsInformeTecnicoProducto->MtdObtenerInformeTecnicoProductos(NULL,NULL,'ItpId','ASC',NULL,$this->IteId,NULL,NULL) ;
				 
				 $this->InformeTecnicoProducto = $ResInformeTecnicoProducto['Datos'];
				 
			}
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerInformeTecnicos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'IteId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oVehiculoMarca=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

			
	
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaIte)){
				$fecha = ' AND DATE(ite.IteFecha)>="'.$oFechaInicio.'" AND DATE(ite.IteFecha)<="'.$oFechaIte.'"';
			}else{
				$fecha = ' AND DATE(ite.IteFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaIte)){
				$fecha = ' AND DATE(ite.IteFecha)<="'.$oFechaIte.'"';		
			}			
		}

		if(!empty($oEstado)){
			$estado = ' AND ite.IteEstado = '.$oEstado;
		}

		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND ein.VmaId = "'.$oVehiculoMarca.'"';
		}

		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ite.IteId,
				ite.FinId,
				ite.PerId,
				ite.IteCargo,
				ite.IteConcesionario,
				ite.IteSedeLocal,
				DATE_FORMAT(ite.IteFecha, "%d/%m/%Y") AS "NIteFecha",
				DATE_FORMAT(ite.IteFechaVenta, "%d/%m/%Y") AS "NIteFechaVenta",
				ite.IteContactoGM,
				ite.ItePlaca,
				ite.ItePropietario,
				ite.IteCondicion,
				ite.IteCausa,
				ite.IteCorreccion,
				ite.IteConclusion,
				ite.IteSolucionSatisfactoria,
				
				ite.IteMotor,
				ite.IteTipoTransmision,
				ite.IteTipoCarroceria,
				ite.IteCarga,
				ite.IteCiudad,
				ite.IteDepartamento,
				ite.IteUsoVehiculo,
				ite.IteAltitud,
				
				ite.MonId,
				ite.IteTipoCambio,
				
				ite.IteObservacion,
				ite.IteEstado,
				DATE_FORMAT(ite.IteTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NIteTiempoCreacion",
				DATE_FORMAT(ite.IteTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NIteTiempoModificacion",
				
				ein.EinVIN,
				ein.EinPlaca,
				
				fin.FinVehiculoKilometraje,
				
				
				vmo.VmaId,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre				
				
				FROM tbliteinformetecnico ite
					LEFT JOIN tblfinfichaingreso fin
					ON ite.FinId = fin.FinId
						LEFT JOIN tbleinvehiculoingreso ein
						ON fin.EinId = ein.EinId
						
								LEFT JOIN tblvvevehiculoversion vve
								ON ein.VveId = vve.VveId 
									LEFT JOIN tblvmovehiculomodelo vmo
									ON vve.VmoId = vmo.VmoId
										LEFT JOIN tblvmavehiculomarca vma
										ON vmo.VmaId = vma.VmaId
				
				WHERE 1 = 1 '.$filtrar.$fecha.$estado.$vmarca.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsInformeTecnico = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$InformeTecnico = new $InsInformeTecnico();
                   	$InformeTecnico->IteId = $fila['IteId'];
					$InformeTecnico->FinId = $fila['FinId'];
					$InformeTecnico->PerId = $fila['PerId'];
					$InformeTecnico->IteCargo = $fila['IteCargo'];
					$InformeTecnico->IteConcesionario = $fila['IteConcesionario'];
					$InformeTecnico->IteSedeLocal = $fila['IteSedeLocal'];
					$InformeTecnico->IteFecha = $fila['NIteFecha']; 
					$InformeTecnico->IteFechaVenta = $fila['NIteFechaVenta']; 
					$InformeTecnico->IteContactoGM = $fila['IteContactoGM']; 
					$InformeTecnico->ItePlaca = $fila['ItePlaca']; 	
					$InformeTecnico->ItePropietario = $fila['ItePropietario']; 	
					$InformeTecnico->IteCondicion = $fila['IteCondicion']; 	
					$InformeTecnico->IteCausa = $fila['IteCausa']; 	
					$InformeTecnico->IteCorreccion = $fila['IteCorreccion']; 	
					$InformeTecnico->IteConclusion = $fila['IteConclusion']; 	
					$InformeTecnico->IteSolucionSatisfactoria = $fila['IteSolucionSatisfactoria']; 	
					
					$InformeTecnico->IteMotor = $fila['IteMotor']; 	
					$InformeTecnico->IteTipoTransmision = $fila['IteTipoTransmision']; 	
					$InformeTecnico->IteTipoCarroceria = $fila['IteTipoCarroceria']; 	
					$InformeTecnico->IteCarga = $fila['IteCarga']; 	
					$InformeTecnico->IteCiudad = $fila['IteCiudad']; 	
					$InformeTecnico->IteDepartamento = $fila['IteDepartamento']; 	
					$InformeTecnico->IteUsoVehiculo = $fila['IteUsoVehiculo']; 	
					$InformeTecnico->IteAltitud = $fila['IteAltitud']; 	
					
					$InformeTecnico->MonId = $fila['MonId']; 
					$InformeTecnico->IteTipoCambio = $fila['IteTipoCambio']; 
					
					$InformeTecnico->IteObservacion = $fila['IteObservacion']; 	
					$InformeTecnico->IteEstado = $fila['IteEstado']; 	
					$InformeTecnico->IteTiempoCreacion = $fila['NIteTiempoCreacion']; 	
					$InformeTecnico->IteTiempoModificacion = $fila['NIteTiempoModificacion']; 
					
					$InformeTecnico->EinVIN = $fila['EinVIN']; 
					$InformeTecnico->EinPlaca = $fila['EinPlaca']; 
					
					
					
					
					$InformeTecnico->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje']; 
					$InformeTecnico->VmaId = $fila['VmaId']; 
					
					$InformeTecnico->VmaNombre = $fila['VmaNombre']; 
					$InformeTecnico->VmoNombre = $fila['VmoNombre']; 
					$InformeTecnico->VveNombre = $fila['VveNombre']; 
					
				
                    $InformeTecnico->InsMysql = NULL;                    
	
					$Respuesta['Datos'][]= $InformeTecnico;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarInformeTecnico($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					$aux = explode("%",$elemento);	

						$sql = 'DELETE FROM tbliteinformetecnico WHERE  (IteId = "'.($aux[0]).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarInformeTecnico(3,"Se elimino el Informe Tecnico",$aux);		
						}

				}
			$i++;

			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoInformeTecnico($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){

					$sql = 'UPDATE tbliteinformetecnico SET IteEstado = '.$oEstado.' WHERE IteId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarInformeTecnico(2,"Se actualizo el Estado del Informe Tecnico",$elemento);
				
					}

					
				}
			$i++;
	
			}

		if($error) {	
			$this->InsMysql->MtdTransaccionDeshacer();			
			return false;
		} else {				
			$this->InsMysql->MtdTransaccionHacer();			
			return true;
		}									
	}
	
	
	public function MtdRegistrarInformeTecnico() {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarInformeTecnicoId();

			$this->InsMysql->MtdTransaccionIniciar();		
			
			$sql = 'INSERT INTO tbliteinformetecnico (
			IteId,
			FinId,
			PerId,
			IteCargo,
			IteConcesionario,
			IteSedeLocal,
			IteFecha,
			IteFechaVenta,
			IteContactoGM,
			ItePlaca,
			ItePropietario,
			IteCondicion,
			IteCausa,
			IteCorreccion,
			IteConclusion,
			IteSolucionSatisfactoria,
			
		
			IteMotor,
			IteTipoTransmision,
			IteTipoCarroceria,
			IteCarga,
			IteCiudad,
			IteDepartamento,
			IteUsoVehiculo,
			IteAltitud,
			
			MonId,
			IteTipoCambio,
			
			IteObservacion,
			IteEstado,
			IteTiempoCreacion,
			IteTiempoModificacion
			) 
			VALUES (
			"'.($this->IteId).'",
			"'.($this->FinId).'",
			"'.($this->PerId).'",
			"'.($this->IteCargo).'",
			"'.($this->IteConcesionario).'",
			"'.($this->IteSedeLocal).'",
			"'.($this->IteFecha).'",
			"'.($this->IteFechaVenta).'",
			"'.($this->IteContactoGM).'",
			"'.($this->ItePlaca).'",
			"'.($this->ItePropietario).'",
			"'.($this->IteCondicion).'",
			"'.($this->IteCausa).'",			
			"'.($this->IteCorreccion).'",
			"'.($this->IteConclusion).'",
			'.($this->IteSolucionSatisfactoria).',
			
			"'.($this->IteMotor).'",
			"'.($this->IteTipoTransmision).'",
			"'.($this->IteTipoCarroceria).'",
			"'.($this->IteCarga).'",
			"'.($this->IteCiudad).'",
			"'.($this->IteDepartamento).'",
			"'.($this->IteUsoVehiculo).'",
			"'.($this->IteAltitud).'",
			
			"'.($this->MonId).'",
			'.(empty($this->IteTipoCambio)?"NULL,":'"'.$this->IteTipoCambio.'",').'
			
			"'.($this->IteObservacion).'",
			'.($this->IteEstado).',
			"'.($this->IteTiempoCreacion).'", 				
			"'.($this->IteTiempoModificacion).'");';
				
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			

			if(!$error){			
			
				if (!empty($this->InformeTecnicoProducto)){		
						
					$validar = 0;				

					foreach ($this->InformeTecnicoProducto as $DatInformeTecnicoProducto){
						
						$InsInformeTecnicoProducto = new ClsInformeTecnicoProducto();
						$InsInformeTecnicoProducto->IteId = $this->IteId;
						$InsInformeTecnicoProducto->ProId = $DatInformeTecnicoProducto->ProId;
						$InsInformeTecnicoProducto->UmeId = $DatInformeTecnicoProducto->UmeId;
						$InsInformeTecnicoProducto->FapId = $DatInformeTecnicoProducto->FapId;

						$InsInformeTecnicoProducto->ItpValorUnitario = $DatInformeTecnicoProducto->ItpValorUnitario;
						$InsInformeTecnicoProducto->ItpCantidad = $DatInformeTecnicoProducto->ItpCantidad;
						$InsInformeTecnicoProducto->ItpValorTotal = $DatInformeTecnicoProducto->ItpValorTotal;
						//	deb($InsInformeTecnicoProducto->ItpValorUnitario."a");
							
						$InsInformeTecnicoProducto->ItpEstado = $DatInformeTecnicoProducto->ItpEstado;
						$InsInformeTecnicoProducto->ItpTiempoCreacion = $DatInformeTecnicoProducto->ItpTiempoCreacion;
						$InsInformeTecnicoProducto->ItpTiempoModificacion = $DatInformeTecnicoProducto->ItpTiempoModificacion;						
						$InsInformeTecnicoProducto->ItpEliminado = $DatInformeTecnicoProducto->ItpEliminado;

						if($InsInformeTecnicoProducto->MtdRegistrarInformeTecnicoProducto()){
							$validar++;	
						}else{
							$Resultado.='#ERR_ITE_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->InformeTecnicoProducto) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			if(!$error){			

				if (!empty($this->InformeTecnicoOperacion)){		

					$validar = 0;					
					$InsInformeTecnicoOperacion = new ClsInformeTecnicoOperacion();		
											
					foreach ($this->InformeTecnicoOperacion as $DatInformeTecnicoOperacion){

						$InsInformeTecnicoOperacion->IteId = $this->IteId;
						
						$InsInformeTecnicoOperacion->ItoNumero = $DatInformeTecnicoOperacion->ItoNumero;
						$InsInformeTecnicoOperacion->ItoTiempo = $DatInformeTecnicoOperacion->ItoTiempo;
						$InsInformeTecnicoOperacion->ItoCostoHora = $DatInformeTecnicoOperacion->ItoCostoHora;
						$InsInformeTecnicoOperacion->ItoValorTotal = $DatInformeTecnicoOperacion->ItoValorTotal;
						
						$InsInformeTecnicoOperacion->ItoEstado = $DatInformeTecnicoOperacion->ItoEstado;							
						$InsInformeTecnicoOperacion->ItoTiempoCreacion = $DatInformeTecnicoOperacion->ItoTiempoCreacion;
						$InsInformeTecnicoOperacion->ItoTiempoModificacion = $DatInformeTecnicoOperacion->ItoTiempoModificacion;						
						$InsInformeTecnicoOperacion->ItoEliminado = $DatInformeTecnicoOperacion->ItoEliminado;
						
						if($InsInformeTecnicoOperacion->MtdRegistrarInformeTecnicoOperacion()){
							$validar++;	
						}else{
							$Resultado.='#ERR_ITE_301';
							$Resultado.='#Item Numero: '.($validar+1);
						}

					}					
					
					if(count($this->InformeTecnicoOperacion) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			
					
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarInformeTecnico(1,"Se registro el Informe Tecnico",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarInformeTecnico() {

		global $Resultado;
		$error = false;

			$this->InsMysql->MtdTransaccionIniciar();			
				
			$sql = 'UPDATE tbliteinformetecnico SET
			PerId = "'.($this->PerId).'",
			IteConcesionario = "'.($this->IteConcesionario).'",
			IteSedeLocal = "'.($this->IteSedeLocal).'",
			IteFecha = "'.($this->IteFecha).'",
			IteFechaVenta = "'.($this->IteFechaVenta).'",
			IteContactoGM = "'.($this->IteContactoGM).'",
			ItePlaca = "'.($this->ItePlaca).'",
			ItePropietario = "'.($this->ItePropietario).'",
			IteCondicion = "'.($this->IteCondicion).'",
			IteCausa = "'.($this->IteCausa).'",
			IteCorreccion = "'.($this->IteCorreccion).'",
			IteConclusion = "'.($this->IteConclusion).'",
			IteSolucionSatisfactoria = '.($this->IteSolucionSatisfactoria).',
			IteCargo = "'.($this->IteCargo).'",		
			
			IteEstado = '.($this->IteEstado).',

			IteMotor = "'.($this->IteMotor).'",			
			IteTipoTransmision = "'.($this->IteTipoTransmision).'",			
			IteTipoCarroceria = "'.($this->IteTipoCarroceria).'",			
			IteCarga = "'.($this->IteCarga).'",			
			IteCiudad = "'.($this->IteCiudad).'",			
			IteDepartamento = "'.($this->IteDepartamento).'",			
			IteUsoVehiculo = "'.($this->IteUsoVehiculo).'",	
			IteAltitud = "'.($this->IteAltitud).'",			
			
			MonId = "'.($this->MonId).'",			
			'.(empty($this->IteTipoCambio)?'IteTipoCambio = NULL, ':'IteTipoCambio = '.$this->IteTipoCambio.',').'
			
			IteObservacion = "'.($this->IteObservacion).'",			
			IteTiempoModificacion = "'.($this->IteTiempoModificacion).'"
			WHERE IteId = "'.($this->IteId).'";';			

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

			if(!$resultado) {
				$error = true;
			}
			


if(!$error){

				if (!empty($this->InformeTecnicoProducto)){		
						
					$validar = 0;
					foreach ($this->InformeTecnicoProducto as $DatInformeTecnicoProducto){
	
						$InsInformeTecnicoProducto = new ClsInformeTecnicoProducto();
						$InsInformeTecnicoProducto->ItpId = $DatInformeTecnicoProducto->ItpId;
						$InsInformeTecnicoProducto->IteId = $this->IteId;
						$InsInformeTecnicoProducto->ProId = $DatInformeTecnicoProducto->ProId;
						$InsInformeTecnicoProducto->UmeId = $DatInformeTecnicoProducto->UmeId;
						$InsInformeTecnicoProducto->FapId = $DatInformeTecnicoProducto->FapId;
						$InsInformeTecnicoProducto->ItpValorUnitario = $DatInformeTecnicoProducto->ItpValorUnitario;	
						$InsInformeTecnicoProducto->ItpCantidad = $DatInformeTecnicoProducto->ItpCantidad;						
						$InsInformeTecnicoProducto->ItpValorTotal = $DatInformeTecnicoProducto->ItpValorTotal;
					
						$InsInformeTecnicoProducto->ItpEstado = $DatInformeTecnicoProducto->ItpEstado;
						$InsInformeTecnicoProducto->ItpTiempoCreacion = $DatInformeTecnicoProducto->ItpTiempoCreacion;
						$InsInformeTecnicoProducto->ItpTiempoModificacion = $DatInformeTecnicoProducto->ItpTiempoModificacion;
						$InsInformeTecnicoProducto->ItpEliminado = $DatInformeTecnicoProducto->ItpEliminado;

						if(empty($InsInformeTecnicoProducto->ItpId)){
							if($InsInformeTecnicoProducto->ItpEliminado<>2){
								if($InsInformeTecnicoProducto->MtdRegistrarInformeTecnicoProducto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_ITE_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
			 				}else{
								$validar++;
							}
						}else{						
							if($InsInformeTecnicoProducto->ItpEliminado==2){
								if($InsInformeTecnicoProducto->MtdEliminarInformeTecnicoProducto($InsInformeTecnicoProducto->ItpId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_ITE_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsInformeTecnicoProducto->MtdEditarInformeTecnicoProducto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_ITE_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->InformeTecnicoProducto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			

			if(!$error){

				if (!empty($this->InformeTecnicoOperacion)){		
						
					$validar = 0;				
					
					$InsInformeTecnicoOperacion = new ClsInformeTecnicoOperacion();

					foreach ($this->InformeTecnicoOperacion as $DatInformeTecnicoOperacion){


						$InsInformeTecnicoOperacion->ItoId = $DatInformeTecnicoOperacion->ItoId;
						$InsInformeTecnicoOperacion->IteId = $this->IteId;
						$InsInformeTecnicoOperacion->ItoNumero = $DatInformeTecnicoOperacion->ItoNumero;
						$InsInformeTecnicoOperacion->ItoTiempo = $DatInformeTecnicoOperacion->ItoTiempo;
						$InsInformeTecnicoOperacion->ItoCostoHora = $DatInformeTecnicoOperacion->ItoCostoHora;
						$InsInformeTecnicoOperacion->ItoValorTotal = $DatInformeTecnicoOperacion->ItoValorTotal;	
						
						$InsInformeTecnicoOperacion->ItoEstado = $DatInformeTecnicoOperacion->ItoEstado;
						$InsInformeTecnicoOperacion->ItoTiempoCreacion = $DatInformeTecnicoOperacion->ItoTiempoCreacion;
						$InsInformeTecnicoOperacion->ItoTiempoModificacion = $DatInformeTecnicoOperacion->ItoTiempoModificacion;
						$InsInformeTecnicoOperacion->ItoEliminado = $DatInformeTecnicoOperacion->ItoEliminado;
						
			
						if(empty($InsInformeTecnicoOperacion->ItoId)){
							if($InsInformeTecnicoOperacion->ItoEliminado<>2){
								if($InsInformeTecnicoOperacion->MtdRegistrarInformeTecnicoOperacion()){
									$validar++;	
								}else{
									$Resultado.='#ERR_ITE_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsInformeTecnicoOperacion->ItoEliminado==2){
								if($InsInformeTecnicoOperacion->MtdEliminarInformeTecnicoOperacion($InsInformeTecnicoOperacion->ItoId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_ITE_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsInformeTecnicoOperacion->MtdEditarInformeTecnicoOperacion()){
									$validar++;	
								}else{
									$Resultado.='#ERR_ITE_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->InformeTecnicoOperacion) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			

			if($error) {
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {
				$this->InsMysql->MtdTransaccionHacer();								
				$this->MtdAuditarInformeTecnico(2,"Se edito el Informe Tecnico",$this);		
				return true;
			}
				
		}	
		
	
	
		private function MtdAuditarInformeTecnico($oAccion,$oDescripcion,$oDatos){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->IteId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
}
?>