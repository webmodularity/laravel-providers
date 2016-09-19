<?php

return [
    /**
     * To find Google values go to Google My Business and navigate to dashboard for this business
     * Navigate to the Info tab and find the "Published On" section
     * id: Click the Google Search and use the shortest value that pulls up business in google (try and crop address from search)
     * place :
     *     id: Go to https://developers.google.com/places/place-id and enter name of business then copy Place ID: (27 char string)
     *     cid: Right click Google Maps and choose "Copy link location". Paste that into scratch file and extract cid=(19 digit number)
     *     lrd: Go to http://www.uksbd.co.uk/local/cid-converter/ and enter this business' cid
     */
    'google' => [
        'id' => env('GOOGLE_BUSINESS_ID'),
        'place' => [
            'id' => env('GOOGLE_PLACE_ID'),
            'cid' => env('GOOGLE_PLACE_CID'),
            'lrd' => env('GOOGLE_PLACE_LRD')
        ]
    ],
    /**
     * Go to yelp.com and search for business, ID is at end of URL yelp.com/biz/*yelp-id*
     * refer to http://www.yelp-support.com/article/What-is-my-Yelp-Business-ID?l=en_US for help
     */
    'yelp' => [
        'id' => env('YELP_BUSINESS_ID')
    ]
];