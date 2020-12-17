@extends('layouts.nav')
@section('undernav')
    <div class="card">
        <div class="card-header">{{ (isset($post)) ? 'Update' : 'New' }} Post</div>
        <div class="card-body">
            <form name="new_post" method="POST" action="{{ route('insert_post') }}" enctype="multipart/form-data">
                @csrf
                <input value="{{ $post->id ?? '' }}" name="id" style="display:none">
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Tên</label>
                    <div class="col-md-6">
                        <input name="name" value="{{ $post->name ?? '' }}" type="text" class="form-control @error('name') is-invalid @enderror" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Tên</label>
                    <div class="col-md-6">
                        <select class="custom-select" ref="kind" name="kind" class="input">
                            <option>Đồ Uống</option>
                            <option>Đồ ăn mặn</option>
                            <option>Đồ ăn ngọt</option>
                            <option>Địa điểm vui chơi</option>
                            <option>Review</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Giá (000 VND)</label>
                    <div class="col-md-6">
                        <input name="price" value="{{ $post->price ?? '1000' }}" type="number" class="col form-control @error('name') is-invalid @enderror">
                    </div>
                </div>

                <district 
                    old-district="{{ $post->district ?? '' }}" 
                    old-province="{{ $post->province ?? '' }}" 
                /></district>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Address</label>
                    <div class="col-md-6">
                        <input name="address" value="{{ $post->address ?? '' }}" id="address" type="text" class="form-control @error('address') is-invalid @enderror" required autofocus>
                    </div>
                </div>

                <input name="is_link" value="true" class="d-none">
                
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right" id="picture-input-label">Upload Picture</label>
                    <div class="col-md-6" id="link-input">
                        <input name="picture" value="{{ $post->picture ?? '' }}" id="picture" type="text" onchange="loadPicture()" class="form-control">
                        <button onclick="deletePicture()" form="not_here" class="btn btn-danger">Xóa link</button>
                        <button onclick="showFileUploader(1)" form="not_here" class="btn btn-primary">Choose File</button>
                    </div>

                    <div class="col-md-6" id="file-input" style="display: none;">
                        <input name="picture" id="file" type="file" onchange="readFile()" class="form-control">
                        <button onclick="showFileUploader(0)" form="not_here" class="btn btn-primary">Paste Link</button>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Time</label>
                    <div class="col-md-6">
                        <input id="time" type="text" class="form-control " name="time" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Xem ảnh</label>
                        <img id="picture-preview" src="{{ $post->picture ?? asset('picture/blank-img.png') }}" alt="Chưa có ảnh" width="50%" height="50%">
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">
                    {{(isset($post)) ? 'Update' : 'New'}}
                </button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const loadPicture = () => {
            const link = document.getElementById('picture'); // declair in function to renew everytime fuction called
            document.getElementById('picture-preview').setAttribute('src', link.value);
        }

        const deletePicture = () => {
            const link = document.getElementById('picture');
            link.value = "";
            document.getElementById('picture-preview').setAttribute('src', '{{ asset('picture/blank-img.png') }}');
        }

        const showFileUploader = (show) => {
            const linkInput = document.getElementById('link-input');
            const fileInput = document.getElementById('file-input');
            const label = document.getElementById('picture-input-label');
            if(show == 1){
                document.forms['new_post']['is_link'].value = "false";
                label.innerText = "Upload File";
                fileInput.style.display = "block";
                linkInput.style.display = "none";
                deletePicture();
            }
            else{
                document.forms['new_post']['is_link'].value = "true";
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
                    document.getElementById('picture-preview').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
    </script>
@endsection