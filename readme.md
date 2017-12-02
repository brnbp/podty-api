[![CircleCI](https://circleci.com/gh/brnbp/podty-api.svg?style=svg&circle-token=120eaa9768f28a5ae58d7c3b88e66fe628c304d0)](https://circleci.com/gh/brnbp/podty-api)
[![StyleCI](https://styleci.io/repos/57003001/shield?branch=master)](https://styleci.io/repos/57003001)
[![codecov](https://codecov.io/gh/brnbp/podty-api/branch/master/graph/badge.svg)](https://codecov.io/gh/brnbp/podty-api)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4ddf7889-ef30-4e89-b5c5-7fafa7da9b9f/small.png)](https://insight.sensiolabs.com/projects/4ddf7889-ef30-4e89-b5c5-7fafa7da9b9f)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/651998c049474a47aabac3071cda0ad0)](https://www.codacy.com/app/bruno9pereira/podty-api?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=brnbp/podty-api&amp;utm_campaign=Badge_Grade)


## Podcast API :rocket:

## Requirements
- [Composer](https://getcomposer.org)
- PHP >= 7.0
- MySQL >= 5.6

## Getting Started
##### Download and install
```bash
$ git clone https://github.com/brnbp/brnpod-api.git .
$ composer install
```

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

##### Run Server
```bash
$ php artisan serve
```

-------


- Routes:

Filters available
 - limit
 - offset
 - order
    - DESC
    - ASC

- Feeds:

###### GET:
```
    api.podcast.com/v1/feeds/name/{FeedName}
    retrieve podcast main informations
```

```
    api.podcast.com/v1/feeds/id/{FeedId}
    retrieve podcast main informations
```

```
    api.podcast.com/v1/feeds/latest
    retrieve latests podcasts updated
```

```
    api.podcast.com/v1/episodes/feedId/{FeedId}
    retrieve episodes from given podcast
```

```
    api.podcast.com/v1/episodes/latest
    retrieve latests episode updated
```

- Users

##### GET
```
    api.podcast.com/v1/users/{Username}
    retrieve user
```

##### POST
```
    api.podcast.com/v1/users/
    create user
    payload:
    {
        "username": "foo",
        "email": "bar",
        "password": "baz"
    }
```

###### DELETE
```
    api.podcast.com/v1/users/{Username}
    delete user
```

###### POST
```
    api.podcast.com/v1/users/authenticate
    test authentication for given payload user
    payload:
    {
        "username": "foo",
        "password": "bar"
    }
```


- User Feeds

##### GET
```
    api.podcast.com/v1/users/{Username}/feeds
    retrieve all user feeds
```

##### GET
```
    api.podcast.com/v1/users/{Username}/feeds/{FeedId}
    retrieve one user feeds
```

###### POST
```
    api.podcast.com/v1/users/{Username}/feeds
    attach feeds on user list
    payload:
    {
        "feeds": [
            {feedId},
            {feedId},
            {feedId}
        ]
    }
```

###### DELETE
```
    api.podcast.com/v1/users/{Username}/feeds/{FeedId}
    detach feed on user list
```


- Queue

###### GET
```
    api.podcast.com/v1/queue
    retrieve queued tasks
```

```
    api.podcast.com/v1/queue/failed
    retrieve queued task that have failed
```
###### DELETE
```
    api.podcast.com/v1/queue/{queueId}
    delete task from queue that is not reserved
```


### On Production Env.

##### queuing:
```bash
$ php artisan queue:work --daemon --sleep 120 --tries 3 -q &
```

##### run crons (put this on crontab, run every minute)
```bash
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

###### giving the correctly rights
```bash
sudo chmod 777 -R storage/
```
