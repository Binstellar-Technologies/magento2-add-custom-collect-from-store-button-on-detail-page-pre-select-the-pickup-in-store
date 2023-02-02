## Magento2 Add custom Collect from Store button on detail page & pre-select the Pickup in store

> Magento2 how to add a custom Collect from Store(Add to cart) button on product details page & when a user clicks on it & goes to checkout Pick up in store is pre-select.

> Please make sure Pick up Instore is ON.

## Installation Steps

Step 1 : Download the Zip file from Github & Unzip it
Step 2 : Create a directory under app/code/Binstellar/CollectfromStore
Step 3 : Upload the files & folders from extracted package to app/code/Binstellar/CollectfromStore
Step 4 : Go to the Magento2 Root directory & run following commands

php bin/magento setup:upgrade 
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
php bin/magento cache:flush


## Note : We have tested this option in Magento ver. 2.4.5-p1