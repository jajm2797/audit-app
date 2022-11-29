<?php

namespace App\Console\Commands;

use App\Mail\FindReminderMail;
use App\Models\Find;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FindReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifica a los Usuarios los Hallazgos que están por vencer con una semana de antelación';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $finds = Find::where('status', 1)
        ->with(['user','audit'])
        ->orderBy('end_date', 'asc')
        ->get();

        foreach ($finds as $find) {
            Mail::to($find->user->email)
            ->send(new FindReminderMail($find));
        }

        $this->info('Successfully sent daily quote to everyone.');
    }
}
