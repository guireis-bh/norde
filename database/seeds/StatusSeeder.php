<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    protected $status = [
        [
            'id' => 1,
            'slug' => 'active',
            'label' => 'Ativo'
        ],
        [
            'id' => 2,
            'slug' => 'inative',
            'label' => 'Inativo'
        ],
        [
            'id' => 3,
            'slug' => 'prospective',
            'label' => 'Prospectivo'
        ],
        [
            'id' => 4,
            'slug' => 'archived',
            'label' => 'Arquivado'
        ],
        [
            'id' => 5,
            'slug' => 'removed',
            'label' => 'Removido'
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->status as $fields) {
            $status = new \App\Status();
            $status->id = $fields['id'];
            $status->slug = $fields['slug'];
            $status->label = $fields['label'];
            $status->save();
        } 
    }
}
