<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Branch;
use Illuminate\Support\Str;

class GenerateBranchSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'branch:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for existing branches based on name';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $branches = Branch::whereNull('slug')->orWhere('slug', '')->get();

        $this->info("Found {$branches->count()} branches without slugs.");

        foreach ($branches as $branch) {
            $slug = Str::slug($branch->name);
            
            // Check uniqueness basic
            $count = Branch::where('slug', $slug)->where('id', '!=', $branch->id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . $branch->id;
            }

            $branch->slug = $slug;
            $branch->saveQuietly(); // Use saveQuietly to avoid triggering events if needed, but save() is fine too.
            
            $this->info("Generated slug for '{$branch->name}': {$slug}");
        }

        $this->info('All slugs generated successfully!');
    }
}
