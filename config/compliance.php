<?php

return [

    /*
    | Company advertising permit issued for general promotion of the brokerage.
    | It must not be attached to a property listing. Each advertisement needs
    | the Trakheesi permit and QR code issued for that property.
    */
    'company_trakheesi' => [
        'permit_no' => '0582084507',
        'qr_image' => 'frontend/img/trakheesi-company-permit-0582084507.png',
        'hidden_on' => [
            'listing',
            'listing/*',
            'detail',
            'detail/*',
            'map-view',
            'view',
            'developer/*',
            'luxury-rentals',
            'agents/*',
            'graeme',
            'graeme/*',
        ],
    ],

];
