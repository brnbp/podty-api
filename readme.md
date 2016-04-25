## Podcast API

## Requirements
- [Composer](https://getcomposer.org)

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

Routes:
###### POST:
```
    api.podcast.com/name/{PodcastName}
    creates new feed and add episodes
```
###### GET:
```
    api.podcast.com/name/{PodcastName}
    retrieve episodes previously saved
```


### License

The BrnPod API is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
