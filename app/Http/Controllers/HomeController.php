<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB, \App\User,\App\Post,\App\Savedpost;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(count(\App\Info::where('user_id','=',auth()->user()->id)->get())==0){
            $new= new \App\Info();
            $new->user_id=auth()->user()->id;
            $new->save();
        }
        $var['user']=auth()->user();
        return view('home', $var);
    }
    public function push(){

        return view('push');
    }
    public function sendpush(Request $req){
        $new= new Post();
        $new->name=$req->name;
        $new->kind=$req->kind;
        $new->price=$req->price;
        $new->district=$req->district;
        $new->province=$req->province;
        $new->address=$req->address;
        $new->picture=$req->picture;
        $new->time=$req->time;
        $new->user_id=auth()->user()->id;
        $new->save();
        $var['user']=auth()->user();
        $var['post']=Post::where('user_id','=',$var['user']->id)->orderBy('id','DESC')->paginate(4);
        return redirect('post');
        
    }
    public function profile($id){
        $var['user']=User::find($id);
        return view('profile', $var);
    }
    /*
    public function showall(){
        $var['post']=Post::all();
        return view('showall', $var);
    }*/
    public function newsavedpost($id){
        if(count(auth()->user()->savedpost
        ->where('post_id','=',$id))==0){
            $new= new Savedpost();
            $new->mode="Tất cả";
            $new->user_id=auth()->user()->id;
            $new->post_id=$id;
            $new->save();
        }
        else echo "   bạn đã lưu rồi";
        //return back();
    }
    public function newschedule($id){
        $p=Post::find($id);
        /*
        if(count(\App\Schedule::where('user_id','=',auth()->user()->id)
        ->where('post_id','=',$id)->get())==0){
            echo "New schedule";
        }
        else echo "   Bạn đã có schedule rồi";
        */
        return view('personal.newschedule', compact('p'));
    }
    public function insertschedule(Request $req){
        $new= new \App\Schedule();
        $new->time=$req->time;
        $new->mode=$req->mode;
        $new->user_id=auth()->user()->id;
        $new->post_id=$req->post_id;
        $new->save();
        $var['schedule']=\App\Schedule::where('user_id','=',auth()->user()->id)->orderBy('id', 'DESC')->paginate(4);
        return redirect('schedule');
    }
    public function update($name, $id, $mode=""){
        $var['isUser']="none";
        $var['isPost']="none";
        $var['isSchedule']="none";
        if($name=="savedpost"){
            /*$sp=\App\Savedpost::find($id);
            if($mode=="all") $sp->mode="Tất cả";
            if($mode=="only") $sp->mode="Chỉ mình tôi";
            $sp->save();*/
            $sp=DB::table('saved_posts')->where('id','=',$id);
            if($mode=="all") $sp->update(["mode"=>"Tất cả"]);
            if($mode=="only") $sp->update(["mode"=>"Chỉ mình tôi"]);
            return back();
        }
        if($name=="user"){
            $var['isUser']="block";
            $var['user']=User::find($id);
        }
        if($name=="post"){
            $var['isPost']="block";
            $var['post']=Post::find($id);
        }
        if($name=="schedule"){
            $var['isSchedule']="block";
            $var['schedule']=\App\Schedule::find($id);
        }
        return view('update', $var);
    }
    public function delete($name, $id){
        if($name=="post"){
            $post=\App\Post::find($id);
            $schedule=DB::table('schedules')
            ->where('post_id','=',$id)
            ->get();
            foreach($schedule as $s){
                DB::table('attendees')
                ->where('schedule_id','=',$s->id)
                ->delete();
            }
            $schedule=DB::table('schedules')
            ->where('post_id','=',$id)
            ->delete();
            $savedpost=DB::table('saved_posts')->where('post_id','=',$id);
            $savedpost->delete();
            $post->delete();
            return back();
        }
        if($name=="savedpost"){
            $sp=DB::table('saved_posts')->where('id','=',$id);
            $sp->delete();
            return back();
        }
        if($name=="schedule"){
            $sch=\App\Schedule::find($id);
            DB::table('attendees')
            ->where('schedule_id','=',$sch->id)
            ->delete();
            $sch->delete();
            return back();
        }
        if($name=="attend"){
            $a=\App\Attendee::find($id);
            $a->delete();
            return back();
        }
    }
    public function post(){
        $var['user']=auth()->user();
        $var['post']=Post::where('user_id','=',$var['user']->id)->orderBy('id','DESC')->paginate(4);
        return view('personal.post', $var);
    }
    public function savedpost()
    {
        $var['user']=auth()->user();
        $var['savedpost']=\App\SavedPost::where('user_id','=',$var['user']->id)->orderBy('id', 'DESC')->paginate(4);
        return view('personal.savedpost', $var);
    }
    public function schedule()
    {
        $var['user']=auth()->user();
        $var['schedule']=\App\Schedule::where('user_id','=',$var['user']->id)->orderBy('id', 'DESC')->paginate(4);
        return view('personal.schedule', $var);
    }
    public function friend()
    {
        $var['user']=auth()->user();
        $var['friend']=$var['user']->friend;
        $var['friendspost']=collect();
        foreach($var['user']->friend as $f){
            foreach($f->post as $p){
                $var['friendspost']->push($p);
            }
        }
        $var['friendspost']=$var['friendspost']->sortByDesc('id');
        
        $var['mightknow']=collect();
        $savedpost=auth()->user()->savedpost;
        foreach($savedpost as $sp){
            $postsaver=$sp->post->savedpost;
            foreach($postsaver as $saver){
                $var['mightknow']->push($saver->user);
            }
        }
        $var['mightknow']=$var['mightknow']->unique('id');
        return view('personal.friend', $var);
    }
    public function addfriend($id){
        $friend=DB::table('friend')
        ->where('subject_id','=',auth()->user()->id)
        ->where('object_id','=',$id)->get();
        if(count($friend)==0){
            DB::table('friend')->insert([
            "subject_id"=>auth()->user()->id,
            "object_id"=>$id
            ]);
        }
        else echo "   bạn đã lưu rồi";
    }
    public function dropfriend($id){
        $friend=DB::table('friend')
        ->where('subject_id','=',auth()->user()->id)
        ->where('object_id','=',$id)->get();
        if(count($friend)!=0){
            DB::table('friend')
        ->where('subject_id','=',auth()->user()->id)
        ->where('object_id','=',$id)->delete();
        }
        else echo "   bạn đã lưu rồi";
    }
    public function message(){
        $message=collect();
        foreach(\App\Message::where('subject_id','=',auth()->user()->id)
        ->select('object_id')
        ->distinct()
        ->get() as $o){
            $message->push($o);
        }
        foreach(\App\Message::where('object_id','=',auth()->user()->id)
        ->select('subject_id')
        ->distinct()
        ->get() as $u){
            foreach($message as $m){
                if($u->object_id==$m->subject_id){
                    $message->pop($m);
                }
            }
            $message->push($u);
        }
        //$message=$message->unique('subject_id','object_id');
        return view('personal.message', compact('message'));
    }
    public function inbox($id){
        $object=\App\User::find($id);
        $inbox=collect();
        foreach(\App\Message::where('subject_id','=',auth()->user()->id)
        ->where('object_id','=',$id)->get() as $m){
            $inbox->push($m);
        }
        foreach(\App\Message::where('object_id','=',auth()->user()->id)
        ->where('subject_id','=',$id)->get() as $m){
            $inbox->push($m);
        }
        $inbox=$inbox->sortBy('id');
        return view('personal.inbox', compact('inbox', 'object'));
    }
}
