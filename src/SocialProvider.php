<?php

namespace WebModularity\LaravelProviders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * WebModularity\LaravelProviders\SocialProvider
 *
 * @property int $id
 * @property int $provider_id
 * @property string $url
 * @property-read \WebModularity\LaravelProviders\Provider $provider
 */

class SocialProvider extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('withProvider', function (Builder $builder) {
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
        return in_array($this->getSlug(), config('wm.user.social.providers', []));
    }

    public function getSlug()
    {
        return $this->provider->slug;
    }

    /**
     * Get a more accurate first and last name from some social providers.
     * @param $socialUser
     * @return array|null [] keyed by firstName, lastName
     */

    public function getPersonNameFromSocialUser($socialUser)
    {
        // Extract person name based on SocialProvider
        if ($this->getSlug() == 'google') {
            return [
                'firstName' => $socialUser->user['name']['givenName'],
                'lastName' => $socialUser->user['name']['familyName']
            ];
        }

        return null;
    }
}
