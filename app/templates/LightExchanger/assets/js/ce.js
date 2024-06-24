$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();

    $('#datepicker').datepicker({
        format: "dd-mm-yyyy",
        orientation: "bottom auto"
    });
    $('#datepicker2').datepicker({
        format: "dd-mm-yyyy",
        orientation: "bottom auto"
    });

    // Feedback Carousel
    var $imagesSlider = $(".feedback-slides .client-feedback>div"),
        $thumbnailsSlider = $(".client-thumbnails>div");
    // images options
    $imagesSlider.slick({
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        cssEase: 'linear',
        fade: true,
        autoplay: true,
        draggable: true,
        asNavFor: ".client-thumbnails>div",
        prevArrow: '.client-feedback .prev-arrow',
        nextArrow: '.client-feedback .next-arrow'
    });
    // Thumbnails options
    $thumbnailsSlider.slick({
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 1,
        cssEase: 'linear',
        autoplay: true,
        centerMode: true,
        draggable: false,
        focusOnSelect: true,
        asNavFor: ".feedback-slides .client-feedback>div",
        prevArrow: '.client-thumbnails .prev-arrow',
        nextArrow: '.client-thumbnails .next-arrow',
    });
    var $caption = $('.feedback-slides .caption');
    var captionText = $('.client-feedback .slick-current img').attr('alt');
    updateCaption(captionText);
    $imagesSlider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        $caption.addClass('hide');
    });
    $imagesSlider.on('afterChange', function(event, slick, currentSlide, nextSlide) {
        captionText = $('.client-feedback .slick-current img').attr('alt');
        updateCaption(captionText);
    });


    function updateCaption(text) {
        // if empty, add a no breaking space
        if (text === '') {
            text = '&nbsp;';
        }
        $caption.html(text);
        $caption.removeClass('hide');
    }
    $("#showhide_reserve").on("click", function() {
        const div = document.querySelector('.reserve-hidden');
        if (div.classList.contains('reserve-show')) {
            $(".reserve-hidden ").removeClass("reserve-show");
            $(this).html($(this).data("textshow"));
        } else {
            $(".reserve-hidden ").addClass("reserve-show");
            $(this).html($(this).data("texthide"));
        }
    });
});


function ce_refresh(tt, value) {
    $("#ce_status_loading").show();
    $("#ce_gateway_send,#ce_gateway_receive,#ce_amount_send,#ce_amount_receive,#ce_exbtn").prop("disabled", true);
    $("#ce_exchange_rate,#ce_reserve_text").html("<i class='fa fa-spin fa-spinner'></i>");
    if (tt == "1") {
        ce_load_receive_list(value);
        ce_load_img(1);
        ce_load_rate();
    } else if (tt == "2") {
        ce_load_rate();
        ce_load_img(2);
    } else {
        return true;
    }

}

function ce_load_rate() {
    var from = $("#ce_gateway_send").val();
    var to = $("#ce_gateway_receive").val();
    var url = $("#wurl").val();
    var data_url = url + "app/requests/load.php?a=rate&from=" + from + "&to=" + to;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "json",
        success: function(data) {
            if (data.status == "success") {
                var exchange_rate = data.rate_from + ' ' + data.currency_from + ' = ' + data.rate_to + ' ' + data.currency_to;
                var reserve = data.reserve + ' ' + data.currency_to;
                $("#ce_exchange_rate").html(exchange_rate);
                $("#ce_reserve_text").html(reserve);
                $("#ce_amount_send").val(data.rate_from);
                $("#ce_amount_receive").val(data.rate_to);
                $("#ce_amount_receive2").val(data.rate_to);
                $("#ce_rate_from").val(data.rate_from);
                $("#ce_rate_to").val(data.rate_to);
                $("#ce_currency_from").val(data.currency_from);
                $("#ce_currency_to").val(data.currency_to);
                $("#ce_reserve").val(data.reserve);
                $("#ce_sic1").val(data.sic1);
                $("#ce_sic2").val(data.sic2);
                $("#ce_gateway_send,#ce_gateway_receive,#ce_amount_send,#ce_amount_receive,#ce_exbtn").prop("disabled", false);
                $("#ce_status_loading").hide();
            }
        }
    });
}

function ce_load_rate2() {
    var from = $("#ce_gateway_send").val();
    var to = $("#ce_gateway_receive").val();
    var url = $("#wurl").val();
    var data_url = url + "app/requests/load.php?a=rate&from=" + from + "&to=" + to;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "json",
        success: function(data) {
            if (data.status == "success") {
                var exchange_rate = data.rate_from + ' ' + data.currency_from + ' = ' + data.rate_to + ' ' + data.currency_to;
                var reserve = data.reserve + ' ' + data.currency_to;
                $("#ce_exchange_rate").html(exchange_rate);
                $("#ce_reserve_text").html(reserve);
                $("#ce_rate_from").val(data.rate_from);
                $("#ce_rate_to").val(data.rate_to);
                $("#ce_currency_from").val(data.currency_from);
                $("#ce_currency_to").val(data.currency_to);
                $("#ce_reserve").val(data.reserve);
                $("#ce_sic1").val(data.sic1);
                $("#ce_sic2").val(data.sic2);
                ce_calculator(1);
                $("#exrateupdate").hide();
            } else {
                alert(data.msg);
            }
        }
    });
}

function ce_load_receive_list(value) {
    var url = $("#wurl").val();
    var data_url = url + "app/requests/load.php?a=receive_list&id=" + value;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "json",
        success: function(data) {
            if (data.status == "success") {
                $("#ce_gateway_receive").html(data.content);
                ce_load_img(2);
                ce_load_rate();
            } else {
                alert(data.msg);
            }
        }
    });
}

function ce_load_img(tt) {
    if (tt == "1") {
        var url = $("#wurl").val();
        var gtid = $("#ce_gateway_send").val();
        var data_url = url + "app/requests/load.php?a=img&id=" + gtid;
        $.ajax({
            type: "GET",
            url: data_url,
            dataType: "json",
            success: function(data) {
                if (data.status == "success") {
                    $("#ce_send_img").attr("src", data.content);;
                } else {
                    alert(data.msg);
                }
            }
        });
    } else if (tt == "2") {
        var url = $("#wurl").val();
        var gtid = $("#ce_gateway_receive").val();
        var data_url = url + "app/requests/load.php?a=img&id=" + gtid;
        $.ajax({
            type: "GET",
            url: data_url,
            dataType: "json",
            success: function(data) {
                if (data.status == "success") {
                    $("#ce_receive_img").attr("src", data.content);;
                } else {
                    alert(data.msg);
                }
            }
        });
    } else {
        return true;
    }
}

function ce_calculator(type) {
    if (type == "1") {
        var currency_from = $("#ce_currency_from").val();
        var currency_to = $("#ce_currency_to").val();
        var rate_from = $("#ce_rate_from").val();
        var rate_to = $("#ce_rate_to").val();
        var sic1 = $("#ce_sic1").val();
        var sic2 = $("#ce_sic2").val();
        var amount_send = $("#ce_amount_send").val();
        if (isNaN(amount_send)) {
            var data = '0';
        } else {
            if (sic1 == "1" && sic2 == "1") {
                if (rate_from < 1) {
                    var sum = amount_send / rate_from;
                    var data = sum.toFixed(8);
                } else {
                    var sum = amount_send * rate_to;
                    var data = sum.toFixed(8);
                }
            } else if (sic2 == "1") {
                var sum = amount_send / rate_from;
                var data = sum.toFixed(8);
            } else if (rate_from > 1) {
                var sum = amount_send / rate_from;
                var data = sum.toFixed(2);
            } else {
                var sum = amount_send * rate_to;
                var data = sum.toFixed(2);
            }
            //var sum = amount_send / rate_from;
            //var data = sum.toFixed(8);
            //var sum = amount_send * rate_to;
            //var data = sum.toFixed(2);
        }
        $("#ce_amount_receive").val(data);
        $("#ce_amount_receive2").val(data);
    } else if (type == "2") {
        var currency_from = $("#ce_currency_from").val();
        var currency_to = $("#ce_currency_to").val();
        var rate_from = $("#ce_rate_to").val();
        var rate_to = $("#ce_rate_from").val();
        var sic1 = $("#ce_sic2").val();
        var sic2 = $("#ce_sic1").val();
        var amount_send = $("#ce_amount_receive").val();
        $("#ce_amount_receive2").val(amount_send);
        if (isNaN(amount_send)) {
            var data = '0';
        } else {
            if (sic1 == "1" && sic2 == "1") {
                if (rate_from < 1) {
                    var sum = amount_send / rate_from;
                    var data = sum.toFixed(8);
                } else {
                    var sum = amount_send * rate_to;
                    var data = sum.toFixed(8);
                }
            } else if (sic2 == "1") {
                var sum = amount_send / rate_from;
                var data = sum.toFixed(8);
            } else if (rate_from > 1) {
                var sum = amount_send / rate_from;
                var data = sum.toFixed(2);
            } else {
                var sum = amount_send * rate_to;
                var data = sum.toFixed(2);
            }
            //var sum = amount_send / rate_from;
            //var data = sum.toFixed(8);
            //var sum = amount_send * rate_to;
            //var data = sum.toFixed(2);
        }
        $("#ce_amount_send").val(data);
        $("#ce_amount_send2").val(data);
    } else {
        return false;
    }
}

function ce_exchange(formID) {
    $("#ce_status").html("");
    $("#ce_status_loading").show();
    var url = $("#wurl").val();
    var data_url = url + "app/requests/exchange.php?a=prepare";
    $.ajax({
        type: "POST",
        url: data_url,
        data: $(formID).serialize(),
        dataType: "json",
        success: function(data) {
            $("#ce_status_loading").hide();
            if (data.status == "success") {
                window.location.href = data.redirect;
            } else {
                var alertmsg = '<br><br><span class="badge badge-danger cryptoexchanger-badge-text"><i class="fa fa-times"></i> ' + data.msg + '</span>';
                $("#ce_status").html(alertmsg);
            }
        }
    });
}

function ce_invest_change_plan(id) {
    var url = $("#wurl").val();
    var c_redirect = url + "account/invest/" + id;
    window.location.href = c_redirect;
}

function ce_invest(package_id) {
    var url = $("#wurl").val();
    var data_url = url + "app/requests/invest.php?a=invest&package_id=" + package_id;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "json",
        success: function(data) {
            if (data.status == "success") {
                $("#invest_content").html(data.content);
                $("#inv_invest").modal("show");
            }
        }
    });
}

function ce_invest_deposit(package_id) {
    var url = $("#wurl").val();
    var data_url = url + "app/requests/invest.php?a=deposit&package_id=" + package_id;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "json",
        success: function(data) {
            if (data.status == "success") {
                $("#invest_content").html(data.content);
                $("#inv_deposit").modal("show");
            }
        }
    });
}

function ce_invest_withdrawal(package_id) {
    var url = $("#wurl").val();
    var data_url = url + "app/requests/invest.php?a=withdrawal&package_id=" + package_id;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "json",
        success: function(data) {
            if (data.status == "success") {
                $("#invest_content").html(data.content);
                $("#inv_withdrawal").modal("show");
            }
        }
    });
}

function ce_invest_withdrawal_process(package_id) {
    var url = $("#wurl").val();
    var data_url = url + "app/requests/invest.php?a=withdrawal_process&package_id=" + package_id;
    $.ajax({
        type: "POST",
        url: data_url,
        data: $("#form_inv_withdrawal").serialize(),
        dataType: "json",
        success: function(data) {
            $("#ce_status_loading").hide();
            if (data.status == "success") {
                $("#inv_withdrawal_content").html(data.content);
            } else {
                $("#inv_withdrawal_status").html(data.msg);
            }
        }
    });
}

function ce_invest_process(package_id) {
    var url = $("#wurl").val();
    var data_url = url + "app/requests/invest.php?a=invest_process&package_id=" + package_id;
    $.ajax({
        type: "POST",
        url: data_url,
        data: $("#form_inv_invest").serialize(),
        dataType: "json",
        success: function(data) {
            $("#ce_status_loading").hide();
            if (data.status == "success") {
                $("#inv_invest_content").html(data.content);
            } else {
                $("#inv_invest_status").html(data.msg);
            }
        }
    });
}

function ce_buy_insurance(id) {
    var url = $("#wurl").val();
    var data_url = url + "app/requests/invest.php?a=insurance&invest_id=" + id;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "json",
        success: function(data) {
            if (data.status == "success") {
                $("#invest_content").html(data.content);
                $("#inv_buy_insurance").modal("show");
            }
        }
    });
}

function ce_invest_insurance_process(id) {
    var url = $("#wurl").val();
    var data_url = url + "app/requests/invest.php?a=insurance_process&invest_id=" + id;
    $.ajax({
        type: "POST",
        url: data_url,
        data: $("#form_inv_insurance").serialize(),
        dataType: "json",
        success: function(data) {
            $("#ce_status_loading").hide();
            if (data.status == "success") {
                $("#inv_insurance_content").html(data.content);
            } else {
                $("#inv_insurance_status").html(data.msg);
            }
        }
    });
}

function CE_InvestCalculator(amount) {
    var i_modal = "#inv_invest";
    var i_days = $(i_modal + " #mi_days").html();
    var i_dprofit = $(i_modal + " #mi_dprofit").html();
    var i_tprofit = $(i_modal + " #mi_tprofit");
    var i_treturn = $(i_modal + " #mi_treturn");
    var calculate_1 = amount * i_days;
    calculate_1 = calculate_1 * i_dprofit;
    var calculate_2 = calculate_1 / 100;
    calculate_2 = (parseFloat(calculate_2)).toFixed(6);
    var calculate_3 = (parseFloat(amount) + parseFloat(calculate_2)).toFixed(6);
    $(i_tprofit).html(calculate_2);
    $(i_treturn).html(calculate_3);
}

function toggleCurrency(tab,element)
{   
    $(".currency-loader").prop("hidden",false);
    var currency = tab;
    var url = $("#wurl").val();
    var wallets_data = $("#wallets_data").val();
    $(".currency-tab").removeClass("active");
    $(element).addClass("active");
    $.ajax({
        url:url + "app/requests/load.php?a=wallet_currency_convertor",
        method:"POST",
        data:{wallets_data:wallets_data, currency: currency},
        success:function(response)
        {
            for(var i = 0; i < response.length; i++)
            {
                $("#"+response[i].currency+"-label").html(response[i].amount);
            }
            $(".currency-loader").prop("hidden",true);
        }   
    });
}


function ce_change_withdraw_wallets(element)
{
    var wallet_id = $(element).val();
    var url = $("#wurl").val();
    $.ajax({
        url:url + "app/requests/load.php?a=wallet_balance",
        method:"POST",
        data:{wallet_id:wallet_id},
        success:function(response)
        {
            $("#current_balance").html(response.balance);  
        }   
    });
}

function ce_change_transfer_wallets(element)
{
    var wallet_id = $(element).val();
    var url = $("#wurl").val();
    $.ajax({
        url:url + "app/requests/load.php?a=wallet_balance",
        method:"POST",
        data:{wallet_id:wallet_id},
        success:function(response)
        {
            $("#current_balance").html(response.balance);  
        }   
    });
}

function search_user_by_wallet(element)
{
    var wallet_id = $(element).val();
    var url = $("#wurl").val();
    if(wallet_id == null || wallet_id == "")
    {
        $("#useremail").css("color","#1F2641");
        $("#useremail").html("N/A");
    }
    else
    {
        $("#useremail").html(wallet_id);
        $.ajax({
            url:url+"app/requests/load.php?a=search_user_by_wallet",
            method:"POST",
            data:{wallet_id:wallet_id},
            success:function(response) 
            {
                $("#useremail").html(response.message);        
                if(response.code == 1)
                {
                    $("#useremail").css("color","green");
                }
                else if(response.code == 0)
                {
                    $("#useremail").css("color","red");
                }
            }
        });
    }
}