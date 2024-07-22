# HUG market

Install this application:
make up
make migrate

Import Todos:
make in
bin/console app:todo:import

Run tests:
make qa

Use Postman for API utilization:
GET,POST http://localhost/api/v1/todos
GET,PUT,DELETE http://localhost/api/v1/todos/{id}

Stop application:
make down
