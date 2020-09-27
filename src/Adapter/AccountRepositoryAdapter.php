<?php

declare(strict_types=1);

namespace Wallet\Adapter;

use Doctrine\DBAL\Connection;
use Wallet\Model\Account;
use Wallet\Model\AccountRepository;
use Wallet\Model\DbId;
use Wallet\Model\Money;
use Wallet\Model\Transaction;
use Wallet\Model\TransactionCollection;
use Wallet\Model\User;
use Wallet\Model\Merchant;
use Wallet\Model\Wallet;

final class AccountRepositoryAdapter implements AccountRepository
{
    private const CPF_SIZE = 8;

    private const CNPJ_SIZE = 14;

    private Connection $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function get(DbId $id): Account
    {
        try {
            $account = $this->selectAccount($id);
            $wallet = $this->selectWallet($id);

            return $this->buildAccount($account[0], $wallet);
        } catch (\Exception $error) {
            print_r('Exception: ' . $error->getMessage());
            exit;
            // Retornar exception do domínio quando isso acontecer
        }
    }

    private function buildAccount(array $account, array $wallet): Account
    {
        $transactions = new TransactionCollection();
        foreach ($wallet as $transaction) {
            $isDebit = (float)$transaction['debit'] != 0.00;
            if ($isDebit) {
                $transactions->push(
                    Transaction::debit(
                        new Money((float)$transaction['debit'])
                    )
                );
                continue;
            }
            $transactions->push(
                Transaction::credit(
                    new Money((float)$transaction['credit'])
                )
            );
        }

        $id = new DbId((int)$account['user_id']);
        $isMerchant = strlen($account['document']) === static::CNPJ_SIZE;
        $wallet = Wallet::fromTransactions($transactions);

        return $isMerchant ? new Merchant($id, $wallet) : new User($id, $wallet);
    }


    public function push(Account $account): void
    {
        // TODO: Implement push() method.
    }


    private function selectAccount(DbId $id): array
    {
        $query = $this->connection->createQueryBuilder();

        // Compensa fazer um Join? Acho que sim
        return $query->select('user_id, name, document, email')
            ->from('user')
            ->where('user_id = :userId')
            ->setParameter('userId', $id->getValue())
            ->execute()
            ->fetchAllAssociative();
    }


    private function selectWallet(DbId $id): array
    {
        $query = $this->connection->createQueryBuilder();

        return $query->select('debit, credit')
            ->from('user_wallet')
            ->where('user_id = :userId')
            ->setParameter('userId', $id->getValue())
            ->execute()
            ->fetchAllAssociative();
    }
}