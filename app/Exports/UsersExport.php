<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Exports\Sheets\AbsensiPerSheet;

class UsersExport implements WithMultipleSheets, FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    public function __construct(array $data, array $date, array $periode)
    {
        $this->request = $data;
        $this->date = $date;
        $this->periode = $periode;
        // dd($this->request);
    }
    public function array(): array
    {
        return $this->request;
    }
    
    
    public function sheets(): array
    {  
       
        // dd($this->date, $this->request);
        $sheets = [];
        
        $j=1;

        foreach($this->request as $key => $value){
            // foreach($value as $key2 => $value2){
                // if($j==2){

                    // dd($key);
                    $sheets[] = new AbsensiPerSheet($j,$value, $this->date, $this->periode);
                // }
                // $sheets[] = new ControlPointPerSheet($j, $value, $this->request[1]);
                // dd($sheets);
            // }
            // dd(count($value));
        // for ($i=1; $i <= count($this->request) ; $i++) { 
            // foreach($value as $id=>$data_sheet){
                // dd($key);
                // array_key_exist
                // if($key == 'L'){
                    // $j=1;
                    // $sheets[] = new AbsensiPerSheet($j, $value);
                    // $j++;
                // }
                // }else{
                //     $j=2;
                //     $sheets[] = new AbsensiPerSheet($j, $data_sheet);
                //     // $j++;
                // }
                // $sheets[] = new AbsensiPerSheet($j, $this->request[$key]);
            // }
            $j++;
        }
        // dd($j);

        return $sheets;
    }
    // public function view(): View
    // {
    //     return view('exports.invoices', [
    //         'invoices' => Invoice::all()
    //     ]);
    // }
}
