<ul class="dropdown-menu">
   @foreach($categories as $category)
      <li> <a href="{{action('FrontendController@getCategory',['slug'=>$category->slug])}}">{{$category->name}} </a> </li>
   @endforeach
</ul>