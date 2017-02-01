<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = array (
            array(
				'name' => 'admin',
				'email' => 'admin',
				'password' => bcrypt('admin'),
                'role' => 1,
            ),
        );
        DB::table('users')->insert($user);
    }
}
