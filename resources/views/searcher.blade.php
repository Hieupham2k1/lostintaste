@extends('layouts.app')
@section('content')
<div class="card" onemitresponse="load()">
    <div class="card-header">Phạm vi Hà Nội</div>
    <searcher></searcher>
</div>
{{--
<form method="post" action="searcher">
    @csrf
    <span>Loại:</span><select ref="kind" name="kind" class="input">
        <option>Tất cả</option>
        <option>Đồ Uống</option>
        <option>Đồ ăn mặn</option>
        <option>Đồ ăn ngọt</option>
        <option>Địa điểm vui chơi</option>
        <option>Review</option>
    </select>
    <span>Giá dưới:</span>
    <input type="text" name="price" ref="price" style="width:15%" value="1000"><span>000 VND</span>
    <br>
    <district></district>
    <br>
    <button>Search</button>
</form>

@foreach ($response as $item)

<div>{{$item->name}}</div>
@endforeach
--}}
@endsection
