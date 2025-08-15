<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteFichaIngreso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteCotizacionRepuesto {

    public $InsMysql;

	
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

		
	  public function MtdObtenerReporteCotizacionRepuestoCYC($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL) {

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
					if(!empty($oFechaFin)){
						
						$fecha = ' AND DATE(cve.CveFecha) >="'.$oFechaInicio.'" AND DATE(cve.CveFecha) <="'.$oFechaFin.'"';
						
					}else{
						$fecha = ' AND  DATE(cve.CveFecha) >="'.$oFechaInicio.'"';
					}
				}else{
					if(!empty($oFechaFin)){
						$fecha = ' AND DATE(cve.CveFecha)<="'.$oFechaFin.'"';		
					}			
				}
				
			
	
		
		
	if(!empty($oSucursal)){
			$sucursal = ' AND cve.SucId = "'.$oSucursal.'"';
		}
		
		 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS
				 
				SELECT 
cpr.CprId,
-- cpr.SucId,

suc.SucNombre,

cpr.CprFecha,
-- crd.ProId,

pro.ProCodigoOriginal,
pro.ProNombre,


crd.CrdCantidad,
crd.CrdImporte,
cpr.CprObservacionImpresa,
per.PerNombre

FROM tblcrdcotizacionproductodetalle crd
LEFT JOIN tblcprcotizacionproducto cpr
ON crd.CprId = cpr.CprId
LEFT JOIN tblproproducto pro
ON crd.ProId = pro.ProId
LEFT JOIN tblsucsucursal suc
ON cpr.SucId = suc.SucId
LEFT JOIN tblfinfichaingreso fin
ON cpr.FinId = fin.FinId
LEFT JOIN tblperpersonal per
ON fin.PerId = per.PerId
WHERE cpr.CprObservacionImpresa LIKE "%CYC%"

AND YEAR(cpr.CprFecha) = 2019
 AND MONTH(cpr.CprFecha) = 3
ORDER BY cpr.CprFecha ASC

			WHERE cve.CveEstado <> 6 '.$filtrar.$fecha.$ovvehiculo.$sucursal.$tipo.$stipo.$entrega.$estado.$moneda.$cocompra.$vdirecta.$ocompra.$faccion.$fingreso.$orden.$paginacion;
										
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteCotizacionRepuesto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
		

					$ReporteCotizacionRepuesto = new $InsReporteCotizacionRepuesto();
					
					
					  $ReporteCotizacionRepuesto->CveId = $fila['CveId'];
                    $ReporteCotizacionRepuesto->SucNombre = $fila['SucNombre'];
					
					$ReporteCotizacionRepuesto->CveFecha = $fila['NCveFecha'];
					$ReporteCotizacionRepuesto->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					
					$ReporteCotizacionRepuesto->CliNombre = $fila['CliNombre'];					
					$ReporteCotizacionRepuesto->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$ReporteCotizacionRepuesto->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$ReporteCotizacionRepuesto->CliTelefono = $fila['CliTelefono'];
					$ReporteCotizacionRepuesto->CliCelular = $fila['CliCelular'];
					
					$ReporteCotizacionRepuesto->PerNombre = $fila['PerNombre'];					
					$ReporteCotizacionRepuesto->PerApellidoPaterno = $fila['PerApellidoPaterno'];					
					$ReporteCotizacionRepuesto->PerApellidoMaterno = $fila['PerApellidoMaterno'];	
									
					$ReporteCotizacionRepuesto->AvvVehiculoModelo = $fila['CliNombreCompleto'];
					$ReporteCotizacionRepuesto->AvvVehiculoVersion = $fila['PerNombreCompleto'];										
					
					
					$ReporteCotizacionRepuesto->VmaNombre = $fila['VmaNombre'];
					$ReporteCotizacionRepuesto->VmoNombre = $fila['VmoNombre'];

					$ReporteCotizacionRepuesto->TrfNombre = $fila['TrfNombre'];
					
					$ReporteCotizacionRepuesto->CvePrecio = $fila['CvePrecio'];
					$ReporteCotizacionRepuesto->CveTotal = $fila['CveTotal'];
					
					$ReporteCotizacionRepuesto->MonId = $fila['MonId'];
					$ReporteCotizacionRepuesto->CveTipoCambio = $fila['CveTipoCambio'];
					
					
					$ReporteCotizacionRepuesto->MonNombre = $fila['MonNombre'];
					$ReporteCotizacionRepuesto->MonSimbolo = $fila['MonSimbolo'];


                    $ReporteCotizacionRepuesto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteCotizacionRepuesto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}



}
?>