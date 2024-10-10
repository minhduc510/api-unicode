<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionHelper
{
    /**
     * Xử lý transaction và trả về kết quả.
     *
     * @param \Closure $callback
     * @return mixed
     * @throws \Throwable
     */
    public static function handle(\Closure $callback)
    {
        DB::beginTransaction();

        try {
            $result = $callback(); // Thực hiện logic truyền vào từ controller
            DB::commit();          // Commit nếu thành công
            return $result;        // Trả về kết quả từ closure
        } catch (\Exception $exception) {
            DB::rollback();  // Rollback nếu có lỗi
            Log::error('Transaction failed. Error: ' . $exception->getMessage() . ' in file: ' . $exception->getFile() . ' on line: ' . $exception->getLine());
            throw $exception;  // Ném lại ngoại lệ để controller biết có lỗi và xử lý
        }
    }
}
