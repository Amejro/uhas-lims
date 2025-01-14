<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Sample;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifySampleStatusJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    // public function handle(): void
    // {
    //     //
    // }

    public function handle()
    {
        $now = Carbon::now();

        // Two-week reminders
        $twoWeekSamples = Sample::where('status', 'collected')
            ->where('created_at', '<=', $now->subWeeks(2))
            ->get();

        // Three-week reminders
        $threeWeekSamples = Sample::where('status', 'collected')
            ->where('created_at', '<=', $now->subWeeks(3))
            ->get();

        $all = Sample::all();

        // Get all technicians and admins
        $recepients = User::with('role')->whereHas('role', function ($query) {
            $query->where('id', Role::TECHNICIAN)->orWhere('id', Role::SUPER_AMINISTRATOR)->orWhere('id', Role::AMINISTRATOR) ;
        })->get();



        if ($twoWeekSamples->count() > 0) {
            foreach ($twoWeekSamples as $sample) {

                foreach ($recepients as $receipient) {
                    Notification::make()
                        ->title('Reminder:')
                        ->body( "Sample $sample->serial_code has been in collected state for two weeks.")
                        ->warning()
                        ->actions([
                            Action::make('View Sample')
                                ->url(url('/samples/' . $sample->id))
                                ->markAsRead(),
                        ])
                        ->sendToDatabase($receipient);
                }

            }
        }


        if ($threeWeekSamples->count() > 0) {

            foreach ($threeWeekSamples as $sample) {
                foreach ($recepients as $receipient) {
                    Notification::make()
                        ->title('Reminder')
                        ->warning()
                        ->body("Sample $sample->serial_code has been in collected state for three weeks.")
                        ->actions([
                            Action::make('View Sample')
                                ->url(url('/samples/' . $sample->id))
                                ->markAsRead(),
                        ])
                        ->sendToDatabase($receipient);
                }
            }
        }
    }
}
