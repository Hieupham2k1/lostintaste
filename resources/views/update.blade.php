@extends('layouts.nav')
@section('undernav')
<br>
<div class="card">
    <div class="card-header">{{ __('Update') }}</div>
        <div class="card-body">
            <div style="display:{{$isUser}}">
                <form method="POST" action="/insertupdate">
                    @csrf
                    <input value="user" name="type" style="display:none">
                    <input value="{{$user->id??""}}" name="id" style="display:none">
                    <label>Tên</label>
                    <input name="name" value="{{$user->name??""}}" class="form-control">
                    <label>Ngày sinh</label>
                    <input name="birthdate" value="{{$user->info->birthdate??""}}" placeholder="19/07/2001" class="form-control">
                    <label>Trường học/Công ty</label>
                    <input name="workplace" value="{{$user->info->workplace??""}}" placeholder="ĐH BKHN"class="form-control">
                    <label for="avatar" class="col-md-4 col-form-label ">{{ __('Link ảnh') }}</label>     
                    <input id="avatar" type="text" onchange="load()" class="form-control " name="avatar" required autofocus>
                    <div onclick="del()" class="btn btn-danger">Xóa link</div>
                    <br>
                    <img id="avatar-img" src="{{$user->info->avatar??""}}" width="50%" height="50%">
                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update Info') }}
                    </button>
                </form>
            </div>
            <div style="display:{{$isPost}}">
                <form method="POST" action="/insertupdate">
                    @csrf
                    <input value="post" name="type" style="display:none">
                    <input value="{{$post->id??""}}" name="id" style="display:none">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tên') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" value="{{$post->name??""}}" class="form-control @error('name') is-invalid @enderror" name="name" required autofocus>
                        </div>
                    </div>
                    <span>Loại:</span><select class="custom-select" ref="kind" name="kind" class="input">
                        <option>Đồ Uống</option>
                        <option>Đồ ăn mặn</option>
                        <option>Đồ ăn ngọt</option>
                        <option>Địa điểm vui chơi</option>
                        <option>Review</option>
                    </select>
                    <br>
                    <span>Giá:</span>
                    <input id="price" type="text" value="{{$post->price??""}}" name="price" ref="price" style="width:15%" value="1000"><span>000 VND</span>
                    <br>
                    <district></district>
                    <label for="address" class="col-md-4 col-form-label ">{{ __('Địa chỉ') }}</label>
                    <input id="address" type="text" value="{{$post->address??""}}" class="form-control @error('address') is-invalid @enderror" name="address" required autofocus>
                    
                    <label for="picture" class="col-md-4 col-form-label ">{{ __('Link ảnh') }}</label>
                    <input id="picture" type="text" onchange="load()" class="form-control " name="picture" required autofocus>
                    <div onclick="del()" class="btn btn-danger">Xóa link</div>
                    <br>
                    <label for="time" class="col-md-4 col-form-label ">{{ __('Time') }}
                    
                    <input id="time" type="text" class="form-control " name="time" autofocus></label><br>
                    <div>Xem ảnh<br>
                    <img id="img" src="{{$post->picture??""}}" width="50%" height="50%">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update Post') }}
                    </button>
                </form>
            </div>
            <div style="display:{{$isSchedule}}">
                <div> {{$schedule->post->name??""}}</div>
                <div style="display:none">{{$p=$schedule->post??""}}</div>
                <form method="POST" action="/insertupdate">
                    @csrf
                    <input name="type" value="schedule" style="display:none">
                    <input name="id" value="{{$schedule->id??""}}" style="display:none">
                    <div class="card">
                        <img class="card-img-top" 
                        src="{{$p->picture??""}}" width="100%" height="100%">
                        <div class="card-body">
                            <h2>Tên: {{$p->name??""}}</h2>
                        </div>
                        <label for="time" class="col-form-label ">{{ __('Thời gian') }}</label>
                        <input id="stime" type="text" 
                        class="form-control @error('time') is-invalid @enderror" 
                        name="time" value="CN, 19/7/2020, 19:00"
                        required autofocus>
                        <br>
                        <select class="custom-seclect" name="mode">
                            <option>Squad</option>
                            <option>Duo</option>
                            <option>Solo</option>
                        </select>
                        <br>
                    </div>                
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update Schedule') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    const load=()=>{
        const link=document.getElementById("picture").value;
        document.getElementById("img").setAttribute("src", link);
    }
</script>
@endsection