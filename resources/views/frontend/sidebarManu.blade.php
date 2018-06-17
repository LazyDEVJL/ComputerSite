@foreach($manufactures as $manu)
   <li><a href="{{action('FrontendController@ProductbyBrand',['id'=>$manu->id])}}">{{$manu->name}}</a></li>
@endforeach