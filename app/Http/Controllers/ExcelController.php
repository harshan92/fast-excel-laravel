<?php

namespace App\Http\Controllers;

use App\Models\TblGl;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\Request;
use OpenSpout\Common\Entity\Style\Style;
class ExcelController extends Controller
{
    public function to_excel()
    {

        $header_style = (new Style())->setFontBold();

        $rows_style = (new Style())
            ->setFontSize(15)
            ->setShouldWrapText()
            ->setBackgroundColor("EDEDED");
        $gls=TblGl::limit(10000)->get();
        return (new FastExcel($gls))->headerStyle($header_style)->download('file.xlsx',function ($gl) {
            $dr="";
            if($gl->Dr!=0){
                $dr=number_format($gl->Dr,2,'.',',');
            }
            return [
                'ID' => $gl->ID,
                'Description' => $gl->Description,
                'Dr' => $dr,
                
            ];
        });
    }
}
