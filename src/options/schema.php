<?php
/**
 * File containing the ezcDbSchemaOptions class
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for charts
 *
 * @property string $tableClassName
 *                  The objects that are returned for each table are of this
 *                  class, it needs to extend from the ezcDbSchemaTable struct.
 * @property string $fieldClassName
 *                  The objects that are returned for each field are of this
 *                  class, it needs to extend from the ezcDbSchemaField struct.
 * @property string $indexClassName
 *                  The objects that are returned for each index are of this
 *                  class, it needs to extend from the ezcDbSchemaIndex struct.
 * @property string $indexFieldClassName
 *                  The objects that are returned for each index field are of
 *                  this class, it needs to extend from the
 *                  ezcDbSchemaIndexField struct.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaOptions extends ezcBaseOptions
{
    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->properties['tableClassName'] = 'ezcDbSchemaTable';
        $this->properties['fieldClassName'] = 'ezcDbSchemaField';
        $this->properties['indexClassName'] = 'ezcDbSchemaIndex';
        $this->properties['indexFieldClassName'] = 'ezcDbSchemaIndexField';
        parent::__construct( $options );
    }

    /**
     * Set an option value
     * 
     * @param string $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBasePropertyNotFoundException
     *         If a property is not defined in this class
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        $parentClassMap = array(
            'tableClassName' => 'ezcDbSchemaTable',
            'fieldClassName' => 'ezcDbSchemaField',
            'indexClassName' => 'ezcDbSchemaIndex',
            'indexFieldClassName' => 'ezcDbSchemaIndexField',
        );
        switch ( $propertyName )
        {
            case 'tableClassName':
            case 'fieldClassName':
            case 'indexClassName':
            case 'indexFieldClassName':
                if ( !is_string( $propertyValue ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'string that contains a class name' );
                }

                // Check if the passed classname actually implements the
                // correct parent class. We have to do that with reflection
                // here unfortunately
                $parentClass = new ReflectionClass( $parentClassMap[$propertyName] );
                $handlerClass = new ReflectionClass( $propertyValue );
                if ( $parentClassMap[$propertyName] !== $propertyValue && !$handlerClass->isSubclassOf( $parentClass ) )
                {
                    throw new ezcDbSchemaInvalidParentClassException( $parentClassMap[$propertyName], $propertyValue );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }
}

?>