# Download Analytics
The following solution uses a custom microframework built specifcally for this project. It's very simple to use. It has in built functionality for controllers, commands and models. The ORM I've done for is incomplete, so lacks functionality. I've only only added in functionality that is required for this solution.

# Getting Started
To install this project, run the following the command:
```sh
$ composer install
```
This will install any necesary dependencies.

# Database
This solution requires that you set up a database with three tables:
- metrics
- metric_types
- units

These can be created by running the SQL queries found in the `resources` folder.

# Environment Variables
In order for this solution to function correctly you will need to set up the following environment variables. This can be done by either injecting them into your container/environment or you can create a `.env` in the projects root folder.
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD
- JSON_HOST

# Ingest
I've built a custom CLI for for this solution. After setting up your database, run the following command:
```sh
$ php bin/console command=CaptureMetricsCommand
```

# API
To set up the API, start up a http server and set the document root to the `public` folder within the project root.

You'll then need to set `index.php` as the router script. This can be done via a `.htaccess` file or through your code editor gui(if supported). PHP Storm supports this but I'm not sure about other code editors.

You can then query the API by opening up the following URL:
`http://localhost:8080/unit/{unitId}/{metricType}`

Where `unitId` is the id of the unit, and `metricType` is the name of the metric you wish to see.

# Considerations
 - The ORM is incomplete, with more time I could add onto this allow a complete abstraction of the database and query layer.
 - I've used dependency injection as much as possible but it doesn't really work very well with the way I've built the models. Ideally we'd have some repositories and they'd be injected in to each of the applicable services. Laravel allows you to use your models without injecting but they are mockable so it's fine for testing. I didn't get that far, due to time constraints.
 - I wouldn't normally be pulling data in from a json file like this. Data for each of the units would be held in a queuing system, and then seperate consumers/containers would process each unit seperatly allowing for concurrency.
 - With more data, I would have partitioned the database into month/metric_type combinations to aid performance. I've had good success with this in the past.
 - Finally, I wouldn't every build something from scratch like this. No need to reinvent the wheel. Symfony, Laravel or even Lumen would be used. But the instructions said not to use any franeworks.
 - I also wouldn't be building my own ORM. Either Doctrine or Eloquent would be more than sufficient for the needs of the project. I was unsure with the instructions on whether or not ORMs were allowed.