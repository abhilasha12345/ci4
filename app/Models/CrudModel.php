<?php

namespace App\Models;

use CodeIgniter\Model;

class CrudModel extends Model
{
	protected $table = 'user_table';

	protected $primaryKey = 'id';

	protected $allowedFields = ['first_name','last_name','name', 'email', 'dob','gender','profile_pic','address','created_at','updated_at'];

}

?>
