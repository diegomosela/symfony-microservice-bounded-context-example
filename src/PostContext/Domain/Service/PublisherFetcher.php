<?php

namespace PostContext\Domain\Service;

use PostContext\Domain\Publisher;
use PostContext\Domain\Repository\PublisherRepositoryInterface;
use PostContext\Domain\ValueObjects\PublisherId;

class PublisherFetcher
{
    private $publisherRepository;

    public function __construct(PublisherRepositoryInterface $publisherRepository)
    {
        $this->publisherRepository = $publisherRepository;
    }

    /**
     * @param PublisherId $publisherId
     * @return Publisher
     */
    public function fetchPublisher(PublisherId $publisherId)
    {
        $publisherCollection = $this->publisherRepository->get($publisherId);

        if ($publisherCollection->count() === 0) {
            $publisherCollection->add($this->createPublisher($publisherId));
        }

        return $publisherCollection->get(0);
    }

    private function createPublisher(PublisherId $publisherId)
    {
        $publisher = new Publisher($publisherId);
        $this->publisherRepository->add($publisher);

        return $publisher;
    }
}
