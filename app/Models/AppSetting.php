<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class AppSetting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];

    public const DEFAULTS = [
        'system_name' => 'FurMend Appointment System',
        'system_tagline' => 'Compassionate scheduling and service tracking for every patient visit.',
        'support_email' => 'support@furmend.local',
        'clinic_phone' => '(555) 010-2026',
        'clinic_address' => '123 Care Avenue, Manila',
        'business_hours' => 'Mon - Sat, 8:00 AM - 6:00 PM',
    ];

    public static function defaults(): array
    {
        return self::DEFAULTS;
    }

    public static function allAsMap(): array
    {
        try {
            if (! Schema::hasTable('settings')) {
                return self::defaults();
            }
        } catch (\Throwable) {
            return self::defaults();
        }

        $stored = Cache::rememberForever('settings.map', static function (): array {
            return static::query()->pluck('value', 'key')->all();
        });

        return array_replace(self::defaults(), $stored);
    }

    public static function updateFromArray(array $settings): void
    {
        foreach ($settings as $key => $value) {
            static::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Cache::forget('settings.map');
    }
}
