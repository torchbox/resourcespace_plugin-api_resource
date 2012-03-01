Resource API

Usage:
http://url/plugins/api_resource/?key=[authkey]&[optional parameters]

Parameters:
resource=[int]           get resource file in stream
meta=[bool]              get the json metadata cache file in stream


sample call:
http://localhost/r2000/plugins/api_resource/?resource=142&key=ZX13...
http://localhost/r2000/plugins/api_resource/?resource=142&meta=1&key=ZX13...

sample output:
raw resource in its original format streamed via php