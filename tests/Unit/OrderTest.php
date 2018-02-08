<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Order;
use App\ProductOrder;
use App\User;
use App\Customer;
use App\Product;
use App\Admin;

class OrderTest extends TestCase
{
    use DatabaseMigrations;
    
    private $order;
    private $user;
    private $customer;
    private $product;
    private $productOrder;
    private $admin;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        unset($this->user);
        unset($this->admin);
        unset($this->customer);
        unset($this->order);
        unset($this->product);
        unset($this->productOrder);
        parent::tearDown();
    }

    /**
     * Test get product orders
     *
     * @return void
     */
    public function testProductOrders()
    {
        $this->user = factory(User::class)->create();
        $this->admin = factory(Admin::class)->create(['user_id' => $this->user->id]);
        $this->customer = factory(Customer::class)->create(['user_id' => $this->user->id]);
        $this->order = factory(Order::class)->create(['customer_id' => $this->customer->id]);
        $this->product = factory(Product::class)->create();
        $this->productOrder = factory(ProductOrder::class)->create(['product_id' => $this->product->id, 'order_id' => $this->order->id]);

        $order = new Order;
        $product_orders = $order->productOrders();
        $this->assertNotEmpty($product_orders);
        $this->assertInternalType('object', $product_orders);
    }

    public function testProductOrdersReturnEmptyObject()
    {
        $order = new Order;
        $product_orders = $order->productOrders();
        $this->assertEmpty($product_orders);
    }
}
