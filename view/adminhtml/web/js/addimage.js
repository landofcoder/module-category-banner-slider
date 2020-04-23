define([
    'jquery',
    'jquery/ui',
    'Magento_Ui/js/modal/modal'
], function ($,modal) {
    var optionOnline = { type: 'slide',
        responsive: true,
        innerScroll: true,
        title: 'Add Gallery Form Another Website',

        buttons: [{
            text: $.mage.__('Save'),
            class: 'save-url-online',

            click: function () {
                this.closeModal();

                var urlOnline = $('#url-image-online').val();
                var urlController = $('#url-instagram').attr('data-url');

                $.ajax({
                    url: urlController,
                    type: "POST",
                    dataType: 'json',
                    showLoader: true,
                    data: {'urlOnline': urlOnline},
                    success: function (data) {
                        if(data.error){
                            $("#popup-modal-message").modal(ontions2).modal('openModal');
                            $('.url-online-image').val('');
                        }else {
                            $('#images_content').trigger('addItem', data);
                            $('#url-online-image').val('');
                        }

                    }
                });
            }
        },
            {
                text:$.mage.__('Cancel'),
                class:'',
                click:function () {
                    $('#url-online-image').val('');
                    this.closeModal();
                }
            }]
    };
    var ontions2 = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Attention',
        buttons:[{
            text: $.mage.__('Close'),
            click: function () {
                this.closeModal();
            }
        }]
    };
    var options = {
        type: 'slide',
        responsive: true,
        innerScroll: true,
        title: 'Add Gallery Form HashTag Instagram',

        buttons: [{
            text: $.mage.__('Save'),
            class: 'save-url-instagram',

            click: function () {
                this.closeModal();

                var urlhashTag = $('#url-instagram').val()+'?__a=1';
                var urlController = $('#url-instagram').attr('data-url');
                $.ajax({
                    url: urlController,
                    type: "POST",
                    dataType: 'json',
                    showLoader: true,
                    data: {'urlhashTag': urlhashTag},
                    success: function (data) {
                        if(data.error){
                            $("#popup-modal-message").modal(ontions2).modal('openModal');
                            $('#url-instagram').val('');
                        }else {
                            $.each(data, function(index, value ) {
                                $.each(value,function (itemIndex,values) {
                                    $('#images_content').trigger('addItem', values);
                                });
                            });
                            $('#url-instagram').val('');
                        }

                    }
                });
            }
        },
            {
                text:$.mage.__('Cancel'),
                class:'',
                click:function () {
                    $('#url-instagram').val('');
                    this.closeModal();
                }
            }]
    };
    $('#url-instagram').on('change', function () {

        var str = "https://www.instagram.com/explore/tags/";
        var n = $('#url-instagram').val();
        var compareUrl = n.indexOf(str);
        if(compareUrl == 0){
            $(".message-url-success").show();
            $(".message-url-fail").hide();
            $(".save-url-instagram").removeAttr('disabled');
        }else{
            $(".message-url-fail").show();
            $(".message-url-success").hide();
            $(".save-url-instagram").attr('disabled','disabled');
        }

    });
    $('.select-image-online').on('click',function () {
        $("#popup-modal").modal(options).modal('openModal');
        $(".save-url-instagram").attr('disabled','disabled');
        $(".message-url-fail").hide();
        $(".message-url-success").hide();
    });
    $('.add-image-online').on('click',function () {
        $("#slide-modal-online-image").modal(optionOnline).modal('openModal');
    })

});