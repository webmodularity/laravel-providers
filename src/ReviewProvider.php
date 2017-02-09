<?php

namespace WebModularity\LaravelProviders;

use Illuminate\Database\Eloquent\Model;

/**
 * WebModularity\LaravelProviders\ReviewProvider
 *
 * @property int $id
 * @property int $provider_id
 * @property string $url
 * @property string $url_review
 * @property string $url_review_user
 * @property-read \WebModularity\LaravelProviders\Provider $provider
 */

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

    public function getUrlAttribute($value)
    {
        return Provider::urlReplace($this->provider->slug, $value);
    }

    public function getUrlReviewAttribute($value)
    {
        return Provider::urlReplace($this->provider->slug, $value);
    }

    public function getUrlReviewUserAttribute($value)
    {
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
