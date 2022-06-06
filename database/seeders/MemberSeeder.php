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
        $file = storage_path('app/public/master_member/MemberKYU.xlsx');
        $spreadsheet = IOFactory::load($file);

        $sheetCount = $spreadsheet->getSheetCount();

        for ($i = 0; $i < $sheetCount; $i++) {

            $gender = $i==0 ? 'L' : 'P';
            $city = 'Semarang';
            
            $sheet = $spreadsheet->getSheet($i);
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range(3, $row_limit);
            $column_range = range('A', $column_limit);
            $startcount = 2;
            
            foreach ($row_range as $row) {

                $complete_name = $sheet->getCell('A'.$row)->getValue();
                $name = $sheet->getCell('B'.$row)->getValue();
                $username = strtolower($name);
                $email = $sheet->getCell('C'.$row)->getValue();
                $place_of_birth = $sheet->getCell('D'.$row)->getValue();
                $dob = $sheet->getCell('G'.$row)->getValue().'-'.$sheet->getCell('F'.$row)->getValue().'-'.$sheet->getCell('E'.$row)->getValue();
                $password = $sheet->getCell('E'.$row)->getValue().$sheet->getCell('F'.$row)->getValue().$sheet->getCell('G'.$row)->getValue();
                $main_address = $sheet->getCell('H'.$row)->getValue();
                $living_address = $sheet->getCell('I'.$row)->getValue();
                $phone_number = $sheet->getCell('J'.$row)->getValue();
                $instagram = $sheet->getCell('K'.$row)->getValue();
                $work = $sheet->getCell('L'.$row)->getValue();
                $church_membership = $sheet->getCell('M'.$row)->getValue();

                $user = User::where('complete_name', $complete_name)->first();

                if(empty($user)){
                    User::create([
                        'complete_name' => $complete_name,
                        'name' => $name,
                        'email' => $email,
                        'gender' => $gender,
                        'city' => $city,
                        'place_birth' => $place_of_birth,
                        'date_of_birth' => $password,
                        'main_address' => $main_address,
                        'living_address' => $living_address,
                        'phone_number' => $phone_number,
                        'instagram' => $instagram,
                        'work' => $work,
                        'church_membership' => $church_membership,
                        'email' => $username,
                        'password' => $password
                    ]);
                }
            
            }
        }
    }
}
