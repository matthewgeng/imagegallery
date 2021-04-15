
(function ($) {

    "use strict";

    var JSONArr; // json array
	var isPrivateChecked = false; // is private checked for image filter
	var isPublicChecked = false; // is public checked for image filter
	var isAllChecked = false; // is all checked for image filter
	var access = ""; // what the access is
    var controlPressed = false; // is ctr pressed
    var hrefAttribute = []; // array of href attributes 
    var selectedHrefAttribute = []; // array of selected href attributes for image selection
    var stringHrefAttribute = ""; // string of selected href attributes
	var canSelectImages = false; // can the user select images

    // makes sure only one checkbox is checked
	$(document).on('click', 'input[type="checkbox"]', function() {      
		$('input[type="checkbox"]').not(this).prop('checked', false);      
	});

  
    /*==================================================================
    [ Focus Contact2 ]*/

    // makes sure when the input is selected the title doesn't come down
    $('.input2').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }else {
                $(this).removeClass('has-val');
            } // else
        })    
    });

    // makes sure when the input has a value the title doesn't come down
    $('.input2').each(function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }else {
                $(this).removeClass('has-val');
            } // else
    });


    // set captions for lightbox for each image
    $('.lightbox').each(function(index, element){

        // ajax for json 
        $.getJSON("galleryinfo.json", function(data) {
              JSONArr = data;
        });

        // for each loop
        $.each(JSONArr, function(index,value){


             var href = $(element).attr('href');

             if (href === value.imagefile){
                $(element).attr('data-caption', "image");
                } // if

            });
        
    });

        // when select all is pressed
        $('#selectAll').click(function(){
            if ($("#selectAll").text().trim() == "Select All"){
                    $('.lightbox').each(function(index, element){

                    // adds selected class if image is not hidden
					if ($(element).parent().css('display') !== 'none'){
                            $(element).addClass("selected");
							$(element).attr('id',$(element).attr('href'));

                            // adds selected href to string in hidden input in form
							if ($.inArray($(element).attr("id"), selectedHrefAttribute) < 0){ 
								selectedHrefAttribute.push($(element).attr("id"));

								stringHrefAttribute = selectedHrefAttribute + "";
								
								$('#files').val(stringHrefAttribute);
                            console.log($('#files').val());
								
							} // if
							
					
					} // if

                    });

                    $("#selectAll").text("Deselect All");

                } else if ($("#selectAll").text().trim() == "Deselect All"){
                    $('.lightbox').each(function(index, element){

                    // removes css class if image is not hidden
					if ($(element).parent().css('display') !== 'none'){
                            $(element).removeClass("selected");

                            // removes selected href to string in hidden input in form
							if ($.inArray($(element).attr("id"), selectedHrefAttribute) >= 0){
								selectedHrefAttribute.splice($.inArray($(element).attr("id"), selectedHrefAttribute),1);

								stringHrefAttribute = selectedHrefAttribute + "";
								
								$('#files').val(stringHrefAttribute);
                            console.log($('#files').val());

							} // if
							
					} // if
                    });		

                    $("#selectAll").text("Select All");

                } // else if

         });

    // if the select opposite button is pressed
    $('#selectOpposite').click(function(){

        $('.lightbox').each(function(index, element){
                // toggle selection classes if not hidden
				if ($(element).parent().css('display') !== 'none'){
                $(element).toggleClass("selected");
				} // if

				if ($(element).hasClass("selected")){
					$(element).attr('id',$(element).attr('href'));

                        // adds selected href to string in hidden input in form
						if ($.inArray($(element).attr("id"), selectedHrefAttribute) < 0){
								selectedHrefAttribute.push($(element).attr("id"));

								stringHrefAttribute = selectedHrefAttribute + "";
								
								$('#files').val(stringHrefAttribute);
                            console.log($('#files').val());
								
							} // if
				
				} else {
				

                            // removes selected href to string in hidden input in form
							if ($.inArray($(element).attr("id"), selectedHrefAttribute) >= 0){
								selectedHrefAttribute.splice($.inArray($(element).attr("id"), selectedHrefAttribute),1);

								stringHrefAttribute = selectedHrefAttribute + "";
								
								$('#files').val(stringHrefAttribute);
                            console.log($('#files').val());

							} // if
				} // else
        
        });

    });
    
    if( getUrlParameter('page') === "approve" || getUrlParameter('page') === "moderator" && getUrlParameter('edit') === "true"){

        canSelectImages = true;

    } else{
        canSelectImages = false;
    } // else

    if (getUrlParameter('page') === ""){
        $('#home').addClass("active");
        $('#moderator').removeClass("active");
        $('#upload').removeClass("active");
    } else if (getUrlParameter('page') === "form"){
        $('#home').removeClass("active");
        $('#moderator').removeClass("active");
        $('#upload').addClass("active");
    }else if (getUrlParameter('page') === "moderator" && getUrlParameter('edit') === "true"){
        $('#home').removeClass("active");
        $('#user').removeClass("active");
        $('#approve').removeClass("active");
        $('#edit').addClass("active");
    } else if (getUrlParameter('page') === "moderator"){
        $('#home').addClass("active");
        $('#user').removeClass("active");
        $('#approve').removeClass("active");
        $('#edit').removeClass("active");
    } else if (getUrlParameter('page') === "approve"){
        $('#home').removeClass("active");
        $('#user').removeClass("active");
        $('#approve').addClass("active");
        $('#edit').removeClass("active");
    } 


    // key listener for ctr
    $(document).keydown(function(event){
    	if(event.which=="17" && canSelectImages){
			controlPressed = true;
			
			$('.lightbox').each(function(index, element){
				
				if (controlPressed === true){
					$(element).removeAttr('data-fancybox');
					hrefAttribute.push($(element).attr('href'));
					$(element).removeAttr('href');
				} // if
			});
		} // if
    });
	
    // key listner for release
	$(document).keyup(function(){
        controlPressed = false;
		if (controlPressed === false && canSelectImages){
			$('.lightbox').each(function(index, element){

                $(element).attr('data-fancybox', "gallery");
                $(element).attr('href', hrefAttribute[index]);

            });
		} // if
    });
	
	

        // adds selection class if image is selected in approve page
        $('.lightbox').each(function(index, element){
		
                $(element).click(function(){
				
                    if ($(element).hasClass("selected") && controlPressed === true && canSelectImages === true){
                        $(element).removeClass('selected');
						if ($.inArray($(this).attr("id"), selectedHrefAttribute) >= 0){
							selectedHrefAttribute.splice($.inArray($(this).attr("id"), selectedHrefAttribute),1);

							stringHrefAttribute = selectedHrefAttribute + "";
							$('#files').val(stringHrefAttribute);
                            

							} // if
							
                    } else if (!$(element).hasClass("selected") && controlPressed === true && canSelectImages === true){
                        $(element).addClass('selected');
                         $(element).attr('id',hrefAttribute[index]);
						 if ($.inArray($(this).attr("id"), selectedHrefAttribute) < 0){
							selectedHrefAttribute.push($(this).attr("id"));

							stringHrefAttribute = selectedHrefAttribute + "";
							$('#files').val(stringHrefAttribute);
                            
							
							} // if
							
					} // if
                });
			
     });
     
    // searches for image
    $('#searchbar').submit(function(e){
        e.preventDefault(); // prevents reload

        var value = $('#search').val().trim();

        // gets json from ajax
        $.getJSON("galleryinfo.json", function(data) {
              JSONArr = data;
        });

		if (isPrivateChecked){
			access = "private";
		} else if (isPublicChecked){
			access = "public";
		} else {
			access = "all";
		} // else

        // if there is a value in search bar
        if (value){
                $.each(JSONArr, function(i,v){
                    var tags = v.tag.toLowerCase().split(',');
                        
                        $.each(tags, function(index, string){

                            tags[index] = string.trim().toLowerCase();
                        });
                        
                        if (!tags.includes(value)){
                             $('.lightbox').each(function(){
                                        var href = $(this).attr('href');

                                        if (href === v.imagefile){
                                            $(this).parent().hide();
                                            $(this).attr("searched",false);
											$(this).attr("data-fancybox","");

                                        } // if
                             });
                        } else {
                            $('.lightbox').each(function(){
                                        var href = $(this).attr('href');
											
                                        if (href === v.imagefile && v.access === access || access === "all" && href === v.imagefile ){
                                            $(this).parent().show();
                                            $(this).attr("searched",true);
											$(this).attr("data-fancybox","gallery");

                                        } // if
                                    });
                        } // else

                            });
                            
        } else {
            $.each(JSONArr, function(i,v){

			if (isPrivateChecked){
				$('.lightbox').each(function(){
                                        var href = $(this).attr('href');
                                        if (href === v.imagefile && v.access === "private"){
                                            $(this).parent().show();
                                            $(this).attr("searched",true);
											$(this).attr("data-fancybox","gallery");

                                        } // if
                                }); 
			} else if (isPublicChecked){
				$('.lightbox').each(function(){
                                        var href = $(this).attr('href');

                                        if (href === v.imagefile && v.access === "public"){
                                            $(this).parent().show();
                                            $(this).attr("searched",true);
											$(this).attr("data-fancybox","gallery");

                                        } // if
                                }); 
			} else {

                                $('.lightbox').each(function(){
                                        var href = $(this).attr('href');

                                        if (href === v.imagefile){
                                            $(this).parent().show();
                                            $(this).attr("searched",true);
											$(this).attr("data-fancybox","gallery");

                                        } // if
                                }); 

				} // else
            });
        } // else

    });

    // display private images if private is checked for image types
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
                                    $(this).parent().hide();
									$(this).attr("data-fancybox","");
                                } // if
                            });
                        }  // if
						if (v.access == "private"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
                                var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).parent().show();
									$(this).attr("data-fancybox","gallery");
                                } // if
                            });
                        } // if
                    });
            } else {
			isPrivateChecked = false;

                    $.each(JSONArr, function(i,v){
                        
                        if (v.access == "public"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
                                var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).parent().show();
									$(this).attr("data-fancybox","gallery");
                                } // if
                            });
                        } // if
                    });
            } // else
       
    });

        // displays public images if public button is pressed
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
                                    $(this).parent().hide();
									$(this).attr("data-fancybox","");
                                } // if
                            });
                        } // if
						if (v.access == "public"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
                                var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).parent().show();
									$(this).attr("data-fancybox","gallery");
                                } else if (searched == "false"){
									$(this).parent().hide();
									$(this).attr("data-fancybox","");
								} // else if
                            });
                        } // if

                    });
            } else {

			 isPublicChecked = false;

                    $.each(JSONArr, function(i,v){
                        
                        if (v.access == "private"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
                                var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).parent().show();
									$(this).attr("data-fancybox","gallery");
                                } // if
                            });
                        } // if
                    });
            } // else
       
    });
	
    // display all images if all is checked
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
                                    $(this).parent().show();
									$(this).attr("data-fancybox","gallery");
                                } // if
                            });
                        } // if


                    });
            } else {

			 isAllChecked = false;
                   $.each(JSONArr, function(i,v){

                        if (v.access == "private" || v.access == "public"){

                            $('.lightbox').each(function(){
                                var href = $(this).attr('href');
								var searched = $(this).attr('searched');
                                if (href === v.imagefile && searched !== "false"){
                                    $(this).parent().show();
									$(this).attr("data-fancybox","gallery");
                                } // if
                            });
                        } // if

                    });
            } // else
       
    });


        // adds class to file upload button if given a file
    $('#file-upload').on('change',function(){
        if ($('#file-upload').val().trim() != ''){
            $('#file-upload').addClass('has-val');
        } else {
            $('#file-upload').removeClass('has-val');
        } // else
    });

    // resets form
    $('#reset-button').on('click',function(){

        // general reset
        $("#uploadForm").trigger("reset");

        // text reset
        $('.input2').each(function(){
            $(this).attr('value', "")
            $(this).removeClass('has-val');
			hideValidate(this);
            hideErrorValidate(this);
        });

        // resets file
		$('#file-upload').each(function(){
            $(this).removeClass('has-val');

			hideValidate(this);
            hideErrorValidate(this);

        });

        // resets descriptions and tags
        $('textarea').each(function(){
            $(this).text("");
        });

        // resets button
		$('#button').each(function(){
            $(this).attr('checked', false);
			hideValidate(this);
            hideErrorValidate(this);

        });

        // resets radio buttons
		$('.radio').each(function(){
            $(this).attr('checked', false);
			hideValidate(this);
            hideErrorValidate(this);

        });


    });

    /*==================================================================
    [ Validate ]*/
    var firstName = $('.validate-input input[name="first-name"]'); // first name value from form
    var lastName = $('.validate-input input[name="last-name"]'); // last name value from form
    var description = $('.validate-input textarea[name="description"]'); // description value from form
    var tag = $('.validate-input textarea[name="tag"]'); // tag value from form
	var copyright = $('.validate-input input[name="copyright"]'); // copyright value from form
    var file = $('.validate-input input[name="file"]'); // file upload value from form
    var access = $('.validate-input input[name="access"]'); // access type value from form
	
    // validates form
    $('.validate-form').on('submit',function(){
        var check = true;

        if($(firstName).val().trim() == ''){
            showValidate(firstName);
            check=false;
        } // if
		
		if($(lastName).val().trim() == ''){
            showValidate(lastName);
            check=false;
        } // if
		
        if ($(file).val().trim() == ''){
            showValidate(file);
            check = false;
        } // if

        if($(description).val().trim() == ''){
            showValidate(description);
            check=false;
        } // if
        
        if($(tag).val().trim() == ''){
            showValidate(tag);
            check=false;
        } // if
		
		if ($(copyright).prop('checked') == false){
			showValidate(copyright);
			check = false;
		} // if

		if ($('#public').prop('checked') == false && $('#private').prop('checked') == false) {
			showValidate(access);
			check = false;
		} // if 


		return check;
    });

    // hides validate error on click on value
    $('.validate-form .input2').each(function(){
        $(this).focus(function(){
		   hideValidate(this);
           hideErrorValidate(this);
       });
    });
	
    // adds class to file upload if it has a value
	$('#file-upload').on('change',function(){
        if ($('#file-upload').val().trim() != ''){
            $('#file-upload').addClass('has-val');
        } else {
            $('#file-upload').removeClass('has-val');
        } // else
    });
	
    // hides error if file upload is changed and has a value
	$('.validate-form #file-upload').each(function(){
		$(this).on('change',function(){
        if ($(this).val().trim() != ''){
            hideValidate(this);
            hideErrorValidate(this);
			} // if 
		});
    });
	
    // hides error if button is checked true
	$('.validate-form #button').each(function(){
		$(this).on('change', function() {
			if ($(this).prop('checked') == true) {
            hideValidate(this);
            hideErrorValidate(this);
			} // if
		});
		
    });
	
    // hides error on radio value change
	$('.validate-form .radio').each(function(){
		$(this).on('change', function() {
			if ($('#public').prop('checked') == true || $('#private').prop('checked') == true) {
				hideValidate(this);
                hideErrorValidate(this);
			} // if
		});
		
    });
	
    // show error
    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    } // showValidate

    // hide error
    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    } // hideValidate

    // hide error
    function hideErrorValidate(input) {
        var thisAlert = $(input).parent();
        $(thisAlert).removeClass('error');
    } // hideValidate
	
    // get key value pairs in url
	function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
	} // getUrlParameter
    

})(jQuery);