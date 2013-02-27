<?php
namespace FooForms;
require_once 'fooformfactory.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Foo Form Factory Test</title>
<link rel="stylesheet" type="text/css" href="test.css" />
</head>
<body>
<ol>
<li>
<?php echo FooFormFactory::getField('FooForms', 'Test field', 0, 'Test text', "", true, 'texttest', 'texttest'); ?>
</li>
<li>
<?php echo FooFormFactory::getField('FooForms', 'Test area', 1, 'Test text', "", false, 'areatest', 'areatest'); ?>
</li>
<li>
<?php echo FooFormFactory::getField('FooForms', 'Test radiogroup', 2, 'baz', "foo\nbar\nbaz", false, 'radiotest', 'radiotest'); ?>
</li>
<li>
<?php echo FooFormFactory::getField('FooForms', 'Test select', 3, 'quux', "qux\nquux\nquuux", false, 'selecttest', 'selecttest'); ?>
</li>
<li>
<?php echo FooFormFactory::getField('FooForms', 'Do it!', 4, true, "", false, 'checktest', 'checktest'); ?>
</li>
<li>
<?php echo FooFormFactory::getField('FooForms', 'Select many!', 5, "bananas", "apples\nbananas\npears\noranges", false, 'multiselecttest', 'multiselecttest'); ?>
</li>
</ol>
<table>
<tr>
<td>
<?php echo FooFormFactory::getField('Backend', 'Backend field', 0, 'Backend test', "", false, 'backendtest', 'backendtest'); ?>
</td>
</tr>
</table>
</body>
</html>