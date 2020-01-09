# RESTAPI

Examples how to use the api.

## GET Requests
``GET all items
http://localhost/RESTAPI/api/measurement/read.php

``GET single item by id
http://localhost/RESTAPI/api/measurement/read_single.php?id=1


## POST Requests
By post request we need more then a single url. The request needs headers and a body contains JSON data.

``Create url
http://localhost/RESTAPI/api/measurement/create.php

``Create header 
Content-Type : application/json

``Create body
``` JSON
{
	"device_id": "1",
	"date_time": "2020-01-07 20:25",
	"temperature": "21.1",
	"humidity": "49.8"
}
 ```

## PUT Request
By put request we need more then a single url. The request needs headers and a body contains JSON data.

``Update url
http://localhost/RESTAPI/api/measurement/update.php

``Update header 
Content-Type : application/json

``Update body
``` JSON
{
	"device_id": "1",
	"date_time": "2020-01-07 20:20",
	"temperature": "19.4",
	"humidity": "51.2",
	"id" : "1"
}
 ```

## DELETE Request
By delete request we need more then a single url. The request needs headers and a body contains JSON data.

``Update url
http://localhost/RESTAPI/api/measurement/create.php

``Update header 
Content-Type : application/json

``Update body
``` JSON
{
	"id" : "1"
}
```
