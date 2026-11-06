<?php

return [
    'key' => env('PROPERTY_FINDER_API_KEY'),
    'secret' => env('PROPERTY_FINDER_API_SECRET'),
    'enabled' => env('LISTING_SYNC_ENABLED', false),
    'withdraw' => env('LISTING_SYNC_WITHDRAW', false),
    'feed' => env('CRM_LISTINGS_FILE'),
    'agents' => json_decode(env('LISTING_SYNC_AGENT_MAP', '{}'), true),
    'locations' => json_decode(env('LISTING_SYNC_LOCATION_MAP', '{}'), true),
    'alert_email' => env('LISTING_SYNC_ALERT_EMAIL'),
];
