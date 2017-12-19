<?php

namespace App\Services;

use App\Exceptions\Classes\NotCreatedException;
use App\Exceptions\Classes\NotFoundException;
use App\Exceptions\Classes\NotUpdatedException;
use App\Mail\Traits\SendEmailTrait;
use App\Models\Order;
use App\Models\Product;
use App\Models\QuotationRequest;
use App\Services\Traits\ClearNullInputsTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuotationRequestService extends AbstractService
{

    use ClearNullInputsTrait;
    use SendEmailTrait;

    private $quotationRequestModel = null;
    private $productModel = null;
    private $orderModel = null;
    protected $prefixDocumentNumber = QuotationRequest::DOCUMENT_NUMBER_PREFIX;

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
        return $this->quotationRequestModel->orderBy('created_at', 'desc')->get();
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
                'document_number' => $this->documentNumberGenerator($this->quotationRequestModel->id)
            ]);

            $mailableData = [];

            foreach ($products as $product) {
                $productDB = $this->productModel->where('uuid', $product['uuid'])->first();
                if(!is_null($productDB)) {
                    $this->quotationRequestModel->products()->attach($productDB->id, ['quantity' => $product['quantity']]);

                    $suppliers = $productDB->getTopRatedSuppliers();
                    foreach ($suppliers as $supplier) {
                        $mailableData[$supplier['uuid']]['name'] = $supplier->name;
                        $mailableData[$supplier['uuid']]['email'] = $supplier->email;
                        $mailableData[$supplier['uuid']]['products'][] = ['name' => $productDB->name, 'quantity' => $product['quantity']];
                    }

                } else {
                    throw new NotFoundException();
                }
            }

            $order->status = Order::ORDER_STATUS_COMPLETED;
            $order->save();

            DB::commit();

            foreach ($mailableData as $mailableElement) {
                $dataEmail = [
                    'supplier' => $mailableElement['name'],
                    'products' => $mailableElement['products']
                ];
                $this->sendEmail('Hola ' . $mailableElement['name'], $mailableElement['email'], 'emails.quotation-request', $dataEmail);
            }

            return $this->quotationRequestModel;

        } catch (NotFoundException $exception){
            DB::rollBack();
            throw $exception;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getTraceAsString());
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

            $quotationRequest = $this->quotationRequestModel->where('uuid', '=', $uuid)->first();
            if(is_null($quotationRequest)) {
                throw new NotFoundException();
            }

            if (isset($data['order']) && !empty($data['order'])) {
                $order = $this->orderModel->where('uuid', $data['order'])->first();
                if(!is_null($order)) {
                    $data['order_id'] = $order->id;
                } else {
                    throw new NotFoundException();
                }

                $orderInDB = Order::find($quotationRequest->order_id);
                if($orderInDB->id != $order->id) {
                    $orderInDB->status = Order::ORDER_STATUS_PENDING;
                    $orderInDB->save();

                    $order->status = Order::ORDER_STATUS_COMPLETED;
                    $order->save();
                }
            }

            $data = $this->clearNullParams($data);
            $quotationRequest->fill($data);
            $quotationRequest->save();

            if(isset($data['products']) && !empty($data['products'])) {
                $products = $data['products'];
                unset($data['products']);
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
            Log::error($exception->getTraceAsString());
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