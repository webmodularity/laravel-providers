<?php

namespace WebModularity\LaravelProviders;

use Illuminate\Database\Eloquent\Model;
use SKAgarwal\GoogleApi\PlacesApi;
use SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException;
use Stevenmaguire\Yelp\Client as YelpClient;
use Log;

/**
 * WebModularity\LaravelProviders\Provider
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $url_home
 */

class Provider extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'common.providers';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function urlReplace($sourceSlug, $url)
    {
        return str_replace(
            array_keys(static::getUrlReplaceConfig($sourceSlug)),
            static::getUrlReplaceConfig($sourceSlug),
            $url
        );
    }

    public static function getUrlReplaceConfig($sourceSlug)
    {
        $configData = config('wm.providers.' . $sourceSlug, []);
        $parsed = [];
        foreach ($configData as $key => $data) {
            if (is_array($data)) {
                foreach ($data as $nestedKey => $nestedData) {
                    $fullKey = $key . '.' . $nestedKey;
                    $parsed['{' . $fullKey . '}'] = $nestedData;
                }
            } else {
                $parsed['{' . $key . '}'] = $data;
            }
        }
        return $parsed;
    }

    public static function getConfiguredProviderSlugs()
    {
        $configuredProviders = [];
        $allProviders = config('wm.providers', []);
        foreach ($allProviders as $providerKey => $providerData) {
            if (isset($providerData['id']) && !empty($providerData['id'])) {
                $configuredProviders[] = $providerKey;
            }
        }
        return $configuredProviders;
    }

    public static function getDataFromGoogle()
    {
        $apiKey = config('services.google.key');
        $placeId = config('wm.providers.google.place.id');
        $googlePlaces = new PlacesApi($apiKey);
        $response = null;
        try {
            $response = $googlePlaces->placeDetails($placeId);
        } catch (GooglePlacesApiException $e) {
            Log::critical('GooglePlaces: ' . $e->getMessage(), [
                'api_key' => $apiKey,
                'place_id' => $placeId
            ]);
        }
        return $response;
    }

    public static function getDataFromYelp()
    {
        $client = new YelpClient([
            'consumerKey' => config('services.yelp.consumerKey'),
            'consumerSecret' => config('services.yelp.consumerSecret'),
            'token' => config('services.yelp.token'),
            'tokenSecret' => config('services.yelp.tokenSecret')
        ]);
        return collect($client->getBusiness(config('wm.providers.yelp.id')));
    }
}
