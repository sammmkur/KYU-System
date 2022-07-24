<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Exports\Sheets\AbsensiPerSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;

class UsersExport implements WithMultipleSheets, FromArray, ShouldAutoSize, WithPreCalculateFormulas
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
        $data = [];
     

        for($j=1;$j<=2;$j++){
            if($j==1){
                foreach($this->request as $date => $genders){
                    if(!empty($genders)){
                        $data['L'][$date] = $genders['L'];
                    }  
                }
               
            }else{
                foreach($this->request as $date => $genders){
                    if(!empty($genders)){
                        $data['P'][$date] = $genders['P'];
                    }  
                }
            }

            $sheets[] = new AbsensiPerSheet($j,$data, $this->date, $this->periode);
              
        }

        return $sheets;
    }
   
}
