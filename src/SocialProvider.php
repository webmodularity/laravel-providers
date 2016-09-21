<?php

namespace WebModularity\LaravelProviders;

use Illuminate\Database\Eloquent\Model;
use WebModularity\LaravelProviders\Provider;
use Log;
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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ProviderScope);
    }

    public function getUrlAttribute($value)
    {
        return Provider::urlReplace($this->provider->name, $value);
    }
}