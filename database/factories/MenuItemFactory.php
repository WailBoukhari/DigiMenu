<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;

class MenuItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MenuItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Predefined meal names and descriptions
        $mealNames = [
            'Spaghetti Carbonara',
            'Chicken Parmesan',
            'Caesar Salad',
            'Margherita Pizza',
            'Grilled Salmon',
            'Beef Burger',
            'Fish and Chips',
            'Tacos al Pastor',
            'Pad Thai',
            'Sushi Platter',
            'Chicken Tikka Masala',
            'Caprese Salad',
            'Vegetable Stir-Fry',
            'Shrimp Scampi',
            'BBQ Ribs',
            'Mushroom Risotto',
            'Chicken Caesar Wrap',
            'Lobster Bisque',
            'Fettuccine Alfredo',
            'Pulled Pork Sandwich',
            'Vegetable Curry',
            'Steak Frites',
            'Falafel Wrap',
            'Greek Salad',
            'Clam Chowder',
            'Eggplant Parmesan',
            'Beef Wellington',
            'Chili Con Carne',
            'Cobb Salad',
            'Shrimp Fried Rice',
            'Beef Tacos',
            'Roast Beef Dinner',
            'Sesame Chicken',
            'Spinach and Ricotta Cannelloni',
            'Chicken Quesadilla',
            'Pesto Pasta',
            'Turkey Club Sandwich',
            'Seafood Paella',
            'Beef Stroganoff',
            'Vegetable Lasagna',
            'Gyro Platter',
            'Butter Chicken',
            'Vegetarian Chili',
            'Tom Yum Soup',
            'Steamed Mussels',
            'Portobello Burger',
            'Hawaiian Pizza',
            'Peking Duck',
            'Shrimp Cocktail',
            'Beef Kebabs',
            'Egg Foo Young',
            'Chimichanga',
            'Teriyaki Salmon',
            'Lamb Gyro',
            'Ratatouille',
            'Beef Pho',
            'Pasta Primavera',
            'Chicken Satay',
            'Falafel Plate',
            'Lemon Herb Roast Chicken',
            'Shrimp and Grits',
            'Vegetable Tempura',
            'Beef Enchiladas',
            'Margherita Flatbread',
            'Chicken Shawarma',
            'Pumpkin Ravioli',
            'Beef Teriyaki Bowl',
            'Eggplant Rollatini',
            'Cajun Shrimp Pasta',
            'Meatball Sub',
            'Vegetable Paella',
            'Szechuan Tofu',
            'Mushroom Swiss Burger',
            'Beef Ramen',
            'Pulled Chicken Tacos',
            'Egg Drop Soup',
            'Caprese Flatbread',
            'Vegetable Korma',
            'BBQ Chicken Pizza',
            'Lamb Tagine',
            'Shrimp Po Boy',
            'Chicken Fajitas',
            'Crab Cakes',
            'Vegetable Biryani',
            'Beef Gyro'
        ];

        $mealDescriptions = [
            'Delicious pasta dish with creamy sauce, pancetta, and Parmesan cheese.',
            'Juicy chicken breasts coated in breadcrumbs, topped with marinara sauce and melted mozzarella cheese.',
            'Crisp romaine lettuce tossed with Caesar dressing, croutons, and Parmesan cheese.',
            'Classic pizza topped with tomato sauce, mozzarella cheese, and fresh basil.',
            'Perfectly grilled salmon served with a side of roasted vegetables and lemon-butter sauce.',
            'Succulent beef patty served on a toasted bun with lettuce, tomato, and onion.',
            'Crispy battered fish served with French fries and tartar sauce.',
            'Authentic Mexican tacos with marinated pork, onions, pineapple, and cilantro.',
            'Stir-fried rice noodles with tofu, egg, peanuts, and bean sprouts.',
            'Assortment of fresh fish and seafood served with soy sauce, wasabi, and pickled ginger.',
            'Creamy tomato-based curry with tender pieces of chicken, served with rice or naan bread.',
            'Fresh salad with tomatoes, mozzarella cheese, basil, and balsamic glaze.',
            'Assorted vegetables stir-fried in a savory sauce, served over rice or noodles.',
            'Tender shrimp cooked in garlic, butter, and white wine sauce, served with pasta.',
            'Tender pork ribs smothered in barbecue sauce, served with coleslaw and fries.',
            'Creamy Italian rice dish cooked with mushrooms, onions, and Parmesan cheese.',
            'Grilled chicken wrapped in a tortilla with Caesar salad and Parmesan cheese.',
            'Rich and creamy soup made with lobster, cream, and sherry.',
            'Creamy pasta dish with fettuccine noodles and Parmesan cheese sauce.',
            'Tender pulled pork piled high on a bun with barbecue sauce and coleslaw.',
            'Spicy curry dish with mixed vegetables and your choice of protein.',
            'Grilled steak served with crispy French fries and a side of sauce.',
            'Delicious falafel wrapped in a pita with lettuce, tomato, and tahini sauce.',
            'Fresh salad with tomatoes, cucumbers, olives, feta cheese, and Greek dressing.',
            'Creamy soup made with clams, potatoes, onions, and cream.',
            'Breaded and fried eggplant slices topped with marinara sauce and melted mozzarella cheese.',
            'Tender beef filet wrapped in puff pastry, baked until golden brown.',
            'Spicy stew made with ground beef, beans, tomatoes, and spices.',
            'Fresh salad with chicken, bacon, avocado, tomatoes, and blue cheese dressing.',
            'Stir-fried rice with shrimp, vegetables, and soy sauce.',
            'Tender beef served in soft corn tortillas with onions, cilantro, and salsa.',
            'Traditional Sunday dinner with roast beef, mashed potatoes, and gravy.',
            'Crispy battered chicken tossed in a sweet and tangy sauce, served with rice.',
            'Delicious pasta tubes stuffed with spinach and ricotta cheese, baked with marinara sauce.',
            'Grilled chicken and melted cheese sandwiched between flour tortillas, served with salsa and sour cream.',
            'Fresh basil pesto tossed with pasta and cherry tomatoes.',
            'Classic sandwich with turkey, bacon, lettuce, tomato, and mayonnaise.',
            'Spanish rice dish with shrimp, mussels, clams, chorizo, and saffron.',
            'Tender strips of beef cooked in a creamy mushroom sauce, served with noodles or rice.',
            'Layered pasta dish with vegetables, ricotta cheese, and marinara sauce.',
            'Grilled gyro meat served with pita bread, tzatziki sauce, and Greek salad.',
            'Tender chicken cooked in a creamy tomato-based sauce, served with rice or naan bread.',
            'Hearty vegetarian chili made with beans, vegetables, and spices.',
            'Spicy and sour soup made with shrimp, lemongrass, and Thai spices.',
            'Steamed mussels cooked in a flavorful broth of white wine, garlic, and herbs.',
            'Grilled portobello mushroom served on a bun with Swiss cheese, lettuce, and tomato.',
            'Hawaiian-style pizza topped with ham, pineapple, and mozzarella cheese.',
            'Roasted duck served with pancakes, hoisin sauce, and scallions.',
            'Chilled shrimp served with cocktail sauce, lemon wedges, and crackers.',
            'Skewered pieces of beef grilled to perfection, served with vegetables and rice.',
            'Egg omelette with vegetables and meat, served with gravy or sauce.',
            'Deep-fried burrito filled with meat, cheese, beans, and vegetables.',
            'Grilled salmon fillet glazed with teriyaki sauce, served with rice and steamed vegetables.',
            'Grilled lamb served with pita bread, tzatziki sauce, and Greek salad.',
            'Vegetarian dish made with stewed vegetables, herbs, and olive oil.',
            'Vietnamese noodle soup with beef, herbs, and rice noodles.',
            'Pasta dish with fresh vegetables sautéed in olive oil and garlic.',
            'Grilled chicken skewers served with peanut sauce and cucumber salad.',
            'Fried chickpea patties served with pita bread, hummus, and salad.',
            'Roast chicken seasoned with lemon, garlic, and herbs, served with roasted potatoes.',
            'Southern-style dish with shrimp served over creamy grits.',
            'Assorted vegetables dipped in tempura batter and deep-fried until crispy.',
            'Corn tortillas filled with beef, cheese, and enchilada sauce, baked until bubbly.',
            'Thin-crust pizza topped with tomato sauce, mozzarella cheese, and fresh basil.',
            'Thinly sliced marinated chicken served in a pita with vegetables and tahini sauce.',
            'Ravioli stuffed with pumpkin and served with sage butter sauce.',
            'Grilled beef served over rice with teriyaki sauce and vegetables.',
            'Rolled eggplant slices filled with ricotta cheese, baked with marinara sauce.',
            'Spicy pasta dish with shrimp, sausage, peppers, onions, and tomatoes.',
            'Meatballs served on a sub roll with marinara sauce and melted cheese.',
            'Vegetarian paella made with rice, vegetables, and saffron.',
            'Spicy tofu stir-fried with vegetables in a flavorful Szechuan sauce.',
            'Grilled beef patty topped with sautéed mushrooms and Swiss cheese, served on a bun.',
            'Japanese noodle soup with beef, green onions, and broth.',
            'Soft corn tortillas filled with pulled chicken, salsa, and toppings.',
            'Chinese soup made with beaten eggs and chicken broth.',
            'Flatbread topped with mozzarella cheese, tomatoes, and basil.',
            'Indian curry dish made with vegetables, nuts, and creamy sauce.',
            'Barbecue chicken pizza with red onions, cilantro, and mozzarella cheese.',
            'Moroccan stew made with lamb, vegetables, and spices.',
            'Breaded shrimp served on a baguette with lettuce, tomato, and remoulade sauce.',
            'Sizzling chicken and vegetable fajitas served with tortillas, guacamole, and sour cream.',
            'Pan-fried crab cakes served with remoulade sauce and lemon wedges.',
            'Fragrant rice dish with mixed vegetables and aromatic spices.',
            'Grilled lamb and beef wrapped in pita bread with vegetables and tzatziki sauce.'
        ];

        return [
            'menu_id' => Menu::factory(),
            'name' => $this->faker->randomElement($mealNames),
            'description' => $this->faker->randomElement($mealDescriptions),
            'price' => $this->faker->randomFloat(2, 5, 20),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (MenuItem $menuItem) {
            // Fetch a random food-related image from Pexels
            $response = Http::withHeaders([
                'Authorization' => 'J5F0HckUWmzyts9LEy5sYtJSxRqzj45vuHYCETcve6wfNvbXkEuuBuPg',
            ])->get('https://api.pexels.com/v1/search?query=food&per_page=80&page=1');

            // Check if the request was successful and extract the image URL from the response
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['photos'][0]['src']['original'])) {
                    $imageUrl = $data['photos'][0]['src']['original'];

                    // Attach demo image to the menu item
                    $menuItem->addMediaFromUrl($imageUrl)->toMediaCollection('images');
                }
            }
        });
    }


}
