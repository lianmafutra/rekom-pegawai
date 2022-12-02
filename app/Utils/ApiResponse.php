<?php

namespace App\Utils;

trait ApiResponse
{
   protected function success($data, $message = null, $code = 200)
	{
		return response()->json([
			'success' => true,
			'message' => $message,
			'data'    => $data
		], $code);
	}

	protected function error($message = null, $code)
	{
		return response()->json([
			'success' => false,
			'message' => $message,
			'data'    => null
		], $code);
	}

}
