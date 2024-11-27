# car-maintenance


### Run application

Clone repository:
```shell
git clone git@github.com:mikhailovv/car-maintenance.git car-maintenance
```
Run docker on your local machine

Run cli command "make" in root directory
```shell
cd car-maintenance
make
```
Confirm loading of fixtures for database.

The application will available at http://localhost:8000

The application to access to database will available at http://localhost:8050

Use
* bmw-owner@admin.com:bmw-owner
* mercedes-owner@admin.com:mercedes-owner

as login/password 

### Routes

#### Login
```http request
POST http://localhost:8000/api/login
Content-Type: application/json

{"email":  "admin@admin.com", "password": "admin"}
```

####  Get parts categories
```http request
GET http://localhost:8000/api/parts/categories/
Content-Type: application/json
Authorization: Bearer {token}
```

#### Get car brands
```http request
GET http://localhost:8000/api/cars/brands
Content-Type: application/json
Authorization: Bearer {token}
```
#### Get car models
```http request
GET http://localhost:8000/api/cars/{brand-slug}/models
Content-Type: application/json
Authorization: Bearer {token}
```
#### Get user cars
```http request
GET http://localhost:8000/api/cars
Content-Type: application/json
Authorization: Bearer {token}
```
