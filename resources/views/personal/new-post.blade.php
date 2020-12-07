@extends('layouts.nav')
@section('undernav')
    <div class="card">
        <div class="card-header">{{ (isset($post)) ? 'Update' : 'New' }} Post</div>
        <div class="card-body">
            <form method="POST" action="{{ route('insert_post') }}">
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

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Picture Link</label>
                    <div class="col-md-6">
                        <input name="picture" value="{{ $post->picture ?? '' }}" id="picture" type="text" onchange="loadPicture()" class="form-control " required autofocus>
                        <button onclick="deletePicture()" class="btn btn-danger">Xóa link</button>
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
                        <img id="picture-preview" src="{{ $post->picture ?? '' }}" alt="Chưa có ảnh" width="50%" height="50%">
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
            const link=document.getElementById("picture");
            document.getElementById("picture-preview").setAttribute("src", link.value);
        }
        const deletePicture = () => {
            const link=document.getElementById("picture");
            link.value="";
            document.getElementById("picture-preview").setAttribute("src", link.value);
        }
    </script>
@endsection