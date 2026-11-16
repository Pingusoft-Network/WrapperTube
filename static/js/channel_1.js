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
