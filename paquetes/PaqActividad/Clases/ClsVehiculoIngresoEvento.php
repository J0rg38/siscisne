<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoIngresoEvento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoIngresoEvento {

    public $VieId;
	public $PrvId;
	public $EinId;
	
	public $VieFecha;
    public $VieFechaProgramada;
	public $VieHoraProgramada;
	public $VieMonto;
	public $VieMontoReal;
	public $VieObservacionInterna;
	public $VieObservacionImpresa;
	public $VieKilometrajeMantenimiento;
	
	public $VieEstado;	
    public $VieTiempoCreacion;
    public $VieTiempoModificacion;
    public $VieEliminado;

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
		
	public function MtdGenerarVehiculoIngresoEventoId() {
	
			
			$sql = 'SELECT	
			suc.SucSiglas AS SIGLA,
	
			MAX(CONVERT(SUBSTR(vie.VieId,5),unsigned)) AS "MAXIMO"
			
			FROM tblvievehiculoingresoevento vie
				LEFT JOIN tblsucsucursal suc
			ON vie.SucId = suc.SucId
			
			WHERE vie.SucId = "'.$this->SucId.'"
			';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VieId = "VIE-10000-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);

			}else{
				$fila['MAXIMO']++;
				$this->VieId = "VIE-".$fila['MAXIMO']."-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);				
			}	
			
				
		}
		
    public function MtdObtenerVehiculoIngresoEvento(){

        $sql = 'SELECT 
        vie.VieId,
		vie.SucId,
		vie.PrvId,
		vie.EinId,
		vie.PerId,
		
		DATE_FORMAT(vie.VieFecha, "%d/%m/%Y") AS "NVieFecha",
		
		vie.VieObservacionInterna,
		vie.VieObservacionImpresa,
		
		vie.VieReferencia,
			
		vie.VieEstado,	
		DATE_FORMAT(vie.VieTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVieTiempoCreacion",
        DATE_FORMAT(vie.VieTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVieTiempoModificacion",

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
		
		
        FROM tblvievehiculoingresoevento vie
			
				LEFT JOIN tbleinvehiculoingreso ein
				ON vie.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
									
        WHERE vie.VieId = "'.$this->VieId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
			{
				$this->VieId = $fila['VieId'];
				$this->SucId = $fila['SucId'];
				
				
				$this->EinId = $fila['EinId'];
				$this->PerId = $fila['PerId'];
				
				$this->VieFecha = $fila['NVieFecha'];

			
				$this->VieObservacionInterna = $fila['VieObservacionInterna'];
				$this->VieObservacionImpresa = $fila['VieObservacionImpresa'];
			
				
				$this->VieReferencia = $fila['VieReferencia'];
				
				$this->VieEstado = $fila['VieEstado'];
				$this->VieTiempoCreacion = $fila['NVieTiempoCreacion'];
				$this->VieTiempoModificacion = $fila['NVieTiempoModificacion'];
				
				
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
			
			
				switch($this->VieEstado){
					case 1:
						$this->VieEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$this->VieEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$this->VieEstadoDescripcion = "Anulado";
				
					break;
					
				}
				
				
				switch($this->VieEstado){
					case 1:
						$this->VieEstadoIcono = '<img src="imagenes/estado/pendiente.png" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$this->VieEstadoIcono = '<img src="imagenes/estado/realizado.png" alt="[Realizado]" title="Realizado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$this->VieEstadoIcono = '<img src="imagenes/estado/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
					break;
					
				}
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoIngresoEventos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VieId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oProveedor=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoIngresoId=NULL,$oSucursal=NULL) {



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
			$estado = ' AND vie.VieEstado = '.$oEstado;
		}	
		
		if(!empty($oProveedor)){
			$cliente = ' AND vie.PrvId = "'.$oProveedor.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND vie.PerId = "'.$oPersonal.'"';
		}	
		
			
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vie.VieFecha)>="'.$oFechaInicio.'" AND DATE(vie.VieFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vie.VieFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vie.VieFecha)<="'.$oFechaFin.'"';		
			}			
		}

		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND vie.EinId = "'.$oVehiculoIngresoId.'"';
		}
	
		if(!empty($oSucursal)){
			$sucursal = ' AND vie.EinId = "'.$oSucursal.'"';
		}
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		vie.VieId,
vie.SucId,
		
		vie.EinId,
		vie.PerId,
	

		DATE_FORMAT(vie.VieFecha, "%d/%m/%Y") AS "NVieFecha",
		
			
		vie.VieObservacionInterna,
		vie.VieObservacionImpresa,

		
vie.VieReferencia,
	
	
		vie.VieEstado,	
		DATE_FORMAT(vie.VieTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVieTiempoCreacion",
        DATE_FORMAT(vie.VieTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVieTiempoModificacion",
		
		ein.EinVIN,
		ein.EinPlaca,
		
		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno
		
		
        FROM tblvievehiculoingresoevento vie
		
			
				LEFT JOIN tbleinvehiculoingreso ein
				ON vie.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per
								ON vie.PerId = per.PerId
									
								
				WHERE 1 = 1 '.$filtrar.$estado.$cliente.$vingreso.$hora.$sfichaingreso .$pmecanico.$personal.$fecha.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoIngresoEvento = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoIngresoEvento = new $InsVehiculoIngresoEvento();				
					
                    $VehiculoIngresoEvento->VieId = $fila['VieId'];
					$VehiculoIngresoEvento->SucId = $fila['SucId'];
										
					$VehiculoIngresoEvento->EinId = $fila['EinId'];					
					$VehiculoIngresoEvento->PerId = $fila['PerId'];										
					$VehiculoIngresoEvento->VieFecha = $fila['NVieFecha'];
				
					$VehiculoIngresoEvento->VieObservacionInterna = $fila['VieObservacionInterna'];
					$VehiculoIngresoEvento->VieObservacionImpresa = $fila['VieObservacionImpresa'];
				
					$VehiculoIngresoEvento->VieReferencia = $fila['VieReferencia'];
				
					$VehiculoIngresoEvento->VieEstado = $fila['VieEstado'];					
                    $VehiculoIngresoEvento->VieTiempoCreacion = $fila['NVieTiempoCreacion'];
                    $VehiculoIngresoEvento->VieTiempoModificacion = $fila['NVieTiempoModificacion'];    

		
	
					$VehiculoIngresoEvento->EinVIN = $fila['EinVIN'];    
					$VehiculoIngresoEvento->EinPlaca  = $fila['EinPlaca'];    
					
					$VehiculoIngresoEvento->VmaNombre = $fila['VmaNombre'];    
					$VehiculoIngresoEvento->VmoNombre = $fila['VmoNombre'];    
					$VehiculoIngresoEvento->VveNombre = $fila['VveNombre'];  
					
					$VehiculoIngresoEvento->PerApellidoPaterno = $fila['PerApellidoPaterno'];    
					$VehiculoIngresoEvento->PerApellidoMaterno = $fila['PerApellidoMaterno'];    
					$VehiculoIngresoEvento->PerNombre = $fila['PerNombre'];   
				
	
				switch($VehiculoIngresoEvento->VieEstado){
					case 1:
						$VehiculoIngresoEvento->VieEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$VehiculoIngresoEvento->VieEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$VehiculoIngresoEvento->VieEstadoDescripcion = "Anulado";
				
					break;
					
				}
				
				
				switch($VehiculoIngresoEvento->VieEstado){
					case 1:
						$VehiculoIngresoEvento->VieEstadoIcono = '<img src="imagenes/estado/pendiente.png" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$VehiculoIngresoEvento->VieEstadoIcono = '<img src="imagenes/estado/realizado.png" alt="[Realizado]" title="Realizado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$VehiculoIngresoEvento->VieEstadoIcono = '<img src="imagenes/estado/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
					break;
					
				}
				
                    $VehiculoIngresoEvento->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoIngresoEvento;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	public function MtdObtenerVehiculoIngresoEventosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VieId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oProveedor=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoIngresoId=NULL,$oVehiculoMarca=NULL,$oHoraInicio=NULL,$oSucursal=NULL) {

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
			$estado = ' AND vie.VieEstado = '.$oEstado;
		}	
		
		if(!empty($oProveedor)){
			$cliente = ' AND vie.PrvId = "'.$oProveedor.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND vie.PerId = "'.$oPersonal.'"';
		}	
		
		
			
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vie.VieFecha)>="'.$oFechaInicio.'" AND DATE(vie.VieFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vie.VieFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vie.VieFecha)<="'.$oFechaFin.'"';		
			}			
		}

		
		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND vie.EinId = "'.$oVehiculoIngresoId.'"';
		}	
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
		
		
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (vie.SucId) = "'.$oSucursal.'"';		
		}	
		
		
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(vie.VieFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(vie.VieFecha) ="'.($oAno).'"';
		}
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		'.$funcion.' AS "RESULTADO"
		
        FROM tblvievehiculoingresoevento vie
			
				LEFT JOIN tbleinvehiculoingreso ein
				ON vie.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per
								ON vie.PerId = per.PerId
								
				WHERE 1 = 1 '.$ano.$mes.$filtrar.$estado.$sucursal.$vmarca.$hora.$cliente.$vingreso.$sfichaingreso .$personal.$fecha.$orden.$paginacion;
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoIngresoEvento($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VieId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VieId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblvievehiculoingresoevento WHERE '.$eliminar;
			
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
	
	
	
	public function MtdActualizarEstadoVehiculoIngresoEvento($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
				
					$sql = 'UPDATE tblvievehiculoingresoevento SET VieEstado = '.$oEstado.' WHERE   (VieId = "'.($elemento).'" )';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
//						$this->MtdAuditarBoleta(2,"Se actualizo el Estado de la VehiculoIngresoEvento",$aux);	
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

	public function MtdRegistrarVehiculoIngresoEvento() {
	

		global $Resultado;
		$error = false;
		//
//		$this->MtdVerificarExisteVehiculoIngresoEvento();
		
		//if(!empty($this->PrvId)){
//			$error = true;
//			$Resultado.='#ERR_VIE_201';
//		}
			
			
			$this->MtdGenerarVehiculoIngresoEventoId();
				
			$sql = 'INSERT INTO tblvievehiculoingresoevento (
			VieId,
			SucId,
			
			EinId,
			PerId,
		
			VieFecha,
		
			VieObservacionInterna,
			VieObservacionImpresa,
			VieReferencia,
			
			
			VieEstado,
			VieTiempoCreacion,
			VieTiempoModificacion
			) 
			VALUES (
			"'.($this->VieId).'",
			"'.($this->SucId).'",
	
			'.(empty($this->EinId)?'NULL, ':'"'.$this->EinId.'",').'
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			
			"'.($this->VieFecha).'",
		
			"'.($this->VieObservacionInterna).'",
			"'.($this->VieObservacionImpresa).'",
			"'.($this->VieReferencia).'",
			
			'.($this->VieEstado).', 
			"'.($this->VieTiempoCreacion).'", 
			"'.($this->VieTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarVehiculoIngresoEvento() {
		
//		if($this->Transaccion){
//			$this->InsMysql->MtdTransaccionIniciar();
//		}
	
			$sql = 'UPDATE tblvievehiculoingresoevento SET 
		
			
			
			'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'

			
			VieFecha = "'.($this->VieFecha).'",
	
			VieObservacionInterna = "'.($this->VieObservacionInterna).'",
			VieObservacionImpresa = "'.($this->VieObservacionImpresa).'",
	
			VieReferencia = "'.($this->VieReferencia).'",
		
			
			VieEstado = '.($this->VieEstado).',
			VieTiempoModificacion = "'.($this->VieTiempoModificacion).'"
			WHERE VieId = "'.($this->VieId).'";';
			
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