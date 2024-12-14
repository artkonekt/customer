# Customer Module Changelog

## Unreleased
##### 2024-XX-YY

- Fixed an SQLite migration error with Laravel 11.15+
- Added PHP 8.4 support

## 3.1.0
##### 2024-11-25

- Added the Customer purchases table and model

## 3.0.0
##### 2024-04-25

- BC: Changed the `CustomerType` interface so that it now extends the `EnumInterface`
- BC: Added the following methods to the Customer interface:
  - `addresses()`
  - `hasDefaultBillingAddress()`
  - `hasDefaultShippingAddress()`
  - `defaultBillingAddress()`
  - `defaultShippingAddress()`
  - `setDefaultShippingAddress()`
  - `setDefaultBillingAddress()`
- BC: Changed the `Address::addresses()` method from `BelongsToMany` to `MorphToMany` - the two are very compatible, but aren't the same
- Dropped the `customer_addresses` table in favor of the Address module's `model()` polymorphic properties (migration included)
- Dropped Laravel 9 support
- Dropped PHP 8.0 support
- Fixed a possible type error in the `Customer::getName()` method
- Added the `default_billing_address_id` and the `default_shipping_address_id` fields to the customer table/model
- Added the registration of `customer` to the relation morph map
- Added PHP 8.3 support
- Added Laravel 11 support
- Changed minimum version requirements to:
    - Enum v4.1
    - Address v3.0
    - Doctrine DBAL v3.5.1/v4.0

## 2.4.1
##### 2023-12-17

- Added PHP 8.3 support

## 2.4.0
##### 2023-02-17

- Added Laravel 10 support
- Dropped Laravel 8 support

## 2.3.1
##### 2022-03-24

- Fixed `down()` method of the migration added in 2.3.0 when running against an SQLite engine

## 2.3.0
##### 2022-03-15

- Added optional `timezone` field to customers
- Added `currency` field to customers table
- Added `ltv` (Customer Lifetime Value) field to customers table
- Added traits for composing models that belong to a customer

## 2.2.0
##### 2022-03-10

- Added Enum v4 support
- Added Laravel 9 support
- Dropped PHP 7.3 & 7.4 support
- Dropped Laravel 6 & 7 support
- Changed minimum Laravel version to 8.22.1, to enforce the [CVE-2021-21263](https://blog.laravel.com/security-laravel-62011-7302-8221-released) security patch
- Changed CI from Travis to Github Actions

## 2.1.0
##### 2020-12-07

- Added PHP 8 support

## 2.0.1
##### 2020-10-11

- Fixed (slightly) invalid dependency versions in composer.json

## 2.0.0
##### 2020-10-11

- BC: return type hints have been added to the interfaces
- BC: Enums have been upgraded to v3
- Added Laravel 8 support
- Dropped Laravel 5 support
- Dropped PHP 7.2 support

### 1.2.0
##### 2020-03-14

- Added Laravel 7 support
- Added PHP 7.4 support
- Dropped PHP 7.1 support
- Minimum required Concord version is 1.5+

### 1.1.0
##### 2019-11-23

- Added Laravel 6 support
- Removed Laravel 5.4 support
- Minimum required Concord version is 1.4+

### 1.0.0
##### 2019-08-17

- Removed PHP 7.0 support
- Added PHP 7.3 support
- Minimum Address module version is 1.0.1
- Stability fixes

## 0.9

### 0.9.6
##### 2018-11-01

- Added `last_purchase_at` field to customers table
- Minimum Concord version requirement is 1.0
- Fixed model events incompatibility with Laravel 5.5+
- Tested up to Laravel v5.7

### 0.9.5
##### 2018-01-10

- The calculated Name can be accessed as property as well

### 0.9.4
##### 2017-12-11

- Dependency updates
- Readme fixes


### 0.9.3
##### 2017-11-26

- Client Module has been forked into Customer
- Everything has been renamed from **_Client_ -> Customer**
- Customer is no longer a composite object of `Person` and `Organization`
- Customer is now stored in a single table, and no longer contains the
  following fields:
    - birthdate
    - gender
    - nin
    - nameorder
- Nameorder and gender support has been dropped (so far)

### 0.9.2
##### 2017-11-25

- Client factory methods have been added for creating client objects
  without saving them to the db


### 0.9.1
##### 2017-11-25

- Common fields (name, email, phone) can be set directly on client


### 0.9.0
##### 2017-11-24

- Changelog and versioning has been started
