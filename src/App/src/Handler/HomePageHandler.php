<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HomePageHandler implements RequestHandlerInterface
{
    /** @var Router\RouterInterface */
    private Router\RouterInterface $router;

    private array $data = [];

    public function __construct(Router\RouterInterface $router)
    {
        $this->router = $router;
        $this->data = [
            'api_response' => 200,
            'status' => 'success',
            'data' => [
                'last_updated' => (new \DateTimeImmutable())->format(DATE_W3C),
                'parcel_id' => '123456789',
                'most_recent_change' => [
                    'carrier_name' => 'Australia Post',
                    'event' => [
                        'type' => 'delivery',
                        'time' => (new \DateTimeImmutable())->format(DATE_W3C),
                        'location' => 'customer_address'
                    ],
                ],
                'all_changes' => [
                    [
                        'carrier_name' => 'Australia Post',
                        'event' => [
                            'type' => 'delivery',
                            'time' => (new \DateTimeImmutable())->format(DATE_W3C),
                            'location' => 'customer_address'
                        ],
                    ],
                    [
                        'carrier_name' => 'Australia Post',
                        'event' => [
                            'type' => 'arrival_at_depot',
                            'time' => (new \DateTimeImmutable())->format(DATE_W3C),
                            'location' => 'Brisbane Mail Centre'
                        ],
                    ],
                    [
                        'carrier_name' => 'Australia Post',
                        'event' => [
                            'type' => 'parcel_pickup',
                            'time' => (new \DateTimeImmutable())->format(DATE_W3C),
                            'location' => 'retailer'
                        ],
                    ],
                ],
                'parcel' => [
                    'details' => [
                        'height' => [
                            'value' => '100.4',
                            'unit' => 'cm'
                        ],
                        'weight' => [
                            'value' => '400.4',
                            'unit' => 'cm'
                        ],
                        'depth' => [
                            'value' => '120.4',
                            'unit' => 'cm'
                        ],
                        'value' => [
                            'value' => "120.0000000",
                            'unit' => 'EUR'
                        ]
                    ]
                ],
                'customer' => [
                    'name' => [
                        'first' => 'John',
                        'last' => 'Citizen'
                    ],
                    'email' => 'j.citizen@example.org',
                    'phone_number' => '+6140912345678',
                    'address' => [
                        'street_name' => 'North Street',
                        'street_number' => '123',
                        'city' => 'Brisbane',
                        'state' => 'Queensland',
                        'postcode' => '4006',
                        'country' => 'Australia'
                    ]

                ]
            ]
        ];
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($this->data);
    }
}
