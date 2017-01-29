<?php

namespace WebModularity\LaravelProviders;

use Illuminate\Database\Eloquent\Model;

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

    public function getSlugAttribute($value)
    {
        return $this->provider->slug;
    }

    /**
     * Get the associated Provider record.
     */
    public function provider()
    {
        return $this->belongsTo('WebModularity\LaravelProviders\Provider');
    }

    /**
     * @param string $slug
     * @return bool
     */

    public static function isActiveSocialAuth($slug)
    {
        return in_array($slug, config('wm.auth.social.providers', []));
    }

}