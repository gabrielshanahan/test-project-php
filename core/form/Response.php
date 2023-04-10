<?php

class Response
{
    public const ERROR_KEY = 'error';

    private int $status;
    private array $body;

    public function __construct(int $status, array $body)
    {
        $this->status = $status;
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }
}

class Created extends Response {
    public function __construct(array $body = [])
    {
        parent::__construct(201, $body);
    }
}

class BadRequest extends Response {
    public function __construct(array $body)
    {
        parent::__construct(400, $body);
    }
}

class ServerError extends Response {
    public function __construct(string $message)
    {
        parent::__construct(500, [Response::ERROR_KEY => $message]);
    }
}

class UncaughtException extends ServerError {
    public function __construct(Throwable $exception, $debug = false)
    {
        parent::__construct(
            "Uncaught exception of type '" . get_class($exception) . "'."
            . ($debug
                ? " Message: '{$exception->getMessage()}'. " .
                " Stacktrace: '{$exception->getTraceAsString()}'"
                : "")
        );
    }
}