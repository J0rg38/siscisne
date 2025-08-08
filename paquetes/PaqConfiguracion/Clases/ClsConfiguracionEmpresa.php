<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsConfiguracionEmpresa
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsConfiguracionEmpresa {

	public $CemId;
	public $CemAlias;
 	public $CemNombre;
	public $CemNombreComercial;
	public $CemCodigo;
	public $CemEmail;
	public $CemWeb;
	
	public $CemTelefono;
	public $CemFax;
	public $CemPais;
	public $CemDireccion;
	public $CemDepartamento;
	
	public $CemDistrito;
	public $CemProvincia;
	public $CemLogo;

	public $MonId;
	public $MonSimbolo;
	public $MonNombre;
	
	public $CemImpuestoVenta;
	public $CemImpuestoRenta;
	public $CemArticuloTipoCodificacion;	
	
	public $CemRepresentanteNombre;
	public $CemRepresentanteNumeroDocumento;
	
	public $CemCorreoPedidoTaller;
	public $CemCorreoVentaVehiculo;
	public $CemCorreoVentaRepuesto;	
	public $CemCorreoPedidoGM;

	public $CemRepuestoMargenUtilidad;
	public $CemRepuestoFlete;
	
	public $AlmId;
	public $CemMantenimientoPorcentajeManoObra;
    public $CemTiempoCreacion;
    public $CemTiempoModificacion;
    public $CemEliminado;
    public $InsMysql;
    public $CemPaisAbreviacion;
    public $CemCodigoUbigeo;
    public $CemImpuestoSelectivo;
    public $CalId;
    public $EmpresaXml;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

		
	public function MtdObtenerConfiguracionEmpresa(){

        $sql = 'SELECT 
        cem.CemId,
		cem.CemAlias,
        cem.CemNombre,

		cem.CemNombreComercial,
		cem.CemCodigo,
		cem.CemEmail,
		cem.CemWeb,

		cem.CemTelefono,
		
		cem.CemFax,
		cem.CemPais,
		cem.CemPaisAbreviacion,
		cem.CemDireccion,
		cem.CemDepartamento,

		cem.CemDistrito,
		cem.CemProvincia,
		cem.CemLogo,
		cem.MonId,
		cem.CalId,
		
		cem.CemCodigoUbigeo,
		cem.CemImpuestoVenta,
		cem.CemImpuestoSelectivo,
		cem.CemImpuestoRenta,
		cem.CemArticuloTipoCodificacion,
		
		cem.CemRepresentanteNombre,
		cem.CemRepresentanteNumeroDocumento,	

	
	
		cem.CemCorreoPedidoTaller,	
		cem.CemCorreoVentaVehiculo,	
		cem.CemCorreoVentaRepuesto,	
		cem.CemCorreoPedidoGM,	
		
	
		cem.CemRepuestoMargenUtilidad,
		cem.CemRepuestoFlete,
		
		cem.AlmId,
		cem.CemMantenimientoPorcentajeManoObra,
		
		DATE_FORMAT(cem.CemTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCemTiempoCreacion",
        DATE_FORMAT(cem.CemTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCemTiempoModificacion",
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		cal.CalTipo,
		cal.CalCosto,
		cal.CalTipoCambio,
		cal.CalMargen
		
        FROM tblcemconfiguracionempresa cem
			LEFT JOIN tblmonmoneda mon ON
			cem.MonId = mon.MonId
				LEFT JOIN tblcalcalificacion cal
				ON cem.CalId = cal.CalId
				
        WHERE cem.CemId = "'.$this->CemId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CemId = $fila['CemId'];
			$this->CemAlias = $fila['CemAlias'];          
			$this->CemNombre = $fila['CemNombre'];
			$this->CemNombreComercial = $fila['CemNombreComercial'];
			$this->CemCodigo = $fila['CemCodigo'];
			$this->CemEmail = $fila['CemEmail'];
			$this->CemWeb = $fila['CemWeb'];
			$this->CemTelefono = $fila['CemTelefono'];
			$this->CemFax = $fila['CemFax'];
			$this->CemPais = $fila['CemPais'];
			$this->CemPaisAbreviacion = $fila['CemPaisAbreviacion'];
			
			$this->CemDireccion = $fila['CemDireccion'];
			$this->CemDepartamento = $fila['CemDepartamento'];
			$this->CemDistrito = $fila['CemDistrito'];
			$this->CemProvincia = $fila['CemProvincia'];
			$this->CemLogo = $fila['CemLogo'];
			$this->MonId = $fila['MonId'];
			$this->CalId = $fila['CalId'];

			$this->CemCodigoUbigeo = $fila['CemCodigoUbigeo'];
			$this->CemImpuestoVenta = $fila['CemImpuestoVenta'];
			$this->CemImpuestoSelectivo = $fila['CemImpuestoSelectivo'];			
			$this->CemImpuestoRenta = $fila['CemImpuestoRenta'];
			$this->CemArticuloTipoCodificacion = $fila['CemArticuloTipoCodificacion'];
			
			$this->CemRepresentanteNombre = $fila['CemRepresentanteNombre'];
			$this->CemRepresentanteNumeroDocumento = $fila['CemRepresentanteNumeroDocumento'];	
			
			$this->CemCorreoPedidoTaller = $fila['CemCorreoPedidoTaller'];	
			$this->CemCorreoVentaVehiculo = $fila['CemCorreoVentaVehiculo'];	
			  $this->CemCorreoVentaRepuesto = $fila['CemCorreoVentaRepuesto'];	
			$this->CemCorreoPedidoGM = $fila['CemCorreoPedidoGM'];	

			$this->CemRepuestoMargenUtilidad = $fila['CemRepuestoMargenUtilidad'];
			$this->CemRepuestoFlete = $fila['CemRepuestoFlete'];
			
			$this->AlmId = $fila['AlmId'];
			$this->CemMantenimientoPorcentajeManoObra = $fila['CemMantenimientoPorcentajeManoObra'];
	
			$this->CemTiempoCreacion = $fila['NCemTiempoCreacion'];
			$this->CemTiempoModificacion = $fila['NCemTiempoModificacion']; 

			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];

			$this->CalTipo = $fila['CalTipo'];
			$this->CalCosto = $fila['CalCosto'];
			$this->CalTipoCambio = $fila['CalTipoCambio'];
			$this->CalMargen = $fila['CalMargen'];

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

	
	
		public function MtdGenerarConfiguracionEmpresa() {
			
//			deb($this->CemId);
$error = false;
			$this->MtdObtenerConfiguracionEmpresa();

			$cadena = '<?php '.	chr(13).	chr(13).
			' $EmpresaAlias = "'.$this->CemAlias.'";'.	chr(13).
			' $EmpresaNombre = "'.$this->CemNombre.'";'.	chr(13).
			' $EmpresaNombreComercial = "'.$this->CemNombreComercial.'";'.	chr(13).
			' $EmpresaCodigo = "'.$this->CemCodigo.'";'.	chr(13).
			' $EmpresaEmail = "'.$this->CemEmail.'";'.	chr(13).
			' $EmpresaWeb = "'.$this->CemWeb.'";'.	chr(13).
			' $EmpresaTelefono = "'.$this->CemTelefono.'";'.	chr(13).
			' $EmpresaFax = "'.$this->CemFax.'";'.	chr(13).
			' $EmpresaPais = "'.$this->CemPais.'";'.	chr(13).
			' $EmpresaPaisAbreviacion = "'.$this->CemPaisAbreviacion.'";'.	chr(13).
			
			
			' $EmpresaDireccion = "'.$this->CemDireccion.'";'.	chr(13).
			' $EmpresaDepartamento = "'.$this->CemDepartamento.'";'.	chr(13).
			' $EmpresaDistrito = "'.$this->CemDistrito.'";'.	chr(13).
			' $EmpresaProvincia = "'.$this->CemProvincia.'";'.	chr(13).
			' $EmpresaMonedaId = "'.$this->MonId.'";'.	chr(13).
			' $EmpresaMoneda = "'.$this->MonSimbolo.'";'.	chr(13).
			' $EmpresaMonedaNombre = "'.$this->MonNombre.'";'.	chr(13).
			
			' $EmpresaCodigoUbigeo = "'.$this->CemCodigoUbigeo.'";'.chr(13).
			' $EmpresaImpuestoVenta = "'.$this->CemImpuestoVenta.'";'.chr(13).
			' $EmpresaImpuestoSelectivo = "'.$this->CemImpuestoSelectivo.'";'.chr(13).
			
			' $EmpresaImpuestoRenta = "'.$this->CemImpuestoRenta.'";'.chr(13).

			' $EmpresaCorreoPedidoTaller = "'.$this->CemCorreoPedidoTaller.'";'.chr(13).
			' $EmpresaCorreoVentaVehiculo = "'.$this->CemCorreoVentaVehiculo.'";'.chr(13).
			' $EmpresaCorreoVentaRepuesto = "'.$this->CemCorreoVentaRepuesto.'";'.chr(13).
			' $EmpresaCorreoPedidoGM = "'.$this->CemCorreoPedidoGM.'";'.chr(13).
			
			' $EmpresaRepuestoMargenUtilidad = "'.$this->CemRepuestoMargenUtilidad.'";'.chr(13).
			' $EmpresaRepuestoFlete = "'.$this->CemRepuestoFlete.'";'.chr(13).
			
			' $EmpresaRepresentanteNombre = "'.$this->CemRepresentanteNombre.'";'.chr(13).
			' $EmpresaRepresentanteNumeroDocumento = "'.$this->CemRepresentanteNumeroDocumento.'";'.chr(13).	
			' $EmpresaArticuloTipoCodificacion = "'.$this->CemArticuloTipoCodificacion.'";'.chr(13).
			
			' $EmpresaAlmacenId = "'.$this->AlmId.'";'.chr(13).
			' $EmpresaMantenimientoPorcentajeManoObra = "'.$this->CemMantenimientoPorcentajeManoObra.'";'.chr(13).
				
			' $EmpresaCalificacionId = "'.$this->CalId.'";'.	
			'?>';			
			
/*
			' $EmpresaArticuloTipoCodificacion = "'.$this->CemArticuloTipoCodificacion.'";'.chr(13).	
			'?>';			

*/			
//deb($this->CemRuta.'CnfEmpresa.php'.$this->EmpresaXml);
			$Archivo = fopen($this->CemRuta.'CnfEmpresa.php'.$this->EmpresaXml,"w+");
			
			if(fwrite ($Archivo,$cadena)){
				fclose($Archivo);
			}else{
				$error = true;
			}

//deb($error);
			if($error) {						
				return false;
			} else {				
				return true;
			}	
						
				
	}	
		
	public function MtdEditarConfiguracionEmpresa() {
		
			$sql = 'UPDATE tblcemconfiguracionempresa SET 
			CemAlias = "'.($this->CemAlias).'",          

			CemNombre = "'.($this->CemNombre).'",
			CemNombreComercial = "'.($this->CemNombreComercial).'",
			CemCodigo = "'.($this->CemCodigo).'",
			CemEmail = "'.($this->CemEmail).'",
			CemWeb = "'.($this->CemWeb).'",
			
			CemTelefono = "'.($this->CemTelefono).'",
			CemFax = "'.($this->CemFax).'",
			CemPais = "'.($this->CemPais).'",
			CemPaisAbreviacion = "'.($this->CemPaisAbreviacion).'",
			
			CemDireccion = "'.($this->CemDireccion).'",
			CemDepartamento = "'.($this->CemDepartamento).'",
			
			CemDistrito = "'.($this->CemDistrito).'",
			CemProvincia = "'.($this->CemProvincia).'",
			CemLogo = "'.($this->CemLogo).'",
			MonId = "'.($this->MonId).'",
			CalId = "'.($this->CalId).'",
			
			CemCodigoUbigeo = "'.($this->CemCodigoUbigeo).'",
			CemImpuestoVenta = '.($this->CemImpuestoVenta).',
			CemImpuestoSelectivo = '.($this->CemImpuestoSelectivo).',
			CemImpuestoRenta = '.($this->CemImpuestoRenta).',
			CemArticuloTipoCodificacion = '.($this->CemArticuloTipoCodificacion).',	
			
			CemRepresentanteNombre = "'.($this->CemRepresentanteNombre).'",	
			CemRepresentanteNumeroDocumento = "'.($this->CemRepresentanteNumeroDocumento).'",	
			
			AlmId = "'.($this->AlmId).'",	
			CemMantenimientoPorcentajeManoObra = "'.($this->CemMantenimientoPorcentajeManoObra).'",	
			
			CemRepuestoMargenUtilidad = "'.($this->CemRepuestoMargenUtilidad).'",	
			CemRepuestoFlete = "'.($this->CemRepuestoFlete).'",	
			
			CemTiempoModificacion = "'.($this->CemTiempoModificacion).'"
			WHERE CemId = "'.($this->CemId).'";';
			
		
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
		
	
}
?>