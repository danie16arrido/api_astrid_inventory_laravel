<?php
use Faker\Factory as Faker;
use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder {

  public function run()
  {
    $faker = Faker::create();
    foreach (range(1,10) as $index) {
      Category::create([
        'name' => $faker->unique->word()
      ]);
    }
  }
}
