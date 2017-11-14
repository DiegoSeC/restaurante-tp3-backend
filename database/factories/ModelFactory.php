<?php

$factory->define(App\Models\Warehouse::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'code' => $faker->randomNumber(5),
        'address' => $faker->address,
        'contact_name' => $faker->name(),
        'contact_email' => $faker->email,
        'contact_phone_number' => $faker->phoneNumber,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'status' => 'active'
    ];
});

$factory->define(App\Models\Truck::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'license_plate' => strtoupper($faker->randomLetter . $faker->randomLetter . $faker->randomLetter) . $faker->randomNumber(3),
        'brand' => $faker->word,
        'status' => 'active'
    ];
});

$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'name' => $faker->word
    ];
});

$factory->define(App\Models\Employee::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'role_id' => function($employee) {
            return App\Models\Role::inRandomOrder()->first()->id ?: factory(App\Models\Role::class)->create()->id;
        },
        'user_uuid' => $faker->uuid,
        'document_number' => $faker->randomNumber(8),
        'name' => $faker->name(),
        'last_name' => $faker->lastName,
        'address' => $faker->address,
        'phone_number' => $faker->phoneNumber,
        'email' => $faker->email,
        'status' => 'active'
    ];
});

$factory->define(App\Models\Carrier::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'employee_id' => function($carrier) {
            return App\Models\Employee::inRandomOrder()->first()->id ?: factory(App\Models\Employee::class)->create()->id;
        },
        'driver_license' => $faker->randomNumber(7)
    ];
});

$factory->define(App\Models\Waybill::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'document_number' => $faker->randomNumber(9),
        'carrier_id' => function($waybill) {
            return App\Models\Carrier::inRandomOrder()->first()->id ?: factory(App\Models\Carrier::class)->create()->id;
        },
        'truck_id' => function($waybill) {
            return App\Models\Truck::inRandomOrder()->first()->id ?: factory(App\Models\Truck::class)->create()->id;
        },
        'warehouse_from_id' => function($waybill) {
            return App\Models\Warehouse::inRandomOrder()->first()->id ?: factory(App\Models\Warehouse::class)->create()->id;
        },
        'warehouse_to_id' => function($waybill) {
            return App\Models\Warehouse::inRandomOrder()->first()->id ?: factory(App\Models\Warehouse::class)->create()->id;
        },
        'date_time' => $faker->dateTime,
        'comment' => null,
        'delivery_status' => 'pending',
        'status' => 'active'
    ];
});

$factory->define(App\Models\ProductCategory::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'name' => $faker->word
    ];
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'product_category_id' => function($product) {
            return App\Models\ProductCategory::inRandomOrder()->first()->id ?: factory(App\Models\ProductCategory::class)->create()->id;
        },
        'sku' => $faker->randomNumber(8),
        'name' => $faker->word,
        'description' => $faker->words(20, true),
        'unit_of_measurement' => $faker->randomLetter . $faker->randomLetter
    ];
});

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'warehouse_id' => function($order) {
            return App\Models\Warehouse::inRandomOrder()->first()->id ?: factory(App\Models\Warehouse::class)->create()->id;
        },
        'document_number' => $faker->randomNumber(8)
    ];
});

$factory->define(App\Models\OrderHasProduct::class, function (Faker\Generator $faker) {
    return [
        'product_id' => function($orderHasProduct) {
            return App\Models\Product::inRandomOrder()->first()->id ?: factory(App\Models\Product::class)->create()->id;
        },
        'order_id' => function($orderHasProduct) {
            return App\Models\Order::inRandomOrder()->first()->id ?: factory(App\Models\Order::class)->create()->id;
        },
        'quantity' => $faker->randomNumber(2)
    ];
});