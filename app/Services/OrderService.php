<?php

namespace App\Services;

use App\Exceptions\Classes\NotCreatedException;
use App\Exceptions\Classes\NotFoundException;
use App\Exceptions\Classes\NotUpdatedException;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use App\Services\Traits\ClearNullInputsTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * @throws NotCreatedException
     * @throws NotFoundException
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
                'document_number' => $this->documentNumberGenerator(Order::DOCUMENT_NUMBER_PREFIX, 10, $this->orderModel->id)
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

        } catch (NotFoundException $exception){
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            throw new NotCreatedException(null);
        }
    }

    /**
     * @param $uuid
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|null|static
     * @throws NotFoundException
     * @throws NotUpdatedException
     */
    public function update($uuid, $data) {
        try {

            DB::beginTransaction();

            $products = $data['products'];
            unset($data['products']);

            if(isset($data['warehouse']) && !empty($data['warehouse'])) {
                $warehouse = $this->warehouseModel->where('uuid', $data['warehouse'])->first();
                if(!is_null($warehouse)) {
                    $data['warehouse_id'] = $warehouse->id;
                } else {
                    throw new NotFoundException();
                }
            }

            $order = $this->orderModel->where('uuid', '=', $uuid)->first();
            if(is_null($order)) {
                throw new NotFoundException();
            }

            $data = $this->clearNullParams($data);
            $order->fill($data);
            $order->save();

            if(isset($products) && !empty($products)) {
                $order->products()->detach();
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

        } catch (NotFoundException $exception){
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            throw new NotUpdatedException(null);
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