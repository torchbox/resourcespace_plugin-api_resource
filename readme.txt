Alternative File API

Usage:
http://url/plugins/api_resource/?key=[authkey]&[optional parameters]

Parameters:
resource=[int]           get list of alternative files for a resource

sample call:
http://localhost/r2000/plugins/api_resource/?resource=142&key=ZX13...

sample output:
raw resource in its original format streamed via php

If a signature is required, you must md5([yourhashkey].[querystring]) and submit it as a final parameter called skey.
Your hash key is a shared secret available from plugins/api_core.
The query string you hash this with must not include a leading '?', and must not include an skey parameter.

The simplest example of a signed call is:
url/plugins/api_alt_file/?key=aBCdEf...&skey=<?php echo md5("yourhashkey"."key=aBCdEf...")?>
