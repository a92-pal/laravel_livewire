<div class="row"  x-data="{geoZoneSection: true, postalCodeSection: false}">
    <div class="col-md-8 offset-md-2 py-2">
        <button class="btn btn-info" @click="geoZoneSection = true, postalCodeSection = false"><h3 >Geozones</h3></button>
        <button class="btn btn-info" @click="postalCodeSection = true, geoZoneSection = false"><h3 >Postal Code</h3></button>
    </div>
    <div class="col-md-8 offset-md-2">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
                <button type="button" class="close btn btn-sm btn-success" style="float: right" data-dismiss="alert">×</button>
            </div>
        @endif
        <div class="card" x-show="geoZoneSection">
            <div class="card-body">
                <form wire:submit.prevent="storeGeozone">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Geozone</label>
                        <input type="text" wire:model.lazy="zone" class="form-control" id="exampleInputEmail1" placeholder="Enter Name Of The Geozone">
                        @error('zone') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                </form>
                <div class="accordion mt-2" id="accordionExample">
                    @foreach($geoZones as $zone)
                    <div x-data="{ open: false }" class="card mb-1">
                        <div class="card-header" @click="open = true">
                            <h2 class="mb-0">
                              <button class="btn" type="button">
                                {{$zone->name}}
                              </button>
                            </h2>
                        </div>
                
                        <ul x-show="open" @click.away="open = false" class="mt-2">
                            @if($zone->postalcodes->count())
                                @foreach($zone->postalcodes as $postalcode)
                                    <li type="button" class="btn btn-success btn-sm">{{$postalcode->code}}</li>
                                @endforeach
                            @else
                                No postal code has been set.
                            @endif
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Postal codes -->
        <div class="card" x-show="postalCodeSection" style="min-height: 200px">
            <div class="card-body">
                <form wire:submit.prevent="connectPostalCodesWithGeozone">
                    <div class="form-group">
                        <select class="form-control " style="width:100%" wire:change="chooseZone" wire:model="zoneId">
                            <option value="">Select Geozone</option>
                            @foreach($geoZones as $zone)
                                <option value="{{$zone->id}}">{{$zone->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($zoneId != '')
                        <div class="mt-1">
                            @foreach($allPostalCodes as $key=>$postalcode)
                                <input type="checkbox" wire:model="chooseCodes" value="{{$postalcode->id}}" > {{$postalcode->code}}
                            @endforeach
                        </div>
                        @error('chooseCodes') <span class="error text-danger">{{ $message }}</span> @enderror
                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>