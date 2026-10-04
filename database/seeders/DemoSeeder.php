<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/** Explicit, public sample accounts and orders for a disposable demo database. */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(DatabaseSeeder::class);
        foreach (['customer' => 'user', 'admin' => 'admin'] as $name => $role) {
            $email = $name.'@petcare.test';
            if (!User::where('email', $email)->exists()) {
                User::forceCreate([
                    'name' => $role === 'admin' ? 'PetCare Admin' : 'Khách Demo',
                    'email' => $email, 'role' => $role, 'status' => 'active',
                    'password' => Hash::make('PetCareDemo123!'),
                ]);
            }
        }
        $customer = User::where('email', 'customer@petcare.test')->firstOrFail();
        $products = Product::orderBy('namePro')->limit(3)->get();
        foreach (['PCDEMO0001' => 0, 'PCDEMO0002' => 1] as $id => $status) {
            if (DB::table('orders')->where('id', $id)->exists()) continue;
            DB::transaction(function () use ($id, $status, $customer, $products) {
                $date = $status === 0 ? now()->startOfDay()->addHours(9) : now()->subDays(3)->startOfDay()->addHours(10);
                DB::table('orders')->insert([
                    'id' => $id, 'idCus' => $customer->id, 'status' => $status,
                    'address' => 'Địa chỉ minh họa · ứng dụng demo',
                    'note' => 'Đơn hàng mẫu để khám phá PetCare.', 'thanhtoan' => 'cod',
                    'created_at' => $date, 'updated_at' => $date,
                ]);
                foreach ($products->take($status === 0 ? 2 : 1) as $index => $product) {
                    DB::table('order_detail')->insert([
                        'id' => 'DEMO'.substr($id, -4).$index, 'idOrder' => $id, 'idPro' => $product->idPro,
                        'number' => 1, 'price' => $product->cost, 'discount_snapshot' => $product->discount ?? 0,
                        'created_at' => $date, 'updated_at' => $date,
                    ]);
                    $product->decrement('count');
                }
            });
        }
        $this->command?->info('Demo accounts: customer@petcare.test and admin@petcare.test / PetCareDemo123! (local demo only).');
    }
}
