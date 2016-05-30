<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 80px;
            }

            .subtitle {
                font-size: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Podcast API</div>
            </div>
        </div>
<br>
        <div class="container">
            <div class="content">
                <h2>Routes</h2>
                <br><br>
                <div class="subtitle">
                    GET:<br>
                    api.podcast.com/v1/feed/{podcastName}<br>
                    creates new feed and add episodes
                </div>
                <br>
                <hr><br>
                <div class="subtitle">
                    GET:<br>
                    api.podcast.com/v1/episodes/{feedId}<br>
                    retrieve episodes previously saved<br>
                    <br><br>
                    more:<br>
                    by default, returns the last X episodes from the podcast<br>
                    <br><br>
                    its possible to add some filters like:<br>
                     - limit = integer<br>
                     - offset = integer<br>
                     - order = string (desc/asc)<br>


                </div>
                <div class="subtitle">
                    GET:<br>
                    api.podcast.com/v1/queue<br>
                    retrieve queued tasks
                </div>
                <br>
                <hr><br>
                <div class="subtitle">
                    GET:<br>
                    api.podcast.com/v1/queue/reserved<br>
                    retrieve queued task that is reserved
                </div>
                <br>
                <hr><br>
                <div class="subtitle">
                    DELETE:<br>
                    api.podcast.com/v1/queue/{queueId}<br>
                    delete task from queue that is not reserved
                </div>
                <br><br><br><br><br>
            </div>
        </div>
    </body>
</html>
