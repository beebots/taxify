<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 1:52 PM
 */

namespace rk\Taxify;

class Code extends StringEntity
{

    /** You account codes may be different, these are just the defaults */
    public const CODE_CLOTHING = 'CLOTHING';
    public const CODE_FOOD     = 'FOOD';
    public const CODE_FREIGHT  = 'FREIGHT';
    public const CODE_NONTAX   = 'NONTAX';
    public const CODE_TAXABLE  = 'TAXABLE';
    public const CODE_WINE     = 'WINE';

}