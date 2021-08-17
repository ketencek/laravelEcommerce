<div class="col-sm-8">
  <div class="row">
    <div class="col-sm-6">
      <input name="prod-size" id="prod-size" placeholder="{{__('Select size') }}" class="form-control" type="text"  />
    </div>
    <div class="col-sm-12 margin-top-15">
      <table class="table table-striped table-bordered">
	<thead>
	  <tr>
	    <th>{{__('No')}}</th>
	    <th>{{__('Title')}}</th>
	    <th class="text-center">{{__('Delete')}}</th>
	  </tr>
	</thead>
	<tbody id="product_rows">
	  @foreach ($selectedsizes as $k => $row)
		  <tr id="row-{{$row['id'] }}" class="row-move">
		    <td>{{$k + 1 }}</td>
		    <td>{{ $row['name'] }}</td>
		    <td class="text-center action_div">
		      <a href="{{ route('admin.products.deleteProductSize') }}" class="delete removerow" id="delete_{{$row['id']}}"><i class="fa fa-times" ></i></a>
		      <a class="handle" href="javascript:void(0)"><i class="fa fa-arrows"></i></a>
		    </td>
		  </tr>
	   @endforeach
	<tbody>
      </table>
    </div>
  </div>
</div>
<div class="col-sm-4 border-left">
  <a href="{{ route('admin.sizes.store')}}" class="btn btn-site btn-block" target="_blank"><i class="fa fa-plus"></i> <?php echo __('Add size'); ?></a>
</div>
<input type="hidden" name="table_name" id="table_name" value="product_sizes"/>

<div class="clearfix"></div>
<script type="text/javascript">
    $(document).ready(function () {
      $("#product_rows").sortable({
	items: ".row-move",
	cursor: 'move',
	handle: ".handle",
	opacity: 0.5,
	update: function (event, ui) {
	  jQuery.ajax({
	    type: 'post',
	    dataType: 'html',
	    success: function (data) {
	    },
	    data: $(this).sortable('serialize'),
	    url: $('#orderby_url').val() + '?table_name=' + $('#table_name').val()
	  });
	}
      });
      $("#sortable").disableSelection();
    });
</script>