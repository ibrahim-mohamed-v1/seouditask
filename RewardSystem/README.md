# Reward Point Extension

## Overview

- Once customer purchases any paid product, they get discount in the form of reward points which can be redeemed on next checkout
- Admin can set reward points for individual product
- Customer can share product link on social media and based on successful sharing, customer will get 2 reward points
- link video : https://youtu.be/ElsMH1wJFgg
## Features

- reward point system to give customers loyality to store as getting point over purchase from the store which can be used in the future on checkout page to get discount 

## Installation


## Configuration

### Store Configuration

The module adds a new section under `System > Configuration > Seoudi > Reward System` where you can set the reward point to be enable and the value for each 1 reward point , max of reward point per customer , and also max reward point can be used on single checkout .
## Installation

1. Create a directory `Seoudi/RewardSystem` inside `app/code` if it doesn't exist..
3. Run  `bin/magento module:enable Seoudi_RewardSystem`.
4. Run `bin/magento setup:di:compile`.
5. Run `bin/magento cache:clean`.
