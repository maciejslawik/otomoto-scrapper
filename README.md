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

## Built With

* Symfony Console
* Guzzle
* ReactPHP

## Authors

* [Maciej Sławik](https://github.com/maciejslawik)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details