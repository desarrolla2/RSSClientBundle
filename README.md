RSSClientBundle
===============

Service for provide RSS client in your website, you can automatically add content to your site from your favorite information providers.

build status : [![Build Status](https://secure.travis-ci.org/desarrolla2/RSSClientBundle.png)](http://travis-ci.org/desarrolla2/RSSClientBundle)

## Bundle Installation


### Get the bundle

Add to your `/deps` file :

``` composer.json
    "require": {
        ...       
        "desarrolla2/rss-client-bundle": "dev-master" 
    },
````
        
And make a 

`composer update`

### Register the bundle

``` php
<?php

  // app/AppKernel.php
  public function registerBundles()
  {
    return array(
      // ...
      new Desarrolla2\Bundle\RSSClientBundle\RSSClientBundle(),
      );
  }
```

## Using RSS Bundle

### Configure providers

You need edit your config.yml and add the rss routes you want to get.

``` yml
# app/config/config.yml
rss_client:
   channels:
     
      channel_name1:
         - 'http://www.osukaru.es/feed/'
         - 'http://desarrolla2.com/feed/'
         
      channel_name2:
         - 'http://feeds.feedburner.com/symfony/blog'
         - 'http://www.symfony.es/feed/'
```


### In your controller

Retrieve the service and fetch the content

``` php
<?php

class NewsController extends Controller
{

    /**
     * Renders latest news
     *
     * @return array
     * @Route("/noticias", name="news_index")
     * @Template()
     */
    public function indexAction()
    {
        $this->client = $this->get('d2_rss_client');
        $this->client->fetch('channel_name1');

        return array(
            'feeds'   => $this->client->getNodes(),
        );
    }

}
```

### In your view

Render the content for your users

``` twig
{% block content %}
    <section>
        {% for feed in feeds %}            
            <article>
                <header>
                    <a href="{{ feed.link }}" target="_blank">{{ feed.title }}</a>
                    <small class="date-header">{{ feed.pubDate|date('d/m/Y H:i') }}</small>
                </header>
                <p>{{ feed.desc | replace({'&lt;':'<', '&gt;':'>'}) | striptags | truncate(420) | raw }}</p>
            </article>      
        {% else %}
            <p>Not news :(</p>
        {% endfor %}    
    </section>
{% endblock %}
```

## Coming soon

* This client only was tested with RSS2.0 other format not guaranteed.
* This client provide APC cache. Configuration time, and cache provider will be ready soon.