<?php

namespace WebModularity\LaravelProviders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('withProvider', function(Builder $builder) {
            $builder->with(['provider']);
        });
    }

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

    public function authIsActive()
    {
        return in_array($this->getSlug(), config('wm.auth.social.providers', []));
    }

    public function getSlug()
    {
        return $this->provider->slug;
    }
}