$$("input[type=radio]").each(function(el){
    if (el.up("label")) {
        el.up("label").addClassName("custom-radio-label").down("input[type=radio]").insert({
            after: "<span class='custom-tick'></span>"
        });
    }
});

$$("input[type=checkbox]").each(function(el){
    if (el.up("label")) {
        el.up("label").addClassName("custom-checkbox-label").down("input[type=checkbox]").insert({
            after: "<span class='custom-tick'></span>"
        });
    }
});

document.observe("dom:loaded", function() {
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        var switchery = new Switchery(html);
    });
    
  
     
    jQuery('#front_image_upload').change(function() {
        jQuery('#vss_upload_image_section .kb_error_message').remove();
        var imgPath = jQuery(this)[0].value;
        /*Knowband image validation start*/
        if(jQuery('#front_image_upload').val() != ''){
            var image_err = velovalidation.checkImage(jQuery('#front_image_upload'));
            if (image_err != true) {
                jQuery('#front_image_upload').after('<span class="kb_error_message">' + image_err + '</span>');
            } else {
                var image_holder = jQuery("#image_preview");
                image_holder.empty();
                var reader = new FileReader();
                reader.onload = function(e) {
                    image_holder.attr('src', e.target.result);
                }
                image_holder.show();
                reader.readAsDataURL(jQuery(this)[0].files[0]);
                jQuery('#front_image_upload_hidden').val(1);
            }
        }
        /*Knowband image validation end*/
    });
   
    /* End - Code for Charts */
    var previousPoint = null, previousLabel = null;
    jQuery.fn.CreateVerticalGraphToolTip = function () {
        jQuery(this).bind("plothover", function (event, pos, item) {
            if (item) {
                if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                    previousPoint = item.dataIndex;
                    previousLabel = item.series.label;
                    jQuery("#tooltip").remove();

                    var x = item.datapoint[0];
                    var y = item.datapoint[1];

                    var color = item.series.color;
                    OlGraph_showTooltip(item.pageX, item.pageY, color,
                                "<strong>" + item.series.xaxis.ticks[x].label + "</strong><br><strong>" + item.series.label + "</strong>"  +
                                " : <strong>" + y + "</strong> ");
                }
            } else {
                jQuery("#tooltip").remove();
                previousPoint = null;
            }
        });
    };
});

/*
 * Function for change color of wheel
 * @returns {undefined}
 */
function changeColor(wheel_color)
{
    try{
        if(wheel_color == ""){
            document.getElementById("wheel_preview").style.filter = "";
        }else{
            velsofWheelHexCode = wheel_color;
            var colorRGB = hexToRgb(velsofWheelHexCode);
            var hslColorCode = rgb2hsb(colorRGB.r, colorRGB.g, colorRGB.b);
            document.getElementById("wheel_preview").style.filter = 'hue-rotate(' + hslColorCode.hue + 'deg) saturate(' + hslColorCode.sat + '%) contrast(1.1)';
        }
    }catch(e){
    }
}




//use &&
if ( (typeof jQuery === 'undefined') && !window.jQuery ) {
    //document.write(unescape("%3Cscript type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js'%3E%3C/script%3E"));
} else {
    if((typeof jQuery === 'undefined') && window.jQuery) {
        jQuery = window.jQuery;
    } else if((typeof jQuery !== 'undefined') && !window.jQuery) {
        window.jQuery = jQuery;
    }
}

/*
 * Function for handling tooltip for the module's line chart
 * @param {type} x
 * @param {type} y
 * @param {type} color
 * @param {type} contents
 * @returns {undefined}
 */
function OlGraph_showTooltip(x, y, color, contents) {
    jQuery('<div id="tooltip">' + contents + '</div>').css({
        position: 'absolute',
        display: 'none',
        top: y - 40,
        left: x - 20,
        border: '1px solid ' + color,
        padding: '3px',
        'font-size': '11px',
        'border-radius': '5px',
        'background-color': '#fff',
        'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
        opacity: 0.9
    }).appendTo("body").fadeIn(200);
}

/*
 * Function to validate (velovalidation) the admin config form and submit the same
 */
function submitSpinandWinForm() {
    var is_error = false;
    var general_setting_error = false;
    var display_setting_error = false;
    var lookandfeel_error = false;
    var slice_setting_error = false;
    var email_marketing_error = false;
    var email_setting_error = false;
    
    jQuery('.kb_error_message').remove();
    jQuery('#tab_general_settings_contents input').parent().removeClass('kb_error_field');
    jQuery('#tab_general_settings_contents input').removeClass('kb_error_field');
    jQuery('#tab_general_settings_contents textarea').removeClass('kb_error_field');
                
    jQuery('#tab_display_settings_contents input').removeClass('kb_error_field');
    jQuery('#tab_display_settings_contents input').parent().removeClass('kb_error_field');
    jQuery('#tab_display_settings_contents .chosen-container').removeClass('kb_error_field');

    jQuery('#tab_look_and_feel_settings_contents input').removeClass('kb_error_field');

    jQuery('#tab_slice_settings_contents input').removeClass('kb_error_field');
    jQuery('.vss_slice_gravity_td').removeClass('kb_error_field');

    /*Knowband validation start*/
    if(jQuery('#front_image_upload').val() != ''){
        var p_image_err = velovalidation.checkImage(jQuery('#front_image_upload'));
        if (p_image_err != true) {
            is_error = true;
            lookandfeel_error = true;
            jQuery('#front_image_upload').after('<span class="kb_error_message">' + p_image_err + '</span>');
        }
    }

    jQuery('input[id^="colorpicker"]').each(function(i, obj) {
        var color_mandatory_err = velovalidation.checkMandatory(jQuery(this));
        if (color_mandatory_err != true)
        {
            is_error = true;
            lookandfeel_error = true;
            jQuery(this).addClass('kb_error_field');
            jQuery(this).parent().after('<span class="kb_error_message">' + color_mandatory_err + '</span>');
            jQuery(this).parent().css('padding-left', '0px');
        }
        else
        {
            var color_valid_err = velovalidation.isColor(jQuery(this));
            if (color_valid_err != true)
            {
                is_error = true;
                lookandfeel_error = true;
                jQuery(this).addClass('kb_error_field');
                jQuery(this).parent().after('<span class="kb_error_message">' + color_valid_err + '</span>');
                jQuery(this).parent().css('padding-left', '0px');
            }
        }
    });
    /*Knowband validation end*/
    
    /*Knowband validation start*/
    jQuery('#tab_slice_settings_contents input').each(function(i, obj) {
        if (jQuery(this).hasClass('vss_slice_label')) {
            var slice_label_man_err = velovalidation.checkMandatory(jQuery(this));
            if (slice_label_man_err != true)
            {
                is_error = true;
                slice_setting_error = true;
                jQuery(this).addClass('kb_error_field');
                jQuery(this).after('<span class="kb_error_message">' + slice_label_man_err + '</span>');
            }
        } else if (jQuery(this).hasClass('vss_slice_value') || jQuery(this).hasClass('vss_slice_gravity')) {
            var slice_man_err = velovalidation.checkMandatory(jQuery(this));
            if (slice_man_err != true)
            {
                is_error = true;
                slice_setting_error = true;
                jQuery(this).addClass('kb_error_field');
                jQuery(this).after('<span class="kb_error_message">' + slice_man_err + '</span>');
            }
            else
            {
                var slice_positive_err = velovalidation.isNumeric(jQuery(this), true);
                if (slice_positive_err != true)
                {
                    is_error = true;
                    slice_setting_error = true;
                    jQuery(this).addClass('kb_error_field');
                    jQuery(this).after('<span class="kb_error_message">' + slice_positive_err + '</span>');
                }
                else
                {
                    if (jQuery(this).hasClass('vss_slice_value')) {
                        if (jQuery(this).parent().parent().find('select').val() == 'percent') {
                            var slice_bet_err = velovalidation.isBetween(jQuery(this), 0, 100);
                            if (slice_bet_err != true)
                            {
                                is_error = true;
                                slice_setting_error = true;
                                jQuery(this).addClass('kb_error_field');
                                jQuery(this).after('<span class="kb_error_message">' + slice_bet_err + '</span>');
                            }
                        }
                    } else {
                        var slice_bet_err = velovalidation.isBetween(jQuery(this), 0, 100);
                        if (slice_bet_err != true)
                        {
                            is_error = true;
                            slice_setting_error = true;
                            jQuery(this).addClass('kb_error_field');
                            jQuery(this).after('<span class="kb_error_message">' + slice_bet_err + '</span>');
                        }
                    }
                }
            }
        }
    });
    var gravity_total = 0;
    jQuery('#tab_slice_settings_contents input.vss_slice_gravity').each(function(i, obj) {
        gravity_total += parseInt(jQuery(this).val());
    });
    if (gravity_total < 1 || gravity_total > 100) {        
        is_error = true;
        slice_setting_error = true;
        jQuery('.vss_slice_gravity_td').addClass('kb_error_field');
        jQuery('#vss_slice_settings_table').after('<span class="kb_error_message">' + gravity_range_error + '</span>');
    }
    /*Knowband validation end*/
    
    /*Knowband validation start*/

    
    if (lookandfeel_error == true) {
        jQuery("#tab_look_and_feel_settings .error-icon").show();
    } else {
        jQuery("#tab_look_and_feel_settings .error-icon").hide();
    }
    if (slice_setting_error == true) {
        jQuery("#tab_slice_settings .error-icon").show();
    } else {
        jQuery("#tab_slice_settings .error-icon").hide();
    }
  
    if (is_error) {
        return false;
    }

    /*Knowband button validation start*/
    jQuery('#vss_save_spinwin_form_button').attr('onclick', 'javascript:void(0)');
    jQuery('#vss_save_spinwin_form_button').attr('disabled', 'disabled');    
    jQuery('#vss_save_spinwin_form_button').css('background-color', '#b9b9b9');    
    jQuery('#vss_save_spinwin_form_button').css('border-color', '#b9b9b9');
    /*Knowband button validation end*/

    jQuery('#spinandwin_form').submit();
}


/*
 * Function for replacing all occurences of a sub-string inside a string
 */
function str_replace_all(string, str_find, str_replace){
    try{
        return string.replace(new RegExp(str_find, "gi"), str_replace);
    } catch(ex){
        return string;
    }
}


/*
 * Function for getting a Random Color code
 */
function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

/*
 * Function for changing the time to desired format
 */
function changetime(time) {
    var r = time.split('/');
    var t = r[2].split(' ');
    return t[0] + "-" + r[0] + "-" + r[1] + " " + t[1];
}

/*
 * Function for disabling value field in case Free Shipping is selected.
 */
function changeCurrentValueState(ele) {
    var $sliceValueSelector = jQuery(ele).parent().parent().find('.vss_slice_value');
    if (jQuery(ele).val() == 'freeship') {
        $sliceValueSelector.val('0');
        $sliceValueSelector.prop('readonly', true);
    } else {
        $sliceValueSelector.prop('readonly', false);
    }
}

function hexToRgb(hex) {
    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function (m, r, g, b) {
        return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function rgb2hsb(r, g, b)
{
    r /= 255;
    g /= 255;
    b /= 255; // Scale to unity.   
    var minVal = Math.min(r, g, b),
            maxVal = Math.max(r, g, b),
            delta = maxVal - minVal,
            HSB = {hue: 0, sat: 0, bri: maxVal},
    del_R, del_G, del_B;

    if (delta !== 0)
    {
        HSB.sat = delta / maxVal;
        del_R = (((maxVal - r) / 6) + (delta / 2)) / delta;
        del_G = (((maxVal - g) / 6) + (delta / 2)) / delta;
        del_B = (((maxVal - b) / 6) + (delta / 2)) / delta;

        if (r === maxVal) {
            HSB.hue = del_B - del_G;
        } else if (g === maxVal) {
            HSB.hue = (1 / 3) + del_R - del_B;
        } else if (b === maxVal) {
            HSB.hue = (2 / 3) + del_G - del_R;
        }

        if (HSB.hue < 0) {
            HSB.hue += 1;
        }
        if (HSB.hue > 1) {
            HSB.hue -= 1;
        }
    }

    HSB.hue *= 360;
    HSB.sat *= 100;
    HSB.bri *= 100;
    return HSB;
};
