
(function ($) {

    "use strict";

    var JSONArr;
	var isPrivateChecked = false;
	var isPublicChecked = false;
	var isAllChecked = false;
	var access = "";
    var controlPressed = false;
    var hrefAttribute = [];
    var selectedHrefAttribute = [];
    var stringHrefAttribute = "";
	var isApprovePage = false;

	$(document).on('click', 'input[type="checkbox"]', function() {      
		$('input[type="checkbox"]').not(this).prop('checked', false);      
	});

  
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

        $.each(JSONArr, function(index,value){


             var href = $(element).attr('href');

             if (href === v.imagefile){
                $(element).attr('data-caption', "image");
                }

            });
        
    });
        console.log($("#selectAll").text().trim());

        $('#selectAll').click(function(){
            if ($("#selectAll").text().trim() == "Select All"){
                    $('.lightbox').each(function(index, element){
                   
                            $(element).addClass("selected");
                    
                    });

                    $("#selectAll").text("Deselect All");
                } else if ($("#selectAll").text().trim() == "Deselect All"){
                    $('.lightbox').each(function(index, element){
                   
                            $(element).removeClass("selected");
                    
                    });

                    $("#selectAll").text("Select All");
                }

         });



    $('#selectOpposite').click(function(){

        $('.lightbox').each(function(index, element){
       
                $(element).toggleClass("selected");
        
        });

    });
    

    $(document).keydown(function(event){
    	if(event.which=="17"){
			controlPressed = true;
			
			console.log(controlPressed);
			$('.lightbox').each(function(index, element){
				
				if (controlPressed === true){
					$(element).removeAttr('data-fancybox');
					hrefAttribute.push($(element).attr('href'));
					$(element).removeAttr('href');
				}
			});
		}
    });
	
	$(document).keyup(function(){
        controlPressed = false;
		if (controlPressed === false){
			$('.lightbox').each(function(index, element){

                $(element).attr('data-fancybox', "gallery");
                $(element).attr('href', hrefAttribute[index]);

            });
		}
    });
	
	
		 
	if(getUrlParameter('page') === "moderator" || getUrlParameter('page') === "approve"){
		isApprovePage === true
	}
        
        $('.lightbox').each(function(index, element){
		
                $(element).click(function(){
                    if ($(element).hasClass("selected") && controlPressed === true && isApprovePage === true){
                        $(element).removeClass('selected');
						if ($.inArray($(this).attr("id"), selectedHrefAttribute) >= 0){
							selectedHrefAttribute.splice($.inArray($(this).attr("id"), selectedHrefAttribute),1);

							stringHrefAttribute = selectedHrefAttribute + "";
							/*console.log(selectedHrefAttribute);
							console.log("");
							console.log(stringHrefAttribute);
							*/
							$('#files').val(stringHrefAttribute);

							}
							
                    } else if (!$(element).hasClass("selected") && controlPressed === true && isApprovePage === true){
                        $(element).addClass('selected');
                         $(element).attr('id',hrefAttribute[index]);
						 if ($.inArray($(this).attr("id"), selectedHrefAttribute) < 0){
							selectedHrefAttribute.push($(this).attr("id"));

							stringHrefAttribute = selectedHrefAttribute + "";
							/*console.log(selectedHrefAttribute);
							console.log("");
							console.log(stringHrefAttribute);
							*/
							$('#files').val(stringHrefAttribute);
							
							}
							
					}
                });
				
			
			
			

     });
     






	

    $('#searchbar').submit(function(e){
        e.preventDefault();
        var value = $('#search').val().trim();
        $.getJSON("galleryinfo.json", function(data) {
              JSONArr = data;
        });

		if (isPrivateChecked){
			access = "private";
		} else if (isPublicChecked){
			access = "public";
		} else {
			access = "all";
		}

        if (value){
                $.each(JSONArr, function(i,v){
                    var tags = v.tag.split(',');
                        
                        
                        console.log(value);
                        console.log(tags);
                        console.log(!tags.includes(value));
                        
                        $.each(tags, function(index, string){

                            tags[index] = string.trim();
                        });

                        
                        
                        console.log("");
                        console.log(value);
                        console.log(tags);
                        console.log(!tags.includes(value));
                        

                        if (!tags.includes(value)){
                             $('.lightbox').each(function(){
                                        var href = $(this).attr('href');

                                        if (href === v.imagefile){
                                            $(this).hide();
                                            $(this).attr("searched",false);
											$(this).attr("data-fancybox","");
                                        }
                             });
                        } else {
                            $('.lightbox').each(function(){
                                        var href = $(this).attr('href');
											
                                        if (href === v.imagefile && v.access === access || access === "all" && href === v.imagefile ){
                                            $(this).show();
                                            $(this).attr("searched",true);
											$(this).attr("data-fancybox","gallery");
                                        }
                                    });
                        }

                            });
                            
        } else {
            $.each(JSONArr, function(i,v){

			if (isPrivateChecked){
				$('.lightbox').each(function(){
                                        var href = $(this).attr('href');

                                        if (href === v.imagefile && v.access === "private"){
                                            $(this).show();
                                            $(this).attr("searched",true);
											$(this).attr("data-fancybox","gallery");
                                        }
                                }); 
			} else if (isPublicChecked){
				$('.lightbox').each(function(){
                                        var href = $(this).attr('href');

                                        if (href === v.imagefile && v.access === "public"){
                                            $(this).show();
                                            $(this).attr("searched",true);
											$(this).attr("data-fancybox","gallery");
                                        }
                                }); 
			} else {

                                $('.lightbox').each(function(){
                                        var href = $(this).attr('href');

                                        if (href === v.imagefile){
                                            $(this).show();
                                            $(this).attr("searched",true);
											$(this).attr("data-fancybox","gallery");
                                        }
                                }); 

				}
            });
        }

    });

	$('#labelPrivateCheck').on('change', function() {

        $.getJSON("galleryinfo.json", function(data) {
              JSONArr = data;
        });

           if ($('#privateCheck').prop('checked') == true){
		   	 isPrivateChecked = true;
			 isPublicChecked = false;
			 isAllChecked = false;
			 
                $.each(JSONArr, function(i,v){

                        if (v.access == "public"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');

                                if (href === v.imagefile){
                                    $(this).hide();
									$(this).attr("data-fancybox","");
                                }
                            });
                        } 
						if (v.access == "private"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
                                var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).show();
									$(this).attr("data-fancybox","gallery");
                                }
                            });
                        } 

                    });
            } else {
			isPrivateChecked = false;

                    $.each(JSONArr, function(i,v){
                        
                        if (v.access == "public"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
                                var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).show();
									$(this).attr("data-fancybox","gallery");
                                }
                            });
                        } 
                    });
            }
       
    });

		$('#labelPublicCheck').on('change', function() {

        $.getJSON("galleryinfo.json", function(data) {
              JSONArr = data;
        });

           if ($('#publicCheck').prop('checked') == true){
		   isPrivateChecked =  false;
			 isPublicChecked = true;
			 isAllChecked = false;
                $.each(JSONArr, function(i,v){

                        if (v.access == "private"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');

                                if (href === v.imagefile){
                                    $(this).hide();
									$(this).attr("data-fancybox","");
                                }
                            });
                        } 
						if (v.access == "public"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
                                var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).show();
									$(this).attr("data-fancybox","gallery");
                                } else if (searched == "false"){
									$(this).hide();
									$(this).attr("data-fancybox","");
								}
                            });
                        } 

                    });
            } else {

			 isPublicChecked = false;

                    $.each(JSONArr, function(i,v){
                        
                        if (v.access == "private"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
                                var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).show();
									$(this).attr("data-fancybox","gallery");
                                }
                            });
                        } 
                    });
            }
       
    });
	
	$('#labelAllCheck').on('change', function() {

        $.getJSON("galleryinfo.json", function(data) {
              JSONArr = data;
        });

           if ($('#allCheck').prop('checked') == true){
		   isPrivateChecked = false;
			 isPublicChecked = false;
			 isAllChecked = true;
                $.each(JSONArr, function(i,v){
			
                        if (v.access == "private" || v.access == "public"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
								var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).show();
									$(this).attr("data-fancybox","gallery");
                                }
                            });
                        } 


                    });
            } else {

			 isAllChecked = false;
                   $.each(JSONArr, function(i,v){

                        if (v.access == "private" || v.access == "public"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
								var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).show();
									$(this).attr("data-fancybox","gallery");
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
	
	function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
	};
    

})(jQuery);