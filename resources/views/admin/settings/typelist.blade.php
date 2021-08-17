@extends('layouts.admin')

@section('content')

@php 
$settings = config('customconfig.settings_type');
@endphp

<h3 class="page-title">{{ __('Settings type')}}</h3>
<div class="clearfix"></div>
<div class="row">
  <div class="col-sm-12">
    <div class="table-responsive">
      <table id="table" class="table table-striped  table-bordered table-hover">
	<thead>
	  <tr>
	    <th class=""><input type="checkbox"  id="selectall"  /></th>
	    <th class="">{{ __('Title')  }}</th>
	    <th class="text-center">{{ __('Actions') }}</th>
	  </tr>
	</thead>
	<tbody>
	  @if (count($settings)) 
		  @foreach ($settings as $k => $setting)
	    	  <tr id="row-{{$setting}}">
	    	    <td class="text-center"><input type="checkbox" class="allcheckbox" value="{{ $setting }}" /></td>
	    	    <td>{{  __($setting) }} </td>
	    	    <td class="text-center action_div">
	    	      <a class="View" title="<?php echo __('Edit') ?>" target="_blank" href="{{ route('admin.settings.index',['type'=>$setting]) }}"><i class="fa fa-arrow-right"></i></a>
	    	    </td>
	    	  </tr>

		  @endforeach
	    @else
		  <tr>
		    <td colspan="6">
		     {{ __('No Record found') }}
		    </td>
		  </tr>
	  @endif
	</tbody>
      </table>
    </div>
    <div class="clearfix"></div>
    @include('admin.general.changeMultiAction', array(
		'ajax_url'=> '',
        'action' => array()
		))
  </div>
</div>
<div class="clearfix"></div>
@endsection