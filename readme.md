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

notes:

    - Queue: on .env file, by default, sets QUEUE_DRIVER=database
        if you want to collaborate, the goal is to use REDIS
    - Crons: we only have one, that runs every 1am and 13pm
        per day, updating all episodes of existing feeds
    - Tests: for now, only the XML class have tests
        the goal is to create for every class, we accept help on that
-------


- Collaborate:

    - Queue:
        - now:  it uses database mysql.
        - goal: use redis.

    - Tests:
        - now:  only the XML class have tests
        - goal: create for every class

    - Authentication:
        - now:  none.
        - goal: basic auth.

    - Refactor:
        - now:  Poor Entities, controllers with highly coupled logic
        - goal: open for suggestions


- Routes:
###### GET:
```
    api.podcast.com/feed/{PodcastName}
    retrieve podcast main informations
```
```
    api.podcast.com/episodes/{feedId}
    retrieve episodes previously saved
```



##### listen queuing:
```bash
$ php artisan queue:listen
```
##### run crons
```bash
$ php artisan schedule:run
```


### License

The BrnPod API is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
