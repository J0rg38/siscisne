<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCita
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCita {

    public $CitId;
	public $CliId;
	public $EinId;
	
	public $CitFecha;
    public $CitFechaProgramada;
	public $CitHoraProgramada;
	public $CitTelefono;
	public $CitCelular;
	public $CitEmail;
	public $CitDescripcion;
	public $CitKilometrajeMantenimiento;
	
	public $CitEstado;	
    public $CitTiempoCreacion;
    public $CitTiempoModificacion;
    public $CitEliminado;

	public $InsMysql;

	public $Transaccion;
	
    public function __construct(){

		$this->InsMysql = new ClsMysql();
		$this->Transaccion = true;
		
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarCitaId() {
	
			global $SucursalSiglas;
			
			$sql = 'SELECT	
			suc.SucSiglas AS SIGLA,
			MAX(CONVERT(SUBSTR(cit.CitId,5),unsigned)) AS "MAXIMO"
			FROM tblcitcita cit
				LEFT JOIN tblsucsucursal suc
			ON cit.SucId = suc.SucId
			
			WHERE cit.SucId = "'.$this->SucId.'"
			';
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

			if(empty($fila['MAXIMO'])){		

				$this->CitId = "CIT-10000-".(empty($fila['SIGLA'])?(empty($SucursalSiglas)?$_SESSION['SesionSucursalSiglas']:$SucursalSiglas):$fila['SIGLA']);

			}else{
				
				$fila['MAXIMO']++;
				$this->CitId = "CIT-".$fila['MAXIMO']."-".(empty($fila['SIGLA'])?(empty($SucursalSiglas)?$_SESSION['SesionSucursalSiglas']:$SucursalSiglas):$fila['SIGLA']);				
			
			}	
			
		}
		
    public function MtdObtenerCita(){

        $sql = 'SELECT 
        cit.CitId,
		cit.SucId,
		
		cit.CliId,
		cit.EinId,
		cit.PerId,
		cit.PerIdMecanico,
		cit.PerIdRegistro,
		
		DATE_FORMAT(cit.CitFecha, "%d/%m/%Y") AS "NCitFecha",
		
		DATE_FORMAT(cit.CitFechaProgramada, "%d/%m/%Y") AS "NCitFechaProgramada",		
		cit.CitHoraProgramada,
	
		cit.CitTelefono,
		cit.CitCelular,		
		cit.CitEmail,
		cit.CitDescripcion,
		cit.CitKilometrajeMantenimiento,
		
		cit.CitDuracion,
		
		
		IFNULL(cit.CitVehiculoMarca,vma.VmaNombre) AS CitVehiculoMarca,
		IFNULL(cit.CitVehiculoModelo,vmo.VmoNombre) AS CitVehiculoModelo,
		IFNULL(cit.CitVehiculoVersion,vve.VveNombre) AS CitVehiculoVersion,
		IFNULL(cit.CitVehiculoPlaca,ein.EinPlaca) AS CitVehiculoPlaca,
		
		cit.CitReferencia,		
		
cit.CitEstado,
	
		DATE_FORMAT(cit.CitTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCitTiempoCreacion",
        DATE_FORMAT(cit.CitTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCitTiempoModificacion",

		cli.LtiId,
		cli.CliNombreCompleto,
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		cli.CliNumeroDocumento,
		cli.TdoId,
		cli.CliCelular,
		cli.CliContactoCelular1,
		cli.CliContactoCelular2,
		cli.CliContactoCelular3,
		
		cli.CliTelefono,
		cli.CliDireccion,
		
		ein.EinVIN,
		ein.EinPlaca,
		ein.EinColor,
		ein.EinAnoFabricacion,
		ein.EinAnoModelo,
		
		ein.VveId,
		vve.VmoId,
		vmo.VmaId,
	
		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre
		
        FROM tblcitcita cit
			LEFT JOIN tblclicliente cli
			ON cit.CliId = cli.CliId
				LEFT JOIN tbleinvehiculoingreso ein
				ON cit.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
									
        WHERE cit.CitId = "'.$this->CitId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
			{
				$this->CitId = $fila['CitId'];
				$this->SucId = $fila['SucId'];
				
				$this->CliId = $fila['CliId'];
				$this->EinId = $fila['EinId'];
				$this->PerId = $fila['PerId'];
				$this->PerIdMecanico = $fila['PerIdMecanico'];
				$this->PerIdRegistro = $fila['PerIdRegistro'];
				
				
				$this->CitFecha = $fila['NCitFecha'];
				$this->CitFechaProgramada = $fila['NCitFechaProgramada'];
				$this->CitHoraProgramada = $fila['CitHoraProgramada'];
				
				$this->CitTelefono = $fila['CitTelefono'];			
				$this->CitCelular = $fila['CitCelular'];
				$this->CitEmail = $fila['CitEmail'];
				$this->CitDescripcion = $fila['CitDescripcion'];
				$this->CitKilometrajeMantenimiento = $fila['CitKilometrajeMantenimiento'];
		
	
				$this->CitDuracion = $fila['CitDuracion'];
				
				$this->CitVehiculoMarca = $fila['CitVehiculoMarca'];			
				$this->CitVehiculoModelo = $fila['CitVehiculoModelo'];
				$this->CitVehiculoVersion = $fila['CitVehiculoVersion'];
				$this->CitVehiculoPlaca = $fila['CitVehiculoPlaca'];
				
				$this->CitReferencia = $fila['CitReferencia'];
				$this->CitEstado = $fila['CitEstado'];
				$this->CitTiempoCreacion = $fila['NCitTiempoCreacion'];
				$this->CitTiempoModificacion = $fila['NCitTiempoModificacion'];
				
				$this->LtiId = $fila['LtiId'];
				$this->CliNombreCompleto = $fila['CliNombreCompleto'];
				$this->CliNombre = $fila['CliNombre'];
				$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
				$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
				$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
				$this->TdoId = $fila['TdoId'];
				$this->CliCelular = $fila['CliCelular'];
				$this->CliContactoCelular1 = $fila['CliContactoCelular1'];
				$this->CliContactoCelular2 = $fila['CliContactoCelular2'];
				$this->CliContactoCelular3 = $fila['CliContactoCelular3'];
		
		
				$this->CliTelefono = $fila['CliTelefono'];
				$this->CliDireccion = $fila['CliDireccion'];
			
				$this->EinVIN = $fila['EinVIN'];
				$this->EinPlaca = $fila['EinPlaca'];
				$this->EinColor = $fila['EinColor'];
				$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];
				$this->EinAnoModelo = $fila['EinAnoModelo'];
				
				$this->VveId = $fila['VveId'];
				$this->VmoId = $fila['VmoId'];
				$this->VmaId = $fila['EinAnoModelo'];
			
				$this->VmaNombre = $fila['VmaNombre'];
				$this->VmoNombre = $fila['VmoNombre'];
				$this->VveNombre = $fila['VveNombre'];
			
				switch($this->CitEstado){
					case 1:
						$this->CitEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$this->CitEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$this->CitEstadoDescripcion = "Anulado";
				
					break;
					
				}
				
				
				switch($this->CitEstado){
					case 1:
						$this->CitEstadoIcono = '<img src="imagenes/estado/pendiente.png" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$this->CitEstadoIcono = '<img src="imagenes/estado/realizado.png" alt="[Realizado]" title="Realizado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$this->CitEstadoIcono = '<img src="imagenes/estado/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
					break;
					
				}
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCitas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oPersonalMecanico=NULL,$oHora=NULL,$oSucursal=NULL) {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$estado = '';
		$cliente = '';
		$vingreso = '';
		$hora = '';
		$sfichaingreso = '';
		$sucursal = '';
		$pmecanico = '';
		$personal = '';
		$fecha = '';
		$orden = '';
		$paginacion = '';

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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
			
				
		if(!empty($oEstado)){
			$estado = ' AND cit.CitEstado = '.$oEstado;
		}	
		
		if(!empty($oCliente)){
			$cliente = ' AND cit.CliId = "'.$oCliente.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND cit.PerId = "'.$oPersonal.'"';
		}	
		
		
			
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cit.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(cit.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cit.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cit.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}

		if(($oSinFichaIngreso)){
			$sfichaingreso = ' AND
			
			NOT EXISTS(
				SELECT 
				fin.FinId 
				FROM tblfinfichaingreso fin
				
				WHERE fin.CitId = cit.CitId
				AND fin.FinEstado <> 9
				LIMIT 1
			)
			';
		}	
		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND cit.EinId = "'.$oVehiculoIngresoId.'"';
		}
		
	//	if(!empty($oPersonal)){
//			$personal = ' AND cit.PerId = "'.$oPersonal.'"';
//		}	
		
		if(!empty($oPersonalMecanico)){
			$pmecanico = ' AND cit.PerIdMecanico = "'.$oPersonalMecanico.'"';
		}	
		
		if(!empty($oHora)){
			$hora = ' AND (
			
			 TIME_TO_SEC(cit.CitHoraProgramada) <=  TIME_TO_SEC("'.$oHora.'")
			 
			 AND TIME_TO_SEC(ADDTIME(cit.CitHoraProgramada,SEC_TO_TIME(cit.CitDuracion*60*60))) >= TIME_TO_SEC("'.$oHora.'")
			  
			 ) ';
		}	
		
			
		if(!empty($oSucursal)){
			$sucursal = ' AND cit.SucId = "'.$oSucursal.'"';
		}
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		cit.CitId,
		cit.CliId,
		cit.EinId,
		cit.PerId,
		cit.PerIdMecanico,
		cit.PerIdRegistro,
		
		DATE_FORMAT(cit.CitFecha, "%d/%m/%Y") AS "NCitFecha",
		
		DATE_FORMAT(cit.CitFechaProgramada, "%d/%m/%Y") AS "NCitFechaProgramada",
		cit.CitHoraProgramada,
		DATE_FORMAT(CONCAT(cit.CitFechaProgramada," ",cit.CitHoraProgramada), "%d/%m/%Y %H:%m:%s") AS "CitFechaHoraInicio",
		DATE_FORMAT(DATE_ADD(CONCAT(cit.CitFechaProgramada," ",cit.CitHoraProgramada), INTERVAL IFNULL(cit.CitDuracion,0) HOUR)  , "%d/%m/%Y %H:%m:%s")AS "CitFechaHoraFin",

		cit.CitTelefono,
		cit.CitCelular,		
		cit.CitEmail,
		cit.CitDescripcion,
		cit.CitKilometrajeMantenimiento,
		
		cit.CitDuracion,
		
		IFNULL(cit.CitVehiculoMarca,vma.VmaNombre) AS CitVehiculoMarca,
		IFNULL(cit.CitVehiculoModelo,vmo.VmoNombre) AS CitVehiculoModelo,
		IFNULL(cit.CitVehiculoVersion,vve.VveNombre) AS CitVehiculoVersion,
		IFNULL(cit.CitVehiculoPlaca,ein.EinPlaca) AS CitVehiculoPlaca,
		
		cit.CitReferencia,
cit.CitEstado,
	
		DATE_FORMAT(cit.CitTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCitTiempoCreacion",
        DATE_FORMAT(cit.CitTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCitTiempoModificacion",
		
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		cli.CliNumeroDocumento,
		cli.TdoId,
		cli.CliTelefono,
		cli.CliCelular,
		cli.CliContactoCelular1,
		cli.CliContactoCelular2,
		cli.CliContactoCelular3,
		
		ein.EinVIN,
		ein.EinPlaca,
		
		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		
		mec.PerNombre AS PerNombreMecanico,
		mec.PerApellidoPaterno AS PerApellidoPaternoMecanico,
		mec.PerApellidoMaterno AS PerApellidoMaternoMecanico,
		
		rgr.PerNombre AS PerNombreRegistro,
		rgr.PerApellidoPaterno AS PerApellidoPaternoRegistro,
		rgr.PerApellidoMaterno AS PerApellidoMaternoRegistro,
		
		suc.SucNombre
		
        FROM tblcitcita cit
			LEFT JOIN tblclicliente cli
			ON cit.CliId = cli.CliId
			
				LEFT JOIN tbleinvehiculoingreso ein
				ON cit.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per
								ON cit.PerId = per.PerId
									LEFT JOIN tblperpersonal mec
									ON cit.PerIdMecanico = mec.PerId
										LEFT JOIN tblsucsucursal suc
										ON cit.SucId = suc.SucId
										
											LEFT JOIN tblperpersonal rgr
									ON cit.PerIdRegistro = rgr.PerId
										
				WHERE 1 = 1 '.$filtrar.$estado.$cliente.$vingreso.$hora.$sfichaingreso.$sucursal.$pmecanico.$personal.$fecha.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCita = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Cita = new $InsCita();				
					
                    $Cita->CitId = $fila['CitId'];
					$Cita->CliId = $fila['CliId'];
					$Cita->EinId = $fila['EinId'];
					
					$Cita->PerId = $fila['PerId'];
					$Cita->PerIdMecanico = $fila['PerIdMecanico'];
						$Cita->PerIdRegistro = $fila['PerIdRegistro'];	
							
										
					$Cita->CitFecha = $fila['CitFecha'];
					$Cita->CitFechaProgramada = $fila['NCitFechaProgramada'];
					$Cita->CitHoraProgramada = $fila['CitHoraProgramada'];

					$Cita->CitFechaHoraInicio = $fila['CitFechaHoraInicio'];
					$Cita->CitFechaHoraFin = $fila['CitFechaHoraFin'];

					$Cita->CitTelefono= $fila['CitTelefono'];
					
					$Cita->CitCelular= $fila['CitCelular'];
					$Cita->CitEmail = $fila['CitEmail'];
					$Cita->CitDescripcion = $fila['CitDescripcion'];
					$Cita->CitKilometrajeMantenimiento = $fila['CitKilometrajeMantenimiento'];

					
					$Cita->CitDuracion = $fila['CitDuracion'];
					
					$Cita->CitVehiculoMarca= $fila['CitVehiculoMarca'];
					$Cita->CitVehiculoModelo = $fila['CitVehiculoModelo'];
					$Cita->CitVehiculoVersion = $fila['CitVehiculoVersion'];
					$Cita->CitVehiculoPlaca = $fila['CitVehiculoPlaca'];
		
					$Cita->CitReferencia = $fila['CitReferencia'];
					$Cita->CitEstado = $fila['CitEstado'];					
                    $Cita->CitTiempoCreacion = $fila['NCitTiempoCreacion'];
                    $Cita->CitTiempoModificacion = $fila['NCitTiempoModificacion'];    

					$Cita->CliNombre = $fila['CliNombre'];    
					$Cita->CliApellidoPaterno = $fila['CliApellidoPaterno'];    
					$Cita->CliApellidoMaterno = $fila['CliApellidoMaterno'];   
					$Cita->TdoId = $fila['TdoId'];  
					$Cita->CliTelefono = $fila['CliTelefono'];
					$Cita->CliCelular = $fila['CliCelular'];  
					
					$Cita->CliContactoCelular1 = $fila['CliContactoCelular1'];  
					$Cita->CliContactoCelular2 = $fila['CliContactoCelular2'];  
					$Cita->CliContactoCelular3 = $fila['CliContactoCelular3'];  
	
					$Cita->EinVIN = $fila['EinVIN'];    
					$Cita->EinPlaca  = $fila['EinPlaca'];    
					
					$Cita->VmaNombre = $fila['VmaNombre'];    
					$Cita->VmoNombre = $fila['VmoNombre'];    
					$Cita->VveNombre = $fila['VveNombre'];  
					
					
					$Cita->PerApellidoPaterno = $fila['PerApellidoPaterno'];    
					$Cita->PerApellidoMaterno = $fila['PerApellidoMaterno'];    
					$Cita->PerNombre = $fila['PerNombre'];   
					
					$Cita->PerNombreMecanico = $fila['PerNombreMecanico'];    
					$Cita->PerApellidoPaternoMecanico = $fila['PerApellidoPaternoMecanico'];    
					$Cita->PerApellidoMaternoMecanico = $fila['PerApellidoMaternoMecanico'];    
					
					$Cita->PerNombreRegistro = $fila['PerNombreRegistro'];    
					$Cita->PerApellidoPaternoRegistro = $fila['PerApellidoPaternoRegistro'];    
					$Cita->PerApellidoMaternoRegistro = $fila['PerApellidoMaternoRegistro'];    
					
					
					$Cita->SucNombre = $fila['SucNombre'];    
					
					 
				switch($Cita->CitEstado){
					case 1:
						$Cita->CitEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$Cita->CitEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$Cita->CitEstadoDescripcion = "Anulado";
				
					break;
					
				}
				
				
				switch($Cita->CitEstado){
					case 1:
						$Cita->CitEstadoIcono = '<img src="imagenes/estado/pendiente.png" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$Cita->CitEstadoIcono = '<img src="imagenes/estado/realizado.png" alt="[Realizado]" title="Realizado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$Cita->CitEstadoIcono = '<img src="imagenes/estado/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
					break;
					
				}
				
                    $Cita->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Cita;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	public function MtdObtenerCitasValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oVehiculoMarca=NULL,$oHoraInicio=NULL,$oHoraFin=NULL,$oSucursal=NULL,$oDia=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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
			
				
		if(!empty($oEstado)){
			$estado = ' AND cit.CitEstado = '.$oEstado;
		}	
		
		if(!empty($oCliente)){
			$cliente = ' AND cit.CliId = "'.$oCliente.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND cit.PerId = "'.$oPersonal.'"';
		}	
		
		
			
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cit.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(cit.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cit.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cit.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}

		if(($oSinFichaIngreso)){
			$sfichaingreso = ' AND
			
			NOT EXISTS(
				SELECT 
				fin.FinId 
				FROM tblfinfichaingreso fin
				
				WHERE fin.CitId = cit.CitId
				AND fin.FinEstado <> 9
				LIMIT 1
			)
			';
		}	
		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND cit.EinId = "'.$oVehiculoIngresoId.'"';
		}	
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
		
		
			
		if(!empty($oHoraInicio)){
			
			if(!empty($oHoraFin)){
				$hora = ' AND TIME(cit.CitHoraProgramada)>="'.$oHoraInicio.'" AND TIME(cit.CitHoraProgramada)<="'.$oHoraFin.'"';
			}else{
				$hora = ' AND TIME(cit.CitHoraProgramada)>="'.$oHoraInicio.'"';
			}
			
		}else{
			if(!empty($oHoraFin)){
				$hora = ' AND TIME(cit.CitHoraProgramada)<="'.$oHoraFin.'"';		
			}			
		}
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (cit.SucId) = "'.$oSucursal.'"';		
		}	
		
		
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(cit.CitFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(cit.CitFecha) ="'.($oAno).'"';
		}
		
		if(!empty($oDia)){
			$dia = ' AND DAY(cit.CitFecha) ="'.($oDia).'"';
		}
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		'.$funcion.' AS "RESULTADO"
		
        FROM tblcitcita cit
			LEFT JOIN tblclicliente cli
			ON cit.CliId = cli.CliId
				LEFT JOIN tbleinvehiculoingreso ein
				ON cit.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per
								ON cit.PerId = per.PerId
								
				WHERE 1 = 1 '.$ano.$mes.$dia.$filtrar.$estado.$sucursal.$vmarca.$hora.$cliente.$vingreso.$sfichaingreso .$personal.$fecha.$orden.$paginacion;
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarCita($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CitId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CitId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblcitcita WHERE '.$eliminar;
			
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
	
	
	
	public function MtdActualizarEstadoCita($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
				
					$sql = 'UPDATE tblcitcita SET CitEstado = '.$oEstado.' WHERE   (CitId = "'.($elemento).'" )';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
//						$this->MtdAuditarBoleta(2,"Se actualizo el Estado de la Cita",$aux);	
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


	public function MtdValidarCita($oFecha,$oHora,$oSucursal){
		
		//echo "MtdValidarCita";
		//echo "<br>";
				
		global $CitaRestriccionHorario;	
		
		//MtdObtenerCitasValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oVehiculoMarca=NULL,$oHoraInicio=NULL,$oHoraFin=NULL) {
		
		$Limite = 0;
		$TotalCitas = 0;		
		$Valido = false;		
		$ValidacionRespuesta = array();
		
		foreach($CitaRestriccionHorario as $DatCitaRestriccionHorario){
			//echo $DatCitaRestriccionHorario['Inicio']." - ".$DatCitaRestriccionHorario['Fin']." - ".$oHora;
			//echo "<br>";
		//	echo TimeToSec($DatCitaRestriccionHorario['Inicio'])." (".$DatCitaRestriccionHorario['Inicio'].") "." - ".TimeToSec($DatCitaRestriccionHorario['Fin'])." (".$DatCitaRestriccionHorario['Fin'].") - ".TimeToSec($oHora)." (".$oHora.")";
		//	echo "<br>";
			if( TimeToSec($DatCitaRestriccionHorario['Inicio']) <= TimeToSec($oHora) and TimeToSec($DatCitaRestriccionHorario['Fin']) > TimeToSec($oHora)){
				//echo "ok";
				//echo "<br>";
				
											//MtdObtenerCitasValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oVehiculoMarca=NULL,$oHoraInicio=NULL,$oHoraFin=NULL,$oSucursal=NULL)

				$TotalCitas = $this->MtdObtenerCitasValor("COUNT","CitId",NULL,NULL,NULL,NULL,NULL,'CitId','Desc','1',NULL,NULL,NULL,($oFecha),$oFecha,"CitFechaProgramada",false,NULL,NULL,$DatCitaRestriccionHorario['Inicio'],$DatCitaRestriccionHorario['Fin'],$oSucursal);//FncCambiaFechaAMysql
				//echo "TotalCitas: ".$TotalCitas;
				//echo "<br>";
				if(($TotalCitas+1)<$DatCitaRestriccionHorario['Limite']+0){
					$Valido = true;
				}
				
				$Limite = $DatCitaRestriccionHorario['Limite']+0;
				
				break;
				
			}else{
				//echo "no";
				//echo "<br>";
			}
			
		}
		
		$ValidacionRespuesta['respuesta'] = $Valido;
		$ValidacionRespuesta['citas'] = $TotalCitas;
		$ValidacionRespuesta['limite'] = $Limite;
		
		return $ValidacionRespuesta;
	}

	public function MtdRegistrarCita() {
	

		global $Resultado;
		$error = false;
		//
//		$this->MtdVerificarExisteCita();
		
		//if(!empty($this->CliId)){
//			$error = true;
//			$Resultado.='#ERR_CIT_201';
//		}
			
			
			$this->MtdGenerarCitaId();
				
			$sql = 'INSERT INTO tblcitcita (
			CitId,
			SucId,
			
			CliId,
			EinId,
			PerId,
			PerIdMecanico,
			PerIdRegistro,
			
			CitFecha,
			CitFechaProgramada,
			CitHoraProgramada,

			CitTelefono,			
			CitCelular,
			CitEmail,
			CitDescripcion,
			CitKilometrajeMantenimiento,
			
			CitDuracion,
			
			CitVehiculoMarca,			
			CitVehiculoModelo,
			CitVehiculoVersion,
			CitVehiculoPlaca,
			
			CitReferencia,
			CitEstado,
			CitTiempoCreacion,
			CitTiempoModificacion
			) 
			VALUES (
			"'.($this->CitId).'",
			"'.($this->SucId).'",
	
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'	
			'.(empty($this->EinId)?'NULL, ':'"'.$this->EinId.'",').'
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			'.(empty($this->PerIdMecanico)?'NULL, ':'"'.$this->PerIdMecanico.'",').'
			'.(empty($this->PerIdRegistro)?'NULL, ':'"'.$this->PerIdRegistro.'",').'
			
			
			
			"'.($this->CitFecha).'",
			"'.($this->CitFechaProgramada).'",
			"'.($this->CitHoraProgramada).'",

			"'.($this->CitTelefono).'",
			"'.($this->CitCelular).'",
			"'.($this->CitEmail).'",
			"'.($this->CitDescripcion).'",
			'.(empty($this->CitKilometrajeMantenimiento)?'NULL, ':'"'.$this->CitKilometrajeMantenimiento.'",').'
			
			'.($this->CitDuracion).', 
			
			"'.($this->CitVehiculoMarca).'",
			"'.($this->CitVehiculoModelo).'",
			"'.($this->CitVehiculoVersion).'",
			"'.($this->CitVehiculoPlaca).'",
			
			"'.($this->CitReferencia).'",			
			'.($this->CitEstado).', 
			"'.($this->CitTiempoCreacion).'", 
			"'.($this->CitTiempoModificacion).'");';					

			if(!$error){
				
				$resultado = $this->InsMysql->MtdEjecutar($sql,true);

				if(!$resultado) {						
					$error = true;
				} 	

			}

			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	
	
	public function MtdEditarCita() {
		
//		if($this->Transaccion){
//			$this->InsMysql->MtdTransaccionIniciar();
//		}
	
			$sql = 'UPDATE tblcitcita SET 
			
			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			
			
			'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			'.(empty($this->PerIdMecanico)?'PerIdMecanico = NULL, ':'PerIdMecanico = "'.$this->PerIdMecanico.'",').'
			
			CitFecha = "'.($this->CitFechaProgramada." ".$this->CitHoraProgramada." ".$this->CitTelefono).'",
			CitFechaProgramada = "'.($this->CitFechaProgramada).'",
			CitHoraProgramada = "'.($this->CitHoraProgramada).'",

			CitTelefono = "'.($this->CitTelefono).'",
			CitCelular = "'.($this->CitCelular).'",
			CitEmail = "'.($this->CitEmail).'",
			CitDescripcion = "'.($this->CitDescripcion).'",
			'.(empty($this->CitKilometrajeMantenimiento)?'CitKilometrajeMantenimiento = NULL, ':'CitKilometrajeMantenimiento = "'.$this->CitKilometrajeMantenimiento.'",').'

			
			CitDuracion = '.($this->CitDuracion).',
			
			CitVehiculoMarca = "'.($this->CitVehiculoMarca).'",
			CitVehiculoModelo = "'.($this->CitVehiculoModelo).'",
			CitVehiculoVersion = "'.($this->CitVehiculoVersion).'",
			CitVehiculoPlaca = "'.($this->CitVehiculoPlaca).'",
			
			CitReferencia = "'.($this->CitReferencia).'",
			CitEstado = '.($this->CitEstado).',
			CitTiempoModificacion = "'.($this->CitTiempoModificacion).'"
			WHERE CitId = "'.($this->CitId).'";';
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {
//				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionDeshacer();
//				}
				return false;
			} else {				
//				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionHacer();
//				}
				return true;
			}					
		}	
		
				
		
				
	
}
?>