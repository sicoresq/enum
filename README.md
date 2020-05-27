# Enum
Class emulating `enum` type known from other languages, e.g. Java.
It works like SplEnum but it's more convenient.

## Usage

```php

use Sicoresq\Enum\Enum;

/**
 * @method static MyEnum EXAMPLE_1()
 * @method static MyEnum EXAMPLE_2()
*/
class MyEnum extends Enum
{
    public const EXAMPLE_1 = 'EXAMPLE_1';       
    public const EXAMPLE_2 = 'EXAMPLE_2';       
}

$myEnum1 = MyEnum::EXAMPLE_1();
$myEnum2 = new MyEnum(MyEnum::EXAMPLE_2);

```

PhpDoc is used only to support autocompletion.

### Other features

Check if Enum has value:

```php

MyEnum::hasValue('abc');

```

Get all values as Enum objects:

```php

MyEnum::getAll();

```


Get all values as constants list:

```php

MyEnum::getConstList();
```
