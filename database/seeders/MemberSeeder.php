<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\User;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = storage_path('app/public/master_member/MemberKYUnew.xlsx');
        $spreadsheet = IOFactory::load($file);

        $sheetCount = $spreadsheet->getSheetCount();

        for ($i = 0; $i < $sheetCount; $i++) {

            $gender = $i==0 ? 'L' : 'P';
            $city = 'Semarang';
            
            $sheet = $spreadsheet->getSheet($i);
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range(2, $row_limit);
            $column_range = range('A', $column_limit);
            // $startcount = 2;
            
            foreach ($row_range as $row) {

                $complete_name = $sheet->getCell('A'.$row)->getValue();
                $name = $sheet->getCell('B'.$row)->getValue() ? $sheet->getCell('B'.$row)->getValue() : '-';
                $username = strtolower(strtok($name, " "));
                $place_of_birth = $sheet->getCell('D'.$row)->getValue() ? $sheet->getCell('D'.$row)->getValue() : '-';
                $email = $sheet->getCell('C'.$row)->getValue()? $sheet->getCell('C'.$row)->getValue() : $username.$place_of_birth.'@kyu.com';
                $monthname = $sheet->getCell('F'.$row)->getValue();
                
                switch ($monthname) {
                    case 'Januari':
                       $monthname = '01';
                        break;
                    
                    case 'Februari':
                        $monthname = '02';
                        break;
                    
                    case 'Maret':
                        $monthname = '03';
                        break;
                    
                    case 'April':
                        $monthname = '04';
                        break;
                    
                    case 'Mei':
                        $monthname = '05';
                        break;
                    
                    case 'Juni':
                        $monthname = '06';
                        break;
                    
                    case 'Juli':
                        $monthname = '07';
                        break;
                    
                    case 'Agustus':
                        $monthname = '08';
                        break;
                    
                    case 'September':
                        $monthname = '09';
                        break;
                    
                    case 'Oktober':
                        $monthname = '10';
                        break;

                    case 'November':
                        $monthname = '11';
                        break;
                    
                    case 'Desember':
                        $monthname = '12';
                        break;
                    
                    default:
                        $monthname = '01';
                        break;
                }
                $dob = $sheet->getCell('G'.$row)->getValue().'-'.$monthname.'-'.$sheet->getCell('E'.$row)->getValue();
                $password = $sheet->getCell('E'.$row)->getValue().$monthname.$sheet->getCell('G'.$row)->getValue();
              
                $main_address = $sheet->getCell('H'.$row)->getValue()? $sheet->getCell('H'.$row)->getValue() : '-';
                $living_address = $sheet->getCell('I'.$row)->getValue() ? $sheet->getCell('I'.$row)->getValue() : $main_address ? $main_address : '-';
                $phone_number = $sheet->getCell('J'.$row)->getValue();
                $instagram = $sheet->getCell('K'.$row)->getValue() ? $sheet->getCell('K'.$row)->getValue() : '-';
                $work = $sheet->getCell('L'.$row)->getValue()? $sheet->getCell('L'.$row)->getValue() : '-';
                $church_membership = $sheet->getCell('M'.$row)->getValue() ? $sheet->getCell('M'.$row)->getValue() : '-';
                $notelp = $sheet->getCell('J'.$row)->getValue();

                $user = User::where('complete_name', $complete_name)->first();
            
                if(empty($user)){
                    User::create([
                        'complete_name' => $complete_name,
                        'name' => $name,
                        'gender' => $gender,
                        'city' => $city,
                        'place_birth' => $place_of_birth,
                        'date_of_birth' => $dob,
                        'main_address' => $main_address,
                        'living_address' => $living_address,
                        'phone_number' => $phone_number,
                        'instagram' => $instagram,
                        'work' => $work,
                        'church_membership' => $church_membership,
                        'phone_number' => $notelp,
                        'email' => $email,
                        'password' => bcrypt($password)
                    ]);
                }else{
                    $user->update([
                        'complete_name' => $complete_name,
                        'name' => $name,
                        // 'email' => $email,
                    ]);
                }
            
            }
        }
    }
}
