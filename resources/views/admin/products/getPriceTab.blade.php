<style>
    .qaun_width{ width: 50% }
</style>
<div class="col-sm-12 margin-bottom-20">
    <strong>{{ __('Enter Same Price For All Color And Size?') }} : </strong> <input type="text" class="change-all-price form-control qaun_width" name="price" id="price" value="0" />
</div>
<form method="post">
@csrf
    <div class="col-sm-12">
        <div class="row">
            <div class="clearfix"></div>
            <input type="hidden" name="product_id" value="{{ $product_id }}" class="product_id" />
            <div class="clearfix"></div>
           @foreach($price_types as $price_type)
                <div class="grey_bg margin-15">
                    <h2 class="title">{{ $price_type['name'] }}</h2>
                    <div class="clearfix"></div>
                    @if ($product_type == 'BOTH')
                       @foreach($colors as $color)
                            <div class="col-sm-2">
                                <table class="table table-responsive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:60%">{{ $color['name'] }}</th>
                                            <th>{{ __('Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($sizes as $size)
                                            @php $n = $color['id'] . "_" . $size['id'] . "_" . $price_type['id'] @endphp
                                            <tr>
                                                <td>{{ $size['name'] }}</td>
                                                <td><input style="width:50px; text-align: center" class="change-price qaun_width" type="text" name="quantity[{{ $n }}]" id="bothquantity_{{ $n }}" value="{{ (isset($array[$n]) ? $array[$n] : 0) }}" /></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @elseif ($product_type == 'ColorBase')
                       @foreach($colors as $color)
                            <div class="col-sm-2">
                                <table class="table table-responsive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:60%">{{ $color['name'] }}</th>
                                            <th>{{ __('Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $n = $color['id'] . "_" . $price_type['id'] @endphp
                                        <tr>
                                            <td>{{ __('No size') }} </td>
                                            <td><input style="width:50px; text-align: center" class="change-price qaun_width" type="text" name="quantity[{{ $n }}]" id="colorquantity_{{ $n }}" value="{{ (isset($array[$n]) ? $array[$n] : 0) }}" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @elseif ($product_type == 'SizeBase')
                       @foreach($sizes as $size)
                            <div class="col-sm-2">
                                <table class="table table-responsive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:60%">{{ __('No color') }}</th>
                                            <th>{{ __('Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $n = $size['id'] . "_" . $price_type['id'] @endphp
                                        <tr>
                                            <td>{{ $size['name'] }}</td>
                                            <td><input style="width:50px; text-align: center" type="text" class="change-price qaun_width" name="quantity[{{ $n }}]" id="sizequantity_{{ $n }}" value="{{ (isset($array[$n]) ? $array[$n] : 0) }}" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @else
                        <div class="col-sm-2">
                            <table class="table table-responsive table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:60%">{{ __('No color') }}</th>
                                        <th>{{ __('Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $n = $price_type['id'] @endphp
                                    <tr>
                                        <td>{{ __('No size') }}</td>
                                        <td><input style="width:50px; text-align: center" type="text" class="change-price qaun_width" name="quantity[{{ $n }}]" id="noquantity_{{ $n }}" value="{{ (isset($array[$n]) != '' ? $array[$n] : 0) }}" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                </div>
            @endforeach
        </div>
    </div>
</form>
<div class="clearfix"></div>