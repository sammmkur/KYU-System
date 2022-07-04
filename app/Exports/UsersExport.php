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
    }
    public function array(): array
    {
        return $this->request;
    }
    
    
    public function sheets(): array
    {  
        $sheets = [];
        
        $j=1;

        foreach($this->request as $key => $value){
          
                    $sheets[] = new AbsensiPerSheet($j,$value, $this->date, $this->periode);
              
            $j++;
        }

        return $sheets;
    }
   
}
