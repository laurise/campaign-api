<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Models\Input;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class CampaignController extends Controller
{
    private $perPage = 20;

    public function index(Request $request)
    {
        $campaigns = Campaign::with('inputs');

        $perPage = $request->get('perPage') ?? $this->perPage;
        $sort = $request->get('sort');
        $sortBy = $request->get('sortBy');

        if (in_array($sortBy, Input::getTypes())) {
            $campaigns = $this->orderByInput($campaigns, $sortBy, $this->getSortDirection($sort));
        } else if ($sort) {
            $campaigns->orderBy('created_at', $this->getSortDirection($sort));
        }

        return CampaignResource::collection($campaigns->paginate($perPage));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'author_id' => 'required|exists:mysql2.users,id',
            'channel' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'campaign_name' => 'required|string|max:255',
            'target_url' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['errors' => $validator->errors()], 422);
        }

        DB::transaction(function () use ($request) {
            $campaign = new Campaign();
            $campaign->uuid = Uuid::uuid4();
            $campaign->user_id = $request->get('author_id');
            $campaign->save();

            $inputs = [
                Input::TYPE_CHANNEL => $request->get('channel'),
                Input::TYPE_SOURCE => $request->get('source'),
                Input::TYPE_CAMPAIGN_NAME => $request->get('campaign_name'),
                Input::TYPE_TARGET_URL => $request->get('target_url'),
            ];

            foreach ($inputs as $inputType => $inputValue) {
                $input = new Input();
                $input->campaign()->associate($campaign->id);
                $input->type = $inputType;
                $input->value = $inputValue;
                $input->save();
            }
        });

        return response()
            ->json(['created' => true], 201);
    }

    private function orderByInput(Builder $campaigns, string $inputType, string $sortDirection): Builder
    {
        return $campaigns
            ->join('inputs', 'inputs.campaign_id', '=', 'campaigns.id')
            ->where('inputs.type', $inputType)
            ->orderBy('inputs.value', $sortDirection)
            ->select('campaigns.*');
    }

    private function getSortDirection($sort): string
    {
        return $sort == 'desc' ? 'desc' : 'asc';
    }
}
