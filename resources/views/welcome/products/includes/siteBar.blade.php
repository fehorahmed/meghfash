<div class="proSideBar">
    <div class="collpasBox">
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice">
            Price Range
        </button>
        <div class="collapse show" id="collapsePrice">
            <div class="card card-body">
                <div class="range-slider">
                    <input value="{{$minPrice}}" min="{{$minPrice}}" max="{{$maxPrice}}" step="100" type="range" class="filterAction" />
                	<input value="{{$maxPrice}}" min="{{$minPrice}}" max="{{$maxPrice}}" step="100" type="range" class="filterAction"/>
                	<br>
                    <span style="display: flex; justify-content: space-between; width: 100%; padding: 5px;">
                        <input type="number" class="filterAction min-price-input" name="min_price" value="{{$minPrice}}" min="{{$minPrice}}" max="{{$maxPrice}}" style="width: 100px;">
                        <input type="number" class="filterAction max-price-input" name="max_price" value="{{$maxPrice}}" min="{{$minPrice}}" max="{{$maxPrice}}" style="width: 100px;" >
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    @foreach($attributes as $attri)
    <div class="collpasBox">
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_Attri_{{$attri->id}}" aria-expanded="false" aria-controls="collapse_Attri_{{$attri->id}}">
            {{$attri->name}}
        </button>
        <div class="collapse" id="collapse_Attri_{{$attri->id}}">
            <div class="card card-body">
                <ul>
                    @foreach($attri->subCtgs as $item)
                    <li>
                        <input type="checkbox" class="filterAction" id="anadigital_{{$item->id}}" name="options[]" value="{{$item->id}}">
                        <label for="anadigital_{{$item->id}}"> {{$item->name}}</label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endforeach
    
</div>