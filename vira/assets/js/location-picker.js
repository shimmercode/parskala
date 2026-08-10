///city location js
jQuery(document).on('click', '#tekecablSearchcityModal .citieslists .city', function(e){
    var id=jQuery(this).attr('id');
    var txt=jQuery(this).find('span').html();

    var form_data = new FormData();
    form_data.append('action', 'prskala_search_getCityChildern');
    form_data.append('cityid', id);
    //form_data.append('nonce', my_ajax_object.nonce);

   // var sc=[];
    var c=0;
    var j;
    // jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities .selectedcty').each(function() {
    //    j=jQuery(this).attr('id') ;
    //    j=j.replace("selectedcty", "");
    //    sc[c]=j;
    //    ++c;
    // });
var ssss=getCookie('prskalaSearchCity');
	if(ssss!=null)
        var sc=ssss.split(',');

    else
	   var sc=[];
    jQuery.ajax({
        url: vira_values.ajax_url,
        type: 'POST',
        contentType: false,
        processData: false,
        dataType : 'json',
        data: form_data,
        success: function (res) {
            jQuery('#tekecablSearchcityModal .citieslists').empty();
            var i;
            var html="<div class='location-item'><div class=\"allcity\" id=\"-1\"><i class=\"ri-arrow-right-line\"></i>"+location_allcity_text+"</div></div>";
            html+="<div class='location-item'><div class=\"subcity allthiscity\" id=\""+id+"\"><span> "+location_sallcity_text+" "+txt+"</span><label class=\"containercheckbox\">";
            if(jQuery.inArray( id.toString(), sc )!=-1)
                html+="<input type=\"checkbox\" checked>" ;
            else
                html+="<input type=\"checkbox\" >" ;

            html+= "<span class=\"checkmark\"></span>" +
                "</label></div></div>";

            for (i = 0; i < res.length; ++i) {

                html+="<div class='location-item'><div class=\"subcity\" id=\""+res[i]['term_id']+"\"><span>"+res[i]['name']+"</span><label class=\"containercheckbox\">" ;
                if(jQuery.inArray( id.toString(), sc )>-1 || jQuery.inArray( res[i]['term_id'].toString(), sc )>-1)
                    html+= "<input type=\"checkbox\" checked>" ;
                else
                    html+="<input type=\"checkbox\" >" ;

                html+="<span class=\"checkmark\"></span>" +
                    "</label></div></div>";
            }
            jQuery('#tekecablSearchcityModal .citieslists').append(html);
        }

    });
    e.stopPropagation();
    e.stopImmediatePropagation();
});
jQuery(document).on('click', '#tekecablSearchcityModal .citieslists .allcity', function(e){
    var form_data = new FormData();
    form_data.append('action', 'prskala_search_getCities');
   // form_data.append('nonce', my_ajax_object.nonce);
    jQuery.ajax({
         url: vira_values.ajax_url,
        type: 'POST',
        contentType: false,
        processData: false,
        dataType : 'json',
        data: form_data,
        success: function (res) {
            jQuery('#tekecablSearchcityModal .citieslists').empty();
            var i;
            var html="";

            for (i = 0; i < res.length; ++i) {
                html+="<div class='location-item'><div class=\"city\" id=\""+res[i]['term_id']+"\"><span>"+res[i]['name']+"</span><i class=\"ri-arrow-left-s-line\"></i></div></div>";
            }
            jQuery('#tekecablSearchcityModal .citieslists').append(html);
        }

    });
    e.stopPropagation();
    e.stopImmediatePropagation();
});
jQuery(document).on('click', '#tekecablSearchcityModal .citieslists .subcity input[type=checkbox]', function(){

    var lbl=jQuery(this).parents('.subcity').find('span').text();
    var id=jQuery(this).parents('.subcity').attr('id');
    var parentid=jQuery('#tekecablSearchcityModal .allthiscity').attr('id');
    var checked=jQuery(this).is(':checked');
	//alert(checked);
    if(jQuery(this).parents('.subcity').hasClass('allthiscity')) {
        if(checked) {
            jQuery("#tekecablSearchcityModal .citieslists .subcity input[type=checkbox]").prop('checked', true);
            //jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').empty();
            jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities div[data-id='+parentid+']').remove();
        }
        else{
            jQuery("#tekecablSearchcityModal .citieslists .subcity input[type=checkbox]").prop('checked', false);
        }
    }
    if(checked){
       // jQuery('#tekecablSearchcityModal .modal-footer .taeed').removeAttr('disabled');
        var html=jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').html();
        if(html==location_selectcity_text){
            jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').empty();
        }

        if(!jQuery(this).parents('.subcity').hasClass('allthiscity')) {
            var d, is;
            is = false;
			//alert(is);
            jQuery("#tekecablSearchcityModal .citieslists .subcity").each(function () {
                d = jQuery(this).attr('id');
				// alert(!is);
				// alert(d);
				// alert(id);
				// alert(parentid);
                if (!is && /* d != id &&*/ d != parentid && !jQuery(this).find('input').is(':checked')) {

                    var span = '<div data-id="' + parentid + '" class="selectedcty" id="selectedcty' + id + '">' + lbl + '<i class="ri-close-line"></i></div>';
                    jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').append(span);
                    is = true;
                }

            });
            if (!is) {
                jQuery('#tekecablSearchcityModal .citieslists .allthiscity input[type=checkbox]').click();
            }
        }
        else{
            var span = '<div data-id="' + parentid + '" class="selectedcty" id="selectedcty' + id + '">' + lbl + '<i class="ri-close-line"></i></div>';

            jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').append(span);
        }


    }
    else{
        //alert('#tekecablSearchcityModal .topp-part-modal-body .selected-cities #selectedcty'+id);
        jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities #selectedcty'+id).remove();
        var s= jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').html();
        if(s==''){
            var $span=location_selectcity_text;
            jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').append($span);
           // jQuery('#tekecablSearchcityModal .modal-footer .taeed').attr('disabled','disabled');
        }
        if(!jQuery(this).parents('.subcity').hasClass('allthiscity')){
            if(jQuery("#tekecablSearchcityModal .citieslists .allthiscity input[type=checkbox]").is(':checked')){
                jQuery("#tekecablSearchcityModal .citieslists .allthiscity input[type=checkbox]").prop('checked', false);
                jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities div[id=selectedcty'+parentid+']').remove();
                var d,span1,lbl1;
                jQuery("#tekecablSearchcityModal .citieslists .subcity").each(function(){
                    d=jQuery(this).attr('id');
                    if(d!=id && d!=parentid){
                         lbl1=jQuery(this).find('span').text();
                        // alert(lbl1);
                        span1='<div data-id="'+parentid+'" class="selectedcty" id="selectedcty'+d+'">'+lbl1+'<i class="ri-close-line"></i></div>';
                        jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').append(span1);
                    }
                });
            }
        }
    }
})

jQuery(document).on('click', '#tekecablSearchcityModal .topp-part-modal-body .selected-cities .selectedcty i', function() {
    var id=jQuery(this).parents('.selectedcty').attr('id');
	//alert(id);
    id=id.replace("selectedcty", "");
	// var ssss=getCookie('prskalaSearchCity');
	// var newarr=[];
    //     var sc=ssss.split(',');
	// 	for(var i=0;i<sc.length;++i ){
	// 		//alert(sc[i]);
	// 		//alert(id);
	// 		if(sc[i]!=id){
	// 			newarr.push(sc[i]);
	// 		}
	// 	}
	// 	setCookie('prskalaSearchCity',newarr,30);
    jQuery('#tekecablSearchcityModal .citieslists #'+id).find('input').click();
    jQuery(this).parents('.selectedcty').remove();
    var s= jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').html();
    if(s==''){
        var $span=location_selectcity_text;
        jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').append($span);
       // jQuery('#tekecablSearchcityModal .modal-footer .taeed').attr('disabled','disabled');
    }
})
    function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}
jQuery(document).on('keyup', '#tekecablSearchcityModal .searchpartdiv .searchcity-input', function() {
    var val=jQuery(this).val();
    if(val.length>1){
        var form_data = new FormData();
        form_data.append('action', 'prskala_search_searchCityByName');
        form_data.append('txt', val);
        //form_data.append('nonce', my_ajax_object.nonce);
		var ssss=getCookie('prskalaSearchCity');
		var sc=[];
        if(ssss!=null)
        	var sc=ssss.split(',');
        var c=0;
        var j,i,id;
        var html='';
        // jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities .selectedcty').each(function() {
        //     j=jQuery(this).attr('id') ;
        //     j=j.replace("selectedcty", "");
        //     sc[c]=j;
        //     ++c;
        // });
        jQuery.ajax({
            url: vira_values.ajax_url,
            type: 'POST',
            contentType: false,
            processData: false,
            dataType : 'json',
            data: form_data,
            success: function (res) {
                jQuery('#tekecablSearchcityModal .citieslists').empty();
                for (i = 0; i < res.length; ++i) {
                    id=res[i]['parent'];
                    html+="<div class='location-item'><div class=\"subcity\" id=\""+res[i]['term_id']+"\"><span>"+res[i]['name']+"</span><label class=\"containercheckbox\">" ;
                    if(jQuery.inArray( id.toString(), sc )>-1 || jQuery.inArray( res[i]['term_id'].toString(), sc )>-1)
                        html+= "<input type=\"checkbox\" checked>" ;
                    else
                        html+="<input type=\"checkbox\" >" ;

                    html+="<span class=\"checkmark\"></span>" +
                        "</label></div></div>";
                }
                jQuery('#tekecablSearchcityModal .citieslists').append(html);
            }
        });
    }
    else {
        var form_data = new FormData();
        form_data.append('action', 'prskala_search_getCities');
        //form_data.append('nonce', my_ajax_object.nonce);
        html='';
        jQuery.ajax({
            url: vira_values.ajax_url,
            type: 'POST',
            contentType: false,
            processData: false,
            dataType : 'json',
            data: form_data,
            success: function (res) {
                jQuery('#tekecablSearchcityModal .citieslists').empty();
                var i;
                var html="";

                for (i = 0; i < res.length; ++i) {
                    html+="<div class='location-item'><div class=\"city\" id=\""+res[i]['term_id']+"\"><span>"+res[i]['name']+"</span><i class=\"ri-arrow-left-s-line\" aria-hidden=\"true\"></i></div></div>";
                }

                jQuery('#tekecablSearchcityModal .citieslists').append(html);
            }

        });
    }
})
function setCookie(key, value, expiry) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';path=/' + ';expires=' + expires.toUTCString();
}
jQuery(document).on('click', '#tekecablSearchcityModal .taeedcityloactionmodalsetcookie', function(e) {
    var id;
    var arr=[];
    //var cityname=null;
    jQuery( "#tekecablSearchcityModal:first").find(".topp-part-modal-body .selected-cities .selectedcty" ).each(function( index ) {
        // if(index==0){
        //     cityname=jQuery(this).text();
        // }
        id=jQuery(this).attr('id');
        id = id.replace("selectedcty", "");
		//alert(id+"  "+index);
		//alert(jQuery.inArray( id, arr ));
		if(jQuery.inArray( id, arr )<0)
        		arr.push(id);
    });
	if(arr.length==0)
	    setCookie('prskalaSearchCity','',-1);
	else
    	setCookie('prskalaSearchCity',arr,30);
    //jQuery('#tekecablSearchcityModal #tekecablsearchcityinput').val(arr);

jQuery('#tekecablSearchcityModal .modal-footer .enseraf').click();
    location.reload();

	e.stopImmediatePropagation();
	e.stopPropagation();

})



jQuery(document).on('click', '#tekecablSearchcityModal  .delallcities', function() {
    jQuery("#tekecablSearchcityModal .citieslists .subcity input[type=checkbox]").prop('checked', false);
    jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').empty();
    //jQuery('#tekecablSearchcityModal .modal-footer .taeed').attr('disabled','disabled');
    var $span=location_selectcity_text;
	 setCookie('prskalaSearchCity','',-1);
    jQuery('#tekecablSearchcityModal .topp-part-modal-body .selected-cities').append($span);

})
