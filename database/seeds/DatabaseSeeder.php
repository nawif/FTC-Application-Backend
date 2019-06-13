<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();
        $this->generateUsers();
        $this->generateEvents();
        $this->generateTasks();
    }

    public function createAdmin()
    {
        $faker = Faker::create();
	        DB::table('users')->insert([
	            'first_name' => "نواف",
                'last_name' => "القعيد",
	            'is_admin' => "1",
	            'student_id' => "436105865",
	            'email' => $faker->email,
	            'phone' => "0568484248",
	            'device_id' => $faker->domainName,
	            'bio' => $faker->paragraph,
	            'password' => Hash::make("12345"),
	        ]);
    }

    public function generateUsers($num = 10)
    {
        $faker = Faker::create();
        $password = '12345';
        foreach (range(1,$num) as $index) {
	        DB::table('users')->insert([
	            'first_name' => $faker->firstName,
	            'last_name' => $faker->lastName,
	            'student_id' => $faker->numberBetween(436100000,436109999),
	            'email' => $faker->email,
	            'phone' => $faker->phoneNumber,
	            'device_id' => $faker->domainName,
	            'bio' => $faker->paragraph,
	            'password' => Hash::make($password),
	        ]);
        }
    }

    public function generateEvents($num = 10)
    {
        $faker = Faker::create();
        foreach (range(1,$num) as $index) {
	        DB::table('events')->insert([
	            'name' => $faker->catchPhrase,
	            'whatsapp_link' => $faker->domainName,
	            'leader_id' => $faker->numberBetween(1,5),
	            'user_limit' => $faker->numberBetween(3,10),
	            'date' => $faker->date,
	            'type' => "ORGANIZE",
	            'description' => $faker->paragraph,
	        ]);
        }
    }

    public function generateTasks($num = 20)
    {
        $faker = Faker::create();
        foreach (range(1,$num) as $index) {
            $event_id = $faker->numberBetween(1,10);
            $user_id = $faker->numberBetween(1,10);
	        DB::table('tasks')->insert([
	            'description' => $faker->paragraph,
	            'user_id' => $user_id ,
	            'event_id' => $event_id ,
	            'is_approved' => $faker->numberBetween(0,1),
            ]);

            DB::table('users_events')->insert([
	            'user_id' => $user_id ,
	            'event_id' => $event_id ,
            ]);

        }
    }
}
