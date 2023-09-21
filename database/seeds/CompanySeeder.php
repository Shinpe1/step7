<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            ['products_id' => 1, 'company_name' => 'コカコーラ'],
            ['products_id' => 2, 'company_name' => 'サントリー']
        ];
        DB::table('companies')->insert($companies);
}

}