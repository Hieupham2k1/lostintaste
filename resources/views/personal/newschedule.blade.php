@extends('layouts.nav')
@section('undernav')
<br>
<div class="card">
    <div class="card-header">{{ __('Push') }}</div>
    <div class="card-body">
        <form method="POST" action="../insertschedule">
            @csrf
            <div class="card">
                <img class="card-img-top" 
                src="{{$p->picture}}" width="100%" height="100%">
                <div class="card-body">
                    <h2>Tên: {{$p->name}}</h2>
                    <div>Loại: {{$p->kind}}</div>
                    <div>Giá: {{$p->price}}000 VND</div>
                    <span>Quận: {{$p->district}},</span>
                    <span>Phường: {{$p->province}}</span>
                    <div>Địa chỉ: {{$p->address}}</div>
                    <b> Uploader:
                        <a href="profile/{{$p->user->id}}">
                            {{$p->user->name}}
                        </a>
                    </b> 
                    <p>at {{$p->updated_at}}<p>
                </div>
                <input name="post_id" value={{$p->id}} style="display:none">
                <label for="time" class="col-form-label ">{{ __('Thời gian') }}</label>
                <input id="time" type="text" 
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
                {{ __('+New Schedule') }}
            </button>
        </form>
    </div>
</div>
@endsection
@push('script')
<script>
    const load=()=>{
        const link=document.getElementById("picture");
        document.getElementById("img").setAttribute("src", link.value);
    }
    const del=()=>{
        const link=document.getElementById("picture");
        link.value="";
        document.getElementById("img").setAttribute("src", link.value);
    }
    //alert('ds');
</script>
@endpush