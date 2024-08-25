<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Models\Product;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

class ProductTest extends DuskTestCase
{
    // use DatabaseMigrations;

    /**
     * Test product index.
     *
     * @return void
     */
    public function testProductsIndex()
    {
        Product::create(
            [
                'name' => 'car',
                'description' => 'City Trailer cars are manufactured from high quality, non-toxic metal. The complex printing process ensures clear colors and high gloss on the top coat. Each model is modeled on famous designs in a sophisticated, beautiful and precise manner in every detail of the real car.',
                'price' => '200.00'
            ],
            [
                'name' => 'Helicopter',
                'description' => 'KIDZYMON® Remote Control Helicopter with Radio Remote Control and Hand Sensor Charging Helicopter 2 in 1 Toys with 3D Light Toys for Boys Kids (Indoor & Outdoor Flying) (Blue)',
                'price' => '500.00'
            ]
    );

        $this->browse(function (Browser $browser) {
            $browser->visit('/products')
                    ->assertSee('Product List')
                    ->assertVisible('.table-bordered')
                    ->assertSee('ID')
                    ->assertSee('Name') 
                    ->assertSee('Description')
                    ->assertSee('Price')
                    ->assertSee('Actions')
                    ->assertSeeIn('tbody tr:first-child td:nth-child(2)', Product::first()->name);
        });
    }

    /**
     * Test product creation.
     *
     * @return void
     */
    public function testCreateProduct()
    {
        $this->browse(function (Browser $browser) {
            $faker = Faker::create();
            $randomImagePath = $faker->image(storage_path('app/public/images'), 640, 480, null, false);

            $browser->visit('/products')
                    ->clickLink('Add New Product')
                    ->assertPathIs('/products/create')
                    ->type('name', 'Barbie doll')
                    ->type('description', 'Barbie Doll and Fairytale Dress-Up Set, Clothes and Accessories for Princess, Mermaid and Fairy Characters, Kids Toys and Gifts​.')
                    ->type('price', '1299.99')
                    ->attach('image', storage_path('app/public/images') . '/' . $randomImagePath)
                    ->pause(1000)
                    ->press('Create Product')
                    ->assertPathIs('/products')
                    ->assertSee('Product created successfully.')
                    ->assertSee('Barbie doll');
        });
    }

    /**
     * Test product editing.
     *
     * @return void
     */
    public function testEditProduct()
    {
        $product = Product::create([
            'name' => 'Speaker',
            'description' => 'Electronics.',
            'price' => '1599.00'
        ]);

        $this->browse(function (Browser $browser) use ($product) {
            
            $browser->visit('/products')
                    ->click('.btn-edit-' . $product->id)
                    ->assertPathIs('/products/' . $product->id . '/edit')
                    ->type('name', 'Head set')
                    ->pause(1000)
                    ->press('Update Product')
                    ->assertPathIs('/products')
                    ->assertSee('Product updated successfully.')
                    ->assertSee('Head set');
        });
    }

    /**
     * Test product deletion.
     *
     * @return void
     */
    public function testDeleteProduct()
    {
        $product = Product::create([
            'name' => 'toy',
            'description' => 'doll',
            'price' => '20.00'
        ]);

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products')
                    ->assertSee('Delete')
                    ->press('.btn-del-' . $product->id)
                    ->pause(1000)
                    ->assertDialogOpened('Are you sure you want to delete this product?')
                    ->pause(1000)
                    ->acceptDialog()
                    ->assertPathIs('/products');
        });
    }
}
