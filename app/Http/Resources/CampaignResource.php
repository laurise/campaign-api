<?php

namespace App\Http\Resources;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userRepository = app(UserRepositoryInterface::class);
        $author = $userRepository->findById($this->user_id);

        $campaign = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'author' => [
                'id' => $author->id,
                'name' => $author->name,
                'email' => $author->email,
                'created_at' => $author->created_at,
                'updated_at' => $author->updated_at,
            ],
        ];

        foreach ($this->inputs as $input) {
            $campaign['inputs'][$input->type] = $input->value;
        }

        return $campaign;
    }
}
