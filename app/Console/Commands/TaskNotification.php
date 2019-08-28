<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Libraries\Api;
use App\Models\Admin\Task;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\User;

class TaskNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salesforce:taskNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Task Notification Cron';

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
     * @return mixed
     */
    public function handle()
    {   
        Log::info('Command Started');
        $tasks=Task::select('*')
            ->where(DB::raw('date(date_time)'),'=',date('Y-m-d'))
            ->get();
        $users_list=$tasks->lists("salesperson_id");
        $users=User::select('*')
            ->whereIn('id',$users_list)
            ->lists('gcm_id','id');

        foreach ($users as $key => $value) {
            Log::info('User '.$key);
            $data_notification=[
                'page'=>'tasks',
                'date'=>date('Y-m-d')
            ];
            $tasks_count=Task::select('*')
                ->where(DB::raw('date(date_time)'),'=',date('Y-m-d'))
                ->where('salesperson_id','=',$key)
                ->get();
            $task_count=count($tasks_count);

            $notification=Api::firebaseNotification('Area Change','Hello, Good Morning. Today You have '.strval($task_count).' to complete. Kindly contact your manager if any queries',$value,$data_notification,$key);
            Log::info('Notification Sended to '.$key);
        }
    }
}
