# Overview

This module was designed to provide with some boilerplate models by handling customers.
It uses the [Address](https://konekt.dev/address) and [User](https://konekt.dev/user) modules,
and offers composite models based on those.

Customers in business applications are organized in several ways, and this module was designed to
provide with the parts, so you can use them the way you want.

The "parts" are the following:

- **user** (from Laravel): someone or something who can log in to the application.
- **person**: a human being.
- **organization**: company, foundation, NGO, etc.
- **customer**: a person or organization who buys goods or services.
- **address**:  location of a building, apartment, post box, etc.

So yes, there's an overlap between these, and based on your app's logic it's OK to ignore some
models and/or fields. You can even create a migration to drop the unused fields from your DB schema.

## Simple Scenario

The basic idea is that in case one wants a simple customer management without complication, then all
the fields are available in the `Customer` model.

## Advanced Scenario

There are cases where a customer can have multiple subordinate organizations and/or persons.

### Example 1 - Billing Application

A customer (`Customer`) represents a person who controls several companies (each is an `Organization`)
each having their own business `Address` that shows on the "Bill From" field of an Invoice. The
customer can use these companies, but from the business perspective he/she is still a single
customer.

### Example 2 - Helpdesk

The customer (`Customer`) represents a company, and it has multiple contact persons (each is a `Person`).
The firstname/lastname in the customer model *may* represent the primary contact for that company.

### Example 3 - Simple Webshop

The customer (`Customer`) represents either a company or a person and it can have one shipping
address (`Address`) and one billing address (`Address`).

### Example 4 - Advanced Webshop

A user (`User`) represents a person who can have multiple billing and shipping "addresses". Each of
these "addresses" are composed of a `Person` or `Organization` and an `Address`. The `Customer`
entity can be used as a "glue" between them.

## Summary

There are quite several variations, so there's no one size fits all solution.
The library's intent is to make some ready to use components and leave the composition to the
application developer.. you :)
