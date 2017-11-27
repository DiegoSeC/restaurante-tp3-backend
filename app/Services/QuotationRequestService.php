<?php

namespace App\Services;

use App\Exceptions\Classes\NotCreatedException;
use App\Exceptions\Classes\NotFoundException;
use App\Exceptions\Classes\NotUpdatedException;
use App\Models\Order;
use App\Models\Product;
use App\Models\QuotationRequest;
use App\Services\Traits\ClearNullInputsTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuotationRequestService extends AbstractService
{

    use ClearNullInputsTrait;

    private $quotationRequestModel = null;
    private $productModel = null;
    private $orderModel = null;

    /**
     * QuotationRequestService constructor.
     */
    public function __construct()
    {
        $this->quotationRequestModel = new QuotationRequest();
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->quotationRequestModel->quotationRequestBy('created_at', 'desc')->get();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUuid($uuid) {
        return $this->quotationRequestModel->where('uuid', '=', $uuid)->first();
    }

    /**
     * @param $data
     * @return QuotationRequest|null
     * @throws NotCreatedException
     * @throws NotFoundException
     */
    public function create($data) {
        try {

            DB::beginTransaction();

            $products = $data['products'];
            unset($data['products']);

            $data['status'] = QuotationRequest::QUOTATION_REQUEST_STATUS_PENDING;

            $order = $this->orderModel->where('uuid', $data['order'])->first();
            if(!is_null($order)) {
                $data['order_id'] = $order->id;
            } else {
                throw new NotFoundException();
            }

            $this->quotationRequestModel->fill($data);
            $this->quotationRequestModel->save();

            $this->quotationRequestModel->update([
                'uuid' => $this->quotationRequestModel->generateUuid(),
                'document_number' => $this->documentNumberGenerator(QuotationRequest::DOCUMENT_NUMBER_PREFIX, 10, $this->quotationRequestModel->id)
            ]);

            foreach ($products as $product) {
                $productDB = $this->productModel->where('uuid', $product['uuid'])->first();
                if(!is_null($productDB)) {
                    $this->quotationRequestModel->products()->attach($productDB->id, ['quantity' => $product['quantity']]);
                } else {
                    throw new NotFoundException();
                }
            }

            DB::commit();

            return $this->quotationRequestModel;

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

            $quotationRequest = $this->quotationRequestModel->where('uuid', '=', $uuid)->first();
            if(is_null($quotationRequest)) {
                throw new NotFoundException();
            }

            $data = $this->clearNullParams($data);
            $quotationRequest->fill($data);
            $quotationRequest->save();

            if(isset($products) && !empty($products)) {
                $quotationRequest->products()->detach();
                foreach ($products as $product) {
                    $productDB = $this->productModel->where('uuid', $product['uuid'])->first();
                    if(!is_null($productDB)) {
                        $quotationRequest->products()->attach($productDB->id, ['quantity' => $product['quantity']]);
                    } else {
                        throw new NotFoundException();
                    }
                }
            }

            DB::commit();

            return $quotationRequest;

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
        $order = $this->quotationRequestModel->where('uuid', '=', $uuid)->first();
        if(is_null($order)) {
            throw new NotFoundException();
        }
        $order->delete();
    }
}