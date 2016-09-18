<?php

namespace WebModularity\LaravelProviders;

use Illuminate\Database\Eloquent\Model;
use SKAgarwal\GoogleApi\PlacesApi;
use SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException;
use Stevenmaguire\Yelp\Client as YelpClient;
use Log;

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

    public static function urlReplace($sourceSlug, $url) {
        return str_replace(array_keys(static::getUrlReplaceConfig($sourceSlug)), static::getUrlReplaceConfig($sourceSlug), $url);
    }

    public static function getUrlReplaceConfig($sourceSlug) {
        $configData = config('local.providers.' . $sourceSlug, []);
        $parsed = [];
        foreach ($configData as $key => $data) {
            $parsed['{' . $key . '}'] = $data;
        }
        return $parsed;
    }

    public static function getConfiguredProviderSlugs()
    {
        return array_keys(config('local.providers', []));
    }

    public static function getDataFromGoogle() {
        $apiKey = config('local.api.google.key');
        $placeId = config('local.providers.google.place_id');
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

    public static function getDataFromYelp() {
        $client = new YelpClient([
            'consumerKey' => config('local.api.yelp.consumerKey'),
            'consumerSecret' => config('local.api.yelp.consumerSecret'),
            'token' => config('local.api.yelp.token'),
            'tokenSecret' => config('local.api.yelp.tokenSecret')
        ]);
        return collect($client->getBusiness(config('local.providers.yelp.id')));
    }
}
