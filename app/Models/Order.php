<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamp = true;
    public $incrementing = false;
    public $keyType = 'string';
    protected $fillable = ['idCus', 'status', 'address', 'note', 'thanhtoan', 'idVoucher', 'created_at'];
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            do {
                $randomId = Str::upper(Str::random(10));
            } while (self::where('id', $randomId)->exists());
            $order->id = $randomId;
        });
    }
    /**
     * get information detail of product
     * @param string $id
     * @return \App\Models\Product|null
     */
    public function getDetailProduct(string $id): Product|null
    {
        try {
            return Product::with('ImageProduct')->select('idPro', 'namePro', 'count', 'cost', 'discount')->where('idPro', $id)->first();
        } catch (Throwable $e) {
            Log::error("GetDetailproduct" . $e);
            return null;
        }
    }
    /**
     * get information of Order Detail
     * @param string $id
     * @return \Illuminate\Support\Collection|null
     *  */
    public function getDetailOrder(string $id): Collection|null
    {
        try {
            $OrderDetail = OrderDetail::where('idOrder', $id)->get();
            foreach ($OrderDetail as $row) {
                $row['ProductDetail'] = $this->getDetailProduct($row->idPro);
                $row['TotalCostOfProduct'] = $this->getTotalCostOfProduct($row->id);
            }
            return $OrderDetail;
        } catch (Throwable $e) {
            Log::error("GetDetailproduct2" . $e);
            return null;
        }
    }


    /**
     * get discount of product
     * @param string $id
     * @return int|null
     */
    public function getDiscountProduct(string $id): int|null
    {
        try {
            $product = Product::find($id);
            return $product->discount;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     *  get total cost of each product in order
     * @param string $idOrderDetail
     * @return string|null
     */
    public function getTotalCostOfProduct(string $idOrderDetail): string|null
    {
        try {
            $orderDetail = OrderDetail::where('id', $idOrderDetail)->select('id', 'idPro', 'number', 'price')->first();
            $discountProduct = $this->getDiscountProduct($orderDetail->idPro);
            if ($discountProduct > 0) {
                return number_format(($orderDetail->price - ($orderDetail->price * ($discountProduct) / 100)) * $orderDetail->number);
            }
            return number_format($orderDetail->price * $orderDetail->number);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
    /**
     * get total cost of Order
     * @param string $idOrderDetail
     * @return int|null
     */
    public function getTotalCostOfOrder(string $id): int|null
    {
        try {
            $order = OrderDetail::where('idOrder', $id)->select('idOrder', 'number', 'price', 'idPro')->get();
            $totalCostOfOrder = 0;
            foreach ($order as $row) {
                $discountProduct = $this->getDiscountProduct($row->idPro);
                if ($discountProduct > 0) {
                    $totalCostOfOrder += ($row->price - ($row->price * ($discountProduct) / 100)) * $row->number;
                } else {
                    $totalCostOfOrder += $row->number * $row->price;
                }
            }
            return $totalCostOfOrder;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     * get list order of user
     * @param int $idOrder
     * @return \Illuminate\Support\Collection|null
     */
    public function getListOrderUser(int $id): Collection|null
    {
        try {
            $order = Order::where('idCus', $id)->orderBy("id", 'desc')->get();
            foreach ($order as $row) {
                $row['totalCost'] = number_format($this->getTotalCostOfOrder($row->id));
                $row['OrderDetail'] = $this->getDetailOrder($row->id);
            }
            return $order;
        } catch (Throwable $e) {
            return null;
        }
    }
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function getListInforOfOrder(): LengthAwarePaginator|null
    {
        try {
            $Query = DB::table("orders as o")
                ->join('users as u', 'u.id', '=', 'o.idCus')
                ->select('o.id', 'o.status', 'o.created_at', 'o.idCus as IdCusInOrder', 'u.id as IdCusInUser', 'u.name', 'u.phone')
                ->paginate(20);
            return $Query;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     * Get detail order include:
     * - Information of Order
     * - Products in order
     * - Total cost
     * - Information of customer
     *
     * @param string $idOrder
     * @return \Illuminate\Database\Eloquent\Model|null 
     */
    public function detailOfOrder(string $idOrder): Model|null
    {
        try {
            $order = Order::where('id', $idOrder)->first();
            $user = new User();
            $DetailUser = $user->getDetailUser($order->idCus);
            $order['totalCost'] = number_format($this->getTotalCostOfOrder($order->id));
            $order['OrderDetail'] = $this->getDetailOrder($order->id);
            $order['UserInfo'] = $DetailUser;
            return $order;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     * confirm delevery order
     * @param string id
     * @return bool
     */
    public function deliveryOrder(string $id): bool
    {
        try {
            DB::beginTransaction();
            $order = Order::find($id);
            $order->status = 1;
            $order->save();
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            return false;
        }
    }
}
