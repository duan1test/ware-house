<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Warehouse;
use Faker\Factory as Faker;
use App\Services\WarehouseService;

class WarehouseTest extends TestCase
{
    protected $warehouse;
    protected $faker;
    protected $warehouseService;
    
    public function setUp() : void
    {
        parent::setUp();
        $this->faker = Faker::create();
        $this->warehouse = [
            'code'      => $this->faker->countryCode(),
            'name'      => $this->faker->name,
            'phone'     => $this->faker->phoneNumber(),
            'email'     => $this->faker->email(),
            'address'   => $this->faker->address,
            'active'    => $this->faker->boolean,
        ];
        $this->warehouseService = new WarehouseService();
    }
    /**
     * A basic unit test example.
     */
    public function test_store(): void
    {
        $warehouse = $this->warehouseService->store($this->warehouse);
        $this->assertInstanceOf(Warehouse::class, $warehouse);
        $this->assertEquals($this->warehouse['name'], $warehouse->name);
        $this->assertEquals($this->warehouse['code'], $warehouse->code);
        $this->assertDatabaseHas('warehouses', $this->warehouse);
    }
}
