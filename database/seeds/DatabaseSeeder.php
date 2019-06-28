<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{

    protected $numOfUsers = 60;


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();
        $this->generateUsers($this->numOfUsers);
        $this->generateEvents();
        $this->generateTasks();
        $this->generatePoints();
        $this->generateSocialMediaAccounts();
    }

    public function createAdmin()
    {
        $faker = Faker::create('ar_SA');
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
                'profilephoto' => 'data:image/jpeg;base64,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'
            ]);
            DB::table('total_points')->insert([
                'user_id' => 1,
	            'value' => $faker->numberBetween(0,2000),
            ]);
    }

    public function generateUsers($num = 11)
    {
        $faker = Faker::create('ar_SA');
        $password = '12345';
        foreach (range(2,$num) as $index) {
	        DB::table('users')->insert([
                'id' => $index,
	            'first_name' => $faker->firstName,
	            'last_name' => $faker->lastName,
	            'student_id' => $faker->numberBetween(436100000,436109999),
	            'email' => $faker->email,
	            'phone' => $faker->phoneNumber,
	            'device_id' => $faker->domainName,
	            'bio' => $faker->realText(100),
                'password' => Hash::make($password),
                'profilephoto' => 'data:image/jpeg;base64,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'
            ]);
            DB::table('total_points')->insert([
                'user_id' => $index,
	            'value' => $faker->numberBetween(0,2000),
            ]);

        }
    }

    public function generateEvents($num = 10)
    {
        $faker = Faker::create('ar_SA');
        foreach (range(1,$num) as $index) {
	        DB::table('events')->insert([
	            'name' => $faker->catchPhrase,
	            'whatsapp_link' => $faker->domainName,
	            'leader_id' => $faker->numberBetween(1,5),
	            'user_limit' => $faker->numberBetween(3,10),
	            'date' => $faker->date,
	            'type' => "ORGANIZE",
	            'description' => $faker->realText(255),
	        ]);
        }
    }

    public function generateTasks($avrPerUser = 50)
    {
        $startDate = Carbon::now()->subWeeks(15);
        $faker = Faker::create('ar_SA');
        foreach (range(1,$avrPerUser*$this->numOfUsers) as $index) {
            $event_id = $faker->numberBetween(1,10);
            $user_id = $faker->numberBetween(1, $this->numOfUsers);
	        DB::table('tasks')->insert([
	            'description' => $faker->realText(100),
	            'user_id' => $user_id ,
	            'event_id' => $event_id ,
	            'is_approved' => $faker->numberBetween(0,1),
	            'created_at' => $faker->dateTimeBetween($startDate),
            ]);

            DB::table('users_events')->insert([
	            'user_id' => $user_id ,
	            'event_id' => $event_id ,
            ]);

        }
    }

    public function generatePoints($avrPerUser = 50)
    {
        $startDate = Carbon::now()->subWeeks(3);
        $faker = Faker::create('ar_SA');
        foreach (range(1,$avrPerUser * $this->numOfUsers) as $index) {
	        DB::table('points')->insert([
	            'value' => $faker->numberBetween(1,99),
	            'approved_by_admin_id' => 1 ,
	            'task_id' => $index,
                'user_id' => $faker->numberBetween(2,$this->numOfUsers),
                'updated_at' => $faker->dateTimeBetween($startDate)
            ]);

        }
    }
    public function generateSocialMediaAccounts()
    {
        $faker = Faker::create();
        $socialMediaPlatforms = ['twitter', 'steam', 'whatsapp', 'linkedin', 'snapchat'];
        foreach (range(1,$this->numOfUsers) as $index) {
        for ($i=0; ($i < sizeof($socialMediaPlatforms)) && $i<$faker->numberBetween(0, sizeof($socialMediaPlatforms)) ; $i++) {
            DB::table('socialmedia_accounts')->insert([
	            'platform' => $socialMediaPlatforms[$i],
	            'username' => $faker->userName() ,
                'user_id' => $index,
            ]);
        }
        }
    }
}
