@extends('layouts.admin')

@section('content')
    <h3 class="page-title">{{ $label }}
        <div class="pull-right">
            <a class="btn btn-site" role="button" href="{{ route('admin.newsletter-messages.create') }}" id="add"><i
                    class="fa fa-plus"></i> {{ __('Add') }}</a>
        </div>
    </h3>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="table-responsive">
                <table id="table" class="table table-striped  table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectall" /></th>
                            <th class="">{{ __('Subject') }}</th>
                            <th class="">{{ __('Message') }}</th>
                            <th class="text-center ">{{ __('View more') }}</th>
                            <th class="text-center ">{{ __('Send') }}</th>
                            <th class="text-center status_td">{{ __('Status') }}</th>
                            <th class="text-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody id="product_rows">
                        @if (count($messages))
                            @foreach ($messages as $k => $language)
                                <tr id="row-{{ $language['id'] }}" class="row-move">
                                    <td class="text-center"><input type="checkbox" class="allcheckbox"
                                            value="{{ $language['id'] }}" /></td>
                                    <td>{{ getSubString($language['subject'], 50) }}</td>
                                    <td>{{ getSubString(getcontent($language['body']), 100) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.newsletter-messages.show', ['id' => $language['id']]) }}"
                                            class="table_link view_more">{{ __('View More') }} <i
                                                class="fa fa-angle-double-right"></i></a>
                                    </td>
                                    <td class="text-center">
                                        {{-- <a href="{{ route('admin.newsletter-messages.send', ['id' => $language['id']]) }}"
                                            class="table_link send_mail"><i class="fa fa-envelope-o"></i>
                                            {{ __('Send Mail') }} <i class="fa fa-spinner fa-spin hide"></i>
                                        </a> --}}
                                    </td>
                                    <td class="text-center">
                                        <a id="status-{{ $language['id'] }}" href="status-{{ $language['status'] }}"
                                            class="green change_status">
                                            <i
                                                class="fa fa-{{ $language['status'] == 1 ? 'check-square-o' : 'square-o' }}"></i>
                                        </a>
                                    </td>
                                    <td class="text-center action_div">
                                        @include('admin.general.action_btn', ['id' => $language->id, 'route' =>
                                        'admin.newsletter-messages'])
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9">
                                    {{ __('No Record found') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
            @include('admin.general.changeMultiAction', array(
            'table_name' => 'newsletter-messages',
            'folder_name' =>'newslettermessage',
            'is_orderby'=> 'yes',
            'ajax_url'=> '',
            'action' => array(
            'change-status-1' => __('Active'),
            'change-status-0' => __('Inactive'),
            'delete' => __('Delete'))
            ))
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content my-model">
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.send_mail', function() {
                var parent = $(this);
                parent.addClass('disabled');
                parent.find('.fa-spin').removeClass('hide');
                $.ajax({
                    type: 'post',
                    url: $(this).attr('href'),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 'success') {
                            $.notify(data.message, {
                                type: "success",
                                delay: 3000,
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                animate: {
                                    enter: 'animated fadeInRight',
                                    exit: 'animated fadeOutRight'
                                }
                            });
                        } else {
                            $.notify(data.message, {
                                type: "danger",
                                delay: 3000,
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                animate: {
                                    enter: 'animated fadeInRight',
                                    exit: 'animated fadeOutRight'
                                }
                            });
                        }
                        parent.removeClass('disabled');
                        parent.find('.fa-spin').addClass('hide');
                    },
                });
                return false;
            });
        });
    </script>
@endpush
