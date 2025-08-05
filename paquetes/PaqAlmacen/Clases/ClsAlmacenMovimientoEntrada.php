<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAlmacenMovimientoEntrada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAlmacenMovimientoEntrada {

    public $AmoId;
	public $AmoTipo;
	public $AmoSubTipo;
	public $PrvId;
	public $CtiId;
	public $TopId;
	
	public $OcoId;
	
	public $NpaId;
	public $AmoCantidadDia;
	
	public $AlmId;
	public $AmoFecha;
	public $AmoDocumentoOrigen;
	
	public $AmoGuiaRemisionNumero;
	public $AmoGuiaRemisionNumeroSerie;
	public $AmoGuiaRemisionNumeroNumero;
	public $AmoGuiaRemisionFecha;
	public $AmoGuiaRemisionFoto;
	
	public $AmoComprobanteNumero;
	public $AmoComprobanteNumeroSerie;
	public $AmoComprobanteNumeroNumero;
	public $AmoComprobanteFecha;


	public $MonId;
	public $AmoTipoCambio;

	public $AmoIncluyeImpuesto;
	public $AmoPorcentajeImpuestoVenta;
	
	public $AmoFoto;
    public $AmoObservacion;
	
	public $AmoInternacionalTotalAduana;
	public $AmoInternacionalTotalTransporte;
	public $AmoInternacionalTotalDesestiba;
	public $AmoInternacionalTotalAlmacenaje;
	public $AmoInternacionalTotalAdValorem;
	public $AmoInternacionalTotalAduanaNacional;
	public $AmoInternacionalTotalGastoAdministrativo;
	public $AmoInternacionalTotalOtroCosto1;
	public $AmoInternacionalTotalOtroCosto2;	
	
	public $AmoNacionalTotalRecargo;
	public $AmoNacionalTotalFlete;
	public $AmoNacionalTotalOtroCosto;


	public $AmoInternacionalNumeroComprobante1;
	public $AmoInternacionalNumeroComprobante2;
	public $AmoInternacionalNumeroComprobante3;
	public $AmoInternacionalNumeroComprobante4;
	public $AmoInternacionalNumeroComprobante5;
	public $AmoInternacionalNumeroComprobante6;
	public $AmoInternacionalNumeroComprobante7;
	public $AmoInternacionalNumeroComprobante8;
	public $AmoInternacionalNumeroComprobante9;

	public $AmoNacionalNumeroComprobante1;
	public $AmoNacionalNumeroComprobante2;
	public $AmoNacionalNumeroComprobante3;
	
	public $AmoNacionalFoto1;
	public $AmoNacionalFoto2;
	public $AmoNacionalFoto3;

	public $MonIdInternacional1;
	public $MonIdInternacional2;
	public $MonIdInternacional3;
	public $MonIdInternacional4;
	public $MonIdInternacional5;
	public $MonIdInternacional6;
	public $MonIdInternacional7;
	public $MonIdInternacional8;
	public $MonIdInternacional9;

	public $MonIdNacional1;
	public $MonIdNacional2;
	public $MonIdNacional3;
	
		
	public $PrvIdInternacional1;
	public $PrvIdInternacional2;
	public $PrvIdInternacional3;
	public $PrvIdInternacional4;
	public $PrvIdInternacional5;
	public $PrvIdInternacional6;
	public $PrvIdInternacional7;
	public $PrvIdInternacional8;
	public $PrvIdInternacional9;

	public $PrvIdNacional1;
	public $PrvIdNacional2;
	public $PrvIdNacional3;

	public $PrvNumeroDocumentoInternacional1;
	public $PrvNumeroDocumentoInternacional2;
	public $PrvNumeroDocumentoInternacional3;
	public $PrvNumeroDocumentoInternacional4;
	public $PrvNumeroDocumentoInternacional5;
	public $PrvNumeroDocumentoInternacional6;
	public $PrvNumeroDocumentoInternacional7;
	public $PrvNumeroDocumentoInternacional8;
	public $PrvNumeroDocumentoInternacional9;	
			
	public $PrvNombreInternacional1;
	public $PrvNombreInternacional2;
	public $PrvNombreInternacional3;
	public $PrvNombreInternacional4;
	public $PrvNombreInternacional5;
	public $PrvNombreInternacional6;
	public $PrvNombreInternacional7;
	public $PrvNombreInternacional8;
	public $PrvNombreInternacional9;	
	
	public $TdoIdInternacional1;
	public $TdoIdInternacional2;
	public $TdoIdInternacional3;
	public $TdoIdInternacional4;
	public $TdoIdInternacional5;
	public $TdoIdInternacional6;
	public $TdoIdInternacional7;
	public $TdoIdInternacional8;
	public $TdoIdInternacional9;	
	
	

	public $PrvNumeroDocumentoNacional1;
	public $PrvNumeroDocumentoNacional2;
	public $PrvNumeroDocumentoNacional3;
	
	public $PrvNombreNacional1;
	public $PrvNombreNacional2;
	public $PrvNombreNacional3;	

	public $TdoIdDocumentoNacional1;
	public $TdoIdNacional2;
	public $TdoIdNacional3;
	
		
		
	public $AmoSubTotal;
	public $AmoImpuesto;
	public $AmoTotal;
	

	public $AmoValorTotal;
	
	public $AmoTotalInternacional;
	public $AmoTotalNacional;
			
	public $AmoCancelado;
	
	public $AmoRevisado;
	
	public $AmoEstado;
	public $AmoTiempoCreacion;
	public $AmoTiempoModificacion;
    public $AmoEliminado;

	public $CtiNombre;
	
	public $TdoId;
	public $PrvNombre;
	public $PrvNumeroDocumento;
	
	public $TdoNombre;
	
	public $MonSimbolo;
	
	public $AlmacenMovimientoEntradaDetalle;
	public $AlmacenMovimientoEntradaExtorno;
	public $OrdenCompraPedido;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarAlmacenMovimientoEntradaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(amo.AmoId,5),unsigned)) AS "MAXIMO"
		FROM tblamoalmacenmovimiento amo
		WHERE amo.AmoTipo = 1';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->AmoId = "AME-10000";
		}else{
			$fila['MAXIMO']++;
			$this->AmoId = "AME-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerAlmacenMovimientoEntrada(){

        $sql = 'SELECT 
        amo.AmoId,  
		amo.SucId,
		
		amo.AmoTipo,
		amo.AmoSubTipo,
		amo.PrvId,
		amo.CtiId,
		amo.TopId,
		
		amo.OcoId,
		
		amo.NpaId,
		amo.AmoCantidadDia,
		
		amo.AlmId,
		DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
		amo.AmoDocumentoOrigen,

		amo.AmoGuiaRemisionNumero,
		DATE_FORMAT(amo.AmoGuiaRemisionFecha, "%d/%m/%Y") AS "NAmoGuiaRemisionFecha",
		amo.AmoGuiaRemisionFoto,
		
		amo.AmoComprobanteNumero,
		DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",
		
		amo.MonId,
		amo.AmoTipoCambio,
		amo.AmoTipoCambioComercial,
		
		amo.AmoIncluyeImpuesto,
		amo.AmoPorcentajeImpuestoVenta,
	
		amo.AmoFoto,
		amo.AmoObservacion,

		amo.AmoNacionalTotalRecargo,
		amo.AmoNacionalTotalFlete,
		amo.AmoNacionalTotalOtroCosto,
		
		amo.AmoInternacionalTotalAduana,
		amo.AmoInternacionalTotalTransporte,
		amo.AmoInternacionalTotalDesestiba,
		amo.AmoInternacionalTotalAlmacenaje,
		amo.AmoInternacionalTotalAdValorem,
		amo.AmoInternacionalTotalAduanaNacional,
		amo.AmoInternacionalTotalGastoAdministrativo,
		amo.AmoInternacionalTotalOtroCosto1,
		amo.AmoInternacionalTotalOtroCosto2,

		amo.AmoInternacionalNumeroComprobante1,
		amo.AmoInternacionalNumeroComprobante2,
		amo.AmoInternacionalNumeroComprobante3,
		amo.AmoInternacionalNumeroComprobante4,
		amo.AmoInternacionalNumeroComprobante5,
		amo.AmoInternacionalNumeroComprobante6,
		amo.AmoInternacionalNumeroComprobante7,
		amo.AmoInternacionalNumeroComprobante8,
		amo.AmoInternacionalNumeroComprobante9,
		
		amo.AmoNacionalNumeroComprobante1,
		amo.AmoNacionalNumeroComprobante2,
		amo.AmoNacionalNumeroComprobante3,

		amo.AmoNacionalFoto1,
		amo.AmoNacionalFoto2,
		amo.AmoNacionalFoto3,

		amo.MonIdInternacional1,
		amo.MonIdInternacional2,
		amo.MonIdInternacional3,
		amo.MonIdInternacional4,
		amo.MonIdInternacional5,
		amo.MonIdInternacional6,
		amo.MonIdInternacional7,
		amo.MonIdInternacional8,
		amo.MonIdInternacional9,
		
		amo.MonIdNacional1,
		amo.MonIdNacional2,
		amo.MonIdNacional3,
				
		amo.PrvIdInternacional1,
		amo.PrvIdInternacional2,
		amo.PrvIdInternacional3,
		amo.PrvIdInternacional4,
		amo.PrvIdInternacional5,
		amo.PrvIdInternacional6,
		amo.PrvIdInternacional7,
		amo.PrvIdInternacional8,
		amo.PrvIdInternacional9,
		
		amo.PrvIdNacional1,
		amo.PrvIdNacional2,
		amo.PrvIdNacional3,

		pin1.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional1,
		pin2.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional2,
		pin3.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional3,
		pin4.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional4,
		pin5.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional5,
		pin6.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional6,
		pin7.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional7,
		pin8.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional8,
		pin9.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional9,	
				
		pin1.PrvNombre AS PrvNombreInternacional1,
		pin2.PrvNombre AS PrvNombreInternacional2,
		pin3.PrvNombre AS PrvNombreInternacional3,
		pin4.PrvNombre AS PrvNombreInternacional4,
		pin5.PrvNombre AS PrvNombreInternacional5,
		pin6.PrvNombre AS PrvNombreInternacional6,
		pin7.PrvNombre AS PrvNombreInternacional7,
		pin8.PrvNombre AS PrvNombreInternacional8,
		pin9.PrvNombre AS PrvNombreInternacional9,	
		
		pin1.TdoId AS TdoIdInternacional1,
		pin2.TdoId AS TdoIdInternacional2,
		pin3.TdoId AS TdoIdInternacional3,
		pin4.TdoId AS TdoIdInternacional4,
		pin5.TdoId AS TdoIdInternacional5,
		pin6.TdoId AS TdoIdInternacional6,
		pin7.TdoId AS TdoIdInternacional7,
		pin8.TdoId AS TdoIdInternacional8,
		pin9.TdoId AS TdoIdInternacional9,	
			
		pna1.PrvNumeroDocumento AS PrvNumeroDocumentoNacional1,
		pna2.PrvNumeroDocumento AS PrvNumeroDocumentoNacional2,
		pna3.PrvNumeroDocumento AS PrvNumeroDocumentoNacional3,
		
		pna1.PrvNombre AS PrvNombreNacional1,
		pna2.PrvNombre AS PrvNombreNacional2,
		pna3.PrvNombre AS PrvNombreNacional3,	
		
		pna1.TdoId AS TdoIdNacional1,
		pna2.TdoId AS TdoIdNacional2,
		pna3.TdoId AS TdoIdNacional3,	
		
	
		amo.AmoSubTotal,
		amo.AmoImpuesto,
		amo.AmoTotal,
		
		amo.AmoSubTotal AS AmoValorTotal,
		
		amo.AmoTotalInternacional,
		amo.AmoTotalNacional,
		
		amo.AmoCancelado,
		amo.AmoRevisado,
		
		amo.AmoValidarStock,
		amo.AmoEstado,
		DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoCreacion",
        DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoModificacion",
		
		cti.CtiNombre,
		
	
		prv.PrvNombreCompleto,
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		
		prv.PrvNumeroDocumento,
		prv.TdoId,
				
		mon.MonSimbolo
		
        FROM tblamoalmacenmovimiento amo
		
			LEFT JOIN tblcticomprobantetipo cti
			ON amo.CtiId = cti.CtiId
				LEFT JOIN tblprvproveedor prv
				ON amo.PrvId = prv.PrvId
					LEFT JOIN tbltdotipodocumento tdo
					ON prv.TdoId = tdo.TdoId
						LEFT JOIN tblmonmoneda mon
						ON amo.MonId = mon.MonId		
						
							LEFT JOIN tblprvproveedor pin1
							ON amo.PrvIdInternacional1 = pin1.PrvId
								LEFT JOIN tblprvproveedor pin2
								ON amo.PrvIdInternacional2 = pin2.PrvId
									LEFT JOIN tblprvproveedor pin3
									ON amo.PrvIdInternacional3 = pin3.PrvId
										LEFT JOIN tblprvproveedor pin4
										ON amo.PrvIdInternacional4 = pin4.PrvId
											LEFT JOIN tblprvproveedor pin5
											ON amo.PrvIdInternacional5 = pin5.PrvId
												LEFT JOIN tblprvproveedor pin6
												ON amo.PrvIdInternacional6 = pin6.PrvId
													LEFT JOIN tblprvproveedor pin7
													ON amo.PrvIdInternacional7 = pin7.PrvId
														LEFT JOIN tblprvproveedor pin8
														ON amo.PrvIdInternacional8 = pin8.PrvId
															LEFT JOIN tblprvproveedor pin9
															ON amo.PrvIdInternacional9 = pin9.PrvId

				LEFT JOIN tblprvproveedor pna1
				ON amo.PrvIdNacional1 = pna1.PrvId
					LEFT JOIN tblprvproveedor pna2
					ON amo.PrvIdNacional2 = pna2.PrvId
						LEFT JOIN tblprvproveedor pna3
						ON amo.PrvIdNacional3 = pna3.PrvId

        WHERE amo.AmoId = "'.$this->AmoId.'" AND amo.AmoTipo = 1 ;';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
			$ResAlmacenMovimientoEntradaDetalle =  $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,NULL,NULL,1,NULL,$fila['AmoId']);

			//$InsAlmacenMovimientoEntradaExtorno = new ClsAlmacenMovimientoEntradaExtorno();
//			$ResAlmacenMovimientoEntradaExtorno =  $InsAlmacenMovimientoEntradaExtorno->MtdObtenerAlmacenMovimientoEntradaExtornos(NULL,NULL,NULL,NULL,1,NULL,$fila['AmoId']);
				
			$this->AmoId = $fila['AmoId'];
			$this->SucId = $fila['SucId'];
			
			$this->PrvId = $fila['PrvId'];		
			$this->CtiId = $fila['CtiId'];		
			$this->TopId = $fila['TopId'];		
			
			$this->OcoId = $fila['OcoId'];
			
			$this->NpaId = $fila['NpaId'];
			$this->AmoCantidadDia = $fila['AmoCantidadDia'];

			$this->AlmId = $fila['AlmId'];
			$this->AmoFecha = $fila['NAmoFecha'];

			$this->AmoDocumentoOrigen = $fila['AmoDocumentoOrigen'];
			
			$this->AmoGuiaRemisionNumero = $fila['AmoGuiaRemisionNumero'];
			list($this->AmoGuiaRemisionNumeroSerie,$this->AmoGuiaRemisionNumeroNumero) = explode("-",$this->AmoGuiaRemisionNumero);
			$this->AmoGuiaRemisionFecha = $fila['NAmoGuiaRemisionFecha'];
			$this->AmoGuiaRemisionFoto = $fila['AmoGuiaRemisionFoto'];
			
			$this->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];
			list($this->AmoComprobanteNumeroSerie,$this->AmoComprobanteNumeroNumero) = explode("-",$this->AmoComprobanteNumero);
			$this->AmoComprobanteFecha = $fila['NAmoComprobanteFecha'];

			$this->MonId = $fila['MonId'];
			$this->AmoTipoCambio = $fila['AmoTipoCambio'];
			$this->AmoTipoCambioComercial = $fila['AmoTipoCambioComercial'];
			
			$this->AmoIncluyeImpuesto = $fila['AmoIncluyeImpuesto'];
			$this->AmoPorcentajeImpuestoVenta = $fila['AmoPorcentajeImpuestoVenta'];
			
			$this->AmoFoto = $fila['AmoFoto'];
			$this->AmoObservacion = $fila['AmoObservacion'];

			$this->AmoNacionalTotalRecargo = $fila['AmoNacionalTotalRecargo'];
			$this->AmoNacionalTotalFlete = $fila['AmoNacionalTotalFlete'];
			$this->AmoNacionalTotalOtroCosto = $fila['AmoNacionalTotalOtroCosto'];
					
			$this->AmoInternacionalTotalAduana = $fila['AmoInternacionalTotalAduana'];
			$this->AmoInternacionalTotalTransporte = $fila['AmoInternacionalTotalTransporte'];
			$this->AmoInternacionalTotalDesestiba = $fila['AmoInternacionalTotalDesestiba'];
			$this->AmoInternacionalTotalAlmacenaje = $fila['AmoInternacionalTotalAlmacenaje'];
			$this->AmoInternacionalTotalAdValorem = $fila['AmoInternacionalTotalAdValorem'];
			$this->AmoInternacionalTotalAduanaNacional = $fila['AmoInternacionalTotalAduanaNacional'];
			$this->AmoInternacionalTotalGastoAdministrativo = $fila['AmoInternacionalTotalGastoAdministrativo'];
			$this->AmoInternacionalTotalOtroCosto1 = $fila['AmoInternacionalTotalOtroCosto1'];
			$this->AmoInternacionalTotalOtroCosto2 = $fila['AmoInternacionalTotalOtroCosto2'];
	
	$this->AmoInternacionalNumeroComprobante1 = $fila['AmoInternacionalNumeroComprobante1'];
	$this->AmoInternacionalNumeroComprobante2 = $fila['AmoInternacionalNumeroComprobante2'];
	$this->AmoInternacionalNumeroComprobante3 = $fila['AmoInternacionalNumeroComprobante3'];
	$this->AmoInternacionalNumeroComprobante4 = $fila['AmoInternacionalNumeroComprobante4'];
	$this->AmoInternacionalNumeroComprobante5 = $fila['AmoInternacionalNumeroComprobante5'];
	$this->AmoInternacionalNumeroComprobante6 = $fila['AmoInternacionalNumeroComprobante6'];
	$this->AmoInternacionalNumeroComprobante7 = $fila['AmoInternacionalNumeroComprobante7'];
	$this->AmoInternacionalNumeroComprobante8 = $fila['AmoInternacionalNumeroComprobante8'];
	$this->AmoInternacionalNumeroComprobante9 = $fila['AmoInternacionalNumeroComprobante9'];
	
	$this->AmoNacionalNumeroComprobante1 = $fila['AmoNacionalNumeroComprobante1'];
	$this->AmoNacionalNumeroComprobante2 = $fila['AmoNacionalNumeroComprobante2'];
	$this->AmoNacionalNumeroComprobante3 = $fila['AmoNacionalNumeroComprobante3'];

	$this->MonIdInternacional1 = $fila['MonIdInternacional1'];
	$this->MonIdInternacional2 = $fila['MonIdInternacional2'];
	$this->MonIdInternacional3 = $fila['MonIdInternacional3'];
	$this->MonIdInternacional4 = $fila['MonIdInternacional4'];
	$this->MonIdInternacional5 = $fila['MonIdInternacional5'];
	$this->MonIdInternacional6 = $fila['MonIdInternacional6'];
	$this->MonIdInternacional7 = $fila['MonIdInternacional7'];
	$this->MonIdInternacional8 = $fila['MonIdInternacional8'];
	$this->MonIdInternacional9 = $fila['MonIdInternacional9'];
	
	$this->MonIdNacional1 = $fila['MonIdNacional1'];
	$this->MonIdNacional2 = $fila['MonIdNacional2'];
	$this->MonIdNacional3 = $fila['MonIdNacional3'];
	
	$this->PrvIdInternacional1 = $fila['PrvIdInternacional1'];
	$this->PrvIdInternacional2 = $fila['PrvIdInternacional2'];
	$this->PrvIdInternacional3 = $fila['PrvIdInternacional3'];
	$this->PrvIdInternacional4 = $fila['PrvIdInternacional4'];
	$this->PrvIdInternacional5 = $fila['PrvIdInternacional5'];
	$this->PrvIdInternacional6 = $fila['PrvIdInternacional6'];
	$this->PrvIdInternacional7 = $fila['PrvIdInternacional7'];
	$this->PrvIdInternacional8 = $fila['PrvIdInternacional8'];
	$this->PrvIdInternacional9 = $fila['PrvIdInternacional9'];
	
	$this->PrvIdNacional1 = $fila['PrvIdNacional1'];
	$this->PrvIdNacional2 = $fila['PrvIdNacional2'];
	$this->PrvIdNacional3 = $fila['PrvIdNacional3'];
	
	$this->PrvNumeroDocumentoInternacional1 = $fila['PrvNumeroDocumentoInternacional1'];
	$this->PrvNumeroDocumentoInternacional2 = $fila['PrvNumeroDocumentoInternacional2'];
	$this->PrvNumeroDocumentoInternacional3 = $fila['PrvNumeroDocumentoInternacional3'];
	$this->PrvNumeroDocumentoInternacional4 = $fila['PrvNumeroDocumentoInternacional4'];
	$this->PrvNumeroDocumentoInternacional5 = $fila['PrvNumeroDocumentoInternacional5'];
	$this->PrvNumeroDocumentoInternacional6 = $fila['PrvNumeroDocumentoInternacional6'];
	$this->PrvNumeroDocumentoInternacional7 = $fila['PrvNumeroDocumentoInternacional7'];
	$this->PrvNumeroDocumentoInternacional8 = $fila['PrvNumeroDocumentoInternacional8'];
	$this->PrvNumeroDocumentoInternacional9 = $fila['PrvNumeroDocumentoInternacional9'];	
			
	$this->PrvNombreInternacional1 = $fila['PrvNombreInternacional1'];
	$this->PrvNombreInternacional2 = $fila['PrvNombreInternacional2'];
	$this->PrvNombreInternacional3 = $fila['PrvNombreInternacional3'];
	$this->PrvNombreInternacional4 = $fila['PrvNombreInternacional4'];
	$this->PrvNombreInternacional5 = $fila['PrvNombreInternacional5'];
	$this->PrvNombreInternacional6 = $fila['PrvNombreInternacional6'];
	$this->PrvNombreInternacional7 = $fila['PrvNombreInternacional7'];
	$this->PrvNombreInternacional8 = $fila['PrvNombreInternacional8'];
	$this->PrvNombreInternacional9 = $fila['PrvNombreInternacional9'];	
	
	$this->TdoIdInternacional1 = $fila['TdoIdInternacional1'];
	$this->TdoIdInternacional2 = $fila['TdoIdInternacional2'];
	$this->TdoIdInternacional3 = $fila['TdoIdInternacional3'];
	$this->TdoIdInternacional4 = $fila['TdoIdInternacional4'];
	$this->TdoIdInternacional5 = $fila['TdoIdInternacional5'];
	$this->TdoIdInternacional6 = $fila['TdoIdInternacional6'];
	$this->TdoIdInternacional7 = $fila['TdoIdInternacional7'];
	$this->TdoIdInternacional8 = $fila['TdoIdInternacional8'];
	$this->TdoIdInternacional9 = $fila['TdoIdInternacional9'];	

	$this->AmoNacionalFoto1 = $fila['AmoNacionalFoto1'];
	$this->AmoNacionalFoto2 = $fila['AmoNacionalFoto2'];
	$this->AmoNacionalFoto3 = $fila['AmoNacionalFoto3'];

	$this->PrvNombreNacional1 = $fila['PrvNombreNacional1'];
	$this->PrvNombreNacional2 = $fila['PrvNombreNacional2'];
	$this->PrvNombreNacional3 = $fila['PrvNombreNacional3'];	
	
	$this->TdoIdNacional1 = $fila['TdoIdNacional1'];
	$this->TdoIdNacional2 = $fila['TdoIdNacional2'];
	$this->TdoIdNacional3 = $fila['TdoIdNacional3'];		

		
			$this->AmoSubTotal = $fila['AmoSubTotal'];
			$this->AmoImpuesto = $fila['AmoImpuesto'];
			$this->AmoTotal = $fila['AmoTotal'];
			
			$this->AmoValorTotal = $fila['AmoValorTotal'];

			$this->AmoTotalInternacional = $fila['AmoTotalInternacional'];
			$this->AmoTotalNacional = $fila['AmoTotalNacional'];
	
					
					
			$this->AmoCancelado = $fila['AmoCancelado'];
			$this->AmoRevisado = $fila['AmoRevisado'];
			
			$this->AmoValidarStock = $fila['AmoValidarStock'];
			
			$this->AmoEstado = $fila['AmoEstado'];
			$this->AmoTiempoCreacion = $fila['NAmoTiempoCreacion']; 
			$this->AmoTiempoModificacion = $fila['NAmoTiempoModificacion']; 	
			
			$this->AlmacenMovimientoEntradaDetalle = 	$ResAlmacenMovimientoEntradaDetalle['Datos'];	

			$this->CtiNombre = $fila['CtiNombre']; 	
			

			$this->PrvNombreCompleto = $fila['PrvNombreCompleto']; 	
			$this->PrvNombre = $fila['PrvNombre']; 	
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 	
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 	
			
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->TdoId = $fila['TdoId']; 	
			$this->TdoNombre = $fila['TdoNombre'];

			$this->MonSimbolo = $fila['MonSimbolo']; 	
			



			switch($this->AmoEstado){
			
				case 1:
					$Estado = "No Realizado";
				break;
			
				case 3:
					$Estado = "Realizado";						
				break;	

				default:
					$Estado = "";
				break;
			
			}
				
			$this->AmoEstadoDescripcion = $Estado;
			
			
			switch($this->AmoEstado){
			
				case 1:
					$Estado = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
				break;
			
				case 3:
					$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';						
				break;	
				
				default:
					$Estado = "";
				break;
			
			}
				
			$this->AmoEstadoIcono = $Estado;




		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oSubTipo=NULL,$oAlmacen=NULL,$oSucursal=NULL) {

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
				
				

				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					amd.AmdId

					FROM tblamdalmacenmovimientodetalle amd
					
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId

							LEFT JOIN tblpcdpedidocompradetalle pcd
							ON amd.PcdId = pcd.PcdId
								
								LEFT JOIN tblpcopedidocompra pco
								ON pcd.PcoId = pco.PcoId
								
									LEFT JOIN tblclicliente cli
									ON pco.CliId = cli.CliId

					WHERE 
						amd.AmoId = amo.AmoId AND 
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" OR
						
						cli.CliNombreCompleto  LIKE "%'.$oFiltro.'%" OR
						cli.CliNombre  LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoPaterno  LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoMaterno  LIKE "%'.$oFiltro.'%" OR
						cli.CliNumeroDocumento  LIKE "%'.$oFiltro.'%"
						
						)
						
						
						
					) ';
					
									
				$filtrar .= '  ) ';

			

				
					
					
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		if(!empty($oTipo)){
			$tipo = ' AND amo.AmoTipo = '.$oTipo;
		}
				
		if(!empty($oSubTipo)){

			$elementos = explode(",",$oSubTipo);

				$i=1;
				$stipo .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$stipo .= '  (amo.AmoSubTipo = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$stipo .= ' OR ';	
						}
				$i++;		
				}
				
				$stipo .= ' ) ';

		}
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(amo.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		/*if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}*/


		if(!empty($oEstado)){
			$estado = ' AND amo.AmoEstado = '.$oEstado;
		}
		

		if(!empty($oOrigen)){
			$origen = ' AND amo.AmoDocumentoOrigen = '.$oOrigen;
		}
		

		if(!empty($oMoneda)){
			$moneda = ' AND amo.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND amo.OcoId = "'.$oOrdenCompra.'"';
		}
		


		
		if(!empty($oPedidoCompra)){
			
			$pcompra = ' 
			AND EXISTS(
			
				SELECT 
				pcd.PcoId
				FROM tblamdalmacenmovimientodetalle amd
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
				WHERE amd.AmoId = amo.AmoId
				AND pcd.PcoId = "'.$oPedidoCompra.'"
				LIMIT 1
			)
							
			';
		}
		
		if(!empty($oPedidoCompraDetalle)){
			
			 $pcompradetalle = ' 
			AND EXISTS(

				SELECT
				amd.AmdId
				FROM tblamdalmacenmovimientodetalle amd
				WHERE 
				amo.AmoId = amd.AmoId
				AND amd.PcdId = "'.$oPedidoCompraDetalle.'"

				LIMIT 1

			)
			';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND amo.CliId = "'.$oCliente.'"';
		}	
		
		
		switch($oConOrdenCompra){
			
			case 1:
			
				$cocompra = ' AND amo.OcoId IS NOT NULL ';
				
			break;
			
			case 2:

				$cocompra = ' AND amo.OcoId IS NULL ';
				
			break;
			
			default:
			
			break;
		}
		
		if($oCancelado){
			$cancelado = ' AND amo.AmoCancelado = '.$oCancelado;
		}
		
		
		if(!empty($oProveedor)){
			$proveedor = ' AND amo.PrvId = "'.$oProveedor.'"';
		}
		
		if(!empty($oVentaDirecta)){
			$vdirecta = ' AND pco.VdiId = "'.$oVentaDirecta.'"';
		}
		
		if(!empty($oCondicionPago)){
			$cpago = ' AND amo.NpaId = "'.$oCondicionPago.'"';
		}
		
		
		if(!empty($oAlmacen)){
			$almacen = ' AND amo.AlmId = "'.$oAlmacen.'"';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND amo.SucId = "'.$oSucursal.'"';
		}	
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				amo.AmoId,		
				amo.SucId,				
				
				amo.AmoTipo,
				amo.AmoSubTipo,
				amo.PrvId,
				amo.CtiId,
				amo.TopId,
				
				amo.OcoId,	
				amo.NpaId,	
				amo.AmoCantidadDia,	
				
				
				amo.AlmId,
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
				amo.AmoDocumentoOrigen,
				
				amo.AmoGuiaRemisionNumero,
				DATE_FORMAT(amo.AmoGuiaRemisionFecha, "%d/%m/%Y") AS "NAmoGuiaRemisionFecha",
				amo.AmoGuiaRemisionFoto,
				
				amo.AmoComprobanteNumero,
				DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",
				
				amo.MonId,
				amo.AmoTipoCambio,
				amo.AmoTipoCambioComercial,
				
				amo.AmoIncluyeImpuesto,
				amo.AmoPorcentajeImpuestoVenta,
						
				amo.AmoNacionalTotalRecargo,
				amo.AmoNacionalTotalFlete,
				amo.AmoNacionalTotalOtroCosto,
					
				amo.AmoInternacionalTotalAduana,
				amo.AmoInternacionalTotalTransporte,
				amo.AmoInternacionalTotalDesestiba,
				amo.AmoInternacionalTotalAlmacenaje,
				amo.AmoInternacionalTotalAdValorem,
				amo.AmoInternacionalTotalAduanaNacional,
				amo.AmoInternacionalTotalGastoAdministrativo,
				amo.AmoInternacionalTotalOtroCosto1,
				amo.AmoInternacionalTotalOtroCosto2,				
			
			
		amo.AmoInternacionalNumeroComprobante1,
		amo.AmoInternacionalNumeroComprobante2,
		amo.AmoInternacionalNumeroComprobante3,
		amo.AmoInternacionalNumeroComprobante4,
		amo.AmoInternacionalNumeroComprobante5,
		amo.AmoInternacionalNumeroComprobante6,
		amo.AmoInternacionalNumeroComprobante7,
		amo.AmoInternacionalNumeroComprobante8,
		amo.AmoInternacionalNumeroComprobante9,
		
		amo.AmoNacionalNumeroComprobante1,
		amo.AmoNacionalNumeroComprobante2,
		amo.AmoNacionalNumeroComprobante3,
		
		amo.AmoNacionalFoto1,
		amo.AmoNacionalFoto2,
		amo.AmoNacionalFoto3,

		amo.MonIdInternacional1,
		amo.MonIdInternacional2,
		amo.MonIdInternacional3,
		amo.MonIdInternacional4,
		amo.MonIdInternacional5,
		amo.MonIdInternacional6,
		amo.MonIdInternacional7,
		amo.MonIdInternacional8,
		amo.MonIdInternacional9,
		
		amo.MonIdNacional1,
		amo.MonIdNacional2,
		amo.MonIdNacional3,


		amo.PrvIdInternacional1,
		amo.PrvIdInternacional2,
		amo.PrvIdInternacional3,
		amo.PrvIdInternacional4,
		amo.PrvIdInternacional5,
		amo.PrvIdInternacional6,
		amo.PrvIdInternacional7,
		amo.PrvIdInternacional8,
		amo.PrvIdInternacional9,
		
		amo.PrvIdNacional1,
		amo.PrvIdNacional2,
		amo.PrvIdNacional3,

	pin1.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional1,
	pin2.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional2,
	pin3.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional3,
	pin4.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional4,
	pin5.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional5,
	pin6.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional6,
	pin7.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional7,
	pin8.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional8,
	pin9.PrvNumeroDocumento AS PrvNumeroDocumentoInternacional9,	
			
	pin1.PrvNombre AS PrvNombreInternacional1,
	pin2.PrvNombre AS PrvNombreInternacional2,
	pin3.PrvNombre AS PrvNombreInternacional3,
	pin4.PrvNombre AS PrvNombreInternacional4,
	pin5.PrvNombre AS PrvNombreInternacional5,
	pin6.PrvNombre AS PrvNombreInternacional6,
	pin7.PrvNombre AS PrvNombreInternacional7,
	pin8.PrvNombre AS PrvNombreInternacional8,
	pin9.PrvNombre AS PrvNombreInternacional9,	
	
	pin1.TdoId AS TdoIdInternacional1,
	pin2.TdoId AS TdoIdInternacional2,
	pin3.TdoId AS TdoIdInternacional3,
	pin4.TdoId AS TdoIdInternacional4,
	pin5.TdoId AS TdoIdInternacional5,
	pin6.TdoId AS TdoIdInternacional6,
	pin7.TdoId AS TdoIdInternacional7,
	pin8.TdoId AS TdoIdInternacional8,
	pin9.TdoId AS TdoIdInternacional9,	
	
	

	pna1.PrvNumeroDocumento AS PrvNumeroDocumentoNacional1,
	pna2.PrvNumeroDocumento AS PrvNumeroDocumentoNacional2,
	pna3.PrvNumeroDocumento AS PrvNumeroDocumentoNacional3,
	
	pna1.PrvNombre AS PrvNombreNacional1,
	pna2.PrvNombre AS PrvNombreNacional2,
	pna3.PrvNombre AS PrvNombreNacional3,	
	
	pna1.TdoId AS TdoIdNacional1,
	pna2.TdoId AS TdoIdNacional2,
	pna3.TdoId AS TdoIdNacional3,	

				amo.AmoFoto,
				amo.AmoObservacion,
				
				amo.AmoSubTotal,
				amo.AmoImpuesto,				
				amo.AmoTotal,
				
				amo.AmoTotalInternacional,
				amo.AmoTotalNacional,
				
				amo.AmoCancelado,
				amo.AmoRevisado,
				amo.AmoCierre,
				
				amo.AmoValidarStock,
				amo.AmoEstado,
				DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoCreacion",
	        	DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoModificacion",
				
				DATE_FORMAT(adddate(amo.AmoComprobanteFecha,amo.AmoCantidadDia), "%d/%m/%Y") AS AmoFechaVencimiento,
				DATEDIFF(DATE(NOW()),amo.AmoComprobanteFecha) AS AmoDiaTranscurrido,

				CASE
				WHEN EXISTS (
					SELECT 
					amo.AmoId 
					FROM tblamoalmacenmovimiento amo2
					WHERE amo2.AmoIdOrigen = amo.AmoId
					AND amo2.AmoEstado = 3 
					AND amo2.AmoTipo = 2
					AND amo2.AmoSubTipo = 5
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoNotaCreditoCompra,
				
				(SELECT COUNT(amd.AmdId) FROM tblamdalmacenmovimientodetalle amd WHERE amd.AmoId = amo.AmoId ) AS "AmoTotalItems",

				cti.CtiNombre,
				
				prv.TdoId,

				prv.PrvNombreCompleto,
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				
				prv.PrvNumeroDocumento,
				
				tdo.TdoNombre,
				
				mon.MonSimbolo,
				
				npa.NpaNombre,
				
				vma.VmaNombre,
				
				suc.SucNombre,
				alm.AlmNombre
				

				FROM tblamoalmacenmovimiento amo
					LEFT JOIN tblocoordencompra oco
					ON amo.OcoId = oco.OcoId
					
						LEFT JOIN tblvmavehiculomarca vma
						ON oco.VmaId = vma.VmaId
						
						LEFT JOIN tblpcopedidocompra pco
						ON oco.OcoId = pco.OcoId
						
						LEFT JOIN tblnpacondicionpago npa
						ON amo.NpaId = npa.NpaId
						
					LEFT JOIN tblcticomprobantetipo cti
					ON amo.CtiId = cti.CtiId
						LEFT JOIN tblprvproveedor prv
						ON amo.PrvId = prv.PrvId
							LEFT JOIN tbltdotipodocumento tdo
							ON prv.TdoId = tdo.TdoId
								LEFT JOIN tblmonmoneda mon
								ON amo.MonId = mon.MonId
	
							LEFT JOIN tblprvproveedor pin1
							ON amo.PrvIdInternacional1 = pin1.PrvId
								LEFT JOIN tblprvproveedor pin2
								ON amo.PrvIdInternacional2 = pin2.PrvId
									LEFT JOIN tblprvproveedor pin3
									ON amo.PrvIdInternacional3 = pin3.PrvId
										LEFT JOIN tblprvproveedor pin4
										ON amo.PrvIdInternacional4 = pin4.PrvId
											LEFT JOIN tblprvproveedor pin5
											ON amo.PrvIdInternacional5 = pin5.PrvId
												LEFT JOIN tblprvproveedor pin6
												ON amo.PrvIdInternacional6 = pin6.PrvId
													LEFT JOIN tblprvproveedor pin7
													ON amo.PrvIdInternacional7 = pin7.PrvId
														LEFT JOIN tblprvproveedor pin8
														ON amo.PrvIdInternacional8 = pin8.PrvId
															LEFT JOIN tblprvproveedor pin9
															ON amo.PrvIdInternacional9 = pin9.PrvId
	
					LEFT JOIN tblprvproveedor pna1
					ON amo.PrvIdNacional1 = pna1.PrvId
						LEFT JOIN tblprvproveedor pna2
						ON amo.PrvIdNacional2 = pna2.PrvId
							LEFT JOIN tblprvproveedor pna3
							ON amo.PrvIdNacional3 = pna3.PrvId
							
							
							LEFT JOIN tblsucsucursal suc
							ON amo.SucId = suc.SucId
								LEFT JOIN tblalmalmacen alm
								ON amo.AlmId = alm.AlmId
						
				WHERE amo.AmoTipo = 1 '.$filtrar.$fecha.$tipo.$sucursal.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$proveedor.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAlmacenMovimientoEntrada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AlmacenMovimientoEntrada = new $InsAlmacenMovimientoEntrada();
                    $AlmacenMovimientoEntrada->AmoId = $fila['AmoId'];
					$AlmacenMovimientoEntrada->SucId = $fila['SucId'];
					
					$AlmacenMovimientoEntrada->PrvId = $fila['PrvId'];		
					$AlmacenMovimientoEntrada->CtiId = $fila['CtiId'];	
					$AlmacenMovimientoEntrada->TopId = $fila['TopId'];	
						
					$AlmacenMovimientoEntrada->OcoId = $fila['OcoId'];
					
					$AlmacenMovimientoEntrada->NpaId = $fila['NpaId'];
					$AlmacenMovimientoEntrada->AmoCantidadDia = $fila['AmoCantidadDia'];							
					
				
					$AlmacenMovimientoEntrada->AlmId = $fila['AlmId'];
					$AlmacenMovimientoEntrada->AmoFecha = $fila['NAmoFecha'];
					$AlmacenMovimientoEntrada->AmoDocumentoOrigen = $fila['AmoDocumentoOrigen'];
					
					$AlmacenMovimientoEntrada->AmoGuiaRemisionNumero = $fila['AmoGuiaRemisionNumero'];
					list($AlmacenMovimientoEntrada->AmoGuiaRemisionNumeroSerie,$AlmacenMovimientoEntrada->AmoGuiaRemisionNumeroNumero) = explode("-",$AlmacenMovimientoEntrada->AmoGuiaRemisionNumero);
					$AlmacenMovimientoEntrada->AmoGuiaRemisionFecha = $fila['NAmoGuiaRemisionFecha'];
					$AlmacenMovimientoEntrada->AmoGuiaRemisionFoto = $fila['AmoGuiaRemisionFoto'];
					
					
					$AlmacenMovimientoEntrada->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];
					list($AlmacenMovimientoEntrada->AmoComprobanteNumeroSerie,$AlmacenMovimientoEntrada->AmoComprobanteNumeroNumero) = explode("-",$AlmacenMovimientoEntrada->AmoComprobanteNumero);					
					$AlmacenMovimientoEntrada->AmoComprobanteFecha = $fila['NAmoComprobanteFecha'];
					
					$AlmacenMovimientoEntrada->MonId = $fila['MonId'];
					$AlmacenMovimientoEntrada->AmoTipoCambio = $fila['AmoTipoCambio'];
					$AlmacenMovimientoEntrada->AmoTipoCambioComercial = $fila['AmoTipoCambioComercial'];
					
					$AlmacenMovimientoEntrada->AmoIncluyeImpuesto = $fila['AmoIncluyeImpuesto'];
					$AlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta = $fila['AmoPorcentajeImpuestoVenta'];
					
					
					
					$AlmacenMovimientoEntrada->AmoFoto = $fila['AmoFoto'];
					$AlmacenMovimientoEntrada->AmoObservacion = $fila['AmoObservacion'];
		
					$AlmacenMovimientoEntrada->AmoNacionalTotalRecargo = $fila['AmoNacionalTotalRecargo'];
					$AlmacenMovimientoEntrada->AmoNacionalTotalFlete = $fila['AmoNacionalTotalFlete'];
					$AlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto = $fila['AmoNacionalTotalOtroCosto'];
					
					$AlmacenMovimientoEntrada->AmoInternacionalTotalAduana = $fila['AmoInternacionalTotalAduana'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalTransporte = $fila['AmoInternacionalTotalTransporte'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba = $fila['AmoInternacionalTotalDesestiba'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje = $fila['AmoInternacionalTotalAlmacenaje'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem = $fila['AmoInternacionalTotalAdValorem'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional = $fila['AmoInternacionalTotalAduanaNacional'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo = $fila['AmoInternacionalTotalGastoAdministrativo'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1 = $fila['AmoInternacionalTotalOtroCosto1'];
					$AlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2 = $fila['AmoInternacionalTotalOtroCosto2'];
					


	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero1 = $fila['AmoInternacionalComprobanteNumero1'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero2 = $fila['AmoInternacionalComprobanteNumero2'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero3 = $fila['AmoInternacionalComprobanteNumero3'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero4 = $fila['AmoInternacionalComprobanteNumero4'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero5 = $fila['AmoInternacionalComprobanteNumero5'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero6 = $fila['AmoInternacionalComprobanteNumero6'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero7 = $fila['AmoInternacionalComprobanteNumero7'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero8 = $fila['AmoInternacionalComprobanteNumero8'];
	$AlmacenMovimientoEntrada->AmoInternacionalComprobanteNumero9 = $fila['AmoInternacionalComprobanteNumero9'];
	
	$AlmacenMovimientoEntrada->AmoNacionalComprobanteNumero1 = $fila['AmoNacionalComprobanteNumero1'];
	$AlmacenMovimientoEntrada->AmoNacionalComprobanteNumero2 = $fila['AmoNacionalComprobanteNumero2'];
	$AlmacenMovimientoEntrada->AmoNacionalComprobanteNumero3 = $fila['AmoNacionalComprobanteNumero3'];
	
	$AlmacenMovimientoEntrada->AmoNacionalFoto1 = $fila['AmoNacionalFoto1'];
	$AlmacenMovimientoEntrada->AmoNacionalFoto2 = $fila['AmoNacionalFoto2'];
	$AlmacenMovimientoEntrada->AmoNacionalFoto3 = $fila['AmoNacionalFoto3'];
	
	$AlmacenMovimientoEntrada->MonIdInternacional1 = $fila['MonIdInternacional1'];
	$AlmacenMovimientoEntrada->MonIdInternacional2 = $fila['MonIdInternacional2'];
	$AlmacenMovimientoEntrada->MonIdInternacional3 = $fila['MonIdInternacional3'];
	$AlmacenMovimientoEntrada->MonIdInternacional4 = $fila['MonIdInternacional4'];
	$AlmacenMovimientoEntrada->MonIdInternacional5 = $fila['MonIdInternacional5'];
	$AlmacenMovimientoEntrada->MonIdInternacional6 = $fila['MonIdInternacional6'];
	$AlmacenMovimientoEntrada->MonIdInternacional7 = $fila['MonIdInternacional7'];
	$AlmacenMovimientoEntrada->MonIdInternacional8 = $fila['MonIdInternacional8'];
	$AlmacenMovimientoEntrada->MonIdInternacional9 = $fila['MonIdInternacional9'];
	
	$AlmacenMovimientoEntrada->MonIdNacional1 = $fila['MonIdNacional1'];
	$AlmacenMovimientoEntrada->MonIdNacional2 = $fila['MonIdNacional2'];
	$AlmacenMovimientoEntrada->MonIdNacional3 = $fila['MonIdNacional3'];
	
	
	
	
	$AlmacenMovimientoEntrada->PrvIdInternacional1 = $fila['PrvIdInternacional1'];
	$AlmacenMovimientoEntrada->PrvIdInternacional2 = $fila['PrvIdInternacional2'];
	$AlmacenMovimientoEntrada->PrvIdInternacional3 = $fila['PrvIdInternacional3'];
	$AlmacenMovimientoEntrada->PrvIdInternacional4 = $fila['PrvIdInternacional4'];
	$AlmacenMovimientoEntrada->PrvIdInternacional5 = $fila['PrvIdInternacional5'];
	$AlmacenMovimientoEntrada->PrvIdInternacional6 = $fila['PrvIdInternacional6'];
	$AlmacenMovimientoEntrada->PrvIdInternacional7 = $fila['PrvIdInternacional7'];
	$AlmacenMovimientoEntrada->PrvIdInternacional8 = $fila['PrvIdInternacional8'];
	$AlmacenMovimientoEntrada->PrvIdInternacional9 = $fila['PrvIdInternacional9'];
	
	$AlmacenMovimientoEntrada->PrvIdNacional1 = $fila['PrvIdNacional1'];
	$AlmacenMovimientoEntrada->PrvIdNacional2 = $fila['PrvIdNacional2'];
	$AlmacenMovimientoEntrada->PrvIdNacional3 = $fila['PrvIdNacional3'];
						
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional1 = $fila['PrvNumeroDocumentoInternacional1'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional2 = $fila['PrvNumeroDocumentoInternacional2'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional3 = $fila['PrvNumeroDocumentoInternacional3'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional4 = $fila['PrvNumeroDocumentoInternacional4'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional5 = $fila['PrvNumeroDocumentoInternacional5'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional6 = $fila['PrvNumeroDocumentoInternacional6'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional7 = $fila['PrvNumeroDocumentoInternacional7'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional8 = $fila['PrvNumeroDocumentoInternacional8'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional9 = $fila['PrvNumeroDocumentoInternacional9'];	
			
	$AlmacenMovimientoEntrada->PrvNombreInternacional1 = $fila['PrvNombreInternacional1'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional2 = $fila['PrvNombreInternacional2'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional3 = $fila['PrvNombreInternacional3'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional4 = $fila['PrvNombreInternacional4'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional5 = $fila['PrvNombreInternacional5'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional6 = $fila['PrvNombreInternacional6'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional7 = $fila['PrvNombreInternacional7'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional8 = $fila['PrvNombreInternacional8'];
	$AlmacenMovimientoEntrada->PrvNombreInternacional9 = $fila['PrvNombreInternacional9'];
	
	$AlmacenMovimientoEntrada->TdoIdInternacional1 = $fila['TdoIdInternacional1'];
	$AlmacenMovimientoEntrada->TdoIdInternacional2 = $fila['TdoIdInternacional2'];
	$AlmacenMovimientoEntrada->TdoIdInternacional3 = $fila['TdoIdInternacional3'];
	$AlmacenMovimientoEntrada->TdoIdInternacional4 = $fila['TdoIdInternacional4'];
	$AlmacenMovimientoEntrada->TdoIdInternacional5 = $fila['TdoIdInternacional5'];
	$AlmacenMovimientoEntrada->TdoIdInternacional6 = $fila['TdoIdInternacional6'];
	$AlmacenMovimientoEntrada->TdoIdInternacional7 = $fila['TdoIdInternacional7'];
	$AlmacenMovimientoEntrada->TdoIdInternacional8 = $fila['TdoIdInternacional8'];
	$AlmacenMovimientoEntrada->TdoIdInternacional9 = $fila['TdoIdInternacional9'];	
	

	$AlmacenMovimientoEntrada->PrvNumeroDocumentoNacional1 = $fila['PrvNumeroDocumentoNacional1'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoNacional2 = $fila['PrvNumeroDocumentoNacional2'];
	$AlmacenMovimientoEntrada->PrvNumeroDocumentoNacional3 = $fila['PrvNumeroDocumentoNacional3'];
	
	$AlmacenMovimientoEntrada->PrvNombreNacional1 = $fila['PrvNombreNacional1'];
	$AlmacenMovimientoEntrada->PrvNombreNacional2 = $fila['PrvNombreNacional2'];
	$AlmacenMovimientoEntrada->PrvNombreNacional3 = $fila['PrvNombreNacional3'];	
	
	$AlmacenMovimientoEntrada->TdoIdNacional1 = $fila['TdoIdNacional1'];
	$AlmacenMovimientoEntrada->TdoIdNacional2 = $fila['TdoIdNacional2'];
	$AlmacenMovimientoEntrada->TdoIdNacional3 = $fila['TdoIdNacional3'];	
	
					$AlmacenMovimientoEntrada->AmoSubTotal = $fila['AmoSubTotal'];			
					$AlmacenMovimientoEntrada->AmoImpuesto = $fila['AmoImpuesto'];
					$AlmacenMovimientoEntrada->AmoTotal = $fila['AmoTotal'];
					
					$AlmacenMovimientoEntrada->AmoValorTotal = $AlmacenMovimientoEntrada->AmoTotal;
					
					$AlmacenMovimientoEntrada->AmoTotalInternacional = $fila['AmoTotalInternacional'];
					$AlmacenMovimientoEntrada->AmoTotalNacional = $fila['AmoTotalNacional'];
							
							
					$AlmacenMovimientoEntrada->AmoCancelado = $fila['AmoCancelado'];	
					$AlmacenMovimientoEntrada->AmoRevisado = $fila['AmoRevisado'];
					$AlmacenMovimientoEntrada->AmoCierre = $fila['AmoCierre'];		
					
					
							$AlmacenMovimientoEntrada->AmoValidarStock = $fila['AmoValidarStock'];			
					$AlmacenMovimientoEntrada->AmoEstado = $fila['AmoEstado'];
					$AlmacenMovimientoEntrada->AmoTiempoCreacion = $fila['NAmoTiempoCreacion'];  
					$AlmacenMovimientoEntrada->AmoTiempoModificacion = $fila['NAmoTiempoModificacion']; 

					$AlmacenMovimientoEntrada->AmoFechaVencimiento = $fila['AmoFechaVencimiento']; 
					$AlmacenMovimientoEntrada->AmoDiaTranscurrido = $fila['AmoDiaTranscurrido']; 

					$AlmacenMovimientoEntrada->AmoNotaCreditoCompra = $fila['AmoNotaCreditoCompra']; 
					
					$AlmacenMovimientoEntrada->AmoTotalItems = $fila['AmoTotalItems']; 
					
					$AlmacenMovimientoEntrada->CtiNombre = $fila['CtiNombre']; 
					
					$AlmacenMovimientoEntrada->TdoId = $fila['TdoId']; 
					

				
					$AlmacenMovimientoEntrada->PrvNombreCompleto = $fila['PrvNombreCompleto']; 
					$AlmacenMovimientoEntrada->PrvNombre = $fila['PrvNombre']; 
					$AlmacenMovimientoEntrada->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 
					$AlmacenMovimientoEntrada->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 
					
					$AlmacenMovimientoEntrada->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 
					
					$AlmacenMovimientoEntrada->TdoNombre = $fila['TdoNombre']; 

					$AlmacenMovimientoEntrada->MonSimbolo = $fila['MonSimbolo']; 
					
					$AlmacenMovimientoEntrada->NpaNombre = $fila['NpaNombre']; 
					
				$AlmacenMovimientoEntrada->VmaNombre = $fila['VmaNombre']; 
				
					$AlmacenMovimientoEntrada->SucNombre = $fila['SucNombre']; 
					$AlmacenMovimientoEntrada->AlmNombre = $fila['AlmNombre']; 
		
					switch($AlmacenMovimientoEntrada->AmoEstado){
					
						case 1:
							$Estado = "No Realizado";
						break;
					
						case 3:
							$Estado = "Realizado";						
						break;	
		
						default:
							$Estado = "";
						break;
					
					}
						
					$AlmacenMovimientoEntrada->AmoEstadoDescripcion = $Estado;
					
					
					switch($AlmacenMovimientoEntrada->AmoEstado){
					
						case 1:
							$Estado = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
						break;
					
						case 3:
							$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';						
						break;	
						
						default:
							$Estado = "";
						break;
					
					}
						$AlmacenMovimientoEntrada->AmoEstadoIcono = $Estado;
						
						


					switch($AlmacenMovimientoEntrada->AmoRevisado){
					
						case 1:
							$Revisado = "Revisado";
						break;
					
						case 3:
							$Revisado = "No Revisado";						
						break;	
		
						default:
							$Revisado = "";
						break;
					
					}
						
					$AlmacenMovimientoEntrada->AmoRevisadoDescripcion = $Revisado;
					
					
					switch($AlmacenMovimientoEntrada->AmoRevisado){
					
						case 1:
							$Revisado = '<img width="15" height="15" alt="[Revisado]" title="No Realizado" src="imagenes/iconos/revisado.png" />';
						break;
					
						case 3:
							$Revisado = '<img width="15" height="15" alt="[No Revisado]" title="Enviado" src="imagenes/iconos/norevisado.png" />';						
						break;	
						
						default:
							$Revisado = "";
						break;
					
					}
						
						
						
					$AlmacenMovimientoEntrada->AmoRevisadoIcono = $Revisado;

					
					if($AlmacenMovimientoEntrada->AmoTipoCambio=="0.000"){
						$AlmacenMovimientoEntrada->AmoTipoCambio = NULL;
					}


                    $AlmacenMovimientoEntrada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AlmacenMovimientoEntrada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		



    public function MtdObtenerAlmacenMovimientoEntradasValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oSubTipo=NULL,$oAlmacen=NULL) {

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
				
				

				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					amd.AmdId

					FROM tblamdalmacenmovimientodetalle amd
					
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId

							LEFT JOIN tblpcdpedidocompradetalle pcd
							ON amd.PcdId = pcd.PcdId
								
								LEFT JOIN tblpcopedidocompra pco
								ON pcd.PcoId = pco.PcoId
								
									LEFT JOIN tblclicliente cli
									ON pco.CliId = cli.CliId

					WHERE 
						amd.AmoId = amo.AmoId AND 
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" OR
						
						cli.CliNombreCompleto  LIKE "%'.$oFiltro.'%" OR
						cli.CliNombre  LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoPaterno  LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoMaterno  LIKE "%'.$oFiltro.'%" OR
						cli.CliNumeroDocumento  LIKE "%'.$oFiltro.'%"
						
						)
						
						
						
					) ';
					
									
				$filtrar .= '  ) ';

			

				
					
					
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		if(!empty($oTipo)){
			$tipo = ' AND amo.AmoTipo = '.$oTipo;
		}
				
		if(!empty($oSubTipo)){

			$elementos = explode(",",$oSubTipo);

				$i=1;
				$stipo .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$stipo .= '  (amo.AmoSubTipo = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$stipo .= ' OR ';	
						}
				$i++;		
				}
				
				$stipo .= ' ) ';

		}
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(amo.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		/*if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}*/


		if(!empty($oEstado)){
			$estado = ' AND amo.AmoEstado = '.$oEstado;
		}
		

		if(!empty($oOrigen)){
			$origen = ' AND amo.AmoDocumentoOrigen = '.$oOrigen;
		}
		

		if(!empty($oMoneda)){
			$moneda = ' AND amo.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND amo.OcoId = "'.$oOrdenCompra.'"';
		}
		


		
		if(!empty($oPedidoCompra)){
			
			$pcompra = ' 
			AND EXISTS(
			
				SELECT 
				pcd.PcoId
				FROM tblamdalmacenmovimientodetalle amd
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
				WHERE amd.AmoId = amo.AmoId
				AND pcd.PcoId = "'.$oPedidoCompra.'"
				LIMIT 1
			)
							
			';
		}
		
		if(!empty($oPedidoCompraDetalle)){
			
			 $pcompradetalle = ' 
			AND EXISTS(

				SELECT
				amd.AmdId
				FROM tblamdalmacenmovimientodetalle amd
				WHERE 
				amo.AmoId = amd.AmoId
				AND amd.PcdId = "'.$oPedidoCompraDetalle.'"

				LIMIT 1

			)
			';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND amo.CliId = "'.$oCliente.'"';
		}	
		
		
		switch($oConOrdenCompra){
			
			case 1:
			
				$cocompra = ' AND amo.OcoId IS NOT NULL ';
				
			break;
			
			case 2:

				$cocompra = ' AND amo.OcoId IS NULL ';
				
			break;
			
			default:
			
			break;
		}
		
		if($oCancelado){
			$cancelado = ' AND amo.AmoCancelado = '.$oCancelado;
		}
		
		
		if(!empty($oProveedor)){
			$proveedor = ' AND amo.PrvId = "'.$oProveedor.'"';
		}
		
		if(!empty($oVentaDirecta)){
			$vdirecta = ' AND pco.VdiId = "'.$oVentaDirecta.'"';
		}
		
		if(!empty($oCondicionPago)){
			$cpago = ' AND amo.NpaId = "'.$oCondicionPago.'"';
		}
		
		
		if(!empty($oAlmacen)){
			$almacen = ' AND amo.AlmId = "'.$oAlmacen.'"';
		}
		
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(amo.AmoFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(amo.AmoFecha) ="'.($oAno).'"';
		}
		
		
		
			 $sql = 'SELECT
				'.$funcion.' AS "RESULTADO" 

				FROM tblamoalmacenmovimiento amo
					LEFT JOIN tblocoordencompra oco
					ON amo.OcoId = oco.OcoId
						LEFT JOIN tblpcopedidocompra pco
						ON oco.OcoId = pco.OcoId
						
						LEFT JOIN tblnpacondicionpago npa
						ON amo.NpaId = npa.NpaId
						
					LEFT JOIN tblcticomprobantetipo cti
					ON amo.CtiId = cti.CtiId
						LEFT JOIN tblprvproveedor prv
						ON amo.PrvId = prv.PrvId
							LEFT JOIN tbltdotipodocumento tdo
							ON prv.TdoId = tdo.TdoId
								LEFT JOIN tblmonmoneda mon
								ON amo.MonId = mon.MonId
	
							LEFT JOIN tblprvproveedor pin1
							ON amo.PrvIdInternacional1 = pin1.PrvId
								LEFT JOIN tblprvproveedor pin2
								ON amo.PrvIdInternacional2 = pin2.PrvId
									LEFT JOIN tblprvproveedor pin3
									ON amo.PrvIdInternacional3 = pin3.PrvId
										LEFT JOIN tblprvproveedor pin4
										ON amo.PrvIdInternacional4 = pin4.PrvId
											LEFT JOIN tblprvproveedor pin5
											ON amo.PrvIdInternacional5 = pin5.PrvId
												LEFT JOIN tblprvproveedor pin6
												ON amo.PrvIdInternacional6 = pin6.PrvId
													LEFT JOIN tblprvproveedor pin7
													ON amo.PrvIdInternacional7 = pin7.PrvId
														LEFT JOIN tblprvproveedor pin8
														ON amo.PrvIdInternacional8 = pin8.PrvId
															LEFT JOIN tblprvproveedor pin9
															ON amo.PrvIdInternacional9 = pin9.PrvId
	
					LEFT JOIN tblprvproveedor pna1
					ON amo.PrvIdNacional1 = pna1.PrvId
						LEFT JOIN tblprvproveedor pna2
						ON amo.PrvIdNacional2 = pna2.PrvId
							LEFT JOIN tblprvproveedor pna3
							ON amo.PrvIdNacional3 = pna3.PrvId
						
				WHERE amo.AmoTipo = 1 '.$ano.$mes.$filtrar.$fecha.$tipo.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$proveedor.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarAlmacenMovimientoEntrada($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){

					$ResAlmacenMovimientoEntradaDetalle = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmdId','DESC',1,NULL,$elemento);
					$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];

					if(!empty($ArrAlmacenMovimientoEntradaDetalles)){
						$amdetalle = '';

						foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
							$amdetalle .= '#'.$DatAlmacenMovimientoEntradaDetalle->AmdId;
						}

						if(!$InsAlmacenMovimientoEntradaDetalle->MtdEliminarAlmacenMovimientoEntradaDetalle($amdetalle)){								
							$error = true;
						}

					}
					
					if(!$error) {		
					
						$this->AmoId = $elemento;
						$this->MtdObtenerAlmacenMovimientoEntrada();


						$sql = 'DELETE FROM tblamoalmacenmovimiento WHERE  (AmoId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

						if(!$resultado) {						
							$error = true;
						}else{
							
							if(!empty($this->OcoId)){
								$InsOrdenCompra = new ClsOrdenCompra();
								$InsOrdenCompra->MtdActualizarEstadoOrdenCompra($this->OcoId,3);
							}
							//MtdAuditarAlmacenMovimientoEntrada($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL)
							$this->MtdAuditarAlmacenMovimientoEntrada(3,"Se elimino el Movimiento de Almacen",$aux,$elemento,$_SESSION['SesionId'],$_SESSION['SesionPersonal']);		
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
	public function MtdActualizarEstadoAlmacenMovimientoEntrada($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		//$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
		//$InsAlmacenMovimientoEntradaDetalles = new ClsAlmacenMovimientoEntradaDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				//$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblamoalmacenmovimiento SET AmoEstado = '.$oEstado.' WHERE AmoId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarAlmacenMovimientoEntrada(2,"Se actualizo el Estado del Movimiento de Almacen",$elemento,$elemento,$_SESSION['SesionId'],$_SESSION['SesionPersonal']);
						//MtdAuditarAlmacenMovimientoEntrada($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL)
					
				
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
	
	
	
	public function MtdActualizarRevisadoAlmacenMovimientoEntrada($oElementos,$oRevisado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				
					$sql = 'UPDATE tblamoalmacenmovimiento SET AmoRevisado = '.$oRevisado.' WHERE AmoId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
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
	
	
	
	public function MtdActualizarValidarStockAlmacenMovimientoEntrada($oElementos,$oRevisado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				
					$sql = 'UPDATE tblamoalmacenmovimiento SET AmoValidarStock = '.$oRevisado.' WHERE AmoId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
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
	
	public function MtdVerificarExisteAlmacenMovimientoEntrada($oCampo,$oDato,$oProveedor=NULL){

		$Respuesta =   NULL;

		if($oProveedor){
			$proveedor = ' AND PrvId = "'.$oProveedor.'"';
		}

			$sql = 'SELECT 
			AmoId
			FROM tblamoalmacenmovimiento
			WHERE '.$oCampo.' = "'.$oDato.'" '.$proveedor.' LIMIT 1;';

			$resultado = $this->InsMysql->MtdConsultar($sql);

			if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
				
				$fila = $this->InsMysql->MtdObtenerDatos($resultado);
				//$this->EinId = $fila['EinId'];
				$Respuesta = $fila['AmoId'];
	
			}
			
			return $Respuesta;
	
		}
	
	
	
	public function MtdRegistrarAlmacenMovimientoEntrada() {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarAlmacenMovimientoEntradaId();
			
			$InsAlmacenCierre = new ClsAlmacenCierre();
			
			if($InsAlmacenCierre->MtdVerificarAlmacenCierre($this->AmoFecha)){
				
				$error = true;
				$Resultado.='#ERR_AMO_603';
				
			}
			
			
			//if(empty($this->PrvId)){
//				$InsProveedor = new ClsProveedor();
//				$InsProveedor->TdoId = $this->TdoId;
//				$InsProveedor->PrvNombre = $this->PrvNombre;
//				$InsProveedor->PrvNumeroDocumento = $this->PrvNumeroDocumento;
//				
//				$InsProveedor->MtdVerificarExisteProveedor();
//				if(empty($this->PrvId)){
//					$InsProveedor->PrvEstado = 1;
//					$InsProveedor->PrvTiempoCreacion = date("Y-m-d H:i:s");
//					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
//					$InsProveedor->PrvEliminado = 1;
//
//					if(!$InsProveedor->MtdRegistrarProveedor2()){
//						$error = true;
//						$Resultado.='#ERR_PRV_101';
//					}
//
//				}else{
//
//					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
//
//					if(!$InsProveedor->MtdEditarProveedor2()){
//						$error = true;
//						$Resultado.='#ERR_PRV_102';
//					}
//
//					$this->PrvId = $InsProveedor->PrvId;	
//					
//				}
//			}

			$AlmacenMovimientoId = $this->MtdVerificarExisteAlmacenMovimientoEntrada("AmoComprobanteNumero",$this->AmoComprobanteNumero,$this->PrvId);
	
			if(!empty($AlmacenMovimientoId)){
				$error = true;
				$Resultado.='#ERR_AMO_601';
			}
			
			
			
			$sql = 'INSERT INTO tblamoalmacenmovimiento (
			AmoId,	
			SucId,
			
			PrvId,
			CtiId,
			TopId,
			
			CprId,
			VdiId,
			OcoId,
			
			NpaId,
			AmoCantidadDia,

			LtiId,
			
			AmoTipo,
			AmoSubTipo,
			
			AlmId,
			AmoIdOrigen,
			TalId,
			PprId,
			
			AmoFecha,
			AmoDocumentoOrigen,
			
			AmoGuiaRemisionNumero,
			AmoGuiaRemisionFecha,
			AmoGuiaRemisionFoto,
			
			AmoComprobanteNumero,
			AmoComprobanteFecha,
			MonId,
			AmoTipoCambio,
			
			
			AmoIncluyeImpuesto,
			AmoPorcentajeImpuestoVenta,
						
			AmoInternacionalNumeroComprobante1,
			AmoInternacionalNumeroComprobante2,
			AmoInternacionalNumeroComprobante3,
			AmoInternacionalNumeroComprobante4,
			AmoInternacionalNumeroComprobante5,
			AmoInternacionalNumeroComprobante6,
			AmoInternacionalNumeroComprobante7,
			AmoInternacionalNumeroComprobante8,
			AmoInternacionalNumeroComprobante9,

			AmoNacionalNumeroComprobante1,
			AmoNacionalNumeroComprobante2,
			AmoNacionalNumeroComprobante3,
			
			AmoNacionalFoto1,
			AmoNacionalFoto2,
			AmoNacionalFoto3,
	
			MonIdInternacional1,
			MonIdInternacional2,
			MonIdInternacional3,
			MonIdInternacional4,
			MonIdInternacional5,
			MonIdInternacional6,
			MonIdInternacional7,
			MonIdInternacional8,
			MonIdInternacional9,

			MonIdNacional1,
			MonIdNacional2,
			MonIdNacional3,

			AmoInternacionalTotalAduana,
			AmoInternacionalTotalTransporte,
			AmoInternacionalTotalDesestiba,
			AmoInternacionalTotalAlmacenaje,
			AmoInternacionalTotalAdValorem,
			AmoInternacionalTotalAduanaNacional,
			AmoInternacionalTotalGastoAdministrativo,
			AmoInternacionalTotalOtroCosto1,
			AmoInternacionalTotalOtroCosto2,

			AmoNacionalTotalRecargo,
			AmoNacionalTotalFlete,
			AmoNacionalTotalOtroCosto,
			
					
			PrvIdInternacional1,
			PrvIdInternacional2,
			PrvIdInternacional3,
			PrvIdInternacional4,
			PrvIdInternacional5,
			PrvIdInternacional6,
			PrvIdInternacional7,
			PrvIdInternacional8,
			PrvIdInternacional9,	
		
			PrvIdNacional1,
			PrvIdNacional2,
			PrvIdNacional3,		

			AmoFoto,
			AmoObservacion,
			
			AmoSubTotal,
			AmoImpuesto,				
			AmoTotal,
				
			AmoTotalInternacional,
			AmoTotalNacional,
			
			AmoCancelado,
			AmoRevisado,
			AmoFacturable,
			
			
			AmoValidarStock,
			AmoCierre,
			AmoEstado,			
			AmoTiempoCreacion,
			AmoTiempoModificacion) 
			VALUES (
			"'.($this->AmoId).'", 
			"'.($this->SucId).'", 
			
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			'.(empty($this->CtiId)?'NULL, ':'"'.$this->CtiId.'",').'
			'.(empty($this->TopId)?'NULL, ':'"'.$this->TopId.'",').'
			NULL,
			NULL,
			'.(empty($this->OcoId)?'NULL, ':'"'.$this->OcoId.'",').'
				
			"'.($this->NpaId).'", 
			'.($this->AmoCantidadDia).',
			
			NULL,
			
			1,
			'.($this->AmoSubTipo).',
			
			
			'.(empty($this->AlmId)?'NULL, ':'"'.$this->AlmId.'",').'
			NULL,
			NULL,
			NULL,
			
			"'.($this->AmoFecha).'", 
			'.($this->AmoDocumentoOrigen).',
			"'.($this->AmoGuiaRemisionNumero).'", 
			'.(empty($this->AmoGuiaRemisionFecha)?'NULL, ':'"'.$this->AmoGuiaRemisionFecha.'",').'
			"'.($this->AmoGuiaRemisionFoto).'", 
			
			
			"'.($this->AmoComprobanteNumero).'", 
			'.(empty($this->AmoComprobanteFecha)?'NULL, ':'"'.$this->AmoComprobanteFecha.'",').'
			"'.($this->MonId).'",
			'.($this->AmoTipoCambio).',
			
			
			'.($this->AmoIncluyeImpuesto).',
			'.($this->AmoPorcentajeImpuestoVenta).',

			"'.($this->AmoInternacionalNumeroComprobante1).'",
			"'.($this->AmoInternacionalNumeroComprobante2).'",
			"'.($this->AmoInternacionalNumeroComprobante3).'",
			"'.($this->AmoInternacionalNumeroComprobante4).'",
			"'.($this->AmoInternacionalNumeroComprobante5).'",
			"'.($this->AmoInternacionalNumeroComprobante6).'",
			"'.($this->AmoInternacionalNumeroComprobante7).'",
			"'.($this->AmoInternacionalNumeroComprobante8).'",
			"'.($this->AmoInternacionalNumeroComprobante9).'",

			"'.($this->AmoNacionalNumeroComprobante1).'",
			"'.($this->AmoNacionalNumeroComprobante2).'",
			"'.($this->AmoNacionalNumeroComprobante3).'",
			
			"'.($this->AmoNacionalFoto1).'",
			"'.($this->AmoNacionalFoto2).'",
			"'.($this->AmoNacionalFoto3).'",
			
			'.(empty($this->MonIdInternacional1)?'NULL, ':'"'.$this->MonIdInternacional1.'",').'
			'.(empty($this->MonIdInternacional2)?'NULL, ':'"'.$this->MonIdInternacional2.'",').'
			'.(empty($this->MonIdInternacional3)?'NULL, ':'"'.$this->MonIdInternacional3.'",').'
			'.(empty($this->MonIdInternacional4)?'NULL, ':'"'.$this->MonIdInternacional4.'",').'
			'.(empty($this->MonIdInternacional5)?'NULL, ':'"'.$this->MonIdInternacional5.'",').'
			'.(empty($this->MonIdInternacional6)?'NULL, ':'"'.$this->MonIdInternacional6.'",').'
			'.(empty($this->MonIdInternacional7)?'NULL, ':'"'.$this->MonIdInternacional7.'",').'
			'.(empty($this->MonIdInternacional8)?'NULL, ':'"'.$this->MonIdInternacional8.'",').'
			'.(empty($this->MonIdInternacional9)?'NULL, ':'"'.$this->MonIdInternacional9.'",').'
			
			'.(empty($this->MonIdNacional1)?'NULL, ':'"'.$this->MonIdNacional1.'",').'
			'.(empty($this->MonIdNacional2)?'NULL, ':'"'.$this->MonIdNacional2.'",').'
			'.(empty($this->MonIdNacional3)?'NULL, ':'"'.$this->MonIdNacional3.'",').'	
			
			'.($this->AmoInternacionalTotalAduana).',
			'.($this->AmoInternacionalTotalTransporte).',
			'.($this->AmoInternacionalTotalDesestiba).',
			'.($this->AmoInternacionalTotalAlmacenaje).',
			'.($this->AmoInternacionalTotalAdValorem).',
			'.($this->AmoInternacionalTotalAduanaNacional).',
			'.($this->AmoInternacionalTotalGastoAdministrativo).',
			'.($this->AmoInternacionalTotalOtroCosto1).',
			'.($this->AmoInternacionalTotalOtroCosto2).',

			'.($this->AmoNacionalTotalRecargo).',
			'.($this->AmoNacionalTotalFlete).',
			'.($this->AmoNacionalTotalOtroCosto).',

			
			'.(empty($this->PrvIdInternacional1)?'NULL, ':'"'.$this->PrvIdInternacional1.'",').'
			'.(empty($this->PrvIdInternacional2)?'NULL, ':'"'.$this->PrvIdInternacional2.'",').'
			'.(empty($this->PrvIdInternacional3)?'NULL, ':'"'.$this->PrvIdInternacional3.'",').'
			'.(empty($this->PrvIdInternacional4)?'NULL, ':'"'.$this->PrvIdInternacional4.'",').'
			'.(empty($this->PrvIdInternacional5)?'NULL, ':'"'.$this->PrvIdInternacional5.'",').'
			'.(empty($this->PrvIdInternacional6)?'NULL, ':'"'.$this->PrvIdInternacional6.'",').'
			'.(empty($this->PrvIdInternacional7)?'NULL, ':'"'.$this->PrvIdInternacional7.'",').'
			'.(empty($this->PrvIdInternacional8)?'NULL, ':'"'.$this->PrvIdInternacional8.'",').'
			'.(empty($this->PrvIdInternacional9)?'NULL, ':'"'.$this->PrvIdInternacional9.'",').'

			'.(empty($this->PrvIdNacional1)?'NULL, ':'"'.$this->PrvIdNacional1.'",').'
			'.(empty($this->PrvIdNacional2)?'NULL, ':'"'.$this->PrvIdNacional2.'",').'
			'.(empty($this->PrvIdNacional3)?'NULL, ':'"'.$this->PrvIdNacional3.'",').'


			"'.($this->AmoFoto).'",
			"'.($this->AmoObservacion).'",

			'.($this->AmoSubTotal).',
			'.($this->AmoImpuesto).',
			'.($this->AmoTotal).',
			
			'.($this->AmoTotalInternacional).',
			'.($this->AmoTotalNacional).',
			2,
			2,
			1,
			
			
			'.($this->AmoValidarStock).',
			2,
			'.($this->AmoEstado).',
			"'.($this->AmoTiempoCreacion).'", 			
								
			"'.($this->AmoTiempoModificacion).'");';			
		
			
			$this->InsMysql->MtdTransaccionIniciar();
		
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			
//			'.($this->AmoTipo).',
//			'.($this->AmoSubTipo).',	
			
			
			if(!$resultado) {							
				$error = true;
			} 


//			if(round($this->AmoValorTotal) <> round($this->AmoSubTotal)){
//				$error = true;
//				$Resultado.='#ERR_AMO_110';
//			}


			if(!$error){			
			
				if (!empty($this->AlmacenMovimientoEntradaDetalle)){		
						
					$validar = 0;				
					$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();		
					
					foreach ($this->AlmacenMovimientoEntradaDetalle as $DatAlmacenMovimientoEntradaDetalle){
					
						$InsAlmacenMovimientoEntradaDetalle->AmoId = $this->AmoId;
						$InsAlmacenMovimientoEntradaDetalle->ProId = $DatAlmacenMovimientoEntradaDetalle->ProId;
						$InsAlmacenMovimientoEntradaDetalle->UmeId = $DatAlmacenMovimientoEntradaDetalle->UmeId;
						$InsAlmacenMovimientoEntradaDetalle->AmdIdAnterior = $DatAlmacenMovimientoEntradaDetalle->AmdIdAnterior;
						$InsAlmacenMovimientoEntradaDetalle->AmdCosto = $DatAlmacenMovimientoEntradaDetalle->AmdCosto;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoAnterior = $DatAlmacenMovimientoEntradaDetalle->AmdCostoAnterior;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoExtraTotal = $DatAlmacenMovimientoEntradaDetalle->AmdCostoExtraTotal;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoExtraUnitario = $DatAlmacenMovimientoEntradaDetalle->AmdCostoExtraUnitario;
						$InsAlmacenMovimientoEntradaDetalle->AmdValorTotal = $DatAlmacenMovimientoEntradaDetalle->AmdValorTotal;
						
						$InsAlmacenMovimientoEntradaDetalle->AmdCantidad = $DatAlmacenMovimientoEntradaDetalle->AmdCantidad;
						$InsAlmacenMovimientoEntradaDetalle->AmdCantidadReal = $DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal;
						$InsAlmacenMovimientoEntradaDetalle->AmdImporte = $DatAlmacenMovimientoEntradaDetalle->AmdImporte;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoPromedio = $DatAlmacenMovimientoEntradaDetalle->AmdCostoPromedio;
						
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduana = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduana;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalTransporte = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalTransporte;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalDesestiba = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalDesestiba;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAlmacenaje = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAlmacenaje;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAdValorem = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAdValorem;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduanaNacional = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduanaNacional;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalGastoAdministrativo = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalGastoAdministrativo;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto1 = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto1;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto2 = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto2;
						
						$InsAlmacenMovimientoEntradaDetalle->AmdNacionalTotalRecargo = $DatAlmacenMovimientoEntradaDetalle->AmdNacionalTotalRecargo;
						$InsAlmacenMovimientoEntradaDetalle->AmdNacionalTotalFlete = $DatAlmacenMovimientoEntradaDetalle->AmdNacionalTotalFlete;
						$InsAlmacenMovimientoEntradaDetalle->AmdNacionalTotalOtroCosto = $DatAlmacenMovimientoEntradaDetalle->AmdNacionalTotalOtroCosto;
						
						$InsAlmacenMovimientoEntradaDetalle->PcdId = $DatAlmacenMovimientoEntradaDetalle->PcdId;
						$InsAlmacenMovimientoEntradaDetalle->AmdEstado = $DatAlmacenMovimientoEntradaDetalle->AmdEstado;									
						$InsAlmacenMovimientoEntradaDetalle->AmdTiempoCreacion = $DatAlmacenMovimientoEntradaDetalle->AmdTiempoCreacion;
						$InsAlmacenMovimientoEntradaDetalle->AmdTiempoModificacion = $DatAlmacenMovimientoEntradaDetalle->AmdTiempoModificacion;						
						$InsAlmacenMovimientoEntradaDetalle->AmdEliminado = $DatAlmacenMovimientoEntradaDetalle->AmdEliminado;
						
						$InsAlmacenMovimientoEntradaDetalle->AlmId = $this->AlmId;
						$InsAlmacenMovimientoEntradaDetalle->AmdFecha = $this->AmoFecha;
						
						if($InsAlmacenMovimientoEntradaDetalle->MtdRegistrarAlmacenMovimientoEntradaDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_AMO_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->AlmacenMovimientoEntradaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
							
							
							
							
										
		//	if(!$error){			
//			
//				if (!empty($this->AlmacenMovimientoEntradaDetalle)){		
//						
//					$validar = 0;				
//					$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();		
//					
//					foreach ($this->AlmacenMovimientoEntradaDetalle as $DatAlmacenMovimientoEntradaDetalle){
//					
//						$InsAlmacenMovimientoEntradaDetalle->AmoId = $this->AmoId;
//						$InsAlmacenMovimientoEntradaDetalle->ProId = $DatAlmacenMovimientoEntradaDetalle->ProId;
//						$InsAlmacenMovimientoEntradaDetalle->UmeId = $DatAlmacenMovimientoEntradaDetalle->UmeId;
//						$InsAlmacenMovimientoEntradaDetalle->AmdCosto = $DatAlmacenMovimientoEntradaDetalle->AmdCosto;
//						$InsAlmacenMovimientoEntradaDetalle->AmdCostoAnterior = $DatAlmacenMovimientoEntradaDetalle->AmdCostoAnterior;
//						$InsAlmacenMovimientoEntradaDetalle->AmdCostoTotal = $DatAlmacenMovimientoEntradaDetalle->AmdCostoTotal;
//						$InsAlmacenMovimientoEntradaDetalle->AmdCantidad = $DatAlmacenMovimientoEntradaDetalle->AmdCantidad;
//						$InsAlmacenMovimientoEntradaDetalle->AmdCantidadReal = $DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal;
//						$InsAlmacenMovimientoEntradaDetalle->AmdImporte = $DatAlmacenMovimientoEntradaDetalle->AmdImporte;
//						$InsAlmacenMovimientoEntradaDetalle->AmdEstado = $this->AmoEstado;									
//						$InsAlmacenMovimientoEntradaDetalle->AmdTiempoCreacion = $DatAlmacenMovimientoEntradaDetalle->AmdTiempoCreacion;
//						$InsAlmacenMovimientoEntradaDetalle->AmdTiempoModificacion = $DatAlmacenMovimientoEntradaDetalle->AmdTiempoModificacion;						
//						$InsAlmacenMovimientoEntradaDetalle->AmdEliminado = $DatAlmacenMovimientoEntradaDetalle->AmdEliminado;
//						
//						if($InsAlmacenMovimientoEntradaDetalle->MtdRegistrarAlmacenMovimientoEntradaDetalle()){
//							$validar++;	
//						}else{
//							$Resultado.='#ERR_AMO_201';
//							$Resultado.='#Item Numero: '.($validar+1);
//						}
//					}					
//					
//					if(count($this->AlmacenMovimientoEntradaDetalle) <> $validar ){
//						$error = true;
//					}					
//								
//				}				
//			}
			
				
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				//MtdAuditarAlmacenMovimientoEntrada($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL)
				$this->MtdAuditarAlmacenMovimientoEntrada(1,"Se registro el Movimiento de Almacen",$this,$this->AmoId,$_SESSION['SesionId'],$_SESSION['SesionPersonal']);			
				return true;
			}			
					
	}
	
	public function MtdEditarAlmacenMovimientoEntrada() {

		global $Resultado;
		$error = false;
/*
			if(empty($this->PrvId)){
				
				$InsProveedor = new ClsProveedor();
				$InsProveedor->TdoId = $this->TdoId;
				$InsProveedor->PrvNombre;
				$InsProveedor->PrvNumeroDocumento;
				$InsProveedor->MtdVerificarExisteProveedor();
				
				if(empty($this->PrvId)){
					
					$InsProveedor->PrvEstado = 1;
					$InsProveedor->PrvTiempoCreacion = date("Y-m-d H:i:s");
					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
					$InsProveedor->PrvEliminado = 1;

					if(!$InsProveedor->MtdRegistrarProveedor2()){
						$error = true;
						$Resultado.='#ERR_PRV_101';
					}

				}else{

					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");

					if(!$InsProveedor->MtdEditarProveedor2()){
						$error = true;
						$Resultado.='#ERR_PRV_102';
					}

					$this->PrvId = $InsProveedor->PrvId;	
					
				}
			}*/
			
			$sql = 'UPDATE tblamoalmacenmovimiento SET
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			'.(empty($this->CtiId)?'CtiId = NULL, ':'CtiId = "'.$this->CtiId.'",').'
			'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
			
			NpaId = "'.($this->NpaId).'",
			AmoCantidadDia = '.($this->AmoCantidadDia).',
			
			'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'
			AmoFecha = "'.($this->AmoFecha).'",
			AmoDocumentoOrigen = '.($this->AmoDocumentoOrigen).',
			AmoGuiaRemisionNumero = "'.($this->AmoGuiaRemisionNumero).'",
			'.(empty($this->AmoGuiaRemisionFecha)?'AmoGuiaRemisionFecha = NULL, ':'AmoGuiaRemisionFecha = "'.$this->AmoGuiaRemisionFecha.'",').'
			AmoGuiaRemisionFoto = "'.($this->AmoGuiaRemisionFoto).'",
			
			
			AmoComprobanteNumero = "'.($this->AmoComprobanteNumero).'",
			'.(empty($this->AmoComprobanteFecha)?'AmoComprobanteFecha = NULL, ':'AmoComprobanteFecha = "'.$this->AmoComprobanteFecha.'",').'
			MonId = "'.($this->MonId).'",
			AmoTipoCambio = '.($this->AmoTipoCambio).',
			
			AmoIncluyeImpuesto = '.($this->AmoIncluyeImpuesto).',
			AmoPorcentajeImpuestoVenta = '.($this->AmoPorcentajeImpuestoVenta).',						
			AmoNacionalTotalRecargo = '.($this->AmoNacionalTotalRecargo).',
			AmoNacionalTotalFlete = '.($this->AmoNacionalTotalFlete).',
			AmoNacionalTotalOtroCosto = '.($this->AmoNacionalTotalOtroCosto).',
			
			AmoInternacionalTotalAduana = '.($this->AmoInternacionalTotalAduana).',
			AmoInternacionalTotalTransporte = '.($this->AmoInternacionalTotalTransporte).',
			AmoInternacionalTotalDesestiba = '.($this->AmoInternacionalTotalDesestiba).',
			AmoInternacionalTotalAlmacenaje = '.($this->AmoInternacionalTotalAlmacenaje).',
			AmoInternacionalTotalAdValorem = '.($this->AmoInternacionalTotalAdValorem).',
			AmoInternacionalTotalAduanaNacional = '.($this->AmoInternacionalTotalAduanaNacional).',
			AmoInternacionalTotalGastoAdministrativo = '.($this->AmoInternacionalTotalGastoAdministrativo).',
			AmoInternacionalTotalOtroCosto1 = '.($this->AmoInternacionalTotalOtroCosto1).',
			AmoInternacionalTotalOtroCosto2 = '.($this->AmoInternacionalTotalOtroCosto2).',
			
			AmoInternacionalNumeroComprobante1 = "'.($this->AmoInternacionalNumeroComprobante1).'",
			AmoInternacionalNumeroComprobante2 = "'.($this->AmoInternacionalNumeroComprobante2).'",
			AmoInternacionalNumeroComprobante3 = "'.($this->AmoInternacionalNumeroComprobante3).'",
			AmoInternacionalNumeroComprobante4 = "'.($this->AmoInternacionalNumeroComprobante4).'",
			AmoInternacionalNumeroComprobante5 = "'.($this->AmoInternacionalNumeroComprobante5).'",
			AmoInternacionalNumeroComprobante6 = "'.($this->AmoInternacionalNumeroComprobante6).'",
			AmoInternacionalNumeroComprobante7 = "'.($this->AmoInternacionalNumeroComprobante7).'",
			AmoInternacionalNumeroComprobante8 = "'.($this->AmoInternacionalNumeroComprobante8).'",
			AmoInternacionalNumeroComprobante9 = "'.($this->AmoInternacionalNumeroComprobante9).'",
			
			AmoNacionalNumeroComprobante1 = "'.($this->AmoNacionalNumeroComprobante1).'",
			AmoNacionalNumeroComprobante2 = "'.($this->AmoNacionalNumeroComprobante2).'",
			AmoNacionalNumeroComprobante3 = "'.($this->AmoNacionalNumeroComprobante3).'",
			
			AmoNacionalFoto1 = "'.($this->AmoNacionalFoto1).'",
			AmoNacionalFoto2 = "'.($this->AmoNacionalFoto2).'",
			AmoNacionalFoto3 = "'.($this->AmoNacionalFoto3).'",
		
		'.(empty($this->MonIdInternacional1)?'MonIdInternacional1 = NULL, ':'MonIdInternacional1 = "'.$this->MonIdInternacional1.'",').'
		'.(empty($this->MonIdInternacional2)?'MonIdInternacional2 = NULL, ':'MonIdInternacional2 = "'.$this->MonIdInternacional2.'",').'
		'.(empty($this->MonIdInternacional3)?'MonIdInternacional3 = NULL, ':'MonIdInternacional3 = "'.$this->MonIdInternacional3.'",').'
		'.(empty($this->MonIdInternacional4)?'MonIdInternacional4 = NULL, ':'MonIdInternacional4 = "'.$this->MonIdInternacional4.'",').'
		'.(empty($this->MonIdInternacional5)?'MonIdInternacional5 = NULL, ':'MonIdInternacional5 = "'.$this->MonIdInternacional5.'",').'
		'.(empty($this->MonIdInternacional6)?'MonIdInternacional6 = NULL, ':'MonIdInternacional6 = "'.$this->MonIdInternacional6.'",').'
		'.(empty($this->MonIdInternacional7)?'MonIdInternacional7 = NULL, ':'MonIdInternacional7 = "'.$this->MonIdInternacional7.'",').'
		'.(empty($this->MonIdInternacional8)?'MonIdInternacional8 = NULL, ':'MonIdInternacional8 = "'.$this->MonIdInternacional8.'",').'
		'.(empty($this->MonIdInternacional9)?'MonIdInternacional9 = NULL, ':'MonIdInternacional9 = "'.$this->MonIdInternacional9.'",').'
		
		'.(empty($this->MonIdNacional1)?'MonIdNacional1 = NULL, ':'MonIdNacional1 = "'.$this->MonIdNacional1.'",').'
		'.(empty($this->MonIdNacional2)?'MonIdNacional2 = NULL, ':'MonIdNacional2 = "'.$this->MonIdNacional2.'",').'
		'.(empty($this->MonIdNacional3)?'MonIdNacional3 = NULL, ':'MonIdNacional3 = "'.$this->MonIdNacional3.'",').'
		
		
		'.(empty($this->PrvIdInternacional1)?'PrvIdInternacional1 = NULL, ':'PrvIdInternacional1 = "'.$this->PrvIdInternacional1.'",').'
		'.(empty($this->PrvIdInternacional2)?'PrvIdInternacional2 = NULL, ':'PrvIdInternacional2 = "'.$this->PrvIdInternacional2.'",').'
		'.(empty($this->PrvIdInternacional3)?'PrvIdInternacional3 = NULL, ':'PrvIdInternacional3 = "'.$this->PrvIdInternacional3.'",').'
		'.(empty($this->PrvIdInternacional4)?'PrvIdInternacional4 = NULL, ':'PrvIdInternacional4 = "'.$this->PrvIdInternacional4.'",').'
		'.(empty($this->PrvIdInternacional5)?'PrvIdInternacional5 = NULL, ':'PrvIdInternacional5 = "'.$this->PrvIdInternacional5.'",').'
		'.(empty($this->PrvIdInternacional6)?'PrvIdInternacional6 = NULL, ':'PrvIdInternacional6 = "'.$this->PrvIdInternacional6.'",').'
		'.(empty($this->PrvIdInternacional7)?'PrvIdInternacional7 = NULL, ':'PrvIdInternacional7 = "'.$this->PrvIdInternacional7.'",').'
		'.(empty($this->PrvIdInternacional8)?'PrvIdInternacional8 = NULL, ':'PrvIdInternacional8 = "'.$this->PrvIdInternacional8.'",').'
		'.(empty($this->PrvIdInternacional9)?'PrvIdInternacional9 = NULL, ':'PrvIdInternacional9 = "'.$this->PrvIdInternacional9.'",').'
		
		'.(empty($this->PrvIdNacional1)?'PrvIdNacional1 = NULL, ':'PrvIdNacional1 = "'.$this->PrvIdNacional1.'",').'
		'.(empty($this->PrvIdNacional2)?'PrvIdNacional2 = NULL, ':'PrvIdNacional2 = "'.$this->PrvIdNacional2.'",').'
		'.(empty($this->PrvIdNacional3)?'PrvIdNacional3 = NULL, ':'PrvIdNacional3 = "'.$this->PrvIdNacional3.'",').'			
	
	
	
			AmoFoto = "'.($this->AmoFoto).'",
			AmoObservacion = "'.($this->AmoObservacion).'",
			AmoSubTotal = '.($this->AmoSubTotal).',
			AmoImpuesto = '.($this->AmoImpuesto).',
			AmoTotal = '.($this->AmoTotal).',
			
			AmoTotalInternacional = '.($this->AmoTotalInternacional).',
			AmoTotalNacional = '.($this->AmoTotalNacional).',
			
			
			
			AmoValidarStock = '.($this->AmoValidarStock).',
			AmoEstado = '.($this->AmoEstado).'
			WHERE AmoId = "'.($this->AmoId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			


			//if(round($this->AmoValorTotal) <> round($this->AmoSubTotal)){
//				$error = true;
//				$Resultado.='#ERR_AMO_110';
//			}
			
			
			if(!$error){
			
				if (!empty($this->AlmacenMovimientoEntradaDetalle)){		
						
						
					$validar = 0;				
					$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
							
					foreach ($this->AlmacenMovimientoEntradaDetalle as $DatAlmacenMovimientoEntradaDetalle){
										
						$InsAlmacenMovimientoEntradaDetalle->AmdId = $DatAlmacenMovimientoEntradaDetalle->AmdId;
						$InsAlmacenMovimientoEntradaDetalle->AmoId = $this->AmoId;
						$InsAlmacenMovimientoEntradaDetalle->ProId = $DatAlmacenMovimientoEntradaDetalle->ProId;
						$InsAlmacenMovimientoEntradaDetalle->UmeId = $DatAlmacenMovimientoEntradaDetalle->UmeId;
						$InsAlmacenMovimientoEntradaDetalle->AmdIdAnterior = $DatAlmacenMovimientoEntradaDetalle->AmdIdAnterior;
						$InsAlmacenMovimientoEntradaDetalle->AmdCosto = $DatAlmacenMovimientoEntradaDetalle->AmdCosto;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoAnterior = $DatAlmacenMovimientoEntradaDetalle->AmdCostoAnterior;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoExtraTotal = $DatAlmacenMovimientoEntradaDetalle->AmdCostoExtraTotal;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoExtraUnitario = $DatAlmacenMovimientoEntradaDetalle->AmdCostoExtraUnitario;
						$InsAlmacenMovimientoEntradaDetalle->AmdValorTotal = $DatAlmacenMovimientoEntradaDetalle->AmdValorTotal;
						$InsAlmacenMovimientoEntradaDetalle->AmdCantidad = $DatAlmacenMovimientoEntradaDetalle->AmdCantidad;
						$InsAlmacenMovimientoEntradaDetalle->AmdCantidadReal = $DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal;

						$InsAlmacenMovimientoEntradaDetalle->AmdImporte = $DatAlmacenMovimientoEntradaDetalle->AmdImporte;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoPromedio = $DatAlmacenMovimientoEntradaDetalle->AmdCostoPromedio;
						
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduana = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduana;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalTransporte = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalTransporte;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalDesestiba = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalDesestiba;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAlmacenaje = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAlmacenaje;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAdValorem = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAdValorem;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduanaNacional = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduanaNacional;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalGastoAdministrativo = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalGastoAdministrativo;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto1 = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto1;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto2 = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto2;
						
						$InsAlmacenMovimientoEntradaDetalle->AmdNacionalTotalRecargo = $DatAlmacenMovimientoEntradaDetalle->AmdNacionalTotalRecargo;
						$InsAlmacenMovimientoEntradaDetalle->AmdNacionalTotalFlete = $DatAlmacenMovimientoEntradaDetalle->AmdNacionalTotalFlete;
						$InsAlmacenMovimientoEntradaDetalle->AmdNacionalTotalOtroCosto = $DatAlmacenMovimientoEntradaDetalle->AmdNacionalTotalOtroCosto;
						
						$InsAlmacenMovimientoEntradaDetalle->PcdId = $DatAlmacenMovimientoEntradaDetalle->PcdId;
						
						$InsAlmacenMovimientoEntradaDetalle->AmdEstado = $DatAlmacenMovimientoEntradaDetalle->AmdEstado;		
						$InsAlmacenMovimientoEntradaDetalle->AmdTiempoCreacion = $DatAlmacenMovimientoEntradaDetalle->AmdTiempoCreacion;
						$InsAlmacenMovimientoEntradaDetalle->AmdTiempoModificacion = $DatAlmacenMovimientoEntradaDetalle->AmdTiempoModificacion;
						$InsAlmacenMovimientoEntradaDetalle->AmdEliminado = $DatAlmacenMovimientoEntradaDetalle->AmdEliminado;
						
						$InsAlmacenMovimientoEntradaDetalle->AlmId = $this->AlmId;
						$InsAlmacenMovimientoEntradaDetalle->AmdFecha = $this->AmoFecha;
						
						if(empty($InsAlmacenMovimientoEntradaDetalle->AmdId)){
							if($InsAlmacenMovimientoEntradaDetalle->AmdEliminado<>2){
								if($InsAlmacenMovimientoEntradaDetalle->MtdRegistrarAlmacenMovimientoEntradaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_AMO_201';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsAlmacenMovimientoEntradaDetalle->AmdEliminado==2){
								if($InsAlmacenMovimientoEntradaDetalle->MtdEliminarAlmacenMovimientoEntradaDetalle($InsAlmacenMovimientoEntradaDetalle->AmdId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_AMO_203';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsAlmacenMovimientoEntradaDetalle->MtdEditarAlmacenMovimientoEntradaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_AMO_202';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->AlmacenMovimientoEntradaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
						
//			if(!$error){
//			
//				if (!empty($this->AlmacenMovimientoEntradaDetalle)){		
//						
//						
//					$validar = 0;				
//					$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
//							
//					foreach ($this->AlmacenMovimientoEntradaDetalle as $DatAlmacenMovimientoEntradaDetalle){
//										
//						$InsAlmacenMovimientoEntradaDetalle->AmdId = $DatAlmacenMovimientoEntradaDetalle->AmdId;
//						$InsAlmacenMovimientoEntradaDetalle->AmoId = $this->AmoId;
//						$InsAlmacenMovimientoEntradaDetalle->ProId = $DatAlmacenMovimientoEntradaDetalle->ProId;
//						$InsAlmacenMovimientoEntradaDetalle->UmeId = $DatAlmacenMovimientoEntradaDetalle->UmeId;
//						$InsAlmacenMovimientoEntradaDetalle->AmdCosto = $DatAlmacenMovimientoEntradaDetalle->AmdCosto;
//						$InsAlmacenMovimientoEntradaDetalle->AmdCostoAnterior = $DatAlmacenMovimientoEntradaDetalle->AmdCostoAnterior;
//						$InsAlmacenMovimientoEntradaDetalle->AmdCostoTotal = $DatAlmacenMovimientoEntradaDetalle->AmdCostoTotal;
//						$InsAlmacenMovimientoEntradaDetalle->AmdCantidad = $DatAlmacenMovimientoEntradaDetalle->AmdCantidad;
//						$InsAlmacenMovimientoEntradaDetalle->AmdCantidadReal = $DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal;
//
//						$InsAlmacenMovimientoEntradaDetalle->AmdImporte = $DatAlmacenMovimientoEntradaDetalle->AmdImporte;
//						$InsAlmacenMovimientoEntradaDetalle->AmdEstado = $this->AmoEstado;		
//						$InsAlmacenMovimientoEntradaDetalle->AmdTiempoCreacion = $DatAlmacenMovimientoEntradaDetalle->AmdTiempoCreacion;
//						$InsAlmacenMovimientoEntradaDetalle->AmdTiempoModificacion = $DatAlmacenMovimientoEntradaDetalle->AmdTiempoModificacion;
//						$InsAlmacenMovimientoEntradaDetalle->AmdEliminado = $DatAlmacenMovimientoEntradaDetalle->AmdEliminado;
//						
//						if(empty($InsAlmacenMovimientoEntradaDetalle->AmdId)){
//							if($InsAlmacenMovimientoEntradaDetalle->AmdEliminado<>2){
//								if($InsAlmacenMovimientoEntradaDetalle->MtdRegistrarAlmacenMovimientoEntradaDetalle()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_AMO_201';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								$validar++;
//							}
//						}else{						
//							if($InsAlmacenMovimientoEntradaDetalle->AmdEliminado==2){
//								if($InsAlmacenMovimientoEntradaDetalle->MtdEliminarAlmacenMovimientoEntradaDetalle($InsAlmacenMovimientoEntradaDetalle->AmdId)){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_AMO_203';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								if($InsAlmacenMovimientoEntradaDetalle->MtdEditarAlmacenMovimientoEntradaDetalle()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_AMO_202';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}
//						}									
//					}
//					
//					if(count($this->AlmacenMovimientoEntradaDetalle) <> $validar ){
//						$error = true;
//					}					
//								
//				}				
//			}	
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				//MtdAuditarAlmacenMovimientoEntrada($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL)
				$this->MtdAuditarAlmacenMovimientoEntrada(2,"Se edito el Movimiento de Almacen",$this,$this->AmoId,$_SESSION['SesionId'],$_SESSION['SesionPersonal']);		
				return true;
			}	
				
		}
		
		
	public function MtdEditarAlmacenMovimientoEntradaDetalle() {
		
		$this->InsMysql->MtdTransaccionIniciar();

		global $Resultado;
		$error = false;

			if(!$error){
			
				if (!empty($this->AlmacenMovimientoEntradaDetalle)){		
						
					$validar = 0;				
					$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
							
					foreach ($this->AlmacenMovimientoEntradaDetalle as $DatAlmacenMovimientoEntradaDetalle){
										
						$InsAlmacenMovimientoEntradaDetalle->AmdId = $DatAlmacenMovimientoEntradaDetalle->AmdId;
						$InsAlmacenMovimientoEntradaDetalle->AmoId = $this->AmoId;
						$InsAlmacenMovimientoEntradaDetalle->ProId = $DatAlmacenMovimientoEntradaDetalle->ProId;
						$InsAlmacenMovimientoEntradaDetalle->UmeId = $DatAlmacenMovimientoEntradaDetalle->UmeId;
						$InsAlmacenMovimientoEntradaDetalle->AmdIdAnterior = $DatAlmacenMovimientoEntradaDetalle->AmdIdAnterior;
						$InsAlmacenMovimientoEntradaDetalle->AmdCosto = $DatAlmacenMovimientoEntradaDetalle->AmdCosto;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoAnterior = $DatAlmacenMovimientoEntradaDetalle->AmdCostoAnterior;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoExtraTotal = $DatAlmacenMovimientoEntradaDetalle->AmdCostoExtraTotal;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoExtraUnitario = $DatAlmacenMovimientoEntradaDetalle->AmdCostoExtraUnitario;
						$InsAlmacenMovimientoEntradaDetalle->AmdValorTotal = $DatAlmacenMovimientoEntradaDetalle->AmdValorTotal;
						$InsAlmacenMovimientoEntradaDetalle->AmdCantidad = $DatAlmacenMovimientoEntradaDetalle->AmdCantidad;
						$InsAlmacenMovimientoEntradaDetalle->AmdCantidadReal = $DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal;

						$InsAlmacenMovimientoEntradaDetalle->AmdImporte = $DatAlmacenMovimientoEntradaDetalle->AmdImporte;
						$InsAlmacenMovimientoEntradaDetalle->AmdCostoPromedio = $DatAlmacenMovimientoEntradaDetalle->AmdCostoPromedio;
						
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduana = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduana;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalTransporte = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalTransporte;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalDesestiba = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalDesestiba;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAlmacenaje = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAlmacenaje;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAdValorem = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAdValorem;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduanaNacional = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduanaNacional;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalGastoAdministrativo = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalGastoAdministrativo;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto1 = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto1;
						$InsAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto2 = $DatAlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto2;
						
						$InsAlmacenMovimientoEntradaDetalle->AmdNacionalTotalRecargo = $DatAlmacenMovimientoEntradaDetalle->AmdNacionalTotalRecargo;
						$InsAlmacenMovimientoEntradaDetalle->AmdNacionalTotalFlete = $DatAlmacenMovimientoEntradaDetalle->AmdNacionalTotalFlete;
						$InsAlmacenMovimientoEntradaDetalle->AmdNacionalTotalOtroCosto = $DatAlmacenMovimientoEntradaDetalle->AmdNacionalTotalOtroCosto;
						
						$InsAlmacenMovimientoEntradaDetalle->PcdId = $DatAlmacenMovimientoEntradaDetalle->PcdId;
						
						$InsAlmacenMovimientoEntradaDetalle->AmdEstado = $DatAlmacenMovimientoEntradaDetalle->AmdEstado;		
						$InsAlmacenMovimientoEntradaDetalle->AmdTiempoCreacion = $DatAlmacenMovimientoEntradaDetalle->AmdTiempoCreacion;
						$InsAlmacenMovimientoEntradaDetalle->AmdTiempoModificacion = $DatAlmacenMovimientoEntradaDetalle->AmdTiempoModificacion;
						$InsAlmacenMovimientoEntradaDetalle->AmdEliminado = $DatAlmacenMovimientoEntradaDetalle->AmdEliminado;
						
						$InsAlmacenMovimientoEntradaDetalle->AlmId = $this->AlmId;
						$InsAlmacenMovimientoEntradaDetalle->AmdFecha = $this->AmoFecha;
						
						if(empty($InsAlmacenMovimientoEntradaDetalle->AmdId)){
							if($InsAlmacenMovimientoEntradaDetalle->AmdEliminado<>2){
								if($InsAlmacenMovimientoEntradaDetalle->MtdRegistrarAlmacenMovimientoEntradaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_AMO_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsAlmacenMovimientoEntradaDetalle->AmdEliminado==2){
								if($InsAlmacenMovimientoEntradaDetalle->MtdEliminarAlmacenMovimientoEntradaDetalle($InsAlmacenMovimientoEntradaDetalle->AmdId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_AMO_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsAlmacenMovimientoEntradaDetalle->MtdEditarAlmacenMovimientoEntradaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_AMO_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->AlmacenMovimientoEntradaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();	
				return true;
			}	
				
		}
		
			
		
		
		
		//
//		
//		
//		
//		
//		
//	public function MtdExtornarAlmacenMovimientoEntrada() {
//
//		global $Resultado;
//		$error = false;
//
////			if(empty($this->PrvId)){
////				$InsProveedor = new ClsProveedor();
////				$InsProveedor->PrvNombre;
////				$InsProveedor->PrvNumeroDocumento;
////				$InsProveedor->MtdVerificarExisteProveedor();
////				if(empty($this->PrvId)){
////					$InsProveedor->PrvEstado = 1;
////					$InsProveedor->PrvTiempoCreacion = date("Y-m-d H:i:s");
////					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
////					$InsProveedor->PrvEliminado = 1;
////
////					if(!$InsProveedor->MtdRegistrarProveedor2()){
////						$error = true;
////						$Resultado.='#ERR_PRV_101';
////					}
////
////				}else{
////
////					$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
////
////					if(!$InsProveedor->MtdEditarProveedor2()){
////						$error = true;
////						$Resultado.='#ERR_PRV_102';
////					}
////
////					$this->PrvId = $InsProveedor->PrvId;	
////					
////				}
////			}
////			
////			$sql = 'UPDATE tblamoalmacenmovimiento SET
////			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
////			'.(empty($this->CtiId)?'CtiId = NULL, ':'CtiId = "'.$this->CtiId.'",').'
////			'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
////			AmoFecha = "'.($this->AmoFecha).'",
////			AmoDocumentoOrigen = '.($this->AmoDocumentoOrigen).',
////			AmoGuiaRemisionNumero = "'.($this->AmoGuiaRemisionNumero).'",
////			'.(empty($this->AmoGuiaRemisionFecha)?'AmoGuiaRemisionFecha = NULL, ':'AmoGuiaRemisionFecha = "'.$this->AmoGuiaRemisionFecha.'",').'
////			AmoComprobanteNumero = "'.($this->AmoComprobanteNumero).'",
////			'.(empty($this->AmoComprobanteFecha)?'AmoComprobanteFecha = NULL, ':'AmoComprobanteFecha = "'.$this->AmoComprobanteFecha.'",').'
////			MonId = "'.($this->MonId).'",
////			AmoTipoCambio = '.($this->AmoTipoCambio).',
////			
////			AmoIncluyeImpuesto = '.($this->AmoIncluyeImpuesto).',
////			AmoPorcentajeImpuestoVenta = '.($this->AmoPorcentajeImpuestoVenta).',						
////			AmoNacionalTotalRecargo = '.($this->AmoNacionalTotalRecargo).',
////			AmoNacionalTotalFlete = '.($this->AmoNacionalTotalFlete).',
////			AmoNacionalTotalOtroCosto = '.($this->AmoNacionalTotalOtroCosto).',
////			
////			AmoInternacionalTotalAduana = '.($this->AmoInternacionalTotalAduana).',
////			AmoInternacionalTotalTransporte = '.($this->AmoInternacionalTotalTransporte).',
////			AmoInternacionalTotalDesestiba = '.($this->AmoInternacionalTotalDesestiba).',
////			AmoInternacionalTotalAlmacenaje = '.($this->AmoInternacionalTotalAlmacenaje).',
////			AmoInternacionalTotalAdValorem = '.($this->AmoInternacionalTotalAdValorem).',
////			AmoInternacionalTotalAduanaNacional = '.($this->AmoInternacionalTotalAduanaNacional).',
////			AmoInternacionalTotalGastoAdministrativo = '.($this->AmoInternacionalTotalGastoAdministrativo).',
////			AmoInternacionalTotalOtroCosto1 = '.($this->AmoInternacionalTotalOtroCosto1).',
////			AmoInternacionalTotalOtroCosto2 = '.($this->AmoInternacionalTotalOtroCosto2).',
////			
////			AmoInternacionalNumeroComprobante1 = "'.($this->AmoInternacionalNumeroComprobante1).'",
////			AmoInternacionalNumeroComprobante2 = "'.($this->AmoInternacionalNumeroComprobante2).'",
////			AmoInternacionalNumeroComprobante3 = "'.($this->AmoInternacionalNumeroComprobante3).'",
////			AmoInternacionalNumeroComprobante4 = "'.($this->AmoInternacionalNumeroComprobante4).'",
////			AmoInternacionalNumeroComprobante5 = "'.($this->AmoInternacionalNumeroComprobante5).'",
////			AmoInternacionalNumeroComprobante6 = "'.($this->AmoInternacionalNumeroComprobante6).'",
////			AmoInternacionalNumeroComprobante7 = "'.($this->AmoInternacionalNumeroComprobante7).'",
////			AmoInternacionalNumeroComprobante8 = "'.($this->AmoInternacionalNumeroComprobante8).'",
////			AmoInternacionalNumeroComprobante9 = "'.($this->AmoInternacionalNumeroComprobante9).'",
////			
////			AmoNacionalNumeroComprobante1 = "'.($this->AmoNacionalNumeroComprobante1).'",
////			AmoNacionalNumeroComprobante2 = "'.($this->AmoNacionalNumeroComprobante2).'",
////			AmoNacionalNumeroComprobante3 = "'.($this->AmoNacionalNumeroComprobante3).'",
////			
////
////'.(empty($this->MonIdInternacional1)?'MonIdInternacional1 = NULL, ':'MonIdInternacional1 = "'.$this->MonIdInternacional1.'",').'
////'.(empty($this->MonIdInternacional2)?'MonIdInternacional2 = NULL, ':'MonIdInternacional2 = "'.$this->MonIdInternacional2.'",').'
////'.(empty($this->MonIdInternacional3)?'MonIdInternacional3 = NULL, ':'MonIdInternacional3 = "'.$this->MonIdInternacional3.'",').'
////'.(empty($this->MonIdInternacional4)?'MonIdInternacional4 = NULL, ':'MonIdInternacional4 = "'.$this->MonIdInternacional4.'",').'
////'.(empty($this->MonIdInternacional5)?'MonIdInternacional5 = NULL, ':'MonIdInternacional5 = "'.$this->MonIdInternacional5.'",').'
////'.(empty($this->MonIdInternacional6)?'MonIdInternacional6 = NULL, ':'MonIdInternacional6 = "'.$this->MonIdInternacional6.'",').'
////'.(empty($this->MonIdInternacional7)?'MonIdInternacional7 = NULL, ':'MonIdInternacional7 = "'.$this->MonIdInternacional7.'",').'
////'.(empty($this->MonIdInternacional8)?'MonIdInternacional8 = NULL, ':'MonIdInternacional8 = "'.$this->MonIdInternacional8.'",').'
////'.(empty($this->MonIdInternacional9)?'MonIdInternacional9 = NULL, ':'MonIdInternacional9 = "'.$this->MonIdInternacional9.'",').'
////
////'.(empty($this->MonIdNacional1)?'MonIdNacional1 = NULL, ':'MonIdNacional1 = "'.$this->MonIdNacional1.'",').'
////'.(empty($this->MonIdNacional2)?'MonIdNacional2 = NULL, ':'MonIdNacional2 = "'.$this->MonIdNacional2.'",').'
////'.(empty($this->MonIdNacional3)?'MonIdNacional3 = NULL, ':'MonIdNacional3 = "'.$this->MonIdNacional3.'",').'
////
////
////'.(empty($this->PrvIdInternacional1)?'PrvIdInternacional1 = NULL, ':'PrvIdInternacional1 = "'.$this->PrvIdInternacional1.'",').'
////'.(empty($this->PrvIdInternacional2)?'PrvIdInternacional2 = NULL, ':'PrvIdInternacional2 = "'.$this->PrvIdInternacional2.'",').'
////'.(empty($this->PrvIdInternacional3)?'PrvIdInternacional3 = NULL, ':'PrvIdInternacional3 = "'.$this->PrvIdInternacional3.'",').'
////'.(empty($this->PrvIdInternacional4)?'PrvIdInternacional4 = NULL, ':'PrvIdInternacional4 = "'.$this->PrvIdInternacional4.'",').'
////'.(empty($this->PrvIdInternacional5)?'PrvIdInternacional5 = NULL, ':'PrvIdInternacional5 = "'.$this->PrvIdInternacional5.'",').'
////'.(empty($this->PrvIdInternacional6)?'PrvIdInternacional6 = NULL, ':'PrvIdInternacional6 = "'.$this->PrvIdInternacional6.'",').'
////'.(empty($this->PrvIdInternacional7)?'PrvIdInternacional7 = NULL, ':'PrvIdInternacional7 = "'.$this->PrvIdInternacional7.'",').'
////'.(empty($this->PrvIdInternacional8)?'PrvIdInternacional8 = NULL, ':'PrvIdInternacional8 = "'.$this->PrvIdInternacional8.'",').'
////'.(empty($this->PrvIdInternacional9)?'PrvIdInternacional9 = NULL, ':'PrvIdInternacional9 = "'.$this->PrvIdInternacional9.'",').'
////
////'.(empty($this->PrvIdNacional1)?'PrvIdNacional1 = NULL, ':'PrvIdNacional1 = "'.$this->PrvIdNacional1.'",').'
////'.(empty($this->PrvIdNacional2)?'PrvIdNacional2 = NULL, ':'PrvIdNacional2 = "'.$this->PrvIdNacional2.'",').'
////'.(empty($this->PrvIdNacional3)?'PrvIdNacional3 = NULL, ':'PrvIdNacional3 = "'.$this->PrvIdNacional3.'",').'			
////	
////			AmoObservacion = "'.($this->AmoObservacion).'",
////			AmoSubTotal = '.($this->AmoSubTotal).',
////			AmoImpuesto = '.($this->AmoImpuesto).',
////			AmoTotal = '.($this->AmoTotal).',
////			
////			AmoTotalInternacional = '.($this->AmoTotalInternacional).',
////			AmoTotalNacional = '.($this->AmoTotalNacional).',
////			
////			AmoEstado = '.($this->AmoEstado).'
////			WHERE AmoId = "'.($this->AmoId).'";';			
////		
////			$this->InsMysql->MtdTransaccionIniciar();
////			
////			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
////			
////			if(!$resultado) {							
////				$error = true;
////			} 			
//
//			if(!$error){
//			
//				if (!empty($this->AlmacenMovimientoEntradaExtorno)){		
//						
//					$validar = 0;				
//					$InsAlmacenMovimientoEntradaExtorno = new ClsAlmacenMovimientoEntradaExtorno();
//
//					foreach ($this->AlmacenMovimientoEntradaExtorno as $DatAlmacenMovimientoEntradaExtorno){
//
//						$InsAlmacenMovimientoEntradaExtorno->AmeId = $DatAlmacenMovimientoEntradaExtorno->AmeId;
//						$InsAlmacenMovimientoEntradaExtorno->AmoId = $this->AmoId;
//						$InsAlmacenMovimientoEntradaExtorno->ProId = $DatAlmacenMovimientoEntradaExtorno->ProId;
//						$InsAlmacenMovimientoEntradaExtorno->UmeId = $DatAlmacenMovimientoEntradaExtorno->UmeId;
//						$InsAlmacenMovimientoEntradaExtorno->AmeCosto = $DatAlmacenMovimientoEntradaExtorno->AmeCosto;
//
//						$InsAlmacenMovimientoEntradaExtorno->AmeCantidad = $DatAlmacenMovimientoEntradaExtorno->AmeCantidad;
//						$InsAlmacenMovimientoEntradaExtorno->AmeCantidadReal = $DatAlmacenMovimientoEntradaExtorno->AmeCantidadReal;
//
//						$InsAlmacenMovimientoEntradaExtorno->AmeImporte = $DatAlmacenMovimientoEntradaExtorno->AmeImporte;
//						$InsAlmacenMovimientoEntradaExtorno->AmeEstado = $this->AmoEstado;		
//						$InsAlmacenMovimientoEntradaExtorno->AmeTiempoCreacion = $DatAlmacenMovimientoEntradaExtorno->AmeTiempoCreacion;
//						$InsAlmacenMovimientoEntradaExtorno->AmeTiempoModificacion = $DatAlmacenMovimientoEntradaExtorno->AmeTiempoModificacion;
//						$InsAlmacenMovimientoEntradaExtorno->AmeEliminado = $DatAlmacenMovimientoEntradaExtorno->AmeEliminado;
//						
//						if(empty($InsAlmacenMovimientoEntradaExtorno->AmeId)){
//							if($InsAlmacenMovimientoEntradaExtorno->AmeEliminado<>2){
//								if($InsAlmacenMovimientoEntradaExtorno->MtdRegistrarAlmacenMovimientoEntradaExtorno()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_AMO_301';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								$validar++;
//							}
//						}else{						
//							if($InsAlmacenMovimientoEntradaExtorno->AmeEliminado==2){
//								if($InsAlmacenMovimientoEntradaExtorno->MtdEliminarAlmacenMovimientoEntradaExtorno($InsAlmacenMovimientoEntradaExtorno->AmeId)){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_AMO_303';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								if($InsAlmacenMovimientoEntradaExtorno->MtdEditarAlmacenMovimientoEntradaExtorno()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_AMO_302';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}
//						}									
//					}
//					
//					if(count($this->AlmacenMovimientoEntradaExtorno) <> $validar ){
//						$error = true;
//					}					
//								
//				}				
//			}	
//				
//			if($error) {		
//				$this->InsMysql->MtdTransaccionDeshacer();					
//				return false;
//			} else {			
//				$this->InsMysql->MtdTransaccionHacer();				
//				
//				$this->MtdAuditarAlmacenMovimientoEntrada(2,"Se extorno el Movimiento de Almacen",$this);		
//				return true;
//			}	
//				
//		}
//		
		
	
		public function MtdEditarAlmacenMovimientoEntradaDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblamoalmacenmovimiento SET 
			'.$oCampo.' = "'.($oDato).'",
			AmoTiempoModificacion = NOW()
			WHERE AmoId = "'.($oId).'";';
			
			$error = false;

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



		private function MtdAuditarAlmacenMovimientoEntrada($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL,$oSucursal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			//$InsAuditoria->AudCodigo = $this->AmoId;
			$InsAuditoria->AudCodigo = $oCodigo;
			//$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->UsuId = $oUsuario;
			$InsAuditoria->SucId = $oSucursal;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
			$InsAuditoria->AudUsuario = $oUsuario;
			$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
		
		public function MtdNotificarAlmacennMovimientoEntradaOrdenCompra($oAlmacenMovimientoEntrada,$oDestinatario,$oImportante=false){
			
global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->AmoId = $oAlmacenMovimientoEntrada;
			$this->MtdObtenerAlmacenMovimientoEntrada();
			
			$InsOrdenCompra = new ClsOrdenCompra();
			$InsOrdenCompra->OcoId = $this->OcoId;
			$InsOrdenCompra->MtdObtenerOrdenCompra();
			

							
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de Ingreso a almacen c/ Orden de Compra .";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->AmoId."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Proveedor: <b>".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Fecha Registro: <b>".$this->AmoFecha."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Orden de Compra: <b>".$this->OcoId."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
			$mensaje .= "Datos del comprobante";	
			$mensaje .= "<br>";
			$mensaje .= "Tipo: <b>".$this->CtiNombre."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Numero : <b>".$this->AmoComprobanteNumero."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Fecha : <b>".$this->AmoComprobanteFecha."</b>";				
			$mensaje .= "<br>";
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";

			if(!empty($InsOrdenCompra->OrdenCompraPedido)){
				foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
					

			
					$InsPedidoCompra = new ClsPedidoCompra();
					$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
					$InsPedidoCompra->MtdObtenerPedidoCompra();
					
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
					$mensaje .= "<table>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "Cliente: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->CliNombre." ".$InsPedidoCompra->CliApellidoPaterno." ".$InsPedidoCompra->CliApellidoMaterno;
						$mensaje .= "</b></td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "Fecha: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->PcoFecha;
						$mensaje .= "</b></td>";
						
						
						$mensaje .= "<td>";
						$mensaje .= "Ord. Ven.: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->VdiId;
						$mensaje .= "</b></td>";
						
						
						$mensaje .= "<td>";
						$mensaje .= "O/C Ref: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->VdiOrdenCompraNumero." - ".$InsPedidoCompra->VdiOrdenCompraFecha;
						$mensaje .= "</b></td>";
		
					$mensaje .= "</tr>";
									
					$mensaje .= "</table>";
									
									
									


					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "#";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Cod. Original";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Nombre";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Cantidad";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Estado";
						$mensaje .= "</td>";
						
						
		
					$mensaje .= "</tr>";

					
					$i = 1;
					if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
						foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
							
							$mensaje .= "<tr>";


								if(empty($DatPedidoCompraDetalle->AmdCantidad)){
									$fondo = "#F30";
								}else if($DatPedidoCompraDetalle->AmdCantidad >= $DatPedidoCompraDetalle->PcdCantidad){
									$fondo = "#6F3";
								}else if($DatPedidoCompraDetalle->AmdCantidad < $DatPedidoCompraDetalle->PcdCantidad){
									$fondo = "#FC0";		
								}else{
									$fondo = "";	
								}
								
								
								$mensaje .= "<td>";
								$mensaje .= $i;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraDetalle->ProCodigoOriginal;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraDetalle->ProNombre;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= number_format($DatPedidoCompraDetalle->PcdCantidad,2);
								$mensaje .= "</td>";
				
								$mensaje .= "<td bgcolor='".$fondo."'>";
								
								if(empty($DatPedidoCompraDetalle->AmdCantidad)){
									$mensaje .= "No Atendido";
								}else if($DatPedidoCompraDetalle->AmdCantidad >= $DatPedidoCompraDetalle->PcdCantidad){
									$mensaje .= "Ya llego";
								}else if($DatPedidoCompraDetalle->AmdCantidad < $DatPedidoCompraDetalle->PcdCantidad){
									$mensaje .= "Incompleto, aun faltan (".($DatPedidoCompraDetalle->PcdCantidad - $DatPedidoCompraDetalle->AmdCantidad).") items";
								}else{
									$mensaje .= "</td>";
								}
								
								$mensaje .= "</td>";

							$mensaje .= "</tr>";
							$i++;							
						}
					}
					
					$mensaje .= "</table>";
					

					
				}
			}
			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			///echo $mensaje;
			
			if($oImportante){
			
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: INGRESO A ALMACEN C/ ORDEN DE COMPRA: ".$this->OcoId." - ".$this->PrvNombre." ".$this->PrvApellidoPaterno." [IMPORTANTE]".$this->PrvApellidoMaterno,$mensaje);
						
			}else{
			
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: INGRESO A ALMACEN C/ ORDEN DE COMPRA: ".$this->OcoId." - ".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno,$mensaje);
					
			}
			
				
				
			
		}
		//
//			
//		public function MtdNotificarAlmacennMovimientoEntradaOrdenCompra($oAlmacenMovimientoEntrada,$oDestinatario){
//			
//
//			$this->AmoId = $oAlmacenMovimientoEntrada;
//			$this->MtdObtenerAlmacenMovimientoEntrada();
//			
//			$InsOrdenCompra = new ClsOrdenCompra();
//			$InsOrdenCompra->OcoId = $this->OcoId;
//			$InsOrdenCompra->MtdObtenerOrdenCompra();
//			
//
//							
//			$mensaje .= "NOTIFICACION DE REGISTRO:";	
//			$mensaje .= "<br>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Registro de Ingreso a almacen c/ Orden de Compra .";	
//			$mensaje .= "<br>";	
//
//			$mensaje .= "Codigo Interno: <b>".$this->AmoId."</b>";	
//			$mensaje .= "<br>";	
//			$mensaje .= "Proveedor: <b>".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno."</b>";	
//			$mensaje .= "<br>";	
//			$mensaje .= "Fecha Registro: <b>".$this->AmoFecha."</b>";	
//			$mensaje .= "<br>";	
//			$mensaje .= "Orden de Compra: <b>".$this->OcoId."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "<br>";
//			$mensaje .= "<br>";
//			
//			$mensaje .= "Datos del comprobante";	
//			$mensaje .= "<br>";
//			$mensaje .= "Tipo: <b>".$this->CtiNombre."</b>";	
//			$mensaje .= "<br>";
//			$mensaje .= "Numero : <b>".$this->AmoComprobanteNumero."</b>";	
//			$mensaje .= "<br>";
//			$mensaje .= "Fecha : <b>".$this->AmoComprobanteFecha."</b>";				
//			$mensaje .= "<br>";
//			
//			$mensaje .= "<hr>";
//			$mensaje .= "<br>";
//
//			if(!empty($InsOrdenCompra->OrdenCompraPedido)){
//				foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
//					
//
//			
//					$InsPedidoCompra = new ClsPedidoCompra();
//					$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
//					$InsPedidoCompra->MtdObtenerPedidoCompra();
//					
//			$mensaje .= "<br>";
//			$mensaje .= "<br>";
//			
//					$mensaje .= "<table>";
//					
//					$mensaje .= "<tr>";
//					
//						$mensaje .= "<td>";
//						$mensaje .= "Cliente: ";
//						$mensaje .= "</td>";
//		
//						$mensaje .= "<td><b>";
//						$mensaje .= $InsPedidoCompra->CliNombre." ".$InsPedidoCompra->CliApellidoPaterno." ".$InsPedidoCompra->CliApellidoMaterno;
//						$mensaje .= "</b></td>";
//		
//					$mensaje .= "</tr>";
//					
//					$mensaje .= "<tr>";
//					
//						$mensaje .= "<td>";
//						$mensaje .= "Fecha: ";
//						$mensaje .= "</td>";
//		
//						$mensaje .= "<td><b>";
//						$mensaje .= $InsPedidoCompra->PcoFecha;
//						$mensaje .= "</b></td>";
//						
//						
//						$mensaje .= "<td>";
//						$mensaje .= "Ord. Ven.: ";
//						$mensaje .= "</td>";
//		
//						$mensaje .= "<td><b>";
//						$mensaje .= $InsPedidoCompra->VdiId;
//						$mensaje .= "</b></td>";
//						
//						
//						$mensaje .= "<td>";
//						$mensaje .= "O/C Ref: ";
//						$mensaje .= "</td>";
//		
//						$mensaje .= "<td><b>";
//						$mensaje .= $InsPedidoCompra->VdiOrdenCompraNumero." - ".$InsPedidoCompra->VdiOrdenCompraFecha;
//						$mensaje .= "</b></td>";
//		
//					$mensaje .= "</tr>";
//									
//					$mensaje .= "</table>";
//									
//									
//									
//
//
//					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
//					
//					$mensaje .= "<tr>";
//					
//						$mensaje .= "<td>";
//						$mensaje .= "#";
//						$mensaje .= "</td>";
//		
//						$mensaje .= "<td>";
//						$mensaje .= "Cod. Original";
//						$mensaje .= "</td>";
//		
//						$mensaje .= "<td>";
//						$mensaje .= "Nombre";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td>";
//						$mensaje .= "Cantidad";
//						$mensaje .= "</td>";
//		
//						$mensaje .= "<td>";
//						$mensaje .= "Estado";
//						$mensaje .= "</td>";
//						
//						
//		
//					$mensaje .= "</tr>";
//
//					
//					$i = 1;
//					if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
//						foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
//							
//							$mensaje .= "<tr>";
//
//
//								if(empty($DatPedidoCompraDetalle->AmdCantidad)){
//									$fondo = "#F30";
//								}else if($DatPedidoCompraDetalle->AmdCantidad >= $DatPedidoCompraDetalle->PcdCantidad){
//									$fondo = "#6F3";
//								}else if($DatPedidoCompraDetalle->AmdCantidad < $DatPedidoCompraDetalle->PcdCantidad){
//									$fondo = "#FC0";		
//								}else{
//									$fondo = "";	
//								}
//								
//								
//								$mensaje .= "<td>";
//								$mensaje .= $i;
//								$mensaje .= "</td>";
//				
//								$mensaje .= "<td>";
//								$mensaje .= $DatPedidoCompraDetalle->ProCodigoOriginal;
//								$mensaje .= "</td>";
//				
//								$mensaje .= "<td>";
//								$mensaje .= $DatPedidoCompraDetalle->ProNombre;
//								$mensaje .= "</td>";
//								
//								$mensaje .= "<td>";
//								$mensaje .= number_format($DatPedidoCompraDetalle->PcdCantidad,2);
//								$mensaje .= "</td>";
//				
//								$mensaje .= "<td bgcolor='".$fondo."'>";
//								
//								if(empty($DatPedidoCompraDetalle->AmdCantidad)){
//									$mensaje .= "No Realizado";
//								}else if($DatPedidoCompraDetalle->AmdCantidad >= $DatPedidoCompraDetalle->PcdCantidad){
//									$mensaje .= "Ya llego";
//								}else if($DatPedidoCompraDetalle->AmdCantidad < $DatPedidoCompraDetalle->PcdCantidad){
//									$mensaje .= "Incompleto, aun faltan (".($DatPedidoCompraDetalle->PcdCantidad - $DatPedidoCompraDetalle->AmdCantidad).") items";
//								}else{
//									$mensaje .= "</td>";
//								}
//								
//								$mensaje .= "</td>";
//
//							$mensaje .= "</tr>";
//							$i++;							
//						}
//					}
//					
//					$mensaje .= "</table>";
//					
//
//					
//				}
//			}
//			
//			
//			$mensaje .= "<br>";
//			$mensaje .= "<br>";
//			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
//			
//			///echo $mensaje;
//			
//			
//						
//			$InsCorreo = new ClsCorreo();	
//			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: INGRESO A ALMACEN C/ ORDEN DE COMPRA: ".$this->OcoId." - ".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno,$mensaje);
//				
//				
//			
//		}
		
//		MtdNotificarAlmacennMovimientoEntradaOrdenCompra
		public function MtdNotificarAlmacenMovimientoEntradaVencimiento($oDestinatario,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL,$oProveedor=NULL){
		
			global $EmpresaMonedaId;
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$Enviar = false;
			
			$ProveedorNombre = "";
			$ProveedorNumeroDocumento = "";
			
			if(!empty($oProveedor)){
				
				$InsProveedor = new ClsProveedor();
				$InsProveedor->PrvId = $oProveedor;
				$InsProveedor->MtdObtenerProveedor();
				
				$ProveedorNombre = $InsProveedor->PrvNombre." ".$InsProveedor->PrvApellidoPaterno." ".$InsProveedor->PrvApellidoMaterno;
				$ProveedorNumeroDocumento = $InsProveedor->PrvNumeroDocumento;
				$ProveedorTipoDocumento = $InsProveedor->TdoNombre;
				
			}
			
			$mensaje .= "AVISO DE VENCIMIENTO DE FACTURAS:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

		
			$mensaje .= "Fecha de aviso: <b>".date("d/m/Y")."</b>";	
			$mensaje .= "<br>";	
			
			if(!empty($oProveedor)){
				
				$mensaje .= "Proveedor: <b>".$ProveedorNombre."</b>";	
				$mensaje .= "<br>";
				
				$mensaje .= "Num.Doc.: <b>".$ProveedorTipoDocumento."/".$ProveedorNumeroDocumento."</b>";	
				$mensaje .= "<br>";		
							
			}
			
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			
			
			$InsMoneda = new ClsMoneda();
			$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","DESC",NULL);
			$ArrMonedas = $ResMoneda['Datos'];

			foreach($ArrMonedas as $DatMoneda){
			
				$mensaje .= "<br>";
				//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL) {
				$ResAlmacenMovimientoEntrada = $this->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,"AmoComprobanteFecha","ASC",NULL,FncCambiaFechaAMysql($oFechaInicio),FncCambiaFechaAMysql($oFechaFin),NULL,NULL,$DatMoneda->MonId,NULL,NULL,NULL,NULL,"AmoComprobanteFecha",0,2,$oProveedor,NULL,$oCondicionPago);
				$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];

				if(!empty($ArrAlmacenMovimientoEntradas)){
				
					$mensaje .= "<b>RELACION DE FACTURAS EN ".$DatMoneda->MonNombre." (".$DatMoneda->MonSimbolo.") </b>" ;
					$mensaje .= "<br>";
					
					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%' border='0'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td width='2%'>";
						$mensaje .= "<b>#</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>COND. PAGO</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "<b>NUM. COMPROB.</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>FECHA COMPROB.</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>NUM. DOC.</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='60%'>";
						$mensaje .= "<b>PROVEEDOR</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>MONEDA</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>ORD. COMPRA</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>CRED. CANT. DIAS</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>FECHA VENC.</b>";
						$mensaje .= "</td>";
						
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>TOTAL</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>AMORT.</b>";
						$mensaje .= "</td>";
						
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>SALDO</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>VENCIMIENTO</b>";
						$mensaje .= "</td>";
						
						
					$mensaje .= "</tr>";
					
					
							
				$c = 1;	
				
				foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){


					$DatAlmacenMovimientoEntrada->AmoTotal = (($EmpresaMonedaId==$DatMoneda->MonId or empty($DatMoneda->MonId))?$DatAlmacenMovimientoEntrada->AmoTotal:($DatAlmacenMovimientoEntrada->AmoTotal/$DatAlmacenMovimientoEntrada->AmoTipoCambio));
				
					$DatAlmacenMovimientoEntrada->AmoTotal = round($DatAlmacenMovimientoEntrada->AmoTotal,2);
					
					$Mostrar = true;

					if($DatAlmacenMovimientoEntrada->NpaId == "NPA-10001"){
						
						settype($DatAlmacenMovimientoEntrada->AmoTotal ,"float");
						settype($ProveedorPagoMontoTotal ,"float");
						
						
						if(($ProveedorPagoMontoTotal+1000) < ($DatAlmacenMovimientoEntrada->AmoTotal+1000)){
							if($DatAlmacenMovimientoEntrada->AmoCantidadDia<$DatAlmacenMovimientoEntrada->AmoDiaTranscurrido){
								
							}else if ( ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido) >= 1 and ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido) <=3 ){
				
							}else{
								
								$Mostrar = false;
								
							}
						}
						
					}
	
				if($Mostrar){
						
					$mensaje .= "<tr>";
									
					$mensaje .= "<td>";
					$mensaje .= $c;
					$mensaje .= "</td>";
	
					$mensaje .= "<td>";
					$mensaje .= $DatAlmacenMovimientoEntrada->NpaNombre;
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= "<span title='".$DatAlmacenMovimientoEntrada->AmoId."'>".$DatAlmacenMovimientoEntrada->AmoComprobanteNumero."</span>";
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatAlmacenMovimientoEntrada->AmoComprobanteFecha;
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= $DatAlmacenMovimientoEntrada->PrvNumeroDocumento;
					$mensaje .= "</td>";

					
					$mensaje .= "<td>";
					$mensaje .= $DatAlmacenMovimientoEntrada->PrvNombreCompleto;
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatAlmacenMovimientoEntrada->MonSimbolo;
					$mensaje .= "</td>";
					
					
					$mensaje .= "<td>";
					$mensaje .= $DatAlmacenMovimientoEntrada->OcoId;
					$mensaje .= "</td>";
							
					$mensaje .= "<td>";
					
					if($DatAlmacenMovimientoEntrada->NpaId == "NPA-10001"){
					
						$mensaje .= $DatAlmacenMovimientoEntrada->AmoCantidadDia;
						
						if($DatAlmacenMovimientoEntrada->AmoCantidadDia <=30){
							$TotalCredito30 += $DatAlmacenMovimientoEntrada->AmoTotal;
						}else{
							$TotalCredito30Mas += $DatAlmacenMovimientoEntrada->AmoTotal;
						}
					
					}else{
						$TotalContado += $DatAlmacenMovimientoEntrada->AmoTotal;
					}
					
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= $DatAlmacenMovimientoEntrada->AmoFechaVencimiento;
					$mensaje .= "</td>";
								
					$mensaje .= "<td>";
					$mensaje .= number_format($DatAlmacenMovimientoEntrada->AmoTotal,2);
					$mensaje .= "</td>";
								

		
					$ProveedorPagoMontoTotal = 0;

					switch($DatAlmacenMovimientoEntrada->AmoCancelado){
					
						case 1:
							$ProveedorPagoMontoTotal = $DatAlmacenMovimientoEntrada->AmoTotal;					
						break;
					
						case 2:
									
						break;	

					}
				
					$mensaje .= "<td>";
					$mensaje .= $ProveedorPagoMontoTotal;
					$mensaje .= "</td>";
					
					settype($DatAlmacenMovimientoEntrada->AmoTotal ,"float");
					settype($ProveedorPagoMontoTotal ,"float");
					
					$AlmacenMovimientoEntradaSaldo = round($DatAlmacenMovimientoEntrada->AmoTotal,2) - round($ProveedorPagoMontoTotal,2);
		
						
					$mensaje .= "<td>";
					$mensaje .= number_format($AlmacenMovimientoEntradaSaldo,2);
					$mensaje .= "</td>";
					
					
		
					$mensaje .= "<td>";

	
					if($DatAlmacenMovimientoEntrada->NpaId == "NPA-10001"){
						
						settype($DatAlmacenMovimientoEntrada->AmoTotal ,"float");
						settype($ProveedorPagoMontoTotal ,"float");
						
						
						if(($ProveedorPagoMontoTotal+1000) < ($DatAlmacenMovimientoEntrada->AmoTotal+1000)){
							if($DatAlmacenMovimientoEntrada->AmoCantidadDia<$DatAlmacenMovimientoEntrada->AmoDiaTranscurrido){
								
								$mensaje .= "VENCIDO ";
								$mensaje .= ($DatAlmacenMovimientoEntrada->AmoDiaTranscurrido - $DatAlmacenMovimientoEntrada->AmoCantidadDia)." dias";
								
							}else if ( ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido) >= 1 and ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido) <=3 ){
								
								$mensaje .= "POR VENCER ";				
								$mensaje .= ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido)." dias";
				
							}else{
								
								$mensaje .= "VIGENTE ";
								
							}
						}
						
					}
	
					$mensaje .= "</td>";
	
	
					$mensaje .= "</tr>";

					$c++;			
					
				
					$Enviar = true;
					
					}
					
					
							
				}
				

					
						
					$mensaje .= "</table>";
					
					
				}
				
			}
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			
			echo $mensaje;
			
			if($Enviar){
				
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"AVISO: FACTURAS C/ CREDITO - ".$ProveedorNombre,$mensaje);
				
			}
				
				
				
				
		}

		
		/*public function MtdEditarAlmacenMovimientoEntradaDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblamoalmacenmovimiento SET 
			'.(empty($oDato)?$oCampo.' = NULL  ':$oCampo.' = "'.$oDato.'" ').'
		
			WHERE AmoId = "'.($oId).'";';
			
			$error = false;

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
	*/
		
}
?>