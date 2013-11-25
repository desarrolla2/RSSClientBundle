# RSSClientBundle

[![knpbundles.com](http://knpbundles.com/desarrolla2/RSSClientBundle/badge)](http://knpbundles.com/desarrolla2/RSSClientBundle)

[![Latest Stable Version](https://poser.pugx.org/desarrolla2/rss-client-bundle/v/stable.png)](https://packagist.org/packages/desarrolla2/rss-client-bundle) [![Total Downloads](https://poser.pugx.org/desarrolla2/rss-client-bundle/downloads.png)](https://packagist.org/packages/desarrolla2/rss-client-bundle) [![Build Status](https://secure.travis-ci.org/desarrolla2/RSSClientBundle.png)](http://travis-ci.org/desarrolla2/RSSClientBundle)

Service for provide RSS client in your website, you can automatically add content to your site from your favorite information providers.


## Bundle Installation

### Get the bundle

Add to your `/composer.json` file :

``` json
    "require": {
        ...       
        "desarrolla2/rss-client-bundle": "2.*" 
    },
````
        
And make

``` bash
composer update
```

### Register the bundle

``` php
// app/AppKernel.php
<?php

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
   cache:
      ttl:     3600 # This is the default
   channels:     
      channel_name1:
         - 'http://www.osukaru.es/feed/'
         - 'http://desarrolla2.com/feed/'
         
      channel_name2:
         - 'http://feeds.feedburner.com/symfony/blog'
         - 'http://www.symfony.es/feed/'
```

The cache option is completely optional. If not specified the shown default take effect.

#### Optionally: configure custom processors

If you want to use [custom processors](https://github.com/desarrolla2/RSSClient/blob/master/doc/custom-process.md) to extract additional information from a feed, also add the "processors" key pointing to services that implement the ```ProcessorInterface```.

```yml
rss_client:
   processors: ["my_service_id", "my_other_service_id"]
```

### In your controller

Retrieve the service and fetch the content.

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
        $this->client = $this->get('rss_client');

        return array(
            'feeds'   => $this->client->fetch('channel_name1'),
        );
    }

}
```

### In your view


Render the content for your users

``` html
{% block content %}
    <section>
        {% for feed in feeds %}            
            <article>
                <header>
                    <a href="{{ feed.link }}" target="_blank">{{ feed.title }}</a>
                    <time>{{ feed.pubDate | date('d/m/Y H:i') }}</time>
                </header>
                <p>{{ feed | raw }}</p>
            </article>      
        {% else %}
            <p>Not news :(</p>
        {% endfor %}    
    </section>
{% endblock %}
```

## Contact

You can contact with me on [twitter](https://twitter.com/desarrolla2).

## More Info

See [RSSClient](https://github.com/desarrolla2/RSSClient).
