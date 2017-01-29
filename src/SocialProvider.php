<?php

namespace WebModularity\LaravelProviders;

use Illuminate\Database\Eloquent\Model;
use WebModularity\LaravelProviders\Provider;
use WebModularity\LaravelProviders\Scopes\ProviderScope;

class SocialProvider extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'common.social_providers';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getUrlAttribute($value)
    {
        return Provider::urlReplace($this->provider->name, $value);
    }

    /**
     * Get the associated Provider record.
     */
    public function provider()
    {
        return $this->belongsTo('WebModularity\LaravelProviders\Provider');
    }

    public static function isActiveSocialAuth($slug)
    {
        return in_array($slug, config('wm.auth.social.providers', []));
    }

    /**
     * @param $slug
     * @return mixed
     */
    public static function findFromSlug($slug)
    {
        if (static::isActiveSocialAuth($slug)) {
            return static::whereHas('provider', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->first();
        }

        return null;
    }
}