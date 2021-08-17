<style>
    .qaun_width {
        width: 50%
    }

</style>
<form method="post" id="productdepo">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <table class="margin-bottom-20">
                    <tr>
                        <td colspan="2"><strong>{{ __('Total stock') }} : </strong></td>
                        <td><strong>{{ (($totalquantity != '') ? " " . $totalquantity : 0) }}</strong></td>
                    </tr>
                </table>
            </div>
            <div class="clearfix"></div>
            <input type="hidden" name="product_id" value="{{  $product_id }}" class="product_id" />
            @if ($product_type == 'BOTH')
            @foreach($colors as $color)
            <div class="col-sm-2">
                <table class="table table-responsive table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60%">{{ $color['name'] }}</th>
                            <th>{{ __('Quantity') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sizes as $size)
                        @php $n = $color['id'] . "_" . $size['id']@endphp
                        <tr>
                            <td>{{ $size['name'] }}</td>
                            <td><input style="width:50px; text-align: center" class="change-quantity" type="text" name="quantity[{{  $n }}]" id="bothquantity_{{  $color['id'] . "_" . $size['id'] }}" value="{{  (isset($array[$n]) ? $array[$n] : 0) }}" /></td>
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
                            <th>{{ __('Quantity') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $n = $color['id'] @endphp
                        <tr>
                            <td>{{ __('No size') }}</td>
                            <td><input class="change-quantity" style="width:50px; text-align: center" type="text" name="quantity[{{  $n }}]" id="colorquantity_{{  $color['id'] }}" value="{{ (isset($array[$n]) ? $array[$n] : 0) }}" /></td>
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
                            <th>{{ __('Quantity') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $n = $size['id'] @endphp
                        <tr>
                            <td>{{ $size['name'] }}</td>
                            <td><input type="text" style="width:50px; text-align: center" class="change-quantity qaun_width" name="quantity[{{  $n }}]" id="sizequantity_{{  $size['id'] }}" value="{{  (isset($array[$n]) ? $array[$n] : 0) }}" /></td>
                        </tr>
                </table>
                </table>
            </div>
            @endforeach
            @else
            <div class="col-sm-2">
                <h5>{{ __('No color') }}</h5>
                <table class="table table-responsive table-bordered table-striped">
                    <tr>
                        <td>{{ __('No size') }}</td>
                        <td><input type="text" class="change-quantity qaun_width" name="quantity" id="noquantity" value="{{  ($array != '' ? $array : 0) }}" /></td>
                    </tr>
                </table>
            </div>
            @endif
            <div class="clearfix"></div>

        </div>
    </div>
</form>
<div class="clearfix"></div>
