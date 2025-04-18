<?php

// File generated from our OpenAPI spec

namespace Stripe;

/**
 * Invoice Line Items represent the individual lines within an <a href="https://stripe.com/docs/api/invoices">invoice</a> and only exist within the context of an invoice.
 *
 * Each line item is backed by either an <a href="https://stripe.com/docs/api/invoiceitems">invoice item</a> or a <a href="https://stripe.com/docs/api/subscription_items">subscription item</a>.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property int $amount The amount, in cents (or local equivalent).
 * @property null|int $amount_excluding_tax The integer amount in cents (or local equivalent) representing the amount for this line item, excluding all tax and discounts.
 * @property string $currency Three-letter <a href="https://www.iso.org/iso-4217-currency-codes.html">ISO currency code</a>, in lowercase. Must be a <a href="https://stripe.com/docs/currencies">supported currency</a>.
 * @property null|string $description An arbitrary string attached to the object. Often useful for displaying to users.
 * @property null|((object{amount: int, discount: Discount|string}&\stdClass&StripeObject))[] $discount_amounts The amount of discount calculated per discount for this line item.
 * @property bool $discountable If true, discounts will apply to this line item. Always false for prorations.
 * @property (Discount|string)[] $discounts The discounts applied to the invoice line item. Line item discounts are applied before invoice discounts. Use <code>expand[]=discounts</code> to expand each discount.
 * @property null|string $invoice The ID of the invoice that contains this line item.
 * @property null|InvoiceItem|string $invoice_item The ID of the <a href="https://stripe.com/docs/api/invoiceitems">invoice item</a> associated with this line item if any.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property null|((object{amount: int, margin: Margin|string}&\stdClass&StripeObject))[] $margin_amounts The amount of margin calculated per margin for this line item.
 * @property null|(Margin|string)[] $margins The margins applied to the line item. When set, the <code>default_margins</code> on the invoice do not apply to the line item. Use <code>expand[]=margins</code> to expand each margin.
 * @property StripeObject $metadata Set of <a href="https://stripe.com/docs/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format. Note that for line items with <code>type=subscription</code>, <code>metadata</code> reflects the current metadata from the subscription associated with the line item, unless the invoice line was directly updated with different metadata after creation.
 * @property (object{end: int, start: int}&\stdClass&StripeObject) $period
 * @property null|Plan $plan The plan of the subscription, if the line item is a subscription or a proration.
 * @property null|((object{amount: int, credit_balance_transaction?: null|Billing\CreditBalanceTransaction|string, discount?: Discount|string, margin?: Margin|string, type: string}&\stdClass&StripeObject))[] $pretax_credit_amounts Contains pretax credit amounts (ex: discount, credit grants, etc) that apply to this line item.
 * @property null|Price $price The price of the line item.
 * @property bool $proration Whether this is a proration.
 * @property null|(object{credited_items: null|(object{invoice: string, invoice_line_items: string[]}&\stdClass&StripeObject)}&\stdClass&StripeObject) $proration_details Additional details for proration line items
 * @property null|int $quantity The quantity of the subscription, if the line item is a subscription or a proration.
 * @property null|string|Subscription $subscription The subscription that the invoice item pertains to, if any.
 * @property null|string|SubscriptionItem $subscription_item The subscription item that generated this line item. Left empty if the line item is not an explicit result of a subscription.
 * @property ((object{amount: int, inclusive: bool, tax_rate: string|TaxRate, taxability_reason: null|string, taxable_amount: null|int}&\stdClass&StripeObject))[] $tax_amounts The amount of tax calculated per tax rate for this line item
 * @property TaxRate[] $tax_rates The tax rates which apply to the line item.
 * @property string $type A string identifying the type of the source of this line item, either an <code>invoiceitem</code> or a <code>subscription</code>.
 * @property null|string $unit_amount_excluding_tax The amount in cents (or local equivalent) representing the unit amount for this line item, excluding all tax and discounts.
 */
class InvoiceLineItem extends ApiResource
{
    const OBJECT_NAME = 'line_item';

    use ApiOperations\Update;

    /**
     * Updates an invoice’s line item. Some fields, such as <code>tax_amounts</code>,
     * only live on the invoice line item, so they can only be updated through this
     * endpoint. Other fields, such as <code>amount</code>, live on both the invoice
     * item and the invoice line item, so updates on this endpoint will propagate to
     * the invoice item as well. Updating an invoice’s line item is only possible
     * before the invoice is finalized.
     *
     * @param string $id the ID of the resource to update
     * @param null|array{amount?: int, description?: string, discountable?: bool, discounts?: null|array{coupon?: string, discount?: string, discount_end?: array{duration?: array{interval: string, interval_count: int}, timestamp?: int, type: string}, promotion_code?: string}[], expand?: string[], margins?: null|string[], metadata?: null|StripeObject, period?: array{end: int, start: int}, price?: string, price_data?: array{currency: string, product?: string, product_data?: array{description?: string, images?: string[], metadata?: StripeObject, name: string, tax_code?: string}, tax_behavior?: string, unit_amount?: int, unit_amount_decimal?: string}, quantity?: int, tax_amounts?: null|array{amount: int, tax_rate_data: array{country?: string, description?: string, display_name: string, inclusive: bool, jurisdiction?: string, percentage: float, state?: string, tax_type?: string}, taxable_amount: int}[], tax_rates?: null|string[]} $params
     * @param null|array|string $opts
     *
     * @return InvoiceLineItem the updated resource
     *
     * @throws Exception\ApiErrorException if the request fails
     */
    public static function update($id, $params = null, $opts = null)
    {
        self::_validateParams($params);
        $url = static::resourceUrl($id);

        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToStripeObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
