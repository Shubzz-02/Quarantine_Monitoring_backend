<?php
require_once '__getVillData.block.php';
require_once '__userDetails.block.php';
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class GetXls
{

    private $getVill = null;
    private $getUserDet = null;
    private $block = array();
    private $detailsArr = array();
    private $dailyArr = array();

    public function __construct()
    {
        $this->block = array("Agustyamuni", "Jakholi", "Ukhimath");
        $this->detailsArr = array("Name Of Gram Pnchayat", "S.No", "Name of person coming from other Place", "Father/ Husband Name"
        , "Age", "Gender", "Phone Number", "Coming From", "Date of reaching in village");
        $this->dailyArr = ["Was found roaming outside home", "ASHA/ANM Visit", "came in contact with any local person"
            , "is suffering from cold and fever"];
    }

    public function getXls()
    {

        foreach ($this->block as $block) {
            $getVill = null;
            $getVill = new GetVillData($block);
            $villname = $getVill->getVillname();
            if ($villname == null) {
                continue;
            } else {
                foreach ($villname as $vill) {
                    $data = $getVill->getTableData($vill);
                    if ($data == null) {
                        continue;
                    } else {
                        $this->createXls($data, $vill, $block);
                    }
                }
            }
        }
    }

    private function createXls($data, $vill_name, $block)
    {
        try {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->getDefaultStyle()->getFont()->setName("Calibri");
            $spreadsheet->getDefaultStyle()->getFont()->setSize(11);
            $spreadsheet->getProperties()
                ->setCreator("Shubzz")
                ->setLastModifiedBy("Shubzz")
                ->setTitle("XLSX Sheet of " . $vill_name . " village")
                ->setSubject($vill_name . " Data")
                ->setDescription("Data of " . $vill_name . " village, generated using PHP classes.")
                ->setKeywords($vill_name . " village")
                ->setCategory("Data");
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->getDefaultRowDimension()->setRowHeight(20);
            $sheet->getDefaultColumnDimension()->setWidth(9.11);
            $sheet->getRowDimension(8)->setRowHeight(78);
            $sheet->getColumnDimension("A")->setWidth(13);
            $sheet->getColumnDimension("B")->setWidth(7.78);
            $sheet->getColumnDimension("C")->setWidth(33.33);
            $sheet->getStyle("A8:I8")->getAlignment()->setWrapText(true);
            $sheet->fromArray($this->detailsArr, "", "A8");
            $sheet->mergeCells("C7:I7");
            $column = $this->getColumn($data);
            $size = count($column);
            for ($i = 0; $i < $size / 4; $i++) {
                $bfC = $sheet->getHighestDataColumn();
                $bfR = $sheet->getHighestDataRow();
                $bfC = $this->getColumnIndex($bfC);
                $sheet->fromArray($this->dailyArr, "", $bfC . $bfR);
                $sel = $bfC . "7:" . $sheet->getHighestDataColumn() . "7";
                $sheet->mergeCells($sel);
                $DateI = $column[4 * $i];
                $gDate = str_replace("_", "-", substr($DateI, 0, 10));
                $sheet->setCellValue($bfC . "7", "Date:- " . $gDate);
                $styleArray = ['alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],];
                $sheet->getStyle($bfC . "7")->applyFromArray($styleArray);
                $sheet->getStyle($bfC . $bfR . ":" .
                    $sheet->getHighestDataColumn() . $sheet->getHighestDataRow())->getAlignment()->setWrapText(true);
            }
            $szData = count($data);
            $st = 9;
            for ($i = 0; $i < $szData; $i++) {
                $arr = array($vill_name, strval($i));
                $mergeArray = array_merge($arr, $this->getValues($data, $i));
                $cot = strval($st + $i);
                $bfC = "A";
                foreach ($mergeArray as $value) {
                    $sheet->setCellValue($bfC . $cot, strval($value));
                    $bfC = $this->getColumnIndex($bfC);
                }
            }
            $writer = new Xlsx($spreadsheet);
            $path = 'files/' . $block . '/' . $vill_name . '.xlsx';
            $writer->save($path);
            //here--------------
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            echo $e->getMessage();
        }
    }


    private function getColumn($data)
    {
        $ar = $data[0];
        $column = array_keys($ar);
        $column = array_slice($column, 8);
        return $column;
    }

    private function getValues($data, $i)
    {
        $ar = $data[$i];
        $values = array_values($ar);
        $values = array_slice($values, 1);
        return $values;
    }

    private function getColumnIndex($bfC)
    {
        $c = str_split($bfC);
        $sz = count($c);
        $ct = 0;
        for ($i = $sz - 1; $i >= 0; $i--) {
            $char = ord($c[$i]) + (int)1;
            if ($char > 90) {
                $c[$i] = "A";
                $ct++;
                continue;
            } else {
                $c[$i] = chr($char);
                break;
            }
        }
        if ($ct == $sz) {
            $bfC = "A" . implode($c);
        } else {
            $bfC = implode($c);
        }
        return $bfC;
    }

    public function createZip()
    {
        $pathdir = "files/";
        $data = "download/data.zip";
        $zip = new ZipArchive;
        if ($zip->open($data, ZipArchive::CREATE) === TRUE | ZipArchive::OVERWRITE) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($pathdir),
                RecursiveIteratorIterator::LEAVES_ONLY
            );
            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($pathdir) + 1);

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
            return true;
        } else {
            return false;
        }
    }

    private function feedData($data, $vill_name, $block)
    {

    }
}

$download = new GetXls();
$download->getXls();
$download->createZip();



