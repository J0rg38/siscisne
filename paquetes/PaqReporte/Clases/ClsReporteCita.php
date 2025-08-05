<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteCita
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteCita {

	
	public $Transaccion;
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
		$this->Transaccion = false;
    }
	
	public function __destruct(){

	}

	


 public function MtdObtenerReporteCitaFichaIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oPersonalMecanico=NULL,$oHora=NULL,$oSucursal=NULL) {



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
		
		suc.SucNombre,
		
		
		reg.PerNombre AS PerNombreRegistro,
		reg.PerApellidoPaterno AS PerApellidoPaternoRegistro,
		reg.PerApellidoMaterno AS PerApellidoMaternoRegistro,
		
		
		(
		SELECT 
		
		DATE_FORMAT(fin.FinFecha, "%d/%m/%Y")
		
		FROM tblfinfichaingreso fin
		WHERE fin.CitId = cit.CitId
		
		LIMIT 1
		) AS FinFecha
		
		
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
										
										LEFT JOIN tblperpersonal reg
										ON cit.PerIdRegistro = reg.PerId
										
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
										
					$Cita->CitFecha = $fila['NCitFecha'];
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
					
					$Cita->SucNombre = $fila['SucNombre'];    
					
					 
					$Cita->PerNombreRegistro = $fila['PerNombreRegistro'];    
					$Cita->PerApellidoPaternoRegistro = $fila['PerApellidoPaternoRegistro'];    
					$Cita->PerApellidoMaternoRegistro = $fila['PerApellidoMaternoRegistro'];   
					
					$Cita->FinFecha = $fila['FinFecha'];    
		 
		
				
				
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
				
}
?>