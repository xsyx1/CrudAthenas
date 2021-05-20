<?php

use App\Person;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $person = Person::create([
            'type' => 2,
            'name' => 'Matheus',
            'email' => 'mths@mths.com',
            'nickname' => 'Matheus',
            'nif' => '04496906000108',
            'phone' => '6332155400',
            'address' => 'Quadra 203 norte, Al. Oscar Niemeyer, QI - 02, HM - 06, Lt. 02',
            'zip_code' => '77016-524',
            'city_id' => '443'
        ]);

        $user = User::create([
            'person_id' => $person->id,
            'email' => 'mths@mths.com',
            'phone' => '6332155400',
            'password' => bcrypt('1234567o')
        ]);

        $user->assignRole('super_administrador');

        // Exibe uma informação no console durante o processo de seed
        $this->command->info('User '.$user->name.' created');

    }
}
