<?php

require_once __DIR__ . "/../app.php";
require_once __DIR__ . "/Captcha.php";
require_once __DIR__ . "/CSRF.php";
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Validated.php";

/**
 * Base class of very simple framework which handles responses to form submissions. To implement your own, extend this
 * class, and then pass it to App->handleFormAndExit(), along with the data (see create.php for an example).
 *
 * The basic flow goes like this: App initializes an instance of this class, and calls doHandle(), which transforms the
 * raw form data (typically $_POST) into an instance of Response. App then translates this instance into an actual
 * response from the server.
 *
 * By default, the doHandle() function takes care of CSRF and Captcha validation and performs reasonable sanitization of
 * fields. It passes the result to your validate() method, which is expected to return an array with the same keys, but
 * with values which are instances of Validated, and handles any Invalid instances by generating the appropriate
 * response. Finally, if all goes well, your handle() method is called with the result of the validate() method, with
 * the instances of Validated unwrapped. The handle() method is expected to return the instance of Response which should
 * be returned to the client.
 */
abstract class FormHandler
{
    protected App $app;

    public final function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * @param array $sanitizedFormData
     *
     * @return Validated[]
     */
    abstract protected function validate(array $sanitizedFormData): array;

    /**
     * @param array $validatedFormData
     *
     * @return Response
     */
    abstract protected function handle(array $validatedFormData): Response;

    public function doHandle($formData): Response
    {
        try {
            if(!CSRF::validate(
                static::extractCSRFToken($formData),
                $this->app->getDefinedCSRFTokens()
            )) {
                return new InvalidCSRF();
            }

            if(!Captcha::validate(
                static::extractCaptchaToken($formData),
                App::$config->captchaSecret,
                $this->app->getRemoteIp()
            )) {
                return new InvalidCaptcha();
            }

            $formData = self::sanitize($formData);
            $validationResults = $this->validate($formData);

            $invalidFields = array_filter(
                array_map(
                    fn($it) => $it instanceof Invalid ? $it->getMessages() : null,
                    $validationResults
                )
            );

            if(count($invalidFields)) {
                return new BadRequest($invalidFields);
            } else {
                return $this->handle(
                    array_map(
                        fn($it) => $it->getValue(),
                        $validationResults
                    )
                );
            }
        } catch(Throwable $e) {
            return new UncaughtException($e, App::$config->debug);
        }
    }

    public static function extractCaptchaToken($formData): string {
        return $formData['captchaToken'] ?? '';
    }

    public static function extractCSRFToken($formData): string {
        return $formData['csrfToken'] ?? '';
    }

    protected static function sanitize($formData): array {
        array_walk_recursive($formData, fn($value) => is_string($value) ? self::sanitizeString($value) : $value);
        return $formData;
    }

    private static function sanitizeString($str): string {
        $str = strip_tags($str);
        $str = filter_var($str);
        $str = htmlspecialchars($str, ENT_QUOTES | ENT_HTML5);
        return trim($str);
    }
}