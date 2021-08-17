@extends('layouts.admin')

@section('content')

    <h3 class="page-title">{{ __('Newsletter import') }}
        <div class="pull-right">
            <a class="btn btn-site" role="button" href="{{ route('admin.newsletters.index') }}" id="add"><i
                    class="fa fa-list"></i> {{ __('List') }}</a>
        </div>
    </h3>
    <div class="clearfix"></div>
    @if (Session::has('msg'))
        <div id="add_success" class="alert alert-success margin-bottom-0 flash_notice">{{ Session::get('msg') }}</div>
    @endif
    <div class="clearfix"></div>
    <div class="well form_tabs">
        <div class="row">
            <div class="col-sm-4">
                <form class="validate_form" enctype="multipart/form-data" method="post" role="form"
                    action="{{ route('admin.newsletters.import') }}">
                    @csrf
                    <div class="form-group">
                        <label>Select excel file</label>
                        <input type="file" name="file" id="file" class="required" />
                    </div>
                    @php
                        $newsletter_roles_arr = \App\Models\Setting::where('label', 'Setting_newsletter_type')->get();
                    @endphp
                    <div class="form-group">
                        <label>{{ __('Subscribed type') }}</label>
                        <select name="newletter_type" id="newletter_type" class="form-control required">
                            <option value="">{{ __('Select type') }}</option>

                            @foreach ($newsletter_roles_arr as $type)
                                <option value="{{ $type['name'] }}">{{ $type['value'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-site" name="Import" value="Import"><i class="fa fa-upload"></i>
                        {{ __('Upload file') }}</button>
                </form>
            </div>
            <div class="col-sm-6 col-sm-offset-1">
                <h3 style="font-size: 20px">Demo Excel file</h3>
                <a href="{{ asset('admins/images/Newsletter.xls') }}"><i class="fa fa-download"></i>
                    {{ __('Download file') }}
                </a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @include('admin.general.addForm')
@endsection
