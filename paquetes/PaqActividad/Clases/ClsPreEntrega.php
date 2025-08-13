<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPreEntrega
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPreEntrega {

	public $PenId;
	public $PenFecha;
	public $PenAno;
	
	public $CamId;
	public $CliId;
	public $PerId;
	public $EinId;
	public $PenObservacion;
	public $PenEstado;
	public $PenTiempoCreacion;
	public $PenTiempoModificacion;
	
	public $TdoId;
	public $CliNumeroDocumento;
	public $CliNombre;
	public $CliNombreCompleto;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $TdoNombre;
	public $LtiId;
	public $LtiUtilidad;
	public $LtiNombre;
	public $LtiAbreviatura;
	public $EinVIN;
	public $VmaId;
	public $VmoId;
	public $VveId;
	public $EinAnoFabricacion;
	public $EinPlaca;
	public $EinColor;
	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	public $PerNombreAsesor;
	public $PerApellidoPaternoAsesor;
	public $PerApellidoMaternoAsesor;
	public $Ruta;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarPreEntregaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(pen.PenId,10),unsigned)) AS "MAXIMO"
		FROM tblpenpreentrega pen
			WHERE YEAR(pen.PenFecha) = '.$this->PenAno.';';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){			
			$this->PenId = "PDS-".$this->PenAno."-00001";
		}else{
			$fila['MAXIMO']++;
			$this->PenId = "PDS-".$this->PenAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
		}

	}
	
	public function MtdObtenerPreEntrega($oCompleto=true){

		$sql = 'SELECT 
        pen.PenId,  
		DATE_FORMAT(pen.PenFecha, "%d/%m/%Y") AS "NPenFecha",
		pen.CamId,
		pen.CliId,
		pen.PerId,		
		pen.EinId,
		pen.PenObservacion,
		pen.PenEstado,
		DATE_FORMAT(pen.PenTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPenTiempoCreacion",
        DATE_FORMAT(pen.PenTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPenTiempoModificacion",
		
		cli.TdoId,
		cli.CliNumeroDocumento,
		cli.CliNombre,
		cli.CliNombreCompleto,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		tdo.TdoNombre,
		cli.LtiId,
		lti.LtiUtilidad,
		lti.LtiNombre,
		lti.LtiAbreviatura,
		
		ein.EinVIN,
		ein.VmaId,
		ein.VmoId,
		ein.VveId,
		ein.EinAnoFabricacion,
		ein.EinPlaca,
		ein.EinColor,

		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre,

		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,

		per2.PerNombre AS PerNombreAsesor,
		per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
		per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,

		cam.CamCodigo,
		cam.CamNombre,
		cam.CamBoletin
		
        FROM tblpenpreentrega pen
				LEFT JOIN tblclicliente cli
				ON pen.CliId = cli.CliId
					LEFT JOIN tbllticlientetipo lti
					ON cli.LtiId = lti.LtiId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbleinvehiculoingreso ein
							ON pen.EinId = ein.EinId
								LEFT JOIN tblvehvehiculo veh
								ON ein.VehId = veh.VehId
									LEFT JOIN tblvvevehiculoversion vve
									ON ein.VveId = vve.VveId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON ein.VmoId = vmo.VmoId
											LEFT JOIN tblvmavehiculomarca vma
											ON vmo.Vmaid = vma.VmaId
											
												LEFT JOIN tblperpersonal per2
												ON pen.PerIdAsesor = per2.PerId

													LEFT JOIN tblcamcampana cam
													ON pen.CamId = cam.CamId

			LEFT JOIN tblperpersonal per
			ON pen.PerId = per.PerId
			
        WHERE pen.PenId = "'.$this->PenId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

		$this->PenId = $fila['PenId'];
		
		$this->PenFecha = $fila['NPenFecha'];
		$this->CamId = $fila['CamId'];
		$this->CliId = $fila['CliId'];
		$this->PerId = $fila['PerId'];
		$this->EinId = $fila['EinId'];
		
		$this->PenObservacion = $fila['PenObservacion'];
		$this->PenEstado = $fila['PenEstado'];
		$this->PenTiempoCreacion = $fila['NPenTiempoCreacion'];
		$this->PenTiempoModificacion = $fila['NPenTiempoModificacion'];
	
		$this->TdoId = $fila['TdoId'];
		$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
		$this->CliNombre = $fila['CliNombre'];
		$this->CliNombreCompleto = $fila['CliNombreCompleto'];
		$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
		$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
		
		$this->TdoNombre = $fila['TdoNombre'];
		$this->LtiId = $fila['LtiId'];
		$this->LtiUtilidad = $fila['LtiUtilidad'];
		$this->LtiNombre = $fila['LtiNombre'];
		$this->LtiAbreviatura = $fila['LtiAbreviatura'];
	
		$this->EinVIN = $fila['EinVIN'];
		$this->VmaId = $fila['VmaId'];
		$this->VmoId = $fila['VmoId'];
		$this->VveId = $fila['VveId'];
		$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];
		$this->EinPlaca = $fila['EinPlaca'];
		$this->EinColor = $fila['EinColor'];
	
		$this->VmaNombre = $fila['VmaNombre'];
		$this->VmoNombre = $fila['VmoNombre'];
		$this->VveNombre = $fila['VveNombre'];
		
		$this->PerNombre = $fila['PerNombre'];
		$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
		$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
		
		$this->PerNombreAsesor = $fila['PerNombreAsesor'];
		$this->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
		$this->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];


		$Estado = "";

			switch($this->PenEstado){

				case 1:
					$Estado = "<img src='".$this->Ruta."imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Pendiente]";
				break;
						
				case 11:
					$Estado = "<img src='".$this->Ruta."imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Enviado]";
				break;
					
											
				default:
					$Estado = "";
				break;								

			}
				
			$this->PenEstadoDescripcion = $Estado;
				
				
			if($oCompleto){
				
			
			$InsPreEntregaModalidad = new ClsPreEntregaModalidad();
			$ResPreEntregaModalidad = $InsPreEntregaModalidad->MtdObtenerPreEntregaModalidades(NULL,NULL,'PemId','ASC',NULL,$this->PenId,NULL);
			$ArrPreEntregaModalidades = $ResPreEntregaModalidad['Datos'];
			
			
			$InsPreEntregaTarea = new ClsPreEntregaTarea();
			$InsPreEntregaProducto = new ClsPreEntregaProducto();
			$InsPreEntregaSuministro = new ClsPreEntregaSuministro();
			$InsPreEntregaMantenimiento = new ClsPreEntregaMantenimiento();
			
			$InsFichaAccion = new ClsFichaAccion();
			
			$InsFichaAccionTarea = new ClsFichaAccionTarea();
			$InsFichaAccionTempario = new ClsFichaAccionTempario();
			$InsFichaAccionProducto = new ClsFichaAccionProducto();
			$InsFichaAccionMantenimiento = new ClsFichaAccionMantenimiento();
			$InsFichaAccionSuministro = new ClsFichaAccionSuministro();
			
			$InsTallerPedido = new ClsTallerPedido();
			$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();
			
			//echo "<h1>".count($ArrPreEntregaModalidades )."</h1>";
			
				$i = 1;
				
				$this->PreEntregaModalidad = array();
				
				foreach($ArrPreEntregaModalidades as $DatPreEntregaModalidad){
					
					
					
					$ResPreEntregaTarea = $InsPreEntregaTarea->MtdObtenerPreEntregaTareas(NULL,NULL,'FitId','ASC',NULL,$DatPreEntregaModalidad->PemId,NULL);
					$DatPreEntregaModalidad->PreEntregaTarea = $ResPreEntregaTarea['Datos'];
					

					$ResPreEntregaProducto = $InsPreEntregaProducto->MtdObtenerPreEntregaProductos(NULL,NULL,'FipId','ASC',NULL,$DatPreEntregaModalidad->PemId,NULL);
					$DatPreEntregaModalidad->PreEntregaProducto = $ResPreEntregaProducto['Datos'];
	
					$ResPreEntregaSuministro = $InsPreEntregaSuministro->MtdObtenerPreEntregaSuministros(NULL,NULL,'FisId','ASC',NULL,$DatPreEntregaModalidad->PemId,NULL);
					$DatPreEntregaModalidad->PreEntregaSuministro = $ResPreEntregaSuministro['Datos'];

					$ResPreEntregaMantenimiento = $InsPreEntregaMantenimiento->MtdObtenerPreEntregaMantenimientos(NULL,NULL,'FiaId','ASC',NULL,$DatPreEntregaModalidad->PemId,NULL,NULL,false,NULL);
					$DatPreEntregaModalidad->PreEntregaMantenimiento = $ResPreEntregaMantenimiento['Datos'];
	
	
					
					$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','ASC','1',$DatPreEntregaModalidad->PemId,NULL,NULL,NULL);
					$ArrFichaAcciones = $ResFichaAccion['Datos'];
	
					foreach($ArrFichaAcciones as $DatFichaAccion){
							
						$ResFichaAccionTarea = $InsFichaAccionTarea->MtdObtenerFichaAccionTareas(NULL,NULL,'FatId','ASC',NULL,$DatFichaAccion->FccId,NULL);
						$DatFichaAccion->FichaAccionTarea = $ResFichaAccionTarea['Datos'];
						
						$ResFichaAccionTempario = $InsFichaAccionTempario->MtdObtenerFichaAccionTemparios(NULL,NULL,NULL,'FaeId','ASC',NULL,$DatFichaAccion->FccId,NULL);
						$DatFichaAccion->FichaAccionTempario = $ResFichaAccionTempario['Datos'];
						
						////MtdObtenerFichaAccionProductos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FapId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL,$oFichaAccionMantenimiento=NULL,$oEstricto=1)
						$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,1);
						$DatFichaAccion->FichaAccionProducto = $ResFichaAccionProducto['Datos'];
						
						
						//MtdObtenerFichaAccionMantenimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FaaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL,$oNivel=NULL,$oSevero=false,$oAccion=NULL)
						
						//deb($DatFichaAccion->FccId);
						$ResFichaAccionMantenimiento = $InsFichaAccionMantenimiento->MtdObtenerFichaAccionMantenimientos(NULL,NULL,'FaaId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,false,NULL);
						$DatFichaAccion->FichaAccionMantenimiento = $ResFichaAccionMantenimiento['Datos'];
	//deb($DatFichaAccion->FichaAccionMantenimiento);
	
						$ResFichaAccionSuministro = $InsFichaAccionSuministro->MtdObtenerFichaAccionSuministros(NULL,NULL,'FasId','Desc',NULL,$DatFichaAccion->FccId,NULL);
						$DatFichaAccion->FichaAccionSuministro = $ResFichaAccionSuministro['Datos'];
				
						$DatPreEntregaModalidad->FichaAccion = $DatFichaAccion;
						
						$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoId','ASC','1',NULL,NULL,NULL,$DatFichaAccion->FccId);
						$ArrTallerPedidos = $ResTallerPedido['Datos'];
						//deb($ArrTallerPedidos);
						foreach($ArrTallerPedidos as $DatTallerPedido){
	
							$DatPreEntregaModalidad->FichaAccion->TallerPedido = $DatTallerPedido;
	
							$ResTallerPedidoDetalle =  $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetalles(NULL,NULL,NULL,NULL,NULL,$DatTallerPedido->AmoId);
							$DatPreEntregaModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle = $ResTallerPedidoDetalle['Datos'];
	
						}
					}
	
					//echo "<h3>".$i."</h3>";
	
					$this->PreEntregaModalidad[] = $DatPreEntregaModalidad;
					$i++;
				}
//
			}
		}
        

			
			
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
	
	
    public function MtdObtenerPreEntregas( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PenId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaPen=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oCampana=NULL,$oClienteTipo=NULL ) {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fecha = '';
		$estado = '';
		$prioridad = '';
		$mingreso = '';
		$vin = '';
		$cliente = '';
		$personal = '';
		$campana = '';
		$cltipo = '';

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
			
			if(!empty($oFechaPen)){
				$fecha = ' AND DATE(pen.PenFecha)>="'.$oFechaInicio.'" AND DATE(pen.PenFecha)<="'.$oFechaPen.'"';
			}else{
				$fecha = ' AND DATE(pen.PenFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaPen)){
				$fecha = ' AND DATE(pen.PenFecha)<="'.$oFechaPen.'"';		
			}			
		}



		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (pen.PenEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}

			$estado .= ' ) 

			)
			';

		}

		
		
		if(!empty($oPrioridad)){
			$prioridad = ' AND pen.PenPrioridad = '.$oPrioridad;
		}
		
		if(!empty($oModalidadIngreso)){
			$mingreso = ' AND EXISTS (
				SELECT pem.PemId
					FROM tblpempreentregamodalidadingreso pem
					WHERE pem.MinId = "'.$oModalidadIngreso.'"
					AND pem.PenId = pen.PenId
				LIMIT 1
			) ';
		}		
		
		if(!empty($oVIN)){
			$vin = ' AND ein.EinVIN = "'.$oVIN.'"';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND pen.CliId = "'.$oCliente.'"';
		}
		
		if(!empty($oPersonalId)){
			$personal = ' AND pen.PerId = "'.$oPersonalId.'"';
		}
		
		if(!empty($oCampana)){
			$campana = ' AND pen.CamId = "'.$oCampana.'"';
		}		


		if(!empty($oClienteTipo)){

			$elementos = explode(",",$oClienteTipo);

			$i=1;
			$cltipo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$cltipo .= '  (cli.LtiId = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$cltipo .= ' OR ';	
				}
			$i++;		
			}

			$cltipo .= ' ) 
			)
			';

		}

		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		pen.PenId,  
		DATE_FORMAT(pen.PenFecha, "%d/%m/%Y") AS "NPenFecha",
		pen.CamId,
		pen.CliId,
		pen.PerId,		
		pen.EinId,
		pen.PenObservacion,
		pen.PenEstado,
		DATE_FORMAT(pen.PenTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPenTiempoCreacion",
        DATE_FORMAT(pen.PenTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPenTiempoModificacion",
		
		cli.TdoId,
		cli.CliNumeroDocumento,
		cli.CliNombre,
		cli.CliNombreCompleto,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,

		tdo.TdoNombre,
		cli.LtiId,
		lti.LtiUtilidad,
		lti.LtiNombre,
		lti.LtiAbreviatura,
		
		ein.EinVIN,
		ein.VmaId,
		ein.VmoId,
		ein.VveId,
		ein.EinAnoFabricacion,
		ein.EinPlaca,
		ein.EinColor,

		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre,

		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,

		per2.PerNombre AS PerNombreAsesor,
		per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
		per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,

		cam.CamCodigo,
		cam.CamNombre,
		cam.CamBoletin
		
				FROM tblpenpreentrega pen
						LEFT JOIN tblclicliente cli
						ON pen.CliId = cli.CliId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
								LEFT JOIN tbltdotipodocumento tdo
								ON cli.TdoId = tdo.TdoId
									
									LEFT JOIN tbleinvehiculoingreso ein
									ON pen.EinId = ein.EinId
										LEFT JOIN tblvehvehiculo veh
										ON ein.VehId = veh.VehId
										
											LEFT JOIN tblvvevehiculoversion vve
											ON ein.VveId = vve.VveId
												LEFT JOIN tblvmovehiculomodelo vmo
												ON ein.VmoId = vmo.VmoId
													LEFT JOIN tblvmavehiculomarca vma
													ON vmo.Vmaid = vma.VmaId	
													
														LEFT JOIN tbliteinformetecnico ite
														ON ite.PenId = pen.PenId
																
															LEFT JOIN tblperpersonal per2
															ON pen.PerIdAsesor = per2.PerId
					LEFT JOIN tblperpersonal per
					ON pen.PerId = per.PerId
					
						LEFT JOIN tblcamcampana cam
						ON pen.CamId = cam.CamId
						
				WHERE 1 = 1 '.$filtrar.$fecha.$estado.$prioridad.$mingreso.$vin.$cliente.$personal.$tconcluido.$campana.$cltipo.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPreEntrega = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PreEntrega = new $InsPreEntrega();
                    $PreEntrega->PenId = $fila['PenId'];
					$PreEntrega->CliId = $fila['CliId'];
					$PreEntrega->EinId = $fila['EinId'];
					$PreEntrega->CamId = $fila['CamId'];
					
					$PreEntrega->PerId = $fila['PerId'];
					$PreEntrega->PerIdAsesor = $fila['PerIdAsesor'];
					
					$PreEntrega->PenManoObraPrecio = $fila['PenManoObraPrecio'];

					$PreEntrega->PenConductor = $fila['PenConductor'];
					$PreEntrega->PenTelefono = $fila['PenTelefono'];
					$PreEntrega->PenDireccion = $fila['PenDireccion'];
					$PreEntrega->PenContacto = $fila['PenContacto'];
					
					$PreEntrega->PenFecha = $fila['NPenFecha'];
					$PreEntrega->PenFechaEntrega = $fila['NPenFechaEntrega'];
					$PreEntrega->PenHoraEntrega = $fila['PenHoraEntrega'];
					
					$PreEntrega->PenFechaEntregaExtendida = $fila['NPenFechaEntregaExtendida'];
					$PreEntrega->PenHoraEntregaExtendida = $fila['PenHoraEntregaExtendida'];
					
					$PreEntrega->PenFechaCita = $fila['NPenFechaCita'];
					
					$PreEntrega->PenHora = $fila['PenHora'];
					$PreEntrega->PenPlaca = $fila['PenPlaca'];
					
					$PreEntrega->PenMantenimientoKilometraje = $fila['PenMantenimientoKilometraje'];
					$PreEntrega->PenObservacion = $fila['PenObservacion'];
					$PreEntrega->PenVehiculoKilometraje = $fila['PenVehiculoKilometraje'];
					
					$PreEntrega->PenExteriorDelantero1 = $fila['PenExteriorDelantero1'];
					$PreEntrega->PenExteriorDelantero2 = $fila['PenExteriorDelantero2'];
					$PreEntrega->PenExteriorDelantero3 = $fila['PenExteriorDelantero3'];
					$PreEntrega->PenExteriorDelantero4 = $fila['PenExteriorDelantero4'];
					$PreEntrega->PenExteriorDelantero5 = $fila['PenExteriorDelantero5'];
					$PreEntrega->PenExteriorDelantero6 = $fila['PenExteriorDelantero6'];
					$PreEntrega->PenExteriorDelantero7 = $fila['PenExteriorDelantero7'];
					
					$PreEntrega->PenExteriorPosterior1 = $fila['PenExteriorPosterior1'];
					$PreEntrega->PenExteriorPosterior2 = $fila['PenExteriorPosterior2'];
					$PreEntrega->PenExteriorPosterior3 = $fila['PenExteriorPosterior3'];
					$PreEntrega->PenExteriorPosterior4 = $fila['PenExteriorPosterior4'];
					$PreEntrega->PenExteriorPosterior5 = $fila['PenExteriorPosterior5'];
					$PreEntrega->PenExteriorPosterior6 = $fila['PenExteriorPosterior6'];
					
					$PreEntrega->PenExteriorDerecho1 = $fila['PenExteriorDerecho1'];
					$PreEntrega->PenExteriorDerecho2 = $fila['PenExteriorDerecho2'];
					$PreEntrega->PenExteriorDerecho3 = $fila['PenExteriorDerecho3'];
					$PreEntrega->PenExteriorDerecho4 = $fila['PenExteriorDerecho4'];
					$PreEntrega->PenExteriorDerecho5 = $fila['PenExteriorDerecho5'];
					$PreEntrega->PenExteriorDerecho6 = $fila['PenExteriorDerecho6'];
					$PreEntrega->PenExteriorDerecho7 = $fila['PenExteriorDerecho7'];
					$PreEntrega->PenExteriorDerecho8 = $fila['PenExteriorDerecho8'];
					
					$PreEntrega->PenExteriorIzquierdo1 = $fila['PenExteriorIzquierdo1'];
					$PreEntrega->PenExteriorIzquierdo2 = $fila['PenExteriorIzquierdo2'];
					$PreEntrega->PenExteriorIzquierdo3 = $fila['PenExteriorIzquierdo3'];
					$PreEntrega->PenExteriorIzquierdo4 = $fila['PenExteriorIzquierdo4'];
					$PreEntrega->PenExteriorIzquierdo5 = $fila['PenExteriorIzquierdo5'];
					$PreEntrega->PenExteriorIzquierdo6 = $fila['PenExteriorIzquierdo6'];
					$PreEntrega->PenExteriorIzquierdo7 = $fila['PenExteriorIzquierdo7'];
					
					
					$PreEntrega->PenInterior1 = $fila['PenInterior1'];
					$PreEntrega->PenInterior2 = $fila['PenInterior2'];
					$PreEntrega->PenInterior3 = $fila['PenInterior3'];
					$PreEntrega->PenInterior4 = $fila['PenInterior4'];
					$PreEntrega->PenInterior5 = $fila['PenInterior5'];
					$PreEntrega->PenInterior6 = $fila['PenInterior6'];
					$PreEntrega->PenInterior7 = $fila['PenInterior7'];
					$PreEntrega->PenInterior8 = $fila['PenInterior8'];
					$PreEntrega->PenInterior9 = $fila['PenInterior9'];
					$PreEntrega->PenInterior10 = $fila['PenInterior10'];
					$PreEntrega->PenInterior11 = $fila['PenInterior11'];
					$PreEntrega->PenInterior12 = $fila['PenInterior12'];
					$PreEntrega->PenInterior13 = $fila['PenInterior13'];
					$PreEntrega->PenInterior14 = $fila['PenInterior14'];
					$PreEntrega->PenInterior15 = $fila['PenInterior15'];
					$PreEntrega->PenInterior16 = $fila['PenInterior16'];
					$PreEntrega->PenInterior17 = $fila['PenInterior17'];
					$PreEntrega->PenInterior18 = $fila['PenInterior18'];
					$PreEntrega->PenInterior19 = $fila['PenInterior19'];
					$PreEntrega->PenInterior20 = $fila['PenInterior20'];
					$PreEntrega->PenInterior21 = $fila['PenInterior21'];
					$PreEntrega->PenInterior22 = $fila['PenInterior22'];
					$PreEntrega->PenInterior23 = $fila['PenInterior23'];
					$PreEntrega->PenInterior24 = $fila['PenInterior24'];
					$PreEntrega->PenInterior25 = $fila['PenInterior25'];
					$PreEntrega->PenInterior26 = $fila['PenInterior26'];
					$PreEntrega->PenInterior27 = $fila['PenInterior27'];
					
				
					
					$PreEntrega->PenInformeTecnicoMantenimiento= $fila['PenInformeTecnicoMantenimiento'];
					$PreEntrega->PenInformeTecnicoRevision= $fila['PenInformeTecnicoRevision'];
					$PreEntrega->PenInformeTecnicoDiagnostico= $fila['PenInformeTecnicoDiagnostico'];
					
					$PreEntrega->PenSalidaFecha= $fila['NPenSalidaFecha'];
					$PreEntrega->PenSalidaHora= $fila['PenSalidaHora'];
					$PreEntrega->PenSalidaObservacion= $fila['PenSalidaObservacion'];
					$PreEntrega->PenTerminadoObservacion= $fila['PenTerminadoObservacion'];
					
					
					$PreEntrega->PenInformeTecnico= $fila['PenInformeTecnico'];			
	
					$PreEntrega->PenPrioridad = $fila['PenPrioridad'];
					
					$PreEntrega->PenTiempoTallerConcluido = $fila['NPenTiempoTallerConcluido'];
					$PreEntrega->PenTiempoTallerRevisando = $fila['NPenTiempoTallerRevisando'];
					$PreEntrega->PenTiempoTrabajoTerminado = $fila['NPenTiempoTrabajoTerminado'];
	
	
	
					$PreEntrega->PenEstado = $fila['PenEstado'];
					$PreEntrega->PenTiempoCreacion = $fila['NPenTiempoCreacion'];  
					$PreEntrega->PenTiempoModificacion = $fila['NPenTiempoModificacion']; 
					
					$PreEntrega->MinNombre = $fila['MinNombre'];
					
					$PreEntrega->TdoId = $fila['TdoId']; 
					$PreEntrega->CliNombre = $fila['CliNombre']; 
					$PreEntrega->CliNumeroDocumento = $fila['CliNumeroDocumento'];

					$PreEntrega->LtiUtilidad = $fila['LtiUtilidad']; 
					$PreEntrega->LtiNombre = $fila['LtiNombre']; 
					$PreEntrega->LtiAbreviatura = $fila['LtiAbreviatura']; 

					$PreEntrega->EinVIN = $fila['EinVIN'];
					$PreEntrega->VmaId = $fila['VmaId'];
					$PreEntrega->VmoId = $fila['VmoId'];
					$PreEntrega->VveId = $fila['VveId'];
					$PreEntrega->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$PreEntrega->EinPlaca = $fila['EinPlaca'];
					$PreEntrega->EinColor = $fila['EinColor'];
					
					$PreEntrega->VmaNombre = $fila['VmaNombre'];
					$PreEntrega->VmoNombre = $fila['VmoNombre'];
					$PreEntrega->VveNombre = $fila['VveNombre'];
					
					$PreEntrega->PerNombre = $fila['PerNombre'];
					$PreEntrega->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$PreEntrega->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$PreEntrega->PerNombreAsesor = $fila['PerNombreAsesor'];
					$PreEntrega->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
					$PreEntrega->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];
					
					$PreEntrega->CamCodigo = $fila['CamCodigo'];
					$PreEntrega->CamNombre = $fila['CamNombre'];
					$PreEntrega->CamBoletin = $fila['CamBoletin'];
					
					$PreEntrega->PenGarantia = $fila['PenGarantia'];
					
			
			$Estado = "";
					switch($PreEntrega->PenEstado){
					
						case 1:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Pendiente]";
						break;
						
							case 11:	$Estado ="<img src='".$this->Ruta."imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Enviado]";
							break;
							
						case 2:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Revisando]";
						break;
					
						case 3:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Preparando Pedido]";
						break;	
						
						case 4:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Pedido Enviado]";
						break;
						
						case 5:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Revisado Pedido]";
						break;
						
						case 6:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Preparando Pedido]";
						break;
						
						case 7:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Pedido Enviado]";
						break;

							
						case 71:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Pedido Recibido]";
						break;
						
						case 72:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Pedido Extornado]";
						break;
						
						
						case 73:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Trabajo Terminado]";
						break;

						case 74:
							//$Estado ="<img src='".$this->Ruta."imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Revisando]";
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/recepcion.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Trabajo Terminado]";
						break;

						case 75:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Conforme/Por Facturar]";
						break;

						
						case 8:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Por Facturar]";
						break;
						
						
						
						case 9:
							$Estado ="<img src='".$this->Ruta."imagenes/iconos/contabilidad.png' alt='CONTABILIDAD' border='0' width='20' height='20' title='CONTABILIDAD' > [Facturado]";						
						break;	
						
						default:
							$Estado ="";
						break;					

					}
				
				
					$PreEntrega->IteId = $fila['IteId'];
					
					$PreEntrega->PenEstadoDescripcion = $Estado;
					
                    $PreEntrega->InsMysql = NULL;                    
	
					$Respuesta['Datos'][]= $PreEntrega;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	    public function MtdObtenerPreEntregasTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PenId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaPen=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL) {


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
			
			if(!empty($oFechaPen)){
				$fecha = ' AND DATE(pen.PenFecha)>="'.$oFechaInicio.'" AND DATE(pen.PenFecha)<="'.$oFechaPen.'"';
			}else{
				$fecha = ' AND DATE(pen.PenFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaPen)){
				$fecha = ' AND DATE(pen.PenFecha)<="'.$oFechaPen.'"';		
			}			
		}



		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (pen.PenEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}

			$estado .= ' ) 

				'.(($oTrabajoConcluido==1)?' OR pen.PenTiempoTallerConcluido IS NOT NULL':'').'
			)
			';

		}
		
//		if(!empty($oEstado)){
//			$estado = ' AND pen.PenEstado = '.$oEstado;
//		}
		
		
		if(!empty($oPrioridad)){
			$prioridad = ' AND pen.PenPrioridad = '.$oPrioridad;
		}
		
		

		if(!empty($oModalidadIngreso)){

			$elementos = explode(",",$oModalidadIngreso);

			$i=1;
			$mingreso .= ' AND (
			
			
			 EXISTS (
				SELECT pem.PemId
					FROM tblpempreentregamodalidadingreso pem
					WHERE
			
				(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$mingreso .= '  (pem.MinId = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$mingreso .= ' OR ';	
				}
			$i++;		
			}
			
			$mingreso .= ' ) 
			
				AND pem.PenId = pen.PenId
				LIMIT 1
				)
			)
			';

		}
		//echo $mingreso;
		//
		//
//		if(!empty($oModalidadIngreso)){
//			$mingreso = ' AND EXISTS (
//				SELECT pem.PemId
//					FROM tblpempreentregamodalidadingreso pem
//					WHERE pem.MinId = "'.$oModalidadIngreso.'"
//					AND pem.PenId = pen.PenId
//				LIMIT 1
//			) ';
//		}		
		
		if(!empty($oVIN)){
			$vin = ' AND ein.EinVIN = "'.$oVIN.'"';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND pen.CliId = "'.$oCliente.'"';
		}
		
		if(!empty($oPersonalId)){
			$personal = ' AND pen.PerId = "'.$oPersonalId.'"';
		}
		
		if(!empty($oCampana)){
			$campana = ' AND pen.CamId = "'.$oCampana.'"';
		}		


		if(!empty($oClienteTipo)){

			$elementos = explode(",",$oClienteTipo);

			$i=1;
			$cltipo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$cltipo .= '  (cli.LtiId = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$cltipo .= ' OR ';	
				}
			$i++;		
			}

			$cltipo .= ' ) 
			)
			';

		}
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND ein.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
		
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(pen.PenFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(pen.PenFecha) ="'.($oAno).'"';
		}
			//echo "<br>";echo "<br>";
				$sql = 'SELECT
				'.$funcion.' AS "RESULTADO"
				
				FROM tblpenpreentrega pen
						LEFT JOIN tblclicliente cli
						ON pen.CliId = cli.CliId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
								LEFT JOIN tbltdotipodocumento tdo
								ON cli.TdoId = tdo.TdoId
									
									LEFT JOIN tbleinvehiculoingreso ein
									ON pen.EinId = ein.EinId
										LEFT JOIN tblvehvehiculo veh
										ON ein.VehId = veh.VehId
										
											LEFT JOIN tblvvevehiculoversion vve
											ON ein.VveId = vve.VveId
												LEFT JOIN tblvmovehiculomodelo vmo
												ON ein.VmoId = vmo.VmoId
													LEFT JOIN tblvmavehiculomarca vma
													ON vmo.Vmaid = vma.VmaId	
													
														LEFT JOIN tbliteinformetecnico ite
														ON ite.PenId = pen.PenId
																
															LEFT JOIN tblperpersonal per2
															ON pen.PerIdAsesor = per2.PerId
					LEFT JOIN tblperpersonal per
					ON pen.PerId = per.PerId
					
						LEFT JOIN tblcamcampana cam
						ON pen.CamId = cam.CamId
						
				WHERE 1 = 1 '.$ano.$mes.$filtrar.$fecha.$estado.$prioridad.$mingreso.$vin.$cliente.$personal.$tconcluido.$campana.$cltipo.$vmarca.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			

			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}

	//Accion eliminar	 
	public function MtdEliminarPreEntrega($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
						
						$this->PenId = $elemento;
//
//						$this->MtdObtenerPreEntrega();
//							
//							$validar = 0;
//							if(!empty($this->PreEntregaModalidad)){
//								foreach($this->PreEntregaModalidad as $DatPreEntregaModalidad){
//
//									$InsPreEntregaModalidad = new ClsPreEntregaModalidad();
//									if($InsPreEntregaModalidad->MtdEliminarPreEntregaModalidad($DatPreEntregaModalidad->PemId)){
//										$validar++;
//									}else{
//										$error = true;	
//									}
//									
//								}
//							}

					if(!$error){
						
						$sql = 'DELETE FROM tblpenpreentrega WHERE  (PenId = "'.($this->PenId).'" ) ';

						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

						if(!$resultado) {						
							$error = true;
						}else{
							//$InsPreEntregaModalidad = new ClsPreEntregaModalidad();
							//$ResPreEntregaModalidad = $InsPreEntregaModalidad->MtdObtenerPreEntregaModalidades(NULL,NULL,'PemId','ASC',NULL,$oPreEntrega=NULL,$oEstado=NULL);
							$this->MtdAuditarPreEntrega(3,"Se elimino la Orden de Trabajo",$aux);		
						}

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
	public function MtdActualizarEstadoPreEntrega($oElementos,$oEstado,$oTransaccion=true) {
		
		global $Resultado;
		
		$error = false;
		
		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();			
		}

		$elementos = explode("#",$oElementos);

		//$InsPreEntrega = new ClsPreEntrega();
		//$InsPreEntregaTareas = new ClsPreEntregaTarea();

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
					
					$this->PenId = $elemento;
					$this->MtdObtenerPreEntrega(false);

					switch($oEstado){
							
							case 1://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: RECEPCION [Pendiente]";
								
								if($this->PenEstado == 11){
							
									$sql = 'UPDATE tblpenpreentrega SET 
									PenEstado = '.$oEstado.',
									PenTiempoModificacion = NOW()					
									WHERE PenId = "'.$elemento.'"';
				
									$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
									
									if(!$resultado) {						
										$error = true;
									}else{
										
										$this->PenTiempoTallerRevisando = NULL;
										$this->PenTiempoModificacion = date("Y-m-d H:i:s");
										$this->MtdEditarPreEntregaTallerRevisando();
				
				
										$Auditoria = $this->MtdDefinirAuditoria($oEstado);
										$this->PenId = $elemento;
										$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
									}
					
								}else{
									
									$error = true;
									$Resultado.='#OT: '.$this->PenId;
									$Resultado.='#ERR_FIN_913';
					
								}
								
							break;

							case 11://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: RECEPCION [Enviado]";

								//deb($this->PenEstado);
								
								if($this->PenEstado == 1 || $this->PenEstado == 2 || $this->PenEstado == 3){
										
									
									
									if($this->PenEstado == 2 || $this->PenEstado == 3){
											
											







			
											$InsPreEntregaModalidad = new ClsPreEntregaModalidad();
											$InsFichaAccion = new ClsFichaAccion();
											$InsFichaAccionProducto = new ClsFichaAccionProducto();
											
											$ResPreEntregaModalidad = $InsPreEntregaModalidad->MtdObtenerPreEntregaModalidades(NULL,NULL,'PemId','ASC',NULL,$this->PenId,NULL);
											$ArrPreEntregaModalidades = $ResPreEntregaModalidad['Datos'];
													
													//deb($ArrPreEntregaModalidades);	
											foreach($ArrPreEntregaModalidades as $DatPreEntregaModalidad){
											
												$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','ASC','1',$DatPreEntregaModalidad->PemId,NULL,NULL,NULL);
												$ArrFichaAcciones = $ResFichaAccion['Datos'];
												
												
												//deb($ArrFichaAcciones);
												
												if(!empty($ArrFichaAcciones)){
													$faccion = '';
													foreach($ArrFichaAcciones as $DatFichaAccion){
														$faccion .= '#'.$DatFichaAccion->FccId;
													}
													
													if(!$InsFichaAccion->MtdEliminarFichaAccion($faccion)){
														$error = true;
													}
													
												}
												
												
												
												
											}
																
								
										$this->PenTiempoTallerRevisando = NULL;
										$this->PenTiempoModificacion = date("Y-m-d H:i:s");
										$this->MtdEditarPreEntregaTallerRevisando();
					
					
					
									}
									
									
									if(!$error){

									$sql = 'UPDATE tblpenpreentrega SET 
									PenEstado = '.$oEstado.',
									PenTiempoModificacion = NOW()					
									WHERE PenId = "'.$elemento.'"';
				
									$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
									
									if(!$resultado) {						
										$error = true;
									}else{
										$Auditoria = $this->MtdDefinirAuditoria($oEstado);
										$this->PenId = $elemento;
										$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
									}

										
									}
					
								}else{
									
									$error = true;
									$Resultado.='#OT: '.$this->PenId;
									$Resultado.='#ERR_FIN_900';
					
								}
									
							break;
							
							case 2://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: TALLER [Revisando]";
							
							
								if($this->PenEstado == 11){
							
									$sql = 'UPDATE tblpenpreentrega SET 
									PenEstado = '.$oEstado.',
									PenTiempoModificacion = NOW()					
									WHERE PenId = "'.$elemento.'"';
				
									$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
									
									if(!$resultado) {						
										$error = true;
									}else{
										$Auditoria = $this->MtdDefinirAuditoria($oEstado);
										$this->PenId = $elemento;
										$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
									}
					
								}else{
									
									$error = true;
									$Resultado.='#OT: '.$this->PenId;
									$Resultado.='#ERR_FIN_901';

								}
								
							break;
						
							case 3://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: TALLER [Preparando Pedido]";
							
								if($this->PenEstado == 2 || $this->PenEstado == 4){
							
							




$InsPreEntregaModalidad = new ClsPreEntregaModalidad();
								$InsFichaAccion = new ClsFichaAccion();
								$InsFichaAccionProducto = new ClsFichaAccionProducto();
								
								$ResPreEntregaModalidad = $InsPreEntregaModalidad->MtdObtenerPreEntregaModalidades(NULL,NULL,'PemId','ASC',NULL,$this->PenId,NULL);
								$ArrPreEntregaModalidades = $ResPreEntregaModalidad['Datos'];
											
								foreach($ArrPreEntregaModalidades as $DatPreEntregaModalidad){
								
									$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','ASC','1',$DatPreEntregaModalidad->PemId,NULL,NULL,NULL);
									$ArrFichaAcciones = $ResFichaAccion['Datos'];
									
									foreach($ArrFichaAcciones as $DatFichaAccion){
											
										$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,1,"C");
										$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
										
										if(!empty($ArrFichaAccionProductos)){
											foreach($ArrFichaAccionProductos as $DatFichaAccionProducto){
												
												$InsFichaAccionProducto->FapId = $DatFichaAccionProducto->FapId;
												$InsFichaAccionProducto->FapVerificar2 = 1;
												$InsFichaAccionProducto->MtdEditarFichaAccionProductoVerificar2();

											}
										}
										
										
										$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,2);
										$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
										
										if(!empty($ArrFichaAccionProductos)){
											foreach($ArrFichaAccionProductos as $DatFichaAccionProducto){
												
												$InsFichaAccionProducto->FapId = $DatFichaAccionProducto->FapId;
												$InsFichaAccionProducto->FapVerificar2 = 1;
												$InsFichaAccionProducto->MtdEditarFichaAccionProductoVerificar2();

											}
										}
										
										
										
									}
								}
																
								
								
								
								
									$sql = 'UPDATE tblpenpreentrega SET 
									PenEstado = '.$oEstado.',
									PenTiempoModificacion = NOW()					
									WHERE PenId = "'.$elemento.'"';
				
									$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
									
									if(!$resultado) {						
										$error = true;
									}else{
										$Auditoria = $this->MtdDefinirAuditoria($oEstado);
										$this->PenId = $elemento;
										$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
									}
					
								}else{

									$error = true;
									$Resultado.='#OT: '.$this->PenId;
									$Resultado.='#ERR_FIN_902';

								}
								
											
									
							break;	
							
							case 4://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: TALLER [Pedido Enviado]";
							
								//deb($this->PenEstado);
//								if($this->PenEstado == 3 || $this->PenEstado == 5 || $this->PenEstado == 6){
								if($this->PenEstado == 3 || $this->PenEstado == 5 || $this->PenEstado == 6 
								|| $this->PenEstado == 7 ){								


									if($this->PenEstado == 3){

										$InsPreEntregaModalidad = new ClsPreEntregaModalidad();
										$InsFichaAccion = new ClsFichaAccion();
										$InsFichaAccionProducto = new ClsFichaAccionProducto();
										
										$ResPreEntregaModalidad = $InsPreEntregaModalidad->MtdObtenerPreEntregaModalidades(NULL,NULL,'PemId','ASC',NULL,$this->PenId,NULL);
										$ArrPreEntregaModalidades = $ResPreEntregaModalidad['Datos'];
												
												
										foreach($ArrPreEntregaModalidades as $DatPreEntregaModalidad){
										
											$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','ASC','1',$DatPreEntregaModalidad->PemId,NULL,NULL,NULL);
											$ArrFichaAcciones = $ResFichaAccion['Datos'];
											
											foreach($ArrFichaAcciones as $DatFichaAccion){
													
												$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,1,"C");
												$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
												
												if(!empty($ArrFichaAccionProductos)){
													foreach($ArrFichaAccionProductos as $DatFichaAccionProducto){
														
														$InsFichaAccionProducto->FapId = $DatFichaAccionProducto->FapId;
														$InsFichaAccionProducto->FapVerificar2 = 2;
														$InsFichaAccionProducto->MtdEditarFichaAccionProductoVerificar2();
		
													}
												}
												
												
												$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,2);
												$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
												
												if(!empty($ArrFichaAccionProductos)){
													foreach($ArrFichaAccionProductos as $DatFichaAccionProducto){
														
														$InsFichaAccionProducto->FapId = $DatFichaAccionProducto->FapId;
														$InsFichaAccionProducto->FapVerificar2 = 2;
														$InsFichaAccionProducto->MtdEditarFichaAccionProductoVerificar2();
		
													}
												}
												
												
												
											}
										}
										
									}else{
										
										$InsTallerPedido = new ClsTallerPedido();
										
										$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoId','ASC',NULL,NULL,NULL,NULL,NULL,$this->PenId);
										$ArrTallerPedidos = $ResTallerPedido['Datos'];				
					
										//deb($ArrTallerPedidos);
										if(!empty($ArrTallerPedidos)){
											
											$tpedido = "";											
											foreach($ArrTallerPedidos as $DatTallerPedido){
												$tpedido.="#".$DatTallerPedido->AmoId;
											}
											
											//deb($tpedido);
											if(!($InsTallerPedido->MtdEliminarTallerPedido($tpedido,false))){
												$error = true;
											}
											
											
												
										}
										
									}
									

									//deb($error);
								
								
									if(!$error){
										
										$sql = 'UPDATE tblpenpreentrega SET 
										PenEstado = '.$oEstado.',
										PenTiempoModificacion = NOW()					
										WHERE PenId = "'.$elemento.'"';
	
										$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
	
										if(!$resultado) {						
											$error = true;
										}else{
											$Auditoria = $this->MtdDefinirAuditoria($oEstado);
											$this->PenId = $elemento;
											$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
										}
										
									}

								}else{

									$error = true;
									$Resultado.='#OT: '.$this->PenId;
									$Resultado.='#ERR_FIN_903';

								}
								
							break;
							
							case 5://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: ALMACEN [Revisado Pedido]";
								
								if($this->PenEstado == 4){

									$sql = 'UPDATE tblpenpreentrega SET 
									PenEstado = '.$oEstado.',
									PenTiempoModificacion = NOW()					
									WHERE PenId = "'.$elemento.'"';
			
									$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
									
									if(!$resultado) {						
										$error = true;
									}else{
										$Auditoria = $this->MtdDefinirAuditoria($oEstado);
										$this->PenId = $elemento;
										$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
									}
					
								}else{

									$error = true;
									$Resultado.='#OT: '.$this->PenId;
									$Resultado.='#ERR_FIN_904';

								}
								
								
								
							break;
							
							case 6://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: ALMACEN [Preparando Pedido]";
								
								if($this->PenEstado == 5){

									$sql = 'UPDATE tblpenpreentrega SET 
									PenEstado = '.$oEstado.',
									PenTiempoModificacion = NOW()					
									WHERE PenId = "'.$elemento.'"';
			
									$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
									
									if(!$resultado) {						
										$error = true;
									}else{
										$Auditoria = $this->MtdDefinirAuditoria($oEstado);
										$this->PenId = $elemento;
										$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
									}
					
								}else{

									$error = true;
									$Resultado.='#OT: '.$this->PenId;
									$Resultado.='#ERR_FIN_905';

								}
								
								
							break;
							
							case 7://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: ALMACEN [Pedido Enviado]";

								if($this->PenEstado == 6 || $this->PenEstado == 72){
									

									
									$InsTallerPedido = new ClsTallerPedido();
									
									$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoId','ASC',NULL,NULL,NULL,NULL,NULL,$this->PenId);
									$ArrTallerPedidos = $ResTallerPedido['Datos'];				

									if(!empty($ArrTallerPedidos)){
										
										$tpedido = "";
										foreach($ArrTallerPedidos as $DatTallerPedido){										
											$tpedido.="#".$DatTallerPedido->AmoId;
										}
										
										if(!$InsTallerPedido->MtdActualizarEstadoTallerPedido($tpedido,3,false)){
											$error = true;
										}

									}
					
									if(!$error){

										$sql = 'UPDATE tblpenpreentrega SET 
										PenEstado = '.$oEstado.',
										PenTiempoModificacion = NOW()					
										WHERE PenId = "'.$elemento.'"';
				
										$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
									
										if(!$resultado) {						
											$error = true;
										}else{
											$Auditoria = $this->MtdDefinirAuditoria($oEstado);
											$this->PenId = $elemento;
											$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
										}
										
					
									}
					
									
									if(!$error){
										
										if($this->PenEstado == 6){
											
											
											if(!empty($this->PenTiempoTallerConcluido)){
												
												if(!$this->MtdActualizarEstadoPreEntrega($this->PenId,71,false)){
														$error = true;
												}
											}
											
										}
										
									}
									
									//deb("xd");
									
									if(!$error){
										
										//deb($this->PenEstado);
										//deb(":33");
										if($this->PenEstado == 7){

											if(!empty($this->PenTiempoTallerConcluido)){
													
												if(!$this->MtdActualizarEstadoPreEntrega($this->PenId,73,false)){
													$error = true;
												}
											}
											
										}
										
									}
									
								}else{

									$error = true;
									$Resultado.='#OT: '.$this->PenId;
									$Resultado.='#ERR_FIN_906';

								}
								
								
							break;
							
							
														
						case 71://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a:TALLER [Pedido Recibido]";
							
							if($this->PenEstado == 7 || $this->PenEstado == 73 || $this->PenEstado == 74){

								if($this->PenEstado == 73){
									$ActualizarEstado = true;
	
									$InsPreEntregaModalidad = new ClsPreEntregaModalidad();
									$InsFichaAccion = new ClsFichaAccion();
									$InsFichaAccionProducto = new ClsFichaAccionProducto();
	
									$ResPreEntregaModalidad = $InsPreEntregaModalidad->MtdObtenerPreEntregaModalidades(NULL,NULL,'PemId','ASC',NULL,$this->PenId,NULL);
									$ArrPreEntregaModalidades = $ResPreEntregaModalidad['Datos'];
												
									foreach($ArrPreEntregaModalidades as $DatPreEntregaModalidad){
									
										$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','ASC','1',$DatPreEntregaModalidad->PemId,NULL,NULL,NULL);
										$ArrFichaAcciones = $ResFichaAccion['Datos'];
										
										foreach($ArrFichaAcciones as $DatFichaAccion){
												
											$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,1,"C");
											$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
											
											if(!empty($ArrFichaAccionProductos)){
												$ActualizarEstado = false;
											}
											
											$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,2);
											$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
											
											if(!empty($ArrFichaAccionProductos)){
												$ActualizarEstado = false;
											}
											
										}
									}
									
									
									if($ActualizarEstado){
										$oEstado = 3;
									}
									
									
									
									$this->PenTiempoTrabajoTerminado = NULL;
									$this->PenTiempoModificacion = date("Y-m-d H:i:s");
									$this->MtdEditarPreEntregaTrabajoTerminado();
				
									
								}

								
									$sql = 'UPDATE tblpenpreentrega SET 
									PenEstado = '.$oEstado.',
									PenTiempoModificacion = NOW()					
									WHERE PenId = "'.$elemento.'"';
			
									$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
									
									if(!$resultado) {						
										$error = true;
									}else{
										$Auditoria = $this->MtdDefinirAuditoria($oEstado);
										$this->PenId = $elemento;
										$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
									}
					
								}else{

									$error = true;
									$Resultado.='#OT: '.$this->PenId;
									$Resultado.='#ERR_FIN_907';

								}
								
								
						break;
						
						case 72://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a:ALMACEN [Pedido Extornado]";
							
							if($this->PenEstado == 7 || $this->PenEstado == 71 || $this->PenEstado == 72){

								$sql = 'UPDATE tblpenpreentrega SET 
								PenEstado = '.$oEstado.',
								PenTiempoModificacion = NOW()					
								WHERE PenId = "'.$elemento.'"';
		
								$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
								
								if(!$resultado) {						
									$error = true;
								}else{
									$Auditoria = $this->MtdDefinirAuditoria($oEstado);
									$this->PenId = $elemento;
									$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
								}

							}else{

								$error = true;
								$Resultado.='#OT: '.$this->PenId;
								$Resultado.='#ERR_FIN_908';

							}

						break;
						
		
						
						
						case 73://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a:TALLER [Trabajo Terminado]";
							
							if($this->PenEstado == 7 || $this->PenEstado == 71 || $this->PenEstado == 3){

								$ActualizarEstado = true;

								if($this->PenEstado <> 71 ){
								
									$InsPreEntregaModalidad = new ClsPreEntregaModalidad();
									$InsFichaAccion = new ClsFichaAccion();
									$InsFichaAccionProducto = new ClsFichaAccionProducto();
									
									$ResPreEntregaModalidad = $InsPreEntregaModalidad->MtdObtenerPreEntregaModalidades(NULL,NULL,'PemId','ASC',NULL,$this->PenId,NULL);
									$ArrPreEntregaModalidades = $ResPreEntregaModalidad['Datos'];
												
									foreach($ArrPreEntregaModalidades as $DatPreEntregaModalidad){
									
										$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','ASC','1',$DatPreEntregaModalidad->PemId,NULL,NULL,NULL);
										$ArrFichaAcciones = $ResFichaAccion['Datos'];
										
										foreach($ArrFichaAcciones as $DatFichaAccion){
												
											$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,1,"C");
											$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
											
											if(!empty($ArrFichaAccionProductos)){
												$ActualizarEstado = false;
											}
											
											$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,2);
											$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
											
											if(!empty($ArrFichaAccionProductos)){
												$ActualizarEstado = false;
											}
											
										}
									}	
									
								}
								
								
								
								
								if($ActualizarEstado){
			
									$sql = 'UPDATE tblpenpreentrega SET 
									PenEstado = '.$oEstado.',
									PenTiempoModificacion = NOW()					
									WHERE PenId = "'.$elemento.'"';
			
									$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
									
									if(!$resultado) {						
										$error = true;
									}else{

										$this->PenTiempoTrabajoTerminado = date("Y-m-d H:i:s");
										$this->PenTiempoModificacion = date("Y-m-d H:i:s");
										$this->MtdEditarPreEntregaTrabajoTerminado();
										
										if(empty($this->PenTiempoTallerConcluido)){
											
											$this->PenTiempoTallerConcluido = date("Y-m-d H:i:s");	
											$this->MtdEditarPreEntregaTallerConcluido();
			
										}
										
										$Auditoria = $this->MtdDefinirAuditoria($oEstado);
										$this->PenId = $elemento;
										$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
									}
							
								}else{
									$error = true;
									$Resultado.='#OT: '.$this->PenId;
									$Resultado.='#ERR_FIN_9090';
								}
								

							}else{

								$error = true;
								$Resultado.='#OT: '.$this->PenId;
								$Resultado.='#ERR_FIN_909';

							}
							
							
						break;

						case 74://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a:RECEPCION [Revisando]";

							if($this->PenEstado == 73 || $this->PenEstado == 75){

								$sql = 'UPDATE tblpenpreentrega SET 
								PenEstado = '.$oEstado.',
								PenTiempoModificacion = NOW()					
								WHERE PenId = "'.$elemento.'"';
		
								$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
								
								if(!$resultado) {						
									$error = true;
								}else{
									$Auditoria = $this->MtdDefinirAuditoria($oEstado);
									$this->PenId = $elemento;
									$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
								}
				
							}else{

								$error = true;
								$Resultado.='#OT: '.$this->PenId;
								$Resultado.='#ERR_FIN_910';

							}
							
							
						break;

						case 75://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a:RECEPCION [Conforme/Por Facturar]";

							if($this->PenEstado == 74 || $this->PenEstado == 9){

								$sql = 'UPDATE tblpenpreentrega SET 
								PenEstado = '.$oEstado.',
								PenTiempoModificacion = NOW()					
								WHERE PenId = "'.$elemento.'"';
		
								$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
								
								if(!$resultado) {						
									$error = true;
								}else{
									$Auditoria = $this->MtdDefinirAuditoria($oEstado);
									$this->PenId = $elemento;
									$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
								}
				
							}else{

								$error = true;
								$Resultado.='#OT: '.$this->PenId;
								$Resultado.='#ERR_FIN_911';

							}
							
						break;

							case 8://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: TALLER [Por Facturar]";
								
							break;
							
							case 9://$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: CONTABILIDAD [Facturado]";						

								//deb($this->PenEstado);
								
								if($this->PenEstado == 75){
	
									$sql = 'UPDATE tblpenpreentrega SET 
									PenEstado = '.$oEstado.',
									PenTiempoModificacion = NOW()					
									WHERE PenId = "'.$elemento.'"';
			
									$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

									if(!$resultado) {						
										$error = true;
									}else{
										$Auditoria = $this->MtdDefinirAuditoria($oEstado);
										$this->PenId = $elemento;
										$this->MtdAuditarPreEntrega(2,$Auditoria,$elemento);
									}
					
								}else{

									$error = true;
									$Resultado.='#OT: '.$this->PenId;
									$Resultado.='#ERR_FIN_912';

								}
							
							
							break;	
							
							default:
								$Auditoria = "Error";
							break;	
						
						}
						
						 
						
						
					

				}
			$i++;
			}

		//deb($Auditoria);
//deb($error);
//deb($oTransaccion);
		if($error){	
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		}else{
			if($oTransaccion){				
				$this->InsMysql->MtdTransaccionHacer();			
			}
			return true;
		}									
	}
	
	private function MtdDefinirAuditoria($oEstado){
		
		$Auditoria = "";
		
		switch($oEstado){
							
							case 1:
								$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: RECEPCION [Pendiente]";
							break;

							case 11:

//								$this->PenId = $elemento;
//								$this->MtdObtenerPreEntrega(false);
//									
//								$this->PenEstado = 1;
//								
//								if($this->PenEstado == 1){
//									
//									
//								}
								
								
//									if(!empty($this->PreEntregaModalidad)){
//										foreach($this->PreEntregaModalidad as $DatPreEntregaModalidad){
//
//											if(!empty($DatPreEntregaModalidad->FichaAccion->FccId)){
//
//												$InsFichaAccion = new ClsFichaAccion();
//	
//												if(!$InsFichaAccion->MtdEliminarFichaAccion($DatPreEntregaModalidad->FichaAccion->FccId)){
//													$error = true;
//													break;
//												}
//
//												
//											}
////											foreach($DatPreEntregaModalidad->FichaAccion as $DatFichaAccion){
////												deb($DatFichaAccion);
////												echo "<hr>";
////												$InsFichaAccion = new ClsFichaAccion();
////												//$InsFichaAccion->FccId = $DatFichaAccion->FccId;
////												if(!$InsFichaAccion->MtdEliminarFichaAccion($DatFichaAccion->FccId)){
////													$error = true;
////													break;
////												}
////
////											}
//											
//										}
//									}
										
								$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: RECEPCION [Enviado]";
									
							break;
							
							case 2:
								$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: TALLER [Revisando]";
							break;
						
							case 3:
								$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: TALLER [Preparando Pedido]";
								
									
							break;	
							
							case 4:
								$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: TALLER [Pedido Enviado]";
							break;
							
							case 5:
								$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: ALMACEN [Revisado Pedido]";
							break;
							
							case 6:
								$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: ALMACEN [Preparando Pedido]";
							break;
							
							case 7:
								$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: ALMACEN [Pedido Enviado]";
							break;
							
							
														
						case 71:
							$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a:TALLER [Pedido Recibido]";
						break;
						
						case 72:
							$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a:ALMACEN [Pedido Extornado]";
						break;
						
		
						
						
						case 73:
							$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a:TALLER [Trabajo Terminado]";
						break;

						case 74:
							$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a:RECEPCION [Revisando]";
						break;

						case 75:
							$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a:RECEPCION [Conforme/Por Facturar]";
						break;


							case 8:
								$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: TALLER [Por Facturar]";
							break;
							
							case 9:
								$Auditoria = "Se actualizo el Estado de la ORDEN DE TRABAJO a: CONTABILIDAD [Facturado]";						
							break;	
							
							default:
								$Auditoria = "Error";
							break;	
						
						}
						
						return $Auditoria;
	}
	
	
	public function MtdRegistrarPreEntrega() {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarPreEntregaId();

			$this->InsMysql->MtdTransaccionIniciar();		
			
			
			
			
			
			
			$sql = 'INSERT INTO tblpenpreentrega (
			PenId,				
			EinId,
			CamId,
			
			CliId,
			PerId,
			PerIdAsesor,
			PmaId,
			
			OvvId,
			TreId,
			
			PenManoObraPrecio,
			PenPrecioEstimado,
			
			PenConductor,
			PenTelefono,
			PenDireccion,
			PenContacto,
			
			PenFecha,
			
			PenFechaEntrega,
			PenHoraEntrega,

			PenFechaEntregaExtendida,
			PenHoraEntregaExtendida,

			PenFechaCita,
			
			PenHora,
			PenPlaca,

			PenMantenimientoKilometraje,			
			PenVehiculoKilometraje,			
			PenObservacion,		
			
			PenExteriorDelantero1,
			PenExteriorDelantero2,
			PenExteriorDelantero3,
			PenExteriorDelantero4,
			PenExteriorDelantero5,
			PenExteriorDelantero6,
			PenExteriorDelantero7,
			
			PenExteriorPosterior1,
			PenExteriorPosterior2,
			PenExteriorPosterior3,
			PenExteriorPosterior4,
			PenExteriorPosterior5,
			PenExteriorPosterior6,
			
			PenExteriorDerecho1,
			PenExteriorDerecho2,
			PenExteriorDerecho3,
			PenExteriorDerecho4,
			PenExteriorDerecho5,
			PenExteriorDerecho6,
			PenExteriorDerecho7,
			PenExteriorDerecho8,
			
			PenExteriorIzquierdo1,
			PenExteriorIzquierdo2,
			PenExteriorIzquierdo3,
			PenExteriorIzquierdo4,
			PenExteriorIzquierdo5,
			PenExteriorIzquierdo6,
			PenExteriorIzquierdo7,
			
			
			PenInterior1,
			PenInterior2,
			PenInterior3,
			PenInterior4,
			PenInterior5,
			PenInterior6,
			PenInterior7,
			PenInterior8,
			PenInterior9,
			PenInterior10,
			PenInterior11,
			PenInterior12,
			PenInterior13,
			PenInterior14,
			PenInterior15,
			PenInterior16,
			PenInterior17,
			PenInterior18,
			PenInterior19,
			PenInterior20,
			PenInterior21,
			PenInterior22,
			PenInterior23,
			PenInterior24,
			PenInterior25,
			PenInterior26,
			PenInterior27,
		
		
			PenInformeTecnicoMantenimiento,
			PenInformeTecnicoRevision,
			PenInformeTecnicoDiagnostico,
			
			PenSalidaFecha,
			PenSalidaHora,
			PenSalidaObservacion,
			PenTerminadoObservacion,
			PenPrioridad,
			
			PenTiempoTallerConcluido,
			PenTiempoTallerRevisando,
			PenTiempoTrabajoTerminado,
			
			PenEstado,			
			
			PenTiempoCreacion,
			PenTiempoModificacion
			) 
			VALUES (
			"'.($this->PenId).'",
			'.(empty($this->EinId)?"NULL,":'"'.$this->EinId.'",').'
			'.(empty($this->CamId)?"NULL,":'"'.$this->CamId.'",').'
			
			'.(empty($this->CliId)?'NULL,':'"'.$this->CliId.'",').'
			'.(empty($this->PerId)?'NULL,':'"'.$this->PerId.'",').'
			'.(empty($this->PerIdAsesor)?'NULL,':'"'.$this->PerIdAsesor.'",').'
			
			'.(empty($this->PmaId)?'NULL,':'"'.$this->PmaId.'",').'
			
			NULL,
			NULL,
			
			0,
			'.($this->PenPrecioEstimado).',
			
			"'.($this->PenConductor).'",
			"'.($this->PenTelefono).'",
			"'.($this->PenDireccion).'",
			"'.($this->PenContacto).'",
			
			"'.($this->PenFecha).'", 
			
			'.(empty($this->PenFechaEntrega)?'NULL,':'"'.$this->PenFechaEntrega.'",').'		
			"'.($this->PenHoraEntrega).'", 

			'.(empty($this->PenFechaEntregaExtendida)?'NULL,':'"'.$this->PenFechaEntregaExtendida.'",').'		
			"'.($this->PenHoraEntregaExtendida).'", 
			
			'.(empty($this->PenFechaCita)?'NULL,':'"'.$this->PenFechaCita.'",').'		
			
			"'.($this->PenHora).'", 
			"'.($this->PenPlaca).'", 

			'.($this->PenMantenimientoKilometraje).',
			'.($this->PenVehiculoKilometraje).',
			"'.($this->PenObservacion).'",
			
			'.($this->PenExteriorDelantero1).',
			'.($this->PenExteriorDelantero2).',
			'.($this->PenExteriorDelantero3).',
			'.($this->PenExteriorDelantero4).',
			'.($this->PenExteriorDelantero5).',
			'.($this->PenExteriorDelantero6).',
			'.($this->PenExteriorDelantero7).',
			
			'.($this->PenExteriorPosterior1).',
			'.($this->PenExteriorPosterior2).',
			'.($this->PenExteriorPosterior3).',
			'.($this->PenExteriorPosterior4).',
			'.($this->PenExteriorPosterior5).',
			'.($this->PenExteriorPosterior6).',
			
			'.($this->PenExteriorDerecho1).',
			'.($this->PenExteriorDerecho2).',
			'.($this->PenExteriorDerecho3).',
			'.($this->PenExteriorDerecho4).',
			'.($this->PenExteriorDerecho5).',
			'.($this->PenExteriorDerecho6).',
			'.($this->PenExteriorDerecho7).',
			'.($this->PenExteriorDerecho8).',
			
			'.($this->PenExteriorIzquierdo1).',
			'.($this->PenExteriorIzquierdo2).',
			'.($this->PenExteriorIzquierdo3).',
			'.($this->PenExteriorIzquierdo4).',
			'.($this->PenExteriorIzquierdo5).',
			'.($this->PenExteriorIzquierdo6).',
			'.($this->PenExteriorIzquierdo7).',
			
			'.($this->PenInterior1).',
			'.($this->PenInterior2).',
			'.($this->PenInterior3).',
			'.($this->PenInterior4).',
			'.($this->PenInterior5).',
			'.($this->PenInterior6).',
			'.($this->PenInterior7).',
			'.($this->PenInterior8).',
			'.($this->PenInterior9).',
			'.($this->PenInterior10).',
			'.($this->PenInterior11).',
			'.($this->PenInterior12).',
			'.($this->PenInterior13).',
			'.($this->PenInterior14).',
			'.($this->PenInterior15).',
			'.($this->PenInterior16).',
			'.($this->PenInterior17).',
			'.($this->PenInterior18).',
			'.($this->PenInterior19).',
			'.($this->PenInterior20).',
			'.($this->PenInterior21).',
			'.($this->PenInterior22).',
			'.($this->PenInterior23).',
			'.($this->PenInterior24).',
			'.($this->PenInterior25).',
			'.($this->PenInterior26).',
			'.($this->PenInterior27).',
			
			"'.($this->PenInformeTecnicoMantenimiento).'",
			"'.($this->PenInformeTecnicoRevision).'",
			"'.($this->PenInformeTecnicoDiagnostico).'",
			
			'.(empty($this->PenSalidaFecha)?'NULL,':'"'.$this->PenSalidaFecha.'",').'	
			'.(empty($this->PenSalidaHora)?'NULL,':'"'.$this->PenSalidaHora.'",').'	

			"'.($this->PenSalidaObservacion).'",
			"'.($this->PenTerminadoObservacion).'",
			'.($this->PenPrioridad).',
			
			NULL,
			NULL,
			NULL,
			
			'.($this->PenEstado).',
			"'.($this->PenTiempoCreacion).'", 				
			"'.($this->PenTiempoModificacion).'");';

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

			if(!$resultado) {							
				$error = true;
			} 

			if(!$error){
				if(!empty($this->EinId)){
					if(!empty($this->CliId)){
						$InsVehiculoIngreso = new ClsVehiculoIngreso();
						if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoCliente($this->EinId,$this->CliId)){
							$error = true;
							$Resultado.='#ERR_FIN_604';							
						}
					}else{
						$error = true;
						$Resultado.='#ERR_FIN_602';
					}
				}else{
					$error = true;
					$Resultado.='#ERR_FIN_601';
				}
			}
			
			if(!$error){
				$InsVehiculoIngreso = new ClsVehiculoIngreso();
				
				
				
				if(!$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinPlaca",$this->PenPlaca,$this->EinId)){
					$Resultado.='#ERR_FIN_605';		
					$error = true;
				}
				
				
				//if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoPlaca($this->EinId,$this->PenPlaca)){
//					$Resultado.='#ERR_FIN_605';		
//					$error = true;
//				}
			}

			if(!$error){		
			
				if (!empty($this->PreEntregaModalidad)){		
				
					$validar = 0;	
					$InsPreEntregaModalidad = new ClsPreEntregaModalidad();		
							
					foreach ($this->PreEntregaModalidad as $DatPreEntregaModalidad){
						
						$InsModalidadIngreso = new ClsModalidadIngreso();
						$InsModalidadIngreso->MinId = $DatPreEntregaModalidad->MinId;
						$InsModalidadIngreso->MtdObtenerModalidadIngreso();
												
						$InsPreEntregaModalidad->PenId = $this->PenId;
						$InsPreEntregaModalidad->MinId = $DatPreEntregaModalidad->MinId;
						$InsPreEntregaModalidad->PemObsequio = $DatPreEntregaModalidad->PemObsequio;

						$InsPreEntregaModalidad->PemEstado = $DatPreEntregaModalidad->PemEstado;
						$InsPreEntregaModalidad->PreEntregaProducto = $DatPreEntregaModalidad->PreEntregaProducto;
						$InsPreEntregaModalidad->PreEntregaTarea = $DatPreEntregaModalidad->PreEntregaTarea;
						$InsPreEntregaModalidad->PreEntregaSuministro = $DatPreEntregaModalidad->PreEntregaSuministro;
						$InsPreEntregaModalidad->PreEntregaMantenimiento = $DatPreEntregaModalidad->PreEntregaMantenimiento;
						
						$InsPreEntregaModalidad->PemTiempoCreacion = $DatPreEntregaModalidad->PemTiempoCreacion;
						$InsPreEntregaModalidad->PemTiempoModificacion = $DatPreEntregaModalidad->PemTiempoModificacion;
						$InsPreEntregaModalidad->PemEliminado = $DatPreEntregaModalidad->PemEliminado;
						
						$InsPreEntregaModalidad->FichaAccion = $DatPreEntregaModalidad->FichaAccion;
						
						if($InsPreEntregaModalidad->MtdRegistrarPreEntregaModalidad()){
							$validar++;					
						}else{
							$Resultado.='#Modalidad: '.strtoupper($InsModalidadIngreso->MinNombre);		
							$Resultado.='#ERR_FIN_201';
						}
						
					}					
					
					if(count($this->PreEntregaModalidad) <> $validar ){
						$error = true;
					}	
					
				}
				
			}
			
	
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarPreEntrega(1,"Se registro la Orden de Trabajo",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarPreEntrega() {

		global $Resultado;
		$error = false;

			$this->InsMysql->MtdTransaccionIniciar();


			
			$sql = 'UPDATE tblpenpreentrega SET
			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'
			'.(empty($this->CamId)?'CamId = NULL, ':'CamId = "'.$this->CamId.'",').'
			
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			'.(empty($this->PerIdAsesor)?'PerIdAsesor = NULL, ':'PerIdAsesor = "'.$this->PerIdAsesor.'",').'
			
			'.(empty($this->PmaId)?'PmaId = NULL, ':'PmaId = "'.$this->PmaId.'",').'
			
			PenPrecioEstimado = '.($this->PenPrecioEstimado).',

			PenConductor = "'.($this->PenConductor).'",
			PenTelefono = "'.($this->PenTelefono).'",
			PenDireccion = "'.($this->PenDireccion).'",
			PenContacto = "'.($this->PenContacto).'",
			
			PenFecha = "'.($this->PenFecha).'",
			
			'.(empty($this->PenFechaEntrega)?'PenFechaEntrega = NULL, ':'PenFechaEntrega = "'.$this->PenFechaEntrega.'",').'
			PenHoraEntrega = "'.($this->PenHoraEntrega).'",
			
			'.(empty($this->PenFechaEntregaExtendida)?'PenFechaEntregaExtendida = NULL, ':'PenFechaEntregaExtendida = "'.$this->PenFechaEntregaExtendida.'",').'
			PenHoraEntregaExtendida = "'.($this->PenHoraEntregaExtendida).'",
			
			'.(empty($this->PenFechaCita)?'PenFechaCita = NULL, ':'PenFechaCita = "'.$this->PenFechaCita.'",').'
			
			PenHora = "'.($this->PenHora).'",
			PenPlaca = "'.($this->PenPlaca).'",

			PenMantenimientoKilometraje = '.($this->PenMantenimientoKilometraje).',						
			PenVehiculoKilometraje = '.($this->PenVehiculoKilometraje).',			
			PenObservacion = "'.($this->PenObservacion).'",
			
			PenExteriorDelantero1 = '.($this->PenExteriorDelantero1).',
			PenExteriorDelantero2 = '.($this->PenExteriorDelantero2).',
			PenExteriorDelantero3 = '.($this->PenExteriorDelantero3).',
			PenExteriorDelantero4 = '.($this->PenExteriorDelantero4).',
			PenExteriorDelantero5 = '.($this->PenExteriorDelantero5).',
			PenExteriorDelantero6 = '.($this->PenExteriorDelantero6).',
			PenExteriorDelantero7 = '.($this->PenExteriorDelantero7).',
			
			PenExteriorPosterior1 = '.($this->PenExteriorPosterior1).',
			PenExteriorPosterior2 = '.($this->PenExteriorPosterior2).',
			PenExteriorPosterior3 = '.($this->PenExteriorPosterior3).',
			PenExteriorPosterior4 = '.($this->PenExteriorPosterior4).',
			PenExteriorPosterior5 = '.($this->PenExteriorPosterior5).',
			PenExteriorPosterior6 = '.($this->PenExteriorPosterior6).',
			
			PenExteriorDerecho1 = '.($this->PenExteriorDerecho1).',
			PenExteriorDerecho2 = '.($this->PenExteriorDerecho2).',
			PenExteriorDerecho3 = '.($this->PenExteriorDerecho3).',
			PenExteriorDerecho4 = '.($this->PenExteriorDerecho4).',
			PenExteriorDerecho5 = '.($this->PenExteriorDerecho5).',
			PenExteriorDerecho6 = '.($this->PenExteriorDerecho6).',
			PenExteriorDerecho7 = '.($this->PenExteriorDerecho7).',
			PenExteriorDerecho8 = '.($this->PenExteriorDerecho8).',
			
			PenExteriorIzquierdo1 = '.($this->PenExteriorIzquierdo1).',
			PenExteriorIzquierdo2 = '.($this->PenExteriorIzquierdo2).',
			PenExteriorIzquierdo3 = '.($this->PenExteriorIzquierdo3).',
			PenExteriorIzquierdo4 = '.($this->PenExteriorIzquierdo4).',
			PenExteriorIzquierdo5 = '.($this->PenExteriorIzquierdo5).',
			PenExteriorIzquierdo6 = '.($this->PenExteriorIzquierdo6).',
			PenExteriorIzquierdo7 = '.($this->PenExteriorIzquierdo7).',
			
			
			PenInterior1 = '.($this->PenInterior1).',
			PenInterior2 = '.($this->PenInterior2).',
			PenInterior3 = '.($this->PenInterior3).',
			PenInterior4 = '.($this->PenInterior4).',
			PenInterior5 = '.($this->PenInterior5).',
			PenInterior6 = '.($this->PenInterior6).',
			PenInterior7 = '.($this->PenInterior7).',
			PenInterior8 = '.($this->PenInterior8).',
			PenInterior9 = '.($this->PenInterior9).',
			PenInterior10 = '.($this->PenInterior10).',
			PenInterior11 = '.($this->PenInterior11).',
			PenInterior12 = '.($this->PenInterior12).',
			PenInterior13 = '.($this->PenInterior13).',
			PenInterior14 = '.($this->PenInterior14).',
			PenInterior15 = '.($this->PenInterior15).',
			PenInterior16 = '.($this->PenInterior16).',
			PenInterior17 = '.($this->PenInterior17).',
			PenInterior18 = '.($this->PenInterior18).',
			PenInterior19 = '.($this->PenInterior19).',
			PenInterior20 = '.($this->PenInterior20).',
			PenInterior21 = '.($this->PenInterior21).',
			PenInterior22 = '.($this->PenInterior22).',
			PenInterior23 = '.($this->PenInterior23).',
			PenInterior24 = '.($this->PenInterior24).',
			PenInterior25 = '.($this->PenInterior25).',
			PenInterior26 = '.($this->PenInterior26).',
			PenInterior27 = '.($this->PenInterior27).',
		
			PenInformeTecnicoMantenimiento = "'.($this->PenInformeTecnicoMantenimiento).'",
			PenInformeTecnicoRevision = "'.($this->PenInformeTecnicoRevision).'",
			PenInformeTecnicoDiagnostico = "'.($this->PenInformeTecnicoDiagnostico).'",
			'.(empty($this->PenSalidaFecha)?'PenSalidaFecha = NULL, ':'PenSalidaFecha = "'.$this->PenSalidaFecha.'",').'
			PenSalidaHora = "'.($this->PenSalidaHora).'",
			PenSalidaObservacion = "'.($this->PenSalidaObservacion).'",
	
			PenPrioridad = '.($this->PenPrioridad).',
			PenEstado = '.($this->PenEstado).',
			PenTiempoModificacion = "'.($this->PenTiempoModificacion).'"
			WHERE PenId = "'.($this->PenId).'";';			
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			
				
//			if(!$error){
//				
//				$InsVehiculoIngreso = new ClsVehiculoIngreso();
//				if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoCliente($this->EinId,$this->CliId)){
//					$error = true;
//				}
//			}

			if(!$error){
				if(!empty($this->EinId)){
					if(!empty($this->CliId)){
						$InsVehiculoIngreso = new ClsVehiculoIngreso();
						if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoCliente($this->EinId,$this->CliId)){
							$error = true;
							$Resultado.='#ERR_FIN_604';
						}
					}else{
						$Resultado.='#ERR_FIN_602';
					}
				}else{
					$Resultado.='#ERR_FIN_601';
				}
			}

			if(!$error){
				$InsVehiculoIngreso = new ClsVehiculoIngreso();
				
								
				if(!$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinPlaca",$this->PenPlaca,$this->EinId)){
					$Resultado.='#ERR_FIN_605';		
					$error = true;
				}
				
				//if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoPlaca($this->EinId,$this->PenPlaca)){
//					$error = true;
//					$Resultado.='#ERR_FIN_605';
//				}
			}

			if(!$error){
				if (!empty($this->PreEntregaModalidad)){		

					$validar = 0;	
						
					$InsPreEntregaModalidad = new ClsPreEntregaModalidad();		

					foreach ($this->PreEntregaModalidad as $DatPreEntregaModalidad){
						
						$InsModalidadIngreso = new ClsModalidadIngreso();
						$InsModalidadIngreso->MinId = $DatPreEntregaModalidad->MinId;
						$InsModalidadIngreso->MtdObtenerModalidadIngreso();
						
						$InsPreEntregaModalidad->PemId = $DatPreEntregaModalidad->PemId;
						$InsPreEntregaModalidad->PenId = $this->PenId;
						$InsPreEntregaModalidad->MinId = $DatPreEntregaModalidad->MinId;
						$InsPreEntregaModalidad->PemObsequio = $DatPreEntregaModalidad->PemObsequio;
						$InsPreEntregaModalidad->PemEstado = $DatPreEntregaModalidad->PemEstado;
						
						$InsPreEntregaModalidad->PreEntregaProducto = $DatPreEntregaModalidad->PreEntregaProducto;
						$InsPreEntregaModalidad->PreEntregaTarea = $DatPreEntregaModalidad->PreEntregaTarea;
						$InsPreEntregaModalidad->PreEntregaSuministro = $DatPreEntregaModalidad->PreEntregaSuministro;
						$InsPreEntregaModalidad->PreEntregaMantenimiento = $DatPreEntregaModalidad->PreEntregaMantenimiento;
						
						$InsPreEntregaModalidad->PemTiempoCreacion = $DatPreEntregaModalidad->PemTiempoCreacion;
						$InsPreEntregaModalidad->PemTiempoModificacion = $DatPreEntregaModalidad->PemTiempoModificacion;
						$InsPreEntregaModalidad->PemEliminado = $DatPreEntregaModalidad->PemEliminado;
						
						$InsPreEntregaModalidad->FichaAccion = $DatPreEntregaModalidad->FichaAccion;

						if(empty($InsPreEntregaModalidad->PemId)){
							if($InsPreEntregaModalidad->PemEliminado<>2){
								if($InsPreEntregaModalidad->MtdRegistrarPreEntregaModalidad()){
									$validar++;					
								}else{
									$Resultado.='#Modalidad: '.strtoupper($InsModalidadIngreso->MinNombre);		
									$Resultado.='#ERR_FIN_201';									
								}
							}else{
								$validar++;	
							}
							
						}else{						
							if($InsPreEntregaModalidad->PemEliminado==2){
								if($InsPreEntregaModalidad->MtdEliminarPreEntregaModalidad($InsPreEntregaModalidad->PemId)){
									$validar++;					
								}else{
									$Resultado.='#Modalidad: '.strtoupper($InsModalidadIngreso->MinNombre);
									$Resultado.='#ERR_FIN_203';									
								}
							}else{
								if($InsPreEntregaModalidad->MtdEditarPreEntregaModalidad()){
									$validar++;					
								}else{
									$Resultado.='#Modalidad: '.strtoupper($InsModalidadIngreso->MinNombre);
									$Resultado.='#ERR_FIN_202';									
								}
							}
						}	
						
					}					
					
					if(count($this->PreEntregaModalidad) <> $validar ){
						$error = true;
					}	
					
				}
			}
			
			
			
			if(!$error){
				if (!empty($this->PreEntregaHerramienta)){		

					$validar = 0;		
					$item = 1;		
					$InsPreEntregaHerramienta = new ClsPreEntregaHerramienta();		

					foreach ($this->PreEntregaHerramienta as $DatPreEntregaHerramienta){
				
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatPreEntregaHerramienta->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						$InsPreEntregaHerramienta->FihId = $DatPreEntregaHerramienta->FihId;
						$InsPreEntregaHerramienta->PenId = $this->PenId;
						$InsPreEntregaHerramienta->ProId = $DatPreEntregaHerramienta->ProId;
						$InsPreEntregaHerramienta->UmeId = $DatPreEntregaHerramienta->UmeId;
						$InsPreEntregaHerramienta->FihCantidad = $DatPreEntregaHerramienta->FihCantidad;
						$InsPreEntregaHerramienta->FihCantidadReal = $DatPreEntregaHerramienta->FihCantidadReal;
						$InsPreEntregaHerramienta->FihEstado = $DatPreEntregaHerramienta->FihEstado;
						$InsPreEntregaHerramienta->FihTiempoCreacion = $DatPreEntregaHerramienta->FihTiempoCreacion;
						$InsPreEntregaHerramienta->FihTiempoModificacion = $DatPreEntregaHerramienta->FihTiempoModificacion;
						$InsPreEntregaHerramienta->PemEliminado = $DatPreEntregaHerramienta->PemEliminado;
						
						if(empty($InsPreEntregaHerramienta->FihId)){
							if($InsPreEntregaHerramienta->PenEliminado<>2){
								
								if(!empty($InsPreEntregaHerramienta->ProId)){
									if(!empty($InsPreEntregaHerramienta->UmeId)){
										if(!empty($InsPreEntregaHerramienta->FihCantidad)){
											if(!empty($InsPreEntregaHerramienta->FihCantidadReal)){
												
												if($InsPreEntregaHerramienta->MtdRegistrarPreEntregaHerramienta()){
													$validar++;					
												}else{
													$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado.='#ERR_FIN_211';
												}											
												
											}else{
												$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado.='#ERR_FIN_217';												
											}
											
										}else{
											$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
											$Resultado.='#ERR_FIN_216';
										}
									}else{
										$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
										$Resultado.='#ERR_FIN_214';
									}									
								}else{
									$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
									$Resultado.='#ERR_FIN_215';
								}
								
							}else{
								$validar++;	
							}
						}else{						
							if($InsPreEntregaHerramienta->PenEliminado==2){
								if($InsPreEntregaHerramienta->MtdEliminarPreEntregaHerramienta($InsPreEntregaHerramienta->FihId)){
									$validar++;					
								}else{
									$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
									$Resultado.='#ERR_FIN_213';
								}
							}else{
								
								
								if(!empty($InsPreEntregaHerramienta->ProId)){
									if(!empty($InsPreEntregaHerramienta->UmeId)){
										if(!empty($InsPreEntregaHerramienta->FihCantidad)){
											if(!empty($InsPreEntregaHerramienta->FihCantidadReal)){
												
												if($InsPreEntregaHerramienta->MtdEditarPreEntregaHerramienta()){
													$validar++;					
												}else{
													$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado.='#ERR_FIN_212';
												}										
												
											}else{
												$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado.='#ERR_FIN_217';												
											}
											
										}else{
											$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
											$Resultado.='#ERR_FIN_216';
										}
									}else{
										$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
										$Resultado.='#ERR_FIN_214';
									}									
								}else{
									$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
									$Resultado.='#ERR_FIN_215';
								}
								
								
								
							}
						}	
							
						$item++;	
					}					
					
					if(count($this->PreEntregaHerramienta) <> $validar ){
						$error = true;
					}	
					
				}
			}
			


			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarPreEntrega(2,"Se edito la Orden de Trabajo",$this);		
				return true;
			}	
				
		}	
		
		
		
		
		
public function MtdCorregirPreEntrega() {

		global $Resultado;
		$error = false;

			$this->InsMysql->MtdTransaccionIniciar();

			//PenMantenimientoKilometraje = '.($this->PenMantenimientoKilometraje).',						
			$sql = 'UPDATE tblpenpreentrega SET

			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			PenVehiculoKilometraje = '.($this->PenVehiculoKilometraje).',			
			PenMantenimientoKilometraje = '.($this->PenMantenimientoKilometraje).',			

			PenExteriorDelantero1 = '.($this->PenExteriorDelantero1).',
			PenExteriorDelantero2 = '.($this->PenExteriorDelantero2).',
			PenExteriorDelantero3 = '.($this->PenExteriorDelantero3).',
			PenExteriorDelantero4 = '.($this->PenExteriorDelantero4).',
			PenExteriorDelantero5 = '.($this->PenExteriorDelantero5).',
			PenExteriorDelantero6 = '.($this->PenExteriorDelantero6).',
			PenExteriorDelantero7 = '.($this->PenExteriorDelantero7).',
			
			PenExteriorPosterior1 = '.($this->PenExteriorPosterior1).',
			PenExteriorPosterior2 = '.($this->PenExteriorPosterior2).',
			PenExteriorPosterior3 = '.($this->PenExteriorPosterior3).',
			PenExteriorPosterior4 = '.($this->PenExteriorPosterior4).',
			PenExteriorPosterior5 = '.($this->PenExteriorPosterior5).',
			PenExteriorPosterior6 = '.($this->PenExteriorPosterior6).',
			
			PenExteriorDerecho1 = '.($this->PenExteriorDerecho1).',
			PenExteriorDerecho2 = '.($this->PenExteriorDerecho2).',
			PenExteriorDerecho3 = '.($this->PenExteriorDerecho3).',
			PenExteriorDerecho4 = '.($this->PenExteriorDerecho4).',
			PenExteriorDerecho5 = '.($this->PenExteriorDerecho5).',
			PenExteriorDerecho6 = '.($this->PenExteriorDerecho6).',
			PenExteriorDerecho7 = '.($this->PenExteriorDerecho7).',
			PenExteriorDerecho8 = '.($this->PenExteriorDerecho8).',
			
			PenExteriorIzquierdo1 = '.($this->PenExteriorIzquierdo1).',
			PenExteriorIzquierdo2 = '.($this->PenExteriorIzquierdo2).',
			PenExteriorIzquierdo3 = '.($this->PenExteriorIzquierdo3).',
			PenExteriorIzquierdo4 = '.($this->PenExteriorIzquierdo4).',
			PenExteriorIzquierdo5 = '.($this->PenExteriorIzquierdo5).',
			PenExteriorIzquierdo6 = '.($this->PenExteriorIzquierdo6).',
			PenExteriorIzquierdo7 = '.($this->PenExteriorIzquierdo7).',
			
			
			PenInterior1 = '.($this->PenInterior1).',
			PenInterior2 = '.($this->PenInterior2).',
			PenInterior3 = '.($this->PenInterior3).',
			PenInterior4 = '.($this->PenInterior4).',
			PenInterior5 = '.($this->PenInterior5).',
			PenInterior6 = '.($this->PenInterior6).',
			PenInterior7 = '.($this->PenInterior7).',
			PenInterior8 = '.($this->PenInterior8).',
			PenInterior9 = '.($this->PenInterior9).',
			PenInterior10 = '.($this->PenInterior10).',
			PenInterior11 = '.($this->PenInterior11).',
			PenInterior12 = '.($this->PenInterior12).',
			PenInterior13 = '.($this->PenInterior13).',
			PenInterior14 = '.($this->PenInterior14).',
			PenInterior15 = '.($this->PenInterior15).',
			PenInterior16 = '.($this->PenInterior16).',
			PenInterior17 = '.($this->PenInterior17).',
			PenInterior18 = '.($this->PenInterior18).',
			PenInterior19 = '.($this->PenInterior19).',
			PenInterior20 = '.($this->PenInterior20).',
			PenInterior21 = '.($this->PenInterior21).',
			PenInterior22 = '.($this->PenInterior22).',
			PenInterior23 = '.($this->PenInterior23).',
			PenInterior24 = '.($this->PenInterior24).',
			PenInterior25 = '.($this->PenInterior25).',
			PenInterior26 = '.($this->PenInterior26).',
			PenInterior27 = '.($this->PenInterior27).',
			PenTiempoModificacion = "'.($this->PenTiempoModificacion).'"
			
			WHERE PenId = "'.($this->PenId).'";';			
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarPreEntrega(2,"Se corrigio la Orden de Trabajo",$this);		
				return true;
			}	
				
		}	
		
		
		
		
		
		
	public function MtdEditarPreEntregaHerramienta() {

		global $Resultado;
		$error = false;

			$this->InsMysql->MtdTransaccionIniciar();
			
				if (!empty($this->PreEntregaHerramienta)){		

					
					$validar = 0;		
					$item = 1;		
					$InsPreEntregaHerramienta = new ClsPreEntregaHerramienta();		

					foreach ($this->PreEntregaHerramienta as $DatPreEntregaHerramienta){
				
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatPreEntregaHerramienta->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						$InsPreEntregaHerramienta->FihId = $DatPreEntregaHerramienta->FihId;
						$InsPreEntregaHerramienta->PenId = $this->PenId;
						$InsPreEntregaHerramienta->ProId = $DatPreEntregaHerramienta->ProId;
						$InsPreEntregaHerramienta->UmeId = $DatPreEntregaHerramienta->UmeId;
						$InsPreEntregaHerramienta->FihCantidad = $DatPreEntregaHerramienta->FihCantidad;
						$InsPreEntregaHerramienta->FihCantidadReal = $DatPreEntregaHerramienta->FihCantidadReal;
						$InsPreEntregaHerramienta->FihEstado = $DatPreEntregaHerramienta->FihEstado;
						$InsPreEntregaHerramienta->FihTiempoCreacion = $DatPreEntregaHerramienta->FihTiempoCreacion;
						$InsPreEntregaHerramienta->FihTiempoModificacion = $DatPreEntregaHerramienta->FihTiempoModificacion;
						$InsPreEntregaHerramienta->PemEliminado = $DatPreEntregaHerramienta->PemEliminado;
						
						if(empty($InsPreEntregaHerramienta->FihId)){
							if($InsPreEntregaHerramienta->PenEliminado<>2){
								
								if(!empty($InsPreEntregaHerramienta->ProId)){
									if(!empty($InsPreEntregaHerramienta->UmeId)){
										if(!empty($InsPreEntregaHerramienta->FihCantidad)){
											if(!empty($InsPreEntregaHerramienta->FihCantidadReal)){
												
												if($InsPreEntregaHerramienta->MtdRegistrarPreEntregaHerramienta()){
													$validar++;					
												}else{
													$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado.='#ERR_FIN_211';
												}											
												
											}else{
												$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado.='#ERR_FIN_217';												
											}
											
										}else{
											$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
											$Resultado.='#ERR_FIN_216';
										}
									}else{
										$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
										$Resultado.='#ERR_FIN_214';
									}									
								}else{
									$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
									$Resultado.='#ERR_FIN_215';
								}
								
							}else{
								$validar++;	
							}
						}else{						
							if($InsPreEntregaHerramienta->PenEliminado==2){
								if($InsPreEntregaHerramienta->MtdEliminarPreEntregaHerramienta($InsPreEntregaHerramienta->FihId)){
									$validar++;					
								}else{
									$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
									$Resultado.='#ERR_FIN_213';
								}
							}else{
								
								
								if(!empty($InsPreEntregaHerramienta->ProId)){
									if(!empty($InsPreEntregaHerramienta->UmeId)){
										if(!empty($InsPreEntregaHerramienta->FihCantidad)){
											if(!empty($InsPreEntregaHerramienta->FihCantidadReal)){
												
												if($InsPreEntregaHerramienta->MtdEditarPreEntregaHerramienta()){
													$validar++;					
												}else{
													$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado.='#ERR_FIN_212';
												}										
												
											}else{
												$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado.='#ERR_FIN_217';												
											}
											
										}else{
											$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
											$Resultado.='#ERR_FIN_216';
										}
									}else{
										$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
										$Resultado.='#ERR_FIN_214';
									}									
								}else{
									$Resultado.='#Herramienta: '.($InsProducto->ProNombre).' ('.$item.')';
									$Resultado.='#ERR_FIN_215';
								}
								
								
								
							}
						}	
							
						$item++;	
					}					
					
					if(count($this->PreEntregaHerramienta) <> $validar ){
						$error = true;
					}	
					
					
					
					
				}
			

			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarPreEntrega(2,"Se edito la Orden de Trabajo",$this);		
				return true;
			}	
				
		}	
		
		
		
	public function MtdEditarPreEntregaObservacionSalida() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblpenpreentrega SET
			PenSalidaObservacion = "'.($this->PenSalidaObservacion).'",
			PenTiempoModificacion = "'.($this->PenTiempoModificacion).'"
			WHERE PenId = "'.($this->PenId).'";';			
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			
				
			if($error) {		
				return false;
			} else {			
				$this->MtdAuditarPreEntrega(2,"Se edito la Observacion de Salida de la ORDEN DE TRABAJO",$this->PenId);		
				return true;
			}	
				
		}	
		
	public function MtdEditarPreEntregaObservacionTerminado() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblpenpreentrega SET
			PenTerminadoObservacion = "'.($this->PenTerminadoObservacion).'",
			PenTiempoModificacion = "'.($this->PenTiempoModificacion).'"
			WHERE PenId = "'.($this->PenId).'";';			
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			
				
			if($error) {		
				return false;
			} else {			
				$this->MtdAuditarPreEntrega(2,"Se edito la Observacion Penal de la ORDEN DE TRABAJO",$this->PenId);		
				return true;
			}	
				
		}	
				
		
	public function MtdEditarPreEntregaMantenimientoKilometraje() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblpenpreentrega SET
			PenMantenimientoKilometraje = "'.($this->PenMantenimientoKilometraje).'",
			PenTiempoModificacion = "'.($this->PenTiempoModificacion).'"
			WHERE PenId = "'.($this->PenId).'";';			
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			
				
			if($error) {		
				return false;
			} else {			
				$this->MtdAuditarPreEntrega(2,"Se edito el Kilometraje de Plan de Mantenimiento de la ORDEN DE TRABAJO",NULL);		
				return true;
			}	
				
		}	


	
	
	
	
	
	
	

		
	public function MtdEditarPreEntregaTallerRevisando() {
	
		global $Resultado;
		$error = false;		
		
		$sql = 'UPDATE tblpenpreentrega SET
	
		
		'.(empty($this->PenTiempoTallerRevisando)?'PenTiempoTallerRevisando = NULL, ':'PenTiempoTallerRevisando = "'.$this->PenTiempoTallerRevisando.'",').'
		
		
		PenTiempoModificacion = "'.($this->PenTiempoModificacion).'"
		WHERE PenId = "'.($this->PenId).'";';			
		
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
	
	
	public function MtdEditarPreEntregaTallerConcluido() {
	
		global $Resultado;
		$error = false;		
		
		$sql = 'UPDATE tblpenpreentrega SET
		
		
		'.(empty($this->PenTiempoTallerConcluido)?'PenTiempoTallerConcluido = NULL, ':'PenTiempoTallerConcluido = "'.$this->PenTiempoTallerConcluido.'",').'
		
		
		PenTiempoModificacion = "'.($this->PenTiempoModificacion).'"
		WHERE PenId = "'.($this->PenId).'";';			
		
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
	
	public function MtdEditarPreEntregaTrabajoTerminado() {
	
		global $Resultado;
		$error = false;		
		
		$sql = 'UPDATE tblpenpreentrega SET
		'.(empty($this->PenTiempoTrabajoTerminado)?'PenTiempoTrabajoTerminado = NULL, ':'PenTiempoTrabajoTerminado = "'.$this->PenTiempoTrabajoTerminado.'",').'
		PenTiempoModificacion = "'.($this->PenTiempoModificacion).'"
		WHERE PenId = "'.($this->PenId).'";';			
		
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
	
	
	private function MtdAuditarPreEntrega($oAccion,$oDescripcion,$oDatos){
		
		$InsAuditoria = new ClsAuditoria();
		$InsAuditoria->AudCodigo = $this->PenId;
	
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