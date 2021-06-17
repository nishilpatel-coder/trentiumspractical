<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class cities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$cities = array(
			array('name' => "Bombuflat"),
			array('name' => "Garacharma"),
			array('name' => "Port Blair"),
			array('name' => "Rangat"),
			array('name' => "Addanki"),
			array('name' => "Adivivaram"),
			array('name' => "Adoni"),
			array('name' => "Aganampudi"),
			array('name' => "Ajjaram"),
			array('name' => "Akividu"),
			array('name' => "Akkarampalle"),
			array('name' => "Akkayapalle"),
			array('name' => "Akkireddipalem"),
			array('name' => "Alampur"),
			array('name' => "Amalapuram"),
			array('name' => "Amudalavalasa")
		);
		DB::table('cities')->insert($cities);
    }
}
