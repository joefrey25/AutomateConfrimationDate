<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Admin;
use App\Customer;
use App\Order;
use App\Product;
use App\ProductOrder;

class OrdersControllerTest extends TestCase
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
        $this->user = factory(User::class)->create();
        $this->admin = factory(Admin::class)->create(['user_id' => $this->user->id, 'type' => 'superadmin']);
        $this->customer = factory(Customer::class)->create(['user_id' => $this->user->id]);
        $this->order = factory(Order::class)->create(['customer_id' => $this->customer->id]);
        $this->product = factory(Product::class)->create();
        $this->productOrder = factory(ProductOrder::class)->create(['product_id' => $this->product->id, 'order_id' => $this->order->id]);
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
     * Testing Orders page
     */
    public function testIndex()
    {
        $response = $this->call('GET', '/orders');
        $response->assertSuccessful();
        $response->assertViewHas('orders');
    }

    /**
     * Testing an exception in laravel
     * Exception thrown when there's another request method that doesn't allow to a certain route
     */
    public function testConfirmThrowException()
    {
        $response = $this->call('GET', '/orders/confirm');
        $response->assertStatus(405);
    }

    /**
     * Testing confirm order successfully
     */
    public function testConfirmSuccess()
    {
        $user = factory(User::class)->create();
        $admin = factory(Admin::class)->create(['user_id' => $user->id, 'type' => 'superadmin']);
        $customer = factory(Customer::class)->create(['user_id' => $user->id]);
        $product = factory(Product::class)->create();
        $order = factory(Order::class)->create(['customer_id' => $customer->id]);
        $product_order = factory(ProductOrder::class)->create(['product_id' => $product->id, 'order_id' => $order->id]);
        $response = $this->call('POST', '/orders/confirm', ['order_id' => $order->id]);
        $product_order_status = ProductOrder::where('order_id', $order->id)->first()->status;
        $this->assertEquals('confirmed', $product_order_status);
        $response->assertStatus(302);
    }

    /**
     * Test confirmation with empty order id
     */
    public function testConfirmFail()
    {
        $response = $this->call('POST', '/orders/confirm', ['order_id' => 3]);
        dd($response); die;
        // $response->assertStatus(500);
    }
}
