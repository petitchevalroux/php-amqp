<?php

namespace Amqp;

class Exchange extends \AMQPExchange
{
    /**
     * Publish a message to an exchange.
     *
     * Publish a message to the exchange represented by the AMQPExchange object.
     *
     * @param string $message     The message to publish.
     * @param string $routing_key The optional routing key to which to
     *                            publish to.
     * @param int    $flags       One or more of AMQP_MANDATORY and
     *                            AMQP_IMMEDIATE.
     * @param array  $attributes  One of content_type, content_encoding,
     *                            message_id, user_id, app_id, delivery_mode,
     *                            priority, timestamp, expiration, type
     *                            or reply_to, headers.
     *
     * @throws AMQPExchangeException   On failure.
     * @throws AMQPChannelException    If the channel is not open.
     * @throws AMQPConnectionException If the connection to the broker was lost.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function publish($message, $routing_key = null, $flags = AMQP_NOPARAM, array $attributes = array())
    {
        if (is_null($routing_key)) {
            $publishRoutingKey = $this->getPublishRoutingKey();
            if ($publishRoutingKey !== '') {
                $routing_key = $publishRoutingKey;
            }
        }

        return parent::publish($message, $routing_key, $flags, $attributes);
    }

    /**
     * Default publish routing key.
     *
     * @var string
     */
    protected $publishRoutingKey = '';

    /**
     * Set default publish routing key.
     *
     * @param string $routing_key
     */
    public function setPublishRoutingKey($routing_key)
    {
        $this->publishRoutingKey = $routing_key;
    }

    /**
     * Return default publish routing key.
     *
     * @return string
     */
    public function getPublishRoutingKey()
    {
        return $this->publishRoutingKey;
    }
}
