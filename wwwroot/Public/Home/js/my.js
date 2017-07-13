//ajax get璇锋眰
$('.ajax-get').click(function(){
    var target;
    var that = this;
    if ( $(this).hasClass('confirm') ) {
        if(!confirm('纭瑕佹墽琛岃鎿嶄綔鍚�?')){
            return false;
        }
    }
    if ( (target = $(this).attr('href')) || (target = $(this).attr('url')) ) {
        $.get(target).success(function(data){
            if (data.status==1) {
                if (data.url) {
                    updateAlert(data.info + ' 椤甸潰鍗冲皢鑷姩璺宠浆~','alert-success');
                }else{
                    updateAlert(data.info,'alert-success');
                }
                setTimeout(function(){
                    if (data.url) {
                        location.href=data.url;
                    }else if( $(that).hasClass('no-refresh')){
                        $('#top-alert').find('button').click();
                    }else{
                        location.reload();
                    }
                },1500);
            }else{
                updateAlert(data.info);
                setTimeout(function(){
                    if (data.url) {
                        location.href=data.url;
                    }else{
                        $('#top-alert').find('button').click();
                    }
                },1500);
            }
        });

    }
    return false;
});


//ajax post submit璇锋眰
$('.ajax-post').click(function(){
    var target,query,form;
    var target_form = $(this).attr('target-form');
    var that = this;
    var nead_confirm=false;
    if( ($(this).attr('type')=='submit') || (target = $(this).attr('href')) || (target = $(this).attr('url')) ){
        form = $('.'+target_form);

        if ($(this).attr('hide-data') === 'true'){//鏃犳暟鎹椂涔熷彲浠ヤ娇鐢ㄧ殑鍔熻兘
            form = $('.hide-data');
            query = form.serialize();
        }else if (form.get(0)==undefined){
            return false;
        }else if ( form.get(0).nodeName=='FORM' ){
            if ( $(this).hasClass('confirm') ) {
                if(!confirm('纭瑕佹墽琛岃鎿嶄綔鍚�?')){
                    return false;
                }
            }
            if($(this).attr('url') !== undefined){
                target = $(this).attr('url');
            }else{
                target = form.get(0).action;
            }
            query = form.serialize();
        }else if( form.get(0).nodeName=='INPUT' || form.get(0).nodeName=='SELECT' || form.get(0).nodeName=='TEXTAREA') {
            form.each(function(k,v){
                if(v.type=='checkbox' && v.checked==true){
                    nead_confirm = true;
                }
            })
            if ( nead_confirm && $(this).hasClass('confirm') ) {
                if(!confirm('纭瑕佹墽琛岃鎿嶄綔鍚�?')){
                    return false;
                }
            }
            query = form.serialize();
        }else{
            if ( $(this).hasClass('confirm') ) {
                if(!confirm('纭瑕佹墽琛岃鎿嶄綔鍚�?')){
                    return false;
                }
            }
            query = form.find('input,select,textarea').serialize();
        }
        $(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
        $.post(target,query).success(function(data){
            if (data.status==1) {
                if (data.url) {
                    updateAlert(data.info + ' 椤甸潰鍗冲皢鑷姩璺宠浆~','alert-success');
                }else{
                    updateAlert(data.info ,'alert-success');
                }
                setTimeout(function(){
                    $(that).removeClass('disabled').prop('disabled',false);
                    if (data.url) {
                        location.href=data.url;
                    }else if( $(that).hasClass('no-refresh')){
                        $('#top-alert').find('button').click();
                    }else{
                        location.reload();
                    }
                },1500);
            }else{
                updateAlert(data.info);
                setTimeout(function(){
                    $(that).removeClass('disabled').prop('disabled',false);
                    if (data.url) {
                        location.href=data.url;
                    }else{
                        $('#top-alert').find('button').click();
                    }
                },1500);
            }
        });
    }
    return false;
});


/**椤堕儴璀﹀憡鏍�*/
var content = $('#main');
var top_alert = $('#top-alert');
top_alert.find('.close').on('click', function () {
    top_alert.removeClass('block').slideUp(200);
    // content.animate({paddingTop:'-=55'},200);
});

window.updateAlert = function (text,c) {
    text = text||'default';
    c = c||false;
    if ( text!='default' ) {
        top_alert.find('.alert-content').text(text);
        if (top_alert.hasClass('block')) {
        } else {
            top_alert.addClass('block').slideDown(200);
            // content.animate({paddingTop:'+=55'},200);
        }
    } else {
        if (top_alert.hasClass('block')) {
            top_alert.removeClass('block').slideUp(200);
            // content.animate({paddingTop:'-=55'},200);
        }
    }
    if ( c!=false ) {
        top_alert.removeClass('alert-error alert-warn alert-info alert-success').addClass(c);
    }
};


