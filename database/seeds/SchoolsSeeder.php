<?php

use Illuminate\Database\Seeder;

class SchoolsSeeder extends Seeder
{
    protected $schools = [
        [
            'name' => 'Ello',
            'webpage' => 'http://colegioello.com.br/',
            'config' => 'configs',
            'address' => [
                'street' => 'Largo do Soledade',
                'number' => 7,
                'city' => 'Salvador',
                'state' => 'BA',
                'postalcode' => '40325-090',
                'country' => 'Brasil',
            ],
            'status_id' => 1,
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->schools as $school) {
            $address = new \App\Address();
            $address->street = empty($school['address']['street']) ? null 
                : $school['address']['street'];
            $address->number = empty($school['address']['number']) ? null 
                : $school['address']['number'];
            $address->city = empty($school['address']['city']) ? null 
                : $school['address']['city'];
            $address->state = empty($school['address']['state']) ? null 
                : $school['address']['state'];
            $address->district = empty($school['address']['district']) ? null 
                : $school['address']['district'];
            $address->complement = empty($school['address']['complement']) ? null 
                : $school['address']['complement'];
            $address->postalcode = empty($school['address']['postalcode']) ? null 
                : $school['address']['postalcode'];
            $address->country = empty($school['address']['country']) ? null 
                : $school['address']['country'];
            $address->save();

            $School = new \App\School();
            $School->name = $school['name'];
            $School->webpage = $school['webpage'];
            $School->config = $school['config'];
            $School->address_id = $address->id;
            $School->status_id = 1;
            $School->save();
        }
    }
}
