<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'L5Swagger',
    description: 'Implementation of Swagger with in Laravel',
    contact: new OA\Contact(email: 'admin@admin.com'),
    license: new OA\License(name: 'Apache 2.0', url: 'http://www.apache.org/licenses/LICENSE-2.0.html'),
)]
#[OA\Server(url: L5_SWAGGER_CONST_HOST, description: 'Local')]
#[OA\Server(url: L5_SWAGGER_CONST_HOST2, description: 'Production')]
#[OA\SecurityScheme(securityScheme: 'bearerAuth', type: 'http', scheme: 'bearer', bearerFormat: 'JWT')]
#[OA\Schema(
    schema: 'ArendatorAll',
    title: 'ArendatorAll',
    properties: [
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'af42801a-70bb-4966-87d6-d53ead3015b5'),
            new OA\Property(property: 'default_bill_id', type: 'uuid', example: '5z7490a8-f20e-32eb-87f4-3630d5999c0b'),
            new OA\Property(property: 'last_name', type: 'string', example: 'Haley'),
            new OA\Property(property: 'first_name', type: 'string', example: 'Carolyn'),
            new OA\Property(property: 'middle_name', type: 'string', example: 'Berta'),
            new OA\Property(property: 'status', type: 'string', example: 'active'),
            new OA\Property(property: 'phone', type: 'integer', example: '7525301782'),
        ])),
    ],
)]
#[OA\Schema(
    schema: 'ArendatorId',
    title: 'ArendatorId',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'af42801a-70bb-4966-87d6-d53ead3015b5'),
            new OA\Property(property: 'default_bill_id', type: 'uuid', example: '5z7490a8-f20e-32eb-87f4-3630d5999c0b'),
            new OA\Property(property: 'last_name', type: 'string', example: 'Haley'),
            new OA\Property(property: 'first_name', type: 'string', example: 'Carolyn'),
            new OA\Property(property: 'middle_name', type: 'string', example: 'Berta'),
            new OA\Property(property: 'status', type: 'string', example: 'active'),
            new OA\Property(property: 'phone', type: 'integer', example: '7525301782'),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'ArendatorRequest',
    title: 'ArendatorRequest',
    properties: [
        new OA\Property(property: 'email', type: 'string', example: 'towne.christy@example.org'),
        new OA\Property(property: 'password', type: 'string', example: '12345678'),
        new OA\Property(property: 'default_bill_id', type: 'uuid', example: '5z7490a8-f20e-32eb-87f4-3630d5999c0b'),
        new OA\Property(property: 'last_name', type: 'string', example: 'Haley'),
        new OA\Property(property: 'first_name', type: 'string', example: 'Carolyn'),
        new OA\Property(property: 'middle_name', type: 'string', example: 'Berta'),
        new OA\Property(property: 'status', type: 'string', example: 'active'),
        new OA\Property(property: 'passport_series', type: 'string', example: '52 59'),
        new OA\Property(property: 'passport_number', type: 'string', example: '875660'),
        new OA\Property(property: 'driverlicense_series', type: 'string', example: '96 48'),
        new OA\Property(property: 'driverlicense_number', type: 'string', example: '665211'),
        new OA\Property(property: 'driverlicense_date', type: 'string', example: '05.01.1999'),
        new OA\Property(property: 'phone', type: 'integer', example: '7525301782'),
    ],
)]
#[OA\Schema(
    schema: 'ArendatorChange',
    title: 'ArendatorChange',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'af42801a-70bb-4966-87d6-d53ead3015b5'),
            new OA\Property(property: 'email', type: 'string', example: 'towne.christy@example.org'),
            new OA\Property(property: 'password', type: 'string', example: '12345678'),
            new OA\Property(property: 'default_bill_id', type: 'uuid', example: '5z7490a8-f20e-32eb-87f4-3630d5999c0b'),
            new OA\Property(property: 'last_name', type: 'string', example: 'Haley'),
            new OA\Property(property: 'first_name', type: 'string', example: 'Carolyn'),
            new OA\Property(property: 'middle_name', type: 'string', example: 'Berta'),
            new OA\Property(property: 'status', type: 'string', example: 'active'),
            new OA\Property(property: 'passport_series', type: 'string', example: '52 59'),
            new OA\Property(property: 'passport_number', type: 'string', example: '875660'),
            new OA\Property(property: 'driverlicense_series', type: 'string', example: '96 48'),
            new OA\Property(property: 'driverlicense_number', type: 'string', example: '665211'),
            new OA\Property(property: 'driverlicense_date', type: 'string', example: '05.01.1999'),
            new OA\Property(property: 'phone', type: 'integer', example: '7525301782'),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'ArendatorDefaultBill',
    title: 'ArendatorDefaultBill',
    properties: [
        new OA\Property(property: 'default_bill_id', type: 'uuid', example: '5z7490a8-f20e-32eb-87f4-3630d5999c0b'),
    ],
)]
#[OA\Schema(
    schema: 'ArendatorStatus',
    title: 'ArendatorStatus',
    properties: [
        new OA\Property(property: 'status', type: 'string', example: 'frozen'),
    ],
)]
#[OA\Schema(
    schema: 'BillAll',
    title: 'BillAll',
    properties: [
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'ff7f36b1-1cab-35b9-9b3f-969bb0e92109'),
            new OA\Property(property: 'arendators_count', type: 'integer', example: 1),
            new OA\Property(property: 'type', type: 'string', example: 'personal'),
            new OA\Property(property: 'status', type: 'string', example: 'open'),
        ])),
    ],
)]
#[OA\Schema(
    schema: 'BillId',
    title: 'BillId',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'ff7f36b1-1cab-35b9-9b3f-969bb0e92109'),
            new OA\Property(property: 'arendators_count', type: 'integer', example: 1),
            new OA\Property(property: 'type', type: 'string', example: 'personal'),
            new OA\Property(property: 'status', type: 'string', example: 'open'),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'BillRequest',
    title: 'BillRequest',
    properties: [
        new OA\Property(property: 'arendators_count', type: 'integer', example: 1),
        new OA\Property(property: 'balance', type: 'decimal', example: 48658.52),
        new OA\Property(property: 'type', type: 'string', example: 'personal'),
        new OA\Property(property: 'status', type: 'string', example: 'open'),
    ],
)]
#[OA\Schema(
    schema: 'BillChange',
    title: 'BillChange',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'ff7f36b1-1cab-35b9-9b3f-969bb0e92109'),
            new OA\Property(property: 'arendators_count', type: 'integer', example: 1),
            new OA\Property(property: 'balance', type: 'decimal', example: 48658.52),
            new OA\Property(property: 'type', type: 'string', example: 'personal'),
            new OA\Property(property: 'status', type: 'string', example: 'open'),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'BillStatus',
    title: 'BillStatus',
    properties: [
        new OA\Property(property: 'status', type: 'string', example: 'closed'),
    ],
)]
#[OA\Schema(
    schema: 'CarAll',
    title: 'CarAll',
    properties: [
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3'),
            new OA\Property(property: 'model_id', type: 'uuid', example: '0b4932f2-5c19-4de2-9ddc-17ce2375d164'),
            new OA\Property(property: 'status', type: 'string', example: 'rented'),
            new OA\Property(property: 'mileage', type: 'integer', example: 10383),
            new OA\Property(property: 'license_plate', type: 'string', example: 'J949YJ 93'),
            new OA\Property(property: 'vin', type: 'string', example: 'X4XCM59560PS61468'),
            new OA\Property(property: 'price_minute', type: 'decimal', example: 12.50),
        ])),
    ],
)]
#[OA\Schema(
    schema: 'CarId',
    title: 'CarId',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3'),
            new OA\Property(property: 'model_id', type: 'uuid', example: '0b4932f2-5c19-4de2-9ddc-17ce2375d164'),
            new OA\Property(property: 'status', type: 'string', example: 'rented'),
            new OA\Property(property: 'mileage', type: 'integer', example: 10383),
            new OA\Property(property: 'license_plate', type: 'string', example: 'J949YJ 93'),
            new OA\Property(property: 'vin', type: 'string', example: 'X4XCM59560PS61468'),
            new OA\Property(property: 'price_minute', type: 'decimal', example: 12.50),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'CarRequest',
    title: 'CarRequest',
    properties: [
        new OA\Property(property: 'model_id', type: 'uuid', example: '0b4932f2-5c19-4de2-9ddc-17ce2375d164'),
        new OA\Property(property: 'status', type: 'string', example: 'rented'),
        new OA\Property(property: 'mileage', type: 'integer', example: 10383),
        new OA\Property(property: 'license_plate', type: 'string', example: 'J949YJ 93'),
        new OA\Property(property: 'vin', type: 'string', example: 'X4XCM59560PS61468'),
        new OA\Property(property: 'location', type: 'string', example: '-35.71 -45.96609'),
        new OA\Property(property: 'price_minute', type: 'decimal', example: 12.50),
    ],
)]
#[OA\Schema(
    schema: 'CarChange',
    title: 'CarChange',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3'),
            new OA\Property(property: 'model_id', type: 'uuid', example: '0b4932f2-5c19-4de2-9ddc-17ce2375d164'),
            new OA\Property(property: 'status', type: 'string', example: 'rented'),
            new OA\Property(property: 'mileage', type: 'integer', example: 10383),
            new OA\Property(property: 'license_plate', type: 'string', example: 'J949YJ 93'),
            new OA\Property(property: 'vin', type: 'string', example: 'X4XCM59560PS61468'),
            new OA\Property(property: 'location', type: 'string', example: '-35.71 -45.96609'),
            new OA\Property(property: 'price_minute', type: 'decimal', example: 12.50),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'CarStatus',
    title: 'CarStatus',
    properties: [
        new OA\Property(property: 'status', type: 'string', example: 'expectation'),
    ],
)]
#[OA\Schema(
    schema: 'CarMarkAll',
    title: 'CarMarkAll',
    properties: [
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(properties: [
            new OA\Property(property: 'id', type: 'uuid', example: '24a0f5c9-0a83-4b79-8bb2-173fa979749b'),
            new OA\Property(property: 'name', type: 'string', example: 'Volvo'),
        ])),
    ],
)]
#[OA\Schema(
    schema: 'CarMarkId',
    title: 'CarMarkId',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: '46a4eeeb-e7d7-3d25-aa7a-496a94d44e75'),
            new OA\Property(property: 'name', type: 'string', example: 'Toyota'),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'CarMarkRequest',
    title: 'CarMarkRequest',
    properties: [
        new OA\Property(property: 'name', type: 'string', example: 'BMW'),
    ],
)]
#[OA\Schema(
    schema: 'CarMarkChange',
    title: 'CarMarkChange',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: '6c117024-ff60-3020-bf74-dedddabc7dac'),
            new OA\Property(property: 'name', type: 'string', example: 'Audi'),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'CarModelAll',
    title: 'CarModelAll',
    properties: [
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'b650e982-2e20-38be-8468-a378dcd2b4cf'),
            new OA\Property(property: 'mark_id', type: 'string', example: 'a7e3fc62-97ae-3344-89b3-d86483d06afb'),
            new OA\Property(property: 'name', type: 'string', example: 'Volvo'),
            new OA\Property(property: 'car_class', type: 'string', example: 'comfort'),
            new OA\Property(property: 'car_type', type: 'string', example: 'sedan'),
            new OA\Property(property: 'fuel_type', type: 'string', example: 'diesel'),
            new OA\Property(property: 'door_count', type: 'integer', example: 4),
            new OA\Property(property: 'seat_count', type: 'integer', example: 4),
            new OA\Property(property: 'gear_box', type: 'string', example: 'manual'),
            new OA\Property(property: 'drive_type', type: 'string', example: 'full'),
            new OA\Property(property: 'engine_power', type: 'integer', example: 140),
            new OA\Property(property: 'year', type: 'integer', example: 2022),
        ])),
    ],
)]
#[OA\Schema(
    schema: 'CarModelId',
    title: 'CarModelId',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: '7513ae02-514e-38c9-bfa8-a70c14742d1c'),
            new OA\Property(property: 'mark_id', type: 'string', example: 'fbd8d2e1-056e-3f40-adf6-35408b6aba67'),
            new OA\Property(property: 'name', type: 'string', example: '710'),
            new OA\Property(property: 'car_class', type: 'string', example: 'comfort'),
            new OA\Property(property: 'car_type', type: 'string', example: 'small'),
            new OA\Property(property: 'fuel_type', type: 'string', example: 'diesel'),
            new OA\Property(property: 'door_count', type: 'integer', example: 4),
            new OA\Property(property: 'seat_count', type: 'integer', example: 4),
            new OA\Property(property: 'gear_box', type: 'string', example: 'automatic'),
            new OA\Property(property: 'drive_type', type: 'string', example: 'full'),
            new OA\Property(property: 'engine_power', type: 'integer', example: 300),
            new OA\Property(property: 'year', type: 'integer', example: 2022),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'CarModelRequest',
    title: 'CarModelRequest',
    properties: [
        new OA\Property(property: 'mark_id', type: 'string', example: '1c1b68db-b6d5-3eaf-b0f2-b0be31c8e397'),
        new OA\Property(property: 'name', type: 'string', example: 'Renegade'),
        new OA\Property(property: 'car_class', type: 'string', example: 'comfort'),
        new OA\Property(property: 'car_type', type: 'string', example: 'sedan'),
        new OA\Property(property: 'fuel_type', type: 'string', example: 'gasoline'),
        new OA\Property(property: 'door_count', type: 'integer', example: 4),
        new OA\Property(property: 'seat_count', type: 'integer', example: 5),
        new OA\Property(property: 'gear_box', type: 'string', example: 'manual'),
        new OA\Property(property: 'drive_type', type: 'string', example: 'full'),
        new OA\Property(property: 'engine_power', type: 'integer', example: 220),
        new OA\Property(property: 'year', type: 'integer', example: 2022),
    ],
)]
#[OA\Schema(
    schema: 'CarModelChange',
    title: 'CarModelChange',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'string', example: 'da8bdb3f-75b4-33da-9201-c2cbed141eff'),
            new OA\Property(property: 'mark_id', type: 'string', example: '8619b523-32a3-3dda-aab3-cdcc25f9decf'),
            new OA\Property(property: 'name', type: 'string', example: 'Gonow'),
            new OA\Property(property: 'car_class', type: 'string', example: 'comfort'),
            new OA\Property(property: 'car_type', type: 'string', example: 'convertible'),
            new OA\Property(property: 'fuel_type', type: 'string', example: 'hybrid'),
            new OA\Property(property: 'door_count', type: 'integer', example: 4),
            new OA\Property(property: 'seat_count', type: 'integer', example: 5),
            new OA\Property(property: 'gear_box', type: 'string', example: 'automatic'),
            new OA\Property(property: 'drive_type', type: 'string', example: 'full'),
            new OA\Property(property: 'engine_power', type: 'integer', example: 152),
            new OA\Property(property: 'year', type: 'integer', example: 2022),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'CarModelMark',
    title: 'CarModelMark',
    properties: [
        new OA\Property(property: 'mark_id', type: 'string', example: 'cf94810c-2bdb-32d9-99af-ee674c3c57b0'),
    ],
)]
#[OA\Schema(
    schema: 'CarModelClass',
    title: 'CarModelClass',
    properties: [
        new OA\Property(property: 'car_class', type: 'string', example: 'comfort'),
    ],
)]
#[OA\Schema(
    schema: 'CarModelType',
    title: 'CarModelType',
    properties: [
        new OA\Property(property: 'car_type', type: 'string', example: 'hatchback'),
    ],
)]
#[OA\Schema(
    schema: 'CarModelFuelType',
    title: 'CarModelFuelType',
    properties: [
        new OA\Property(property: 'fuel_type', type: 'string', example: 'gasoline'),
    ],
)]
#[OA\Schema(
    schema: 'CarModelGearBoxType',
    title: 'CarModelGearBoxType',
    properties: [
        new OA\Property(property: 'gear_box', type: 'string', example: 'manual'),
    ],
)]
#[OA\Schema(
    schema: 'CarModelDriveType',
    title: 'CarModelDriveType',
    properties: [
        new OA\Property(property: 'drive_type', type: 'string', example: 'full'),
    ],
)]
#[OA\Schema(
    schema: 'RentAll',
    title: 'RentAll',
    properties: [
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'beceda62-2656-3617-97b9-b686a7d36e3b'),
            new OA\Property(property: 'car_id', type: 'uuid', example: '40644966-2862-35d0-a7c6-ad87c512625a'),
            new OA\Property(property: 'arendator_id', type: 'uuid', example: '63f081c5-1967-322f-9c2a-7f7b116441fc'),
            new OA\Property(property: 'status', type: 'string', example: 'open'),
            new OA\Property(property: 'start_datetime', type: 'string', example: '2024-07-06 19:52:25'),
            new OA\Property(property: 'end_datetime', type: 'string', example: '2024-07-06 19:52:25'),
            new OA\Property(property: 'rented_time', type: 'integer', example: 720),
            new OA\Property(property: 'total_price', type: 'decimal', example: 8658.32),
        ])),
    ],
)]
#[OA\Schema(
    schema: 'RentId',
    title: 'RentId',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'beceda62-2656-3617-97b9-b686a7d36e3b'),
            new OA\Property(property: 'car_id', type: 'uuid', example: '40644966-2862-35d0-a7c6-ad87c512625a'),
            new OA\Property(property: 'arendator_id', type: 'uuid', example: '63f081c5-1967-322f-9c2a-7f7b116441fc'),
            new OA\Property(property: 'status', type: 'string', example: 'open'),
            new OA\Property(property: 'start_datetime', type: 'string', example: '2024-07-06 19:52:25'),
            new OA\Property(property: 'end_datetime', type: 'string', example: '2024-07-06 19:52:25'),
            new OA\Property(property: 'rented_time', type: 'integer', example: 720),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'RentRequest',
    title: 'RentRequest',
    properties: [
        new OA\Property(property: 'car_id', type: 'uuid', example: '40644966-2862-35d0-a7c6-ad87c512625a'),
        new OA\Property(property: 'arendator_id', type: 'uuid', example: '63f081c5-1967-322f-9c2a-7f7b116441fc'),
        new OA\Property(property: 'status', type: 'string', example: 'open'),
        new OA\Property(property: 'start_datetime', type: 'string', example: '2024-07-06 19:52:25'),
        new OA\Property(property: 'end_datetime', type: 'string', example: '2024-07-06 19:52:25'),
        new OA\Property(property: 'rented_time', type: 'integer', example: 720),
        new OA\Property(property: 'total_price', type: 'decimal', example: 8658.32),
    ],
)]
#[OA\Schema(
    schema: 'RentChange',
    title: 'RentChange',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'beceda62-2656-3617-97b9-b686a7d36e3b'),
            new OA\Property(property: 'car_id', type: 'uuid', example: '40644966-2862-35d0-a7c6-ad87c512625a'),
            new OA\Property(property: 'arendator_id', type: 'uuid', example: '63f081c5-1967-322f-9c2a-7f7b116441fc'),
            new OA\Property(property: 'status', type: 'string', example: 'open'),
            new OA\Property(property: 'start_datetime', type: 'string', example: '2024-07-06 19:52:25'),
            new OA\Property(property: 'end_datetime', type: 'string', example: '2024-07-06 19:52:25'),
            new OA\Property(property: 'rented_time', type: 'integer', example: 720),
            new OA\Property(property: 'total_price', type: 'decimal', example: 8658.32),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'RentOpen',
    title: 'RentOpen',
    properties: [
        new OA\Property(property: 'car_id', type: 'uuid', example: '40644966-2862-35d0-a7c6-ad87c512625a'),
        new OA\Property(property: 'arendator_id', type: 'uuid', example: '63f081c5-1967-322f-9c2a-7f7b116441fc'),
    ],
)]
#[OA\Schema(
    schema: 'RentClose',
    title: 'RentClose',
    properties: [
        new OA\Property(property: 'id', type: 'uuid', example: '40644966-2862-35d0-a7c6-ad87c512625a'),
    ],
)]
#[OA\Schema(
    schema: 'TransactionAll',
    title: 'TransactionAll',
    properties: [
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'beceda62-2656-3617-97b9-b686a7d36e3b'),
            new OA\Property(property: 'arendator_id', type: 'uuid', example: '63f081c5-1967-322f-9c2a-7f7b116441fc'),
            new OA\Property(property: 'bill_id', type: 'uuid', example: '40644966-2862-35d0-a7c6-ad87c512625a'),
            new OA\Property(property: 'modification', type: 'string', example: '-200.00'),
        ])),
    ],
)]
#[OA\Schema(
    schema: 'TransactionId',
    title: 'TransactionId',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'beceda62-2656-3617-97b9-b686a7d36e3b'),
            new OA\Property(property: 'arendator_id', type: 'uuid', example: '63f081c5-1967-322f-9c2a-7f7b116441fc'),
            new OA\Property(property: 'bill_id', type: 'uuid', example: '40644966-2862-35d0-a7c6-ad87c512625a'),
            new OA\Property(property: 'modification', type: 'string', example: '-200.00'),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'TransactionRequest',
    title: 'TransactionRequest',
    properties: [
        new OA\Property(property: 'arendator_id', type: 'uuid', example: '63f081c5-1967-322f-9c2a-7f7b116441fc'),
        new OA\Property(property: 'bill_id', type: 'uuid', example: '40644966-2862-35d0-a7c6-ad87c512625a'),
        new OA\Property(property: 'modification', type: 'string', example: '-200.00'),
    ],
)]
#[OA\Schema(
    schema: 'TransactionChange',
    title: 'TransactionChange',
    type: 'object',
    properties: [
        new OA\Property(property: 'data', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'uuid', example: 'beceda62-2656-3617-97b9-b686a7d36e3b'),
            new OA\Property(property: 'arendator_id', type: 'uuid', example: '63f081c5-1967-322f-9c2a-7f7b116441fc'),
            new OA\Property(property: 'bill_id', type: 'uuid', example: '40644966-2862-35d0-a7c6-ad87c512625a'),
            new OA\Property(property: 'modification', type: 'string', example: '-200.00'),
        ]),
    ],
)]
#[OA\Schema(
    schema: 'Response401',
    title: 'Response401',
    properties: [
        new OA\Property(property: 'status', type: 'integer', example: '401'),
        new OA\Property(property: 'message', type: 'string', example: 'Unauthorized'),
    ],
)]
#[OA\Schema(
    schema: 'Response403',
    title: 'Response403',
    properties: [
        new OA\Property(property: 'status', type: 'integer', example: '403'),
        new OA\Property(property: 'message', type: 'string', example: 'Forbidden'),
    ],
)]
#[OA\Schema(
    schema: 'Response404',
    title: 'Response404',
    properties: [
        new OA\Property(property: 'status', type: 'integer', example: '404'),
        new OA\Property(property: 'message', type: 'string', example: 'Not Found'),
    ],
)]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
