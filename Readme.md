
Calendar APP

The entire application runs in docker containers.
In order to start the application the following command must be ran from the root folder

`make up && make db`

the applications will be accessible in `http::localhost:8888`

The application is implemented using DDD(Domain Driven Design) concepts.
The following endpoints are accessible through REST Endpoints.



 **_Create a calendar_**:
 
`curl -X POST \
 http://localhost:8888/calendar \
 -H 'Cache-Control: no-cache' \
 -H 'Content-Type: application/json' \
 -H 'Postman-Token: 9123745f-dde9-4eaf-a080-c529d7e06928' \
 -d '{

"name": "calendar name",
"description": "calendar description"
}'`




**_Schedule an calendar event in a given calendar._**

`curl -X POST \
  http://localhost:8888/calendar/c5196c67-8d0d-42ea-802a-beb552294a85/events \
  -H 'Cache-Control: no-cache' \
  -H 'Content-Type: application/json' \
  -H 'Postman-Token: 93b6491b-8aeb-4c6d-9573-54828b4dd205' \
  -d '{
    "id": "0e7ba396-c6e3-41fa-a2c7-6f8f2597ace0",
    "calendar_id": "25f1bcbd-45e5-4ff0-b9cd-510d87456d69",
    "description": "A description",
    "begins": "2018-04-20T10:10:00",
    "ends": "2018-04-20T11:10:00",
    "location": "a location",
    "comment": "a comment"
}'`

**_Retrieve all scheduled events in a calendar._**

`curl -X GET \
  http://localhost:8888/calendar/c5196c67-8d0d-42ea-802a-beb552294a85/events \
  -H 'Cache-Control: no-cache' \
  -H 'Content-Type: application/json' \
  -H 'Postman-Token: 061e7118-e1c2-4254-8e99-153cefcfb934' \
  -d '{
	"description": "A description",
	"location": "a location",
	"begins" : "2018-04-20T10:10:00",
	"ends" : "2018-04-06",
	"comment": "a comment"
}'
`
**_Modify a given event_**

`curl -X PUT \
  http://localhost:8888/calendar/c5196c67-8d0d-42ea-802a-beb552294a85/events/0759e416-05df-46a2-910a-768aec4734e1 \
  -H 'Cache-Control: no-cache' \
  -H 'Content-Type: application/json' \
  -H 'Postman-Token: 72acb2cf-62e6-4002-a586-36bf1b1c7278' \
  -d '{
	"description": "a description",
	"location": "asdada",
	"begins" : "2018-04-20T10:10:00",
	"ends" : "2018-04-20T11:10:00",
	"comment": "a comment"
}'`

_**Delete event**_

`curl -X DELETE \
  http://localhost:8888/calendar/c5196c67-8d0d-42ea-802a-beb552294a85/events/0759e416-05df-46a2-910a-768aec4734e1 \
  -H 'Cache-Control: no-cache' \
  -H 'Content-Type: application/json' \
  -H 'Postman-Token: cb9c3dd1-8db1-4d3b-a3cc-4667a97685d4'
`