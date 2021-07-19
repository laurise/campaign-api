<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Input;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inputTypes = Input::getTypes();
        $faker = Factory::create();

        $limit = 100;
        for ($i = 0; $i < $limit; $i++) {
            $randomUser = DB::connection('mysql2')
                ->table('users')
                ->inRandomOrder()
                ->first();

            $campaign = new Campaign();
            $campaign->uuid = Uuid::uuid4();
            $campaign->user_id = $randomUser->id;
            $campaign->created_at = $faker->dateTime;
            $campaign->save();

            foreach ($inputTypes as $inputType) {
                $input = new Input();
                $input->campaign()->associate($campaign);
                $input->type = $inputType;
                $input->value = $inputType == Input::TYPE_TARGET_URL ? $faker->url : $faker->word;
                $input->save();
            }
        }
    }
}
