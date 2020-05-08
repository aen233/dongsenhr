<?php

namespace App\Exceptions;


class Error extends \Exception
{
    /**
     * @var array
     */
    public $data = [];
    public $code = 200;
    public $message = [];

    /**
     * Error constructor.
     * @param int $code
     * @param string $message
     */
    public function __construct(
        int $code,
        string $message
    )
    {
        parent::__construct();
        $this->code = $code;
        $this->message = $message;
    }


    public function render()
    {
        return response()->json([
            'code'    => $this->code,
            'message' => $this->message,
        ]);
    }
}
