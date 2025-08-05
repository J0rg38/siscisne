<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoIngresoPredictivo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoIngresoPredictivo {

    public $VipId;
	public $CliId;
	public $EinId;
	
	public $VipFichaIngresoFechaPredecida;
    public $VipFichaIngresoFechaUltimo;
	public $VipHoraProgramada;
	public $VipFichaIngresoMantenimientoKilometrajeUltimo;
	public $VipPromedioDiaMantenimiento;
	public $VipEmail;
	public $VipDescripcion;
	public $VipKilometrajeMantenimiento;
	
	public $VipEstado;	
    public $VipTiempoCreacion;
    public $VipTiempoModificacion;
    public $VipEliminado;

	public $InsMysql;

	public $Transaccion;
	
    public function __construct(){

		$this->InsMysql = new ClsMysql();
		$this->Transaccion = true;
		
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarVehiculoIngresoPredictivoId() {
	
			global $SucursalSiglas;
			
			$sql = 'SELECT	
			suc.SucSiglas AS SIGLA,
			MAX(CONVERT(SUBSTR(vip.VipId,5),unsigned)) AS "MAXIMO"
			FROM tblvipvehiculoingresopredictivo vip
				LEFT JOIN tblsucsucursal suc
				ON vip.SucId = suc.SucId
			
			WHERE vip.SucId = "'.$this->SucId.'"
			';
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

			if(empty($fila['MAXIMO'])){		

				$this->VipId = "VIP-10000-".(empty($fila['SIGLA'])?(empty($SucursalSiglas)?$_SESSION['SesionSucursalSiglas']:$SucursalSiglas):$fila['SIGLA']);

			}else{
				
				$fila['MAXIMO']++;
				$this->VipId = "VIP-".$fila['MAXIMO']."-".(empty($fila['SIGLA'])?(empty($SucursalSiglas)?$_SESSION['SesionSucursalSiglas']:$SucursalSiglas):$fila['SIGLA']);				
			
			}	
			
		}
		
    public function MtdObtenerVehiculoIngresoPredictivo(){

        $sql = 'SELECT 
        vip.VipId,
		vip.SucId,	
		vip.EinId,
		vip.CliId,
		vip.VipReferencia,
		
		DATE_FORMAT(vip.VipFichaIngresoFechaPredecida, "%d/%m/%Y") AS "NVipFichaIngresoFechaPredecida",
		DATE_FORMAT(vip.VipFichaIngresoFechaUltimo, "%d/%m/%Y") AS "NVipFichaIngresoFechaUltimo",		
		
		vip.VipFichaIngresoMantenimientoKilometrajeUltimo,
		vip.VipPromedioDiaMantenimiento,		
		vip.VipKilometrajeMantenimiento,
		
		vip.VipObservacionImpresa,
		vip.VipObservacionInterna,		
		
		vip.VipEstado,
	
		DATE_FORMAT(vip.VipTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVipTiempoCreacion",
        DATE_FORMAT(vip.VipTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVipTiempoModificacion",

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
		
        FROM tblvipvehiculoingresopredictivo vip
			LEFT JOIN tblclicliente cli
			ON vip.CliId = cli.CliId
				LEFT JOIN tbleinvehiculoingreso ein
				ON vip.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
									
        WHERE vip.VipId = "'.$this->VipId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
			{
				$this->VipId = $fila['VipId'];
				$this->SucId = $fila['SucId'];				
				$this->CliId = $fila['CliId'];
				$this->EinId = $fila['EinId'];
			
				$this->VipReferencia = $fila['VipReferencia'];
				
				$this->VipFichaIngresoFechaPredecida = $fila['NVipFichaIngresoFechaPredecida'];
				$this->VipFichaIngresoFechaUltimo = $fila['NVipFichaIngresoFechaUltimo'];
				
				$this->VipFichaIngresoMantenimientoKilometrajeUltimo = $fila['VipFichaIngresoMantenimientoKilometrajeUltimo'];			
				$this->VipPromedioDiaMantenimiento = $fila['VipPromedioDiaMantenimiento'];
				$this->VipKilometrajeMantenimiento = $fila['VipKilometrajeMantenimiento'];
		
				$this->VipObservacionImpresa = $fila['VipObservacionImpresa'];
				$this->VipObservacionInterna = $fila['VipObservacionInterna'];
				
				$this->VipEstado = $fila['VipEstado'];
				$this->VipTiempoCreacion = $fila['NVipTiempoCreacion'];
				$this->VipTiempoModificacion = $fila['NVipTiempoModificacion'];
				
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
			
				switch($this->VipEstado){
					case 1:
						$this->VipEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$this->VipEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$this->VipEstadoDescripcion = "Anulado";
				
					break;
					
				}
				
				
				switch($this->VipEstado){
					case 1:
						$this->VipEstadoIcono = '<img src="imagenes/estado/pendiente.png" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$this->VipEstadoIcono = '<img src="imagenes/estado/realizado.png" alt="[Realizado]" title="Realizado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$this->VipEstadoIcono = '<img src="imagenes/estado/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
					break;
					
				}
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoIngresoPredictivos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VipId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="VipFichaIngresoFechaPredecida",$oVehiculoIngresoId=NULL,$oSucursal=NULL) {



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
			$estado = ' AND vip.VipEstado = '.$oEstado;
		}	
		
		if(!empty($oCliente)){
			$cliente = ' AND vip.CliId = "'.$oCliente.'"';
		}
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vip.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(vip.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vip.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vip.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}

		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND vip.EinId = "'.$oVehiculoIngresoId.'"';
		}
		
			
		if(!empty($oSucursal)){
			$sucursal = ' AND vip.SucId = "'.$oSucursal.'"';
		}
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		vip.VipId,
		vip.CliId,
		vip.EinId,
		vip.PerId,
		vip.PerIdMecanico,

		DATE_FORMAT(vip.VipFichaIngresoFechaPredecida, "%d/%m/%Y") AS "NVipFecha",
		
		DATE_FORMAT(vip.VipFichaIngresoFechaUltimo, "%d/%m/%Y") AS "NVipFechaProgramada",
		vip.VipHoraProgramada,
		DATE_FORMAT(CONCAT(vip.VipFichaIngresoFechaUltimo," ",vip.VipHoraProgramada), "%d/%m/%Y %H:%m:%s") AS "VipFechaHoraInicio",
		DATE_FORMAT(DATE_ADD(CONCAT(vip.VipFichaIngresoFechaUltimo," ",vip.VipHoraProgramada), INTERVAL IFNULL(vip.VipObservacionImpresa,0) HOUR)  , "%d/%m/%Y %H:%m:%s")AS "VipFechaHoraFin",

		vip.VipFichaIngresoMantenimientoKilometrajeUltimo,
		vip.VipPromedioDiaMantenimiento,		
		vip.VipKilometrajeMantenimiento,
		
		vip.VipEmail,
		vip.VipDescripcion,
		vip.VipKilometrajeMantenimiento,
		
		vip.VipObservacionImpresa,
		
		IFNULL(vip.VipVehiculoMarca,vma.VmaNombre) AS VipVehiculoMarca,
		IFNULL(vip.VipVehiculoModelo,vmo.VmoNombre) AS VipVehiculoModelo,
		IFNULL(vip.VipVehiculoVersion,vve.VveNombre) AS VipVehiculoVersion,
		IFNULL(vip.VipVehiculoPlaca,ein.EinPlaca) AS VipVehiculoPlaca,
		
		vip.VipObservacionInterna,
vip.VipEstado,
	
		DATE_FORMAT(vip.VipTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVipTiempoCreacion",
        DATE_FORMAT(vip.VipTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVipTiempoModificacion",
		
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
		mec.PerApellidoMaterno AS PerApellidoMaternoMecanico
		
        FROM tblvipvehiculoingresopredictivo vip
			LEFT JOIN tblclicliente cli
			ON vip.CliId = cli.CliId
			
				LEFT JOIN tbleinvehiculoingreso ein
				ON vip.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per
								ON vip.PerId = per.PerId
									LEFT JOIN tblperpersonal mec
									ON vip.PerIdMecanico = mec.PerId
								
				WHERE 1 = 1 '.$filtrar.$estado.$cliente.$vingreso.$hora.$sfichaingreso.$sucursal.$pmecanico.$personal.$fecha.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoIngresoPredictivo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoIngresoPredictivo = new $InsVehiculoIngresoPredictivo();				
					
                    $VehiculoIngresoPredictivo->VipId = $fila['VipId'];
					$VehiculoIngresoPredictivo->SucId = $fila['SucId'];
					$VehiculoIngresoPredictivo->CliId = $fila['CliId'];
					$VehiculoIngresoPredictivo->EinId = $fila['EinId'];
					$VehiculoIngresoPredictivo->VipReferencia = $fila['VipReferencia'];
										
					$VehiculoIngresoPredictivo->VipFichaIngresoFechaPredecida = $fila['NVipFichaIngresoFechaPredecida'];
					$VehiculoIngresoPredictivo->VipFichaIngresoFechaUltimo = $fila['NVipFechaProgramada'];
					
					$VehiculoIngresoPredictivo->VipFichaIngresoMantenimientoKilometrajeUltimo= $fila['VipFichaIngresoMantenimientoKilometrajeUltimo'];
					$VehiculoIngresoPredictivo->VipPromedioDiaMantenimiento= $fila['VipPromedioDiaMantenimiento'];
					$VehiculoIngresoPredictivo->VipKilometrajeMantenimiento = $fila['VipKilometrajeMantenimiento'];

					
					$VehiculoIngresoPredictivo->VipObservacionImpresa = $fila['VipObservacionImpresa'];
					$VehiculoIngresoPredictivo->VipObservacionInterna = $fila['VipObservacionInterna'];
					
					$VehiculoIngresoPredictivo->VipEstado = $fila['VipEstado'];					
                    $VehiculoIngresoPredictivo->VipTiempoCreacion = $fila['NVipTiempoCreacion'];
                    $VehiculoIngresoPredictivo->VipTiempoModificacion = $fila['NVipTiempoModificacion'];    

					$VehiculoIngresoPredictivo->CliNombre = $fila['CliNombre'];    
					$VehiculoIngresoPredictivo->CliApellidoPaterno = $fila['CliApellidoPaterno'];    
					$VehiculoIngresoPredictivo->CliApellidoMaterno = $fila['CliApellidoMaterno'];   
					$VehiculoIngresoPredictivo->TdoId = $fila['TdoId'];  
					$VehiculoIngresoPredictivo->CliTelefono = $fila['CliTelefono'];
					$VehiculoIngresoPredictivo->CliCelular = $fila['CliCelular'];  
					
					$VehiculoIngresoPredictivo->CliContactoCelular1 = $fila['CliContactoCelular1'];  
					$VehiculoIngresoPredictivo->CliContactoCelular2 = $fila['CliContactoCelular2'];  
					$VehiculoIngresoPredictivo->CliContactoCelular3 = $fila['CliContactoCelular3'];  
	
					$VehiculoIngresoPredictivo->EinVIN = $fila['EinVIN'];    
					$VehiculoIngresoPredictivo->EinPlaca  = $fila['EinPlaca'];    
					
					$VehiculoIngresoPredictivo->VmaNombre = $fila['VmaNombre'];    
					$VehiculoIngresoPredictivo->VmoNombre = $fila['VmoNombre'];    
					$VehiculoIngresoPredictivo->VveNombre = $fila['VveNombre'];  
					
					
					$VehiculoIngresoPredictivo->PerApellidoPaterno = $fila['PerApellidoPaterno'];    
					$VehiculoIngresoPredictivo->PerApellidoMaterno = $fila['PerApellidoMaterno'];    
					$VehiculoIngresoPredictivo->PerNombre = $fila['PerNombre'];   
					
					$VehiculoIngresoPredictivo->PerNombreMecanico = $fila['PerNombreMecanico'];    
					$VehiculoIngresoPredictivo->PerApellidoPaternoMecanico = $fila['PerApellidoPaternoMecanico'];    
					$VehiculoIngresoPredictivo->PerApellidoMaternoMecanico = $fila['PerApellidoMaternoMecanico'];    
					
					 
				switch($VehiculoIngresoPredictivo->VipEstado){
					case 1:
						$VehiculoIngresoPredictivo->VipEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$VehiculoIngresoPredictivo->VipEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$VehiculoIngresoPredictivo->VipEstadoDescripcion = "Anulado";
				
					break;
					
				}
				
				
				switch($VehiculoIngresoPredictivo->VipEstado){
					case 1:
						$VehiculoIngresoPredictivo->VipEstadoIcono = '<img src="imagenes/estado/pendiente.png" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$VehiculoIngresoPredictivo->VipEstadoIcono = '<img src="imagenes/estado/realizado.png" alt="[Realizado]" title="Realizado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$VehiculoIngresoPredictivo->VipEstadoIcono = '<img src="imagenes/estado/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
					break;
					
				}
				
                    $VehiculoIngresoPredictivo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoIngresoPredictivo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	public function MtdObtenerVehiculoIngresoPredictivosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VipId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="VipFichaIngresoFechaPredecida",$oVehiculoIngresoId=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oDia=NULL) {

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
			$estado = ' AND vip.VipEstado = '.$oEstado;
		}	
		
		if(!empty($oCliente)){
			$cliente = ' AND vip.CliId = "'.$oCliente.'"';
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vip.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(vip.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vip.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vip.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}

	
		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND vip.EinId = "'.$oVehiculoIngresoId.'"';
		}	
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (vip.SucId) = "'.$oSucursal.'"';		
		}	
		
		
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(vip.VipFichaIngresoFechaPredecida) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(vip.VipFichaIngresoFechaPredecida) ="'.($oAno).'"';
		}
		
		if(!empty($oDia)){
			$dia = ' AND DAY(vip.VipFichaIngresoFechaPredecida) ="'.($oDia).'"';
		}
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		'.$funcion.' AS "RESULTADO"
		
        FROM tblvipvehiculoingresopredictivo vip
			LEFT JOIN tblclicliente cli
			ON vip.CliId = cli.CliId
				LEFT JOIN tbleinvehiculoingreso ein
				ON vip.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per
								ON vip.PerId = per.PerId
								
				WHERE 1 = 1 '.$ano.$mes.$dia.$filtrar.$estado.$sucursal.$vmarca.$hora.$cliente.$vingreso.$sfichaingreso .$personal.$fecha.$orden.$paginacion;
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoIngresoPredictivo($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VipId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VipId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblvipvehiculoingresopredictivo WHERE '.$eliminar;
			
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
	
	
	
	public function MtdActualizarEstadoVehiculoIngresoPredictivo($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
				
					$sql = 'UPDATE tblvipvehiculoingresopredictivo SET VipEstado = '.$oEstado.' WHERE   (VipId = "'.($elemento).'" )';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
//						$this->MtdAuditarBoleta(2,"Se actualizo el Estado de la VehiculoIngresoPredictivo",$aux);	
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


	

	public function MtdRegistrarVehiculoIngresoPredictivo() {
	

		global $Resultado;
		$error = false;
		//
//		$this->MtdVerificarExisteVehiculoIngresoPredictivo();
		
		//if(!empty($this->CliId)){
//			$error = true;
//			$Resultado.='#ERR_VIP_201';
//		}
			
			
			$this->MtdGenerarVehiculoIngresoPredictivoId();
				
			$sql = 'INSERT INTO tblvipvehiculoingresopredictivo (
			VipId,
			SucId,
			CliId,			
			EinId,
			
			VipFichaIngresoFechaPredecida,
			VipFichaIngresoFechaUltimo,
			
			VipFichaIngresoMantenimientoKilometrajeUltimo,			
			VipPromedioDiaMantenimiento,
			VipKilometrajeMantenimiento,
			
			VipObservacionImpresa,
			VipObservacionInterna,
			
			VipEstado,
			VipTiempoCreacion,
			VipTiempoModificacion
			) 
			VALUES (
			"'.($this->VipId).'",
			"'.($this->SucId).'",
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'	
			'.(empty($this->EinId)?'NULL, ':'"'.$this->EinId.'",').'
		
			'.(empty($this->VipFichaIngresoFechaPredecida)?'NULL, ':'"'.$this->VipFichaIngresoFechaPredecida.'",').'
			'.(empty($this->VipFichaIngresoFechaUltimo)?'NULL, ':'"'.$this->VipFichaIngresoFechaUltimo.'",').'
		
			'.($this->VipFichaIngresoMantenimientoKilometrajeUltimo).',
			'.($this->VipPromedioDiaMantenimiento).',
			'.(empty($this->VipKilometrajeMantenimiento)?'NULL, ':'"'.$this->VipKilometrajeMantenimiento.'",').'
			
			"'.($this->VipObservacionImpresa).'", 
			"'.($this->VipObservacionInterna).'",	
					
			'.($this->VipEstado).', 
			"'.($this->VipTiempoCreacion).'", 
			"'.($this->VipTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarVehiculoIngresoPredictivo() {
		
//		if($this->Transaccion){
//			$this->InsMysql->MtdTransaccionIniciar();
//		}
	
			$sql = 'UPDATE tblvipvehiculoingresopredictivo SET 
			
			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'
			
			'.(empty($this->VipFichaIngresoFechaPredecida)?'VipFichaIngresoFechaPredecida = NULL, ':'VipFichaIngresoFechaPredecida = "'.$this->VipFichaIngresoFechaPredecida.'",').'
			'.(empty($this->VipFichaIngresoFechaUltimo)?'VipFichaIngresoFechaUltimo = NULL, ':'VipFichaIngresoFechaUltimo = "'.$this->VipFichaIngresoFechaUltimo.'",').'


			VipFichaIngresoMantenimientoKilometrajeUltimo = "'.($this->VipFichaIngresoMantenimientoKilometrajeUltimo).'",
			VipPromedioDiaMantenimiento = "'.($this->VipPromedioDiaMantenimiento).'",
			'.(empty($this->VipKilometrajeMantenimiento)?'VipKilometrajeMantenimiento = NULL, ':'VipKilometrajeMantenimiento = "'.$this->VipKilometrajeMantenimiento.'",').'

			VipObservacionImpresa = '.($this->VipObservacionImpresa).',
			VipObservacionInterna = "'.($this->VipObservacionInterna).'",
			
			VipEstado = '.($this->VipEstado).',
			VipTiempoModificacion = "'.($this->VipTiempoModificacion).'"
			WHERE VipId = "'.($this->VipId).'";';
			
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