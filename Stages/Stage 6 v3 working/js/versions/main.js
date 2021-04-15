
(function ($) {

    "use strict";

    var JSONArr;


     $.getJSON("galleryinfo.json", function(data) {
              JSONArr = data;
        });
     console.log(JSONArr);

    /*==================================================================
    [ Focus Contact2 ]*/
    $('.input2').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }else {
                $(this).removeClass('has-val');
            }
        })    
    });

    $('.input2').each(function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }else {
                $(this).removeClass('has-val');
            }
    });

        $('.lightbox').each(function(index, element){
        $.getJSON("galleryinfo.json", function(data) {
              JSONArr = data;
        });
        console.log(element);
        console.log(JSONArr);
        $.each(JSONArr, function(index,value){

            console.log("json");
             var href = $(element).attr('href');

             if (href === v.imagefile){
                $(element).attr('data-caption', "image");
                }

            });
        
    });


    $('#searchbar').submit(function(e){
        e.preventDefault();
        var value = $('#search').val().trim();
        $.getJSON("galleryinfo.json", function(data) {
              JSONArr = data;
        });

        console.log(JSONArr);

        if (value){
                $.each(JSONArr, function(i,v){
                    var tags = v.tag.split(',');
                        /*

                        console.log(value);
                        console.log(tags);
                        console.log(!tags.includes(value));
                        */
                        $.each(tags, function(index, string){

                            tags[index] = string.trim();
                        });

                        /*
                        
                        console.log("");
                        console.log(value);
                        console.log(tags);
                        console.log(!tags.includes(value));
                        */

                        if (!tags.includes(value)){
                             $('.lightbox').each(function(){
                                        var href = $(this).attr('href');

                                        if (href === v.imagefile){
                                            $(this).hide();
                                            $(this).attr("searched",false);
                                        }
                             });
                        } else {
                            $('.lightbox').each(function(){
                                        var href = $(this).attr('href');

                                        if (href === v.imagefile){
                                            $(this).show();
                                            $(this).attr("searched",true);
                                        }
                                    });
                        }

                            });
                            
        } else {
            $.each(JSONArr, function(i,v){


                                $('.lightbox').each(function(){
                                        var href = $(this).attr('href');

                                        if (href === v.imagefile){
                                            $(this).show();
                                            $(this).attr("searched",true);
                                        }
                                }); 

            });
        }

    });

	$('#privateCheck').on('change', function() {

        $.getJSON("galleryinfo.json", function(data) {
              JSONArr = data;
        });

           if ($('#check').prop('checked') == true){
                $.each(JSONArr, function(i,v){

                        if (v.access == "public"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');

                                if (href === v.imagefile){
                                    $(this).hide();
                                }
                            });
                        } 


                    });
            } else {
                    $.each(JSONArr, function(i,v){
                        
                        if (v.access == "public"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
                                var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).show();
                                }
                            });
                        } 
                    });
            }
       
    });

	$('.button').each(function(){
		$(this).on('change', function() {
			if ($(this).prop('checked') == true) {
				$(this).addClass('has-val');
			} else {
				$(this).removeClass('has-val');
			}
		});
	});
	
	$('.radio').on('change', function() {
		if ($('#public').prop('checked') == true || $('#private').prop('checked') == true) {
			$(this).addClass('has-val');
		} else {
			$(this).removeClass('has-val');
		}
	});
		
    $('#file-upload').on('change',function(){
        if ($('#file-upload').val().trim() != ''){
            $('#file-upload').addClass('has-val');
        } else {
            $('#file-upload').removeClass('has-val');
        }
    });

    $('#reset-button').on('click',function(){
        $('.input2').each(function(){
            $(this).removeClass('has-val');
			hideValidate(this);
        });
		$('#file-upload').each(function(){
            $(this).removeClass('has-val');
			hideValidate(this);
        });
		$('.button').each(function(){
            $(this).removeClass('has-val');
			hideValidate(this);
        });
		$('.radio').each(function(){
            $(this).removeClass('has-val');
			hideValidate(this);
        });
    });

    /*==================================================================
    [ Validate ]*/
    var firstName = $('.validate-input input[name="first-name"]');
    var lastName = $('.validate-input input[name="last-name"]');
    var description = $('.validate-input textarea[name="description"]');
    var tag = $('.validate-input textarea[name="tag"]');
	var copyright = $('.validate-input input[name="copyright"]');
    var file = $('.validate-input input[name="file"]');
    var access = $('.validate-input input[name="access"]');
	
    $('.validate-form').on('submit',function(){
        var check = true;

        if($(firstName).val().trim() == ''){
            showValidate(firstName);
            check=false;
        }
		
		if($(lastName).val().trim() == ''){
            showValidate(lastName);
            check=false;
        }
		
        if ($(file).val().trim() == ''){
            showValidate(file);
            check = false;
        } 

        if($(description).val().trim() == ''){
            showValidate(description);
            check=false;
        }
        
        if($(tag).val().trim() == ''){
            showValidate(tag);
            check=false;
        }
		
		if ($(copyright).prop('checked') == false){
			showValidate(copyright);
			check = false;
		}

		if ($('#public').prop('checked') == false && $('#private').prop('checked') == false) {
			showValidate(access);
			check = false;
		} 


		return check;
    });


    $('.validate-form .input2').each(function(){
        $(this).focus(function(){
		   hideValidate(this);
       });
    });
	
	$('#file-upload').on('change',function(){
        if ($('#file-upload').val().trim() != ''){
            $('#file-upload').addClass('has-val');
        } else {
            $('#file-upload').removeClass('has-val');
        }
    });
	
	$('.validate-form #file-upload').each(function(){
		$(this).on('change',function(){
        if ($(this).val().trim() != ''){
            hideValidate(this);
			} 
		});
    });
	
	$('.validate-form .button').each(function(){
		$(this).on('change', function() {
			if ($(this).prop('checked') == true) {
            hideValidate(this);
			} 
		});
		
    });
	
	$('.validate-form .radio').each(function(){
		$(this).on('change', function() {
			if ($('#public').prop('checked') == true || $('#private').prop('checked') == true) {
				hideValidate(this);
			} 
		});
		
    });
	
    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    

})(jQuery);