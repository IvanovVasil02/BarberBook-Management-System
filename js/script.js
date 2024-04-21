
$('#tweets .btn').click(function (evt){
    evt.preventDefault();   
    const ele = $(this);
    const userId = ele.attr('data-user');
    let following = ele.attr('data-following');
    const btnClass = following ? 'btn-danger':'btn-primary';

   

    $.ajax({
        method : 'POST',
        url: 'actions.php',
        data: {
            userId,
            following,
            action:'toggleFollow',
            csrf: $('#csrf').val(),
            
        }, 
        success: function (data) {
            const ele = $(evt.target);
            const result = JSON.parse(data);

            if(result.success){
               
                following = result.following;
                

                console.log(following);
                console.log(result.following);

                if(result.following){
                    
                    ele.attr('data-following', 1);
                    ele.removeClass('btn-primary');
                    ele.addClass('btn-danger');
                    ele.html('UnFollow');

                    console.log(userId);

                    const id = '#'+userId;                  


                }else{

                   

                    ele.attr('data-following', 0);
                    ele.removeClass('btn-danger');
                    ele.addClass('btn-primary'); 
                    ele.html('Follow');

                    console.log(userId);
                }
            
            }
        }  

    })
});


//post a tweet

$('#tweetForm #btnTweetPost').click(function (evt){
    evt.preventDefault();
   
    const data = $('#tweetForm').serialize();

    $.ajax({
        method : 'POST',
        url: 'actions.php',
        data: data, 
        success: function (data) {
            const tweetdata = JSON.parse(data);
            if(!tweetdata['success']){
                alert(tweetdata['msg']);
                return;
            }

            const tweets = document.getElementById('tweets');
            const firstChild = tweets.firstChild;
            const myDiv = document.createElement('div');
            myDiv.innerHTML = tweetdata['tweet'];
            tweets.insertBefore(myDiv, firstChild);
        
        }});


});

//filter tweets
$('#filterTweetsForm #filterTweetsBtn').click(function (evt){
    evt.preventDefault();

    const searchFilter = $('#searchFilter').val();
    if(!searchFilter || searchFilter.length <2){
        alert('The search text min is 3!');
        return false;
    }

    console.log(searchFilter);

    const data = $('#filterTweetsForm').serialize();

    $.ajax({
        method : 'GET',
        url: 'actions.php',
        data: data, 
        success: function (data) {
            const tweetData = JSON.parse(data);
            
            if(!tweetData['success']){
                alert(tweetData['msg']);
                return;
            }

            const tweets = document.getElementById('tweets');
            
            tweets.innerHTML = tweetData['tweets'];
        }
    });


});