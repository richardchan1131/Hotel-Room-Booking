<?php

namespace Modules\User\Traits;

use Modules\User\Models\Wallet\Transaction;

trait HasWallet
{
    public function getBalanceAttribute()
    {
        return (int)$this->credit_balance;
    }

    public function getPendingBalanceAttribute()
    {
        return (int)$this->transactions()->where('status', 'pending')->sum('amount');
    }

    public function withdraw($amount, $meta = [], $refId = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception("BALANCE_NOT_ENOUGH");
        }
        $data = [
            'user_id' => $this->id,
            'amount'  => $amount,
            'type'    => 'withdraw',
            'meta'    => $meta
        ];
        if ($refId) {
            $data['ref_id'] = $refId;
        }
        $trans = new Transaction();
        $trans->fillByAttr(array_keys($data), $data);
        $trans->save();

        $this->credit_balance -= $amount;
        $this->save();

        return $trans;
    }

    public function deposit($amount, $meta = [], $refId = null, $status = 'confirmed')
    {
        $data = [
            'user_id' => $this->id,
            'amount'  => $amount,
            'type'    => 'deposit',
            'meta'    => $meta,
            'status'  => $status
        ];
        if ($refId) {
            $data['ref_id'] = $refId;
        }
        $trans = new Transaction();
        $trans->fillByAttr(array_keys($data), $data);
        $trans->save();

        $this->credit_balance += $amount;
        $this->save();

        return $trans;
    }

    public function draftDeposit($amount, $paymentId)
    {
        $data = [
            'user_id'    => $this->id,
            'amount'     => $amount,
            'type'       => 'deposit',
            'status'     => 'pending',
            'payment_id' => $paymentId
        ];
        $trans = new Transaction();
        $trans->fillByAttr(array_keys($data), $data);
        $trans->save();

        return $trans;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }
}
