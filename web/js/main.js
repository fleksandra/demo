$(document).ready(function(){
    $('#cart-link').click( function(e) {
        e.preventDefault();
        getCart();
        $("#cart").modal();
    })

    $('#catalog').on('click', '.add', function(e) {
        e.preventDefault();
        $.ajax({
            url: '/cart/add',
            method: 'post',
            data: {id: $(this).data('id')},
            async: false,
            success: function (data) {
                if(data != true){
                    $('#error').modal('show');
                    setTimeout(function() {
                        $('#error').modal('hide');
                    }, 3000);
                }
            }
        });
    })

    $('#clear').click( function(e) {
        e.preventDefault();
        $.ajax({
            url: '/cart/clear-cart',
            method: 'post',
            async: false,
            success: function (data) {
                getCart();
            }
        });
    })

    function getCart() {
        $.ajax({
            url: '/cart/view',
            method: 'post',
            async: false,
            success: function (data) {
                if(data) {
                    $('#body-cart').html(data);
                    if($('#cart-view').data('isset') == 1) {
                        $('#order').removeClass('disabled');
                        $('#clear').removeClass('disabled');
                    } else {
                        $('#order').addClass('disabled');
                        $('#clear').addClass('disabled');
                    }
                    return true;
                }
            }
        });
    }

    $('#cart').on('click', '.delete', function(e) {
        e.preventDefault();
        let btn = $(this);
        $.ajax({
            url: '/cart/delete',
            method: 'post',
            data: {id: btn.data('id')},
            async: false,
            success: function (data) {
                if(data){
                    getCart();
                }
            }
        });
    })

    $('#cart').on('click', '.svg-add', function(e) {
        e.preventDefault();
        let btn = $(this);
        $.ajax({
            url: '/cart/add-count',
            method: 'post',
            data: {id: btn.data('id')},
            async: false,
            success: function (data) {
                if(data){
                    getCart();
                } else {
                    $('#error').modal('show');
                    setTimeout(function() {
                        $('#error').modal('hide');
                    }, 3000);
                }
            }
        });
    })

    $('#cart').on('click', '.svg-delete', function(e) {
        e.preventDefault();
        let btn = $(this);
        $.ajax({
            url: '/cart/delete-count',
            method: 'post',
            data: {id: btn.data('id')},
            async: false,
            success: function (data) {
                if(data){
                    getCart();
                }
            }
        });
    })

    $('#catalog-pjax').on('change', '#productsearch-category_id', function(e){       
        $("#form-search").submit();
    })
})

