<?php
/**
 * Form Factory Library
 *
 * PHP Version 5
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @copyright  2011 WAY Media Inc.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version    SVN: $Id: formFactory.php 296 2011-11-08 21:08:58Z alexander $
 * @link       http://www.wayfm.com
 */

namespace FooForms;

/**
 * Frontend Input Factory
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class FooFormFactory
{
   /**
    * Returns a field object of appropriate type
    *
    * @param string $namespace Namespace
    * @param string $label     Label
    * @param int    $type      Type
    * @param string $value     Default value
    * @param string $options   Options, newline delineated
    * @param bool   $required  Item is required
    * @param string $name      Name of field
    * @param string $cssid     CSS id
    * @param string $cssclass  CSS class
    * @param bool   $disabled  Item is disabled
    *
    * @access public
    * @return object Field
    * @static
    */
   static public function getField(
       $namespace, $label, $type, $value, $options = '', $required = false,
       $name = '', $cssid = '', $cssclass = '', $disabled = false
   ) {
       $object = ucwords($namespace) . "\\" . ucwords(self::_getType($type))
           . 'Input';
       $field = new $object(
           $label, self::_getType($type), htmlentities($value, ENT_COMPAT, 'UTF-8'), $options, $required, $name, $cssid, $cssclass,
           $disabled
       );
       return $field;
   }
   
   /**
    * Get type name from type ID
    *
    * @param int $type Field type id
    *
    * @access private
    * @return string
    */
   static private function _getType($type)
   {
       switch ($type) {
       case 0:
           $type = 'text';
           break;
           
       case 1:
           $type = 'textarea';
           break;
           
       case 2:
           $type = 'radiogroup';
           break;
           
       case 3:
           $type = 'select';
           break;
           
       case 4:
           $type = 'checkbox';
           break;
           
       case 5:
           $type = 'multiselect';
           break;
           
       case 6:
           $type = 'file';
           break;
           
       case 7:
           $type = 'hidden';
           break;
           
       case 8:
           $type = 'password';
           break;
           
       case 9:
           $type = 'image';
           break;
           
       case 10:
           $type = 'reset';
           break;
           
       case 11:
           $type = 'button';
           break;
           
       case 12:
           $type = 'submit';
           break;
           
       case 13:
           $type = 'radio';
           break;
           
       case 14:
           $type = 'option';
           break;
           
       default:
           $type = 'text';
           break;
       }
       return $type;
   }
}

/**
 * FooForms Abstract Input class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
abstract class Input
{
   /**
    * Display output
    * @var string $_output Output for display
    */
   private $_output;
   
   /**
    * Field name
    * @var string $name Name of field
    */
   protected $name;
   
   /**
    * CSS id
    * @var string CSS id
    */
   protected $id;
   
   /**
    * CSS id
    * @var string CSS id
    */
   protected $class;
   
   /**
    * Label
    * @var string Label
    */
   protected $label;
   
   /**
    * Default value
    * @var string Default Value
    */
   protected $value;
   
   /**
    * Disabled
    * @var bool Disabled
    */
   protected $disabled;
   
   /**
    * Type
    * @var string Type
    */
   protected $type;

   /**
    * Constructor for Input class
    *
    * @param string $label    Label
    * @param string $type     Type
    * @param string $value    Default value
    * @param string $options  Options, newline delineated
    * @param bool   $required Item is required
    * @param string $name     Name of field
    * @param string $cssid    CSS id
    * @param string $cssclass CSS class
    * @param bool   $disabled Item is disabled
    *
    * @access public
    * @return void
    */
   public function __construct(
       $label, $type, $value, $options, $required, $name, $cssid, $cssclass,
       $disabled
   ) {
       //Initialize instance variables...
       $this->label = $label;
       $this->type = $type;
       $this->value = $value;
       $this->name = $name;
       $this->id = $cssid;
       $this->class = $cssclass;
       $this->disabled = $disabled;
       
       //Which HTML tag do we use?
       switch ($this->type) {
       case 'textarea':
           $this->tag = 'textarea';
           break;
       case 'radiogroup':
           $this->tag = 'fieldset';
           break;
       case 'select':
       case 'multiselect':
           $this->tag = 'select';
           break;
       case 'option':
           $this->tag = 'option';
           break;
       default:
           $this->tag = 'input';
           break;
       }
       
       $this->value = $value;
   }
   
   /**
    * Get output when treated as string
    *
    * @access public
    * @return void
    */
   public function __toString()
   {
       return $this->display();
   }
   
   /**
    * Create an appropriate label
    *
    * @access protected
    * @return string label
    */
   protected function makeLabel()
   {
       $label = '<label for="' . $this->name . '">' . $this->label . '</label>';
       return $label;
   }
   
   /**
    * Make attributes for HTML tag
    *
    * @access protected
    * @return string attributes
    */
   protected function makeAttrs()
   {
       //name
       $attrs = ' name="' . $this->name . '"';
       //id
       $attrs .= $this->id ? ' id="' . $this->id . '"' : '';
       //class
       $attrs .= $this->class ? ' class="' . $this->class . '"' : '';
       //disabled
       $attrs .= $this->disabled == 1 ? ' disabled="disabled"' : '';
       
       return $attrs;
   }
   
   /**
    * Make contents of tag
    *
    * @access protected
    * @return string content
    */
   protected function makeContent()
   {
       //Input is a self-closing tag (no content)
       return '';
   }
   
   /**
    * Build the field with label
    *
    * @access public
    * @return string field
    */
   public function display()
   {
       if ($this->tag == 'input') {
           $typeparam = ' type="' . $this->type .'"';
           $value = $this->value ? ' value="' . $this->value . '"' : '';
           $tagclose = ' />';
       } else {
           $tagclose = '>' . $this->makeContent() . '</' . $this->tag . '>';
       }
       
       $attrs = $this->makeAttrs();
       
       $this->_output = $this->makeLabel() . '<' . $this->tag . $typeparam . $attrs
           . $value . $tagclose;
       
       return $this->_output;
   }
}

/**
* FooForms Abstract ComplexInput class
*
* @category   Components
* @package    Joomla
* @subpackage Foo_Form_Factory
* @author     Alexander Clark <aclark@wayfm.com>
* @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link       http://ww.wayfm.com
*/
abstract class ComplexInput extends Input
{
   /**
    * Array of child Inputs
    * @var array Child Input objects
    */
   protected $inputs = array();
   
   /**
    * Constructor for ComplexInput class
    *
    * @param string $label    Label
    * @param string $type     Type
    * @param string $value    Default value
    * @param string $options  Options, newline delineated
    * @param bool   $required Item is required
    * @param string $name     Name of field
    * @param string $cssid    CSS id
    * @param string $cssclass CSS class
    * @param bool   $disabled Item is disabled
    *
    * @access public
    * @return void
    */
   public function __construct(
       $label, $type, $value, $options, $required, $name, $cssid, $cssclass,
       $disabled
   ) {
       parent::__construct(
           $label, $type, $value, $options, $required, $name, $cssid, $cssclass,
           $disabled
       );
        
       $inputs = explode("\n", $options);
       
       switch ($this->type) {
       case 'radiogroup':
           $childType = 13;
           break;
       case 'select':
       case 'multiselect':
           $childType = 14;
           break;
       }
       
       foreach ($inputs as $input) {
           $field = \FooForms\FooFormFactory::getField(
               __NAMESPACE__, $input, $childType, html_entity_decode($value, ENT_COMPAT, 'UTF-8'), '', false,
               $name, '', '', $disabled
           );
           $this->addInput($field);
       }
   }
   
   /**
    * Add child Input
    *
    * @param Input $input Child to add
    *
    * @access public
    * @return void
    */
   public function addInput(Input $input)
   {
       $this->inputs[] = $input;
   }
   
   /**
    * Fill contents of tag with children
    *
    * @access protected
    * @return string content
    */
   public function makeContent()
   {
       foreach ($this->inputs as $input) {
           $content .= $input->display();
       }
       return $content;
   }
}

/**
 * FooForms Abstract LabelOnRightInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
abstract class LabelOnRightInput extends Input
{
   /**
    * Create a label without for attr
    *
    * @access protected
    * @return string label
    */
   protected function makeLabel()
   {
       $label = '<label>' . $this->label . '</label>';
       return $label;
   }
   
   /**
    * Build the field with label on the right
    *
    * @access public
    * @return string field
    */
   public function display()
   {
       $typeparam = ' type="' . $this->type .'"';
       $attrs = $this->makeAttrs();
       $value = $this->value ? ' value="' . $this->value . '"' : '';
           
       $this->output = '<input' . $typeparam . $attrs . $value . ' />'
           . $this->makeLabel();
       
       return $this->output;
   }
}

/**
 * FooForms TextInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class TextInput extends Input
{

}

/**
 * FooForms TextareaInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class TextareaInput extends Input
{
   
   /**
    * Make contents of tag
    *
    * @access protected
    * @return string content
    */
   protected function makeContent()
   {
       return $this->value;
   }
}

/**
 * FooForms RadioGroupInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class RadioGroupInput extends ComplexInput
{
   
   /**
    * Make attributes for HTML tag
    *
    * @access protected
    * @return string attributes
    */
   protected function makeAttrs()
   {
       //name is not valid for fieldset
       $attrs = '';
       //id
       $attrs .= $this->id ? ' id="' . $this->id . '"' : '';
       //class
       $attrs .= $this->class ? ' class="' . $this->class . '"' : '';
       //disabled is not valid for fieldset
       
       return $attrs;
   }
   
   /**
    * Make contents of tag
    *
    * @access protected
    * @return string content
    */
   public function makeContent()
   {
       $content = '<ol>';
       foreach ($this->inputs as $input) {
           $content .= '<li>' . $input->display() . '</li>';
       }
       $content .= '</ol>';
       return $content;
   }
}

/**
 * FooForms RadioInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class RadioInput extends LabelOnRightInput
{
   
   /**
    * Make attributes for HTML tag
    *
    * @access protected
    * @return string attributes
    */
   protected function makeAttrs()
   {
       //name
       $attrs = ' name="' . $this->name . '"';
       //checked
       $attrs .= html_entity_decode($this->value, ENT_COMPAT, 'UTF-8') == $this->label ? ' checked="checked"' : '';
       //disabled
       $attrs .= $this->disabled == 1 ? ' disabled="disabled"' : '';
       //value
       $attrs .= ' value="' . htmlentities($this->label, ENT_COMPAT, 'UTF-8') . '"';
       
       //Prevent duplicate (and incorrect) value param in LabelOnRightInput::display()
       $this->value = '';
       
       return $attrs;
   }
}

/**
 * FooForms SelectInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class SelectInput extends ComplexInput
{

}

/**
 * FooForms OptionInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class OptionInput extends Input
{
   
   /**
    * Create an appropriate label
    *
    * @access protected
    * @return string label
    */
   protected function makeLabel()
   {
       //Options don't have labels
       return '';
   }
   
   /**
    * Make attributes for HTML tag
    *
    * @access protected
    * @return string attributes
    * @todo   accept array of selected items for select list
    */
   protected function makeAttrs()
   {
       $attrs = html_entity_decode($this->value, ENT_COMPAT, 'UTF-8') == $this->label ? ' selected="selected"' : '';
       return $attrs;
   }
   
   /**
    * Make contents of tag
    *
    * @access protected
    * @return string content
    */
   protected function makeContent()
   {
       return $this->label;
   }
}

/**
 * FooForms CheckboxInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class CheckboxInput extends LabelOnRightInput
{
   
   /**
    * Build the field with label on the right
    *
    * @access public
    * @return string field
    */
   public function display()
   {
       $checked = ($this->value == 'true' || $this->value == '1')
           ? ' checked="checked"'
           : '';
       
       $attrs = $this->makeAttrs();
       
       $this->output = '<input type="checkbox"' . $attrs . $checked
           . ' /><label for="' . $this->name . '">' . $this->label . '</label>';
       return $this->output;
   }
}

/**
 * FooForms MultiselectInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class MultiselectInput extends SelectInput
{
   
   /**
    * Make attributes for HTML tag
    *
    * @access protected
    * @return string attributes
    */
   protected function makeAttrs()
   {
       $attrs = parent::makeAttrs();
       $attrs .= ' multiple="multiple"';
       return $attrs;
   }
}

/**
 * FooForms FileInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class FileInput extends Input
{
   
}

/**
 * FooForms HiddenInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class HiddenInput extends Input
{
   
   /**
    * Create an appropriate label
    *
    * @access protected
    * @return string label
    */
   protected function makeLabel()
   {
       //no label for hidden inputs
       return '';
   }
}

/**
 * FooForms PasswordInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class PasswordInput extends Input
{
   
}

/**
 * FooForms ImageInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class ImageInput extends Input
{
   
   /**
    * Create an appropriate label
    *
    * @access protected
    * @return string label
    */
   protected function makeLabel()
   {
       //No label for image inputs
       return '';
   }
   
   /**
    * Make attributes for HTML tag
    *
    * @access protected
    * @return string attributes
    */
   protected function makeAttrs()
   {
       $attrs = ' src="' . $this->value . '"';
       $attrs .= ' alt="' . $this->label . '"';
       $attrs .= parent::makeAttrs();
       
       return $attrs;
   }
   
   /**
    * Build the field without label
    *
    * @access public
    * @return string field
    */
   public function display()
   {
       $output = '<input type="image"' . $this->makeAttrs() . ' />';
       return $output;
   }
}

/**
 * FooForms ButtonInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class ButtonInput extends Input
{
   
   /**
    * Create an appropriate label
    *
    * @access protected
    * @return string label
    */
   protected function makeLabel()
   {
       //Buttons have built-in labels
       return '';
   }
   
   /**
    * Make contents of tag
    *
    * @access protected
    * @return string content
    */
   protected function makeContent()
   {
       return $this->label;
   }
}

/**
 * FooForms SubmitInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class SubmitInput extends Input
{
   
   /**
    * Create an appropriate label
    *
    * @access protected
    * @return string label
    */
   protected function makeLabel()
   {
       //Buttons have built-in labels
       return '';
   }
   
   /**
    * Make contents of tag
    *
    * @access protected
    * @return string content
    */
   protected function makeContent()
   {
       return $this->label;
   }
}

namespace Backend;

/**
 * Abstract Backend Input class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
abstract class Input extends \FooForms\Input
{
   /**
    * Create a label with edit class
    *
    * @access protected
    * @return string label
    */
   protected function makeLabel()
   {
       $label = '<label class="edit">' . $this->label . '</label></td><td>';
       return $label;
   }
}

/**
 * Abstract Backend ComplexInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
abstract class ComplexInput extends \FooForms\ComplexInput
{
   /**
    * Create a label with edit class
    *
    * @access protected
    * @return string label
    */
   protected function makeLabel()
   {
       $label = '<label class="edit">' . $this->label . '</label></td><td>';
       return $label;
   }
}

/**
 * Backend TextInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class TextInput extends Input
{

}

/**
 * Backend TextareaInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class TextareaInput extends Input
{
   /**
    * Make contents of tag
    *
    * @access protected
    * @return string content
    */
   protected function makeContent()
   {
       return $this->value;
   }
}

/**
 * Backend RadiogroupInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class RadiogroupInput extends ComplexInput
{
   
   /**
    * Make attributes for HTML tag
    *
    * @access protected
    * @return string attributes
    * @todo   label for must have matching input id - write makeLabel()
    */
   protected function makeAttrs()
   {
       //name is not a valid attr for fieldset
       $attrs = '';
       //id
       $attrs .= $this->id ? ' id="' . $this->id . '"' : '';
       //class
       $attrs .= $this->class ? ' class="' . $this->class . '"' : '';
       //disabled is not a valid attr for fieldset
       
       return $attrs;
   }
   
   /**
    * Make contents of tag
    *
    * @access protected
    * @return string content
    */    
   public function makeContent()
   {
       $content = '<ol>';
       foreach ($this->inputs as $input) {
           $content .= '<li>' . $input->display() . '</li>';
       }
       $content .= '</ol>';
       return $content;
   }
}

/**
 * Backend RadioInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class RadioInput extends \FooForms\LabelOnRightInput
{
   
   /**
    * Make attributes for HTML tag
    *
    * @access protected
    * @return string attributes
    */
   protected function makeAttrs()
   {
       //name
       $attrs = ' name="' . $this->name . '"';
       //checked
       $attrs .= $this->value == $this->label ? ' checked="checked"' : '';
       //disabled
       $attrs .= $this->disabled == 1 ? ' disabled="disabled"' : '';
       
       return $attrs;
   }
}

/**
 * Backend SelectInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class SelectInput extends ComplexInput
{

}

/**
 * Backend OptionInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class OptionInput extends \FooForms\Input
{
   
   /**
    * Create an appropriate label
    *
    * @access protected
    * @return string label
    */
   protected function makeLabel()
   {
       //Options don't have labels
       return '';
   }
   
   /**
    * Make attributes for HTML tag
    *
    * @access protected
    * @return string attributes
    */
   protected function makeAttrs()
   {
       $attrs = $this->value == $this->label ? ' selected="selected"' : '';
       return $attrs;
   }
   
   /**
    * Make contents of tag
    *
    * @access protected
    * @return string content
    */
   public function makeContent()
   {
       return $this->label;
   }
}

/**
 * Backend CheckboxInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class CheckboxInput extends \FooForms\LabelOnRightInput
{
   
   /**
    * Build the field with label on the right
    *
    * @access public
    * @return string field
    */
   public function display()
   {
       $this->output = '<label class="edit">' . $this->label . '</label></td><td>'
           . parent::display();
       return $this->output;
   }
}

/**
 * Backend MultiselectInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class MultiselectInput extends SelectInput
{
   
   /**
    * Make attributes for HTML tag
    *
    * @access protected
    * @return string attributes
    */
   protected function makeAttrs()
   {
       $attrs = parent::makeAttrs();
       $attrs .= ' multiple="multiple"';
       return $attrs;
   }
}

/**
 * Backend FileInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class FileInput extends Input
{
   
}

/**
 * Backend HiddenInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class HiddenInput extends Input
{
   
}

/**
 * Backend PasswordInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class PasswordInput extends Input
{
   
}

/**
 * Backend ImageInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class ImageInput extends Input
{
   
   /**
    * Make attributes for HTML tag
    *
    * @access protected
    * @return string attributes
    */
   protected function makeAttrs()
   {
       $attrs = ' src="' . $this->value . '"';
       $attrs .= ' alt="' . $this->label . '"';
       $attrs .= parent::makeAttrs();
       
       return $attrs;
   }
}

/**
 * Backend ButtonInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class ButtonInput extends Input
{
   
   /**
    * Make contents of tag
    *
    * @access protected
    * @return string content
    */
   protected function makeContent()
   {
       return $this->label;
   }
}

/**
 * Backend SubmitInput class
 *
 * @category   Components
 * @package    Joomla
 * @subpackage Foo_Form_Factory
 * @author     Alexander Clark <aclark@wayfm.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://ww.wayfm.com
 */
class SubmitInput extends Input
{
   
   /**
    * Make contents of tag
    *
    * @access protected
    * @return string content
    */
   protected function makeContent()
   {
       return $this->label;
   }
}
?>
