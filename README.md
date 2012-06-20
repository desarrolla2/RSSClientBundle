RSSClientBundle
===============

Service for provide RSS client in your website, you can automatically add content to your site from your favorite information providers.

## Bundle Installation

### Register the namespace

``` php
<?php

  // app/autoload.php
  $loader->registerNamespaces(array(
      'Desarrolla2' => __DIR__.'/../vendor/bundles',
      // your other namespaces
      ));
```

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

### Get the bundle

Add to your `/deps` file :

``` deps
[RSSClientBundle]
    git=git@github.com:desarrolla2/RSSClientBundle.git
    target=/bundles/Desarrolla2/Bundle/RSSClientBundle
````
        
And make a 

`php bin/vendors install`


## Using RSS Bundle

### Configure providers

You need edit your config.yml and add the rss routes you want to get.

``` yml
parameters:
  d2.client.rss.feeds:
    - 'http://codeup.net/feed/'
    - 'http://www.osukaru.es/feed/'
    - 'http://feeds.feedburner.com/moidev?format=xml'
    - 'http://desarrolla2.com/feed/'
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
        $this->client = $this->get('d2.client.rss');
        $this->client->fetch();

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
    <section class="page-content news">
        {% for feed in feeds %}            
            <article class="hentry">
                <header class="entry-title">
                    <a href="{{ feed.link }}" target="_blank">{{ feed.title }}</a>
                    <small class="date-header">{{ feed.pubDate|date('d/m/Y H:i') }}</small>
                </header>
                <p class="entry-content">{{ feed.desc | replace({'&lt;':'<', '&gt;':'>'}) | striptags | truncate(420) | raw }}</p>
            </article>      
        {% else %}
            <p>Not news :(</p>
        {% endfor %}    
    </section>
{% endblock %}
```

## Coming soon

* This client only was tested with RSS2.0 other format not guaranteed.
* This client not provide any kind of cache. We like to provide APC cache or similar.