<?php
namespace App\Exports\Sheets;

use DB;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Carbon\Carbon;

class AbsensiPerSheet implements  WithTitle, FromView, ShouldAutoSize, WithPreCalculateFormulas
{
    private $i;
    private $request;

    public function __construct(int $i, array $request, array $date, array $periode)
    {
        $this->i = $i;
        $this->request = $request;
        $this->date = $date;
        $this->periode = $periode;
    }
   

    /**
     * @return Builder
     */
    
    public function view(): View
    {
       
       
        $request = $this->request;
        $date = $this->date;
        $periode = $this->periode;
        $data=[];
        $absen_date=[];
      
        if($this->i == 1){
            foreach($request['L'] as $key=>$value){
                foreach($value as $id =>$value_id){
                   
                    if(!array_key_exists($id, $data)){
                        $data[$id] = [];
                        $absen_date[$id] = [];
                    }
                    array_push($absen_date[$id],$value_id['absent_date']);
                
                    $data[$id]=[
                        'complete' => $value_id['complete_name'],
                        'short_name' => $value_id['short_name'],
                        'gender' => $value_id['gender'],
                        'absent_date' => $absen_date[$id],
                    ];
                    
                }
               
            }
            return view('exports.absenlaki', [
                'data' => $data,
                'date' => $date,
                'periode' => $periode,
                
               
            ]);
        }
        else if($this->i == 2) {
            foreach($request['P'] as $key=>$value){
                foreach($value as $id =>$value_id){
                   
                    if(!array_key_exists($id, $data)){
                        $data[$id] = [];
                        $absen_date[$id] = [];
                    }
                    array_push($absen_date[$id],$value_id['absent_date']);
                
                    $data[$id]=[
                        'complete' => $value_id['complete_name'],
                        'short_name' => $value_id['short_name'],
                        'gender' => $value_id['gender'],
                        'absent_date' => $absen_date[$id],
                    ];
                    
                }
               
            }
            return view('exports.absenperempuan', [
                'data' => $data,
                'date' => $date,
                'periode' => $periode,
               
            ]);
        }else{
            return view('exports.absenlaki', [
                'data' => $request,
                'date' => $date,
                'periode' => $periode,
                
               
            ]);
        }
    }

    public function title(): string
    {
        if($this->i==1){
            return '(L) 2022';
        }else {
            return '(P) 2022';
        }
    }
}