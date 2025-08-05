<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Cdicription of ClsCajaDiaria
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCajaDiaria {

    public $CdiId;
	
	public $PrvId;
	public $CliId;
	public $PerId;
	
	public $CueId;
    public $CdiFecha;
    public $MonId;
	
	public $AreId;
	
	public $CdiTipoCambio;
	public $CdiObservacion;
	public $CdiObservacionImpresa;
	public $CdiConcepto;
	
	public $CdiNumeroCheque;
	public $CdiReferencia;

	public $CdiMonto;
	public $CdiTipo;
	public $CdiFoto;
	
	public $CdiTipoDestino;
	
	public $CdiEstado;	
    public $CdiTiempoCreacion;
    public $CdiTiempoModificacion;
    public $CdiEliminado;

	
	
	
	public $PrvNombre;
	public $PrvApellidoPaterno;
	public $PrvApellidoMaterno;
	public $PrvNumeroDocumento;
	public $TdoIdProveedr;
	
	public $CliNombre;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $CliNumeroDocumento;
	public $TdoIdCliente;
	
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	public $PerNumeroDocumento;
	public $TdoIdPersonal;
	
	public $MonNombre;
	
	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __cditruct(){

	}
		
    public function MtdObtenerCajaDiarias($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CdiId',$oSentido = 'Cdic',$oCdiinacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CdiFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoCditino=NULL,$oArea=NULL,$oSucursal=NULL) {
		
		
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

		if(!empty($oCdiinacion)){
			$paginacion = ' LIMIT '.($oCdiinacion);
		}
			
				
		if(!empty($oEstado)){
			$estado = ' AND cdi.CdiEstado = '.$oEstado;
		}	
		
		if(!empty($oVentaDirecta)){
			
			$vdirecta = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.CdiId = cdi.CdiId
				AND pac.VdIId = "'.$oVentaDirecta.'"
			
			)
			';
		}
		
		if(!empty($oOrdenVentaVehiculo)){
			
			$ovvehiculo = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.CdiId = cdi.CdiId
				AND pac.CdiId = "'.$oOrdenVentaVehiculo.'"
			
			)
			';
		}	
		
	
			
		if(!empty($oMoneda)){
			$moneda = ' AND cdi.MonId = "'.$oMoneda.'"';
		}	
		
	
		if(!empty($oFactura) and !empty($oFacturaTalonario)){
			
			$factura = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.CdiId = cdi.CdiId
				AND pac.FacId = "'.$oFactura.'"
				AND pac.FtaId = "'.$oFacturaTalonario.'"
			
			)
			';
		}	
		
		if(!empty($oBoleta) and !empty($oBoletaTalonario)){
			
			$boleta = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.CdiId = cdi.CdiId
				AND pac.BolId = "'.$oBoleta.'"
				AND pac.BtaId = "'.$oBoletaTalonario.'"			
			)
			';

		}	
		
			
		if(!empty($oArea)){
			$area = ' AND cdi.AreId = "'.$oArea.'"';
		}	
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cdi.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(cdi.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cdi.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cdi.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oCuenta)){
			$cuenta = ' AND cdi.CueId = "'.$oCuenta.'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND cdi.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oTipoCditino)){
			$tcditino = ' AND cdi.CdiTipoDestino = "'.$oTipoCditino.'"';
		}
		
		if(!empty($oArea)){
			$area = ' AND cdi.AreId = "'.$oArea.'"';
		}	
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND cdi.SucId = "'.$oSucursal.'"';
		}	

			  $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cdi.CdiId,
				cdi.SucId,
				
				cdi.PrvId,
				
				cdi.PerId,
				cdi.CueId,

				DATE_FORMAT(cdi.CdiFecha, "%d/%m/%Y") AS "NCdiFecha",
				cdi.MonId,
				
				cdi.AreId,
				
				cdi.CdiTipoCambio,
				cdi.CdiObservacion,
				cdi.CdiObservacionImpresa,
				cdi.CdiConcepto,
				cdi.CdiNumeroCheque,
				cdi.CdiReferencia,
				
				cdi.CdiMonto,
				cdi.CdiTipo,
				
				cdi.CdiFoto,
			
				cdi.CdiTipoDestino,

				cdi.CdiEstado,	
				cdi.CdiTipoCajaDiaria,
				DATE_FORMAT(cdi.CdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCdiTiempoCreacion",
                DATE_FORMAT(cdi.CdiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCdiTiempoModificacion",

				mon.MonNombre,
				mon.MonSimbolo,
				
				cue.CueNumero,
				ban.BanNombre,
				
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.PrvNumeroDocumento,
				prv.TdoId AS TdoIdProveedor,
				
				tdo.TdoNombre AS TdoNombreProveedor,
				
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliNumeroDocumento,
				cli.TdoId AS TdoIdCliente,
				tdo2.TdoNombre AS TdoNombreCliente,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				per.PerNumeroDocumento,
				per.TdoId AS TdoIdPersonal,
				tdo3.TdoNombre AS TdoNombrePersonal
				
				FROM viscdicajadiaria cdi

					LEFT JOIN tblprvproveedor prv
					ON cdi.PrvId = prv.PrvId
				
						LEFT JOIN tbltdotipodocumento tdo
						ON prv.TdoId = tdo.TdoId
						
							LEFT JOIN tblclicliente cli
							ON cdi.CliId = cli.CliId
							
								LEFT JOIN tbltdotipodocumento tdo2
								ON cli.TdoId = tdo2.TdoId
		
									LEFT JOIN tblperpersonal per
									ON cdi.PerId = per.PerId
									
										LEFT JOIN tbltdotipodocumento tdo3
										ON per.TdoId = tdo3.TdoId
								
											LEFT JOIN tblcuecuenta cue
											ON cdi.CueId = cue.CueId
												
												LEFT JOIN tblbanbanco ban
												ON cue.BanId = ban.BanId
													
													LEFT JOIN tblmonmoneda mon
													ON cdi.MonId = mon.MonId
						
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$sucursal.$vdirecta.$ovvehiculo.$cpago.$moneda.$tcditino.$factura.$boleta.$area.$fecha.$cuenta.$area.$orden.$paginacion;
										
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCajaDiaria = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CajaDiaria = new $InsCajaDiaria();				
					
                    $CajaDiaria->CdiId = $fila['CdiId'];
					  $CajaDiaria->SucId = $fila['SucId'];
					
					$CajaDiaria->PrvId = $fila['PrvId'];
					$CajaDiaria->PerId = $fila['PerId'];
					$CajaDiaria->CueId = $fila['CueId'];
					
                    $CajaDiaria->CdiFecha = $fila['NCdiFecha'];
					$CajaDiaria->MonId = $fila['MonId'];
					
					$CajaDiaria->AreId = $fila['AreId'];
					
					$CajaDiaria->CdiTipoCambio= $fila['CdiTipoCambio'];
					$CajaDiaria->CdiObservacion = $fila['CdiObservacion'];
					$CajaDiaria->CdiObservacionImpresa = $fila['CdiObservacionImpresa'];
					$CajaDiaria->CdiConcepto = $fila['CdiConcepto'];
					$CajaDiaria->CdiNumeroCheque = $fila['CdiNumeroCheque'];
					$CajaDiaria->CdiReferencia = $fila['CdiReferencia'];
					
					$CajaDiaria->CdiMonto = $fila['CdiMonto'];
					$CajaDiaria->CdiTipo = $fila['CdiTipo'];
					
					$CajaDiaria->CdiFoto = $fila['CdiFoto'];
					
					$CajaDiaria->CdiTipoDestino = $fila['CdiTipoDestino'];
					
					$CajaDiaria->CdiEstado = $fila['CdiEstado'];
					$CajaDiaria->CdiTipoCajaDiaria = $fila['CdiTipoCajaDiaria'];
					
                    $CajaDiaria->CdiTiempoCreacion = $fila['NCdiTiempoCreacion'];
					$CajaDiaria->CdiTiempoModificacion = $fila['NCdiTiempoModificacion'];

					$CajaDiaria->MonNombre = $fila['MonNombre'];
					$CajaDiaria->MonSimbolo = $fila['MonSimbolo'];
					
					$CajaDiaria->CueNumero = $fila['CueNumero'];
					$CajaDiaria->BanNombre = $fila['BanNombre'];
					
					$CajaDiaria->PrvNombre = $fila['PrvNombre'];
					$CajaDiaria->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$CajaDiaria->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$CajaDiaria->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
					$CajaDiaria->TdoIdProveedor = $fila['TdoIdProveedor'];					
					$CajaDiaria->TdoNombreProveedor = $fila['TdoNombreProveedor'];
					
					$CajaDiaria->CliNombre = $fila['CliNombre'];
					$CajaDiaria->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$CajaDiaria->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$CajaDiaria->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$CajaDiaria->TdoIdCliente = $fila['TdoIdCliente'];
					$CajaDiaria->TdoNombreCliente = $fila['TdoNombreCliente'];
				
					$CajaDiaria->PerNombre = $fila['PerNombre'];
					$CajaDiaria->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$CajaDiaria->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$CajaDiaria->PerNumeroDocumento = $fila['PerNumeroDocumento'];
					$CajaDiaria->TdoIdPersonal = $fila['TdoIdPersonal'];
					$CajaDiaria->TdoNombrePersonal = $fila['TdoNombrePersonal'];		

	
					switch($CajaDiaria->CdiEstado){
						case 1:
							$CajaDiaria->CdiEstadoCdicripcion = "Pendiente";
						break;
											
						case 3:
							$CajaDiaria->CdiEstadoCdicripcion = "Realizado";
						break;
						
						case 6:
							$CajaDiaria->CdiEstadoCdicripcion = "Anulado";
					
						break;
						
					}	
				
                    $CajaDiaria->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CajaDiaria;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
}
?>