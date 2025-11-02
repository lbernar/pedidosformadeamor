<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Color;
use App\Models\EndCategory;
use App\Models\Faq;
use App\Models\MidCategory;
use App\Models\Product;
use App\Models\Size;
use App\Models\Slider;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Colors
        $colors = [
            ['name' => 'Black', 'hex_code' => '#000000'],
            ['name' => 'White', 'hex_code' => '#FFFFFF'],
            ['name' => 'Red', 'hex_code' => '#FF0000'],
            ['name' => 'Blue', 'hex_code' => '#0000FF'],
            ['name' => 'Green', 'hex_code' => '#00FF00'],
            ['name' => 'Yellow', 'hex_code' => '#FFFF00'],
            ['name' => 'Pink', 'hex_code' => '#FFC0CB'],
            ['name' => 'Purple', 'hex_code' => '#800080'],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }

        echo "✓ Colors created\n";

        // Create Sizes
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        foreach ($sizes as $size) {
            Size::create(['name' => $size]);
        }

        echo "✓ Sizes created\n";

        // Create Categories
        $menCategory = Category::create([
            'name' => 'Men',
            'show_on_menu' => true,
        ]);

        $womenCategory = Category::create([
            'name' => 'Women',
            'show_on_menu' => true,
        ]);

        $kidsCategory = Category::create([
            'name' => 'Kids',
            'show_on_menu' => true,
        ]);

        echo "✓ Top categories created\n";

        // Create Mid Categories
        $menClothing = MidCategory::create([
            'name' => 'Clothing',
            'top_category_id' => $menCategory->id,
        ]);

        $menAccessories = MidCategory::create([
            'name' => 'Accessories',
            'top_category_id' => $menCategory->id,
        ]);

        $womenClothing = MidCategory::create([
            'name' => 'Clothing',
            'top_category_id' => $womenCategory->id,
        ]);

        $womenAccessories = MidCategory::create([
            'name' => 'Accessories',
            'top_category_id' => $womenCategory->id,
        ]);

        echo "✓ Mid categories created\n";

        // Create End Categories
        $menTshirts = EndCategory::create([
            'name' => 'T-Shirts',
            'mid_category_id' => $menClothing->id,
        ]);

        $menJeans = EndCategory::create([
            'name' => 'Jeans',
            'mid_category_id' => $menClothing->id,
        ]);

        $womenDresses = EndCategory::create([
            'name' => 'Dresses',
            'mid_category_id' => $womenClothing->id,
        ]);

        $womenBags = EndCategory::create([
            'name' => 'Bags',
            'mid_category_id' => $womenAccessories->id,
        ]);

        echo "✓ End categories created\n";

        // Create Products
        $products = [
            [
                'name' => 'Classic Black T-Shirt',
                'current_price' => 49.90,
                'old_price' => 79.90,
                'qty' => 100,
                'featured_photo' => 'product-1.jpg',
                'description' => 'High-quality cotton t-shirt perfect for everyday wear. Comfortable, durable, and stylish.',
                'short_description' => 'Premium cotton t-shirt',
                'is_featured' => true,
                'is_active' => true,
                'end_category_id' => $menTshirts->id,
            ],
            [
                'name' => 'Slim Fit Blue Jeans',
                'current_price' => 129.90,
                'old_price' => 199.90,
                'qty' => 50,
                'featured_photo' => 'product-2.jpg',
                'description' => 'Modern slim fit jeans with stretch denim for maximum comfort. Perfect for casual or semi-formal occasions.',
                'short_description' => 'Comfortable stretch denim jeans',
                'is_featured' => true,
                'is_active' => true,
                'end_category_id' => $menJeans->id,
            ],
            [
                'name' => 'Summer Floral Dress',
                'current_price' => 159.90,
                'qty' => 30,
                'featured_photo' => 'product-3.jpg',
                'description' => 'Beautiful floral dress perfect for summer. Lightweight, breathable fabric with elegant design.',
                'short_description' => 'Elegant summer dress',
                'is_featured' => true,
                'is_active' => true,
                'end_category_id' => $womenDresses->id,
            ],
            [
                'name' => 'Leather Crossbody Bag',
                'current_price' => 249.90,
                'old_price' => 349.90,
                'qty' => 20,
                'featured_photo' => 'product-4.jpg',
                'description' => 'Genuine leather crossbody bag with multiple compartments. Stylish and practical for everyday use.',
                'short_description' => 'Premium leather bag',
                'is_featured' => true,
                'is_active' => true,
                'end_category_id' => $womenBags->id,
            ],
            [
                'name' => 'White Cotton T-Shirt',
                'current_price' => 39.90,
                'qty' => 150,
                'featured_photo' => 'product-5.jpg',
                'description' => 'Essential white t-shirt made from 100% cotton. A wardrobe staple for every man.',
                'short_description' => 'Basic white tee',
                'is_featured' => false,
                'is_active' => true,
                'end_category_id' => $menTshirts->id,
            ],
            [
                'name' => 'Ripped Black Jeans',
                'current_price' => 149.90,
                'qty' => 40,
                'featured_photo' => 'product-6.jpg',
                'description' => 'Trendy ripped jeans in black. Stylish distressed design for a modern look.',
                'short_description' => 'Trendy ripped jeans',
                'is_featured' => false,
                'is_active' => true,
                'end_category_id' => $menJeans->id,
            ],
            [
                'name' => 'Evening Cocktail Dress',
                'current_price' => 299.90,
                'old_price' => 449.90,
                'qty' => 15,
                'featured_photo' => 'product-7.jpg',
                'description' => 'Elegant cocktail dress perfect for special occasions. Sophisticated design with premium fabric.',
                'short_description' => 'Elegant evening dress',
                'is_featured' => false,
                'is_active' => true,
                'end_category_id' => $womenDresses->id,
            ],
            [
                'name' => 'Designer Tote Bag',
                'current_price' => 199.90,
                'qty' => 25,
                'featured_photo' => 'product-8.jpg',
                'description' => 'Spacious tote bag with designer touch. Perfect for work or shopping.',
                'short_description' => 'Stylish tote bag',
                'is_featured' => false,
                'is_active' => true,
                'end_category_id' => $womenBags->id,
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);

            // Attach random colors (2-4 colors per product)
            $randomColors = Color::inRandomOrder()->limit(rand(2, 4))->pluck('id');
            $product->colors()->attach($randomColors);

            // Attach random sizes (3-5 sizes per product)
            $randomSizes = Size::inRandomOrder()->limit(rand(3, 5))->pluck('id');
            $product->sizes()->attach($randomSizes);
        }

        echo "✓ Products created (with colors and sizes)\n";

        // Create Sliders
        Slider::create([
            'photo' => 'slider-1.jpg',
            'heading' => 'Welcome to Pedidos Forma de Amor',
            'content' => 'Discover our amazing collection of fashion items. Quality products at great prices!',
            'button_text' => 'Shop Now',
            'button_url' => '/products',
            'position' => 'center',
            'order' => 1,
            'is_active' => true,
        ]);

        Slider::create([
            'photo' => 'slider-2.jpg',
            'heading' => 'Summer Collection 2025',
            'content' => 'Fresh new styles for the summer season. Limited time offer!',
            'button_text' => 'View Collection',
            'button_url' => '/products',
            'position' => 'left',
            'order' => 2,
            'is_active' => true,
        ]);

        echo "✓ Sliders created\n";

        // Create FAQs
        $faqs = [
            [
                'question' => 'How long does shipping take?',
                'answer' => 'Standard shipping typically takes 5-7 business days. Express shipping is also available for 2-3 business days delivery.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'What is your return policy?',
                'answer' => 'We offer a 30-day return policy for all items. Items must be unused and in original packaging.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Do you ship internationally?',
                'answer' => 'Yes, we ship to most countries worldwide. Shipping costs and delivery times vary by destination.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept credit cards (Visa, Mastercard, Amex), PayPal, PIX, and bank transfers.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'How can I track my order?',
                'answer' => 'Once your order ships, you will receive a tracking number via email. You can also track your order in your customer dashboard.',
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        echo "✓ FAQs created\n";

        // Create a test customer
        Customer::create([
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'phone' => '+55 11 98765-4321',
            'address' => 'Rua Teste, 123',
            'city' => 'São Paulo',
            'state' => 'SP',
            'zip_code' => '01234-567',
            'country' => 'Brazil',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        echo "✓ Test customer created (email: customer@test.com, password: password)\n";

        echo "\n";
        echo "╔═══════════════════════════════════════════════════════════╗\n";
        echo "║                                                           ║\n";
        echo "║  ✅ DATABASE SEEDED SUCCESSFULLY!                         ║\n";
        echo "║                                                           ║\n";
        echo "║  Test Customer Login:                                     ║\n";
        echo "║  Email: customer@test.com                                 ║\n";
        echo "║  Password: password                                       ║\n";
        echo "║                                                           ║\n";
        echo "║  Products created: 8                                      ║\n";
        echo "║  Categories: 3 top, 4 mid, 4 end                         ║\n";
        echo "║  Colors: 8                                                ║\n";
        echo "║  Sizes: 6                                                 ║\n";
        echo "║  Sliders: 2                                               ║\n";
        echo "║  FAQs: 5                                                  ║\n";
        echo "║                                                           ║\n";
        echo "╚═══════════════════════════════════════════════════════════╝\n";
    }
}
