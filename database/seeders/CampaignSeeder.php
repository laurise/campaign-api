<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Input;
use App\Repositories\UserRepositoryInterface;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CampaignSeeder extends Seeder
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $inputTypes = Input::getTypes();

        $limit = 100;
        for ($i = 0; $i < $limit; $i++) {
            DB::transaction(function () use ($faker, $inputTypes) {
                $randomAuthor = $this->userRepository->random();

                $campaign = new Campaign();
                $campaign->uuid = Uuid::uuid4();
                $campaign->user_id = $randomAuthor['id'];
                $campaign->created_at = $faker->dateTime;
                $campaign->save();

                foreach ($inputTypes as $inputType) {
                    $input = new Input();
                    $input->campaign()->associate($campaign);
                    $input->type = $inputType;
                    $input->value = $inputType == Input::TYPE_TARGET_URL ? $faker->url : $faker->word;
                    $input->save();
                }
            });
        }
    }
}
