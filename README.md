# virta-rest-api

Test App Directory Explained:

1. virta-rest-api folder: Virta Companies and Stations API - Laravel-based API that runs on port 8080.
2. docker-compose.yml file.

Here's how the client can run the application using Docker Compose:

Navigate to the root directory that contains the docker-compose.yml file.
Open a terminal or command prompt in that directory.
1. Run the following command to build and start the containers: docker-compose up --build
2. Navigating to: http://127.0.0.1:8080/api/documentation/ This URL will lead them to the Swagger API app where you can interact with the api: Add/ Edit / Delete Companies And Stations and perform "Task 2" requested actions on "Charging Stations" API section.


API URL to Task 2
"Within the radius of n kilometers from a point (latitude, longitude), your station list is ordered by increasing distance, and stations in the same
location are grouped. Your list includes all the children stations in the tree, for the given company_id."

1. Navigating to: http://127.0.0.1:8080/api/charging-stations?company_id=1&latitude=10.1&longitude=12.1&radiusInKm=1
