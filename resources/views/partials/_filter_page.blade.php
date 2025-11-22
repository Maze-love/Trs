      
    <div class="mt-5 p-2 filter_page border ">

                        <div class="sidebar">
                            <form action="/trip/filter" class="p-3" id="filterForm" method="POST">
                                @csrf
                                        <h6 class="form-header px-0">Category</h6>
                                    
                                        @foreach ($categories as $category)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{$category->id}}">
                                                    <label class="form-check-label" for="categoryCheck1">
                                                        {{$category->name}}
                                                    </label>
                                                </div>
                                        @endforeach

                                        <!-- Divider -->
                                        <hr class="divider">

                                         <!-- Destination options to filter -->
                                        <div class="mb-3 ">
                                            <label for="selectDestination" class="formlabel">Destination</label>
                                            <select class="form-select "  name="destination_id"  >
                                                <option disabled selected>Select a destination</option>

                                                @foreach ($trips as $place)
                                                    @if ($place->destination)
                                                    <option value="{{$place->destination->id}}">{{$place->destination->title}}</option>

                                                    @endif
                                                @endforeach
                                            
                                            </select>                                          
                                        </div>

                                        <!-- Duration Range Section -->
                                        <div class="mb-3 range-container">
                                            Min Duration<span class="range-value" id="duration_min"> {{$min_duration}}</span>
                                            <input type="range" class="form-range" min="{{$min_duration}}" max="{{$max_duration}}" id="durationRange" name="duration_min" value="{{$min_duration}}" oninput="document.getElementById('duration_min').textContent = this.value">

                                            Max Duration<span class="range-value" id="duration_max">{{$max_duration}}</span>
                                            <input type="range" class="form-range" min="{{$min_duration}}" max="{{$max_duration}}" id="durationRange" name="duration_max" value="{{$max_duration}}" oninput="document.getElementById('duration_max').textContent = this.value">
                                    
                                    
                                        </div>

                                        <!-- Price Range Section -->
                                        <div class="mb-3 range-container">
                                            
                                            Min Price<span class="range-value" id="priceValue_min">{{$min_price}}</span>
                                            <input type="range" class="form-range" min="{{$min_price}}" max="{{$max_price}}"  id="priceRange"  name="price_min" value="{{$min_price}}" oninput="document.getElementById('priceValue_min').textContent = this.value">
                                            
                                            Max Price<span class="range-value" id="priceValue_max">{{$max_price}}</span>

                                            <input type="range" class="form-range" min="{{$min_price}}" max="{{$max_price}}"  id="priceRange"  name="price_max" value="{{$max_price}}" oninput="document.getElementById('priceValue_max').textContent = this.value">
                                                
                                        
                                        </div>
                                        
                                        <!-- Divider -->
                                        <hr class="divider">

                                        <!-- Action Buttons Section -->
                                        <div class="d-flex justify-content-between">
                                            <input type="reset" value="Reset" class="btn btn-outline-secondary btn-sm">
                                            <button type="submit"  class="btn btn-primary btn-sm">Apply Filter</button>
                                            
                                        </div>

                                
                                

                            </form>
                        </div>

    </div>   
