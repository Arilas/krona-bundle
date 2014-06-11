<?php
/**
 * User: krona
 * Date: 6/11/14
 * Time: 6:31 AM
 */

namespace Arilas\KronaBundle\Mapping;

use Arilas\KronaBundle\Mapping\Converter\AutoWiredConverter;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class AutoWired
 * @package Arilas\KronaBundle\Mapping
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 */
class AutoWired implements AnnotationInterface
{
    const CONVERTER = AutoWiredConverter::class;
    /**
     * Service name or Class Name
     * @var string
     */
    protected $type;

    public function __construct($value)
    {
        if (isset($value['type'])) {
            $this->type = $value['type'];
        } else {
            $this->type = $value['value'];
        }
    }

    public function getType()
    {
        return $this->type;
    }

    public function getConverterClassName()
    {
        return static::CONVERTER;
    }
} 