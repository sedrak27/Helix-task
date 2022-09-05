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

<------------------------------------------------->

To be able to send the code for verification you must configurate MAIL config in the env. file like bellow

MAIL_DRIVER=smtp  
MAIL_HOST=smtp.googlemail.com  
MAIL_PORT=465  
MAIL_USERNAME="your mail address"  
MAIL_PASSWORD="your mail password"  
MAIL_ENCRYPTION=tls  
MAIL_FROM_ADDRESS="your mail address"  
MAIL_FROM_NAME="${APP_NAME}"

You must fill your mail address  
and password.  
You can generate the password by following this video https://www.youtube.com/watch?v=qk8nJmIRbxk