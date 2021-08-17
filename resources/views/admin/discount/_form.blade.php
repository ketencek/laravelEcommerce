{!! Form::model($result, ['url' => $url, 'method' => $method, 'enctype' => 'multipart/form-data', 'class' => 'validate_form', 'autocomplete' => 'off']) !!}

<ul class="nav nav-tabs pull-left">
    <li class="pull-right"><button class="btn btn-site save_btn" type="submit"><i class="fa fa-plus"></i>
            {{ __('Save') }}</button></li>
    <li class="active"><a data-toggle="tab" href="#general">{{ __('General') }}</a></li>
</ul>
<div class="clearfix"></div>
<div class="tab-content">
    <div class="col-sm-12 error_global hide">
        <div class="alert alert-danger">{{ __('Fill all required fields') }}</div>
    </div>
    @if ($errors->any())
        <div class="col-sm-12">
            <div class="alert alert-danger">
                {!! implode('', $errors->all('<p>:message</p>')) !!}
            </div>
        </div>
    @endif

    <div id="general" class="tab-pane fade in active">
        <div class="col-sm-2">
            <div class="form-group">
                <div class="form-group {{ $errors->first('discount_percentage') ? 'has-error' : '' }}">
                    <label class="control-label" for="d_discount_percentage">{{ __('Discount percentage') }}</label>
                    :<span class="require">*</span>
                    <div class="input-group">
                        {!! Form::text('discount_percentage', $result != '' ? $result->discount_percentage : null, ['class' => 'form-control required', 'id' => 'd_discount_percentage']) !!}
                        <span class="input-group-addon" id="basic-addon2">%</span>
                    </div>
                    @if ($errors->has('discount_percentage'))
                        <span class="error"
                            id="d_discount_percentage">{{ $errors->first('discount_percentage') }}</span>
                    @endif
                </div>
            </div>
        </div>
        @if ($type == 'global-user')
            <div class="col-sm-2">
                <div class="form-group {{ $errors->first('discount_code') ? 'has-error' : '' }}">
                    <label class="control-label" for="d_discount_code">{{ __('Discount code') }}</label> :<span
                        class="require">*</span>
                    {!! Form::text('discount_code', $result != '' ? $result->discount_code : null, ['class' => 'form-control required', 'id' => 'd_discount_code']) !!}
                    @if ($errors->has('discount_code'))
                        <span class="error" id="d_discount_code">{{ $errors->first('discount_code') }}</span>
                    @endif
                </div>
            </div>
            @php
                $languages = \App\Models\PriceType::pluck('name', 'name')->toArray();
                $curr = config('settingconfig.default_currency') ? strtoupper(config('settingconfig.default_currency')) : '';
            @endphp
            <div class="col-sm-3">
                <div class="form-group {{ $errors->first('min_amount') ? 'has-error' : '' }}"">
                        <label class=" control-label" for="d_min_amount">{{ __('Min amount') }}</label> :<span
                        class="require">*</span>
                    <div class="input-group">
                        @if ($curr == '')
                            {!! Form::text('min_amount', $result != '' ? $result->min_amount : null, ['class' => 'form-control required number', 'id' => 'd_min_amount', 'readonly' => 'readonly']) !!}
                        @else
                            {!! Form::text('min_amount', $result != '' ? $result->min_amount : null, ['class' => 'form-control required number', 'id' => 'd_min_amount']) !!}
                        @endif
                        <div class="input-group-btn">
                            <button type="button" style="padding: 4px 12px !important;"
                                class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="btn_curr">{{ $languages[$curr] }}</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($languages as $k => $value)
                                    <li data-curr='{{ $k }}' class="change_currency"><a
                                            href="javascript:void(0)">{{ $value }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @if ($errors->has('min_amount'))
                        <span class="error" id="d_min_amount">{{ $errors->first('min_amount') }}</span>
                    @endif
                </div>
            </div>
        @endif
        <div class="clearfix"></div>
        <div class="col-sm-3">
            <div class="form-group {{ $errors->first('discount_start_date') ? 'has-error' : '' }}">
                <label class="control-label" for="d_discount_start_date">{{ __('Discount start date') }}</label>
                :<span class="require">*</span>
                {!! Form::text('discount_start_date', $result != '' ? $result->formated_discount_start_date : null, ['class' => 'form-control required', 'readonly' => 'readonly', 'id' => 'd_discount_start_date']) !!}
                @if ($errors->has('discount_start_date'))
                    <span class="error"
                        for="d_discount_start_date">{{ $errors->first('discount_start_date') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group {{ $errors->first('discount_end_date') ? 'has-error' : '' }}">
                <label class="control-label" for="d_discount_end_date">{{ __('Discount end date') }}</label> :<span
                    class="require">*</span>
                {!! Form::text('discount_end_date', $result != '' ? $result->formated_discount_end_date : null, ['class' => 'form-control required', 'readonly' => 'readonly', 'id' => 'd_discount_end_date']) !!}
                @if ($errors->has('discount_end_date'))
                    <span class="error" for="blog_discount_end_date">{{ $errors->first('discount_end_date') }}</span>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        @if ($type == 'global-user')
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" id="get_user_id" class="form-control" name="">
                </div>
            </div>
            <div class="col-sm-4">

                <table class="table table-striped table-bordered table-hover" id="user_table">
                    @if ($result != '' && $result['users'])
                        @php
                            $user_ids = [];
                        @endphp
                        @foreach ($result['users'] as $key => $user)
                            @php
                                $user_ids[] = $user['id'];
                            @endphp
                            <tr data-id='{{ $user['id'] }}'>
                                <td style="text-align: left">
                                    {{ $user['first_name'] . ' ' . $user['last_name'] . ' (' . $user['email'] . ')' }}<a
                                        class="remove_user pull-right delete"><i class='fa fa-times'
                                            aria-hidden='true'></i></a></td>
                            </tr>
                        @endforeach
                        @php
                            $user_ids = implode(',', $user_ids);
                        @endphp
                    @endif
                </table>
                <input type="hidden" id="discount_user_id" name="user_id"
                    value="{{ isset($user_ids) ? $user_ids : '' }}">
            </div>
            <div class="hidden_user_id hidden">
            </div>
            <div class="clearfix"></div>
        @endif
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status', 1, $result != '' ? $result->status : true, ['id' => 'colors_status']) }}
                    {{ __('Status') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>
</div>
{!! Form::close() !!}
@include('admin.general.addForm')

@push('scripts')
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datetimepicker.min.css') }}" />
    <script src="{{ asset('plugins/datepicker/js/moment.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>


    <script type="text/javascript">
        var user_id_array = $('#discount_user_id').val();
        if (user_id_array) {
            user_id_array = user_id_array.split(",");
        } else {
            user_id_array = [];
        }

        $(document).ready(function() {
            $('#d_discount_start_date,#d_discount_end_date').datetimepicker({
                format: "dd-mm-yyyy hh:ii",
                startDate: '-1d',
                // defaultDate: moment().subtract(1, 'days')
            });
            $('#d_discount_start_date').datetimepicker().on('change.dp', function(e) {
                var date = $(this).val();
                date = date.split("-");
                date = date[1] + '-' + date[0] + '-' + date[2];
                var minDate = new Date(date);
                minDate.setMinutes(minDate.getMinutes() + 5);
                $('#d_discount_end_date').data('datetimepicker').setStartDate(minDate);
            });

            $('#d_discount_end_date').datetimepicker().on('change.dp', function(e) {
                var date = $(this).val();
                date = date.split("-");
                date = date[1] + '-' + date[0] + '-' + date[2];
                var maxDate = new Date(date);
                maxDate.setMinutes(maxDate.getMinutes() - 5);
                $('#d_discount_start_date').data('datetimepicker').setEndDate(maxDate);
            });
            @if ($type == 'global-user')
                $(document).on("click", ".change_currency", function() {
                var curr = $(this).attr('data-curr');
                $('#discount_price_unit').val(curr);
                if (curr == '') {
                $('#discount_min_amount').val(0.00);
                $('#discount_min_amount').attr('readonly', 'readonly');
                curr = '{{ __('Currency') }}';
                } else {
                $('#discount_min_amount').removeAttr('readonly');
                }
                $('.btn_curr').html(curr);
                });
            
                $(document).on('click', '.remove_user', function() {
                var id = $(this).parents('tr').data('id');
                var index = user_id_array.indexOf(id.toString());
                if (index !== -1)
                user_id_array.splice(index, 1);
                // user_id_array.splice($.inArray(id, user_id_array), 1);
                $("#discount_user_id").val(user_id_array);
                $(this).parents('tr').remove();
                });
            
                typehead('{{ route('admin.discounts.findUser') }}', "#get_user_id");
            @endif
        });
    </script>

    @if ($type == 'global-user')
        <script src="{{ asset('plugins/typehead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            function typehead(get_data_url, from_id) {
                var from_air = new Bloodhound({
                    limit: 100,
                    datumTokenizer: function(d) {
                        return d.tokens;
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: get_data_url,
                        filter: function(caris) {
                            return $.map(caris, function(cari) {
                                return {
                                    name: cari.Name,
                                    id: cari.Id
                                };
                            });
                        },
                        replace: function(url, query) {
                            return url + '#' + query;
                        },
                        ajax: {
                            type: "GET",
                            data: {
                                query: function() {
                                    return $(from_id).val();
                                }
                            },
                            beforeSend: function(msg) {
                                $(from_id).addClass('spinner');
                            },
                            success: function(msg) {
                                $(from_id).removeClass('spinner');
                            }
                        }
                    }
                });
                $(from_id).typeahead({
                    items: 100
                }, {
                    name: "Search",
                    displayKey: "name",
                    source: from_air.ttAdapter(),
                    hint: false
                });
                from_air.initialize();
                $(from_id).on('typeahead:selected', function(evt, item) {
                    user_id_array.push(item.id);
                    $("#discount_user_id").val(user_id_array);
                    $("#user_table").append("<tr data-id='" + item.id + "'><td style='text-align: left'>" + item.name +
                        "<a class='remove_user pull-right delete'><i class='fa fa-times' aria-hidden='true'></i></a></td></tr>"
                        );
                    $("#get_user_id").val('');
                });
            }
        </script>
    @endif
@endpush
