$(document).ready(function () {
  $('.toogle_bar').on('click', function () {
    if ($("body").hasClass('shrink_panel')) {
      $("body").removeClass('shrink_panel');
      setCookie('leftpanel_shrink', 'no', '30');
    } else {
      $("body").addClass('shrink_panel');
      setCookie('leftpanel_shrink', 'yes', '30');
    }
  });
  if ($(window).width() > 768) {
    $('.drop > a').on('click', function () {
      if (!$("body").hasClass('shrink_panel')) {
        $(this).parent().find('.dropdown-menu').slideToggle('100', function () {
          $(this).parent().toggleClass('active', '100');
        });
      }
    });
    $(".drop").not('.active').hover(
      function () {
        if ($("body").hasClass('shrink_panel')) {
          $(this).addClass('active');
        }
      }, function () {
        if ($("body").hasClass('shrink_panel')) {
          $(this).removeClass('active');
        }
      });
  }
  $("#selectall").on('click', function () { // bulk checked
    var status = this.checked;
    $(".allcheckbox").each(function () {
      $(this).prop("checked", status);
    });
  });
  $(document).on("click", ".change_status", function () {
    var parent = $(this);
    var ids = [];
    var idrow = this.id.split('-');
    ids.push(idrow[1]);
    var params = '';
    var rowparam = parent.attr('href').split('-');
    if (rowparam[1] == '1') {
      params = '0';
    } else {
      params = '1';
    }

    var field = rowparam[0];
    ChangeMultiple(ids, field, params);
    return false;
  });
  $(document).on("click", ".imagedelete", function () {
    var parent = $(this);
    if (confirm('Are you sure ?')) {
      $.ajax({
        type: 'GET',
        url: $(this).attr('href'),
        dataType: 'json',
        success: function (data) {
          $('#image_display').html('');
        }
      });
    }
    return false;
  });
  $(document).on("click", ".bannerdelete", function () {
    var parent = $(this);
    if (confirm('Are you sure ?')) {
      $.ajax({
        type: 'GET',
        url: $(this).attr('href'),
        dataType: 'json',
        success: function (data) {
          $('#banner_display').html('');
        }
      });
    }
    return false;
  });
  $(document).on("click", ".delete_row", function () {
    if (confirm("Are you sure ?")) {

      var parent = $(this);
      parent.addClass('disabled');
      parent.html('<i class="fa fa-spinner fa-spin"></i>');
      var ids = [];
      delsplit = $(this).attr('href').split('-');
      ids.push(delsplit[1]);
      DeleteMultiple(ids);
    }
    return false;
  });
  var discount_object_id = [];
  $(document).on("click", "#multi-action", function () {
    if ($('#action').val() == "") {
      notify("Please select an action", "danger");
      return false;
    } else {
      if ($('.allcheckbox:checked').length > 0) {

        var ids = [];
        $('.allcheckbox').each(function () {
          if ($(this).is(':checked')) {
            ids.push($(this).val());
          }
        });
        var rowparam = $('#action').val().split('-');
        if ($('#action').val() == "delete") {

          if (confirm("Are you sure ?")) {
            $("#multi-action i").removeClass('hide');
            $("#multi-action").addClass('disabled');
            DeleteMultiple(ids);
          }

        } else if (rowparam[0] == "change") {
          var params = '';
          params = rowparam[2];
          var field = rowparam[1];
          $("#multi-action i").removeClass('hide');
          $("#multi-action").addClass('disabled');
          ChangeMultiple(ids, field, params);
        } else if ($('#action').val() == "discount") {
          openDiscountModel();
          discount_object_id = ids;
        }
      } else {
        notify("Select any checkbox", "danger");
      }
    }
  });
  $(document).on('change', '.add_discount', function () {
    if ($('#action').val() == "discount") {
      var table = $('#table_name').val();
      var newurl = 'table_name=' + table + '&ids=' + discount_object_id + '&discount_id=' + $(this).data('id');
      $.ajax({
        type: 'GET',
        url: $('#discount_url').val(),
        data: newurl,
        dataType: 'json',
        success: function (data) {
          if (data.status == 'success') {
            $('#myModal').modal('hide');
          }
        }
      });
    }
  });
  function openDiscountModel() {
    $('.my-model').html('<i class="fa fa-spin fa-spinner font-22 margin-15"></i>');
    $('.my-model').addClass('text-center');
    $('#myModal').modal('show');
    $.ajax({
      type: 'GET',
      url: $('#discount_list_url').val(),
      dataType: 'json',
      success: function (data) {
        if (data.status == 'success') {
          $('.my-model').removeClass('text-center');
          $('#myModal').find('.my-model').html(data.html);
          $('#myModal').find('.remove_dicount').remove();
          $('#myModal .modal-header').removeClass('hide');
          $('#myModal .modal-footer').removeClass('hide');
        }
      }
    });
  }

  function DeleteMultiple(ids) {

    var table = $('#table_name').val();
    var newurl = '';
    var folder_name = $('#folder_name').val();
    if (folder_name == '') {
      newurl = 'table_name=' + table + '&id=' + ids;
    } else {
      newurl = 'table_name=' + table + '&id=' + ids + '&folder_name=' + folder_name;
    }

    $.ajax({
      type: 'GET',
      url: $('#delete_url').val(),
      data: newurl,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'Success') {
          if (table == 'Category' || table == 'Menu') {
            $(ids).each(function () {
              $('.cat-' + this).remove();
            });
          } else {
            $(ids).each(function () {
              $('#row-' + this).remove();
            });
          }
          $("#multi-action i").addClass('hide');
          $("#multi-action").removeClass('disabled');
          notify(data.message, "success");
        } else {
          notify(data.message, "success");

          $('.delete_row').removeClass('disabled');
          $('.delete_row').html('<i class="fa fa-times"></i>');
        }
      }
    });
  }
  function ChangeMultiple(ids, field, params) {

    var table = $('#table_name').val();
    $(ids).each(function () {
      $('#' + field + '-' + this).addClass('disabled');
      $('#' + field + '-' + this).html('<i class="fa fa-spinner fa-spin"></i>');
    });
    $.ajax({
      type: 'GET',
      url: $('#status_url').val(),
      data: 'id=' + ids + '&table_name=' + table + '&field=' + field + '&param=' + params,
      dataType: 'json',
      error: function (data) {
        notify("Something went wrong", "danger");
      },
      success: function (data) {
        $(ids).each(function () {

          if (params == '1') {
            if (field == 'on_home') {
              htmlsuc = '<i class="fa fa-home green"></i>';
            } else {
              htmlsuc = '<i class="fa fa-check-square-o"></i>';
            }

            $('#' + field + '-' + this).attr('href', field + '-1');
            $('#' + field + '-' + this).html(htmlsuc);
          } else {
            if (field == 'on_home') {
              htmlsuc = '<i class="fa fa-home black"></i>';
            } else {
              htmlsuc = '<i class="fa fa-square-o"></i>';
            }
            $('#' + field + '-' + this).attr('href', field + '-0');
            $('#' + field + '-' + this).html(htmlsuc);
          }
          $('#' + field + '-' + this).removeClass('disabled');
          $("#multi-action i").addClass('hide');
          $("#multi-action").removeClass('disabled');
        });
      }
    });
  }

  $(document).on("click", ".view_more", function () {
    $('.my-model').html('<i class="fa fa-spin fa-spinner font-22 margin-15"></i>');
    $('.my-model').addClass('text-center');
    $.ajax({
      type: 'GET',
      url: $(this).attr('href'),
      dataType: 'html',
      success: function (data) {
        $('.my-model').removeClass('text-center');
        $('.my-model').html(data);
      },
    });
    $(".modal").modal('show');
    return false;
  });
  $(document).on("click", ".export_btn", function () {

    if ($(this).hasClass("all_id")) {
      $(this).attr('href', url);
      return true;
    } else {
      if ($('.allcheckbox:checked').length > 0) {
        var url = $(this).attr('href');
        var ids = [];
        $('.allcheckbox').each(function () {
          if ($(this).is(':checked')) {
            ids.push($(this).val());
          }
        });
        $(this).attr('href', url + '?id=' + ids);
        return true;
      } else {
        notify("Select any checkbox", "danger");

        return false;
      }
    }
  });
  setTimeout(function () {
    $('body').removeClass('loading_smooth');
  }, 300);
});