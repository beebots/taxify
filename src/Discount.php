<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/23/15
 * Time: 7:55 AM
 */

namespace rk\Taxify;

class Discount
{

    /** @var int The sort order of this discount */
    private $order;
    /** @var string The discount code */
    private $code;
    /** @var float The value of this discount in dollars */
    private $amount;
    /** @var string Unknown use */
    private $discount_type;

    public function __construct(int $order = 0, string $code = '', float $amount = 0, string $discount_type = '')
    {
        $this
            ->setOrder($order)
            ->setCode($code)
            ->setAmount($amount)
            ->setDiscountType($discount_type);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'Discount' => [
                'Order'        => $this->order,
                'Code'         => $this->code,
                'Amount'       => $this->amount,
                'DiscountType' => $this->discount_type,
            ],
        ];
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount ?? 0.0;
    }

    public function setAmount(float $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDiscountType(): string
    {
        return $this->discount_type;
    }

    public function setDiscountType(string $discount_type)
    {
        $this->discount_type = $discount_type;

        return $this;
    }
}