# PHP Learning

## Getting started

### Docker installation

1. Go to [Get Docker](https://docs.docker.com/get-docker/) page
2. Download and install Docker for your platform
3. Launch Docker

### Launch containers

1. Open the terminal and run `cd /path/to/php-practice` to navigate to the root of the project
2. Run `docker-compose build` to build containers (run once to build/rebuild the containers)
3. Run `docker-compose up -d` to start containers (flag `-d` is for daemon mode) 

#### Web app

Once you have the containers up and running, you can access the web app by opening [localhost:3000](http://localhost:3000) address in your browser.

#### CLI

Run `docker-compose run app <command-to-execute>` to execute command inside `app` container.
 