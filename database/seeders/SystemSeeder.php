<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Bank;
use App\Models\Role;
use App\Models\User;
use App\Models\Guest;
use App\Models\Image;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Courier;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Shipping;
use App\Models\Template;
use App\Models\Wishlist;
use App\Models\Orderdetail;
use App\Models\Socialmedia;
use App\Models\Transaction;
use App\Models\Productdetail;
use App\Models\ProductTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating roles
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $sub_adminRole = Role::firstOrCreate(['name' => 'sub_admin']);
        $cooperateRole = Role::firstOrCreate(['name' => 'corporate']);

        // Creating users of each role
        $customers = User::factory(3)
            ->afterCreating(function (User $user) use ($customerRole) {
                // Attach the 'corporate' role
                $user->roles()->attach($customerRole->id);
        })->create();


        $cooperators = User::factory(3)
            ->afterCreating(function (User $user) use ($cooperateRole) {
                // Attach the 'corporate' role
                $user->roles()->attach($cooperateRole->id);

                $corporate = $user->corporate()->create([
                    'company_name' => $user->name, // Using user's name as company name
                ]);


                Project::factory(3)
                    ->create([
                        'corporate_id' => $corporate->id,
                    ]);
            })
            ->create();


        $dummyCustomer = User::factory(1)
            ->afterCreating(function (User $user) use ($customerRole) {
                // Attach the 'corporate' role
                $user->roles()->attach($customerRole->id);
        })->create([
            'name' => 'Customer',
            'email' => 'customer@mail.com',
            'password' => 'customer@mail.com',
            'status' => 'active'
        ]);
        $dummyCooperators = User::factory(1)
            ->afterCreating(function (User $user) use ($cooperateRole) {
                // Attach the 'corporate' role
                $user->roles()->attach($cooperateRole->id);

                $corporate = $user->corporate()->create([
                    'company_name' => $user->name, // Using user's name as company name
                ]);


                Project::factory(3)
                    ->create([
                        'corporate_id' => $corporate->id,
                    ]);
            })
            ->create([
            'name' => 'Cooprate',
            'email' => 'corporate@mail.com',
            'password' => 'corporate@mail.com',
            'status' => 'active'
        ]);


        $sub_admins = User::factory(1)
            ->afterCreating(fn(User $user) => $user->roles()->attach($sub_adminRole->id))
            ->create();

        // Creating couriers
        // Courier::factory(10)->create();
        Coupon::factory(10)->create();
        Payment::factory(5)->create();

        Courier::factory(1)->create([
            'name' => 'Nana Delivery',
            'contact_phone' => '+251939999111/+251911740848',
            'contact_email' => 'info@nanaexpresset.com',
            'address' => '22,Addis Ababa,Ethiopia',
            'description' => 'Nana Express is the trusted partner for reliable and efficient delivery services. They’re committed to simplifying the process of sending and receiving packages, providing real-time tracking, and offering exceptional customer support. There platform is designed to cater to the needs of both individuals and businesses. Whether you’re shipping a gift to a loved one or managing a large-scale logistics operation, Nana Express has the solution for you.',
            'is_featured' => true,
            'status' => true,
            'logo' => 'static/images/logo/Nana-Express-Logo.png'
        ]);

    //     $products = Product::factory(3)
    // ->afterCreating(function (Product $product) {
    //     // Attach relationships
    //     $product->categories()->attach(Category::factory()->create()->id);
    //     $product->tags()->attach(Tag::factory()->create()->id);
    //     $product->images()->createMany(Image::factory(3)->make()->toArray());

    //     // Create ProductDetail
    //     $detail = ProductDetail::factory()->create([
    //         'product_id' => $product->id,
    //     ]);


    //     // Create template if template_status is true
    //     if ($detail->template_status) {
    //         $template = Template::factory()->create();
    //         ProductTemplate::factory()->create([
    //             'product_id' => $product->id,
    //             'template_id' => $template->id,
    //             'structure' => $template->structure,
    //         ]);
    //     }

    //     // Create Wishlist
    //     Wishlist::factory(3)->create([
    //         'product_id' => $product->id,
    //     ]);

    //     // Create Orders
    //     $orders = Order::factory(3)->create([
    //         'product_id' => $product->id,
    //     ]);

    //     foreach ($orders as $order) {
    //         // Ensure product and template are loaded
    //         $order->load('product.template');


    //         if($order->product->detail->template_status){
    //             $product_ordered = $order->product->template->first()?->structure;
    //         }else{
    //             $product_ordered = NULL;
    //         }

    //         Orderdetail::factory()->create([
    //             'order_id' => $order->id,
    //             'product_ordered' => $product_ordered,
    //             'price' => $order->product?->price,
    //         ]);

    //         // // Create Transaction
    //         // if($order->status != 'pending'){
    //         //     $status =  'unconfirmed';
    //         // }   



    //         $method = 'bank';
    //         $transaction = Transaction::factory()->create([
    //             'order_id' => $order->id,
    //             'status' => 'unconfirmed',
    //             'method' => $method,
    //         ]);

    //         // Create Bank record if method is bank
    //         if ($method === 'bank') {
    //             Bank::factory()->create([
    //                 'transaction_id' => $transaction->id,
    //             ]);
    //         }

    //         if($order->status != 'pending'){
    //             Delivery::factory()->create();
    //         }
    //     }


    // })
    // ->create();
        

        $categories = [
            [
                'name' => 'Woodwork Lights', 
                'image' => 'static/images/category_images/woodworkLightsCategoryImage.png'
            ],
            [
                'name' => 'Table Wood Lamp', 
                'image' => 'static/images/category_images/tableWoodLampCategoryImage.png'
            ],
            [
                'name' => 'Breaker', 
                'image' => 'static/images/category_images/breakerCategoryImage.png'
            ],
            [
                'name' => 'Junction Box', 
                'image' => 'static/images/category_images/junctionBoxCategoryImage.png'
            ],
            [
                'name' => 'Wire', 
                'image' => 'static/images/category_images/wireCategoryImage.png'
            ],
            [
                'name' => 'Cable', 
                'image' => 'static/images/category_images/cableCategoryImage.png'
            ]
        ];
        foreach ($categories as $category) {
            Category::factory()->create($category);
        }

        $tags = [
            [
                'name' => 'Woodlights', 
            ],
            [
                'name' => 'Dinning', 
            ],
            [
                'name' => 'Bedroom', 
            ],
            [
                'name' => 'Living room', 
            ],
            [
                'name' => 'Three phase', 
            ],
            [
                'name' => 'Single phase', 
            ],
            [
                'name' => 'Scatola', 
            ]
        ];
        foreach ($tags as $tag) {
            Tag::factory()->create($tag);
        }

    
        Setting::factory()->create([
            'contact_phone' => '+251 912690007',
            'contact_email' => 'ellielectronics@gmail.com',
            'address' => 'Ureal, Addis Abeba, Ethiopia',
            'logo' => 'storage/images/logo/logo.png'
        ]);
        Socialmedia::factory()->create([
            'tiktok' => 'https://www.tiktok.com/@ellielectricalequipment',
            'instagram' => 'https://www.instagram.com/elli_electrical_equipment',
        ]);


    }
}
