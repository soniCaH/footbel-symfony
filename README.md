Footbel Data
============

Project to retrieve, process and expose footbel (Belgian Football) data (results and rankings).
Create public API to display data, create webdav calendar etc...

Application:
- Downloads the static CSV files provided by the official football association.
- Creates RabbitMQ message to process the file
- Store/update the data in MySQL database
- Provides public API's to retrieve data
- Provides public webdav calendar to subscribe to your favorite teams (incl updates with results).