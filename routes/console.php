<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Customer;
use App\Order;
use Validator as Validator;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/



/**
 * Buyevent console 
 */
Artisan::command('buy', function () {
	// alert 
    $this->info("Buy event Started!");

    // get email addres
    
    ask_email:

    $email = $this->ask('What is your email address ?');

    $validate = Validator::make(['email' => $email],['email'=>'email|max:255:required']);

    if($validate->fails())
    {
    	$this->info($validate->errors()->first());

    	goto ask_email;
    }

    // get phone number
    ask_phone:

    $phone = $this->ask('What is your phone number ?');

    if($phone == '')
    {
    	$this->info("Phone number cannot be empty!");
    	
    	goto ask_phone;
    }

    // some products
    $products = 
    [
    	['name'=>'1 - Mac','price'=>'1200$'],

    	['name'=>'2 - HP','price'=>'800$'],

    	['name'=>'3 - Asus','price'=>'750$'],

    	['name'=>'4 - Monster','price'=>'950$'],

    ];
    product_list:
    // we will show product list to user
    foreach ($products as $key => $product) 
    {

    	$this->info($product['name'].' = '.$product['price']);
    }

    // ask to user: which product you want to get
    $ask = $this->ask('Select one of above products. Just whrite the number');

    // we will get user response
    switch ($ask) {
    	case '1':

    		$product_name = $products[0]['name'];

    		$product_price = $products[0]['price'];

    		break;

    	case '2':

    		$product_name = $products[1]['name'];

    		$product_price = $products[1]['price'];

    		break;

    	case '3':

    		$product_name = $products[2]['name'];

    		$product_price = $products[2]['price'];

    		break;

    	case '4':

    		$product_name = $products[3]['name'];

    		$product_price = $products[3]['price'];

    		break;

    	default:
    		
    		$this->info("Non product!");

    		if($this->confirm("Do you want to get prouct list again ?"))
    		{
    			goto product_list;
    		}

    		$this->info("Order Canceled!");

    		die();

    		break;
    }

    order_info:
    // show email address
    $this->info("-------------------------------");
    $this->info("Your Email Address :".$email);
    $this->info("-------------------------------");

    // show phone
    $this->info("-------------------------------");
    $this->info("Your Phone number :".$phone);
    $this->info("-------------------------------");
    
    // show product name
    $this->info("-------------------------------");
    $this->info("Prouct : ".$product_name);
    $this->info("-------------------------------");

    // show product price
    $this->info("-------------------------------");
    $this->info("Price: ".$product_price);
    $this->info("-------------------------------");

    // get accept
    if($this->confirm('Do you accept above information ?'))
    {
    	$this->info("The information is being saved, please wait...");

    	// save customer 
    	$customer = new Customer();
    	$customer->email = $email;
    	$customer->phone = $phone;
   		$customer->save();

   		// save order
   		$order = new Order();
   		$order->name = $product_name;
   		$order->price = $product_price;
   		$order->save();

   		// send message to email
   		$customer->notify(new \App\Notifications\OrderNotification());

    	$this->info("");
    	$this->info("The information has been saved!");
    	$this->info("-------------------------------");
    	$this->info("Thank you for choosing us!");
    	$this->info("We get your order. We will send as soon as possible!");

    	// send email address
    	$customer->notify(new \App\Notifications\OrderNotification());

    	$this->info("Order information sent to ". $email);

    }else
    {	
    	// asks when user cancel order 
    	if($this->confirm('Are you sure ?'))
    	{
    		$this->info("Order Canceled!");
    		die();
    	}
    	// goto back order info
    	goto order_info;

    }

})->describe('Email Sent');