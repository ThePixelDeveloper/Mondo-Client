<?php

namespace Thepixeldeveloper\Mondo\Client;

use Thepixeldeveloper\Mondo\MondoClientInterface;

class Transactions
{
    /**
     * Mondo client.
     *
     * @var MondoClientInterface
     */
    protected $client;

    /**
     * Accounts constructor.
     *
     * @param MondoClientInterface $client
     */
    public function __construct(MondoClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Information for a given transaction ID.
     *
     * @param string $transactionId
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getTransaction($transactionId)
    {
        return $this->client->get('/transactions/' . $transactionId);
    }

    /**
     * Get the transaction history for the account id.
     *
     * @param string $accountId
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getTransactionsForAccountId($accountId)
    {
        return $this->client->get('/transactions', [
            'query' => ['account_id' => $accountId],
        ]);
    }

    /**
     * Add annotation(s) for a transaction.
     *
     * @param string       $transactionId
     * @param string|array $key
     * @param string       $value
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addAnnotationForTransaction($transactionId, $key, $value = null)
    {
        if (is_string($key)) {
            $metadata = [$key => $value];
        } else {
            $metadata = $key;
        }

        return $this->client->get('/transactions/' . $transactionId, [
            'body' => ['metadata' => $metadata],
        ]);
    }

    /**
     * Remove annotation(s) for a transaction.
     *
     * @param string $transactionId
     * @param string $keys
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function removeAnnotationForTransaction($transactionId, $keys)
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }

        $keys = array_flip($keys);

        return $this->client->get('/transactions/' . $transactionId, [
            'body' => ['metadata' => $keys],
        ]);
    }
}
