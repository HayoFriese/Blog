/************************************************************************************/



/***********************                  ADMIN               ***********************/



/*************************************************************************************/

/*Show Image*/
	var cover;
    function readURL(input) {
    	if (input.files && input.files[0]) {
    	    var reader = new FileReader();
    	    
    	    reader.onload = function (e) {
    	        $('.admin-newb-cover').css('background', '#FFFFFF url("' + reader.result + '") no-repeat fixed');
    	    	$('.admin-newb-cover').css('background-size', 'cover');
    	    	$('.admin-newb-cover').css('background-position', 'center center');
    	    }
    	    
    	    reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#blog-post-cover").change(function(){
        readURL(this);
    });

function _(id){
	return document.getElementById(id);
}

/*multi Phase*/
	var blogCover, blogTitle, blogDesc, blogCat, blogPost, progress;
	var step = _("admin-blog-step");
	step.innerHTML = "Step 1";
	
	function blog_nextStep(){
		//Variables
			//progress bar
				var one = _("blog-step-one");
				var two = _("blog-step-two");
				var three = _("blog-step-three");
				progress = _("blog-progress");
			//input fields
				//step 1
					blogCover = _("blog-post-cover").value;
					blogTitle = _("blog-post-title").value;
					blogDesc = _("blog-post-desc").value;
					blogCat = _("blog-post-cat").value;
				//step 2
					blogPost = _("blog-post-content").innerHTML;
				//step 3
					blogSubmit = _("blog-post-submit");

		if(step.innerHTML == "Step 1"){
			//validate input fields
			step.innerHTML = "Step 2";
			progress.style.width = "66%";
			one.style.display = "none";
			two.style.display = "block";
		}
		else if(step.innerHTML == "Step 2"){
			//validate input fields
			step.innerHTML = "Step 3";
			progress.style.width = "100%";
			two.style.display = "none";
			three.style.display = "block";
		}
	}

/*WYSIWYG*/
	/*Color pallete*/
		var colorPalette = ['000000', 'FF9966', '6699FF', '99FF66', 'CC0000', '00CC00', '0000CC', '333333', '0066FF', 'FFFFFF'];
		var forePalette = $('.fore-palette');
		for (var i = 0; i < colorPalette.length; i++) {
		    forePalette.append('<a href="#" data-command="forecolor" data-value="' + '#' +
		     colorPalette[i] + '" style="background-color:' + '#' + colorPalette[i] + 
		     ';" class="palette-item"></a>');
		}

	/*Editor Commands List*/
		$('.blog-editor-bar a').click(function(e) {
			var command = $(this).data('command');
			if(command == 'h1' || command == 'h2' || command == 'h3' ||
				command == 'h4' || command == 'blockquote' || command == 'p'){
				document.execCommand('formatBlock', false, command);
			}
			if(command=='forecolor'){
				document.execCommand($(this).data('command'), false, $(this).data('value'));
			}
			if(command == 'fontSize'){
				document.execCommand($(this).data('command'), false, $(this).data('value'));
			}
			if (command == 'createlink'|| command == 'insertimage'){
				url = prompt('Enter the link here: ', 'http:\/\/');
				document.execCommand($(this).data('command'), false, url);
			} else {
				document.execCommand($(this).data('command'), false, null);
			}
		});
	
	/*Save*/
		$('#save').click(function (){
			var input = $('input[type=hidden]');
			var id = input[0].value;
 			var postcontent = $('#blog-post-content').html();
 			var title = $('#blog-post-title').val();
 			var cat = $('#blog-post-cat').val();
 			var desc = $('#blog-post-desc').val();
 			var cover = $('#blog-post-cover').val();

    	    $.ajax({                        //start an AJAX call
    	        type: 'POST', 
    	        url: "save.php",                     //Action: GET or POST
    	        data: {id: id,
    	        	cover: cover,
    	        	title: title,
    	        	desc: desc,
    	        	cat: cat,
    	        	post: postcontent
    	        },
    	        datatype: 'html',    //Separate each line with a comma
    	            success: function(done){         //if values send do this 
    	    			$('#postid').value = id;
    	    			$('#blog-post-content').html(postcontent);
    	    			alert(done);
    	            } 
    	    }); //end ajax request
 		});

 	/*Form Submit*/
		$('#new-blog-post').on('submit', function(e){
			e.preventDefault();
			
			var myform = document.querySelector('#new-blog-post');
			var cover = $('#blog-post-cover').val();
 			var postcontent = $('#blog-post-content').html();

			var formData = new FormData(myform);
			formData.append('post', postcontent);
			formData.append('cover', cover);

    	    $.ajax({
    	        type: 'POST',
    	        url: "server/blog_process.php",
    	        data: formData,
    	        contentType: false,
    	        processData: false, 
    	        success: function(done){
    	    		alert(done);
    	    		window.location.href = "admin_blog.php";
    	        } 
    	    });
		});