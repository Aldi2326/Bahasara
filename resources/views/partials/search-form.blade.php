<div class="ts-form__map-search ts-z-index__2">
    <form class="ts-form">

        <!--Collapse button-->
        <a href=".ts-form-collapse" data-toggle="collapse" 
           class="ts-center__vertical justify-content-between">
            <h5 class="mb-0">Search Filter</h5>
        </a>

        <div class="ts-form-collapse ts-xs-hide-collapse collapse show">

            <!-- Keyword -->
            <div class="form-group my-2 pt-2">
                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Address, City or ZIP">
            </div>

            <!-- Category -->
            <select class="custom-select my-2" id="type" name="category">
                <option value="">Type</option>
                <option value="1">Apartment</option>
                <option value="2">Villa</option>
                <option value="3">Land</option>
                <option value="4">Garage</option>
            </select>

            <!-- Status -->
            <select class="custom-select my-2" id="status" name="status">
                <option value="">Status</option>
                <option value="1">Sale</option>
                <option value="2">Rent</option>
            </select>

            <!-- Max Price -->
            <select class="custom-select my-2" id="price" name="price">
                <option value="">Max Price</option>
                <option value="5000">$5,000</option>
                <option value="10000">$10,000</option>
                <option value="50000">$50,000</option>
                <option value="100000">$100,000</option>
                <option value="100000>">> $100,000</option>
            </select>

            <!-- Submit -->
            <div class="form-group mt-2 mb-3">
                <button type="submit" class="btn btn-primary w-100" id="search-btn">Search</button>
            </div>

            <!-- More Options -->
            <a href="#more-options-collapse" class="collapsed" data-toggle="collapse" 
               role="button" aria-expanded="false" aria-controls="more-options-collapse">
                <i class="fa fa-plus-circle ts-text-color-primary mr-2 ts-visible-on-collapsed"></i>
                <i class="fa fa-minus-circle ts-text-color-primary mr-2 ts-visible-on-uncollapsed"></i>
                More Options
            </a>

            <!-- Hidden Options -->
            <div class="collapse" id="more-options-collapse">
                <div class="pt-4">
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="bedrooms">Bedrooms</label>
                                <input type="number" class="form-control" id="bedrooms" name="bedrooms" min="0">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="bathrooms">Bathrooms</label>
                                <input type="number" class="form-control" id="bathrooms" name="bathrooms" min="0">
                            </div>
                        </div>
                    </div>

                    <div id="features-checkboxes" class="w-100">
                        <h6 class="mb-3">Features</h6>
                        <div>
                            @foreach ([
                                'Air conditioning', 'Bedding', 'Heating', 'Internet',
                                'Microwave', 'Smoking allowed', 'Terrace', 'Balcony',
                                'Iron', 'Hi-Fi', 'Beach', 'Parking'
                            ] as $i => $feature)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" 
                                           id="ch_{{ $i+1 }}" name="features[]" value="ch_{{ $i+1 }}">
                                    <label class="custom-control-label" for="ch_{{ $i+1 }}">{{ $feature }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
