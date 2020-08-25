<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Customer;
use App\Order;

class BuyEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:buyevent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sends a notification to an e-mail address when a user buys something!';

    

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->ask("What is your Email Address ?");
        $phone = $this->ask('What is your Phone number ?');
        $this->info('Just select one of following product and write the number that you selected');
        $this->info('1.Samsung \n 2.HP \n 3.Asus');

        if($product = $this->confirm('Which else do you want to buy ? '))
        {
            switch ($product) {
                case '1':
                    return  $this->info('You selected Samsung');
                    break;
                case '2':
                    return $this->info('You selected HP');
                    break;
                case '3':
                    return $this->info('You selected Asus');
                    break;
                
                default:
                    return $this->info('There is not like this product');
                    break;
            }
        }
        


        // $cutomer = new Customer();
        // $customer->name = $this->argument('email');
        // $customer->email = $this->argument('phone');
        // $cutomer->save();

        // $order = new Order();
        // $order->name = $this->argument('order_name');
    }
}
