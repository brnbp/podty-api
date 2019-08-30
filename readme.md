[![CircleCI](https://circleci.com/gh/brnbp/podty-api.svg?style=svg&circle-token=120eaa9768f28a5ae58d7c3b88e66fe628c304d0)](https://circleci.com/gh/brnbp/podty-api)
[![StyleCI](https://styleci.io/repos/57003001/shield?branch=master)](https://styleci.io/repos/57003001)
[![codecov](https://codecov.io/gh/brnbp/podty-api/branch/master/graph/badge.svg)](https://codecov.io/gh/brnbp/podty-api)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4ddf7889-ef30-4e89-b5c5-7fafa7da9b9f/small.png)](https://insight.sensiolabs.com/projects/4ddf7889-ef30-4e89-b5c5-7fafa7da9b9f)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/651998c049474a47aabac3071cda0ad0)](https://www.codacy.com/app/bruno9pereira/podty-api?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=brnbp/podty-api&amp;utm_campaign=Badge_Grade)
[![Coverage Status](https://coveralls.io/repos/github/brnbp/podty-api/badge.svg?branch=master)](https://coveralls.io/github/brnbp/podty-api?branch=master)

## Podty API

Podty API is a application that its divided in basically two parts:
  - podcast aggregator - collects all podcasts and episodes from the world inside a centralized storage
  - user aggregator - centralize all podcasts that a user listen, tracks which episodes they're already listen to, favorites, friends, and much more


### First Steps
For start, we need to populate the database with podcasts, there's an endpoint for that, but its also possible to use any other kind of script that auto-populates (like a crawler for the itunes library).

After we already have the xml feeds inside the database, the only thing needed is to run cron commands to periodically look for new episodes of those feeds. This command will look for new episodes and then add to the database, and to the users that follows those podcasts (to receive the fresh new episodes).

To run this, just set the follow crontab config:

```bash
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

```bash
$ php artisan queue:work --daemon --sleep 120 --tries 3 -q &
```

And there's also a queue the takes care of heavy process, as the search for new episodes and updates that don't require immediate response for the services to work.


##### Setup environment
```bash
$ cp .env.example.env
# then, fill out your environment information
$ vim .env
```

##### Build up database
```bash
$ php artisan migrate
```

##### Run server locally
```bash
$ php artisan serve
```

Besides all the background work, this application also offers an extensive API to manage podcasts and their listeners
Its possible to see all routes registered inside the routes file:
```
https://github.com/brnbp/podty-api/blob/master/routes/v1/api.php
```
but there's also a postman collection to have a more user friendly view:
```
https://github.com/brnbp/podty-api/blob/master/podcast-api.postman_collection.json
```
