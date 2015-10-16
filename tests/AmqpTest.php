<?php

use Faker\Factory as FakerFactory;
use Amqp\Connection as AmqpConnection;

if (!class_exists('AMQPConnection')) {
    require __DIR__.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'AMQPConnection.php';
}
class AmqpTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Factory
     */
    private $faker;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->faker = FakerFactory::create();
    }

    public function testConfig()
    {
        $expectedConfiguration = $this->faker->name;
        $connection = new AmqpConnection();
        $connection->setConfig($expectedConfiguration);
        $this->assertEquals(
                $expectedConfiguration, $connection->getConfig()
        );
    }

    public function testConfigException()
    {
        $this->setExpectedException('\Amqp\Exception', 'Amqp connection\'s config not setted');
        $connection = new AmqpConnection();
        $connection->getConfig();
    }

    public function testGet()
    {
        $connection = new AmqpConnection();
        $connection->setConfig([
            'host' => $this->faker->ipv4,
            'port' => $this->faker->randomDigit(),
        ]);
        $this->assertEquals(
                'AMQPConnection', get_class($connection->get())
        );

        $amqpConnection = $this->getMockBuilder('AMQPConnection')
                ->setMethods(['isConnected'])
                ->getMock();
        $amqpConnection->expects($this->once())
                ->method('isConnected')->willReturn(false);
        $connection->connection = $amqpConnection;
        $connection->get();
    }
}
