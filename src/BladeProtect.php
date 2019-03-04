<?php

namespace Jaybizzle\BladeProtect;

use Jaybizzle\BladeProtect\Models\Protect;

class BladeProtect
{
    protected $model;

    protected $user_id;

    protected $data;

    public function __construct()
    {
        $this->model = new Protect();
        $this->user_id = auth()->user()->getKey() ?? null;
        $this->data = $this->getData(request()->getContent());

        if ($this->shouldCleanup()) {
            $this->cleanup();
        }

        if (!$protected = $this->isLocked()) {
            $this->createLock();
        } elseif ($protected->user_id == $this->user_id) {
            $this->renewLock($protected);
        }
    }

    public function isLocked()
    {
        return $this->model
            ->where(['name' => $this->data[0], 'identifier' => $this->data[1]])
            ->where('updated_at', '>=', now()->subSeconds(20))
            ->first();
    }

    public function createLock()
    {
        $this->model->create([
            'name'       => $this->data[0],
            'user_id'    => $this->user_id,
            'identifier' => $this->data[1],
        ]);
    }

    public function renewLock($protected)
    {
        $protected->updated_at = now();

        $protected->save();
    }

    public function shouldCleanup()
    {
        return random_int(1, 100) <= 2;
    }

    public function cleanup()
    {
        $this->model->where('updated_at', '<=', now()->subSeconds(20))->delete();
    }

    public function getData($data)
    {
        return explode(':', json_decode($data));
    }

    public function __toString()
    {
        return json_encode('ok');
    }
}
