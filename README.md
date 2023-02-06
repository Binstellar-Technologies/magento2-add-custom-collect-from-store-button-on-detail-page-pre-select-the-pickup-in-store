## Magento2 Add custom Collect from Store button on detail page & pre-select the Pickup in store

> Magento2 how to add a custom Collect from Store(Add to cart) button on product details page & when a user clicks on it & goes to checkout Pick up in store is pre-select.

> Please make sure Pick up Instore is ON.

## Installation Steps

##### Step 1 : Download the Zip file from Github & Unzip it
##### Step 2 : Create a directory under app/code/Binstellar/CollectfromStore
##### Step 3 : Upload the files & folders from extracted package to app/code/Binstellar/CollectfromStore
##### Step 4 : Go to the Magento2 Root directory & run following commands

php bin/magento setup:upgrade 

php bin/magento setup:di:compile

php bin/magento setup:static-content:deploy -f

php bin/magento cache:flush

&nbsp;
&nbsp;

##### Product Details Page Display Collect From Store Button
<kbd>

![image3](https://user-images.githubusercontent.com/123800304/216258059-2438f83b-02b8-4ba6-9645-c9a11cdd3dff.png)

</kbd>

&nbsp;
&nbsp;

##### Admin Store Configuration Added Option To Change Collect From Store Button Text
<kbd>

![image2](https://user-images.githubusercontent.com/123800304/216258532-434333c2-079b-41d9-b595-12538e567c33.png)

</kbd>

&nbsp;
&nbsp;

##### Checkout Page Default Select Pickup In Store

<kbd>

![image1](https://user-images.githubusercontent.com/123800304/216258732-aee124d4-876e-4aa9-9bdf-268a92f5f9c6.png)

</kbd>


&nbsp;
&nbsp;

## Note : We have tested this option in Magento ver. 2.4.5-p1
