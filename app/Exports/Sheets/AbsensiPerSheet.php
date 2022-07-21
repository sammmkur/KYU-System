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
        // dd($request);
      
        if($this->i == 1){
           
            return view('exports.absenlaki', [
                'data' => $request,
                'date' => $date,
                'periode' => $periode,
                
               
            ]);
        }
        else if($this->i == 2) {
            // dd($this->request);
            return view('exports.absenperempuan', [
                'data' => $request,
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