# How to Queue Jobs works in Laravel
We have some tasks that takes to long to perform during a typical web request.Thankfully, [Laravel](https://laravel.com/) allows you to easily create queued jobs that may be processed in the background
Install maatwebsite/excel library by composer.

In your application to use the database driver by updating the `QUEUE_CONNECTION` variable in your .env file:
```env
QUEUE_CONNECTION=database
```

Using database queue driver we need to add database queue table for hold jobs.
```
php artisan queue:table
 
php artisan migrate
```

Generating Job Classes when you run the `make:job` Artisan command
```
php artisan make:job EventMailJob
```

### Handle Job Dispatch code in your controller

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\EventMailJob;

class JobDispatchController extends Controller
{
    public function dispatchPostJob(Request $request){
        EventMailJob::dispatch()->onQueue('high');
        return redirect()->route('home')->withMessage('Job dispatched successfully');
    }
}


```
### Now Update EventMailJob Class path `App\Jobs`

```php

public function handle(){
    $users=User::whereNotNull('email')->get()->toArray();
    if($users){
        foreach($users as $user){
            Mail::send('mail/events-email-template',['name'=>$user['name']],function($message) use($user){
                $message->from('no-reply@example.com','Project Name');
                $message->to($user['email']);
                $message->subject('Events Invitation');
            });
        }
    }
}

```
### Now run the `queue:work` artisan command
Note : once the queue:work command has started, it will continue to run. if command stopped then queue not working
```
php artisan queue:work
```
