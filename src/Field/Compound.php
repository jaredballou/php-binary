<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;

use Binary\Field\Property\Property;
use Binary\Stream\StreamInterface;
use Binary\DataSet;

/**
 * Compound
 * A field that can comprise a number of fields.
 *
 * @since 1.0
 */
class Compound implements FieldInterface
{
    /**
     * @protected array The fields enclosed within this compound field.
     */
    protected $fields = array();

    /**
     * @public string The name of the field.
     */
    public $name = '';

    /**
     * @public integer The number of times this field will be repeated.
     */
    public $count = 1;

    /**
     * @param int $count The number of times this compound field is repeated.
     *
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = new Property($count);

        return $this;
    }

    /**
     * @param FieldInterface $field The field to add to the compound field.
     *
     * @return $this
     */
    public function addField(FieldInterface $field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function read(StreamInterface $stream, DataSet $result)
    {
        $result->push($this->name);
        $count = isset($this->count) ? $this->count->get($result) : 1;

        // Read this compound field $count times
        for ($iteration = 0; $iteration < $count; $iteration ++) {
            $result->push($iteration);

            foreach ($this->fields as $field) {
                $field->read($stream, $result);
            }

            $result->pop();
        }

        $result->pop();
    }

    /**
     * {@inheritdoc}
     */
    public function write(StreamInterface $stream, DataSet $result)
    {
        $result->push($this->name);
        $count = isset($this->count) ? $this->count->get($result) : 1;

        // Read this compound field $count times
        for ($iteration = 0; $iteration < $count; $iteration ++) {
            $result->push($iteration);

            foreach ($this->fields as $field) {
                $field->write($stream, $result);
            }

            $result->pop();
        }

        $result->pop();
    }
}
