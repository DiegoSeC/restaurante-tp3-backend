<?php

namespace App\Services;

use App\Exceptions\Classes\NotCreatedException;
use App\Exceptions\Classes\NotFoundException;
use App\Exceptions\Classes\NotUpdatedException;
use App\Models\Carrier;
use App\Models\Order;
use App\Models\Product;
use App\Models\Truck;
use App\Models\Warehouse;
use App\Models\Waybill;
use App\Services\Traits\ClearNullInputsTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WaybillService extends AbstractService implements CrudServiceInterface
{

    use ClearNullInputsTrait;

    private $waybillModel = null;
    private $warehouseModel = null;
    private $orderModel = null;
    private $productModel = null;
    private $carrierModel = null;
    private $truckModel = null;

    /**
     * WaybillService constructor.
     */
    public function __construct()
    {
        $this->waybillModel = new Waybill();
        $this->warehouseModel = new Warehouse();
        $this->orderModel = new Order();
        $this->productModel = new Product();
        $this->carrierModel = new Carrier();
        $this->truckModel = new Truck();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->waybillModel->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUuid($uuid) {
        return $this->waybillModel->where('uuid', '=', $uuid)->first();
    }

    /**
     * @param $data
     * @return Waybill|null
     * @throws NotCreatedException
     * @throws NotFoundException
     */
    public function create($data) {
        try {

            DB::beginTransaction();

            $products = $data['products'];
            unset($data['products']);

            $data['date_time'] = date('Y-m-d H:i:s');
            $data['status'] = Waybill::WAYBILL_STATUS_ACTIVE;
            $data['delivery_status'] = Waybill::WAYBILL_DELIVERY_STATUS_PENDING;

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

            $carrier = $this->carrierModel->where('uuid', $data['carrier'])->first();
            if(!is_null($carrier)) {
                $data['carrier_id'] = $carrier->id;
            } else {
                throw new NotFoundException();
            }

            $truck = $this->truckModel->where('uuid', $data['truck'])->first();
            if(!is_null($truck)) {
                $data['truck_id'] = $truck->id;
            } else {
                throw new NotFoundException();
            }

            $this->waybillModel->fill($data);
            $this->waybillModel->save();

            $this->waybillModel->update([
                'uuid' => $this->waybillModel->generateUuid(),
                'document_number' => $this->documentNumberGenerator(Waybill::DOCUMENT_NUMBER_PREFIX, 10, $this->waybillModel->id)
            ]);

            foreach ($products as $product) {
                $productDB = $this->productModel->where('uuid', $product['uuid'])->first();
                if(!is_null($productDB)) {
                    $this->waybillModel->products()->attach($productDB->id, ['quantity' => $product['quantity']]);
                } else {
                    throw new NotFoundException();
                }
            }

            DB::commit();

            return $this->waybillModel;
        } catch (NotFoundException $exception){
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error(json_encode($exception));
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

            if (isset($data['order']) && !empty($data['order'])) {
                $order = $this->orderModel->where('uuid', $data['order'])->first();
                if (!is_null($order)) {
                    $data['order_id'] = $order->id;
                } else {
                    throw new NotFoundException();
                }
            }

            if (isset($data['warehouse_from']) && !empty($data['warehouse_from'])) {
                $warehouseFrom = $this->warehouseModel->where('uuid', $data['warehouse_from'])->first();
                if (!is_null($warehouseFrom)) {
                    $data['warehouse_from_id'] = $warehouseFrom->id;
                } else {
                    throw new NotFoundException();
                }
            }

            if (isset($data['warehouse_to']) && !empty($data['warehouse_to'])) {
                $warehouseTo = $this->warehouseModel->where('uuid', $data['warehouse_to'])->first();
                if (!is_null($warehouseTo)) {
                    $data['warehouse_to_id'] = $warehouseTo->id;
                } else {
                    throw new NotFoundException();
                }
            }

            if (isset($data['carrier']) && !empty($data['carrier'])) {
                $carrier = $this->carrierModel->where('uuid', $data['carrier'])->first();
                if (!is_null($carrier)) {
                    $data['carrier_id'] = $carrier->id;
                } else {
                    throw new NotFoundException();
                }
            }

            if (isset($data['truck']) && !empty($data['truck'])) {
                $truck = $this->truckModel->where('uuid', $data['truck'])->first();
                if (!is_null($truck)) {
                    $data['truck_id'] = $truck->id;
                } else {
                    throw new NotFoundException();
                }
            }

            $waybill = $this->waybillModel->where('uuid', '=', $uuid)->first();
            if (is_null($waybill)) {
                throw new NotFoundException();
            }

            $data = $this->clearNullParams($data);
            $waybill->fill($data);
            $waybill->save();

            if(isset($data['products']) && !empty($data['products'])) {
                $products = $data['products'];
                unset($data['products']);
                $waybill->products()->detach();
                foreach ($products as $product) {
                    $productDB = $this->productModel->where('uuid', $product['uuid'])->first();
                    if (!is_null($productDB)) {
                        $waybill->products()->attach($productDB->id, ['quantity' => $product['quantity']]);
                    } else {
                        throw new NotFoundException();
                    }
                }
            }

            return $waybill;

            DB::commit();

            return $transferGuide;
        } catch (NotFoundException $exception){
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error(json_encode($exception));
            throw new NotUpdatedException(null);
        }
    }

    /**
     * @param $uuid
     * @throws NotFoundException
     */
    public function delete($uuid) {
        $waybill = $this->waybillModel->where('uuid', '=', $uuid)->first();
        if(is_null($waybill)) {
            throw new NotFoundException();
        }
        $waybill->delete();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByCarrierUuid($uuid) {
        return $this->waybillModel
            ->select('waybills.*')
            ->join('carriers', 'waybills.carrier_id', '=','carriers.id')
            ->where('carriers.uuid', '=', $uuid)
            ->get();
    }

    /**
     * @param $waybills
     * @param $data
     */
    public function batchUpdate($waybills, $data) {
        $data = $this->clearNullParams($data);
        foreach ($waybills as $waybillUuid) {
            $waybill = $this->waybillModel->where('uuid', '=', $waybillUuid)->first();
            if(!is_null($waybill)) {
                $waybill->fill($data);
                $waybill->save();
            }
        }
    }

}