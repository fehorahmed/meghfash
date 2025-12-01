@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{websiteTitle($category->seo_title?:$category->name)}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{websiteTitle($category->seo_title?:$category->name)}}" />
<meta name="description" property="og:description" content="{!!$category->seo_description?:general()->meta_description!!}" />
<meta name="keywords" content="{{$category->seo_keyword?:general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset($category->image())}}" />
<meta name="url" property="og:url" content="{{route('productCategory',$category->slug?:'no-title')}}" />
<link rel="canonical" href="{{route('productCategory',$category->slug?:'no-title')}}">
@endsection @push('css')

<style>

</style>

@endpush 

@section('contents')

<div class="singleProHead">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                @if($ctg=$category->parent)
                    @if($ctgSub=$ctg->parent)
                    <li class="breadcrumb-item"><a href="{{route('productCategory',$ctgSub->slug?:'no-title')}}">{{$ctgSub->name}}</a></li>
                    @endif
                <li class="breadcrumb-item"><a href="{{route('productCategory',$ctg->slug?:'no-title')}}">{{$ctg->name}}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="categoryMainDiv">
    <div class="container-fluid">
        <div class="productsLists">
            
            <div class="row">
                @php
                
                    if($attributes->count() > 0){
                    $colName='col-md-4';
                    }else{
                    $colName='col-md-3';
                    }
                
                @endphp
                
                @if($attributes->count() > 0)
                <div class="col-md-3">
                    @include(welcomeTheme().'.products.includes.siteBar')
                </div>
                <div class="col-md-9">
                @else
                <div class="col-md-12">
                @endif
                
                    <div class="ajaxProductList">
                        @include(welcomeTheme().'products.includes.productsAll')
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
</div>

@if($category->description)
<div class="homeSeoContent">
    <div class="container-fluid">
        <div class="homeTextBox pageContents">
            {!!$category->description!!}
        </div>
    </div>
</div>
@endif



@endsection 
@push('js')

<script>
(function() {

  var parent = document.querySelector(".range-slider");
  if(!parent) return;

  var
    rangeS = parent.querySelectorAll("input[type=range]"),
    numberS = parent.querySelectorAll("input[type=number]");

  rangeS.forEach(function(el) {
    el.oninput = function() {
      var slide1 = parseFloat(rangeS[0].value),
        	slide2 = parseFloat(rangeS[1].value);

      if (slide1 > slide2) {
		[slide1, slide2] = [slide2, slide1];
      }
      numberS[0].value = slide1;
      numberS[1].value = slide2;
    }
  });


  numberS.forEach(function(el) {
    el.oninput = function() {
			var number1 = parseFloat(numberS[0].value),
					number2 = parseFloat(numberS[1].value);
			
      if (number1 > number2) {
        var tmp = number1;
        numberS[0].value = number2;
        numberS[1].value = tmp;
      }

      rangeS[0].value = number1;
      rangeS[1].value = number2;
      

    }
  });
  
  

})();


    $(document).ready(function(){
        

    
    //     $('.min-range, .max-range').on('change', function() {
    //         filterAction();
    //     });
       
    //   $(document).on('change','.priceFilter',function(){
    //         filterAction();
    //   });
       
       $(document).on('change','.filterAction',function(){
           filterAction();
           
       });
       
       function filterAction(){
           var url="{{route('productCategory',$category->slug?:'no-title')}}";
           var formData = $('.proSideBar').find('select, input').serialize();
           $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                data:formData,
                success : function(data){

                $('.ajaxProductList').empty().append(data.viewData);
                
                setTimeout(function() {
                }, 200);

                },error: function () {
                    alert('error');
                }
            });
       }
       
       
       
       
    });


</script>

@endpush