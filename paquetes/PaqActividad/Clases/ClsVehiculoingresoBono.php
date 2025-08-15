<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoIngresoBono
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoIngresoBono {

    public $VibId;
	public $PrvId;
	public $EinId;
	
	public $VibFecha;
    public $VibFechaProgramada;
	public $VibHoraProgramada;
	public $VibMonto;
	public $VibMontoReal;
	public $VibObservacionInterna;
	public $VibObservacionImpresa;
	public $VibKilometrajeMantenimiento;
	
	public $VibEstado;	
    public $VibTiempoCreacion;
    public $VibTiempoModificacion;
    public $VibEliminado;

	public $InsMysql;

	public $Transaccion;
	
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
		
	public function MtdGenerarVehiculoIngresoBonoId() {
	
			
			$sql = 'SELECT	
			suc.SucSiglas AS SIGLA,
			MAX(CONVERT(SUBSTR(vib.VibId,
vib.SucId,5),unsigned)) AS "MAXIMO"
			FROM tblvibvehiculoingresobono vib
				LEFT JOIN tblsucsucursal suc
			ON vib.SucId = suc.SucId
			
			WHERE vib.SucId = "'.$this->SucId.'"
			';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VibId = "VIB-10000-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);

			}else{
				$fila['MAXIMO']++;
				$this->VibId = "VIB-".$fila['MAXIMO']."-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);				
			}	
			
				
		}
		
    public function MtdObtenerVehiculoIngresoBono(){

        $sql = 'SELECT 
        vib.VibId,
vib.SucId,
		vib.PrvId,
		vib.EinId,
		vib.PerId,
		
		vib.MonId,

		DATE_FORMAT(vib.VibFecha, "%d/%m/%Y") AS "NVibFecha",
		
	
		vib.VibMonto,
		vib.VibMontoReal,		
		vib.VibObservacionInterna,
		vib.VibObservacionImpresa,
		
		vib.VibTipoCambio,
vib.VibReferencia,
			
			
		vib.VibEstado,	
		DATE_FORMAT(vib.VibTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVibTiempoCreacion",
        DATE_FORMAT(vib.VibTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVibTiempoModificacion",

	
		
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
		vve.VveNombre,
		
		ein.EinPlaca
		
		
        FROM tblvibvehiculoingresobono vib
			
				LEFT JOIN tbleinvehiculoingreso ein
				ON vib.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
									
        WHERE vib.VibId = "'.$this->VibId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
			{
				$this->VibId = $fila['VibId'];
				$this->SucId = $fila['SucId'];
				
				
				$this->PrvId = $fila['PrvId'];
				$this->EinId = $fila['EinId'];
				$this->PerId = $fila['PerId'];
				$this->MonId = $fila['MonId'];
				
				$this->VibFecha = $fila['NVibFecha'];

				$this->VibMonto = $fila['VibMonto'];			
				$this->VibMontoReal = $fila['VibMontoReal'];
				$this->VibObservacionInterna = $fila['VibObservacionInterna'];
				$this->VibObservacionImpresa = $fila['VibObservacionImpresa'];
			
				$this->VibTipoCambio = $fila['VibTipoCambio'];
				$this->VibReferencia = $fila['VibReferencia'];
				
				$this->VibEstado = $fila['VibEstado'];
				$this->VibTiempoCreacion = $fila['NVibTiempoCreacion'];
				$this->VibTiempoModificacion = $fila['NVibTiempoModificacion'];
				
				
				$this->PrvNombreCompleto = $fila['PrvNombreCompleto'];
				$this->PrvNombre = $fila['PrvNombre'];
				$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
				$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
				$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
				$this->TdoId = $fila['TdoId'];
				$this->PrvCelular = $fila['PrvCelular'];
				$this->PrvContactoCelular1 = $fila['PrvContactoCelular1'];
				$this->PrvContactoCelular2 = $fila['PrvContactoCelular2'];
				$this->PrvContactoCelular3 = $fila['PrvContactoCelular3'];
		
				$this->PrvTelefono = $fila['PrvTelefono'];
				$this->PrvDireccion = $fila['PrvDireccion'];
			
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
			
			
			$this->EinPlaca = $fila['EinPlaca'];
			
			
				switch($this->VibEstado){
					case 1:
						$this->VibEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$this->VibEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$this->VibEstadoDescripcion = "Anulado";
				
					break;
					
				}
				
				
				switch($this->VibEstado){
					case 1:
						$this->VibEstadoIcono = '<img src="imagenes/estado/pendiente.png" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$this->VibEstadoIcono = '<img src="imagenes/estado/realizado.png" alt="[Realizado]" title="Realizado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$this->VibEstadoIcono = '<img src="imagenes/estado/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
					break;
					
				}
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoIngresoBonos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VibId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oProveedor=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoIngresoId=NULL,$oSucursal=NULL) {



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
			$estado = ' AND vib.VibEstado = '.$oEstado;
		}	
		
		if(!empty($oProveedor)){
			$cliente = ' AND vib.PrvId = "'.$oProveedor.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND vib.PerId = "'.$oPersonal.'"';
		}	
		
			
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vib.VibFecha)>="'.$oFechaInicio.'" AND DATE(vib.VibFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vib.VibFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vib.VibFecha)<="'.$oFechaFin.'"';		
			}			
		}

		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND vib.EinId = "'.$oVehiculoIngresoId.'"';
		}
	
		if(!empty($oSucursal)){
			$sucursal = ' AND vib.EinId = "'.$oSucursal.'"';
		}
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		vib.VibId,
vib.SucId,
		vib.PrvId,
		vib.EinId,
		vib.PerId,
		vib.MonId,

		DATE_FORMAT(vib.VibFecha, "%d/%m/%Y") AS "NVibFecha",
		
		
		vib.VibMonto,
		vib.VibMontoReal,		
		vib.VibObservacionInterna,
		vib.VibObservacionImpresa,

		vib.VibTipoCambio,
vib.VibReferencia,
	
	
		vib.VibEstado,	
		DATE_FORMAT(vib.VibTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVibTiempoCreacion",
        DATE_FORMAT(vib.VibTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVibTiempoModificacion",
		
		
		ein.EinVIN,
		ein.EinPlaca,
		
		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		
		mon.MonNombre,
		mon.MonSimbolo
		
        FROM tblvibvehiculoingresobono vib
		
			
				LEFT JOIN tbleinvehiculoingreso ein
				ON vib.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per
								ON vib.PerId = per.PerId
									LEFT JOIN tblperpersonal mec
									ON vib.MonId = mec.PerId
										LEFT JOIN tblmonmoneda mon
										ON vib.MonId = mon.MonId
								
				WHERE 1 = 1 '.$filtrar.$estado.$cliente.$vingreso.$hora.$sfichaingreso .$pmecanico.$personal.$fecha.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoIngresoBono = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoIngresoBono = new $InsVehiculoIngresoBono();				
					
                    $VehiculoIngresoBono->VibId = $fila['VibId'];
					$VehiculoIngresoBono->SucId = $fila['SucId'];
					
					$VehiculoIngresoBono->PrvId = $fila['PrvId'];
					$VehiculoIngresoBono->EinId = $fila['EinId'];
					
					$VehiculoIngresoBono->PerId = $fila['PerId'];
					$VehiculoIngresoBono->MonId = $fila['MonId'];
										
					$VehiculoIngresoBono->VibFecha = $fila['NVibFecha'];
				
					$VehiculoIngresoBono->VibMonto= $fila['VibMonto'];
					$VehiculoIngresoBono->VibMontoReal= $fila['VibMontoReal'];
					$VehiculoIngresoBono->VibObservacionInterna = $fila['VibObservacionInterna'];
					$VehiculoIngresoBono->VibObservacionImpresa = $fila['VibObservacionImpresa'];
				
					$VehiculoIngresoBono->VibTipoCambio = $fila['VibTipoCambio'];
					$VehiculoIngresoBono->VibReferencia = $fila['VibReferencia'];
				
					$VehiculoIngresoBono->VibEstado = $fila['VibEstado'];					
                    $VehiculoIngresoBono->VibTiempoCreacion = $fila['NVibTiempoCreacion'];
                    $VehiculoIngresoBono->VibTiempoModificacion = $fila['NVibTiempoModificacion'];    

					$VehiculoIngresoBono->PrvNombre = $fila['PrvNombre'];    
					$VehiculoIngresoBono->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];    
					$VehiculoIngresoBono->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];   
					$VehiculoIngresoBono->TdoId = $fila['TdoId'];  
					$VehiculoIngresoBono->PrvTelefono = $fila['PrvTelefono'];
					$VehiculoIngresoBono->PrvCelular = $fila['PrvCelular'];  
					
					$VehiculoIngresoBono->PrvContactoCelular1 = $fila['PrvContactoCelular1'];  
					$VehiculoIngresoBono->PrvContactoCelular2 = $fila['PrvContactoCelular2'];  
					$VehiculoIngresoBono->PrvContactoCelular3 = $fila['PrvContactoCelular3'];  
	
					$VehiculoIngresoBono->EinVIN = $fila['EinVIN'];    
					$VehiculoIngresoBono->EinPlaca  = $fila['EinPlaca'];    
					
					$VehiculoIngresoBono->VmaNombre = $fila['VmaNombre'];    
					$VehiculoIngresoBono->VmoNombre = $fila['VmoNombre'];    
					$VehiculoIngresoBono->VveNombre = $fila['VveNombre'];  
					
					
					$VehiculoIngresoBono->PerApellidoPaterno = $fila['PerApellidoPaterno'];    
					$VehiculoIngresoBono->PerApellidoMaterno = $fila['PerApellidoMaterno'];    
					$VehiculoIngresoBono->PerNombre = $fila['PerNombre'];   
					
					$VehiculoIngresoBono->PerNombreMecanico = $fila['PerNombreMecanico'];    
					$VehiculoIngresoBono->PerApellidoPaternoMecanico = $fila['PerApellidoPaternoMecanico'];    
					$VehiculoIngresoBono->PerApellidoMaternoMecanico = $fila['PerApellidoMaternoMecanico'];    
					
					 
					 
					 $VehiculoIngresoBono->MonNombre = $fila['MonNombre'];    
					$VehiculoIngresoBono->MonSimbolo = $fila['MonSimbolo'];    
					
	
				switch($VehiculoIngresoBono->VibEstado){
					case 1:
						$VehiculoIngresoBono->VibEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$VehiculoIngresoBono->VibEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$VehiculoIngresoBono->VibEstadoDescripcion = "Anulado";
				
					break;
					
				}
				
				
				switch($VehiculoIngresoBono->VibEstado){
					case 1:
						$VehiculoIngresoBono->VibEstadoIcono = '<img src="imagenes/estado/pendiente.png" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$VehiculoIngresoBono->VibEstadoIcono = '<img src="imagenes/estado/realizado.png" alt="[Realizado]" title="Realizado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$VehiculoIngresoBono->VibEstadoIcono = '<img src="imagenes/estado/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
					break;
					
				}
				
                    $VehiculoIngresoBono->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoIngresoBono;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	public function MtdObtenerVehiculoIngresoBonosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VibId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oProveedor=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoIngresoId=NULL,$oVehiculoMarca=NULL,$oHoraInicio=NULL,$oSucursal=NULL) {

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
			$estado = ' AND vib.VibEstado = '.$oEstado;
		}	
		
		if(!empty($oProveedor)){
			$cliente = ' AND vib.PrvId = "'.$oProveedor.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND vib.PerId = "'.$oPersonal.'"';
		}	
		
		
			
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vib.VibFecha)>="'.$oFechaInicio.'" AND DATE(vib.VibFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vib.VibFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vib.VibFecha)<="'.$oFechaFin.'"';		
			}			
		}

		
		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND vib.EinId = "'.$oVehiculoIngresoId.'"';
		}	
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
		
		
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (vib.SucId) = "'.$oSucursal.'"';		
		}	
		
		
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(vib.VibFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(vib.VibFecha) ="'.($oAno).'"';
		}
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		'.$funcion.' AS "RESULTADO"
		
        FROM tblvibvehiculoingresobono vib
			
				LEFT JOIN tbleinvehiculoingreso ein
				ON vib.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per
								ON vib.PerId = per.PerId
								
				WHERE 1 = 1 '.$ano.$mes.$filtrar.$estado.$sucursal.$vmarca.$hora.$cliente.$vingreso.$sfichaingreso .$personal.$fecha.$orden.$paginacion;
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoIngresoBono($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VibId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VibId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblvibvehiculoingresobono WHERE '.$eliminar;
			
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
	
	
	
	public function MtdActualizarEstadoVehiculoIngresoBono($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
				
					$sql = 'UPDATE tblvibvehiculoingresobono SET VibEstado = '.$oEstado.' WHERE   (VibId = "'.($elemento).'" )';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
//						$this->MtdAuditarBoleta(2,"Se actualizo el Estado de la VehiculoIngresoBono",$aux);	
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

	public function MtdRegistrarVehiculoIngresoBono() {
	

		global $Resultado;
		$error = false;
		//
//		$this->MtdVerificarExisteVehiculoIngresoBono();
		
		//if(!empty($this->PrvId)){
//			$error = true;
//			$Resultado.='#ERR_VIB_201';
//		}
			
			
			$this->MtdGenerarVehiculoIngresoBonoId();
				
			$sql = 'INSERT INTO tblvibvehiculoingresobono (
			VibId,
			SucId,
			
			PrvId,
			EinId,
			PerId,
			MonId,
			
			VibFecha,
		
			VibMonto,			
			VibMontoReal,
			VibObservacionInterna,
			VibObservacionImpresa,
			VibReferencia,
			
			
			VibTipoCambio,
			
			VibEstado,
			VibTiempoCreacion,
			VibTiempoModificacion
			) 
			VALUES (
			"'.($this->VibId).'",
			"'.($this->SucId).'",
	
		
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'		
			'.(empty($this->EinId)?'NULL, ':'"'.$this->EinId.'",').'
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			'.(empty($this->MonId)?'NULL, ':'"'.$this->MonId.'",').'
			
			"'.($this->VibFecha).'",
		
			"'.($this->VibMonto).'",
			"'.($this->VibMontoReal).'",
			"'.($this->VibObservacionInterna).'",
			"'.($this->VibObservacionImpresa).'",
			"'.($this->VibReferencia).'",
			
			
			
			
			'.(empty($this->VibTipoCambio)?'NULL, ':''.$this->VibTipoCambio.',').'
			'.($this->VibEstado).', 
			"'.($this->VibTiempoCreacion).'", 
			"'.($this->VibTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarVehiculoIngresoBono() {
		
//		if($this->Transaccion){
//			$this->InsMysql->MtdTransaccionIniciar();
//		}
	
			$sql = 'UPDATE tblvibvehiculoingresobono SET 
		
			
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			'.(empty($this->MonId)?'MonId = NULL, ':'MonId = "'.$this->MonId.'",').'
			
			VibFecha = "'.($this->VibFecha).'",
	
			VibMonto = "'.($this->VibMonto).'",
			VibMontoReal = "'.($this->VibMontoReal).'",
			VibObservacionInterna = "'.($this->VibObservacionInterna).'",
			VibObservacionImpresa = "'.($this->VibObservacionImpresa).'",
		VibReferencia = "'.($this->VibReferencia).'",
		
		
		
		
			
			'.(empty($this->VibTipoCambio)?'VibTipoCambio = NULL, ':'VibTipoCambio = '.$this->VibTipoCambio.',').'
			
			
			VibEstado = '.($this->VibEstado).',
			VibTiempoModificacion = "'.($this->VibTiempoModificacion).'"
			WHERE VibId = "'.($this->VibId).'";';
			
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