---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---

# Info

Welcome to the generated API reference.

# Available routes

@foreach($parsedRoutes as $group => $routes)
@if($group)
#{{$group}}
@endif
@foreach($routes as $parsedRoute)

@if($parsedRoute['title'] != '')## {{ $parsedRoute['title']}}
@else## {{$parsedRoute['uri']}}
@endif
@if($parsedRoute['description'])

{{$parsedRoute['description']}}
@endif

> Example request:

```bash
curl "{{config('app.url')}}/{{$parsedRoute['uri']}}" \
-H "Accept: application/json"@if(count($parsedRoute['parameters'])) \
@foreach($parsedRoute['parameters'] as $attribute => $parameter)
    -d "{{$attribute}}"="{{$parameter['value']}}" \
@endforeach
@endif

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "{{config('app.url')}}/{{$parsedRoute['uri']}}",
    "method": "{{$parsedRoute['methods'][0]}}",
    @if(count($parsedRoute['parameters']))
"data": {!! str_replace('    ','        ',json_encode(array_combine(array_keys($parsedRoute['parameters']), array_map(function($param){ return $param['value']; },$parsedRoute['parameters'])), JSON_PRETTY_PRINT)) !!},
    @endif
    "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

@if(in_array('GET',$parsedRoute['methods']))
> Example response:

```json
{!! str_limit(json_encode(json_decode($parsedRoute['response']), JSON_PRETTY_PRINT), 1000) !!}
```
@endif

### HTTP Request
@foreach($parsedRoute['methods'] as $method)
`{{$method}} {{$parsedRoute['uri']}}`

@endforeach
@if(count($parsedRoute['parameters']))
#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
@foreach($parsedRoute['parameters'] as $attribute => $parameter)
    {{$attribute}} | {{$parameter['type']}} | @if($parameter['required']) required @else optional @endif | {!! implode(' ',$parameter['description']) !!}
@endforeach
@endif

@endforeach
@endforeach
