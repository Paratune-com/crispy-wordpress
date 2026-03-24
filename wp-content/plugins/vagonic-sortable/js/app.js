(function ($) {

  $(function () {

    $.ajax({
      url: ajaxurl,
      dataType: "html",
      method: "POST",
      data: {
        action: 'vagonic_sortable_lite_get_categories'
      },
      success: function (data) {

        $('#categoryList').append($(data));
        $( '#categoryList > .list-group-item' ).each(function( index ) {
          $( this ).find('a').first().on('click', function() {
            const id = $(this).attr('id');
            $(this).parent().parent().find('.list-group-item').removeClass('active');
            $(this).parent().addClass('active');
            $('.spinner-border').toggle();
            $('input[name="cat_id"]').val(id);
            getProducts(id, true, function (data) {
              $('.spinner-border').toggle();
              $('#product_items').html(data);
            }, $('#checkPriceForCat').is(':checked'), $('#checkStockForCat').is(':checked'));
          });
        });
      }
    });

    $.ajax({
      url: ajaxurl,
      dataType: "html",
      method: "POST",
      data: {
        action: 'vagonic_sortable_lite_get_tags'
      },
      success: function (data) {

        $('#tagList').append($(data));
        $( '#tagList > .list-group-item' ).each(function( index ) {
          $( this ).find('a').first().on('click', function() {
            const id = $(this).attr('id');
            $(this).parent().parent().find('.list-group-item').removeClass('active');
            $(this).parent().addClass('active');
            $('.spinner-border').toggle();
            $('input[name="tag_id"]').val(id);
            getProducts(id, false, function (data) {
              $('.spinner-border').toggle();
              $('#product_items').html(data);
            }, $('#checkPriceForTag').is(':checked'), $('#checkStockForTag').is(':checked'));
          });
        });
      }
    });

    //type true is category or false is tag
    function getProducts(id, type, success, isPrice = false, isStock = false) {

      if (type) {
        $.ajax({
          url: ajaxurl,
          dataType: "html",
          method: "POST",
          data: {
            cat_id: id,
            isPrice: isPrice,
            isStock: isStock,
            action: 'vagonic_sortable_lite_get_category_products'
          },
          success: success
        });
      } else {
        $.ajax({
          url: ajaxurl,
          dataType: "html",
          method: "POST",
          data: {
            tag_id: id,
            isPrice: isPrice,
            isStock: isStock,
            action: 'vagonic_sortable_lite_get_tag_products'
          },
          success: success
        });
      }

    }

    $('.btn-column').on('click', function () {
      $(this).parent().parent().find('.btn-column').removeClass('active');
      $(this).addClass('active');
    });

    $('#panelTitleCategory').find('a').on('click', function () {
      $('#categoryList').toggleClass('list-group-collapsed');
    });

    $('#panelTitleTag').find('a').on('click', function () {
      $('#tagList').toggleClass('list-group-collapsed');
    });

    $("#searchCategory").on("keyup", function () {
      var value = $(this).val().toLowerCase();
      $("#categoryList div").filter(function () {
        $(this).toggle($(this).find('a').first().text().toLowerCase().indexOf(value) > -1)
      });
    });

    $("#searchTag").on("keyup", function () {
      var value = $(this).val().toLowerCase();
      $("#tagList div").filter(function () {
        $(this).toggle($(this).find('a').first().text().toLowerCase().indexOf(value) > -1)
      });
    });

    $('#vagonicSidebarCollapse').on('click', function () {
      $('#vagonicSidebar').toggleClass('active');
    });

    $('#vagonicSidebarCollapseAuto').on('click', function () {
      $('#vagonicSidebar').toggleClass('active');
    });

    $("#btn-upgrade-show").click(function () {
      $('.nav-tabs a[href="#settings"]').tab('show');
    });

    $('.spinner-border').toggle();

    $("#checkPriceForCat, #checkStockForCat").on('change', function () {
      $('.spinner-border').toggle();
      getProducts($('input[name="cat_id"]').val(), true, function (data) {
        $('.spinner-border').toggle();
        $('#product_items').html(data);
      },
        $('#checkPriceForCat').is(':checked'),
        $('#checkStockForCat').is(':checked'));
    });

    $("#checkPriceForTag, #checkStockForTag").on('change', function () {
      $('.spinner-border').toggle();
      getProducts($('input[name="tag_id"]').val(), false, function (data) {
        $('.spinner-border').toggle();
        $('#product_items').html(data);
      },
        $('#checkPriceForTag').is(':checked'),
        $('#checkStockForTag').is(':checked'));
    });

    $(".btn-pref .btn").click(function () {
      $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
      // $(".tab").addClass("active"); // instead of this do the below 
      $(this).removeClass("btn-default").addClass("btn-primary");
    });

    /** Category */
    $("#frm_category_vagonic_sortable_lite").submit(function (e) {
      e.preventDefault();

      $.ajax({
        type: "POST",
        url: ajaxurl,
        data: $('#frm_category_vagonic_sortable_lite, #frm_products_vagonic_sortable_lite').serialize(),
        success: function (response) {
          Toastify({
            text: response,
            duration: 3000,
            newWindow: true,
            gravity: "top",
            position: 'right',
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            stopOnFocus: true,
            onClick: function () { }
          }).showToast();

          getProducts($('input[name="cat_id"]').val(), true, function (data) {
            $('#product_items').html(data);
          }, $('#checkPriceForCat').is(':checked'), $('#checkStockForCat').is(':checked'));
        }
      });
    });

    /** Tags */
    $("#frm_tag_vagonic_sortable_lite").submit(function (e) {
      e.preventDefault();

      $.ajax({
        type: "POST",
        url: ajaxurl,
        data: $('#frm_tag_vagonic_sortable_lite, #frm_products_vagonic_sortable_lite').serialize(),
        success: function (response) {
          Toastify({
            text: response,
            duration: 3000,
            newWindow: true,
            gravity: "top",
            position: 'right',
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            stopOnFocus: true,
            onClick: function () { }
          }).showToast();

          getProducts($('input[name="tag_id"]').val(), false, function (data) {
            console.log(data);
            $('#product_items').html(data);
          }, $('#checkPriceForTag').is(':checked'), $('#checkStockForTag').is(':checked'));
        }
      });

    });

    Sortable.create(document.getElementById('product_items'), {
      forceFallback: true,
      multiDrag: true,
      selectedClass: "selected",
      handle: ".draggable",
      onEnd: function (evt) {
        update_all_index($('#product_items .card-vagonic'));
      }
    });

    function update_all_index(el) {
      el.each(function (index, element) {
        $(this).find('input[name="menu_order[]"]').val(index);
      });
    }
  });

  $("#frm_settings_vagonic_sortable_lite").submit(function (e) {
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: ajaxurl,
      dataType: 'json',
      data: $('#frm_settings_vagonic_sortable_lite').serialize(),
      success: function (response) {
        Toastify({
          text: response.message,
          duration: 3000,
          newWindow: true,
          gravity: "top",
          position: 'right',
          backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
          stopOnFocus: true,
          onClick: function () { }
        }).showToast();

      }
    });
  });

})(jQuery);