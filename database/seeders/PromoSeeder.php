<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Promo::factory()->state(
            [
                'promo_name' => "New Year's Sale",
                'promo_image' => "https://i.ytimg.com/vi/QgS6ezJ1YIA/maxresdefault.jpg",
                'promo_description' => "New Year's Sale up to 70% off. Sale ends at 4th January.",
            ])->create();

        Promo::factory()->state(
            [
                'promo_name' => "Santa's Surprise",
                'promo_image' => "https://a.storyblok.com/f/157322/1500x1000/e184e8dfb3/los-angeles-thrift-stores-feature.jpg",
                'promo_description' => "Christmas Sale up to 50% off. Sale ends at 31th December."
            ])->create();

        Promo::factory()->state(
            [
                'promo_name' => "Driver's Night",
                'promo_image' => "https://imgx.parapuan.co/crop/0x0:0x0/360x240/photo/2021/10/30/istock-485039700jpg-20211030010755.jpg",
                'promo_description' => "Sale on driving products."
            ])->create();

        Promo::factory()->state(
            [
                'promo_name' => "Super Sale",
                'promo_image' => "https://www.popsci.com/wp-content/uploads/2021/02/25/MCJEXOO3WVBGZERMPADG3MIZHY-scaled.jpg?w=2560",
                'promo_description' => "Sale up to 75% off, limited time only."
            ])->create();

        Promo::factory()->state(
            [
                'promo_name' => "PB's Magical Blessing",
                'promo_image' => "https://assets3.thrillist.com/v1/image/3146699/828x610/flatten;crop;webp=auto;jpeg_quality=60.jpg",
                'promo_description' => "Up to 100% off."
            ])->create();

    }
}
