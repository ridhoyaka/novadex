<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Services\CategoryIconService;

class UpdateCategoryIconsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        $this->command->info("Updating icons for {$categories->count()} categories...\n");
        
        foreach ($categories as $category) {
            $icon = CategoryIconService::getIcon($category->nama_kategori);
            
            $category->update(['icon' => $icon]);
            
            $this->command->info("✅ {$icon} {$category->nama_kategori}");
        }
        
        $this->command->info("\n🎉 Successfully updated all category icons!");
    }
}
