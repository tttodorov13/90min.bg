jQuery(document).ready(function($) {
    
    window.fbAsyncInit = function() {
        FB.init({
            appId: EFL.appId, // App ID
            channelUrl: '//connect.facebook.net/en_US/all.js', // Channel File
            status: true, // check login status
            cookie: true, // enable cookies to allow the server to access the session
            xfbml: true  // parse XFBML
        });


        FB.Event.subscribe('auth.authResponseChange', function(response)
        {
            if (response.status === 'connected')
            {
                console.log("ELF Facebook Connected.");
                //SUCCESS
            }
            else if (response.status === 'not_authorized')
            {
                console.log("ELF Facebook Failed to Connect");
                //FAILED
            } else
            {
                console.log("ELF Facebook Logged Out");
                //UNKNOWN ERROR
            }
        });

    };




    (function(d) {
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement('script');
        js.id = id;
        js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        ref.parentNode.insertBefore(js, ref);
    }(document));


    jQuery(".EFL-login").click(function() {
        FB.login(function(response) {
            if (response.authResponse)
            {
                var mypic_small;
                var mypic_large;

                FB.api('/me/picture?type=small', function(response) {
                    mypic_small = response.data.url;
                });
                FB.api('/me/picture?type=large', function(response) {
                    mypic_large = response.data.url;
                });

                FB.api('/me', function(fbResponse) {

                    var args = {};
                    args["Name"] = fbResponse.name;
                    args["Link"] = fbResponse.link;
                    args["Username"] = fbResponse.username;
                    args["Id"] = fbResponse.id;
                    args["Email"] = fbResponse.email;
                    args["pic_small"] = mypic_small;
                    args["pic_large"] = mypic_large;

                    jQuery.post(
                            EFL.ajaxurl,
                            {
                                action: 'ajaxAction',
                                myAction: 'login',
                                args: args,
                                nextNonce: EFL.nextNonce
                            },
                    function(response) {
                        if (response === 'Busted!')
                            return false;
                        document.location.assign(EFL.eflAfterLogin);
                    }
                    );

                });
            } else
            {
                console.log('User cancelled login or did not fully authorize.');
            }
        }, {scope: 'email,user_photos,user_videos'});

    });

    jQuery(".EFL-logout").click(function() {
        FB.logout(function() {

            jQuery.post(
                    EFL.ajaxurl,
                    {
                        action: 'ajaxAction',
                        myAction: 'logout',
                        nextNonce: EFL.nextNonce
                    },
            function(response) {
                if (response === 'Busted!')
                    return false;

                document.location.assign(EFL.eflAfterLogOut);
            }
            );
        });
    });

});
