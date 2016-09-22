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

    /**
     * Scope a query to join providers with an alias of PROVIDER
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Builder instance
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeJoinProvider($query)
    {
        return $query->select('social_providers.*', 'providers.name AS provider.name', 'providers.slug AS provider.slug')->leftJoin('common.providers AS providers', 'providers.id', '=', 'common.social_providers.provider_id');
    }

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
}