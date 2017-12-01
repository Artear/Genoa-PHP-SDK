## Table of contents

- [\genoa\File](#class-genoafile)
- [\genoa\ApiException](#class-genoaapiexception)
- [\genoa\ApiCall](#class-genoaapicall)
- [\genoa\Client](#class-genoaclient)
- [\genoa\service\Contents](#class-genoaservicecontents)
- [\genoa\service\Content](#class-genoaservicecontent)
- [\genoa\service\AuthorizationAccess](#class-genoaserviceauthorizationaccess)

<hr />

### Class: \genoa\File

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$path</strong>, <em>mixed</em> <strong>$mimetype</strong>, <em>mixed</em> <strong>$name</strong>)</strong> : <em>void</em><br /><em>ApiException constructor.</em> |
| public | <strong>getMimeType()</strong> : <em>string</em> |
| public | <strong>getName()</strong> : <em>string</em> |
| public | <strong>getPath()</strong> : <em>string</em> |

<hr />

### Class: \genoa\ApiException

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$message=`''`</strong>, <em>int</em> <strong>$code</strong>, <em>[\Exception](http://php.net/manual/en/class.exception.php)/NULL/[\Exception](http://php.net/manual/en/class.exception.php)</em> <strong>$previous=null</strong>)</strong> : <em>void</em><br /><em>ApiException constructor.</em> |

*This class extends \Exception*

<hr />

### Class: \genoa\ApiCall

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$host</strong>, <em>array</em> <strong>$headers=array()</strong>)</strong> : <em>void</em><br /><em>Api constructor.</em> |
| public | <strong>addHeader(</strong><em>mixed</em> <strong>$key</strong>, <em>mixed</em> <strong>$value</strong>)</strong> : <em>[\genoa\ApiCall](#class-genoaapicall)</em> |
| public | <strong>asJSON()</strong> : <em>[\genoa\ApiCall](#class-genoaapicall)</em> |
| public | <strong>call(</strong><em>mixed</em> <strong>$url</strong>, <em>mixed</em> <strong>$payload</strong>, <em>mixed</em> <strong>$method</strong>)</strong> : <em>mixed</em> |
| public | <strong>get(</strong><em>null</em> <strong>$payload=null</strong>)</strong> : <em>mixed</em> |
| public | <strong>getHost()</strong> : <em>string</em> |
| public | <strong>post(</strong><em>mixed</em> <strong>$payload</strong>)</strong> : <em>mixed</em> |
| public | <strong>put(</strong><em>mixed</em> <strong>$payload=null</strong>)</strong> : <em>mixed</em> |
| public | <strong>setCurlOption(</strong><em>mixed</em> <strong>$key</strong>, <em>mixed</em> <strong>$value</strong>)</strong> : <em>[\genoa\ApiCall](#class-genoaapicall)</em> |
| public | <strong>uploadFile(</strong><em>mixed</em> <strong>$file_path</strong>, <em>mixed</em> <strong>$mimetype</strong>, <em>mixed</em> <strong>$filename</strong>)</strong> : <em>string</em> |
| protected | <strong>prepareCurlFileRequest(</strong><em>mixed</em> <strong>$file_path</strong>, <em>mixed</em> <strong>$mimetype</strong>, <em>mixed</em> <strong>$filename</strong>)</strong> : <em>void</em> |
| protected | <strong>prepareCurlRequest(</strong><em>mixed</em> <strong>$url</strong>, <em>mixed</em> <strong>$payload</strong>, <em>mixed</em> <strong>$method</strong>)</strong> : <em>void</em> |

<hr />

### Class: \genoa\Client

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$client_id</strong>, <em>mixed</em> <strong>$secret_id</strong>)</strong> : <em>void</em><br /><em>Client constructor.</em> |
| public | <strong>get(</strong><em>mixed</em> <strong>$path</strong>, <em>mixed</em> <strong>$payload=null</strong>)</strong> : <em>mixed</em> |
| public | <strong>getAccessToken()</strong> : <em>mixed</em> |
| public | <strong>getApiHost()</strong> : <em>string</em> |
| public | <strong>post(</strong><em>mixed</em> <strong>$path</strong>, <em>mixed</em> <strong>$payload</strong>)</strong> : <em>void</em> |
| public | <strong>put(</strong><em>mixed</em> <strong>$path</strong>, <em>mixed</em> <strong>$payload=null</strong>)</strong> : <em>void</em> |
| public | <strong>upload(</strong><em>mixed</em> <strong>$path</strong>, <em>array</em> <strong>$query=array()</strong>, <em>mixed</em> <strong>$file</strong>)</strong> : <em>void</em> |
| protected | <strong>call(</strong><em>mixed</em> <strong>$method</strong>, <em>mixed</em> <strong>$path</strong>, <em>mixed</em> <strong>$payload</strong>)</strong> : <em>void</em> |
| protected | <strong>getApiCall(</strong><em>mixed</em> <strong>$endpoint</strong>)</strong> : <em>mixed</em> |

<hr />

### Class: \genoa\service\Contents

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>[\genoa\Client](#class-genoaclient)</em> <strong>$client</strong>, <em>mixed</em> <strong>$publisher_id</strong>)</strong> : <em>void</em><br /><em>Content constructor.</em> |
| public | <strong>getCategoryContents(</strong><em>number</em> <strong>$category_id</strong>, <em>number</em> <strong>$page=1</strong>)</strong> : <em>array</em><br /><em>Return category contents</em> |
| public | <strong>getDeletedContents(</strong><em>number</em> <strong>$page=1</strong>)</strong> : <em>array</em><br /><em>Return deleted contents</em> |
| public | <strong>getLatestContents(</strong><em>number</em> <strong>$limit=20</strong>)</strong> : <em>array</em><br /><em>Return the last $limit contents from the publisher (defaults to 20)</em> |

<hr />

### Class: \genoa\service\Content

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>[\genoa\Client](#class-genoaclient)</em> <strong>$client</strong>)</strong> : <em>void</em><br /><em>Content constructor.</em> |
| public | <strong>getContentById(</strong><em>mixed</em> <strong>$content_id</strong>)</strong> : <em>mixed</em> |
| public | <strong>getQualities(</strong><em>mixed</em> <strong>$content_id</strong>)</strong> : <em>mixed</em><br /><em>Return the qualities of the video</em> |
| public | <strong>updateContent(</strong><em>mixed</em> <strong>$content_id</strong>, <em>array</em> <strong>$payload=array()</strong>)</strong> : <em>mixed</em><br /><em>Update a content description: optional (String) name: optional (String) categories: optional (int,int) status: optional ('enabled','disabled') tags: optional (String) comscore: {"ns_st_st":"test","ns_st_pu":"test2"}</em> |
| public | <strong>updateHighlightThumbnail(</strong><em>mixed</em> <strong>$content_id</strong>, <em>string</em> <strong>$path</strong>, <em>string</em> <strong>$mimetype</strong>, <em>string</em> <strong>$name</strong>)</strong> : <em>string</em> |

<hr />

### Class: \genoa\service\AuthorizationAccess

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$client_id</strong>, <em>mixed</em> <strong>$secret_id</strong>)</strong> : <em>void</em><br /><em>AuthorizationAccess constructor.</em> |

