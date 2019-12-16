<?php

use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Отдел 1',
                'description' => 'Краткое описание функций Отдела 1',
                'logo' => 'uploads/M7O26QrWROT1KCjjFiDooZguiAU5aa1OiybSwMYL.jpeg'                
            ],
            [
                'name' => 'Отдел 2',
                'description' => 'Краткое описание функций Отдела 2',
                'logo' => 'uploads/WIm61rE7xLvbNUVXoDWUyFS8rXm5rLtAEixXifpn.jpeg'                
            ],
            [
                'name' => 'Отдел 3',
                'description' => 'Краткое описание функций Отдела 3',
                'logo' => 'uploads/ozgnfPUO6z3cCOn105pAdz7PDJb7eIUFynLhqDyq.jpeg'                
            ],
            [
                'name' => 'Отдел 4',
                'description' => 'Краткое описание функций Отдела 4',
                'logo' => 'uploads/1hWKaO731cKkXRpSfY9fcrlsREG6TZuKDTCGqmWW.jpeg'                
            ],
            [
                'name' => 'Отдел 5',
                'description' => 'Краткое описание функций Отдела 5',
                'logo' => 'uploads/IinocxOVIMr7fbAVefAr0GIXkzbFj5Gjwv0RVXKJ.jpeg'                
            ],
            [
                'name' => 'Отдел 6',
                'description' => 'Краткое описание функций Отдела 6',
                'logo' => 'uploads/LsxdhKNajkD9FL0oVPEm09AYeLooZaAikp2B8EDM.jpeg'                
            ],
            [
                'name' => 'Отдел 7',
                'description' => 'Краткое описание функций Отдела 7',
                'logo' => 'uploads/rDnQoTmuFWkjIadAEBiBKe9O9VrPT8pbSvc8jLpj.jpeg'                
            ],
            [
                'name' => 'Отдел 8',
                'description' => 'Краткое описание функций Отдела 8',
                'logo' => 'uploads/nXtud90E0t04WaaZC2JQ3AERnD6vhT8efnwJD2uQ.jpeg'                
            ],
            [
                'name' => 'Отдел 9',
                'description' => 'Краткое описание функций Отдела 9',
                'logo' => 'uploads/hBkrR7bTuWi10qP19UcNP23iVxXnTnh3WLoZXfkf.jpeg'                
            ],
            [
                'name' => 'Отдел 10',
                'description' => 'Краткое описание функций Отдела 10',
                'logo' => 'uploads/M7O26QrWROT1KCjjFiDooZguiAU5aa1OiybSwMYL.jpeg'                
            ],
            [
                'name' => 'Отдел 11',
                'description' => 'Краткое описание функций Отдела 11',
                'logo' => 'uploads/WIm61rE7xLvbNUVXoDWUyFS8rXm5rLtAEixXifpn.jpeg'                
            ],
            [
                'name' => 'Отдел 12',
                'description' => 'Краткое описание функций Отдела 12',
                'logo' => 'uploads/ozgnfPUO6z3cCOn105pAdz7PDJb7eIUFynLhqDyq.jpeg'                
            ],
            [
                'name' => 'Отдел 13',
                'description' => 'Краткое описание функций Отдела 13',
                'logo' => 'uploads/1hWKaO731cKkXRpSfY9fcrlsREG6TZuKDTCGqmWW.jpeg'                
            ],
            [
                'name' => 'Отдел 14',
                'description' => 'Краткое описание функций Отдела 14',
                'logo' => 'uploads/LsxdhKNajkD9FL0oVPEm09AYeLooZaAikp2B8EDM.jpeg'                
            ],
            [
                'name' => 'Отдел 15',
                'description' => 'Краткое описание функций Отдела 15',
                'logo' => 'uploads/nXtud90E0t04WaaZC2JQ3AERnD6vhT8efnwJD2uQ.jpeg'                
            ],

        ];
        
        \DB::table('sections')->insert($data);
    }
}
