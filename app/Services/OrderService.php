<?php

namespace App\Services;

use App\Exceptions\Classes\NotFoundException;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use App\Services\Traits\ClearNullInputsTrait;
use Illuminate\Support\Facades\DB;

class OrderService extends AbstractService implements CrudServiceInterface
{

    use ClearNullInputsTrait;

    private $orderModel = null;
    private $productModel = null;
    private $warehouseModel = null;

    /**
     * OrderService constructor.
     */
    public function __construct()
    {
        $this->orderModel = new Order();
        $this->productModel = new Product();
        $this->warehouseModel = new Warehouse();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->orderModel->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUuid($uuid) {
        return $this->orderModel->where('uuid', '=', $uuid)->first();
    }

    /**
     * @param $data
     * @return Order|null
     */
    public function create($data) {
        try {

            DB::beginTransaction();

            $products = $data['products'];
            unset($data['products']);

            $data['status'] = Order::ORDER_STATUS_PENDING;
            $warehouse = $this->warehouseModel->where('uuid', $data['warehouse'])->first();
            if(!is_null($warehouse)) {
                $data['warehouse_id'] = $warehouse->id;
            } else {
                throw new NotFoundException();
            }

            $this->orderModel->fill($data);
            $this->orderModel->save();

            $this->orderModel->update([
                'uuid' => $this->orderModel->generateUuid(),
                'document_number' => str_pad($this->orderModel->id, 10, '0', STR_PAD_LEFT)
            ]);

            foreach ($products as $product) {
                $productDB = $this->productModel->where('uuid', $product['uuid'])->first();
                if(!is_null($productDB)) {
                    $this->orderModel->products()->attach($productDB->id, ['quantity' => $product['quantity']]);
                } else {
                    throw new NotFoundException();
                }
            }

            DB::commit();

            return $this->orderModel;
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    /**
     * @param $uuid
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|null|static
     * @throws NotFoundException
     */
    public function update($uuid, $data) {
        try {

            DB::beginTransaction();

            $products = $data['products'];
            unset($data['products']);

            $warehouse = $this->warehouseModel->where('uuid', $data['warehouse'])->first();
            if(!is_null($warehouse)) {
                $data['warehouse_id'] = $warehouse->id;
            } else {
                throw new NotFoundException();
            }

            $order = $this->orderModel->where('uuid', '=', $uuid)->first();
            if(is_null($order)) {
                throw new NotFoundException();
            }

            $order->fill($data);
            $order->save();

            $order->products()->detach();
            if(isset($products) && !empty($products)) {
                foreach ($products as $product) {
                    $productDB = $this->productModel->where('uuid', $product['uuid'])->first();
                    if(!is_null($productDB)) {
                        $order->products()->attach($productDB->id, ['quantity' => $product['quantity']]);
                    } else {
                        throw new NotFoundException();
                    }
                }
            }

            DB::commit();

            return $order;
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    /**
     * @param $uuid
     * @throws NotFoundException
     */
    public function delete($uuid) {
        $order = $this->orderModel->where('uuid', '=', $uuid)->first();
        if(is_null($order)) {
            throw new NotFoundException();
        }
        $order->delete();
    }

}