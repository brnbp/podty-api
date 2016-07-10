## Podcast API

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

- Collaborate:

    - Queue:
        - now:  it uses database mysql.
        - goal: use redis.

    - Tests:
        - now:  only the XML class have tests
        - goal: create for every class


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


### License

The BrnPod API is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
