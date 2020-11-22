@extends('layouts.nav')
@section('undernav')
<br>
<div class="card">
    <div class="card-header">{{ __('Push') }}</div>
    <div class="card-body">
        <form method="POST" action="sendpush">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tên') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autofocus>
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
            <span>Giá dưới:</span>
            <input type="text" name="price" ref="price" style="width:15%" value="1000"><span>000 VND</span>
            <br>
            <district></district>
            <label for="address" class="col-md-4 col-form-label ">{{ __('Address') }}</label>
            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" required autofocus>
            <label for="picture" class="col-md-4 col-form-label ">{{ __('Picture Link') }}</label>
            <input id="picture" type="text" onchange="load()" class="form-control " name="picture" required autofocus>
            <div onclick="del()" class="btn btn-danger">Xóa link</div>
            <br>
            <label for="time" class="col-md-4 col-form-label ">{{ __('Time') }}
            <input id="time" type="text" class="form-control " name="time" autofocus></label><br>
            <div>Xem ảnh<br>
                <img id="img" src="" width="50%" height="50%">
            </div>
            <button type="submit" class="btn btn-primary">
                {{ __('Push') }}
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