<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\ZipArchive;
use PhpOffice\PhpWord\SimpleType\DocProtect;

class PruebaWord extends Controller
{	
	public function index()
	{

		$PHPWord = new PHPWord();
		
 		$documentProtection = $PHPWord->getSettings()->getDocumentProtection();
		$documentProtection->setEditing(DocProtect::READ_ONLY);
		$documentProtection->setPassword('123456');

		$sectionStyle =
			array
			(
			'page' => 'b4',
			'marginTop' => 600,
			'marginLeft' => 600,
			'marginRight' => 600,
			);
		$section = $PHPWord->createSection($sectionStyle);
		// Define table style arrays
		$styleTable = array('cellMargin'=>80);
		$styleFirstRow = array('borderBottomSize'=>10, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');
		// Define cell style arrays
		$styleCell = array('valign'=>'center', 'halign'=>'center');
		$styleCellBorder = array('valign'=>'center', 'halign'=>'center', 'borderBottomSize'=>5);

		$styleCellRight = array('valign'=>'center', 'halign'=>'center', 'borderRightSize'=>5);
		$styleCellBorderRight = array('valign'=>'center', 'halign'=>'center', 'borderBottomSize'=>5, 'borderRightSize'=>5);
		// Define font style for first row
		$fontStyle = array('bold'=>true, 'alignment'=>'center');
		// Add table style
		$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);
		// Add table
		$table = $section->addTable('myOwnTableStyle');
		// Add row
		$table->addRow(400);
		// Add cells
		$table->addCell(5500, $styleCellRight)->addText('FIEDBA S.A.S                                                    *PARCIAL*');
		$table->addCell(5500, $styleCell)->addText('FIEDBA S.A.S                                                    *PARCIAL*');


		$table->addRow(400);
		$table->addCell(5500, $styleCellBorderRight)->addText("                               Cupon de pago");
		$table->addCell(5500, $styleCellBorder)->addText("                               Cupon de pago");

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("                                           N°");
		$table->addCell(5500, $styleCell)->addText("                                           N°");

		$table->addRow(400);
		$table->addCell(5500, $styleCellBorderRight)->addText("                        777-1 - BE-MUEBLERIA");
		$table->addCell(5500, $styleCellBorder)->addText("                        777-1 - BE-MUEBLERIA");

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("1-40519839-SOL AGUSTINA");
		$table->addCell(5500, $styleCell)->addText("1-40519839-SOL AGUSTINA");

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("LA ROQUE Y PEÑA");
		$table->addCell(5500, $styleCell)->addText("LA ROQUE Y PEÑA");

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("(1806)-MORATURA 2563 - TRISTAN SUAREZ");
		$table->addCell(5500, $styleCell)->addText("(1806)-MORATURA 2563 - TRISTAN SUAREZ");

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("CRÉDITO: 57                                    CUOTA: 3/10");
		$table->addCell(5500, $styleCell)->addText("CRÉDITO: 57                                    CUOTA: 3/10");

		$table->addRow(400);
		$table->addCell(5500, $styleCellBorderRight)->addText("VENCIM: 13-01-2019                        F.PAGO: 25-10-2018");
		$table->addCell(5500, $styleCellBorder)->addText("VENCIM: 13-01-2019                        F.PAGO: 25-10-2018");

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("                            CUOTA: 416");
		$table->addCell(5500, $styleCell)->addText("                            CUOTA: 416");

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("                  PUNITORIOS: 0");
		$table->addCell(5500, $styleCell)->addText("                  PUNITORIOS: 0");

		$table->addRow(400);
		$table->addCell(5500, $styleCellBorderRight)->addText("                             TOTAL: 416");
		$table->addCell(5500, $styleCellBorder)->addText("                             TOTAL: 416");

		$table->addRow(400);
		$table->addCell(5500, $styleCellBorderRight)->addText("Son $: Cuatrocientos dieciseis");
		$table->addCell(5500, $styleCellBorder)->addText("Son $: Cuatrocientos dieciseis");

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("Proximos vencimientos");
		$table->addCell(5500, $styleCell)->addText("Proximos vencimientos");

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("Crédito                  Cu/Cc                  Venc                  Monto", array('align'=>'center'));
		$table->addCell(5500, $styleCell)->addText("Crédito                  Cu/Cc                  Venc                  Monto", array('align'=>'center'));

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("57                       4/10                13-02-2019               416.00", array('align'=>'center'));
		$table->addCell(5500, $styleCell)->addText("57                       4/10                13-02-2019               416.00", array('align'=>'center'));

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("ATENCION:", array('bold'=>true));
		$table->addCell(5500, $styleCell)->addText("ATENCION:", array('bold'=>true));

		$table->addRow(400);
		$table->addCell(5500, $styleCellRight)->addText("Su pago en termino evita la adicion de intereses punitorios y gastos a la/s cuota/s.", array('align'=>'center'));
		$table->addCell(5500, $styleCell)->addText("Su pago en termino evita la adicion de intereses punitorios y gastos a la/s cuota/s.", array('align'=>'center'));

		// Save File
		$objWriter = IOFactory::createWriter($PHPWord, 'Word2007');

	    try {
	        $objWriter->save(storage_path('TestWordsFislse.doc'));
	    } catch (Exception $e) {
	    }
	 
	    return response()->download(storage_path('TestWordsFislse.doc'));
	}
	    
}
