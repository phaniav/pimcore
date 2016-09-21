# Areablock

## General 

The areablock is the content construction kit for documents offered by pimcore.
The concept is like you know it already from the block element. 
The difference is that you can insert predefined **mini applications** called bricks into an areablock.

![Admin panel preview 1](../../../img/areablock_editmode1.png)

![Admin panel preview 2](../../../img/areablock_editmode2.png)

## Integrate an areablock in a template
Similar to the other document editables, an areablock can be integrated in any document view template as follows:

```php
<?php echo $this->areablock('myAreablock'); ?>
```

Advanced usage with allowed areas, below:

```php

<?php echo $this->areablock("myAreablock", [
    "allowed" => ["iframe","googletagcloud","spacer","rssreader"],
    "group" => [
        "First Group" => ["iframe", "spacer"],
        "Second Group" => ["rssreader"]
    ],
    "areablock_toolbar" => [
        "title" => "",
        "width" => 230,
        "x" => 20,
        "y" => 50,
        "xAlign" => "right",
        "buttonWidth" => 218,
        "buttonMaxCharacters" => 35
    ],
    "params" => [
        "iframe" => [ // some additional parameters / configuration for the brick type "iframe"
            "parameter1" => "value1",
            "parameter2" => "value2"
        ],
        "googletagcloud" => [ // additional parameter for the brick type "googletagcloud"
            "param1" => "value1"
        ]
    ]]);
?>
```

Have a look, how you can access parameters from the brick file:

```php
//use the value of parameter named "param1" for this brick
echo $this->param1;
```

Sorting items in the toolbar: 

```php
echo  $this->areablock("content", [
    'allowed' => ['image', 'video', 'wysiwyg'],
    'sorting' => ['wysiwyg', 'image', 'video']
]); 
```

And you can see the effect, below:

![Admin panel preview - sroting areablocks](../../../img/areablock_editmode3.png)

## Configuration

| Name              | Type   | Description                                                                                                                                                                                  |
|-------------------|--------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| allowed           | array  | An array of area-ID's which are allowed for this tag. The order of items in the array is also used as the default sorting, but of course you can combine this configuration with **sorting** |
| sorting           | array  | An array of area-ID's in the order you want to display them in the toolbar.                                                                                                                  |
| params            | array  | Optional Parameter, this can also contain additional brick-specific configurations, see **brick-specific configuration**                                                                     |
| group             | array  | Array with group configuration (see example above).                                                                                                                                          |
| manual            | bool   | forces the manual mode, which enables a complete free implementation for areablocks, for example using real `<table>` elements... example see below                                      |
| reload            | bool   | set to true, to force a reload in editmode after reordering items (default: **false**)                                                                                                       |
| toolbar           | bool   | set to false to not display the extra toolbar for areablocks (default: **true**)                                                                                                             |
| dontCheckEnabled  | bool   | set to true to display all installed area bricks, regardless if they are enabled in the extension manager                                                                                    |
| limit             | int    | limit the amount of elements                                                                                                                                                                 |
| areablock_toolbar | array  | Array with option that allows you to change the position of the toolbar.                                                                                                                     |
| areaDir           | string | absolute path (from document-root) to an area directory, only areas out of this path will be shown eg. `/website/views/customAreas/`                                                     |
| editWidth         | int    | Width of editing popup (if dedicated `edit.php` is used).                                                                                                                                |
| editHeight        | int    | Height of editing popup (if dedicated `edit.php` is used).                                                                                                                               |

## Brick-specific configuration
Brick-specific configurations are passed using the params configuration (see above). 

| Name            | Type | Description                                                                                                                                                     |
|-----------------|------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------|
| forceEditInView | bool | if a brick contains an edit.php there's no editmode for the `view.php` file, if you want to have the editmode enabled in both templates, enable this option |

Example: 

```php
<?php echo $this->areablock("myArea", [
    "params" => [
        "my_brick" => ["forceEditInView" => true]
    ]
]); ?>
```
## Methods

| Name                    | Description                                                                            |
|-------------------------|----------------------------------------------------------------------------------------|
| `getCount()`        | total count of blocks                                                                  |
| `getCurrent()`      | current number of block (useful with area bricks)                                      |
| `getCurrentIndex()` | get the current index (index is different from position, as you can move block around) |
| `getElement()`      | get an element out of an areabrick                                                     |
| `renderIndex()`     | renders only one specific block within the areablock                                   |

## How to create bricks for the areablock

You can read about **bricks** in the [Bricks](./02_Bricks.md) section.

## Using manual mode

The manual mode offers you the possibility to deal with areablocks the way you like, this is for example useful with tables: 

```php
<?php $areaBlock = $this->areablock("myArea", ["manual" => true])->start(); ?>
<table>
    <?php while ($areaBlock->loop()) { ?>
        <?php $areaBlock->blockConstruct(); ?>
            <tr>
                <td>
                    <?php $areaBlock->blockStart(); ?>
                    <?php $areaBlock->content(); ?>
                    <?php $areaBlock->blockEnd(); ?>
                </td>
            </tr>
        <?php $areaBlock->blockDestruct(); ?>
    <?php } ?>
</table>
<?php $areaBlock->end(); ?>
```