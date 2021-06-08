<?php

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    protected $services = [
        [
            'id' => 1,
            'name' => 'Multidiciplinar',
            'fee' => 30,
            'wage' => 80,
        ],
        [
            'id' => 2,
            'name' => 'Matemática',
            'fee' => 30,
            'wage' => 80,
        ],
        [
            'id' => 3,
            'name' => 'Português',
            'fee' => 30,
            'wage' => 80,
        ],
        [
            'id' => 4,
            'name' => 'História',
            'fee' => 30,
            'wage' => 80,
        ],
        [
            'id' => 5,
            'name' => 'Geografia',
            'fee' => 30,
            'wage' => 80,
        ],
        [
            'id' => 6,
            'name' => 'Física',
            'fee' => 30,
            'wage' => 80,
        ],
        [
            'id' => 7,
            'name' => 'Química',
            'fee' => 30,
            'wage' => 80,
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->services as $fields) {
            $service = new \App\Service();
            $service->id = $fields['id'];
            $service->name = $fields['name'];
            $service->fee = $fields['fee'];
            $service->wage = $fields['wage'];
            $service->save();
        }
    }
}
