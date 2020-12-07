@extends('layouts.nav')
@section('undernav')
<div class="card">
    <div class="card-header">Update</div>
        <div class="card-body">
            <form method="POST" action="{{ route('insert_user') }}">
                @csrf
                <input name="id" value="{{ $user->id ?? '' }}" style="display:none">
                <label>Tên</label>
                <input name="name" value="{{ $user->name ?? '' }}" class="form-control">
                <label>Ngày sinh</label>
                <input name="birthdate" value="{{ $user->info->birthdate ?? '' }}" placeholder="19/07/2001" class="form-control">
                <label>Trường học/Công ty</label>
                <input name="workplace" value="{{ $user->info->workplace ?? '' }}" placeholder="ĐH BKHN"class="form-control">
                <label class="col-md-4 col-form-label">Link ảnh</label>     
                <input name="avatar" value="{{ $user->info->avatar ?? '' }}" id="avatar" type="text" onchange="loadAvatar()" class="form-control " required autofocus>
                <div onclick="deleteAvatar()" class="btn btn-danger">Xóa link</div>
                <br>
                <img id="avatar-preview" src="{{ $user->info->avatar ?? '' }}" width="50%" height="50%">
                <br>
                <br>
                <button type="submit" class="btn btn-primary">
                    Update Info
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        const loadAvatar = () => {
            const link=document.getElementById("avatar");
            document.getElementById("avatar-preview").setAttribute("src", link.value);
        }
        const deleteAvatar = () => {
            const link=document.getElementById("avatar");
            link.value="";
            document.getElementById("avatar-preview").setAttribute("src", link.value);
        }
    </script>
@endsection