<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AbsensiRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Absensi;
use DatePeriod;
use DateTime;
use DateInterval;
use DB;
/**
 * Class AbsensiCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AbsensiCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation{
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation{
        update as traitUpdate;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Absensi::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/absensi');
        CRUD::setEntityNameStrings('absensi', 'absensi');
        CRUD::addButtonFromView('top', 'modal_download', 'modal_download', 'beginning');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name'         => 'user', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'Nama', // Table column heading
             // OPTIONAL
            'entity'    => 'user', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => App\Models\User::class, // foreign key model
        ]);
        $this->crud->addColumn([
            'name'         => 'user_absen', // name of relationship method in the model
            'type'         => 'closure',
            'label'        => 'Kehadiran', // Table column heading
            'function' => function($entry) {
                $entry->user_absen==True ? $absen_status =  'Hadir' : $absen_status =  'Tidak Hadir';
                return $absen_status;
            }
        ]);
        $this->crud->addColumn([
            'type' => 'date',
            'name' => 'created_at',
            'label' => 'Tanggal Absen',
        ]);
        // $this->crud->addClause('whereDate', 'created_at', '=', Carbon::today());

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AbsensiRequest::class);

        CRUD::addField([
            'label'     => "Anak KYU",
            'type'      => 'select2',
            'name'      => 'user_id', // the db column for the foreign key

            // optional
            // 'entity' should point to the method that defines the relationship in your Model
            // defining entity will make Backpack guess 'model' and 'attribute'
            'entity'    => 'user',

            // optional - manually specify the related model and attribute
            'model'     => "App\Models\User", // related model
            'attribute' => 'complete_name', // foreign key attribute that is shown to user
        ]); 

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    public function getSaturdays($y, $m)
    {
        return new DatePeriod(
            new DateTime("first saturday of $y-$m"),
            DateInterval::createFromDateString('next saturday'),
            new DateTime("last day of $y-$m")
        );
    }
    
    public function download(Request $request){

        $data = [];
        $date = [];
        $periode = [];
        $year = $request->period;
        $month = $request->month;
    //   $absen_data = Absensi::with('user')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->orderBy('name')->get();
        // $absen_data = Absensi::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get()->sortBy(function($query){
        //     return $query->user->complete_name;
        // })->unique();

        $absen_data = Absensi::whereYear('absensi.created_at', '=', $year)
                        ->whereMonth('absensi.created_at', '=', $month)
                        ->orderBy('name')
                        ->join('users', 'users.id', '=', 'absensi.user_id')
                        ->select('users.complete_name','users.name','users.gender', 'absensi.*')
                        ->orderBy('users.complete_name')
                        ->get()
                        ->groupBy(function($item) {
                            return $item->created_at->format('d-m-y');
                       });
                       
        // dd($absen_data);
        if(!$absen_data->isEmpty()){
            foreach($absen_data as $absensi_date=>$absen){
                    if(!array_key_exists($absensi_date, $data)){
                        $data[$absensi_date] = [];
                    }

                    $absen_gender = $absen->groupBy('gender');
                   
                    foreach($absen_gender as $gender=>$values){
                        
                        if(!array_key_exists($gender, $data)){
                            $data[$absensi_date][$gender] = [];
                        }
                        foreach($values as $value){
    
                            $data[$absensi_date][$gender][$value->user_id] = [
                                'complete_name' => $value->complete_name,
                                'short_name' => $value->name,
                                'gender' => $value->gender,
                                'absent_date' => Carbon::parse($value->created_at)->format('d-m-y'),
                            ];
                            
        
                            
                        }
                        
                    }
                   
            }
        }
       
        foreach ($this->getSaturdays($year, $month) as $saturday){
                array_push($date,$saturday->format("d-m-y"));
        }
       
        $month_name = date("F", mktime(0, 0, 0, $month, 10));
        $periode = [
            $month_name,
            $year,
        ];
        
       
        return Excel::download(new UsersExport($data, $date, $periode), 'absensi.xlsx');
    }
}
