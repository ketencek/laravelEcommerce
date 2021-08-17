<div class="col-sm-12">
    <div class="row">
        <form method="post" id="productoptions">
           @csrf
           <input type="hidden" value="{{ $product_id }}" name="product_id">
            <div class="col-sm-12">
                <div class="pull-right">
                    <button class="btn btn-site saveproductoptions" type="submit"><i class="fa fa-plus"></i> {{  __('Save') }} <i class="fa fa-spinner fa-spin hide"></i></button>
                </div>
                <h2 class="page-title-small margin-bottom-20">{{ __('Attribute') }}</h2>
            </div>
            <div class="col-sm-6">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 40%;text-align: left">{{  __('Title') }} </th>
                                <th style="width: 60%">{{  __('Value') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($options as $option)
                                <tr>
                                    <td>{{ $option['name'] }}</td>
                                    <td>
                                        <select name="optionvalue[{{ $option['id'] }}]" class="form-control" {{ $option['id'] == 4 ? 'multiple' : '' }}>
                                            <option value="">{{ __('Select') }}</option>
                                            @foreach($option->optionvalues as $value)
                                                <option value="{{ $value['id'] }}" {{  ((in_array($value['id'], $product_options)) ? 'selected="selected"' : '') }} >{{  $value['name'] }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>
<div class="clearfix"></div>