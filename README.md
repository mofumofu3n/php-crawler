# php-crawler

this is feed crawler library in php curl.

## Usage

### Get single url

```
$crawler = new Crawler("http://example.com");
$result = $crawler->getContents();
```

### Get multi url

```
$urls = array(
            "http://example.com",
            "http://www.example.com"
        );
$crawler = new Crawler($urls);
$result = $crawler->getContents();
```
