<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\LostinTaste\User;
use App\Models\LostinTaste\Post;
use App\Models\LostinTaste\SavedPost;
use App\Models\LostinTaste\Schedule;
use App\Models\LostinTaste\Attendee;
use App\Models\LostinTaste\Info;
use App\Models\LostinTaste\Message;

class QueryService 
{
    public function paginate($query)
    {
        return $query->where('user_id', '=', auth()->user()->id)
        ->orderBy('id', 'DESC')
        ->paginate(4);
    }
    // User Service
    public function createUserInfo()
    {
        $user = auth()->user();
            return (!$user->info) ? $user->info()->create(['user_id' => $user->id]) : '';
    }

    public function updateUser($array)
    {
        return auth()->user()->info()->update($array);
    }

    public function findUser($id)
    {
        return User::find($id);
    }

    public function findUserByName($input)
    {
        return User::where('name','LIKE', '%'.$input.'%')->get();
    }

    // Post Service
    public function createPost($array)
    {
        return Post::create($array);
    }

    public function readPost()
    {
        return $this->paginate($this->getPostWithUser());
    }
    
    public function updatePost($array)
    {
        return Post::find($array['id'])->update($array);
    }

    public function deletePost($id)
    {
        return Post::find($id)->delete();
    }

    public function findPost($id)
    {
        return $this->getPostWithUser()->find($id);
    }

    public function getPostWithUser()
    {
        return Post::with('user', 'user.info');
    }

    public function getCheapestPost()
    {
        return Post::orderBy('price', 'ASC')->limit(6)->get();
    }

    // SavedPost Service
    public function createSavedpost($array)
    {
        return SavedPost::create($array);
    }
    
    public function readSavedpost()
    {
        return $this->paginate(SavedPost::with(['post', 'post.user', 'post.user.info']));
    }

    public function updateSavedpost($id, $mode)
    {
        return Savedpost::find($id)->update(['mode' => ($mode == 'only') ? 'Chỉ mình tôi' : 'Tất cả']);
    }

    public function deleteSavedpost($id)
    {
        return SavedPost::find($id)->delete();
    }

    // Schedule Service
    public function createSchedule($array)
    {
        return Schedule::create($array);
    }

    public function readSchedule()
    {
        return $this->paginate(Schedule::with(['post', 'post.user', 'post.user.info', 'attendee.user']));
    }

     public function updateSchedule($array)
    {
        return Schedule::find($array['id'])->update($array);
    }

    public function deleteSchedule($id)
    {
        return Schedule::find($id)->delete();
    }

    public function findSchedule($id)
    {
        return Schedule::with(['post', 'post.user', 'post.user.info', 'attendee.user'])->find($id);
    }

    public function publicSchedule()
    {
        return Schedule::with(['post', 'post.user', 'post.user.info', 'attendee.user'])
        ->where('mode', '<>', 'solo')
        ->orderBy('id', 'DESC')
        ->get();
    }

    // Attendee Service
    public function createAttendee($array)
    {
        return Attendee::create($array);
    }

    public function hasAttended($userId, $scheduleId)
    {
        return (count(Attendee::where('user_id', '=', $userId)
        ->where('schedule_id', '=', $scheduleId)->get()) == 0) ? false : true;
    }

    public function deleteAttendee($id)
    {
        return Attendee::find($id)->delete();
    }

    // Message Service
    public function createMessage($array)
    {
        return Message::create($array);
    }

    public function getMessageWith($id)
    {
        $userId = auth()->user()->id;
        $inbox = collect();
        foreach(Message::where('subject_id', '=', $userId)
        ->where('object_id', '=', $id)->get() as $m){
            $inbox->push($m);
        }
        foreach(Message::where('object_id', '=', $userId)
        ->where('subject_id', '=', $id)->get() as $m){
            $inbox->push($m);
        }
        return $inbox;
    }

    public function getAllMessages()
    {
        $userId = auth()->user()->id;
        $message = collect();
        foreach(Message::where('subject_id', '=', $userId)
        ->select('object_id')
        ->distinct()
        ->get() as $o){
            $message->push($o);
        }
        foreach(Message::where('object_id', '=', $userId)
        ->select('subject_id')
        ->distinct()
        ->get() as $u){
            foreach($message as $m){
                if($u->object_id == $m->subject_id){
                    $message->pop($m);
                }
            }
            $message->push($u);
        }
        return $message;
    }
}