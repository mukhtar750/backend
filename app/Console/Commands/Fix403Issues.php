<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class Fix403Issues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:403-issues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix 403 error issues for BDSP training modules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== FIXING 403 ERROR ISSUES ===');
        $this->newLine();

        // 1. Fix orphaned training modules
        $this->info('1. FIXING ORPHANED TRAINING MODULES:');
        
        // Find orphaned modules
        $orphanedModules = DB::table('training_modules as tm')
            ->leftJoin('users as u', 'tm.bdsp_id', '=', 'u.id')
            ->whereNull('u.id')
            ->orWhere('u.role', '!=', 'bdsp')
            ->select('tm.id', 'tm.title', 'tm.bdsp_id')
            ->get();

        if ($orphanedModules->isNotEmpty()) {
            $this->warn("   Found " . $orphanedModules->count() . " orphaned modules:");
            foreach ($orphanedModules as $module) {
                $this->line("     - {$module->title} (BDSP ID: {$module->bdsp_id})");
            }

            // Get first approved BDSP
            $firstBdsp = DB::table('users')
                ->where('role', 'bdsp')
                ->where('is_approved', 1)
                ->orderBy('id')
                ->first();

            if ($firstBdsp) {
                $this->line("   Assigning orphaned modules to: {$firstBdsp->name}");
                
                // Update orphaned modules
                $updated = DB::table('training_modules as tm')
                    ->leftJoin('users as u', 'tm.bdsp_id', '=', 'u.id')
                    ->whereNull('u.id')
                    ->orWhere('u.role', '!=', 'bdsp')
                    ->update(['tm.bdsp_id' => $firstBdsp->id]);

                $this->line("   ✓ Updated {$updated} orphaned modules");
            } else {
                $this->error('   ✗ No approved BDSP found to assign modules to');
            }
        } else {
            $this->line('   ✓ No orphaned modules found');
        }
        $this->newLine();

        // 2. Clear all caches
        $this->info('2. CLEARING CACHES:');
        try {
            Artisan::call('optimize:clear');
            $this->line('   ✓ All caches cleared successfully');
        } catch (\Exception $e) {
            $this->error('   ✗ Error clearing caches: ' . $e->getMessage());
        }
        $this->newLine();

        // 3. Cache routes for production
        $this->info('3. CACHING ROUTES:');
        try {
            Artisan::call('route:cache');
            $this->line('   ✓ Routes cached successfully');
        } catch (\Exception $e) {
            $this->error('   ✗ Error caching routes: ' . $e->getMessage());
        }
        $this->newLine();

        // 4. Verify BDSP module ownership
        $this->info('4. VERIFYING BDSP MODULE OWNERSHIP:');
        $bdsps = DB::table('users')
            ->where('role', 'bdsp')
            ->where('is_approved', 1)
            ->get();

        foreach ($bdsps as $bdsp) {
            $moduleCount = DB::table('training_modules')
                ->where('bdsp_id', $bdsp->id)
                ->count();
            
            $this->line("   {$bdsp->name}: {$moduleCount} modules");
        }
        $this->newLine();

        // 5. Check for any remaining issues
        $this->info('5. FINAL VERIFICATION:');
        
        // Check for modules without valid BDSP owners
        $invalidModules = DB::table('training_modules as tm')
            ->leftJoin('users as u', 'tm.bdsp_id', '=', 'u.id')
            ->whereNull('u.id')
            ->orWhere('u.role', '!=', 'bdsp')
            ->count();

        if ($invalidModules == 0) {
            $this->line('   ✓ All modules have valid BDSP owners');
        } else {
            $this->error("   ✗ {$invalidModules} modules still have invalid owners");
        }

        // Check total modules
        $totalModules = DB::table('training_modules')->count();
        $this->line("   Total training modules: {$totalModules}");

        $this->newLine();
        $this->info('=== FIX COMPLETE ===');
        $this->line('Please test BDSP access to training modules now.');
        
        return 0;
    }
}
