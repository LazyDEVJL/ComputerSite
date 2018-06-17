@foreach($categories as $cate)
   <li><a href="{{route('get-category', ['slug'=>$cate->slug])}}"> {{$cate->name}}</a></li>
@endforeach