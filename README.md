[![Build Status](https://travis-ci.org/maciejslawik/otomoto-scrapper.svg?branch=master)](https://travis-ci.org/maciejslawik/otomoto-scrapper)
[![Coverage Status](https://coveralls.io/repos/github/maciejslawik/otomoto-scrapper/badge.svg?branch=master)](https://coveralls.io/github/maciejslawik/otomoto-scrapper?branch=master)
[![Latest Stable Version](https://poser.pugx.org/mslwk/otomoto-scrapper/v/stable)](https://packagist.org/packages/mslwk/otomoto-scrapper)
[![License](https://poser.pugx.org/mslwk/otomoto-scrapper/license)](https://packagist.org/packages/mslwk/otomoto-scrapper)

# Otomoto scrapper

This CLI app scraps [Otomoto](https://otomoto.pl/) to provide you
with average price and mileage of a requested car.

## Getting Started

These instructions will get you a copy of the project up and running 
on your local machine.

### Prerequisites

You can use the provider Docker configuration to run the app.
To do this you will need:
* docker
* docker-compose

Alternatively you can set it up using a locally installed PHP 7.2

### Installing

0. If you want to use Docker run 

```
docker-compose up -d
```

Then, inside your container

```
composer install
```

## Usage

The CLI application is available using the executable
```
bin/otomoto
```

### Available commands
* app:manufacturer-list - lists all available car manufacturers
    ```
    bin/otomoto app:manufacturer-list 
    ```

* app:manufacturer-models manufacturer_name - lists all available models for chosen manufacturer
    ```
    bin/otomoto app:manufacturer-models "Alfa Romeo"
    ```
    
    
* app:model-details manufacturer_name model_name - retrieves stats for a chosen car model
    ```
    bin/otomoto app:model-details "Alfa Romeo" "Giulia"
    ```
    Available filters:
    * From year of production
    * To year of production
    ```
    bin/otomoto app:model-details "Alfa Romeo" "Giulia" --from=2016 --to=2017
    ```
    
### Caching
Models and manufacturers are cached inside ```cache/``` directory. To clear cache
simply remove/empty the directory.    
        
## Built With

* Symfony Console
* Guzzle
* ReactPHP
* Stash caching

## Authors

* [Maciej Sławik](https://github.com/maciejslawik)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Screenshots

![Alt text](docs/models.png?raw=true "Manufacturer models")

![Alt text](docs/details.png?raw=true "Model stats")