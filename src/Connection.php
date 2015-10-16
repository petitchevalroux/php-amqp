<?php

namespace Amqp;

use AMQPConnection;

class Connection
{
    /**
     * Set connection configuration.
     *
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * Return connection configuration.
     *
     * @return array
     *
     * @throws Exception
     */
    public function getConfig()
    {
        if (!isset($this->config)) {
            throw new Exception('Amqp connection\'s config not setted');
        }

        return $this->config;
    }

    /**
     * Return connection to Amqp broker.
     *
     * @return AMQPConnection
     */
    public function get()
    {
        if (!isset($this->connection)) {
            $this->connection = new AMQPConnection(
                    $this->getConfig()
            );
        }
        if ($this->connection->isConnected() === false) {
            $this->connection->connect();
        }

        return $this->connection;
    }

    /**
     * Close opened connection.
     */
    public function __destruct()
    {
        if (isset($this->connection)) {
            $this->connection->disconnect();
        }
    }
}
