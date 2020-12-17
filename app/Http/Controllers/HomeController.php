<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QueryService;
use DB, \App\User,\App\Post,\App\Savedpost;
use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $queryService;

    public function __construct(QueryService $queryService)
    {
        $this->middleware('auth');
        $this->queryService = $queryService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // Welcome Controller
    public function index(){
        $var['topfoods'] = $this->queryService->getCheapestPost();
        return view('welcome', $var);
    }

    public function search(){
        return view('searcher');
    }

    public function getProvince($district){
        return DB::table('hanoidistrict')
        ->where('district', '=', $district)
        ->select('province')
        ->get();
    }

    public function getFood(Request $request){
        $data = $this->queryService->getPostWithUser()->where('price', '<', $request->price);

        if($request->kind != "Tất cả") $data = $data->where('kind', '=', $request->kind);
        if($request->district != "Tất cả") $data = $data->where('district', '=', $request->district);
        if($request->province != "Tất cả") $data = $data->where('province', '=', $request->province);
        return $data->orderBy('id','DESC')->get();
    }
    // User Controller
    public function selfInfo(){
        $this->queryService->createUserInfo();
        $var['user'] = auth()->user();
        return view('me', $var);
    }

    public function userProfile($id){
        $var['user'] = $this->queryService->findUser($id);
        $var['post'] = $var['user']->post()->with('user', 'user.info')->paginate(4);
        return view('personal.profile', $var);
    }

    public function updateUser($id){
        $var['user'] = $this->queryService->findUser($id);
        return view('personal.update-user', $var);
    }

    public function insertUser(Request $request){
        $userId = auth()->user()->id;
        if($request['is_link']){
            $filename = $userId . '.png';
            Storage::putFileAs('public/user-avatar', $request->avatar, $filename);
        }
        else{
            // check for valid file
            if ($request->hasFile('avatar')) {
                if ($request->file('avatar')->isValid()) {
                    $filename = $userId . $request->avatar->extension();
                    $request->avatar->storeAs('public/user-avatar', $filename);
                }
            }
        }
        $array = [
            'birthdate' => $request->birthdate,
            'workplace' => $request->workplace,
            'avatar' => '/user-avatar/' . $filename,
        ];
        $this->queryService->updateUser($array);
        return redirect()->route('self_info');
    }

    // Post Controller
    public function post(){
        $var['post'] = $this->queryService->readPost();
        return view('personal.post', $var);
    }

    public function newPost(){
        return view('personal.new-post');
    }

    public function updatePost($id){
         $var['post'] = $this->queryService->findPost($id);
        return view('personal.new-post', $var);
    }

    public function insertPost(Request $request){
        if($request['id'] != ''){
            // update
            $postId = $request['id'];
            $array = $request->all();
        }else{
            // create
            $request['user_id'] = auth()->user()->id;
            $post = $this->queryService->createPost($request->except('picture'));
            $postId = $post->id;
        }

        if($request['is_link']){
            $filename = $postId . '.png';
            Storage::putFileAs('public/post-picture', $request->picture, $filename);
        }
        else{
            // check for valid file
            if ($request->hasFile('picture')) {
                if ($request->file('picture')->isValid()) {
                    $filename = $postId . $request->picture->extension();
                    $request->picture->storeAs('public/post-picture', $filename);
                }
            }
        }
        $array['id'] = $postId;
        $array['picture'] = '/post-picture/' . $filename;
        $this->queryService->updatePost($array);

        return redirect()->route('post'); 
    }

    public function deletePost($id){
        $this->queryService->deletePost($id);
        return back();
    }

    // Savedpost Controller
    public function savedpost()
    {
        $var['savedpost'] = $this->queryService->readSavedpost();
        return view('personal.savedpost', $var);
    }

    public function newSavedpost($id){
        $user = auth()->user();
        if(count($user->savedpost
        ->where('post_id', '=', $id)) == 0){
            $this->queryService->createSavedpost([
                'mode' => 'Tất cả',
                'user_id' => $user->id,
                'post_id' => $id,
            ]);
            return 1;
        }
        return 0;
    }
    public function updateSavedpost($id, $mode){
        $this->queryService->updateSavedpost($id, $mode);
        return back();
    }

    public function deleteSavedpost($id){
        $this->queryService->deleteSavedpost($id);
        return back();
    }

    // Schedule Controller
    public function schedule()
    {
        $var['schedule'] = $this->queryService->readSchedule();
        $var['attended'] = auth()->user()->attended;
        return view('personal.schedule', $var);
    }
    
    public function newSchedule($id){
        $var['post'] = $this->queryService->findPost($id);
        return view('personal.new-schedule', $var);
    }

    public function updateSchedule($id){
        $var['schedule'] = $this->queryService->findSchedule($id);
        $var['post'] = $var['schedule']->post;
        return view('personal.new-schedule', $var);
    }

    public function insertSchedule(Request $request){
        if($request->id != ''){
            $this->queryService->updateSchedule($request->only('id', 'time', 'mode'));
        }else{
            $request['user_id'] = auth()->user()->id;
            $this->queryService->createSchedule($request->all());
        }
        return redirect()->route('schedule');
    }
    
    public function deleteSchedule($id){
        $this->queryService->deleteSchedule($id);
        return back();
    }

    public function deleteAttendee($id){
        $this->queryService->deleteAttendee($id);
        return back();
    }

    // News Controller
    public function news(){
        $var['news'] = $this->queryService->publicSchedule();
        return view('personal.news', $var);
    }

    public function attend($id){
        $user = auth()->user();
        if(!$this->queryService->hasAttended($user->id, $id)){
            $this->queryService->createAttendee([
                'user_id' => $user->id,
                'schedule_id' => $id
                ]);
            return 1;
        }
        return 0;
    }

    // Friend Controller
    public function friend()
    {
        $var['user'] = auth()->user();
        $var['friend'] = $var['user']->friend;
        
        $var['mightknow'] = collect();
        $savedpost = auth()->user()->savedpost;
        foreach($savedpost as $sp){
            $postsaver = $sp->post->savedpost;
            foreach($postsaver as $saver){
                $var['mightknow']->push($saver->user);
            }
        }
        $var['mightknow'] = $var['mightknow']->unique('id');
        return view('personal.friend', $var);
    }

    public function searchFriend($input){
        return $this->queryService->findUserByName($input);
    }

    public function addfriend($id){
        $userId = auth()->user()->id;
        $friend = DB::table('friend')
        ->where('subject_id', '=', $userId)
        ->where('object_id', '=', $id)->get();
        if(count($friend) == 0){
            DB::table('friend')->insert([
            "subject_id" => $userId,
            "object_id" => $id
            ]);
            return 1;
        }
        return 0;
    }

    public function dropfriend($id){
        $userId = auth()->user()->id;
        $friend = DB::table('friend')
        ->where('subject_id', '=', $userId)
        ->where('object_id', '=', $id)->get();
        if(count($friend) != 0){
            DB::table('friend')
            ->where('subject_id', '=', $userId)
            ->where('object_id', '=', $id)->delete();
            return 1;
        }
        return 0;
    }

    // Message Controller
    public function message(){
        $var['message'] = $this->queryService->getAllMessages();
        return view('personal.message', $var);
    }

    public function inbox($id){
        $var['object'] =  $this->queryService->findUser($id);
        $var['inbox'] = $this->queryService->getMessageWith($id);
        $var['inbox'] = $var['inbox']->sortBy('id');
        return view('personal.inbox', $var);
    }

    public function sendMessage(Request $request) {
        $data['content'] = $request->content;
        $data['subject_id'] = auth()->user()->id;
        $data['object_id'] = $request->id;
        $this->queryService->createMessage($data);
    }

    public function refresh($id) {
        return $this->queryService->getMessageWith($id);
    }
}
