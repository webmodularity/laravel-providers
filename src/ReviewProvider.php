<?php

namespace WebModularity\LaravelProviders;

use Illuminate\Database\Eloquent\Model;
use WebModularity\LaravelProviders\Provider;
use SKAgarwal\GoogleApi\PlacesApi;
use SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException;
use Stevenmaguire\Yelp\Client as YelpClient;
use Log;
use WebModularity\LaravelProviders\Scopes\ProviderScope;

class ReviewProvider extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'common.review_providers';

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

    public function getUrlAttribute($value) {
        return Provider::urlReplace($this->provider->slug, $value);
    }

    public function getUrlReviewAttribute($value) {
        return Provider::urlReplace($this->provider->slug, $value);
    }

    public function getUrlReviewUserAttribute($value) {
        return Provider::urlReplace($this->provider->slug, $value);
    }

    /**
     * Get the associated Provider record.
     */
    public function provider()
    {
        return $this->belongsTo('WebModularity\LaravelProviders\Provider');
    }
}
