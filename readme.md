# Product list field type

`productlist` is a custom field type for selecting products from the official Perch Shop app.


## Installation

Download and place the `productlist` folder in `perch/addons/fieldtypes`.


## Example usage

```
<perch:shop id="accessories" type="productlist" label="Accessories" suppress="true" />
```

```
<?php
    $product = perch_shop_product(perch_get('s'), ['skip-template'=> true]);

    if(is_array($product)) {
        $accessories = $product[0]['accessories'];
        $accessory_slugs = implode(',', $accessories);
    }

    perch_shop_products([
        'template' => 'products/list',
        'filter' => 'productSlug',
        'match' => 'in',
        'value' => $accessory_slugs,
    ]);
?>
```