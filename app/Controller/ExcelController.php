<?php

namespace App\Controller;

use Hyperf\DbConnection\Db;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Swoole\Exception;

class ExcelController extends AbstractController
{

    /**
     * 读取excel中的数据
     * @param string $filename
     * @param string[] $range
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function readexcel($filename = "/data/project/Township_Area_A_202104.xlsx", $range = ["A2:H2"])
    {
        //使用自动读取器\读取程序解析文件类型。
        $inputFileType = IOFactory::identify($filename);
        //创建读取器\i读取器。
        $reader = IOFactory::createReader($inputFileType);
        //将read data only设置为true，建议读取器只读取单元格的数据值，并忽略任何格式信息。
        $reader->setReadDataOnly(true);
        //使用自动读取器解析从文件加载电子表格。
        $spreadsheet = $reader->load($filename);
        $data = [];
        foreach ($spreadsheet->getAllSheets() as $key => $worksheet) {
            //获取工作表的最高行
            $maxRow = $worksheet->getHighestRow();
            //从一系列单元格创建数组
            $data[] = $worksheet->rangeToArray($range[$key] . $maxRow, '');
        }
        //断开所有工作表与此PhpSpreadsheet工作簿对象的连接，通常这样可以取消设置PhpSpreadsheet对象
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        //存储所有省
        $shengArr = [];
        foreach ($data as $v) {
            foreach ($v as $item) {
                $sheng = trim($item[0]);
                $sql = ['cname' => $sheng, 'parent_id' => 1, 'ctype' => 2];
                if (!in_array($sql, $shengArr) && $sheng != '') {
                    array_push($shengArr, $sql);
                }
            }
        }

        Db::table('dgtx_places')->insert($shengArr);

        //存储所有区、市
        $shiArr = [];
        foreach ($data as $v) {
            foreach ($v as $item) {
                $sheng = trim($item[0]);
                $shi = trim($item[2]);
                if ($sheng == '' || $shi == '') {
                    continue;
                }
                $shengData = Db::table('dgtx_places')->where('cname', $sheng)->where('ctype', 2)->first();

                $sql = ['cname' => $shi, 'parent_id' => $shengData['id'], 'ctype' => 3];

                if (!in_array($sql, $shiArr)) {
                    array_push($shiArr, $sql);
                }
            }

        }

        Db::table('dgtx_places')->insert($shiArr);
//
//        //存储所有县
        $xianArr = [];
        foreach ($data as $v) {
            foreach ($v as $item) {
                $sheng = trim($item[0]);
                $shi = trim($item[2]);
                $xian = trim($item[4]);
                if ($sheng == '' || $shi == '' || $xian == '') {
                    continue;
                }
                $shengData = Db::table('dgtx_places')->where('cname', $sheng)->where('ctype', 2)->first();
                $shiData = Db::table('dgtx_places')->where('cname', $shi)->where('ctype', 3)->where('parent_id', $shengData['id'])->first();
                $sql = ['cname' => $xian, 'parent_id' => $shiData['id'], 'ctype' => 4];
                if (!in_array($sql, $xianArr)) {
                    array_push($xianArr, $sql);
                }
            }
        }

        Db::table('dgtx_places')->insert($xianArr);
        return $shengArr;
    }

    /**
     * 写入excel中的数据
     * @param array $schooList （要写入excel的数据，数据顺序和excel模板一一对应）
     * @param string $file （包含文件名的excel模板绝对路径）
     * @param string $readerType (文件扩展名字)
     * @param string $ranges （形如 A2:Az，多个sheel使用逗号分割）
     * @return array
     * @throws Exception
     */
    public function writeExcel($dataList, $file, $readerType, $ranges)
    {
        $reader = IOFactory::createReader($readerType);
        $spreadsheet = $reader->load($file);
        $spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getDefaultStyle()->getFont()->setBold(false);
        $arrRange = explode(',', $ranges);

        $arr = [];
        foreach ($dataList as $i => $item) {
            $startCellValue = array_shift($item);
            foreach ($arrRange as $key => $range) {
                $cells = explode(':', $range);
                $startCell = $cells[0];
                $endCellChr = $cells[1];
                $endCellInt = intval($endCellChr);

                $arrStartCell = preg_split('/([A-Z]+)([0-9]+)/', $startCell, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
                $startCellChr = $arrStartCell[0];
                $startCellInt = $arrStartCell[1];

                $nextCellChr = chr(intval($startCellChr));
                $nextCellInt = $startCellInt + $i;
                $nextCell = $nextCellChr . $nextCellInt;

                $worksheet = $spreadsheet->getSheet($key);
                $worksheet->setCellValue($nextCell, $startCellValue)->getStyle($nextCell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $arr[$i][$key][$nextCell] = $startCellValue;

                $z = 0;
                foreach ($item as $j => $value) {
                    $prevCount = 0;
                    if ($key > 0) {
                        for ($m = 1; $m <= $key; $m++) {
                            $prevCount += count($arr[$i][$m - 1]);
                        }

                        if ($j < ($prevCount - $key)) {
                            continue;
                        }
                        $z = $j - $prevCount + $key;
                    } else {
                        $z = $j;
                    }
                    $cellChr = chr(intval($nextCellChr) + $z + 1);
                    $cell = $cellChr . '' . $nextCellInt;
                    if (intval($cellChr) <= $endCellInt) {
                        $pDataType = DataType::TYPE_STRING;
                        $worksheet->setCellValueExplicit($cell, $value, $pDataType)->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                        $arr[$i][$key][$cell] = $value;
                    }
                }
            }
        }
        unset($arr);
        $spreadsheet->setActiveSheetIndex(0);
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $outFilename = BASE_PATH . '/download/' . microtime(true) . '.xlsx';
        $writer->save($outFilename);

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        return $outFilename;
    }
}




