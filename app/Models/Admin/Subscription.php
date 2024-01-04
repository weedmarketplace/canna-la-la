<?php
namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\ExcelSheet\ExcelSheet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Auth;


class Subscription extends Model{
    use HasFactory;
    const MIN_DURATION = 1;

    public function export(){
        $query = DB::table('subscription');
        $query->select('*');
        $data = $query->get();

        $writer = SimpleExcelWriter::streamDownload('subscription.xlsx');
        
        $writer->addRow(['id','email','created_at']);  

        foreach ($data as $row) {
            $writer->addRow([
                $row->id,
                $row->email,
                $row->created_at,
            ]);
        }
        
        $writer->toBrowser();
        // Create the Excel writer and add the first sheet
        // $stream = $writer->getWriter();

        // $nameSheet = $stream->getCurrentSheet();
        // $nameSheet->setName('Subscription');

        // foreach ($data as $test) {
            
        //     $item = [$test->id,$test->email,$test->created_at];
        //     $row = Row::fromValues($item);
        //     $writer->addRow($row);
        // }
    }
}