<?php


use Phinx\Seed\AbstractSeed;

class Categoria extends AbstractSeed
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
            ['categoria' => 'Roupas'],
            ['categoria' => 'Sapatos'],
            ['categoria' => 'Eletrodoméstico'],
            ['categoria' => 'Celulares']
        ];

        $categoria = $this->table('categoria');
        $categoria->insert($data)
                  ->saveData();
    }
}
