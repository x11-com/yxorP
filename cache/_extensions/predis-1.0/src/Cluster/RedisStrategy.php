<?php /* yxorP */


namespace Predis\Cluster;

use JetBrains\PhpStorm\Pure;
use Predis\Cluster\Hash\CRC16;
use Predis\Cluster\Hash\HashGeneratorInterface;
use Predis\NotSupportedException;


class RedisStrategy extends ClusterStrategy
{
    protected CRC16|HashGeneratorInterface $hashGenerator;


    #[Pure] #[\JetBrains\PhpStorm\Pure] public function __construct(HashGeneratorInterface $hashGenerator = null)
    {
        parent::__construct();

        $this->hashGenerator = $hashGenerator ?: new CRC16();
    }


    public function getSlotByKey($key): int
    {
        $key = $this->extractKeyTag($key);
        return $this->hashGenerator->hash($key) & 0x3FFF;
    }


    /**
     * @throws NotSupportedException
     */
    public function getDistributor()
    {
        throw new NotSupportedException(
            'This cluster strategy does not provide an external distributor'
        );
    }
}