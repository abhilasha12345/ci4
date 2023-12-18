<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\EmployeeModel;
use Faker\Factory;

class EmployeeSeeder extends Seeder
{
	public function run()
	{
		$data = [];

		for($count = 0; $count < 50; $count++)
		{
			$data[] = $this->generate_data();
		}

		$employee_object = new EmployeeModel();

		$employee_object->insertBatch($data);
	}

	function generate_data()
	{
		$faker = Factory::create();

		return [
			"employee_name"		=>	$faker->name(),
			"employee_mobile"	=>	$faker->phoneNumber,
			"employee_email"	=>	$faker->email,
			"employee_department" 	=> $faker->randomElement(["Finance","Marketing","Production","Inventory"])
		];
	}
}