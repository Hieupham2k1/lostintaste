@extends('layouts.nav')
@section('undernav')
<div class="card">
    <div class="card-header">Update</div>
        <div class="card-body">
            <form name="update_user" method="POST" action="{{ route('insert_user') }}" enctype="multipart/form-data">
                @csrf
                <input name="id" value="{{ $user->id ?? '' }}" style="display:none">
                <label>Tên</label>
                <input name="name" value="{{ $user->name ?? '' }}" class="form-control">
                <label>Ngày sinh</label>
                <input name="birthdate" value="{{ $user->info->birthdate ?? '' }}" placeholder="19/07/2001" class="form-control">
                <label>Trường học/Công ty</label>
                <input name="workplace" value="{{ $user->info->workplace ?? '' }}" placeholder="ĐH BKHN"class="form-control">

                <input name="is_link" value="true" class="d-none">
                
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right" id="picture-input-label">Upload Picture</label>
                    <div class="col-md-6" id="link-input">
                        <input name="avatar" value="{{ $user->info->avatar ?? '' }}" id="avatar" type="text" onchange="loadAvatar()" class="form-control">
                        <button onclick="deleteAvatar()" form="not_here" class="btn btn-danger">Xóa link</button>
                        <button onclick="showFileUploader(1)" form="not_here" class="btn btn-primary">Choose File</button>
                    </div>

                    <div class="col-md-6" id="file-input" style="display: none;">
                        <input name="avatar" id="file" type="file" onchange="readFile()" class="form-control">
                        <button onclick="showFileUploader(0)" form="not_here" class="btn btn-primary">Paste Link</button>
                    </div>
                </div>

                <br>
                <img id="avatar-preview" src="{{ $user->info->avatar ?? '' }}" alt="chưa có ảnh" width="50%" height="50%">
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
            const link = document.getElementById("avatar");
            document.getElementById("avatar-preview").setAttribute("src", link.value);
        }

        const deleteAvatar = () => {
            const link = document.getElementById("avatar");
            link.value = "";
            document.getElementById("avatar-preview").setAttribute("src", link.value);
        }

        const showFileUploader = (show) => {
            const linkInput = document.getElementById('link-input');
            const fileInput = document.getElementById('file-input');
            const label = document.getElementById('picture-input-label');
            if(show == 1){
                document.forms['update_user']['is_link'].value = "false";
                label.innerText = "Upload File";
                fileInput.style.display = "block";
                linkInput.style.display = "none";
                deleteAvatar();
            }
            else{
                document.forms['update_user']['is_link'].value = "true";
                label.innerText = "Paste Link";
                fileInput.style.display = "none";
                linkInput.style.display = "block";
                document.getElementById('file').value = "";
            }
        }

        const readFile = () => {
            const input = document.getElementById('file');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
    </script>
@endsection