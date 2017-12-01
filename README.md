# GENOA PHP SDK

A PHP Library to interface with Genoa API

## API docs

See [here](./API.md).

## Sample usage
```php
// Instantiate client using client and secret credentials
$client = new \genoa\Client($clientId, $secretId);


// Create a Content service instance
$contentService = new \genoa\service\Content($client);

// Request video info by ID
$video = $contentService->getContentById(123123);

// Update video info
$contentService->updateContent(123123, array(
  'description' => 'New video description'
));

// Update video thumbnail
$contentService->updateHighlightThumbnail(123123, '/path/to/new/thumbnail.png', 'image/png', 'new-thumbnail');

// Request video qualities
$qualities = $contentService->getQualities(123123);


// Create a Contents service instance
$contentsService = new \genoa\service\Contents($client, $publisherId);

// Request most recent videos
$videos = $contentService->getLatestContents();

// Request videos by category
$videos = $contentService->getCategoryContents(99);

// Request deleted videos
$videos = $contentService->getDeletedContents();
```

## Development
 
### Requirements

* Docker
* Docker Compose

### Generate API documentation
```
composer run generate-api-doc
```

### Run container and install dependencies
```
$ docker-compose run --rm app
$ composer install
```

### Run test cases inside container
```
$ phpunit
```
