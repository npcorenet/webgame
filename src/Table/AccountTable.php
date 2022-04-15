<?php declare(strict_types=1);

namespace App\Table;

use App\Model\AccountModel;

class AccountTable extends AbstractTable
{

    public function insert(AccountModel $accountModel): bool|array
    {

        $values =
            [
                'email' => $accountModel->getEmail(),
                'username' => $accountModel->getUsername(),
                'password' => password_hash($accountModel->getPassword(), PASSWORD_BCRYPT),
                'registered' => $accountModel->getRegistered()->format('Y-m-d H:i:s')
            ];

        return $this->query->insertInto($this->getTableName())->values($values)->execute();

    }

    public function findByEmail(string $email): bool|array
    {

        return $this->query->from($this->getTableName())->where(['email' => $email])->fetch();

    }

    public function findByUsername(string $username): bool|array
    {

        return $this->query->from($this->getTableName())->where(['username' => $username])->fetch();

    }

    public function setCoins(int $amount, int $userId)
    {

        $this->query->update($this->getTableName())->where(['id' => $userId])->set(['coins' => $amount])->execute();

    }

}