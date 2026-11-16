currentView = "main";
currentTab = "All";
currentPage = 1;
currentQuery = "";
mainLoaded = true;
gridLoaded = false;

function selectWatch(id) {
    if(id == "#info-panel") {
        $("#info-panel").fadeIn(75);
        $("#favorite-panel").fadeOut(5);
        $("#playlist-panel").fadeOut(5);
        $("#addto-panel").fadeOut(5);
        $("#flag-panel").fadeOut(5);
    }

    if(id == "#favorite-panel") {
        $("#info-panel").fadeOut(5);
        $("#favorite-panel").fadeIn(75);
        $("#playlist-panel").fadeOut(5);
        $("#addto-panel").fadeOut(5);
        $("#flag-panel").fadeOut(5);
    }

    if(id == "#share-panel") {
        $("#info-panel").fadeOut(5);
        $("#favorite-panel").fadeOut(5);
        $("#playlist-panel").fadeIn(75);
        $("#addto-panel").fadeOut(5);
        $("#flag-panel").fadeOut(5);
    }

    if(id == "#addto-panel") {
        $("#info-panel").fadeOut(5);
        $("#favorite-panel").fadeOut(5);
        $("#playlist-panel").fadeOut(5);
        $("#addto-panel").fadeIn(75);
        $("#flag-panel").fadeOut(5);
    }

    if(id == "#flag-panel") {
        $("#info-panel").fadeOut(5);
        $("#favorite-panel").fadeOut(5);
        $("#playlist-panel").fadeOut(5);
        $("#addto-panel").fadeOut(5);
        $("#flag-panel").fadeIn(75);
    }
}

function main() {
    $("#www-main").fadeIn(75);
    $("#www-grid").fadeOut(75);
    currentView = "main";
    if (!mainLoaded) {
    	if (currentTab == "Search") {
    	    searchChannel(currentQuery,currentPage,true);
    	} else {
    	    selectTab(currentTab,userUserName,currentPage,true);
    	}
    }
}

function grid() {
    $("#www-main").fadeOut(75);
    $("#www-grid").fadeIn(75);
    currentView = "grid";
    if (!gridLoaded) {
        if (currentTab == "Search") {
            searchChannel(currentQuery,currentPage,true);
        } else {
            selectTab(currentTab,userUserName,currentPage,true);
        }
    }
}

function escapeHtml(unsafe) {
  return unsafe
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

function breakToBr(text) {
  return text
    .replace(/(?:\r\n|\r|\n)/g, "<br>");
}

function playVideo(vid) {
    main();
    $("#viddesc").html("<center><img src='/static/img/loadingg.gif'><br>Loading...</center>");
    $.getJSON(
        "/get_video_metadata?video_id=" + vid,
        function(v) {
            selectWatch('#info-panel');
            $("#watch-player").attr('src', "/embed_video?v=" + vid);
            $("#vidtite").text(v.video_info.title);
            $("#vidtite").attr("href", "/watch?v=" + vid);
            $("#vidauth").last().text(v.user_info.username);
            $("#vidauth").last().attr("href", "/user/" + v.user_info.username);
            $("#uploaded-date").text(v.video_info.uploaded_date);
            $("#viewc").text(v.video_info.view_count + " views");
            $("#viddesc").html(v.video_info.parsed_description);
            $("#playnav-watch-link").attr("href", "/watch?v=" + vid);
if (!v.video_info.i_favourited) {
            $("#fav").text("Favorite Video");
} else {
            $("#fav").text("Unfavorite Video");
}
                                                                $("#star_1").attr("src","/static/img/"+((v.video_info.star_ratio>=1)?'full':((v.video_info.star_ratio>=0.5)?'half':'empty'))+"_star.png");
                                                                $("#star_2").attr("src","/static/img/"+((v.video_info.star_ratio>=2)?'full':((v.video_info.star_ratio>=1.5)?'half':'empty'))+"_star.png");
                                                                $("#star_3").attr("src","/static/img/"+((v.video_info.star_ratio>=3)?'full':((v.video_info.star_ratio>=2.5)?'half':'empty'))+"_star.png");
                                                                $("#star_4").attr("src","/static/img/"+((v.video_info.star_ratio>=4)?'full':((v.video_info.star_ratio>=4.5)?'half':'empty'))+"_star.png");
                                                                $("#star_5").attr("src","/static/img/"+((v.video_info.star_ratio>=5)?'full':((v.video_info.star_ratio>=4.5)?'half':'empty'))+"_star.png");
								$("#ratetext").html(v.video_info.stars + " ratings&nbsp;");
            $("#reportlink").attr("href", "/report?v=" + vid);
            $("#playlist-panel a:contains('Twitter')").attr("href", "//twitter.com/intent/tweet?url=http://wrappertube.org/watch?v=" + vid + "&text=" + escape(v.video_info.title) +"&related=WrapperTube");
            $("#playlist-panel a:contains('Reddit')").attr("href", "//reddit.com/submit?url=http://wrappertube.org/watch?v=" + vid + "&title=" + escape(v.video_info.title));
            $("#playlist-panel a:contains('Facebook')").attr("href", "//facebook.com/sharer/sharer?u=http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwrappertube.org/watch?v=" + escape(vid));
            $("#playlist-panel #watch-url-field").val("http://wrappertube.org/watch?v=" + vid);
$('#addto-panel a').each(function() {
  var $this = $(this);
  var oldHref = $this.attr('onclick');

  var newHref = oldHref.replace(currentVideo, vid);
  $this.attr('onclick', newHref);
});
currentVideo = vid;
liked = v.video_info.i_liked;
disliked = v.video_info.i_disliked;
myRating = v.video_info.my_rating;
favourited = v.video_info.i_favourited;
        }
    );
}

function selectTab(tab,username,page,retain) {
if (typeof page === 'undefined') {
page = 1;
}
if (typeof retain === 'undefined') {
retain = false;
}
currentPage = page;
currentTab = tab;
currentQuery = "";
if (currentView == "main") {
$("#html-sidebar").html("<center><img src='/static/img/torch.gif'><br>Loading...</center>");
$.ajax({
    url: "/select_tab?tab=" + tab + "&username=" + escape(username) + "&page=" + page,
    success: function(html){
        if(html){
            $("#html-sidebar").html(html);
        } else {
            alert("Bad response from server.");
            mainLoaded = false;
        }
     }
});
gridLoaded = retain;
mainLoaded = true;
} else if (currentView == "grid") {
$("#html-grid").html("<center><img src='/static/img/torch.gif'><br>Loading...</center>");
$.ajax({
    url: "/select_tab_grid?tab=" + tab + "&username=" + escape(username) + "&page=" + page,
    success: function(html){
        if(html){
            $("#html-grid").html(html);
        } else {
            alert("Bad response from server.");
            gridLoaded = false;
        }
     }
});
mainLoaded = retain;
gridLoaded = true;
}
}

function open_playlist(id,username) {
$("#www-main").fadeIn(75);
$("#www-grid").fadeOut(75);
currentView = "main";
$("#html-sidebar").html("<center><img src='/static/img/torch.gif'><br>Loading...</center>");
$.ajax({
    url: "/open_playlist?id=" + id + "&username=" + escape(username),
    success: function(html){
        if(html){
            $("#html-sidebar").html(html);
        } else {
            alert("Bad response from server.");
            mainLoaded = false;
        }
     }
});
mainLoaded = true;
}

function searchChannel(query,page,retain) {
if (typeof page === 'undefined') {
page = 1;
}
if (typeof retain === 'undefined') {
retain = false;
}
currentPage = page;
currentTab = "Search";
currentQuery = query;
if (currentView == "main") {
$("#html-sidebar").html("<center><img src='/static/img/torch.gif'><br>Loading...</center>");
$.ajax({
    url: "/select_tab?tab=Videos&username=" + escape(userUserName) + "&search=" + escape(query) + "&page=" + page,
    success: function(html){
        if(html){
            $("#html-sidebar").html(html);
        } else {
            alert("Bad response from server.");
            mainLoaded = false;
        }
     }
});
gridLoaded = retain;
mainLoaded = true;
} else if (currentView == "grid") {
$("#html-grid").html("<center><img src='/static/img/torch.gif'><br>Loading...</center>");
$.ajax({
    url: "/select_tab_grid?tab=Videos&username=" + escape(userUserName) + "&search=" + escape(query) + "&page=" + page,
    success: function(html){
        if(html){
            $("#html-grid").html(html);
        } else {
            alert("Bad response from server.");
            gridLoaded = false;
        }
     }
});
mainLoaded = retain;
gridLoaded = true;
}
}

                        function subscribe() {
                                if(loggedIn == true) {
                                        if(subscribed == false) {
                                                $.ajax({
                                                        url: "/get/subscribe?n=" + escape(userUserName),
                                                        type: 'GET',
                                                        success: function(res) {
                                                                alerts++;
                                                                $(".sub_button").text("Unsubscribe");
                                                                addAlert("editsuccess_" + alerts, "Successfully added " + userUserName + " to your subscriptions!");
                                                                showAlert("#editsuccess_" + alerts);
                                                                console.log("DEBUG: " + res);
                                                                subscribed = true;
                                                        }
                                                });
                                        } else {
                                                $.ajax({
                                                        url: "/get/unsubscribe?n=" + escape(userUserName),
                                                        type: 'GET',
                                                        success: function(res) {
                                                                alerts++;
                                                                $(".sub_button").text("Subscribe");
                                                                addAlert("editsuccess_" + alerts, "Successfully removed " + userUserName + " from your subscriptions!");
                                                                showAlert("#editsuccess_" + alerts);
                                                                console.log("DEBUG: " + res);
                                                                subscribed = false;
                                                        }
                                                });
                                        }
                                } else {
                                        alerts++;
                                        addAlert("editsuccess_" + alerts, "You need to log in to add subscriptions!");
                                        showAlert("#editsuccess_" + alerts);
                                }
                        }

         function rate(rating) {
                        if (loggedIn) {
                                        $.ajax({
                                                url: "/get/star?v=" + currentVideo + "&rating=" + rating,
                                                type: 'GET',
                                                xhrFields: {
                                                        withCredentials: true
                                                },
                                                success: function (res) {
                                                        if(!myRating) {
                                                                switch (rating) {
                                                                case 5:
                                                                $("#star_1").attr("src","/static/img/full_star.png");
                                                                $("#star_2").attr("src","/static/img/full_star.png");
                                                                $("#star_3").attr("src","/static/img/full_star.png");
                                                                $("#star_4").attr("src","/static/img/full_star.png");
                                                                $("#star_5").attr("src","/static/img/full_star.png");
                                                                $("#ratetext").html("Very Good!&nbsp;");
                                                                liked = true;
                                                                disliked = false;
                                                                break;
                                                                case 4:
                                                                $("#star_1").attr("src","/static/img/full_star.png");
                                                                $("#star_2").attr("src","/static/img/full_star.png");
                                                                $("#star_3").attr("src","/static/img/full_star.png");
                                                                $("#star_4").attr("src","/static/img/full_star.png");
                                                                $("#star_5").attr("src","/static/img/empty_star.png");
                                                                $("#ratetext").html("Good!&nbsp;");
                                                                liked = true;
                                                                disliked = false;
                                                                break;
                                                                case 3:
                                                                $("#star_1").attr("src","/static/img/full_star.png");
                                                                $("#star_2").attr("src","/static/img/full_star.png");
                                                                $("#star_3").attr("src","/static/img/full_star.png");
                                                                $("#star_4").attr("src","/static/img/empty_star.png");
                                                                $("#star_5").attr("src","/static/img/empty_star.png");
                                                                $("#ratetext").html("OK.&nbsp;");
                                                                liked = false;
                                                                disliked = false;
                                                                break;
                                                                case 2:
                                                                $("#star_1").attr("src","/static/img/full_star.png");
                                                                $("#star_2").attr("src","/static/img/full_star.png");
                                                                $("#star_3").attr("src","/static/img/empty_star.png");
                                                                $("#star_4").attr("src","/static/img/empty_star.png");
                                                                $("#star_5").attr("src","/static/img/empty_star.png");
                                                                $("#ratetext").html("Bad..&nbsp;");
                                                                liked = false;
                                                                disliked = true;
                                                                break;
                                                                case 1:
                                                                $("#star_1").attr("src","/static/img/full_star.png");
                                                                $("#star_2").attr("src","/static/img/empty_star.png");
                                                                $("#star_3").attr("src","/static/img/empty_star.png");
                                                                $("#star_4").attr("src","/static/img/empty_star.png");
                                                                $("#star_5").attr("src","/static/img/empty_star.png");
                                                                $("#ratetext").html("Terrible...&nbsp;");
                                                                liked = false;
                                                                disliked = true;
                                                                break;
                                                                }
                                                                myRating = rating;
                                                        } else {
                                                                $("#star_1").attr("src","/static/img/empty_star.png");
                                                                $("#star_2").attr("src","/static/img/empty_star.png");
                                                                $("#star_3").attr("src","/static/img/empty_star.png");
                                                                $("#star_4").attr("src","/static/img/empty_star.png");
                                                                $("#star_5").attr("src","/static/img/empty_star.png");
                                                                $("#ratetext").html("IDK..&nbsp;");
                                                                liked = false;
                                                                disliked = false;
                                                                myRating = 0;
                                                        }
                                                }
                                        });
                        } else {
                                alerts++;
                                addAlert("editsuccess_" + alerts, "You need to log in to rate videos!");
                                showAlert("#editsuccess_" + alerts);
                        }
                }

                        function add_friend() {
                                    $.ajax({
                                            url: "/get/add_friend?sending=" + userUserName,
                                            type: 'GET',
                                            success: function(res) {
                                            if (res == "OK") {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, "Successfully sent friend request.");
                                                    showAlert("#editsuccess_" + alerts);
                                            } else {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                            }
                                    });
                        }

                        function toggle_favourite() {
                                    var did_i_favourite_already = favourited;
                                    $.ajax({
                                            url: did_i_favourite_already ? ("/get/unfavorite?v=" + currentVideo) : ("/get/favorite?v=" + currentVideo),
                                            type: 'GET',
                                            success: function(res) {
                                                    $("#fav").text((did_i_favourite_already ? "Favorite" : "Unfavorite") + " Video");
                                                    favourited = !favourited;
                                            }
                                    });
                        }

                        function add_to_quicklist() {
                                    $.ajax({
                                            url: "/get/add_to_quicklist?v=" + currentVideo,
                                            type: 'GET',
                                            success: function(res) {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                    });
                        }

                        function add_to_playlist(playlist) {
                                    $.ajax({
                                            url: "/get/add_to_playlist?id=" + currentVideo + "&playlist=" + playlist,
                                            type: 'GET',
                                            success: function(res) {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, escapeHtml(res));
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                    });
                        }

                        function add_to_group(group) {
                                    $.ajax({
                                            url: "/get/add_video_ajax?vid=" + currentVideo + "&gid=" + group,
                                            type: 'GET',
                                            success: function(res) {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, escapeHtml(res));
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                    });
                        }

                        function toggle_block() {
                                    var did_i_block_already = blocked;
                                    $.ajax({
                                            url: did_i_block_already ? ("/get/unblock?user=" + escape(userUserName)) : ("/get/block?user=" + escape(userUserName)),
                                            type: 'GET',
                                            success: function(res) {
                                            if (res == "OK") {
                                                    $("#block_text").text((did_i_block_already ? "B" : "Unb") + "lock");
                                                    blocked = !blocked;
                                            } else {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                            }
                                    });
                        }

                        function add_video_to_quicklist(videoId) {
                                    $.ajax({
                                            url: "/get/add_to_quicklist?v=" + videoId,
                                            type: 'GET',
                                            success: function(res) {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                    });
                        }
            $(function() { 
                $('#submitform' ).submit(
                    function( e ) {
			$("#comment_error").hide();
			$('#submitform input[type="submit"]').prop("disabled", true);
                        var data = new FormData(this);

                        $.ajax( {
                            url: '/post/comment_profile?n=' + escape(userUserName),
                            type: 'POST',
                            data: data,
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function(result){
                                if(result.substr(0,3) == "OK:") {
                                    $("#comments_section_real").prepend(result.substr(3));
                                    $('#submitform textarea[name="comment"]').val('');
                                } else {
                                    $("#comment_error").text(result.substr(6));
                                    $("#comment_error").show();
                                }
                                if (!amITrusted) { ka_reload(false); }
                                $('#submitform input[type="submit"]').prop("disabled", false);
                            }
                        } );
                        e.preventDefault();
                    } 
                );
            });
                        function delete_comment(cid) {
                                    if (!confirm('Are you sure you want to remove this comment?')) { return; }
                                    $.ajax({
                                            url: "/get/delete_comment_profile?id=" + cid,
                                            type: 'GET',
                                            success: function(res) {
                                            if (res == "OK") {
                                                    $("#comment_" + cid).prev().remove();
                                                    $("#comment_" + cid).remove();
                                            } else {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                            }
                                    });
                        }
