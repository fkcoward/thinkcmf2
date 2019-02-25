<?php

function arrayToExcel($head,$body,$title=""){
    if(empty($title)){
        $title=date("YmdHis");
    }
    $objPHPExcel=new \PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("fsd")
        ->setLastModifiedBy("is me")
        ->setTitle($title)
        ->setSubject("Office 2007 XLSX Document")
        ->setDescription("Test document for Office 2007 XLSX")
        ->setKeywords("office 2007")
        ->setCategory("hahaha");
    $abc="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $arrsize=count($head);
    $exceltitle=substr($abc,0,$arrsize);
    //设置当前活动sheet的名称
    $objActSheet=$objPHPExcel->setActiveSheetIndex(0);
    foreach ($head as $n=>$m){
        $objActSheet->setCellValue($exceltitle[$n]."1", $m);
    }
    $hang=2;

    foreach ($body as $m){
        $lie=0;
        foreach ($m as $y){
            if(empty($y)){
                $y=" ";
            }
            $objActSheet->setCellValueExplicit($exceltitle[$lie].$hang, $y,PHPExcel_Cell_DataType::TYPE_STRING);
            $lie++;
        }
        $hang++;
    }
    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Simple');


    // Set active sheet index to the first sheet, so Excel opens this as the first sheet


    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$title.'.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}