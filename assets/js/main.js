(function($){
    $('body').on('click','.btn_zahok_customer_check',function(event){
        event.preventDefault();
        let data = {
            order_id:$(event.target).attr('data-order-id'),
            action:'zahok_customer_check'
        }
        // Initialize Magnific Popup
        $.magnificPopup.open({
            items: {
                src: zahok.ajax_url,
                type: 'ajax',
            },
            modal: false,
            ajax: {
                settings: {
                    type: 'POST',
                    data: data,
                    headers: {
                        'Custom-Header': 'YourHeaderValue',
                    },
                },
                tError: 'Error loading content.',
            },
            //closeOnBgClick: false,
            closeBtnInside: true,
        });
    })
}(jQuery))