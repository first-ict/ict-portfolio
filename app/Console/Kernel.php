<?php

namespace App\Console;

use App\Models\File;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $slider = Slider::all();
            $data =  $slider->pluck('image_id')->toArray();
            $file = File::whereNotIn('id', $data)->get();
            $photos =  $file->pluck('file')->toArray();
            File::whereNotIn('id', $data)->delete();
            Storage::delete($photos);
        }) ->timezone('Asia/Yangon')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
