
@extends('layouts.admin')

@push('styles')
@endpush

@section('content')

@section('pageHeading')
    <div class="col-lg-10">
        <h2>{{ __(isset($module_name) ? $module_name : '') }}</h2>
    </div>
@endsection
<div class="row main_admin_tables">

</div>
@endsection
