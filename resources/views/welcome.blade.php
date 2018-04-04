<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FB Scan Code Generator!</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container" style="width: 30%">
            <h1 class="text-center">FB Scan Code Generator</h1>
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="from" role="form">
                        <div class="form-group">
                            <input type="text" id="token" class="form-control" placeholder="Page Access Token" />
                            <p>Get your access token <a href="https://developers.facebook.com/tools/explorer" target="_blank">here</a></p>
                        </div>
                        <div class="form-group">
                            <input type="text" id="ref" class="form-control" placeholder="Ref" />
                            <p>You can leave this empty or use a ref from ChatFuel</p>
                        </div>
                        <div class="form-group">
                            <input type="text" id="size" class="form-control" placeholder="Image Size" />
                            <p>Allowed values are 100-2000</p>
                        </div>
                        <div class="form-group">
                            <input type="submit" id="submit" class="btn btn-default btn-md pull-right" value="Submit"/>
                        </div>
                    </form>
                </div>
            </div>
            <div id="toggleImageVideo" class="text-center" style="margin-top: 50px;">
                <iframe id="ytVideo" width="100%" height="300" src="https://www.youtube.com/embed/RdsVOmSRykI?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                <span id="messegerCode" style="display: none;"></span>
                <span id="dlCode" style="display: none;"></span>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
        <script>
            (function (window, document) {
                $(document).ready(function () {
                    $('#submit').click(function (event) {
                        event.preventDefault();
                        
                        var token = $('#token').val();
                        var ref = $('#ref').val();
                        var size = $('#size').val();

                        if (!token.length) {
                            swal({
                              type: 'error',
                              title: 'Oops...',
                              text: 'Page Access Token is required!'
                            });
                            return false;
                        }

                        if (size.length) {
                            if (size < 100 || size > 2000) {
                                swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: 'Image size should be betwenn 100 and 2000'
                                });
                                return false;
                            }
                        } else {
                            swal({
                              type: 'error',
                              title: 'Oops...',
                              text: 'Image size is required!'
                            });
                            return false;
                        }

                        var messengerCodeAPI = "https://graph.facebook.com/v2.6/me/messenger_codes?access_token="+token;
                        var payload = {
                            type: "standard",
                            data: {
                                ref: ref
                            },
                            "image-size": size
                        }

                        $.ajax({
                            type: "POST",
                            url: messengerCodeAPI,
                            data: payload
                        }).done(function (response) {
                            var src = response.uri;

                            var ytVideo = $('#ytVideo')
                            ytVideo.remove();

                            var code = $('#messegerCode');
                            code.remove();

                            var button = $('#dlCode');
                            button.remove();

                            var appendHtml = '<img id="messegerCode" class="img-responsive" src="'+src+'" style="height: 300px; width: 300px"><br/>'
                            +'<a id="dlCode" class="btn btn-default btn-md text-center" href="'+src+'" download="code.jpg" name="code.jpg" target="_blank">Download</a>';
                            $('#toggleImageVideo').append(appendHtml);
                        });
                    });
                });
            })(window, document);
        </script>
    </body>
</html>
