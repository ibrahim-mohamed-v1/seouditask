# Graphql Extend Module

## Overview

Add a field to the Root Query in Magento GraphQL API called isLoggedIn. The field should return a Boolean depending on if the customer is logged in or not.

Add a new configuration field in the store configuration. This field should be returned in the storeConfig Magento GraphQL query.

- video link : https://youtu.be/5X7Rc2ZSDqE
## Features

- Add a field to the Root Query in Magento GraphQL API called isLoggedIn. The field should return a Boolean depending on if the customer is logged in or not.

- Add a new configuration field in the store configuration. This field should be returned in the storeConfig Magento GraphQL query.


## Installation


## Usage

### GraphQL Queries

#### IsLoggedIn:

```graphql
{
  isLoggedIn
}
```
## Configuration

### Store Configuration

The module adds a new section under `System > Configuration > General > Seoudi Configuration` named "Custom Login Configuration," where you can configure the "Config Field." You can edit the custom field value based on your requirements.
## Installation

1. Create a directory `Seoudi/GraphqlExtend` inside `app/code` if it doesn't exist..
3. Run  `bin/magento module:enable Seoudi_GraphqlExtend`.
4. Run `bin/magento setup:di:compile`.
5. Run `bin/magento cache:clean`.
