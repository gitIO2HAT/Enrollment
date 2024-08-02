<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use App\Models\Message;
use Pusher\Pusher;
use Illuminate\Support\Facades\DB;
use App\Events\TaskCreated;
use Illuminate\Support\Facades\Http;
use App\Rules\AfterOrEqualStart;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    public function announcement(Request $request)
    {
        $notification['notify'] = DB::select("
    SELECT
        users.id,
        users.name,
        users.lastname,
        users.email,
        COUNT(messages.is_read) AS unread
    FROM
        users
    LEFT JOIN
        messages ON users.id = messages.send_to AND messages.is_read = 0
    WHERE
        users.id = " . Auth::id() . "
    GROUP BY
        users.id, users.name, users.lastname, users.email
");

date_default_timezone_set('Asia/Manila');

// Get the current date and time in Asia/Manila timezone
$currentDateTime['currentDateTime'] = Carbon::now()->setTimezone('Asia/Manila');

        $users['users'] = User::all();

        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();



        $query = Task::getTask();
        $getAnn['getAnn'] = $query->orderby('scheduled_date', 'asc')->paginate(10);

        $query = Task::getCompleted();
        $getCompleted['getCompleted'] = $query->orderby('scheduled_date', 'asc')->paginate(10);





        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.announcement.announcement'
            : (Auth::user()->user_type == 1
                ? 'admin.announcement.announcement'
                : 'employee.dashboard');


        return view($viewPath, [
            'notification' => $notification,
            'getNot' => $getNot,
            'getAnn' => $getAnn['getAnn'],
            'getCompleted' => $getCompleted['getCompleted'],
            'currentDateTime' => $currentDateTime['currentDateTime'],
            'users' => $users['users'], // Access the 'users' array directly
        ]);
    }

    public function read($id)
    {

        $read = Message::getID($id);
        $read->is_read = 1;
        $read->save();
        return redirect()->back();
    }

    public function save_task(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:50',
        'description' => 'required|string',
        'scheduled_date' => 'nullable|date',
        'scheduled_end' => [
            'nullable',
            'date',
            new AfterOrEqualStart($request->input('scheduled_date')),
        ],
        'selected_users' => 'nullable|array',
    ], [
        'title.required' => 'The title field is required.',
        'description.required' => 'The description field is required.',
        'scheduled_end.after_or_equal_start' => 'The end date and time must be after or equal to the start date and time.',
    ]);

    $task = new Task;
    $task->title = $request->title;
    $task->description = $request->description;
    $task->scheduled_date = $request->input('scheduled_date');
    $task->scheduled_end = $request->input('scheduled_end');

    // Check if specific users are selected
    $selectedUsers = $request->input('selected_users', []);

    // Get users based on selection
    $users = $selectedUsers ? User::whereIn('id', $selectedUsers)->get() : User::all();

    $notificationSent = false;

    foreach ($users as $user) {
        $message = new Message;
        $message->send_to = $user->id;
        $message->from = Auth::user()->name;
        $message->profile_pic = Auth::user()->profile_pic;
        $message->title_message = $task->title;
        $message->description_message = $task->description;

        // Send notification only if there is an internet connection
        if ($this->checkInternetConnection()) {
            $options = [
                'cluster' => 'ap2',
                'useTLS' => true,
            ];

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            $data = ['send_to' => $user->id];
            $pusher->trigger('my-channel', 'my-event', $data);
            $notificationSent = true;
        }

        // Save message to the database only if notification was sent successfully
        if ($notificationSent) {
            $message->save();
        }
    }

    // Save task only if notification was sent successfully
    if ($notificationSent) {
        $task->save();
        broadcast(new TaskCreated($task, $message));
        return redirect()->back()->with('success', 'Announcement successfully sent');
    } else {
        return redirect()->back()->with('error', 'No internet connection');
    }
}

private function checkInternetConnection()
{
    try {
        $response = Http::get('https://www.google.com');
        return $response->successful();
    } catch (\Exception $e) {
        return false;
    }
}



}
