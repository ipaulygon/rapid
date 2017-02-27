<?php

use Illuminate\Database\Seeder;

class TechSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = array (
            array(
            	'tsTechId' => 'TECH0001',
            	'tsSkillId' => 'SERV0001',
            	'tsIsActive' => 1,
            ),
            array(
            	'tsTechId' => 'TECH0001',
            	'tsSkillId' => 'SERV0002',
            	'tsIsActive' => 1,
            ),
        );
        DB::table('tech_skill')->insert($skills);
    }
}
