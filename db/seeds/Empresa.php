<?php


use Phinx\Seed\AbstractSeed;

class Empresa extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [
            ['empresa' => '775','4499550608'],
            ['empresa' => 'Samsung','4430303366'],
            ['empresa' => 'PHILIPS','1120325569'],
            ['empresa' => 'Nike', '2130237800'],
        ];

        $empresa = $this->table('empresa');
        $empresa->insert($data)
                ->saveData();
    }
}
