var comment_count= 0;
        
load_comment();

function check_session(){
    $.ajax({
        url:'PHP_AJAX_Queries/Comments/sessions.php',
        method:'POST',
        success:function(data){
            if(data!== '0') {
                $("#signedIn").css({"display":"block"});
                $("#signedOut").css({"display":"none"});
                $("#error").css({"display":"none"});
                $("#text-area").css({"display":"block"});
                $("#links").css({"display":"none"});
                $(".userID").val(data['Connected-UserID']);
                $('.comment_buttons').css({'display':'inline-block'});
                
            } else {
                    $('.comment_buttons').css({'display':'none'});
                    $('.to_show').css({'display':'none'});
            }
        }
    });
}

function load_comment() {
    var articleId=window.location.href.split('=')[1];

    $.ajax({
    url:"PHP_AJAX_Queries/Comments/CommentFetch.php",
    method:"POST",
    data:{
    Article_Id:articleId
    },

    success:function(data)
    {
        check_session();
        $('#comment_section').html(data);
        
        comment_count=0;
        $('.comment-details').each(function(){
            comment_count++;
            $('#comment_count').html(comment_count);
        })

        $('.comment_buttons').each( function(){
            var user_role = $(this).find('.user_role').val();
            var deleted_parent = $(this).find('#deleted_parent').val();
        
            if(user_role=='admin'){
                $(this).siblings('.admin_tag').html('admin');
                $(this).siblings('.comment-name').css({'backgroundColor':'orange'})
            } else {
                $(this).siblings('.admin_tag').html('');
            }

            if (deleted_parent == 1) {
                $(this).find('.commentMenu').css({"display":"none"});  
                $(this).parent().css({"height":"90px"}); 
                $('p.1').html("[Comment removed]" + " ").addClass("gray").css({'padding':'0 0 0 30px', 'font-size':'14px', 'font-style': 'italic'});
                $('div.1').css({'padding':'0',
                                'margin-top':'0', 
                                'margin-bottom':'0', 
                                'height':'65px'});
            }
        })
        
        $('.comment-details').each( function(){
            if ($(this).find('.timeago').attr("title") !== 'Last Updated : ') {
                var dateTime = new Date($(this).find('.timeago').attr("title"));
                dateTime = moment(dateTime).fromNow();
                $(this).find('p.1').append("<span class=''>" + dateTime+ "</span>")
            } else {
                $(this).find('.timeago').css({"display":"none"});
            }

        });                    
        $('.vertical-line').click(function(e){
            $(this).parent().toggleClass('collapsed-comment');  
            $(this).parent().find('.expandIcon').toggleClass('d-none');   
        });

    }
    })
}

function post_reply(commentID){
    event.preventDefault();
    var form_data = $('.comment_form'+commentID).serialize();
    console.log('Comment.js post_reply Function => ', form_data);
    $.ajax({
        url:"PHP_AJAX_Queries/Comments/CommentAdd.php",
        method:"POST",
        data:form_data,
        dataType:"JSON",
        success:function(data)
        {
            console.log(data);
            if(data.error != '')
            {
                $('.comment_form'+commentID)[0].reset();
                $('#comment_message').html(data.error);
                load_comment();
            }
        }
    })
};

function do_delete(commentID){
    event.preventDefault();
    var form_data = $('.delete'+commentID).serialize();
    $.ajax({
        url:"PHP_AJAX_Queries/Comments/CommentDelete.php",
        method:"POST",
        data:form_data,
        dataType:"JSON",
        success:function(data)
        {
            console.log(data);
            if(data.error != '')
            {
                $("#exampleModal").modal("hide");
                $(".modal-backdrop").css({"height":"0%", "width":"0%"});
                $(".modal-open").css({"overflow":"visible"});
                $('#comment_message').html(data.error);
                load_comment();
            }
        }
    })
};

function do_update(commentID) {
        event.preventDefault();
    var form_data = $('.update'+commentID).serialize();
    $.ajax({
        url:"PHP_AJAX_Queries/Comments/CommentEdit.php",
        method:"POST",
        data:form_data,
        dataType:"JSON",
        success:function(data)
        {
            console.log(data);
            if(data.error != '')
            {
                $("#exampleModal").modal("hide");
                $(".modal-backdrop").css({"height":"0%", "width":"0%"});
                $(".modal-open").css({"overflow":"visible"});
                $('#comment_message').html(data.error);
                load_comment();
                
            }
        }
    })
}

function do_report(commentID){
    event.preventDefault();
    var form_data = $('.report'+commentID).serialize();
    console.log(form_data);
    $.ajax({
        url:"PHP_AJAX_Queries/Comments/CommentReport.php",
        method:"POST",
        data:form_data,
        dataType:"JSON",
        success:function(data)
        {
            console.log(data);
            if(data.error != '')
            {
                $("#exampleModal").modal("hide");
                $(".modal-backdrop").css({"height":"0%", "width":"0%"});
                $(".modal-open").css({"overflow":"visible"});
                // $('#comment_message').html(data.error);
                load_comment();
            }
        }
    })
};

