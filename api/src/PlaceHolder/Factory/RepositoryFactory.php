<?php

namespace PlaceHolder\Factory;

use PlaceHolder\Client\ClientInterface;
use PlaceHolder\Exception\UnknownRepositoryNameException;
use PlaceHolder\Repository\AbstractRepository;
use PlaceHolder\Repository\PostRepository;
use PlaceHolder\Repository\UserRepository;
use Symfony\Component\Serializer\SerializerInterface;

class RepositoryFactory
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param ClientInterface $client
     * @param SerializerInterface $serializer
     */
    public function __construct(ClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    /**
     * @param string $name
     *
     * @return AbstractRepository
     */
    public function getByName($name)
    {
        switch ($name) {
            case 'post':
                $className = PostRepository::class;
                break;
            case 'user':
                $className = UserRepository::class;
                break;
            default:
                throw new UnknownRepositoryNameException(sprintf('"%s" repository does not exist.', $name));
        }

        /** @var AbstractRepository $repositoryObject */
        $repositoryObject = new $className();
        $repositoryObject->setClient($this->client);
        $repositoryObject->setSerializer($this->serializer);

        return $repositoryObject;
    }
}
