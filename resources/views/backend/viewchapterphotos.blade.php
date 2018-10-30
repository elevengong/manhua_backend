@foreach($chpaterPhotos as $photo)
    <div style="width: 800px;">
        <div style="width:500px;float: left;">
            <img src="/public/manhua/{{$photo['photo']}}" width="500px;" />
        </div>
        <div style="width:100px;float: left;">
            排列：{{$photo['priority']}}
        </div>
    </div>

@endforeach