<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    CONST TYPE_CHANNEL = 'channel';
    CONST TYPE_SOURCE = 'source';
    CONST TYPE_CAMPAIGN_NAME = 'campaign_name';
    CONST TYPE_TARGET_URL = 'target_url';

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public static function getTypes(): array
    {
        return [
            self::TYPE_CHANNEL,
            self::TYPE_SOURCE,
            self::TYPE_CAMPAIGN_NAME,
            self::TYPE_TARGET_URL,
        ];
    }
}
