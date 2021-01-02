<p align="center">
    <h1 align="center">HTML2PDF Service</h1>
    <br>
</p>

This service is based on Yii2 PHP Framework and using mPDF library to generate the pdf 

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.6.0.

### Install with Docker

Update your vendor packages

    docker-compose run --rm php composer update --prefer-dist
    
Run the installation triggers (creating cookie validation code)

    docker-compose run --rm php composer install    
    
Start the container

    docker-compose up -d
    
You can then access the application through the following URL:

    http://127.0.0.1:8155

**NOTES:** 
- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches
