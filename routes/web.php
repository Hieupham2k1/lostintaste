<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/push', 'HomeController@push');
Route::post('/sendpush', 'HomeController@sendpush');
Route::get('/profile/{id}', function($id) {
    $var['user']=App\User::find($id);
    $var['post']=Post::where('user_id','=',$var['user']->id)
    ->orderBy('id','DESC')
    ->paginate(4);
    $var['savedpost']=\App\User::find($id)->savedpost
    //\App\Savedpost::
    //->where('user_id','=',$id)
    ->where('mode','=','Tất cả');
    //->get();
    return view('profile', $var);
});
//Route::get('/showall', 'HomeController@showall');
Route::get('/newsavedpost/{id}', 'HomeController@newsavedpost');
Route::get('/newschedule/{id}', 'HomeController@newschedule');
Route::post('/insertschedule', 'HomeController@insertschedule');




Route::get('/update/{name}/{id}/{mode?}', 'HomeController@update');

Route::post('/insertupdate', function(Request $req) {
    if($req->type=="user"){
        $user= \App\User::find($req->id);
        $update= \App\Info::where('user_id','=',$user->id)->first();
        $update->birthdate=$req->birthdate;
        $update->workplace=$req->workplace;
        $update->avatar=$req->avatar;
        $user->save();
        $update->save();
        return redirect('home');
    }
    if($req->type=="post"){
        $update= Post::find($req->id);
        $update->name=$req->name;
        $update->kind=$req->kind;
        $update->price=$req->price;
        $update->district=$req->district;
        $update->province=$req->province;
        $update->address=$req->address;
        $update->picture=$req->picture;
        $update->time=$req->time;
        $update->save();
        $var['user']=auth()->user();
        $var['post']=Post::where('user_id','=',$var['user']->id)->orderBy('id','DESC')->paginate(4);
        return redirect('post');
    }
    if($req->type=="schedule"){
        $update= \App\Schedule::find($req->id);
        $update->time=$req->time;
        $update->mode=$req->mode;
        $update->save();
        $var['user']=auth()->user();
        $var['schedule']=\App\Schedule::where('user_id','=',$var['user']->id)->orderBy('id','DESC')->paginate(4);
        return redirect('schedule');
    }
});


Route::get('/delete/{name}/{id}', 'HomeController@delete');


Route::get('news', function() {
    $news=\App\Schedule::where('mode','<>','solo')->orderBy('id','DESC')->get();
    return view('personal.news', compact('news'));
});

Route::get('attend/{id}', function($id) {
    if(count(\App\Attendee::where('user_id','=',auth()->user()->id)
        ->where('schedule_id','=',$id)->get())==0){
            $new= new \App\Attendee();
            $new->user_id=auth()->user()->id;
            $new->schedule_id=$id;
            $new->save();
        }
        else echo "   bạn đã lưu rồi";
});


Route::get('post', 'HomeController@post');
Route::get('savedpost', 'HomeController@savedpost');
Route::get('schedule', 'HomeController@schedule');
Route::get('friend', 'HomeController@friend');

Route::get('getfriendshow', function(Request $req) {
    $show=\App\User::where('name','LIKE', '%'.$req->input.'%')->get();
    if(count($show)==0||$req->input="") return "1";
    else return $show;
});

Route::get('addfriend/{id}', 'HomeController@addfriend');
Route::get('dropfriend/{id}', 'HomeController@dropfriend');

Route::get('message', 'HomeController@message');
Route::get('inbox/{id}', 'HomeController@inbox');
Route::get('sendmessage', function(Request $req) {
    $new=new \App\Message();
    $new->content=$req->content;
    $new->subject_id=auth()->user()->id;
    $new->object_id=$req->id;
    $new->save();
    //return "hello";
});
Route::get('refresh/{id}', function($id) {
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
    //$inbox=$inbox->sortByDesc('content');
    return $inbox;
});







Route::get('/', function () {
    $topfoods=Post::orderBy('price','ASC')
    ->limit(6)
    ->get();
    $test=1;
    return view('welcome', compact('topfoods', 'test'));
});


//Route::get('/', 'HomeController@welcome');

Route::get('/searcher', function() {
    $var['response']="";
    return view('searcher', $var);
});
Route::get('getprovince', function(Request $req) {
    return DB::table('hanoidistrict')
    ->where('district','=',$req->district)
    ->select('province')
    ->get();
});
Route::get('getfood', function(Request $req) {
    $data= Post::where('price','<',$req->price);
    if($req->kind!="Tất cả") $data=$data->where('kind','=',$req->kind);
    if($req->district!="Tất cả") $data=$data->where('district','=',$req->district);
    if($req->province!="Tất cả") $data=$data->where('province','=',$req->province);
    $data=$data->orderBy('id','DESC')->get();
    foreach($data as $d){
        $d->user=App\User::find($d->user_id);
        $d->user->info=App\Info::where('user_id','=',$d->user_id)->first();
    }
    return $data;
    //return view('welcome')->with('topfoods', $data->get());
});

Route::get('hey', function() {
    $data= Post::where('price','<', 10)->get();
    foreach($data as $d){
        $d->user=App\User::find($d->user_id);
        $d->user->info=App\Info::where('user_id','=',$d->user_id)->first();
    }
    return $data;
});
Route::get('vue', function() {
    return view('vue');
});


?>







