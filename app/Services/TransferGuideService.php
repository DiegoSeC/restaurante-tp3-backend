<?php

namespace App\Services;

use App\Exceptions\Classes\NotCreatedException;
use App\Exceptions\Classes\NotFoundException;
use App\Exceptions\Classes\NotUpdatedException;
use App\Models\Order;
use App\Models\Product;
use App\Models\TransferGuide;
use App\Models\Warehouse;
use App\Services\Traits\ClearNullInputsTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransferGuideService extends AbstractService
{

    use ClearNullInputsTrait;

    private $transferGuideModel = null;
    private $productModel = null;
    private $warehouseModel = null;
    private $orderModel = null;

    /**
     * TransferGuideService constructor.
     */
    public function __construct()
    {
        $this->transferGuideModel = new TransferGuide();
        $this->productModel = new Product();
        $this->warehouseModel = new Warehouse();
        $this->orderModel = new Order();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->transferGuideModel->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUuid($uuid) {
        return $this->transferGuideModel->where('uuid', '=', $uuid)->first();
    }

    /**
     * @param $data
     * @return TransferGuide|null
     * @throws NotCreatedException
     * @throws NotFoundException
     */
    public function create($data) {
        try {

            DB::beginTransaction();

            $products = $data['products'];
            unset($data['products']);

            $data['status'] = TransferGuide::TRANSFER_GUIDE_STATUS_ACTIVE;

            $order = $this->orderModel->where('uuid', $data['order'])->first();
            if(!is_null($order)) {
                $data['order_id'] = $order->id;
            } else {
                throw new NotFoundException();
            }

            $warehouseFrom = $this->warehouseModel->where('uuid', $data['warehouse_from'])->first();
            if(!is_null($warehouseFrom)) {
                $data['warehouse_from_id'] = $warehouseFrom->id;
            } else {
                throw new NotFoundException();
            }

            $warehouseTo = $this->warehouseModel->where('uuid', $data['warehouse_to'])->first();
            if(!is_null($warehouseTo)) {
                $data['warehouse_to_id'] = $warehouseTo->id;
            } else {
                throw new NotFoundException();
            }

            $this->transferGuideModel->fill($data);
            $this->transferGuideModel->save();

            $this->transferGuideModel->update([
                'uuid' => $this->transferGuideModel->generateUuid(),
                'document_number' => $this->documentNumberGenerator(TransferGuide::DOCUMENT_NUMBER_PREFIX, 10, $this->transferGuideModel->id)
            ]);

            foreach ($products as $product) {
                $productDB = $this->productModel->where('uuid', $product['uuid'])->first();
                if(!is_null($productDB)) {
                    $this->transferGuideModel->products()->attach($productDB->id, ['quantity' => $product['quantity']]);
                } else {
                    throw new NotFoundException();
                }
            }

            $order->status = Order::ORDER_STATUS_COMPLETED;
            $order->save();

            DB::commit();

            return $this->transferGuideModel;
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

            if (isset($data['order']) && !empty($data['order'])) {
                $order = $this->orderModel->where('uuid', $data['order'])->first();
                if(!is_null($order)) {
                    $data['order_id'] = $order->id;
                } else {
                    throw new NotFoundException();
                }
            }

            if(isset($data['warehouse_from']) && !empty($data['warehouse_from'])) {
                $warehouseFrom = $this->warehouseModel->where('uuid', $data['warehouse_from'])->first();
                if(!is_null($warehouseFrom)) {
                    $data['warehouse_from_id'] = $warehouseFrom->id;
                } else {
                    throw new NotFoundException();
                }
            }

            if(isset($data['warehouse_to']) && !empty($data['warehouse_to'])) {
                $warehouseTo = $this->warehouseModel->where('uuid', $data['warehouse_to'])->first();
                if(!is_null($warehouseTo)) {
                    $data['warehouse_to_id'] = $warehouseTo->id;
                } else {
                    throw new NotFoundException();
                }
            }

            $transferGuide = $this->transferGuideModel->where('uuid', '=', $uuid)->first();
            if(is_null($transferGuide)) {
                throw new NotFoundException();
            }

            $data = $this->clearNullParams($data);
            $transferGuide->fill($data);
            $transferGuide->save();

            if(isset($products) && !empty($products)) {
                $transferGuide->products()->detach();
                foreach ($products as $product) {
                    $productDB = $this->productModel->where('uuid', $product['uuid'])->first();
                    if(!is_null($productDB)) {
                        $transferGuide->products()->attach($productDB->id, ['quantity' => $product['quantity']]);
                    } else {
                        throw new NotFoundException();
                    }
                }
            }

            DB::commit();

            return $transferGuide;

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
        $order = $this->transferGuideModel->where('uuid', '=', $uuid)->first();
        if(is_null($order)) {
            throw new NotFoundException();
        }
        $order->delete();
    }
}